<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
function session_on()
{
	global $rsql,$config,$HTTP_COOKIE_VARS;
	if (empty($HTTP_COOKIE_VARS['session']))
	{// il a pas de trace de session chez le visiteur et donc on lui envois un cookies
		$string="azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890"; 
		$uid = '';
		for($i=0;$i<32;$i++)
		{
			$uid .=$string[mt_rand()%strlen($string)];
		}
		setcookie('session', $uid, time()+3600*24*31*12, $config['site_path']);
		$sql = "INSERT INTO ".$config['prefix']."sessions (id, date, stock) VALUES ('".$uid."', NOW(), '')";
		$rsql->requete_sql($sql, 'session', 'Insertion d\'une session');
		$compteur_1 =$config['compteur']+1;
		$sql = "UPDATE ".$config['prefix']."config SET conf_valeur = '".$compteur_1."' WHERE conf_nom = 'compteur'";
		$rsql->requete_sql($sql, 'site', 'Ajoute 1 au compteur de visite');
		$config['id_session'] = $uid;
		return;
	}
}
function lire_session($ou='')
{
	global $rsql,$config,$HTTP_COOKIE_VARS;
	$ou = (!empty($ou))? $ou : (!empty($HTTP_COOKIE_VARS['session']))? $HTTP_COOKIE_VARS['session'] : $config['id_session'];
	$sql = "SELECT stock FROM ".$config['prefix']."sessions WHERE id='".$ou."'";
	$get = $rsql->requete_sql($sql, 'session', 'Prend les informations de la session');
	if (!($valeur_session = $rsql->s_array($get)))
	{
		$sql = "INSERT INTO ".$config['prefix']."sessions (id, date, stock) VALUES ('".$ou."', NOW(), '')";
		$rsql->requete_sql($sql, 'session', 'Insertion d\'une session');
	}
	else
	{
		$valeur_array = explode('|!*§|', $valeur_session['stock']);
		$valeur_session = '';
		foreach($valeur_array as $valeur)
		{
			$valeur_tmp = explode('|.=.|', $valeur);
			if (!empty($valeur_tmp[0]) && !empty($valeur_tmp[1]))
			{
				$valeur_session[$valeur_tmp[0]] = $valeur_tmp[1];
			}
		}
	}
	return $valeur_session;
}
function save_session($valeur_session='')
{
	global $rsql,$config,$HTTP_COOKIE_VARS;
	$HTTP_COOKIE_VARS['session'] = (!empty($HTTP_COOKIE_VARS['session']))? $HTTP_COOKIE_VARS['session'] : $config['id_session'];
	if (is_array($valeur_session))
	{
		$chaine = '';
		foreach($valeur_session as $key=>$var)
		{
			$chaine .=$key."|.=.|".$var."|!*§|";
		}
		$sql = "UPDATE ".$config['prefix']."sessions SET stock = '".$chaine."', date = NOW() WHERE id = '".$HTTP_COOKIE_VARS['session']."'";
		$rsql->requete_sql($sql, 'session', 'Mise à jour des données de la session');
	}
	dell_old_session();
}
function clear_session()
{
	global $rsql,$config,$HTTP_COOKIE_VARS;
	$sql = "UPDATE ".$config['prefix']."sessions SET stock = '', date = NOW() WHERE id = '".$HTTP_COOKIE_VARS['session']."'";
	if (! ($rsql->requete_sql($sql, 'session', 'Supprime la session')) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
}
function dell_old_session()
{
	global $rsql,$config;
	$seconde = time()-(60*$config['time_cook']);
	$sql = "DELETE FROM `".$config['prefix']."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(date) > ".$config['time_cook'];
	$rsql->requete_sql($sql, 'session', 'Supprime les sessions inactives');
}
?>