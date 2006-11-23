<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
// on inclus la conf
$action_membre = 'where_connecte';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path."controle/cook.php");
include($root_path."conf/frame_admin.php");
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'connecter.tpl'));

$template->assign_vars(array( 
	'TITRE_CONNECTE' => $langue['titre_connecte'],
	'NO_PROFIL' => $langue['no_profil'],
	'ID' => $langue['id'],
	'NOM_SEX' => $langue['nom/sex'],
	'ACTION' => $langue['action'],
	'PROFIL' => $langue['profil'],
	'IP' => $langue['ip'],
));
// création de la liste des connecter
$sql = "SELECT * FROM `".$config['prefix']."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(date) < ".$config['time_cook'];
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$nombre = '';
while ($liste = $rsql->s_array($get))
{
	$nfo_session = unserialize($liste['stock']);
	$template->assign_block_vars('connecter', array( 
		'ID' => ( empty($nfo_session['id']) )? "N/A" : $nfo_session['id'],
		'USER' => ( empty($nfo_session['user']) )? "Visiteur" : $nfo_session['user'],
		'SEX' => ( !empty($nfo_session['sex']) && $nfo_session['sex'] == "Femme" )? "femme" : "homme",
		'ACTION'  => $langue[$nfo_session['action_membre']]
	));
	if (!empty($nfo_session['id']))
	{
		$template->assign_block_vars('connecter.membre_connect', array( 'vide' => 'vide' ));
	}
	else
	{
		$template->assign_block_vars('connecter.no_membre_connect', array( 'vide' => 'vide' ));
	}
	$nombre++;
	if ($user_pouvoir['particulier'] == 'admin')
	{
		$template->assign_block_vars('connecter.admin', array('IP' => $nfo_session['ip']));
		// on limite cette parite a une fois
		if ($nombre == 1)
		{
			$template->assign_block_vars('IP', 'vide');
		}
	}
	unset($nfo_session);
} 
$template->pparse('body');
include($root_path."conf/frame_admin.php");
 ?>