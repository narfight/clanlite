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
$niveau_secu = 18;
$action_membre= 'where_admin_news';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['ajouter']))
{
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."news` (info, date, user, titre) VALUES ('".$_POST['texte']."', '".$config['current_time']."', '".$session_cl['user']."', '".$_POST['titre']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text('news.php',$langue['redirection_admin_news_add'],'admin');
}
if (!empty($_POST['editer']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."news` SET info='".$_POST['texte']."', titre='".$_POST['titre']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('news.php',$langue['redirection_admin_news_edit'],'admin');
	}
}
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."news` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$sql = "DELETE FROM `".$config['prefix']."reaction_news` WHERE id_news ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text('news.php',$langue['redirection_admin_news_dell'],'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_news.tpl'));
liste_smilies_bbcode(true, '', 25);
$template->assign_vars(array( 
	'ICI' => session_in_url('news.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_news'],
	'TITRE_GESTION' => $langue['titre_admin_news_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_news_list'],
	'ACTION' => $langue['action'],
	'TXT_TITRE' => $langue['admin_news_titre'],
	'TXT_CORPS' => $langue['admin_news_corps'],
	'TXT_DATE' => $langue['date'],
	'TXT_POSTEUR' => $langue['posteur'],
));
if (!empty($_POST['edit']))
{
	$sql = "SELECT * FROM ".$config['prefix']."news WHERE id='".$_POST['for']."'";
	if (! ($get_info = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_news = $rsql->s_array($get_info);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars(array(
		'ID' => $edit_news['id'],
		'INFO' => $edit_news['info'],
		'TITRE_TITRE' => $edit_news['titre'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer'])); 
}
$sql = "SELECT id,date,info,titre,user FROM ".$config['prefix']."news ORDER BY `id` DESC";
if (! ($get_list =$rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( $liste_news = $rsql->s_array($get_list) )
{
	$template->assign_block_vars('liste', array( 
		'ID' => $liste_news['id'],
		'DATE' => adodb_date('j-n-y H:i', $liste_news['date']+$session_cl['correction_heure']),
		'INFO' => bbcode($liste_news['info']),
		'TITRE' => $liste_news['titre'],
		'POSTEUR' => $liste_news['user'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>