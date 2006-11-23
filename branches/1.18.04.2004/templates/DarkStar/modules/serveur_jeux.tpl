<!-- BEGIN serveur_jeux -->
	{TXT_IP} : <span class="reponce">{IP}</span><br />
	{TXT_CURRENT_MAP} : <span class="reponce">{CURRENT_MAP}</span><br />
	{TXT_NEXT_MAP} : <span class="reponce">{NEXT_MAP}</span><br />
	{TXT_PLACE} :<span class="reponce">{PLAYER}</span>/<span class="reponce">{PLACE}</span><br />
	{TXT_GAME_TYPE} :<span class="reponce">{GAME_TYPE}</span><br />
	Liste des joueurs :
		{LISTE}
<!-- END serveur_jeux -->
<!-- BEGIN serveur_jeux_boucle --> 
    <div class="{COLOR}">{NAME}</div>
<!-- END serveur_jeux_boucle --> 
<!-- BEGIN serveur_config -->
	<form method="post" action="serveur_jeux.php">
		<div class="big_cadre">
		<h1>{serveur_config.TITRE}</h1>
			<p>
				<span><label for="id_serveur">{serveur_config.TXT_SERVEUR}&nbsp;:</label></span>
				<span><select name="id_serveur" id="id_serveur" onBlur="formverif(this.id,'autre','')">
		    <option value="" >{serveur_config.CHOISIR}</option> 
			{serveur_config.LISTE}
		</select></span>
			</p>
			<p>
				<span>
					<input name="id_module" type="hidden" id="id_module" value="{serveur_config.ID}" />
					<input name="Submit_module" type="submit" id="Editer" value="{serveur_config.EDITER}" /> 
				</span>
			</p>
		</div>
	</form>
<!-- END serveur_config -->