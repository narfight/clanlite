<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}">
		<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="question">{TXT_QUESTION}&nbsp;:</label></span>
				<span><input name="question" type="text" id="question" value="{QUESTION}" onBlur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="question_[0]">{TXT_REPONSES}&nbsp;:</label></span>
			</p>
			<p>
				<ul>
					<!-- BEGIN question -->
					<li><input name="question[{NUM}]" type="text" id="question_[{NUM}]" value="{TXT}" onBlur="formverif(this.id,'nbr','3')" /> <input name="add_question" type="submit" id="add_question" value="{question.AJOUTER}" /> <input name="dell_question" type="submit" id="dell_question" value="{question.SUPPRIMER}" /></li>
					<!-- END question -->
				</ul>
			</p>
			<p>
				<span><label for="image">{TXT_IMAGE}&nbsp;:</label></span>
				<span><input name="image" type="text" id="image" value="{IMAGE}" onBlur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span>
					<!-- BEGIN edit --> 
					<input name="Editer_sondage_module" type="submit" id="Editer" value="{edit.EDITER}" /> 
					<!-- END edit --> 
					<!-- BEGIN rajouter --> 
					<input name="Envoyer_sondage_module" type="submit" id="Envoyer" value="{rajouter.ENVOYER}" /> 
					<!-- END rajouter --> 
					<input name="for_sondage_module" type="hidden" id="for" value="{ID}" /> 
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
				  <input name="dell_sondage_module" type="submit" id="dell" value="{liste.SUPPRIMER}" /> 
				  <input name="for_sondage_module" type="hidden" value="{liste.ID}" /> 
				  <input name="id_module" type="hidden" id="id_module" value="{ID_MODULE}" />
				  <input name="edit_sondage_module" type="submit" value="{liste.EDITER}" /> 
				 </form></td> 
		  </tr> 
		  <!-- END liste --> 
		</table>
		</div>
	</div>
</div>