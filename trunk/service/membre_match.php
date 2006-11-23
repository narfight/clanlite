<?php
/****************************************************************************
 *	Fichier		: 															*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$action_membre = 'where_match_prive';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path."controle/cook.php");
if (!empty($_POST['match']))
{
	// on v�rifie qu'il est pas deja dans le match
	$sql = "SELECT COUNT(id) FROM `".$config['prefix']."match_inscription` WHERE user_id ='".$session_cl['id']."' AND id_match ='".$_POST['match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$verif_present = $rsql->s_array($get);
	if ($verif_present['COUNT(id)'] == 0)
	{
		$sql = "INSERT INTO `".$config['prefix']."match_inscription` (id_match, user_id, statu) VALUES ('".$_POST['match']."', '".$session_cl['id']."', 'demande')";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('membre_match.php', $langue['user_envois_demande_ok'], 'admin');
	}
	else
	{
		$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE `id_match` = '".$_POST['match']."' AND `user_id` = '".$session_cl['id']."'";
		if (! ($list = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('membre_match.php', $langue['user_envois_annule_demande'], 'admin');
	}
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'match_membre.tpl'));
$sql = "SELECT nom FROM ".$config['prefix']."section WHERE id ='".$session_cl['section']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$nom_section = $rsql->s_array($get);
$template->assign_vars(array( 
	'ICI' => session_in_url('membre_match.php'),
	'TITRE_MATCH' => $langue['titre_match'],
	'SECTION' => $nom_section['nom'],
	'CONTRE' => $langue['contre_qui'],
	'DATE' => $langue['date_defit'],
	'HEURE' => $langue['heure_defit'],
	'NBR_JOUEURS' => $langue['nbr_joueurs'],
	'HEURE_CHAT' => $langue['heure_chat'],
	'QUELLE_SECTION' => $langue['quelle_section'],
	'TEAM_OK' => $langue['team_ok'],
	'TEAM_RESERVE' => $langue['team_reserve'],
	'TEAM_DEMANDE' => $langue['team_demande'],
	'ADD_DELL_DEMANDE' => $langue['ajouter/supprimer_demande_match'],
	'VOIR' => $langue['d�tails']
));
$sql = "SELECT inscriptions.statu, inscriptions.id_match, inscriptions.id, user.user FROM `".$config['prefix']."match_inscription` AS inscriptions LEFT JOIN `".$config['prefix']."user` AS user ON inscriptions.user_id = user.id";
if (! ($get_joueur = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($list_user = $rsql->s_array($get_joueur)) )
{
	$liste_user_match[$list_user['id_match']][$list_user['statu']][$list_user['user']] = $list_user['user'];
}
$sql = "SELECT a.*, section.nom FROM ".$config['prefix']."match AS a LEFT JOIN ".$config['prefix']."section section ON section.id='".$session_cl['section']."' WHERE (a.section ='".$session_cl['section']."' OR a.section ='0' OR section.limite ='0') AND a.date > '".(time()-60*60*2) ."' ORDER BY a.date ASC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$i=0;
$inscrit = false;
$pas_inscrit = false;

while ( ($list_match = $rsql->s_array($get_match)) )
{
	$i++;
	// on v�rifie que la personne n'est pas d�ja inscris au match
	if (!empty($liste_user_match[$list_match['id']]['ok'][$session_cl['user']]) || !empty($liste_user_match[$list_match['id']]['demande'][$session_cl['user']]) || !empty($liste_user_match[$list_match['id']]['reserve'][$session_cl['user']]))
	{
		$tpl_ou = 'match_inscrit';
		if (!$inscrit)
		{// on ajoute le titre si il n'est pas encore pr�sent
			$template->assign_block_vars('titre_inscrit', array('TXT' => $langue['match_inscrit']));
			$inscrit = true;
		}
	}
	else
	{
		$tpl_ou = 'match_pas_inscrit';
		if (!$pas_inscrit)
		{// on ajoute le titre si il n'est pas encore pr�sent
			$template->assign_block_vars('titre_pas_inscrit', array('TXT' => $langue['match_pas_inscrit']));
			$pas_inscrit = true;
		}
	}
	$template->assign_block_vars($tpl_ou, array( 
		'FOR' => $list_match['id'],
		'DATE' => date('j/n/Y', $list_match['date']),
		'CLAN' => $list_match['le_clan'],
		'SECTION' => (empty($list_match['nom']))? $langue['toutes_section'] : $list_match['nom'],
		'INFO' => bbcode($list_match['info']),
		'SUR' => $list_match['nombre_de_joueur'],
		'HEURE' => date('H:i', $list_match['date']),
		'CHAT' => $list_match['heure_msn'],
		'NB_JOUEURS' => (!empty($liste_user_match[$list_match['id']]['ok']))? count($liste_user_match[$list_match['id']]['ok']) : '0',
	));
	if (!empty($liste_user_match[$list_match['id']]))
	{
		foreach($liste_user_match[$list_match['id']] as $etat_inscription => $non_inscription)
		{
			foreach($non_inscription as $non_inscri)
			{
				$template->assign_block_vars($tpl_ou.'.'.$etat_inscription, array( 
					'NOM' => $non_inscri,
				));
			}
		}
	}
} 
if ($i === 0)
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_futur_match']));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>