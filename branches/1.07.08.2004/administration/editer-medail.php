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
	$sql = "UPDATE ".$config['prefix']."user SET medail='".((empty($_POST['medail1']))? '' : 1).",".((empty($_POST['medail2']))? '' : 1).",".((empty($_POST['medail3']))? '' : 1).",".((empty($_POST['medail4']))? '' : 1).",".((empty($_POST['medail5']))? '' : 1).",".((empty($_POST['medail6']))? '' : 1).",".((empty($_POST['medail7']))? '' : 1).",".((empty($_POST['medail8']))? '' : 1).",".((empty($_POST['medail9']))? '' : 1).",".((empty($_POST['medail10']))? '' : 1)."' WHERE id ='".$_POST['id']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text($root_path."service/liste-des-membres.php", $langue['redirection_medaille'], 'admin');
}
include($root_path."conf/frame_admin.php");
$sql = "SELECT user,id,medail FROM `".$config['prefix']."user` WHERE id = '".$_POST['id']."'";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ($recherche = $rsql->s_array($get))
{
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('body' => 'admin_medail.tpl'));
	// on affiche ou pas la medaille, si il a ou pas
	$medail=explode(",", $recherche['medail']);
	$boucle = -1;
	$nombre_md = 0;
	$template->assign_vars(array(
		'TITRE' => sprintf($langue['titre_medaille'], $recherche['user']),
		'EDITER' => $langue['editer'],
	));
	while ($boucle <= 8)
	{
		$nombre_md++;
		$boucle++;
		$template->assign_vars(array('M'.$nombre_md => (!empty($medail[$boucle]))? 'checked="checked"' : ''));
	}
	$template->assign_vars(array('ID'=> $_POST['id']));
	$template->pparse('body');
}
else
{
	msg('erreur', $langue['erreur_profil_no_found']);
}
include($root_path."conf/frame_admin.php");
?>