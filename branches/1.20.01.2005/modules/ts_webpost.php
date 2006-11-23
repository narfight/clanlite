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
if ($_SERVER['HTTP_USER_AGENT'] == 'WebPost_UserAgent')
{
	$root_path = './../';
	$action_membre='server_teamspeak_webpost';
	require($root_path.'conf/conf-php.php');
	// on vérifie que le serveur est bien lié à un module
	// scan tout les serveurs de la db pour les users qui sont dedans
	$sql = "SELECT `id` FROM ".$config['prefix']."modules WHERE `config` = '".serialize(array('ip' => $session_cl['ip'], 'port' => $_POST['server_port'], 'query_port' => $_POST['server_queryport']))."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	if ($nfo_connect = $rsql->s_array($get))
	{
		//$_POST = pure_var($_POST);
		// ajoute ou edit le serveur selon qu'il soit deja ou nom dans la db
		$sql = "UPDATE `".$config['prefix']."module_webost_ts` SET `query_port` ='".$_POST['server_queryport']."', `version` ='".$_POST['server_version_major'].'.'.$_POST['server_version_major'].'.'.$_POST['server_version_minor'].'.'.$_POST['server_version_release'].'.'.$_POST['server_version_build']."', `name` ='".$_POST['server_name']."', `password` ='".$_POST['server_password']."', `max_user` ='".$_POST['clients_maximum']."', `country` ='".$_POST['server_ispcountry']."', `mail` ='".$_POST['server_adminemail']."',	`url` ='".$_POST['server_isplinkurl']."', `os` ='".$_POST['server_platform']."', `ispname` ='".$_POST['server_ispname']."', `up_time` ='".$_POST['server_uptime']."' WHERE `ip`='".$session_cl['ip']."' AND `port`='".$_POST['server_port']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		if ($rsql->requete_nb_row() == 0)
		{
			$sql = "INSERT INTO `".$config['prefix']."module_webost_ts` (`ip` ,`port`, `query_port` , `version` , `name` , `password` , `max_user` , `country` , `mail` , `url` , `os` , `ispname` , `up_time`)	VALUES ('".$session_cl['ip']."', '".$_POST['server_port']."', '".$_POST['server_queryport']."', '".$_POST['server_version_major'].'.'.$_POST['server_version_major'].'.'.$_POST['server_version_minor'].'.'.$_POST['server_version_release'].'.'.$_POST['server_version_build']."', '".$_POST['server_name']."', '".$_POST['server_password']."', '".$_POST['clients_maximum']."', '".$_POST['server_ispcountry']."', '".$_POST['server_adminemail']."', '".$_POST['server_isplinkurl']."', '".$_POST['server_platform']."', '".$_POST['server_ispname']."', '".$_POST['server_uptime']."')";
			if (!$rsql->requete_sql($sql))
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
		}
		// scan tout les serveurs de la db pour les users qui sont dedans
		$sql = "SELECT ip,port,query_port FROM ".$config['prefix']."module_webost_ts";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		while ($nfo_connect = $rsql->s_array($get))
		{
			if ($connection = @fsockopen($nfo_connect['ip'], $nfo_connect['query_port']))
			{
				fwrite($connection, "cl ".$nfo_connect['port']."\npl ".$nfo_connect['port']."\nquit\n");
				if (trim(fgets($connection, 4096)) == '[TS]')
				{
					//Partie Channel
					$channel_data_head = explode("\t", fgets($connection, 4096));
					while (!feof($connection))
					{
						if (trim($data_tmp = fgets($connection, 4096)) != 'OK')
						{
							$data_tmp = explode("\t", $data_tmp);
							unset($array_tmp);
							foreach ($data_tmp as $id => $value)
							{
								$array_tmp[trim($channel_data_head[$id])] = $value;
							}
							if ($array_tmp['parent'] == -1)
							{
								$channel_data[$array_tmp['id']] = $array_tmp;
							}
							else
							{
								$channel_data[$array_tmp['parent']]['subchannel'][$array_tmp['id']] = $array_tmp;
							}
						}
						else
						{
							break;
						}
					}
					//Partie user
					$user_data_head = explode("\t", fgets($connection, 4096));
					while (!feof($connection))
					{
						if (trim($data_tmp = fgets($connection, 4096)) != 'OK')
						{
							$data_tmp = explode("\t", trim($data_tmp));
							unset($array_tmp);
							foreach ($data_tmp as $id => $value)
							{
								$array_tmp[trim($user_data_head[$id])] = $value;
							}
							if ( !empty($channel_data[$array_tmp['c_id']]) && is_array($channel_data[$array_tmp['c_id']]) )
							{
								$channel_data[$array_tmp['c_id']]['user'][$array_tmp['p_id']] = $array_tmp;
							}
							else
							{
								foreach ($channel_data as $channel_id => $channel_value)
								{
									if (!empty($channel_value['subchannel']) && is_array($channel_value['subchannel']))
									{
										foreach ($channel_value['subchannel'] as $sub_channel_id => $sub_channel_value)
										{
											if ($sub_channel_id == $data_tmp[1])
											{
												$channel_data[$channel_id]['subchannel'][$sub_channel_id]['user'][$array_tmp['p_id']] = $array_tmp;
												break 2;
											}
										}
									}
								}
							}
						}
					}
				}
				fclose($connection);
				echo $sql = "UPDATE `".$config['prefix']."module_webost_ts` SET `users` ='".serialize($channel_data)."' WHERE `ip`='".$nfo_connect['ip']."' AND `port`='".$nfo_connect['port']."'";
				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
}
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = "TeamSpeak WebPost (central)";
		$central = true;
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$id_insert = mysql_insert_id();
		$sql = "SELECT COUNT(id) FROM ".$config['prefix']."modules WHERE call_page ='ts_webpost.php' LIMIT 1";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$test = $rsql->s_array($get);
		if ($test['COUNT(id)'] == 1)
		{
			$sql = "CREATE TABLE `".$config['prefix']."module_webost_ts` ( `id` mediumint(8) unsigned NOT NULL auto_increment, `ip` varchar(15) NOT NULL default '', `port` smallint(5) unsigned NOT NULL default '0', `query_port` smallint(5) unsigned NOT NULL default '0', `version` varchar(30) NOT NULL default '', `up_time` int(11) unsigned NOT NULL default '0', `name` varchar(255) NOT NULL default '', `password` enum('0','1') NOT NULL default '0', `max_user` smallint(5) unsigned NOT NULL default '0', `country` varchar(255) NOT NULL default '', `mail` varchar(255) NOT NULL default '', `url` varchar(255) NOT NULL default '', `os` enum('Linux','Win32') NOT NULL default 'Linux', `ispname` varchar(255) NOT NULL default '', `users` longtext NOT NULL, PRIMARY KEY  (`id`))";
			if (!$rsql->requete_sql($sql))
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
		}
		$sql = "INSERT INTO `".$config['prefix']."custom_menu` ( `id` , `ordre` , `text` , `url` , `bouge` , `frame` , `module_central` , `id_module` ) VALUES ('', '0', '".$_POST['nom']."', 'modules/ts_webpost.php?from=".$id_insert."', '0', '0', '1', '".$id_insert."')";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		$sql = "SELECT COUNT(id) FROM `".$config['prefix']."modules` WHERE call_page ='ts_webpost.php'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$test = $rsql->s_array($get);
		if ($test['COUNT(id)'] == 0)
		{
			$sql = "DROP TABLE `".$config['prefix']."module_webost_ts`";
			if (!$rsql->requete_sql($sql))
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
		}
		$sql = "DELETE FROM `".$config['prefix']."custom_menu` WHERE `id_module` = '".$_POST['for']."' LIMIT 1";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
}
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_module_webpost_centrale']) )
{
	$root_path = './../';
	$action_membre= 'where_module_webpost';
	$niveau_secu = 16;
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path."controle/cook.php");
	$id_module = (!empty($_POST['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	if ( !empty($_POST['Submit_module_webpost_centrale']) )
	{
		$sql = "UPDATE ".$config['prefix']."modules SET config='".serialize(array('ip' => $_POST['ip'], 'port' => $_POST['port'], 'query_port' => $_POST['query_port']))."' WHERE id ='".$id_module."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		// vérifie si on peux contacter le serveur
		if ($connection = fsockopen($ip, $query_port, $a, $b, 3))
		{
			fwrite($connection, "sel ".$_POST['port']."\nquit\n");
			if (trim(fgets($connection, 4096)) == '[TS]')
			{
				$get = trim(fgets($connection, 4096));
				if ($get == 'OK')
				{
					redirec_text($root_path.'administration/modules.php' , $langue['module_webpost_add'], 'admin');
				}
				elseif ($get == 'ERROR, invalid id')
				{
					redirec_text($root_path.'modules/ts_webpost.php?config_modul_admin=oui&id_module='.$id_module , $langue['erreur_webpost_bad_port'], 'admin');
				}
			}
		}
		else
		{
			redirec_text($root_path.'modules/ts_webpost.php?config_modul_admin=oui&id_module='.$id_module , $langue['erreur_webpost_no_reply'], 'admin');
		}
	}
	require($root_path.'conf/frame_admin.php');
	$template = new Template($root_path.'templates/'.$config['skin']);
	$template->set_filenames( array('body' => 'modules/ts_webpost.tpl'));
	liste_smilies(true, '', 25);
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$recherche = $rsql->s_array($get);
	$recherche = unserialize($recherche['config']);
	$template->assign_block_vars('webpost_config', array(
		'TITRE_M' => $langue['titre_module_webpost'],
		'TITRE_AIDE' => $langue['module_webpost_titre_aide'],
		'TXT_AIDE' => sprintf($langue['module_webpost_txt_aide'], $config['site_domain'].$config['site_path'].'modules/ts_webpost.php'),
		'ID'=> $id_module,
		'TXT_IP' => $langue['ip'],
		'IP' => $recherche['ip'],
		'TXT_PORT' => $langue['port'],
		'PORT' => $recherche['port'],
		'TXT_QUERY_PORT' => $langue['query_port'],
		'QUERY_PORT' => (empty($recherche['query_port']))? 51234 : $recherche['query_port'],
		'EDITER' => $langue['editer'],
	));
	$template->pparse('body');
	require($root_path.'conf/frame_admin.php');
	return;
}
if (!empty($_GET['from']))
{
	$root_path = './../';
	$action_membre = 'where_cl_module_webpost';
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'conf/frame.php');
	$template->set_filenames(array('body' => 'modules/ts_webpost.tpl'));
	$_POST = pure_var($_POST);
	$sql = "SELECT `config`, `nom` FROM `".$config['prefix']."modules` WHERE `id` ='".intval($_GET['from'])."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$brut_nfo_module = $rsql->s_array($get);
	$nfo_server = unserialize($brut_nfo_module['config']);
	$sql = "SELECT * FROM `".$config['prefix']."module_webost_ts` WHERE `ip` ='".$nfo_server['ip']."' AND `port` ='".$nfo_server['port']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	if ($nfo = $rsql->s_array($get))
	{
		$template->assign_block_vars('webpost_show', array(
			'TITRE' => $brut_nfo_module['nom'],
			'SERVER_NAME' => $nfo['name'],
		));
		$tmp_users = unserialize($nfo['users']);
		if (!empty($tmp_users) && is_array($tmp_users))
		{
			foreach($tmp_users as $id => $value)
			{// les channels
				$value = decode_channel($value);
				$template->assign_block_vars('webpost_show.channel', array(
					'CHANNEL_NAME' => $value['name'].' '.$value['flags'],
					'PASSWORD_ICON' => $value['password'],
				));
				if (!empty($value['subchannel']) && is_array($value['subchannel']))
				{
					foreach($value['subchannel'] as $id_sub_channel => $value_sub_channel)
					{// les sub channel
						$value_sub_channel = decode_channel($value_sub_channel);
						$template->assign_block_vars('webpost_show.channel.sub_channel', array(
							'NAME' => $value_sub_channel['name'],
							'PASSWORD_ICON' => $value_sub_channel['password'],
						));
						if (!empty($value_sub_channel['user']) && is_array($value_sub_channel['user']))
						{// user dans subchannel
							foreach($value_sub_channel['user'] as $id_sub_user => $value_sub_user)
							{
								$value_sub_user = decode_user($value_sub_user);
								$template->assign_block_vars('webpost_show.channel.sub_channel.sub_user', array(
									'USER_NAME' => $value_sub_user['nick'],
									'PLAYER_ICON' => $value_sub_user['icon'],
								));
							}
						}
					}
				}
			}
			if (!empty($value['user']) && is_array($value['user']))
			{// user dans channel
				foreach($value['user'] as $id_user => $value_user)
				{
					$value_user = decode_user($value_user);
					$template->assign_block_vars('webpost_show.channel.user', array(
						'USER_NAME' => $value_user['nick'],
						'PLAYER_ICON' => $value_user['icon'],
					));
				}
			}
		}
	}
	$template->pparse('body');
	require($root_path.'conf/frame.php'); 
}
?>