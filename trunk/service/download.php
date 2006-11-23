<?php
/****************************************************************************
 *	Fichier		: 															*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$action_membre = 'where_download';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
if ( !empty($_POST['dll']) )
{// on envois le fichier a télécharger si il a
	$sql = "SELECT url_dl,telecharger FROM ".$config['prefix']."download_fichier WHERE id='".$_POST['for']."' LIMIT 1";
	if (! $get_nfo_dll = $rsql->requete_sql($sql) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$for_nfo = $rsql->s_array($get_nfo_dll);
	$for_nfo['telecharger']++;
	$sql = "UPDATE `".$config['prefix']."download_fichier` SET telecharger='".$for_nfo['telecharger']."' WHERE id ='".$_POST['for']."'";
	if (! $rsql->requete_sql($sql) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirection($for_nfo['url_dl']);
}
if ( !empty($_POST['send_vote']) )
{//on envois le resultat du vote
	$sql = "SELECT nombre_de_vote,cote FROM ".$config['prefix']."download_fichier WHERE id='".$_POST['for']."' LIMIT 1";
	if (! $get_nfo_vote = $rsql->requete_sql($sql) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$for_nfo = $rsql->s_array($get_nfo_vote);
	$nbr = $for_nfo['nombre_de_vote']+1;
	$plus_nombre =$for_nfo['cote']+$_POST['select'];
	$sql = "UPDATE `".$config['prefix']."download_fichier` SET nombre_de_vote='".$nbr."', cote='".$plus_nombre."' WHERE id ='".$_POST['for']."'";
	if (! $rsql->requete_sql($sql) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('download.php', $langue['user_envois_vote'], 'user');
}
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'dl_fichiers.tpl'));
$template->assign_vars(array( 
	'ICI' => session_in_url('download.php'),
	'TITRE_DOWNLOAD' => $langue['titre_download'],
	'TOP_10' => $langue['download_top_10'],
	'TOP_10_U' => session_in_url('download.php?top_dl=nbr_dl#debut'),
	'TOP_10_DEF' => $langue['download_top_10_def'],
));
if ( !empty($_POST['voter']) )
{// on lui donne le formulaire pour voter
	$template->assign_block_vars('voter', array( 
		'TITRE_VOTRE' => $langue['titre_defier'],
		'VOTE_EXPLICATION' => $langue['download_vote_explication'],
		'ENVOYER' => $langue['download_vote_envoyer'],
		'FOR' => $_POST['for'],
	));
}
else
{
	if( empty($_POST['action']) )
	{// on affiche les groups de téléchargement
		$template->assign_block_vars('tete', array('vide' => 'vide'));
		$sql = "SELECT groups.*, COUNT(fichiers.id_rep) FROM `".$config['prefix']."download_groupe` AS groups LEFT JOIN `".$config['prefix']."download_fichier` AS fichiers ON groups.id = fichiers.id_rep GROUP BY groups.id";
		if (! $cat_list = $rsql->requete_sql($sql) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while ($info_group = $rsql->s_array($cat_list))
		{
			$template->assign_block_vars('tete.group', array( 
				'GROUP_U' => session_in_url('download.php?for_rep='.$info_group['id'].'#debut'),
				'INFO_GROUP'  => $info_group['nom'].' ('.$info_group['COUNT(fichiers.id_rep)'].')',
				'INFO_GROUP_DETAIL' => bbcode($info_group['comentaire'])
			));
		
		}
	}
	if (!empty($_GET['for_rep']) || !empty($_GET['top_dl']) )
	{// on fais la liste des fichiers du group
		if ( !empty($_GET['for_rep']) )
		{
			$template->assign_vars(array('FOR_REP' => $_GET['for_rep']));
			$_GET['limite'] = (empty($_GET['limite']) || !is_numeric($_GET['limite']))? 0 : $_GET['limite'];
			$total = get_nbr_objet('download_fichier', "id_rep ='".$_GET['for_rep']."'");
		}
		else
		{
			$_GET['for_rep'] = '';
		}
		// on regarde si il a pas une régle de tri
		if ( !empty($_GET['top_dl']) )
		{
			if ($_GET['top_dl'] == 'nbr_dl')
			{
				$where = "ORDER BY telecharger DESC LIMIT 10";
			}
		}
		else
		{
			$where = "WHERE id_rep ='".$_GET['for_rep']."' LIMIT ".$_GET['limite'].",".$config['objet_par_page'];
		}
		$sql = "SELECT * FROM ".$config['prefix']."download_fichier ".$where;
		if (! $resultat_actu = $rsql->requete_sql($sql) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$nbr_fichier = 0;
		$template->assign_block_vars('liste_fichiers', array(
			'LISTE_DLL' => $langue['download_list'],
		));
		while ($actuelle = $rsql->s_array($resultat_actu))
		{
			$nbr_fichier++;
			$cote = 0;
			if (!empty($actuelle['nombre_de_vote']))
			{
				$cote = $actuelle['cote']/$actuelle['nombre_de_vote'];
				$cote = floor($cote).'/10 ('.$actuelle['nombre_de_vote'].')';
			}
			else
			{
				$cote = $langue['download_no_vote'];
			}
			$template->assign_block_vars('liste_fichiers.pas_vide', array( 
				'VOTER' => $langue['download_vote_envoyer'],
				'TELECHARGER' => $langue['download_bt_telecharger'],
				'NOM' => $actuelle['nom_de_fichier'],
				'TXT_LAST_MODIF' => $langue['download_modif'],
				'TXT_COTE' => $langue['download_bt_cote'],
				'TXT_NB_TELECHARGER' => $langue['download_nombre'],
				'LAST_MODIF' => adodb_date('j-m-Y' , $actuelle['modifier_a']+$session_cl['correction_heure']), 
				'COTE'  => $cote,
				'DETAIL' => bbcode($actuelle['info_en_plus']),
				'NB_TELECHARGER' => $actuelle['telecharger'],
				'FOR_REP' => $_GET['for_rep'],
				'FOR' => $actuelle['id']
			));
		}
		if ( !empty($_GET['for_rep']) )
		{
			displayNextPreviousButtons($_GET['limite'], $total, 'multi_page', 'download.php', '&amp;for_rep='.$_GET['for_rep']);
		}
	} 
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>