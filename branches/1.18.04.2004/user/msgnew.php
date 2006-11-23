<?
$root_path = './../';
$action_membre = 'where_lire_news_nfo';
include($root_path."conf/template.php");
include($root_path."conf/conf-php.php");
include($root_path."conf/frame.php");
$template->set_filenames(array('body' => 'divers_text.tpl'));
$template->assign_vars(array(
	'TITRE' => $langue['titre_lire_news_nfo'],
	'TEXTE' => (empty($config['msg_bienvenu']))? $langue['text_bienvenu_vide'] : nl2br(bbcode($config['msg_bienvenu'])),
));
$template->pparse('body');
include($root_path."conf/frame.php");
?>