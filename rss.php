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
$root_path = './';
header("Content-Type: text/xml\n");
$action_membre = 'where_rss';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');

$sql = "SELECT news.*, COUNT(reaction.id_news) FROM `".$config['prefix']."news` AS news LEFT JOIN ".$config['prefix']."reaction_news AS reaction ON news.id = reaction.id_news  GROUP BY news.id ORDER BY news.id DESC LIMIT 10";
if (! ($list_news = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
// on commence la boucle pour les news
echo '<?xml version="1.0" encoding="iso-8859-1"?>'."\n";
echo '<rss version="2.0"'."\n";
echo '    xmlns:dc="http://purl.org/dc/elements/1.1/"'."\n";
echo '    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"'."\n";
echo '    xmlns:admin="http://webns.net/mvcb/"'."\n";
echo '    xmlns:slash="http://purl.org/rss/1.0/modules/slash/"'."\n";
echo '    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'."\n";
echo '    xmlns:content="http://purl.org/rss/1.0/modules/content/">'."\n";
echo '	<channel>'."\n";
echo '		<title>'.htmlspecialchars($config['nom_clan']).'</title>'."\n";
echo '		<link>'.$config['site_domain'].$config['site_path'].'</link>'."\n";
echo '		<generator>'.htmlspecialchars($config['nom_clan']).'</generator>'."\n";
echo '		<docs>http://blogs.law.harvard.edu/tech/rss</docs>'."\n";
echo '		<description></description>'."\n";
echo '		<image>'."\n";
echo '			<title>'.htmlspecialchars($config['nom_clan']).'</title>'."\n";
echo '			<url>'.$config['site_domain'].$config['site_path'].'images/logo_rss.gif</url>'."\n";
echo '			<link>'.$config['site_domain'].$config['site_path'].'</link>'."\n";
echo '		</image>'."\n";
while ( $recherche = $rsql->s_array($list_news) ) 
{	
	echo '		<item>'."\n";
	echo '			<title>'.$recherche['titre'].'</title>'."\n";
	echo '			<link>'.$config['site_domain'].$config['site_path'].'service/reaction.php?for='.$recherche['id'].'</link>'."\n";
	echo '			<guid>'.$config['site_domain'].$config['site_path'].'service/reaction.php?for='.$recherche['id'].'</guid>'."\n";
	echo '			<comments>'.$config['site_domain'].$config['site_path'].'service/reaction.php?for='.$recherche['id'].'</comments>'."\n";
	echo '			<slash:comments>'.$recherche['COUNT(reaction.id_news)'].'</slash:comments>'."\n";
	echo '			<author>'.$recherche['user'].'</author>'."\n";
	echo '			<dc:date>'.date('r', $recherche['date']).'</dc:date>'."\n";
	echo '		</item>'."\n";
}
echo '	</channel>'."\n";
echo '</rss>'."\n";
?>