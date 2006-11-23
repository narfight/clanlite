<?php
/****************************************************************************
 *	Fichier		: lib.php													*
 *	Copyright	: (C) 2005 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
// compte le nombre de s pour executer une page du site
function getmicrotime()
{
	list($msec, $sec) = explode(' ',microtime());
	return ((float)$msec + (float)$sec);
}

// coupe une chaine de carractére trop longue
function cut_sentence($texte,$nbcar=0)
{
	if (strlen($texte) > $nbcar && 0 != $nbcar)
	{
		$liste = explode(' ', $texte);
		$tmp = '';
		foreach($liste as $value)
		{
			if ( strlen($tmp) >= $nbcar )
			{
				break;
			}
			$tmp .= $value.' ';
		}
		// on supprime le dérnié espace
		$tmp = substr($tmp , 0, strlen($tmp)-1);
		if (count($liste) > 1)
		{
			$tmp .= '...';
		}
	}
	else
	{
		$tmp = $texte;
	}
	return $tmp;
}

// Préparation du tpl de module
function find_module_tpl($file, $split)
{
	global $root_path, $session_cl;
	// on regarde avant dans le TPL si il existe une version perso
	if (file_exists($root_path.'templates/'.$session_cl['skin'].'/modules/'.$file))
	{
		$tpl_repertoire = $root_path.'templates/'.$session_cl['skin'].'/modules/';
	}
	else
	{
		// Sinon, on regarde dans le repertoire module et les sous repertoires
		$url_module_local = $root_path.'/modules/';
		foreach(scandir($url_module_local) as $file_dir)
		{
			if (is_dir($url_module_local.$file_dir))
			{// on scan le sous repertoire
				foreach(scandir($url_module_local.$file_dir) as $file_dir2)
				{
					if ($file_dir2 == $file)
					{
						$tpl_repertoire = $url_module_local.$file_dir;
						break(2);
					}					
				}
			}
			else
			{
				if ($file_dir == $file)
				{
					$tpl_repertoire = $url_module_local;
					break(1);
				}
			}
		}
	}
	if ($split)
	{
		return $tpl_repertoire;
	}
	else
	{
		return $tpl_repertoire.'/'.$file;
	}
}

function module_tpl($file)
{
	// 1er étape, trouver le tpl demandé,
	$tpl_filename = find_module_tpl($file, false);
	// ouverture du TPL
	$file_tpl = fopen($tpl_filename, 'r');
	$tpl = fread($file_tpl, filesize($tpl_filename));
	fclose($file_tpl);
	
	// replace \ with \\ and then ' with \'.
	$tpl = str_replace('\\', '\\\\', $tpl);
	$tpl = str_replace('\'', '\\\'', $tpl);
	
	// strip newlines.
	$tpl = str_replace("\n", '', $tpl);
	
	// Turn template blocks into PHP assignment statements for the values of $match..
	$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
	eval($tpl);
	return $block;
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
	function scandir($dir = './', $sort = 0)
	{
		$dir_open = @opendir($dir);
		if (!$dir_open)
		{
			return false;
		}
		
		while (($dir_content = readdir($dir_open)) !== false)
		{
			$files[] = $dir_content;
		}
		
		if ($sort == 1)
		{
			rsort($files, SORT_STRING);
		}
		else
		{
			sort($files, SORT_STRING);
		}
		return $files;
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

function pure_var($valeur, $action='del', $force=false)
{
	if (!get_magic_quotes_gpc() || $force)
	{// on vérifie qu'il faut le faire ou si on le force
		if ($action === 'del')
		{// on regarde ce qu'on veut faire
			if (is_array($valeur))
			{
				foreach($valeur as $array_id => $array_valeur)
				{
					if (is_array($valeur[$array_id]))
					{
						$valeur[$array_id] = pure_var($valeur[$array_id], $action, $force);
					}
					else
					{
						$valeur[$array_id] = addslashes(trim($valeur[$array_id]));
					}
				}
				return $valeur;
			}
			else
			{
				return addslashes(trim($valeur));
			}
		}
		else
		{
			if (is_array($valeur))
			{
				foreach($valeur as $array_id => $array_valeur)
				{
					if (is_array($valeur[$array_id]))
					{
						$valeur[$array_id] = pure_var($valeur[$array_id], $action, $force);
					}
					else
					{
						$valeur[$array_id] = stripslashes(trim($valeur[$array_id]));
					}
				}
				return $valeur;
			}
			else
			{
				return stripslashes(trim($valeur));
			}
		}
	}
	return $valeur;
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
function bbcode($fichier)
{
	global $config, $root_path, $rsql;
	$fichier = htmlspecialchars($fichier);
	liste_smilies(false);
	//prend les smilies
	foreach($config['smilies_liste'] as $info_smilies)
	{
		$fichier = str_replace(htmlspecialchars($info_smilies['text']), '<img src="'.$root_path.'images/smilies/'.$info_smilies['img'].'" alt="'.$info_smilies['def'].'" width="'.$info_smilies['width'].'" height="'.$info_smilies['height'].'"  />', $fichier);
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
		"#\[center](.*)\[/center]#si",
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
		"#\[video\](([a-z]+?)://([^, \n\r]+))\[/video\]#si"
	);
	
	$bbcode_replace = array(
		"<span style=\"font-size: \\1px;\">\\2</span>",
		"<span style=\"color: \\1\">\\2</span>",
		"<div style=\"text-align: center\">\\1</div>",
		"<strong>\\1</strong>",
		"<span style=\"font-style: italic\">\\1</span>",
		"<span style=\"text-decoration:underline\">\\1</span>",
		"<img src=\"\\1\\2\" alt=\"\\1\\2\" />",
		"<a href=\"mailto:\\1\\2@\\3.\\4\">\\1\\2@\\3.\\4</a>",
		"<a href=\"\\1\\2\">\\1\\2</a>",
		"<a href=\"http://\\1\">\\1</a>",
		"<a href=\"\\1\\2\">\\3</a>",
		"<a href=\"http://\\1\">\\2</a>",
		"<object type=\"application/x-shockwave-flash\" width=\"\\1\" height=\"\\2\" data=\"\\3.swf\"><param name=\"movie\" value=\"\\3.swf\" /></object>",
		"<object type=\"video/x-ms-asf-plugin\" data=\"\\1\" width=\"320\" height=\"320\">\n<param name=\"src\" value=\"\\1\" />\n<param name=\"autoplay\" value=\"false\" />\n<param name=\"loop\" value=\"false\" />\n</object>"
	);
	$fichier = preg_replace($bbcode_search, $bbcode_replace, $fichier);

	return nl2br($fichier);
}

// liste des smilies
function liste_smilies($show, $tpl_ou='', $limite=-1)
{
	global $config, $rsql, $template, $root_path, $langue;
	if (!isset($config['smilies_liste']))
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
	// on fait la liste des smilies ... si il en a !!!
	if (isset($config['smilies_liste']) && is_array($config['smilies_liste']))
	{
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
					'TXT' => addslashes($info_smilies['text']),
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
	}
	return true;
}

// en cas d'erreur sql
function sql_error($requete, $erreur, $line, $file) 
{ 
	global $config, $root_path, $langue, $session_cl;
	if ( $config['raport_error'] == 1 )
	{
		$template = new Template($root_path.'templates/'.$session_cl['skin']);
		$template->set_filenames( array('sql' => 'msg.tpl'));
		$template->assign_block_vars('sql', array( 
			'SKIN' => $session_cl['skin'],
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
			$out = 'GET /com.php?rapport='.urlencode($requete.'|*|'.$erreur.'|*|'.$file.'|*|'.$line)." HTTP/1.1\r\n";
			$out .= "Host: services.clanlite.org\r\n";
			$out .= 'Referer: '.$config['site_domain'].$config['site_path'].'('.$_SERVER['HTTP_HOST'].")\r\n";
			$out .= 'User-Agent: Clanlite '.$config['version']."\r\n";
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
			$log = fopen($root_path.'erreur_sql.txt' ,'a');
			fwrite($log, $config['current_time'].'|*|'.$requete.'|*|'.$erreur.'|*|'.$file.'|*|'.$line.'|*|'.$config['site_domain'].$config['site_path'].'|*|'.$config['version'].chr(10));
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
	global $user_pouvoir, $session_cl;
	if ( (empty($level_page) || $user_pouvoir[$level_page] != 'oui') && $session_cl['pouvoir_particulier'] != 'admin')
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
	$frame_head = '<meta http-equiv="refresh" content="2;URL='.$url.'" />'."\n";
	$frame_where = ($for === 'admin')? $root_path.'conf/frame_admin.php' : $root_path.'conf/frame.php';
	require($frame_where);
	$template->set_filenames(array('body' => 'divers_text.tpl'));
	$template->assign_vars(array(
		'TEXTE' => (empty($txt))? sprintf($langue['redirection_txt_vide'], $url) : sprintf($langue['redirection_txt_nonvide'], $txt, $url),
		'TITRE' => 'Redirection'
	));
	$template->pparse('body');
	require($frame_where);
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

function displayNextPreviousButtons($limite, $total, $tpl_ou, $file_ou, $plus='')
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
				'SUIVANT' => session_in_url($file_ou.'?limite='.($limite+$config['objet_par_page']).$plus),
				'SUIVANT_TXT' => $langue['parpage_suivant'],
			));
		}
		if ($limite != 0)
		{
			$template->assign_block_vars($tpl_ou.'.link_prev', array( 
				'PRECEDENT' => session_in_url($file_ou.'?limite='.($limite-$config['objet_par_page']).$plus),
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
				'URL' => session_in_url($file_ou.'?limite='.$limite_liste.$plus)
			));
			$limite_liste = $limite_liste + $config['objet_par_page'];
			$numeroPages = $numeroPages + 1;
			$compteurPages = $compteurPages + 1;
		}
	}
}

// scan serveur de jeux
function queryServer($address, $port, $protocol, $id_serveur=0)
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
			if ( $config['refresh'] > (time()-$serveur_game_cache['date']) )
			{
				if (empty($config['game_server_cache'][$serveur_game_cache['ip'].':'. $serveur_game_cache['hostport']]) || !is_array($config['game_server_cache'][$serveur_game_cache['ip'].':'. $serveur_game_cache['hostport']]))
				{// on crée l'entrée du serveur dans le array
					$config['game_server_cache'][$serveur_game_cache['ip'].':'. $serveur_game_cache['hostport']] = array(
						'ip' => $serveur_game_cache['ip'],
						'id_serveur' => $serveur_game_cache['id_serveur'],
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
				// l'information est trop vielle, on la supprime
				$sql = "DELETE FROM `".$config['prefix']."game_server_cache` WHERE id='".$serveur_game_cache['id']."'";
				if (! ($rsql->requete_sql($sql, 'site', 'Supprime les infos en cache pour les serveurs de jeux dépassé')) )
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
	// on regarde si le serveur demandé etait en cache
	if (!empty($config['game_server_cache'][$address.':'.$port]) && is_array($config['game_server_cache'][$address.':'.$port]))
	{
		// oui, alors, on le retourne
		return $config['game_server_cache'][$address.':'.$port];
	}
	else
	{
		// non, on le scanne et on le sauvegarde
		// on vérifie si on scan direct ou par un relay
		if ($config['scan_game_server'] == 'udp')
		{
			$gameserver = gsQuery::createInstance($protocol, $address, $port);
			if($gameserver && !$gameserver->query_server(TRUE, TRUE))
			{ // fetch everything
				return false;
			}
		}
		else
		{
			$gameserver = gsQuery::unserializeFromURL('http://services.clanlite.org/gsquery.php?host='.$address.'&queryport='.$port.'&protocol='.$protocol);
		}
		
		if(!$gameserver)
		{
			return false;
		}

		$gameserver->servertitle = $gameserver->htmlize($gameserver->servertitle);
		foreach($gameserver->players as $id_player => $info)
		{
			$gameserver->players[$id_player]['name'] = $gameserver->htmlize($info['name']);
		}
		$sql = 'INSERT INTO `'.$config['prefix'].'game_server_cache` (`id_serveur`, `date` , `ip` , `hostport` , `servertitle` , `gameversion` , `maplist` , `mapname` , `nextmap` , `password` , `maxplayers` , `numplayers` , `gametype` , `players`, `rules`, `JoinerURI`) VALUES ( "'.$id_serveur.'", "'.time().'" , "'.$address.'" , "'.$port.'" , "'.addslashes($gameserver->servertitle).'" , "'.$gameserver->gameversion.'" , "'.addslashes(serialize($gameserver->maplist)).'" , "'.$gameserver->mapname.'" , "'.$gameserver->nextmap.'" , "'.$gameserver->password.'" , "'.$gameserver->maxplayers.'" , "'.$gameserver->numplayers.'" , "'.$gameserver->gametype.'" , "'.addslashes(serialize($gameserver->players)).'" , "'.addslashes(serialize($gameserver->rules)).'" , "'.$gameserver->getGameJoinerURI().'" )';
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
function scan_map($map_console='', $info='array')
{
	//array = retourne le nom dans la map qu'on a trouvé avec $map_console dans un array
	//nom = retourne que le nom de la map qu'on a trouvé avec $map_console
	
	//Si $map_console est vide, on retourne toute la varriables $config['map_liste'] (systeme de cache)
	
	global $config, $rsql;
	if (empty($config['map_liste']))
	{// il n'a pas encore de cache, on le fait
		$sql = 'SELECT * FROM `'.$config['prefix'].'server_map`';
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
		if ($rsql->nbr($map_liste) == 0)
		{// on definit quand même la variable pour eviter de faire des recherches en boucle
			$config['map_liste'][0] = false;
		}
	}
	else
	{
		reset($config['map_liste']);
	}
	
	if (!empty($config['map_liste']) && is_array($config['map_liste']))
	{
		if ($map_console != '')
		{
			foreach($config['map_liste'] as $tmp_map)
			{
				if (!empty($map_console) && ereg($map_console, $tmp_map['console']))
				{
					if ($info == 'nom')
					{
						return $tmp_map[$info];
					}
					else
					{
						return $tmp_map;
					}
				}
			}
		}
	}
	else
	{// Erreur, rien à analyser
		return false;
	}
	
	if ($info == 'nom')
	{
		return $map_console;
	}
	elseif ($map_console == '')
	{
		return $config['map_liste'];
	}
	elseif ($info == 'array')
	{
		return array('nom' => $map_console);
	}
}
?>