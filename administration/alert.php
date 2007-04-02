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
$niveau_secu = 1;
$action_membre= 'where_alert';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if ( !empty($_POST['Envoyer']) )
{
	$_POST = pure_var($_POST);
	$_POST['auto_del'] = (isset($_POST['auto_del']))? $_POST['auto_del'] : '';
	$date = adodb_mktime( $_POST['heure'], $_POST['minute'] , 1 , $_POST['mois'] , $_POST['jour'] , $_POST['annee'])-$session_cl['correction_heure'];
	$sql= "INSERT INTO `".$config['prefix']."alert` (info, date, auto_del) VALUES ('".$_POST['text']."', '".$date."', '".$_POST['auto_del']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text('alert.php',$langue['redirection_alert_add'],'admin');
}
if ( !empty($_POST['Editer']) )
{
	$_POST = pure_var($_POST);
	$_POST['auto_del'] = (isset($_POST['auto_del']))? $_POST['auto_del'] : '';
	$date = adodb_mktime( $_POST['heure'], $_POST['minute'] , 1 , $_POST['mois'] , $_POST['jour'] , $_POST['annee'])-$session_cl['correction_heure'];
	$sql = "UPDATE `".$config['prefix']."alert` SET info='".$_POST['text']."', date='".$date."', auto_del='".$_POST['auto_del']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('alert.php',$langue['redirection_alert_edit'],'admin');
	}
}
if ( !empty($_POST['dell']) )
{
	$sql = "DELETE FROM `".$config['prefix']."alert` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('alert.php',$langue['redirection_alert_dell'],'admin');
	}
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_alert.tpl'));
liste_smilies_bbcode(true, '', 25);
$template->assign_vars( array(
	'ICI' => session_in_url('alert.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_alert'],
	'TITRE_GESTION' => $langue['titre_alert_gestion'],
	'TITRE_LIST' => $langue['titre_alert_list'],
	'TXT_TEXT' => $langue['le_txt'],
	'TXT_DEL_DATE' => $langue['date_dell_alert'],
	'TXT_DEL_HEURE' => $langue['heure_dell_alert'],
	'TXT_AUTO_DEL' => $langue['opt_auto_dell_alert'],
	'BT_ENVOYER' => $langue['envoyer'],
	'BT_EDITER' => $langue['editer'],
	'BT_DELL' => $langue['supprimer'],
	'DATE' => $langue['date'],
	'ACTION' => $langue['action'],
));
if ( !empty($_POST['edit']) )
{
	$template->assign_block_vars('editer', 'vide');
	$sql = "SELECT * FROM ".$config['prefix']."alert WHERE id='".$_POST['for']."'";
	if (! ($get_edit = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$alert_edit = $rsql->s_array($get_edit);
	$template->assign_vars( array(
		'ID' => $alert_edit['id'],
		'TEXT' => $alert_edit['info'],
		'AUTO_DEL' => ( $alert_edit['auto_del'] == 'oui') ? 'checked="checked"' : '',
	));
	if ($alert_edit['date'] != -1)
	{
		$template->assign_vars( array(
			'MINUTE' => adodb_date('i', $alert_edit['date']+$session_cl['correction_heure']),
			'HEURE' => adodb_date('H', $alert_edit['date']+$session_cl['correction_heure']),
			'JOUR' => adodb_date('j', $alert_edit['date']+$session_cl['correction_heure']),
			'MOIS' => adodb_date('n', $alert_edit['date']+$session_cl['correction_heure']),
			'ANNEE' => adodb_date('Y', $alert_edit['date']+$session_cl['correction_heure']),
		));
	}
}
else
{
	$template->assign_block_vars('rajouter', 'vide');
}
$sql = "SELECT * FROM ".$config['prefix']."alert ORDER BY `date` ASC";
if (! ($get_list = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($list = $rsql->s_array($get_list))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $list['id'],
		'DATE' => ($list['date'] == -1)? $langue['opt_auto_dell_desactiver'] : adodb_date("j/n/Y H:i", $list['date']+$session_cl['correction_heure']),
		'TEXT' => bbcode($list['info']), 
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>