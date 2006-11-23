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
	if (empty($_POST['readme']) && defined('CL_INSTALL'))
	{//evite de relancer l'installation si il laisse le fichier en place
		header('Location: '.$root_path."\n");
		exit();
	}
}
if (!empty($_POST['dl_config_php']))
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
require($root_path.'conf/'.((!empty($_POST['db_type']))? $_POST['db_type'] : 'mysql').'.php');
require($root_path.'conf/lib.php');
$config['raport_error'] = false;
$rsql = new mysql();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../templates/BlueStar/Library/styles.css" rel="stylesheet" type="text/css" />
<LINK REL="SHORTCUT ICON" HREF="../templates/BlueStar/images/favicon.gif" />
<style type="text/css">
<!--
.erreur {color: red;FONT-WEIGHT: bold}
.ok {color: green;FONT-WEIGHT: bold}
.annulé {color: orange;FONT-WEIGHT: bold}
-->
</style>
<script type="text/javascript" src="../templates/BlueStar/Library/lib.js"></script>
<title>Installation</title>
</head>
<body>
<div id="flash_poper" class="flash_poper"></div>
<div class="cadre_largeur_admin"> 
  <div class="hautpage"> 
    <object type="application/x-shockwave-flash" width="898" height="84" data="../templates/BlueStar/images/ban_head.swf"> 
      <param name="movie" value="../templates/BlueStar/images/ban_head.swf" /> 
    </object> 
  </div> 
  <div class="menuliens">Installation de ClanLite</div> 
<div class="colonne_gauche">
    <div class="module"> 
      <div class="module_titre">Avancement</div> 
      <div class="module_cellule">
	  	<ul>
			<li><?php if(empty($_POST['readme']) && empty($_POST['connect_ftp']) && empty($_POST['install']) && empty($_POST['connect_mysql']) && empty($_POST['send_config'])) { echo "<b>[=]</b>"; } ?>Vérification</li>
			<li><?php if(!empty($_POST['install'])) { echo "<b>[=]</b>"; } ?>Configuration</li>
			<li><?php if(!empty($_POST['connect_mysql'])) { echo "<b>[=]</b>"; } ?>installation</li>
			<li><?php if(!empty($_POST['send_config']) || !empty($_POST['connect_ftp'])) { echo "<b>[=]</b>"; } ?>place config.php</li>
			<li><?php if(!empty($_POST['readme'])) { echo "<b>[=]</b>"; } ?>Note de fin</li>
		</ul>
	</div> 
      <div class="module_foot"></div> 
    </div> 
