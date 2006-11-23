<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_iframe';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");

include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'iframe.tpl'));
// requette sql
$sql = "SELECT url, text FROM ".$config['prefix']."custom_menu WHERE id ='".$HTTP_GET_VARS['id']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$nombre_frame = 0;
if ( ($frame = $rsql->s_array($get)) ) 
{ 
	$template->assign_block_vars('frame',array('URL_IFRAME' => $frame[0]));
	$nombre_frame = $nombre_frame+1;
}
else
{
	msg('erreur', $langue['frame_erreur_id']);
}
$template->pparse('body');
include($root_path."conf/frame.php");
?>