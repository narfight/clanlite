<?php
/****************************************************************************
 *	Fichier		: game_serveur.phh											*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$niveau_secu = 6;
$action_membre= 'where_game_server';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['envoyer']))
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."game_server` (`ip`, `port`, `protocol`, `clan`) VALUES ('".$_POST['ip']."', '".$_POST['port']."', '".$_POST['protocol']."', '".((!empty($_POST['clan']))? 1 : 0)."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('game_serveur.php', $langue['redirection_game_server_add'], 'admin');
}
if (!empty($_POST['envois_edit']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."game_server` SET `ip`='".$_POST['ip']."', `port`='".$_POST['port']."', `protocol`='".$_POST['protocol']."', `clan`='".((!empty($_POST['clan']))? 1 : 0)."' WHERE `id`='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('game_serveur.php', $langue['redirection_game_server_edit'], 'admin');
	}
}
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."game_server` WHERE `id` ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// supprime les informations en cache sur ce serveur
	$sql = "DELETE FROM `".$config['prefix']."game_server_cache` WHERE `id_serveur` ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('game_serveur.php', $langue['redirection_game_server_dell'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_game_serveur.tpl'));
$template->assign_vars( array( 
	'ICI' => session_in_url('game_serveur.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_game_server'],
	'TITRE_GESTION' => $langue['titre_game_server_gestion'],
	'TITRE_LISTE' => $langue['titre_game_server_list'],
	'ACTION' => $langue['action'],
	'TXT_CHOISIR' => $langue['choisir'],
	'TXT_SERVEUR_GAME_PORT' => $langue['serveur_game_port'],
	'TXT_HELP_GAME_PORT' => $langue['serveur_game_help_port'],
	'TXT_SERVEUR_GAME_IP' => $langue['serveur_game_ip'],
	'TXT_SERVEUR_GAME_PROTOCOL' => $langue['serveur_game_protocol'],
	'TXT_CLAN' => $langue['serveur_game_clan'],
	'ALT_AIDE' => $langue['alt_aide'],
	'TXT_IP' => $langue['ip'],
	'TXT_PORT' => $langue['port'],
	'TXT_PROTOCOL' => $langue['protocol'],
));
if (!empty($_POST['edit']))
{
	$sql = 'SELECT * FROM `'.$config['prefix'].'game_server` WHERE `id`=\''.$_POST['for'].'\'';
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_game_list = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_game_list['id'],
		'IP' => $edit_game_list['ip'],
		'PORT' => $edit_game_list['port'],
		'CLAN_CHECKED' => ($edit_game_list['clan'] != 1)? '' : 'checked="checked"',
	));
}
else
{
	$template->assign_block_vars('envoyer', array('ENVOYER' => $langue['envoyer']));
}
// scan les protocols possible pour le scanner de serveur de jeux
require($root_path.'service/gsquery/gsQuery.php');
foreach(gsQuery::getSupportedProtocols($root_path."service/gsquery/") as $protocol_liste)
{
	$template->assign_block_vars('protocol_game_liste', array(
		'NAME' => $protocol_liste,
		'VALUE' => $protocol_liste,
		'SELECTED' => (!empty($edit_game_list['protocol']) && $edit_game_list['protocol'] === $protocol_liste) ? 'selected="selected"' : '',
	));
}
$sql = 'SELECT * FROM `'.$config['prefix'].'game_server` ORDER BY `id` DESC';
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'IP' => $liste['ip'],
		'PORT' => $liste['port'],
		'PROTOCOL' => $liste['protocol'],
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer']
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>