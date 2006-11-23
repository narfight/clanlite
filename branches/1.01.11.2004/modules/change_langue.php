<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
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
				'IN' => '<form method="post" action="'.session_in_url($config['site_domain'].$_SERVER['PHP_SELF']).'" style="text-align: center;">'."\n".'<select name="change_langue_perso" id="change_langue_perso_module" size="'.$nombre_langue.'" onchange="this.form.submit();">'."\n".$liste_langue."\n".'</select>'."\n".'</form>'
		));
	}
}
?>