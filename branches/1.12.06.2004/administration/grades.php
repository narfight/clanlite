<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 5;
$action_membre= 'where_grade';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."grades` WHERE id ='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("grades.php", $langue['redirection_grade_dell'], "admin");
}
if (!empty($_POST['Envoyer']))
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."grades` (ordre, nom) VALUES ('".$_POST['ordre']."', '".$_POST['nom']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("grades.php", $langue['redirection_grade_add'], "admin");
	}
}
if (!empty($_POST['Editer']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."grades` SET ordre='".$_POST['ordre']."', nom='".$_POST['nom']."' WHERE id='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("grades.php", $langue['redirection_grade_edit'], "admin");
	}
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_grades.tpl'));
$template->assign_vars( array( 
	'ICI' => $_SERVER['PHP_SELF'],
	'TITRE' => $langue['titre_grade'],
	'TITRE_GESTION' => $langue['titre_grade_gestion'],
	'TITRE_LISTE' => $langue['titre_grade_list'],
	'TXT_NOM' => $langue['nom_grade'],
	'TXT_PUISSANCE' => $langue['puissance_grade'],
	'ACTION' => $langue['action'],
));
if (!empty($_POST['edit']))
{
	$sql = "SELECT * FROM ".$config['prefix']."grades WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_liens_info = $rsql->s_array($get);
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_liens_info['id'],
		'ORDRE' => $edit_liens_info['ordre'],
		'NOM' => $edit_liens_info['nom'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."grades ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( $liste = $rsql->s_array($get) )
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'ORDRE' => $liste['ordre'],
		'NOM' => $liste['nom'],
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer']
	));
	if (!empty($liste['images']))
	{
		$template->assign_block_vars('liste.image', array('IMAGE' => $liste['images']));
	}
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>