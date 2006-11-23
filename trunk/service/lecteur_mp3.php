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
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'lecteur_mp3.tpl'));
if (isset($_GET['lecture']) || isset($session_cl['id_mp3']))
{
	$sql = "SELECT `id`, `SRC`, `AUTOPLAY`, `LOOP` FROM `".$config['prefix']."config_sond`";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	while ($nfo_mp3 = $rsql->s_array($get)) 
	{
		$donnees[$nfo_mp3['id']] = $nfo_mp3;
	}
	if ( !empty($donnees) && is_array($donnees) )
	{
		srand((float) microtime() * 10000000);
		$session_cl['id_mp3'] = array_rand($donnees);
		$session_cl['src_mp3'] = $donnees[$session_cl['id_mp3']]['SRC'];
		save_session($session_cl);
		$template->assign_block_vars('lecteur', array(
			'SRC' => $session_cl['src_mp3'],
			'AUTOPLAY' => $donnees[$session_cl['id_mp3']]['AUTOPLAY'],
			'LOOP' => $donnees[$session_cl['id_mp3']]['LOOP'],
			'NEWS' => $langue['news_titre'],
		));
	}
}
else
{
	$template->assign_block_vars('demande', array(
		'TXT' => $langue['demande_lecteur_on'],
	));
}
$template->pparse('body');
?>