<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = "./../";
$action_membre = 'where_inscription';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
// envois du formulaire dans la db
if (!empty($_POST['Submit']) && $inscription != 0)
{
	$forum_error = "";
	$_POST = pure_var($_POST);
	//on vérifie le formulaire point par point
	if(empty($_POST['nom']))
	{
		$forum_error .= $langue['erreur_nom_vide'];
	}
	if(empty($_POST['user1']))
	{
		$forum_error .= $langue['erreur_user_vide'];
	}
	else
	{
		$sql = "SELECT user FROM ".$config['prefix']."user WHERE user = '".$_POST['user1']."' AND id != '".$session_cl['id']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		if ( $rsql->s_array($get) )
		{
			$forum_error .= $langue['erreur_user_prit'];
		}
	}
	if(empty($_POST['sex']))
	{
		$forum_error .= $langue['erreur_sex_vide'];
	}
	if(empty($_POST['age_y']) || empty($_POST['age_m']) || empty($_POST['age_d']))
	{
		$forum_error .= $langue['erreur_naissance_vide'];
	}
	if(empty($_POST['arme']) && $_POST['arme'] == "0.gif")
	{
		$forum_error .= $langue['erreur_arme_vide'];
	}
	if(empty($_POST['perso']) && $_POST['perso'] == "0.gif")
	{
		$forum_error .= $langue['erreur_perso_image_vide'];
	}
	if(empty($_POST['mail']))
	{
		$forum_error .= $langue['erreur_mail_vide'];
	}
	else
	{
		if (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['mail']))
		{
			$forum_error .= $langue['erreur_mail_invalide'];
		}
		else
		{
			$sql = "SELECT mail FROM ".$config['prefix']."user WHERE mail='".$_POST['mail']."'";
			if (! $get = $rsql->requete_sql($sql) )
			{
				sql_error($sql ,mysql_error(), __LINE__, __FILE__);
			}
			if ( $rsql->s_array($get) )
			{
				$forum_error .= $langue['erreur_mail_prit'];
			}
		}
	}
	if(empty($_POST['icq']))
	{
		$forum_error .= $langue['erreur_msn_vide'];
	}
	else if (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['icq']))
	{
		$forum_error .= $langue['erreur_msn_invalide'];
	}
	if(empty($_POST['prenom']))
	{
		$forum_error .= $langue['erreur_prenom_vide'];
	}
	if(empty($_POST['arme']))
	{
		$forum_error .= $langue['erreur_arme_vide'];
	}
	if(empty($_POST['perso']))
	{
		$forum_error .= $langue['erreur_perso_image_vide'];
	}
	if(empty($_POST['langue_form']))
	{
		$forum_error .= $langue['erreur_langue_vide'];
	}
	if(empty($_POST['psw']))
	{
		$forum_error .= $langue['erreur_psw_vide'];
	}
	else if ($_POST['psw'] != $_POST['psw2'])
	{
		$forum_error .= $langue['erreur_code_différent'];
	}
	// on regarde si il a une erreur dans la variable $forum_error et si non on continue
	if( empty($forum_error) )
	{
		// on formate l'heure en Mktime depuis 1970
		$age = mktime ( 0 , 0 , 0 , $_POST['age_m'] , $_POST['age_d'] , $_POST['age_y']);
		$sql = "INSERT INTO `".$config['prefix']."user` (`nom`, `user`, `mail`, `im`, `psw`, `pouvoir`, `sex`, `age`, `web`, `cri`, `last_connect`, `prénom`, `armes_préférées`, `equipe`, `histoire`, `roles`, `images`, `langue`) VALUES ('".$_POST['nom']."', '".$_POST['user1']."', '".$_POST['mail']."', '".$_POST['icq']."', '".md5($_POST['psw'])."', 'news', '".$_POST['sex']."', '".$age."', '".((!empty($_POST["web"]) && eregi('http(s)?://',$_POST["web"]))? $_POST["web"] : 'http://'.$_POST["web"])."', '".$_POST["texte"]."', '', '".$_POST['prenom']."', '".$_POST['arme']."', '', '".$_POST['histoire']."', '', '".$_POST['perso']."', '".$_POST['langue_form']."')"; 
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		$config['nbr_membre']++;
		$sql = "UPDATE ".$config['prefix']."config SET conf_valeur='".$config['nbr_membre']."' WHERE conf_nom='nbr_membre'";
		if (! $rsql->requete_sql($sql) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		redirec_text("msgnew.php", $langue['user_envois_inscription'], "user");
	}
}
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'user_news.tpl'));
liste_smilies(true, '', 25);
if (!empty($forum_error) )
{
	msg('erreur' ,$forum_error);
}

