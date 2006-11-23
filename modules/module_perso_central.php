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
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = 'Module perso (central)';
		$central = true;
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$sql = "INSERT INTO `".$config['prefix']."custom_menu` ( `id` , `ordre` , `text` , `url` , `bouge` , `frame` , `module_central` , `id_module` ) VALUES ('', '0', '".$_POST['nom']."', 'modules/module_perso_central.php?from=".mysql_insert_id()."', '0', '0', '1', '".mysql_insert_id()."')";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		$sql = "DELETE FROM `".$config['prefix']."custom_menu` WHERE `id_module` = '".$_POST['for']."' LIMIT 1";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
}
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_module_p_centrale']) )
{
	$root_path = './../';
	$action_membre= 'where_module_module_custom';
	$niveau_secu = 16;
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'controle/cook.php');
	$id_module = (!empty($_POST['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	if ( !empty($_POST['Submit_module_p_centrale']) )
	{
		$_POST = pure_var($_POST, 'total', true);
		$serialisation = pure_var(serialize(array('contenu' => $_POST['contenu'], 'titre' => $_POST['titre'])), 'del', true);
		$_POST = pure_var($_POST, 'del', true);
		$sql = "UPDATE ".$config['prefix']."modules SET config='".$serialisation."' WHERE id ='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'administration/modules.php' ,$langue['redirection_module_custom_edit'], 'admin');
	}
	require($root_path.'conf/frame_admin.php');
	$template = new Template($root_path.'templates/'.$session_cl['skin']);
	$template->set_filenames( array('body' => 'modules/module_perso_central.tpl'));
	liste_smilies_bbcode(true, '', 25);
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$recherche = $rsql->s_array($get);
	$recherche = unserialize($recherche['config']);
	$template->assign_vars(array(
		'ICI' => session_in_url('module_perso_central.php'),
		'TITRE' => $langue['titre_module_module_custom_c'],
		'ID'=> $id_module,
		'TXT_CONTENU' => $langue['module_custom_contenu'],
		'CONTENU' => $recherche['contenu'],
		'TXT_TITRE' => $langue['module_custom_titre'],
		'TITRE' => $recherche['titre'],
		'EDITER' => $langue['editer'],
	));
	$template->pparse('body');
	require($root_path.'conf/frame_admin.php');
	return;
}
if (!empty($_GET['from']))
{
	$root_path = './../';
	$action_membre = 'where_module_central';
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'conf/frame.php');
	$template->set_filenames(array('body' => 'divers_text.tpl'));
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".intval($_GET['from'])."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$recherche = $rsql->s_array($get);
	$recherche = unserialize($recherche['config']);
	$template->assign_vars(array(
		'TITRE' => $recherche['titre'],
		'TEXTE' => $recherche['contenu'],
	));
	$template->pparse('body');
	require($root_path.'conf/frame.php'); 
}
?>