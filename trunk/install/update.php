<?php
/****************************************************************************
 *	Fichier		: 															*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$action_membre = '';
$action_db = '';
$news_version = '1.20.01.2005';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames(array('body' => 'divers_text.tpl'));
switch($config['version'])
{
	case '1.18.04.2004':
		$action_db['1.18.04.2004'] = array (
			'Options SMTP 1' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('send_mail', 'mail')",
			'Options SMTP 2' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('smtp_ip', 'localhost')",
			'Options SMTP 3' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('smtp_port', '25')",
			'Options SMTP 4' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('smtp_code', '')",
			'Options SMTP 5' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('smtp_login', '')",
			'Options Skin 6' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('skin', '".$config['skin']."')",
			'Correction d\'un smilie' => "UPDATE `".$config['prefix']."smilies` SET `text` = '<(' WHERE `id` = '93'",
			'Correction de la table user 1' => "ALTER TABLE `".$config['prefix']."user` CHANGE `sex` `sex` ENUM( 'Homme', 'Femme' ) NOT NULL",
			'Correction de la table user 2' => "ALTER TABLE `".$config['prefix']."user` CHANGE `pouvoir` `pouvoir` ENUM( 'admin', 'news', 'user' ) DEFAULT 'news' NOT NULL"
		);
	case '1.21.05.2004':
		$action_db['1.21.05.2004'] = array (
			'Cache game server' => "CREATE TABLE `".$config['prefix']."game_server_cache` ( `id` mediumint(8) unsigned NOT NULL auto_increment, `date` decimal(12,0) default NULL, `ip` varchar(255) NOT NULL default '', `hostport` smallint(5) unsigned NOT NULL default '0', `servertitle` text NOT NULL, `gameversion` varchar(255) NOT NULL default '', `maplist` longtext NOT NULL, `mapname` varchar(255) NOT NULL default '', `nextmap` varchar(255) NOT NULL default '', `password` enum('-1','1','0') NOT NULL default '-1', `maxplayers` tinyint(3) unsigned NOT NULL default '0', `numplayers` tinyint(3) unsigned NOT NULL default '0', `gametype` tinytext NOT NULL, `array_name` longtext NOT NULL, `array_value` longtext NOT NULL, PRIMARY KEY  (`id`)) TYPE=MyISAM",
			'Cache game server players' => "CREATE TABLE `".$config['prefix']."game_server_players_cache` ( `id` mediumint(8) unsigned NOT NULL auto_increment, `id_server` mediumint(8) unsigned NOT NULL default '0', `name` text NOT NULL, `score` varchar(255) NOT NULL default '', `frags` varchar(255) NOT NULL default '', `deaths` varchar(255) NOT NULL default '', `honor` varchar(255) NOT NULL default '', `time` varchar(255) NOT NULL default '', PRIMARY KEY  (`id`)) TYPE=MyISAM;",
			'détection de mise à jours' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('get_version', '1')",
		);
	case '1.12.06.2004':
		$action_db['1.12.06.2004'] = array (
			'Query Server' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('scan_game_server', 'udp')",
			'Affiche ou non les grades' => "INSERT INTO `".$config['prefix']."config` VALUES ('show_grade', '1')",
			'Changement du cache serveur 1' => "ALTER TABLE `".$config['prefix']."game_server_cache` CHANGE `array_value` players LONGTEXT NOT NULL",
			'Changement du cache serveur 2' => "ALTER TABLE `".$config['prefix']."game_server_cache` CHANGE `array_name` `rules` LONGTEXT NOT NULL",
			'Correction de la table user' => "ALTER TABLE `".$config['prefix']."user` CHANGE `web` `web` VARCHAR( 255 ) NOT NULL",
			'Section visible en publique' => "ALTER TABLE `".$config['prefix']."section` ADD `visible` ENUM( '1', '0' ) DEFAULT '1' NOT NULL",
			'Optimisation de table custom_menu 1' => "ALTER TABLE `".$config['prefix']."custom_menu` CHANGE `ordre` `ordre` MEDIUMINT( 8 ) NOT NULL",
			'Optimisation de table custom_menu 2' => "ALTER TABLE `".$config['prefix']."custom_menu` CHANGE `text` `text` VARCHAR( 255 ) NOT NULL",
			'Optimisation de table custom_menu 3' => "ALTER TABLE `".$config['prefix']."custom_menu` CHANGE `bouge` `bouge` ENUM( '1', '0' ) DEFAULT '0' NOT NULL",
			'Optimisation de table custom_menu 4' => "ALTER TABLE `".$config['prefix']."custom_menu` CHANGE `frame` `frame` ENUM( '1', '0' ) DEFAULT '0' NOT NULL",
			'Ajoute une colonne à la table custom_menu 1' => "ALTER TABLE `".$config['prefix']."custom_menu` ADD `module_central` ENUM( '1', '0' ) DEFAULT '0' NOT NULL",
			'Ajoute une colonne à la table custom_menu 2' => "ALTER TABLE `".$config['prefix']."custom_menu` ADD `id_module` MEDIUMINT( 8 ) UNSIGNED NOT NULL",
			'Ajoute une colonne à la table custom_menu 3' => "ALTER TABLE `".$config['prefix']."custom_menu` ADD `default` ENUM( 'normal', '1', '0' ) DEFAULT 'normal' NOT NULL AFTER `id_module`",
			'Ajoute l\'option central dans les modules' => "ALTER TABLE `".$config['prefix']."modules` CHANGE `place` `place` ENUM( 'gauche', 'droite', 'centre' ) DEFAULT 'gauche' NOT NULL ",
			'Ajoute le boutton News' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 1, 'boutton_news', 'service/index_pri.php', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Membre' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 2, 'boutton_liste_membres_groupe', 'service/liste-des-membres-groupe.php', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Forum' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 3, 'boutton_forum', 'url_forum', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Match' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 4, 'boutton_match', 'service/match.php', '0', '0', '0', 0, '0');",
			'Ajoute le boutton Calendrier' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 5, 'boutton_calendrier', 'service/calendrier.php', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Réglement' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 6, 'boutton_reglement', 'service/reglement.php', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Résultat' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 7, 'boutton_result_match', 'service/rapport_match.php', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Telechargement' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 8, 'boutton_telecharger', 'service/download.php', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Liens' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 9, 'boutton_liens', 'service/liens.php', '0', '0', '0', 0, '1');",
			'Ajoute le boutton Rencontre' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 10, 'boutton_org_rencontre', 'service/defier.php', '0', '0', '0', 0, '1');",
		);
	case '1.03.07.2004':
	case '1.07.07.2004':
		$action_db['1.07.07.2004'] = array(
			'Activation d\'un liens' => "UPDATE `".$config['prefix']."custom_menu` SET `default` = '1' WHERE `text` = 'boutton_match' LIMIT 1 ;"
		);
	case '1.07.08.2004':
		$action_db['1.07.08.2004'] = array(
			'correction du liens "Un Bug !?"' => "UPDATE `".$config['prefix']."custom_menu` SET `url` = 'http://mantis.clanlite.org/' WHERE `url` = 'http://mantis.lna.be/' LIMIT 1 ;"
		);
		$sql = "SELECT id, config FROM ".$config['prefix']."modules WHERE `call_page` = 'serveur_jeux.php'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while ($liste = $rsql->s_array($get))
		{
			$action_db['1.07.08.2004']['Configuration du module id '.$liste['id']] = "UPDATE `".$config['prefix']."modules` SET `config` = '".serialize(array('serveur' => $liste['config'], 'image' => false, 'liste' => true))."' WHERE `id` = '".$liste['id']."' LIMIT 1 ;";
		}
	case '1.13.09.2004':
	case '1.16.09.2004':
		$action_db['1.16.09.2004'] = array(
			'Ajoute un champ' => "ALTER TABLE `".$config['prefix']."game_server` ADD `clan` ENUM( '0', '1' ) NOT NULL AFTER `id` ;",
			'Modifie le menu du haut' => "INSERT INTO `".$config['prefix']."custom_menu` VALUES ('', 11, 'boutton_liste_game', 'service/serveur_game_list.php', '0', '0', '0', 0, '1');",
			'Ajoute du URL pour rejoindre le serveur de jeu' => "ALTER TABLE `".$config['prefix']."game_server_cache` ADD `JoinerURI` VARCHAR( 255 ) NOT NULL ;",
			'Supprime ip/port/protocol de la base config' => "DELETE FROM `".$config['prefix']."config` WHERE `conf_nom` = 'serveur' OR `conf_nom` = 'serveur_game_ip' OR `conf_nom` = 'serveur_game_port' OR `conf_nom` = 'serveur_game_protocol' OR `conf_nom` = 'serveur_game_info';",
		);
		if ($config['serveur'] == 1)
		{
			$action_db['1.16.09.2004']['Déplace la configuration du serveur de jeu du clan'] = "INSERT INTO `".$config['prefix']."game_server` (`ip`, `port`, `protocol`, `clan`) VALUES ('".$config['serveur_game_ip']."', '".$config['serveur_game_port']."', '".$config['serveur_game_protocol']."', '1');";
		}
	case '1.01.11.2004':
	// pas de modif pour la version 1.01.11.2004
	// sans break, metre case version a la suite, comme ca il fait toutes les mise à jours de la db de la version qu'il a jusqua la version actuelle
	$maj = true;
	break;
	case $news_version :
		$etat = 'Votre ClanLite est déjà mis à jour';
	break;
	default:
		$action_db = '';
		$etat = 'La version de Votre ClanLite est inconnue';
}
if (is_array($action_db) && empty($etat) || $maj)
{
	// on ajoute automatiquement le changement de version dans la db
	$action_db[$config['version']]['Mise à jours du numero de version'] = "UPDATE `".$config['prefix']."config` SET `conf_valeur` = '".$news_version."' WHERE `conf_nom` = 'version' AND `conf_valeur` = '".$config['version']."' LIMIT 1";
	$texte = "<ul>\n";
	foreach ($action_db as $version => $action)
	{
		if (count($action) != 0)
		{
			$texte .= "<li>Mise à jour à la version ".$version."</li>\n";
			$texte .= "	<ul>\n";
			foreach ($action as $for => $sql)
			{
				if (! ($get = $rsql->requete_sql($sql)) )
				{
					$texte .= "	<li><b>".$for." : </b> erreur --> ".$rsql->error;
				}
				$texte .= "	<li><b>".$for." : </b> OK";
			}
			$texte .= "	</ul>\n";
		}
	}
	$texte .= "</ul>\n";
}
$template->assign_vars(array(
	'TITRE' => 'Mise à jour de ClanLite vers la version '.$news_version,
	'TEXTE' => (empty($etat))? $texte : $etat,
));
$template->pparse('body');
?>