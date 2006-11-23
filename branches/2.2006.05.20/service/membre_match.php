<?php
/****************************************************************************
 *	Fichier		: membre_match.php											*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$action_membre = 'where_match_prive';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['match']))
{
	// on vérifie qu'il est pas deja dans le match
	$sql = "SELECT COUNT(id) FROM `".$config['prefix']."match_inscription` WHERE user_id ='".$session_cl['id']."' AND id_match ='".$_POST['match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$verif_present = $rsql->s_array($get);
	if ($verif_present['COUNT(id)'] == 0)
	{
		$sql = "INSERT INTO `".$config['prefix']."match_inscription` (id_match, user_id, statu) VALUES ('".$_POST['match']."', '".$session_cl['id']."', 'demande')";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('membre_match.php', $langue['user_envois_demande_ok'], 'admin');
	}
	else
	{
		$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE `id_match` = '".$_POST['match']."' AND `user_id` = '".$session_cl['id']."'";
		if (! ($list = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('membre_match.php', $langue['user_envois_annule_demande'], 'admin');
	}
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'match_membre.tpl'));
$sql = "SELECT nom FROM ".$config['prefix']."section WHERE id ='".$session_cl['section']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$nom_section = $rsql->s_array($get);
$template->assign_vars(array( 
	'ICI' => session_in_url('membre_match.php'),
	'TITRE_MATCH' => $langue['titre_match'],
	'SECTION' => $nom_section['nom'],
	'CONTRE' => $langue['contre_qui'],
	'TXT_MAP' => $langue['match_map_liste'],
	'DATE' => $langue['date_defit'],
	'HEURE' => $langue['heure_defit'],
	'NBR_JOUEURS' => $langue['nbr_joueurs'],
	'HEURE_CHAT' => $langue['heure_chat'],
	'QUELLE_SECTION' => $langue['quelle_section'],
	'TEAM_OK' => $langue['team_ok'],
	'TEAM_RESERVE' => $langue['team_reserve'],
	'TEAM_DEMANDE' => $langue['team_demande'],
	'ADD_DELL_DEMANDE' => $langue['ajouter/supprimer_demande_match'],
	'VOIR' => $langue['détails'],
	'MSG_PRIVE' => $langue['message_cote_prive'],
	'TXT_MATCH_CLASS' => $langue['match_class'],
));
$sql = "SELECT inscriptions.statu, inscriptions.id_match, inscriptions.id, user.user FROM `".$config['prefix']."match_inscription` AS inscriptions LEFT JOIN `".$config['prefix']."user` AS user ON inscriptions.user_id = user.id";
if (! ($get_joueur = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($list_user = $rsql->s_array($get_joueur)) )
{
	$liste_user_match[$list_user['id_match']][$list_user['statu']][$list_user['user']] = $list_user['user'];
}
$sql = "SELECT a.*, server_map.url, match_map.id_map, match_map.nom AS nom_map, server_map.nom AS nom_map_actu, section.nom FROM `".$config['prefix']."match` AS a LEFT JOIN `".$config['prefix']."match_map` AS match_map ON match_map.id_match = a.id LEFT JOIN `".$config['prefix']."server_map` AS server_map ON server_map.id = match_map.id_map LEFT JOIN `".$config['prefix']."section` section ON a.section = section.id WHERE (a.section ='".$session_cl['section']."' OR a.section ='0' OR section.limite ='0') AND a.date > '".(time()-60*60*2) ."' ORDER BY repertoire, a.date ASC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}

$inscrit = false;
$pas_inscrit = false;

while ( ($list_match = $rsql->s_array($get_match)) )
{
	if (!isset($info_match[$list_match['id']]))
	{
		$info_match[$list_match['id']] = array(
			'nombre_de_joueur' => $list_match['nombre_de_joueur'],
			'date' => $list_match['date'],
			'le_clan' => $list_match['le_clan'],
			'info' => $list_match['info'],
			'priver' => $list_match['priver'],
			'nombre_de_joueur' => $list_match['nombre_de_joueur'],
			'heure_msn' => $list_match['heure_msn'],
			'nom' => $list_match['nom'],
			'repertoire' => $list_match['repertoire'],
		);
	}
	// liste les maps
	if (empty($list_match['id_map']))
	{
		$info_match[$list_match['id']]['map_list'][] = $list_match['nom_map'];
	}
	else
	{
		$info_match[$list_match['id']]['map_list'][] = array(
			'nom' => $list_match['nom_map_actu'],
			'url' => $list_match['url']
		);
	}
}

if (!empty($info_match) && is_array($info_match))
{
	foreach($info_match as $id => $info)
	{
		// on vérifie que la personne n'est pas déja inscris au match
		if (!empty($liste_user_match[$id]['ok'][$session_cl['user']]) || !empty($liste_user_match[$id]['demande'][$session_cl['user']]) || !empty($liste_user_match[$id]['reserve'][$session_cl['user']]))
		{
			$tpl_ou = 'match_inscrit';
			if (!$inscrit)
			{// on ajoute le titre si il n'est pas encore présent
				$template->assign_block_vars('titre_inscrit', array('TXT' => $langue['match_inscrit']));
				$inscrit = true;
			}
		}
		else
		{
			$tpl_ou = 'match_pas_inscrit';
			if (!$pas_inscrit)
			{// on ajoute le titre si il n'est pas encore présent
				$template->assign_block_vars('titre_pas_inscrit', array('TXT' => $langue['match_pas_inscrit']));
				$pas_inscrit = true;
			}
		}
		$template->assign_block_vars($tpl_ou, array( 
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
		));
		if (!empty($liste_user_match[$id]))
		{
			foreach($liste_user_match[$id] as $etat_inscription => $non_inscription)
			{
				foreach($non_inscription as $non_inscri)
				{
					$template->assign_block_vars($tpl_ou.'.'.$etat_inscription, array( 
						'NOM' => $non_inscri,
					));
				}
			}
		}
		if (!empty($info['map_list']) && is_array($info['map_list']))
		{
			foreach($info['map_list'] as $info_map)
			{
				if (is_array($info_map))
				{// il a pt un URL pour télécharger la map !!!
					if (!empty($info_map['url']))
					{
						$template->assign_block_vars($tpl_ou.'.map_list_url', array(
							'NOM' => $info_map['nom'],
							'URL' => $info_map['url']
						));
					}
					else
					{
						$template->assign_block_vars($tpl_ou.'.map_list', array('NOM' => $info_map['nom']));
					}
				}
				else
				{
					$template->assign_block_vars($tpl_ou.'.map_list', array('NOM' => $info_map));
				}
			}
		}
	}
}
else
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_futur_match']));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>