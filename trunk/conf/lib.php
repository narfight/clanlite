<?php
// compte le nombre de s pour executer une page du site
function getmicrotime()
{  
	list($msec, $sec) = explode(" ",microtime());  
	return ((float)$msec + (float)$sec); 
}

//Prend les IP dans tout les cas
function get_ip()
{
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if(isset($_SERVER['HTTP_CLIENT_IP']))
	{
        return $_SERVER['HTTP_CLIENT_IP'];
    }
	return $_SERVER['REMOTE_ADDR'];
}

// décode les info des sessions (tres basic)
function pure_var($var, $action='del')
{
	if ($action == 'del')
	{
		if( !get_magic_quotes_gpc() )
		{
			if (is_array($var))
			{
				foreach($var as $key=>$val)
				{ 
					$var[$key] = addslashes($var[$key]);
				}
			}
			else
			{
				$var = addslashes($var);
			}
		}
	}
	elseif( get_magic_quotes_gpc() )
	{
		if (is_array($var))
		{
			foreach($var as $key=>$val)
			{ 
				$var = str_replace('\\\\', '\\', $var);
				$var  = str_replace('\\\'', '\'', $var);
			} 
		}
		else
		{
			$var = addslashes($var);
		}
	}
	return $var;
}
// envoyer un message
function msg($type, $texte)
{
	global $config, $root_path, $langue, $template;
	$template->set_filenames( array('cadre' => 'msg.tpl'));
	$template->assign_block_vars('msg', array( 
		'TYPE' => $type,
		'TEXTE'  => $texte,
		'ROOT_PATH' => $root_path,
	));
	$template->pparse('cadre');
}
// bbcode pour les mail et les url
function bbcode($fichier, $no_html=true)
{
	global $config, $root_path, $rsql;
	$fichier = ($no_html)? htmlspecialchars($fichier) : $fichier;
	liste_smilies(false);
	//prend les smilies
	foreach($config['smilies_liste'] as $info_smilies)
	{
		$fichier = str_replace(($no_html)? htmlspecialchars($info_smilies['text']) : $info_smilies['text'], "<img src=\"".$root_path."images/smilies/".$info_smilies['img']."\" alt=\"".$info_smilies['def']."\" width=\"".$info_smilies['width']."\" height=\"".$info_smilies['height']."\"  />", $fichier);
	}
	$bbcode_search = array(
		"#\[size=([1-2]?[0-9])]([^]]*)\[/size]#si",
		"#\[color=(\#[0-9A-F]{6}|[a-z]+)]([^]]*)\[/color]#si",
		"#\[center]([^]]*)\[/center]#si",
		"#\[b]([^]]*)\[/b]#si",
		"#\[i]([^]]*)\[/i]#si",
		"#\[u]([^]]*)\[/u]#si",
		"#\[img\]([a-z]+?://)([^\r\n\t<\"]*?)\[/img\]#i",
		"#([0-9a-zA-Z]+?)([0-9a-zA-Z._-]+)@([0-9a-zA-Z._-]+)#i",
		"#\[url\]([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si",
		"#\[url\]([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si",
		"#\[url=([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si",
		"#\[url=([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si"
	);
	$bbcode_replace = array(
		"<span style=\"font-size: \\1px;\">\\2</span>",
		"<span style=\"color: \\1\">\\2</span>",
		"<span style=\"text-align: center\">\\1</span>",
		"<span style=\"font-weight: bold\">\\1</span>",
		"<span style=\"font-style: italic\">\\1</span>",
		"<span style=\"text-decoration:underline\">\\1</span>",
		"<img src=\"\\1\\2\" alt=\"\\1\\2\" />",
		"<a href=\"mailto:\\1\\2@\\3\\4\">\\1\\2@\\3\\4</a>",
		"<a href=\"\\1\\2\" onclick=\"window.open('\\1\\2\');return false;\">\\1\\2</a>",
		"<a href=\"http://\\1\" onclick=\"window.open('http://\\1');return false;\">\\1</a>",
		"<a href=\"\\1\\2\" onclick=\"window.open('\\1\\2');return false;\">\\3</a>",
		"<a href=\"http://\\1\" onclick=\"window.open('http://\\1\');return false;\">\\2</a>"
	);
	$fichier = preg_replace($bbcode_search, $bbcode_replace, $fichier);
	while(ereg('\[list](.*)\[/list]', $fichier))
	{
		$fichier = preg_replace("#\[list](.*)\[/list]#Usi", "<ul>\\1</ul>", $fichier); 
	}
	while(ereg('<ul>(.*)\[\*\](.*)</ul>', $fichier))
	{
		$fichier = preg_replace("#<ul>(.*)\[\*\](.*)</ul>#Usi", "<ul>\\1<li>\\2</li></ul>", $fichier);
	}
	return $fichier;
}

