<?php
/****************************************************************************
 *	Fichier		: 															*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
$root_path = './../';
$niveau_secu = -1;
$action_membre= 'where_pouvoir';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'controle/cook.php');
if (!empty($_POST['envois_edit']))
{
	$_POST = pure_var($_POST);
	$requette = '';
	for ($i = 1;$i < 24;$i++)
	{
		$requette .="p".$i."='".(($_POST['activation'.$i] != 'oui')? 'non' : 'oui')."', ";
	}
	$requette .="p".$i."='".$_POST['activation'.$i]."' ";
	$sql = "UPDATE `".$config['prefix']."pouvoir` SET ".$requette." WHERE user_id='".$_POST['id']."'";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text('../service/liste-des-membres.php', $langue['redirection_pouvoir_edit'],'admin');
	}
}
require($root_path.'conf/frame_admin.php');

//vérifie que l'id existe et qu'il n'est pas un admin
$sql = "SELECT pouvoir FROM ".$config['prefix']."user WHERE id ='".$_POST['id']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql , $rsql->error, __LINE__, __FILE__);
}
if ($info_user = $rsql->s_array($get))
{
	if ($info_user['pouvoir'] != 'admin')
	{
		$template = new Template($root_path.'templates/'.$session_cl['skin']);
		$template->set_filenames( array('body' => 'admin_pouvoir.tpl'));
		$sql = "SELECT user FROM ".$config['prefix']."user WHERE id='".$_POST['id']."'";
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		if ($user_nfo = $rsql->s_array($get))
		{
			$sql = "SELECT * FROM ".$config['prefix']."pouvoir WHERE user_id='".$_POST['id']."'";
			if (! ($get = $rsql->requete_sql($sql)) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
			$edit_pouvoir = $rsql->s_array($get);
			if ($rsql->nbr($get) == 0)
			{
				$sql = "INSERT INTO `".$config['prefix']."pouvoir` ( `user_id` , `p1` , `p2` , `p3` , `p4` , `p5` , `p6` , `p7` , `p8` , `p9` , `p10` , `p11` , `p12` , `p13` , `p14` , `p15` , `p16` , `p17` , `p18` , `p19` , `p20` , `p21` , `p22` , `p23`, `p24`, `p25` )	VALUES ('".$_POST['id']."', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non')";
				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
			for ($i = 1;$i < 25;$i++)
			{
				$template->assign_block_vars('liste', array( 
					'INFO_POUVOIR' => $langue['pv_num_'.$i],
					'NUM' => $i,
					'ACTIVATION_0' => ( $edit_pouvoir['p'.$i] != 'oui') ? 'checked="checked"' : '',
					'ACTIVATION_1' => ( $edit_pouvoir['p'.$i] == 'oui') ? 'checked="checked"' : '',
					'OUI' => $langue['oui'],
					'NON' => $langue['non'],
				));
			}
			$template->assign_vars( array(
				'ICI' => session_in_url('pouvoir.php'),
				'ID' => $_POST['id'],
				'TITRE' => sprintf($langue['titre_pouvoir'], $user_nfo['user']),
				'EDITER' => $langue['editer'],
				'POUVOIR' => $langue['pouvoirs'],
				'ACTION' => $langue['action']
			));
		}
		$template->pparse('body');
	}
	else
	{
		msg('erreur', $langue['erreur_admin_and_pouvoir']);
	}
}
else
{
	msg('erreur', $langue['erreur_profil_no_found']);
}
require($root_path.'conf/frame_admin.php');
?>