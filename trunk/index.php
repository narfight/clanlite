<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'accueil.tpl'));
$sql = "SELECT COUNT(id) FROM `".$config['prefix']."config_sond` GROUP BY id";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$mp3 = $rsql->s_array($get);
if ($mp3['COUNT(id)'] > 0)
{
	$template->assign_vars(array(
		'NOM_CLAN' => $config['nom_clan'],
		'NEWS' => $langue['news_titre'],
		'MP3' => session_in_url($root_path.'service/lecteur_mp3.php'),
		'INDEX' => session_in_url($root_path.'service/index_pri.php')
	));
}
else
{
	redirection($root_path.'service/index_pri.php');
}
$template->pparse('body');
?> 