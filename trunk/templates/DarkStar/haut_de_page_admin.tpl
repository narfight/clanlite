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
			<div class="menuliens"><a href="{LOGIN_U}">{LOGIN}</a> :: <a href="{TITRE_GO_PUBLIQUE_U}">{TITRE_GO_PUBLIQUE}</a> :: <a href="{TITRE_GO_INDEX_U}">{TITRE_GO_INDEX}</a></div> 
<div class="colonne_gauche">
	<div class="module"> 
		<div class="module_titre">{TITRE_USER}</div> 
		<div class="module_cellule">
							<a href="{EDITER_PROFIL_U}">{EDITER_PROFIL}</a><br />
							<a href="{MATCH_U}">{MATCH}</a><br />
							<a href="{LISTE_MEMBRES_U}">{LISTE_MEMBRES}</a><br />
							<a href="{ENTRAINEMENT_U}">{ENTRAINEMENT}</a><br/>
							<a href="{CONNECTE_U}">{CONNECTE}</a>
		</div> 
      <div class="module_foot"></div> 
    </div> 
<!-- BEGIN menu_admin -->
    <div class="module"> 
      <div class="module_titre">{menu_admin.TITRE_ADMIN}</div> 
      <div class="module_cellule">
						<a href="{menu_admin.CONFIGURE_U}">{menu_admin.CONFIGURE}</a><br />
						<a href="{menu_admin.NEWS_U}">{menu_admin.NEWS}</a><br />
						<a href="{menu_admin.SMILIE_U}">{menu_admin.SMILIE}</a><br />
						<a href="{menu_admin.ALERT_U}">{menu_admin.ALERT}</a><br />
						<a href="{menu_admin.MP3_U}">{menu_admin.MP3}</a><br/ >
						<a href="{menu_admin.ENTRAINEMENT_U}">{menu_admin.ENTRAINEMENT}</a><br />
						<a href="{menu_admin.MENU_EDIT_U}">{menu_admin.MENU_EDIT}</a><br />
						<a href="{menu_admin.GAME_SERVEUR_U}">{menu_admin.GAME_SERVEUR}</a><br />
						<a href="{menu_admin.MAILLINGLISTE_U}">{menu_admin.MAILLINGLISTE}</a><br />
						<a href="{menu_admin.LIENS_U}">{menu_admin.LIENS}</a><br />
						<a href="{menu_admin.SECTION_U}">{menu_admin.SECTION}</a><br />
						<a href="{menu_admin.EQUIPE_U}">{menu_admin.EQUIPE}</a><br />
						<!-- BEGIN grade -->
						<a href="{menu_admin.grade.GRADE_U}">{menu_admin.grade.GRADE}</a><br />
						<!-- END grade -->
						<a href="{menu_admin.TELECHARGER_U}">{menu_admin.TELECHARGER}</a><br />
						<a href="{menu_admin.MATCH_U}">{menu_admin.MATCH}</a><br />
						<a href="{menu_admin.DEMANDE_MATCH_U}">{menu_admin.DEMANDE_MATCH}</a><br />
						<a href="{menu_admin.RAPPORT_MATCH_U}">{menu_admin.RAPPORT_MATCH}</a><br />
						<a href="{menu_admin.MAP_SERVEUR_U}">{menu_admin.MAP_SERVEUR}</a>
	</div> 
    <div class="module_foot"></div> 
 </div> 
    <div class="module"> 
      <div class="module_titre">{menu_admin.TITRE_MODULE}</div> 
      <div class="module_cellule">
						<a href="{menu_admin.MODULE_U}">{menu_admin.MODULE}</a><br />
						<!-- BEGIN list_module -->
						<a href="{menu_admin.list_module.URL}">{menu_admin.list_module.NOM}</a><br />
						<!-- END list_module -->
	</div> 
    <div class="module_foot"></div> 
 </div> 
			<!-- END menu_admin -->
</div>
<div class="colonne_central_admin">