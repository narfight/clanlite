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
		$nom = 'Connection au site';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	if (empty($session_cl['user']))
	{
		$block = module_tpl('officiel_module.tpl');
		
		$block['connection'] = str_replace('{ICI}', session_in_url($root_path.'controle/entrer.php'), $block['connection']);
		$block['connection'] = str_replace('{LOGIN}', $langue['form_login'], $block['connection']);
		$block['connection'] = str_replace('{CODE}', $langue['form_psw'], $block['connection']);
		$block['connection'] = str_replace('{SAVE}', $langue['save_code_login'], $block['connection']);
		$block['connection'] = str_replace('{ENVOYER}', $langue['envoyer'], $block['connection']);
		$template->assign_block_vars('modules_'.$modules['place'],array(
			'TITRE' => $modules['nom'],
			'IN' => $block['connection']
		));
	}
}
?>