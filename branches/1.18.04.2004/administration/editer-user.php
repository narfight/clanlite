<?
$action_membre= 'where_admin_edit_user';
$niveau_secu = 8;
$root_path = "./../";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['Submit']))
{
	$code = (!empty($HTTP_POST_VARS['psw']))? "psw='".md5($HTTP_POST_VARS['psw'])."', " : "";
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$age = mktime ( 0 , 0 , 0 , $HTTP_POST_VARS['age_m'] , $HTTP_POST_VARS['age_d'] , $HTTP_POST_VARS['age_y']);
	$sql = "UPDATE ".$config['prefix']."user SET 
		cri='".$HTTP_POST_VARS['texte']."', 
		im='".$HTTP_POST_VARS['icq']."', 
		nom='".$HTTP_POST_VARS['nom']."', 
		user='".$HTTP_POST_VARS['user1']."', 
		mail='".$HTTP_POST_VARS['mail']."',
		web='".$HTTP_POST_VARS['web']."',
		".$code."
		sex='".$HTTP_POST_VARS['sex']."', 
		age='".$age."', 
		pr�nom='".$HTTP_POST_VARS['prenom']."', 
		armes_pr�f�r�es='".$HTTP_POST_VARS['arme']."',
		images='".$HTTP_POST_VARS['perso']."', 
		histoire='".$HTTP_POST_VARS['histoire']."', 
		roles='".$HTTP_POST_VARS['roles']."', 
		equipe='".$HTTP_POST_VARS['equipe']."', 
		grade='".$HTTP_POST_VARS['grade']."', 
		pouvoir='".$HTTP_POST_VARS['pv']."', 
		section='".$HTTP_POST_VARS['section']."', 
		images='".$HTTP_POST_VARS['perso']."',
		langue='".$HTTP_POST_VARS['langue_form']."' 
		WHERE id ='".$HTTP_POST_VARS['link']."'"; 
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text($root_path."service/liste-des-membres.php", $langue['user_envois_edit_profil'] , "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_edit_user.tpl'));
$sql = "SELECT user.*, section.nom, section.id, equipe.nom, equipe.id FROM ".$config['prefix']."user AS user LEFT JOIN ".$config['prefix']."section AS section ON section.id = user.section LEFT JOIN ".$config['prefix']."�quipe as equipe ON equipe.id = user.equipe WHERE user.id = '".$HTTP_POST_VARS['link']."' LIMIT 1";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ( ($profil = $rsql->s_array($get)) )
{
	$template->assign_vars(array( 
		'TITRE' => $langue['titre_edit_user'],
		'LINK' => $HTTP_POST_VARS['link'],
		'ID' => $profil['0'],
		'TXT_LANGUE' => $langue['form_langue'],
		'TXT_CHOISIR' => $langue['choisir'],
		'NOM' => $profil[1],
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
	// on fais la liste des �quipe
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
						'SELECTED' => ( $profil['armes_pr�f�r�es'] == $file) ? 'selected="selected"' : '',
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