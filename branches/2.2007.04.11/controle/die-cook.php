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
clear_session();
SetCookie('auto_connect','',time()-12, $config['site_path']);
$_GET['where'] = (empty($_GET['where']))? '../service/index_pri.php' : $_GET['where'];
redirec_text($_GET['where'], $langue['deconect_login'], 'user');
?>