</div>
<div class="colonne_central_admin">
<div class="big_cadre">
<?php
if (empty($_POST['readme']) && empty($_POST['connect_ftp']) && empty($_POST['install']) && empty($_POST['connect_mysql']) && empty($_POST['send_config']))//verif des droits d'ecriture
{
	$can_mail = (function_exists('mail'))? "<span class=\"ok\">Possible</span>" : "<span class=\"erreur\">Désactivé</span>";
	$good_version = (version_compare(phpversion(),'4.3.0') >= 0)? "<span class=\"ok\">version ".phpversion()." OK</span>" : "<span class=\"erreur\">version ".phpversion()." certainnes options risque de ne pas fonctionner correctement</span>";
	if (is_writable($root_path."config.php"))
	{
		$can_config = "<span class=\"ok\">Peut être modifié</span>";
	}
	else
	{
		if (@chmod($root_path."config.php", 0777))
		{
			$can_config = "<span class=\"ok\">Peut être modifié</span>";
		}
		else
		{
			$can_config = "<span class=\"erreur\">Non trouvé ou écriture interdite</span>";
		}
	}
	if (is_writable($root_path."erreur_sql.txt"))
	{
		$can_erreur_sql = "<span class=\"ok\">Peut être modifié</span>";
	}
	else
	{
		if (@chmod($root_path."erreur_sql.txt", 0777))
		{
			$can_erreur_sql = "<span class=\"ok\">Peut être modifié</span>";
		}
		else
		{
			$can_erreur_sql = "<span class=\"erreur\">Non trouvé ou écriture interdite</span>";
		}
	}
?>
<h1>Vérification</h1>
<ul>
  <li>Version du serveur PHP =< 4.3.0 : <b><?php echo $good_version ?></b></li>
  <li>Enregistrement des erreurs : <b><?php echo $can_erreur_sql ?></b> (pas important)</li>
  <li>droit d'ecriture sur le fichier de config : <b><?php echo $can_config ?></b> (pas important)</li>
  <li>envois de mail : <b><?php echo $can_mail ?></b> (pas important)</li>
</ul>
<form action="install.php" method="post">
<input name="retry" type="submit" value="Revérifier" />
<input name="install" type="submit" value="Continuer l'installation" />
</form>
<?php
}
elseif (!empty($_POST['install']))
{?>
<h1>Configuration</h1>
<form action="install.php" method="post">
<p>
	<span>
	<label for="serveur_mysql">Serveur&nbsp;MySQL :</label>
	</span>
	<span><input name="serveur_mysql" id="serveur_mysql" type="text" value="<?php echo (!empty($_POST['serveur_mysql']))? $_POST['serveur_mysql'] : '' ?>" /></span>
</p>
<p>
	<span><label for="login_mysql">Type de base de donnée&nbsp;:</label></span>
	<span>
		<select name="db_type">
			<option value="mysql"<?php echo (empty($_POST['db_type']) || $_POST['db_type'] === 'mysql')? ' selected="selected"' : '' ?>>MySQL</option>
			<option value="mysqli"<?php echo (!empty($_POST['db_type']) && $_POST['db_type'] === 'mysqli')? ' selected="selected"' : '' ?>>MySQLi</option>
		</select>
	</span>
</p>
<p>
	<span><label for="login_mysql">Login&nbsp;:</label></span>
	<span><input name="login_mysql" id="login_mysql" type="text" value="<?php echo (!empty($_POST['login_mysql']))? $_POST['login_mysql'] : '' ?>" /></span>
</p>
<p>
	<span><label for="code_mysql">Code&nbsp;:</label></span>
	<span><input name="code_mysql" id="code_mysql" type="password" value="<?php echo (!empty($_POST['code_mysql']))? $_POST['code_mysql'] : '' ?>" /></span>
</p>
<p>
	<span><label for="bd_mysql">Base de donnée&nbsp;:</label></span>
	<span><input name="bd_mysql" id="bd_mysql" type="text" value="<?php echo (!empty($_POST['bd_mysql']))? $_POST['bd_mysql'] : '' ?>" /></span>
</p>
<p>
	<span><label for="prefix_mysql">Préfix des tables&nbsp;:</label></span>
	<span><input name="prefix_mysql" id="prefix_mysql" type="text" value="<?php echo (!empty($_POST['prefix_mysql']))? $_POST['prefix_mysql'] : "clanlite_" ?>" /></span>
</p>
<p>
	<span><label for="user_login">Login admin&nbsp;:</label></span>
	<span><input name="user_login" id="user_login" type="text" value="<?php echo (!empty($_POST['user_login']))? $_POST['user_login'] : '' ?>" /></span>
</p>
<p>
	<span><label for="user_code">Code admin&nbsp;:</label></span>
	<span><input name="user_code" id="user_code" type="password" value="<?php echo (!empty($_POST['user_code']))? $_POST['user_code'] : '' ?>" /></span>
</p>
<p>
	<span><label for="user_mail">Mail admin&nbsp;:</label></span>
	<span><input name="user_mail" id="user_mail" type="text" value="<?php echo (!empty($_POST['user_mail']))? $_POST['user_mail'] : '' ?>" /></span>
</p>
<p>
	<span><label for="skin">Skin du portail&nbsp;:</label></span>
	<span>
			<select name="skin" id="skin">
<?php
$dir = "../templates/";
// Ouvre un dossier bien connu, et liste tous les fichiers
if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if($file != '..' && $file !='.' && $file !='' && is_dir($dir.$file))
			{ 
				$selected = ($_POST['skin'] == $file) ? 'selected="selected"' : '';
				echo '				<option value="'.$file.'" '.$selected.'>'.$file.'</option>'."\n";
			}
		}
		closedir($dh);
	}
}
?>
			</select>
	</span>
