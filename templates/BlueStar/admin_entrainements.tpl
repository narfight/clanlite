<div class="big_cadre">
	<h1>{TITRE}</h1>
<form method="post" action="entrainements.php"> 
	<div class="big_cadre">
	<h1>{TITRE_GESTION}</h1>
	<p>
		<span><label for="texte">{TXT_TEXTE}&nbsp;:</label></span>
	</p>
	<p>
		<div class="smilies">
			<!-- BEGIN poste_smilies_liste -->
			<a href="javascript:emoticon('{poste_smilies_liste.TXT}','texte')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
			<!-- BEGIN more -->
			<a href="javascript:toggle_msg('smilies_more_publique', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
			<div id="smilies_more_publique" style="display: none;">
				<!-- BEGIN liste -->
				<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','texte')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
				<!-- END liste -->
			</div>
			<!-- END more -->
			<!-- END poste_smilies_liste -->
		</div>
		<div class="big_texte"><textarea name="texte" cols="40" rows="10" id="texte" onBlur="formverif(this.id,'nbr','10')">{INFO}</textarea></div>
	</p>
	<p>
		<span><label for="priver">{MSG_PRIVE}&nbsp;:</label></span>
	</p>
	<p>
		<div class="smilies">
			<!-- BEGIN poste_smilies_liste -->
			<a href="javascript:emoticon('{poste_smilies_liste.TXT}','priver')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
			<!-- BEGIN more -->
			<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
			<div id="smilies_more" style="display: none;">
				<!-- BEGIN liste -->
				<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','priver')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
				<!-- END liste -->
			</div>
			<!-- END more -->
			<!-- END poste_smilies_liste -->
		</div>
		<div class="big_texte"><textarea name="priver" cols="40" rows="10" id="priver" onBlur="formverif(this.id,'nbr','10')">{PRIVER}</textarea></div>
	</p>
	<p>
		<span><label for="jours">{DATE}&nbsp;:</label></span>
		<span><input name="jours" type="text" id="jours" value="{JOURS}" size="2" maxlength="2"  onBlur="formverif(this.id,'chiffre','31')" />/<input name="mois" type="text" id="mois" value="{MOIS}" size="2" maxlength="2" onBlur="formverif(this.id,'chiffre','12')" />/<input name="annee" type="text" id="annee" value="{ANNEE}" size="4" maxlength="4" onBlur="formverif(this.id,'chiffre','')" /></span>
	</p>
	<p>
		<span><label for="heure">{HEURE}&nbsp;:</label></span>
		<span><input name="heure" type="text" id="heure" value="{HH}" size="2" maxlength="2" onBlur="formverif(this.id,'chiffre','24')" />H<input name="minute" type="text" id="minute" value="{MM}" size="2" maxlength="2" onBlur="formverif(this.id,'chiffre','24')" /></span>
	</p>
	<p>
		<span>
			<input name="for" type="hidden" id="for" value="{ID}" />
            <!-- BEGIN editer --> 
            <input name="Editer" type="submit" value="{editer.EDITER}" /> 
            <!-- END editer --> 
            <!-- BEGIN rajouter --> 
            <input name="Envoyer" type="submit" value="{rajouter.ENVOYER}" /> 
            <!-- END rajouter --> 
		</span>
	</p>
</div>
</form>
<div class="big_cadre">
<h1>{TITRE_LISTE}</h1>
<div class="news"><table class="table"> 
  <tr class="table-titre"> 
    <td>{DATE}</td> 
    <td>{TXT_TEXTE}</td> 
    <td>{MSG_PRIVE}</td> 
    <td>{POSTEUR}</td> 
    <td>{ACTION}</td> 
  </tr> 
  <!-- BEGIN liste --> 
  <tr> 
    <td>{liste.DATE}</td> 
    <td>{liste.INFO}</td> 
    <td>{liste.PRIVER}</td> 
    <td>{liste.POSTEUR}</td> 
      <td>
		<form action="entrainements.php" method="post"> 
			<input name="dell" type="submit" value="{liste.SUPPRIMER}" onClick="return demande('{TXT_CON_DELL}')" /> 
			<input name="for" type="hidden" value="{liste.ID}" /> 
			<input name="edit" type="submit" value="{liste.EDITER}" /> 
		</form> 
        </td> 
  </tr> 
  <!-- END liste --> 
</table>
</div></div>
</div>
