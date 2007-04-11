<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
	    <form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="nom_liens">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom_liens" type="text" id="nom_liens" value="{NOM}" onblur="formverif(this.id,'nbr','6')" /></span>
			</p>
			<p>
				<span><label for="url_liens">{TXT_URL}&nbsp;:</label></span>
				<span><input name="url_liens" type="text" id="url_liens" value="{URL}" onblur="formverif(this.id,'nbr','6')" /></span>
			</p>
			<p>
				<span><label for="url_image">{TXT_IMAGE}&nbsp;:</label></span>
				<span><input name="url_image" type="text" id="url_image" value="{IMAGE}" onblur="formverif(this.id,'nbr','6')" /></span>
			</p>
			<p>
				<span><label for="repertoire">{TXT_REPERTOIRE}&nbsp;:</label></span>
				<span>
					<input name="repertoire" type="text" id="repertoire" value="{REPERTOIRE}" onblur="formverif(this.id,'nbr','3')" />
					<select name="pre-selection" id="pre-selection" onchange="trouve('repertoire').value = this.value;">
						<option value="">{CHOISIR_REPERTOIRE}</option>
						<!-- BEGIN liste_selection -->
						<option value="{liste_selection.VALUE}">{liste_selection.VALUE}</option>
						<!-- END liste_selection -->
					</select> ({OPTIONNEL})
				</span>
			</p>
			<p>
				<span>
					<!-- BEGIN editer --> 
					<input name="Editer" type="submit" id="Editer" value="{editer.EDITER}" /> 
					<!-- END editer --> 
					<!-- BEGIN rajouter --> 
					<input name="Envoyer" type="submit" id="Envoyer" value="{rajouter.ENVOYER}" /> 
					<!-- END rajouter --> 
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
						<th>{TXT_NOM}</th>
						<th>{TXT_URL}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<!-- BEGIN repertoire_liste -->
				<thead>
					<tr>
						<th colspan="3">{repertoire_liste.REPERTOIRE}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste -->
					<tr>
						<td>{repertoire_liste.liste.NOM}</td>
						<td><a href="{repertoire_liste.liste.URL}" onclick="window.open('{repertoire_liste.liste.URL}');return false;">{repertoire_liste.liste.TEST_LIEN}</a></td>
						<td>
							<form action="{ICI}" method="post">
								<input name="dell" type="submit" value="{SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="for" type="hidden" value="{repertoire_liste.liste.ID}" />
								<input name="edit" type="submit" value="{EDITER}" />
							</form>
						</td>
					</tr>
					<!-- BEGIN image -->
					<tr>
						<td colspan="3"><img src="{repertoire_liste.liste.IMAGE}" alt="{repertoire_liste.liste.NOM}" /></td>
					</tr>
					<!-- END image -->
					<!-- END liste -->
				</tbody>
				<!-- END repertoire_liste -->
			</table>
		</div>
	</div>
</div>