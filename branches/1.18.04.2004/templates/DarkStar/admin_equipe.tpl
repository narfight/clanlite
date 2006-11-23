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
				<span><label for="info">{TXT_DETAILS}&nbsp;:</label></span>
				<span><textarea name="info" rows="5" id="info" onBlur="formverif(this.id,'nbr','3')">{INFO}</textarea></span>
			</p>
			<p>
				<span>
						<!-- BEGIN envoyer --> 
						<input type="submit" name="Envoyer" value="{envoyer.ENVOYER}" /> 
						<!-- END envoyer --> 
						<!-- BEGIN edit --> 
						<input type="submit" name="Editer" value="{edit.EDITER}" /> 
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
				<td>{TXT_DETAILS}</td> 
				<td>{ACTION}</td> 
			  </tr> 
			  <!-- BEGIN liste --> 
			  <tr> 
				<td>{liste.NOM}</td> 
				<td>{liste.INFO}</td> 
				  <td><form action="{ICI}" method="post"> 
					  <input name="dell" type="submit" value="{liste.SUPPRIMER}" /> 
					  <input name="for" type="hidden" value="{liste.ID}" /> 
					  <input name="edit" type="submit" value="{liste.EDITER}" /> 
					  </form></td> 
			  </tr> 
			  <!-- END liste --> 
			</table>
		</div>
	</div>
</div>
