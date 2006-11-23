CREATE TABLE `clanlite_alert` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `date` decimal(12,0) NOT NULL default '0',
  `info` longtext NOT NULL,
  `auto_del` enum('oui','non') NOT NULL default 'oui',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_config` (
  `conf_nom` longtext NOT NULL,
  `conf_valeur` longtext NOT NULL
) TYPE=MyISAM;

CREATE TABLE `clanlite_config_sond` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `ordre` mediumint(8) NOT NULL default '0',
  `SRC` longtext NOT NULL,
  `AUTOPLAY` enum('TRUE','FALSE') NOT NULL default 'TRUE',
  `LOOP` enum('TRUE','FALSE') NOT NULL default 'FALSE',
  `arstite` longtext NOT NULL,
  `titre` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_custom_menu` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `ordre` mediumint(8) NOT NULL default '0',
  `text` varchar(255) NOT NULL default '',
  `url` longtext NOT NULL,
  `bouge` enum('1','0') NOT NULL default '0',
  `frame` enum('1','0') NOT NULL default '0',
  `module_central` enum('1','0') NOT NULL default '0',
  `id_module` mediumint(8) unsigned NOT NULL default '0',
  `default` enum('normal','1','0') NOT NULL default 'normal',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_download_fichier` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `id_rep` mediumint(8) unsigned NOT NULL default '0',
  `nom_de_fichier` longtext NOT NULL,
  `info_en_plus` longtext NOT NULL,
  `telecharger` mediumint(8) unsigned NOT NULL default '0',
  `nombre_de_vote` mediumint(8) unsigned NOT NULL default '0',
  `cote` tinyint(4) NOT NULL default '0',
  `modifier_a` int(10) NOT NULL default '0',
  `url_dl` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_download_groupe` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `password` varchar(255) NOT NULL default '',
  `nom` longtext NOT NULL,
  `comentaire` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_entrainement` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `date` decimal(12,0) NOT NULL default '0',
  `info` longtext NOT NULL,
  `user` longtext NOT NULL,
  `priver` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_equipe` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` longtext NOT NULL,
  `detail` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_game_server` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `clan` enum('0','1') NOT NULL default '0',
  `ip` varchar(255) NOT NULL default '',
  `port` mediumint(9) NOT NULL default '0',
  `protocol` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_game_server_cache` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `id_serveur` mediumint(8) unsigned NOT NULL default '0',
  `date` decimal(12,0) default NULL,
  `ip` varchar(255) NOT NULL default '',
  `hostport` smallint(5) unsigned NOT NULL default '0',
  `servertitle` text NOT NULL,
  `gameversion` varchar(255) NOT NULL default '',
  `maplist` longtext NOT NULL,
  `mapname` varchar(255) NOT NULL default '',
  `nextmap` varchar(255) NOT NULL default '',
  `password` enum('-1','1','0') NOT NULL default '-1',
  `maxplayers` tinyint(3) unsigned NOT NULL default '0',
  `numplayers` tinyint(3) unsigned NOT NULL default '0',
  `gametype` tinytext NOT NULL,
  `rules` longtext NOT NULL,
  `players` longtext NOT NULL,
  `JoinerURI` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_grades` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `ordre` mediumint(8) unsigned NOT NULL default '0',
  `nom` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_liens` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `repertoire` varchar(255) NOT NULL default '',
  `nom_liens` longtext NOT NULL,
  `url_liens` longtext NOT NULL,
  `images` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_match` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `repertoire` varchar(255) NOT NULL default '',
  `date` decimal(12,0) unsigned NOT NULL default '0',
  `info` longtext NOT NULL,
  `priver` longtext NOT NULL,
  `le_clan` tinytext NOT NULL,
  `nombre_de_joueur` smallint(2) NOT NULL default '0',
  `heure_msn` longtext NOT NULL,
  `section` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_match_demande` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `clan` tinytext NOT NULL,
  `date` decimal(12,0) unsigned NOT NULL default '0',
  `joueurs` smallint(2) unsigned NOT NULL default '0',
  `mail_demande` longtext NOT NULL,
  `msn_demandeur` longtext NOT NULL,
  `url_clan` longtext NOT NULL,
  `info` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_match_inscription` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `id_match` longtext NOT NULL,
  `statu` enum('ok','reserve','demande') NOT NULL default 'demande',
  `user_id` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_match_map` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `id_match` mediumint(8) unsigned NOT NULL default '0',
  `id_map` mediumint(8) unsigned NOT NULL default '0',
  `nom` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_match_rapport` (
  `id` mediumint(9) NOT NULL auto_increment,
  `repertoire` varchar(255) NOT NULL default '',
  `date` decimal(12,0) unsigned NOT NULL default '0',
  `section` mediumint(8) unsigned NOT NULL default '0',
  `contre` longtext NOT NULL,
  `info` longtext NOT NULL,
  `score_nous` longtext NOT NULL,
  `score_eux` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_match_rapport_map` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `id_rapport` mediumint(8) unsigned NOT NULL default '0',
  `id_map` mediumint(8) unsigned NOT NULL default '0',
  `nom` varchar(255) NOT NULL default '',
  `pt_nous` varchar(255) NOT NULL default '',
  `pt_eux` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_module_partenaires_27` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` longtext NOT NULL,
  `url` longtext NOT NULL,
  `image` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_module_shoutbox_21` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `user` varchar(255) NOT NULL default '',
  `msg` varchar(255) NOT NULL default '',

  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_modules` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `ordre` mediumint(8) NOT NULL default '0',
  `place` enum('gauche','droite','centre') NOT NULL default 'gauche',
  `etat` enum('1','0') NOT NULL default '1',
  `nom` longtext NOT NULL,
  `call_page` longtext NOT NULL,
  `config` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_news` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `date` decimal(12,0) unsigned NOT NULL default '0',
  `titre` varchar(255) NOT NULL default '',
  `info` longtext NOT NULL,
  `user` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_calendrier` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `date` decimal(12,0) unsigned NOT NULL default '0',
  `text` MEDIUMTEXT NOT NULL,
  `cyclique` ENUM( '1', '0' ) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_pouvoir` (
  `user_id` mediumint(8) unsigned NOT NULL auto_increment,
  `p1` enum('oui','non') NOT NULL default 'non',
  `p2` enum('oui','non') NOT NULL default 'non',
  `p3` enum('oui','non') NOT NULL default 'non',
  `p4` enum('oui','non') NOT NULL default 'non',
  `p5` enum('oui','non') NOT NULL default 'non',
  `p6` enum('oui','non') NOT NULL default 'non',
  `p7` enum('oui','non') NOT NULL default 'non',
  `p8` enum('oui','non') NOT NULL default 'non',
  `p9` enum('oui','non') NOT NULL default 'non',
  `p10` enum('oui','non') NOT NULL default 'non',
  `p11` enum('oui','non') NOT NULL default 'non',
  `p12` enum('oui','non') NOT NULL default 'non',
  `p13` enum('oui','non') NOT NULL default 'non',
  `p14` enum('oui','non') NOT NULL default 'non',
  `p15` enum('oui','non') NOT NULL default 'non',
  `p16` enum('oui','non') NOT NULL default 'non',
  `p17` enum('oui','non') NOT NULL default 'non',
  `p18` enum('oui','non') NOT NULL default 'non',
  `p19` enum('oui','non') NOT NULL default 'non',
  `p20` enum('oui','non') NOT NULL default 'non',
  `p21` enum('oui','non') NOT NULL default 'non',
  `p22` enum('oui','non') NOT NULL default 'non',
  `p23` enum('oui','non') NOT NULL default 'non',
  `p24` enum('oui','non') NOT NULL default 'non',
  `p25` enum('oui','non') NOT NULL default 'non',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_reaction_news` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `id_news` longtext NOT NULL,
  `nom` longtext NOT NULL,
  `email` longtext NOT NULL,
  `date` decimal(12,0) NOT NULL default '0',
  `texte` longtext NOT NULL,
  `notif_reponce` longtext NOT NULL,
  `envois_notif` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_section` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` longtext NOT NULL,
  `limite` enum('1','0') NOT NULL default '1',
  `visible` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_server_map` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `nom_console` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_sessions` (
  `id` varchar(255) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `stock` text,
  PRIMARY KEY  (`id`),
  KEY `LastUpdated` (`date`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_smilies` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `text` varchar(30) default NULL,
  `img` varchar(255) default NULL,
  `def` varchar(255) default NULL,
  `width` tinyint(4) NOT NULL default '16',
  `height` tinyint(4) NOT NULL default '16',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `clanlite_user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` varchar(255) NOT NULL default '',
  `user` varchar(255) NOT NULL default '',
  `mail` varchar(255) NOT NULL default '',
  `im` varchar(255) NOT NULL default '',
  `psw` varchar(32) NOT NULL default '',
  `pouvoir` enum('admin','news','user') NOT NULL default 'admin',
  `sex` enum('Homme','Femme') NOT NULL default 'Homme',
  `age` int(10) NOT NULL default '0',
  `user_date` decimal(12,0) unsigned NOT NULL default '0',
  `web` varchar(255) NOT NULL default '',
  `cri` longtext NOT NULL,
  `last_connect` int(10) unsigned NOT NULL default '0',
  `heure_ete` enum('1','0') NOT NULL default '1',
  `time_zone` varchar(6) NOT NULL default '0.00',
  `prenom` varchar(255) NOT NULL default '',
  `armes_preferees` varchar(255) NOT NULL default '',
  `equipe` tinyint(4) unsigned NOT NULL default '0',
  `histoire` longtext NOT NULL,
  `roles` longtext NOT NULL,
  `images` longtext NOT NULL,
  `grade` mediumint(8) NOT NULL default '0',
  `medail` varchar(19) NOT NULL default '',
  `section` tinyint(4) unsigned NOT NULL default '0',
  `tmp_code` tinytext NOT NULL,
  `key_activ_code` varchar(100) NOT NULL default '',
  `langue` varchar(255) NOT NULL default 'francais',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;