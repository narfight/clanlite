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
// on inclus la conf
$action_membre = 'where_connecte';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'connecter.tpl'));

$template->assign_vars(array( 
	'TITRE_CONNECTE' => $langue['titre_connecte'],
	'NO_PROFIL' => $langue['no_profil'],
	'NOM_SEX' => $langue['nom/sex'],
	'ACTION' => $langue['action'],
	'PROFIL' => $langue['profil'],
	'IP' => $langue['ip'],
));
// création de la liste des connecter
$sql = "SELECT * FROM `".$config['prefix']."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(date) < ".($config['time_cook']*60);
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$nombre = 0;
while ($liste = $rsql->s_array($get))
{
	$nfo_session = unserialize($liste['stock']);
	$template->assign_block_vars('connecter', array( 
		'USER' => ( empty($nfo_session['user']) )? $langue['guest'] : $nfo_session['user'],
		'SEX' => ( !empty($nfo_session['sex']) && $nfo_session['sex'] == 'Femme' )? 'femme' : 'homme',
		'ACTION'  => $langue[$nfo_session['action_membre']]
	));
	if (!empty($nfo_session['id']))
	{
		$template->assign_block_vars('connecter.membre_connect', array(
			'ALT_PROFIL' => $langue['alt_profil'],
			'PROFIL_U' => session_in_url('profil.php?link='.$nfo_session['id'])
		));
	}
	else
	{
		$template->assign_block_vars('connecter.no_membre_connect', array( 'vide' => 'vide' ));
	}
	$nombre++;
	if ($session_cl['pouvoir_particulier'] == 'admin')
	{
		$template->assign_block_vars('connecter.admin', array('IP' => $nfo_session['ip']));
		// on limite cette parite a une fois
		if ($nombre == 1)
		{
			$template->assign_block_vars('IP', 'vide');
		}
	}
	unset($nfo_session);
} 
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
 ?>