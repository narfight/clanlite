<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = "Module perso";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => bbcode($modules['config'], false)
	));
	return;
}
if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_module_perso_module']) )
{
	$root_path = './../';
	$action_membre= 'where_module_module_custom';
	$niveau_secu = 16;
	include($root_path.'conf/template.php');
	include($root_path.'conf/conf-php.php');
	include($root_path."controle/cook.php");
	$id_module = (!empty($_POST['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	if ( !empty($_POST['Submit_module_perso_module']) )
	{
		$sql = "UPDATE ".$config['prefix']."modules SET config='".$_POST['contenu']."' WHERE id ='".$id_module."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path."administration/modules.php" ,$langue['redirection_module_custom_edit'], 'admin');
	}
	include($root_path."conf/frame_admin.php");
	$template = new Template($root_path.'templates/'.$config['skin']);
	$template->set_filenames( array('body' => 'modules/module_perso.tpl'));
	liste_smilies(true, '', 25);
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$recherche = $rsql->s_array($get);
	$template->assign_vars(array(
		'TITRE' => $langue['titre_module_module_custom'],
		'ID'=> $id_module,
		'TXT_CONTENU' => $langue['module_custom_contenu'],
		'CONTENU' => $recherche['config'],
		'EDITER' => $langue['editer'],
	));
	$template->pparse('body');
	include($root_path."conf/frame_admin.php");
	return;
}
?>