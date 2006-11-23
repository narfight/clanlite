<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_config_site';
$niveau_secu = 2;
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if( !empty($_POST['Submit']) )
{
	foreach ($_POST as $config_name => $config_value)
	{
		$sql = "UPDATE ".$config['prefix']."config SET conf_valeur='".htmlspecialchars($config_value, ENT_QUOTES)."' WHERE conf_nom='".htmlspecialchars($config_name, ENT_QUOTES)."'";
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}
	// on prend la config
	$sql = "SELECT * FROM ".$config['prefix']."config";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while($donnees = $rsql->s_array($get))
	{
		$config[$donnees['conf_nom']] = $donnees['conf_valeur'];
	}
	unset($langue);
	// on redifinit les varriables importante pour le bon d�roulement du script
	$config['time_cook'] = 60*$config['time_cook'];
	$config['langue'] = (empty($session_cl['langue_user']))? $config['langue'] : $session_cl['langue_user'];
	include ($root_path."langues/".$config['langue']."/langue.php");
	redirec_text("config.php", $langue['redirection_config_ok'] , "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_config.tpl'));
// on fait la liste des membres
$sql = "SELECT id,user FROM ".$config['prefix']."user";
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
// scan les protocols possible pour le scanner de serveur de jeux
include($root_path."service/gsquery/gsQuery.php");
foreach(gsQuery::getSupportedProtocols($root_path."service/gsquery/") as $protocol_liste)
{
	$template->assign_block_vars('protocol_game_liste', array(
		'NAME' => $protocol_liste,
		'VALUE' => $protocol_liste,
		'SELECTED' => ($config['serveur_game_protocol'] == $protocol_liste) ? 'selected="selected"' : '',
	));
}
// scan le rep pour les langues
$dir = "../langues/";
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
$dir = "../templates/";
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
					'SELECTED' => ( $config['skin'] == $file) ? 'selected="selected"' : '',
				));
			}
		}
		closedir($dh);
	}
}
liste_smilies(true, '', 25);
$template->assign_vars( array( 
	'TITRE' => $langue['titre_config_site'],
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
	'LIST_GAME_SERVEUR_OUI' => ( "oui" == $config['list_game_serveur'] ) ? 'selected="selected"' : '',
	'LIST_GAME_SERVEUR_NON' => ( "oui" != $config['list_game_serveur'] ) ? 'selected="selected"' : '',
	'TXT_LIST_GAME_SERVEUR' => $langue['config_show_server_list'],
	'RECRUTEMENT_ALERT_OUI' => ( 1 == $config['recrutement_alert'] ) ? 'selected="selected"' : '',
	'RECRUTEMENT_ALERT_NON' => ( 1 != $config['recrutement_alert'] ) ? 'selected="selected"' : '',
	'TXT_RECRUTEMENT_ALERT' => $langue['config_show_recrute_index'],
	'SERVEUR_GAME_IP' => $config['serveur_game_ip'],
	'TXT_SERVEUR_GAME_IP' => $langue['config_serveur_ip'],
	'SERVEUR_GAME_PORT' => $config['serveur_game_port'],
	'TXT_SERVEUR_GAME_PORT' => $langue['config_serveur_port'],
	'TXT_HELP_GAME_PORT' => $langue['config_help_port'],
	'TXT_SERVEUR_GAME_PROTOCOL' => $langue['config_serveur_protocol'],
	'SERVEUR_GAME_INFO' => $config['serveur_game_info'],
	'SELECT_INSCI_0' => ( 0 == $config['inscription'] ) ? 'selected="selected"' : '',
	'SELECT_INSCI_1' => ( 1 == $config['inscription'] ) ? 'selected="selected"' : '',
	'SELECT_INSCI_2' => ( 2 == $config['inscription'] ) ? 'selected="selected"' : '',
	'TXT_INSCRI' => $langue['config_etat_recrute'],
	'TXT_INSCRI_LIMIT' => $langue['config_recrute_limit'],
	'SERVEUR_GAME_OUI' => ( 1 == $config['serveur'] ) ? 'selected="selected"' : '',
	'SERVEUR_GAME_NON' => ( 0 == $config['serveur'] ) ? 'selected="selected"' : '',
	'TXT_SERVEUR_GAME' => $langue['config_serveur_game'],
	'BT_EDITER' => $langue['editer'],
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
));
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>