<?php
/****************************************************************************
 *	Fichier		: shoutbox.php												*
 *	Copyright	: (C) 2006 ClanLite											*
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
		$nom = 'Shoutbox';
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$sql = 'CREATE TABLE `'.$config['prefix'].'module_shoutbox_'.mysql_insert_id().'` (`id` mediumint(8) unsigned NOT NULL auto_increment, `user` varchar(255) NOT NULL default \'\', `msg` varchar(255) NOT NULL default \'\', PRIMARY KEY  (`id`))';
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

	$sql = 'SELECT `id`, `user`, `msg` FROM '.$config['prefix'].'module_shoutbox_'.$modules['id'].' ORDER BY `id` DESC LIMIT 15';
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
?>