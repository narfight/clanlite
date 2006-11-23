<?
$action_membre= 'where_admin_edit_user';
$niveau_secu = 8;
$root_path = "./../";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($_POST['Submit']))
{
	$code = (!empty($_POST['psw']))? "psw='".md5($_POST['psw'])."', " : "";
	$_POST = pure_var($_POST);
	$age = mktime ( 0 , 0 , 0 , $_POST['age_m'] , $_POST['age_d'] , $_POST['age_y']);
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
		prénom='".$_POST['prenom']."', 
		armes_préférées='".$_POST['arme']."',
		images='".$_POST['perso']."', 
		histoire='".$_POST['histoire']."', 
		roles='".$_POST['roles']."', 
		equipe='".$_POST['equipe']."', 
		grade='".$_POST['grade']."', 
		pouvoir='".$_POST['pv']."', 
		section='".$_POST['section']."', 
		images='".$_POST['perso']."',
		langue='".$_POST['langue_form']."' 
		WHERE id ='".$_POST['link']."'"; 
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text($root_path."service/liste-des-membres.php", $langue['user_envois_edit_profil'] , "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_edit_user.tpl'));
$sql = "SELECT user.*, section.nom, section.id, equipe.nom, equipe.id FROM ".$config['prefix']."user AS user LEFT JOIN ".$config['prefix']."section AS section ON section.id = user.section LEFT JOIN ".$config['prefix']."équipe as equipe ON equipe.id = user.equipe WHERE user.id = '".$_POST['link']."' LIMIT 1";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ( ($profil = $rsql->s_array($get)) )
{
	$template->assign_vars(array( 
		'TITRE' => $langue['titre_edit_user'],
		'LINK' => $_POST['link'],
		'ID' => $profil['0'],
		'TXT_LANGUE' => $langue['form_langue'],
		'TXT_CHOISIR' => $langue['choisir'],
		'NOM' => $profil[1],
		'TXT_NOM' => $langue['form_nom'],
		'PRENOM' => $profil['prénom'],
		'TXT_PRENOM' => $langue['form_prenom'],
		'LOGIN' => $profil['user'], 
		'TXT_LOGIN' => $langue['form_login'], 
		'TXT_CODE' => $langue['form_psw'], 
		'TXT_RE_CODE' => $langue['form_re_psw'], 
		'MAIL'  => $profil['mail'],
		'TXT_MAIL'  => $langue['form_mail'],
		'MSN' => $profil['im'],
		'TXT_MSN' => $langue['form_msn'],
		'HOMME' => ( $profil['sex'] == "Homme" ) ? "checked=\"checked\"" : "",
		'FEMME' => ( $profil['sex'] == "Femme" ) ? "checked=\"checked\"" : "",
		'TXT_HOMME' => $langue['sex_homme'],
		'TXT_FEMME' => $langue['sex_femme'],
		'TXT_SEX' => $langue['form_sex'],
		'AGE_D' => date("j", $profil['age']),
		'AGE_M' => date("n", $profil['age']),
		'AGE_Y' => date("Y", $profil['age']),
		'TXT_NAISSANCE' => $langue['form_naissance'],
		'WEB' => $profil['web'],
		'TXT_WEB' => $langue['form_web'],
		'TEXTE' => $profil['cri'],
		'TXT_TEXTE' => $langue['form_slogan'],
		'ARME' => $profil['armes_préférées'],
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
		'TITRE' => $langue['titre_admin_edit_user'],
		'TXT_POUVOIR' => $langue['pouvoirs'],
		'TXT_EQUIPE' => $langue['equipe'],
		'TXT_SECTION' => $langue['section'],
		'TXT_ROLE' => $langue['role'],
		'DESACTIVE_SELECT' => ($profil['pouvoir'] == "news")? 'selected="selected"' : '',
		'TXT_DESACTIVE' => $langue['desactive'],
		'USER_SELECT' => ($profil['pouvoir'] == "user")? 'selected="selected"' : '',
		'TXT_USER' => $langue['user'],
		'ADMIN_SELECT' => ($profil['pouvoir'] == "admin")? 'selected="selected"' : '',
		'TXT_ADMIN' => $langue['admin'],
		'ROLE' => $profil['roles'],
		'TXT_GRADE' => $langue['grade'],
		'GRADE' => $profil['grade'],
	)); 
	// on fais la liste des équipe
	$sql = "SELECT * FROM ".$config['prefix']."équipe";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ( $liste_équipe = $rsql->s_array($get) )
	{
		$template->assign_block_vars('admin.equipe', array( 
			'SELECTED' => ($profil['equipe'] == $liste_équipe['id'])? 'selected="selected"' : '',
			'ID' => $liste_équipe['id'],
			'NOM' => $liste_équipe['nom']
		));
	}
	// on fais la liste des grades
	$sql = "SELECT * FROM ".$config['prefix']."grades ORDER BY ordre DESC";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ( $liste_grades = $rsql->s_array($get) )
	{
		$template->assign_block_vars('admin.grades', array( 
			'SELECTED' => ($profil['grade'] == $liste_grades['id'])? 'selected="selected"' : '',
			'ID' => $liste_grades['id'],
			'NOM' => $liste_grades['nom']
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
	$dir = "../images/personnages";
	// Ouvre un dossier bien connu, et liste tous les fichiers
	if (is_dir($dir))
	{
		if ($dh = opendir($dir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if($file != '..' && $file !='.' && $file !='' && $file != "0.jpeg")
				{ 
					$perso = explode('.', $file);;
					$template->assign_block_vars('images', array(
						'FICHIER' => $file,
						'SELECTED' => ($profil['images'] == $file) ? 'selected="selected"' : '',
						'VALUE' => $perso[0],
					));
				}
			}
			closedir($dh);
		}
	}
	// scan le rep pour les langues
	$dir = "../langues/";
	// Ouvre un dossier bien connu, et liste tous les fichiers
	if (is_dir($dir))
	{
		if ($dh = opendir($dir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if($file != '..' && $file !='.' && $file !='')
				{ 
					$template->assign_block_vars('langue', array(
						'NAME' => $file,
						'VALUE' => $file,
						'SELECTED' => ( $profil['langue'] == $file) ? 'selected="selected"' : '',
					));
				}
			}
			closedir($dh);
		}
	}
	// scan le rep pour les images des armes
	$dir = "../images/armes";
	// Ouvre un dossier bien connu, et liste tous les fichiers
	if (is_dir($dir))
	{
		if ($dh = opendir($dir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if($file != '..' && $file !='.' && $file !='' && $file != "0.gif")
				{ 
					$armes = explode(".", $file);
					$template->assign_block_vars('armes', array(
						'NOM' => $armes[0],
						'VALUE' => $file,
						'SELECTED' => ( $profil['armes_préférées'] == $file) ? 'selected="selected"' : '',
					));
				}
			}
			closedir($dh);
		}
	}
}
else
{
	msg('erreur', $langue['erreur_profil_no_found']);
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>