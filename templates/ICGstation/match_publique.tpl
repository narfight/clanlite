<SCRIPT LANGUAGE="JavaScript">
<!--

MIN = 80 ;  // largeur minimum en pixel
MAX = MIN*3 ; // largeur maximum en pixel
REACTION = 1.2 ; // réaction des icons par rapport à la souris. plus grand --> plus d'icons qui réagissent

A = ((MIN-MAX)/(MAX * REACTION)) ; // coef directeur de la droite d'agrandissement
img_tags = new Array();
img_rapport = new Array();

function ouEstMaSouris(e, id)
{
	var dock = trouve(id); // div qui contient la barre de menu.

	var x = (navigator.appName.substring(0,3) == "Net") ? e.pageX : event.x+document.body.scrollLeft;
		
	x -= dock.offsetLeft ; // on modifie la coordonnée pour quelle soit relatif au div et non à la fenetre.
	
	img_tags = dock.getElementsByTagName('img') ; // les images contenus dans le div
	for(i=0 ; i<img_tags.length ; i++) // pour chaque images
	{
		millieu = img_tags[i].offsetLeft - parseInt(img_tags[i].width)/2 ;
		delta = millieu - x ;

		if (img_rapport[i] == undefined)
		{
			img_rapport[i] = img_tags[i].height/img_tags[i].width;
		}
		
		if (delta < 0)
		{
			delta *= -1;
		}
		
		coef = A * delta + MAX ;

		if (coef < MIN)
		{
			coef = MIN ;
		}
		else if (coef > MAX)
		{
			coef = MAX ;
		}

		img_tags[i].width = coef;
		img_tags[i].height = img_tags[i].width * img_rapport[i];
	}
}

//-->
</SCRIPT>
<div class="big_cadre">
	<h1>{TITRE_MATCH}</h1>
	<div class="news">
	<!-- BEGIN class -->
	<h2>{class.TITRE}</h2>
	<!-- BEGIN match -->
	<form method="post" action="{ICI}"> 
		<h2 class="toggle_titre">
			<input value="{VOIR}" name="voir_{class.match.FOR}" type="button" onClick="toggle('{class.match.FOR}')">&nbsp;&nbsp;{class.match.CONTRE} {class.match.CLAN}
			<!-- BEGIN liens_membres -->
			<a href="{class.match.liens_membres.URL}">{class.match.liens_membres.TEXTE}</a>
			<!-- END liens_membres -->
		</h2>
	</form> 
	<div id="toggle_{class.match.FOR}" style="display:none">
		<p>
			<span class="nom_liste">{TXT_DATE} :</span>
			<span class="reponce">{class.match.DATE}</span>
		</p>
		<p>
			<span class="nom_liste">{TXT_HEURE} :</span>
			<span class="reponce">{class.match.HEURE}</span>
		</p>
		<p>
			<span class="nom_liste">{TXT_NBR_JOUEUR} :</span>
			<span class="reponce">{class.match.SUR}</span>
		</p>
		<p>
			<span class="nom_liste">{TXT_MAP} :</span>
			<div class="reponce"><br /></div>
		</p>
		<div id="dock_{class.match.ID}" onmousemove="ouEstMaSouris(event, this.id)">
			<!-- BEGIN map_list -->
			<div style="margin:5px;float:left"><span class="reponce">{class.match.map_list.NOM}</span><br /><img src="{class.match.map_list.SRC}" alt="{class.match.map_list.NOM}" width="{class.match.map_list.TAILLE_WIDTH}" height="{class.match.map_list.TAILLE_HEIGHT}" /></div>
			<!-- END map_list -->
		</div>
		<p>
			<span class="nom_liste">{VOIR} :</span>
			<span class="reponce">{class.match.INFO}</span>
		</p>
	  </div>
	<!-- END match -->
	<!-- END class -->
	<!-- BEGIN no_match -->
	{no_match.TXT}
	<!-- END no_match -->
	</div>
</div>