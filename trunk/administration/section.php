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
$niveau_secu = 21;
$action_membre= 'where_admin_section';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path."controle/cook.php");
if (!empty($_POST['envoyer']))
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."section` (nom, limite, visible) VALUES ('".$_POST['nom']."' , '".((!empty($_POST['limite']))? 1 : 0)."' , '".((!empty($_POST['visible']))? 1 : 0)."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text('section.php', $langue['redirection_admin_section_add'], 'admin');
}
if (!empty($_POST['envois_edit']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."section` SET nom='".$_POST['nom']."', limite='".((empty($_POST['limite']))? 0 : 1)."', visible='".((!empty($_POST['visible']))? 1 : 0)."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('section.php', $langue['redirection_admin_section_edit'], 'admin');
	}
}
if (!empty($_POST['Supprimer']))
{
	$sql = "DELETE FROM `".$config['prefix']."section` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// on eneleve le id de la section au membres qui y sont
	$sql = "UPDATE `".$config['prefix']."user` SET section='' WHERE section='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('section.php', $langue['redirection_admin_section_dell'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'admin_section.tpl'));
$template->assign_vars( array(
	'ICI' => session_in_url('section.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_section'],
	'TITRE_GESTION' => $langue['titre_admin_section_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_section_list'],
	'TXT_NOM' => $langue['admin_section_nom'],
	'TXT_LIMITE' => $langue['admin_section_limite'],
	'TITRE_LIMITE' => $langue['admin_section_titre_limite'],
	'TXT_VISIBLE' => $langue['admin_section_visible'],
	'TITRE_VISIBLE' => $langue['admin_section_titre_visible'],
	'ACTION' => $langue['action'],
	'HELP_TXT' => $langue['help_section'],
	'ALT_AIDE' => $langue['alt_aide'],
));
if (!empty($_POST['Editer']))
{
	$sql = "SELECT * FROM ".$config['prefix']."section WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_section = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_section['id'],
		'NOM' => $edit_section['nom'],
		'LIMITE' => ($edit_section['limite'] == 1)? 'checked="checked"' : '',
		'VISIBLE' => ($edit_section['visible'] == 1)? 'checked="checked"' : '',
	));
}
else
{
		$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
		$template->assign_vars( array('VISIBLE' => 'checked="checked"'));	
}
$sql = "SELECT * FROM ".$config['prefix']."section ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'NOM' => $liste['nom'],
		'LIMITE' => ($liste['limite'] == 1)? $langue['admin_section_limite_true'] : $langue['admin_section_limite_false'],
		'VISIBLE' => ($liste['visible'] == 1)? $langue['oui'] : $langue['non'],
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer']
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>