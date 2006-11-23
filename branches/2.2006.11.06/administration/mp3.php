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
$action_membre = 'where_admin_mp3';
$niveau_secu = 17;
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM ".$config['prefix']."config_sond WHERE id = '".$_POST['for']."'";
	if (! $rsql->requete_sql($sql) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('mp3.php',$langue['redirection_admin_mp3_dell'],'admin');
}
if (!empty($_POST['Envoyer']))
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."config_sond` (`ordre`, `SRC`, `titre`) VALUES ('".$_POST['ordre']."', '".$_POST['SRC']."', '".$_POST['titre']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('mp3.php', $langue['redirection_admin_mp3_add'], 'admin');
}
if (!empty($_POST['Editer']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."config_sond` SET `ordre`='".$_POST['ordre']."', `SRC`='".$_POST['SRC']."', `titre`='".$_POST['titre']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('mp3.php', $langue['redirection_admin_mp3_edit'],'admin');
	}
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_mp3.tpl'));
$template->assign_vars(array( 
	'ICI' => session_in_url('mp3.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_mp3'],
	'TITRE_GESTION' => $langue['titre_admin_mp3_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_mp3_list'],
	'ACTION' => $langue['action'],
	'SUPPRIMER' => $langue['supprimer'],
	'EDITER' => $langue['editer'],
	'CHOISIR' => $langue['choisir'],
	'TXT_SOURCE' => $langue['admin_mp3_source'],
	'TXT_AUTO_PLAY' => $langue['admin_mp3_autoplay'],
	'TXT_ORDRE' => $langue['custom_menu_ordre'],
	'TXT_TITRE' => $langue['mp3_titre'],
	'OUI' => $langue['oui'],
	'NON' => $langue['non'],
	'CHECK_AUTOPLAY_1' => ($config['mp3_auto_start'] == 1)? 'selected="selected"' : '',
	'CHECK_AUTOPLAY_0' => ($config['mp3_auto_start'] == 0)? 'selected="selected"' : '',
));
if (!empty($_POST['edit']))
{
	$sql = "SELECT * FROM `".$config['prefix']."config_sond` WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$donnees = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array(
		'ID' => $donnees['id'],
		'SCR' => $donnees['SRC'],
		'TITRE_MP3' => $donnees['titre'],
		'ORDRE' => $donnees['ordre'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer'])); 
}
$sql = "SELECT `id`, `SRC`, `titre` , `ordre` FROM `".$config['prefix']."config_sond` ORDER BY `ordre` ASC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( $liste = $rsql->s_array($get) )
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'SRC' => $liste['SRC'],
		'TITRE' => $liste['titre'],
		'ORDRE' => $liste['ordre'],
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>