<?php
/****************************************************************************
 *	Fichier		: entrainements.php											*
 *	Copyright	: (C) 2005 ClanLite											*
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
		$nom = 'Prochain entrainement';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}

	$block = module_tpl('officiel_module.tpl');

	$sql = "SELECT id,date,info FROM ".$config['prefix']."entrainement ORDER BY `date` ASC LIMIT 1";
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend le prochain entrainement')) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
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
			$entrain['date'] = $entrain['date']+$session_cl['correction_heure'];
			$block['entrain'] = str_replace('{TXT_DATE}', $langue['date_entrai'], $block['entrain']);
			$block['entrain'] = str_replace('{DATE}', adodb_date('j/n/Y', $entrain['date']), $block['entrain']);
			$block['entrain'] = str_replace('{TXT_HEURE}', $langue['heure_entrai'], $block['entrain']);
			$block['entrain'] = str_replace('{HEURE}', adodb_date('H:i', $entrain['date']), $block['entrain']);
			$block['entrain'] = str_replace('{TXT_INFO}', $langue['info_entrai'], $block['entrain']);
			$block['entrain'] = str_replace('{INFO}', bbcode($entrain['info']), $block['entrain']);
			$template->assign_block_vars('modules_'.$modules['place'], array( 
				'TITRE' => $modules['nom'],
				'IN' => $block['entrain']
			));
		}
	}
}
?>