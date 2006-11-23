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
$action_membre= 'where_profil';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$sql = "SELECT user.*,user.nom AS user_nom, equipe.nom AS equipe_nom, section.nom AS section_nom, grade.nom AS grade_nom FROM ".$config['prefix']."user AS user LEFT JOIN ".$config['prefix']."section AS section ON section.id = user.section LEFT JOIN ".$config['prefix']."equipe as equipe ON equipe.id = user.equipe LEFT JOIN ".$config['prefix']."grades as grade ON grade.id = user.grade WHERE user.id = '".$_GET['link']."'";
if (! ($get_p = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ( ($profil = $rsql->s_array($get_p)) )
{
	$template->set_filenames( array('body' => 'profile.tpl'));
	$template->assign_vars(array( 
		'TITRE_PROFIL' =>  sprintf($langue['titre_profil'], $profil['user']),
		'ID' => $profil['id'],
		'NOM' => $profil['user_nom'],
		'TXT_NOM' => $langue['nom'],
		'LOGIN' => $profil['user'],
		'TXT_LOGIN' => $langue['login'], 
		'MAIL' => $profil['mail'],
		'TXT_MAIL' => $langue['e-mail'],
		'MSN' => $profil['im'],
		'TXT_MSN' => $langue['msn'],
		'POUVOIR' => $profil['pouvoir'],
		'TXT_POUVOIR' => $langue['pouvoirs'],
		'SEX' => $profil['sex'],
		'TXT_SEX' => $langue['sex'],
		'AGE' => floor((time()-$profil['age'])/31557600),
		'TXT_AGE' => $langue['age'],
		'WEB' => $profil['web'],
		'TXT_WEB' => $langue['site_web'],
		'TEXT' => $profil['cri'],
		'TXT_TEXT' => $langue['cri_guerre'],
		'LASTCONNECT' => adodb_date('j/n/Y', $profil['last_connect']+$session_cl['correction_heure']),
		'TXT_LASTCONNECT' => $langue['last_connection'],
		'PRENOM' => $profil['prenom'],
		'TXT_PRENOM' => $langue['prenom'],
		'ARME' => $profil['armes_preferees'],
		'TXT_ARME' => $langue['favori_arme'],
		'ALT_ARME' => $langue['alt_arme'],
		'HISTOIRE' => bbcode($profil['histoire']),
		'TXT_HISTOIRE' => $langue['histoire'],
		'ROLES' => $profil['roles'],
		'TXT_ROLES' => $langue['roles'],
		'TXT_IMAGE' => $langue['avatar'],
		'IMAGES' => $profil['images'],
		'ALT_IMAGE_PERSO' =>$langue['alt_profil_image'],
		'SECTION' => $profil['section_nom'],
		'TXT_SECTION' => $langue['section'],
		'EQUIPE' => $profil['equipe_nom'],
		'TXT_EQUIPE' => $langue['equipe'],
		'ALT_MEDAILLES' => $langue['alt_medaille'],
		'TXT_DATE' => $langue['user_date'],
		'DATE_ENTREE' => adodb_date('j/m/Y',$profil['user_date']+$session_cl['correction_heure']),
	));
	if ($config['show_grade'] == 1)
	{
		$template->assign_block_vars('grade', array(
			'GRADE' => $profil['grade_nom'],
			'TXT_GRADE' => $langue['grade'],
		));
	}
	// on fais l'entete du cadre
	// on affiche ou pas la medaille, si il a ou pas
	$medail=explode(',', $profil['medail']);
	$boucle = -1;
	$nombre_md = 0;
	while ($boucle <= 8)
	{
		$nombre_md++;
		$boucle++;
		if (!empty($medail[$boucle]))
		{
			$taille = getimagesize($root_path.'images/medailles/medaille'.$nombre_md.'.gif');
			$template->assign_block_vars('nombre_md_titre', array(
				'NOMBRE_MD' => $nombre_md,
				'TAILLE' => $taille[3],
			));
		}
	}
	$template->pparse('body');
}
else
{
	msg('erreur', $langue['erreur_profil_no_found']);
}
require($root_path.'conf/frame.php');
?>