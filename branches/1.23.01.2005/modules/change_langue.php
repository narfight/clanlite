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
		$nom = "change de langue";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}

	$rep=opendir($root_path.'langues');
	$liste_langue = '';
	$nombre_langue = 0;
	while ($file = readdir($rep))
	{
		if (is_dir($root_path.'langues/'.$file) && $file != '..' && $file != '.' && $file != '')
		{
			$nombre_langue++;
			$liste_langue .= '<option value="'.$file.'" '.(($config['langue_actuelle'] == $file)? 'selected="selected"' : '').'>'.$file.'</option>'."\n";
		}
	}
	closedir($rep);
	if (!empty($liste_langue))
	{
		$template->assign_block_vars('modules_'.$modules['place'], array( 
				'TITRE' => $modules['nom'],
				'IN' => '<form method="post" action="'.session_in_url($config['site_domain'].$_SERVER['PHP_SELF']).'"><p>'."\n".'<select name="change_langue_perso" id="change_langue_perso_module" size="'.$nombre_langue.'">'."\n".$liste_langue."\n".'</select>'."\n".'<input name="Envoyer" type="submit" value="'.$langue['envoyer'].'" />'."\n".'</p></form>'
		));
	}
}
?>