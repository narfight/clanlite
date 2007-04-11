<?php
/****************************************************************************
 *	Fichier		: mp3player.php												*
 *	Copyright	: (C) 2007 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
 
define('CL_AUTH', true);
$root_path = '../';
$action_membre= 'where_xml_mp3';
require($root_path.'conf/conf-php.php');

$sql = 'SELECT `SRC`, `titre` FROM `'.$config['prefix'].'config_sond` ORDER BY `ordre` ASC';
if (! $get = $rsql->requete_sql($sql))
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($info[] = $rsql->s_array($get))

//mélanger la playliste à la demande
if ($config['mp3_shuffle'] == 1)
{
	shuffle($info);
}

header('Content-type: text/xml');

echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
echo '<sommaire autoStart="'.(($config['mp3_auto_start'] == 1)? 'yes' : 'no').'">'."\n";

foreach ($info as $mp3)
{
	echo '	<song title ="'.$mp3['titre'].'" path="'.$mp3['SRC'].'" />'."\n";
}

echo '</sommaire>';
?>