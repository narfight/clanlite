<?php
/****************************************************************************
 *  Fichier		: gallery.php												*
 *  Copyright	: (C) 2006 ClanLite											*
 *  Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
	
if (defined('CL_AUTH'))
{
/******************************************************************************
 * information de la galerie												  *
 ******************************************************************************/

	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = 'Galerie d`images (central)';
		$central = true;
		return;
	}

/******************************************************************************
 * Installation de la galerie												 *
 ******************************************************************************/

	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$id_module = mysql_insert_id();
		$sql = 'CREATE TABLE `'.$config['prefix'].'module_pictures_'.$id_module.'` (`id_image` INT NOT NULL AUTO_INCREMENT , `url_image_mini` VARCHAR( 150 ) NOT NULL , `url_image_norm` VARCHAR( 150 ) NOT NULL , `nb_hauteur` INT NOT NULL , `nb_largeur` INT NOT NULL , `lb_commentaire` VARCHAR( 150 ) NOT NULL , PRIMARY KEY ( `id_image` ) )';
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "INSERT INTO `".$config['prefix']."custom_menu` (`ordre` , `text` , `url` , `bouge` , `frame` , `module_central` , `id_module` ) VALUES ('0', '".$_POST['nom']."', 'modules/gallery.php?from=".$id_module."', '0', '0', '1', '".$id_module."')";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "INSERT INTO `".$config['prefix']."config` VALUES ('img_width' , '500'), ('img_height' , '375'), ('tumb_width' , '100'), ('tumb_height', '75'), ('img_max_size' , 1000000000)";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	
/******************************************************************************
 * désinstalation de la galerie											   *
 ******************************************************************************/

	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		// on supprime toutes les images
		$sql = 'SELECT `url_image_mini`, `url_image_norm` FROM `'.$config['prefix'].'module_pictures_'.$_POST['for'].'`';
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		while ( $liste = $rsql->s_array($get) )
		{
			unlink($liste['url_image_mini']);
			unlink($liste['url_image_norm']);
		}

		$sql = 'DROP TABLE `'.$config['prefix'].'module_pictures_'.$_POST['for'].'`';
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "DELETE FROM `".$config['prefix']."custom_menu` WHERE `id_module` = '".$_POST['for']."' LIMIT 1";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		$sql = "DELETE FROM `".$config['prefix']."config` WHERE `conf_nom` = 'img_width' OR `conf_nom` = 'img_height' OR `conf_nom` = 'tumb_width' OR `conf_nom` = 'tumb_height'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
}

/******************************************************************************
 * Administration															*
 ******************************************************************************/
