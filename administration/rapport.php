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
$niveau_secu = 19;
$action_membre= 'where_admin_rapport_match';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
// envoyer le formulaire rempli
if ( !empty($_POST['envoyer']) )
{ 
	if ( !empty($_POST['del_match']) )
	{
		// on enleve des listes des match
		$sql = "DELETE FROM `".$config['prefix']."match` WHERE id ='".$_POST['id_match_del']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		// on enleve les inscriptions pour le match
		$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE id_match ='".$_POST['id_match_del']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}
	$date = adodb_mktime( 1, 1, 1 ,$_POST['mm'] , $_POST['jj'] , $_POST['aaaa'] , 1 );
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."match_rapport` (`date`, `section`, `contre`, `info`, `score_nous`, `score_eux`) VALUES ('".$date."', '".$_POST['section']."', '".$_POST['clan']."', '".$_POST['information']."', '".$_POST['score_clan']."', '".$_POST['score_mechant']."')"; 
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('rapport.php', $langue['redirection_admin_rapport_match_add'], 'admin');
}
if ( !empty($_POST['supprimer']) )
{
	$sql = "DELETE FROM `".$config['prefix']."match_rapport` WHERE id ='".$_POST['id']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('rapport.php', $langue['redirection_admin_rapport_match_dell'], 'admin');
}
// envoyer le formulaire rempli pour editer
if ( !empty($_POST['edit']) )
{
	$_POST = pure_var($_POST);
	$date = adodb_mktime( 1 , 1 , 1 , $_POST['mm'] , $_POST['jj'] , $_POST['aaaa'] , 1 );
	$sql = "UPDATE `".$config['prefix']."match_rapport` SET `date`='".$date."', `section`='".$_POST['section']."', `contre`='".$_POST['clan']."', `info`='".$_POST['information']."', `score_nous`='".$_POST['score_clan']."', `score_eux`='".$_POST['score_mechant']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('rapport.php', $langue['redirection_admin_rapport_match_edit'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_rapport_match.tpl'));
liste_smilies(true, '', 25);
$template->assign_vars(array(
	'ICI' => session_in_url('rapport.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_rapport_match'],
	'TITRE_GESTION' => $langue['titre_admin_rapport_match_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_rapport_match_list'],
	'IMPORTATION' => $langue['rapport_match_importation'],
	'ACTION' => $langue['action'],
	'CHOISIR' => $langue['choisir'],
	'ENVOYER' => $langue['envoyer'],
	'DATE' => $langue['date'],
	'CONTRE' => $langue['contre_qui'],
	'DETAILS' => $langue['détails'],
	'SCORE' => $langue['rapport_match_score_final'],
	'SECTION' => $langue['section'],
	'DELL_IMPORTE' => $langue['rapport_match_dell_importe'],
	'ALL_SECTION' => $langue['toutes_section'],
));
// on fais la liste des match
$sql = "SELECT * FROM `".$config['prefix']."match`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_match = $rsql->s_array($get)) )
{
	$template->assign_block_vars('liste_match', array( 
		'ID_MATCH' => $liste_match['id'],
		'NOM_MATCH' => adodb_date('j/n/Y', $liste_match[1]).' -- '.$langue['contre_qui'].' '.$liste_match[3]
	));
}
if ( !empty($_POST['importation']) )
{
	// on prend les info du match a importer
	$sql = "SELECT * FROM `".$config['prefix']."match` WHERE id='".$_POST['importation']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$import_match = $rsql->s_array($get);
	$template->assign_vars(array(
		'ID' => $import_match['id'],
		'JJ' => adodb_date('j', $import_match['date']),
		'MM' => adodb_date('n', $import_match['date']),
		'AAAA' => adodb_date('Y', $import_match['date']),
		'CLAN' => $import_match['le_clan'],
		'INFO' => $import_match['info'],
		'SELECTED_ALL' => ($import_match['section'] == 0)? 'selected="selected"' : '',
	));
}
// trouve les info a editer
if ( !empty($_POST['editer']) )
{
	$sql = "SELECT * FROM ".$config['prefix']."match_rapport WHERE id ='".$_POST['id']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$info_rapport_edit = $rsql->s_array($get);
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	$template->assign_vars(array(
		'ID' => $info_rapport_edit['id'],
		'JJ' => adodb_date('j', $info_rapport_edit['date']),
		'MM' => adodb_date('n', $info_rapport_edit['date']),
		'AAAA' => adodb_date('Y', $info_rapport_edit['date']),
		'CLAN' => $info_rapport_edit['contre'],
		'INFO' => $info_rapport_edit['info'],
		'SCORE_NOUS' => $info_rapport_edit['score_nous'],
		'SCORE_MECHANT' => $info_rapport_edit['score_eux'],
		'SELECTED_ALL' => ($info_rapport_edit['section'] == 0)? 'selected="selected"' : '',
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT rapport.*, section.nom FROM ".$config['prefix']."match_rapport AS rapport LEFT JOIN ".$config['prefix']."section AS section ON rapport.section = section.id ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste_rapport = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $liste_rapport['id'],
		'DATE' => adodb_date('j/n/Y', $liste_rapport['date']),
		'SECTION' => (empty($liste_rapport['nom']))? $langue['toutes_section'] : $liste_rapport['nom'],
		'CLAN' => $liste_rapport['contre'],
		'INFO' => bbcode($liste_rapport['info']),
		'SCORE_NOUS' => $liste_rapport['score_nous'],
		'SCORE_MECHANT' => $liste_rapport['score_eux'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
// on fais la liste des sections
$sql = "SELECT * FROM ".$config['prefix']."section";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_section = $rsql->s_array($get)) )
{
	$template->assign_block_vars('section', array( 
		'ID' => $liste_section['id'],
		'NOM' => $liste_section['nom'],
		'SELECTED' => (( !empty($import_match['section']) && $import_match['section'] == $liste_section['id'] ) || ( !empty($info_rapport_edit['section']) && $info_rapport_edit['section'] == $liste_section['id'] ))? 'selected="selected"' : '',
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>