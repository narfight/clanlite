<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (!empty($page_frame))
{
	// pour le bas de page
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('foot' => 'bas_de_page.tpl'));
	if (!empty($module_droite_nfo))
	{
		foreach($module_droite_nfo as $key=>$val)
		{
			$val = explode("|*|", $val);
			$modules['nom'] = $val[1];
			$modules['id'] = $val[2];
			$modules['config'] = $val[3];
			$modules['place'] = $val[4];
			include($root_path.'modules/'.$val[0]);
		}
		unset($module, $module_droite_nfo);
	}
}
else
{
	// pour le haut de page
	$debut = getmicrotime();
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('head' => 'haut_de_page.tpl'));
	$sql = "SELECT id,nom,place,call_page,config FROM `".$config['prefix']."modules` WHERE etat = '1' AND place != 'centre' ORDER BY `ordre` ASC";
	if (! ($get_module = $rsql->requete_sql($sql, 'site', 'Listage des modules a afficher')) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	while( $modules = $rsql->s_array($get_module) )
	{
		if ( $modules['place'] != 'gauche' )
		{
			$module_droite_nfo[$modules['id']] = $modules['call_page']."|*|".$modules['nom']."|*|".$modules['id']."|*|".$modules['config']."|*|". $modules['place'];
		}
		else
		{
			include($root_path.'modules/'.$modules['call_page']);
		}
	}
	unset($module, $get_module);
	// gestion des bouttons en plus
	$sql = "SELECT * FROM `".$config['prefix']."custom_menu` WHERE `default` != '0' ORDER BY `ordre` ASC";
	if (! ($get = $rsql->requete_sql($sql, 'site', 'Listage des bouttons a ajouter au menu')) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	while ($boutton = $rsql->s_array($get)) 
	{
		$target = '';
		$target_u = ($boutton['url'] == 'url_forum')? $config['url_forum'] : $boutton['url'];
		// pour voir ou va etre ouvert la page
		if ($boutton['frame'] == 1)
		{
			$target_u = $root_path."service/iframe.php?id=".$boutton['id'];
		}
		elseif (($boutton['module_central'] == 1 || $boutton['default'] == 1) && $target_u != $config['url_forum'])
		{
			$target_u = $root_path.$boutton['url'];
		}
		elseif ($boutton['frame'] == 0 && $boutton['default'] == 'normal')
		{
			$target_u = $boutton['url'];
			$target = "onclick=\"window.open('".$target_u."');return false;\"";
		}
		$template->assign_block_vars('bouttons', array( 
			  'BOUTTON_U' => $target_u, 
			  'BOUTTON_L'  => ($boutton['default'] == 1)? $langue[$boutton['text']] : $boutton['text'],
			  'TARGET' => (!empty($target))? $target : ''
		));
		if($boutton['bouge'] == 1)
		{
			$template->assign_block_vars('bouttons.marquee', array('vide'));
		}
	}
	// popup
	$sql = "SELECT * FROM ".$config['prefix']."alert";
	if(! ($get_alert = $rsql->requete_sql($sql, 'site', 'Prise de la liste des alertes')) )
	{
		sql_error($sql,mysql_error(), __LINE__, __FILE__);
	}
	$nombre = 0;
	// on verif si on doit afficher l'etat de recrutement dans les alert
	if ($config['recrutement_alert'] == 1)
	{
		switch ($config['inscription'])
		{
			case "0":
				$liste_alert[$nombre] = $langue['recrute_pas'];
			break;
			case "1":
				$liste_alert[$nombre] = $langue['recrute'];
			break;
			case "2":
				if ($config['nbr_recrutement'] == "1")
				{
					$liste_alert[$nombre] = $langue['recrute_s'];
				}
				elseif ($config['nbr_recrutement'] < "1")
				{
					$liste_alert[$nombre] = $langue['recrute_pas'];
				}
				else
				{
					$liste_alert[$nombre] = sprintf($langue['recrute_p'], $config['nbr_recrutement']);
				}
			break;
		}
	}
	// detect le navigateur et alert si il est "bon"
	if (ereg('MSIE', $_SERVER["HTTP_USER_AGENT"]))
	{
		$liste_alert[] = $langue['alert_ie'];
	}
	while ($list_alert = $rsql->s_array($get_alert))
	{
		if ($list_alert['date'] < $config['current_time'] && $list_alert['auto_del'] == "oui")
		{
			$sql = "DELETE FROM `".$config['prefix']."alert` WHERE `id`='".$list_alert['id']."'";
			if (! ($rsql->requete_sql($sql, 'site', 'supprimer une alerte périmée')) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
		}
		elseif ($list_alert['date'] > $config['current_time'] || $list_alert['auto_del'] != "oui")
		{
			$liste_alert[] = $list_alert['info'];
		}
	}
	
	if (!empty($liste_alert) && is_array($liste_alert))
	{
		if (count($liste_alert) > 0)
		{
			$template->assign_block_vars('popup', array('TITRE_ALERT' => $langue['alert_affiche']));
		}
		foreach($liste_alert as $text_alert)
		{
			$template->assign_block_vars('popup.list', array( 
				'TEXT' => nl2br(bbcode($text_alert)),
			));
		}
	}
}
//on vérifie si il faut metre le boutton serveur
if ($config['serveur'] == 1) 
{
	$template->assign_block_vars('bouttons', array(
		'BOUTTON_L' => $langue['boutton_game_serveur_clan'],
		'BOUTTON_U' => $root_path.'service/serveur.php'
	)); 
}
//on vérifie si il faut metre le boutton liste des serveurs de jeux
if ($config['list_game_serveur'] == "oui") 
{
	$template->assign_block_vars('bouttons', array(
		'BOUTTON_L' => $langue['boutton_liste_game'],
		'BOUTTON_U' => $root_path.'service/serveur_game_list.php'
	)); 
}
//on vérifie si il faut metre le boutton inscription
if ($inscription != 0) 
{
	$template->assign_block_vars('bouttons', array(
		'BOUTTON_L' => $langue['boutton_inscription'],
		'BOUTTON_U' => $root_path.'user/new-user.php'
	)); 
}
$template->assign_vars( array( 
	'HEAD' => (!empty($frame_head))? $frame_head : "",
	'PATH_ROOT' => $root_path,
	'COPYRIGHT' => sprintf($langue['copyright'], $config['version']),
	'B_PRIVE' => $langue['boutton_connect'],
	'NOM_CLAN' => $config['nom_clan'],
	'ICI_SELF' => $config['site_domain'].$_SERVER['PHP_SELF'],
	'ICI' => $config['site_domain'].$config['site_path'],
));
if (!empty($user_connect))
{
	$template->assign_block_vars('connecter', array( 
		'LOGIN' => $langue['boutton_deconnect']."[".$session_cl['user']."]",
		'LOGIN_URL' => $root_path."controle/die-cook.php?where=".$root_path."admin.php"
	));
}
if (!empty($page_frame))
{
	if (!empty($user_pouvoir['particulier']) && $user_pouvoir['particulier'] == "admin")
	{
		$template->assign_block_vars('admin', array( 
			'TIME_EXECUT_NBR_SQL' =>  sprintf($langue['exec_time_rsql'], getmicrotime() - $debut, $rsql->nb_req)
		));
	}
	//$rsql->debug();
	$template->pparse('foot');
}
else
{
	$template->pparse('head');
	$page_frame = "foot";
}
?>