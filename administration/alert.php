<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 1;
$action_membre= 'where_alert';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if ( !empty($HTTP_POST_VARS['Envoyer']) )
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$date = mktime ( $HTTP_POST_VARS['heure'] , $HTTP_POST_VARS['minute'] , 1 , $HTTP_POST_VARS['mois'] , $HTTP_POST_VARS['jour'] , $HTTP_POST_VARS['annee']);
	$sql= "INSERT INTO `".$config['prefix']."alert` (info, date, auto_del) VALUES ('".$HTTP_POST_VARS['text']."', '".$date."', '".$HTTP_POST_VARS['auto_del']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text("alert.php",$langue['redirection_alert_add'],"admin");
}
if ( !empty($HTTP_POST_VARS['Editer']) )
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$date = mktime ( $HTTP_POST_VARS['heure'] , $HTTP_POST_VARS['minute'] , 1 , $HTTP_POST_VARS['mois'] , $HTTP_POST_VARS['jour'] , $HTTP_POST_VARS['annee']);
	$sql = "UPDATE `".$config['prefix']."alert` SET info='".$HTTP_POST_VARS['text']."', date='".$date."', auto_del='".$HTTP_POST_VARS['auto_del']."' WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("alert.php",$langue['redirection_alert_edit'],"admin");
	}
}
if ( !empty($HTTP_POST_VARS['dell']) )
{
	$sql = "DELETE FROM `".$config['prefix']."alert` WHERE id ='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("alert.php",$langue['redirection_alert_dell'],"admin");
	}
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_alert.tpl'));
$template->assign_vars( array(
	'ICI' => $HTTP_SERVER_VARS['PHP_SELF'],
	'TITRE' => $langue['titre_alert'],
	'TITRE_GESTION' => $langue['titre_alert_gestion'],
	'TITRE_LIST' => $langue['titre_alert_list'],
	'TXT_TEXT' => $langue['le_txt'],
	'TXT_DEL_DATE' => $langue['date_dell_alert'],
	'TXT_DEL_HEURE' => $langue['heure_dell_alert'],
	'TXT_AUTO_DEL' => $langue['opt_auto_dell_alert'],
	'BT_ENVOYER' => $langue['envoyer'],
	'BT_EDITER' => $langue['editer'],
	'BT_DELL' => $langue['supprimer'],
	'DATE' => $langue['date'],
	'ACTION' => $langue['action'],
));
if ( !empty($HTTP_POST_VARS['edit']) )
{
	$template->assign_block_vars('editer', 'vide');
	$sql = "SELECT * FROM ".$config['prefix']."alert WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($get_edit = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$alert_edit = $rsql->s_array($get_edit);
	$template->assign_vars( array(
		'ID' => $alert_edit['id'],
		'TEXT' => $alert_edit['info'],
		'AUTO_DEL' => ( $alert_edit['auto_del'] == "oui") ? 'checked="checked"' : '',
	));
	if ($alert_edit['date'] != -1)
	{
		$template->assign_vars( array(
			'MINUTE' => date("i", $alert_edit['date']),
			'HEURE' => date("H", $alert_edit['date']),
			'JOUR' => date("j", $alert_edit['date']),
			'MOIS' => date("n", $alert_edit['date']),
			'ANNEE' => date("Y", $alert_edit['date']),
		));
	}
}
else
{
	$template->assign_block_vars('rajouter', 'vide');
}
$sql = "SELECT * FROM ".$config['prefix']."alert ORDER BY `date` ASC";
if (! ($get_list = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($list = $rsql->s_array($get_list))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $list['id'],
		'DATE' => ($list['date'] == -1)? $langue['opt_auto_dell_desactiver'] : date("j/n/Y à H:i", $list['date']),
		'TEXT' => nl2br(bbcode($list['info'])), 
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>