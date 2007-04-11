<?php
/****************************************************************************
 *	Fichier		: match.php													*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
define('CL_AUTH', true);
$root_path = './../';
$action_membre= 'where_admin_match';
$niveau_secu = 14;
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if ( !empty($_POST['Submit']) )
{
	$date = adodb_mktime( $_POST['heure_match'], $_POST['minute_match'] , 1 , $_POST['date2'] , $_POST['date1'] , $_POST['date3'])-$session_cl['correction_heure'];
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."match` (date, info , priver, le_clan, nombre_de_joueur, heure_msn, section, repertoire) VALUES ('".$date."', '".$_POST['infoe']."', '".$_POST['priver']."', '".$_POST['clan']."', '".$_POST['joueur']."', '".$_POST['heure_msn']."', '".$_POST['section']."', '".$_POST['class']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$id_match = $rsql->last_insert_id();
	//ajoute les maps
	if (isset($_POST['liste_map']) && is_array($_POST['liste_map']))
	{
		foreach ($_POST['liste_map'] as $id => $map)
		{
			if ($map != -1)
			{
				if (is_numeric($map))
				{
					$sql = "INSERT INTO `".$config['prefix']."match_map` (id_match , id_map) VALUES ('".$id_match."', '".$map."')";
				}
				else
				{
					$sql = "INSERT INTO `".$config['prefix']."match_map` (id_match , nom) VALUES ('".$id_match."', '".$map."')";
				}

				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
	redirec_text('match.php', $langue['redirection_admin_match_add'], 'admin');
}

if (!empty($_POST['del']))
{
	$sql = "DELETE FROM `".$config['prefix']."match` WHERE id ='".$_POST['id_match']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE id_match ='".$_POST['id_match']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$sql = "DELETE FROM `".$config['prefix']."match_map` WHERE id_match ='".$_POST['id_match']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('match.php', $langue['redirection_admin_match_dell'], 'admin');
}

if (!empty($_POST['edit_save']))
{
	$date = adodb_mktime( $_POST['heure_match'], $_POST['minute_match'] , 1 , $_POST['date2'] , $_POST['date1'] , $_POST['date3'])-$session_cl['correction_heure'];
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."match` SET date='".$date."', info='".$_POST['infoe']."', priver='".$_POST['priver']."', le_clan='".$_POST['clan']."', nombre_de_joueur='".$_POST['joueur']."', heure_msn='".$_POST['heure_msn']."', section='".$_POST['section']."', repertoire='".$_POST['class']."' WHERE id ='".$_POST['id_match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// gestion des maps, on supprime tout est on les réinsert
	$sql = "DELETE FROM `".$config['prefix']."match_map` WHERE id_match ='".$_POST['id_match']."'";
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
				$sql = "INSERT INTO `".$config['prefix']."match_map` (id_match , id_map) VALUES ('".$_POST['id_match']."', '".$map."')";
				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
	redirec_text('match.php#'.$_POST['id_match'], $langue['redirection_admin_match_edit'], 'admin');
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
$template->set_filenames( array('body' => 'admin_match.tpl'));
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
	'ICI' => session_in_url('match.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_match'],
	'TITRE_GESTION' => $langue['titre_admin_match_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_match_list'],
	'TXT_NBR_JOUEUR' => $langue['nbr_joueurs'],
	'TXT_DATE' => $langue['date_defit'],
	'TXT_HEURE' => $langue['heure_defit'],
	'TXT_HEURE_CHAT' => $langue['heure_chat'],
	'TXT_CONTRE' => $langue['contre_qui'],
	'TXT_MAP' => $langue['match_map_liste'],
	'TXT_ADD_MAP' => $langue['add_map_menu_liste'],
	'TXT_ADD_MAP_URL' => session_in_url($root_path.'administration/server_map.php'),
	'TXT_SECTION' => $langue['quelle_section'],
	'CHOISIR' => $langue['choisir'],
	'ALL_SECTION' => $langue['toutes_section'],
	'TXT_DETAILS' => $langue['détails'],
	'MSG_PRIVE' => $langue['message_cote_prive'],
	'VOIR' => $langue['détails'],
	'TXT_MATCH_CLASS' => $langue['match_class'],
	'OPTIONNEL' => $langue['optionnel'],
	'CHOISIR_CLASS' => $langue['match-last-class'],
	'ADD_TEAM_OK' => $langue['add_team_ok'],
	'ADD_TEAM_DEMANDE' => $langue['add_team_demande'],
	'ADD_TEAM_RESERVE' => $langue['add_team_reserve'],
	'TEAM_OK' => $langue['team_ok'],
	'TEAMS_RESERVE' => $langue['team_reserve'],
	'TEAM_DEMANDE' => $langue['team_demande'],
	'EDITER' => $langue['editer'],
	'SUPPRIMER' => $langue['supprimer'],
	'ID_MATCH' => isset($_POST['id_match'])? $_POST['id_match'] : '',
));
if (!empty($_POST['Editer']) || (!empty($_POST['id_match']) && (isset($_POST['add_map']) || isset($_POST['dell_map']))))
{
	if (isset($_POST['add_map']) || isset($_POST['dell_map']))
	{//il modifie la liste des maps
		$template->assign_vars( array(
			'JOURS' => (isset($_POST['date1']))? $_POST['date1'] : '',
			'MOIS' => (isset($_POST['date2']))? $_POST['date2'] : '',
			'ANNEE' => (isset($_POST['date3']))? $_POST['date3'] : '',
			'TEAM_ADV' => (isset($_POST['clan']))? $_POST['clan'] : '',
			'HH' => (isset($_POST['heure_match']))? $_POST['heure_match'] : '',
			'MM' => (isset($_POST['minute_match']))? $_POST['minute_match'] : '',
			'HEURE_CHAT' => (isset($_POST['heure_msn']))? $_POST['heure_msn'] : '',
			'NOMBRE_J' => (isset($_POST['joueur']))? $_POST['joueur'] : '',
			'INFO' => (isset($_POST['infoe']))? $_POST['infoe'] : '',
			'PRIVER' => (isset($_POST['priver']))? $_POST['priver'] : '',
			'CLASS' => (isset($_POST['class']))? $_POST['class'] : '',
			'SELECTED_ALL' => (isset($_POST['section']) && $_POST['section'] == 0)? 'selected="selected"' : '',
		));
		//$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	}
	else
	{
		$sql = "SELECT date, le_clan, heure_msn, nombre_de_joueur, info, section, priver, repertoire FROM `".$config['prefix']."match` AS matche WHERE id ='".$_POST['id_match']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$info_match = $rsql->s_array($get);
		// on liste toutes les maps qui vont avec le match
		$sql = "SELECT liste.id_map, map.nom FROM `".$config['prefix']."match_map` AS liste LEFT JOIN `".$config['prefix']."server_map`AS map ON map.id = liste.id_map WHERE id_match ='".$_POST['id_match']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$nbr_map = 0;
		unset($_POST['liste_map']);
		while ($liste = $rsql->s_array($get))
		{
			$nbr_map++;
			$_POST['liste_map'][] = (!empty($liste['nom']))? $liste['id_map'] : $liste['nom'];
		}
		$template->assign_vars( array(
			'JOURS' => adodb_date('d', $info_match['date']+$session_cl['correction_heure']),
			'MOIS' => adodb_date('n', $info_match['date']+$session_cl['correction_heure']),
			'ANNEE' => adodb_date('Y', $info_match['date']+$session_cl['correction_heure']),
			'TEAM_ADV' => $info_match['le_clan'],
			'HH' => adodb_date('H', $info_match['date']+$session_cl['correction_heure']),
			'MM' => adodb_date('i', $info_match['date']+$session_cl['correction_heure']),
			'HEURE_CHAT' => $info_match['heure_msn'],
			'NOMBRE_J' => $info_match['nombre_de_joueur'],
			'INFO' => $info_match['info'],
			'PRIVER' => $info_match['priver'],
			'CLASS' => $info_match['repertoire'],
			'SELECTED_ALL' => ($info_match['section'] == 0)? 'selected="selected"' : '',
		));
	}
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
}
else
{
	$template->assign_vars(array(
		'JOURS' => (isset($_POST['date1']))? $_POST['date1'] : adodb_date('d', $config['current_time']+$session_cl['correction_heure']),
		'MOIS' => (isset($_POST['date2']))? $_POST['date2'] : adodb_date('n', $config['current_time']+$session_cl['correction_heure']),
		'ANNEE' => (isset($_POST['date3']))? $_POST['date3'] : adodb_date('Y', $config['current_time']+$session_cl['correction_heure']),
		'TEAM_ADV' => (isset($_POST['clan']))? $_POST['clan'] : '',
		'HH' => (isset($_POST['heure_match']))? $_POST['heure_match'] : adodb_date('H', $config['current_time']+$session_cl['correction_heure']),
		'MM' => (isset($_POST['minute_match']))? $_POST['minute_match'] : adodb_date('i', $config['current_time']+$session_cl['correction_heure']),
		'HEURE_CHAT' => (isset($_POST['heure_msn']))? $_POST['heure_msn'] : '',
		'NOMBRE_J' => (isset($_POST['joueur']))? $_POST['joueur'] : '',
		'INFO' => (isset($_POST['infoe']))? $_POST['infoe'] : '',
		'PRIVER' => (isset($_POST['priver']))? $_POST['priver'] : '',
		'CLASS' => (isset($_POST['class']))? $_POST['class'] : '',
		'SELECTED_ALL' => (isset($_POST['section']) && $_POST['section'] == 0)? 'selected="selected"' : '',
	));
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}

for($i=0;$i < $nbr_map-1;$i++)
{
	$template->assign_block_vars('liste_map', array(
		'ID' => $i,
		'VALEUR' => (isset($_POST['liste_map'][$i]))? $_POST['liste_map'][$i] : '',
	));
	if (isset($liste_map) && is_array($liste_map))
	{
		foreach($liste_map as $id => $nom)
		{
			$template->assign_block_vars('liste_map.map_select', array(
				'ID' => $id,
				'SELECTED' => (isset($_POST['liste_map'][$i]) && $_POST['liste_map'][$i] == $id)? 'selected="selected"' : '',
				'VALEUR' => $nom,
			));
		}
	}
}
$template->assign_block_vars('liste_map_last', array(
	'ID' => $i,
	'VALEUR' => (isset($_POST['liste_map'][$i]))? $_POST['liste_map'][$i] : '',
	'ADD' => $langue['add_map_liste'],
	'DELL' => $langue['dell_map_liste'],
));
if (isset($liste_map) && is_array($liste_map))
{
	foreach($liste_map as $id => $nom)
	{
		$template->assign_block_vars('liste_map_last.map_select', array(
			'ID' => $id,
			'SELECTED' => (isset($_POST['liste_map'][$i]) && $_POST['liste_map'][$i] == $id)? 'selected="selected"' : '',
			'VALEUR' => $nom,
		));
	}
}
// on regarde si il a une action a faire
if ( !empty($_POST['ok']) )
{
	$action = 'ok';
}
if ( !empty($_POST['demande']) )
{
	$action = 'demande';
}
if ( !empty($_POST['reserve']) )
{
	$action = 'reserve';
}
if ( !empty($action) )
{
	secu_level_test('9');
	$sql = "UPDATE `".$config['prefix']."match_inscription` SET statu='".$action."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
}
// on fais la liste des inscrits
$sql = "SELECT inscriptions.statu, inscriptions.id_match, inscriptions.id, user.user FROM `".$config['prefix']."match_inscription` AS inscriptions LEFT JOIN `".$config['prefix']."user` AS user ON inscriptions.user_id = user.id";
if (! ($get_joueur = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($list_user = $rsql->s_array($get_joueur)) )
{
	$liste_user_match[$list_user['id_match']][$list_user['statu']][$list_user['user']] = array('user' => $list_user['user'], 'id' => $list_user['id']);
}

unset($info_match);
$sql = "SELECT a.*, match_map.id_map, match_map.nom AS nom_map, server_map.nom AS nom_map_actu, section.nom FROM `".$config['prefix']."match` AS a LEFT JOIN `".$config['prefix']."match_map` AS match_map ON match_map.id_match = a.id LEFT JOIN `".$config['prefix']."server_map` AS server_map ON server_map.id = match_map.id_map LEFT JOIN `".$config['prefix']."section` section ON a.section = section.id ORDER BY repertoire, a.date ASC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}

while ( ($list_match = $rsql->s_array($get_match)) )
{
	if (!isset($info_match[$list_match['repertoire']][$list_match['id']]))
	{
		$info_match[$list_match['repertoire']][$list_match['id']] = array(
			'nombre_de_joueur' => $list_match['nombre_de_joueur'],
			'date' => $list_match['date'],
			'heure_msn' => $list_match['heure_msn'],
			'le_clan' => $list_match['le_clan'],
			'info' => $list_match['info'],
			'priver' => $list_match['priver'],
			'repertoire' => $list_match['repertoire'],
		);
	}
	// liste les maps
	if (empty($list_match['id_map']))
	{
		$info_match[$list_match['repertoire']][$list_match['id']]['map_list'][] = $list_match['nom_map'];
	}
	else
	{
		$info_match[$list_match['repertoire']][$list_match['id']]['map_list'][] = $list_match['nom_map_actu'];
	}
}

if (!empty($info_match) && is_array($info_match))
{
	foreach($info_match as $nom => $match)
	{
		// on fais la liste pour le menu déroulent
		$template->assign_block_vars('liste_class', array('VALEUR' => $nom));

		// on crée la class dans la liste des matchs en bas
		$template->assign_block_vars('class', array('TITRE' => $nom));
		foreach ($match as $id => $info)
		{
			$template->assign_block_vars('class.match', array(
				'FOR' => $id,
				'DATE' => adodb_date('j/n/Y', $info['date']+$session_cl['correction_heure']),
				'HEURE' => adodb_date('H:i', $info['date']+$session_cl['correction_heure']),
				'CLAN' => $info['le_clan'],
				'SECTION' => (empty($info['nom']))? $langue['toutes_section'] : $info['nom'],
				'INFO' => bbcode($info['info']),
				'PRIVER' =>  bbcode($info['priver']),
				'SUR' => $info['nombre_de_joueur'],
				'CHAT' => $info['heure_msn'],
				'CLASS' => $info['repertoire'],
				'NB_JOUEURS' => (!empty($liste_user_match[$id]['ok']))? count($liste_user_match[$id]['ok']) : 0,
				'ACTION_USER_MATCH' => (!empty($liste_user_match[$id]['ok']) && (count($liste_user_match[$id]['ok'][$session_cl['user']]) >= 1 || count($liste_user_match[$id]['reserve'][$session_cl['user']]) >= 1 || count($liste_user_match[$id]['demande'][$session_cl['user']]) >= 1))? 'moin' : 'add',

			));
			if (!empty($info['map_list']) && is_array($info['map_list']))
			{
				foreach($info['map_list'] as $info_map)
				{
					$template->assign_block_vars('class.match.map_list', array('NOM' => $info_map));
				}
			}
			if (!empty($liste_user_match[$id]) && is_array($liste_user_match[$id]))
			{
				foreach($liste_user_match[$id] as $etat_inscription => $non_inscription)
				{
					foreach($non_inscription as $non_inscri)
					{
						$template->assign_block_vars('class.match.'.$etat_inscription, array(
							'NOM' => $non_inscri['user'],
							'ID' => $non_inscri['id'],
						));
					}
				}
			}
		}
	}
}
else
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_futur_match']));
}

//Liste les sections
$sql = 'SELECT * FROM `'.$config['prefix'].'section`';
if (! ($get_section_liste = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_section = $rsql->s_array($get_section_liste)) )
{
	$template->assign_block_vars('section', array(
		'SELECTED' => ((!empty($info_match['section']) && $info_match['section'] == $liste_section['id']) || (!empty($_POST['section']) && $_POST['section'] == $liste_section['id']))? 'selected="selected"' : '',
		'ID' => $liste_section['id'],
		'NOM' => $liste_section['nom']
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>