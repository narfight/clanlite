<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 10;
$action_membre= 'where_entrain';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
if ( !empty($_POST['Envoyer']) )
{
	$date = mktime( $_POST['heure'], $_POST['minute'], 0, $_POST['mois'], $_POST['jours'], $_POST['annee']);
	$_POST = pure_var($_POST);
	$sql = "INSERT INTO `".$config['prefix']."entrainement` (info, date, user, priver) VALUES ('".$_POST['texte']."', '".$date."', '".$session_cl['user']."', '".$_POST['priver']."')";
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql,mysql_error(), __LINE__, __FILE__);
	}
	redirec_text("entrainements.php", $langue['redirection_entrain_add'], "admin");
}
if ( !empty($_POST['Editer']) )
{
	$date = mktime( $_POST['heure'], $_POST['minute'], 0, $_POST['mois'], $_POST['jours'], $_POST['annee']);
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."entrainement` SET info='".$_POST['texte']."', date='".$date."', user='".$session_cl['user']."', priver='".$_POST['priver']."' WHERE id=".$_POST['for'];
	if (!$rsql->requete_sql($sql))
	{
		sql_error($sql,mysql_error(), __LINE__, __FILE__);
	}
	redirec_text("entrainements.php", $langue['redirection_entrain_edit'], "admin");
}
if (!empty($_POST['dell']))
{
	$sql = "DELETE FROM `".$config['prefix']."entrainement` WHERE id ='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	redirec_text("entrainements.php", $langue['redirection_entrain_dell'], "admin");
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'admin_entrainements.tpl'));
liste_smilies(true, '', 25);
$template->assign_vars( array( 
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'TITRE' => $langue['titre_entrain'],
	'TITRE_GESTION' => $langue['titre_entrain_gestion'],
	'TITRE_LISTE' => $langue['titre_entrain_list'],
	'TXT_TEXTE' => $langue['détails'],
	'MSG_PRIVE' => $langue['message_cote_prive'],
	'DATE' => $langue['date'],
	'HEURE' => $langue['heure'],
	'POSTEUR' => $langue['posteur'],
	'ACTION' => $langue['action'],
));
if ( !empty($_POST['edit']) )
{
	$sql = "SELECT * FROM ".$config['prefix']."entrainement WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql,mysql_error(), __LINE__, __FILE__);
	}
	$rechercheedit = $rsql->s_array($get);
	$template->assign_block_vars('editer', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $rechercheedit['id'],
		'INFO' => $rechercheedit['info'],
		'PRIVER' => $rechercheedit['priver'],
		'JOURS' =>  date("j", $rechercheedit['date']),
		'MOIS' => date("n", $rechercheedit['date']),
		'ANNEE' => date("Y", $rechercheedit['date']),
		'HH' => date("H", $rechercheedit['date']),
		'MM' => date("i", $rechercheedit['date']),
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$sql = "SELECT * FROM ".$config['prefix']."entrainement ORDER BY `id` DESC";
if (! ($query = $rsql->requete_sql($sql)) )
{
	sql_error($sql,mysql_error(), __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($query))
{
	$template->assign_block_vars('liste', array(
		'ID' => $liste['id'],
		'INFO' => nl2br(bbcode($liste['info'])),
		'PRIVER' => nl2br(bbcode($liste['priver'])),
		'POSTEUR' => $liste['user'],
		'DATE' =>  date('H:i j/n/Y', $liste['date']),
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>