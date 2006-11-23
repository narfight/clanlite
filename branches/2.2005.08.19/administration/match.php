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
$action_membre= 'where_admin_match';
$niveau_secu = 14;
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if ( !empty($_POST['Submit']) )
{
	$date = adodb_mktime( $_POST['heure_match'], $_POST['minute_match'] , 1 , $_POST['date2'] , $_POST['date1'] , $_POST['date3'])-$session_cl['correction_heure'];
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."match` (date, info , priver, le_clan, nombre_de_joueur, heure_msn, section) VALUES ('".$date."', '".$_POST['infoe']."', '".$_POST['priver']."', '".$_POST['clan']."', '".$_POST['joueur']."', '".$_POST['heure_msn']."', '".$_POST['section']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('match.php', $langue['redirection_admin_match_add'],'admin');
}
if (!empty($_POST['del']))
{
	$sql = "DELETE FROM `".$config['prefix']."match` WHERE id ='".$_POST['id_match']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE id_match ='".$_POST['id_match']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text('match.php',$langue['redirection_admin_match_dell'], 'admin');
}
if (!empty($_POST['edit_save']))
{
	$date = adodb_mktime( $_POST['heure_match'], $_POST['minute_match'] , 1 , $_POST['date2'] , $_POST['date1'] , $_POST['date3'])-$session_cl['correction_heure'];
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."match` SET date='".$date."', info='".$_POST['infoe']."', priver='".$_POST['priver']."', le_clan='".$_POST['clan']."', nombre_de_joueur='".$_POST['joueur']."', heure_msn='".$_POST['heure_msn']."', section='".$_POST['section']."' WHERE id ='".$_POST['id_match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("match.php#".$_POST['id_match'],$langue['redirection_admin_match_edit'],'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'admin_match.tpl'));
liste_smilies(true, '', 25);
$template->assign_vars(array( 
	'ICI' => session_in_url('match.php'),
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_admin_match'],
	'TITRE_GESTION' => $langue['titre_admin_match_gestion'],
	'TITRE_LISTE' => $langue['titre_admin_match_list'],
	'TXT_NBR_JOUEUR' => $langue['nbr_joueurs'],
	'TXT_DATE' => $langue['date_defit'],
	'TXT_HEURE' => $langue['heure_defit'],
	'TXT_HEURE_CHAT' => $langue['heure_chat'],
	'TXT_CONTRE' => $langue['contre_qui'],
	'TXT_SECTION' => $langue['quelle_section'],
	'CHOISIR' => $langue['choisir'],
	'ALL_SECTION' => $langue['toutes_section'],
	'TXT_DETAILS' => $langue['détails'],
	'MSG_PRIVE' => $langue['message_cote_prive'],
	'VOIR' => $langue['détails']
));
if (!empty($_POST['Editer']))
{
	$sql = "SELECT date, le_clan, heure_msn, nombre_de_joueur, info, section FROM `".$config['prefix']."match` AS matche WHERE id ='".$_POST['id_match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$info_match = $rsql->s_array($get);
	$template->assign_vars( array( 
		'ID_MATCH' => $_POST['id_match'],
		'JOURS' => adodb_date('d', $info_match['date']+$session_cl['correction_heure']),
		'MOIS' => adodb_date('n', $info_match['date']+$session_cl['correction_heure']),
		'ANNEE' => adodb_date('Y', $info_match['date']+$session_cl['correction_heure']),
		'TEAM_ADV' => $info_match['le_clan'],
		'HH' => adodb_date('H', $info_match['date']+$session_cl['correction_heure']),
		'MM' => adodb_date('i', $info_match['date']+$session_cl['correction_heure']),
		'HEURE_CHAT' => $info_match['heure_msn'],
		'NOMBRE_J' => $info_match['nombre_de_joueur'],
		'INFO' => $info_match['info'],
		'PRIVER' => $info_match['priver'],
		'SELECTED_ALL' => ($info_match['section'] == 0)? 'selected="selected"' : '',
	));
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer'])); 
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer'])); 
}
// on regarde si il a une action a faire
if ( !empty($_POST['ok']) )
{
	$action = 'ok';
}
if ( !empty($_POST['demande']) )
{
	$action = 'demande';
}
if ( !empty($_POST['reserve']) )
{
	$action = 'reserve';
}
if ( !empty($action) )
{
	secu_level_test('9');
	$sql = "UPDATE `".$config['prefix']."match_inscription` SET statu='".$action."' WHERE id='".$_POST['for']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
}
$sql = "SELECT inscriptions.statu, inscriptions.id_match, inscriptions.id, user.user FROM `".$config['prefix']."match_inscription` AS inscriptions LEFT JOIN `".$config['prefix']."user` AS user ON inscriptions.user_id = user.id";
if (! ($get_joueur = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($list_user = $rsql->s_array($get_joueur)) )
{
	$liste_user_match[$list_user['id_match']][$list_user['statu']][$list_user['user']] = array('user' => $list_user['user'], 'id' => $list_user['id']);
}
$sql = "SELECT a.*, section.nom FROM `".$config['prefix']."match` a LEFT JOIN ".$config['prefix']."section section ON a.section = section.id ORDER BY a.date ASC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$i=0;
while ( ($list_match = $rsql->s_array($get_match)) )
{
	$i++;
	$template->assign_block_vars('match', array( 
		'ADD_TEAM_OK' => $langue['add_team_ok'],
		'ADD_TEAM_DEMANDE' => $langue['add_team_demande'],
		'ADD_TEAM_RESERVE' => $langue['add_team_reserve'],
		'TEAM_OK' => $langue['team_ok'],
		'TEAMS_RESERVE' => $langue['team_reserve'],
		'TEAM_DEMANDE' => $langue['team_demande'],
		'EDITER' => $langue['editer'],
		'SUPPRIMER' => $langue['supprimer'],
		'CONTRE' => $langue['contre_qui'],
		'FOR' => $list_match['id'],
		'DATE' => adodb_date('j/n/Y', $list_match['date']+$session_cl['correction_heure']),
		'HEURE' => adodb_date('H:i', $list_match['date']+$session_cl['correction_heure']),
		'CLAN' => $list_match['le_clan'],
		'SECTION' => (empty($list_match['nom']))? $langue['toutes_section'] : $list_match['nom'],
		'INFO' => bbcode($list_match['info']),
		'PRIVER' =>  bbcode($list_match['priver']),
		'SUR' => $list_match['nombre_de_joueur'],
		'CHAT' => $list_match['heure_msn'],
		'NB_JOUEURS' => (!empty($liste_user_match[$list_match['id']]['ok']))? count($liste_user_match[$list_match['id']]['ok']) : "0",
		'ACTION_USER_MATCH' => (!empty($liste_user_match[$list_match['id']]['ok']) && (count($liste_user_match[$list_match['id']]['ok'][$session_cl['user']]) >= 1 || count($liste_user_match[$list_match['id']]['reserve'][$session_cl['user']]) >= 1 || count($liste_user_match[$list_match['id']]['demande'][$session_cl['user']]) >= 1))? "moin" : "add",
		'TXT_SECTION' => $langue['quelle_section'],

	));
	if (!empty($liste_user_match[$list_match['id']]))
	{
		foreach($liste_user_match[$list_match['id']] as $etat_inscription => $non_inscription)
		{
			foreach($non_inscription as $non_inscri)
			{
				$template->assign_block_vars('match.'.$etat_inscription, array( 
					'NOM' => $non_inscri['user'],
					'ID' => $non_inscri['id'],
				));
			}
		}
	}
} 
if ($i == 0)
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_futur_match']));
}
$sql = "SELECT * FROM ".$config['prefix']."section";
if (! ($get_section_liste = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_section = $rsql->s_array($get_section_liste)) )
{
	$template->assign_block_vars('section', array( 
		'SELECTED' => (!empty($info_match['section']) && $info_match['section'] == $liste_section['id'])? 'selected="selected"' : '',
		'ID' => $liste_section['id'],
		'NOM' => $liste_section['nom']
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>