<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = "./../";
$action_membre = 'where_inscription';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
// envois du formulaire dans la db
if (!empty($HTTP_POST_VARS['Submit']) && $inscription != 0)
{
	$forum_error = "";
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	//on vérifie le formulaire point par point
	if(empty($HTTP_POST_VARS['nom']))
	{
		$forum_error .= $langue['erreur_nom_vide'];
	}
	if(empty($HTTP_POST_VARS['user1']))
	{
		$forum_error .= $langue['erreur_user_vide'];
	}
	else
	{
		$sql = "SELECT user FROM ".$config['prefix']."user WHERE user = '".$HTTP_POST_VARS['user1']."' AND id != '".$session_cl['id']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		if ( $rsql->s_array($get) )
		{
			$forum_error .= $langue['erreur_user_prit'];
		}
	}
	if(empty($HTTP_POST_VARS['sex']))
	{
		$forum_error .= $langue['erreur_sex_vide'];
	}
	if(empty($HTTP_POST_VARS['age_y']) || empty($HTTP_POST_VARS['age_m']) || empty($HTTP_POST_VARS['age_d']))
	{
		$forum_error .= $langue['erreur_naissance_vide'];
	}
	if(empty($HTTP_POST_VARS['arme']) && $HTTP_POST_VARS['arme'] == "0.gif")
	{
		$forum_error .= $langue['erreur_arme_vide'];
	}
	if(empty($HTTP_POST_VARS['perso']) && $HTTP_POST_VARS['perso'] == "0.gif")
	{
		$forum_error .= $langue['erreur_perso_image_vide'];
	}
	if(empty($HTTP_POST_VARS['mail']))
	{
		$forum_error .= $langue['erreur_mail_vide'];
	}
	else
	{
		if (!eregi("(.+)@(.+).([a-z]{2,4})$", $HTTP_POST_VARS['mail']))
		{
			$forum_error .= $langue['erreur_mail_invalide'];
		}
		else
		{
			$sql = "SELECT mail FROM ".$config['prefix']."user WHERE mail='".$HTTP_POST_VARS['mail']."'";
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
	if(empty($HTTP_POST_VARS['icq']))
	{
		$forum_error .= $langue['erreur_msn_vide'];
	}
	else if (!eregi("(.+)@(.+).([a-z]{2,4})$", $HTTP_POST_VARS['icq']))
	{
		$forum_error .= $langue['erreur_msn_invalide'];
	}
	if(empty($HTTP_POST_VARS['prenom']))
	{
		$forum_error .= $langue['erreur_prenom_vide'];
	}
	if(empty($HTTP_POST_VARS['arme']))
	{
		$forum_error .= $langue['erreur_arme_vide'];
	}
	if(empty($HTTP_POST_VARS['perso']))
	{
		$forum_error .= $langue['erreur_perso_image_vide'];
	}
	if(empty($HTTP_POST_VARS['langue_form']))
	{
		$forum_error .= $langue['erreur_langue_vide'];
	}
	if(empty($HTTP_POST_VARS['psw']))
	{
		$forum_error .= $langue['erreur_psw_vide'];
	}
	else if ($HTTP_POST_VARS['psw'] != $HTTP_POST_VARS['psw2'])
	{
		$forum_error .= $langue['erreur_code_différent'];
	}
	// on regarde si il a une erreur dans la variable $forum_error et si non on continue
	if( empty($forum_error) )
	{
		// on formate l'heure en Mktime depuis 1970
		$age = mktime ( 0 , 0 , 0 , $HTTP_POST_VARS['age_m'] , $HTTP_POST_VARS['age_d'] , $HTTP_POST_VARS['age_y']);
		$sql = "INSERT INTO `".$config['prefix']."user` (`nom`, `user`, `mail`, `im`, `psw`, `pouvoir`, `sex`, `age`, `web`, `cri`, `last_connect`, `prénom`, `armes_préférées`, `equipe`, `histoire`, `roles`, `images`, `langue`) VALUES ('".$HTTP_POST_VARS['nom']."', '".$HTTP_POST_VARS['user1']."', '".$HTTP_POST_VARS['mail']."', '".$HTTP_POST_VARS['icq']."', '".md5($HTTP_POST_VARS['psw'])."', 'a valider', '".$HTTP_POST_VARS['sex']."', '".$age."', '".$HTTP_POST_VARS["web"]."', '".$HTTP_POST_VARS["texte"]."', '', '".$HTTP_POST_VARS['prenom']."', '".$HTTP_POST_VARS['arme']."', '', '".$HTTP_POST_VARS['histoire']."', '', '".$HTTP_POST_VARS['perso']."', '".$HTTP_POST_VARS['langue_form']."')"; 
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
	'NOM' => (!empty($HTTP_POST_VARS['nom']))? $HTTP_POST_VARS['nom'] : '',
	'TXT_NOM' => $langue['form_nom'],
	'PRENOM' => (!empty($HTTP_POST_VARS['prenom']))? $HTTP_POST_VARS['prenom'] : '',
	'TXT_PRENOM' => $langue['form_prenom'],
	'LOGIN' => (!empty($HTTP_POST_VARS['user1']))? $HTTP_POST_VARS['user1'] : '',
	'TXT_LOGIN' => $langue['form_login'], 
	'TXT_CODE' => $langue['form_psw'], 
	'TXT_RE_CODE' => $langue['form_re_psw'], 
	'CHECKED_SEX_HOMME' => (!empty($HTTP_POST_VARS['sex']) && $HTTP_POST_VARS['sex'] == "Homme")? "checked=\"checked\"" : '',
	'CHECKED_SEX_FEMME' => (!empty($HTTP_POST_VARS['sex']) && $HTTP_POST_VARS['sex'] == "Femme")? "checked=\"checked\"" : '',
	'TXT_HOMME' => $langue['sex_homme'],
	'TXT_FEMME' => $langue['sex_femme'],
	'TXT_SEX' => $langue['form_sex'],
	'AGE_D' => (!empty($HTTP_POST_VARS['age_d']))? $HTTP_POST_VARS['age_d'] : '',
	'AGE_M' => (!empty($HTTP_POST_VARS['age_m']))? $HTTP_POST_VARS['age_m'] : '',
	'AGE_Y' => (!empty($HTTP_POST_VARS['age_y']))? $HTTP_POST_VARS['age_y'] : '',
	'DATE_FORMAT' => $langue['date_format'],
	'TXT_NAISSANCE' => $langue['form_naissance'],
	'TXT_LANGUE' => $langue['form_langue'],
	'TEXTE' => (!empty($HTTP_POST_VARS['texte']))? $HTTP_POST_VARS['texte'] : '',
	'TXT_TEXTE' => $langue['form_slogan'],
	'WEB' => (!empty($HTTP_POST_VARS['web']))? $HTTP_POST_VARS['web'] : '',
	'TXT_WEB' => $langue['form_web'],
	'HISTOIRE' => (!empty($HTTP_POST_VARS['histoire']))? $HTTP_POST_VARS['histoire'] : '',
	'TXT_HISTOIRE' => $langue['form_histoire'],
	'MAIL' => (!empty($HTTP_POST_VARS['mail']))? $HTTP_POST_VARS['mail'] : '',
	'TXT_MAIL'  => $langue['form_mail'],
	'MSN' => (!empty($HTTP_POST_VARS['icq']))? $HTTP_POST_VARS['icq'] : '',
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
					'SELECTED' => ( !empty($HTTP_POST_VARS['perso']) && $HTTP_POST_VARS['perso'] == $file) ? 'selected="selected"' : '',
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
					'SELECTED' => ( !empty($HTTP_POST_VARS['langue']) && $HTTP_POST_VARS['langue'] == $file) ? 'selected="selected"' : '',
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
					'SELECTED' => ( !empty($HTTP_POST_VARS['arme']) && $HTTP_POST_VARS['arme'] == $file) ? 'selected="selected"' : '',
				));
			}
		}
		closedir($dh);
	}
}
$template->pparse('body');
include($root_path."conf/frame.php");
?>