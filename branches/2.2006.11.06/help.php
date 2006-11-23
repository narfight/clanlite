<?php
header('Content-type: text/plain');
$root_path = './';
@include($root_path.'config.php');
if (!defined('CL_INSTALL'))
{
	die('Aucune version de ClanLite installé dans ce repertoire!');
}
require($root_path.'conf/'.((!empty($config['db_type']))? $config['db_type'] : 'mysql').'.php');
require($root_path.'conf/session.php');
require($root_path.'conf/lib.php');

$rsql = new mysql();
$config['securitee'] = 'no';
$rsql->mysql_connection($mysqlhost, $login, $password, $base);
if (isset($rsql->error))
{
	die($rsql->error);
}

//ajoute les deux champs pour les armes et le prénom
$sql = "ALTER TABLE `".$config['prefix']."user` ADD `prenom` longtext NOT NULL AFTER `last_connect` ;";
if (!$rsql->requete_sql($sql))
{
	echo 'Erreur SQL : '.$rsql->error."\n";
}
else
{
	echo 'le champ prenom crée'."\n";
}

$sql = "ALTER TABLE `".$config['prefix']."user` ADD `armes_preferees` longtext NOT NULL AFTER `prenom` ;";
if (!$rsql->requete_sql($sql))
{
	echo 'Erreur SQL : '.$rsql->error."\n";
}
else
{
	echo 'le champ armes_preferees crée'."\n";
}

//retrouve les armes des personnes
$sql = "SELECT * FROM ".$config['prefix']."user";
if (! ($get = $rsql->requete_sql($sql)) )
{
	echo 'Erreur SQL : '.$rsql->error."\n";
}
else
{
	while ($user = $rsql->s_array($get))
	{
		$equipe[] = $user['equipe'];
		$sql = "UPDATE ".$config['prefix']."user SET `prenom`='".$user[16]."', `armes_preferees`='".$user[17]."' WHERE id ='".$user['id']."'";
		if (!$rsql->requete_sql($sql))
		{
			echo 'Erreur SQL : '.$rsql->error."\n";
		}
	}
}

//on crée la table équipe qui a changé de nom
$sql = 'CREATE TABLE `'.$config['prefix'].'equipe` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` longtext NOT NULL,
  `detail` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;';

if (!$rsql->requete_sql($sql))
{
	echo 'Erreur SQL : '.$rsql->error."\n";
}
else
{
	echo 'Table '.$config['prefix'].'equipe crée'."\n";
}

// recrée les équipes

if (isset($equipe) && is_array($equipe))
{
	foreach ($equipe as $tmp)
	{
		$sql = "INSERT INTO `".$config['prefix']."equipe` VALUES (".$tmp.", 'Equipe n°".$tmp."', '');";
		if (!$rsql->requete_sql($sql))
		{
			echo 'Erreur SQL : '.$rsql->error."\n";
		}
		else
		{
			echo 'Equipe n°'.$tmp.' crée'."\n";
		}
	}
}
?>