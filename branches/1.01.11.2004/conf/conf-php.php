<?php
//ob_start('ob_gzhandler'); 
@include($root_path.'config.php');
include($root_path.'conf/'.((!empty($config['db_type']))? $config['db_type'] : 'mysql').'.php');
include($root_path.'conf/session.php');
include($root_path.'conf/lib.php');
if (!defined('CL_INSTALL'))
{// clanlite non install�, on y va alors
	redirection($root_path.'install/install.php');
}
define('CL_AUTH', true);
$rsql = new mysql();
$config['securitee'] = 'no';
$rsql->mysql_connection($mysqlhost, $login, $password, $base);
// on prend la config
$sql = 'SELECT * FROM `'.$config['prefix'].'config`';
if (!($rsql->requete_sql($sql, 'site', 'prise de la configuration du site')))
{
	echo 'la configuration du site n\'a pu etre charg�e :"'.mysql_error().'<br />';
	exit;
}
while($donnees = $rsql->s_array($rsql->query))
{
	$config[$donnees['conf_nom']] = $donnees['conf_valeur'];
}
$config['nom_clan'] = htmlentities($config['nom_clan']);
$config['tag'] = htmlentities($config['tag']);
// definit quelque information pour la config
$config['skin_default'] = $config['skin'];
$config['time_cook'] = 60*$config['time_cook'];
$config['nbr_recrutement'] = 0;
if ($config['inscription'] == 2)
{
	$config['nbr_recrutement'] = $config['limite_inscription'] - $config['nbr_membre'];
	$inscription = ($config['nbr_recrutement'] < 1)? 0 : 2;
}
else 
{
	$inscription = $config['inscription'];
}
session_on();
$session_cl = lire_session();
//change le template si on le demande
$config['skin'] = (!empty($session_cl['tpl_perso']) && is_dir($root_path.'templates/'.$session_cl['tpl_perso']))? $session_cl['tpl_perso'] : $config['skin'];
if (!empty($_GET['change_tpl_perso']) || !empty($_POST['change_tpl_perso']))
{
	$change_tpl_perso = (!empty($_GET['change_tpl_perso']))? $_GET['change_tpl_perso'] : $_POST['change_tpl_perso'];
	if (is_dir($root_path.'templates/'.$change_tpl_perso))
	{// le th�me est valide
		$user_tpl_perso = $change_tpl_perso;
		$config['skin'] = $change_tpl_perso;
		$session_cl['tpl_perso'] = $change_tpl_perso;
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

$session_cl['ip'] = get_ip();
$user_pouvoir['particulier'] = '';
$nfo_cookies = (!empty($_COOKIE['auto_connect']))? explode('|*|', $_COOKIE['auto_connect']) : array(0 => '', 1 => '');
$user_connect = (!empty($session_cl['user']))? $session_cl['user'] : $nfo_cookies[0];
$psw_connect = (!empty($session_cl['psw']))? $session_cl['psw'] : $nfo_cookies[1];
if(!empty($user_connect) && !empty($psw_connect))
{ 
	$sql = "SELECT a.id,a.nom,a.section,a.langue,a.psw,a.user,a.mail,a.pouvoir,b.*,a.sex FROM ".$config['prefix']."user AS a LEFT JOIN ".$config['prefix']."pouvoir AS b ON b.user_id = a.id WHERE a.user ='".$user_connect."' AND a.psw ='".$psw_connect."'";
	if (!($rsql->requete_sql($sql, 'site', 'V�rifie que le cookies est valide')))
	{
		echo $sql.'<br />';
		echo 'erreur dans la demande des information d\'un membre<br />';
		exit;
	}
	if (($infouser = $rsql->s_array($rsql->query)))
	{
		$session_cl['id'] = $infouser['id'];
		$session_cl['sex'] = $infouser['sex'];
		$session_cl['user'] = $user_connect;
		$session_cl['psw'] = $psw_connect;
		$session_cl['mail'] = $infouser['mail'];
		$session_cl['section'] = $infouser['section'];
		$session_cl['langue_user'] = (!empty($session_cl['langue_user']))? $session_cl['langue_user'] : $infouser['langue'];
		$user_pouvoir['particulier'] = $infouser['pouvoir'];
		for ($i = 1;$i < 26;$i++)
		{
			$user_pouvoir[$i] = $infouser['p'.$i];
		}
		$config['securitee'] = ($user_pouvoir['particulier'] == 'news')? 'news' : 'ok' ;
	}
	else
	{
		unset($session_cl['id'],$session_cl['sex'],$session_cl['user'],$session_cl['psw'],$session_cl['mail'],$session_cl['section']);
	}
}
// on prend l'heure en format mk_time pour le site
$config['current_time'] = time();
// on v�rifie que la langue est valise et on prend tout les fichiers de langues du rep
$config['langue_actuelle'] = (!empty($session_cl['langue_user']) && is_dir($root_path.'langues/'.$session_cl['langue_user']))? $session_cl['langue_user'] : $config['langue'];
include($root_path.'langues/'.$config['langue_actuelle'].'/langue.php');
$rep_langue=opendir($root_path.'langues/'.$config['langue']);
while($curfile=readdir($rep_langue))
{
	if(ereg("^lg_(.*)\.php$", $curfile))
	{
		include($root_path.'langues/'.$config['langue_actuelle'].'/'.$curfile);
	}
}
closedir($rep_langue);
$session_cl['action_membre'] = (!empty($action_membre) &&!empty($langue[$action_membre]))? $action_membre : 'where_unknow';
save_session($session_cl);
?>