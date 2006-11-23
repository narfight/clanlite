<?php
/****************************************************************************
 *	Fichier		: 															*
 *	Copyright	: (C) 2004 ClanLite											*
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
		$nom = 'Connection Teamspeak';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}

	$block = module_tpl('teamspeak_connection.tpl');
		
	$nfo_module = explode('|!|', $modules['config']);
	$block['teamspeak_connection'] = str_replace('{ICI}', session_in_url($root_path.'modules/connection_teamspeak.php'), $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{TXT_NOM}', $langue['form_nom'], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{TXT_LOGIN}', $langue['form_login'], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{TXT_CODE}', $langue['form_psw'], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{TXT_CODE_CHANNEL}', $langue['redirection_module_connect_ts_psw_channel'], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{TXT_CHANNEL}', $langue['redirection_module_connect_ts_channel'], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{CONNECTION}', $langue['redirection_module_connect_ts_connection'], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{IP}', $nfo_module[0], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{PORT}', $nfo_module[1], $block['teamspeak_connection']);
	$block['teamspeak_connection'] = str_replace('{NAME}', (empty($session_cl['user']))? '' : $config['tag'].$session_cl['user'], $block['teamspeak_connection']);
	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => $block['teamspeak_connection']
	));
	return;
}
if(!empty($_POST['teamspeak_connection_envois'])  )
{
	$_POST['teamspeak_connection_envois'] = '';
	$root_path = './../';
	$action_membre= 'where_connection_ts';
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'conf/frame.php');
	$template->set_filenames(array('body_module' => 'divers_text.tpl'));
	$login = (!empty($_POST['teamspeak_connection_login']))? $_POST['teamspeak_connection_login'] : '';
	$code = (!empty($_POST['teamspeak_connection_code']))? $_POST['teamspeak_connection_code'] : '';
	$channel = (!empty($_POST['teamspeak_connection_channel']))? $_POST['teamspeak_connection_channel'] : '';
	$channel_code = (!empty($_POST['teamspeak_connection_channel_code']))? $_POST['teamspeak_connection_channel_code'] : '';
	$template->assign_vars(array(
		'TEXTE' => '<a href="teamspeak://'.$_POST['teamspeak_connection_ip'].':'.$_POST['teamspeak_connection_port'].'/nickname='.$_POST['teamspeak_connection_name'].'?loginname='.$login.'?password='.$code.'?channel='.$channel.'?channelpassword='.$channel_code.'">'.$langue['ts_connection_module_liens'].'</a>',
		'TITRE' => $langue['ts_connection_module_titre']
	));
	$template->pparse('body_module');
	require($root_path.'conf/frame.php');
	return;
}
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_connect_ts_module']) )
{
	$root_path = './../';
	$action_membre= 'where_module_connect_ts';
	$niveau_secu = 16;
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'controle/cook.php');
	$id_module = (!empty($_POST['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	if ( !empty($_POST['Submit_connect_ts_module']) )
	{
		$sql = 'UPDATE `'.$config['prefix']."modules` SET config='".$_POST['ip_vocal']."|!|".$_POST['port_vocal']."' WHERE id ='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'administration/modules.php' ,$langue['redirection_module_connect_ts_edit'], 'admin');
	}
	require($root_path.'conf/frame_admin.php');
	$template = new Template($root_path.'templates/'.$session_cl['skin']);
	$template->set_filenames( array('body' => 'modules/teamspeak_connection.tpl'));
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$recherche = $rsql->s_array($get);
	$nfo_module = explode('|!|', $recherche['config']);
	$template->assign_block_vars('teamspeak_connection_config',array(
		'ICI' => session_in_url('connection_teamspeak.php'),
		'ID'=> $id_module,
		'IP'=> ( !empty($nfo_module[0]) )? $nfo_module[0] : '',
		'PORT'=> ( !empty($nfo_module[1]) )? $nfo_module[1] : '',
		'TITRE' => $langue['titre_module_connect_ts'],
		'TXT_IP' => $langue['ip'],
		'TXT_PORT' => $langue['port'],
		'EDITER' => $langue['editer'],
	));
	$template->pparse('body');
	require($root_path.'conf/frame_admin.php');
	return;
}
?>