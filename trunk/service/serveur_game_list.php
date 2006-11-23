<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_serveur_list';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
require_once($root_path."service/gsquery/gsQuery.php");
$template->set_filenames(array('body' => 'liste_game_serveur.tpl'));
$_GET['limite'] = (empty($_GET['limite']))? 0 : $_GET['limite'];
$total = get_nbr_objet("game_server", "");
$template->assign_vars(array('TITRE' => $langue['titre_serveur_list']));
//on prend la config du serveur
$sql = "SELECT ip,port,protocol FROM `".$config['prefix']."game_server` LIMIT ".$_GET['limite'].",".$config['objet_par_page'];
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($info = $rsql->s_array($get))
// on scan
if ( ($gameserver=queryServer($info['ip'], $info['port'], $info['protocol'])) )
{
	switch($gameserver->password)
	{
		case "0":
			$serveur_password ="non";
		break;
		case "1":
			$serveur_password ="oui";
		break;
		case "-1":
			$serveur_password ="inconnu";
		break;
	}
	$template->assign_block_vars('liste_game_server', array(
		'TITRE' => $langue['titre_serveur_list'],
		'TXT_NAME' => $langue['nom_serveur_jeux'],
		'NAME' => $gameserver->servertitle,
		'TXT_PLACE' => $langue['nbr_place_serveur_jeux'],
		'PLACE' => $gameserver->maxplayers,
		'PLAYER' => $gameserver->numplayers,
		'PORT' => $gameserver->hostport,
		'TXT_IP' => $langue['ip'],
		'IP' => $info['ip'],
		'TXT_GAME_TYPE' => $langue['gametype_serveur_jeux'],
		'GAME_TYPE' => $gameserver->gametype,								
		'TXT_CURRENT_MAP' => $langue['map_serveur_jeux'],
		'CURRENT_MAP' => scan_map($gameserver->mapname, 'nom'),
		'PASSWORD' => $serveur_password,
	));
}
displayNextPreviousButtons($_GET['limite'],$total,"multi_page");
$template->pparse('body');
include($root_path."conf/frame.php"); 
?>
