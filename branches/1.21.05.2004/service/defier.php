<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_defier';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
if (!empty($_POST['submit']) )
	{
	$forum_error = "";
	//on v�rifie le formulaire point par point
	if(empty($_POST['clan']))
	{
		$forum_error .= $langue['erreur_clan_vide'];
	}
	if(empty($_POST['mail_demande']))
	{
		$forum_error .= $langue['erreur_mail_vide'];
	}
	else if (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['mail_demande']))
	{
		$forum_error .= $langue['erreur_mail_invalide'];
	}
	if($_POST['jours'] == "0")
	{
		$forum_error .= $langue['erreur_jour_vide'];
	}
	if($_POST['mois'] == "-1")
	{
		$forum_error .= $langue['erreur_mois_vide'];
	}
	if($_POST['min'] == "-1")
	{
		$forum_error .= $langue['erreur_minute_vide'];
	}
	if($_POST['heure'] == "0")
	{
		$forum_error .= $langue['erreur_heure_vide'];
	}
	if(empty($_POST['msn_demandeur']))
	{
		$forum_error .= $langue['erreur_msn_vide'];
	}
	else if (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['msn_demandeur']))
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
		// on envoys 	
		// convertir la date en mktime
		$date = mktime ( $_POST['heure'] , $_POST['min'] , 1 , $_POST['mois'] , $_POST['jours'] , date("Y"));
		$sql = "INSERT INTO `".$config['prefix']."match_demande` (`clan`, `date`, `joueurs`, `mail_demande`, `msn_demandeur`, `url_clan`, `info`) VALUES ('".$_POST['clan']."', '".$date."', '".$_POST['joueurs']."', '".$_POST['mail_demande']."', '".$_POST['msn_demandeur']."', '".$_POST['url_clan']."', '".$_POST['info_match']."')"; 
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		// on envoy un mail au webmasteur
		include_once($root_path.'service/wamailer/class.mailer.php');
		$mailer = new Mailer();
		$mailer->set_root($root_path.'service/wamailer/');
		if ($config['send_mail'] == 'smtp')
		{
			$mailer->use_smtp($config['smtp_ip'], $config['smtp_port']);
			$mailer->smtp_pass = $config['smtp_code'];
			$mailer->smtp_user = $config['smtp_login'];
		}
		$mailer->set_from($_POST['mail_demande']);
		$mailer->set_reply_to($_POST['mail_demande']);
		$mailer->set_address(( $membre_match = $rsql->s_array($get) ) ? $membre_match['mail'] : $config['master_mail']);
		$mailer->set_subject(sprintf($langue['mail_titre_defit_prop'] ,$config['tag']));
		$mailer->set_message($langue['mail_defit_prop']);
		$mailer->send();
		redirec_text("index_pri.php", $langue['user_envois_defit'], "user");
	}
}
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'defier.tpl'));
liste_smilies(true, '', 25);
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
	'DECEMBRE' => $langue['d�cembre'],
	'ENVOYER' => $langue['envoyer']
));
if ( !empty($forum_error) )
{
	msg('erreur' ,$forum_error);
	$template->assign_vars(array( 
		'FORM_MAIL' => (empty($_POST['mail_demande']))? '' : $_POST['mail_demande'],
		'FORM_MSN' => (empty($_POST['msn_demandeur']))? '' : $_POST['msn_demandeur'],
		'FORM_CLAN' => (empty($_POST['clan']))? '' : $_POST['clan'],
		'FORM_URL_CLAN' => (empty($_POST['url_clan']))? '' : $_POST['url_clan'],
		'FORM_INFO_PLUS' => (empty($_POST['info_match']))? '' : $_POST['info_match'],
	));
}
for($i=1;$i <= $config['nbr_membre'];$i++)
{
	$template->assign_block_vars('liste_nbr_players', array( 
		'SELECTED' => (!empty($_POST['joueurs']) && $_POST['joueurs'] == $i)? 'selected="selected"' : '',
		'NUM' => $i,
	));

}
$template->pparse('body');
include($root_path."conf/frame.php"); 
 ?>