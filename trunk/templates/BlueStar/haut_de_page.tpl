<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="ClanLite">
<head>
<link rel="stylesheet" href="{PATH_ROOT}templates/BlueStar/Library/styles.css" type="text/css" media="screen" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="description" content="Portails des {NOM_CLAN}, vous pouvez leurs proposer un defi ou laisser un message sur leurs forum." />
<meta name="keywords" content="jeux clan clanlite lite serveur match narfight portail map télécharger fichier skin liens news" />
<script type="text/javascript" src="{PATH_ROOT}templates/BlueStar/Library/lib.js"></script>
{HEAD}
<!--
&texte={NOM_CLAN}
-->
<title>ClanLite - {NOM_CLAN}</title>
</head><body> 
<div class="cadre_largeur"> 
  <div id="flash_poper" class="flash_poper"></div> 
  <div class="hautpage"> 
    <object type="application/x-shockwave-flash" width="898" height="84" data="{PATH_ROOT}templates/BlueStar/images/ban_head.swf"> 
      <param name="movie" value="{PATH_ROOT}templates/BlueStar/images/ban_head.swf" /> 
    </object> 
  </div> 
  <div class="menuliens"><a href="{PATH_ROOT}service/index_pri.php">{B_NEWS}</a> :: <a href="{PATH_ROOT}service/liste-des-membres-groupe.php">{B_MEMBRE_GROUP}</a> :: <a href="{URL_FORUM}" onclick="window.open('{URL_FORUM}');return false;">{B_FORUM}</a> :: 
  	<!-- BEGIN inscription -->
	<a href="{PATH_ROOT}user/new-user.php">{inscription.B_INSCRIPTION}</a> ::
	<!-- END inscription -->
	<a href="{PATH_ROOT}service/match.php">{B_MATCH}</a> :: <a href="{PATH_ROOT}service/calendrier.php">{B_CALENDRIER}</a> :: <a href="{PATH_ROOT}service/reglement.php">{B_REGLEMENT}</a> :: <a href="{PATH_ROOT}service/rapport_match.php">{B_RESULT_MATCH}</a> :: <a href="{PATH_ROOT}service/download.php">{B_TELECHARGER}</a> ::
    <!-- BEGIN connecter --> 
    <a href="{connecter.LOGIN_URL}">{connecter.LOGIN}</a> ::
    <!-- END connecter --> 
    <a href="{PATH_ROOT}admin.php" >{B_PRIVE}</a> ::
    <!-- BEGIN serveur --> 
    <a href="{PATH_ROOT}service/serveur.php">{serveur.B_SERVEUR_T}</a> ::
    <!-- END serveur --> 
    <!-- BEGIN liste_jeux --> 
    <a href="{PATH_ROOT}service/serveur_game_list.php">{liste_jeux.B_LISTE_SERVEUR_GAME}</a> ::
    <!-- END liste_jeux --> 
    <a href="{PATH_ROOT}service/liens.php">{B_LIENS}</a> :: <a href="{PATH_ROOT}service/defier.php">{B_ORG_RENCONTRE}</a> 
    <!-- BEGIN bouttons --> 
    :: <a href="{bouttons.BOUTTON_U}" {bouttons.TARGET}>{bouttons.BOUTTON_L}</a> 
    <!-- END bouttons --> 
  </div> 
<!-- BEGIN popup -->
<div class="cadre_alert">
	<div class="alert_visible">{popup.TITRE_ALERT}</div>
   <ul> 
      <!-- BEGIN list --> 
      <li>{popup.list.TEXT}</li> 
      <!-- END list --> 
    </ul> 
</div>
<!-- END popup --> 
<div class="end_head"></div>
<div class="colonne_gauche"> 
    <!-- BEGIN modules_gauche --> 
    <div class="module"> 
      <div class="module_titre">{modules_gauche.TITRE}</div> 
      <div class="module_cellule">{modules_gauche.IN}</div> 
      <div class="module_foot"></div> 
    </div> 
    <!-- END modules_gauche --> 
  </div> 
  <div class="colonne_central">