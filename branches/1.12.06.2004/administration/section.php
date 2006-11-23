<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 21;
$action_membre= 'where_admin_section';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($_POST['envoyer']))
{ 
	$_POST = pure_var($_POST);
	$_POST['limite'] = (!empty($_POST['limite']))? 1 : 0;
	$sql = "INSERT INTO `".$config['prefix']."section` (nom, limite) VALUES ('".$_POST['nom']."', '".$_POST['limite']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text("section.php", $langue['redirection_admin_section_add'], "admin");
}
if (!empty($_POST['envois_edit']))
{
	$_POST = pure_var($_POST);
	$_POST['limite'] = (!empty($_POST['limite']))? 1 : 0;
	$sql = "UPDATE `".$config['prefix']."section` SET nom='".$_POST['nom']."', limite='".$_POST['limite']."' WHERE id='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("section.php", $langue['redirection_admin_section_edit'], "admin");
	}
}
if (!empty($_POST['Supprimer']))
{
	$sql = "DELETE FROM `".$config['prefix']."section` WHERE id ='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// on eneleve le id de la section au membres qui y sont
	$sql = "UPDATE `".$config['prefix']."user` SET section='' WHERE section='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("section.php", $langue['redirection_admin_section_dell'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_section.tpl'));
$template->assign_vars( array(
	'ICI' => $_SERVER['PHP_SELF'],
	'TITRE' => $langue['titre_admin_section'],
	'TITRE_GESTION' => $langue['titre_admin_section_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_section_list'],
	'TXT_NOM' => $langue['admin_section_nom'],
	'TXT_LIMITE' => $langue['admin_section_limite'],
	'TITRE_LIMITE' => $langue['admin_section_titre_limite'],
	'ACTION' => $langue['action'],
	'HELP_TXT' => $langue['help_section'],
	'ALT_AIDE' => $langue['alt_aide'],
));
if (!empty($_POST['Editer']))
{
	$sql = "SELECT * FROM ".$config['prefix']."section WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_section = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_section['id'],
		'NOM' => $edit_section['nom'],
		'LIMITE' => ($edit_section['limite'] == 1)? 'checked="checked"' : '',
	));
}
else
{
		$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."section ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'NOM' => $liste['nom'],
		'LIMITE' => ($liste['limite'] == 1)? $langue['admin_section_limite_true'] : $langue['admin_section_limite_false'],
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>