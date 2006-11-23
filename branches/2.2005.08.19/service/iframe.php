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
$action_membre= 'where_iframe';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');

require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'iframe.tpl'));
// requette sql
$sql = "SELECT url, text FROM ".$config['prefix']."custom_menu WHERE id ='".$_GET['id']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$nombre_frame = 0;
if ( ($frame = $rsql->s_array($get)) ) 
{ 
	$template->assign_block_vars('frame',array('URL_IFRAME' => $frame[0]));
	$nombre_frame = $nombre_frame+1;
}
else
{
	msg('erreur', $langue['frame_erreur_id']);
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>