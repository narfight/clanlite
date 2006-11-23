<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_serveur_list';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path.'conf/frame.php');
require_once($root_path."service/gsquery/gsQuery.php");
$template->set_filenames(array('body' => 'liste_game_serveur.tpl'));
$_GET['limite'] = (empty($_GET['limite']) || !is_numeric($_GET['limite']))? 0 : $_GET['limite'];
$total = get_nbr_objet('game_server', '');
$template->assign_vars(array(
	'TITRE' => $langue['titre_serveur_list'],
	'TXT_IP' => $langue['ip'],
	'TXT_NAME' => $langue['nom_serveur_jeux'],
	'TXT_VERSION' => $langue['version_serveur_jeux'],
	'TXT_PLACE' => $langue['nbr_place_serveur_jeux'],
	'TXT_GAME_TYPE' => $langue['gametype_serveur_jeux'],
	'TXT_CURRENT_MAP' => $langue['map_serveur_jeux'],
	'TXT_PASSWORD' => $langue['password_serveur_jeux'],
	'LISTE_JOUEUR' => $langue['liste_joueur_serveur_jeux'],
	'NAME_JOUEUR' => $langue['name_serveur_jeux'],
	'TXT_OBJ_AXIS' => $langue['obj_axis_serveur_jeux'],
	'TXT_OBJ_ALLIER' => $langue['obj_allier_serveur_jeux'],
	'NAME_JOUEUR' => $langue['name_serveur_jeux'],
));

$nombre_serveur['clan'] = 0;
$nombre_serveur['autre'] = 0;

