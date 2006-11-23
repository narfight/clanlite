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
		$nom = 'Les derniers matchs (Nuked Klan)';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}

	$block = module_tpl('last_match_nk.tpl');
	
	$sql = "SELECT * FROM `".$config['prefix']."match_rapport` ORDER BY `date` DESC LIMIT 5";
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend les résultats des anciens match')) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	$in = '';
	while ($last_match = $rsql->s_array($get))
	{
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

		$block['tmp'] = str_replace('{CLASS}', $class, $block['last_match']);
		$block['tmp'] = str_replace('{CONTRE}', $last_match['contre'], $block['tmp']);
		$block['tmp'] = str_replace('{PT_NOUS}', $last_match['score_nous'], $block['tmp']);
		$in .= str_replace('{PT_MECHANT}', $last_match['score_eux'], $block['tmp']);
	}
	$template->assign_block_vars('modules_'.$modules['place'], array(
		'TITRE' => $modules['nom'],
		'IN' => (!empty($in))? str_replace('{LISTE}', $in, $block['Table']) : $langue['no_match_joue']
	));
}
?>