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
// on inclus la conf
$action_membre= 'where_membre_liste';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if ( !empty($_POST['del']) )
{
	secu_level_test('22');
	// supprime le membre
	$sql = "DELETE FROM ".$config['prefix']."user WHERE id ='".$_POST['id']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//supprime ces pouvoir
	$sql = "DELETE FROM ".$config['prefix']."pouvoir  WHERE user_id ='".$_POST['id']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//supprime ces inscription au match
	$sql = "DELETE FROM ".$config['prefix']."match_inscription WHERE user_id ='".$_POST['id']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//modifie le nombre de membre dans la base de donnée
	$config['nbr_membre']=$config['nbr_membre']-1;
	$sql = "UPDATE ".$config['prefix']."config SET conf_valeur='".$config['nbr_membre']."' WHERE conf_nom='nbr_membre'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('liste-des-membres.php', $langue['membre_dell'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'membre_liste.tpl'));
$template->assign_vars(array( 
	'ICI' => session_in_url('liste-des-membres.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE_LISTE_MEMBRES' => $langue['titre_liste_membres'],
	'NUM' => $langue['numero'],
	'NOM_SEX' => $langue['nom/sex'],
	'MSN' => $langue['msn'],
	'PROFIL' => $langue['profil'],
	'ALT_MSN' => $langue['alt_msn'],
	'ALT_PROFIL' => $langue['alt_profil'],
));
$sql = "SELECT sex,id,user,im,pouvoir FROM ".$config['prefix']."user ORDER BY id ASC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$nombre = 0;
while ($liste = $rsql->s_array($get))
{ 
	$nombre++;
	if ( ( $session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[8] == 'oui') && $nombre == 1)
	{
		$template->assign_block_vars('profil_tete', array('PROFIL' => $langue['profil']));
	}
	if ( ($session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[7] == 'oui') && $nombre == 1)
	{
		$template->assign_block_vars('medail_tete', array('MEDAILLES' => $langue['medailles']));
	}
	if ( ($session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[22] == 'oui') && $nombre == 1)
	{
		$template->assign_block_vars('del_tete', array('SUPPRIMER' => $langue['supprimer']));
	}
	if ($session_cl['pouvoir_particulier'] == 'admin' && $nombre == 1)
	{
		$template->assign_block_vars('admin_tete', array('POUVOIRS' => $langue['pouvoirs']));
	}
	$template->assign_block_vars('liste', array( 
		'NOMBRE' => $nombre,
		'ID' => $liste['id'],
		'SEX' => ($liste['sex'] == 'Femme')? 'femme' : 'homme',
		'USER' => $liste['user'],
		'MSN' => $liste['im'],
		'PROFIL_U' => session_in_url($root_path.'service/profil.php?link='.$liste['id']),
		'EDITER' => $langue['editer']
	));
	if ( $session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[8] == 'oui')
	{
		$template->assign_block_vars('liste.edit_profil', array(
			'ICI_EDIT' => session_in_url($root_path.'administration/editer-user.php')
		));
	}
	if ( $session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[7] == 'oui')
	{
		$template->assign_block_vars('liste.edit_medail', array(
			'ICI_MEDAIL' => session_in_url($root_path.'administration/editer-medail.php')
		));
	}
	if ( $session_cl['pouvoir_particulier'] == 'admin' || $user_pouvoir[7] == 'oui')
	{
		$template->assign_block_vars('liste.del', array(
			'vide' => 'vide'
		));
	}
	if ($session_cl['pouvoir_particulier'] == 'admin')
	{
		$template->assign_block_vars('liste.admin', array(
			'ICI_POUVOIR' => session_in_url($root_path.'administration/pouvoir.php'),
			'DISABLED' => ($liste['pouvoir'] == 'admin')? 'disabled="disabled"' : ''
		));
	}
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>