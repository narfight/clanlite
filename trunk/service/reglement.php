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
$action_membre = 'where_reglement';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template->set_filenames(array('body' => 'divers_text.tpl'));
if (empty($config['reglement']))
{
	$config['reglement'] = $langue['no_reglement'];
}
$template->assign_vars(array(
	'TITRE' => $langue['titre_reglement'],
	'TEXTE' => bbcode((empty($config['reglement']))? $langue['no_reglement'] : $config['reglement']),
));
$template->pparse('body');
require($root_path.'conf/frame.php'); 
?>
