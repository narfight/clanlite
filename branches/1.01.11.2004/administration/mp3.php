<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_admin_mp3';
$niveau_secu = 17;
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path."controle/cook.php");
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM ".$config['prefix']."config_sond WHERE id = '".$_POST['for']."'";
	if (! $rsql->requete_sql($sql) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	redirec_text('mp3.php',$langue['redirection_admin_mp3_dell'],'admin');
}
if (!empty($_POST['Envoyer']))
{ 
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."config_sond` (`SRC`, `AUTOPLAY`, `LOOP`, `titre`, `arstite`) VALUES ('".$_POST['SRC']."', '".$_POST['AUTOPLAY']."', '".$_POST['LOOP']."', '".$_POST['titre']."', '".$_POST['chanteur']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('mp3.php', $langue['redirection_admin_mp3_add'], 'admin');
}
if (!empty($_POST['Editer']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."config_sond` SET `SRC`='".$_POST['SRC']."', `AUTOPLAY`='".$_POST['AUTOPLAY']."', `LOOP`='".$_POST['LOOP']."', `titre`='".$_POST['titre']."', `arstite`='".$_POST['chanteur']."' WHERE id='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('mp3.php', $langue['redirection_admin_mp3_edit'],'admin');
	}
}
include($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'admin_mp3.tpl'));
$template->assign_vars(array( 
	'ICI' => session_in_url('mp3.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_mp3'],
	'TITRE_GESTION' => $langue['titre_admin_mp3_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_mp3_list'],
	'ACTION' => $langue['action'],
	'CHOISIR' => $langue['choisir'],
	'TXT_SOURCE' => $langue['admin_mp3_source'],
	'TXT_AUTO_PLAY' => $langue['admin_mp3_autoplay'],
	'TXT_ARTISTE' => $langue['mp3_artiste'],
	'TXT_LOOP' => $langue['admin_mp3_loop'],
	'TXT_TITRE' => $langue['mp3_titre'],
	'OUI' => $langue['oui'],
	'NON' => $langue['non'],
));
if (!empty($_POST['edit']))
{
	$sql = "SELECT * FROM `".$config['prefix']."config_sond` WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$donnees = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array(
		'ID' => $donnees['id'],
		'SCR' => $donnees['SRC'],
		'CHECK_AUTOPLAY_1' => ($donnees['AUTOPLAY'] == "TRUE")? 'selected="selected"' : '',
		'CHECK_AUTOPLAY_0' => ($donnees['AUTOPLAY'] == "FALSE")? 'selected="selected"' : '',
		'CHECK_LOOP_1' => ($donnees['LOOP'] == "TRUE")? 'selected="selected"' : '',
		'CHECK_LOOP_0' => ($donnees['LOOP'] == "FALSE")? 'selected="selected"' : '',
		'CHANTEUR' => $donnees['arstite'],
		'TITRE_MP3' => $donnees['titre'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer'])); 
}
$sql = "SELECT id, SRC, arstite, titre FROM ".$config['prefix']."config_sond ORDER BY `id` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( $liste = $rsql->s_array($get) )
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'SRC' => $liste['SRC'],
		'CHANTEUR' => $liste['arstite'],
		'TITRE' => $liste['titre'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
$template->pparse('body');
include($root_path.'conf/frame_admin.php');
?>