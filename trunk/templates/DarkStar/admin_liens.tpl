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
				<tbody>
					<!-- BEGIN liste -->
					<tr>
						<td>{liste.NOM}</td>
						<td><a href="{liste.URL}" onclick="window.open('{liste.URL}');return false;">{liste.TEST_LIEN}</a></td>
						<td>
							<form action="{ICI}" method="post">
								<input name="dell" type="submit" value="{liste.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="for" type="hidden" value="{liste.ID}" />
								<input name="edit" type="submit" value="{liste.EDITER}" />
							</form>
						</td>
					</tr>
					<!-- BEGIN image -->
					<tr>
						<td colspan="3"><img src="{liste.image.IMAGE}" alt="{liste.NOM}" /></td>
					</tr>
					<!-- END image -->
					<!-- END liste -->
				</tbody>
			</table>
		</div>
	</div>
</div>