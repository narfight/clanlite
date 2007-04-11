<?php
/****************************************************************************
 *	Fichier		: bbcode.php												*
 *	Copyright	: (C) 2006 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
// les bouttons BBcode de l'interface
$config['bbcode']['bt'] = array (
	'size' => array (
		'START' => '[size=12]',
		'END' => '[/size]'
	),
	'color' => array (
		'START' => '[color=blue]',
		'END' => '[/color]'
	),
	'center' => array (
		'START' => '[center]',
		'END' => '[/center]'
	),
	'b' => array (
		'START' => '[b]',
		'END' => '[/b]'
	),
	'i' => array (
		'START' => '[i]',
		'END' => '[/i]'
	),
	'u' => array (
		'START' => '[u]',
		'END' => '[/u]'
	),
	'img' => array (
		'START' => '[img]',
		'END' => '[/img]'
	),
	'url' => array (
		'START' => '[url=http://www.clanlite.org]ClanLite',
		'END' => '[/url]'
	),
	'swf' => array (
		'START' => '[swf width=12 eight=24]',
		'END' => '[/swf]'
	),
	'video' => array (
		'START' => '[video]',
		'END' => '[/video]'
	),
	/*'' => array (
		'START' => '[]',
		'END' => '[/]'
	),*/
);

$config['bbcode']['search'] = array(
	"#\[size=([1-2]?[0-9])]([^]]*)\[/size]#si",
	"#\[color=(\#[0-9A-F]{6}|[a-z]+)]([^]]*)\[/color]#si",
	"#\[center](.*)\[/center]#si",
	"#\[b]([^]]*)\[/b]#si",
	"#\[i]([^]]*)\[/i]#si",
	"#\[u]([^]]*)\[/u]#si",
	"#\[img\]([a-z]+?://)([^\r\n\t<\"]*?)\[/img\]#i",
	"#([0-9a-zA-Z]+?)([0-9a-zA-Z._-]+)@([0-9a-zA-Z_-]+).([0-9a-zA-Z]+)#i",
	"#\[url\]([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si",
	"#\[url\]([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\[/url\]#si",
	"#\[url=([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si",
	"#\[url=([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\](.*?)\[/url\]#si",
	"#\[(swf|flash) width=([0-9]+?) height=([0-9]+?)\]([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+).swf\[\/(swf|flash)\]#si",
	"#\[video\](([a-z]+?)://([^, \n\r]+))\[/video\]#si"
);
$config['bbcode']['replace'] = array(
	"<span style=\"font-size: \\1px;\">\\2</span>",
	"<span style=\"color: \\1\">\\2</span>",
	"<div style=\"text-align: center\">\\1</div>",
	"<strong>\\1</strong>",
	"<span style=\"font-style: italic\">\\1</span>",
	"<span style=\"text-decoration:underline\">\\1</span>",
	"<img src=\"\\1\\2\" alt=\"\\1\\2\" />",
	"<a href=\"mailto:\\1\\2@\\3.\\4\">\\1\\2@\\3.\\4</a>",
	"<a href=\"\\1\\2\">\\1\\2</a>",
	"<a href=\"http://\\1\">\\1</a>",
	"<a href=\"\\1\\2\">\\3</a>",
	"<a href=\"http://\\1\">\\2</a>",
	"<object type=\"application/x-shockwave-flash\" width=\"\\1\" height=\"\\2\" data=\"\\3.swf\"><param name=\"movie\" value=\"\\3.swf\" /></object>",
	"<object type=\"video/x-ms-asf-plugin\" data=\"\\1\" width=\"320\" height=\"320\">\n<param name=\"src\" value=\"\\1\" />\n<param name=\"autoplay\" value=\"false\" />\n<param name=\"loop\" value=\"false\" />\n</object>"
);

// bbcode [list]
function bbcode_list($fichier)
{	while(ereg('\[list](.*)\[/list]', $fichier))
	{
		$fichier = preg_replace("#\[list](.*)\[/list]#Usi", "<ul>\\1\n</li></ul>", $fichier); 
	}
	while(ereg('<ul>(.*)\[\*\](.*)</ul>', $fichier))
	{
		$fichier = preg_replace("#<ul>(.*)\[\*\](.*)</ul>#Usi", "<ul>\\1</li><li>\\2</ul>", $fichier);
	}
	$fichier = str_replace('<ul></li>', '<ul>', $fichier);
	return str_replace(chr(10).'</li><li>', '</li><li>', $fichier);
}

// applique tout les bbcodes
function bbcode_exec($fichier)
{
	global $config;
	$fichier = bbcode_list($fichier);
	return preg_replace($config['bbcode']['search'], $config['bbcode']['replace'], $fichier);
}

// génére les bouttons bbcode
function bbcode_build_bt ($tpl_ou='')
{
	global $config, $template, $langue;
	// on couple avec le fichier de langue pour l'aide et ajoute l'index
	if (!isset($config['bbcode']['find help']))
	{
		$config['bbcode']['find help'] = true;
		
		foreach($config['bbcode']['bt'] as $bbcode_nom => $bbcode_info)
		{
			if (!isset($config['bbcode']['bt'][$bbcode_nom]['INDEX']))
			{
				$config['bbcode']['bt'][$bbcode_nom]['INDEX'] = $bbcode_nom;
			}

			if (isset($langue['bt_bbcode'][$bbcode_nom]))
			{
				$config['bbcode']['bt'][$bbcode_nom]['HELP'] = $langue['bt_bbcode'][$bbcode_nom];
			}
			else
			{
				$config['bbcode']['bt'][$bbcode_nom]['HELP'] = '';
			}
		}
	}
	foreach($config['bbcode']['bt'] as $bbcode_nom => $bbcode_info)
	{
		$template->assign_block_vars($tpl_ou.'bt_bbcode_liste', $config['bbcode']['bt'][$bbcode_nom]);
	}
}
?>