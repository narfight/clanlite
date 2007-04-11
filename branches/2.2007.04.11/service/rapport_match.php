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
define('CL_AUTH', true);
$root_path = './../';
$action_membre = 'where_match_rapport';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'rapport_match.tpl'));
$template->assign_vars(array( 
	'TITRE_MATCH_RAPPORT' => $langue['titre_match_rapport'],
	'CONTRE' => $langue['contre_qui'],
	'DATE' => $langue['date_defit'],
	'TXT_SECTION' => $langue['quelle_section'],
	'TXT_SCORE_NOUS' => $langue['score_nous'],
	'TXT_CONTRE' => $langue['contre_qui'],
	'TXT_SCORE_MECHANT' => $langue['score_eux'],
	'VOIR' => $langue['détails'],
));
$resulte_match['egalitée'] = 0;
$resulte_match['gagné'] = 0;
$resulte_match['perdu'] = 0;
$resulte_match['total'] = 0;
$sql = 'SELECT `score_nous`, `score_eux` FROM `'.$config['prefix'].'match_rapport`';
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
$_GET['limite'] = (empty($_GET['limite']) || !is_numeric($_GET['limite']))? 0 : $_GET['limite'];
$sql = "SELECT rapport.*, section.nom FROM `".$config['prefix']."match_rapport` AS rapport LEFT JOIN `".$config['prefix']."section` AS section ON rapport.section = section.id ORDER BY `date` DESC LIMIT ".$_GET['limite'].", ".$config['objet_par_page'];
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste_rapport = $rsql->s_array($get))
{
	$points = $liste_rapport['score_nous']-$liste_rapport['score_eux'];
	if ($points == 0)
	{
		$class = 'match_null';
	}
	elseif ($points > 0)
	{
		$class = 'match_win';
	}
	elseif ($points < 0)
	{
		$class = 'match_lost';
	}
	$date = adodb_date('j/n/Y', $liste_rapport['date']+$session_cl['correction_heure']);
	$template->assign_block_vars('liste', array( 
		'ID' => $liste_rapport['id'],
		'TITRE' => sprintf($langue['titre_liste_match_rapport'], $date,$liste_rapport['contre']),
		'DATE' => $date,
		'SECTION' => (empty($liste_rapport['nom']))? $langue['toutes_section'] : $liste_rapport['nom'],
		'INFO' => (empty($liste_rapport['info']))? '' : bbcode($liste_rapport['info']),
		'SCORE_NOUS' => $liste_rapport['score_nous'],
		'SCORE_MECHANT' => $liste_rapport['score_eux'],
		'CONTRE' => $liste_rapport['contre'],
		'CLASS' => $class
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
	displayNextPreviousButtons($_GET['limite'], $resulte_match['total'], 'multi_page', 'rapport_match.php');
}
else
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_match_joue']));
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>
