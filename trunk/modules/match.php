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
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = 'Prochain match';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		// sauvegarde une configuration d'origine
		$id_module = $rsql->last_insert_id();
		
		$sql = "UPDATE `".$config['prefix']."modules` SET config=1 WHERE id='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	
	$block = module_tpl('match.tpl');
	$sql = "SELECT a.*, section.nom, section.limite AS limite_match  FROM `".$config['prefix']."match` a LEFT JOIN ".$config['prefix']."section section ON a.section = section.id WHERE a.date > '".(time()-60*60*2) ."' ORDER BY a.date ASC LIMIT 1";
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend le prochain match')) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	if ($match = $rsql->s_array($get)) 
	{
		if ( empty($match['nom']) )
		{
			$match['nom'] = $langue['toutes_section'];
		}
		
		$block['match'] = str_replace('{TXT_DATE}', $langue['date_defit'], $block['match']);
		$block['match'] = str_replace('{DATE}', adodb_date('j/n/Y', $match['date']+$session_cl['correction_heure']), $block['match']);
		$block['match'] = str_replace('{TXT_HEURE}', $langue['heure_defit'], $block['match']);
		$block['match'] = str_replace('{HEURE}', adodb_date('H:i', $match['date']+$session_cl['correction_heure']), $block['match']);
		$block['match'] = str_replace('{SECTION}', $match['nom'], $block['match']);
		$block['match'] = str_replace('{CONTRE}', $match['le_clan'], $block['match']);
		$block['match'] = str_replace('{INFO}', bbcode($match['info']), $block['match']);
		// on regarde si la personne à droit au match
		if (isset($session_cl['section']) && ($session_cl['section'] == $match['section'] || $match['section'] == 0 || $session_cl['limite_match'] == 0))
		{
			$block['match_liens_membres'] = str_replace('{URL}', $root_path.'service/membre_match.php?regarder='.$match['id'], $block['match_liens_membres']);
			$block['match_liens_membres'] = str_replace('{TEXTE}', $langue['ajouter/supprimer_demande_match'], $block['match_liens_membres']);
			$block['match'] = str_replace('{LIENS_MEMBRES}', $block['match_liens_membres'], $block['match']);
		}
		else
		{
			$block['match'] = str_replace('{LIENS_MEMBRES}', '', $block['match']);
		}
		
		//affiche les maps si c'est demandé dans la config du module
		if ($modules['config'] == 1)
		{
			$liste = '';
			
			$liste_map = scandir($root_path.'images/pics_map/');
			
			$sql = 'SELECT map_match.nom AS match_nom, map_list.nom AS match_nom_in_db, map_list.nom_console AS match_nom_console_in_db FROM `'.$config['prefix'].'match_map` AS map_match LEFT JOIN `'.$config['prefix'].'server_map` AS map_list ON map_match.id_map = map_list.id WHERE map_match.id_match = '.$match['id'];
			if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend le prochain match')) )
			{
				sql_error($sql , $rsql->error, __LINE__, __FILE__);
			}
			while ($map_db = $rsql->s_array($get))
			{
				if (empty($map_db['match_nom']))
				{
					$nom_map_actu = $map_db['match_nom_in_db'];
					$nom_map_img = $map_db['match_nom_console_in_db'];
				}
				else
				{
					$nom_map_actu = $map_db['match_nom'];
					$nom_map_img = $map_db['match_nom'];
				}
				foreach($liste_map as $id => $valeur)
				{
					if (ereg($nom_map_img.'.(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $valeur))
					{
						$img_map = $valeur;
						break;
					}
					$img_map = 'empty.jpg';
				}
				$taille_img_map = getimagesize($root_path.'images/pics_map/'.$img_map);

				// on génére la liste des maps pour le javascript
				$liste .= str_replace('{TITRE}', $nom_map_actu, $block['map_list']);
				$liste = str_replace('{NORM}', $root_path.'images/pics_map/'.$img_map, $liste);
				$liste = str_replace('{NORM_H}', $taille_img_map[1], $liste);
				$liste = str_replace('{NORM_L}', $taille_img_map[0], $liste);
			}

			// on injecte la liste dans le JS
			$block['match_map'] = str_replace('{MAP_SRC}', $root_path.'images/pics_map/'.$valeur, $block['match_map']);
			$block['match_map'] = str_replace('{MAP_LIST}', $liste, $block['match_map']);
			
			// on l'injecte dans l'enssemble
			$block['match'] = str_replace('{MAP}', $block['match_map'], $block['match']);
			$block['match'] = str_replace('{ID_MODULE}', $modules['id'], $block['match']);

		}
		$template->assign_block_vars('modules_'.$modules['place'],array(
			'TITRE' => $modules['nom'],
			'IN' => $block['match']
		));
	}
	else
	{
		$template->assign_block_vars('modules_'.$modules['place'],array(
			'TITRE' => $modules['nom'],
			'IN' => $langue['no_futur_match']
		));
	}
}

//administration
if( (!empty($_GET['config_modul_admin']) || !empty($_POST['Submit_match_config'])) && (isset($_POST['id_module']) || isset($_GET['id_module'])))
{
	$id_module = (empty($_GET['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	define('CL_AUTH', true);
	$root_path = './../';
	$niveau_secu = 16;
	$action_membre= 'where_module_match';
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'controle/cook.php');

	if (!empty($_POST['Submit_match_config']))
	{
		$sql = "UPDATE `".$config['prefix']."modules` SET `config`='".((isset($_POST['show_map']))? 1 : 0)."' WHERE `id`='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'administration/modules.php', $langue['redirection_module_match_edit'], 'admin');
	}

	//lit la config du module
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$actu_data = $rsql->s_array($get);
	$actu_data = intval($actu_data['config']);

	require($root_path.'conf/frame_admin.php');
	$template = new Template(find_module_tpl('match.tpl', true));
	$template->set_filenames( array('body_module' => 'match.tpl'));
	$template->assign_block_vars('match_config', array(
		'ICI' => session_in_url('match.php'),
		'ID' => $id_module,
		'ID_MODULE' => $id_module,
		'TITRE' => $langue['titre_module_match'],
		'TXT_SHOW_MAP' => $langue['match_module_show_map'],
		'CHECK_SHOW_MAP' => ($actu_data == 1)? 'checked="checked"' : '',
		'EDITER' => $langue['editer'],
	));
	
	$template->pparse('body_module');
	require($root_path.'conf/frame_admin.php');
	return;
}
?>