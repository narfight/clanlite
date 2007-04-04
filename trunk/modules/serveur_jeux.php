<?php
/****************************************************************************
 *	Fichier		: serveur_jeux.php											*
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
		$nom = 'Query Serveur';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	require_once($root_path.'service/gsquery/gsQuery.php');
	$block = module_tpl('serveur_jeux.tpl');

	$modules['config'] = unserialize($modules['config']);
	$sql = "SELECT `id`, `ip`, `port`, `protocol` FROM `".$config['prefix']."game_server` WHERE `id`='".$modules['config']['serveur']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$module_game = $rsql->s_array($get);	
	if ( (!$gameserver=queryServer($module_game['ip'], $module_game['port'], $module_game['protocol'], $module_game['id'])) )
	{
		$template->assign_block_vars('modules_'.$modules['place'], array( 
			'TITRE' => $modules['nom'],
			'IN' => $langue['serveur_jeux_down']
		));
	}
	else
	{
		// Turn template blocks into PHP assignment statements for the values of $match..
		$block = module_tpl('serveur_jeux.tpl');		
		$current_map = scan_map($gameserver['mapname'], 'nom');
		if ($modules['config']['image'])
		{
			foreach(scandir($root_path.'images/pics_map/') as $id => $valeur)
			{
				if (ereg($gameserver['mapname'].'.(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $valeur))
				{
					$img_map = $valeur;
					$taille_img_map = getimagesize($root_path.'images/pics_map/'.$valeur);
					break;
				}
				$img_map = 'empty.jpg';
			}
			if ($img_map != 'empty.jpg')
			{
				$block['serveur_jeux'] = str_replace('{IMAGE_MAP}', '<img src="'.$root_path.'images/pics_map/'.$img_map.'" '.$taille_img_map[3].' alt="'.sprintf($langue['alt_img_map_serveur_jeux'], $current_map).'" />', $block['serveur_jeux']);
			}
			else
			{
				$block['serveur_jeux'] = str_replace('{IMAGE_MAP}', '', $block['serveur_jeux']);
			}
		}
		else
		{
			$block['serveur_jeux'] = str_replace('{IMAGE_MAP}', '', $block['serveur_jeux']);
		}
		$block['serveur_jeux'] = str_replace('{TXT_IP}', $langue['ip'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{IP}', $module_game['ip'].' : '.$module_game['port'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_CURRENT_MAP}', $langue['map_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{CURRENT_MAP}', $current_map, $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_NEXT_MAP}', $langue['next_map_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{NEXT_MAP}', scan_map($gameserver['nextmap'], 'nom'), $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{LISTE_PLAYER}', $langue['liste_joueur_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{PLAYER}', $gameserver['numplayers'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_GAME_TYPE}', $langue['gametype_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{GAME_TYPE}', $gameserver['gametype'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{JOINERURI}', $gameserver['JoinerURI'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_PLACE}', $langue['nbr_place_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{PLACE}', $gameserver['maxplayers'], $block['serveur_jeux']);
		// liste des joueurs
		if(count($gameserver['players']) && $modules['config']['liste'])
		{
			$serveur_jeux_boucle = '';
			$color = 'table-cellule';
			foreach($gameserver['players'] as $player)
			{
				$color = ($color === 'table-cellule')? 'table-cellule-2' : 'table-cellule';
				$serveur_jeux_boucle_beta = str_replace('{NAME}', $player["name"], $block['serveur_jeux_boucle']);
				$serveur_jeux_boucle .= str_replace('{COLOR}', $color, $serveur_jeux_boucle_beta);
			}
			$block['serveur_jeux'] = str_replace('{LISTE}', str_replace('{LISTE}', $serveur_jeux_boucle, $block['total_liste']), $block['serveur_jeux']);
			$block['serveur_jeux'] = str_replace('{TXT_LISTE}', $langue['liste_joueur_serveur_jeux'], $block['serveur_jeux']);
		}
		else
		{
			$block['serveur_jeux'] = str_replace('{LISTE}', '', $block['serveur_jeux']);
		}
		$template->assign_block_vars('modules_'.$modules['place'], array( 
			'TITRE' => $modules['nom'],
			'IN' => $block['serveur_jeux']
		));
	}
	return;
}
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_module']) )
{
	define('CL_AUTH', true);
	$root_path = './../';
	$action_membre= 'where_module_serveur_game';
	$niveau_secu = 16;
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'controle/cook.php');
	$id_module = (!empty($_POST['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	if ( !empty($_POST['Submit_module']) )
	{
		$sql = "UPDATE `".$config['prefix']."modules` SET `config`='".serialize(array('serveur' =>$_POST['id_serveur'], 'image' => (empty($_POST['image']))? false : true, 'liste' => (empty($_POST['liste']))? false : true))."' WHERE `id`='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'administration/modules.php' , $langue['redirection_module_serveur_game_edit'],'admin');
	}
	require($root_path.'conf/frame_admin.php');
	$template = new Template(find_module_tpl('serveur_jeux.tpl', true));
	$template->set_filenames(array('body_module' => 'serveur_jeux.tpl'));
	
	//lit la config du module
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$actu_data = $rsql->s_array($get);
	$actu_data = (!empty($actu_data['config']))? unserialize($actu_data['config']): array('serveur' => '', 'liste' => true, 'image' => false);
	
	//list les serveurs
	$sql = 'SELECT `id`, `ip`, `port`, `protocol` FROM `'.$config['prefix'].'game_server`';
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$liste = '';
	while ($server_liste = $rsql->s_array($get))
	{
		$liste .='<option value="'.$server_liste['id'].'" '.(($actu_data['serveur'] === $server_liste['id'])? 'selected="selected"' : '').'>'.$server_liste['ip'].':'.$server_liste['port'].' ('.$server_liste['protocol'].')</option>';
	}
	$template->assign_block_vars('serveur_config', array(
		'ICI' => session_in_url('serveur_jeux.php'),
		'TITRE' => $langue['titre_module_serveur_game'],
		'TXT_SERVEUR' => $langue['serveur_game_ip'],
		'TXT_IMAGE' => $langue['image_map_module_serveur_game'],
		'IMAGE_CHECKED' => ($actu_data['image'])?'checked="checked"' : '',
		'TXT_LISTE' => $langue['liste_module_serveur_game'],
		'LISTE_CHECKED' => ($actu_data['liste'])?'checked="checked"' : '',
		'CHOISIR' => $langue['choisir'],
		'EDITER' => $langue['editer'],
		'ID'=> $id_module,
		'LISTE'=> $liste,
	));
	$template->pparse('body_module');
	require($root_path.'conf/frame_admin.php');
}
?>