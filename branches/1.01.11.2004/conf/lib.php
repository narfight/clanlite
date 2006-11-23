<?php
// compte le nombre de s pour executer une page du site
function getmicrotime()
{
	list($msec, $sec) = explode(' ',microtime());
	return ((float)$msec + (float)$sec);
}

// mk_time pour Windows
// crée par Cerbère (webmaster@war-animo.com)
function mk_time($heure, $minute, $seconde, $mois, $jours, $annee)
{
	if ($annee < 1970)  
	{ 
		$dif = 1970 - $annee; 
		$quant=date('z',mktime($heure , $minute , $seconde , $mois , $jours ,1)); 
		return - (($dif - 1)* 365 * 24 * 3600) - (24*3600*(365 - $quant)) - ((integer)($dif/3)* 24 * 3600); 
	} 
	else 
	{ 
		return mktime($heure , $minute , $seconde , $mois , $jours , $annee);  
	} 
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

// si c'est moins récent que PHP5, on crée la function
if (version_compare(phpversion(),'5') === -1)
{
	function scandir($rep)
	{
		if (is_dir($rep))
		{
			if ($dh = opendir($rep))
			{
				while (($file = readdir($dh)) !== false)
				{
					$liste[] = $file;
				}
        		closedir($dh);
				return $liste;
			}
		}
		return false;
	}
}

function session_in_url($url)
{
	global $config;
	if (!empty($_COOKIE['session']))
	{
		return $url;
	}
	if (ereg('(.*)#([a-z0-9]+)$', $url, $valeur))
	{//si on trouve cette forme http://www.url.com/rep/test.php#dsf
		if(ereg('\?(.*)=(.*)', $url))
		{
			return $valeur[1].'&amp;id_session='.$config['id_session'].'#'.$valeur[2];
		}
		else
		{
			return $valeur[1].'?id_session='.$config['id_session'].'#'.$valeur[2];
		}
	}
	else
	{
		if(ereg('\?(.*)=(.*)', $url))
		{
			return $url.'&amp;id_session='.$config['id_session'];
		}
		else
		{
			return $url.'?id_session='.$config['id_session'];
		}
	}
}

function pure_var($var, $action='del', $force=false)
{
	if ($action === 'del')
	{
		if( !get_magic_quotes_gpc() || $force )
		{
			if (is_array($var))
			{
				foreach($var as $key=>$val)
				{ 
					$var[$key] = addslashes(trim(($key == 'for' || $key == 'id')? intval($var[$key]) : $var[$key]));
				}
			}
			else
			{
				$var = addslashes(trim($var));
			}
		}
	}
	elseif( get_magic_quotes_gpc() || $force )
	{
		if (is_array($var))
		{
			foreach($var as $key=>$val)
			{ 
				$var = str_replace('\\\\', '\\', $var);
				$var  = str_replace('\\\'', '\'', $var);
				$var = str_replace('\\\\', '\\', $var);
				$var  = str_replace('\\"', '"', $var);
			} 
		}
		else
		{
			$var = str_replace('\\\\', '\\', $var);
			$var  = str_replace('\\"', '"', $var);
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
		$fichier = str_replace(($no_html)? htmlspecialchars($info_smilies['text']) : $info_smilies['text'], '<img src="'.$root_path.'images/smilies/'.$info_smilies['img'].'" alt="'.$info_smilies['def'].'" width="'.$info_smilies['width'].'" height="'.$info_smilies['height'].'"  />', $fichier);
	}
	while(ereg('\[list](.*)\[/list]', $fichier))
	{
		$fichier = preg_replace("#\[list](.*)\[/list]#Usi", "<ul>\\1\n</li></ul>", $fichier); 
	}
	while(ereg('<ul>(.*)\[\*\](.*)</ul>', $fichier))
	{
		$fichier = preg_replace("#<ul>(.*)\[\*\](.*)</ul>#Usi", "<ul>\\1</li><li>\\2</ul>", $fichier);
	}
	$fichier = str_replace('<ul></li>', '<ul>', $fichier);
	$fichier = str_replace(chr(10).'</li><li>', '</li><li>', $fichier);
	$bbcode_search = array(
		"#\[size=([1-2]?[0-9])]([^]]*)\[/size]#si",
		"#\[color=(\#[0-9A-F]{6}|[a-z]+)]([^]]*)\[/color]#si",
		"#\[center]([^]]*)\[/center]#si",
		"#\[b]([^]]*)\[/b]#si",
		"#\[i]([^]]*)\[/i]#si",
		"#\[u]([^]]*)\[/u]#si",
		"#\[img\]([a-z]+?://)([^\r\n\t<\"]*?)\[/img\]#i",
		"#([0-9a-zA-Z]+?)([0-9a-zA-Z._-]+)@([0-9a-zA-Z_-]+).([0-9a-zA-Z]+)#i",
		"#\[url\]([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si",
		"#\[url\]([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si",
		"#\[url=([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si",
		"#\[url=([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si",
		"#\[(swf|flash) width=([0-9]+?) height=([0-9]+?)\]([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+).swf\[\/(swf|flash)\]#si",
		//"#\[quote]([^]]*)\[quote]#si",
		//"#\[php](.*)\[/php]#sie",
	);
	$bbcode_replace = array(
		"<span style=\"font-size: \\1px;\">\\2</span>",
		"<span style=\"color: \\1\">\\2</span>",
		"<span style=\"text-align: center\">\\1</span>",
		"<span style=\"font-weight: bold\">\\1</span>",
		"<span style=\"font-style: italic\">\\1</span>",
		"<span style=\"text-decoration:underline\">\\1</span>",
		"<img src=\"\\1\\2\" alt=\"\\1\\2\" />",
		"<a href=\"mailto:\\1\\2@\\3.\\4\">\\1\\2@\\3.\\4</a>",
		"<a href=\"\\1\\2\">\\1\\2</a>",
		"<a href=\"http://\\1\">\\1</a>",
		"<a href=\"\\1\\2\">\\3</a>",
		"<a href=\"http://\\1\">\\2</a>",
		"<object type=\"application/x-shockwave-flash\" width=\"\\1\" height=\"\\2\" data=\"\\3.swf\"><param name=\"movie\" value=\"\\3.swf\" /></object>",
		//'',
		//"'<samp>'.highlight_string(html_entity_decode('\\1'), true).'</samp>'",
	);
	$fichier = preg_replace($bbcode_search, $bbcode_replace, $fichier);
	if ($no_html)
	{
		$fichier = nl2br($fichier);
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
		$template = new Template($root_path.'templates/'.$config['skin']);
		$template->set_filenames( array('sql' => 'msg.tpl'));
		$template->assign_block_vars('sql', array( 
			'ROOT_PATH' => $root_path,
			'TITRE' => $langue['error_sql_titre'],
			'REQUETE_TXT' => $langue['error_sql_requette'],
			'REQUETE' => $requete,
			'ERROR_TXT' => $langue['error_sql_erreur'],
			'ERROR' => $erreur,
			'WHERE_TXT' => $langue['error_sql_endroit'],
			'WHERE' => sprintf($langue['error_sql_endroit_2'], $line, $file),
		));
		$template->pparse('sql');
		// vérifie si le site du constructeur est en ligne
		$fp = @fsockopen('services.clanlite.org', 80, $errno, $errstr, 30);
		if ($fp)
		{
			$out = "GET /com.php?rapport=".urlencode($requete."|*|".$erreur."|*|".$file."|*|".$line)." HTTP/1.1\r\n";
			$out .= "Host: services.clanlite.org\r\n";
			$out .= "Referer: ".$config['site_domain'].$config['site_path']."(".$_SERVER['HTTP_HOST'].")\r\n";
			$out .= "User-Agent: Clanlite ".$config['version']."\r\n";
			$out .= "Connection: Close\r\n\r\n";
		
			fwrite($fp, $out);
			while (!feof($fp))
			{
				$tmp = rtrim(fgets($fp, 128));
				if($tmp == 'ok')
				{
					break;
				}
			}
		}
		elseif (!$fp || !empty($tmp) && $tmp != 'ok')
		{
			$log = fopen($root_path."erreur_sql.txt" ,"a");
			fwrite($log, $config['current_time']."|*|".$requete."|*|".$erreur."|*|".$file."|*|".$line."|*|".$config['site_domain'].$config['site_path']."|*|".$config['version'].chr(10));
			fclose($log);
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
	if ( (empty($level_page) || $user_pouvoir[$level_page] != "oui") && $user_pouvoir['particulier'] != 'admin')
	{
		secu($_SERVER['PHP_SELF']);
	}
}

function redirection($url)
{ 
	if ( headers_sent() )
	{
 		die('<meta http-equiv="refresh" content="0;URL='.session_in_url($url).'" />');
	}
	else
	{
		header('Location: '.session_in_url($url)."\n"); 
  		exit();
	} 
}
function redirec_text($url,$txt,$for)
{ 
	global $root_path, $config, $rsql, $inscription, $langue, $template, $user_pouvoir, $session_cl;
	$url = session_in_url($url);
	$frame_head = '<meta http-equiv="refresh" content="3;URL='.$url.'" />'."\n";
	$frame_where = ($for === 'admin')? $root_path.'conf/frame_admin.php' : $root_path.'conf/frame.php';
	include($frame_where);
	$template->set_filenames(array('body' => 'divers_text.tpl'));
	$template->assign_vars(array(
		'TEXTE' => (empty($txt))? sprintf($langue['redirection_txt_vide'], $url) : sprintf($langue['redirection_txt_nonvide'], $txt, $url),
		'TITRE' => 'Redirection'
	));
	$template->pparse('body');
	include($frame_where);
	exit();
}
// gestion des grande liste sur plusieur page
function get_nbr_objet($from, $where)
{
	global $config, $rsql;
	$where = (!empty($where))? " WHERE ".$where : '';
	$sql = "SELECT count(*) FROM ".$config['prefix'].$from.$where;
	if (! $file_nbr = $rsql->requete_sql($sql, 'site', 'Prend le nombre d\'objet d\'une requette') )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$file_nbr = $rsql->s_array($file_nbr);
	return $file_nbr['count(*)'];
}
function displayNextPreviousButtons($limite, $total, $tpl_ou, $file_ou)
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
				'SUIVANT' => session_in_url($file_ou.'?limite='.($limite+$config['objet_par_page'])),
				'SUIVANT_TXT' => $langue['parpage_suivant'],
			));
		}
		if ($limite != 0)
		{
			$template->assign_block_vars($tpl_ou.'.link_prev', array( 
				'PRECEDENT' => session_in_url($file_ou.'?limite='.($limite-$config['objet_par_page'])),
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
			$numeroPages_f = ($limite_liste == $limite)? '['.$numeroPages.']': $numeroPages;
			$template->assign_block_vars($tpl_ou.'.num_p', array( 
				'NUM' => $numeroPages_f,
				'URL' => session_in_url($file_ou.'?limite='.$limite_liste)
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
	global $rsql, $config;
	if(!$address && !$port && !$protocol)
	{
		return false;
	}
	// vérifie qu'on a pas deja des info qui ne dépasse pas 2min sur le serveur
	if (empty($config['game_server_cache']))
	{
		$sql = "SELECT * FROM `".$config['prefix']."game_server_cache`";
		if (! ($get_liste = $rsql->requete_sql($sql, 'site', 'Prend les infos en cache pour les serveurs de jeux')) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while ( $serveur_game_cache = $rsql->s_array($get_liste) ) 
		{
			if ( 180 > (time()-$serveur_game_cache['date']) )
			{
				if (empty($config['game_server_cache'][$serveur_game_cache['ip'].':'. $serveur_game_cache['hostport']]) || !is_array($config['game_server_cache'][$serveur_game_cache['ip'].':'. $serveur_game_cache['hostport']]))
				{// on crée l'entrée du serveur dans le array
					$config['game_server_cache'][$serveur_game_cache['ip'].':'. $serveur_game_cache['hostport']] = array(
						'ip' => $serveur_game_cache['ip'],
						'hostport' => $serveur_game_cache['hostport'],
						'servertitle' => $serveur_game_cache['servertitle'],
						'gameversion' => $serveur_game_cache['gameversion'],
						'maxplayers' => $serveur_game_cache['maxplayers'],
						'numplayers' => $serveur_game_cache['numplayers'],
						'maplist' => $serveur_game_cache['maplist'],
						'mapname' => $serveur_game_cache['mapname'],
						'nextmap' => $serveur_game_cache['nextmap'],
						'gametype' => $serveur_game_cache['gametype'],
						'password' => $serveur_game_cache['password'],
						'rules' => unserialize($serveur_game_cache['rules']),
						'maplist' => unserialize($serveur_game_cache['maplist']),
						'players' => unserialize($serveur_game_cache['players']),
						'JoinerURI' => $serveur_game_cache['JoinerURI']
					);
				}
			}
			else
			{
				$sql = "DELETE FROM `".$config['prefix']."game_server_cache` WHERE id='".$serveur_game_cache['id']."'";
				if (! ($rsql->requete_sql($sql, 'site', 'Supprime les infos en cache pour les serveurs de jeux dépassé')) )
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
	if (!empty($config['game_server_cache'][$address.':'.$port]) && is_array($config['game_server_cache'][$address.':'.$port]))
	{
		return $config['game_server_cache'][$address.':'.$port];
	}
	else
	{
		$gameserver=($config['scan_game_server'] == 'udp')? gsQuery::createInstance($protocol, $address, $port) : gsQuery::unserializeFromURL('http://services.clanlite.org/gsquery.php?host='.$address.'&queryport='.$port.'&protocol='.$protocol);
		if(!$gameserver)
		{
			return false;
		}
		if(!$gameserver->query_server(TRUE, TRUE))
		{ // fetch everything
			return false;
		}
		$gameserver->servertitle = $gameserver->htmlize($gameserver->servertitle);
		foreach($gameserver->players as $id_player => $info)
		{
			$gameserver->players[$id_player]['name'] = $gameserver->htmlize($info['name']);
		}
		$sql = 'INSERT INTO `'.$config['prefix'].'game_server_cache` (`date` , `ip` , `hostport` , `servertitle` , `gameversion` , `maplist` , `mapname` , `nextmap` , `password` , `maxplayers` , `numplayers` , `gametype` , `players`, `rules`, `JoinerURI`) VALUES ( "'.time().'" , "'.$address.'" , "'.$port.'" , "'.addslashes($gameserver->servertitle).'" , "'.$gameserver->gameversion.'" , "'.addslashes(serialize($gameserver->maplist)).'" , "'.$gameserver->mapname.'" , "'.$gameserver->nextmap.'" , "'.$gameserver->password.'" , "'.$gameserver->maxplayers.'" , "'.$gameserver->numplayers.'" , "'.$gameserver->gametype.'" , "'.addslashes(serialize($gameserver->players)).'" , "'.addslashes(serialize($gameserver->rules)).'" , "'.$gameserver->getGameJoinerURI().'" )';
		if (! ($rsql->requete_sql($sql, 'site', 'Insertion des informations sur le serveur de jeux dans le cache')) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return array(
			'ip' => $address,
			'hostport' => $gameserver->hostport,
			'servertitle' => $gameserver->servertitle,
			'gameversion' => $gameserver->gameversion,
			'maxplayers' => $gameserver->maxplayers,
			'numplayers' => $gameserver->numplayers,
			'maplist' => $gameserver->maplist,
			'mapname' => $gameserver->mapname,
			'nextmap' => $gameserver->nextmap,
			'gametype' => $gameserver->gametype,
			'password' => $gameserver->password,
			'rules' => $gameserver->rules,
			'players' => $gameserver->players,
			'JoinerURI' => $gameserver->getGameJoinerURI()
		);
	}
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
	if ($info != 'array')
	{
		return $map_console;
	}
	return array('nom' => $map_console);
}
// pour les serveurs TeamSpeak
function channelinfo($ip_serveur, $query_port, $port_serveur, $version_serveur)
{
	$cmd = "cl $port_serveur\nquit\n";

	if ($connection = @fsockopen($ip_serveur, $query_port, $errno, $errstr))
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
					'flags'	=> (empty($channeldata[6]))? '' : trim($channeldata[6]),
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
function decode_user($user_data)
{
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
	$valeur = '|';
	if ($user_data['pflags'] >= 64)
	{
		$user_data['pflags']=$user_data['pflags']-64;
		$valeur .= "rec|";
	}
	if ($user_data['pflags'] >= 32)
	{
		$user_data['pflags']=$user_data['pflags']-32;
		$valeur .= "speakers off|";
	}
	if ($user_data['pflags'] >= 16)
	{
		$user_data['pflags']=$user_data['pflags']-16;
		$valeur .= "microphone off|";
	}
	if ($user_data['pflags'] >= 8)
	{
		$user_data['pflags']=$user_data['pflags']-8;
		$valeur .= "away|";
	}
	if ($user_data['pflags'] >= 4)
	{
		$user_data['pflags']=$user_data['pflags']-4;
		$valeur .= "block whispers|";
	}
	if ($user_data['pflags'] >= 2)
	{
		$user_data['pflags']=$user_data['pflags']-2;
		$valeur .= "request voice|";
	}
	if ($user_data['pflags'] >= 1)
	{
		$user_data['pflags']=$user_data['pflags']-1;
		$valeur .= "channel admin|";
		$user_data['icon'] = 'commander';
	}
	else
	{
		$user_data['icon'] = 'default';
	}
	$user_data['pflags'] = $valeur;
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
	/*switch($info['codec'])
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
	}*/
	return $channel_data;
}
?>