// liste des smilies
function liste_smilies($show, $tpl_ou='', $limite=-1)
{
	global $config, $rsql,$template,$root_path,$langue;
	if (empty($config['smilies_liste']))
	{
		$sql = "SELECT * FROM `".$config['prefix']."smilies`";
		if (! ($get = $rsql->requete_sql($sql, 'site', 'Liste les smilies')) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while ( $nfo_smilies = $rsql->s_array($get) ) 
		{
			$config['smilies_liste'][$nfo_smilies['id']] = $nfo_smilies;
		}
	}
	else
	{
		reset($config['smilies_liste']);
	}
	if (!$show)
	{
		return true;
	}
	foreach($config['smilies_liste'] as $info_smilies)
	{
		$smilies_unique[$info_smilies['img']] = $info_smilies;
	}
	$nombre = 0;
	foreach($smilies_unique as $info_smilies)
	{
		if ($limite == 1 || $limite > $nombre)
		{
			$template->assign_block_vars($tpl_ou.'poste_smilies_liste', array( 
				'TXT' => pure_var($info_smilies['text']),
				'IMG' => $root_path.'images/smilies/'.$info_smilies['img'],
				'ALT' => $info_smilies['def'],
				'WIDTH' => $info_smilies['width'],
				'HEIGHT' => $info_smilies['height'],
			));
		}
		else
		{
			if ($limite == $nombre)
			{
				$template->assign_block_vars($tpl_ou.'poste_smilies_liste.more', array('MORE_SMILIES' => $langue['show/hide_smilies']));
			}
			$template->assign_block_vars($tpl_ou.'poste_smilies_liste.more.liste', array( 
				'TXT' => addslashes($info_smilies['text']),
				'IMG' => $root_path.'images/smilies/'.$info_smilies['img'],
				'ALT' => $info_smilies['def'],
				'WIDTH' => $info_smilies['width'],
				'HEIGHT' => $info_smilies['height'],
			));
		}
		$nombre++;
	}
	return true;
}

// en cas d'erreur sql
function sql_error($requete, $erreur, $line, $file) 
{ 
	global $config, $root_path, $langue;
	if ( $config['raport_error'] == 1 )
	{
		$template = new Template($root_path."templates/".$config['skin']);
		$template->set_filenames( array('sql' => 'msg.tpl'));
		$template->assign_block_vars('sql', array( 
			'ROOT_PATH' => $root_path,
			'TITRE' => $langue['error_sql_titre'],
			'REQUETE_TXT' => $langue['error_sql_requette'],
			'REQUETE' => $requete,
			'ERROR_TXT' => $langue['error_sql_erreur'],
			'ERROR'  => $erreur,
			'WHERE_TXT' => $langue['error_sql_endroit'],
			'WHERE' => printf($langue['error_sql_endroit_2'], $line, $file),
		));
		$template->pparse('sql');
		// on va ajouter une ligne dans le fichier erreur_sql.txt
		$rapport = $config['current_time']."|*|".$requete."|*|".$erreur."|*|".$file."|*|".$line."|*|".$config['site_domain'].$config['site_path']."|*|".$config['version'];
		// vérifie si le site du constructeur est en ligne
		$var = "http://europubliweb.com/born-to-up/serveur_central/com.php";
		$file = @fopen($var, "r");
		if ($file)
		{ 
			fclose($file); 
			// on envois le rapport
			$reponce = file ($var."?rapport=".urlencode($rapport));
		}	
		// si le site pas en ligne ou erreur
		if ($reponce[0] != "ok" || !$file)
		{
			$log = fopen($root_path."erreur_sql.txt" ,"a+"); // Ouvre en lecture et écriture; place le pointeur de fichier à la fin du fichier. Si le fichier n'existe pas, on tente de le créer. 
			fwrite($log, $rapport." ".chr(10)); // on ajoute la ligne de code
			fclose($log); // on ferme le fichier
		}
	}
} 

// erreur de sécuritée
function secu($goto)
{
	global $root_path;
	redirection($root_path.'admin.php?erreur=secu&goto='.$goto);
	exit;
}
function secu_level_test($level_page)
{
	global $config, $root_path, $user_pouvoir, $langue;
	if ( (empty($level_page) || $user_pouvoir[$level_page] != "oui") && $user_pouvoir['particulier'] != "admin")
	{
		secu($_SERVER['PHP_SELF']);
	}
}

function redirection($url)
{ 
	if ( headers_sent() )
	{
 		die('<meta http-equiv="refresh" content="0;URL='.$url.'" />');
	}
	else
	{
		header("Location: $url\n"); 
  		exit();
	} 
}
function redirec_text($url,$txt,$for)
{ 
	global $root_path, $config, $rsql, $inscription, $langue, $template, $user_pouvoir, $session_cl;
	$frame_head = '
		<meta http-equiv="refresh" content="3;URL='.$url.'" />';
	$frame_where = ($for == "admin")? $root_path."conf/frame_admin.php" : $root_path."conf/frame.php";
	include($frame_where);
	$template->set_filenames(array('body' => 'divers_text.tpl'));
	$template->assign_vars(array(
		'TEXTE' => (empty($txt))? sprintf($langue['redirection_txt_vide'], $url) : sprintf($langue['redirection_txt_nonvide'], $txt, $url),
		'TITRE' => "Redirection"
	));
	$template->pparse('body');
	include($frame_where);
	exit();
}
// gestion des grande liste sur plusieur page
function get_nbr_objet($from, $where)
{
	global $config, $rsql;
	$where = (!empty($where))? " WHERE ".$where : "";
	$sql = "SELECT count(*) FROM ".$config['prefix'].$from.$where;
	if (! $file_nbr = $rsql->requete_sql($sql, 'site', 'Prend le nombre d\'objet d\'une requette') )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$file_nbr = $rsql->s_array($file_nbr);
	return $file_nbr['count(*)'];
}
function displayNextPreviousButtons($limite,$total,$tpl_ou)
{
	global $template, $config, $langue;
	if ($config['objet_par_page'] < $total && $config['objet_par_page'] != 0)
	{
		// je verifie si limite est un nombre.
		if( !is_numeric($limite) || $limite <0 || $limite > $total || (($limite%$config['objet_par_page'])!=0) )
		{// la limite n'est pas bonne, on le redéfini en 0
			$limite = 0;
		}    
		$template->assign_block_vars($tpl_ou, array('vide','vide'));
		// on affiche les bouttons
		if (($limite + $config['objet_par_page']) < $total)
		{
			$template->assign_block_vars($tpl_ou.'.link_next', array( 
				'SUIVANT' => $limite+$config['objet_par_page'],
				'SUIVANT_TXT' => $langue['parpage_suivant'],
			));
		}
		if ($limite != 0)
		{
			$template->assign_block_vars($tpl_ou.'.link_prev', array( 
				'PRECEDENT' => $limite-$config['objet_par_page'],
				'PRECEDENT_TXT' => $langue['parpage_precedent'],
			));
		}
		// affiche les numérros
		$nbpages= ceil($total/$config['objet_par_page']);
		$numeroPages = 1;
		$compteurPages = 1;
		$limite_liste  = 0;
		while($numeroPages <= $nbpages)
		{
			$numeroPages_f = ($limite_liste == $limite)? "[".$numeroPages."]": $numeroPages;
			$template->assign_block_vars($tpl_ou.'.num_p', array( 
				'NUM' => $numeroPages_f,
				'URL' => "limite=".$limite_liste
			));
			$limite_liste = $limite_liste + $config['objet_par_page'];
			$numeroPages = $numeroPages + 1;
			$compteurPages = $compteurPages + 1;
		}
	}
}
// scan serveur de jeux
function queryServer($address, $port, $protocol)
{
	if(!$address && !$port && !$protocol)
	{
		return FALSE;
	}
	$gameserver=gsQuery::createInstance($protocol, $address, $port);
	if(!$gameserver)
	{
		return FALSE;
	}
	if(!$gameserver->query_server(TRUE, TRUE))
	{ // fetch everything
	    return FALSE;
	}
	return $gameserver;
}
// liste des maps
function scan_map($map_console, $info='array')
{
	global $config, $rsql;
	if (empty($config['map_liste']))
	{
		$sql = "SELECT * FROM `".$config['prefix']."server_map`";
		if (! ($map_liste = $rsql->requete_sql($sql, 'site', 'Liste les maps')) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while ( $map_info = $rsql->s_array($map_liste) ) 
		{
			$config['map_liste'][$map_info['id']] = array(
				'nom' => $map_info['nom'],
				'console' => $map_info['nom_console'],
				'url' => $map_info['url']
			);
		}
	}
	else
	{
		reset($config['map_liste']);
	}
	if (!empty($config['map_liste']) && is_array($config['map_liste']))
	{
		foreach($config['map_liste'] as $tmp_map)
		{
			if (!empty($map_console) && ereg($map_console, $tmp_map['console']))
			{
				if ($info != 'array')
				{
					return $tmp_map[$info];
				}
				return $tmp_map;
			}
		}
	}
	return $map_console;
}
// pour les serveurs TeamSpeak
function channelinfo($ip_serveur, $query_port, $port_serveur, $version_serveur)
{
	$cmd = "cl $port_serveur\nquit\n";

	if ($connection = @fsockopen($ip_serveur, $query_port, &$errno, &$errstr))
	{
		fputs($connection,$cmd, strlen($cmd));
		while($channeldata = fgets($connection, 4096))
		{
			$channeldata = explode("	", $channeldata);
			if (is_numeric($channeldata[0]))
			{
				$channel_data[trim($channeldata[0])] = array(
					'codec'		=> (empty($channeldata[1]))? '' : trim($channeldata[1]),
					'parent'	=> (empty($channeldata[2]))? '' : trim($channeldata[2]),
					'order'		=> (empty($channeldata[3]))? '' : trim($channeldata[3]),
					'maxuser'	=> (empty($channeldata[4]))? '' : trim($channeldata[4]),
					'name'		=> ($version_serveur >= '201936')? addslashes(substr(substr((empty($channeldata[5]))? '' : trim($channeldata[5]), 1), 0, -1)) : addslashes((empty($channeldata[5]))? '' : trim($channeldata[5])),
					'topic'		=> ($version_serveur >= '201936')? addslashes(substr(substr((empty($channeldata[8]))? '' : trim($channeldata[8]), 1), 0, -1)) : addslashes((empty($channeldata[8]))? '' : trim($channeldata[8])),
					'channelflags'	=> (empty($channeldata[6]))? '' : trim($channeldata[6]),
					'priv/pub'	=> (empty($channeldata[7]))? '' : trim($channeldata[7]),
				);
			}
		}
		return $channel_data;
		fclose($connection);
	}
	else
	{
		echo "Cannot connect: ($errno)-$errstr<br>";
	}
}
function userinfo($ip_serveur, $query_port, $port_serveur, $version_serveur)
{
	$cmd = "pl $port_serveur\nquit\n";

	if ($connection = @fsockopen($ip_serveur, $query_port, &$errno, &$errstr))
	{
		fputs($connection,$cmd, strlen($cmd));
		while($userdata = fgets($connection, 4096))
		{
			$userdata = explode("	", $userdata);
			if (is_numeric($userdata[0]))
			{
				$user_data[trim($userdata[0])] = array(
					'pl_channelid'		=> (empty($userdata[1]))? '' : trim($userdata[1]),
					'pl_pktssend'		=> (empty($userdata[2]))? '' : trim($userdata[2]),
					'pl_bytessend'		=> (empty($userdata[3]))? '' : trim($userdata[3]),
					'pl_pktsrecv'		=> (empty($userdata[4]))? '' : trim($userdata[4]),
					'pl_bytesrecv'		=> (empty($userdata[5]))? '' : trim($userdata[5]),
					'pl_pktloss'		=> (empty($userdata[6]))? '' : trim($userdata[6]),
					'pl_ping'			=> (empty($userdata[7]))? '' : trim($userdata[7]),
					'pl_logintime'		=> (empty($userdata[8]))? '' : trim($userdata[8]),
					'pl_idletime'		=> (empty($userdata[9]))? '' : trim($userdata[9]),
					'pl_channelprivileges'	=> (empty($userdata[10]))? '' : trim($userdata[10]),
					'pl_playerprivileges'	=> (empty($userdata[11]))? '' : trim($userdata[11]),
					'pl_playerflags'	=> (empty($userdata[12]))? '' : trim($userdata[12]),
					'pl_ipaddress'		=> (empty($userdata[13]))? '' : trim($userdata[13]),
					'pl_nickname'		=> ($version_serveur >= '201936')? addslashes(substr(substr((empty($userdata[14]))? '' : trim($userdata[14]), 1), 0, -1)) : addslashes((empty($userdata[14]))? '' : trim($userdata[14])),
					'pl_loginname'		=> ($version_serveur >= '201936')? addslashes(substr(substr((empty($userdata[15]))? '' : trim($userdata[15]), 1), 0, -1)) : addslashes((empty($userdata[15]))? '' : trim($userdata[15])),
				);
			}
		}
		fclose($connection);
		return $user_data;
	}
	else
	{
		echo "Cannot connect: ($errno)-$errstr<br>";
	}
}
function decode_user($user_data)
{
	foreach($user_data as $id => $info)
	{
		if ($user_data[$id]['pl_bytessend'] >= 1048576)
		{
			$user_data[$id]['pl_bytessend']=floor($user_data[$id]['pl_bytessend']/1048576).' Mo';
		}
		if ($user_data[$id]['pl_bytessend'] >= 1024)
		{
			$user_data[$id]['pl_bytessend']=floor($user_data[$id]['pl_bytessend']/1024).' Kb';
		}
		if ($user_data[$id]['pl_bytesrecv'] >= 1048576)
		{
			$user_data[$id]['pl_bytesrecv']=floor($user_data[$id]['pl_bytesrecv']/1048576).' Mo';
		}
		if ($user_data[$id]['pl_bytesrecv'] >= 1024)
		{
			$user_data[$id]['pl_bytesrecv']=floor($user_data[$id]['pl_bytesrecv']/1024).' Kb';
		}
		$valeur = '|';
		if ($info['pl_playerflags'] >= 64)
		{
			$info['pl_playerflags']=$info['pl_playerflags']-64;
			$valeur .= "rec|";
		}
		if ($info['pl_playerflags'] >= 32)
		{
			$info['pl_playerflags']=$info['pl_playerflags']-32;
			$valeur .= "speakers off|";
		}
		if ($info['pl_playerflags'] >= 16)
		{
			$info['pl_playerflags']=$info['pl_playerflags']-16;
			$valeur .= "microphone off|";
		}
		if ($info['pl_playerflags'] >= 8)
		{
			$info['pl_playerflags']=$info['pl_playerflags']-8;
			$valeur .= "away|";
		}
		if ($info['pl_playerflags'] >= 4)
		{
			$info['pl_playerflags']=$info['pl_playerflags']-4;
			$valeur .= "block whispers|";
		}
		if ($info['pl_playerflags'] >= 2)
		{
			$info['pl_playerflags']=$info['pl_playerflags']-2;
			$valeur .= "request voice|";
		}
		if ($info['pl_playerflags'] >= 1)
		{
			$info['pl_playerflags']=$info['pl_playerflags']-1;
			$valeur .= "channel admin|";
		}
		$user_data[$id]['pl_playerflags'] = $valeur;
	}
	return $user_data;
}
function decode_channel($channel_data)
{
	if (!is_array($channel_data))
	{
		return $channel_data;
	}
	foreach($channel_data as $id => $info)
	{
		switch($info['channelflags'])
		{
			case 30:
				$channel_data[$id]['channelflags'] = "(RMPSD)";
			break;
			case 28:
				$channel_data[$id]['channelflags'] = "(RPSD)";
			break;
			case 26:
				$channel_data[$id]['channelflags'] = "(RMSD)";
			break;
			case 24:
				$channel_data[$id]['channelflags'] = "(RSD)";
			break;
			case 22:
				$channel_data[$id]['channelflags'] = "(RMPD)";
			break;
			case 20:
				$channel_data[$id]['channelflags'] = "(RPD)";
			break;
			case 18:
				$channel_data[$id]['channelflags'] = "(RMD)";
			break;
			case 16:
				$channel_data[$id]['channelflags'] = "(RD)";
			break;
			case 15:
				$channel_data[$id]['channelflags'] = "(UMPS)";
			break;
			case 14:
				$channel_data[$id]['channelflags'] = "(RMPS)";
			break;
			case 13:
				$channel_data[$id]['channelflags'] = "(UPS)";
			break;
			case 12:
				$channel_data[$id]['channelflags'] = "(RPS)";
			break;
			case 11:
				$channel_data[$id]['channelflags'] = "(UMS)";
			break;
			case 10:
				$channel_data[$id]['channelflags'] = "(RMS)";
			break;
			case 9:
				$channel_data[$id]['channelflags'] = "(US)";
			break;
			case 8:
				$channel_data[$id]['channelflags'] = "(RS)";
			break;
			case 7:
				$channel_data[$id]['channelflags'] = "(UMP)";
			break;
			case 6:
				$channel_data[$id]['channelflags'] = "(RMP)";
			break;
			case 5:
				$channel_data[$id]['channelflags'] = "(UP)";
			break;
			case 4:
				$channel_data[$id]['channelflags'] = "(RP)";
			break;
			case 3:
				$channel_data[$id]['channelflags'] = "(UM)";
			break;
			case 2:
				$channel_data[$id]['channelflags'] = "(UP)";
			break;
			case 1:
				$channel_data[$id]['channelflags'] = "(U)";
			break;
			case 0:
				$channel_data[$id]['channelflags'] = "(R)";
			break;
			default:
				$channel_data[$id]['channelflags'] = "";
		}
		switch($info['codec'])
		{
			case 0:
				$channel_data[$id]['codec'] = "Celp51";
			break;
			case 1:
				$channel_data[$id]['codec'] = "Celp63";
			break;
			case 2:
				$channel_data[$id]['codec'] = "GSM148";
			break;
			case 3:
				$channel_data[$id]['codec'] = "GSM164";
			break;
			case 4:
				$channel_data[$id]['codec'] = "WindowsCELP52";
			break;
			case 5:
				$channel_data[$id]['codec'] = "SPEEX2150";
			break;
			case 6:
				$channel_data[$id]['codec'] = "SPEEX3950";
			break;
			case 7:
				$channel_data[$id]['codec'] = "SPEEX5950";
			break;
			case 8:
				$channel_data[$id]['codec'] = "SPEEX8000";
			break;
			case 9:
				$channel_data[$id]['codec'] = "SPEEX11000";
			break;
			case 10:
				$channel_data[$id]['codec'] = "SPEEX15000";
			break;
			case 11:
				$channel_data[$id]['codec'] = "SPEEX18200";
			break;
			case 12:
				$channel_data[$id]['codec'] = "SPEEX24600";
			break;
			default:
				$channel_data[$id]['codec'] = "Celp51";
		}
	}
	return $channel_data;
}
function show_serveur($channel_data, $user_data)
{
	foreach($channel_data as $id_channel => $info_channel)
	{
		if ($info_channel['parent'] == -1)
		{
			echo "* Channel : ".$info_channel['name']."<br />\n";
			// cherche les connecté dans le channel
			foreach($user_data as $id_user => $info_user)
			{
				if ($id_channel == $info_user['pl_channelid'])
				{
					echo "---* User : ".$info_user['pl_nickname']."<br />\n";
				}
			}
			foreach($channel_data as $id_sub_channel => $info_sub_channel)
			{
				if ($info_sub_channel['parent'] == $id_channel)
				{
					echo "---* Sub Channel : ".$info_sub_channel['name']."<br />\n";
					foreach($user_data as $id_user => $info_user)
					{
						if ($id_sub_channel == $info_user['pl_channelid'])
						{
							echo "------* User : ".$info_user['pl_nickname']."<br />\n";
						}
					}
				}
			}
			// regarde si il a des subchannel
		}
	}
	echo "\n</ul>";
}
?>