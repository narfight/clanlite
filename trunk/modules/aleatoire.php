<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module))
	{
		$filename = basename(__FILE__);
		$nom = "Affichage al�atoire";
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$sql = "CREATE TABLE `".$config['prefix']."module_al�atoire_".mysql_insert_id()."` (`id` MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT ,`txt` LONGTEXT NOT NULL ,PRIMARY KEY ( `id` ))";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		$sql = "DROP TABLE `".$config['prefix']."module_al�atoire_".$_POST['for']."` ";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	$sql = "SELECT id,txt FROM ".$config['prefix']."module_al�atoire_".$modules['id'];
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$module_in = "\n";
	while ( $liste = $rsql->s_array($get) )
	{ 
		$donnees[$liste['id']] = $liste['txt'];
	}
	srand ((float) microtime() * 10000000);
	$module_in_id = array_rand($donnees);
	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => '<div style="text-align: center">'.bbcode($donnees[$module_in_id], false).'</div>',
	));
	return;
}
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Envoyer_al�atoire_module']) || !empty($_POST['Editer_al�atoire_module']) || !empty($_POST['dell_al�atoire_module']) || !empty($_POST['edit_al�atoire_module']) )
{
	$id_module = (empty($_GET['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	$root_path = './../';
	$niveau_secu = 16;
	$action_membre= 'where_module_al�atoire';
	include($root_path.'conf/template.php');
	include($root_path.'conf/conf-php.php');
	include($root_path."controle/cook.php");
	if (!empty($_POST['dell_al�atoire_module']))
	{
		$_POST = pure_var($_POST);
		$sql = "DELETE FROM `".$config['prefix']."module_al�atoire_".$id_module."` WHERE id ='".$_POST['for_al�atoire_module']."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text("aleatoire.php?config_modul_admin=oui&id_module=".$id_module, $langue['redirection_module_al�atoire_dell'], 'admin');
	}
	if (!empty($_POST['Envoyer_al�atoire_module']))
	{ 
		$_POST = pure_var($_POST);
		$sql = "INSERT INTO `".$config['prefix']."module_al�atoire_".$id_module."` (txt) VALUES ('".$_POST['txt']."')";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		else
		{
			redirec_text("aleatoire.php?config_modul_admin=oui&id_module=".$id_module, $langue['redirection_module_al�atoire_add'], 'admin');
		}
	}
	if (!empty($_POST['Editer_al�atoire_module']))
	{
		$_POST = pure_var($_POST);
		$sql = "UPDATE `".$config['prefix']."module_al�atoire_".$id_module."` SET txt='".$_POST['txt']."' WHERE id='".$_POST['for_al�atoire_module']."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		else
		{
			redirec_text("aleatoire.php?config_modul_admin=oui&id_module=".$id_module, $langue['redirection_module_al�atoire_edit'], 'admin');
		}
	}
	include($root_path.'conf/frame_admin.php');
	$template = new Template($root_path.'templates/'.$config['skin']."/modules");
	$template->set_filenames( array('body_module' => 'al�atoire.tpl'));
	liste_smilies(true, '', 25);
	$template->assign_vars( array(
		'ICI' => $_SERVER['PHP_SELF'],
		'ID_MODULE' => $id_module,
		'TITRE' => $langue['titre_module_al�atoire'],
		'TITRE_GESTION' => $langue['titre_gestion_module_al�atoire'],
		'TITRE_LISTE' => $langue['titre_liste_module_al�atoire'],
		'TXT_TXT' => $langue['custum_menu_txt'],
		'ACTION' => $langue['action'],
	));
	if (!empty($_POST['edit_al�atoire_module']))
	{
		$sql = "SELECT id,txt FROM ".$config['prefix']."module_al�atoire_".$id_module." WHERE id='".$_POST['for_al�atoire_module']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$edit_liens_info = $rsql->s_array($get);
		$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
		$template->assign_vars( array( 
			'ID' => $edit_liens_info['id'],
			'INFO' => $edit_liens_info['txt'],
		));
	}
	else
	{
		$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
	}
	$sql = "SELECT * FROM ".$config['prefix']."module_al�atoire_".$id_module." ORDER BY `id` DESC";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ( $liste = $rsql->s_array($get) )
	{
		$template->assign_block_vars('liste', array(
			'ID' => $liste['id'],
			'TXT' => bbcode($liste['txt'], false),
			'SUPPRIMER' => $langue['supprimer'],
			'EDITER' => $langue['editer'],
		));
	}
	$template->pparse('body_module');
	include($root_path.'conf/frame_admin.php');
	return;
}
?>