if ($inscription == 0)
{
 	$block_insc = 'disabled="disabled"';
 	msg('info' ,$langue['inscription_fermée']);
	$template->assign_vars(array('BLOCK' => $block_insc));
} 
else
{
	$block_insc = "";
}
$template->assign_vars(array(
	'TITRE' => $langue['titre_inscription'],
	'TXT_CHOISIR' => $langue['choisir'],
	'NOM' => (!empty($_POST['nom']))? $_POST['nom'] : '',
	'TXT_NOM' => $langue['form_nom'],
	'PRENOM' => (!empty($_POST['prenom']))? $_POST['prenom'] : '',
	'TXT_PRENOM' => $langue['form_prenom'],
	'LOGIN' => (!empty($_POST['user1']))? $_POST['user1'] : '',
	'TXT_LOGIN' => $langue['form_login'], 
	'TXT_CODE' => $langue['form_psw'], 
	'TXT_RE_CODE' => $langue['form_re_psw'], 
	'CHECKED_SEX_HOMME' => (!empty($_POST['sex']) && $_POST['sex'] == "Homme")? "checked=\"checked\"" : '',
	'CHECKED_SEX_FEMME' => (!empty($_POST['sex']) && $_POST['sex'] == "Femme")? "checked=\"checked\"" : '',
	'TXT_HOMME' => $langue['sex_homme'],
	'TXT_FEMME' => $langue['sex_femme'],
	'TXT_SEX' => $langue['form_sex'],
	'AGE_D' => (!empty($_POST['age_d']))? $_POST['age_d'] : '',
	'AGE_M' => (!empty($_POST['age_m']))? $_POST['age_m'] : '',
	'AGE_Y' => (!empty($_POST['age_y']))? $_POST['age_y'] : '',
	'DATE_FORMAT' => $langue['date_format'],
	'TXT_NAISSANCE' => $langue['form_naissance'],
	'TXT_LANGUE' => $langue['form_langue'],
	'TEXTE' => (!empty($_POST['texte']))? $_POST['texte'] : '',
	'TXT_TEXTE' => $langue['form_slogan'],
	'WEB' => (!empty($_POST['web']))? $_POST['web'] : '',
	'TXT_WEB' => $langue['form_web'],
	'HISTOIRE' => (!empty($_POST['histoire']))? $_POST['histoire'] : '',
	'TXT_HISTOIRE' => $langue['form_histoire'],
	'MAIL' => (!empty($_POST['mail']))? $_POST['mail'] : '',
	'TXT_MAIL'  => $langue['form_mail'],
	'MSN' => (!empty($_POST['icq']))? $_POST['icq'] : '',
	'TXT_ARME' => $langue['form_fv_arme'],
	'ALT_ARME' => $langue['alt_arme'],
	'TXT_MSN' => $langue['form_msn'],
	'TXT_IMAGE' => $langue['form_image'],
	'ALT_IMAGE' => $langue['alt_image_profil'],
	'BT_ENVOYER' => $langue['envoyer'],
));
// scan le rep pour les images
// Ouvre un dossier bien connu, et liste tous les fichiers
$dir = "../images/personnages";
if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if($file != '..' && $file !='.' && $file !='' && $file != "0.jpeg")
			{ 
				$perso = explode(".", $file);
				$template->assign_block_vars('images', array(
					'FICHIER' => $file,
					'VALUE' => $perso[0],
					'SELECTED' => ( !empty($_POST['perso']) && $_POST['perso'] == $file) ? 'selected="selected"' : '',
				));
			}
		}
		closedir($dh);
	}
}
// scan le rep pour les langues
$dir = "../langues/";
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
					'SELECTED' => ( !empty($_POST['langue']) && $_POST['langue'] == $file) ? 'selected="selected"' : '',
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
					'VALEUR' => $file,
					'SELECTED' => ( !empty($_POST['arme']) && $_POST['arme'] == $file) ? 'selected="selected"' : '',
				));
			}
		}
		closedir($dh);
	}
}
$template->pparse('body');
include($root_path."conf/frame.php");
?>