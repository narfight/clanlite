<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = "./../";
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
clear_session();
SetCookie("auto_connect","",time()-12, $config['site_path']);
$_GET['where'] = (empty($_GET['where']))? '../service/index_pri.php' : $_GET['where'];
redirec_text($_GET['where'], $langue['deconect_login'],"user");
?>