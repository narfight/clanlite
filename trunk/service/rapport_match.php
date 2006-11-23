<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_match_rapport';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'rapport_match.tpl'));
$sql = "SELECT rapport.*, section.nom FROM ".$config['prefix']."match_rapport AS rapport LEFT JOIN ".$config['prefix']."section AS section ON rapport.section = section.id ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$template->assign_vars(array( 
	'TITRE_MATCH_RAPPORT' => $langue['titre_match_rapport'],
	'CONTRE' => $langue['contre_qui'],
	'DATE' => $langue['date_defit'],
	'TXT_SECTION' => $langue['quelle_section'],
	'TXT_SCORE_NOUS' => $langue['score_nous'],
	'TXT_CONTRE' => $langue['contre_qui'],
	'TXT_SCORE_MECHANT' => $langue['score_eux'],
));
while ($liste_rapport = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $liste_rapport['id'],
		'DATE' => date("j/n/Y", $liste_rapport['date']),
		'SECTION' => (empty($liste_rapport['nom']))? $langue['toutes_section'] : $liste_rapport['nom'],
		'INFO' => nl2br(bbcode($liste_rapport['info'])),
		'SCORE_NOUS' => $liste_rapport['score_nous'],
		'SCORE_MECHANT' => $liste_rapport['score_eux'],
		'CONTRE' => $liste_rapport['contre'],
	));
}
$template->pparse('body');
include($root_path."conf/frame.php");
?>
