<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	var k = Array();
	
	<!-- BEGIN liste -->
	k.push(Array(
		"{liste.TITRE}",
		"{liste.NORM}",
		"{liste.MIN}"
	));
	<!-- END liste -->
		
	var dLoaded = 0;
	var lastdLoaded = -1;
	function diapo(direction)
	{
		var c = document.getElementById('currentImage');
		var p = document.getElementById('previousImage');
		var n = document.getElementById('nextImage');
		var d = document.getElementById('description');
	
		dLoaded += direction;
	
		if (dLoaded == lastdLoaded)
			return;
		lastdLoaded = dLoaded;
	
		// ------------------------------------------------------------
		// le courrant
		if (dLoaded >= k.length) dLoaded = 0;
		if (dLoaded < 0) dLoaded = k.length - 1;
		var ci = k[dLoaded];
		diapoTransition('currentImage', direction, ci[1], 100);
	
		trouve('titre_img').innerHTML = ci[0];
		//document.getElementById('lien').href = '/kits/version-v-' + ci[3] + '.html';
	
		// ------------------------------------------------------------
		// le suivant
		if (dLoaded == k.length - 1)
			var ni = k[0];
		else
			var ni = k[dLoaded + 1];
	
		diapoTransition('nextImage', direction, ni[2], 100);
		
	
		// ------------------------------------------------------------
		// le précédent
		if (dLoaded == 0)
			var pi = k[k.length - 1];
		else
			var pi = k[dLoaded - 1];
	
		diapoTransition('previousImage', direction, pi[2], 100);
	
		return false;	
	}
	
	
	function diapoTransition(obj, direction, image, alpha)
	{
		if (direction == 0)
		{
			if (document.all)
				document.getElementById(obj).style['filter']		= 'alpha(opacity=0)';
			else
				document.getElementById(obj).style.opacity = 0;
				
			document.getElementById(obj).src = image;
			return;
		}
		
		if (document.all)
			document.getElementById(obj).style['filter']		= 'alpha(opacity=' + (alpha - 20) + ')';
		else
			document.getElementById(obj).style.opacity = (alpha - 20) / 100;
		/*if (direction == -1)
			document.getElementById(obj).style.marginLeft = '-' + alpha + 'px';
		else if (direction == 1)
			document.getElementById(obj).style.marginLeft = '-' + (100-alpha) + 'px';*/
			
			
		if (alpha > 0)
			setTimeout("diapoTransition('" + obj + "', '" + direction + "', '" + image + "', " + (alpha - 20) + ");", 10);
		else
		{
			//document.getElementById(obj).style.marginLeft = '0px';
			document.getElementById(obj).src = image;
		}
	}
	
	
	function diapoTransitionOn(obj, alpha)
	{
			if (document.all)
				document.getElementById(obj).style['filter']		= 'alpha(opacity=' + (alpha + 10) + ')';
			else
				document.getElementById(obj).style.opacity = (alpha + 10) / 100;	
			
			
		if (alpha < 100)
			setTimeout("diapoTransitionOn('" + obj + "', " + (alpha + 10) + ");", 10);
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
					<td width="33%"><img style="opacity: 1.1;" id="currentImage" src="{SRC}" onload="diapoTransitionOn(this.id, 0);" /></td>
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
