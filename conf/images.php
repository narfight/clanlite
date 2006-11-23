<?php
/****************************************************************************
 *  Fichier		: images.php												*
 *  Copyright	: (C) 2006 ClanLite											*
 *  Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/

if (!defined('CL_IMAGE'))
{
	define('CL_IMAGE', true);
	function CreateEtiquette($Source, $Image, $Destination, $w_max, $h_max)
	{
		// on vérifie qu'une image du même nom n'existe pas déja et on cherche un non dispo
		$Image_Eti = $Image;
		$i = 1;
		while(is_file($Destination.$Image_Eti))
		{
			$Image_Eti = $i.'-'.$Image;
			$i++;
		}
		
		list($size['width'], $size['height'], $size['type']) = getimagesize($Source.$Image);
		$new_size = get_new_size($size, $w_max, $h_max);
	
		switch($size['type'])
		{
			case 1: //GIF
				$src = @imagecreatefromgif($Source.$Image);
				$im = @imagecreatetruecolor($new_size['width'], $new_size['height']);
				imagecopyresampled($im, $src, 0, 0, 0, 0, $new_size['width'], $new_size['height'], $size['width'], $size['height']);
				if(!imagegif($im, $Destination.$Image_Eti))
				{
					return false;
				}
			break;
			
			case 2: //JPG
				$src = @imagecreatefromjpeg($Source.$Image);
				$im = @imagecreatetruecolor($new_size['width'], $new_size['height']);
				imagecopyresampled($im, $src, 0, 0, 0, 0, $new_size['width'], $new_size['height'], $size['width'], $size['height']);
				if(!imagejpeg($im, $Destination.$Image_Eti))
				{	
					return false;
				}
			break;

			case 3: //PNG
				$src = @imagecreatefrompng($Source.$Image);
				$im = @imagecreatetruecolor($new_size['width'], $new_size['height']);
				imagecopyresampled($im, $src, 0, 0, 0, 0, $new_size['width'], $new_size['height'], $size['width'], $size['height']);
				if(!imagepng($im, $Destination.$Image_Eti))
				{
					return false;
				}
			break;
			
			default: // type non supporté
				return false;
			break;
		}
		return $Destination.$Image_Eti;
	}
	
	function get_new_size($orgsize, $w_max, $h_max)
	{
		if (!isset($orgsize['width']) || !isset($orgsize['height']))
		{
			list($orgsize['width'], $orgsize['height']) = $orgsize;
		}
		
		$ratio = $orgsize['width'] / $orgsize['height'];
		if ( $ratio > 1)
		{
			$new_size['width'] = $w_max;
			$new_size['height'] = round($orgsize['height']*($w_max / $orgsize['width']), 0);
		}
		else
		{
			$new_size['width'] = round($orgsize['width']*($h_max / $orgsize['height']), 0);
			$new_size['height'] = $h_max;
		}
		return $new_size;
	}
}
?>