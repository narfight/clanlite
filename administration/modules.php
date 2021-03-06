<?php
/****************************************************************************
 *	Fichier		: modules.php												*
 *	Copyright	: (C) 2007 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
define('CL_AUTH', true);
$root_path = './../';
$niveau_secu = 16;
$action_membre = 'where_module';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['envoyer']))
{ 
	if (empty($_POST['module']))
	{
		redirec_text('modules.php', $langue['redirection_module_erreur'], 'admin');
	}
	$_POST = pure_var($_POST);
	$central = false;
	$get_nfo_module = 1;
	require($root_path.'modules/'.$_POST['module']);
	unset($get_nfo_module);
	$sql = "INSERT INTO `".$config['prefix']."modules` (nom, ordre, place, call_page, etat) VALUES ('".$_POST['nom']."', '".$_POST['num']."', '".(($central)? 'centre' : $_POST['position'])."', '".$_POST['module']."', '".$_POST['activation']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$module_installtion = 1;
	require($root_path.'modules/'.$_POST['module']);
	redirec_text('modules.php', $langue['redirection_module_add'], 'admin');
}
if (!empty($_POST['envois_edit']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."modules` SET nom='".$_POST['nom']."', ordre='".$_POST['num']."', place='".$_POST['position']."', etat='".(($_POST['activation'] != 0)? 1 : 0)."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('modules.php', $langue['redirection_module_edit'], 'admin');
}
if (!empty($_POST['Supprimer']))
{
	$sql = "DELETE FROM `".$config['prefix']."modules` WHERE id ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$module_deinstaller = 1;
	require($root_path.'modules/'.$_POST['call_page']);
	redirec_text('modules.php', $langue['redirection_module_dell'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_modules.tpl'));
if (!empty($_POST['Editer']))
{
	$sql = "SELECT * FROM ".$config['prefix']."modules WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_module = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_module['id'],
		'NOM' => $edit_module['nom'],
		'ORDRE' => $edit_module['ordre'],
		'ACTIVATION_OFF' => ( $edit_module['etat'] == 0)? 'checked="checked"' : '',
		'EDIT_MODULE' => 'disabled="disabled',
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}

$template->assign_block_vars('where', array(
	'SELECTED_GAUCHE' => ( isset($edit_module['place']) && $edit_module['place'] == 'gauche') ? 'selected="selected"' : '',
	'SELECTED_DROITE' => ( isset($edit_module['place']) && $edit_module['place'] == 'droite') ? 'selected="selected"' : '',
	'TXT_POSITION' => $langue['position_module'],
));

$template->assign_block_vars('header_posix_coter', '');
$template->assign_vars(array(
	'ICI' => session_in_url('modules.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_module'],
	'TITRE_GESTION' => $langue['titre_module_gestion'],
	'TITRE_LISTE' => $langue['titre_module_list'],
	'ACTION' => $langue['action'],
	'EDITER' => $langue['editer'],
	'TXT_ORDRE' => $langue['module_ordre'],
	'TXT_CHOISIR' => $langue['choisir'],
	'TXT_NOM' => $langue['nom_module'],
	'TXT_FICHIER' => $langue['fichier_module'],
	'TXT_DROITE' => $langue['module_droite'],
	'TXT_CENTRE' => $langue['module_centre'],
	'TXT_GAUCHE' => $langue['module_gauche'],
	'TXT_ETAT' => $langue['module_etat'],
	'TXT_ON' => $langue['module_on'],
	'TXT_OFF' => $langue['module_off'],	
	'ACTIVATION_ON' => (!empty($edit_module['etat']) && $edit_module['etat'] != 0 || empty($edit_module['etat']))? 'checked="checked"' : '',
));
$sql = "SELECT id, nom, ordre, call_page, etat, place FROM ".$config['prefix']."modules WHERE place != 'center' ORDER BY `ordre` ASC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	switch($liste['place'])
	{
		case 'gauche':
			$liste['place'] = 'liste_gauche';
		break;
		case 'droite':
			$liste['place'] = 'liste_droite';
		break;
		default:
			$liste['place'] = 'liste_gauche';
	}
	$template->assign_block_vars('header_posix_coter.'.$liste['place'], array(
		'ID' => $liste['id'],
		'NOM' => $liste['nom'],
		'NUM' => $liste['ordre'],
		'ETAT' => ($liste['etat'] == 0) ? $langue['module_off'] : $langue['module_on'],
		'CALL_PAGE' => $liste['call_page'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
// liste des modules
$get_nfo_module = 1;
$central = false;
foreach ($file = scandir('../modules') as $file)
{
	if(eregi('.php$', $file))
	{ 
		require($root_path.'modules/'.$file);
		if (!$central)
		{
			$select = ( !empty($edit_module['call_page']) && $file == $edit_module['call_page'] ) ? 'selected="selected"' : '';
			$template->assign_block_vars('liste_module', array(
				'VALEUR' => $file,
				'NOM' => ( !empty($nom) )? $nom : $file,
				'SELECTED' => $select
			));
		}
		unset($nom);
		$central = false;
	}
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>