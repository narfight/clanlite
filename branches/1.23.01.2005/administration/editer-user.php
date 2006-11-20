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
$action_membre= 'where_admin_edit_user';
$niveau_secu = 8;
$root_path = './../';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path."controle/cook.php");
if (!empty($_POST['Submit']))
{
	$code = (!empty($_POST['psw']))? "psw='".md5($_POST['psw'])."', " : '';
	$_POST = pure_var($_POST);
	$age = mk_time ( 0 , 0 , 0 , $_POST['age_m'] , $_POST['age_d'] , $_POST['age_y']);
	$sql = "UPDATE ".$config['prefix']."user SET 
		cri='".$_POST['texte']."', 
		im='".$_POST['icq']."', 
		nom='".$_POST['nom']."', 
		user='".$_POST['user1']."', 
		mail='".$_POST['mail']."',
		web='".$_POST['web']."',
		".$code."
		sex='".$_POST['sex']."', 
		age='".$age."', 
		pr�nom='".$_POST['prenom']."', 
		armes_pr�f�r�es='".$_POST['arme']."',
		images='".$_POST['perso']."', 
		histoire='".$_POST['histoire']."', 
		roles='".$_POST['roles']."', 
		equipe='".$_POST['equipe']."', 
		grade='".$_POST['grade']."', 
		pouvoir='".$_POST['pv']."', 
		section='".$_POST['section']."', 
		images='".$_POST['perso']."',
		langue='".$_POST['langue_form']."' 
		WHERE id ='".$_POST['id']."'"; 
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text($root_path.'service/liste-des-membres.php', $langue['user_envois_edit_profil'] , 'admin');
}
require($root_path.'conf/frame_admin.php');
$sql = "SELECT user.*, section.nom, section.id, equipe.nom, equipe.id, user.id AS id_user, user.nom AS nom_user FROM ".$config['prefix']."user AS user LEFT JOIN ".$config['prefix']."section AS section ON section.id = user.section LEFT JOIN ".$config['prefix']."�quipe as equipe ON equipe.id = user.equipe WHERE user.id = '".$_POST['id']."' LIMIT 1";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ( ($profil = $rsql->s_array($get)) )
{
	$template = new Template($root_path.'templates/'.$config['skin']);
	$template->set_filenames( array('body' => 'admin_edit_user.tpl'));
	$template->assign_vars(array( 
		'ICI' => session_in_url('editer-user.php'),
		'TITRE' => $langue['titre_edit_user'],
		'ID' => $profil['id_user'],
		'TXT_LANGUE' => $langue['form_langue'],
		'TXT_CHOISIR' => $langue['choisir'],
		'NOM' => $profil['nom_user'],
		'TXT_NOM' => $langue['form_nom'],
		'PRENOM' => $profil['pr�nom'],
		'TXT_PRENOM' => $langue['form_prenom'],
		'LOGIN' => $profil['user'], 
		'TXT_LOGIN' => $langue['form_login'], 
		'TXT_CODE' => $langue['form_psw'], 
		'TXT_RE_CODE' => $langue['form_re_psw'], 
		'MAIL'  => $profil['mail'],
		'TXT_MAIL'  => $langue['form_mail'],
		'MSN' => $profil['im'],
		'TXT_MSN' => $langue['form_msn'],
		'HOMME' => ( $profil['sex'] == 'Homme' ) ? 'checked="checked"' : '',
		'FEMME' => ( $profil['sex'] == 'Femme' ) ? 'checked="checked"' : '',
		'TXT_HOMME' => $langue['sex_homme'],
		'TXT_FEMME' => $langue['sex_femme'],
		'TXT_SEX' => $langue['form_sex'],
		'AGE_D' => date('j', $profil['age']),
		'AGE_M' => date('n', $profil['age']),
		'AGE_Y' => date('Y', $profil['age']),
		'TXT_NAISSANCE' => $langue['form_naissance'],
		'WEB' => $profil['web'],
		'TXT_WEB' => $langue['form_web'],
		'TEXTE' => $profil['cri'],
		'TXT_TEXTE' => $langue['form_slogan'],
		'ARME' => $profil['armes_pr�f�r�es'],
		'TXT_ARME' => $langue['form_fv_arme'],
		'ALT_ARME' => $langue['alt_arme'],
		'HISTOIRE' => $profil['histoire'],
		'TXT_HISTOIRE' => $langue['form_histoire'],
		'IMAGE' => $profil['images'],
		'TXT_IMAGE' => $langue['form_image'],
		'ALT_IMAGE' => $langue['alt_image_profil'],
		'BT_ENVOYER' => $langue['envoyer'],
	));
	$template->assign_block_vars('admin', array(
		'TITRE' => sprintf($langue['titre_admin_edit_user'], $profil['user']),
		'TXT_POUVOIR' => $langue['pouvoirs'],
		'TXT_EQUIPE' => $langue['equipe'],
		'TXT_SECTION' => $langue['section'],
		'TXT_ROLE' => $langue['role'],
		'DESACTIVE_SELECT' => ($profil['pouvoir'] == 'news')? 'selected="selected"' : '',
		'TXT_DESACTIVE' => $langue['desactive'],
		'USER_SELECT' => ($profil['pouvoir'] == 'user')? 'selected="selected"' : '',
		'TXT_USER' => $langue['user'],
		'ADMIN_SELECT' => ($profil['pouvoir'] == 'admin')? 'selected="selected"' : '',
		'TXT_ADMIN' => $langue['admin'],
		'ROLE' => $profil['roles'],
	)); 
	if ($config['show_grade'] == 1)
	{
		$template->assign_block_vars('admin.grade', array(
			'TXT_GRADE' => $langue['grade'],
		));
		// on fais la liste des grades
		$sql = "SELECT * FROM ".$config['prefix']."grades ORDER BY ordre DESC";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while ( $liste_grades = $rsql->s_array($get) )
		{
			$template->assign_block_vars('admin.grade.grade_liste', array( 
				'SELECTED' => ($profil['grade'] == $liste_grades['id'])? 'selected="selected"' : '',
				'ID' => $liste_grades['id'],
				'NOM' => $liste_grades['nom']
			));
		}
	}
	else
	{
		$template->assign_block_vars('admin.no_grade', array(
			'GRADE' => $profil['grade'],
		));
	}// on fais la liste des �quipe
	$sql = "SELECT * FROM ".$config['prefix']."�quipe";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ( $liste_�quipe = $rsql->s_array($get) )
	{
		$template->assign_block_vars('admin.equipe', array( 
			'SELECTED' => ($profil['equipe'] == $liste_�quipe['id'])? 'selected="selected"' : '',
			'ID' => $liste_�quipe['id'],
			'NOM' => $liste_�quipe['nom']
		));
	}
	// on fais la liste des sections
	$sql = "SELECT * FROM ".$config['prefix']."section";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ($liste_section = $rsql->s_array($get) )
	{
		$template->assign_block_vars('admin.section', array( 
			'SELECTED' => ($profil['section'] == $liste_section['id'])? 'selected="selected"' : '',
			'ID' => $liste_section['id'],
			'NOM' => $liste_section['nom']
		));
	}
	// scan le rep pour les images des personnages
	// Ouvre un dossier bien connu, et liste tous les fichiers
	foreach(scandir($root_path.'images/personnages') as $id => $file)
	{
		if (ereg('(.*).(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $file, $perso) && $file != '0.jpeg')
		{ 
			$template->assign_block_vars('images', array(
				'FICHIER' => $perso[0],
				'VALUE' => $perso[1],
				'SELECTED' => ($profil['images'] == $perso[0]) ? 'selected="selected"' : '',
			));
		}
	}
	// scan le rep pour les langues
	// Ouvre un dossier bien connu, et liste tous les fichiers
	foreach(scandir($root_path.'langues') as $id => $file)
	{
		if (file_exists($root_path.'langues/'.$file.'/langue.php'))
		{ 
			$template->assign_block_vars('langue', array(
				'NAME' => $file,
				'VALUE' => $file,
				'SELECTED' => ( $profil['langue'] == $file) ? 'selected="selected"' : '',
			));
		}
	}
	// scan le rep pour les images des armes
	$dir = '../images/armes';
	// Ouvre un dossier bien connu, et liste tous les fichiers
	foreach(scandir($root_path.'images/armes') as $id => $file)
	{
		if (ereg('(.*).(gif|jpg|jpeg|jfif|png|bmp|dib|tif|tiff)', $file, $perso) && $file != '0.jpeg')
		{ 
			$template->assign_block_vars('armes', array(
				'NOM' => $perso[1],
				'VALUE' => $perso[0],
				'SELECTED' => ($profil['armes_pr�f�r�es'] == $perso[0]) ? 'selected="selected"' : '',
			));
		}
	}
	$template->pparse('body');
}
else
{
	msg('erreur', $langue['erreur_profil_no_found']);
}
require($root_path.'conf/frame_admin.php');
?>