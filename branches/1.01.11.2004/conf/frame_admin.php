<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (!empty($page_frame_admin))
{
	$template = new Template($root_path.'templates/'.$config['skin']);
	$template->set_filenames( array('foot_admin' => 'bas_de_page_admin.tpl'));
}
else
{
	$debut = getmicrotime();
	$template = new Template($root_path.'templates/'.$config['skin']);
	$template->set_filenames( array('head_admin' => 'haut_de_page_admin.tpl'));
}
// ce qui doit avoir soit dans le haut ou le bas de page admin
$template->assign_vars( array( 
	'PATH_ROOT' => $root_path,
	'HEAD' => (!empty($frame_head))? $frame_head : '',
	'ICI_SELF' => $config['site_domain'].$_SERVER['PHP_SELF'],
	'ICI' => $config['site_domain'].$config['site_path'],
	'TITRE_PAGE' => $langue['prive_titre_page'],
	'ENTRAINEMENT' => $langue['titre_entrainement'],
	'ENTRAINEMENT_U' => session_in_url($root_path.'service/entrainement.php'),
	'LISTE_MEMBRES' => $langue['titre_liste_membres'],
	'LISTE_MEMBRES_U' => session_in_url($root_path.'service/liste-des-membres.php'),
	'CONNECTE' => $langue['titre_connecte'],
	'CONNECTE_U' => session_in_url($root_path.'service/connecter.php'),
	'MATCH' => $langue['titre_match'],
	'MATCH_U' => session_in_url($root_path.'service/membre_match.php'),
	'EDITER_PROFIL' => $langue['titre_edit_user'],
	'EDITER_PROFIL_U' => session_in_url($root_path.'user/edit-user.php'),
	'LOGIN' => $langue['boutton_deconnect'].'['.$session_cl['user'].']',
	'LOGIN_U' => session_in_url($root_path.'controle/die-cook.php?where='.$root_path.'admin.php'),
	'TITRE_USER' => $langue['menu_titre_user'],
	'TITRE_GO_PUBLIQUE' => $langue['menu_titre_go_publique'],
	'TITRE_GO_PUBLIQUE_U' => session_in_url($root_path.'service/index_pri.php'),
	'TITRE_GO_INDEX' => $langue['menu_titre_prive_entree'],
	'TITRE_GO_INDEX_U' => session_in_url($root_path.'user/index.php'),
));
if ($user_pouvoir['particulier'] == 'admin' || in_array('oui', $user_pouvoir))
{
	$template->assign_block_vars('menu_admin', array( 
		'TITRE_PAGE' => $langue['prive_titre_page'],
		'TITRE_ADMIN' => $langue['menu_titre_admin'],
		'TITRE_USER' => $langue['menu_titre_user'],
		'TITRE_MODULE' => $langue['menu_titre_module'],
		'ALERT' => $langue['titre_alert'],
		'ALERT_U' => session_in_url($root_path.'administration/alert.php'),
		'CONFIGURE' => $langue['titre_config_site'],
		'CONFIGURE_U' => session_in_url($root_path.'administration/config.php'),
		'DEMANDE_MATCH' => $langue['titre_defit_admin'],
		'DEMANDE_MATCH_U' => session_in_url($root_path.'administration/demande-match.php'),
		'EQUIPE' => $langue['titre_equipe'],
		'EQUIPE_U' => session_in_url($root_path.'administration/equipe.php'),
		'GAME_SERVEUR' => $langue['titre_game_server'],
		'GAME_SERVEUR_U' => session_in_url($root_path.'administration/game_serveur.php'),
		'LIENS' => $langue['titre_liens_admin'],
		'LIENS_U' => session_in_url($root_path.'administration/liens.php'),
		'MATCH' => $langue['titre_admin_match'],
		'MATCH_U' => session_in_url($root_path.'administration/match.php'),
		'MENU_EDIT' => $langue['titre_custom_menu'],
		'MENU_EDIT_U' => session_in_url($root_path.'administration/menu_boutton.php'),
		'MODULE' => $langue['titre_module'],
		'MODULE_U' => session_in_url($root_path.'administration/modules.php'),
		'MP3' => $langue['titre_admin_mp3'],
		'MP3_U' => session_in_url($root_path.'administration/mp3.php'),
		'NEWS' => $langue['titre_admin_news'],
		'NEWS_U' => session_in_url($root_path.'administration/news.php'),
		'RAPPORT_MATCH' => $langue['titre_admin_rapport_match'],
		'RAPPORT_MATCH_U' => session_in_url($root_path.'administration/rapport.php'),
		'MAP_SERVEUR' => $langue['titre_admin_map_serveur'],
		'MAP_SERVEUR_U' => session_in_url($root_path.'administration/server_map.php'),
		'SMILIE' => $langue['titre_admin_smilies'],
		'SMILIE_U' => session_in_url($root_path.'administration/smilies.php'),
		'SECTION' => $langue['titre_admin_section'],
		'SECTION_U' => session_in_url($root_path.'administration/section.php'),
		'TELECHARGER' => $langue['titre_download_admin'],
		'TELECHARGER_U' => session_in_url($root_path.'administration/download.php'),
		'ENTRAINEMENT' => $langue['titre_entrain'],
		'ENTRAINEMENT_U' => session_in_url($root_path.'administration/entrainements.php'),
		'MAILLINGLISTE' => $langue['titre_admin_mailiste'],
		'MAILLINGLISTE_U' => session_in_url($root_path.'administration/mailiste.php'),
	));
	if ($config['show_grade'] == 1)
	{
		$template->assign_block_vars('menu_admin.grade', array(
			'GRADE' => $langue['titre_grade'],
			'GRADE_U' => session_in_url($root_path.'administration/grades.php')
		));
	}
	$sql = "SELECT id,nom,place,call_page,config FROM `".$config['prefix']."modules`";
	if (! ($get_module = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$get_nfo_module = 1;
	while( $modules = $rsql->s_array($get_module) )
	{
		include($root_path.'modules/'.$modules['call_page']);
		if ( !empty($filename) && !empty($nom) )
		{
			$template->assign_block_vars('menu_admin.list_module', array( 
				'URL' => session_in_url($root_path.'modules/'.$modules['call_page'].'?config_modul_admin=oui&id_module='.$modules['id']),
				'NOM' => $modules['nom']
			));
		}
		$filename = '';
		$nom = '';
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
	$template->pparse('foot_admin');
}
else
{
	$template->pparse('head_admin');
	$page_frame_admin = 'foot';
}
?>