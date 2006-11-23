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
if ( !empty($_POST['Submit']) )
{
	$sql = "UPDATE ".$config['prefix']."user SET medail='".$_POST['medail1'].",".$_POST['medail2'].",".$_POST['medail3'].",".$_POST['medail4'].",".$_POST['medail5'].",".$_POST['medail6'].",".$_POST['medail7'].",".$_POST['medail8'].",".$_POST['medail9'].",".$_POST['medail10']."' WHERE id ='".$_POST['id_user']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text($root_path."service/liste-des-membres.php", "Les Médails ont été changées" , "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_medail.tpl'));
$sql = "SELECT * FROM `".$config['prefix']."user` WHERE id = '".$_POST['id_user']."'";
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
$template->assign_vars(array('ID'=> $_POST['id_user']));
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>