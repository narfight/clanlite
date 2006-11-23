<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = 'Prochain match';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	$tpl_filename = $template->make_filename('modules/officiel_module.tpl');
	
	$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));
	
	// replace \ with \\ and then ' with \'.
	$tpl = str_replace('\\', '\\\\', $tpl);
	$tpl  = str_replace('\'', '\\\'', $tpl);
	
	// strip newlines.
	$tpl  = str_replace("\n", '', $tpl);
	
	$sql = "SELECT a.*, section.nom  FROM `".$config['prefix']."match` a LEFT JOIN ".$config['prefix']."section section ON a.section = section.id WHERE a.date > '".(time()-60*60*2) ."' ORDER BY a.date ASC LIMIT 1";
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend le prochain match')) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	if ($match = $rsql->s_array($get)) 
	{
		if ( empty($match['nom']) )
		{
			$match['nom'] = $langue['toutes_section'];
		}
		// Turn template blocks into PHP assignment statements for the values of $match..
		$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
		eval($tpl);
		
		$block['match'] = str_replace('{TXT_DATE}', $langue['date_defit'], $block['match']);
		$block['match'] = str_replace('{DATE}', date('j/n/Y', $match['date']), $block['match']);
		$block['match'] = str_replace('{TXT_HEURE}', $langue['heure_defit'], $block['match']);
		$block['match'] = str_replace('{HEURE}', date('H:i', $match['date']), $block['match']);
		$block['match'] = str_replace('{SECTION}', $match['nom'], $block['match']);
		$block['match'] = str_replace('{CONTRE}', $match['le_clan'], $block['match']);
		$block['match'] = str_replace('{INFO}', bbcode($match['info']), $block['match']);
		$template->assign_block_vars('modules_'.$modules['place'],array(
			'TITRE' => $modules['nom'],
			'IN' => $block['match']
		));
	}
	else
	{
		$template->assign_block_vars('modules_'.$modules['place'],array(
			'TITRE' => $modules['nom'],
			'IN' => $langue['no_futur_match']
		));
	}
}
?>