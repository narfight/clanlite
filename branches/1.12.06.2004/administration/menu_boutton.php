<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 15;
$action_membre= 'where_custom_menu';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if ( !empty($_POST['Envoyer']) )
{
	$_POST = pure_var($_POST);
	$bouge = (empty($_POST['bouge']))? '' : $_POST['bouge'];
	$frame = (empty($_POST['frame']))? '' : $_POST['frame'];
	$sql= "INSERT INTO `".$config['prefix']."custom_menu` (text, ordre, url, bouge, frame) VALUES ('".$_POST['text']."', '".$_POST['ordre']."', '".$_POST['url']."', '".$bouge."', '".$frame."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text("menu_boutton.php",$langue['redirection_custom_menu_add'],"admin");
}
if ( !empty($_POST['Editer']) )
{
	$_POST = pure_var($_POST);
	$bouge = (empty($_POST['bouge']))? '' : $_POST['bouge'];
	$frame = (empty($_POST['frame']))? '' : $_POST['frame'];
	$sql = "UPDATE `".$config['prefix']."custom_menu` SET text='".$_POST['text']."', url='".$_POST['url']."', ordre='".$_POST['ordre']."', bouge='".$bouge."', frame='".$frame."' WHERE id='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("menu_boutton.php",$langue['redirection_custom_menu_edit'],"admin");
	}
}
if ( !empty($_POST['dell']) )
{
	$sql = "DELETE FROM `".$config['prefix']."custom_menu` WHERE id ='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("menu_boutton.php",$langue['redirection_custom_menu_dell'],"admin");
	}
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_boutton.tpl'));
$template->assign_vars( array('ICI' => $_SERVER['PHP_SELF']));
$template->assign_vars(array( 
	'TITRE' => $langue['titre_custom_menu'],
	'TITRE_GESTION' => $langue['titre_custom_menu_gestion'],
	'TITRE_LISTE' => $langue['titre_custom_menu_list'],
	'ACTION' => $langue['action'],
	'ALT_AIDE' => $langue['alt_aide'],
	'TXT_AIDE' => $langue['custom_menu_aide_defiler'],
	'TXT_ORDRE' => $langue['custom_menu_ordre'],
	'TXT_TEXTE' => $langue['custum_menu_txt'],
	'TXT_URL' => $langue['custom_menu_url'],
	'TXT_FRAME' => $langue['custom_menu_frame'],
	'TXT_DEFILER' => $langue['custom_menu_défiler'],
	'TXT_URL_LIGHT' => $langue['liens_url_site'],
));
if ( !empty($_POST['edit']) )
{
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer'])); 
	$sql = "SELECT * FROM ".$config['prefix']."custom_menu WHERE id='".$_POST['for']."'";
	if (! ($get_edit = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$bouton_edit = $rsql->s_array($get_edit);
	$template->assign_vars( array(
		'ID' => $bouton_edit['id'],
		'ORDRE' => $bouton_edit['ordre'],
		'NOM' => $bouton_edit['text'], 
		'URL' => $bouton_edit['url'],
		'BOUGE' => ( $bouton_edit['bouge'] == "oui") ? "checked=\"checked\"" : "",
		'FRAME' => ( $bouton_edit['frame'] == "oui") ? "checked=\"checked\"" : "",
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer'])); 
}
$sql = "SELECT * FROM ".$config['prefix']."custom_menu ORDER BY `ordre` ASC";
if (! ($get_list = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($list = $rsql->s_array($get_list))
{
	$template->assign_block_vars('liste', array( 
		'ID' => $list['id'],
		'ORDRE' => $list['ordre'],
		'NOM' => $list['text'], 
		'URL' => $list['url'],
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer'],
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>