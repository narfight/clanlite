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
$action_membre = 'where_liens';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'liens.tpl'));
$template->assign_vars(array( 
	'TITRE_LIENS' => $langue['titre_liens'],
));
$sql = "SELECT * FROM `".$config['prefix']."liens`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($info = $rsql->s_array($get))
{
	$template->assign_block_vars('liens', array( 
		'LIENS_L' => $info['nom_liens'],
		'LIENS_U' => $info['url_liens']
	));
	if (!empty($info['images']))
	{
		$template->assign_block_vars('liens.image', array('IMAGE' => $info['images']));
	}
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>