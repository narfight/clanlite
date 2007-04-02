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
define('CL_AUTH', true);
$root_path = './../';
$niveau_secu = 11;
$action_membre= 'where_equipe';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['Envoyer']))
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."equipe` (nom, detail) VALUES ('".$_POST['nom']."', '".$_POST['info']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('equipe.php', $langue['redirection_equipe_add'], 'admin');
}
if (!empty($_POST['Editer']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."equipe` SET nom='".$_POST['nom']."', detail='".$_POST['info']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('equipe.php', $langue['redirection_equipe_edit'], 'admin');
}
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."equipe` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// on eneleve le id de l'equipe au membres qui y sont
	$sql = "UPDATE `".$config['prefix']."user` SET equipe='' WHERE equipe='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('equipe.php', $langue['redirection_equipe_dell'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_equipe.tpl'));
liste_smilies_bbcode(true, '', 25);
$template->assign_vars( array( 
	'ICI' => session_in_url('equipe.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_equipe'],
	'TITRE_GESTION' => $langue['titre_equipe_gestion'],
	'TITRE_LISTE' => $langue['titre_equipe_list'],
	'HELP_TXT' => $langue['help_equipe'],
	'TXT_NOM' => $langue['nom_equipe'],
	'TXT_DETAILS' => $langue['détails'],
	'ACTION' => $langue['action'],
	'ALT_AIDE' => $langue['alt_aide'],
));
if (!empty($_POST['edit']))
{
	$sql = "SELECT * FROM ".$config['prefix']."equipe WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit['id'],
		'INFO' => $edit['detail'],
		'NOM' => $edit['nom'],
	));
}
else
{
	$template->assign_block_vars('envoyer', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."equipe ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( $liste = $rsql->s_array($get) )
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'INFO' => bbcode($liste['detail']),
		'NOM' => $liste['nom'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer']
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>