<?php
/****************************************************************************
 *	Fichier		: reaction.php												*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
define('CL_AUTH', true);
$root_path = './../';
$action_membre = 'where_reaction';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
if ( !empty($_GET['action']) && ( $session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[12] == 'oui' ) )
{
	$sql = "DELETE FROM `".$config['prefix']."reaction_news` WHERE id ='".$_GET['for']."'";
	if (! ($list_news = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('reaction.php?for='.$_GET['view'], $langue['reaction_dell'], 'user');
}
if ( !empty($_POST['send']) )
{ 
	if (empty($session_cl['user']))
	{// si la personne n'est pas connect�
		// on v�rifie que les champ sont pas vide
		$forum_error = '';
		if(empty($_POST['nom_p']))
		{
			$forum_error .= $langue['erreur_nom_vide'];
		}
		if(empty($_POST['reaction']))
		{
			$forum_error .= $langue['erreur_reaction_vide'];
		}
		$membre_p = false;
		if (!empty($_POST['nom_p']))
		{
			// on v�rifie qu'il na pas prit un nom des membres si il n'est pas un
			$sql = "SELECT user, psw FROM ".$config['prefix']."user WHERE user = '".$_POST['nom_p']."'";
			if (! ($get = $rsql->requete_sql($sql)) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			if ( $membre = $rsql->s_array($get) ) 
			{
				// le nom est dans la db, on v�rifie alors le code
				if ( md5($_POST['code_p']) != $membre['psw'] )
				{
					$forum_error .= $langue['erreur_no_membre'];
				}
				else
				{
					$membre_p = true;
				}
			}
		}
		if (!$membre_p)
		{// ha, c'est un membre, alors, on v�rifie pas son e-mail
			if (empty($_POST['email_p']))
			{
				$forum_error .= $langue['erreur_mail_vide'];
			}
			elseif (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['email_p']))
			{
				$forum_error .= $langue['erreur_mail_invalide'];
			}
		}
	}
	//on v�rifie que tout est en ordre pour envoyer le message
	if (empty($forum_error) || isset($user_connect))
	{
		$_POST = pure_var($_POST);
		// oki ici c'est quand tout est bien rempli
		$sql = "INSERT INTO `".$config['prefix']."reaction_news` (id_news, nom, email, date, texte) VALUES ('".$_POST['for']."', '".((isset($user_connect))? $session_cl['user'] : $_POST['nom_p'])."', '".((isset($user_connect))? '' : $_POST['email_p'])."', '".$config['current_time']."', '".$_POST['reaction']."')";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'service/index_pri.php', $langue['reaction_add'], 'user');
	}
} 
require($root_path.'conf/frame.php');
$for = (empty($_GET['for']))? intval($_POST['for']) : intval($_GET['for']);
$sql = "SELECT date, titre, info, user FROM `".$config['prefix']."news` WHERE id = '".$for."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ($news = $rsql->s_array($get)) 
{
	if (!empty($forum_error))
	{
		msg('erreur', $forum_error);
		$_POST = pure_var($_POST, 'moin');
	}
	$template = new Template($root_path.'templates/'.$session_cl['skin']);
	$template->set_filenames( array('body' => 'reactions.tpl'));
	liste_smilies_bbcode(true, '', 25);
	$sql = "SELECT user.id, reaction.*, user.user FROM `".$config['prefix']."reaction_news` AS reaction LEFT JOIN ".$config['prefix']."user AS user ON reaction.nom = user.user WHERE id_news ='".$for."' ORDER BY reaction.id ASC";
	if (! ($list_reaction = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ($reaction = $rsql->s_array($list_reaction)) 
	{ 
		$template->assign_block_vars('reactions', array( 
			'DATE' => adodb_date('j-n-y H:i', $reaction['date']),
			'REACTION' => bbcode($reaction['texte']),
			'BY' => sprintf($langue['reaction_de'], $reaction['nom']),
			'BY_URL' => (!empty($reaction['user']))? session_in_url($root_path.'service/profil.php?link='.$reaction[0]) : 'mailto:'.$reaction['email'],
			'FOR' => $for, 
			'ID' => $reaction['id'],
		));
		if ($session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[12] == 'oui')
		{
			$template->assign_block_vars('reactions.admin', array(
				'DELL_REACTION' => $langue['dell_reaction'],
				'TXT_CON_DELL' => $langue['confirm_dell'],
				'DELL_REACTION_U' => session_in_url('reaction.php?action=dell&amp;for='.$reaction['id'].'&amp;view='.$for)
			));
		}
	}
	if (empty($user_connect))
	{
		$template->assign_block_vars('login', array( 
			'FORM_LOGIN' => $langue['form_login'],
			'FORM_NOM' => $langue['form_nom'],
			'FORM_PSW' => $langue['form_psw'],
			'FORM_MAIL' => $langue['form_mail'],
			'LOGIN' => $langue['reaction_login'],
		));
	}
	$template->assign_vars(array(
		'ICI' => session_in_url('reaction.php'),
		'TITRE_NEWS' => $langue['news_titre'],
		'POSTE_LE' => $langue['poste_le'],
		'PAR' => $langue['poste_par'],
		'TITRE_NEWS' => $news['titre'],
		'BY' => $news['user'],
		'TEXT' => bbcode($news['info']),
		'DATE' => adodb_date("j/n/y H:i", $news['date']+$session_cl['correction_heure']),
		'TITRE_REACTION' => $langue['titre_reaction'],
		'ADD_COMMENTAIRE' => $langue['add_commentaire'],
		'FORM_MESSAGE' => $langue['form_message'],
		'FORM_ENVOYER' => $langue['envoyer'],
		'REACTION' => (!empty($_POST['reaction']))? $_POST['reaction'] : '',
		'USER' => (!empty($session_cl['user']))? $session_cl['user'] : '',
		'FOR' => (empty($_POST['for']))? $_GET['for'] : $_POST['for'],
		'ID' => $reaction['id'],
		'MAIL' => (!empty($session_cl['mail']))? $session_cl['mail'] : '',
	));
	$template->pparse('body');
}
else
{
	msg('erreur', $langue['erreur_news_no_found']);
}
require($root_path.'conf/frame.php');
?>