</p>
<p>
	<span>
		<input type="submit" name="connect_mysql" value="Envoyer" />
	</span>
</p>
</form>
<?php
}
elseif (!empty($_POST['connect_mysql']))
{
	$connection = $rsql->mysql_connection($_POST['serveur_mysql'], $_POST['login_mysql'], $_POST['code_mysql'], $_POST['bd_mysql']);
	$connection_txt = "<span class=\"ok\">Connecté au serveur</span>";
	if ($connection != "true")
	{
		$connection_txt = "<span class=\"erreur\">Erreur à la connection (".$connection.")</span><form action=\"install.php\" method=\"post\">
		<input name=\"serveur_mysql\" type=\"hidden\" id=\"serveur_mysql\" value=\"".$_POST['serveur_mysql']."\" />
		<input name=\"db_type\" type=\"hidden\" id=\"db_type\" value=\"".$_POST['db_type']."\" />
		<input name=\"prefix_mysql\" type=\"hidden\" id=\"prefix_mysql\" value=\"".$_POST['prefix_mysql']."\" />
		<input name=\"login_mysql\" type=\"hidden\" id=\"login_mysql\" value=\"".$_POST['login_mysql']."\" />
		<input name=\"code_mysql\" type=\"hidden\" id=\"code_mysql\" value=\"".$_POST['code_mysql']."\" />
		<input name=\"bd_mysql\" type=\"hidden\" id=\"bd_mysql\" value=\"".$_POST['bd_mysql']."\" />
		<input name=\"user_login\" type=\"hidden\" id=\"user_login\" value=\"".$_POST['user_login']."\" />
		<input name=\"user_code\" type=\"hidden\" id=\"user_code\" value=\"".$_POST['user_code']."\" />
		<input name=\"user_mail\" type=\"hidden\" id=\"user_mail\" value=\"".$_POST['user_mail']."\" />
		<input name=\"skin\" type=\"hidden\" id=\"skin\" value=\"".$_POST['skin']."\" />
		<input type=\"submit\" name=\"install\" value=\"Reconfigurer la connection\" /></form>";
	}
?>
<h1>Connection et installation</h1>
<ul>
	<li>Connection à Mysql : <?php echo $connection_txt ?></li>
<?php
if ($connection == "true")
{ 
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
		$nom_db = str_replace("clanlite_", $_POST['prefix_mysql'], $nom_db);
		if( ($rsql->requete_sql("CREATE TABLE `".$nom_db."`".$exec_db)) )
		{
			$show_table_install[$nombre]['result'] = "<span class=\"ok\">Installé correctement</span>";
		}
		else
		{
			$show_table_install[$nombre]['result'] = "<span class=\"erreur\">Erreur (".$rsql->error.")</span>";
			$log_erreur_structure = false;
		}
		$show_table_install[$nombre]['table'] = str_replace("clanlite_", $_POST['prefix_mysql'], $nom_db);
		$nombre++;
	}
	unset($rsql_array,$nombre);
	// remplissage des tables
	$db_file = $root_path.'install/requette_install_donnes.sql';
	$get_rsql = @fread(@fopen($db_file, 'r'), @filesize($db_file));
	$get_rsql = str_replace("\'", "&#0R389 ;", $get_rsql);
	$get_rsql = str_replace("'", "\'", $get_rsql);  //protége des ' par des \
	$get_rsql = preg_replace('#INSERT INTO ([a-zA-Z0-9_-é]*) VALUES \((.*)\);#i', '$rsql_array[\'$2\'] = \'$1\';', $get_rsql);
	eval($get_rsql);
	// ajoute l'administrateur
	$rsql_array["'', '', '".$_POST['user_login']."', '".$_POST['user_mail']."', '', MD5('".$_POST['user_code']."'), 'admin', '', '0', '', '', '0', '', '', '0', '', '', '', '0', '', '0', '', '', 'francais'"] = 'clanlite_user';
	$nombre = 0;
	$log_erreur_données = true;
	foreach($rsql_array as $exec_db => $nom_db)
	{
		$exec_db = str_replace("&#0R389 ;", "\'", $exec_db);
		$nom_db = str_replace("clanlite_", $_POST['prefix_mysql'], $nom_db);
		if( ($rsql->requete_sql("INSERT INTO ".$nom_db." VALUES (".$exec_db.")")) )
		{
			$show_exec_install[$nombre]['result'] = "<span class=\"ok\">Installé correctement</span>";
		}
		else
		{
			$show_exec_install[$nombre]['result'] = "<span class=\"erreur\">Erreur (".$rsql->error.")</span>";
			$log_erreur_données = false;
		}
		$show_exec_install[$nombre]['table'] = str_replace("clanlite_", $_POST['prefix_mysql'], $nom_db);
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
		if( ($rsql->requete_sql("UPDATE ".$_POST['prefix_mysql'].'config SET conf_valeur=\''.$exec_db.'\' WHERE conf_nom=\''.$nom_var.'\'')) )
		{
			$show_config_min[$nombre]['result'] = "<span class=\"ok\">Installé correctement</span>";
		}
		else
		{
			$show_config_min[$nombre]['result'] = "<span class=\"erreur\">Erreur (".$rsql->error.")</span>";
			$log_erreur_config_min = false;
		}
		$show_config_min[$nombre]['info'] = $nom_var;
		$nombre++;
		}
?>
	<li><a href="#" onclick="toggle_msg('liste_structure', '', '')">[détails]</a> Création des bases de données: <?php
if ($log_erreur_structure){echo "<span class=\"ok\">Installé correctement</span>";}else{echo "<span class=\"erreur\">Erreur</span>";}?></li>
	<ul style="display:none" id="liste_structure">
<?php
foreach($show_table_install as $id => $info)
	{
		echo "		<li>Création de ".$info['table']." : ".$info['result']."</li>\n";
	}?>
	</ul>
	<li><a href="#" onclick="toggle_msg('liste_données', '', '')">[détails]</a> Remplissage des bases de données: <?php
if ($log_erreur_données){echo "<span class=\"ok\">Installé correctement</span>";}else{echo "<span class=\"erreur\">Erreur</span>";}?></li>
	<ul style="display:none" id="liste_données">
	<?php
foreach($show_exec_install as $id => $info)
	{
		echo "		<li>Table ".$info['table']." : ".$info['result']."</li>\n";
	}?>
	</ul>
	<li><a href="#" onclick="toggle_msg('liste_config_min', '', '')">[détails]</a> Configuration minimal du portail <?php
if ($log_erreur_config_min){echo "<span class=\"ok\">Installé correctement</span>";}else{echo "<span class=\"erreur\">Erreur</span>";}?></li>
	<ul style="display:none" id="liste_config_min">
	<?php
foreach($show_config_min as $id => $info)
	{
		echo "		<li>Table ".$info['info']." : ".$info['result']."</li>\n";
	}?>
	</ul>
	<?php
} ?>
	</ul>
	<form action="install.php" method="post">
	<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="<?php echo $_POST['serveur_mysql'] ?>" />
	<input name="db_type" type="hidden" id="db_type" value="<?php echo $_POST['db_type'] ?>" />
	<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="<?php echo $_POST['prefix_mysql'] ?>" />
	<input name="login_mysql" type="hidden" id="login_mysql" value="<?php echo $_POST['login_mysql'] ?>" />
	<input name="code_mysql" type="hidden" id="code_mysql" value="<?php echo $_POST['code_mysql'] ?>" />
	<input name="bd_mysql" type="hidden" id="bd_mysql" value="<?php echo $_POST['bd_mysql'] ?>" />
	<input name="user_login" type="hidden" id="user_login" value="<?php echo $_POST['user_login'] ?>" />
	<input name="user_code" type="hidden" id="user_code" value="<?php echo $_POST['user_code'] ?>" />
	<input name="user_mail" type="hidden" id="user_mail" value="<?php echo $_POST['user_mail'] ?>" />
	<input name="skin" type="hidden" id="skin" value="<?php echo $_POST['skin'] ?>" />
	<input type="submit" name="send_config" value="Continuer l'installation" /></form>
