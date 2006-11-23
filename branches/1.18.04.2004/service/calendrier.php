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
$template->assign_vars(array(
	'TITRE_CALENDRIER' => $langue['titre_calendrier'],
	'LUNDI' => $langue['lundi'],
	'MARDI' => $langue['mardi'],
	'MERCREDI' => $langue['mercredi'],
	'JEUDI' => $langue['jeudi'],
	'VENDREDI' => $langue['vendredi'],
	'SAMEDI' => $langue['samedi'],
	'DIMANCHE' => $langue['dimanche'],
));

$jour=date("d");
$mois=date("m");
$annee=date("y");

// on va chercher les match, antrainement, anivairsaire des membres qu'on pourrait affichier dedans
//match
$sql = "SELECT date,le_clan FROM `".$config['prefix']."match`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$match_date = "";
for ($i=0;($match = $rsql->s_array($get));$i++)
{
	if ($mois == date("m", $match['date']) && $annee == date("y", $match['date']))
	{
		$match_date[$i] = array(
			'jours' => date("j", $match['date']),
			'clan' => $match['le_clan']
		);
	}
	else
	{
		$i--;
	}
}
//entrainement
$sql = "SELECT date FROM `".$config['prefix']."entrainement`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$entrai_date = "";
for ($i=0;($entrai = $rsql->s_array($get));$i++)
{
	if ($mois == date("m", $entrai['date']) && $annee == date("y", $entrai['date']))
	{
		$entrai_date[$i] = array('jours' => date("j", $entrai['date']));
	}
	else
	{
		$i--;
	}
}
//annif
$sql = "SELECT age,user,id FROM `".$config['prefix']."user`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$annif_date ="";
for ($i=0;($annif = $rsql->s_array($get));$i++)
{
	if ($mois == date("m", $annif['age']))
	{
		$annif_date[$i] = array(
			'jours' => date("j", $annif['age']),
			'user' => $annif['user'],
			'id_user' => $annif['id']
		);
	}
	else
	{
		$i--;
	}
}
// Ces variables vont nous servir pour mettre les jours dans les bonnes colonnes    
$jour_debut_mois=date("w",time()-$jour*24*3600); //lundi = 1 Samedi = 6 et Dimanche = 0
$jour_fin_mois=date("w",mktime(0,0,0,$mois,date('t'),$annee));
$horizontal = 1;
$verticale = 1;
//boucle pour les 28 a 31 jours du mois
for ($i=0;$i<date('t')+$jour_debut_mois;$i++)
{
	$to_days = $i-$jour_debut_mois+1;
	// on regarde si il a rien a metre dans la case comme info
	$case[$horizontal][$verticale]['info'] = "";
	for ($ia=0;(count($match_date)-1 >= $ia);$ia++)
	{
		if(($match_date[$ia]['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= "<li>".sprintf($langue['calendrier_match'], $match_date[$ia]['clan'])."</li>";
		}
	}
	for ($ia=0;(count($entrai_date)-1 >= $ia);$ia++)
	{
		if(($entrai_date[$ia]['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= "<li>".$langue['calendrier_entrai']."</li>";
		}
	}
	for ($ib=0;(count($annif_date)-1 >= $ib);$ib++)
	{
		if(($annif_date[$ib]['jours'] == $to_days) && $to_days > 0)
		{
			$case[$horizontal][$verticale]['info'] .= "<li>".sprintf($langue['calendrier_annif'], $root_path, $annif_date[$ib]['id_user'], $annif_date[$ib]['user'])."</a></li>";
		}
	}
	// change la couleur des case ou il a pas de chiffre dedans
	$case[$horizontal][$verticale]['class'] = ($i<$jour_debut_mois)? "calendra-vide" : "calendra-normal";
	// change la couleur pour le jours actuelle
	$case[$horizontal][$verticale]['class'] = ($horizontal >= 6)? "calendra-wk" : $case[$horizontal][$verticale]['class'];
	// change la couleur pour les wk
	$case[$horizontal][$verticale]['class'] = ($to_days == $jour)? "calendra-today" : $case[$horizontal][$verticale]['class'];
	$case[$horizontal][$verticale]['num'] = ($i<$jour_debut_mois)? "&nbsp;" : $to_days;
	$horizontal++;
	if ($horizontal == 8)
	{// on retourne a la 1er case de la ligne suivant si on est au bout des 7 cases
		$horizontal = 1;
		// v�rif si il faut faire une nouvelle ligne
		if ($case[$horizontal][$verticale]['num']+7 < date('t'))
		{
			$verticale++;
		}
	}
}
while($horizontal < 8 && $horizontal != 1)
{
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