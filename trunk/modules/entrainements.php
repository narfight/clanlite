<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = "prochain entrainement";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	$tpl_filename = $template->make_filename('modules/officiel_module.tpl');
	//$tpl_filename = $template->make_filename('modules/bbcode.tpl');
	
	$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));
	
	// replace \ with \\ and then ' with \'.
	$tpl = str_replace('\\', '\\\\', $tpl);
	$tpl  = str_replace('\'', '\\\'', $tpl);
	
	// strip newlines.
	$tpl  = str_replace("\n", '', $tpl);
	
	// strip newlines.
	$sql = "SELECT id,date,info FROM ".$config['prefix']."entrainement ORDER BY `date` ASC LIMIT 1";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	// on purge ce qui est plus valable
	while($entrain = $rsql->s_array($get))
	{
		if ($entrain['date'] <= $config['current_time'] )
		{
			$sql = "DELETE FROM ".$config['prefix']."entrainement WHERE id = '".$entrain['id']."'";
			$rsql->requete_sql($sql, 'module', 'Supprime les entrainements dépassés');
		}
		else
		{
			// Turn template blocks into PHP assignment statements for the values of $match..
			$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
			eval($tpl);
			
			$block['entrain'] = str_replace('{TXT_DATE}', $langue['date_entrai'], $block['entrain']);
			$block['entrain'] = str_replace('{DATE}', date("j/n/Y", $entrain['date']), $block['entrain']);
			$block['entrain'] = str_replace('{TXT_HEURE}', $langue['heure_entrai'], $block['entrain']);
			$block['entrain'] = str_replace('{HEURE}', date("H:i", $entrain['date']), $block['entrain']);
			$block['entrain'] = str_replace('{TXT_INFO}', $langue['info_entrai'], $block['entrain']);
			$block['entrain'] = str_replace('{INFO}', nl2br(bbcode($entrain['info'])), $block['entrain']);
			$template->assign_block_vars("modules_".$modules['place'], array( 
				'TITRE' => $modules['nom'],
				'IN' => $block['entrain']
			));
		}
	}
}
?>