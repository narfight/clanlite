<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="ordre">{TXT_PUISSANCE}&nbsp;:</label></span>
				<span><input name="ordre" type="text" id="ordre" value="{ORDRE}" onblur="formverif(this.id,'chiffre','')" /></span>
			</p>
			<p>
				<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom" type="text" id="nom" value="{NOM}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span>
					<!-- BEGIN editer --> 
					<input name="Editer" type="submit" id="Editer" value="{editer.EDITER}"> 
					<!-- END editer --> 
					<!-- BEGIN rajouter --> 
					<input name="Envoyer" type="submit" id="Envoyer" value="{rajouter.ENVOYER}"> 
					<!-- END rajouter --> 
					<input name="for" type="hidden" id="for" value="{ID}"> 
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
						<th>{TXT_PUISSANCE}</th>
						<th>{TXT_NOM}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste -->
					<tr>
						<td>{liste.ORDRE}</td>
						<td>{liste.NOM}</td>
						<td>
							<form action="{ICI}" method="post">
								<input name="dell" type="submit" id="dell" value="{liste.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="for" type="hidden" value="{liste.ID}" />
								<input name="edit" type="submit" value="{liste.EDITER}" />
							</form>
						</td>
					</tr>
					<!-- END liste -->
				</tbody>
			</table>
		</div>
	</div>
</div>