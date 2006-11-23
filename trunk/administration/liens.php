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
$niveau_secu = 13;
$action_membre= 'where_liens_admin';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path."controle/cook.php");
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."liens` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("liens.php", $langue['redirection_liens_dell'], 'admin');
}
if (!empty($_POST['Envoyer']))
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."liens` (nom_liens, url_liens, images) VALUES ('".$_POST['nom_liens']."', '".$_POST['url_liens']."', '".$_POST['url_image']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("liens.php", $langue['redirection_liens_add'], 'admin');
	}
}
if (!empty($_POST['Editer']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."liens` SET nom_liens='".$_POST['nom_liens']."', url_liens='".$_POST['url_liens']."', images='".$_POST['url_image']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("liens.php", $langue['redirection_liens_edit'], 'admin');
	}
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'admin_liens.tpl'));
$template->assign_vars( array(
	'ICI' => session_in_url('liens.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_liens_admin'],
	'TITRE_GESTION' => $langue['titre_liens_admin_gestion'],
	'TITRE_LISTE' => $langue['titre_liens_admin_list'],
	'ACTION' => $langue['action'],
	'TXT_NOM' => $langue['liens_nom_site'],
	'TXT_URL' => $langue['liens_url_site'],
	'TXT_IMAGE' => $langue['liens_image_site'],
));
if (!empty($_POST['edit']))
{
	$sql = "SELECT * FROM ".$config['prefix']."liens WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_liens_info = $rsql->s_array($get);
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_liens_info['id'],
		'NOM' => $edit_liens_info['nom_liens'],
		'URL' => $edit_liens_info['url_liens'],
		'IMAGE' => $edit_liens_info['images'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."liens ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( $liste = $rsql->s_array($get) )
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'NOM' => $liste['nom_liens'],
		'URL' => $liste['url_liens'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
		'TEST_LIEN' => $langue['liens_test_url'],
	));
	if (!empty($liste['images']))
	{
		$template->assign_block_vars('liste.image', array('IMAGE' => $liste['images']));
	}
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>