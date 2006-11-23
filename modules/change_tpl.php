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
		$nom = 'Change de théme';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}

	$rep=opendir($root_path.'templates');
	$liste_tpl = '';
	$nombre_tpl = 0;
	while ($file = readdir($rep))
	{
		if (is_dir($root_path.'templates/'.$file) && $file != '..' && $file != '.' && $file != '' && $file != 'CVS' && $file != '.CVS')
		{
			$nombre_tpl++;
			$select = ($session_cl['skin'] == $file)? 'selected="selected"' : '' ;
			$liste_tpl .= '<option value="'.$file.'" '.$select.'>'.$file.'</option>'."\n";
		}
	}
	closedir($rep);
	if (!empty($liste_tpl))
	{
		$template->assign_block_vars('modules_'.$modules['place'], array( 
				'TITRE' => $modules['nom'],
				'IN' => '<form method="post" action="'.session_in_url($config['site_domain'].$_SERVER['REQUEST_URI']).'"><p>'."\n".'<select name="change_tpl_perso" id="change_tpl_perso_module" size="'.$nombre_tpl.'">'."\n".$liste_tpl."\n".'</select><br />'."\n".'<input name="Envoyer" type="submit" value="'.$langue['envoyer'].'" />'."\n".'</p></form>'
		));
	}
}
?>