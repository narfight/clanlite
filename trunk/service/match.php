<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_match';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'match_publique.tpl'));
$sql = "SELECT * FROM ".$config['prefix']."match WHERE date > '".(time()-60*60*2) ."' ORDER BY `date` DESC";
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
$i=0;
while ($liste = $rsql->s_array($get)) 
{ 
	$i++;
	$template->assign_block_vars('match', array(
		'DATE' => date('j/n/Y', $liste['date']),
		'CLAN' => $liste['le_clan'],
		'INFO' => bbcode($liste['info']),
		'HEURE' => date('H:i', $liste['date']),
		'FOR' => $liste['id'],
	));
}
if ($i === 0)
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_futur_match']));
}
$template->pparse('body');
include($root_path.'conf/frame.php');
?>