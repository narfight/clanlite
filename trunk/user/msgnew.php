<?
define('CL_AUTH', true);
$root_path = './../';
$action_membre = 'where_lire_news_nfo';
require($root_path.'conf/template.php');
require($root_path.'conf/conf-php.php');
require($root_path.'conf/frame.php');
$template->set_filenames(array('body' => 'divers_text.tpl'));
$template->assign_vars(array(
	'TITRE' => $langue['titre_lire_news_nfo'],
	'TEXTE' => (empty($config['msg_bienvenu']))? $langue['text_bienvenu_vide'] : bbcode($config['msg_bienvenu']),
));
$template->pparse('body');
require($root_path.'conf/frame.php');
?>