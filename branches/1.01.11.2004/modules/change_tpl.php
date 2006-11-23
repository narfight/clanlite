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
	$nombre_tpl = 0;
	while ($file = readdir($rep))
	{
		if (is_dir($root_path.'templates/'.$file) && $file != '..' && $file != '.' && $file != '')
		{
			$nombre_tpl++;
			$select = ($config['skin'] == $file)? 'selected="selected"' : '' ;
			$liste_tpl .= '<option value="'.$file.'" '.$select.'>'.$file.'</option>'."\n";
		}
	}
	closedir($rep);
	if (!empty($liste_tpl))
	{
		$template->assign_block_vars('modules_'.$modules['place'], array( 
				'TITRE' => $modules['nom'],
				'IN' => '<form method="post" action="'.session_in_url($config['site_domain'].$_SERVER['PHP_SELF']).'" style="text-align: center;">'."\n".'<select name="change_tpl_perso" id="change_tpl_perso_module" size="'.$nombre_tpl.'" onchange="this.form.submit();">'."\n".$liste_tpl."\n".'</select>'."\n".'</form>'
		));
	}
}
?>