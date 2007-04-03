<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_serveur_jeux';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
require_once($root_path."service/gsquery/gsQuery.php");
//on prend la config du serveur
// on scan
if ( (!$gameserver=queryServer($config['serveur_game_ip'], $config['serveur_game_port'], $config['serveur_game_protocol'])) )
{
	$template->set_filenames(array('body' => 'divers_text.tpl'));
	$template->assign_vars(array(
		'TITRE' => sprintf($langue['titre_serveur_jeux'], $config['tag'], $rsql->nb_req),
		'TEXTE' => $langue['serveur_jeux_down'],
	));
}
else
{
	$template->set_filenames(array('body' => 'serveur_jeux.tpl'));
	// on regarde si nous avons des info en db sur la map actuelle
	$sql = "SELECT * FROM `".$config['prefix']."server_map` WHERE nom_console LIKE '%$gameserver->mapname'";
	if (! ($map_actu = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	if (! ($map = $rsql->s_array($map_actu)) )
	{
		$map['nom'] = $gameserver->mapname;
	}
	// on regarde si nous avons des info en db sur la prochaine map
	$sql = "SELECT * FROM `".$config['prefix']."server_map` WHERE nom_console = '".$gameserver->nextmap."'";
	if (! ($map_next = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	if (! ($next_map = $rsql->s_array($map_next)) )
	{
		$next_map['nom'] = $gameserver->nextmap;
	}
	// on regarde si nous avons une image de la map en cour
	$path = $root_path."images/pics_map/".$gameserver->mapname.".jpg";
	switch($gameserver->password)
	{
		case "0":
			$serveur_password = $langue['non'];
		break;
		case "1":
			$serveur_password = $langue['oui'];
		break;
		default:
			$serveur_password = $langue['inconnu'];
		break;
	}
	$template->assign_vars(array(
		'TITRE_SERVEUR' =>  sprintf($langue['titre_serveur_jeux'], $config['tag'], $rsql->nb_req),
		'TXT_IP' => $langue['ip'],
		'IP' => $config['serveur_game_ip'],
		'TXT_INFO' => $langue['info_serveur_jeux'],
		'INFO' => nl2br(bbcode($config['serveur_game_info'])),
		'TXT_NAME' => $langue['nom_serveur_jeux'],
		'NAME' => $gameserver->servertitle,
		'TXT_VERSION' => $langue['version_serveur_jeux'],
		'VERSION' => $gameserver->gameversion,
		'TXT_PLACE' => $langue['nbr_place_serveur_jeux'],
		'PLACE' => $gameserver->maxplayers,
		'PLAYER' => $gameserver->numplayers,
		'MAP' => htmlspecialchars($gameserver->mapname),
		'PORT' => $gameserver->hostport,
		'PICS_MAP' => (file_exists($path))? $path : $root_path."images/pics_map/empty.jpg",
		'TXT_GAME_TYPE' => $langue['gametype_serveur_jeux'],
		'GAME_TYPE' => $gameserver->gametype,								
		'TXT_CURRENT_MAP' => $langue['map_serveur_jeux'],
		'CURRENT_MAP' => $map['nom'],
		'TXT_PASSWORD' => $langue['password_serveur_jeux'],
		'PASSWORD' => $serveur_password,
		'LISTE_JOUEUR' => $langue['liste_joueur_serveur_jeux'],
		'NAME_JOUEUR' => $langue['name_serveur_jeux'],
	));
	if ( !empty($next_map['nom']) )
	{
		$template->assign_block_vars('next_map', array(
			'TXT_NEXT_MAP' => $langue['next_map_serveur_jeux'],
			'NEXT_MAP' => $next_map['nom'],
		));
	}
	if ( !empty($gameserver->rules['sv_maxPing']) || !empty($gameserver->rules['sv_minPing']) )
	{
		$template->assign_block_vars('min_max_ping', array(
			'TXT_ENTRE_PING' => $langue['ip_min_max_serveur_jeux'],
			'MIN_PING' => $gameserver->rules['sv_minPing'],
			'MAX_PING' => $gameserver->rules['sv_maxPing'],
		));
	}
	// on fais la liste des joueurs qui sont sur le serveur
	if ($config['serveur_game_protocol'] == "q3a")
	{
		if ($gameserver->gametype == "Objective-Match")
		{
			$template->assign_block_vars('objectif', array(
				'TXT_OBJ_AXIS' => $langue['obj_axis_serveur_jeux'],
				'TXT_OBJ_ALLIER' => $langue['obj_allier_serveur_jeux'],
				'OBJ_1_ALLIER' => ( !empty($gameserver->rules['g_obj_alliedtext1']) ) ? $gameserver->rules['g_obj_alliedtext1'] : "",
				'OBJ_2_ALLIER' => ( !empty($gameserver->rules['g_obj_alliedtext2']) ) ? $gameserver->rules['g_obj_alliedtext2'] : "",
				'OBJ_3_ALLIER' => ( !empty($gameserver->rules['g_obj_alliedtext3']) ) ? $gameserver->rules['g_obj_alliedtext3'] : "",
				'OBJ_1_AXIS' => ( !empty($gameserver->rules['g_obj_axistext1']) ) ? $gameserver->rules['g_obj_axistext1'] : "",
				'OBJ_2_AXIS' => ( !empty($gameserver->rules['g_obj_axistext2']) ) ? $gameserver->rules['g_obj_axistext2'] : "",
				'OBJ_3_AXIS' => ( !empty($gameserver->rules['g_obj_axistext3']) ) ? $gameserver->rules['g_obj_axistext3'] : "",
			));
		}
		// on fait la liste des maps
		if (!empty($gameserver->maplist) )
		{
			$template->assign_block_vars('list_map', array(
				'TXT_ROTATION' => $langue['rotation_map_serveur_jeux'],
			));
			foreach ($gameserver->maplist as $num => $name)
			{ 
				if (!empty($name))
				{
					// 3.on v�rifie si nous avons des info sur la map dans la db
					$sql = "SELECT * FROM ".$config['prefix']."server_map WHERE nom_console = '".$name."'";
					if (! ($map = $rsql->requete_sql($sql)) )
					{
						sql_error($sql, $rsql->error, __LINE__, __FILE__);
					}
					$info_map = $rsql->s_array($map);
					// on affiche
					$template->assign_block_vars('list_map.map', array('NOM' => ( !empty($info_map['nom']) ) ? $info_map['nom'] : $name));
					if (!empty($info_map['url']))
					{
						$template->assign_block_vars('list_map.map.bouttons_oui', array('URL' => $info_map['url']));
					}
					else 
					{
						$template->assign_block_vars('list_map.map.bouttons_non', array('URL' => "Liens non disponible."));
					}
				}
			}
		}
	}
	// liste des joueurs
	$players=$gameserver->sortPlayers($gameserver->players,'name');
	$verif_ping='';
	$verif_score='';
	$verif_enemy='';
	$verif_kia='';
	$verif_frags='';
	if(count($players))
	{
		foreach($players as $player)
		{
			$template->assign_block_vars('players', array('NAME' => $player['name']));
			if ( isset($player['ping']) )
			{
				$template->assign_block_vars('players.list_ping', array('PING' => ( !empty($player['ping']) ) ? $player['ping'] : ''));
				$verif_ping=1;
			}
			if ( isset($player['score']) )
			{
				$template->assign_block_vars('players.list_score', array('SCORE' => ( !empty($player['score']) ) ? $player['score'] : '0'));
				$verif_score=1;
			}
			if ( isset($player['enemy']) )
			{
				$template->assign_block_vars('players.list_enemy', array('ENEMY' => ( !empty($player['enemy']) ) ? $player["enemy"] : '0'));
				$verif_enemy=1;
			}
			if ( isset($player['kia']) )
			{
				$template->assign_block_vars('players.list_kia', array('KIA' => ( !empty($player['kia']) ) ? $player['kia'] : '0'));
				$verif_kia=1;
			}
			if ( isset($player['frags']) )
			{
				$template->assign_block_vars('players.list_frags', array('FRAGS' => ( !empty($player['frags']) ) ? $player['frags'] : '0'));
				$verif_frags=1;
			}
		}
		if($verif_ping == 1)
		{
			$template->assign_block_vars('tete_ping', array('PING' => $langue['ping_serveur_jeux']));
		}
		if($verif_score == 1)
		{
			$template->assign_block_vars('tete_score', array('SCORE' => $langue['score_serveur_jeux']));
		}
		if($verif_enemy == 1)
		{
			$template->assign_block_vars('tete_enemy', array('ENEMY' => $langue['enemy_serveur_jeux']));
		}
		if($verif_kia == 1)
		{
			$template->assign_block_vars('tete_kia', array('KIA' => $langue['enemy_serveur_jeux']));
		}
		if($verif_frags == 1)
		{
			$template->assign_block_vars('tete_frags', array('FRAGS' => $langue['frags_serveur_jeux']));
		}
	}
}
$template->pparse('body');
include($root_path."conf/frame.php"); 
?>