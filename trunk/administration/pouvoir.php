<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = "-1";
$action_membre= 'where_pouvoir';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if (!empty($HTTP_POST_VARS['envois_edit']))
{
	$HTTP_POST_VARS = pure_var($HTTP_POST_VARS);
	$requette = "";
	for ($i = 1;$i < 23;$i++)
	{
		if($HTTP_POST_VARS['activation'.$i] != "oui")
		{
			$HTTP_POST_VARS['activation'.$i] = "non";
		}
		$requette .="p".$i."='".$HTTP_POST_VARS['activation'.$i]."', ";
	}
	$requette .="p".$i."='".$HTTP_POST_VARS['activation'.$i]."' ";
	$sql = "UPDATE `".$config['prefix']."pouvoir` SET ".$requette." WHERE user_id='".$HTTP_POST_VARS['id_user']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("../service/liste-des-membres.php","les pouvoirs ont �t� mis a jours, vous allez etre rediriger sur la liste des membres","admin");
	}
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_pouvoir.tpl'));
if (!empty($HTTP_POST_VARS['editer']))
{
	$sql = "SELECT * FROM ".$config['prefix']."pouvoir WHERE user_id='".$HTTP_POST_VARS['id_user']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_pouvoir = $rsql->s_array($get);
	if ($rsql->nbr($get) == 0)
	{
		$sql = "INSERT INTO `".$config['prefix']."pouvoir` ( `user_id` , `p1` , `p2` , `p3` , `p4` , `p5` , `p6` , `p7` , `p8` , `p9` , `p10` , `p11` , `p12` , `p13` , `p14` , `p15` , `p16` , `p17` , `p18` , `p19` , `p20` , `p21` , `p22` , `p23` )	VALUES ('".$HTTP_POST_VARS['id_user']."', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non')";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
	}
	for ($i = 1;$i < 24;$i++)
	{
		$template->assign_block_vars('liste', array( 
			'INFO_POUVOIR' => $langue['pv_num_'.$i],
			'NUM' => $i,
			'ACTIVATION_0' => ( $edit_pouvoir['p'.$i] != "oui") ? "checked=\"checked\"" : "",
			'ACTIVATION_1' => ( $edit_pouvoir['p'.$i] == "oui") ? "checked=\"checked\"" : "",
			'OUI' => $langue['oui'],
			'NON' => $langue['non'],
		));
	}
	$template->assign_vars( array(
		'ID' => $HTTP_POST_VARS['id_user'],
		'TITRE' => $langue['titre_pouvoir'],
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>