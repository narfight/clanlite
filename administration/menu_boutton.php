<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 15;
$action_membre= 'where_custom_menu';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path."controle/cook.php");
if ( !empty($_POST['Envoyer']) )
{
	$_POST = pure_var($_POST);
	$sql= "INSERT INTO `".$config['prefix']."custom_menu` (text, ordre, url, bouge, frame) VALUES ('".$_POST['text']."', '".$_POST['ordre']."', '".$_POST['url']."', '".((empty($_POST['bouge']))? 0 : 1)."', '".((empty($_POST['frame']))? 0 : 1)."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
		redirec_text('menu_boutton.php',$langue['redirection_custom_menu_add'],'admin');
}
if ( !empty($_POST['Editer']) )
{
	$_POST = pure_var($_POST);
	$edit_default = (!empty($_POST['liens_default']))? " ,`default`='".((empty($_POST['activation']) && $_POST['activation'] == 0)? 0 : 1)."' " : ' ';
	$edit_central = ((empty($_POST['module_central']) && empty($_POST['liens_default']))? "url='".$_POST['url']."', " : '');
	$edit_liens_default = ((empty($_POST['liens_default']) && empty($_POST['module_central']))? "text='".$_POST['text']."', ": '');
	$sql = "UPDATE `".$config['prefix']."custom_menu` SET ".$edit_liens_default.$edit_central."ordre='".$_POST['ordre']."', bouge='".((empty($_POST['bouge']))? '0' : 1)."', frame='".((empty($_POST['frame']))? 1 : 0)."' ".$edit_default."WHERE id='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('menu_boutton.php',$langue['redirection_custom_menu_edit'],'admin');
	}
}
if ( !empty($_POST['dell']) )
{
	$sql = "DELETE FROM `".$config['prefix']."custom_menu` WHERE module_central != 1 AND `default` ='normal' AND id ='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('menu_boutton.php',$langue['redirection_custom_menu_dell'],'admin');
	}
}
include($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'admin_boutton.tpl'));
$template->assign_vars(array( 
	'ICI' => session_in_url('menu_boutton.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
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
	'TXT_ETAT' => $langue['module_etat'],
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
		'NOM' => ($bouton_edit['default'] != 'normal')? $langue[$bouton_edit['text']] : $bouton_edit['text'], 
		'DISABLED_NOM' => ($bouton_edit['default'] != 'normal')? 'disabled="disabled"' : '',
		'URL' => ($bouton_edit['bouge'] == 1)? $root_path.$bouton_edit['url'] : $bouton_edit['url'],
		'DISABLED_URL' => ($bouton_edit['module_central'] == 1 || $bouton_edit['default'] != 'normal')? 'disabled="disabled"' : '',
		'BOUGE' => ($bouton_edit['bouge'] == 1)? 'checked="checked"' : '',
		'FRAME' => ($bouton_edit['module_central'] == 1)? 'disabled="disabled"' : (($bouton_edit['frame'] == 1)? '' : 'checked="checked"'),
		'MODULE_CENTRAL' => ($bouton_edit['module_central'] == 1)? 1 : 0,
		'LIENS_DEFAULT' => ($bouton_edit['default'] != 'normal')? 1 : 0
	));
	if ($bouton_edit['default'] != 'normal')
	{
		$template->assign_block_vars('activation', array( 
			'TXT_ACTIF' => $langue['module_on'],
			'ACTIF' => ($bouton_edit['default'] == 1)? 'checked="checked"' : '', 
			'TXT_DESACTIF' => $langue['module_off'],
			'DESACTIF' => ($bouton_edit['default'] != 1)? 'checked="checked"' : '', 
		));
	}
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
	if ($list['url'] == 'url_forum')
	{
		$url = $config['url_forum'];
	}
	elseif ($list['module_central'] == 1 || $list['default'] != 'normal')
	{
		$url = $root_path.$list['url'];
	}
	$template->assign_block_vars('liste', array( 
		'ID' => $list['id'],
		'ORDRE' => $list['ordre'],
		'NOM' => ($list['default'] != 'normal')? $langue[$list['text']] : $list['text'], 
		'URL' => $url,
		'ETAT' => ($list['default'] == 1 || $list['default'] == 'normal')? $langue['module_on'] : $langue['module_off'],
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer'],
		'DISABLED_DELL' => ($list['module_central'] == 1 || $list['default'] != 'normal')? 'disabled="disabled"' : ''
	));
}
$template->pparse('body');
include($root_path.'conf/frame_admin.php');
?>