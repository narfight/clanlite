<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}">
		<div class="big_cadre">
			<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="nom">{TXT_TXT}&nbsp;:</label></span>
			</p>
			<p>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','txt')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','txt')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="txt" cols="40" rows="10" id="txt" onblur="formverif(this.id,'nbr','10')">{INFO}</textarea></div>
			</p>
			<p>
				<span>
					<!-- BEGIN edit --> 
					<input name="Editer_aléatoire_module" type="submit" id="Editer" value="{edit.EDITER}" /> 
					<!-- END edit --> 
					<!-- BEGIN rajouter --> 
					<input name="Envoyer_aléatoire_module" type="submit" id="Envoyer" value="{rajouter.ENVOYER}" /> 
					<!-- END rajouter --> 
					<input name="for_aléatoire_module" type="hidden" id="for" value="{ID}" /> 
				    <input name="id_module" type="hidden" id="id_module" value="{ID_MODULE}" />
				</span>
			</p>
		</div>
	</form>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news"><table class="table"> 
		  <tr class="table-titre"> 
			<td>{TXT_TXT}</td> 
			<td>{ACTION}</td> 
		  </tr> 
		  <!-- BEGIN liste --> 
		  <tr> 
			<td>{liste.TXT}</td> 
			  <td><form action="{ICI}" method="post"> 
				  <input name="dell_aléatoire_module" type="submit" id="dell" value="{liste.SUPPRIMER}" /> 
				  <input name="for_aléatoire_module" type="hidden" value="{liste.ID}" /> 
				  <input name="id_module" type="hidden" id="id_module" value="{ID_MODULE}" />
				  <input name="edit_aléatoire_module" type="submit" value="{liste.EDITER}" /> 
				 </form></td> 
		  </tr> 
		  <!-- END liste --> 
		</table>
		</div>
	</div>
</div>