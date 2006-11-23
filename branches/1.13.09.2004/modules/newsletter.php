<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$nom = "Newsletter";
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$sql = "CREATE TABLE `".$config['prefix']."module_newsletter_".mysql_insert_id()."` (`id` mediumint(8) unsigned NOT NULL auto_increment, `mail` varchar(255) NOT NULL default '', PRIMARY KEY  (`id`))";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		$sql = "DROP TABLE `".$config['prefix']."module_newsletter_".$_POST['for']."` ";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	$tpl_filename = $template->make_filename('modules/officiel_module.tpl');
	
	$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));
	
	// replace \ with \\ and then ' with \'.
	$tpl = str_replace('\\', '\\\\', $tpl);
	$tpl = str_replace('\'', '\\\'', $tpl);
	
	// strip newlines.
	$tpl  = str_replace("\n", '', $tpl);
	
	// vérifie si le site du constructeur est en ligne
	$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
	eval($tpl);
		
	$block['newsletter'] = str_replace('{ROOT_PATH}', $root_path, $block['newsletter']);
	$block['newsletter'] = str_replace('{MAIL}', $langue['form_mail'], $block['newsletter']);
	$block['newsletter'] = str_replace('{ID}', $modules['id'], $block['newsletter']);
	$block['newsletter'] = str_replace('{ENVOYER}', $langue['envoyer'], $block['newsletter']);
	$block['newsletter'] = str_replace('{DELL}', $langue['newsletter_deinscription'], $block['newsletter']);
	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => $block['newsletter']
	));
	return;
}
if(!empty($_POST['Submit_newsletter']) && !empty($_POST['id']))
{
	unset($_POST['Submit_newsletter']);
	$root_path = './../';
	$action_membre= 'where_newsletter';
	include($root_path.'conf/template.php');
	include($root_path.'conf/conf-php.php');
	include($root_path.'conf/frame.php');
	$_POST = pure_var($_POST);
	if (!empty($_POST['mail_ns']) && eregi("(.+)@(.+).([a-z]{2,4})$", $_POST['mail_ns']))
	{
		if (empty($_POST['action']))
		{
			$sql = "SELECT COUNT(id) FROM `".$config['prefix']."module_newsletter_".$_POST['id']."` WHERE mail ='".$_POST['mail_ns']."'";
			if (! ($get = $rsql->requete_sql($sql)) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			$verif_present = $rsql->s_array($get);
			if ($verif_present['COUNT(id)'] == "0")
			{
				$sql = "INSERT INTO `".$config['prefix']."module_newsletter_".$_POST['id']."` (mail) VALUES ('".$_POST['mail_ns']."')";
				if (! ($get = $rsql->requete_sql($sql)) )
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
				$txt = $langue['newsletter_send_ok'];
			}
			else
			{
				$txt = $langue['newsletter_doublon'];
			}
		}
		else
		{
			$sql = "DELETE FROM `".$config['prefix']."module_newsletter_".$_POST['id']."` WHERE mail ='".$_POST['mail_ns']."'";
			if (! ($get = $rsql->requete_sql($sql)) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			$txt = $langue['newsletter_deinscription_ok'];
		}
	}
	else
	{
		$txt = $langue['erreur_mail_invalide'];
	}
	$template->set_filenames(array('body_module' => 'divers_text.tpl'));
	$template->assign_vars(array(
		'TEXTE' => $txt,
		'TITRE' => $langue['titre_newsletter']
	));
	$template->pparse('body_module');
	include($root_path.'conf/frame.php');
	return;
}
?>