<?php
/****************************************************************************
 *	Fichier		: calendrier.ph												*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$niveau_secu = 25;
$action_membre= 'where_calendrier';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if ( !empty($_POST['Envoyer']) )
{
	$_POST = pure_var($_POST);
	$_POST['cyclique'] = (isset($_POST['cyclique']))? 1 : 0;
	$date = adodb_mktime( $_POST['heure'], $_POST['minute'] , 1 , $_POST['mois'] , $_POST['jour'] , $_POST['annee'])-$session_cl['correction_heure'];
	$sql= "INSERT INTO `".$config['prefix']."calendrier` (text, date, cyclique) VALUES ('".$_POST['text']."', '".$date."', '".$_POST['cyclique']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text('calendrier.php', $langue['redirection_calendrier_add'],'admin');
}
if ( !empty($_POST['Editer']) )
{
	$_POST = pure_var($_POST);
	$_POST['cyclique'] = (isset($_POST['cyclique']))? 1 : 0;
	$date = adodb_mktime( $_POST['heure'], $_POST['minute'] , 1 , $_POST['mois'] , $_POST['jour'] , $_POST['annee'])-$session_cl['correction_heure'];
	$sql = "UPDATE `".$config['prefix']."calendrier` SET text='".$_POST['text']."', date='".$date."', cyclique='".$_POST['cyclique']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('calendrier.php', $langue['redirection_calendrier_edit'],'admin');
	}
}
if ( !empty($_POST['dell']) )
{
	$sql = "DELETE FROM `".$config['prefix']."calendrier` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('calendrier.php', $langue['redirection_calendrier_dell'],'admin');
	}
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_calendrier.tpl'));
liste_smilies_bbcode(true, '', 25);
$template->assign_vars( array(
	'ICI' => session_in_url('calendrier.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_calendrier'],
	'TITRE_GESTION' => $langue['titre_calendrier_gestion'],
	'TITRE_LIST' => $langue['titre_calendrier_list'],
	'TXT_DATE' => $langue['date'],
	'TXT_HEURE' => $langue['heure'],
	'TXT_TEXT' => $langue['le_txt'],
	'TXT_CYCLIQUE' => $langue['cyclique_calendrier'],
	'TXT_CYCLIQUE_SORT' => $langue['cyclique_calendrier_sort'],
	'BT_ENVOYER' => $langue['envoyer'],
	'BT_EDITER' => $langue['editer'],
	'BT_DELL' => $langue['supprimer'],
	'DATE' => $langue['date'],
	'ACTION' => $langue['action'],
));

if ( !empty($_POST['edit']) )
{
	$template->assign_block_vars('editer', 'vide');
	$sql = "SELECT * FROM ".$config['prefix']."calendrier WHERE id='".$_POST['for']."'";
	if (! ($get_edit = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$calendrier_edit = $rsql->s_array($get_edit);
	$template->assign_vars( array(
		'ID' => $calendrier_edit['id'],
		'TEXT' => $calendrier_edit['text'],
		'MINUTE' => adodb_date('i', $calendrier_edit['date']+$session_cl['correction_heure']),
		'HEURE' => adodb_date('H', $calendrier_edit['date']+$session_cl['correction_heure']),
		'JOUR' => adodb_date('j', $calendrier_edit['date']+$session_cl['correction_heure']),
		'MOIS' => adodb_date('n', $calendrier_edit['date']+$session_cl['correction_heure']),
		'ANNEE' => adodb_date('Y', $calendrier_edit['date']+$session_cl['correction_heure']),
		'CYCLIQUE' => ($calendrier_edit['cyclique'] == 1) ? 'checked="checked"' : '',
	));
}
else
{
	$template->assign_block_vars('rajouter', 'vide');
}

$sql = "SELECT * FROM ".$config['prefix']."calendrier ORDER BY `date` ASC";
if (! ($get_list = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($list = $rsql->s_array($get_list))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $list['id'],
		'DATE' => ($list['date'] == -1)? $langue['opt_cycliquel_desactiver'] : adodb_date("j/n/Y H:i", $list['date']+$session_cl['correction_heure']),
		'TEXT' => bbcode($list['text']), 
		'CYCLIQUE' => ($list['cyclique'] == 1)? $langue['oui'] : $langue['non'], 
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>