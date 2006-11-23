<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre= 'where_entree_user';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."controle/cook.php");
include($root_path."conf/frame_admin.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'info_priver.tpl'));
//on releve tout les match que le joueur peux voir
$sql = "SELECT game.*, COUNT(inscription.id_match) FROM ".$config['prefix']."match AS game LEFT JOIN ".$config['prefix']."match_inscription AS inscription ON game.id = inscription.id_match AND inscription.statu = 'ok' WHERE section = '".$session_cl['section']."' OR section = '0' GROUP BY inscription.id_match ORDER BY `date` DESC";
if (! ($get_match = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
$nombre = "";
$template->assign_vars(array( 
	'TITRE' =>  $langue['titre_entree_user'],
));
while ($match = $rsql->s_array($get_match)) 
{ 
	// on regarde si ils sont pas plien
	if ($match['COUNT(inscription.id_match)'] < $match['nombre_de_joueur'])
	{
		$nombre++;
		// si c'est la 1er ligne on afficher l'entete du tableau
		if ($nombre == 1) 
		{
			$template->assign_block_vars('entete_match', array(
				'MATCH_PLACE' => $langue['user_match_place'],
			));
		} 
		$template->assign_block_vars('cadre_match', array( 
          'MATCH_DISPO' => sprintf($langue['info_match_place'], $match['le_clan'], date("j/n/Y", $match['date']), date("H:i", $match['date'])),
		));
	}
}
// on prend les entrainement
$sql = "SELECT * FROM ".$config['prefix']."entrainement ORDER BY `date` ASC LIMIT 1";
if (! ($get_entrainement = $rsql->requete_sql($sql)) )
{
	sql_error($sql ,mysql_error(), __LINE__, __FILE__);
}
while ($entrainement = $rsql->s_array($get_entrainement)) 
{
	$template->assign_block_vars('entrainement', array( 
		'ENTRAI_PLACE' => $langue['user_entrainement_place'],
		'DATE' =>  date("j/n/Y", $entrainement['date']),
		'TXT_DATE' => $langue['date_entrai'],
		'HEURE' => date("H:i", $entrainement['date']),
		'TXT_HEURE' => $langue['heure_entrai'],
		'INFO' => nl2br(bbcode($entrainement['info'])),
		'TXT_INFO' => $langue['info_entrai'],
		'INFO_PV' => nl2br(bbcode($entrainement['priver'])),
		'TXT_INFO_PV' => $langue['info_prive_entrai']
	 ));
}
// partie admin du script
if ($user_pouvoir['particulier'] == "admin")
{	// on vérifie si il a une derniére version en ligne
	$var = "http://www.europubliweb.com/born-to-up/serveur_central/com.php";
	$file = @fopen($var, "r");
	if ($file)
	{ // le site est en ligne donc on peux envoyer la demande
		$reponce = file ($var."?get_version=oui");
		if ($reponce[0] != "problem")
		{
			$version_local = explode(".", $config['version']);
			$version_distant = explode(".", $reponce[0]);
			$version_local_time = mktime(0, 0, 0, $version_local[2], $version_local[1], $version_local[3]);
			$version_distant_time = mktime(0, 0, 0, $version_distant[2], $version_distant[1], $version_distant[3]);
			if ( $version_distant_time > $version_local_time  && $version_local[0] <= $version_distant[0])
			{
				msg('info', sprintf($langue['admin_news_cl'], $config['version'], $reponce[0]));
			}
		}
	}	
	$sql = "SELECT id FROM `".$config['prefix']."match`";
	if (! ($get_nbr_match = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$sql = "SELECT id FROM `".$config['prefix']."match_demande`";
	if (! ($get_nbr_demande_match = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$template->assign_block_vars('admin', array(
		'TITRE' => $langue['titre_entree_admin'],
		'INFO_ADMIN' => $langue['admin_divers_nfo'],
		'INFO_ADMIN_MEMBRE' => $langue['admin_user_nfo'],
		'NOMBRE_USER' => $config['nbr_membre'],
		'TXT_NOMBRE_USER' => $langue['admin_nombre_membre'],
		'NOMBRE_MATCH' => $rsql->nbr($get_nbr_match),
		'TXT_NOMBRE_MATCH' => $langue['admin_nombre_match'],
		'NOMBRE_DEMANDE_MATCH' => $rsql->nbr($get_nbr_demande_match),
		'TXT_NOMBRE_DEMANDE_MATCH' => $langue['admin_nombre_demande_match'],
		'SEX_NOM' => $langue['nom/sex'],
		'SECTION' => $langue['section'],
		'EQUIPE' => $langue['equipe'],
		'POUVOIR' => $langue['pouvoirs'],
		'PROFIL' => $langue['profil'],
	));
	// on regarde les membres sans equipe ou section
	$sql = "SELECT id,user,sex,equipe,section,pouvoir FROM ".$config['prefix']."user WHERE equipe = '' OR section = '' OR pouvoir = 'news'";
	if (! ($get_vide = $rsql->requete_sql($sql)) )
	{
		sql_error($sql ,mysql_error(), __LINE__, __FILE__);
	}
	$nombre = 0;
	$template->assign_block_vars('cadre_nul', 'vide');
	while ($liste_membre = $rsql->s_array($get_vide))
	{
		$nombre++;
		$template->assign_block_vars('admin.nul_part', array(
			'ID' => $liste_membre['id'],
			'NOM' => $liste_membre['user'],
			'SEX' => ( $liste_membre['sex'] == "Femme") ? "femme" : "homme",
			'EQUIPE' => ( empty($liste_membre['equipe'])  &&  $liste_membre['equipe'] !== 0) ? $langue['user_verif'] : $langue['user_ok'],
			'SECTION' => ( empty($liste_membre['section']) &&  $liste_membre['section'] !== 0) ? $langue['user_verif'] : $langue['user_ok'],
			'PV' => ( $liste_membre['pouvoir'] == "news" ) ? $langue['user_verif'] : $langue['user_ok'],
			'BT_EDITER' => $langue['editer'],
		));
	}
}
$template->pparse('body');
include($root_path."conf/frame_admin.php");
?>