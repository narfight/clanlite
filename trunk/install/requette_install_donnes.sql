INSERT INTO `clanlite_config` VALUES ('langue', 'Francais');
INSERT INTO `clanlite_config` VALUES ('reglement', '');
INSERT INTO `clanlite_config` VALUES ('master_mail', 'narfight@clanlite.org');
INSERT INTO `clanlite_config` VALUES ('site_domain', 'http://www.clanlite.org');
INSERT INTO `clanlite_config` VALUES ('time_cook', '200');
INSERT INTO `clanlite_config` VALUES ('nbr_membre', '1');
INSERT INTO `clanlite_config` VALUES ('id_membre_match', '1');
INSERT INTO `clanlite_config` VALUES ('list_game_serveur', 'oui');
INSERT INTO `clanlite_config` VALUES ('url_forum', 'http://forum.clanlite.org');
INSERT INTO `clanlite_config` VALUES ('compteur', '0');
INSERT INTO `clanlite_config` VALUES ('msg_bienvenu', 'petit message editable dans l''admin pour dire quoi faire apres l''inscription  :roll:');
INSERT INTO `clanlite_config` VALUES ('inscription', '2');
INSERT INTO `clanlite_config` VALUES ('tag', '[CL]');
INSERT INTO `clanlite_config` VALUES ('nom_clan', 'Votre nom de clan');
INSERT INTO `clanlite_config` VALUES ('limite_inscription', '24');
INSERT INTO `clanlite_config` VALUES ('version', '2.2006.11.07');
INSERT INTO `clanlite_config` VALUES ('objet_par_page', '4');
INSERT INTO `clanlite_config` VALUES ('site_path', '/clanlite/');
INSERT INTO `clanlite_config` VALUES ('raport_error', '1');
INSERT INTO `clanlite_config` VALUES ('recrutement_alert', '1');
INSERT INTO `clanlite_config` VALUES ('send_mail', 'php');
INSERT INTO `clanlite_config` VALUES ('smtp_ip', 'localhost');
INSERT INTO `clanlite_config` VALUES ('smtp_port', '25');
INSERT INTO `clanlite_config` VALUES ('smtp_code', '');
INSERT INTO `clanlite_config` VALUES ('smtp_login', '');
INSERT INTO `clanlite_config` VALUES ('skin', 'ICGstation');
INSERT INTO `clanlite_config` VALUES ('get_version', '1');
INSERT INTO `clanlite_config` VALUES ('scan_game_server', 'udp');
INSERT INTO `clanlite_config` VALUES ('show_grade', '1');
INSERT INTO `clanlite_config` VALUES ('refresh', '1');
INSERT INTO `clanlite_config` VALUES ('heure_ete', '1');
INSERT INTO `clanlite_config` VALUES ('time_zone', '1');
INSERT INTO `clanlite_config` VALUES ('mp3_auto_start', '1');
INSERT INTO `clanlite_custom_menu` VALUES (1, 1, 'boutton_news', 'service/index_pri.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (2, 2, 'boutton_liste_membres_groupe', 'service/liste-des-membres-groupe.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (3, 3, 'boutton_forum', 'url_forum', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (4, 4, 'boutton_match', 'service/match.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (5, 5, 'boutton_calendrier', 'service/calendrier.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (6, 6, 'boutton_reglement', 'service/reglement.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (7, 7, 'boutton_result_match', 'service/rapport_match.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (8, 8, 'boutton_telecharger', 'service/download.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (9, 9, 'boutton_liens', 'service/liens.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (10, 10, 'boutton_org_rencontre', 'service/defier.php', '0', '1', '0', 0, '1');
INSERT INTO `clanlite_custom_menu` VALUES (11, 11, 'Un Bug !?', 'http://mantis.clanlite.org/', '0', '0', '0', 0, 'normal');
INSERT INTO `clanlite_custom_menu` VALUES (12, 11, 'boutton_liste_game', 'service/serveur_game_list.php', '0', '0', '0', 0, '1');
INSERT INTO `clanlite_game_server` VALUES (1, '0', '193.27.10.5', 27970, 'q3a');
INSERT INTO `clanlite_grades` VALUES (1, 20, 'Super chef');
INSERT INTO `clanlite_grades` VALUES (2, 15, 'chef');
INSERT INTO `clanlite_grades` VALUES (3, 10, 'sous chef');
INSERT INTO `clanlite_grades` VALUES (4, 5, 'soldat');
INSERT INTO `clanlite_grades` VALUES (5, 0, 'parazit');
INSERT INTO `clanlite_liens` VALUES (1, '', 'ClanLite, le portail', 'http://www.clanlite.org', 'http://logo.clanlite.org/clanlite4.jpg');
INSERT INTO `clanlite_module_partenaires_27` VALUES (1, 'Clanlite', 'http://www.clanlite.org', 'http://logo.clanlite.org/bouton.gif');
INSERT INTO `clanlite_modules` VALUES (4, 0, 'gauche', '1', 'Match  � Venir', 'match.php', '');
INSERT INTO `clanlite_modules` VALUES (5, 1, 'droite', '1', 'Compteur', 'compteur.php', '');
INSERT INTO `clanlite_modules` VALUES (6, 4, 'droite', '1', 'Serveur MOH', 'serveur_jeux.php', 'a:3:{s:7:"serveur";s:1:"7";s:5:"image";b:0;s:5:"liste";b:1;}');
INSERT INTO `clanlite_modules` VALUES (8, 6, 'gauche', '1', 'Last Match', 'dernier_match.php', '');
INSERT INTO `clanlite_modules` VALUES (10, 8, 'gauche', '1', 'Training', 'entrainements.php', '');
INSERT INTO `clanlite_modules` VALUES (12, 0, 'droite', '1', 'Google PUB', 'module_perso.php', '<div style="text-align: center">\r\n<script type="text/javascript"><!--\r\ngoogle_ad_client = "pub-4968198745281917";\r\ngoogle_ad_width = 125;\r\ngoogle_ad_height = 125;\r\ngoogle_ad_format = "125x125_as";\r\ngoogle_ad_channel ="";\r\n//--></script>\r\n<script type="text/javascript"\r\n  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">\r\n</script>\r\n</div>');
INSERT INTO `clanlite_modules` VALUES (21, 1, 'gauche', '1', 'Shoutbox', 'shoutbox.php', '');
INSERT INTO `clanlite_modules` VALUES (27, 5, 'droite', '1', 'Nos partenaires', 'partenaire.php', '');
INSERT INTO `clanlite_news` VALUES (14, 1079790784, 'ClanLite install�', 'Installation de ClanLite r�ussi :!: \r\nSi vous avez des probl�mes ou des questions  :>: vous pouvez prendre contact avec le support par [url=http://www.clanlite.org/service/contact.php]le site www.clanlite.org[/url].\r\n\r\nMerci d�avoir choisi ClanLite', 'narfight');
INSERT INTO `clanlite_section` VALUES (1, 'Section n�1', '0', '1');
INSERT INTO `clanlite_section` VALUES (2, 'Gestion', '1', '0');
INSERT INTO `clanlite_smilies` VALUES (44, ':D', 'mortderire.gif', 'super heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (45, ':-D', 'mortderire.gif', 'super heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (46, ':grin:', 'mortderire.gif', 'super heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (47, ':)', 'joyeux.gif', 'Heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (48, ':-)', 'joyeux.gif', 'Heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (49, ':smile:', 'joyeux.gif', 'Heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (50, ':(', 'triste.gif', 'Pas heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (51, ':-(', 'triste.gif', 'Pas heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (52, ':sad:', 'triste.gif', 'Pas heureux', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (54, ':-o', 'invisible.gif', '�tonn�', 18, 12);
INSERT INTO `clanlite_smilies` VALUES (55, ':eek:', 'dimoipasqsepavrai.gif', 'Choquer', 20, 41);
INSERT INTO `clanlite_smilies` VALUES (56, ':shock:', 'dimoipasqsepavrai.gif', 'Choquer', 20, 41);
INSERT INTO `clanlite_smilies` VALUES (58, ':-?', 'interro.gif', 'Confusion', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (60, '8)', 'lunettes.gif', 'Cool', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (61, '8-)', 'lunettes.gif', 'Cool', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (62, ':cool:', 'lunettes.gif', 'Cool', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (108, ':kiss:', 'bisou.gif', 'Je t''aime toi', 59, 57);
INSERT INTO `clanlite_smilies` VALUES (64, ':x', 'minederien.gif', 'M�content', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (65, ':-x', 'minederien.gif', 'M�content', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (66, ':mad:', 'minederien.gif', 'M�content', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (67, ':P', 'neuneu.gif', 'Razz', 24, 22);
INSERT INTO `clanlite_smilies` VALUES (68, ':-p', 'neuneu.gif', 'Razz', 24, 22);
INSERT INTO `clanlite_smilies` VALUES (69, ':razz:', 'neuneu.gif', 'Razz', 24, 22);
INSERT INTO `clanlite_smilies` VALUES (71, ':cry2:', 'triste.gif', 'Tr�s triste', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (72, ':evil:', 'pascontent.gif', 'Evil or Very Mad', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (73, ':twisted:', 'demon.gif', 'Twisted Evil', 22, 25);
INSERT INTO `clanlite_smilies` VALUES (74, ':roll:', 'triste2.gif', 'Chercher', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (75, ':wink:', 'cligne.gif', 'Wink', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (76, ';)', 'cligne.gif', 'Wink', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (77, ';-)', 'cligne.gif', 'Wink', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (78, ':!:', 'exclam.gif', 'Exclamation', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (79, ':?:', 'interro.gif', 'Question', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (80, ':idea:', 'ampoule.gif', 'id�e', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (81, ':>:', 'fleche.gif', 'fleche', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (82, ':|', 'credule.gif', 'Neutre', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (83, ':-|', 'credule.gif', 'Neutre', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (84, ':neutral:', 'credule.gif', 'Neutre', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (109, ':duel:', 'prizdetete.gif', 'Conversation anim�e', 42, 18);
INSERT INTO `clanlite_smilies` VALUES (92, 'Bp', 'lunettes.gif', 'Cool', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (93, '<(', 'fatigue.gif', 'fatiguer', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (112, ':bg:', 'bienjoue.gif', 'Bien jou�', 35, 31);
INSERT INTO `clanlite_smilies` VALUES (97, ':hug:', 'bisou.gif', 'Je t''aime toi', 59, 57);
INSERT INTO `clanlite_smilies` VALUES (98, ':gerbe:', 'malade.gif', 'BUUuuuuuurg', 21, 29);
INSERT INTO `clanlite_smilies` VALUES (110, ':blabla:', 'prizdetete.gif', 'Conversation anim�e', 42, 18);
INSERT INTO `clanlite_smilies` VALUES (111, ':dead:', 'mort.gif', 'Mort', 33, 18);
INSERT INTO `clanlite_smilies` VALUES (102, ':bave:', 'danslecul.gif', 'J''en bave', 21, 29);
INSERT INTO `clanlite_smilies` VALUES (106, '(a)', 'ange.gif', 'Ange', 35, 23);
INSERT INTO `clanlite_smilies` VALUES (107, ':angel:', 'ange.gif', 'Ange', 35, 23);
INSERT INTO `clanlite_smilies` VALUES (113, ':bof:', 'bof.gif', 'Sans plus', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (114, ':pfff:', 'burp.gif', 'Chiant', 26, 18);
INSERT INTO `clanlite_smilies` VALUES (115, ':evil2:', 'colere.gif', 'Furax', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (116, ':fou:', 'fou.gif', 'Fou', 23, 24);
INSERT INTO `clanlite_smilies` VALUES (117, ':monster:', 'frankenstein.gif', 'Frankenstein', 25, 28);
INSERT INTO `clanlite_smilies` VALUES (118, ':fuck:', 'fuck.gif', 'Fuck', 37, 30);
INSERT INTO `clanlite_smilies` VALUES (119, ':crier:', 'gueulard.gif', 'Crier', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (120, ':pirate:', 'pirate.gif', 'Pirate', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (121, ':naze:', 'naze2.gif', 'Pfff, naze', 49, 31);
INSERT INTO `clanlite_smilies` VALUES (122, ':oops:', 'penaud.gif', 'Embarass�', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (123, ':herbe:', 'petard.gif', 'Petard', 32, 20);
INSERT INTO `clanlite_smilies` VALUES (124, ':zen:', 'respect.gif', 'Respect', 23, 18);
INSERT INTO `clanlite_smilies` VALUES (125, ':sournois:', 'sournois.gif', 'Sournois', 20, 18);
INSERT INTO `clanlite_smilies` VALUES (126, ':lol:', 'stupidking.gif', 'lol', 24, 29);
INSERT INTO `clanlite_smilies` VALUES (127, ':jessica:', 'jessica.gif', 'Jessica', 26, 30);
INSERT INTO `clanlite_smilies` VALUES (128, ':cruella:', 'cruella.gif', 'Cruella', 26, 30);
INSERT INTO `clanlite_smilies` VALUES (129, ':black:', 'jackson5.gif', 'Black', 32, 33);
INSERT INTO `clanlite_smilies` VALUES (130, ':happy:', 'happyjump.gif', 'Super mega happy', 50, 34);
INSERT INTO `clanlite_smilies` VALUES (131, ':jumpsad:', 'sadjump.gif', 'Je vais tout casser', 50, 34);
INSERT INTO `clanlite_equipe` VALUES (1, 'Sniper', 'Les Snipers tout simplement');
INSERT INTO `clanlite_equipe` VALUES (4, 'Rusher', 'une petit SMG ou une M1 et op on fonce chez les pas gentil  LOL ');