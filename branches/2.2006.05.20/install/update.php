<?php
/****************************************************************************
 *	Fichier		: update.php												*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$action_db = '';
$news_version = '2.2006.05.20';

require($root_path.'conf/template.php');

//configuration light
	@include($root_path.'config.php');
	if (defined('CL_INSTALL'))
	{
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
	}
	else
	{
		header('Location: '.$root_path."install/install.php?update=true\n");
		exit();
	}
// fin de la configuration light

$template = new Template($root_path.'install');
$template->set_filenames(array('body' => 'install.tpl'));
$template->assign_block_vars('update_menu', array(
	'UPDATE_B' => '<strong>',
	'UPDATE_B_END' => '</strong>'
));
$template->assign_block_vars('nouvelle_version', array('VERSION' => $news_version));

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
			'Activation d\'un liens' => "UPDATE `".$config['prefix']."custom_menu` SET `default` = '1' WHERE `text` = 'boutton_match' LIMIT 1 ;",
			'Ajoute une partie privée dans les match' => "ALTER TABLE `".$config['prefix']."match` ADD `priver` LONGTEXT NOT NULL AFTER `info` ;",
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
	case '1.23.01.2005':
		$action_db['1.23.01.2005'] = array(
			'Gestion des actualisations' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('refresh', '5')",
			'Répertoire dans les liens' => "ALTER TABLE `".$config['prefix']."liens` ADD `repertoire` VARCHAR( 255 ) NOT NULL AFTER `id` ;",
			'Alongement du liens personnel' => "ALTER TABLE `".$config['prefix']."user` CHANGE `web` `web` VARCHAR( 255 ) NOT NULL",
			'L\'option heure d\'été-hiver pour les utilisateurs' => "ALTER TABLE `".$config['prefix']."user` ADD `heure_ete` ENUM( '1', '0' ) DEFAULT '1' NOT NULL AFTER `last_connect` ;",
			'L\'option des fuseaus horaires pour les utilisateurs' => "ALTER TABLE `".$config['prefix']."user` ADD `time_zone` VARCHAR( 6 ) DEFAULT '1' NOT NULL AFTER `heure_ete` ;",
			'Configuration général pour l\'heure été-hiver' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ('heure_ete', '1');",
			'Configuration général pour les fuseaux horaires' => "INSERT INTO `".$config['prefix']."config` ( `conf_nom` , `conf_valeur` ) VALUES ( 'time_zone', '1' );"
		);
	case '2.2005.04.23':
	case '2.2005.06.17':
		$action_db['2.2005.06.17'] = array(
			'Supprime les smiles' => "TRUNCATE TABLE `".$config['prefix']."smilies`;",
			'Ajoute un smilies 01' => "INSERT INTO `".$config['prefix']."smilies` VALUES (44, ':D', 'mortderire.gif', 'super heureux', 20, 18);",
			'Ajoute un smilies 02' => "INSERT INTO `".$config['prefix']."smilies` VALUES (45, ':-D', 'mortderire.gif', 'super heureux', 20, 18);",
			'Ajoute un smilies 03' => "INSERT INTO `".$config['prefix']."smilies` VALUES (46, ':grin:', 'mortderire.gif', 'super heureux', 20, 18);",
			'Ajoute un smilies 04' => "INSERT INTO `".$config['prefix']."smilies` VALUES (47, ':)', 'joyeux.gif', 'Heureux', 20, 18);",
			'Ajoute un smilies 05' => "INSERT INTO `".$config['prefix']."smilies` VALUES (48, ':-)', 'joyeux.gif', 'Heureux', 20, 18);",
			'Ajoute un smilies 06' => "INSERT INTO `".$config['prefix']."smilies` VALUES (49, ':smile:', 'joyeux.gif', 'Heureux', 20, 18);",
			'Ajoute un smilies 07' => "INSERT INTO `".$config['prefix']."smilies` VALUES (50, ':(', 'triste.gif', 'Pas heureux', 20, 18);",
			'Ajoute un smilies 08' => "INSERT INTO `".$config['prefix']."smilies` VALUES (51, ':-(', 'triste.gif', 'Pas heureux', 20, 18);",
			'Ajoute un smilies 09' => "INSERT INTO `".$config['prefix']."smilies` VALUES (52, ':sad:', 'triste.gif', 'Pas heureux', 20, 18);",
			'Ajoute un smilies 10' => "INSERT INTO `".$config['prefix']."smilies` VALUES (53, ':o', 'invisible.gif', 'Étonné', 18, 12);",
			'Ajoute un smilies 11' => "INSERT INTO `".$config['prefix']."smilies` VALUES (54, ':-o', 'invisible.gif', 'Étonné', 18, 12);",
			'Ajoute un smilies 12' => "INSERT INTO `".$config['prefix']."smilies` VALUES (55, ':eek:', 'dimoipasqsepavrai.gif', 'Choquer', 20, 41);",
			'Ajoute un smilies 13' => "INSERT INTO `".$config['prefix']."smilies` VALUES (56, ':shock:', 'dimoipasqsepavrai.gif', 'Choquer', 20, 41);",
			'Ajoute un smilies 14' => "INSERT INTO `".$config['prefix']."smilies` VALUES (57, ':?', 'interro.gif', 'Confusion', 20, 18);",
			'Ajoute un smilies 15' => "INSERT INTO `".$config['prefix']."smilies` VALUES (58, ':-?', 'interro.gif', 'Confusion', 20, 18);",
			'Ajoute un smilies 16' => "INSERT INTO `".$config['prefix']."smilies` VALUES (60, '8)', 'lunettes.gif', 'Cool', 20, 18);",
			'Ajoute un smilies 17' => "INSERT INTO `".$config['prefix']."smilies` VALUES (61, '8-)', 'lunettes.gif', 'Cool', 20, 18);",
			'Ajoute un smilies 18' => "INSERT INTO `".$config['prefix']."smilies` VALUES (62, ':cool:', 'lunettes.gif', 'Cool', 20, 18);",
			'Ajoute un smilies 19' => "INSERT INTO `".$config['prefix']."smilies` VALUES (108, ':kiss:', 'bisou.gif', 'Je t''aime toi', 59, 57);",
			'Ajoute un smilies 20' => "INSERT INTO `".$config['prefix']."smilies` VALUES (64, ':x', 'minederien.gif', 'Mécontent', 20, 18);",
			'Ajoute un smilies 21' => "INSERT INTO `".$config['prefix']."smilies` VALUES (65, ':-x', 'minederien.gif', 'Mécontent', 20, 18);",
			'Ajoute un smilies 22' => "INSERT INTO `".$config['prefix']."smilies` VALUES (66, ':mad:', 'minederien.gif', 'Mécontent', 20, 18);",
			'Ajoute un smilies 23' => "INSERT INTO `".$config['prefix']."smilies` VALUES (67, ':P', 'neuneu.gif', 'Razz', 24, 22);",
			'Ajoute un smilies 24' => "INSERT INTO `".$config['prefix']."smilies` VALUES (68, ':-p', 'neuneu.gif', 'Razz', 24, 22);",
			'Ajoute un smilies 25' => "INSERT INTO `".$config['prefix']."smilies` VALUES (69, ':razz:', 'neuneu.gif', 'Razz', 24, 22);",
			'Ajoute un smilies 26' => "INSERT INTO `".$config['prefix']."smilies` VALUES (71, ':cry2:', 'triste.gif', 'Trés triste', 20, 18);",
			'Ajoute un smilies 27' => "INSERT INTO `".$config['prefix']."smilies` VALUES (72, ':evil:', 'pascontent.gif', 'Evil or Very Mad', 20, 18);",
			'Ajoute un smilies 28' => "INSERT INTO `".$config['prefix']."smilies` VALUES (73, ':twisted:', 'demon.gif', 'Twisted Evil', 22, 25);",
			'Ajoute un smilies 29' => "INSERT INTO `".$config['prefix']."smilies` VALUES (74, ':roll:', 'triste2.gif', 'Chercher', 20, 18);",
			'Ajoute un smilies 30' => "INSERT INTO `".$config['prefix']."smilies` VALUES (75, ':wink:', 'cligne.gif', 'Wink', 20, 18);",
			'Ajoute un smilies 31' => "INSERT INTO `".$config['prefix']."smilies` VALUES (76, ';)', 'cligne.gif', 'Wink', 20, 18);",
			'Ajoute un smilies 32' => "INSERT INTO `".$config['prefix']."smilies` VALUES (77, ';-)', 'cligne.gif', 'Wink', 20, 18);",
			'Ajoute un smilies 33' => "INSERT INTO `".$config['prefix']."smilies` VALUES (78, ':!:', 'exclam.gif', 'Exclamation', 20, 18);",
			'Ajoute un smilies 34' => "INSERT INTO `".$config['prefix']."smilies` VALUES (79, ':?:', 'interro.gif', 'Question', 20, 18);",
			'Ajoute un smilies 35' => "INSERT INTO `".$config['prefix']."smilies` VALUES (80, ':idea:', 'ampoule.gif', 'idée', 20, 18);",
			'Ajoute un smilies 36' => "INSERT INTO `".$config['prefix']."smilies` VALUES (81, ':>:', 'fleche.gif', 'fleche', 20, 18);",
			'Ajoute un smilies 37' => "INSERT INTO `".$config['prefix']."smilies` VALUES (82, ':|', 'credule.gif', 'Neutre', 20, 18);",
			'Ajoute un smilies 38' => "INSERT INTO `".$config['prefix']."smilies` VALUES (83, ':-|', 'credule.gif', 'Neutre', 20, 18);",
			'Ajoute un smilies 39' => "INSERT INTO `".$config['prefix']."smilies` VALUES (84, ':neutral:', 'credule.gif', 'Neutre', 20, 18);",
			'Ajoute un smilies 40' => "INSERT INTO `".$config['prefix']."smilies` VALUES (109, ':duel:', 'prizdetete.gif', 'Conversation animée', 42, 18);",
			'Ajoute un smilies 41' => "INSERT INTO `".$config['prefix']."smilies` VALUES (92, 'Bp', 'lunettes.gif', 'Cool', 20, 18);",
			'Ajoute un smilies 42' => "INSERT INTO `".$config['prefix']."smilies` VALUES (93, '<(', 'fatigue.gif', 'fatiguer', 20, 18);",
			'Ajoute un smilies 43' => "INSERT INTO `".$config['prefix']."smilies` VALUES (112, ':bg:', 'bienjoue.gif', 'Bien joué', 35, 31);",
			'Ajoute un smilies 44' => "INSERT INTO `".$config['prefix']."smilies` VALUES (97, ':hug:', 'bisou.gif', 'Je t''aime toi', 59, 57);",
			'Ajoute un smilies 45' => "INSERT INTO `".$config['prefix']."smilies` VALUES (98, ':gerbe:', 'malade.gif', 'BUUuuuuuurg', 21, 29);",
			'Ajoute un smilies 46' => "INSERT INTO `".$config['prefix']."smilies` VALUES (110, ':blabla:', 'prizdetete.gif', 'Conversation animée', 42, 18);",
			'Ajoute un smilies 47' => "INSERT INTO `".$config['prefix']."smilies` VALUES (111, ':dead:', 'mort.gif', 'Mort', 33, 18);",
			'Ajoute un smilies 48' => "INSERT INTO `".$config['prefix']."smilies` VALUES (102, ':bave:', 'danslecul.gif', 'J''en bave', 21, 29);",
			'Ajoute un smilies 49' => "INSERT INTO `".$config['prefix']."smilies` VALUES (106, '(a)', 'ange.gif', 'Ange', 35, 23);",
			'Ajoute un smilies 50' => "INSERT INTO `".$config['prefix']."smilies` VALUES (107, ':angel:', 'ange.gif', 'Ange', 35, 23);",
			'Ajoute un smilies 51' => "INSERT INTO `".$config['prefix']."smilies` VALUES (113, ':bof:', 'bof.gif', 'Sans plus', 20, 18);",
			'Ajoute un smilies 52' => "INSERT INTO `".$config['prefix']."smilies` VALUES (114, ':pfff:', 'burp.gif', 'Chiant', 26, 18);",
			'Ajoute un smilies 53' => "INSERT INTO `".$config['prefix']."smilies` VALUES (115, ':evil2:', 'colere.gif', 'Furax', 20, 18);",
			'Ajoute un smilies 54' => "INSERT INTO `".$config['prefix']."smilies` VALUES (116, ':fou:', 'fou.gif', 'Fou', 23, 24);",
			'Ajoute un smilies 55' => "INSERT INTO `".$config['prefix']."smilies` VALUES (117, ':monster:', 'frankenstein.gif', 'Frankenstein', 25, 28);",
			'Ajoute un smilies 56' => "INSERT INTO `".$config['prefix']."smilies` VALUES (118, ':fuck:', 'fuck.gif', 'Fuck', 37, 30);",
			'Ajoute un smilies 57' => "INSERT INTO `".$config['prefix']."smilies` VALUES (119, ':crier:', 'gueulard.gif', 'Crier', 20, 18);",
			'Ajoute un smilies 58' => "INSERT INTO `".$config['prefix']."smilies` VALUES (120, ':pirate:', 'pirate.gif', 'Pirate', 20, 18);",
			'Ajoute un smilies 59' => "INSERT INTO `".$config['prefix']."smilies` VALUES (121, ':naze:', 'naze2.gif', 'Pfff, naze', 49, 31);",
			'Ajoute un smilies 60' => "INSERT INTO `".$config['prefix']."smilies` VALUES (122, ':oops:', 'penaud.gif', 'Embarassé', 20, 18);",
			'Ajoute un smilies 61' => "INSERT INTO `".$config['prefix']."smilies` VALUES (123, ':herbe:', 'petard.gif', 'Petard', 32, 20);",
			'Ajoute un smilies 62' => "INSERT INTO `".$config['prefix']."smilies` VALUES (124, ':zen:', 'respect.gif', 'Respect', 23, 18);",
			'Ajoute un smilies 63' => "INSERT INTO `".$config['prefix']."smilies` VALUES (125, ':sournois:', 'sournois.gif', 'Sournois', 20, 18);",
			'Ajoute un smilies 64' => "INSERT INTO `".$config['prefix']."smilies` VALUES (126, ':lol:', 'stupidking.gif', 'lol', 24, 29);",
			'Ajoute un smilies 65' => "INSERT INTO `".$config['prefix']."smilies` VALUES (127, ':jessica:', 'jessica.gif', 'Jessica', 26, 30);",
			'Ajoute un smilies 66' => "INSERT INTO `".$config['prefix']."smilies` VALUES (128, ':cruella:', '0', 'Cruella', 0, 0);",
			'Ajoute un smilies 67' => "INSERT INTO `".$config['prefix']."smilies` VALUES (129, ':black:', 'jackson5.gif', 'Black', 32, 33);",
			'Ajoute un smilies 68' => "INSERT INTO `".$config['prefix']."smilies` VALUES (130, ':happy:', 'happyjump.gif', 'Super mega happy', 50, 34);",
			'Ajoute un smilies 69' => "INSERT INTO `".$config['prefix']."smilies` VALUES (131, ':jumpsad:', 'sadjump.gif', 'Je vais tout casser', 50, 34);",
		);
	case '2.2005.06.18':
		$action_db['2.2005.06.18'] = array(
			'Supprime le champ Artiste du lecteur mp3' => 'ALTER TABLE `'.$config['prefix'].'config_sond` DROP `AUTOPLAY`;',
			'Supprime le champ Loop du lecteur mp3' => 'ALTER TABLE `'.$config['prefix'].'config_sond` DROP `LOOP`;',
			'Supprime le champ AutoPlay du lecteur mp3' => 'ALTER TABLE `'.$config['prefix'].'config_sond` DROP `arstite`;',
			'Ajoute le champ Ordre dans le lecteur mp3' => 'ALTER TABLE `'.$config['prefix'].'config_sond` ADD `ordre` MEDIUMINT( 8 ) NOT NULL AFTER `id` ;',
			'Ajoute l\'option autoplay dans la config' => 'INSERT INTO `'.$config['prefix'].'config` ( `conf_nom` , `conf_valeur` ) VALUES ( \'mp3_auto_start\', \'1\');',
			'Ajoute le champs Password pour les telechargement' => 'ALTER TABLE `'.$config['prefix'].'download_groupe` ADD `password` VARCHAR( 255 ) NOT NULL AFTER `id` ;',
			'Supprime un doublon dans les smilies' => 'DELETE FROM `'.$config['prefix'].'smilies` WHERE `id` = 53 LIMIT 1;'
		);
	case '2.2005.07.15':
	case '2.2005.08.19':
		$action_db['2.2005.08.19'] = array(
			'Modification de la table des maps 1' => 'ALTER TABLE `'.$config['prefix'].'server_map` CHANGE `nom` `nom` VARCHAR( 255 ) NOT NULL',
			'Modification de la table des maps 2' => 'ALTER TABLE `'.$config['prefix'].'server_map` CHANGE `nom_console` `nom_console` VARCHAR( 255 )  NOT NULL ',
			'Modification de la table des maps 3' => 'ALTER TABLE `'.$config['prefix'].'server_map`  CHANGE `url` `url` VARCHAR( 255 ) NOT NULL ',
			'Ajoute d\'une table pour stocker les maps des matchs' => 'CREATE TABLE `'.$config['prefix'].'match_map` (`id` mediumint(8) unsigned NOT NULL auto_increment,  `id_match` mediumint(8) unsigned NOT NULL default \'0\',  `id_map` mediumint(8) unsigned NOT NULL default \'0\',  `nom` varchar(255) NOT NULL default \'\',  PRIMARY KEY  (`id`)) TYPE=MyISAM;',
			'Ajoute d\'une table pour stocker les maps des rapports de match' => 'CREATE TABLE `'.$config['prefix'].'match_rapport_map` (`id` mediumint(8) unsigned NOT NULL auto_increment,  `id_rapport` mediumint(8) unsigned NOT NULL default \'0\',  `id_map` mediumint(8) unsigned NOT NULL default \'0\',  `nom` varchar(255) NOT NULL default \'\',  `pt_nous` varchar(255) NOT NULL default \'\',  `pt_eux` varchar(255) NOT NULL default \'\',  PRIMARY KEY  (`id`)) TYPE=MyISAM;',
			'Ajoute un systéme de repertoire pour les matchs' => 'ALTER TABLE `'.$config['prefix'].'match` ADD `repertoire` VARCHAR( 255 ) NOT NULL AFTER `id` ;',
			'Ajoute un champ pour le module TS (normal si il a une erreur)' => 'ALTER TABLE `'.$config['prefix'].'module_webost_ts` ADD `last_scan` DECIMAL( 12 ) NOT NULL AFTER `id` ;',
			'Augmente la taille des IP serveur' => 'ALTER TABLE `'.$config['prefix'].'game_server` CHANGE `ip` `ip` VARCHAR( 255 ) NOT NULL ',
			'Correction du vidage du cache serveur' => 'ALTER TABLE `'.$config['prefix'].'game_server_cache` ADD `id_serveur` MEDIUMINT( 8 ) UNSIGNED NOT NULL AFTER `id` ;',
			'Ajoute la date d\inscription du membre' => 'ALTER TABLE `'.$config['prefix'].'user` ADD `user_date` DECIMAL( 12 ) UNSIGNED DEFAULT \'0\' NOT NULL AFTER `age` ;',
			'Modifie la taille du champ nom pour les membres' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `nom` `nom` VARCHAR( 255 ) NOT NULL',
			'Modifie la taille du champ user pour les membres' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `user` `user` VARCHAR( 255 ) NOT NULL',
			'Modifie la taille du champ mail pour les membres' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `mail` `mail` VARCHAR( 255 ) NOT NULL',
			'Modifie la taille du champ im pour les membres' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `im` `im` VARCHAR( 255 ) NOT NULL',
			'Modifie la taille du champ prénom pour les membres' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `prénom` `prénom` VARCHAR( 255 ) NOT NULL',
			'Modifie la taille du champ armes_préférées pour les membres' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `armes_préférées` `armes_préférées` VARCHAR( 255 ) NOT NULL',
			'Supprime les éàè dans la table '.$config['prefix'].'équipe' => 'ALTER TABLE `'.$config['prefix'].'équipe` RENAME `'.$config['prefix'].'equipe`',
			'Supprime les éàè dans le champ "détails" de la table '.$config['prefix'].'équipe' => 'ALTER TABLE `'.$config['prefix'].'equipe` CHANGE `détail` `detail` LONGTEXT',
			'Supprime les éàè dans le champ "prénom" de la table '.$config['prefix'].'user' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `prénom` `prenom` VARCHAR( 255 ) NOT NULL',
			'Supprime les éàè dans le champ "armes_préférées" de la table '.$config['prefix'].'user' => 'ALTER TABLE `'.$config['prefix'].'user` CHANGE `armes_préférées` `armes_preferees` VARCHAR( 255 ) NOT NULL',
		);
	case '2.2005.11.26':
		$action_db['2.2005.11.26'] = array(
			'corrige un smilies' => 'UPDATE `'.$config['prefix'].'smilies` SET `img` = \'cruella.gif\', `width` = 26, `height` = 30,  WHERE `id` =128 LIMIT 1 ;',
		);
	case '2.2006.02.15':
		$action_db['2.2006.02.15'] = array(
			'Supprime un module inutile' => 'DELETE FROM `'.$config['prefix'].'modules` WHERE `call_page`=\'cadre_mp3\'',
		);
	case '2.2006.04.24':
	// sans break, metre case version a la suite, comme ca il fait toutes les mise à jours de la db de la version qu'il a jusqua la version actuelle
	$maj = true;
	break;
	case $news_version :
		$etat = 'Votre ClanLite est déjà mis à jours';
	break;
	default:
		$maj = false;
		$etat = 'La version de votre ClanLite est inconnue';
}
if (is_array($action_db) && empty($etat) || isset($maj))
{
	$template->assign_block_vars('nouvelle_version.normal', array(''));

	// on ajoute automatiquement le changement de version dans la db
	$action_db[$config['version']]['Mise à jours du numero de version'] = "UPDATE `".$config['prefix']."config` SET `conf_valeur` = '".$news_version."' WHERE `conf_nom` = 'version' AND `conf_valeur` = '".$config['version']."' LIMIT 1";

	// on vérifie que le nombre de joueur est toujours le bon
	$sql = "SELECT COUNT(`id`) FROM ".$config['prefix']."user";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		$liste = $rsql->s_array($get);
		$action_db[$config['version']]['vérifie le nombre de membre'] = "UPDATE `".$config['prefix']."config` SET `conf_valeur` = '".$liste['COUNT(`id`)']."' WHERE `conf_nom` = 'nbr_membre' ";
	}
	foreach ($action_db as $version => $action)
	{
		if (count($action) != 0)
		{
			$template->assign_block_vars('nouvelle_version.normal.action', array(
				'ID' => $version,
				'TITRE' => 'Mise à jour à la version '.$version
			));
			foreach ($action as $for => $sql)
			{
				if (! ($get = $rsql->requete_sql($sql)) )
				{
					$texte = '<span class="erreur">'.$rsql->error.'</span>';
				}
				else
				{
					$texte = '<span class="ok">'.'OK'.'</span>';
				}
				$template->assign_block_vars('nouvelle_version.normal.action.liste', array(
					'ACTION' => $for,
					'RESULTAT' => $texte
				));
			}
		}
	}
}
else
{
	$template->assign_block_vars('nouvelle_version.erreur', array('TXT' => $etat));
}

$template->pparse('body');
?>