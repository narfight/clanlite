<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = "./../";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
clear_session();
SetCookie("auto_connect","",time()-12, $config['site_path']);
$HTTP_GET_VARS['where'] = (empty($HTTP_GET_VARS['where']))? '../service/index_pri.php' : $HTTP_GET_VARS['where'];
redirec_text($HTTP_GET_VARS['where'], $langue['deconect_login'],"user");
?>