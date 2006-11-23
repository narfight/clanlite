<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (!empty($page_frame_admin))
{
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('foot_admin' => 'bas_de_page_admin.tpl'));
}
else
{
	$debut = getmicrotime();
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('head_admin' => 'haut_de_page_admin.tpl'));
}
// ce qui doit avoir soit dans le haut ou le bas de page admin
$template->assign_vars( array( 
	'PATH_ROOT' => $root_path,
	'HEAD' => (!empty($frame_head))? $frame_head : "",
	'ENTRAINEMENT' => $langue['titre_entrainement'],
	'LISTE_MEMBRES' => $langue['titre_liste_membres'],
	'CONNECTE' => $langue['titre_connecte'],
	'ICI_SELF' => $config['site_domain'].$_SERVER['PHP_SELF'],
	'ICI' => $config['site_domain'].$config['site_path'],
	'MATCH' => $langue['titre_match'],
	'EDITER_PROFIL' => $langue['titre_edit_user'],
	'LOGIN' => $langue['boutton_deconnect']."[".$session_cl['user']."]",
	'TITRE_USER' => $langue['menu_titre_user'],
	'TITRE_GO_PUBLIQUE' => $langue['menu_titre_go_publique'],
	'TITRE_GO_INDEX' => $langue['menu_titre_prive_entree'],
	'TITRE_PAGE' => $langue['prive_titre_page'],
));
if ( $user_pouvoir['particulier'] == "admin" || in_array('oui', $user_pouvoir))
{
	$template->assign_block_vars('menu_admin', array( 
		'TITRE_PAGE' => $langue['prive_titre_page'],
		'TITRE_ADMIN' => $langue['menu_titre_admin'],
		'TITRE_USER' => $langue['menu_titre_user'],
		'TITRE_MODULE' => $langue['menu_titre_module'],
		'ALERT' => $langue['titre_alert'],
		'CONFIGURE' => $langue['titre_config_site'],
		'DEMANDE_MATCH' => $langue['titre_defit_admin'],
		'EQUIPE' => $langue['titre_equipe'],
		'GAME_SERVEUR' => $langue['titre_game_server'],
		'GRADE' => $langue['titre_grade'],
		'LIENS' => $langue['titre_liens_admin'],
		'MATCH' => $langue['titre_admin_match'],
		'MENU_EDIT' => $langue['titre_custom_menu'],
		'MODULE' => $langue['titre_module'],
		'MP3' => $langue['titre_admin_mp3'],
		'NEWS' => $langue['titre_admin_news'],
		'RAPPORT_MATCH' => $langue['titre_admin_rapport_match'],
		'MAP_SERVEUR' => $langue['titre_admin_map_serveur'],
		'SMILIE' => $langue['titre_admin_smilies'],
		'SECTION' => $langue['titre_admin_section'],
		'TELECHARGER' => $langue['titre_download_admin'],
		'ENTRAINEMENT' => $langue['titre_entrain'],
		'MAILLINGLISTE' => $langue['titre_admin_mailiste'],
	));
	$sql = "SELECT id,nom,place,call_page,config FROM `".$config['prefix']."modules`";
	if (! ($get_module = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$get_nfo_module = 1;
	while( $modules = $rsql->s_array($get_module) )
	{
		include($root_path."modules/".$modules['call_page']);
		if ( !empty($filename) && !empty($nom) )
		{
			$template->assign_block_vars('menu_admin.list_module', array( 
				'URL' => $root_path."modules/".$modules['call_page']."?config_modul_admin=oui&id_module=".$modules['id'],
				'NOM' => $modules['nom']
			));
		}
		$filename = "";
		$nom = "";
	}
	@closedir($dir);
	$template->assign_block_vars('admin', array( 
		'TIME_EXECUT_NBR_SQL' =>  sprintf($langue['exec_time_rsql'], getmicrotime() - $debut, $rsql->nb_req)
	));
}
if (!empty($page_frame_admin))
{
	$template->assign_vars(array(
		'VERSION' => $config['version'],
		'COPYRIGHT' =>  sprintf($langue['copyright'], $config['version']),
	));
	if (!empty($user_pouvoir['particulier']) && $user_pouvoir['particulier'] == "admin")
	{
	}
	$template->pparse('foot_admin');
}
else
{
	$template->pparse('head_admin');
	$page_frame_admin = "foot";
}
?>