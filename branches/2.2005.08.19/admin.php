<?php
/****************************************************************************
 *	Fichier		: admin.php													*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './';
$action_membre= 'where_login';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
if (!empty($session_cl['user']))
{
	redirection($root_path.'user/index.php');
}
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'accueil_admin.tpl'));
$template->assign_vars(array( 
	'TITRE' => $langue['titre_login'],
	'CODE' => $langue['form_psw'],
	'LOGIN' => $langue['form_login'],
	'SAVE' => $langue['save_code_login'],
	'LOST' => $langue['lost_psw'],
	'LOST_U' => session_in_url($root_path.'user/code-perdu.php'),
	'GOTO' => (empty($_GET['goto']))? '' : $_GET['goto'],
	'GOTO_U' => session_in_url($root_path.'controle/entrer.php'),
	'ENVOYER' => $langue['envoyer'],
));
if (!empty($_GET['erreur'])) 
{
	switch($_GET['erreur'])
	{
		case 'news':
			$template->assign_block_vars('erreur', array('TEXTE' => $langue['non_active']));
		break;
		case 'code_login':
			$template->assign_block_vars('erreur', array('TEXTE' => $langue['code_login_incorrect']));
		break;
		case 'secu':
			$template->assign_block_vars('erreur', array('TEXTE' => $langue['erreur_secu']));
		break;
	}
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>