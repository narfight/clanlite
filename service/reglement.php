<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_reglement';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
$template->set_filenames(array('body' => 'divers_text.tpl'));
if (empty($config['reglement']))
{
	$config['reglement'] = $langue['no_reglement'];
}
$template->assign_vars(array(
	'TITRE' => $langue['titre_reglement'],
	'TEXTE' => nl2br(bbcode($config['reglement'])),
));
$template->pparse('body');
include($root_path."conf/frame.php"); 
?>
