<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = 'Les derniers matchs (Nuked Klan)';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	$tpl_filename = $template->make_filename('modules/last_match_nk.tpl');
	
	$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));
	
	// replace \ with \\ and then ' with \'.
	$tpl = str_replace('\\', '\\\\', $tpl);
	$tpl  = str_replace('\'', '\\\'', $tpl);
	
	// strip newlines.
	$tpl  = str_replace("\n", '', $tpl);
	// strip newlines.
	$sql = "SELECT * FROM `".$config['prefix']."match_rapport` ORDER BY `date` DESC LIMIT 5";
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend les résultats des anciens match')) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$in = '';
	while ($last_match = $rsql->s_array($get))
	{
		$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
		eval($tpl);
		$points = $last_match['score_nous']-$last_match['score_eux'];
		if ($points == 0)
		{
			$class = 'match_null';
		}
		elseif ($points > 0)
		{
			$class = 'match_win';
		}
		elseif ($points < 0)
		{
			$class = 'match_lost';
		}
		// Turn template blocks into PHP assignment statements for the values of $match..
		$block['last_match'] = str_replace('{CLASS}', $class, $block['last_match']);
		$block['last_match'] = str_replace('{CONTRE}', $last_match['contre'], $block['last_match']);
		$block['last_match'] = str_replace('{PT_NOUS}', $last_match['score_nous'], $block['last_match']);
		$in .= str_replace('{PT_MECHANT}', $last_match['score_eux'], $block['last_match']);
	}
	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => (!empty($in))? str_replace('{LISTE}', $in, $block['Table']) : $langue['no_match_joue']
	));
}
?>