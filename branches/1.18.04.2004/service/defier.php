<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_defier';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
if (!empty($HTTP_POST_VARS['submit']) )
	{
	$forum_error = "";
	//on vérifie le formulaire point par point
	if(empty($HTTP_POST_VARS['clan']))
	{
		$forum_error .= $langue['erreur_clan_vide'];
	}
	if(empty($HTTP_POST_VARS['mail_demande']))
	{
		$forum_error .= $langue['erreur_mail_vide'];
	}
	else if (!eregi("(.+)@(.+).([a-z]{2,4})$", $HTTP_POST_VARS['mail_demande']))
	{
		$forum_error .= $langue['erreur_mail_invalide'];
	}
	if($HTTP_POST_VARS['jours'] == "0")
	{
		$forum_error .= $langue['erreur_jour_vide'];
	}
	if($HTTP_POST_VARS['mois'] == "-1")
	{
		$forum_error .= $langue['erreur_mois_vide'];
	}
	if($HTTP_POST_VARS['min'] == "-1")
	{
		$forum_error .= $langue['erreur_minute_vide'];
	}
	if($HTTP_POST_VARS['heure'] == "0")
	{
		$forum_error .= $langue['erreur_heure_vide'];
	}
	if(empty($HTTP_POST_VARS['msn_demandeur']))
	{
		$forum_error .= $langue['erreur_msn_vide'];
	}
	else if (!eregi("(.+)@(.+).([a-z]{2,4})$", $HTTP_POST_VARS['msn_demandeur']))
		{
			$forum_error .= $langue['erreur_msn_invalide'];
		}
	if (empty($forum_error))
	{
		// on regarde a qui on doit envoyer
		$sql = "SELECT mail,user FROM ".$config['prefix']."user WHERE id ='".$config['id_membre_match']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$mail_envois = ( $membre_match = $rsql->s_array($get) ) ? $membre_match['mail'] : $config['master_mail'];
		// on envoys 	
		// convertir la date en mktime
		$date = mktime ( $HTTP_POST_VARS['heure'] , $HTTP_POST_VARS['min'] , 1 , $HTTP_POST_VARS['mois'] , $HTTP_POST_VARS['jours'] , date("Y"));
		$sql = "INSERT INTO `".$config['prefix']."match_demande` (`clan`, `date`, `joueurs`, `mail_demande`, `msn_demandeur`, `url_clan`, `info`) VALUES ('".$HTTP_POST_VARS['clan']."', '".$date."', '".$HTTP_POST_VARS['joueurs']."', '".$HTTP_POST_VARS['mail_demande']."', '".$HTTP_POST_VARS['msn_demandeur']."', '".$HTTP_POST_VARS['url_clan']."', '".$HTTP_POST_VARS['info_match']."')"; 
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		// on envoy un mail au webmasteur
		$entetemail  = "From: ".$HTTP_POST_VARS['mail_demande']."\n"; // Adresse expéditeur
		$entetemail .= "Reply-To: ".$HTTP_POST_VARS['mail_demande']."\n"; // Adresse de retour
		mail($config['master_mail'], sprintf($langue['mail_titre_defit_prop'] ,$config['tag']), $langue['mail_defit_prop'], $entetemail);
		redirec_text("index_pri.php", $langue['user_envois_defit'], "user");
	}
}
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'defier.tpl'));
$template->assign_vars(array( 
	'TXT_CHOISIR' => $langue['choisir'],
	'TITRE_DEFIT' => $langue['titre_defier'],
	'NOM_CLAN_ADV' => $langue['nom_clan_opose'],
	'URL_CLAN_ADV' => $langue['url_clan_opose'],
	'HEURE_DEFIT' => $langue['heure_defit'],
	'NBR_JOUEUR' => $langue['nombre_joueurs'],
	'INFO_PLUS' => $langue['info_en_plus'],
	'DATE' => $langue['date_defit'],
	'MAIL' => $langue['form_mail'],
	'MSN' => $langue['form_msn'],
	'JOUR' => $langue['form_jour'],
	'MOIS' => $langue['form_mois'],
	'HEURE' => $langue['form_heure'],
	'MINUTE' => $langue['form_min'],
	'JANVIER' => $langue['janvier'],
	'FEVRIER' => $langue['fevrier'],
	'MARS' => $langue['mars'],
	'AVRIL' => $langue['avril'],
	'MAI' => $langue['mai'],
	'JUIN' => $langue['juin'],
	'JUILLET' => $langue['juillet'],
	'AOUT' => $langue['aout'],
	'SEPTEMBRE' => $langue['septembre'],
	'OCTOBRE' => $langue['octobre'],
	'NOVEMBRE' => $langue['novembre'],
	'DECEMBRE' => $langue['décembre'],
	'ENVOYER' => $langue['envoyer']
));
if ( !empty($forum_error) )
{
	msg('erreur' ,$forum_error);
	$template->assign_vars(array( 
		'FORM_MAIL' => (empty($HTTP_POST_VARS['mail_demande']))? '' : $HTTP_POST_VARS['mail_demande'],
		'FORM_MSN' => (empty($HTTP_POST_VARS['msn_demandeur']))? '' : $HTTP_POST_VARS['msn_demandeur'],
		'FORM_CLAN' => (empty($HTTP_POST_VARS['clan']))? '' : $HTTP_POST_VARS['clan'],
		'FORM_URL_CLAN' => (empty($HTTP_POST_VARS['url_clan']))? '' : $HTTP_POST_VARS['url_clan'],
		'FORM_INFO_PLUS' => (empty($HTTP_POST_VARS['info_match']))? '' : $HTTP_POST_VARS['info_match'],
	));
}
for($i=1;$i <= $config['nbr_membre'];$i++)
{
	$template->assign_block_vars('liste_nbr_players', array( 
		'SELECTED' => (!empty($HTTP_POST_VARS['joueurs']) && $HTTP_POST_VARS['joueurs'] == $i)? 'selected="selected"' : '',
		'NUM' => $i,
	));

}
$template->pparse('body');
include($root_path."conf/frame.php"); 
 ?>