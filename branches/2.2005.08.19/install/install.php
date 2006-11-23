<?php
error_reporting(E_ALL);

// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// Correction de Dolordo <dolordo@free.fr>
// -------------------------------------------------------------
$root_path = '../';
if (file_exists($root_path.'config.php'))
{
	require($root_path.'config.php');
	if (!isset($_POST['readme']) && defined('CL_INSTALL'))
	{
		//evite de relancer l'installation si il laisse le fichier en place
		header('Location: '.$root_path."install/update.php\n");
		exit();
	}
}
if (isset($_POST['dl_config_php']))
{
	header('Content-Type: text/x-delimtext; name="config.php"');
	header('Content-disposition: attachment; filename=config.php');
	$contenu = '<?php'."\n";
	$contenu .= '// -------------------------------------------------------------'."\n";
	$contenu .= '// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]'."\n";
	$contenu .= '// -------------------------------------------------------------'."\n";
	$contenu .= 'define(\'CL_INSTALL\', true);'."\n";
	$contenu .= '$mysqlhost = \''.$_POST['serveur_mysql'].'\';'."\n";
	$contenu .= '$login = \''.$_POST['login_mysql'].'\';'."\n";
	$contenu .= '$password = \''.$_POST['code_mysql'].'\';'."\n";
	$contenu .= '$base = \''.$_POST['bd_mysql'].'\';'."\n";
	$contenu .= '$config[\'prefix\'] = \''.$_POST['prefix_mysql'].'\';'."\n";
	$contenu .= '$config[\'db_type\'] = \''.$_POST['db_type'].'\';'."\n";
	$contenu .= '?>';
	echo $contenu;
	exit;
}
require($root_path.'conf/template.php');
include($root_path.'conf/'.((!empty($_POST['db_type']))? $_POST['db_type'] : 'mysql').'.php');
require($root_path.'conf/lib.php');

$config['raport_error'] = false;
$rsql = new mysql();

$template = new Template($root_path.'install/');
$template->set_filenames( array('body' => 'install.tpl'));

// affiche où nous en sommes dans l'installation ou l'update
if (isset($_POST['send_config']))
{
	$_POST['etape'] = 3;
}

if (isset($_POST['readme']))
{
	$_POST['etape'] = 4;
}

