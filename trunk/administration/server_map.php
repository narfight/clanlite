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
$niveau_secu = 20;
$action_membre = 'where_admin_map_serveur';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if ( !empty($_POST['Envoyer']) )
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."server_map` (nom, url, nom_console) VALUES ('".$_POST['nom_map']."', '".$_POST['url_map']."', '".$_POST['console']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// on regarde si la map qu'il a entré n'est pas déja dans les maps des match ou des rapports
	// si oui, on le supprime et remplace par l'id
	if (!empty($_POST['nom_map']))
	{
		$sql = "UPDATE `".$config['prefix']."match_map` SET nom='', id_map='".mysql_insert_id()."' WHERE nom='".$_POST['nom_map']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "UPDATE `".$config['prefix']."match_rapport_map` SET nom='', id_map='".mysql_insert_id()."' WHERE nom='".$_POST['nom_map']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}
	redirec_text('server_map.php', $langue['redirection_admin_map_serveur_add'], 'admin');
}
if ( !empty($_POST['Editer']) )
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."server_map` SET nom='".$_POST['nom_map']."', url='".$_POST['url_map']."', nom_console='".$_POST['console']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// il est possible qu'il modifie le nom de la map en une map etant dans les matchs/rapport
	if (!empty($_POST['nom_map']))
	{
		$sql = "UPDATE `".$config['prefix']."match_map` SET nom='', id_map='".$_POST['for']."' WHERE nom='".$_POST['nom_map']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "UPDATE `".$config['prefix']."match_rapport_map` SET nom='', id_map='".$_POST['for']."' WHERE nom='".$_POST['nom_map']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}
	redirec_text('server_map.php', $langue['redirection_admin_map_serveur_edit'], 'admin');
}
if ( !empty($_POST['dell']) )
{
	// il faut rechercher le nom de la map pour remplacer dans les DB qui y font référence
	$sql = "SELECT `nom` FROM `".$config['prefix']."server_map` WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$get = $rsql->s_array($get);

	$sql = "UPDATE `".$config['prefix']."match_map` SET nom='".$get['nom']."', id_map='' WHERE id_map='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$sql = "UPDATE `".$config['prefix']."match_rapport_map` SET nom='".$get['nom']."', id_map='' WHERE id_map='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$sql = "DELETE FROM `".$config['prefix']."server_map` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('server_map.php', $langue['redirection_admin_map_serveur_dell'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_map_serveur.tpl'));
$template->assign_vars( array(
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_map_serveur'],
	'TITRE_GESTION' => $langue['titre_admin_map_serveur_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_map_serveur_list'],
	'ACTION' => $langue['action'],
	'TXT_NOM' => $langue['nom_map_sortie'],
	'TXT_URL' => $langue['url_map_custom'],
	'TXT_CONSOLE' => $langue['nom_map_console'],
));
if ( !empty($_POST['edit']) )
{
	$sql = "SELECT * FROM `".$config['prefix']."server_map` WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$get_edit_info = $rsql->s_array($get);
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	$template->assign_vars(array(
		'ID' => $get_edit_info['id'],
		'NOM' => $get_edit_info['nom'],
		'URL' => $get_edit_info['url'],
		'CONSOLE' => $get_edit_info['nom_console'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM `".$config['prefix']."server_map` ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste_map = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $liste_map['id'],
		'NOM' => $liste_map['nom'],
		'URL' => (empty($liste_map['url']))? $langue['liens_test_no_url'] : '<a href="'.$liste_map['url'].'" onclick="window.open(\''.$liste_map['url'].'\');return false;">'.$langue['liens_test_url'].'</a>',
		'CONSOLE' => $liste_map['nom_console'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>