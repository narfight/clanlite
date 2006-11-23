<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// ------------------------------------------------------------- 
$root_path = "./../";
$action_membre = 'where_liens';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'liens.tpl'));
$template->assign_vars(array( 
	'TITRE_LIENS' => $langue['titre_liens'],
));
$sql = "SELECT * FROM `".$config['prefix']."liens`";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($info = $rsql->s_array($get))
{
	$template->assign_block_vars('liens', array( 
		'LIENS_L' => $info['nom_liens'],
		'LIENS_U' => $info['url_liens']
	));
	if (!empty($info['images']))
	{
		$template->assign_block_vars('liens.image', array('IMAGE' => $info['images']));
	}
}
$template->pparse('body');
include($root_path.'conf/frame.php');
?>