if (isset($_GET['update']))
{
	if (!isset($_POST['etape']))
	{
		$_POST['etape'] = 1;
	}
	$template->assign_block_vars('update_menu', array(
		'PLACER_B' => '<strong>',
		'PLACER_B_END' => '</strong>'
	));
	$template->assign_vars(array('URL' => '?update=true'));
	
	//création du fichier config.php et autorise sont édition
	if (is_file($root_path.'erreur_sql.txt'))
	{// le fichier existe
		if (!is_writable($root_path.'erreur_sql.txt'))
		{
			@chmod($root_path.'erreur_sql.txt', 0777);
		}
	}
	else
	{// le fichier n'existe pas
		//on tente de le creer
		$handle = fopen($root_path.'erreur_sql.txt', 'w');
 		if ($handle)
 		{
			@chmod($root_path.'erreur_sql.txt', 0777);
			fclose($handle);
 		}
	}
}
else
{
	if (!isset($_POST['etape']))
	{
		$_POST['etape'] = 0;
		$TPL['VERIF_B'] = '<strong>';
		$TPL['VERIF_B_END'] = '</strong>';
	}
	if ($_POST['etape'] == 1)
	{
		$TPL['INSTALL_B'] = '<strong>';
		$TPL['INSTALL_B_END'] = '</strong>';
	}
	if ($_POST['etape'] == 2)
	{
		$TPL['MYSQL_B'] = '<strong>';
		$TPL['MYSQL_B_END'] = '</strong>';
	}
	if ($_POST['etape'] == 3)
	{
		$TPL['CONFIG_B'] = '<strong>';
		$TPL['CONFIG_B_END'] = '</strong>';
	}
	if ($_POST['etape'] == 4)
	{
		$TPL['FIN_B'] = '<strong>';
		$TPL['FIN_B_END'] = '</strong>';
	}
	
	$template->assign_block_vars('install_menu', $TPL);
}
if ($_POST['etape'] == 0)
{
	// vérification avant l'installation
	if (function_exists('mail'))
	{
		$TPL_BLOCK['MAIL'] = '<span class="ok">Possible</span>';
	}
	else
	{
		$TPL_BLOCK['MAIL'] = '<span class="erreur">Désactivé, Il doit surement avoir moyen en SMTP</span>';
	}

	if(version_compare(phpversion(),'4.3.0') >= 0)
	{
		$TPL_BLOCK['VERSION'] = '<span class="ok">version '.phpversion().' OK</span>';
	}
	else
	{
		$TPL_BLOCK['VERSION'] = '<span class="erreur">version '.phpversion().' certainnes options risque de ne pas fonctionner correctement</span>';
	}

	//verif des droits d'ecriture
	if (is_file($root_path.'config.php'))
	{// le fichier existe
		if (is_writable($root_path.'config.php'))
		{
			$TPL_BLOCK['CONFIG'] = '<span class="ok">Peut être modifié</span>';
		}
		else
		{
			if (@chmod($root_path.'config.php', 0777))
			{
				$TPL_BLOCK['CONFIG'] = '<span class="ok">Peut être modifié</span>';
			}
			else
			{
				$TPL_BLOCK['CONFIG'] = '<span class="erreur">Vous devez métre en chmod 777 depuis votre programme FTP</span>';
			}
		}
	}
	else
	{// le fichier n'existe pas
		//on tente de le creer
		$handle = fopen($root_path.'config.php', 'w');
 		if ($handle)
 		{
			if (@chmod($root_path.'config.php', 0777))
			{
				$TPL_BLOCK['CONFIG'] = '<span class="ok">Peut être modifié</span>';
			}
			else
			{
				$TPL_BLOCK['CONFIG'] = '<span class="erreur">Vous devez métre en chmod 777 depuis votre programme FTP</span>';
			}
			fclose($handle);
 		}
 		else
 		{
 			$TPL_BLOCK['CONFIG'] = '<span class="erreur">Il vous sera surement demandé de le placé manuellement</span>';
 		}
	}

	//verif des droits d'ecriture
	if (is_file($root_path.'erreur_sql.txt'))
	{// le fichier existe
		if (is_writable($root_path.'erreur_sql.txt'))
		{
			$TPL_BLOCK['ERREUR_SQL'] = '<span class="ok">Peut être modifié</span>';
		}
		else
		{
			if (@chmod($root_path.'erreur_sql.txt', 0777))
			{
				$TPL_BLOCK['ERREUR_SQL'] = '<span class="ok">Peut être modifié</span>';
			}
			else
			{
				$TPL_BLOCK['ERREUR_SQL'] = '<span class="erreur">Vous devez métre en chmod 777 depuis votre programme FTP</span>';
			}
		}
	}
	else
	{// le fichier n'existe pas
		//on tente de le creer
		$handle = fopen($root_path.'erreur_sql.txt', 'w');
 		if ($handle)
 		{
			if (@chmod($root_path.'erreur_sql.txt', 0777))
			{
				$TPL_BLOCK['ERREUR_SQL'] = '<span class="ok">Peut être modifié</span>';
			}
			else
			{
				$TPL_BLOCK['ERREUR_SQL'] = '<span class="erreur">Vous devez métre en chmod 777 depuis votre programme FTP</span>';
			}
			fclose($handle);
 		}
 		else
 		{
 			$TPL_BLOCK['ERREUR_SQL'] = '<span class="erreur">Il vous sera surement demandé de le placé manuellement</span>';
 		}
	}
	$template->assign_block_vars('verification', $TPL_BLOCK);
}
if ($_POST['etape'] == 1)
{

	$TPL_BLOCK['MYSQL'] = (!empty($_POST['serveur_mysql']))? $_POST['serveur_mysql'] : '';
	$TPL_BLOCK['DB_TYPE_MYSQL'] = (empty($_POST['db_type']) || $_POST['db_type'] === 'mysql')? ' selected="selected"' : '';
	$TPL_BLOCK['DB_TYPE_MYSQLI'] = (!empty($_POST['db_type']) && $_POST['db_type'] === 'mysqli')? ' selected="selected"' : '';
	$TPL_BLOCK['MYSQL_LOGIN'] = (!empty($_POST['login_mysql']))? $_POST['login_mysql'] : '';
	$TPL_BLOCK['MYSQL_CODE'] = (!empty($_POST['code_mysql']))? $_POST['code_mysql'] : '';
	$TPL_BLOCK['MYSQL_DB'] = (!empty($_POST['bd_mysql']))? $_POST['bd_mysql'] : '';
	$TPL_BLOCK['MYSQL_PREFIX'] = (!empty($_POST['prefix_mysql']))? $_POST['prefix_mysql'] : 'clanlite_';
	$TPL_BLOCK['USER_LOGIN'] = (!empty($_POST['user_mail']))? $_POST['user_login'] : '';
	$TPL_BLOCK['USER_CODE'] = (!empty($_POST['user_mail']))? $_POST['user_code'] : '';
	$TPL_BLOCK['USER_MAIL'] = (!empty($_POST['user_mail']))? $_POST['user_mail'] : '';
	
	$template->assign_block_vars('configuration', $TPL_BLOCK);
	if (!isset($_GET['update']))
	{
		$template->assign_block_vars('configuration.profil', array(''));
	}

	$dir = '../templates/';
	// Ouvre un dossier bien connu, et liste tous les fichiers
	if (is_dir($dir))
	{
		if ($dh = opendir($dir))
		{
			if (!isset($_POST['skin']))
			{
				$_POST['skin'] = 'ICGstation';
			}

			while (($file = readdir($dh)) !== false)
			{
				if($file != '..' && $file !='.' && $file !='' && is_dir($dir.$file))
				{
					$template->assign_block_vars('configuration.liste_skin', array(
					'FILE' => $file,
					'SELECTED' => ($_POST['skin'] == $file) ? 'selected="selected"' : '',
					));
				}
			}
			closedir($dh);
		}
	}
}

