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
		$nom = 'Prochain match';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	
	$block = module_tpl('officiel_module.tpl');

	$sql = "SELECT a.*, section.nom  FROM `".$config['prefix']."match` a LEFT JOIN ".$config['prefix']."section section ON a.section = section.id WHERE a.date > '".(time()-60*60*2) ."' ORDER BY a.date ASC LIMIT 1";
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend le prochain match')) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	if ($match = $rsql->s_array($get)) 
	{
		if ( empty($match['nom']) )
		{
			$match['nom'] = $langue['toutes_section'];
		}
		
		$block['match'] = str_replace('{TXT_DATE}', $langue['date_defit'], $block['match']);
		$block['match'] = str_replace('{DATE}', adodb_date('j/n/Y', $match['date']+$session_cl['correction_heure']), $block['match']);
		$block['match'] = str_replace('{TXT_HEURE}', $langue['heure_defit'], $block['match']);
		$block['match'] = str_replace('{HEURE}', adodb_date('H:i', $match['date']+$session_cl['correction_heure']), $block['match']);
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