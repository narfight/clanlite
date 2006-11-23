<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './';
header("Content-Type: text/xml\n");
$action_membre = 'where_rss';
include($root_path.'conf/template.php');
include($root_path.'conf/conf-php.php');

$sql = "SELECT id,date,titre FROM `".$config['prefix']."news` ORDER BY id DESC";
if (! ($list_news = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
// on commence la boucle pour les news
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n\n";
echo "<rdf:RDF\n";
echo "xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n";
echo "xmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n";
echo "xmlns=\"http://purl.org/rss/1.0/\">\n\n";
echo "	<channel>\n";
echo "		<title>".htmlspecialchars($config['nom_clan'])."</title>\n";
echo "		<link>".$config['site_domain'].$config['site_path']."</link>\n";
echo "		<description>L'actualité des ".$config['tag']."</description>\n";
echo "		<image>\n";
echo "			<title>".htmlspecialchars($config['nom_clan'])."</title>\n";
echo "			<url>".$config['site_domain'].$config['site_path']."images/logo_rss.gif</url>\n";
echo "			<link>".$config['site_domain'].$config['site_path']."</link>\n";
echo "		</image>\n";
while ( $recherche = $rsql->s_array($list_news) ) 
{	
	echo "		<item>\n";
	echo "			<title>".$recherche['titre']."</title>\n";
	echo "			<link>".$config['site_domain'].$config['site_path']."service/reaction.php?for=".$recherche['id']."</link>\n";
	echo "			<dc:date>".date("r",$recherche['date'])."</dc:date>\n";
	echo "		</item>\n";
}
echo "	</channel>\n";
echo "</rdf:RDF>\n";
?>