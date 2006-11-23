<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_reaction';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
if ( !empty($HTTP_GET_VARS['action']) && ( $user_pouvoir[23] == "oui" || $user_pouvoir['particulier'] == "admin" ) )
{
	$sql = "DELETE FROM `".$config['prefix']."reaction_news` WHERE id ='".$HTTP_GET_VARS['for']."'";
	if (! ($list_news = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("reaction.php?for=".$HTTP_GET_VARS['view'], "La réaction a été suprimée" , "user");
}
if ( !empty($HTTP_POST_VARS['send']) )
{ 
	// on vérifie que les champ sont pas vide
	$forum_error = "";
	if(empty($HTTP_POST_VARS['nom_p']))
	{
		$forum_error .= $langue['erreur_nom_vide'];
	}
	if(empty($HTTP_POST_VARS['reaction']))
	{
		$forum_error .= $langue['erreur_reaction_vide'];
	}
	if (!empty($HTTP_POST_VARS['email_p']))
	{
		if (!eregi("(.+)@(.+).([a-z]{2,4})$", $HTTP_POST_VARS['email_p']))
		{
			$forum_error .= $langue['erreur_mail_invalide'];
		}
	}
	// on vérifie qu'il na pas prit un nom des membres si il n'est pas un
	$sql = "SELECT user, psw FROM ".$config['prefix']."user WHERE user = '".$HTTP_POST_VARS['nom_p']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	if ( $membre = $rsql->s_array($get) ) 
	{
		// le nom est dans la db, on vérifie alors le code
		if ( md5($HTTP_POST_VARS['code_p']) != $membre['psw'] )
		{
			$forum_error .= $langue['erreur_no_membre'];
		}
	}
	//on vérifie que tout est en ordre pour envoyer le message
	if (empty($forum_error))
	{
		$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
		// oki ici c'est quand tout est bien rempli
		$sql = "INSERT INTO `".$config['prefix']."reaction_news` (id_news, nom, email, date, texte) VALUES ('".$HTTP_POST_VARS['for']."', '".$HTTP_POST_VARS['nom_p']."', '".$HTTP_POST_VARS['email_p']."', '".$config['current_time']."', '".$HTTP_POST_VARS['reaction']."')";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'service/index_pri.php',"Votre réaction est postée","user");
	}
} 
include($root_path."conf/frame.php");
if (!empty($forum_error))
{
	msg('erreur', $forum_error);
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS, 'moin');
}
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'reactions.tpl'));
$for = (empty($HTTP_GET_VARS['for']))? $HTTP_POST_VARS['for'] : $HTTP_GET_VARS['for'];
$sql = "SELECT user.id, reaction.*, user.user FROM `".$config['prefix']."reaction_news` AS reaction LEFT JOIN ".$config['prefix']."user AS user ON reaction.nom = user.user WHERE id_news ='".$for."' ORDER BY reaction.id ASC";
if (! ($list_reaction = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ($user_pouvoir['particulier'] == "admin")
{
	$template->assign_block_vars('admin', 'vide');
}
while ($reaction = $rsql->s_array($list_reaction)) 
{ 
	$template->assign_block_vars('reactions', array( 
		'DATE' => date("j-n-y H:i", $reaction['date']),
		'REACTION' => nl2br(bbcode($reaction['texte'])),
		'BY' => $reaction['nom'],
		'BY_URL' => (!empty($reaction['user']))? 'profil.php?link='.$reaction[0]: 'mailto:'.$reaction['email'],
		'FOR' => $for, 
		'ID' => $reaction['id'],
	));
	if ($user_pouvoir['particulier'] == "admin")
	{
		$template->assign_block_vars('reactions.admin', 'vide');
	}
}
$template->assign_vars( array( 
	'DELL_REACTION' => $langue['dell_reaction'],
	'TITRE_REACTION' => $langue['titre_reaction'],
	'ADD_COMMENTAIRE' => $langue['add_commentaire'],
	'FORM_LOGIN' => $langue['form_login'],
	'FORM_PSW' => $langue['form_psw'],
	'FORM_MAIL' => $langue['form_mail'],
	'FORM_MESSAGE' => $langue['form_message'],
	'FORM_ENVOYER' => $langue['envoyer'],
	'REACTION' => (!empty($HTTP_POST_VARS['reaction']))? $HTTP_POST_VARS['reaction'] : '',
   	'USER' => (!empty($session_cl['user']))? $session_cl['user'] : "",
	'FOR' => (empty($HTTP_POST_VARS['for']))? $HTTP_GET_VARS['for'] : $HTTP_POST_VARS['for'],
	'TAG' => $config['tag'],
	'ID' => $reaction['id'],
	'MAIL' => (!empty($session_cl['mail']))? $session_cl['mail'] : "",
));
$template->pparse('body');
include($root_path."conf/frame.php");
?>