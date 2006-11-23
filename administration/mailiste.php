<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 24;
$action_membre = 'where_admin_mailiste';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($_POST['Envoyer']))
{ 
	include_once($root_path.'service/wamailer/class.mailer.php');
	$mailer = new Mailer();
	$mailer->set_root($root_path.'service/wamailer/');
	if ($config['send_mail'] == 'smtp')
	{
		$mailer->use_smtp($config['smtp_ip'], $config['smtp_port']);
		$mailer->smtp_pass = $config['smtp_code'];
		$mailer->smtp_user = $config['smtp_login'];
	}
	$mailer->set_from($config['master_mail']);
	$mailer->set_reply_to($config['master_mail']);
	$mailer->set_subject(pure_var($_POST['subject'], 'no'));
	$mailer->set_message(pure_var($_POST['corps'], 'no'));
	$where = ($_POST['section'] == 0)? '' : "WHERE section='".$_POST['section']."' ";
	$sql = "SELECT mail,user FROM ".$config['prefix']."user ".$where."ORDER BY id ASC";
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
	redirec_text("mailiste.php", $langue['redirection_admin_mailiste_add'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_mailiste.tpl'));
$template->assign_vars( array(
	'TITRE' => $langue['titre_admin_mailiste'],
	'ACTION' => $langue['action'],
	'TXT_SUBJECT' => $langue['mailiste_subject'],
	'TXT_CORPS' => $langue['mailiste_corps'],
	'ENVOYER' => $langue['envoyer'],
	'TXT_FOR' => $langue['quelle_section'],
	'ALL_SECTION' => $langue['toutes_section'],
));
$sql = "SELECT * FROM ".$config['prefix']."section";
if (! ($get_section_liste = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ( ($liste_section = $rsql->s_array($get_section_liste)) )
{
	$template->assign_block_vars('section', array( 
		'ID' => $liste_section['id'],
		'NOM' => $liste_section['nom']
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>