<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = "Query Serveur";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	require_once($root_path."service/gsquery/gsQuery.php");
	$tpl_filename = $template->make_filename('modules/serveur_jeux.tpl');
	$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));
	
	// replace \ with \\ and then ' with \'.
	$tpl = str_replace('\\', '\\\\', $tpl);
	$tpl  = str_replace('\'', '\\\'', $tpl);
	
	// strip newlines.
	$tpl  = str_replace("\n", '', $tpl);
	
	$modules['config'] = unserialize($modules['config']);
	if ($modules['config']['serveur'] != 'serveur_clan')
	{
		$sql = "SELECT id,ip,port,protocol FROM ".$config['prefix']."game_server WHERE id='".$modules['config']['serveur']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$module_game = $rsql->s_array($get);	
	}
	else
	{
		$module_game['ip'] = $config['serveur_game_ip'];
		$module_game['port'] = $config['serveur_game_port'];
		$module_game['protocol'] = $config['serveur_game_protocol'];
	}
	if ( (!$gameserver=queryServer($module_game['ip'], $module_game['port'], $module_game['protocol'])) )
	{
		$template->assign_block_vars('modules_'.$modules['place'], array( 
			'TITRE' => $modules['nom'],
			'IN' => $langue['serveur_jeux_down']
		));
	}
	else
	{
		// Turn template blocks into PHP assignment statements for the values of $match..
		$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
		eval($tpl);
		
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
				$block['serveur_jeux'] = str_replace('{IMAGE_MAP}', '<img src="'.$root_path.'images/pics_map/'.$img_map.'" '.$taille_img_map[3].' alt="'.printf($langue['alt_img_map_serveur_jeux'], $current_map).'" />', $block['serveur_jeux']);
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
		$block['serveur_jeux'] = str_replace('{IP}', $module_game['ip']." : ".$module_game['port'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_CURRENT_MAP}', $langue['map_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{CURRENT_MAP}', $current_map, $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_NEXT_MAP}', $langue['next_map_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{NEXT_MAP}', scan_map($gameserver['nextmap'], 'nom'), $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{LISTE_PLAYER}', $langue['liste_joueur_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{PLAYER}', $gameserver['numplayers'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_GAME_TYPE}', $langue['gametype_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{GAME_TYPE}', $gameserver['gametype'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{TXT_PLACE}', $langue['nbr_place_serveur_jeux'], $block['serveur_jeux']);
		$block['serveur_jeux'] = str_replace('{PLACE}', $gameserver['maxplayers'], $block['serveur_jeux']);
		// liste des joueurs
		if(count($gameserver['players']) && $modules['config']['liste'])
		{
			$serveur_jeux_boucle = '';
			$color = '';
			foreach($gameserver['players'] as $player)
			{
				$color = ($color == "table-cellule")? "table-cellule-2" : "table-cellule";
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
	$root_path = './../';
	$action_membre= 'where_module_serveur_game';
	$niveau_secu = 16;
	include($root_path.'conf/template.php');
	include($root_path.'conf/conf-php.php');
	include($root_path."controle/cook.php");
	$id_module = (!empty($_POST['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	if ( !empty($_POST['Submit_module']) )
	{
		$sql = "UPDATE ".$config['prefix']."modules SET config='".serialize(array('serveur' =>$_POST['id_serveur'], 'image' => (empty($_POST['image']))? false : true, 'liste' => (empty($_POST['liste']))? false : true))."' WHERE id ='".$id_module."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path."administration/modules.php" , $langue['redirection_module_serveur_game_edit'],'admin');
	}
	include($root_path."conf/frame_admin.php");
	$template = new Template($root_path.'templates/'.$config['skin']);
	$template->set_filenames( array('body' => 'modules/serveur_jeux.tpl'));
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$actu_data = $rsql->s_array($get);
	$actu_data = unserialize($actu_data['config']);
	$sql = "SELECT id,ip,port,protocol FROM ".$config['prefix']."game_server";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$selected = ($actu_data['serveur'] == 'serveur_clan')? 'selected="selected"' : '';
	$liste = ($config['serveur'] == 1)? "<option value=\"serveur_clan\" ".$selected.">".$langue['clanserveur_module_serveur_game']."</option>" : "";
	while ($server_liste = $rsql->s_array($get))
	{
		$selected = ($actu_data['serveur'] == $server_liste['id'])? 'selected="selected"' : '';
		$liste .="<option value=\"".$server_liste['id']."\" ".$selected.">".$server_liste['ip'].":".$server_liste['port']." (".$server_liste['protocol'].")</option>";
	}
	$template->assign_block_vars('serveur_config',array(
		'TITRE' => $langue['titre_module_serveur_game'],
		'TXT_SERVEUR' => $langue['redirection_module_serveur_game_edit'],
		'TXT_IMAGE' => $langue['image_map_module_serveur_game'],
		'IMAGE_CHECKED' => ($actu_data['image'])?'checked="checked"' : '',
		'TXT_LISTE' => $langue['liste_module_serveur_game'],
		'LISTE_CHECKED' => ($actu_data['liste'])?'checked="checked"' : '',
		'CHOISIR' => $langue['choisir'],
		'EDITER' => $langue['editer'],
		'ID'=> $id_module,
		'LISTE'=> $liste,
	));
	$template->pparse('body');
	include($root_path."conf/frame_admin.php");
}
?>