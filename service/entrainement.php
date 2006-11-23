<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_entrainement';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path."controle/cook.php");
include($root_path."conf/frame_admin.php");
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'antrainement.tpl'));
$template->assign_vars(array( 
	'ENTRAINEMENT' => $langue['titre_entrainement'],
	'DATE' => $langue['date'],
	'MSG_PRIVE' => $langue['message_cote_prive'],
	'DETAILS' => $langue['détails'],
	'POSTEUR' => $langue['posteur'],
));
// on vérie que l'info est pas dépâseée
$sql = "SELECT * FROM ".$config['prefix']."entrainement ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($list_entrain = $rsql->s_array($get))
{ 
	if ($list_entrain['date'] <= $config['current_time'] )
	{
		$sql = "DELETE FROM ".$config['prefix']."entrainement WHERE id = ".$list_entrain['id'];
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		
	}
	else
	{
		$template->assign_block_vars('entrain', array( 
			'DATE' => date("H:i j/n/Y", $list_entrain['date']),
			'INFO' => bbcode($list_entrain['info']), 
			'CODE'  => $list_entrain['priver'],
			'POSTEUR' => $list_entrain['user'],
		));
	} 
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>