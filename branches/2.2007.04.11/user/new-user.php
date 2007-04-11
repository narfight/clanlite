<?php
/****************************************************************************
 *	Fichier		: new-user.php												*
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
$action_membre = 'where_inscription';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
// envois du formulaire dans la db
if (!empty($_POST['Submit']) && $inscription != 0)
{
	$forum_error = '';
	$_POST = pure_var($_POST);
	//on vérifie le formulaire point par point
	if(empty($_POST['nom']))
	{
		$forum_error .= $langue['erreur_nom_vide'];
	}
	if(empty($_POST['user1']))
	{
		$forum_error .= $langue['erreur_user_vide'];
	}
	else
	{
		$id_test = (isset($session_cl['id']))? $session_cl['id'] : '';
		$sql = "SELECT user FROM ".$config['prefix']."user WHERE user = '".$_POST['user1']."' AND id != '".$id_test."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		if ( $rsql->s_array($get) )
		{
			$forum_error .= $langue['erreur_user_prit'];
		}
	}
	if(empty($_POST['sex']))
	{
		$forum_error .= $langue['erreur_sex_vide'];
	}
	if(empty($_POST['age_y']) || empty($_POST['age_m']) || empty($_POST['age_d']))
	{
		$forum_error .= $langue['erreur_naissance_vide'];
	}
	if(empty($_POST['arme']) && $_POST['arme'] == '0.gif')
	{
		$forum_error .= $langue['erreur_arme_vide'];
	}
	if(empty($_POST['perso']) && $_POST['perso'] == '0.gif')
	{
		$forum_error .= $langue['erreur_perso_image_vide'];
	}
	if(empty($_POST['mail']))
	{
		$forum_error .= $langue['erreur_mail_vide'];
	}
	else
	{
		if (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['mail']))
		{
			$forum_error .= $langue['erreur_mail_invalide'];
		}
		else
		{
			$sql = "SELECT mail FROM ".$config['prefix']."user WHERE mail='".$_POST['mail']."'";
			if (! $get = $rsql->requete_sql($sql) )
			{
				sql_error($sql , $rsql->error, __LINE__, __FILE__);
			}
			if ( $rsql->s_array($get) )
			{
				$forum_error .= $langue['erreur_mail_prit'];
			}
		}
	}
	if(empty($_POST['icq']))
	{
		$forum_error .= $langue['erreur_msn_vide'];
	}
	else if (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['icq']))
	{
		$forum_error .= $langue['erreur_msn_invalide'];
	}
	if(empty($_POST['prenom']))
	{
		$forum_error .= $langue['erreur_prenom_vide'];
	}
	if(empty($_POST['arme']))
	{
		$forum_error .= $langue['erreur_arme_vide'];
	}
	if(empty($_POST['perso']))
	{
		$forum_error .= $langue['erreur_perso_image_vide'];
	}
	if(empty($_POST['langue_form']))
	{
		$forum_error .= $langue['erreur_langue_vide'];
	}
	if(!isset($_POST['time_zone']))
	{
		$forum_error .= $langue['erreur_time_zone'];
	}
	if(empty($_POST['psw']))
	{
		$forum_error .= $langue['erreur_psw_vide'];
	}
	else if ($_POST['psw'] != $_POST['psw2'])
	{
		$forum_error .= $langue['erreur_code_différent'];
	}
	// on regarde si il a une erreur dans la variable $forum_error et si non on continue
	if( empty($forum_error) )
	{
		// on formate l'heure en mk_time depuis 1970
		$age = adodb_mktime( 0 , 0 , 0 , $_POST['age_m'] , $_POST['age_d'] , $_POST['age_y']);
		$sql = "INSERT INTO `".$config['prefix']."user` (`nom`, `user`, `mail`, `im`, `psw`, `pouvoir`, `sex`, `age`, `web`, `cri`, `last_connect`, `prenom`, `armes_preferees`, `equipe`, `histoire`, `roles`, `images`, `langue`, `time_zone`, `heure_ete`, `user_date`) VALUES ('".$_POST['nom']."', '".$_POST['user1']."', '".$_POST['mail']."', '".$_POST['icq']."', '".md5($_POST['psw'])."', 'news', '".$_POST['sex']."', '".$age."', '".((!empty($_POST['web']) && eregi('http(s)?://',$_POST['web']))? $_POST['web'] : 'http://'.$_POST['web'])."', '".$_POST['texte']."', '', '".$_POST['prenom']."', '".$_POST['arme']."', '', '".$_POST['histoire']."', '', '".$_POST['perso']."', '".$_POST['langue_form']."', '".$_POST['time_zone']."', '".((isset($_POST['heure_ete']) && $_POST['heure_ete'] == 1)? $_POST['heure_ete'] == 1 : 0)."', '".$config['current_time']."')"; 
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql , $rsql->error, __LINE__, __FILE__);
		}
		else
		{
			$config['nbr_membre']++;
			$sql = "UPDATE ".$config['prefix']."config SET conf_valeur='".$config['nbr_membre']."' WHERE conf_nom='nbr_membre'";
			if (! $rsql->requete_sql($sql) )
			{
				sql_error($sql , $rsql->error, __LINE__, __FILE__);
			}
		}
		redirec_text('msgnew.php', $langue['user_envois_inscription'], 'user');
	}
}
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'user_news.tpl'));
liste_smilies_bbcode(true, '', 25);
if (!empty($forum_error) )
{
	msg('erreur' ,$forum_error);
}

if ($inscription == 0)
{
 	$block_insc = 'disabled="disabled"';
 	msg('info' ,$langue['inscription_fermée']);
	$template->assign_vars(array('BLOCK' => $block_insc));
} 
else
{
	$block_insc = '';
}
// scan le rep pour les images
// Ouvre un dossier bien connu, et liste tous les fichiers
foreach(scandir($root_path.'images/personnages') as $id => $file)
{
	if (ereg('(.*).(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $file, $perso))
	{
		if ($perso[1] == '0' || !empty($_POST['perso']) && $_POST['perso'] == $perso[0])
		{
			$default_img = $perso[0];
		}
		$template->assign_block_vars('images', array(
			'FICHIER' => $perso[0],
			'VALUE' => $perso[1],
			'SELECTED' => ( !empty($_POST['perso']) && $_POST['perso'] == $perso[0]) ? 'selected="selected"' : '',
		));
	}
}
// scan le rep pour les langues
foreach(scandir($root_path.'langues') as $id => $file)
{
	if (file_exists($root_path.'langues/'.$file.'/langue.php'))
	{
		$template->assign_block_vars('langue', array(
			'NAME' => $file,
			'VALUE' => $file,
			'SELECTED' => (!empty($_POST['langue']) && $_POST['langue'] == $file) ? 'selected="selected"' : '',
		));
	}
}
// scan le rep pour les images des armes
// Ouvre un dossier bien connu, et liste tous les fichiers
foreach(scandir($root_path.'images/armes') as $id => $file)
{
	if (ereg('(.*).(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $file, $perso))
	{
		if ($perso[1] == '0' || !empty($_POST['arme']) && $_POST['arme'] == $perso[0])
		{
			$default_arme = $perso[0];
		}
		else
		{
			$template->assign_block_vars('armes', array(
				'NOM' => $perso[1],
				'VALEUR' => $perso[0],
				'SELECTED' => (!empty($_POST['arme']) && $_POST['arme'] == $perso[0]) ? 'selected="selected"' : '',
			));
		}
	}
}
$template->assign_vars(array(
	'ICI' => session_in_url('new-user.php'),
	'TITRE' => $langue['titre_inscription'],
	'TXT_CHOISIR' => $langue['choisir'],
	'TXT_OUI' => $langue['oui'],
	'TXT_NON' => $langue['non'],
	'NOM' => (!empty($_POST['nom']))? $_POST['nom'] : '',
	'TXT_NOM' => $langue['form_nom'],
	'PRENOM' => (!empty($_POST['prenom']))? $_POST['prenom'] : '',
	'TXT_PRENOM' => $langue['form_prenom'],
	'LOGIN' => (!empty($_POST['user1']))? $_POST['user1'] : '',
	'TXT_LOGIN' => $langue['form_login'], 
	'TXT_CODE' => $langue['form_psw'], 
	'TXT_RE_CODE' => $langue['form_re_psw'], 
	'CHECKED_SEX_HOMME' => (!empty($_POST['sex']) && $_POST['sex'] == 'Homme')? 'checked="checked"' : '',
	'CHECKED_SEX_FEMME' => (!empty($_POST['sex']) && $_POST['sex'] == 'Femme')? 'checked="checked"' : '',
	'TXT_HOMME' => $langue['sex_homme'],
	'TXT_FEMME' => $langue['sex_femme'],
	'TXT_SEX' => $langue['form_sex'],
	'AGE_D' => (!empty($_POST['age_d']))? $_POST['age_d'] : '',
	'AGE_M' => (!empty($_POST['age_m']))? $_POST['age_m'] : '',
	'AGE_Y' => (!empty($_POST['age_y']))? $_POST['age_y'] : '',
	'DATE_FORMAT' => $langue['date_format'],
	'TXT_NAISSANCE' => $langue['form_naissance'],
	'TXT_LANGUE' => $langue['form_langue'],
	'TEXTE' => (!empty($_POST['texte']))? $_POST['texte'] : '',
	'TXT_TEXTE' => $langue['form_slogan'],
	'WEB' => (!empty($_POST['web']))? $_POST['web'] : '',
	'TXT_WEB' => $langue['form_web'],
	'HISTOIRE' => (!empty($_POST['histoire']))? $_POST['histoire'] : '',
	'TXT_HISTOIRE' => $langue['form_histoire'],
	'MAIL' => (!empty($_POST['mail']))? $_POST['mail'] : '',
	'TXT_MAIL'  => $langue['form_mail'],
	'MSN' => (!empty($_POST['icq']))? $_POST['icq'] : '',
	'TXT_ARME' => $langue['form_fv_arme'],
	'ALT_ARME' => $langue['alt_arme'],
	'DEFAULT_ARMES' => $default_arme,
	'TXT_MSN' => $langue['form_msn'],
	'TXT_IMAGE' => $langue['form_image'],
	'ALT_IMAGE' => $langue['alt_image_profil'],
	'DEFAULT_IMAGE' => $default_img,
	'TXT_HEURE_ETE' => $langue['form_heure_ete'],
	'CHECKED_HEURE_ETE_0' => (isset($_POST['heure_ete']) && $_POST['heure_ete'] == 0)? 'checked="checked"' : '',
	'CHECKED_HEURE_ETE_1' => (!empty($_POST['heure_ete']) && $_POST['heure_ete'] == 1)? 'checked="checked"' : '',
	'TXT_TIME_ZONE' => $langue['form_time_zone'],
	'TIME_ZONE_'.((isset($_POST['time_zone']))? $_POST['time_zone'] : $config['time_zone']) => 'selected="selected"',
	'TXT_TIME_ZONE_-12' => sprintf($langue['select_time_zone'], -12, '00'),
	'TXT_TIME_ZONE_-11' => sprintf($langue['select_time_zone'], -11, '00'),
	'TXT_TIME_ZONE_-10' => sprintf($langue['select_time_zone'], -10, '00'),
	'TXT_TIME_ZONE_-9' => sprintf($langue['select_time_zone'], -9, '00'),
	'TXT_TIME_ZONE_-8' => sprintf($langue['select_time_zone'], -8, '00'),
	'TXT_TIME_ZONE_-7' => sprintf($langue['select_time_zone'], -7, '00'),
	'TXT_TIME_ZONE_-6' => sprintf($langue['select_time_zone'], -6, '00'),
	'TXT_TIME_ZONE_-5' => sprintf($langue['select_time_zone'], -5, '00'),
	'TXT_TIME_ZONE_-4' => sprintf($langue['select_time_zone'], -4, '00'),
	'TXT_TIME_ZONE_-3_5' => sprintf($langue['select_time_zone'], -3.5, 30),
	'TXT_TIME_ZONE_-3' => sprintf($langue['select_time_zone'], -3, '00'),
	'TXT_TIME_ZONE_-2' => sprintf($langue['select_time_zone'], -2, '00'),
	'TXT_TIME_ZONE_-1' => sprintf($langue['select_time_zone'], -1, '00'),
	'TXT_TIME_ZONE_0' => sprintf($langue['select_time_zone'], 0, '00'),
	'TXT_TIME_ZONE_1' => sprintf($langue['select_time_zone'], +1, '00'),
	'TXT_TIME_ZONE_2' => sprintf($langue['select_time_zone'], 2, '00'),
	'TXT_TIME_ZONE_3' => sprintf($langue['select_time_zone'], 3, '00'),
	'TXT_TIME_ZONE_3_5' => sprintf($langue['select_time_zone'], 3.5, 30),
	'TXT_TIME_ZONE_4' => sprintf($langue['select_time_zone'], 4, '00'),
	'TXT_TIME_ZONE_4_5' => sprintf($langue['select_time_zone'], 4.5, 30),
	'TXT_TIME_ZONE_5' => sprintf($langue['select_time_zone'], 5, '00'),
	'TXT_TIME_ZONE_5_5' => sprintf($langue['select_time_zone'], 5, 30),
	'TXT_TIME_ZONE_5_75' => sprintf($langue['select_time_zone'], 5, 75),
	'TXT_TIME_ZONE_6' => sprintf($langue['select_time_zone'], 6, '00'),
	'TXT_TIME_ZONE_6_5' => sprintf($langue['select_time_zone'], 6, 30),
	'TXT_TIME_ZONE_7' => sprintf($langue['select_time_zone'], 7, '00'),
	'TXT_TIME_ZONE_8' => sprintf($langue['select_time_zone'], 8, '00'),
	'TXT_TIME_ZONE_9' => sprintf($langue['select_time_zone'], 9, '00'),
	'TXT_TIME_ZONE_9_5' => sprintf($langue['select_time_zone'], 9, 30),
	'TXT_TIME_ZONE_10' => sprintf($langue['select_time_zone'], 10, '00'),
	'TXT_TIME_ZONE_11' => sprintf($langue['select_time_zone'], 11, '00'),
	'TXT_TIME_ZONE_12' => sprintf($langue['select_time_zone'], 12, '00'),
	'TXT_TIME_ZONE_13' => sprintf($langue['select_time_zone'], 13, '00'),
	'BT_ENVOYER' => $langue['envoyer'],
));
$template->pparse('body');
require($root_path.'conf/frame.php');
?>