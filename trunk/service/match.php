<?php
/****************************************************************************
 *	Fichier		: match.php													*
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
$action_membre= 'where_match';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'match_publique.tpl'));

$template->assign_vars(array( 
	'TITRE_MATCH' => $langue['titre_match'],
	'TXT_NBR_JOUEUR' => $langue['nbr_joueurs'],
	'TXT_DATE' => $langue['date_defit'],
	'TXT_HEURE' => $langue['heure_defit'],
	'TXT_CONTRE' => $langue['contre_qui'],
	'TXT_MAP' => $langue['match_map_liste'],
	'TXT_SECTION' => $langue['quelle_section'],
	'VOIR' => $langue['détails'],
));

$sql = "SELECT a.*, match_map.id_map, match_map.nom AS nom_map, server_map.nom AS nom_map_actu, server_map.nom_console FROM `".$config['prefix']."match` AS a LEFT JOIN `".$config['prefix']."match_map` AS match_map ON match_map.id_match = a.id LEFT JOIN `".$config['prefix']."server_map` AS server_map ON server_map.id = match_map.id_map ORDER BY repertoire, a.date ASC";
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
			'le_clan' => $list_match['le_clan'],
			'info' => $list_match['info'],
			'nombre_de_joueur' => $list_match['nombre_de_joueur'],
			'repertoire' => $list_match['repertoire'],
			'section' => $list_match['section'],
		);
	}
	// liste les maps
	if (empty($list_match['id_map']))
	{
		$info_match[$list_match['repertoire']][$list_match['id']]['map_list'][] = array(
			'nom' => $list_match['nom_map']
		);
	}
	else
	{
		$info_match[$list_match['repertoire']][$list_match['id']]['map_list'][] = array(
			'nom' => $list_match['nom_map_actu'],
			'console' => $list_match['nom_console']
		);
	}
}

$id_map = 0;
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
				'DATE' => adodb_date('j/n/Y', $info['date']+$session_cl['correction_heure']),
				'HEURE' => adodb_date('H:i', $info['date']+$session_cl['correction_heure']),
				'CLAN' => $info['le_clan'],
				'INFO' => bbcode($info['info']),
				'SUR' => $info['nombre_de_joueur'],
				'CLASS' => $info['repertoire'],
				'ID' => $id
			));
			// affiche les maps
			if (!empty($info['map_list']) && is_array($info['map_list']))
			{
				$liste_map = scandir($root_path.'images/pics_map/');

				foreach($info['map_list'] as $info_map)
				{
					// vérifie quel nom à analiser
					if (isset($info_map['console']))
					{
						$info_map = $info_map['console'];
					}
					else
					{
						$info_map = $info_map['nom'];
					}
					foreach($liste_map as $id => $valeur)
					{
						if (ereg($info_map.'.(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $valeur))
						{
							$img_map = $valeur;
							break;
						}
						$img_map = 'empty.jpg';
					}
					$taille_img_map = getimagesize($root_path.'images/pics_map/'.$img_map);
					$rapport = $taille_img_map[0]/80;
					$template->assign_block_vars('class.match.map_list', array(
						'NOM' => $info_map,
						'TAILLE_WIDTH' => floor($taille_img_map[0]/$rapport),
						'TAILLE_HEIGHT' => floor($taille_img_map[1]/$rapport),
						'SRC' => $root_path.'images/pics_map/'.$img_map,
						'ID' => $id_map,
					));
					$id_map++;
				}
			}
			// affiche le liens pour aller dans la partie membre s'inscrire
			if (isset($session_cl['section']) && ($session_cl['section'] == $info['section'] || $info['section'] == 0 || $session_cl['limite_match'] == 0))
			{
				$template->assign_block_vars('class.match.liens_membres', array(
					'URL' => $root_path.'service/membre_match.php?regarder='.$id,
					'TEXTE' => $langue['ajouter/supprimer_demande_match'],
				));
			}

		}
	}
}
else
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_futur_match']));
}

$template->pparse('body');
require($root_path.'conf/frame.php');
?>