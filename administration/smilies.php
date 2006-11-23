<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 12;
$action_membre= "configure les smilies";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['envoyer']))
{ 
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	list($width, $height, $type, $attr) = getimagesize("../images/smilies/".$HTTP_POST_VARS['img']);
	$sql = "INSERT INTO `".$config['prefix']."smilies` (text, img, def, width, height) VALUES ('".$HTTP_POST_VARS['text']."', '".$HTTP_POST_VARS['img']."', '".$HTTP_POST_VARS['def']."', '".$width."', '".$height."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("smilies.php", $langue['redirection_admin_smilies_add'], "admin");
}
if (!empty($HTTP_POST_VARS['envois_edit']))
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	list($width, $height, $type, $attr) = getimagesize("../images/smilies/".$HTTP_POST_VARS['img']);
	$sql = "UPDATE `".$config['prefix']."smilies` SET text='".$HTTP_POST_VARS['text']."', img='".$HTTP_POST_VARS['img']."', def='".$HTTP_POST_VARS['def']."', width='".$width."', height='".$height."' WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("smilies.php", $langue['redirection_admin_smilies_edit'], "admin");
}
if (!empty($HTTP_POST_VARS['Supprimer']))
{
	$sql = "DELETE FROM `".$config['prefix']."smilies` WHERE id ='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("smilies.php", $langue['redirection_admin_smilies_dell'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_smilies.tpl'));
$template->assign_vars( array(
	'ICI' => $HTTP_SERVER_VARS['PHP_SELF'],
	'TITRE' => $langue['titre_admin_smilies'],
	'TITRE_GESTION' => $langue['titre_admin_smilies_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_smilies_list'],
	'ACTION' => $langue['action'],
	'TXT_NOM' => $langue['nom_map_sortie'],
	'TXT_URL' => $langue['url_map_custom'],
	'CHOISIR' => $langue['choisir'],
	'IMAGES' => $langue['smilie_images'],
	'TXT' => $langue['smilie_text'],
	'TXT_DEF' => $langue['smilie_def'],
));
if (!empty($HTTP_POST_VARS['Editer']))
{
	$sql = "SELECT * FROM ".$config['prefix']."smilies WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_smilies = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_smilies['id'],
		'IMG' => $edit_smilies['img'],
		'TEXT' => $edit_smilies['text'],
		'DEF' => $edit_smilies['def'],
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."smilies ORDER BY `id` ASC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	$template->assign_block_vars('list_smilies', array(
		'ID' => $liste['id'],
		'TEXT' => $liste['text'],
		'DEF' => $liste['def'],
		'IMG' => $liste['img'],
		'WIDTH' => $liste['width'],
		'HEIGHT' => $liste['height'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
// liste des smilies
$dir = $root_path."images/smilies";
// Ouvre un dossier bien connu, et liste tous les fichiers
if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if($file != '..' && $file !='.' && $file !='')
			{ 
				$template->assign_block_vars('list_img', array(
					'VALEUR' => $file,
					'SELECTED' => ( !empty($edit_smilies['img']) && $file == $edit_smilies['img'] ) ? 'selected="selected"' : ''
				));
			}
		}
		closedir($dh);
	}
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>