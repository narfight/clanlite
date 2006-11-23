<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 11;
$action_membre= 'where_equipe';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['Envoyer']))
{ 
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "INSERT INTO `".$config['prefix']."équipe` (nom,détail) VALUES ('".$HTTP_POST_VARS['nom']."', '".$HTTP_POST_VARS['info']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("equipe.php", $langue['redirection_equipe_add'], "admin");
}
if (!empty($HTTP_POST_VARS['Editer']))
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "UPDATE `".$config['prefix']."équipe` SET nom='".$HTTP_POST_VARS['nom']."', détail='".$HTTP_POST_VARS['info']."' WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("equipe.php", $langue['redirection_equipe_edit'], "admin");
}
if (!empty($HTTP_POST_VARS['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."équipe` WHERE id ='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// on eneleve le id de l'equipe au membres qui y sont
	$sql = "UPDATE `".$config['prefix']."user` SET equipe='' WHERE equipe='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("equipe.php", $langue['redirection_equipe_dell'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_equipe.tpl'));
$template->assign_vars( array( 
	'ICI' => $HTTP_SERVER_VARS['PHP_SELF'],
	'TITRE' => $langue['titre_equipe'],
	'TITRE_GESTION' => $langue['titre_equipe_gestion'],
	'TITRE_LISTE' => $langue['titre_equipe_list'],
	'HELP_TXT' => $langue['help_equipe'],
	'TXT_NOM' => $langue['nom_equipe'],
	'TXT_DETAILS' => $langue['détails'],
	'ACTION' => $langue['action'],
	'ALT_AIDE' => $langue['alt_aide'],
));
if (!empty($HTTP_POST_VARS['edit']))
{
	$sql = "SELECT * FROM ".$config['prefix']."équipe WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit['id'],
		'INFO' => $edit['détail'],
		'NOM' => $edit['nom'],
	));
}
else
{
	$template->assign_block_vars('envoyer', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."équipe ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( $liste = $rsql->s_array($get) )
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'INFO' => $liste['détail'],
		'NOM' => $liste['nom'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer']
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>