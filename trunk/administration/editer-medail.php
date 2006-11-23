<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_medaille';
$niveau_secu = 7;
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if ( !empty($HTTP_POST_VARS['Submit']) )
{
	$sql = "UPDATE ".$config['prefix']."user SET medail='".$HTTP_POST_VARS['medail1'].",".$HTTP_POST_VARS['medail2'].",".$HTTP_POST_VARS['medail3'].",".$HTTP_POST_VARS['medail4'].",".$HTTP_POST_VARS['medail5'].",".$HTTP_POST_VARS['medail6'].",".$HTTP_POST_VARS['medail7'].",".$HTTP_POST_VARS['medail8'].",".$HTTP_POST_VARS['medail9'].",".$HTTP_POST_VARS['medail10']."' WHERE id ='".$HTTP_POST_VARS['id_user']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text($root_path."service/liste-des-membres.php", "Les Médails ont été changées" , "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_medail.tpl'));
$sql = "SELECT * FROM `".$config['prefix']."user` WHERE id = '".$HTTP_POST_VARS['id_user']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
$recherche = $rsql->s_array($get);
// on affiche ou pas la medaille, si il a ou pas
$medail=explode(",", $recherche[19]);
$boucle = -1;
$nombre_md = 0;
$template->assign_vars(array(
	'TITRE' => $langue['titre_medaille'],
	'EDITER' => $langue['editer'],
));
while ($boucle <= 8)
{
	$nombre_md++;
	$boucle++;
	$template->assign_vars(array('M'.$nombre_md => (!empty($medail[$boucle]))? 'checked="checked"' : ''));
}
$template->assign_vars(array('ID'=> $HTTP_POST_VARS['id_user']));
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>