if ($_POST['etape'] == 2)
{
	$TPL_BLOCK['MYSQL'] = (!empty($_POST['serveur_mysql']))? $_POST['serveur_mysql'] : '';
	$TPL_BLOCK['DB_TYPE'] = (empty($_POST['db_type']) || $_POST['db_type'] === 'mysql')? 'mysql' : 'mysqli';
	$TPL_BLOCK['MYSQL_LOGIN'] = (!empty($_POST['login_mysql']))? $_POST['login_mysql'] : '';
	$TPL_BLOCK['MYSQL_CODE'] = (!empty($_POST['code_mysql']))? $_POST['code_mysql'] : '';
	$TPL_BLOCK['MYSQL_DB'] = (!empty($_POST['bd_mysql']))? $_POST['bd_mysql'] : '';
	$TPL_BLOCK['MYSQL_PREFIX'] = (!empty($_POST['prefix_mysql']))? $_POST['prefix_mysql'] : 'clanlite_';
	$TPL_BLOCK['USER_LOGIN'] = (!empty($_POST['user_mail']))? $_POST['user_login'] : '';
	$TPL_BLOCK['USER_CODE'] = (!empty($_POST['user_mail']))? $_POST['user_code'] : '';
	$TPL_BLOCK['USER_MAIL'] = (!empty($_POST['user_mail']))? $_POST['user_mail'] : '';
	$TPL_BLOCK['SKIN'] = (!empty($_POST['skin']))? $_POST['skin'] : 'ICGstation';
	
	$connection = $rsql->mysql_connection($_POST['serveur_mysql'], $_POST['login_mysql'], $_POST['code_mysql'], $_POST['bd_mysql']);
	
	// Vérifier que tout est correctement rempli
	if (isset($_GET['update']))
	{
		if (!$connection)
		{
			$template->assign_block_vars('configuration_erreur', $TPL_BLOCK);
			$template->assign_block_vars('configuration_erreur.mysql', array('ERREUR' => $rsql->error));
		}
		else
		{
			$_POST['etape'] = 3;
		}
	}
	else
	{
		if (empty($_POST['user_login']) || empty($_POST['user_code']) || empty($_POST['user_mail']) || empty($_POST['skin']) || !$connection)
		{
			$template->assign_block_vars('configuration_erreur', $TPL_BLOCK);
	
			if (!$connection)
			{
				$template->assign_block_vars('configuration_erreur.mysql', array('ERREUR' => $rsql->error));
			}
			if (empty($_POST['user_login']) || empty($_POST['user_code']) || empty($_POST['user_mail']) || empty($_POST['skin']))
			{
				$template->assign_block_vars('configuration_erreur.vide', array(''));
			}
		}
		else
		{
			$template->assign_block_vars('install', $TPL_BLOCK);
			// installation de la structure
			$db_file = $root_path.'install/requette_install_structure.sql';
			$get_rsql = @fread(@fopen($db_file, 'r'), @filesize($db_file));
			$get_rsql = preg_replace('/\s/', ' ', $get_rsql);
			$get_rsql = str_replace("\s", " ", $get_rsql);
			$get_rsql = str_replace(";", ";\n", $get_rsql);
			$get_rsql = str_replace("'", "\'", $get_rsql);
			$get_rsql = preg_replace('#CREATE TABLE `([a-zA-Z0-9_-é]*)`(.*)TYPE=MyISAM#i', "\n".'$rsql_array[\'$1\'] = \'$2\';', $get_rsql);
	
			eval($get_rsql);
			$nombre = 0;
			$log_erreur_structure = true;
	
			foreach($rsql_array as $nom_db => $exec_db)
			{
				$nom_db = str_replace('clanlite_', $_POST['prefix_mysql'], $nom_db);
				if( ($rsql->requete_sql('CREATE TABLE `'.$nom_db.'`'.$exec_db)) )
				{
					$show_table_install[$nombre]['result'] = '<span class="ok">Installé correctement</span>';
				}
				else
				{
					$show_table_install[$nombre]['result'] = '<span class="erreur">Erreur ('.$rsql->error.')</span>';
					$log_erreur_structure = false;
				}
				$show_table_install[$nombre]['table'] = str_replace('clanlite_', $_POST['prefix_mysql'], $nom_db);
				$nombre++;
			}
			unset($rsql_array,$nombre);
			
			// remplissage des tables
			$db_file = $root_path.'install/requette_install_donnes.sql';
			$get_rsql = @fread(@fopen($db_file, 'r'), @filesize($db_file));
			$get_rsql = str_replace("\'", "&#0R389 ;", $get_rsql);
			$get_rsql = str_replace("'", "\'", $get_rsql);  //protéger des ' par des \
			$get_rsql = preg_replace('#INSERT INTO ([a-zA-Z0-9_-é]*) VALUES \((.*)\);#i', '$rsql_array[\'$2\'] = \'$1\';', $get_rsql);
			eval($get_rsql);
			
			// ajoute l'administrateur
			$rsql_array["'', '', '".$_POST['user_login']."', '".$_POST['user_mail']."', '', MD5('".$_POST['user_code']."'), 'admin', '', '0', '', '', '0', '1', '1', '', '', '0', '', '', '', '0', '', '0', '', '', 'francais'"] = 'clanlite_user';
			$nombre = 0;
			$log_erreur_données = true;
			foreach($rsql_array as $exec_db => $nom_db)
			{
				$exec_db = str_replace("&#0R389 ;", "\'", $exec_db);
				$nom_db = str_replace('clanlite_', $_POST['prefix_mysql'], $nom_db);
				if( ($rsql->requete_sql('INSERT INTO '.$nom_db.' VALUES ('.$exec_db.')')) )
				{
					$show_exec_install[$nombre]['result'] = '<span class="ok">Installé correctement</span>';
				}
				else
				{
					$show_exec_install[$nombre]['result'] = '<span class="erreur">Erreur ('.$rsql->error.')</span>';
					$log_erreur_données = false;
				}
				$show_exec_install[$nombre]['table'] = str_replace('clanlite_', $_POST['prefix_mysql'], $nom_db);
				$nombre++;
			}
			unset($rsql_array,$nombre);
			// configuration minimal
			$log_erreur_config_min = true;
			$nombre = 0;
			$rsql_array = array(
				'site_domain' => 'http://'.$_SERVER['HTTP_HOST'],
				'site_path' => str_replace('install', '', dirname($_SERVER['PHP_SELF'])),
				'compteur' => 0,
				'nbr_membre' => 1,
				'master_mail' => $_POST['user_mail'],
				'skin' => $_POST['skin'],
			);
	
			foreach($rsql_array as $nom_var => $exec_db)
			{
				if( ($rsql->requete_sql('UPDATE '.$_POST['prefix_mysql'].'config SET conf_valeur=\''.$exec_db.'\' WHERE conf_nom=\''.$nom_var.'\'')) )
				{
					$show_config_min[$nombre]['result'] = '<span class="ok">Installé correctement</span>';
				}
				else
				{
					$show_config_min[$nombre]['result'] = '<span class="erreur">Erreur ('.$rsql->error.')</span>';
					$log_erreur_config_min = false;
				}
				$show_config_min[$nombre]['info'] = $nom_var;
				$nombre++;
			}
	
			if ($log_erreur_structure)
			{
				$status = '<span class="ok">Installé correctement</span>';
			}
			else
			{
				$status = '<span class="erreur">Erreur</span>';
			}
	
			$template->assign_block_vars('install.action', array(
				'ID' => 0,
				'TITRE' => 'Création des bases de données',
				'STATUS' => $status,
			));
	
			foreach($show_table_install as $id => $info)
			{
				$template->assign_block_vars('install.action.liste', array(
				'ACTION' => 'Création de '.$info['table'],
				'RESULTAT' => $info['result'],
				));
			}
	
			if ($log_erreur_données)
			{
				$status = '<span class="ok">Installé correctement</span>';
			}
			else
			{
				$status = '<span class="erreur">Erreur</span>';
			}
	
			$template->assign_block_vars('install.action', array(
				'ID' => 1,
				'TITRE' => 'Remplissage des bases de données',
				'STATUS' => $status,
			));
	
			foreach($show_exec_install as $id => $info)
			{
				$template->assign_block_vars('install.action.liste', array(
					'ACTION' => 'Création de '.$info['table'],
					'RESULTAT' => $info['result'],
				));
			}
	
			if ($log_erreur_config_min)
			{
				$status = '<span class="ok">Installé correctement</span>';
			}
			else
			{
				$status = '<span class="erreur">Erreur</span>';
			}
	
			$template->assign_block_vars('install.action', array(
			'ID' => 2,
			'TITRE' => 'Configuration minimal du portail',
			'STATUS' => $status,
			));
	
			foreach($show_config_min as $id => $info)
			{
				$template->assign_block_vars('install.action.liste', array(
				'ACTION' => 'Varriable '.$info['info'],
				'RESULTAT' => $info['result'],
				));
			}
		}
	}
}

