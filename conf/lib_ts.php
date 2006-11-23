<?php
/****************************************************************************
 *	Fichier		: lib_ts.php												*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
function refresh_cache($add_from_webpost)
{
	global $config, $rsql, $ts_cache;
	
	unset($ts_cache);
	$ts_cache['scanné'] = true;
	$sql = "SELECT * FROM `".$config['prefix']."module_webost_ts` WHERE `ip` = '".$ip_serveur."' AND `port` ='".$port_serveur."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while($nfo = $rsql->s_array($get))
	{
		$info = get_info_server ($nfo['ip'], $nfo['query_port'], $nfo['port']);
		if ($info != false)
		{
			$tmp_users = scan_ts_server ($nfo['ip'], $nfo['query_port'], $nfo['port']);
			$sql = "UPDATE `".$config['prefix']."module_webost_ts` SET `query_port` ='".$nfo['query_port']."', `version` ='".$info['total_server_version']."', `name` ='".$info['server_name']."', `password` ='".$info['server_password']."', `max_user` ='".$info['server_maxusers']."', `country` ='', `mail` ='".$info['isp_adminemail']."', `url` ='".$info['isp_linkurl']."', `os` ='".$info['server_platform']."', `ispname` ='".$info['isp_ispname']."', `up_time` ='".$info['server_uptime']."', `users` ='".serialize($tmp_users)."', `last_scan` ='".time()."' WHERE `ip`='".$ip_serveur."' AND `port`='".$port_serveur."'";
			if (!$rsql->requete_sql($sql, 'TS', 'Actualisation manuel du cache des serveurs TeamSpeak'))
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			$nfo['users'] = $tmp_users;
			$ts_cache[$nfo['ip'].$nfo['port']] = array(
				'id' => time(),
				'last_scan' => time(),
				'ip' => $nfo['ip'],
				'port' => $nfo['port'],
				'query_port' => $nfo['query_port'],
				'version' => $info['total_server_version'],
				'up_time' => $info['server_uptime'],
				'name' => $info['server_name'],
				'password' => $info['server_password'],
				'max_user' => $info['server_maxusers'],
				'country' => '',
				'mail' => $info['isp_adminemail'],
				'url' => $info['isp_linkurl'],
				'os' => $info['server_platform'],
				'ispname' => $info['isp_ispname'],
				'users' => $tmp_users,
			);
		}
	}
}

function get_server_ts_cache($ip_serveur, $query_port, $port_serveur)
{
	global $config, $rsql, $ts_cache;
	if(!isset($ts_cache['scanné']))
	{// on n'a pas encore mis les serveurs en cache
		$ts_cache['scanné'] = true;
		$sql = "SELECT * FROM `".$config['prefix']."module_webost_ts` WHERE `ip` = '".$ip_serveur."' AND `port` ='".$port_serveur."'";
		if (! ($get = $rsql->requete_sql($sql, 'TS', 'Mise en cache des serveurs TeamSpeak')) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while($nfo = $rsql->s_array($get))
		{
			$nfo['users'] = pure_var(unserialize($nfo['users']), 'total', true);
			$ts_cache[$nfo['ip'].$nfo['port']] = $nfo;
		}
	}
	
	if(isset($ts_cache[$ip_serveur.$port_serveur]))
	{// ha haaaaa, le serveur est deja en cache, on vérifie si les infos ne sont pas périmée
		if ($config['refresh'] > (time()- $ts_cache[$ip_serveur.$port_serveur]['last_scan']))
		{// il est sufisament jeune, goo
			return $ts_cache[$ip_serveur.$port_serveur];
		}
		else
		{// il faut scanner :-s
			$info = get_info_server ($ip_serveur, $query_port, $port_serveur);
			if ($info != false)
			{
				$tmp_users = scan_ts_server($ip_serveur, $query_port, $port_serveur);
				$sql = "UPDATE `".$config['prefix']."module_webost_ts` SET `query_port` ='".$query_port."', `version` ='".$info['total_server_version']."', `name` ='".$info['server_name']."', `password` ='".$info['server_password']."', `max_user` ='".$info['server_maxusers']."', `country` ='', `mail` ='".$info['isp_adminemail']."',	`url` ='".$info['isp_linkurl']."', `os` ='".$info['server_platform']."', `ispname` ='".$info['isp_ispname']."', `up_time` ='".$info['server_uptime']."', `users` ='".pure_var(serialize(pure_var($tmp_users, 'total', true)), 'del', true)."', `last_scan` ='".time()."' WHERE `ip`='".$ip_serveur."' AND `port`='".$port_serveur."'";
				if (!$rsql->requete_sql($sql, 'TS', 'Actualisation des données relative à un serveur Teamspeak'))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
				 return $ts_cache[$ip_serveur.$port_serveur] = array(
					'id' => time(),
					'last_scan' => time(),
					'ip' => $ip_serveur,
					'port' => $port_serveur,
					'query_port' => $query_port,
					'version' => $info['total_server_version'],
					'up_time' => $info['server_uptime'],
					'name' => $info['server_name'],
					'password' => $info['server_password'],
					'max_user' => $info['server_maxusers'],
					'country' => '',
					'mail' => $info['isp_adminemail'],
					'url' => $info['isp_linkurl'],
					'os' => $info['server_platform'],
					'ispname' => $info['isp_ispname'],
					'users' => pure_var($tmp_users, 'total', true),
				);
			}
			else
			{
				return false;
			}
		}
	}
	else
	{// il n'est pas encore dans la DB, il faut donc créer l'entrée dans la DB
		$info = get_info_server ($ip_serveur, $query_port, $port_serveur);
		if ($info != false)
		{
			$info_clean = pure_var($info, 'del', true);
			$tmp_users = scan_ts_server($ip_serveur, $query_port, $port_serveur);
			$sql = "INSERT INTO `".$config['prefix']."module_webost_ts` (`ip` ,`port`, `query_port` , `version` , `name` , `password` , `max_user` , `country` , `mail` , `url` , `os` , `ispname` , `up_time`, `last_scan`, `users`) VALUES ('".$ip_serveur."', '".$port_serveur."', '".$query_port."', '".$info_clean['total_server_version']."', '".$info_clean['server_name']."', '".$info_clean['server_password']."', '".$info_clean['server_maxusers']."', '', '".$info_clean['isp_adminemail']."', '".$info_clean['isp_linkurl']."', '".$info_clean['server_platform']."', '".$info_clean['isp_ispname']."', '".$info_clean['server_uptime']."', '".time()."', '".pure_var(serialize(pure_var($tmp_users, 'total', true)), 'del', true)."')";
			if (!$rsql->requete_sql($sql, 'TS', 'Ajoute le serveur dans le system de cache'))
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			return $ts_cache[$ip_serveur.$port_serveur] = array(
				'id' => time(),
				'last_scan' => time(),
				'ip' => $ip_serveur,
				'port' => $port_serveur,
				'query_port' => $query_port,
				'version' => $info['total_server_version'],
				'up_time' => $info['server_uptime'],
				'name' => $info['server_name'],
				'password' => $info['server_password'],
				'max_user' => $info['server_maxusers'],
				'country' => '',
				'mail' => $info['isp_adminemail'],
				'url' => $info['isp_linkurl'],
				'os' => $info['server_platform'],
				'ispname' => $info['isp_ispname'],
				'users' => $tmp_users,
			);
		}
		else
		{
			return false;
		}
	}
}

function get_info_server($ip_serveur, $query_port, $port_serveur)
{
	if ($connection = @fsockopen($ip_serveur, $query_port))
	{
		fwrite($connection, 'si '.$port_serveur."\ngi\nquit\n");
		if (trim(fgets($connection, 4096)) == '[TS]')
		{
			while (!feof($connection))
			{
				$get = fgets($connection, 4096);
				if (trim($get) == 'OK')
				{// le serveur dis qu'il a fini
					break;
				}
				$data_tmp = explode('=', $get, 2);
				$server_info[$data_tmp[0]] = $data_tmp[1];
			}
			while (!feof($connection))
			{
				$get = fgets($connection, 4096);
				if (trim($get) == 'OK')
				{// le serveur dis qu'il a fini
					break;
				}
				$data_tmp = explode('=', $get, 2);
				$server_info[$data_tmp[0]] = $data_tmp[1];
			}
			return $server_info;
		}
		return false;
	}
}

function scan_ts_server($ip_serveur, $query_port, $port_serveur)
{
	if ($connection = @fsockopen($ip_serveur, $query_port))
	{
		fwrite($connection, 'cl '.$port_serveur."\npl ".$port_serveur."\nquit\n");
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
		return $channel_data;
	}
	else
	{// le serveur n'a pas répondu
		return false;
	}
}
function decode_user($user_data)
{
	$valeur['visible']['user'] = true;
	if ($user_data['bs'] >= 1048576)
	{
		$user_data['bs']=floor($user_data['bs']/1048576).' Mo';
	}
	if ($user_data['bs'] >= 1024)
	{
		$user_data['bs']=floor($user_data['bs']/1024).' Kb';
	}
	if ($user_data['br'] >= 1048576)
	{
		$user_data['br']=floor($user_data['br']/1048576).' Mo';
	}
	if ($user_data['br'] >= 1024)
	{
		$user_data['br']=floor($user_data['br']/1024).' Kb';
	}
	
	if ($user_data['pflags'] >= 64)
	{
		$user_data['pflags']=$user_data['pflags']-64;
		$valeur['visible']['rec'] = true;
		$valeur['tag_visible']['rec'] = ' Rec';
	}
	if ($user_data['pflags'] >= 32)
	{
		$user_data['pflags']=$user_data['pflags']-32;
		$valeur['visible']['speakers off'] = true;
	}
	if ($user_data['pflags'] >= 16)
	{
		$user_data['pflags']=$user_data['pflags']-16;
		$valeur['visible']['microphone off'] = true;
	}
	if ($user_data['pflags'] >= 8)
	{
		$user_data['pflags']=$user_data['pflags']-8;
		$valeur['visible']['away'] = true;
	}
	if ($user_data['pflags'] >= 4)
	{
		$user_data['pflags']=$user_data['pflags']-4;
		$valeur['non_visible']['block whispers'] = true;
	}
	if ($user_data['pflags'] >= 2)
	{
		$user_data['pflags']=$user_data['pflags']-2;
		$valeur['tag_visible']['request voice'] = ' VW';
	}
	if ($user_data['pflags'] >= 1)
	{
		$user_data['pflags']=$user_data['pflags']-1;
		$valeur['visible']['channel admin'] = true;
	}

	switch ($user_data['pprivs'])
	{
		case 13:
		case 5:
			$valeur['user privs'] = 'R SA';
		break;
		case 4:
			$valeur['user privs'] = 'R';
		break;
		case 0:
			$valeur['user privs'] = 'U';
		break;
	}

	if ($user_data['cprivs'] == 1)
	{
		$valeur['channel privs'] = 'CA';
	}
	
	if (isset($valeur['tag_visible']))
	{
		$nbr = count($valeur['tag_visible']);
		$valeur['tag_user'] = '';
		$i = 0;
		foreach ($valeur['tag_visible'] as $value)
		{
			$i++;
			$valeur['tag_user'] .= $value;
			if ($i != $nbr)
			{
				$valeur['tag_user'] .= ' ';
			}
		}
	}
	else
	{
		$valeur['tag_user'] = '';
	}
	
	// on definit l'icone a afficher
	$user_data['icon'] = 'default';
	if (isset($valeur['visible']['microphone off']))
	{
		$user_data['icon'] = 'mute_mic';
	}
	if (isset($valeur['visible']['speakers off']))
	{
		$user_data['icon'] = 'mute_speaker';
	}
	if (isset($valeur['visible']['channel admin']))
	{
		$user_data['icon'] = 'commander';
	}
	if (isset($valeur['visible']['away']))
	{
		$user_data['icon'] = 'away';
	}
	$user_data['les PV'] = $valeur['user privs'].((isset($valeur['channel privs']))? ' '.$valeur['channel privs'] : '').$valeur['tag_user'];
	return $user_data;
}

function decode_channel($channel_data)
{
	switch($channel_data['flags'])
	{
		case 30:
			$channel_data['flags'] = '(RMPSD)';
		break;
		case 28:
			$channel_data['flags'] = '(RPSD)';
		break;
		case 26:
			$channel_data['flags'] = '(RMSD)';
		break;
		case 24:
			$channel_data['flags'] = '(RSD)';
		break;
		case 22:
			$channel_data['flags'] = '(RMPD)';
		break;
		case 20:
			$channel_data['flags'] = '(RPD)';
		break;
		case 18:
			$channel_data['flags'] = '(RMD)';
		break;
		case 16:
			$channel_data['flags'] = '(RD)';
		break;
		case 15:
			$channel_data['flags'] = '(UMPS)';
		break;
		case 14:
			$channel_data['flags'] = '(RMPS)';
		break;
		case 13:
			$channel_data['flags'] = '(UPS)';
		break;
		case 12:
			$channel_data['flags'] = '(RPS)';
		break;
		case 11:
			$channel_data['flags'] = '(UMS)';
		break;
		case 10:
			$channel_data['flags'] = '(RMS)';
		break;
		case 9:
			$channel_data['flags'] = '(US)';
		break;
		case 8:
			$channel_data['flags'] = '(RS)';
		break;
		case 7:
			$channel_data['flags'] = '(UMP)';
		break;
		case 6:
			$channel_data['flags'] = '(RMP)';
		break;
		case 5:
			$channel_data['flags'] = '(UP)';
		break;
		case 4:
			$channel_data['flags'] = '(RP)';
		break;
		case 3:
			$channel_data['flags'] = '(UM)';
		break;
		case 2:
			$channel_data['flags'] = '(UP)';
		break;
		case 1:
			$channel_data['flags'] = '(U)';
		break;
		case 0:
			$channel_data['flags'] = '(R)';
		break;
		default:
			$channel_data['flags'] = '';
	}

	switch($channel_data['codec'])
	{
		case 0:
			$channel_data['codec'] = 'Celp51';
		break;
		case 1:
			$channel_data['codec'] = 'Celp63';
		break;
		case 2:
			$channel_data['codec'] = 'GSM148';
		break;
		case 3:
			$channel_data['codec'] = 'GSM164';
		break;
		case 4:
			$channel_data['codec'] = 'WindowsCELP52';
		break;
		case 5:
			$channel_data['codec'] = 'SPEEX2150';
		break;
		case 6:
			$channel_data['codec'] = 'SPEEX3950';
		break;
		case 7:
			$channel_data['codec'] = 'SPEEX5950';
		break;
		case 8:
			$channel_data['codec'] = 'SPEEX8000';
		break;
		case 9:
			$channel_data['codec'] = 'SPEEX11000';
		break;
		case 10:
			$channel_data['codec'] = 'SPEEX15000';
		break;
		case 11:
			$channel_data['codec'] = 'SPEEX18200';
		break;
		case 12:
			$channel_data['codec'] = 'SPEEX24600';
		break;
		default:
			$channel_data['codec'] = 'Celp51';
	}
	return $channel_data;
}
?>