<?php
}
if (!empty($_POST['send_config']) || !empty($_POST['connect_ftp']))
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
	$contenu .= "?>";

	//tentative de création du fichier ou simplement l'ouverture
	$ftp_result = '';
	if (empty($_POST['connect_ftp']))
	{
		if($open_fichier = fopen($root_path.'config.php', 'w'))
		{
			if(fwrite($open_fichier, $contenu))
			{
				$config_result = "<span class=\"ok\">config.php placé</span>";
				$ftp_result = "<span class=\"annulé\">Inutile</span>";
				fclose($open_fichier);
				$config_result_b = true;
			}
			else
			{
				$config_result = "<span class=\"erreur\">l'ecriture a echoué</span>";
				$config_result_b = false;
			}
		}
		else
		{
			$config_result = "<span class=\"erreur\">erreur a l'ouverture du fichier</span>";
			$config_result_b = false;
		}
	}
	else
	{
		$config_result = "<span class=\"annulé\">Annulé, transfert par FTP</span>";
		if($conn_id = @ftp_connect($_POST['ip_ftp'], $_POST['port_ftp'], 10))
		{
			if (@ftp_login($conn_id, $_POST['login_ftp'], $_POST['code_ftp']))
			{
				//remplace le timeout de 90s a 10s
				@ftp_set_option($conn_id, FTP_TIMEOUT_SEC, 10);
				if (@ftp_chdir($conn_id, $_POST['rep_ftp']))
				{
					if (@ftp_put($conn_id, 'config.php', $contenu, FTP_ASCII))
					{
						$ftp_result = "<span class=\"ok\">Fichier placé</span>";
						$ftp_result_b = true;
					}
					else
					{
						$ftp_result = "<span class=\"erreur\">Le fichier n'a pu etre uploadé</span>";
						$ftp_result_b = false;
					}
					@ftp_close($conn_id);
				}
				else
				{
					$ftp_result = "<span class=\"erreur\">Repertoire Non trouvé</span>";
					$ftp_result_b = false;
				}
			}
			else
			{
				$ftp_result = "<span class=\"erreur\">Code ou login incorrect</span>";
				$ftp_result_b = false;
			}			
		}
		else
		{
			$ftp_result = "<span class=\"erreur\">Le FTP ne répond pas</span>";
			$ftp_result_b = false;
		}
	}
	?><h1>Placement du fichier config.php</h1>
