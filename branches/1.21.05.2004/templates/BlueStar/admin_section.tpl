<div class="big_cadre">
	<h1>{TITRE} <img src="../images/smilies/question.gif" onmouseover="poplink('{HELP_TXT}',event)" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></h1>
    <form method="post" action="{ICI}"> 
		<div class="big_cadre">
			<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom" type="text" id="nom" value="{NOM}" onBlur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="nom">{TXT_LIMITE}&nbsp;:</label></span>
				<span><input name="limite" type="checkbox" value="1" {LIMITE} /></span>
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
		</div>
	</form>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news">
			<table class="table"> 
			  <tr class="table-titre"> 
				<td>{TXT_NOM}</td> 
				<td>{TITRE_LIMITE}</td> 
				<td>{ACTION}</td> 
			  </tr> 
			  <!-- BEGIN liste --> 
			  <tr> 
				<td>{liste.NOM}</td> 
				<td>{liste.LIMITE}</td> 
				  <td><form action="{ICI}" method="post"> 
					  <input name="Supprimer" type="submit" value="Supprimer" /> 
					  <input name="for" type="hidden" value="{liste.ID}" /> 
					  <input name="Editer" type="submit" value="Editer" /> 
					</form></td> 
			  </tr> 
			  <!-- END liste --> 
			</table>
		</div>
	</div>
</div>