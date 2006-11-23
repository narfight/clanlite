<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}">
		<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom" type="text" id="nom" value="{NOM}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="url">{TXT_URL}&nbsp;:</label></span>
				<span><input name="url" type="text" id="url" value="{URL}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="image">{TXT_IMAGE}&nbsp;:</label></span>
				<span><input name="image" type="text" id="image" value="{IMAGE}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span>
					<!-- BEGIN edit --> 
					<input name="Editer_partenaire_module" type="submit" id="Editer" value="{edit.EDITER}" /> 
					<!-- END edit --> 
					<!-- BEGIN rajouter --> 
					<input name="Envoyer_partenaire_module" type="submit" id="Envoyer" value="{rajouter.ENVOYER}" /> 
					<!-- END rajouter --> 
					<input name="for_partenaire_module" type="hidden" id="for" value="{ID}" /> 
				    <input name="id_module" type="hidden" id="id_module" value="{ID_MODULE}" />
				</span>
			</p>
		</div>
	</form>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news"><table class="table"> 
		  <tr class="table-titre"> 
			<td>{TXT_IMAGE}</td> 
			<td>{TXT_URL}</td> 
			<td>{ACTION}</td> 
		  </tr> 
		  <!-- BEGIN liste --> 
		  <tr> 
			<td><img src="{liste.IMAGE}"  alt="{liste.NOM}" /></td> 
			<td><a href="{liste.URL}" onclick="window.open('{liste.URL}');return false;">{liste.NOM}</a></td> 
			  <td><form action="{ICI}" method="post"> 
				  <input name="dell_partenaire_module" type="submit" id="dell" value="{liste.SUPPRIMER}" /> 
				  <input name="for_partenaire_module" type="hidden" value="{liste.ID}" /> 
				  <input name="id_module" type="hidden" id="id_module" value="{ID_MODULE}" />
				  <input name="edit_partenaire_module" type="submit" value="{liste.EDITER}" /> 
				 </form></td> 
		  </tr> 
		  <!-- END liste --> 
		</table>
		</div>
	</div>
</div>