if ($_POST['etape'] == 3)
{
	$contenu = '<?php'."\n";
	$contenu .= '// -------------------------------------------------------------'."\n";
	$contenu .= '// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]'."\n";
	$contenu .= '// -------------------------------------------------------------'."\n";
	$contenu .= 'define(\'CL_INSTALL\', true);'."\n";
	$contenu .= '$mysqlhost = \''.$_POST['serveur_mysql'].'\';'."\n";
	$contenu .= '$login = \''.$_POST['login_mysql'].'\';'."\n";
	$contenu .= '$password = \''.$_POST['code_mysql'].'\';'."\n";
	$contenu .= '$base = \''.$_POST['bd_mysql'].'\';'."\n";
	$contenu .= '$config[\'prefix\'] = \''.$_POST['prefix_mysql'].'\';'."\n";
	$contenu .= '$config[\'db_type\'] = \''.$_POST['db_type'].'\';'."\n";
	$contenu .= '?>';

	$TPL_BLOCK['MYSQL'] = (!empty($_POST['serveur_mysql']))? $_POST['serveur_mysql'] : '';
	$TPL_BLOCK['DB_TYPE_MYSQL'] = (empty($_POST['db_type']) || $_POST['db_type'] === 'mysql')? ' selected="selected"' : '';
	$TPL_BLOCK['DB_TYPE_MYSQLI'] = (!empty($_POST['db_type']) && $_POST['db_type'] === 'mysqli')? ' selected="selected"' : '';
	$TPL_BLOCK['MYSQL_LOGIN'] = (!empty($_POST['login_mysql']))? $_POST['login_mysql'] : '';
	$TPL_BLOCK['MYSQL_CODE'] = (!empty($_POST['code_mysql']))? $_POST['code_mysql'] : '';
	$TPL_BLOCK['MYSQL_DB'] = (!empty($_POST['bd_mysql']))? $_POST['bd_mysql'] : '';
	$TPL_BLOCK['MYSQL_PREFIX'] = (!empty($_POST['prefix_mysql']))? $_POST['prefix_mysql'] : 'clanlite_';
	$TPL_BLOCK['USER_LOGIN'] = (!empty($_POST['user_mail']))? $_POST['user_login'] : '';
	$TPL_BLOCK['USER_CODE'] = (!empty($_POST['user_mail']))? $_POST['user_code'] : '';
	$TPL_BLOCK['USER_MAIL'] = (!empty($_POST['user_mail']))? $_POST['user_mail'] : '';
	
	$template->assign_block_vars('place', $TPL_BLOCK);
	//tentative de création du fichier ou simplement l'ouverture
	if($open_fichier = fopen($root_path.'config.php', 'w'))
	{
		if(fwrite($open_fichier, $contenu))
		{
			$template->assign_block_vars('place.manuel_oui', array('TXT' => '<span class="ok">config.php placé</span>'));
			fclose($open_fichier);
			$config_result_b = true;
		}
		else
		{
			$template->assign_block_vars('place.manuel_non', array('TXT' => '<span class="erreur">l\'ecriture a echoué</span>'));
			$config_result_b = false;
		}
	}
	else
	{
		$template->assign_block_vars('place.manuel_non', array('TXT' => '<span class="erreur">erreur a l\'ouverture du fichier</span>'));
		$config_result_b = false;
	}
}

