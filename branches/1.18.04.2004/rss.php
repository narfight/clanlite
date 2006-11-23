<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
$root_path = './';
$action_membre = "Utilise le system de News RSS";
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");

$sql = "SELECT date,titre FROM `".$config['prefix']."news` ORDER BY id DESC";
if (! ($list_news = $rsql->requete_sql($sql)) )
{
	sql_error($sql, $rsql->error, __LINE__, __FILE__);
}
// on commence la boucle pour les news
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
<rdf:RDF
xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
xmlns=\"http://purl.org/rss/1.0/\">
<channel>
 <title>".$config['nom_clan']."</title>
 <link>http://".$config['site']."/</link>
 <description>L'actualité des ".$config['tag']."</description>
</channel>
<image>
 <title>".$config['nom_clan']."</title>
 <url>".$config['site_domain'].$config['site_path']."/images/logo_rss.gif</url>
 <link>".$config['site_domain'].$config['site_path']."</link>
</image>";
while ( $recherche = $rsql->s_array($list_news) ) 
{	
echo"<item>
 <title>".$recherche['titre']."</title> 
 <link>".$config['site_domain'].$config['site_path']."</link> 
 <dc:date>".date("r",$recherche['date'])."</dc:date> 
</item>";
}
echo "</rdf:RDF>";
?>