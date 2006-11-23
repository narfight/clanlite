<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = "Les compteurs";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	$sql = "SELECT COUNT(*) FROM `".$config['prefix']."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(date) < ".$config['time_cook'];
	if (! ($get_connecte = $rsql->requete_sql($sql, 'module', 'prend le nombre de session')) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$nombre_connecte = $rsql->s_array($get_connecte);
	$template->assign_block_vars("modules_".$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => sprintf($langue['module_compteur'], $config['compteur'], $nombre_connecte['COUNT(*)'])
	));
}
?>