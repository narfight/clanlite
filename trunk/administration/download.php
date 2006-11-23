<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_download_admin';
$niveau_secu = 4;
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['Envoyer_group']))
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "INSERT INTO `".$config['prefix']."download_groupe` (nom, comentaire) VALUES ('".$HTTP_POST_VARS['nom_group']."', '".$HTTP_POST_VARS['information_group']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("download.php", $langue['redirection_group_dl_add'], "admin");
}
if (!empty($HTTP_POST_VARS['Supprimer_group']))
{
	// on vérifie que le group est vide
	$sql = "SELECT COUNT(id) as nombre FROM `".$config['prefix']."download_fichier` WHERE id_rep ='".$HTTP_POST_VARS['for_group']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$nbr_fichier = $rsql->s_array($get);
	if ($nbr_fichier['nombre'] == 0)
	{
		$sql = "DELETE FROM `".$config['prefix']."download_groupe` WHERE id ='".$HTTP_POST_VARS['for_group']."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text("download.php", $langue['redirection_group_dl_dell'], "admin");
	}
	else
	{
		redirec_text("download.php", $langue['redirection_group_dl_pasvide'], "admin");
	}
}
if (!empty($HTTP_POST_VARS['Edit_group']))
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "UPDATE `".$config['prefix']."download_groupe` SET nom='".$HTTP_POST_VARS['nom_group']."', comentaire='".$HTTP_POST_VARS['information_group']."' WHERE id ='".$HTTP_POST_VARS['for_group']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("download.php", $langue['redirection_group_dl_edit'], "admin");
}
if ( !empty($HTTP_POST_VARS['Envoyer_fichier']) )
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "INSERT INTO ".$config['prefix']."download_fichier (id_rep, nom_de_fichier, info_en_plus, telecharger, nombre_de_vote, cote, modifier_a, url_dl) VALUES ('".$HTTP_POST_VARS['groupe']."', '".$HTTP_POST_VARS['nom']."', '".$HTTP_POST_VARS['information']."', '0', '0', '0', '".$config['current_time']."', '".$HTTP_POST_VARS['url_dl']."')";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	redirec_text("download.php", $langue['redirection_dl_add'], "admin");
}
if ( !empty($HTTP_POST_VARS['Supprimer_fichier']) )
{
	$sql = "DELETE FROM `".$config['prefix']."download_fichier ` WHERE id = '".$HTTP_POST_VARS['for_fichier']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	redirec_text("download.php", $langue['redirection_dl_dell'], "admin");
}
if ( !empty($HTTP_POST_VARS['Edit_fichier']) )
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "UPDATE `".$config['prefix']."download_fichier` SET nom_de_fichier='".$HTTP_POST_VARS['nom']."', info_en_plus='".$HTTP_POST_VARS['information']."', modifier_a='".$config['current_time']."', url_dl='".$HTTP_POST_VARS['url_dl']."', id_rep='".$HTTP_POST_VARS['groupe']."' WHERE id = ".$HTTP_POST_VARS['for_fichier'];
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	redirec_text("download.php", $langue['redirection_dl_edit'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_dl_fichiers.tpl'));
$template->assign_vars( array(
	'ICI' => $HTTP_SERVER_VARS['PHP_SELF'],
	'TITRE' => $langue['titre_download_admin'],
	'TITRE_GESTION' => $langue['titre_gestion_download_admin'],
	'TITRE_LISTE' => $langue['titre_liste_download_admin'],
	'TOGGLE_FICHIER' => $langue['toggle_gestion_fichier'],
	'TOGGLE_GROUP' => $langue['toggle_gestion_group'],
	'CHOISIR' => $langue['choisir'],
	'NOM' => $langue['nom'],
	'SRC' => $langue['dll_url'],
	'TXT' => $langue['le_txt'],
	'TXT_GROUP' => $langue['group_fichier'],
	'ACTION' => $langue['action'],
	'COTE' => $langue['download_bt_cote'],
	'DATE_MODIF' => $langue['download_modif'],
));
if (!empty($HTTP_POST_VARS['Editer_group']))
{
	$template->assign_block_vars('editer_group', array('EDITER' => $langue['editer']));
	$sql = "SELECT nom, comentaire, id FROM `".$config['prefix']."download_groupe` WHERE id ='".$HTTP_POST_VARS['for_group']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$editer = $rsql->s_array($get);
	$template->assign_vars( array( 
		'NOM_GROUP' => $editer['nom'],
		'INFO_GROUP' => $editer['comentaire'],
		'FOR_GROUP' => $editer['id']
	));
}
else
{
	$template->assign_block_vars('rajouter_group', array('ENVOYER' => $langue['envoyer']));
}
if ( !empty($HTTP_POST_VARS['Editer_fichier']) )
{
	$template->assign_block_vars('editer_fichier', array('EDITER' => $langue['editer']));
	$sql = "SELECT nom_de_fichier, info_en_plus, url_dl, id, id_rep FROM ".$config['prefix']."download_fichier fichier WHERE fichier.id = ".$HTTP_POST_VARS['for_fichier'];
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error() , __LINE__, __FILE__);
	}
	$editer = $rsql->s_array($get);
	$template->assign_vars( array( 
    	'NOM_FICHIER' => $editer['nom_de_fichier'],
		'INFO_FICHIER' => $editer['info_en_plus'],
		'URL_FICHIER' => $editer['url_dl'],
		'FOR_FICHIER' => $editer['id']
	));
}
else
{
	$template->assign_block_vars('rajouter_fichier', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT nom, id, comentaire FROM `".$config['prefix']."download_groupe`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
while ($group_liste = $rsql->s_array($get))
{
	$liste_group[$group_liste['id']] = $group_liste['nom'];
	$template->assign_block_vars('liste_group', array( 
		'SELECTED' => (!empty($editer['id_rep']) && $editer['id_rep'] == $group_liste['id'])? 'selected="selected"' : '',
		'GROUP' => $group_liste['nom'],
		'ID_GROUP' => $group_liste['id'],
		'INFO' => $group_liste['comentaire']
	));
}
$sql = "SELECT * FROM ".$config['prefix']."download_fichier fichier";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
while ($actuelle = $rsql->s_array($get))
{
	$cote = "0";
	if ($actuelle['nombre_de_vote'] != 0)
 	{
		$cote = $actuelle['cote']/$actuelle['nombre_de_vote'];
	}
	$liste_fichier[$actuelle['id_rep']][$actuelle['id']] = $actuelle;
}
foreach($liste_group as $id_group => $nom_group)
{
	$template->assign_block_vars('liste_group_bas', array(
		'GROUP_NOM' => $nom_group,
		'GROUP_ID' => $id_group,
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer'],		
	));
	if (!empty($liste_fichier[$id_group]))
	{
		foreach($liste_fichier[$id_group] as $fichier_id => $array_fichier)
		{
			$template->assign_block_vars('liste_group_bas.liste', array( 
				'NOM' => $array_fichier['nom_de_fichier'],
				'URL' => $array_fichier['url_dl'],
				'COTE' => floor($cote),
				'MODIF' => date('j-m-Y' , $array_fichier['modifier_a']),
				'INFO' => nl2br(bbcode($array_fichier['info_en_plus'])),
				'FOR' => $fichier_id,
				'EDITER' => $langue['editer'],
				'SUPPRIMER' => $langue['supprimer'],		
			));
		}
	}
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>