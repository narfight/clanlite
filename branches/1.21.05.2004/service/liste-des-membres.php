<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
// on inclus la conf
$action_membre= 'where_membre_liste';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if ( !empty($_POST['del']) )
{
	secu_level_test('22');
	// supprime le membre
	$sql = "DELETE FROM ".$config['prefix']."user WHERE id ='".$_POST['id_user']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//supprime ces pouvoir
	$sql = "DELETE FROM ".$config['prefix']."pouvoir  WHERE user_id ='".$_POST['id_user']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//supprime ces inscription au match
	$sql = "DELETE FROM ".$config['prefix']."match_inscription WHERE user_id ='".$_POST['id_user']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	//modifie le nombre de membre dans la base de donnée
	$config['nbr_membre']=$config['nbr_membre']-1;
	$sql = "UPDATE ".$config['prefix']."config SET conf_valeur='".$config['nbr_membre']."' WHERE conf_nom='nbr_membre'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("liste-des-membres.php","Le membres est supprimé", "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'membre_liste.tpl'));
// connection Mysql
$template->assign_vars(array( 
	'TITRE_LISTE_MEMBRES' => $langue['titre_liste_membres'],
	'ID' => $langue['id'],
	'NUM' => $langue['numero'],
	'NOM_SEX' => $langue['nom/sex'],
	'MSN' => $langue['msn'],
));
$sql = "SELECT sex,id,user,im FROM ".$config['prefix']."user ORDER BY id ASC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$nombre = "";
while ($liste = $rsql->s_array($get))
{ 
	$nombre++;
	if ( ( $user_pouvoir['particulier'] == "admin" || $user_pouvoir[8] == "oui") && $nombre == 1)
	{
		$template->assign_block_vars('profil_tete', array('PROFIL' => $langue['profil']));
	}
	if ( ($user_pouvoir['particulier'] == "admin" || $user_pouvoir[7] == "oui") && $nombre == 1)
	{
		$template->assign_block_vars('medail_tete', array('MEDAILLES' => $langue['medailles']));
	}
	if ( ($user_pouvoir['particulier'] == "admin" || $user_pouvoir[22] == "oui") && $nombre == 1)
	{
		$template->assign_block_vars('del_tete', array('SUPPRIMER' => $langue['supprimer']));
	}
	if ($user_pouvoir['particulier'] == "admin" && $nombre == 1)
	{
		$template->assign_block_vars('admin_tete', array('POUVOIRS' => $langue['pouvoirs']));
	}
	$template->assign_block_vars('liste', array( 
		'NOMBRE' => $nombre,
		'ID' => $liste['id'],
		'SEX' => ($liste['sex'] == 'Femme')? "femme" : "homme",
		'USER' => $liste['user'],
		'MSN' => $liste['im']
	));
	if ( $user_pouvoir['particulier'] == "admin" || $user_pouvoir[8] == "oui")
	{
		$template->assign_block_vars('liste.edit_profil', array( 'vide' => 'vide'));
	}
	if ( $user_pouvoir['particulier'] == "admin" || $user_pouvoir[7] == "oui")
	{
		$template->assign_block_vars('liste.edit_medail', array( 'vide' => 'vide'));
	}
	if ( $user_pouvoir['particulier'] == "admin" || $user_pouvoir[7] == "oui")
	{
		$template->assign_block_vars('liste.del', array( 'vide' => 'vide'));
	}
	if ($user_pouvoir['particulier'] == "admin")
	{
		$template->assign_block_vars('liste.admin', array( 'vide' => 'vide'));
	}
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>