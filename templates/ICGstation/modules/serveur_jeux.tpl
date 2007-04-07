<!-- BEGIN serveur_jeux -->
	{IMAGE_MAP}
	{TXT_IP}: <span class="reponce"><a href="{JOINERURI}">{IP}</a></span><br />
	{TXT_CURRENT_MAP}: <span class="reponce">{CURRENT_MAP}</span><br />
	{TXT_NEXT_MAP}: <span class="reponce">{NEXT_MAP}</span><br />
	{TXT_PLACE}: <span class="reponce">{PLAYER}</span>/<span class="reponce">{PLACE}</span><br />
	{TXT_GAME_TYPE}: <span class="reponce">{GAME_TYPE}</span><br />
	{LISTE}
<!-- END serveur_jeux -->
<!-- BEGIN serveur_jeux_image_map -->
	<div id="module_serveur_jeux_{MODULE_ID}">
		<img src="{SRC}" id="map_serveur_act_{MODULE_ID}" alt="{ALT}" {TAILLE} />
		<script type="text/javascript">
			<!--//--><![CDATA[//><!--
			// calcul la nouvelle taille par rapport à la place dispo pour l'image de map
			if (trouve('module_serveur_jeux_{MODULE_ID}').offsetWidth < trouve('map_serveur_act_{MODULE_ID}').width)
			{
				rapport_taille_{MODULE_ID} = trouve('map_serveur_act_{MODULE_ID}').width/trouve('module_serveur_jeux_{MODULE_ID}').offsetWidth;
				//alert(rapport_taille);
				trouve('map_serveur_act_{MODULE_ID}').width = trouve('map_serveur_act_{MODULE_ID}').width/rapport_taille_{MODULE_ID};
				trouve('map_serveur_act_{MODULE_ID}').height = trouve('map_serveur_act_{MODULE_ID}').height/rapport_taille_{MODULE_ID};
			}
		//--><!]]>
		</script>
	</div>
<!-- END serveur_jeux_image_map -->
<!-- BEGIN total_liste -->
	{TXT_LISTE} :
<marquee height="100" scrollamount="1" scrolldelay="20" direction="up" onmouseover="this.scrollAmount=0" onmouseout="this.scrollAmount=1">
	{LISTE}
</marquee>
<!-- END total_liste -->
<!-- BEGIN serveur_jeux_boucle --> 
<div class="{COLOR}">{NAME}</div>
<!-- END serveur_jeux_boucle --> 
<!-- BEGIN serveur_config -->
	<div class="big_cadre" id="simple">
		<h1>{serveur_config.TITRE}</h1>
			<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="id_serveur">{serveur_config.TXT_SERVEUR}&nbsp;:</label></span>
				<span>
					<select name="id_serveur" id="id_serveur" onblur="formverif(this.id,'autre','')">
						<option value"" >{serveur_config.CHOISIR}</option> 
						{serveur_config.LISTE}
					</select>
				</span>
			</p>
			<p>
				<span><label for="liste">{serveur_config.TXT_LISTE}&nbsp;:</label></span>
				<span><input name="liste" id="liste" type="checkbox" value="true" {serveur_config.LISTE_CHECKED} /></span>
			</p>
			<p>
				<span><label for="image">{serveur_config.TXT_IMAGE}&nbsp;:</label></span>
				<span><input name="image" id="image" type="checkbox" value="true" {serveur_config.IMAGE_CHECKED} /></span>
			</p>
			<p>
				<span>
					<input name="id_module" type="hidden" id="id_module" value="{serveur_config.ID}" />
					<input name="Submit_module" type="submit" id="Editer" value="{serveur_config.EDITER}" /> 
				</span>
			</p>
		</form>
	</div>
<!-- END serveur_config -->