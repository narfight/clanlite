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
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = 'Block MP3';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	if (!empty($session_cl['id_mp3']))
	{
		$sql = "SELECT arstite, titre FROM `".$config['prefix']."config_sond` WHERE id = '".$session_cl['id_mp3']."'";
		if (! ($get = $rsql->requete_sql($sql, 'module', 'information sur le mp3 joué')) )
		{
			sql_error($sql , $rsql->error, __LINE__, __FILE__);
		}
		$block_mp3 = $rsql->s_array($get);
		$modules_in = sprintf($langue['module_mp3'], $block_mp3['arstite'], $block_mp3['titre']);
	}
	else
	{
		$modules_in = $langue['module_mp3_no_info'];
	}
	$template->assign_block_vars('modules_'.$modules['place'], array( 
			'TITRE' => $modules['nom'],
			'IN' => $modules_in
	));
}
?>