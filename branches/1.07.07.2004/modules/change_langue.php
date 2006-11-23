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
			$select = ($config['langue'] == $file)? 'selected="selected"' : '' ;
			$liste_langue .= '<option value="'.$file.'" '.$select.'>'.$file.'</option>'."\n";
		}
	}
	closedir($rep);
	if (!empty($liste_langue))
	{
		$template->assign_block_vars("modules_".$modules['place'], array( 
				'TITRE' => $modules['nom'],
				'IN' => '<form method="post" style="text-align: center;">'."\n".'<select name="change_langue_perso" id="change_langue_perso_module" size="'.$nombre_langue.'" onChange="this.form.submit();">'."\n".$liste_langue."\n".'</select>'."\n".'</form>'
		));
	}
}
?>