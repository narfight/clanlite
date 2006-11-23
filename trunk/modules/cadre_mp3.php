<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = "Block MP3";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	if (!empty($session_cl['id_mp3']))
	{
		$sql = "SELECT arstite, titre FROM `".$config['prefix']."config_sond` WHERE id = '".$session_cl['id_mp3']."'";
		if (! ($get = $rsql->requete_sql($sql, 'module', 'information sur le mp3 joué')) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		$block_mp3 = $rsql->s_array($get);
		$modules_in = sprintf($langue['module_mp3'], $block_mp3['arstite'], $block_mp3['titre']);
	}
	else
	{
		$modules_in = $langue['module_mp3_no_info'];
	}
	$template->assign_block_vars('modules_'.$modules['place'], array( 
			'TITRE' => $modules['nom'],
			'IN' => $modules_in
	));
}
?>