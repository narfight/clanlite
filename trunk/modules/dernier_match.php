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
		$nom = 'Dernier match';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	$block = module_tpl('officiel_module.tpl');

	$sql = "SELECT * FROM ".$config['prefix']."match_rapport ORDER BY `date` DESC LIMIT 1";
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend les Résultats des anciens match')) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	if ($last_match = $rsql->s_array($get))
	{
		$block['last_match'] = str_replace('{TXT_DATE}', $langue['date_defit'], $block['last_match']);
		$block['last_match'] = str_replace('{DATE}', adodb_date("j/n/Y", $last_match['date']), $block['last_match']);
		$block['last_match'] = str_replace('{TXT_CONTRE}', $langue['contre_qui'], $block['last_match']);
		$block['last_match'] = str_replace('{CONTRE}', $last_match['contre'], $block['last_match']);
		$block['last_match'] = str_replace('{INFO_SHOW_INFO}', $langue['module_last_match_affiche_info'], $block['last_match']);
		$block['last_match'] = str_replace('{INFO}', nl2br(bbcode($last_match['info'])), $block['last_match']);
		$block['last_match'] = str_replace('{TXT_PT_NOUS}', $langue['score_nous'], $block['last_match']);
		$block['last_match'] = str_replace('{PT_NOUS}', $last_match['score_nous'], $block['last_match']);
		$block['last_match'] = str_replace('{TXT_PT_MECHANT}', $langue['score_eux'], $block['last_match']);
		$block['last_match'] = str_replace('{PT_MECHANT}', $last_match['score_eux'], $block['last_match']);
		$template->assign_block_vars("modules_".$modules['place'], array( 
			'TITRE' => $modules['nom'],
			'IN' => $block['last_match']
		));
	}
	else
	{
		$template->assign_block_vars('modules_'.$modules['place'], array( 
			'TITRE' => $modules['nom'],
			'IN' => $langue['no_match_joue']
		));
	}
}
?>