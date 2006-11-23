<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$niveau_secu = 16;
$action_membre = 'where_module';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
include($root_path."controle/cook.php");
if (!empty($_POST['envoyer']))
{ 
	if (empty($_POST['module']))
	{
		redirec_text("modules.php", $langue['redirection_module_erreur'], 'admin');
	}
	$_POST = pure_var($_POST);
	$central = false;
	$get_nfo_module = 1;
	include($root_path."modules/".$_POST['module']);
	unset($get_nfo_module);
	$sql = "INSERT INTO `".$config['prefix']."modules` (nom, ordre, place, call_page, etat) VALUES ('".$_POST['nom']."', '".$_POST['num']."', '".(($central)? 'centre' : $_POST['position'])."', '".$_POST['module']."', '".$_POST['activation']."')";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$module_installtion = 1;
	include($root_path."modules/".$_POST['module']);
	redirec_text("modules.php", $langue['redirection_module_add'], 'admin');
}
if (!empty($_POST['envois_edit']))
{
	if (empty($_POST['module']))
	{
		redirec_text("modules.php", $langue['redirection_module_erreur'], 'admin');
	}
	$_POST = pure_var($_POST);
	$sql = "UPDATE `".$config['prefix']."modules` SET nom='".$_POST['nom']."', ordre='".$_POST['num']."', place='".$_POST['position']."', call_page='".$_POST['module']."', etat='".(($_POST['activation'] != 0)? 1 : 0)."' WHERE id='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	else
	{
		redirec_text("modules.php", $langue['redirection_module_edit'], 'admin');
	}
}
if (!empty($_POST['Supprimer']))
{
	$sql = "DELETE FROM `".$config['prefix']."modules` WHERE id ='".$_POST['for']."'";
	if (! ($rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$module_deinstaller = 1;
	include($root_path."modules/".$_POST['call_page']);
	redirec_text("modules.php", $langue['redirection_module_dell'], 'admin');
}
include($root_path."conf/frame_admin.php");
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'admin_modules.tpl'));
if (!empty($_POST['Editer']))
{
	$sql = "SELECT * FROM ".$config['prefix']."modules WHERE id='".$_POST['for']."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$edit_module = $rsql->s_array($get);
	$template->assign_block_vars('edit', array('EDITER' => $langue['editer']));
	$template->assign_vars( array( 
		'ID' => $edit_module['id'],
		'NOM' => $edit_module['nom'],
		'ORDRE' => $edit_module['ordre'],
		'SELECTED_GAUCHE' => ( $edit_module['place'] == "gauche") ? 'selected="selected"' : '',
		'SELECTED_DROITE' => ( $edit_module['place'] == "droite") ? 'selected="selected"' : '',
		'SELECTED_CENTRE' => ( $edit_module['place'] == "centre") ? 'selected="selected"' : '',
		'ACTIVATION_OFF' => ( $edit_module['etat'] == 0)? 'checked="checked"' : '',
	));
}
else
{
	$template->assign_block_vars('rajouter', array('ENVOYER' => $langue['envoyer']));
}
$template->assign_vars(array( 
	'TXT_CON_DELL' => $langue['confirm_dell'],
	'ICI' => $_SERVER['PHP_SELF'],
	'TITRE' => $langue['titre_module'],
	'TITRE_GESTION' => $langue['titre_module_gestion'],
	'TITRE_LISTE' => $langue['titre_module_list'],
	'ACTION' => $langue['action'],
	'TXT_ORDRE' => $langue['module_ordre'],
	'TXT_CHOISIR' => $langue['choisir'],
	'TXT_NOM' => $langue['nom_module'],
	'TXT_FICHIER' => $langue['fichier_mosule'],
	'TXT_POSITION' => $langue['position_module'],
	'TXT_DROITE' => $langue['module_droite'],
	'TXT_CENTRE' => $langue['module_centre'],
	'TXT_GAUCHE' => $langue['module_gauche'],
	'TXT_ETAT' => $langue['module_etat'],
	'TXT_ON' => $langue['module_on'],
	'TXT_OFF' => $langue['module_off'],	
	'ACTIVATION_ON' => (!empty($edit_module['etat']) && $edit_module['etat'] != 0 || empty($edit_module['etat']))? 'checked="checked"' : '',
	'DISABLED_G_D' => (empty($_POST['centre']))? '' : 'disabled="disebled"',
	'DISABLED_C' => (!empty($_POST['centre']))? '' : 'disabled="disebled"',
));
$sql = "SELECT id,nom,ordre,call_page,etat,place FROM ".$config['prefix']."modules ORDER BY `ordre` ASC";
if (! ($get = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste = $rsql->s_array($get))
{
	switch($liste['place'])
	{
		case 'gauche':
			$liste['place'] = 'liste_gauche';
		break;
		case 'droite':
			$liste['place'] = 'liste_droite';
		break;
		case 'centre':
			$liste['place'] = 'liste_centre';
		break;
		default:
			$liste['place'] = 'liste_gauche';
	}
	$template->assign_block_vars($liste['place'], array(
		'ID' => $liste['id'],
		'NOM' => $liste['nom'],
		'NUM' => $liste['ordre'],
		'ETAT' => ( $liste['etat'] == "0") ? $langue['module_off'] : $langue['module_on'],
		'CALL_PAGE' => $liste['call_page'],
		'SUPPRIMER' => $langue['supprimer'],
		'EDITER' => $langue['editer'],
	));
}
// liste des modules
$dir = "../modules";
// Ouvre un dossier bien connu, et liste tous les fichiers
if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		$get_nfo_module = 1;
		while (($file = readdir($dh)) !== false)
		{
			if($file != '..' && $file !='.' && $file !='')
			{ 
				include($root_path.'modules/'.$file);
				$select = ( !empty($edit_module['call_page']) && $file == $edit_module['call_page'] ) ? 'selected="selected"' : '';
				$template->assign_block_vars('liste_module', array(
					'VALEUR' => $file,
					'NOM' => ( !empty($nom) )? $nom : $file,
					'SELECTED' => $select
				));
				unset($nom,$central);
			}
		}
		closedir($dh);
	}
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>