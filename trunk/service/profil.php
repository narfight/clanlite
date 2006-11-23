<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_profil';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'profile.tpl'));
$sql = "SELECT user.*,user.nom AS user_nom, section.nom, equipe.nom AS equipe_nom, section.nom AS section_non, grade.nom AS grade_nom FROM ".$config['prefix']."user AS user LEFT JOIN ".$config['prefix']."section AS section ON section.id = user.section LEFT JOIN ".$config['prefix']."équipe as equipe ON equipe.id = user.equipe LEFT JOIN ".$config['prefix']."grades as grade ON grade.id = user.grade WHERE user.id = '".$_GET['link']."'";
if (! ($get_p = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
if ( ($profil = $rsql->s_array($get_p)) )
{
	$template->assign_vars(array( 
		'TITRE_PROFIL' =>  sprintf($langue['titre_profil'], $profil['user']),
		'ID' => $profil['id'],
		'NOM' => $profil['user_nom'],
		'TXT_NOM' => $langue['nom'],
		'LOGIN' => $profil['user'],
		'TXT_LOGIN' => $langue['login'], 
		'MAIL' => $profil['mail'],
		'TXT_MAIL' => $langue['e-mail'],
		'MSN' => $profil['im'],
		'TXT_MSN' => $langue['msn'],
		'POUVOIR' => $profil['pouvoir'],
		'TXT_POUVOIR' => $langue['pouvoirs'],
		'SEX' => $profil['sex'],
		'TXT_SEX' => $langue['sex'],
		'AGE' => floor((time()-$profil['age'])/31557600),
		'TXT_AGE' => $langue['age'],
		'WEB' => $profil['web'],
		'TXT_WEB' => $langue['site_web'],
		'TEXT' => $profil['cri'],
		'TXT_TEXT' => $langue['cri_guerre'],
		'LASTCONNECT' => date("j/n/Y", $profil['last_connect']),
		'TXT_LASTCONNECT' => $langue['last_connection'],
		'PRENOM' => $profil['prénom'],
		'TXT_PRENOM' => $langue['prenom'],
		'ARME' => $profil['armes_préférées'],
		'TXT_ARME' => $langue['favori_arme'],
		'ALT_ARME' => $langue['alt_arme'],
		'HISTOIRE' => $profil['histoire'],
		'TXT_HISTOIRE' => $langue['histoire'],
		'ROLES' => $profil['roles'],
		'TXT_ROLES' => $langue['roles'],
		'IMAGES' => $profil['images'],
		'ALT_IMAGE_PERSO' =>$langue['alt_profil_image'],
		'GRADE' => $profil['grade_nom'],
		'TXT_GRADE' => $langue['grade'],
		'SECTON' => $profil['section_non'],
		'TXT_SECTION' => $langue['section'],
		'EQUIPE' => $profil['equipe_nom'],
		'TXT_EQUIPE' => $langue['equipe'],
		'ALT_MEDAILLES' => $langue['alt_medaille']
	));
	// on fais l'entete du cadre
	// on affiche ou pas la medaille, si il a ou pas
	$medail=explode(",", $profil['medail']);
	$boucle = -1;
	$nombre_md = 0;
	while ($boucle <= 8)
	{
		$nombre_md++;
		$boucle++;
		if (!empty($medail[$boucle]))
		{
			$template->assign_block_vars('nombre_md_titre', array('NOMBRE_MD' => $nombre_md));
		}
	}
}
else
{
	msg('erreur', $langue['erreur_profil_no_found']);
}
$template->pparse('body');
include($root_path."conf/frame.php");
?>
