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
$action_membre= 'where_config_site';
$niveau_secu = 2;
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path."controle/cook.php");
if( !empty($_POST['Submit']) )
{
	foreach ($_POST as $config_name => $config_value)
	{
		$sql = 'UPDATE `'.$config['prefix']."config` SET conf_valeur='".pure_var($config_value)."' WHERE conf_nom='".htmlspecialchars($config_name, ENT_QUOTES)."'";
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}
	// on prend la config
	$sql = 'SELECT * FROM `'.$config['prefix'].'config`';
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while($donnees = $rsql->s_array($get))
	{
		$config[$donnees['conf_nom']] = $donnees['conf_valeur'];
	}
	unset($langue);
	// on redifinit les varriables importante pour le bon déroulement du script
	$config['time_cook'] = 60*$config['time_cook'];
	require ($root_path.'langues/'.$config['langue_actuelle'].'/langue.php');
	redirec_text('config.php', $langue['redirection_config_ok'] , 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'admin_config.tpl'));
// on fait la liste des membres
$sql = 'SELECT `id` ,`user` FROM `'.$config['prefix'].'user`';
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while($user_list = $rsql->s_array($get))
{
	$template->assign_block_vars('list_membre_match', array(
		'ID' => $user_list['id'],
		'NOM' => $user_list['user'],
		'SELECTED_ID_MATCH' => ( $user_list['id'] == $config['id_membre_match'] ) ? 'selected="selected"' : ''
	));
}
// scan le rep pour les langues
$dir = '../langues/';
// Ouvre un dossier bien connu, et liste tous les fichiers
if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if($file != '..' && $file !='.' && $file !='')
			{ 
				$template->assign_block_vars('langue', array(
					'NAME' => $file,
					'VALUE' => $file,
					'SELECTED' => ( $config['langue'] == $file) ? 'selected="selected"' : '',
				));
			}
		}
		closedir($dh);
	}
}
// scan le rep pour les skins
$dir = '../templates/';
// Ouvre un dossier bien connu, et liste tous les fichiers
if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if($file != '..' && $file !='.' && $file !='' && is_dir($dir.$file))
			{ 
				$template->assign_block_vars('skin', array(
					'NAME' => $file,
					'VALUE' => $file,
					'SELECTED' => ( $config['skin_default'] == $file) ? 'selected="selected"' : '',
				));
			}
		}
		closedir($dh);
	}
}
liste_smilies(true, '', 25);
$template->assign_vars( array( 
	'ICI' => session_in_url('config.php'),
	'TITRE' => $langue['titre_config_site'],
	'TITRE_CONFIG_BASE' => $langue['config_site_base_titre'],
	'TITRE_CONFIG_AVANCEE' => $langue['config_site_avancée_titre'],
	'TITRE_INSCRIPTION' => $langue['config_inscription_titre'],
	'ALT_AIDE' => $langue['alt_aide'],
	'TXT_USER_MATCH' => $langue['config_user_match'],
	'TXT_CHOISIR' => $langue['choisir'],
	'TXT_OUI' => $langue['oui'],
	'TXT_NON' => $langue['non'],
	'TXT_LANGUE' => $langue['config_langue'],
	'TXT_SKIN' => $langue['config_skin'],
	'TAG' => $config['tag'],
	'TXT_TAG' => $langue['config_tag_clan'],
	'NOM_CLAN' => $config['nom_clan'],
	'TXT_NOM_CLAN' => $langue['config_nom_clan'],
	'OBJET_PAR_PAGE' => $config['objet_par_page'],
	'TXT_OBJET_PAR_PAGE' => $langue['config_nbr_par_page'],
	'TXT_HELP_OBJET_PAR_PAGE' => $langue['config_help_nbr/page'],
	'URL_SITE_DOMAIN' => $config['site_domain'],
	'TXT_URL_SITE_DOMAIN' => $langue['config_domain_site'],
	'URL_SITE_PATH' => $config['site_path'],
	'TXT_URL_SITE_PATH' => $langue['config_path_site'],
	'MAIL' => $config['master_mail'],
	'TXT_MAIL' => $langue['config_webmasteur'],
	'TIME_COOK' => $config['time_cook']/60,
	'TXT_TIME_COOK' => $langue['config_tmp_session'],
	'LIMITE' => $config['limite_inscription'],
	'TXT_LIMITE' => $langue['config_recrutement_limit_txt'],
	'REGLEMENT' => $config['reglement'],
	'TXT_REGLEMENT' => $langue['config_reglement'],
	'TXT_MSG_BIENVENU' => $langue['config_msg_news_membre'],
	'MSG_BIENVENU' => $config['msg_bienvenu'],
	'URL_FORUM' => $config['url_forum'],
	'TXT_URL_FORUM' => $langue['config_url_config'],
	'RECRUTEMENT_ALERT_OUI' => ( 1 == $config['recrutement_alert'] ) ? 'selected="selected"' : '',
	'RECRUTEMENT_ALERT_NON' => ( 1 != $config['recrutement_alert'] ) ? 'selected="selected"' : '',
	'TXT_RECRUTEMENT_ALERT' => $langue['config_show_recrute_index'],

	'SELECT_INSCI_0' => ( 0 == $config['inscription'] ) ? 'selected="selected"' : '',
	'SELECT_INSCI_1' => ( 1 == $config['inscription'] ) ? 'selected="selected"' : '',
	'SELECT_INSCI_2' => ( 2 == $config['inscription'] ) ? 'selected="selected"' : '',
	'TXT_INSCRI' => $langue['config_etat_recrute'],
	'TXT_INSCRI_LIMIT' => $langue['config_recrute_limit'],
	'BT_EDITER' => $langue['editer'],
	'TXT_SEND_MAIL_TITRE' => $langue['config_mail_send_titre'],
	'TXT_SEND_MAIL' => $langue['config_send_by'],
	'SEND_MAIL' => $config['send_mail'],
	'SEND_MAIL_PAR_PHP' => ( $config['send_mail'] == 'php' ) ? 'selected="selected"' : '',
	'SEND_MAIL_PAR_SMTP' => ( $config['send_mail'] == 'smtp' ) ? 'selected="selected"' : '',
	'TXT_SEND_SMTP' => $langue['config_by_smtp'],
	'TXT_SEND_PHP' => $langue['config_by_php'],
	'TXT_SMTP_IP' => $langue['config_smtp_server_ip'],
	'SMTP_IP' => $config['smtp_ip'],
	'TXT_SMTP_PORT' => $langue['config_smtp_server_port'],
	'SMTP_PORT' => $config['smtp_port'],
	'TXT_SMTP_CODE' => $langue['config_smtp_code'],
	'SMTP_CODE' => $config['smtp_code'],
	'TXT_SMTP_LOGIN' => $langue['config_smtp_login'],
	'SMTP_LOGIN' => $config['smtp_login'],
	'TXT_SCAN_GAME_SERVER' => $langue['config_scan_game_server'],
	'TXT_HELP_SCAN_GAME_SERVER' => $langue['config_help_scan_game_server'],
	'SCAN_GAME_SERVER' => $config['scan_game_server'],
	'TXT_SCAN_GAME_SERVER_UDP' => $langue['config_scan_game_server_udp'],
	'TXT_SCAN_GAME_SERVER_HTTP' => $langue['config_scan_game_server_http'],
	'SELECT_SCAN_UDP' => ( 'udp' == $config['scan_game_server'] ) ? 'selected="selected"' : '',
	'SELECT_SCAN_HTTP' => ( 'http' == $config['scan_game_server'] ) ? 'selected="selected"' : '',
	'TXT_SHOW_GRADE' => $langue['config_show_grade'],
	'SHOW_GRADE_1' => ( '1' == $config['show_grade'] ) ? 'selected="selected"' : '',
	'SHOW_GRADE_0' => ( '0' == $config['show_grade'] ) ? 'selected="selected"' : '',
));
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>