<ul>
	<li>Mise en place automatique : <?php echo $config_result ?></li>	
	<li>Mise en place par FTP : <?php echo $ftp_result ?></li>	
	<li>Télécharger et uploader manuellement : 	<form action="install.php" method="post">
	<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="<?php echo $_POST['serveur_mysql'] ?>" />
	<input name="db_type" type="hidden" id="db_type" value="<?php echo $_POST['db_type'] ?>" />
	<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="<?php echo $_POST['prefix_mysql'] ?>" />
	<input name="login_mysql" type="hidden" id="login_mysql" value="<?php echo $_POST['login_mysql'] ?>" />
	<input name="code_mysql" type="hidden" id="code_mysql" value="<?php echo $_POST['code_mysql'] ?>" />
	<input name="bd_mysql" type="hidden" id="bd_mysql" value="<?php echo $_POST['bd_mysql'] ?>" />
	<input name="user_login" type="hidden" id="user_login" value="<?php echo $_POST['user_login'] ?>" />
	<input name="user_code" type="hidden" id="user_code" value="<?php echo $_POST['user_code'] ?>" />
	<input name="user_mail" type="hidden" id="user_mail" value="<?php echo $_POST['user_mail'] ?>" />
	<input name="skin" type="hidden" id="skin" value="<?php echo $_POST['skin'] ?>" />
	<input type="submit" name="dl_config_php" value="Télécharger config.php" /></form>
