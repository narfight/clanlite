<div class="big_cadre">
	<h1>{TITRE}</h1>

	<div class="big_cadre">
		<h1>{CONFIG}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="mp3_auto_start">{TXT_AUTOPLAY}&nbsp;:</label></span>
				<span><input name="mp3_auto_start" type="checkbox" id="mp3_auto_start" value="1" {CHECK_AUTOPLAY} /></span>
			</p>
			<p>
				<span><label for="mp3_shuffle">{TXT_SHUFFLE}&nbsp;:</label></span>
				<span><input name="mp3_shuffle" type="checkbox" id="mp3_shuffle" value="1" {CHECK_SHUFFLE} /></span>
			</p>
			<p>
				<span>
					<input type="submit" name="Config_editer" value="{EDITER}" />
				</span>
			</p>

		</form>
	</div>

	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="ordre">{TXT_ORDRE}&nbsp;:</label></span>
				<span><input name="ordre" type="text" id="ordre" value="{ORDRE}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="titre">{TXT_TITRE}&nbsp;:</label></span>
				<span><input name="titre" type="text" id="titre" value="{TITRE_MP3}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="SRC">{TXT_SOURCE}&nbsp;:</label></span>
				<span><input name="SRC" id="SRC" type="text" value="{SCR}" onblur="formverif(this.id,'nbr','5')" /></span>
			</p>
			<p>
				<span>
					<!-- BEGIN rajouter -->
					<input type="submit" name="Envoyer" value="{rajouter.ENVOYER}" />
					<!-- END rajouter -->
					<!-- BEGIN edit -->
					<input type="submit" name="Editer" value="{EDITER}" />
					<!-- END edit -->
					<input name="for" type="hidden" id="for" value="{ID}" />
				</span>
			</p>
		</form>
	</div>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news">
			<table class="table">
				<thead>
					<tr>
						<th>{TXT_ORDRE}</th>
						<th>{TXT_TITRE}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste --> 
					<tr> 
						<td>{liste.ORDRE}</td> 
						<td><a href="{liste.SRC}" onclick="window.open('{liste.SRC}');return false;">{liste.TITRE}</a></td> 
						<td>
							<form action="{ICI}" method="post"> 
								<input name="dell" type="submit" value="{SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" /> 
								<input name="for" type="hidden" value="{liste.ID}" /> 
								<input name="edit" type="submit" value="{EDITER}" /> 
							</form>
						</td> 
					</tr> 
					<!-- END liste --> 
				</tbody>
			</table>
		</div>
	</div>
</div>