if ($_POST['etape'] == 4)
{
	if (!defined('CL_INSTALL'))
	{// le fichier config.php n'est pas bien placé
		$TPL_BLOCK['MYSQL'] = (!empty($_POST['serveur_mysql']))? $_POST['serveur_mysql'] : '';
		$TPL_BLOCK['DB_TYPE_MYSQL'] = (empty($_POST['db_type']) || $_POST['db_type'] === 'mysql')? ' selected="selected"' : '';
		$TPL_BLOCK['DB_TYPE_MYSQLI'] = (!empty($_POST['db_type']) && $_POST['db_type'] === 'mysqli')? ' selected="selected"' : '';
		$TPL_BLOCK['MYSQL_LOGIN'] = (!empty($_POST['login_mysql']))? $_POST['login_mysql'] : '';
		$TPL_BLOCK['MYSQL_CODE'] = (!empty($_POST['code_mysql']))? $_POST['code_mysql'] : '';
		$TPL_BLOCK['MYSQL_DB'] = (!empty($_POST['bd_mysql']))? $_POST['bd_mysql'] : '';
		$TPL_BLOCK['MYSQL_PREFIX'] = (!empty($_POST['prefix_mysql']))? $_POST['prefix_mysql'] : 'clanlite_';
		$TPL_BLOCK['USER_LOGIN'] = (!empty($_POST['user_mail']))? $_POST['user_login'] : '';
		$TPL_BLOCK['USER_CODE'] = (!empty($_POST['user_mail']))? $_POST['user_code'] : '';
		$TPL_BLOCK['USER_MAIL'] = (!empty($_POST['user_mail']))? $_POST['user_mail'] : '';
		$template->assign_block_vars('readme_erreur', $TPL_BLOCK);
	}
	else
	{
		if (isset($_GET['update']))
		{
			header('Location: '.$root_path."install/update.php\n");
			exit();
		}
		$template->assign_block_vars('readme', array(''));
	}
}
$template->pparse('body');
?>