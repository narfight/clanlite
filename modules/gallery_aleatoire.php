<?php
/****************************************************************************
 *	Fichier		: gallery_aleatoire.php										*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = 'Galerie aléatoire';
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}

	include($root_path.'conf/images.php');
	$sql = 'SELECT `id_image`, `url_image_mini`, `url_image_norm`, `nb_hauteur`, `nb_largeur`, `lb_commentaire` FROM '.$config['prefix'].'pictures ORDER BY `id_image`';
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	
	$u = 1;
	while ( $liste[$u++] = $rsql->s_array($get) );
	$image_id = rand(1, count($liste)-1);

	$the_image = $liste[$image_id];
	$img_url = session_in_url($root_path.'modules/gallery.php?id='.$image_id);
	$img_size = get_new_size(array($the_image['nb_largeur'],$the_image['nb_hauteur']), $config['tumb_width'], $config['tumb_height']);
	$module_in = '<a href="'.$img_url.'"><img src="'.$the_image['url_image_mini'].'" width="'.$img_size[0].'" heigth="'.$img_size[1].'" alt="'.$the_image['lb_commentaire'].'" /></a><br />'."\n";

	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => '<div style="text-align: center">'.$module_in.'</div>',
	));
	return;
}

if( !empty($_GET['config_modul_admin']) || !empty($_POST['Submit_module_perso_module']) )
{
	define('CL_AUTH', true);
$root_path = './../';
	require($root_path.'modules/gallery.php');
}
?>