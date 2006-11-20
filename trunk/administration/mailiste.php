<?php
/****************************************************************************
 *	Fichier		: mailiste.php												*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$niveau_secu = 24;
$action_membre = 'where_admin_mailiste';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path."controle/cook.php");
$_POST = pure_var($_POST, 'no');
if (!empty($_POST['Envoyer']))
{ 
	require_once($root_path.'service/wamailer/class.mailer.php');
	$mailer = new Mailer();
	$mailer->set_root($root_path.'service/wamailer/');
	if ($config['send_mail'] == 'smtp')
	{
		$mailer->use_smtp($config['smtp_ip'], $config['smtp_port']);
		$mailer->smtp_pass = $config['smtp_code'];
		$mailer->smtp_user = $config['smtp_login'];
	}
	$mailer->set_from($session_cl['mail']);
	$mailer->set_reply_to($session_cl['mail']);
	$mailer->set_subject($_POST['subject']);
	$mailer->set_message($_POST['corps']);
	// par rapport au section
	if (!empty($_POST['liste_section']) && is_array($_POST['liste_section']))
	{
		$where = '';
		$i = 0;
		$total = count($_POST['liste_section']);
		foreach ($_POST['liste_section'] as $id => $etat)
		{
			$i++;
			$where .= 'section = '.$id.' ';
			$where .= ($i < $total)? 'AND ' : '';
		}
		$sql = "SELECT mail,user FROM ".$config['prefix']."user WHERE ".$where;
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		while ($liste = $rsql->s_array($get))
		{ 
			$mailer->set_address(array($liste['user'] => $liste['mail']));
			$mailer->send();
			$mailer->clear_address();
		}
	}
	// par rapport au newsletter
	if (!empty($_POST['liste_newsletter']) && is_array($_POST['liste_newsletter']))
	{
		foreach ($_POST['liste_newsletter'] as $id => $etat)
		{
			$sql = "SELECT mail FROM ".$config['prefix']."module_newsletter_".$id;
			if (! ($get = $rsql->requete_sql($sql)) )
			{
				sql_error($sql ,mysql_error(), __LINE__, __FILE__);
			}
			while ($liste = $rsql->s_array($get))
			{ 
				$mailer->set_address($liste['mail']);
				$mailer->send();
				$mailer->clear_address();
			}
		}
	}
	if (!empty($_GET['no_section']))
	{
		$sql = "SELECT mail,user FROM ".$config['prefix']."user WHERE section = 0";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql ,mysql_error(), __LINE__, __FILE__);
		}
		while ($liste = $rsql->s_array($get))
		{ 
			$mailer->set_address(array($liste['user'] => $liste['mail']));
			$mailer->send();
			$mailer->clear_address();
		}
	}
	redirec_text('mailiste.php', $langue['redirection_admin_mailiste_add'], 'admin');
}
require($root_path.'conf/frame_admin.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'admin_mailiste.tpl'));
$template->assign_vars( array(
	'ICI' => session_in_url('mailiste.php'),
	'TITRE' => $langue['titre_admin_mailiste'],
	'ACTION' => $langue['action'],
	'TXT_SUBJECT' => $langue['mailiste_subject'],
	'SUBJECT' => (!empty($_POST['subject']))? $_POST['subject'] : '',
	'TXT_CORPS' => $langue['mailiste_corps'],
	'CORPS' => (!empty($_POST['corps']))? $_POST['corps'] : '',
	'ENVOYER' => $langue['envoyer'],
	'TXT_FOR' => $langue['mailiste_qui'],
	'NO_SECTION' => $langue['mailiste_sans_section'],
	'APERCU' => $langue['apercu'],
	'NO_SECTION_SELECTED' => (!empty($_POST['no_section']))? 'checked="checked"' : ''
));
if (!empty($_POST['Apercu']))
{
	$template->assign_block_vars('apercu', array( 
		'TITRE' => $langue['apercu'],
		'SUBJECT' => (!empty($_POST['corps']))? $_POST['corps'] : '',
		'CORPS' => (!empty($_POST['corps']))? $_POST['corps'] : '',
	));

}
$sql = "SELECT * FROM ".$config['prefix']."section";
if (! ($get_section_liste = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_section = $rsql->s_array($get_section_liste)) )
{
	$template->assign_block_vars('liste_send', array( 
		'ID' => 'liste_section['.$liste_section['id'].']',
		'NOM' => $langue['quelle_section'].' "'.$liste_section['nom'].'"',
		'SELECTED' => (!empty($_POST['liste_section'][$liste_section['id']]))? 'checked="checked"' : ''
	));
}
$sql = "SELECT id,nom FROM ".$config['prefix']."modules WHERE call_page = 'newsletter.php'";
if (! ($get_ns_liste = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_ns = $rsql->s_array($get_ns_liste)) )
{
	$template->assign_block_vars('liste_send', array( 
		'ID' => 'liste_newsletter['.$liste_ns['id'].']',
		'NOM' => $langue['newsletter_mailiste_send'].' "'.$liste_ns['nom'].'"',
		'SELECTED' => (!empty($_POST['liste_newsletter'][$liste_ns['id']]))? 'checked="checked"' : ''
	));
}
$template->pparse('body');
require($root_path.'conf/frame_admin.php');
?>