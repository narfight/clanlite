<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 20;
$action_membre = 'where_admin_map_serveur';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if ( !empty($_POST['Envoyer']) )
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."server_map` (nom, url, nom_console) VALUES ('".$_POST['nom_map']."', '".$_POST['url_map']."', '".$_POST['console']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("server_map.php", $langue['redirection_admin_map_serveur_add'], "admin");
}
if ( !empty($_POST['Editer']) )
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."server_map` SET nom='".$_POST['nom_map']."', url='".$_POST['url_map']."', nom_console='".$_POST['console']."' WHERE id='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("server_map.php", $langue['redirection_admin_map_serveur_edit'], "admin");
}
if ( !empty($_POST['dell']) )
{
	$sql = "DELETE FROM `".$config['prefix']."server_map` WHERE id ='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("server_map.php", $langue['redirection_admin_map_serveur_dell'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_map_serveur.tpl'));
$template->assign_vars( array(
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_map_serveur'],
	'TITRE_GESTION' => $langue['titre_admin_map_serveur_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_map_serveur_list'],
	'ACTION' => $langue['action'],
	'TXT_NOM' => $langue['nom_map_sortie'],
	'TXT_URL' => $langue['url_map_custom'],
	'TXT_CONSOLE' => $langue['nom_map_console'],
));
if ( !empty($_POST['edit']) )
{
	$sql = "SELECT * FROM ".$config['prefix']."server_map WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$get_edit_info = $rsql->s_array($get);
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	$template->assign_vars(array(
		'ID' => $get_edit_info['id'],
		'NOM' => $get_edit_info['nom'],
		'URL' => $get_edit_info['url'],
		'CONSOLE' => $get_edit_info['nom_console'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."server_map ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste_map = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $liste_map['id'],
		'NOM' => $liste_map['nom'],
		'URL' => (empty($liste_map['url']))? 'Pas de liens': '<a href="'.$liste_map['url'].'" onclick="window.open(\''.$liste_map['url'].'\');return false;">'.$langue['liens_test_url'].'</a>',
		'CONSOLE' => $liste_map['nom_console'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>