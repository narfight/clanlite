<SCRIPT LANGUAGE="JavaScript">
<!--
function GetDomOffset( Obj, Prop ) {
	var iVal = 0;
	while (Obj && Obj.tagName != 'BODY') {
		eval('iVal += Obj.' + Prop + ';');
		Obj = Obj.offsetParent;
	}
	return iVal;
}

var img_actu = 0;
var step = 5;

function SurImage(e, id, minimum)
{
	var img = trouve(id); // div qui contient la barre de menu.
	img_actu = img;
	var x = (navigator.appName.substring(0,3) == "Net") ? e.pageX : event.x+document.body.scrollLeft;
	x -= GetDomOffset(img, 'offsetLeft');
	// Declaration d'un objet Image pour avoir la taille reel
	var reel = new Image();
	reel.src = img.src;
	var rapport_l_h = reel.height/reel.width;

	var millieu = img.width/2;
	var delta = millieu - x ;
	var A = (reel.width - minimum) / millieu;
	
	if (x <= millieu)
	{
		coef = A * x + minimum;
	}
	else
	{
		coef = -1 * A * (x-millieu) + reel.width;
	}
	window.status = "Coef:" + coef + " X:" + x + " Millieu:" + millieu + " Angle:" + A + "Min:" + minimum + " Vrais largeur:" + reel.width;

	img.width = coef;
	img.height = img.width * rapport_l_h;
}

function OrImage(id, minimum, action)
{
	var img = trouve(id); // div qui contient la barre de menu.
	if (action)
	{
		img_actu = 0;
	}
	else if (img_actu == img)
	{
		return;
	}
	
	// Declaration d'un objet Image pour avoir la taille reel
	var reel = new Image();
	reel.src = img.src;
	var rapport_l_h = reel.height/reel.width;

	if (img.width > minimum)
	{
		if ((img.width-minimum) < step)
		{
			img.width -= (img.width-minimum);
		}
		else
		{
			img.width -= step;
		}
		img.height = img.width * rapport_l_h;
		setTimeout("OrImage(\"" + id + "\"," + minimum + ", false);", 50);
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
		<div id="dock_{class.match.ID}">
			<!-- BEGIN map_list -->
			<div style="margin:5px;float:left"><span class="reponce">{class.match.map_list.NOM}</span><br /><img id="image_{class.match.map_list.ID}" src="{class.match.map_list.SRC}" alt="{class.match.map_list.NOM}" width="{class.match.map_list.TAILLE_WIDTH}" height="{class.match.map_list.TAILLE_HEIGHT}" onmousemove="SurImage(event, this.id, {class.match.map_list.TAILLE_WIDTH}, true)" onmouseout="OrImage(this.id, {class.match.map_list.TAILLE_WIDTH}, true)" /></div>
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