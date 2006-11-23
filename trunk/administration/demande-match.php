<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 3;
$action_membre= 'where_defit_admin';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['del']))
{
	$sql = "DELETE FROM ".$config['prefix']."match_demande WHERE id = '".$HTTP_POST_VARS['id']."'";
	if (! $rsql->requete_sql($sql) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	redirec_text("demande-match.php",$langue['redirection_defit_dell'],"admin");
}
// action = envoyer
if (!empty($HTTP_POST_VARS['envois_mail']))
{
	// on envoys le mail
	$sql = "SELECT * FROM ".$config['prefix']."match_demande WHERE id= '".$HTTP_POST_VARS['id']."'";
	if (! ($post = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$envois = $rsql->s_array($post);
	$entetemail  = "From: ".$HTTP_POST_VARS['From']." \n"; // Adresse expéditeur
	$entetemail .= "Reply-To: ".$HTTP_POST_VARS['Reply']." \n"; // Adresse de retour
	mail($HTTP_POST_VARS['mail'], sprintf($langue['titre_mail_defit'], $config['tag']), $HTTP_POST_VARS['texte'], $entetemail);
	// si il veut bien le match on le rajoute dans les match
	if ($HTTP_POST_VARS['envois'] == 'oui')
	{
		// la on ajoute le match
		$sql = "INSERT INTO `".$config['prefix']."match` (date, info, le_clan, nombre_de_joueur, heure_msn, section) VALUES ('".$envois['date']."', '".$envois['info']."', '".$envois['clan']."', '".$envois['joueurs']."', '', '0')";
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		//et la on surrpime la demande
		$sql = "DELETE FROM ".$config['prefix']."match_demande WHERE id = ".$HTTP_POST_VARS['id'];
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		redirec_text("demande-match.php",$langue['redirection_defit_add'],"admin");
	}
	if ($HTTP_POST_VARS['envois'] == 'non')
	{
		//on surrpime la demande
		$sql = "DELETE FROM ".$config['prefix']."match_demande WHERE id = ".$HTTP_POST_VARS['id'];
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		redirec_text("demande-match.php",$langue['redirection_defit_dell'],"admin");
	}
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_propo_match.tpl'));
$template->assign_vars(array( 
	'TITRE' => $langue['titre_defit_admin'],
	'TITRE_LISTE' => $langue['titre_list_defit'],
	'CLAN' => $langue['clan_opose'],
	'CONTACTER' => $langue['contact_clan_op'],
	'DATE' => $langue['date'],
	'HEURE' => $langue['heure'],
	'NOMBRE_PAR_TEAM' => $langue['nbr_joueurs'],
	'INFO' => $langue['info_defit_admin'],
	'ACTION' => $langue['action'],
	'REPONCE' => $langue['reponce_defit'],
));
if ( (!empty($HTTP_POST_VARS['envois_oui']) || !empty($HTTP_POST_VARS['envois_non'])) && !empty($HTTP_POST_VARS['id']) )
{
	// on preparre a utiliser la fonction mail() normale
	$sql = "SELECT * FROM ".$config['prefix']."match_demande WHERE id=".$HTTP_POST_VARS['id'];
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$nfo_match = $rsql->s_array($get);
	$sql = "SELECT mail, user FROM ".$config['prefix']."user WHERE id='".$config['id_membre_match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	if ( $membre_match = $rsql->s_array($get) )
	{
		$mail = $membre_match['mail'];
		$nom = $membre_match['user'];
	}
	else
	{
		$mail = $config['master_mail'];
		$nom = $langue['admin'];
	}
	if (!empty($HTTP_POST_VARS['envois_oui']))
	{
		$texte = sprintf($langue['reponce_defit_oui'], $nfo_match['clan'], date("j/n/Y",$nfo_match['date']), date("H:i",$nfo_match['date']), $nfo_match['joueurs'], $nom, $mail);
	}
	else
	{
		$texte = sprintf($langue['reponce_defit_non'], $nfo_match['clan'], date("j/n/Y",$nfo_match['date']), date("H:i",$nfo_match['date']), $nom, $mail);
	}
	$sql = "SELECT mail FROM ".$config['prefix']."user WHERE id='".$config['id_membre_match']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$template->assign_block_vars('notification', array( 
		'TITRE' => $langue['titre_defit_notif'],
		'ADR_EXPEDITEUR' => $langue['adr_exp'],
		'ADR_RETOUR' => $langue['adr_retour'],
		'ENVOYER_A' => $langue['envoyer_a'],
		'TXT' => $langue['le_txt'],
		'MASTER_MAIL' => $mail,
		'TO' => $nfo_match['mail_demande'],
		'TEXTE' => $texte,
		'ENVOIS' => (empty($HTTP_POST_VARS['envois_non']))? 'oui' : 'non',
		'ID' => $HTTP_POST_VARS['id'],
		'ENVOYER' => $langue['envoyer'],
  	));
}
$sql = "SELECT * FROM ".$config['prefix']."match_demande";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
while (	$liste_demande = $rsql->s_array($get) ) 
{
	$template->assign_block_vars('propo', array( 
		'ALT_MSN' => $langue['alt_msn'],
		'ALT_MAIL' => $langue['alt_mail'],
		'DELL' => $langue['supprimer'],
		'OUI' => $langue['oui'],
		'NON' => $langue['non'],
		'ID' => $liste_demande['id'],
		'CLAN' => $liste_demande['clan'],
		'DATE' => date("j/n/Y", $liste_demande['date']),
		'TIME' => date("H:i", $liste_demande['date']),
		'VS' => $liste_demande['joueurs'],
		'MAIL' => $liste_demande['mail_demande'],
		'NOM' => $liste_demande['msn_demandeur'],
		'URL_CLAN' => $liste_demande['url_clan'],
		'INFO' => $liste_demande['info'],
		'VOIR' => (empty($voir))? "" : $voir
  	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>