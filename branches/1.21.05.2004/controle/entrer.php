<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = "../";
include($root_path.'conf/template.php');
include($root_path."conf/conf-php.php");
//on converti son code en md5
$psw = md5($_POST['psw']);
$user = $_POST['user'];
// on regarde si il veut sauvergarder son code/login pour une autoreconnection
$sql = "SELECT nom, pouvoir, psw, id FROM `".$config['prefix']."user` WHERE user = '".$user."' AND psw = '".$psw."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if (! ($info_connection = $rsql->s_array($get)) )
{
	redirection('../admin.php?erreur=1');
}
else
{
	if (!empty($_POST['save_code_login']))
	{
		SetCookie("auto_connect", $user."|*|".$psw,time()+3600*24*31*12, $config['site_path']);
	}
	// on change la date a la quelle il c'est connecter pour la derniere fois
	$sql = "UPDATE ".$config['prefix']."user SET last_connect='".$config['current_time']."' WHERE user ='".$user."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//pour le compteur de conecter
	$session_cl['action_membre'] = 'titre_login';
	save_session($session_cl);
	if ($info_connection['pouvoir'] == "news")
	{
		redirection('../admin.php?erreur=news');
	}
	// oki on envoys sur la page
	else
	{
		$session_cl['id'] = $info_connection['id'];
		$session_cl['user'] = $user;
		$session_cl['psw'] = $psw;
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