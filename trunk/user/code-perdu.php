<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = "../";
$action_membre = 'where_lost_code';
include($root_path."conf/conf-php.php");
include($root_path."conf/template.php");
if (empty($HTTP_GET_VARS['activ_pw']) && empty($HTTP_POST_VARS['activ_pw']) && empty($HTTP_POST_VARS['mail']))
{// envois le formulaire pour retrouver son code
	include($root_path."conf/frame.php");
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('body' => 'code-perdu.tpl'));
	$template->assign_vars(array( 
		'TITRE' => $langue['titre_lost_code'],
		'MAIL' => $langue['form_mail'],
		'DEF_ACTIVATION' => $langue['def_code_activation'],
		'BT_ENVOYER' => $langue['envoyer'],
	));
	$template->pparse('body');
	include($root_path."conf/frame.php");
}
else
{
	if(!empty($HTTP_GET_VARS['activ_pw']) || !empty($HTTP_POST_VARS['activ_pw']))
	{// active le nouveau code
		$key_activ_code = (empty($HTTP_GET_VARS['activ_pw']))? $HTTP_POST_VARS['activ_pw'] : $HTTP_GET_VARS['activ_pw'];
		$sql = "SELECT tmp_code FROM ".$config['prefix']."user WHERE  key_activ_code='".$key_activ_code."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		if ( $info_lost = $rsql->s_array($get) )
		{//la key est bonne
			$sql = "UPDATE ".$config['prefix']."user SET tmp_code='', key_activ_code='', psw='".$info_lost['tmp_code']."' WHERE key_activ_code ='".$key_activ_code."'";
			if (! ($rsql->requete_sql($sql)) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			redirec_text($root_path.'admin.php', $langue['user_envois_newscodeok'] , 'user');
		}
		else
		{//il est pas bon
			redirec_text($root_path.'user/code-perdu.php', $langue['user_envois_newscodeerror'] , 'user');
		}
	}
	else
	{
		if (!eregi("(.+)@(.+).([a-z]{2,4})$", $HTTP_POST_VARS['mail']))
		{
			redirec_text($root_path.'user/code-perdu.php', $langue['user_envois_mailinvalide'], 'user');
		}
		else
		{
			// on prend les info du membres
			$sql = "SELECT mail, psw, nom, user, id FROM ".$config['prefix']."user WHERE mail='".$HTTP_POST_VARS['mail']."'";
			if (! ($get = $rsql->requete_sql($sql)) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			if ( !($info_lost = $rsql->s_array($get)) )
			{
				redirec_text($root_path.'user/code-perdu.php', $langue['user_envois_mailnofound'], 'user');
			}
			else
			{
				//génére le nouveau code
				$string="abcdefghijklmnopqrstuvwxyz1234567890"; 
				$news_code = "";
				for($i=0;$i<6;$i++)
				{
					$news_code.=$string[mt_rand()%strlen($string)];
				}
				$activation = "";
				for($i=0;$i<31;$i++)
				{
					$activation.=$string[mt_rand()%strlen($string)];
				}
				//on change sont code
				$sql = "UPDATE ".$config['prefix']."user SET tmp_code='".md5($news_code)."', key_activ_code='".$activation."' WHERE id ='".$info_lost['id']."'";
				if (! ($rsql->requete_sql($sql)) )
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
				// et on l'envois
				mail($HTTP_POST_VARS['mail'], sprintf($langue['titre_mail_codeperdu'], $config['nom_clan']), sprintf($langue['corps_mail_codeperdu'], $info_lost['nom'], $news_code, $info_lost['user'], $config['site_domain'].$config['site_path'], $activation));
				redirec_text($root_path.'user/code-perdu.php', $langue['user_envois_mailinvalideenvoye'], 'user');
			}
		}
	}
}
?>