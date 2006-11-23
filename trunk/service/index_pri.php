<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './../';
$action_membre = 'where_news';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
$template = new Template($root_path."templates/".$config['skin']);
$template->set_filenames( array('body' => 'accueil_centre.tpl'));
// on prend le nombre de news pour les news/page
$HTTP_GET_VARS['limite'] = (empty($HTTP_GET_VARS['limite']))? 0 : $HTTP_GET_VARS['limite'];
$total = get_nbr_objet("news", "");
$sql = "SELECT news.*, COUNT(reaction.id_news) FROM `".$config['prefix']."news` AS news LEFT JOIN ".$config['prefix']."reaction_news AS reaction ON news.id = reaction.id_news  GROUP BY news.id ORDER BY news.id DESC LIMIT ".$HTTP_GET_VARS['limite'].",".$config['objet_par_page'];
if (! ($list_news = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
// on commence la boucle pour les news
$template->assign_vars( array( 
	'TITRE_NEWS' => $langue['news_titre'],
	'POSTE_LE' => $langue['poste_le'],
	'PAR' => $langue['poste_par'],
));
while ( $recherche = $rsql->s_array($list_news) ) 
{	
	switch($recherche['COUNT(reaction.id_news)'])
	{
		case 0:
			$reaction = $langue['0_reaction'];
		break;
		case 1:
			$reaction = $langue['1_reaction'];
		break;
		default:
			$reaction = sprintf($langue['plus_reaction'], $recherche['COUNT(reaction.id_news)']);
		break;
	}
	$template->assign_block_vars('news', array( 
		'BY' => $recherche['user'],
		'COMMENTAIRE' => $reaction,
		'DATE'  => date("j/n/y H:i", $recherche['date']),
		'FOR' => $recherche['id'],
		'TEXT' => nl2br(bbcode($recherche['info'])),
		'TITRE' => $recherche['titre']
	));
}
displayNextPreviousButtons($HTTP_GET_VARS['limite'],$total,"multi_page");
$template->pparse('body');
include($root_path."conf/frame.php");
?>