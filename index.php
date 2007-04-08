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
 ****************************************************************************
 *$Id$
 */
define('CL_AUTH', true);
$root_path = './';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'accueil.tpl'));
$sql = "SELECT COUNT(id) FROM `".$config['prefix']."config_sond` GROUP BY id";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$mp3 = $rsql->s_array($get);
if ($mp3['COUNT(id)'] > 0)
{
	$template->assign_vars(array(
		'ROOT_PATH' => $root_path,
		'SKIN' => $session_cl['skin'],
		'NOM_CLAN' => $config['nom_clan'],
		'NEWS' => $langue['news_titre'],
		'MP3' => session_in_url($root_path.'service/lecteur_mp3.php'),
		'INDEX' => session_in_url($root_path.'service/index_pri.php')
	));
}
else
{
	redirection($root_path.'service/index_pri.php');
}
$template->pparse('body');
?> 