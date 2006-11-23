<?php
/****************************************************************************
 *	Fichier		: rapport.php												*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$niveau_secu = 19;
$action_membre= 'where_admin_rapport_match';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');

function show_list_map($selected, $where, $nbr_map=false)
{
	global $langue, $template;

	// on prend la liste des maps
	$liste_map = scan_map('', 'tout');

	if(!$liste_map || !is_array($selected))
	{
		return false;
	}

	if ($nbr_map !== false)
	{
		$nbr = $nbr_map;
	}
	else
	{
		$nbr = count($selected);
	}

	for($i=0;$i < $nbr-1;$i++)
	{
		$template->assign_block_vars($where, array(
			'ID' => $i,
			'PT_EUX' => (isset($_POST['pt_eux'][$i]))? $_POST['pt_eux'][$i] : 0,
			'PT_NOUS' => (isset($_POST['pt_nous'][$i]))? $_POST['pt_nous'][$i] : 0,
		));
		foreach($liste_map as $id => $nfo_map)
		{
			$template->assign_block_vars($where.'.map_select', array(
				'ID' => $id,
				'SELECTED' => (isset($selected[$i]) && $selected[$i] == $id)? 'selected="selected"' : '',
				'VALEUR' => $nfo_map['nom'],
			));
		}
	}

	$template->assign_block_vars($where.'_last', array(
		'ID' => $i,
		'PT_EUX' => (isset($_POST['pt_eux'][$i]))? $_POST['pt_eux'][$i] : 0,
		'PT_NOUS' => (isset($_POST['pt_nous'][$i]))? $_POST['pt_nous'][$i] : 0,
		'ADD' => $langue['add_map_liste'],
		'DELL' => $langue['dell_map_liste'],
	));

	foreach($liste_map as $id => $nfo_map)
	{
		$template->assign_block_vars($where.'_last.map_select', array(
			'ID' => $id,
			'SELECTED' => (isset($selected[$i]) && $selected[$i] == $id)? 'selected="selected"' : '',
			'VALEUR' => $nfo_map['nom'],
		));
	}

	return true;
}

// envoyer le formulaire rempli
if ( !empty($_POST['envoyer']) )
{
	if (isset($_POST['del_match']))
	{
		// on enleve des listes des match
		$sql = "DELETE FROM `".$config['prefix']."match` WHERE id ='".$_POST['id_match_imp']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		// on enleve les inscriptions pour le match
		$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE id_match ='".$_POST['id_match_imp']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		// on enleve les maps pour le match
		$sql = "DELETE FROM `".$config['prefix']."match_map` WHERE id_match ='".$_POST['id_match_imp']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}

	$date = adodb_mktime( 1, 1, 1 ,$_POST['mm'] , $_POST['jj'] , $_POST['aaaa'] , 1 );
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."match_rapport` (`date`, `repertoire`, `section`, `contre`, `info`, `score_nous`, `score_eux`) VALUES ('".$date."', '".$_POST['class']."', '".$_POST['section']."', '".$_POST['clan']."', '".$_POST['information']."', '".$_POST['score_clan']."', '".$_POST['score_mechant']."')";

	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}

	$id_rapport = mysql_insert_id();

	// on ajoute la liste des maps
	if (isset($_POST['liste_map']) && is_array($_POST['liste_map']))
	{
		foreach ($_POST['liste_map'] as $id => $map)
		{
			if ($map != -1)
			{
				$sql = "INSERT INTO `".$config['prefix']."match_rapport_map` (id_rapport , id_map, pt_nous, pt_eux) VALUES ('".$id_rapport."', '".$map."', '".((isset($_POST['pt_nous'][$id]))? $_POST['pt_nous'][$id] : 0)."', '".((isset($_POST['pt_nous'][$id]))? $_POST['pt_eux'][$id] : 0)."')";
				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
	redirec_text('rapport.php', $langue['redirection_admin_rapport_match_add'], 'admin');
}

if ( !empty($_POST['supprimer']) )
{
	$sql = "DELETE FROM `".$config['prefix']."match_rapport` WHERE id ='".$_POST['id']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// gestion des maps, on supprime tout
	$sql = "DELETE FROM `".$config['prefix']."match_rapport_map` WHERE id_rapport ='".$_POST['id']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('rapport.php', $langue['redirection_admin_rapport_match_dell'], 'admin');
}

// envoyer le formulaire rempli pour editer
if ( !empty($_POST['edit']) )
{
	$_POST = pure_var($_POST);
	$date = adodb_mktime( 1 , 1 , 1 , $_POST['mm'] , $_POST['jj'] , $_POST['aaaa'] , 1 );
	$sql = "UPDATE `".$config['prefix']."match_rapport` SET `repertoire`='".$_POST['class']."', `date`='".$date."', `section`='".$_POST['section']."', `contre`='".$_POST['clan']."', `info`='".$_POST['information']."', `score_nous`='".$_POST['score_clan']."', `score_eux`='".$_POST['score_mechant']."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// gestion des maps, on supprime tout est on les réinsert
	$sql = "DELETE FROM `".$config['prefix']."match_rapport_map` WHERE id_rapport ='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	if (isset($_POST['liste_map']) && is_array($_POST['liste_map']))
	{
		foreach ($_POST['liste_map'] as $id => $map)
		{
			if ($map != -1)
			{
				$sql = "INSERT INTO `".$config['prefix']."match_rapport_map` (id_rapport , id_map, pt_nous, pt_eux) VALUES ('".$_POST['for']."', '".$map."', '".((isset($_POST['pt_nous'][$id]))? $_POST['pt_nous'][$id] : 0)."', '".((isset($_POST['pt_nous'][$id]))? $_POST['pt_eux'][$id] : 0)."')";
				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
	redirec_text('rapport.php', $langue['redirection_admin_rapport_match_edit'], 'admin');
}

$sql = "SELECT `id`, `nom` FROM `".$config['prefix']."server_map` ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($nfo = $rsql->s_array($get))
{
	$liste_map[$nfo['id']] = $nfo['nom'];
}

require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_rapport_match.tpl'));
liste_smilies_bbcode(true, '', 25);
// gestion des maps
//on vérifie que c'est un array, si non, on le crée mais vide
if (!isset($_POST['liste_map']) || !is_array($_POST['liste_map']))
{
	$_POST['liste_map'][] = '';
}
//on vérifie si il faut ajouter un champ
if ( isset($_POST['add_map']) )
{
	$nbr_map = count($_POST['liste_map'])+1;
}
elseif ( isset($_POST['dell_map']) )
{
	$nbr_map = count($_POST['liste_map'])-1;
}
else
{
	$nbr_map = count($_POST['liste_map']);
}

$template->assign_vars(array(
	'ICI' => session_in_url('rapport.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_rapport_match'],
	'TITRE_GESTION' => $langue['titre_admin_rapport_match_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_rapport_match_list'],
	'IMPORTATION' => $langue['rapport_match_importation'],
	'ACTION' => $langue['action'],
	'CHOISIR' => $langue['choisir'],
	'ENVOYER' => $langue['envoyer'],
	'DATE' => $langue['date'],
	'CONTRE' => $langue['contre_qui'],
	'DETAILS' => $langue['détails'],
	'SCORE' => $langue['rapport_match_score_final'],
	'SECTION' => $langue['section'],
	'DELL_IMPORTE' => $langue['rapport_match_dell_importe'],
	'ALL_SECTION' => $langue['toutes_section'],
	'TXT_MAP' => $langue['match_map_liste'],
	'PT_NOUS' => $langue['score_nous'],
	'PT_EUX' => $langue['score_eux'],
	'TXT_ADD_MAP' => $langue['add_map_menu_liste'],
	'TXT_ADD_MAP_URL' => session_in_url($root_path.'administration/server_map.php'),
	'TXT_MATCH_CLASS' => $langue['match_class'],
	'OPTIONNEL' => $langue['optionnel'],
	'CHOISIR_CLASS' => $langue['match-last-class'],
));

// on fais la liste des match
$sql = "SELECT * FROM `".$config['prefix']."match` ORDER BY `repertoire`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_match = $rsql->s_array($get)) )
{
	$match = array(
		'ID_MATCH' => $liste_match['id'],
		'NOM_MATCH' => adodb_date('j/n/Y', $liste_match['date']).' : '.$langue['contre_qui'].' '.$liste_match['le_clan'],
		'SELECTED' => (isset($_POST['importation']) && $_POST['importation'] == $liste_match['id'])? 'selected="selected"' : ''
	);

	if ($liste_match['repertoire'] == '')
	{// si il n'est pas dans un repertoire
		$template->assign_block_vars('liste_match', $match);
	}
	else
	{
		if (!isset($tmp[$liste_match['repertoire']]))
		{//on regarde si le repertoire est déja ouvert
			$tmp[$liste_match['repertoire']] = true;
			$template->assign_block_vars('group', array('TITRE' => $liste_match['repertoire']));
		}
		$template->assign_block_vars('group.liste_match', $match);
	}
}
unset($tmp);

if ( isset($_POST['Submit']) )
{
	// on prend les info du match a importer
	$tmp = true;
	$sql = "SELECT ".$config['prefix']."match.*, id_map, nom FROM `".$config['prefix']."match` LEFT JOIN `".$config['prefix']."match_map` AS map ON ".$config['prefix']."match.id = map.id_match WHERE ".$config['prefix']."match.id='".$_POST['importation']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ($import_match = $rsql->s_array($get))
	{
		$import_map[] = ($import_match['id_map'] != 0)? $import_match['id_map'] : $import_match['nom'];
		if ($tmp)
		{
			$tmp = false;
			//nous affichons quand même les infos des maps :p
			$_POST['id_match_imp'] = $import_match['id'];
			$template->assign_vars(array(
				'JJ' => adodb_date('j', $import_match['date']),
				'MM' => adodb_date('n', $import_match['date']),
				'AAAA' => adodb_date('Y', $import_match['date']),
				'CLAN' => $import_match['le_clan'],
				'INFO' => $import_match['info'],
				'CLASS' => $import_match['repertoire'],
				'SELECTED_ALL' => ($import_match['section'] == 0)? 'selected="selected"' : '',
				'ID_MATCH_IMP' => (isset($_POST['id_match_imp']))? $_POST['id_match_imp'] : '',
				'CHECKED' => (isset($_POST['del_match']))? 'checked="checked"' : '',
			));
		}
	}
	show_list_map($import_map, 'liste_map');
}
elseif (empty($_POST['Editer']))
{// affiche les maps SI il ne fait pas une importation ET pas une édition
	show_list_map($_POST['liste_map'], 'liste_map', $nbr_map);
}

// trouve les info a editer
if (!empty($_POST['Editer']) || (!isset($_POST['for']) && ((isset($_POST['add_map']) || isset($_POST['dell_map'])) ) ))
{
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	//il modifie la liste des maps
	if (isset($_POST['add_map']) || isset($_POST['dell_map']))
	{
		$template->assign_vars(array(
			'JJ' => (isset($_POST['jj']))? $_POST['jj'] : '',
			'MM' => (isset($_POST['mm']))? $_POST['mm'] : '',
			'AAAA' => (isset($_POST['aaaa']))? $_POST['aaaa'] : '',
			'CLAN' => (isset($_POST['clan']))? $_POST['clan'] : '',
			'INFO' => (isset($_POST['information']))? $_POST['information'] : '',
			'SCORE_NOUS' => (isset($_POST['score_clan']))? $_POST['score_clan'] : '',
			'SCORE_MECHANT' => (isset($_POST['score_mechant']))? $_POST['score_mechant'] : '',
			'SELECTED_ALL' => (isset($_POST['section']) && $_POST['section'] == 0)? 'selected="selected"' : '',
			'CHECKED' => (isset($_POST['del_match']))? 'checked="checked"' : '',
			'ID_MATCH_IMP' => (isset($_POST['id_match_imp']))? $_POST['id_match_imp'] : '',
			'CLASS' => (isset($_POST['class']))? $_POST['class'] : '',
			'ID' => (isset($_POST['for']))? $_POST['for'] : '',
		));
	}
	else
	{
		// on liste toutes les maps qui vont avec le match
		$sql = "SELECT liste.id_map, map.nom, pt_eux, pt_nous FROM `".$config['prefix']."match_rapport_map` AS liste LEFT JOIN `".$config['prefix']."server_map`AS map ON map.id = liste.id_map WHERE id_rapport ='".$_POST['id']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}

		//liste toutes les maps
		unset($_POST['liste_map'], $_POST['pt_eux'], $_POST['pt_nous']);
		while ($liste = $rsql->s_array($get))
		{
			$_POST['liste_map'][] = (!empty($liste['nom']))? $liste['id_map'] : $liste['nom'];
			$_POST['pt_eux'][] = $liste['pt_eux'];
			$_POST['pt_nous'][] = $liste['pt_nous'];
		}
		show_list_map((isset($_POST['liste_map']) && is_array($_POST['liste_map']))? $_POST['liste_map'] : array(''), 'liste_map');

		$sql = "SELECT * FROM ".$config['prefix']."match_rapport WHERE id ='".$_POST['id']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$info_rapport_edit = $rsql->s_array($get);
		$template->assign_vars(array(
			'ID' => $info_rapport_edit['id'],
			'JJ' => adodb_date('j', $info_rapport_edit['date']),
			'MM' => adodb_date('n', $info_rapport_edit['date']),
			'AAAA' => adodb_date('Y', $info_rapport_edit['date']),
			'CLAN' => $info_rapport_edit['contre'],
			'INFO' => $info_rapport_edit['info'],
			'CLASS' => $info_rapport_edit['repertoire'],
			'SCORE_NOUS' => $info_rapport_edit['score_nous'],
			'SCORE_MECHANT' => $info_rapport_edit['score_eux'],
			'SELECTED_ALL' => ($info_rapport_edit['section'] == 0)? 'selected="selected"' : '',
		));
	}
}
else
{
	if (!isset($_POST['Submit']))
	{
		$template->assign_vars(array(
			'JJ' => (isset($_POST['jj']))? $_POST['jj'] : '',
			'MM' => (isset($_POST['mm']))? $_POST['mm'] : '',
			'AAAA' => (isset($_POST['aaaa']))? $_POST['aaaa'] : '',
			'CLAN' => (isset($_POST['clan']))? $_POST['clan'] : '',
			'INFO' => (isset($_POST['information']))? $_POST['information'] : '',
			'SCORE_NOUS' => (isset($_POST['score_clan']))? $_POST['score_clan'] : '',
			'SCORE_MECHANT' => (isset($_POST['score_mechant']))? $_POST['score_mechant'] : '',
			'SELECTED_ALL' => (isset($_POST['section']) && $_POST['section'] == 0)? 'selected="selected"' : '',
			'CHECKED' => (isset($_POST['del_match']))? 'checked="checked"' : '',
			'ID_MATCH_IMP' => (isset($_POST['id_match_imp']))? $_POST['id_match_imp'] : '',
			'CLASS' => (isset($_POST['class']))? $_POST['class'] : '',
			'ID' => (isset($_POST['for']))? $_POST['for'] : '',
		));
	}
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}

// on liste tout les rapports
$sql = "SELECT rapport.*, section.nom FROM ".$config['prefix']."match_rapport AS rapport LEFT JOIN ".$config['prefix']."section AS section ON rapport.section = section.id ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste_rapport = $rsql->s_array($get))
{
	// on les stokes dans un Array trié par classification
	$liste_rapport_out[$liste_rapport['repertoire']][$liste_rapport['id']] =  array(
		'ID' => $liste_rapport['id'],
		'DATE' => adodb_date('j/n/Y', $liste_rapport['date']),
		'SECTION' => (empty($liste_rapport['nom']))? $langue['toutes_section'] : $liste_rapport['nom'],
		'CLAN' => $liste_rapport['contre'],
		'INFO' => bbcode($liste_rapport['info']),
		'SCORE_NOUS' => $liste_rapport['score_nous'],
		'SCORE_MECHANT' => $liste_rapport['score_eux'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	);
}
// On regarde si il a bien eu des rapports et on affiche
if (isset($liste_rapport_out) && is_array($liste_rapport_out))
{
	foreach ($liste_rapport_out as $class => $info)
	{
		$template->assign_block_vars('class', array( 'TITRE' => (empty($class))? $langue['match-sans-class'] : $class));
		foreach ($info as $rapport_out)
		{
			$template->assign_block_vars('class.liste', $rapport_out);
		}
	}
}

// on fais la liste des sections
$sql = 'SELECT * FROM '.$config['prefix'].'section';
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_section = $rsql->s_array($get)) )
{
	$template->assign_block_vars('section', array(
		'ID' => $liste_section['id'],
		'NOM' => $liste_section['nom'],
		'SELECTED' => (( !empty($import_match['section']) && $import_match['section'] == $liste_section['id'] ) || ( !empty($info_rapport_edit['section']) && $info_rapport_edit['section'] == $liste_section['id'] ))? 'selected="selected"' : '',
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>