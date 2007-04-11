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
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module))
	{
		$nom = 'Top 10 Referers';
		return;
	}
	if( !empty($module_installtion))
	{
		secu_level_test(16);
		$sql = 'CREATE TABLE `'.$config['prefix'].'module_top_referers_'.$rsql->last_insert_id().'` (`name` VARCHAR( 255 ) NOT NULL , `url` VARCHAR( 255 ) NOT NULL ,`nbr` MEDIUMINT( 8 ) UNSIGNED NOT NULL ,UNIQUE (`url`)) TYPE = MYISAM ;';
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	if( !empty($module_deinstaller))
	{
		secu_level_test(16);
		$sql = 'DROP TABLE `'.$config['prefix'].'module_top_referers_'.$_POST['for'].'`';
		if (!$rsql->requete_sql($sql))
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		return;
	}
	
	//Le module coté public
	$sql = 'SELECT `nbr`, `url`, `name` FROM `'.$config['prefix'].'module_top_referers_'.$modules['id'].'`';
	if (! ($get = $rsql->requete_sql($sql, 'module', 'Prend les infos sur les référenceurs')) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$html_liste = '<ul>';
	$i = 0;
	while ( $liste = $rsql->s_array($get) )
	{ 
		$donnees[$liste['name']] = $liste['nbr'];
		if ($i < 11)
		{
			$html_liste .= '<li><a href="'.$liste['url'].'">'.cut_sentence($liste['name'], 40)."</a></li>\n";
			$i++;
		}
	}
	$html_liste .= '</ul>';
	
	$template->assign_block_vars('modules_'.$modules['place'], array( 
		'TITRE' => $modules['nom'],
		'IN' => $html_liste,
	));

	if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != 'bookmarks')
	{
		//on vérifie que le référent ne soit pas nous même
		if (!eregi('^'.$config['site_domain'].$config['site_path'], $_SERVER['HTTP_REFERER']))
		{
			$shortref = preg_replace('/http:\/\//', '', $_SERVER['HTTP_REFERER']);
			$shortref = preg_replace('/\/.*/', '', $shortref);
	
	    	// quote the &s in URLs to make legal HTML
			$longref = preg_replace('/&/', '&amp;', $_SERVER['HTTP_REFERER']);
			// on l'ajoute ou modifie
			if (isset($donnees[$shortref]))
			{// il est déja en DB, on ajoute 1 au compteur
				$donnees[$shortref]++;
				$sql = 'UPDATE `'.$config['prefix'].'module_top_referers_'.$modules['id']."` SET `nbr`='".$donnees[$shortref]."' WHERE `name`='".$shortref."'";
				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}				
			}
			else
			{// il n'est pas en DB
				$sql = 'INSERT INTO `'.$config['prefix'].'module_top_referers_'.$modules['id']."` (`name`, `url`, `nbr`) VALUES ('".$shortref."', '".$longref."', 0)";
				if (!$rsql->requete_sql($sql))
				{
					sql_error($sql, $rsql->error, __LINE__, __FILE__);
				}
			}
		}
	}
	return;
}
?>