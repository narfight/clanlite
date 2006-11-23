<div class="big_cadre">
	<h1>{TITRE}</h1>
    <form method="post" action="{ICI}">
		<div class="big_cadre">
			<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="console">{TXT_CONSOLE}&nbsp;:</label></span>
				<span><input id="console" name="console" type="text" value="{CONSOLE}" onblur="formverif(this.id,'nbr','6')" /></span>
			</p>
			<p>
				<span><label for="nom_map">{TXT_NOM}&nbsp;:</label></span>
				<span><input id="nom_map" name="nom_map" type="text" value="{NOM}" onblur="formverif(this.id,'nbr','6')" /></span>
			</p>
			<p>
				<span><label for="url_map">{TXT_URL}&nbsp;:</label></span>
				<span><input id="url_map" name="url_map" type="text" value="{URL}" onblur="formverif(this.id,'nbr','6')" /></span>
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
		</div>
	</form>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news">
			<table class="table">
				<thead>
					<tr>
						<th>{TXT_CONSOLE}</th>
						<th>{TXT_NOM}</th>
						<th>{TXT_URL}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<!-- BEGIN liste -->
				<tr>
					<td>{liste.CONSOLE}</td>
					<td>{liste.NOM}</td>
					<td>{liste.URL}</td>
					<td>
						<form action="{ICI}" method="post">
							<input name="dell" type="submit" id="Supprimer" value="{liste.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
							<input name="for" type="hidden" value="{liste.ID}" />
							<input name="edit" type="submit" value="{liste.EDITER}" />
						</form>
					</td>
				</tr>
				<!-- END liste -->
			</table>
		</div>
	</div>
</div>