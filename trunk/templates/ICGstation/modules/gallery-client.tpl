<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	var k = Array();
	
	<!-- BEGIN liste -->
	k.push(Array(
		"{liste.TITRE}",
		"{liste.NORM}",
		"{liste.MIN}",
		"{liste.NORM_H}",
		"{liste.NORM_L}"
	));
	<!-- END liste -->
		
	var dLoaded = 0;
	var lastdLoaded = -1;
	function diapo(direction)
	{
		dLoaded += direction;
	
		if (dLoaded == lastdLoaded)
			return;
		lastdLoaded = dLoaded;
	
		// ------------------------------------------------------------
		// le courrant
		if (dLoaded >= k.length) dLoaded = 0;
		if (dLoaded < 0) dLoaded = k.length - 1;
		var ci = k[dLoaded];
		diapoTransition('currentImage', direction, ci[1], ci[3], ci[4], 100);
	
		trouve('titre_img').innerHTML = ci[0];
		trouve('url_currentImage').href = ci[1];
		
	
		// ------------------------------------------------------------
		// le suivant
		if (dLoaded == k.length - 1)
			var ni = k[0];
		else
			var ni = k[dLoaded + 1];
	
		diapoTransition('nextImage', direction, ni[2], 0, 0, 100);
		
	
		// ------------------------------------------------------------
		// le précédent
		if (dLoaded == 0)
			var pi = k[k.length - 1];
		else
			var pi = k[dLoaded - 1];
	
		diapoTransition('previousImage', direction, pi[2], 0, 0, 100);
	
		return false;	
	}
//--><!]]>
</script>
<div class="big_cadre" id="simple">
	<h1>{TITRE}</h1>
	<div class="news">
		<table class="table">
			<thead>
				<tr>
					<th colspan="3" id="titre_img">{COM_IMG}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="33%"><a href="#" onClick="return diapo(-1);"><img style="opacity: 1.1;" id="previousImage" src="{SRC_MIN_1}" onload="diapoTransitionOn(this.id, 0);" /></a></td>
					<td width="33%"><a href="{SRC}" id="url_currentImage"><img style="opacity: 1.1;" id="currentImage" width="{WIDTH}" height="{HEIGHT}" src="{SRC}" onload="diapoTransitionOn(this.id, 0);" /></a></td>
					<td width="33%"><a href="#" onClick="return diapo(1);"><img style="opacity: 1.1;" id="nextImage" src="{SRC_MIN_2}" onload="diapoTransitionOn(this.id, 0);" /></a></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
	diapo(0);
//--><!]]>
</script>
