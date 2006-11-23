<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="ClanLite">
<head>
<link href="{PATH_ROOT}templates/DarkStar/Library/styles.css" rel="stylesheet" type="text/css" />
<link rel="SHORTCUT icon" href="{PATH_ROOT}templates/DarkStar/images/favicon.gif" />
<script type="text/javascript" src="{PATH_ROOT}templates/DarkStar/Library/lib.js"></script>
{HEAD}
<title>{TITRE_PAGE}</title>
</head>
<body>
<div id="flash_poper" class="flash_poper"></div>
<div class="cadre_largeur_admin"> 
  <div class="hautpage"> 
    <object type="application/x-shockwave-flash" width="898" height="84" data="{PATH_ROOT}templates/DarkStar/images/ban_head.swf"> 
      <param name="movie" value="{PATH_ROOT}templates/DarkStar/images/ban_head.swf" /> 
    </object> 
  </div> 
  <div class="menuliens"><a href="{PATH_ROOT}controle/die-cook.php?where={PATH_ROOT}admin.php">{LOGIN}</a> :: <a href="{PATH_ROOT}service/index_pri.php">{TITRE_GO_PUBLIQUE}</a> :: <a href="{PATH_ROOT}user/index.php">{TITRE_GO_INDEX}</a></div> 
<div class="colonne_gauche">
    <div class="module"> 
      <div class="module_titre">{TITRE_USER}</div> 
      <div class="module_cellule">
			<a href="{PATH_ROOT}user/edit-user.php">{EDITER_PROFIL}</a><br />
			<a href="{PATH_ROOT}service/membre_match.php">{MATCH}</a><br />
			<a href="{PATH_ROOT}service/liste-des-membres.php">{LISTE_MEMBRES}</a><br />
			<a href="{PATH_ROOT}service/entrainement.php">{ENTRAINEMENT}</a><br/>
			<a href="{PATH_ROOT}service/connecter.php">{CONNECTE}</a>
	</div> 
      <div class="module_foot"></div> 
    </div> 
<!-- BEGIN menu_admin -->
    <div class="module"> 
      <div class="module_titre">{menu_admin.TITRE_ADMIN}</div> 
      <div class="module_cellule">
	  		<a href="{PATH_ROOT}administration/config.php">{menu_admin.CONFIGURE}</a><br />
			<a href="{PATH_ROOT}administration/news.php">{menu_admin.NEWS}</a><br />
			<a href="{PATH_ROOT}administration/smilies.php">{menu_admin.SMILIE}</a><br />
			<a href="{PATH_ROOT}administration/alert.php">{menu_admin.ALERT}</a><br />
			<a href="{PATH_ROOT}administration/mp3.php">{menu_admin.MP3}</a><br/ >
			<a href="{PATH_ROOT}administration/entrainements.php">{menu_admin.ENTRAINEMENT}</a><br />
			<a href="{PATH_ROOT}administration/menu_boutton.php">{menu_admin.MENU_EDIT}</a><br />
			<a href="{PATH_ROOT}administration/game_serveur.php">{menu_admin.GAME_SERVEUR}</a><br />
			<a href="{PATH_ROOT}administration/mailiste.php">{menu_admin.MAILLINGLISTE}</a><br />
			<a href="{PATH_ROOT}administration/liens.php">{menu_admin.LIENS}</a><br />
			<a href="{PATH_ROOT}administration/section.php">{menu_admin.SECTION}</a><br />
			<a href="{PATH_ROOT}administration/equipe.php">{menu_admin.EQUIPE}</a><br />
			<!-- BEGIN grade -->
			<a href="{PATH_ROOT}administration/grades.php">{menu_admin.grade.GRADE}</a><br />
			<!-- END grade -->
			<a href="{PATH_ROOT}administration/download.php">{menu_admin.TELECHARGER}</a><br />
			<a href="{PATH_ROOT}administration/match.php">{menu_admin.MATCH}</a><br />
			<a href="{PATH_ROOT}administration/demande-match.php">{menu_admin.DEMANDE_MATCH}</a><br />
			<a href="{PATH_ROOT}administration/rapport.php">{menu_admin.RAPPORT_MATCH}</a><br />
			<a href="{PATH_ROOT}administration/server_map.php">{menu_admin.MAP_SERVEUR}</a>
	</div> 
    <div class="module_foot"></div> 
 </div> 
    <div class="module"> 
      <div class="module_titre">{menu_admin.TITRE_MODULE}</div> 
      <div class="module_cellule">
			<a href="{PATH_ROOT}administration/modules.php">{menu_admin.MODULE}</a><br />
			<!-- BEGIN list_module -->
			<a href="{menu_admin.list_module.URL}">{menu_admin.list_module.NOM}</a><br />
			<!-- END list_module -->
	</div> 
    <div class="module_foot"></div> 
 </div> 
			<!-- END menu_admin -->
</div>
<div class="colonne_central_admin">