<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// ------------------------------------------------------------- 
$root_path = "./";
$action_membre= 'where_login';
include($root_path.'conf/template.php');
include($root_path."conf/conf-php.php");
if (!empty($session_cl['user']))
{
	redirection($root_path.'user/index.php');
}
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'accueil_admin.tpl'));
$template->assign_vars(array( 
	'TITRE' => $langue['titre_login'],
	'CODE' => $langue['form_psw'],
	'LOGIN' => $langue['form_login'],
	'SAVE' => $langue['save_code_login'],
	'LOST' => $langue['lost_psw'],
	'ENVOYER' => $langue['envoyer'],
));
if (empty($HTTP_GET_VARS['lost'])) 
{
	if (!empty($HTTP_GET_VARS['erreur_news'])) 
	{
		msg('info',$langue['non_active']);
	}
	if ( !empty($HTTP_GET_VARS['erreur']) && $HTTP_GET_VARS['erreur'] == 1 )
	{
		msg('info',$langue['code_login_incorrect']);
	}
}
$template->pparse('body');
include($root_path."conf/frame.php");
?>