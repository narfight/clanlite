<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_admin_match';
$niveau_secu = 14;
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if ( !empty($HTTP_POST_VARS['Submit']) )
{
	// on sauvegarde le match
	$date = mktime ( $HTTP_POST_VARS['heure_match'] , $HTTP_POST_VARS['minute_match'] , 1 , $HTTP_POST_VARS['date2'] , $HTTP_POST_VARS['date1'] , $HTTP_POST_VARS['date3']);
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "INSERT INTO `".$config['prefix']."match` (date , info , le_clan , nombre_de_joueur , heure_msn, section) VALUES ('".$date."', '".$HTTP_POST_VARS['infoe']."', '".$HTTP_POST_VARS['clan']."', '".$HTTP_POST_VARS['joueur']."', '".$HTTP_POST_VARS['heure_msn']."', '".$HTTP_POST_VARS['section']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("match.php",$langue['redirection_admin_match_add'],"admin");
}
if (!empty($HTTP_POST_VARS['del']))
{
	// on enleve des listes des match
	$sql = "DELETE FROM `".$config['prefix']."match` WHERE id ='".$HTTP_POST_VARS['id_match']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	// on enleve les inscriptions pour le match
	$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE id_match ='".$HTTP_POST_VARS['id_match']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("match.php",$langue['redirection_admin_match_dell'],"admin");
}
if (!empty($HTTP_POST_VARS['edit_save']))
{
	$date = mktime ( $HTTP_POST_VARS['heure_match'] , $HTTP_POST_VARS['minute_match'] , 1 , $HTTP_POST_VARS['date2'] , $HTTP_POST_VARS['date1'] , $HTTP_POST_VARS['date3']);
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$sql = "UPDATE `".$config['prefix']."match` SET date='".$date."', info='".$HTTP_POST_VARS['infoe']."', le_clan='".$HTTP_POST_VARS['clan']."', nombre_de_joueur='".$HTTP_POST_VARS['joueur']."', heure_msn='".$HTTP_POST_VARS['heure_msn']."', section='".$HTTP_POST_VARS['section']."' WHERE id ='".$HTTP_POST_VARS['id_match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("match.php#".$HTTP_POST_VARS['id_match'],$langue['redirection_admin_match_edit'],"admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_match.tpl'));
$template->assign_vars(array( 
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
));
if (!empty($HTTP_POST_VARS['Editer']))
{
	$sql = "SELECT date, le_clan, heure_msn, nombre_de_joueur, info, section FROM `".$config['prefix']."match` AS matche WHERE id ='".$HTTP_POST_VARS['id_match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$info_match = $rsql->s_array($get);
	$template->assign_vars( array( 
		'ID_MATCH' => $HTTP_POST_VARS['id_match'],
		'JOURS' => date("d", $info_match['date']),
		'MOIS' => date("n", $info_match['date']),
		'ANNEE' => date("Y", $info_match['date']),
		'TEAM_ADV' => $info_match['le_clan'],
		'HH' => date("H", $info_match['date']),
		'MM' => date("i", $info_match['date']),
		'HEURE_CHAT' => $info_match['heure_msn'],
		'NOMBRE_J' => $info_match['nombre_de_joueur'],
		'INFO' => $info_match['info'],
		'SELECTED_ALL' => ($info_match['section'] == 0)? 'selected="selected"' : '',
	));
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer'])); 
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer'])); 
}
// on regarde si il a une action a faire
if ( !empty($HTTP_POST_VARS['ok']) )
{
	$action = "ok";
}
if ( !empty($HTTP_POST_VARS['demande']) )
{
	$action = "demande";
}
if ( !empty($HTTP_POST_VARS['reserve']) )
{
	$action = "reserve";
}
if ( !empty($action) )
{
	secu_level_test('9');
	$sql = "UPDATE `".$config['prefix']."match_inscription` SET statu='".$action."' WHERE id='".$HTTP_POST_VARS['for']."'";
	if (! ($rsql->requete_sql($sql)) )
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
$sql = "SELECT a.*, section.nom FROM ".$config['prefix']."match a LEFT JOIN ".$config['prefix']."section section ON a.section = section.id ORDER BY a.date ASC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($list_match = $rsql->s_array($get_match)) )
{
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
		'DATE' => date("j/n/Y", $list_match['date']),
		'CLAN' => $list_match['le_clan'],
		'SECTION' => (empty($list_match['nom']))? $langue['toutes_section'] : $list_match['nom'],
		'INFO' => nl2br(bbcode($list_match['info'])),
		'SUR' => $list_match['nombre_de_joueur'],
		'HEURE' => date("H:i", $list_match['date']),
		'CHAT' => $list_match['heure_msn'],
		'NB_JOUEURS' => (!empty($liste_user_match[$list_match['id']]))? count($liste_user_match[$list_match['id']]['ok']) : "0",
		'ACTION_USER_MATCH' => (!empty($liste_user_match[$list_match['id']]) && (count($liste_user_match[$list_match['id']]['ok'][$session_cl['user']]) >= 1 || count($liste_user_match[$list_match['id']]['reserve'][$session_cl['user']]) >= 1 || count($liste_user_match[$list_match['id']]['demande'][$session_cl['user']]) >= 1))? "moin" : "add",
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
include($root_path."conf/frame_admin.php");
?>