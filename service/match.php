<?php
/****************************************************************************
 *	Fichier		: match.php													*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
define('CL_AUTH', true);
$root_path = './../';
$action_membre= 'where_match';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'match_publique.tpl'));

$sql = "SELECT * FROM `".$config['prefix']."match` WHERE date > '".(time()-60*60*2) ."' ORDER BY `date` DESC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$template->assign_vars(array( 
	'TITRE_MATCH' => $langue['titre_match'],
	'CONTRE' => $langue['contre_qui'],
	'DATE' => $langue['date_defit'],
	'HEURE' => $langue['heure_defit'],
));
// on fais la boucle pour les matchs
$i=0;
while ($liste = $rsql->s_array($get)) 
{ 
	$i++;
	$template->assign_block_vars('match', array(
		'DATE' => adodb_date('j/n/Y', $liste['date']+$session_cl['correction_heure']),
		'CLAN' => $liste['le_clan'],
		'INFO' => bbcode($liste['info']),
		'HEURE' => adodb_date('H:i', $liste['date']+$session_cl['correction_heure']),
		'FOR' => $liste['id'],
	));
}
if ($i === 0)
{
	$template->assign_block_vars('no_match', array('TXT' => $langue['no_futur_match']));
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>