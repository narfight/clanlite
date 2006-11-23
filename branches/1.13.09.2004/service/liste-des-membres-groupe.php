<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_membre_group';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');
// liste des sections
$sql = "SELECT user.id AS user_id, section.nom AS section_nom, equipe.nom AS equipe_nom, grade.nom AS grade_nom, user.user, user.sex, user.im, user.roles FROM ".$config['prefix']."user AS user LEFT  JOIN ".$config['prefix']."équipe AS equipe ON user.equipe = equipe.id LEFT  JOIN ".$config['prefix']."section AS section ON user.section= section.id LEFT JOIN ".$config['prefix']."grades AS grade ON grade.id = user.grade WHERE section.visible = 1 OR user.section = '' ORDER BY grade.ordre DESC";
if (! ($nfo_user_liste = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($get_liste = $rsql->s_array($nfo_user_liste))
{
	$liste_group[(!empty($get_liste['section_nom']))? $get_liste['section_nom'] : $langue['no_section']][(!empty($get_liste['equipe_nom']))? $get_liste['equipe_nom'] : $langue['no_equipe']][$get_liste['user_id']] = $get_liste;
}
include($root_path.'conf/frame.php');
$template = new Template($root_path.'templates/'.$config['skin']);
$template->set_filenames( array('body' => 'membre_group.tpl'));
$template->assign_vars(array( 
	'ROLE' => $langue['role'],
	'NOM_SEX' => $langue['nom/sex'],
	'MSN' => $langue['msn'],
	'PROFIL' => $langue['profil'],
	'ALT_MSN' => $langue['alt_msn'],
	'ALT_PROFIL' => $langue['alt_profil'],
	'DEF_EQUIPE' => $langue['def_equipe'],
));
foreach($liste_group as $nom_section => $array_section)
{// fait la liste des section
	$template->assign_block_vars('cadre', array('NOM_SECTION' => $nom_section));
	if ($config['show_grade'] == 1)
	{
		$template->assign_block_vars('cadre.grade', array('GRADE' => $langue['grade']));
	}
	foreach($array_section as $nom_equipe => $array_equipe)
	{//fait la liste des equipes
		$template->assign_block_vars('cadre.total', array('NOM_EQUIPE' => $nom_equipe));
		if ($config['show_grade'] == 1)
		{
			$template->assign_block_vars('cadre.total.grade', array('vide'));
		}
		else
		{
			$template->assign_block_vars('cadre.total.no_grade', array('vide'));
		}
		foreach($array_equipe as $liste_user => $array_user)
		{// fait la liste des membres dans l'equipe
			$template->assign_block_vars('cadre.total.listage', array(
				'NOM' => $array_user['user'],
				'ID' => $array_user['user_id'],
				'SEX' => ($array_user['sex'] == 'Femme')? 'femme' : 'homme',
				'ROLE' => $array_user['roles'],
				'IM' => $array_user['im']
			));
			if ($config['show_grade'] == 1)
			{
				$template->assign_block_vars('cadre.total.listage.grade', array('GRADE' => $array_user['grade_nom']));
			}
		}
	}
}
// on en profite pour faire la définition
$sql = "SELECT * FROM ".$config['prefix']."équipe";
if (! ($equipe = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
while ($liste_équipe = $rsql->s_array($equipe))
{
	$template->assign_block_vars('info', array(
		'NOM' => $liste_équipe['nom'],
		'DETAIL' => $liste_équipe['détail']
	));
}
$template->pparse('body');
include($root_path.'conf/frame.php'); 
?>