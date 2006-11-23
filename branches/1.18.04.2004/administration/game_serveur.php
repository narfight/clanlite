<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 6;
$action_membre= "Est dans la gestion des serveurs de jeux";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['envoyer']))
{ 
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "INSERT INTO `".$config['prefix']."game_server` (ip,port,protocol) VALUES ('".$HTTP_POST_VARS['ip']."', '".$HTTP_POST_VARS['port']."', '".$HTTP_POST_VARS['protocol']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("game_serveur.php", $langue['redirection_game_server_add'], "admin");
}
if (!empty($HTTP_POST_VARS['envois_edit']))
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "UPDATE `".$config['prefix']."game_server` SET ip='".$HTTP_POST_VARS['ip']."', port='".$HTTP_POST_VARS['port']."', protocol='".$HTTP_POST_VARS['protocol']."' WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("game_serveur.php", $langue['redirection_game_server_edit'], "admin");
	}
}
if (!empty($HTTP_POST_VARS['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."game_server` WHERE id ='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("game_serveur.php", $langue['redirection_game_server_dell'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_game_serveur.tpl'));
$template->assign_vars( array( 
	'ICI' => $HTTP_SERVER_VARS['PHP_SELF'],
	'TITRE' => $langue['titre_game_server'],
	'TITRE_GESTION' => $langue['titre_game_server_gestion'],
	'TITRE_LISTE' => $langue['titre_game_server_list'],
	'ACTION' => $langue['action'],
	'TXT_SERVEUR_GAME_PORT' => $langue['config_serveur_port'],
	'TXT_HELP_GAME_PORT' => $langue['config_help_port'],
	'TXT_SERVEUR_GAME_IP' => $langue['config_serveur_ip'],
	'TXT_SERVEUR_GAME_PROTOCOL' => $langue['config_serveur_protocol'],
	'ALT_AIDE' => $langue['alt_aide'],
	'TXT_IP' => $langue['ip'],
	'TXT_PORT' => $langue['port'],
	'TXT_PROTOCOL' => $langue['protocol'],
));
if (!empty($HTTP_POST_VARS['edit']))
{
	$sql = "SELECT * FROM ".$config['prefix']."game_server WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_game_list = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_game_list['id'],
		'IP' => $edit_game_list['ip'],
		'PORT' => $edit_game_list['port'],
		'SELECT_PROTOCOL_HLIFE' => ( "hlife" == $edit_game_list['protocol'] ) ? 'selected="selected"' : '',
		'SELECT_PROTOCOL_RVNSHLD' => ( "rvnshld" == $edit_game_list['protocol'] ) ? 'selected="selected"' : '',
		'SELECT_PROTOCOL_ARMYGAME' => ( "armygame" == $edit_game_list['protocol'] ) ? 'selected="selected"' : '',
		'SELECT_PROTOCOL_GAMESPY' => ( "gamespy" == $edit_game_list['protocol'] ) ? 'selected="selected"' : '',
		'SELECT_PROTOCOL_Q3A' => ( "q3a" == $edit_game_list['protocol'] ) ? 'selected="selected"' : '',
		'SELECT_PROTOCOL_VIETKONG' => ( "vietkong" == $edit_game_list['protocol'] ) ? 'selected="selected"' : '',
	));
}
else
{
	$template->assign_block_vars('envoyer', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."game_server ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'IP' => $liste['ip'],
		'PORT' => $liste['port'],
		'PROTOCOL' => $liste['protocol'],
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer']
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>