</li>	
</ul><?php
if (!$config_result_b)
	{?>
	<div class="big_cadre">
		<h1>Transfer de config.php par FTP</h1>
		<form action="install.php" method="post">
			<div class="news">
				Comme l'autocréation du fichier de configuration a échoé, vous pouvez envoyer automatiquement envoyer le fichier par FTP depuis l'installation. Nous avons alors besoins de quelque information
				<p>
					<span><label for="login_ftp">Login&nbsp;:</label></span>
					<span><input name="login_ftp" id="login_ftp" type="text" value="<?php echo (!empty($_POST['login_ftp']))? $_POST['login_ftp'] : '' ?>" /></span>
				</p>
				<p>
					<span><label for="code_ftp">Password&nbsp;:</label></span>
					<span><input name="code_ftp" id="code_ftp" type="text" value="<?php echo (!empty($_POST['code_ftp']))? $_POST['code_ftp'] : '' ?>" /></span>
				</p>
				<p>
					<span><label for="ip_ftp">Adresse IP&nbsp;:</label></span>
					<span><input name="ip_ftp" id="ip_ftp" type="text" value="<?php echo (!empty($_POST['ip_ftp']))? $_POST['ip_ftp'] : '' ?>" /></span>
				</p>
				<p>
					<span><label for="port_ftp">Port&nbsp;:</label></span>
					<span><input name="port_ftp" id="port_ftp" type="text" value="<?php echo (!empty($_POST['port_ftp']))? $_POST['port_ftp'] : "21" ?>" /></span>
				</p>
				<p>
					<span><label for="rep_ftp">Répertoire d'installation de ClanLite&nbsp;:</label></span>
					<span><input name="rep_ftp" id="rep_ftp" type="text" value="<?php echo (!empty($_POST['rep_ftp']))? $_POST['rep_ftp'] : str_replace('install', '', dirname($_SERVER['PHP_SELF'])) ?>" /></span>
				</p>
				<p>
					<span>
						<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="<?php echo $_POST['serveur_mysql'] ?>" />
						<input name="db_type" type="hidden" id="db_type" value="<?php echo $_POST['db_type'] ?>" />
						<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="<?php echo $_POST['prefix_mysql'] ?>" />
						<input name="login_mysql" type="hidden" id="login_mysql" value="<?php echo $_POST['login_mysql'] ?>" />
						<input name="code_mysql" type="hidden" id="code_mysql" value="<?php echo $_POST['code_mysql'] ?>" />
						<input name="bd_mysql" type="hidden" id="bd_mysql" value="<?php echo $_POST['bd_mysql'] ?>" />
						<input name="user_login" type="hidden" id="user_login" value="<?php echo $_POST['user_login'] ?>" />
						<input name="user_code" type="hidden" id="user_code" value="<?php echo $_POST['user_code'] ?>" />
						<input name="user_mail" type="hidden" id="user_mail" value="<?php echo $_POST['user_mail'] ?>" />
						<input name="skin" type="hidden" id="skin" value="<?php echo $_POST['skin'] ?>" />
						<input type="submit" name="connect_ftp" value="Envoyer" />
					</span>
				</p>
			</div>
		</form>
	</div>
<?php
}
else
{
?><br /><form action="install.php" method="post"><input type="submit" name="readme" value="Finir l'installation" /></form><?php
}
}
if (!empty($_POST['readme']))
{
	if (!defined('CL_INSTALL'))
	{// le fichier config.php est pas bien placé ?>
	<h1>Erreur</h1>
Le fichier config.php n'est pas placé au bon endroit, vous devez retourner en arriére pour le placer correctement
<form action="install.php" method="post">
<input name="readme" type="submit" value="Revérifier" />
<input name="send_config" type="submit" value="Recommencer l'envois de config.php" />
</form>

	<?php
}
	else
	{// le fichier n'est pas bien placé ?>
<h1>Note de fin d'installation</h1>
Tous semble en ordre pour un bon fonctionnement de ClanLite, vous pouvez maintenent l'utiliser. Il serait bien de passer dans l'administration pour configurer au mieux votre portail
<form action="../index.php" method="post">
<input name="install" type="submit" value="Aller sur le portail" />
</form>
	
	<?php
}
} ?>
  </div></div>
  <div class="copyright">
  <div class="cellule_copyright"></div> 
</div></body></htm>