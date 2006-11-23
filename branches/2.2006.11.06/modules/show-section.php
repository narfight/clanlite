<?php
/****************************************************************************
 *	Fichier		: show-section.php											*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = 'Afficher une section';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	$block = module_tpl('show-section.tpl');

	// si il veut tout les membres ou seulement une team
	if ($modules['config'] === 0 || $modules['config'] == '')
	{ //tout
		$sql = 'SELECT `id`, `user`, `sex`, `im` FROM `'.$config['prefix'].'user`';
	}
	else
	{ //une seul team
		$sql = 'SELECT `id`, `user`, `sex`, `im` FROM `'.$config['prefix'].'user` WHERE `section`=\''.$modules['config']['serveur'].'\'';
	}
	
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}

	// Turn template blocks into PHP assignment statements for the values of $match..
	$block = module_tpl('show-section.tpl');		

	// on configure le html utilisé dans le listage
	$block['liste'] = str_replace('{PATH_ROOT}', $root_path, $block['liste']);
	$block['liste'] = str_replace('{ALT_MSN}', $langue['alt_msn'], $block['liste']);

	// liste des joueurs
	$user_liste = '';
	while ($liste = $rsql->s_array($get))
	{
		$sex = ($liste['sex'] === 'Femme')? 'femme' : 'homme';
		$user_liste_beta = str_replace('{USER}', $liste['user'], $block['liste']);
		$user_liste_beta = str_replace('{PROFIL_U}', session_in_url($root_path.'service/profil.php?link='.$liste['id']), $user_liste_beta);
		$user_liste_beta = str_replace('{IM}', $liste['im'], $user_liste_beta);
		$user_liste .= str_replace('{SEX}', $sex, $user_liste_beta);
	}
	$contenu = str_replace('{LISTE}', $user_liste, $block['total']);

	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => $contenu
	));
	return;
}

if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_module']) )
{
	$root_path = './../';
	$action_membre= 'where_module_show-section';
	$niveau_secu = 16;
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'controle/cook.php');
	$id_module = (!empty($_POST['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	if ( !empty($_POST['Submit_module']) )
	{
		$sql = "UPDATE `".$config['prefix']."modules` SET `config`='".$_POST['section']."' WHERE `id`='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'administration/modules.php' , $langue['redirection_module_show-section'], 'admin');
	}
	require($root_path.'conf/frame_admin.php');
	$template = new Template($root_path.'templates/'.$session_cl['skin']);
	$template->set_filenames( array('body' => 'modules/show-section.tpl'));
	
	// prend la configuration du module
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$actu_data = $rsql->s_array($get);
	$actu_data = $actu_data['config'];
	
	// liste les sections
	$sql = "SELECT * FROM ".$config['prefix']."section ORDER BY `id` DESC";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$liste = '';
	while ($section_liste = $rsql->s_array($get))
	{
		$liste .='<option value="'.$section_liste['id'].'" '.(($actu_data === $section_liste['id'])? 'selected="selected"' : '').'>'.$section_liste['nom'].'</option>';
	}
	$template->assign_block_vars('module_config',array(
		'ICI' => session_in_url('show-section.php'),
		'TITRE' => $langue['titre_module_show-section'],
		'TXT_LISTE' => $langue['liste_module_serveur_game'],
		'TXT_SECTION' => $langue['quelle_section'],
		'ALL_SECTION' => $langue['toutes_section'],
		'CHOISIR' => $langue['choisir'],
		'EDITER' => $langue['editer'],
		'ID'=> $id_module,
		'LISTE'=> $liste,
	));
	$template->pparse('body');
	require($root_path.'conf/frame_admin.php');
}
?>