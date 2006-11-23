<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_match';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'match_publique.tpl'));
$sql = "SELECT game.* FROM ".$config['prefix']."match AS game ORDER BY `date` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$template->assign_vars(array( 
	'TITRE_MATCH' => $langue['titre_match'],
	'CONTRE' => $langue['contre_qui'],
	'DATE' => $langue['date_defit'],
	'HEURE' => $langue['heure_defit'],
));
// on fais la boucle pour les matchs
while ($liste = $rsql->s_array($get)) 
{ 
	$template->assign_block_vars('match', array(
		'DATE' => date("j/n/Y", $liste['date']),
		'CLAN' => $liste['le_clan'],
		'INFO' => nl2br(bbcode($liste['info'])),
		'HEURE' => date("H:i", $liste['date']),
		'FOR' => $liste['id'],
	));
}
$template->pparse('body');
include($root_path."conf/frame.php");
?>