if( !empty($_GET['config_modul_admin']) || !empty($_POST['del']) || !empty($_POST['modify']) || !empty($_POST['send']))
{
	$id_module = (empty($_GET['id_module']))? $_POST['id_module'] : $_GET['id_module'];
	define('CL_AUTH', true);
$root_path = './../';
	$niveau_secu = 16;
	$action_membre= 'where_module_gallery';
	require($root_path.'conf/conf-php.php');
	require($root_path.'conf/images.php');
	require($root_path.'controle/cook.php');
	require($root_path.'conf/template.php');
	$template = new Template($root_path.'templates/'.$session_cl['skin']);

	if ( !empty($_POST['del']) )
	{
		// supprime l'image
		$sql = 'SELECT `url_image_mini`, `url_image_norm` FROM `'.$config['prefix'].'module_pictures_'.$id_module.'` WHERE id_image =\''.$_POST['id'].'\'';
		if (! ($get = $rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		if ( $liste = $rsql->s_array($get) )
		{
			unlink($liste['url_image_mini']);
			unlink($liste['url_image_norm']);
		}

		$sql = "DELETE FROM `".$config['prefix']."module_pictures_".$id_module."` WHERE id_image ='".$_POST['id']."'";
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path.'modules/gallery.php?config_modul_admin=oui&id_module='.$id_module ,$langue['redirection_gallery_dell'], 'admin');
	}

	if ( !empty($_POST['modify']) )
	{
		// Sauvegarde les infos
		foreach ($_POST as $config_name => $config_value)
		{
			$sql = 'UPDATE `'.$config['prefix']."config` SET conf_valeur='".pure_var($config_value)."' WHERE conf_nom='".htmlspecialchars($config_name, ENT_QUOTES)."'";
			if (! $rsql->requete_sql($sql) )
			{
				sql_error($sql, $rsql->error, __LINE__, __FILE__);
			}
		}
	
		redirec_text($root_path.'modules/gallery.php?config_modul_admin=oui&id_module='.$id_module ,$langue['redirection_gallery_edit'], 'admin');
	}

	if ( !empty($_POST['send']) )
	{
		// Reception d'une image
		$target_file = $_FILES['userfile']['name'];
		$file_ext = strtolower(substr($target_file, strlen($target_file)-4, 4));
		if (strcmp($file_ext, '.jpg') == 0 || strcmp($file_ext, '.gif') == 0 || strcmp($file_ext, '.png') == 0)
		{
			$target_path_norm = $root_path.'gallery/norm/';
			$target_path_mini = $root_path.'gallery/mini/';
			$target_norm = $target_path_norm . $target_file;
			$target_mini = $target_path_mini . $target_file;
			
			$filename = $_FILES['userfile']['tmp_name']; // c'est le nom du fichier temporaire...
		
			if (is_uploaded_file($filename))
			{
				// on vérifie qu'une image du même nom n'existe pas déja et on cherche un non dispo
				$i = 1;
				while(is_file($target_norm))
				{
					$target_norm = $target_path_norm.$i.'-'.$target_file;
					$i++;
				}

				if(move_uploaded_file($filename, $target_norm))
				{
					$url_etiquette = CreateEtiquette($target_path_norm, $target_file, $target_path_mini, $config['tumb_width'], $config['tumb_height']);
					if (!$url_etiquette)
					{
						redirec_text($root_path.'modules/gallery.php?config_modul_admin=oui&id_module='.$id_module, $langue['mini_error'], 'admin');
					}

					$img_size = getimagesize($target_norm);
					$sql = "INSERT INTO `".$config['prefix']."module_pictures_".$id_module."` ( `id_image` , `url_image_mini` , `url_image_norm` , `nb_hauteur` , `nb_largeur` , `lb_commentaire` ) VALUES ('".mysql_insert_id()."', '".$url_etiquette."', '".$target_norm."', '".$img_size[1]."', '".$img_size[0]."', '".$_POST['com_img']."')";
					if (!$rsql->requete_sql($sql))
					{
						sql_error($sql, $rsql->error, __LINE__, __FILE__);
					}
					redirec_text($root_path.'modules/gallery.php?config_modul_admin=oui&id_module='.$id_module, sprintf($langue['the_file_has_been_uploaded'],$_FILES['userfile']['name']), 'admin');
				}
				else
				{
					redirec_text($root_path.'modules/gallery.php?config_modul_admin=oui&id_module='.$id_module ,$langue['upload_error'], 'admin');
				}
			}
			else
			{
					redirec_text($root_path.'modules/gallery.php?config_modul_admin=oui&id_module='.$id_module ,$langue['upload_error'], 'admin');
			}
		}
		else
		{
			redirec_text($root_path.'modules/gallery.php?config_modul_admin=oui&id_module='.$id_module ,$langue['not_supported'], 'admin');
		}
	}

	require($root_path.'conf/frame_admin.php');
	$template = new Template($root_path.'templates/'.$session_cl['skin']);
	$template->set_filenames( array('body' => 'modules/gallery.tpl'));

	$_GET['limite'] = (empty($_GET['limite']) || !is_numeric($_GET['limite']))? 0 : $_GET['limite'];
	$nb_img = get_nbr_objet('module_pictures_'.$id_module, '');

	$sql = 'SELECT `id_image`, `url_image_mini`, `url_image_norm`, `nb_hauteur`, `nb_largeur`, `lb_commentaire` FROM `'.$config['prefix'].'module_pictures_'.$id_module.'` ORDER BY `id_image` LIMIT '.$_GET['limite'].', '.$config['objet_par_page'];
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	
	$template->assign_vars(array(
		'ICI' => session_in_url('gallery.php'),
		'ID' => $id_module,
		'TITRE' => $langue['titre_module_gallery'],

		'TITRE_CONFIGURATION' => $langue['titre_configuration_module_img'],
		'CONFIGURATION' => $langue['gallery_config-show'],
		'IMG_H' => $config['img_height'],
		'IMG_W' => $config['img_width'],
		'TUMB_H' => $config['tumb_height'],
		'TUMB_W' => $config['tumb_width'],
		'TXT_MAX_SIZE' => $langue['gallery_max_size'],
		'MAX_IMG_SIZE' => $config['img_max_size'],
		'TXT_SIZE_IMG' => $langue['gallery_size_img'],
		'TXT_SIZE_TUMB' => $langue['gallery_size_tumb'],
		'EDITER' => $langue['editer'],

		'TITRE_GESTION' => $langue['titre_gestion_module_img'],
		'TITRE_LISTE' => $langue['titre_liste_module_img'],
		'ACTION' => $langue['action'],
		'TXT_APERCU' => $langue['gallery_apercu'],
		'TXT_LINK' => $langue['gallery_txt_url'],
		'UNIT_BYTE' => $langue['unit_byte'],
		'TXT_BTN_SEND' => $langue['envoyer'],
		'TXT_COM_IMG' => $langue['com_img'],
	));

	while ( $current_img = $rsql->s_array($get) )
	{
		$tumb_size = get_new_size(array(
				$current_img['nb_largeur'],
				$current_img['nb_hauteur']
			),
			$config['tumb_width'],
			$config['tumb_height']
		);
		
		$template->assign_block_vars('images', array(
			'SRC_IMG' => $current_img['url_image_mini'],
			'COM_IMG' => $current_img['lb_commentaire'],
			'REMOVE' => $langue['gallery_remove'],
			'TXT_CON_DELL' => $langue['confirm_dell'],
			'ID' => $current_img['id_image'],
			'ICI' => session_in_url('gallery.php'),
			'TUMB_H' => $tumb_size['height'],
			'TUMB_W' => $tumb_size['width']
		));
	}
	displayNextPreviousButtons($_GET['limite'], $nb_img, 'multi_page', $root_path.'modules/gallery.php');
  
	$template->pparse('body');
	require($root_path.'conf/frame_admin.php');
	return;
}

/******************************************************************************
 * Affichage de la galerie coté client										*
 ******************************************************************************/

if (!empty($_GET['from']))
{
	define('CL_AUTH', true);
$root_path = './../';
	$action_membre= 'where_gallery';
	require($root_path.'conf/template.php');
	require($root_path.'conf/conf-php.php');
	require($root_path.'conf/frame.php');
	include($root_path.'conf/images.php');
	
	$template = new Template($root_path.'templates/'.$session_cl['skin']);
	$template->set_filenames(array('body' => 'modules/gallery-client.tpl'));
	
	$_GET['from'] = intval($_GET['from']);
	$sql = 'SELECT `id_image`, `url_image_mini`, `url_image_norm`, `nb_hauteur`, `nb_largeur`, `lb_commentaire` FROM `'.$config['prefix'].'module_pictures_'.$_GET['from'].'` ORDER BY `id_image`';
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	
	$i = 1;
	while ( $liste = $rsql->s_array($get) )
	{
		// définit la taille max de l'image central
		$tmp = get_new_size(
			array($liste['nb_largeur'], $liste['nb_hauteur']),
			$config['img_width'], $config['img_height']);
		$liste['nb_hauteur'] = $tmp['height'];
		$liste['nb_largeur'] = $tmp['width'];
	
		$template->assign_block_vars('liste', array(
			'TITRE' => $liste['lb_commentaire'],
			'MIN' => $liste['url_image_mini'],
			'NORM' => $liste['url_image_norm'],
			'NORM_H' => $liste['nb_hauteur'],
			'NORM_L' => $liste['nb_largeur'],
		));
		if ($i < 4)
		{
			$je_t_aime_anne_sophie[$i] = $liste;
		}
		$i++;
	}
	$i--;
	// vérifie qu'il a au moins 3 images
	switch($i)
	{
		case 0:
			list($size['width'], $size['height'], $size['type']) = getimagesize('images/logo_rss.gif');
			
			$je_t_aime_anne_sophie[1]['url_image_min'] = 'images/logo_rss.gif';

			$je_t_aime_anne_sophie[2]['url_image_norm'] = 'images/logo_rss.gif';
			$je_t_aime_anne_sophie[2]['nb_hauteur'] = $size['height'];
			$je_t_aime_anne_sophie[2]['nb_largeur'] = $size['width'];
			
			$je_t_aime_anne_sophie[3]['url_image_mini'] = 'images/logo_rss.gif';
		break;
		case 1:
			$je_t_aime_anne_sophie[2]['url_image_norm'] = $je_t_aime_anne_sophie[1]['url_image_norm'];
			$je_t_aime_anne_sophie[3]['url_image_mini'] = $je_t_aime_anne_sophie[1]['url_image_mini'];
			$je_t_aime_anne_sophie[2]['lb_commentaire'] = $je_t_aime_anne_sophie[1]['lb_commentaire'];
		break;
		case 2:
			$je_t_aime_anne_sophie[3]['url_image_mini'] = $je_t_aime_anne_sophie[2]['url_image_mini'];
		break;
	}

	$template->assign_vars(array(
		'TITRE' => $langue['gallery'],
		'SRC_MIN_1' => $je_t_aime_anne_sophie[1]['url_image_mini'],
		'COM_IMG' => $je_t_aime_anne_sophie[2]['lb_commentaire'],
		'SRC' => $je_t_aime_anne_sophie[2]['url_image_norm'],
		'WIDTH' => $je_t_aime_anne_sophie[2]['nb_largeur'],
		'HEIGHT' => $je_t_aime_anne_sophie[2]['nb_hauteur'],
		'SRC_MIN_2' => $je_t_aime_anne_sophie[3]['url_image_mini'],
	));

	$template->pparse('body');
	require($root_path.'conf/frame.php');
}
?>