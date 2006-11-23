<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_match_prive';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['match']))
{
	// on vérifie qu'il est pas deja dans le match
	$sql = "SELECT COUNT(id) FROM `".$config['prefix']."match_inscription` WHERE user_id ='".$session_cl['id']."' AND id_match ='".$HTTP_POST_VARS['match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$verif_present = $rsql->s_array($get);
	if ($verif_present['COUNT(id)'] == "0")
	{
		$sql = "INSERT INTO `".$config['prefix']."match_inscription` (id_match, user_id, statu) VALUES ('".$HTTP_POST_VARS['match']."', '".$session_cl['id']."', 'demande')";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text("membre_match.php", $langue['user_envois_demande_ok'], "admin");
	}
	else
	{
		$sql = "DELETE FROM `".$config['prefix']."match_inscription` WHERE `id_match` = '".$HTTP_POST_VARS['match']."' AND `user_id` = '".$session_cl['id']."'";
		if (! ($list = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text("membre_match.php", $langue['user_envois_annule_demande'], "admin");
		}
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'match_membre.tpl'));
$sql = "SELECT nom FROM ".$config['prefix']."section WHERE id ='".$session_cl['section']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$nom_section = $rsql->s_array($get);
$template->assign_vars(array( 
	'TITRE_MATCH' => $langue['titre_match'],
	'SECTION' => $nom_section['nom'],
	'CONTRE' => $langue['contre_qui'],
	'DATE' => $langue['date_defit'],
	'HEURE' => $langue['heure_defit'],
	'NBR_JOUEURS' => $langue['nbr_joueurs'],
	'HEURE_CHAT' => $langue['heure_chat'],
	'QUELLE_SECTION' => $langue['quelle_section'],
	'TEAM_OK' => $langue['team_ok'],
	'TEAM_RESERVE' => $langue['team_reserve'],
	'TEAM_DEMANDE' => $langue['team_demande'],
	'ADD_DELL_DEMANDE' => $langue['ajouter/supprimer_demande_match'],
));
$sql = "SELECT inscriptions.statu, inscriptions.id_match, inscriptions.id, user.user FROM `".$config['prefix']."match_inscription` AS inscriptions LEFT JOIN `".$config['prefix']."user` AS user ON inscriptions.user_id = user.id";
if (! ($get_joueur = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($list_user = $rsql->s_array($get_joueur)) )
{
	$liste_user_match[$list_user['id_match']][$list_user['statu']][$list_user['user']] = $list_user['user'];
}
$sql = "SELECT a.*, section.nom FROM ".$config['prefix']."match a LEFT JOIN ".$config['prefix']."section section ON section.id='".$session_cl['section']."' WHERE a.section ='".$session_cl['section']."' OR a.section ='0' OR section.limite ='0' ORDER BY a.date ASC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($list_match = $rsql->s_array($get_match)) )
{
	$template->assign_block_vars('match', array( 
		'FOR' => $list_match['id'],
		'DATE' => date("j/n/Y", $list_match['date']),
		'CLAN' => $list_match['le_clan'],
		'SECTION' => (empty($list_match['nom']))? $langue['toutes_section'] : $list_match['nom'],
		'INFO' => nl2br(bbcode($list_match['info'])),
		'SUR' => $list_match['nombre_de_joueur'],
		'HEURE' => date("H:i", $list_match['date']),
		'CHAT' => $list_match['heure_msn'],
		'NB_JOUEURS' => (!empty($liste_user_match[$list_match['id']]))? count($liste_user_match[$list_match['id']]['ok']) : "0",
	));
	if (!empty($liste_user_match[$list_match['id']]))
	{
		foreach($liste_user_match[$list_match['id']] as $etat_inscription => $non_inscription)
		{
			foreach($non_inscription as $non_inscri)
			{
				$template->assign_block_vars('match.'.$etat_inscription, array( 
					'NOM' => $non_inscri,
				));
			}
		}
	}
} 
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>