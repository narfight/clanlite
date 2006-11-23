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
if (!empty($HTTP_POST_VARS['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."grades` WHERE id ='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("grades.php", $langue['redirection_grade_dell'], "admin");
}
if (!empty($HTTP_POST_VARS['Envoyer']))
{ 
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "INSERT INTO `".$config['prefix']."grades` (ordre, nom) VALUES ('".$HTTP_POST_VARS['ordre']."', '".$HTTP_POST_VARS['nom']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("grades.php", $langue['redirection_grade_add'], "admin");
	}
}
if (!empty($HTTP_POST_VARS['Editer']))
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "UPDATE `".$config['prefix']."grades` SET ordre='".$HTTP_POST_VARS['ordre']."', nom='".$HTTP_POST_VARS['nom']."' WHERE id='".$HTTP_POST_VARS['for']."'";
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
	'ICI' => $HTTP_SERVER_VARS['PHP_SELF'],
	'TITRE' => $langue['titre_grade'],
	'TITRE_GESTION' => $langue['titre_grade_gestion'],
	'TITRE_LISTE' => $langue['titre_grade_list'],
	'TXT_NOM' => $langue['nom_grade'],
	'TXT_PUISSANCE' => $langue['puissance_grade'],
	'ACTION' => $langue['action'],
));
if (!empty($HTTP_POST_VARS['edit']))
{
	$sql = "SELECT * FROM ".$config['prefix']."grades WHERE id='".$HTTP_POST_VARS['for']."'";
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