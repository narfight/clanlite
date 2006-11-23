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
$action_membre = 'where_liens';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$session_cl['skin']);
$template->set_filenames( array('body' => 'liens.tpl'));
$template->assign_vars(array( 
	'ICI' => session_in_url('liens.php'),
	'TITRE_LIENS' => $langue['titre_liens'],
	'BT_ENVOYER' => $langue['envoyer'],
));
$sql = "SELECT * FROM `".$config['prefix']."liens`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	$liste_liens[$liste['repertoire']][] = array(
		'NOM' => $liste['nom_liens'],
		'URL' => $liste['url_liens'],
		'IMAGE' => $liste['images'],
	);
}
if (!isset($_POST['pre-selection']))
{
	$_POST['pre-selection'] = '';
}

if (count($liste_liens) > 1)
{ //si il a des groups
	$template->assign_block_vars('selection', array(
		'TITRE' => $langue['liens_repertoire_choix_titre'],
		'TXT' => $langue['liens_repertoire_choix'],
		'CHOISIR' => $langue['choisir'],
));
}

foreach ($liste_liens as  $id => $value)
{
	if (count($liste_liens) > 1)
	{
		$template->assign_block_vars('selection.liste_selection', array(
			'TXT' => ($id == '')? $langue['liens-no-repertoire'] : $id,
			'VALUE' => $id,
			'SELECTED' => ($_POST['pre-selection'] == $id)? 'selected="selected"' : '',
		));
	}
	if ($_POST['pre-selection'] == $id || count($liste_liens) == 1)
	{ // si c'est le repertoire de liens qu'on veut voir
		$template->assign_block_vars('titre_repertoire', array('TITRE' => ($id == '')? $langue['liens-no-repertoire'] : $id));
		foreach ($value as $liens)
		{
			$template->assign_block_vars('liens', $liens);
			if (!empty($liens['IMAGE']))
			{
				$template->assign_block_vars('liens.image', '');
			}
		}
	}
}
$template->pparse('body');
require($root_path.'conf/frame.php');
?>