<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="{PATH_ROOT}templates/DarkStar/Library/styles.css" type="text/css" media="screen" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="description" content="Portails des {NOM_CLAN}, vous pouvez leurs proposer un defi ou laisser un message sur leurs forum." />
<meta name="keywords" content="jeux clan clanlite lite serveur match narfight portail map télécharger fichier skin liens news" />
<script type="text/javascript" src="{PATH_ROOT}templates/DarkStar/Library/lib.js"></script>
{HEAD}
<title>ClanLite - {NOM_CLAN}</title>
</head><body>
<div class="cadre_largeur">
  <div id="flash_poper" class="flash_poper"></div>
  <div class="hautpage">
    <object type="application/x-shockwave-flash" width="898" height="84" data="{PATH_ROOT}templates/DarkStar/images/ban_head.swf">
      <param name="movie" value="{PATH_ROOT}templates/DarkStar/images/ban_head.swf" />
    </object>
  </div>
  <ul class="menuliens">
    <!-- BEGIN bouttons -->
    <li><a href="{bouttons.BOUTTON_U}" {bouttons.TARGET}>{bouttons.BOUTTON_L}</a> </li>
    <!-- END bouttons -->
    <!-- BEGIN connecter -->
    <li><a href="{connecter.LOGIN_URL}">{connecter.LOGIN}</a></li>
    <!-- END connecter -->
    <li><a href="{PATH_ROOT}admin.php" >{B_PRIVE}</a></li>
  </ul>
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