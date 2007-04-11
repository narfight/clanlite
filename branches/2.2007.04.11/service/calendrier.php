<?php
/****************************************************************************
 *	Fichier		: calendrier.php											*
 *	Copyright	: (C) 2007 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
define('CL_AUTH', true);
$root_path = './../';
$action_membre = 'where_calendrier';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'calendrier.tpl'));
$jour=adodb_date('d', $config['current_time']+$session_cl['correction_heure']);
$annee=(empty($_GET['annee']))? adodb_date('Y', $config['current_time']+$session_cl['correction_heure']) : $_GET['annee'];
$mois=(isset($_GET['mois']))? $_GET['mois'] : adodb_date('n', $config['current_time']+$session_cl['correction_heure']);
$mk_time_date = adodb_mktime( 1, 1, 1, $mois, 1, $annee);
if ($mois > 12)
{
	$annee++;
	$mois=1;
}
elseif ($mois < 1)
{
	$annee=$annee-1;
	$mois=12;
}

switch($mois)
{
	case 1 :
		$name_mois = $langue['janvier'];
	break;
	case 2 :
		$name_mois = $langue['fevrier'];
	break;
	case 3 :
		$name_mois = $langue['mars'];
	break;
	case 4 :
		$name_mois = $langue['avril'];
	break;
	case 5 :
		$name_mois = $langue['mai'];
	break;
	case 6 :
		$name_mois = $langue['juin'];
	break;
	case 7 :
		$name_mois = $langue['juillet'];
	break;
	case 8 :
		$name_mois = $langue['aout'];
	break;
	case 9 :
		$name_mois = $langue['septembre'];
	break;
	case 10 :
		$name_mois = $langue['octobre'];
	break;
	case 11 :
		$name_mois = $langue['novembre'];
	break;
	case 12 :
		$name_mois = $langue['décembre'];
	break;
}
$template->assign_vars(array(
	'TITRE_CALENDRIER' => $langue['titre_calendrier'],
	'CURRENT_MOIS' => $name_mois,
	'CURRENT_ANNEE' => $annee,
	'PREV_MOIS' => session_in_url('calendrier.php?mois='.($mois-1).'&annee='.$annee),
	'NEXT_MOIS' => session_in_url('calendrier.php?mois='.($mois+1).'&annee='.$annee),
	'LUNDI' => $langue['lundi'],
	'MARDI' => $langue['mardi'],
	'MERCREDI' => $langue['mercredi'],
	'JEUDI' => $langue['jeudi'],
	'VENDREDI' => $langue['vendredi'],
	'SAMEDI' => $langue['samedi'],
	'DIMANCHE' => $langue['dimanche'],
));

// on va chercher les match, antrainement, anivairsaire des membres qu'on pourrait affichier dedans
//evenement
$sql = 'SELECT `date`, `text`, `cyclique` FROM `'.$config['prefix'].'calendrier`';
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$evenements_date = array();
while ($evenements = $rsql->s_array($get))
{
	if ($evenements['cyclique'] == 1)
	{
		if ($mois == adodb_date('n', $evenements['date']+$session_cl['correction_heure']))
		{
			$evenements_date[$match['id']] = array(
				'jours' => adodb_date('j', $evenements['date']+$session_cl['correction_heure']),
				'text' => $evenements['text']
			);
		}
	}
	else
	{
		if ($mois == adodb_date('n', $evenements['date']+$session_cl['correction_heure']) && $annee == adodb_date('Y', $evenements['date']+$session_cl['correction_heure']))
		{
			$evenements_date[$match['id']] = array(
				'jours' => adodb_date('j', $evenements['date']+$session_cl['correction_heure']),
				'text' => $evenements['text']
			);
		}
	}
}

//match
$sql = 'SELECT `id`, `date`, `le_clan`, `section` FROM `'.$config['prefix'].'match`';
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$match_date = array();
while ($match = $rsql->s_array($get))
{
	if ($mois == adodb_date('n', $match['date']+$session_cl['correction_heure']) && $annee == adodb_date('Y', $match['date']+$session_cl['correction_heure']))
	{
		$match_date[$match['id']] = array(
			'jours' => adodb_date('j', $match['date']+$session_cl['correction_heure']),
			'clan' => $match['le_clan'],
			'section' => $match['section']
		);
	}
}

//entrainement
$sql = 'SELECT `id`, `date` FROM `'.$config['prefix'].'entrainement`';
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$entrai_date = array();
while ($entrai = $rsql->s_array($get))
{
	if ($mois == adodb_date('n', $entrai['date']) && $annee == adodb_date('Y', $entrai['date']+$session_cl['correction_heure']))
	{
		$entrai_date[$entrai['id']] = array('jours' => adodb_date('j', $entrai['date']+$session_cl['correction_heure']));
	}
}

//annif et annif d'entrée
$sql = 'SELECT `id`, `age`, `user`, `user_date` FROM `'.$config['prefix'].'user`';
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$annif_date = array();
$annif_entree_date = array();
while ($annif = $rsql->s_array($get))
{
	if ($mois == adodb_date('n', $annif['age']+$session_cl['correction_heure']))
	{
		$annif_date[$annif['id']] = array(
			'jours' => adodb_date('j', $annif['age']+$session_cl['correction_heure']),
			'user' => $annif['user'],
			'id_user' => $annif['id']
		);
	}
	if (isset($annif_entree['user_date']) && $mois == adodb_date('n', $annif_entree['user_date']+$session_cl['correction_heure']))
	{
		$annif_entree_date[$annif_entree['id']] = array(
			'jours' => adodb_date('j', $annif_entree['user_date']+$session_cl['correction_heure']),
			'user' => $annif_entree['user'],
			'id_user' => $annif_entree['id']
		);
	}
}

// Ces variables vont nous servir pour mettre les jours dans les bonnes colonnes    
$jour_debut_mois = (adodb_date('w', $mk_time_date) == 0)? 7 : adodb_date('w', $mk_time_date)-1; //lundi = 1 Samedi = 6 et Dimanche = 7
$horizontal = ($jour_debut_mois == 7)? 0 : 1;
$verticale = 1;
//boucle pour les 28 a 31 jours du mois
for ($i=0;$i<adodb_date('t', $mk_time_date)+$jour_debut_mois;$i++)
{
	$to_days = $i-$jour_debut_mois+1;
	// on regarde si il a rien a metre dans la case comme info
	$case[$horizontal][$verticale]['info'] = '';
	foreach($match_date as $id => $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			// si il est membre et qu'il peut participer a ce match, on lui fait un liens pour les détails
			if (isset($session_cl['user']) && ($session_cl['limite_match'] == 0 || $info_tmp['section'] = $session_cl['section'] || $info_tmp['section'] = 0))
			{
				$case[$horizontal][$verticale]['info'] .= '<li><a href="'.session_in_url($root_path.'service/membre_match.php?regarder='.$id).'">'.sprintf($langue['calendrier_match'], $info_tmp['clan']).'</a></li>';
			}
			else
			{
				$case[$horizontal][$verticale]['info'] .= '<li>'.sprintf($langue['calendrier_match'], $info_tmp['clan']).'</li>';
			}
		}
	}
	foreach ($entrai_date as $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= '<li>'.$langue['calendrier_entrai'].'</li>';
		}
	}
	foreach ($annif_date as $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= '<li>'.sprintf($langue['calendrier_annif'], $root_path, $info_tmp['id_user'], $info_tmp['user']).'</a></li>';
		}
	}
	foreach ($annif_entree_date as $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= '<li>'.sprintf($langue['calendrier_annif_date'], $root_path, $info_tmp['id_user'], $info_tmp['user']).'</a></li>';
		}
	}
	foreach ($evenements_date as $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= '<li>'.bbcode($info_tmp['text']).'</li>';
		}
	}

	$case[$horizontal][$verticale]['class'] = ($i<$jour_debut_mois)? 'calendra-vide' : 'calendra-normal';
	$case[$horizontal][$verticale]['class'] = ($horizontal >= 6)? 'calendra-wk' : $case[$horizontal][$verticale]['class'];
	$case[$horizontal][$verticale]['class'] = ($to_days == $jour && (adodb_date('m-Y', $config['current_time']+$session_cl['correction_heure']) == adodb_date('m-Y',$mk_time_date)))? 'calendra-today' : $case[$horizontal][$verticale]['class'];
	$case[$horizontal][$verticale]['num'] = ($i<$jour_debut_mois)? '&nbsp;' : $to_days;
	$horizontal++;
	if ($horizontal == 8)
	{
		$horizontal = 1;
		if ($case[$horizontal][$verticale]['num']+7 <= adodb_date('t', $mk_time_date))
		{
			$verticale++;
		}
	}
}
while($horizontal < 9 && $horizontal != 1)
{
	$case[$horizontal][$verticale]['info'] = '';
	$case[$horizontal][$verticale]['class'] = 'calendra-vide';
	$case[$horizontal][$verticale]['num'] = '&nbsp;';
	$horizontal++;
}
for ($i=1;$i<$verticale+1;$i++)
{
	$template->assign_block_vars('semaine', array(
		'CLASS_1' => $case[1][$i]['class'],
		'NUM_1' => $case[1][$i]['num'],
		'INFO_1' => $case[1][$i]['info'],
		'CLASS_2' => $case[2][$i]['class'],
		'NUM_2' => $case[2][$i]['num'],
		'INFO_2' => $case[2][$i]['info'],
		'CLASS_3' => $case[3][$i]['class'],
		'NUM_3' => $case[3][$i]['num'],
		'INFO_3' => $case[3][$i]['info'],
		'CLASS_4' => $case[4][$i]['class'],
		'NUM_4' => $case[4][$i]['num'],
		'INFO_4' => $case[4][$i]['info'],
		'CLASS_5' => $case[5][$i]['class'],
		'NUM_5' => $case[5][$i]['num'],
		'INFO_5' => $case[5][$i]['info'],
		'CLASS_6' => $case[6][$i]['class'],
		'NUM_6' => $case[6][$i]['num'],
		'INFO_6' => $case[6][$i]['info'],
		'CLASS_7' => $case[7][$i]['class'],
		'NUM_7' => $case[7][$i]['num'],
		'INFO_7' => $case[7][$i]['info'],
	));
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>