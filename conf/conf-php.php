<?php
/****************************************************************************
 *	Fichier		: conf-php.php												*
 *	Copyright	: (C) 2007 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
ob_start('ob_gzhandler'); 
@ini_set('register_globals', 0);
@include($root_path.'config.php');
require($root_path.'conf/'.((!empty($config['db_type']))? $config['db_type'] : 'mysql').'.php');
require($root_path.'conf/session.php');
require($root_path.'conf/lib.php');
require($root_path.'conf/adodb-time.inc.php');

if (!defined('CL_INSTALL'))
{// clanlite non installé, on y va alors
	redirection($root_path.'install/install.php');
}

define('CL_AUTH', true);
$rsql = new mysql();
$config['securitee'] = 'no';
$rsql->mysql_connection($mysqlhost, $login, $password, $base);
unset($mysqlhost, $login, $password, $base);

if (isset($rsql->error))
{
	die($rsql->error);
}

// on prend la config
$sql = 'SELECT * FROM `'.$config['prefix'].'config`';
if (!($rsql->requete_sql($sql, 'site', 'prise de la configuration du site')))
{
	die('La configuration du site n\'a pu etre chargée : '.$rsql->error);
}
while($donnees = $rsql->s_array($rsql->query))
{
	$config[$donnees['conf_nom']] = $donnees['conf_valeur'];
}
$config['nom_clan'] = htmlentities($config['nom_clan']);
$config['tag'] = htmlentities($config['tag']);
// definit quelque information pour la config
$config['refresh'] = 60*$config['refresh'];
$config['nbr_recrutement'] = 0;
if ($config['inscription'] == 2)
{ // inscription limité
	$config['nbr_recrutement'] = $config['limite_inscription'] - $config['nbr_membre'];
	$inscription = ($config['nbr_recrutement'] < 1)? 0 : 2;
}
else 
{
	$inscription = $config['inscription'];
}
// on vérifie que c'est pas un robot comme le serveur TS, alors on ne lui donne pas de session
if ($action_membre != 'no session please Mr ClanLite')
{
	//on démarre la session
	session_on();
	$session_cl = lire_session();
	$session_cl['ip'] = get_ip();
	
	//change le template si on le demande
	$session_cl['skin'] = (!empty($session_cl['skin']) && is_dir($root_path.'templates/'.$session_cl['skin']))? $session_cl['skin'] : $config['skin'];
	if (!empty($_GET['change_tpl_perso']) || !empty($_POST['change_tpl_perso']))
	{
		$change_tpl_perso = (!empty($_GET['change_tpl_perso']))? $_GET['change_tpl_perso'] : $_POST['change_tpl_perso'];
		if (is_dir($root_path.'templates/'.$change_tpl_perso))
		{// le théme est valide
			$session_cl['skin'] = $change_tpl_perso;
		}
	}
	
	// change de langue si on le demande
	if (!empty($_GET['change_langue_perso']) || !empty($_POST['change_langue_perso']))
	{
		$change_langue_perso = (!empty($_GET['change_langue_perso']))? $_GET['change_langue_perso'] : $_POST['change_langue_perso'];
		if (is_dir($root_path.'langues/'.$change_langue_perso))
		{// la langue existe bien
			$session_cl['langue_user'] = $change_langue_perso;
		}
	}
	
	// lecture du cookies pour l'auto connection seulement si il n'est pas déja connecté
	if (!empty($_COOKIE['auto_connect']) && (empty($session_cl['user']) || empty($session_cl['psw'])))
	{
		list($session_cl['user'], $session_cl['psw']) = pure_var(explode('|*|', $_COOKIE['auto_connect']));
	}
	
	if(!empty($session_cl['user']) && !empty($session_cl['psw']))
	{ 
		$sql = "SELECT a.id, a.nom, a.section, a.langue, a.psw, a.user, a.mail, a.pouvoir, b.*, a.sex, a.time_zone, a.heure_ete, section.limite AS limite_match FROM ".$config['prefix']."user AS a LEFT JOIN ".$config['prefix']."pouvoir AS b ON b.user_id = a.id LEFT JOIN ".$config['prefix']."section AS section ON a.section = section.id WHERE a.user ='".$session_cl['user']."' AND a.psw ='".$session_cl['psw']."'";
		if (!($rsql->requete_sql($sql, 'site', 'Vérifie que le cookies est valide')))
		{
			die('Erreur dans la demande des information d\'un membre pour la session : '.$rsql->error);
		}
		if (($infouser = $rsql->s_array($rsql->query)))
		{
			// on redéfinit les valeurs qui pourrait étre changé par l'admin
			$session_cl['id'] = $infouser['id'];
			$session_cl['sex'] = $infouser['sex'];
			$session_cl['nom'] = $infouser['nom'];
			$session_cl['mail'] = $infouser['mail'];
			$session_cl['section'] = $infouser['section'];
			$session_cl['limite_match'] = $infouser['limite_match'];
			$session_cl['langue_user'] = (!empty($session_cl['langue_user']))? $session_cl['langue_user'] : $infouser['langue'];
			$session_cl['correction_heure'] = (3600*$infouser['heure_ete']*date('I'))+(3600*$infouser['time_zone']);
			$session_cl['pouvoir_particulier'] = $infouser['pouvoir'];
			for ($i = 1;$i < 26;$i++)
			{
				$user_pouvoir[$i] = $infouser['p'.$i];
			}
			$config['securitee'] = ($session_cl['pouvoir_particulier'] == 'news')? 'news' : 'ok';
		}
		else
		{
			// on vide la session au cas ou
			unset($session_cl['id'],$session_cl['sex'],$session_cl['user'],$session_cl['psw'],$session_cl['mail'],$session_cl['section']);
			// ainsi que son cookies pour l'autoconnection si il en a un
			SetCookie('auto_connect','',time()-12, $config['site_path']);
		}
	}
	else
	{
		// c'est un visiteur, on lui donne une config par default et aucun pouvoir
		$session_cl['pouvoir_particulier'] = 'guest';
		// quoi qu'il arrive, il n'a pas d'id
		unset($session_cl['id']);
		for ($i = 1;$i < 26;$i++)
		{
			$user_pouvoir[$i] = 'non';
		}
		$session_cl['correction_heure'] = (3600*$config['heure_ete']*date('I'))+(3600*$config['time_zone']);
	}
	
	// on prend l'heure en format mk_time pour le site et on lui donne le temps GMT
	$config['current_time'] = time()-date('Z');
	
	// on vérifie que la langue est valise et on prend tout les fichiers de langues du rep
	$config['langue_actuelle'] = (!empty($session_cl['langue_user']) && file_exists($root_path.'langues/'.$session_cl['langue_user'].'/langue.php'))? $session_cl['langue_user'] : $config['langue'];
	require($root_path.'langues/'.$config['langue_actuelle'].'/langue.php');
	foreach(scandir($root_path.'langues/'.$config['langue_actuelle']) as $id => $file)
	{
		if(ereg('^lg_(.*)\.php$', $file))
		{
			require($root_path.'langues/'.$config['langue_actuelle'].'/'.$file);
		}
	}
	$session_cl['action_membre'] = (!empty($action_membre) && !empty($langue[$action_membre]))? $action_membre : 'where_unknow';
	save_session($session_cl);
}
?>