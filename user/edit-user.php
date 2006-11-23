<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$action_membre= 'where_edit_user';
$root_path = "./../";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['Submit']))
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
			$sql = "SELECT mail FROM ".$config['prefix']."user WHERE mail='".$HTTP_POST_VARS['mail']."' AND id != '".$session_cl['id']."'";
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
	if(empty($HTTP_POST_VARS['arme']) && $HTTP_POST_VARS['arme'] == "0.gif")
	{
		$forum_error .= $langue['erreur_arme_vide'];
	}
	if(empty($HTTP_POST_VARS['perso']) && $HTTP_POST_VARS['perso'] == "0.gif")
	{
		$forum_error .= $langue['erreur_perso_image_vide'];
	}
	if(empty($HTTP_POST_VARS['langue_form']))
	{
		$forum_error .= $langue['erreur_langue_vide'];
	}
	if (!empty($HTTP_POST_VARS['psw']) && !empty($HTTP_POST_VARS['psw2']))
	{
		if ($HTTP_POST_VARS['psw'] != $HTTP_POST_VARS['psw2'])
		{
			$forum_error .= $langue['erreur_code_différent'];
		}
		else
		{
			$code="psw='".md5($HTTP_POST_VARS['psw'])."', ";
			$session_cl['psw'] = md5($HTTP_POST_VARS['psw']);
		}
	}
	else
	{
		$code = "";
	}
	if ( empty($forum_error) )
	{
		$session_cl['user'] = $HTTP_POST_VARS['user1'];
		$session_cl['sex'] = $HTTP_POST_VARS['sex'];
		$session_cl['mail'] = $HTTP_POST_VARS['mail'];
		$session_cl['langue_user'] = $HTTP_POST_VARS['langue_form'];
		save_session($session_cl);
		$age = mktime (0 , 0 , 0 , $HTTP_POST_VARS['age_m'] , $HTTP_POST_VARS['age_d'] , $HTTP_POST_VARS['age_y']);
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
			prénom='".$HTTP_POST_VARS['prenom']."', 
			armes_préférées='".$HTTP_POST_VARS['arme']."',
			images='".$HTTP_POST_VARS['perso']."', 
			histoire='".$HTTP_POST_VARS['histoire']."', 
			langue='".$HTTP_POST_VARS['langue_form']."', 
			images='".$HTTP_POST_VARS['perso']."' 
			WHERE id ='".$session_cl['id']."'"; 
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text('edit-user.php',"Votre profils a été mis à jours","admin");
	}
}
include($root_path."conf/frame_admin.php");
if ( !empty($forum_error) )
{
	msg('erreur', $forum_error);
}
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_edit_user.tpl'));

$sql = "SELECT user.* FROM ".$config['prefix']."user AS user WHERE user.id = '".$session_cl['id']."' LIMIT 1";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ( ($profil = $rsql->s_array($get)) )
{
	// on regarde le sex
	$template->assign_vars(array( 
		'TITRE' => $langue['titre_edit_user'],
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
		'DATE_FORMAT' => $langue['date_format'],
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
		'TXT_LANGUE' => $langue['form_langue'],
		'BT_ENVOYER' => $langue['envoyer'],
	));
	// scan le rep pour les images
	$dir = "../images/personnages";
	// Ouvre un dossier bien connu, et liste tous les fichiers
	if (is_dir($dir))
	{
		if ($dh = opendir($dir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if($file != '..' && $file !='.' && $file !='')
				{ 
					$perso = explode(".", $file);
					$template->assign_block_vars('images', array(
						'FICHIER' => $file,
						'SELECTED' => ( $profil['images'] == $file) ? 'selected="selected"' : '',
						'VALUE' => $perso[0],
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
						'SELECTED' => ($profil['langue'] == $file) ? 'selected="selected"' : '',
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
