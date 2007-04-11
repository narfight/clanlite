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
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'lecteur_mp3.tpl'));
$template->assign_vars(array(
	'SKIN' => $session_cl['skin'],
	'PATH_ROOT' => $root_path
));
$template->pparse('body');
?>