//on prend la config du serveur
$sql = 'SELECT `id`, `ip`, `port`, `protocol`, `clan` FROM `'.$config['prefix'].'game_server` ORDER BY `clan` DESC LIMIT '.$_GET['limite'].','.$config['objet_par_page'];
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($info = $rsql->s_array($get))
{
	// on scan et on stocke tout dans un Array
	if ( ($gameserver=queryServer($info['ip'], $info['port'], $info['protocol'])) )
	{
		// on enregistre combien de serveur dispo
		if ($info['clan'] == 1)
		{
			$nombre_serveur['clan']++;
		}
		else
		{
			$nombre_serveur['autre']++;
		}
		// on regarde si nous avons une image de la map en cour
		foreach(scandir($root_path.'images/pics_map/') as $id => $valeur)
		{
			if (ereg($gameserver['mapname'].'.(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $valeur))
			{
				$img_map = $valeur;
				$taille_img_map = getimagesize($root_path.'images/pics_map/'.$valeur);
				break;
			}
			$img_map = 'empty.jpg';
			$taille_img_map = getimagesize($root_path.'images/pics_map/empty.jpg');
		}
		switch($gameserver['password'])
		{
			case 0:
				$serveur_password = $langue['non'];
			break;
			case 1:
				$serveur_password = $langue['oui'];
			break;
			default:
				$serveur_password = $langue['inconnu'];
			break;
		}
		// on fait la liste des maps
		if (!empty($gameserver['maplist']) && is_array($gameserver['maplist']))
		{
			foreach ($gameserver['maplist'] as $num => $name)
			{ 
				if (!empty($name))
				{
					// on vérifie si nous avons des info sur la map dans la db
					$info_map = scan_map($name);
					$gameserver['maplist'][$num] = scan_map($name);
				}
			}
		}
		$liste_serveur[$info['id']] = array(
			'LINK' => session_in_url('serveur_game_list.php?details='.$info['id'].'&amp;limite='.$_GET['limite']),
			'CLAN' => $info['clan'],
			'IP' => $info['ip'],
			'JOINERURI' => $gameserver['JoinerURI'],
			'NAME' => $gameserver['servertitle'],
			'VERSION' => $gameserver['gameversion'],
			'PLACE' => $gameserver['maxplayers'],
			'PLAYER' => $gameserver['numplayers'],
			'PORT' => $gameserver['hostport'],
			'PICS_MAP' => $root_path.'images/pics_map/'.$img_map,
			'PICS_MAP_TAILLE' => $taille_img_map[3],
			'GAME_TYPE' => $gameserver['gametype'],
			'CURRENT_MAP_INFO' => scan_map($gameserver['mapname']),
			'CURRENT_MAP' => scan_map($gameserver['mapname'], 'nom'),
			'PASSWORD' => $serveur_password,
			'PROTOCOL' => $info['protocol'],
			'NEXT_MAP' => (!empty($gameserver['nextmap']))? scan_map($gameserver['nextmap'], 'nom'): '',
			'MIN_PING' => (!empty($gameserver['rules']['sv_minPing']))? $gameserver['rules']['sv_minPing'] : '',
			'MAX_PING' => (!empty($gameserver['rules']['sv_maxPing']))? $gameserver['rules']['sv_maxPing'] : '',
			'OBJ_1_ALLIER' => ( !empty($gameserver['rules']['g_obj_alliedtext1']) ) ? $gameserver['rules']['g_obj_alliedtext1'] : '',
			'OBJ_2_ALLIER' => ( !empty($gameserver['rules']['g_obj_alliedtext2']) ) ? $gameserver['rules']['g_obj_alliedtext2'] : '',
			'OBJ_3_ALLIER' => ( !empty($gameserver['rules']['g_obj_alliedtext3']) ) ? $gameserver['rules']['g_obj_alliedtext3'] : '',
			'OBJ_1_AXIS' => ( !empty($gameserver['rules']['g_obj_axistext1']) ) ? $gameserver['rules']['g_obj_axistext1'] : '',
			'OBJ_2_AXIS' => ( !empty($gameserver['rules']['g_obj_axistext2']) ) ? $gameserver['rules']['g_obj_axistext2'] : '',
			'OBJ_3_AXIS' => ( !empty($gameserver['rules']['g_obj_axistext3']) ) ? $gameserver['rules']['g_obj_axistext3'] : '',
			'MAPLISTE' => $gameserver['maplist'],
			'ALT_PICS_MAP' => sprintf($langue['alt_img_map_serveur_jeux'], scan_map($gameserver['mapname'], 'nom')),
			'LISTE_PLAYER' => $gameserver['players'],
		);
	}
	else
	{
		$liste_serveur[$info['id']] = array(
			'LINK' => '#',
			'CURRENT_MAP' => '',
			'GAME_TYPE' => '',
			'CLAN' => '',
			'NAME' => $langue['serveur_jeux_down'],
		);
	}
}
$group_activé['clan'] = false;
$group_activé['autre'] = false;
foreach($liste_serveur as $id => $info)
{// on fait la liste des serveurs
	if ($info['CLAN'] == 1)
	{
		if(!$group_activé['clan'])
		{// on prépare l'entête
			$template->assign_block_vars('liste_game_server', array(
				'TITRE_GROUP' => sprintf(($nombre_serveur['clan'] > 1)? $langue['titre_serveurs_jeux'] : $langue['titre_serveur_jeux'], $config['nom_clan'])
			));
			$group_activé['clan'] = true;
		}
	}
	else
	{
		if(!$group_activé['autre'])
		{// on prépare l'entête
			$template->assign_block_vars('liste_game_server', array(
				'TITRE_GROUP' => $langue['titre_serveur_jeux_autre'],
			));
			$group_activé['autre'] = true;
		}
	}
	$template->assign_block_vars('liste_game_server.liste', $info);
}

if (!empty($_GET['details']) && !empty($liste_serveur[$_GET['details']]) && is_array($liste_serveur[$_GET['details']]))
{// affiche en détails un serveur demandé
	$template->assign_block_vars('details', $liste_serveur[$_GET['details']]);
	if ($liste_serveur[$_GET['details']]['PROTOCOL'] === 'q3a')
	{
		if ($liste_serveur[$_GET['details']]['GAME_TYPE'] === 'Objective-Match')
		{
			$template->assign_block_vars('details.objectif', $liste_serveur[$_GET['details']]);
		}
	}
	// on regarde l'info qu'on a sur la map actuelle
	if (!empty($liste_serveur[$_GET['details']]['CURRENT_MAP_INFO']['url']))
	{
		$template->assign_block_vars('details.url_map', array(
			'URL' => $liste_serveur[$_GET['details']]['CURRENT_MAP_INFO']['url'],
			'NOM' => $liste_serveur[$_GET['details']]['CURRENT_MAP_INFO']['nom'],
		));
	}
	else
	{
		$template->assign_block_vars('details.no_url_map', array(
			'NOM' => $liste_serveur[$_GET['details']]['CURRENT_MAP_INFO']['nom'],
		));
	}
	// on fait la liste des map si le serveur le permet
	if (!empty($liste_serveur[$_GET['details']]['MAPLISTE']) && is_array($liste_serveur[$_GET['details']]['MAPLISTE']))
	{
		$template->assign_block_vars('details.list_map', array('TXT_ROTATION' => $langue['rotation_map_serveur_jeux']));
		foreach ($liste_serveur[$_GET['details']]['MAPLISTE'] as $num => $info)
		{ 
			//$info = scan_map($info);
			//echo $info['nom'].'-*-'.$info.' <br />';
			$template->assign_block_vars('details.list_map.map', array('NOM' => $info['nom']));
			if (!empty($info['url']))
			{
				$template->assign_block_vars('details.list_map.map.bouttons_oui', array('URL' => $info['url']));
			}
			else 
			{
				$template->assign_block_vars('details.list_map.map.bouttons_non', 'vide');
			}
		}
	}
	// liste des joueurs
	$verif_ping='';
	$verif_score='';
	$verif_enemy='';
	$verif_kia='';
	$verif_frags='';
	if(count($liste_serveur[$_GET['details']]['LISTE_PLAYER']))
	{
		foreach($liste_serveur[$_GET['details']]['LISTE_PLAYER'] as $player)
		{
			$template->assign_block_vars('details.players', array('NAME' => $player['name']));
			if ( isset($player['ping']) )
			{
				$template->assign_block_vars('details.players.list_ping', array('PING' => ( !empty($player['ping']) ) ? $player['ping'] : ''));
				$verif_ping=1;
			}
			if ( isset($player['score']) )
			{
				$template->assign_block_vars('details.players.list_score', array('SCORE' => ( !empty($player['score']) ) ? $player['score'] : '0'));
				$verif_score=1;
			}
			if ( isset($player['enemy']) )
			{
				$template->assign_block_vars('details.players.list_enemy', array('ENEMY' => ( !empty($player['enemy']) ) ? $player["enemy"] : '0'));
				$verif_enemy=1;
			}
			if ( isset($player['kia']) )
			{
				$template->assign_block_vars('details.players.list_kia', array('KIA' => ( !empty($player['kia']) ) ? $player['kia'] : '0'));
				$verif_kia=1;
			}
			if ( isset($player['frags']) )
			{
				$template->assign_block_vars('details.players.list_frags', array('FRAGS' => ( !empty($player['frags']) ) ? $player['frags'] : '0'));
				$verif_frags=1;
			}
		}
		if($verif_ping == 1)
		{
			$template->assign_block_vars('details.tete_ping', array('PING' => $langue['ping_serveur_jeux']));
		}
		if($verif_score == 1)
		{
			$template->assign_block_vars('details.tete_score', array('SCORE' => $langue['score_serveur_jeux']));
		}
		if($verif_enemy == 1)
		{
			$template->assign_block_vars('details.tete_enemy', array('ENEMY' => $langue['enemy_serveur_jeux']));
		}
		if($verif_kia == 1)
		{
			$template->assign_block_vars('details.tete_kia', array('KIA' => $langue['enemy_serveur_jeux']));
		}
		if($verif_frags == 1)
		{
			$template->assign_block_vars('details.tete_frags', array('FRAGS' => $langue['frags_serveur_jeux']));
		}
	}
}
displayNextPreviousButtons($_GET['limite'],$total ,'multi_page', 'serveur_game_list.php');
$template->pparse('body');
include($root_path.'conf/frame.php'); 
?>