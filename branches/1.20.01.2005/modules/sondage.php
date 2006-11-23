<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module))
	{
		$filename = basename(__FILE__);
		$nom = "Sondage";
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$last_id = mysql_insert_id();
		$sql = "CREATE TABLE `".$config['prefix']."module_sondage_".$last_id."` ( `id` mediumint(8) unsigned NOT NULL auto_increment, `question` mediumtext NOT NULL, `etat` enum('on','off') NOT NULL default 'on', PRIMARY KEY  (`id`))";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "CREATE TABLE `".$config['prefix']."module_sondage_reponses_".$last_id."` ( `id` mediumint(8) unsigned NOT NULL auto_increment, `id_sondage` mediumint(8) unsigned NOT NULL default '0', `nbr` mediumint(8) unsigned NOT NULL default '0', `reponse` mediumtext NOT NULL, PRIMARY KEY  (`id`))";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		$sql = "DROP TABLE `".$config['prefix']."module_sondage_".$_POST['for']."` ";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "DROP TABLE `".$config['prefix']."module_sondage_reponses_".$_POST['for']."` ";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	$sql = "SELECT image,url,nom FROM ".$config['prefix']."module_partenaires_".$modules['id']." ORDER BY `id` DESC";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$module_in = "\n";
	while ( $liste = $rsql->s_array($get) )
	{ 
		$module_in .= '<a href="'.$liste['url'].'" onclick="window.open(\''.$liste['url'].'\');return false;"><img src="'.$liste['image'].'" alt="'.$liste['nom'].'" /></a><br />'."\n";
	}
	$template->assign_block_vars("modules_".$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => '<div style="text-align: center">'.$module_in.'</div>',
	));
	return;
}
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Envoyer_sondage_module']) || !empty($_POST['Editer_sondage_module']) || !empty($_POST['dell_sondage_module']) || !empty($_POST['edit_sondage_module']) )
{
	$id_module = (empty($_GET['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	$root_path = './../';
	$niveau_secu = 16;
	$action_membre= 'where_module_sondage';
	include($root_path."conf/template.php");
	include($root_path."conf/conf-php.php");
	include($root_path."controle/cook.php");
	if (!empty($_POST['dell_sondage_module']))
	{
		$sql = "DELETE FROM `".$config['prefix']."module_sondage_reponses_".$id_module."` WHERE id ='".$_POST['for_sondage_module']."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "DELETE FROM `".$config['prefix']."module_sondage_".$id_module."` WHERE id_sondage ='".$_POST['for_sondage_module']."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text("sondage.php?config_modul_admin=oui&id_module=".$id_module, $langue['redirection_module_sondage_dell'], "admin");
	}
	if (!empty($_POST['Envoyer_sondage_module']))
	{ 
		$_POST = pure_var($_POST);
		$sql = "INSERT INTO `".$config['prefix']."module_partenaires_".$id_module."` (url, nom, image) VALUES ('".$_POST['url']."', '".$_POST['nom']."', '".$_POST['image']."')";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		else
		{
			redirec_text("sondage.php?config_modul_admin=oui&id_module=".$id_module, $langue['redirection_module_sondage_add'], "admin");
		}
	}
	if (!empty($_POST['Editer_sondage_module']))
	{
		$_POST = pure_var($_POST);
		$sql = "UPDATE `".$config['prefix']."module_partenaires_".$id_module."` SET url='".$_POST['url']."', nom='".$_POST['nom']."', image='".$_POST['image']."' WHERE id='".$_POST['for_sondage_module']."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		else
		{
			redirec_text("sondage.php?config_modul_admin=oui&id_module=".$id_module, $langue['redirection_module_sondage_edit'], "admin");
		}
	}
	include($root_path."conf/frame_admin.php");
	$template = new Template($root_path."templates/".$config['skin']."/modules");
	$template->set_filenames( array('body_module' => 'sondage.tpl'));
	$template->assign_vars( array(
		'ICI' => $_SERVER['PHP_SELF'],
		'ID_MODULE' => $id_module,
		'TITRE' => $langue['titre_module_sondage'],
		'TITRE_GESTION' => $langue['titre_gestion_module_sondage'],
		'TITRE_LISTE' => $langue['titre_liste_module_sondage'],
		'TXT_REPONSES' => $langue['module_sondage_reponses'],
		'TXT_IMAGE' => $langue['liens_image_site'],
		'TXT_QUESTION' => $langue['module_sondage_question'],
		'ACTION' => $langue['action'],
	));
	if (!empty($_POST['edit_sondage_module']))
	{
		$sql = "SELECT * FROM ".$config['prefix']."module_partenaires_".$id_module." WHERE id='".$_POST['for_sondage_module']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$edit_liens_info = $rsql->s_array($get);
		$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
		$template->assign_vars( array( 
			'ID' => $edit_liens_info['id'],
			'URL' => $edit_liens_info['url'],
			'NOM' => $edit_liens_info['nom'],
			'IMAGE' => $edit_liens_info['image'],
		));
	}
	else
	{
		$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
		$template->assign_block_vars('question', array(
			'AJOUTER' => $langue['module_sondage_ajouter'],
			'SUPPRIMER' => $langue['module_sondage_supprimer'],
			'NUM' => 0
		));
	}
	$sql = "SELECT * FROM ".$config['prefix']."module_sondage_".$id_module." AS sondage LEFT JOIN ".$config['prefix']."module_sondage_reponses_".$id_module." AS reponses ON sondage.id = reponses.id_sondage";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ( $liste = $rsql->s_array($get) )
	{
		$template->assign_block_vars('liste', array(
			'ID' => $liste['id'],
			'URL' => $liste['url'],
			'NOM' => $liste['nom'],
			'IMAGE' => $liste['image'],
			'SUPPRIMER' => $langue['supprimer'],
			'EDITER' => $langue['editer'],
		));
	}
	$template->pparse('body_module');
	include($root_path."conf/frame_admin.php");
	return;
}
?>