<?php
/****************************************************************************
 *	Fichier		: download.php												*
 *	Copyright	: (C) 2007 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
define('CL_AUTH', true);
$root_path = './../';
$action_membre= 'where_download_admin';
$niveau_secu = 4;
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['Envoyer_group']))
{
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."download_groupe` (nom, comentaire, password) VALUES ('".$_POST['nom_group']."', '".$_POST['information_group']."', '".$_POST['password_group']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('download.php', $langue['redirection_group_dl_add'], 'admin');
}
if (!empty($_POST['Supprimer_group']))
{
	$_POST = pure_var($_POST);
	// on vérifie que le group est vide
	$sql = "SELECT COUNT(id) AS nombre FROM `".$config['prefix']."download_fichier` WHERE id_rep ='".$_POST['for_group']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$nbr_fichier = $rsql->s_array($get);
	if ($nbr_fichier['nombre'] == 0)
	{
		$sql = "DELETE FROM `".$config['prefix']."download_groupe` WHERE id ='".$_POST['for_group']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('download.php', $langue['redirection_group_dl_dell'], 'admin');
	}
	else
	{
		redirec_text('download.php', $langue['redirection_group_dl_pasvide'], 'admin');
	}
}
if (!empty($_POST['Edit_group']))
{
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."download_groupe` SET nom='".$_POST['nom_group']."', comentaire='".$_POST['information_group']."', password='".$_POST['password_group']."' WHERE id ='".$_POST['for_group']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('download.php', $langue['redirection_group_dl_edit'], 'admin');
}
if ( !empty($_POST['Envoyer_fichier']) )
{
	$_POST = pure_var($_POST);
	$sql = "SELECT COUNT(id) AS nombre FROM `".$config['prefix']."download_groupe` WHERE id ='".$_POST['groupe']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$nbr_fichier = $rsql->s_array($get);
	if ($nbr_fichier['nombre'] != 0)
	{// si le repertoire existe
		$sql = "INSERT INTO `".$config['prefix']."download_fichier` (id_rep, nom_de_fichier, info_en_plus, telecharger, nombre_de_vote, cote, modifier_a, url_dl) VALUES ('".$_POST['groupe']."', '".$_POST['nom']."', '".$_POST['information']."', '0', '0', '0', '".$config['current_time']."', '".$_POST['url_dl']."')";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql , $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('download.php', $langue['redirection_dl_add'], 'admin');
	}
	else
	{
		$erreur = $langue['erreur_no_group'];
	}
}
if ( !empty($_POST['Supprimer_fichier']) )
{
	$sql = "DELETE FROM `".$config['prefix']."download_fichier` WHERE id = '".$_POST['for_fichier']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('download.php', $langue['redirection_dl_dell'], 'admin');
}
if ( !empty($_POST['Edit_fichier']) )
{
	$_POST = pure_var($_POST);
	$sql = "SELECT COUNT(id) AS nombre FROM `".$config['prefix']."download_groupe` WHERE id ='".$_POST['groupe']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$nbr_fichier = $rsql->s_array($get);
	if ($nbr_fichier['nombre'] != 0)
	{
		$sql = "UPDATE `".$config['prefix']."download_fichier` SET nom_de_fichier='".$_POST['nom']."', info_en_plus='".$_POST['information']."', modifier_a='".$config['current_time']."', url_dl='".$_POST['url_dl']."', id_rep='".$_POST['groupe']."' WHERE id = ".$_POST['for_fichier'];
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql , $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('download.php', $langue['redirection_dl_edit'], 'admin');
	}
	else
	{
		$erreur = $langue['erreur_no_group'];
		$_POST['Editer_fichier'] = 1;
	}
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_dl_fichiers.tpl'));
liste_smilies_bbcode(true, '', 25);
if (isset($erreur))
{
	$template->assign_block_vars('erreur', array(
		'TITRE' => $langue['erreur_titre'],
		'TXT' => $erreur
	));
	$template->assign_vars( array( 
    	'NOM_FICHIER' => $_POST['nom'],
		'INFO_FICHIER' => $_POST['information'],
		'URL_FICHIER' => $_POST['url_dl'],
		'FOR_FICHIER' => $_POST['for_fichier'],
	));
}
$template->assign_vars( array(
	'ICI' => session_in_url('download.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
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
	'TXT_PASSWORD' => $langue['group_dl_password'],
	'OPTIONNEL' => $langue['optionnel'],
));
if (!empty($_POST['Editer_group']))
{
	$template->assign_block_vars('editer_group', array('EDITER' => $langue['editer']));
	$sql = "SELECT `nom`, `comentaire`, `id`, `password` FROM `".$config['prefix']."download_groupe` WHERE id ='".$_POST['for_group']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$editer = $rsql->s_array($get);
	$template->assign_vars( array( 
		'NOM_GROUP' => $editer['nom'],
		'INFO_GROUP' => $editer['comentaire'],
		'FOR_GROUP' => $editer['id'],
		'PASSWORD_GROUP' => $editer['password']
	));
}
else
{
	$template->assign_block_vars('rajouter_group', array('ENVOYER' => $langue['envoyer']));
}

if ( !empty($_POST['Editer_fichier']) )
{
	$template->assign_block_vars('editer_fichier', array('EDITER' => $langue['editer']));
	if (!isset($erreur))
	{
		$sql = "SELECT nom_de_fichier, info_en_plus, url_dl, id, id_rep FROM ".$config['prefix']."download_fichier fichier WHERE fichier.id = ".$_POST['for_fichier'];
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql , $rsql->error , __LINE__, __FILE__);
		}
		$editer = $rsql->s_array($get);
		$template->assign_vars( array( 
			'NOM_FICHIER' => $editer['nom_de_fichier'],
			'INFO_FICHIER' => $editer['info_en_plus'],
			'URL_FICHIER' => $editer['url_dl'],
			'FOR_FICHIER' => $editer['id']
		));
	}
}
else
{
	$template->assign_block_vars('rajouter_fichier', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT `nom`, `id`, `comentaire`, `password` FROM `".$config['prefix']."download_groupe`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
while ($group_liste = $rsql->s_array($get))
{
	$liste_group[$group_liste['id']] = array ('nom' => $group_liste['nom'], 'psw' => $group_liste['password']);
	$template->assign_block_vars('liste_group', array( 
		'SELECTED' => (!empty($editer['id_rep']) && $editer['id_rep'] == $group_liste['id'])? 'selected="selected"' : '',
		'GROUP' => $group_liste['nom'],
		'ID_GROUP' => $group_liste['id'],
		'INFO' => $group_liste['comentaire']
	));
}
$sql = "SELECT * FROM `".$config['prefix']."download_fichier` ORDER BY `nom_de_fichier` ASC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
while ($actuelle = $rsql->s_array($get))
{
	$cote = 0;
	if ($actuelle['nombre_de_vote'] != 0)
 	{
		$cote = $actuelle['cote']/$actuelle['nombre_de_vote'];
	}
	$liste_fichier[$actuelle['id_rep']][$actuelle['id']] = $actuelle;
}
if ( !empty($liste_group))
{
	foreach($liste_group as $id_group => $le_group)
	{
		$template->assign_block_vars('liste_group_bas', array(
			'GROUP_NOM' => $le_group['nom'],
			'GROUP_ID' => $id_group,
			'EDITER' => $langue['editer'],
			'SUPPRIMER' => $langue['supprimer'],		
		));
		//signiale si il a un code pour télécharger le fichier
		if (!empty($le_group['psw']))
		{
			$template->assign_block_vars('liste_group_bas.psw', array(
				'PATH_ROOT' => $root_path,
				'ALT' => $langue['download_alt_psw'],
			));
		}

		if (!empty($liste_fichier[$id_group]))
		{
			foreach($liste_fichier[$id_group] as $fichier_id => $array_fichier)
			{
				$template->assign_block_vars('liste_group_bas.liste', array( 
					'NOM' => $array_fichier['nom_de_fichier'],
					'URL' => $array_fichier['url_dl'],
					'COTE' => floor($cote),
					'MODIF' => adodb_date('j-m-Y' , $array_fichier['modifier_a']+$session_cl['correction_heure']),
					'INFO' => bbcode(cut_sentence($array_fichier['info_en_plus'], 100)),
					'FOR' => $fichier_id,
					'EDITER' => $langue['editer'],
					'SUPPRIMER' => $langue['supprimer'],		
				));
			}
		}
	}
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>