<?php
/****************************************************************************
 *	Fichier		: entrer.php												*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = '../';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
//on converti son code en md5
$_POST = pure_var($_POST);
$_POST['psw'] = md5($_POST['psw']);

$sql = "SELECT `nom`, `pouvoir`, `psw`, `id` FROM `".$config['prefix']."user` WHERE `user` = '".$_POST['user']."' AND `psw` = '".$_POST['psw']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if (! ($info_connection = $rsql->s_array($get)) )
{
	redirection('../admin.php?erreur=code_login');
}
else
{
	// on regarde si il veut sauvergarder son code/login pour une autoreconnection
	if (!empty($_POST['save_code_login']))
	{
		SetCookie('auto_connect', $_POST['user'].'|*|'.$_POST['psw'],time()+3600*24*31*12, $config['site_path']);
	}
	// on change la date a la quelle il c'est connecter pour la derniere fois
	$sql = "UPDATE ".$config['prefix']."user SET last_connect='".$config['current_time']."' WHERE user ='".$_POST['user']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//pour le compteur de conecter
	$session_cl['action_membre'] = 'titre_login';
	save_session($session_cl);
	if ($info_connection['pouvoir'] == 'news')
	{
		redirection('../admin.php?erreur=news');
	}
	// oki on envoys sur la page
	else
	{
		$session_cl['id'] = $info_connection['id'];
		$session_cl['user'] = $_POST['user'];
		$session_cl['psw'] = $_POST['psw'];
		save_session($session_cl);
		if (empty($_POST['goto']))
		{
			redirection($root_path.'user/index.php');
		}
		else 
		{
			redirection($_POST['goto']);
		}
	}
}
?>