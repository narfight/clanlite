<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_calendrier';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'calendrier.tpl'));
$jour=date("d");
$annee=(empty($_GET['annee']))? date("Y") : $_GET['annee'];
$mois=(isset($_GET['mois']))? $_GET['mois'] : date('n');
$mk_time_date = mktime( 1, 1, 1, $mois, 1, $annee);
if ( $mois > 12)
{
	$annee++;
	$mois=1;
}
if ( $mois < 1)
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
	'MOIS_MOINS' => $mois-1,
	'MOIS_PLUS' => $mois+1,
	'LUNDI' => $langue['lundi'],
	'MARDI' => $langue['mardi'],
	'MERCREDI' => $langue['mercredi'],
	'JEUDI' => $langue['jeudi'],
	'VENDREDI' => $langue['vendredi'],
	'SAMEDI' => $langue['samedi'],
	'DIMANCHE' => $langue['dimanche'],
));

// on va chercher les match, antrainement, anivairsaire des membres qu'on pourrait affichier dedans
//match
$sql = "SELECT id,date,le_clan FROM `".$config['prefix']."match`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$match_date = array();
while ($match = $rsql->s_array($get))
{
	if ($mois == date('n', $match['date']) && $annee == date('Y', $match['date']))
	{
		$match_date[$match['id']] = array(
			'jours' => date('j', $match['date']),
			'clan' => $match['le_clan']
		);
	}
}
//entrainement
$sql = "SELECT id,date FROM `".$config['prefix']."entrainement`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$entrai_date = array();
while ($entrai = $rsql->s_array($get))
{
	if ($mois == date('n', $entrai['date']) && $annee == date('Y', $entrai['date']))
	{
		$entrai_date[$entrai['id']] = array('jours' => date('j', $entrai['date']));
	}
}
//annif
$sql = "SELECT id,age,user FROM `".$config['prefix']."user`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$annif_date = array();
while ($annif = $rsql->s_array($get))
{
	if ($mois == date('n', $annif['age']))
	{
		$annif_date[$annif['id']] = array(
			'jours' => date('j', $annif['age']),
			'user' => $annif['user'],
			'id_user' => $annif['id']
		);
	}
}
// Ces variables vont nous servir pour mettre les jours dans les bonnes colonnes    
$jour_debut_mois = (date('w', $mk_time_date) == 0)? 7 : date('w', $mk_time_date)-1; //lundi = 1 Samedi = 6 et Dimanche = 0
$horizontal = 1;
$verticale = 1;
//boucle pour les 28 a 31 jours du mois
for ($i=0;$i<date('t', $mk_time_date)+$jour_debut_mois;$i++)
{
	$to_days = $i-$jour_debut_mois+1;
	// on regarde si il a rien a metre dans la case comme info
	$case[$horizontal][$verticale]['info'] = '';
	foreach($match_date as $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= "<li>".sprintf($langue['calendrier_match'], $info_tmp['clan'])."</li>";
		}
	}
	foreach ($entrai_date as $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= "<li>".$langue['calendrier_entrai']."</li>";
		}
	}
	foreach ($annif_date as $info_tmp)
	{
		if(($info_tmp['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= "<li>".sprintf($langue['calendrier_annif'], $root_path, $info_tmp['id_user'], $info_tmp['user'])."</a></li>";
		}
	}
	$case[$horizontal][$verticale]['class'] = ($i<$jour_debut_mois)? "calendra-vide" : "calendra-normal";
	$case[$horizontal][$verticale]['class'] = ($horizontal >= 6)? "calendra-wk" : $case[$horizontal][$verticale]['class'];
	$case[$horizontal][$verticale]['class'] = ($to_days == $jour && (date('m-Y',time()) == date('m-Y',$mk_time_date)))? "calendra-today" : $case[$horizontal][$verticale]['class'];
	$case[$horizontal][$verticale]['num'] = ($i<$jour_debut_mois)? "&nbsp;" : $to_days;
	$horizontal++;
	if ($horizontal == 8)
	{
		$horizontal = 1;
		if ($case[$horizontal][$verticale]['num']+7 <= date('t', $mk_time_date))
		{
			$verticale++;
		}
	}
}
while($horizontal < 9 && $horizontal != 1)
{
	$case[$horizontal][$verticale]['info'] = "";
	$case[$horizontal][$verticale]['class'] = "calendra-vide";
	$case[$horizontal][$verticale]['num'] = "&nbsp;";
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
include($root_path."conf/frame.php");
?>