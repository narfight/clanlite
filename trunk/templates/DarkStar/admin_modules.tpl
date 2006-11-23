<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom" type="text" id="nom" value="{NOM}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="module">{TXT_FICHIER}&nbsp;:</label></span>
				<span>
					<select name="module" id="module" onblur="formverif(this.id,'autre','')" {EDIT_MODULE}>
						<option value"">{TXT_CHOISIR}</option>
						<!-- BEGIN liste_module -->
						<option value="{liste_module.VALEUR}" {liste_module.SELECTED}>{liste_module.NOM}</option>
						<!-- END liste_module -->
					</select>
				</span>
			</p>
			<p>
				<span><label for="num">{TXT_ORDRE}&nbsp;:</label></span>
				<span><input name="num" id="num" type="text" value="{ORDRE}" size="4" onblur="formverif(this.id,'chiffre','')" /></span>
			</p>
			<p>
				<span><label for="position">{TXT_POSITION}&nbsp;:</label></span>
				<span>
					<select name="position" id="position" onblur="formverif(this.id,'autre','')">
						<option value"">{TXT_CHOISIR}</option>
						<option value="gauche" {SELECTED_GAUCHE} {DISABLED_G_D}>{TXT_GAUCHE}</option>
						<option value="droite" {SELECTED_DROITE} {DISABLED_G_D}>{TXT_DROITE}</option>
						<option value="centre" {SELECTED_CENTRE} {DISABLED_C}>{TXT_CENTRE}</option>
					</select>
				</span>
			</p>
			<p>
				<span><label for="activation_oui">{TXT_ETAT}&nbsp;:</label></span>
				<span><input id="activation_oui" name="activation" type="radio" value="1" {ACTIVATION_ON} />
				{TXT_ON} <input id="activation_non" name="activation" type="radio" value="0" {ACTIVATION_OFF} />{TXT_OFF}</span>
			</p>
			<p>
				<span>
					<!-- BEGIN rajouter -->
					<input type="submit" name="envoyer" value="{rajouter.ENVOYER}" />
					<!-- END rajouter -->
					<!-- BEGIN edit -->
					<input type="submit" name="envois_edit" value="{edit.EDITER}" />
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
						<th>{TXT_NOM}</th>
						<th>{TXT_ETAT}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<thead>
					<tr class="sous-cellule">
						<th colspan="4">{TXT_DROITE}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste_droite -->
					<tr>
						<td>{liste_droite.NUM}</td>
						<td>{liste_droite.NOM}</td>
						<td>{liste_droite.ETAT}</td>
						<td>
							<form action="{ICI}" method="post">
								<input name="Supprimer" type="submit" value="{liste_droite.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="for" type="hidden" value="{liste_droite.ID}" />
								<input name="call_page" type="hidden" value="{liste_droite.CALL_PAGE}" />
								<input name="Editer" type="submit" value="{liste_droite.EDITER}" />
							</form>
						</td>
					</tr>
					<!-- END liste_droite -->
				</tbody>
				<thead>
					<tr class="sous-cellule">
						<th colspan="4">{TXT_CENTRE}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste_centre -->
					<tr>
						<td>{liste_centre.NUM}</td>
						<td>{liste_centre.NOM}</td>
						<td>{liste_centre.ETAT}</td>
						<td>
							<form action="{ICI}" method="post">
								<input name="Supprimer" type="submit" value="{liste_centre.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="for" type="hidden" value="{liste_centre.ID}" />
								<input name="call_page" type="hidden" value="{liste_centre.CALL_PAGE}" />
								<input name="centre" type="hidden" value="true" />
								<input name="Editer" type="submit" value="{liste_centre.EDITER}" />
							</form>
						</td>
					</tr>
					<!-- END liste_centre -->
				</tbody>
				<thead>
					<tr class="sous-cellule">
						<th colspan="4">{TXT_GAUCHE}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste_gauche -->
					<tr>
						<td>{liste_gauche.NUM}</td>
						<td>{liste_gauche.NOM}</td>
						<td>{liste_gauche.ETAT}</td>
						<td>
							<form action="{ICI}" method="post">
								<input name="Supprimer" type="submit" value="{liste_gauche.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="call_page" type="hidden" value="{liste_gauche.CALL_PAGE}" />
								<input name="for" type="hidden" value="{liste_gauche.ID}" />
								<input name="Editer" type="submit" value="{liste_gauche.EDITER}" />
							</form>
						</td>
					</tr>
					<!-- END liste_gauche -->
				</tbody>
			</table>
		</div>
	</div>
</div>