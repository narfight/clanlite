<?php
/****************************************************************************
 *	Fichier		: shoutbox.php												*
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
		$nom = 'Shoutbox';
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$id_module = $rsql->last_insert_id();
		$sql = 'CREATE TABLE `'.$config['prefix'].'module_shoutbox_'.$id_module.'` (`id` mediumint(8) unsigned NOT NULL auto_increment, `user` varchar(255) NOT NULL default \'\', `msg` varchar(255) NOT NULL default \'\', PRIMARY KEY  (`id`))';
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		// sauvegarde une configuration d'origine
		$sql = "UPDATE `".$config['prefix']."modules` SET config=15 WHERE id='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		$sql = 'DROP TABLE `'.$config['prefix'].'module_shoutbox_'.$_POST['for'].'`';
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}

	//Quand on poste un message
	if(!empty($_POST['Submit_shoutbox']) && !empty($_POST['shoutbox_msg']) && !empty($_POST['id']) && $modules['id'] == $_POST['id'])
	{
		//on vérifie que c'est pas un msg en doublon
		if (!isset($session_cl['module_shourbox_anti_doublon']) || (isset($session_cl['module_shourbox_anti_doublon']) && $session_cl['module_shourbox_anti_doublon'] != $_POST['shoutbox_msg']))
		{
			$_POST = pure_var($_POST);

			//si la personne n'a pas donné de pseudo
			if (empty($_POST['shoutbox_user']))
			{
				$_POST['shoutbox_user'] = $langue['guest'];
			}

			//on sauvegarde le message pour la détection de doublon
			$session_cl['module_shourbox_anti_doublon'] = $_POST['shoutbox_msg'];
			save_session($session_cl);

			$sql = 'INSERT INTO `'.$config['prefix'].'module_shoutbox_'.$_POST['id'].'` (`user`, `msg`) VALUES (\''.$_POST['shoutbox_user'].'\', \''.$_POST['shoutbox_msg'].'\')';
			if (! ($get = $rsql->requete_sql($sql, 'module', 'Ajoute le message dans la shoutbox')) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
		}
	}

	$block = module_tpl('shoutbox.tpl');

	// liste le contenu de la shoutbox
	$sql = 'SELECT `id`, `user`, `msg` FROM '.$config['prefix'].'module_shoutbox_'.$modules['id'].' ORDER BY `id` DESC LIMIT '.intval($modules['config']);
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Liste le contenu de la shoutbox')) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$liste_msg = '';
	$color = 'table-cellule';
	while ( $liste = $rsql->s_array($get) )
	{
		$color = ($color === 'table-cellule')? 'table-cellule-2' : 'table-cellule';
		$tmp = str_replace('{USER}', htmlspecialchars($liste['user']), $block['liste_shoutbox']);
		$tmp = str_replace('{CLASS}', $color, $tmp);
		$liste_msg .= str_replace('{MSG}', bbcode($liste['msg']), $tmp)."\n";
		$last_id = $liste['id'];
	}
	
	//supprime tout les messages trop vieux
	if (isset($last_id))
	{
		$sql = 'DELETE FROM `'.$config['prefix'].'module_shoutbox_'.$modules['id'].'` WHERE `id` < \''.$last_id.'\'';
		if (!$rsql->requete_sql($sql, 'module', 'Supprime les messages trop vieux') )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}

	$block['shoutbox'] = str_replace('{ICI}', session_in_url($config['site_domain'].$_SERVER['REQUEST_URI']), $block['shoutbox']);
	$block['shoutbox'] = str_replace('{ID}', $modules['id'], $block['shoutbox']);
	$block['shoutbox'] = str_replace('{USER_DEFAULT}', (empty($session_cl['user']))? '' : $session_cl['user'], $block['shoutbox']);
	$block['shoutbox'] = str_replace('{USER}', $langue['form_nom'], $block['shoutbox']);
	$block['shoutbox'] = str_replace('{MSG}', $langue['form_message'], $block['shoutbox']);
	$block['shoutbox'] = str_replace('{LISTE}', $liste_msg, $block['shoutbox']);
	$block['shoutbox'] = str_replace('{ENVOYER}', $langue['envoyer'], $block['shoutbox']);
	$template->assign_block_vars('modules_'.$modules['place'], array(
		'TITRE' => $modules['nom'],
		'IN' => $block['shoutbox']
	));
}

//administration
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_shoutbox_config']) || !empty($_POST['Submit_shoutbox_vider']) || !empty($_POST['Supprimer_msg']) && (isset($_POST['id_module']) || isset($_GET['id_module'])))
{
	$id_module = (empty($_GET['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	define('CL_AUTH', true);
	$root_path = './../';
	$niveau_secu = 16;
	$action_membre= 'where_module_shoutbox';
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'controle/cook.php');

	//supprimer un ou des messages
	if (isset($_POST['Supprimer_msg']) || isset($_POST['Submit_shoutbox_vider']))
	{
		if (!empty($_POST['Submit_shoutbox_vider']))
		{
			$sql = "DELETE FROM `".$config['prefix']."module_shoutbox_".$id_module."`";
		}
		else
		{
			$sql = "DELETE FROM `".$config['prefix']."module_shoutbox_".$id_module."` WHERE id ='".$_POST['for_msg']."'";
		}
		
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('shoutbox.php?config_modul_admin=true&id_module='.$id_module, $langue['redirection_module_shoutbox_dell'], 'admin');
	}
	
	if (!empty($_POST['Submit_shoutbox_config']))
	{
		$sql = "UPDATE `".$config['prefix']."modules` SET `config`='".intval($_POST['nbr_lignes'])."' WHERE `id`='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('shoutbox.php?config_modul_admin=true&id_module='.$id_module, $langue['redirection_module_shoutbox_edit'], 'admin');
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
	$template = new Template(find_module_tpl('shoutbox.tpl', true));
	$template->set_filenames( array('body_module' => 'shoutbox.tpl'));
	$template->assign_block_vars('shoutbox_config', array(
		'ICI' => session_in_url('shoutbox.php'),
		'ID' => $id_module,
		'ID_MODULE' => $id_module,
		'TITRE' => $langue['titre_module_shoutbox'],
		'TITRE_DEL' => $langue['titre_module_shoutbox_del'],
		'TXT_NBR_LIGNES' => $langue['module_shoutbox_nbr_lignes'],
		'NOM' => $langue['nom'],
		'MSG' => $langue['le_txt'],
		'ACTION' => $langue['action'],
		'TXT_CON_DELL' => $langue['confirm_dell'],
		'SUPPRIMER' => $langue['supprimer'],
		'NBR_LIGNES' => $actu_data,
		'EDITER' => $langue['editer'],
		'VIDER' => $langue['module_shoutbox_vider'],
	));
	
	$sql = "SELECT `id`, `user`, `msg` FROM ".$config['prefix']."module_shoutbox_".$id_module." ORDER BY `id` DESC";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ( $liste = $rsql->s_array($get) )
	{
		$template->assign_block_vars('shoutbox_config.liste', array(
			'FOR' => $liste['id'],
			'NOM' => $liste['user'],
			'MSG' => $liste['msg'],
		));
	}
	$template->pparse('body_module');
	require($root_path.'conf/frame_admin.php');
	return;
}
?>