<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = "change de théme";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}

	$rep=opendir($root_path.'templates');
	$liste_tpl = '';
	while ($file = readdir($rep))
	{
		if (is_dir($root_path.'templates/'.$file) && $file != '..' && $file != '.' && $file != '')
		{
			$select = ($config['skin'] == $file)? 'selected="selected"' : '' ;
			$liste_tpl .= '<option value="'.$file.'" '.$select.'>'.$file.'</option>'."\n";
		}
	}
	closedir($rep);
	if (!empty($liste_tpl))
	{
		$template->assign_block_vars("modules_".$modules['place'], array( 
				'TITRE' => $modules['nom'],
				'IN' => '<form method="post">'."\n".'<select name="change_tpl_perso" id="change_tpl_perso_module" onChange="this.form.submit();">'."\n".$liste_tpl."\n".'</select>'."\n".'</form>'
		));
	}
}
?>