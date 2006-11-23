<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_reaction';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
if ( !empty($_GET['action']) && ( $user_pouvoir[23] == "oui" || $user_pouvoir['particulier'] == "admin" ) )
{
	$sql = "DELETE FROM `".$config['prefix']."reaction_news` WHERE id ='".$_GET['for']."'";
	if (! ($list_news = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("reaction.php?for=".$_GET['view'], "La r�action a �t� suprim�e" , "user");
}
if ( !empty($_POST['send']) )
{ 
	// on v�rifie que les champ sont pas vide
	$forum_error = "";
	if(empty($_POST['nom_p']))
	{
		$forum_error .= $langue['erreur_nom_vide'];
	}
	if(empty($_POST['reaction']))
	{
		$forum_error .= $langue['erreur_reaction_vide'];
	}
	if (!empty($_POST['email_p']))
	{
		if (!eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['email_p']))
		{
			$forum_error .= $langue['erreur_mail_invalide'];
		}
	}
	// on v�rifie qu'il na pas prit un nom des membres si il n'est pas un
	$sql = "SELECT user, psw FROM ".$config['prefix']."user WHERE user = '".$_POST['nom_p']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	if ( $membre = $rsql->s_array($get) ) 
	{
		// le nom est dans la db, on v�rifie alors le code
		if ( md5($_POST['code_p']) != $membre['psw'] )
		{
			$forum_error .= $langue['erreur_no_membre'];
		}
	}
	//on v�rifie que tout est en ordre pour envoyer le message
	if (empty($forum_error))
	{
		$_POST = pure_var($_POST);
		// oki ici c'est quand tout est bien rempli
		$sql = "INSERT INTO `".$config['prefix']."reaction_news` (id_news, nom, email, date, texte) VALUES ('".$_POST['for']."', '".$_POST['nom_p']."', '".$_POST['email_p']."', '".$config['current_time']."', '".$_POST['reaction']."')";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'service/index_pri.php',"Votre r�action est post�e","user");
	}
} 
include($root_path."conf/frame.php");
if (!empty($forum_error))
{
	msg('erreur', $forum_error);
	$_POST = pure_var($_POST, 'moin');
}
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'reactions.tpl'));
liste_smilies(true, '', 25);
$for = (empty($_GET['for']))? $_POST['for'] : $_GET['for'];
$sql = "SELECT user.id, reaction.*, user.user FROM `".$config['prefix']."reaction_news` AS reaction LEFT JOIN ".$config['prefix']."user AS user ON reaction.nom = user.user WHERE id_news ='".$for."' ORDER BY reaction.id ASC";
if (! ($list_reaction = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
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
	'REACTION' => (!empty($_POST['reaction']))? $_POST['reaction'] : '',
   	'USER' => (!empty($session_cl['user']))? $session_cl['user'] : "",
	'FOR' => (empty($_POST['for']))? $_GET['for'] : $_POST['for'],
	'TAG' => $config['tag'],
	'ID' => $reaction['id'],
	'MAIL' => (!empty($session_cl['mail']))? $session_cl['mail'] : "",
));
$template->pparse('body');
include($root_path."conf/frame.php");
?>