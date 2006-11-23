<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
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
		$tpl_filename = $template->make_filename('modules/officiel_module.tpl');
		
		$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));
		
		// replace \ with \\ and then ' with \'.
		$tpl = str_replace('\\', '\\\\', $tpl);
		$tpl  = str_replace('\'', '\\\'', $tpl);
		
		// strip newlines.
		$tpl  = str_replace("\n", '', $tpl);
		
		// Turn template blocks into PHP assignment statements for the values of $match..
		$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
		eval($tpl);
		
		$block['connection'] = str_replace('{ROOT_PATH}', $root_path, $block['connection']);
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