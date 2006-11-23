<?
// compte le nombre de s pour executer une page du site
function getmicrotime()
{  
	list($msec, $sec) = explode(" ",microtime());  
	return ((float)$msec + (float)$sec); 
}
// décode les info des sessions (tres basic)
function pure_var($var, $action='del')
{
	if ($action == 'del')
	{
		if( !get_magic_quotes_gpc() )
		{
			foreach($var as $key=>$val)
			{ 
				$var[$key] = addslashes($var[$key]);
			} 
		}
	}
	elseif( get_magic_quotes_gpc() )
	{
		foreach($var as $key=>$val)
		{ 
			$var = str_replace('\\\\', '\\', $var);
			$var  = str_replace('\\\'', '\'', $var);
		} 
	}
	return $var;
}
function decode_session($var)
{
	foreach(explode(";", $var) as $key=>$val)
	{
		$tmp = explode("|s:", $val);
		$tmp[1] = preg_replace("#([^]]*)\:\"#si","", $tmp[1]);
		$tmp[1] = preg_replace("/\"$/","", $tmp[1]);
		$et2[$tmp[0]] = $tmp[1];
	} 
	return $et2;
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
	global $config, $root_path, $rsql, $smilies_liste;
	$fichier = htmlspecialchars($fichier);
	// les smilies
	if( !is_array($smilies_liste) || count($smilies_liste) == 0 )
	{
		$sql = "SELECT * FROM ".$config['prefix']."smilies ORDER BY `id` ASC";
		if (! ($get = $rsql->requete_sql($sql, 'site', 'prend la liste des smilies et les stockes')) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$nombre = 0;
		while ($nfo_smilies = $rsql->s_array($get))
		{
			$nombre++;
			$smilies_liste[$nombre] = $nfo_smilies;
		}
	}
	//prend les smilies
		$nombre = 0;
		while ($nombre < count($smilies_liste))
		{
			$nombre++;
			$fichier = str_replace(htmlspecialchars($smilies_liste[$nombre]['text']), "<img src=\"".$root_path."images/smilies/".$smilies_liste[$nombre]['img']."\" alt=\"".$smilies_liste[$nombre]['def']."\" width=\"".$smilies_liste[$nombre]['width']."\" height=\"".$smilies_liste[$nombre]['height']."\" border=\"0\">", $fichier);
		}
	// taille du texte
	$fichier = preg_replace("#\[size=([1-2]?[0-9])]([^]]*)\[/size]#si", "<span style=\"font-size: \\1px;\">\\2</span>", $fichier);
	// colorer du texte
	$fichier = preg_replace("#\[color=(\#[0-9A-F]{6}|[a-z]+)]([^]]*)\[/color]#si", "<span style=\"color: \\1\">\\2</span>", $fichier); 
	// centrer
	$fichier = preg_replace("#\[center]([^]]*)\[/center]#si", "<center>\\1</center>", $fichier); 
	// gras ([b]texte[/b])
	$fichier = preg_replace("#\[b]([^]]*)\[/b]#si", "<b>\\1</b>", $fichier); 
	// italique
	$fichier = preg_replace("#\[i]([^]]*)\[/i]#si", "<i>\\1</i>", $fichier); 
	// soulignier
	$fichier = preg_replace("#\[u]([^]]*)\[/u]#si", "<u>\\1</u>", $fichier); 
	// image
	$fichier = preg_replace("#\[img\]([a-z]+?://)([^\r\n\t<\"]*?)\[/img\]#ie", "'<img src=\\1\\2 alt=\"\\1\\2\">'", $fichier);
	// pour les e-mail
	$fichier = preg_replace("#([0-9a-zA-Z]+?)([0-9a-zA-Z._-]+)@([0-9a-zA-Z._-]+)#i","<a href=\"mailto:\\1\\2@\\3\\4\" onclick=\"window.open('mailto:\\1\\2@\\3\\4');return false;\">\\1\\2@\\3\\4</a>", $fichier);
	// pour les listes
	while(ereg('\[list](.*)\[/list]', $fichier))
	{
		$fichier = preg_replace("#\[list](.*)\[/list]#Usi", "<ul>\\1</ul>", $fichier); 
	}
	while(ereg('<ul>(.*)\[\*\](.*)</ul>', $fichier))
	{
		$fichier = preg_replace("#<ul>(.*)\[\*\](.*)</ul>#Usi", "<ul>\\1<li>\\2</li></ul>", $fichier);
	}
	// pour les url
	// [url]xxxx://www.phpbb.com[/url] code..
	$fichier = preg_replace("#\[url\]([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si", "<a href=\"\\1\\2\" onclick=\"window.open('\\1\\2\');return false;\">\\1\\2</a>", $fichier); 
	// [url]www.phpbb.com[/url] code.. (no xxxx:// prefix).
	$fichier = preg_replace("#\[url\]([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si", "<a href=\"http://\\1\" onclick=\"window.open('http://\\1');return false;\">\\1</a>", $fichier);
	// [url=xxxx://www.phpbb.com]phpBB[/url] code..
	$fichier = preg_replace("#\[url=([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si", "<a href=\"\\1\\2\" onclick=\"window.open('\\1\\2');return false;\">\\3</a>", $fichier);
	// [url=www.phpbb.com]phpBB[/url] code.. (no xxxx:// prefix).
	$fichier = preg_replace("#\[url=([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si", "<a href=\"http://\\1\" onclick=\"window.open('http://\\1\');return false;\">\\2</a>", $fichier);
	return $fichier;
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
	global $config, $root_path, $langue, $rsql;
	include($root_path."conf/frame.php");
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('secu' => 'msg.tpl'));
	$template->assign_block_vars('secu', array( 
		'SITE' => $config['site_domain'].$config['site_path'],
		'GOTO'  => $goto,
	));
	$template->pparse('secu');
	include($root_path."conf/frame.php");
	exit;
}
function secu_level_test($level_page)
{
	global $config, $root_path, $user_pouvoir, $langue;
	if ( (empty($level_page) || $user_pouvoir[$level_page] != "oui") && $user_pouvoir['particulier'] != "admin")
	{
		secu($HTTP_SERVER_VARS['PHP_SELF']);
	}
}

function redirection($url)
{ 
	if ( headers_sent() )
	{
 		die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
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
	$frame_head = '<meta http-equiv="refresh" content="3;URL='.$url.'">';
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
?>