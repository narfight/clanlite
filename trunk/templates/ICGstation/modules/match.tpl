<!-- BEGIN match -->
	{TXT_DATE} : <span class="reponce">{DATE}</span><br />
	{TXT_HEURE} : <span class="reponce">{HEURE}</span><br />
	<span class="reponce">{SECTION}</span> VS <span class="reponce">{CONTRE}</span><br />
	<span class="reponce">{INFO}</span>
	{MAP}
	{LIENS_MEMBRES}
<!-- END match -->
<!-- BEGIN match_map -->
	<div id="module_match_{ID_MODULE}">
		<span id="nom_match_map_{ID_MODULE}">nom_map</span>
		<img id="img_match_map_{ID_MODULE}" href="{MAP_SRC}" style="opacity: 1.1;" onload="diapoTransitionOn(this.id, 0);" />
		<script type="text/javascript">
			<!--//--><![CDATA[//><!--
			var liste_map_{ID_MODULE} = Array();
			{MAP_LIST}		
			var dLoaded_{ID_MODULE} = 0;
			var lastdLoaded_{ID_MODULE} = -1;
			var rapport_taille_{ID_MODULE} = 1;
			
			function next_map_{ID_MODULE}(direction)
			{
				dLoaded_{ID_MODULE} += direction;
			
				if (dLoaded_{ID_MODULE} == lastdLoaded_{ID_MODULE})
					return;
				lastdLoaded_{ID_MODULE} = dLoaded_{ID_MODULE};
			
				if (dLoaded_{ID_MODULE} >= liste_map_{ID_MODULE}.length) dLoaded_{ID_MODULE} = 0;
				if (dLoaded_{ID_MODULE} < 0) dLoaded_{ID_MODULE} = liste_map_{ID_MODULE}.length - 1;
				var map_actuelle = liste_map_{ID_MODULE}[dLoaded_{ID_MODULE}];
				
				// calcul la nouvelle taille par rapport à la place dispo
				if (trouve('module_match_{ID_MODULE}').offsetWidth < map_actuelle[3])
				{
					rapport_taille = map_actuelle[3]/trouve('module_match_{ID_MODULE}').offsetWidth;
					//alert(rapport_taille);
					map_actuelle[2] = map_actuelle[2]/rapport_taille;
					map_actuelle[3] = map_actuelle[3]/rapport_taille;
				}
				
				diapoTransition('img_match_map_{ID_MODULE}', direction, map_actuelle[1], map_actuelle[2], map_actuelle[3], 100);
				trouve('nom_match_map_{ID_MODULE}').innerHTML = map_actuelle[0];
				return false;	
			}
			
			function boucle_{ID_MODULE}()
			{
				next_map_{ID_MODULE}(1);
				setTimeout("boucle_{ID_MODULE}();", 2500);
			}
			next_map_{ID_MODULE}(0);
			boucle_{ID_MODULE}();
		//--><!]]>
		</script>
	</div>
<!-- END match_map -->
<!-- BEGIN map_list -->
	liste_map_{ID_MODULE}.push(Array(
		"{TITRE}",
		"{NORM}",
		"{NORM_H}",
		"{NORM_L}"
	));
<!-- END map_list -->
<!-- BEGIN match_liens_membres -->
	<a href="{URL}">{TEXTE}</a>
<!-- END match_liens_membres -->
<!-- BEGIN match_config -->
<div class="big_cadre" id="simple">
	<h1>{match_config.TITRE}</h1>
	<form method="post" action="{match_config.ICI}" class="visible">
		<p>
			<span><label for="show_map">{match_config.TXT_SHOW_MAP}&nbsp;:</label></span>
			<span><input name="show_map" type="checkbox" id="show_map" value="1" {match_config.CHECK_SHOW_MAP} /></span>
	  <p>
		<span>
				<input name="id_module" type="hidden" id="id_module" value="{match_config.ID}" />
				<input name="Submit_match_config" type="submit" id="Editer" value="{match_config.EDITER}" />
		  </span>
		</p>
	</form>
</div>
<!-- END match_config -->