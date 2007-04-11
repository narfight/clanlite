<?php
/****************************************************************************
 *	Fichier		: index.php													*
 *	Copyright	: (C) 2005 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
define('CL_AUTH', true);
$root_path = './../';
$action_membre= 'where_entree_user';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'info_priver.tpl'));
//on releve tout les match que le joueur peux voir
$sql = "SELECT game.*, COUNT(inscription.id_match) FROM `".$config['prefix']."match` AS game LEFT JOIN ".$config['prefix']."match_inscription AS inscription ON game.id = inscription.id_match AND inscription.statu = 'ok' WHERE section = '".$session_cl['section']."' OR section = '0' GROUP BY inscription.id_match ORDER BY `date` DESC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
$nombre = 0;
$template->assign_vars(array('TITRE' =>  $langue['titre_entree_user']));
while ($match = $rsql->s_array($get_match)) 
{ 
	// on regarde si ils sont pas plien
	if ($match['COUNT(inscription.id_match)'] < $match['nombre_de_joueur'])
	{
		$nombre++;
		// si c'est la 1er ligne on afficher l'entete du tableau
		if ($nombre == 1) 
		{
			$template->assign_block_vars('entete_match', array(
				'MATCH_PLACE' => $langue['user_match_place'],
			));
		} 
		$match['date'] = $match['date']+$session_cl['correction_heure'];
		$template->assign_block_vars('cadre_match', array( 
			'MATCH_DISPO' => sprintf($langue['info_match_place'], $match['le_clan'], adodb_date('j/n/Y', $match['date']), adodb_date('H:i', $match['date'])),
		));
	}
}
// on prend les entrainement
$sql = "SELECT * FROM ".$config['prefix']."entrainement ORDER BY `date` ASC LIMIT 1";
if (! ($get_entrainement = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
while ($entrainement = $rsql->s_array($get_entrainement)) 
{
	$entrainement['date'] = $entrainement['date']+$session_cl['correction_heure'];
	$template->assign_block_vars('entrainement', array( 
		'ENTRAI_PLACE' => $langue['user_entrainement_place'],
		'DATE' =>  adodb_date('j/n/Y', $entrainement['date']),
		'TXT_DATE' => $langue['date_entrai'],
		'HEURE' => adodb_date('H:i', $entrainement['date']),
		'TXT_HEURE' => $langue['heure_entrai'],
		'INFO' => bbcode($entrainement['info']),
		'TXT_INFO' => $langue['info_entrai'],
		'INFO_PV' => bbcode($entrainement['priver']),
		'TXT_INFO_PV' => $langue['info_prive_entrai']
	 ));
}
// partie admin du script
if ($session_cl['pouvoir_particulier'] == 'admin')
{
	if (!empty($_POST['toggle_get_version']))
	{
		$sql = "UPDATE `".$config['prefix']."config` SET `conf_valeur` = '".(($config['get_version'] == 1)? 0 : 1)."' WHERE `conf_nom` = 'get_version'";
		if (! ($get_nbr_match = $rsql->requete_sql($sql)) )
		{
			sql_error($sql , $rsql->error, __LINE__, __FILE__);
		}
		$config['get_version'] = ($config['get_version'] == 1)? 0 : 1;
	}
	$sql = "SELECT id FROM `".$config['prefix']."match` WHERE date > '".(time()-60*60*2) ."'";
	if (! ($get_nbr_match = $rsql->requete_sql($sql)) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	$sql = "SELECT id FROM `".$config['prefix']."match` WHERE date < '".(time()-60*60*2) ."'";
	if (! ($get_nbr_old_match = $rsql->requete_sql($sql)) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	$sql = "SELECT id FROM `".$config['prefix']."match_demande`";
	if (! ($get_nbr_demande_match = $rsql->requete_sql($sql)) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	$template->assign_block_vars('admin', array(
		'TITRE' => $langue['titre_entree_admin'],
		'INFO_ADMIN' => $langue['admin_divers_nfo'],
		'INFO_ADMIN_MEMBRE' => $langue['admin_user_nfo'],
		'NOMBRE_USER' => $config['nbr_membre'],
		'TXT_NOMBRE_USER' => $langue['admin_nombre_membre'],
		'NOMBRE_MATCH' => $rsql->nbr($get_nbr_match),
		'TXT_NOMBRE_OLD_MATCH' => $langue['admin_nombre_old_match'],
		'NOMBRE_OLD_MATCH' => $rsql->nbr($get_nbr_old_match),
		'TXT_NOMBRE_MATCH' => $langue['admin_nombre_match'],
		'NOMBRE_DEMANDE_MATCH' => $rsql->nbr($get_nbr_demande_match),
		'TXT_NOMBRE_DEMANDE_MATCH' => $langue['admin_nombre_demande_match'],
		'SEX_NOM' => $langue['nom/sex'],
		'SECTION' => $langue['section'],
		'EQUIPE' => $langue['equipe'],
		'POUVOIR' => $langue['pouvoirs'],
		'PROFIL' => $langue['profil'],
	));
	// on vérifie si il a une derniére version en ligne
	if ($config['get_version'] == 0)
	{
		$fp = @fsockopen('services.clanlite.org', 80, $errno, $errstr, 0.5);
		if ($fp)
		{
			$out  = "GET /com.php?get_version=oui HTTP/1.1\r\n";
			$out .= "Host: services.clanlite.org\r\n";
			$out .= 'Referer: '.$config['site_domain'].$config['site_path'].'('.$_SERVER['HTTP_HOST'].")\r\n";
			$out .= "User-Agent: Clanlite ".$config['version']."\r\n";
			$out .= "Connection: Close\r\n\r\n";
		
			fwrite($fp, $out);
			while (!feof($fp))
			{
				$tmp = rtrim(fgets($fp, 128));
				if(ereg('([0-9]{1,2}).([0-9]{4}).([0-9]{2}).([0-9]{2})', $tmp) || $tmp == 'problem')
				{
					$reponce = $tmp;
					break;
				}
			}
			fclose($fp);
			if (!empty($reponce) && $reponce != 'problem')
			{
				list($local['majeur'], $local['annee'], $local['mois'], $local['jours']) = explode('.', $config['version']);
				list($distant['majeur'], $distant['annee'], $distant['mois'], $distant['jours']) = explode('.', $reponce);

				$local_time = mktime(0, 0, 0, $local['mois'], $local['jours'], $local['annee']);
				$distant_time = mktime(0, 0, 0, $distant['mois'], $distant['jours'], $distant['annee']);
				if ( ($distant_time > $local_time  && $local['majeur'] <= $distant['majeur']) ||  $local['majeur'] < $distant['majeur'])
				{
					$template->assign_block_vars('admin.update', array(
						'ICI' => session_in_url('index.php'),
						'TITRE' => $langue['admin_news_cl_titre'],
						'TEXTE' => sprintf($langue['admin_news_cl_on'], $config['version'], $reponce),
						'TXT_TOGGLE' => $langue['admin_news_cl_toggle'],
					));
				}
			}
		}
	}	
	else
	{
		$template->assign_block_vars('admin.update', array(
			'ICI' => session_in_url('index.php'),
			'TITRE' => $langue['admin_news_cl_titre'],
			'TEXTE' => $langue['admin_news_cl_off'],
			'TXT_TOGGLE' => $langue['admin_news_cl_toggle'],
		));
	}
	// on regarde les membres sans equipe ou section
	$sql = "SELECT id,user,sex,equipe,section,pouvoir FROM ".$config['prefix']."user WHERE equipe = '' OR section = '' OR pouvoir = 'news'";
	if (! ($get_vide = $rsql->requete_sql($sql)) )
	{
		sql_error($sql , $rsql->error, __LINE__, __FILE__);
	}
	$nombre = 0;
	while ($liste_membre = $rsql->s_array($get_vide))
	{
		$nombre++;
		$template->assign_block_vars('admin.nul_part', array(
			'ICI' => session_in_url($root_path.'administration/editer-user.php'),
			'ID' => $liste_membre['id'],
			'NOM' => $liste_membre['user'],
			'SEX' => ( $liste_membre['sex'] == 'Femme') ? 'femme' : 'homme',
			'EQUIPE' => ( empty($liste_membre['equipe'])  &&  $liste_membre['equipe'] !== 0) ? $langue['user_verif'] : $langue['user_ok'],
			'SECTION' => ( empty($liste_membre['section']) &&  $liste_membre['section'] !== 0) ? $langue['user_verif'] : $langue['user_ok'],
			'PV' => ( $liste_membre['pouvoir'] == 'news' ) ? $langue['user_verif'] : $langue['user_ok'],
			'BT_EDITER' => $langue['editer'],
		));
	}
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>