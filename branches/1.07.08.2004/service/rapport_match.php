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
$template->assign_vars(array( 
	'TITRE_MATCH_RAPPORT' => $langue['titre_match_rapport'],
	'CONTRE' => $langue['contre_qui'],
	'DATE' => $langue['date_defit'],
	'TXT_SECTION' => $langue['quelle_section'],
	'TXT_SCORE_NOUS' => $langue['score_nous'],
	'TXT_CONTRE' => $langue['contre_qui'],
	'TXT_SCORE_MECHANT' => $langue['score_eux'],
));
$resulte_match['egalitée'] = 0;
$resulte_match['gagné'] = 0;
$resulte_match['perdu'] = 0;
$resulte_match['total'] = 0;
$sql = "SELECT `score_nous`, `score_eux` FROM ".$config['prefix']."match_rapport";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($get_points = $rsql->s_array($get))
{
	$resulte_match['total']++;
	$points = $get_points['score_nous']-$get_points['score_eux'];
	if ($points == 0)
	{
		$resulte_match['egalitée']++;
	}
	elseif ($points > 0)
	{
		$resulte_match['gagné']++;
	}
	elseif ($points < 0)
	{
		$resulte_match['perdu']++;
	}
}
$_GET['limite'] = (empty($_GET['limite']))? 0 : $_GET['limite'];
$sql = "SELECT rapport.*, section.nom FROM ".$config['prefix']."match_rapport AS rapport LEFT JOIN ".$config['prefix']."section AS section ON rapport.section = section.id ORDER BY `date` DESC LIMIT ".$_GET['limite'].", ".$resulte_match['total'];
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
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
if ($resulte_match['total'] > 0)
{
	$rapport_pc = 100/$resulte_match['total'];
	$template->assign_block_vars('resume', array( 
		'TXT_MATCH_WIN' => $langue['resume_match_gagnee'],
		'MATCH_WIN' => $resulte_match['gagné'],
		'MATCH_WIN_PC' => round(($resulte_match['gagné']*$rapport_pc), 2),
		'TXT_MATCH_LOST' => $langue['resume_match_perdu'],
		'MATCH_LOST' => $resulte_match['perdu'],
		'MATCH_LOST_PC' => round(($resulte_match['perdu']*$rapport_pc), 2),
		'TXT_MATCH_NORM' => $langue['resume_match_norm'],
		'MATCH_NORM' => $resulte_match['egalitée'],
		'MATCH_NORM_PC' => round(($resulte_match['egalitée']*$rapport_pc), 2),
	));
	displayNextPreviousButtons($_GET['limite'], $resulte_match['total'], 'multi_page');
}
else
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_match_joue']));

}
$template->pparse('body');
include($root_path."conf/frame.php");
?>
