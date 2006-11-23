<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" href="{PATH_ROOT}templates/ICGstation/Library/styles.css" type="text/css" media="screen" />
		<link rel="shortcut icon" href="{PATH_ROOT}templates/ICGstation/images/favicon.gif" />
		<meta http-equiv="imagetoolbar" content="no" />
		<meta name="description" content="Portails des {NOM_CLAN}, vous pouvez leurs proposer un defi ou laisser un message sur leurs forum." />
		<meta name="keywords" content="jeux clan clanlite lite serveur match narfight portail map télécharger fichier skin liens news" />
		<link rel="alternate" type="application/rss+xml" title="{NEWS}" href="{PATH_ROOT}rss.php" />
		<script type="text/javascript" src="{PATH_ROOT}templates/ICGstation/Library/lib.js"></script>
		{HEAD}
		<title>ClanLite - {NOM_CLAN}</title>
	</head>
	<body> 
		<div class="cadre_largeur"> 
			<div id="flash_poper" class="flash_poper"></div> 
			<div class="hautpage"><img src="{PATH_ROOT}templates/ICGstation/images/banner.jpg" alt="logo" height="100" width="950" /></div> 
			<ul class="menuliens">
				<!-- BEGIN bouttons -->
				<li><a href="{bouttons.BOUTTON_U}" {bouttons.TARGET}>{bouttons.BOUTTON_L}</a> </li>
				<!-- END bouttons -->
				<!-- BEGIN connecter -->
				<li><a href="{connecter.LOGIN_U}">{connecter.LOGIN}</a></li>
				<!-- END connecter -->
				<li><a href="{B_PRIVE_U}" >{B_PRIVE}</a></li>
			</ul>
			<h1 class="navbar">{BIENVENU}</h1>
			<div class="end_head"></div>
			<!-- BEGIN popup -->
			<div class="cadre_alert">
				<h1>{popup.TITRE_ALERT}</h1>
				<div class="news">
					<ul> 
						<!-- BEGIN list --> 
						<li>{popup.list.TEXT}</li> 
						<!-- END list --> 
					</ul>
				</div>
			</div>
			<!-- END popup --> 
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