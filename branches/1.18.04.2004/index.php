<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = "./";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'accueil.tpl'));
$template->assign_vars(array(
	'NOM_CLAN' => $config['nom_clan'],
));
$template->pparse('body');
?> 