<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
	<h1>{TITRE_GESTION}</h1>
	<p>
		<span><a href="#" onClick="toggle_msg('fichier', '', '')">{TOGGLE_FICHIER}</a></span>
	</p>
	<div id="fichier" style="display:none">
	    <form method="post" action="{ICI}"> 
			<p>
				<span><label for="nom">{NOM}&nbsp;:</label></span>
				<span><input name="nom" id="nom" type="text" value="{NOM_FICHIER}" onBlur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="url_dl">{SRC}&nbsp;:</label></span>
				<span><input name="url_dl" type="text" id="url_dl" value="{URL_FICHIER}" onBlur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="information">{TXT}&nbsp;:</label></span>
			</p>
			<p>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','information')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more_fichier', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more_fichier" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','information')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="information" cols="40" rows="10" id="information" onBlur="formverif(this.id,'nbr','10')">{INFO_FICHIER}</textarea></div>
			</p>
			<p>
				<span><label for="groupe">{TXT_GROUP}&nbsp;:</label></span>
				<span><select name="groupe" id="groupe" onBlur="formverif(this.id,'autre','')"> 
				  <option value="">{CHOISIR}</option> 
				  <!-- BEGIN liste_group --> 
				  <option value="{liste_group.ID_GROUP}" {liste_group.SELECTED}>{liste_group.GROUP}</option> 
				  <!-- END liste_group --> 
				</select></span>
			</p>
			<p>
				<span>
				  <!-- BEGIN editer_fichier --> 
				  <input name="Edit_fichier" type="submit" id="Edit_fichier" value="{editer_fichier.EDITER}" /> 
				  <!-- END editer_fichier --> 
				  <!-- BEGIN rajouter_fichier --> 
				  <input name="Envoyer_fichier" type="submit" id="Envoyer_fichier" value="{rajouter_fichier.ENVOYER}" /> 
				  <!-- END rajouter_fichier --> 
				  <input name="for_fichier" type="hidden" id="for_fichier_form" value="{FOR_FICHIER}" /> 
				</span>
			</p>
		</form>
	</div>
	<p>
		<span><a href="#" onClick="toggle_msg('group', '', '')">{TOGGLE_GROUP}</a></span>
	</p>
	<div id="group" style="display:none">
		<form method="post" action="{ICI}"> 
			<p>
				<span><label for="nom">{NOM}&nbsp;:</label></span>
				<span><input name="nom_group" id="nom_group" type="text" value="{NOM_GROUP}" onBlur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="information">{TXT}&nbsp;:</label></span>
			</p>
			<p>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','information_group')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more_group', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more_group" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','information_group')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="information_group" cols="40" rows="10" id="information_group" onBlur="formverif(this.id,'nbr','10')">{INFO_GROUP}</textarea></div>
			</p>
			<p>
				<span>
				  <!-- BEGIN editer_group --> 
				  <input name="Edit_group" type="submit" id="Edit_group" value="{editer_group.EDITER}" /> 
				  <!-- END editer_group --> 
				  <!-- BEGIN rajouter_group --> 
				  <input name="Envoyer_group" type="submit" id="Envoyer_group" value="{rajouter_group.ENVOYER}" /> 
				  <!-- END rajouter_group --> 
				  <input name="for_group" type="hidden" id="for_group_form" value="{FOR_GROUP}" /> 
				</span>
			</p>
		</form>
	</div>
</div>
<div class="big_cadre">
<h1>{TITRE_LISTE}</h1>
<div class="news">
<table class="table"> 
  <tr class="table-titre"> 
    <td>{NOM}</td> 
    <td>{COTE}</td> 
    <td>{DATE_MODIF}</td> 
    <td>{TXT}</td> 
    <td>{ACTION}</td> 
  </tr> 
<!-- BEGIN liste_group_bas --> 
  <tr class="sous-cellule"> 
    <td colspan="3">{liste_group_bas.GROUP_NOM}</td> 
    <td colspan="2"><form method="post" action="{ICI}"> 
          <input name="Supprimer_group" type="submit" id="Supprimer_group" value="{liste_group_bas.SUPPRIMER}" /> 
          <input name="for_group" type="hidden" id="for_group" value="{liste_group_bas.GROUP_ID}" /> 
          <input name="Editer_group" type="submit" id="Edite_group" value="{liste_group_bas.EDITER}" /> 
    </form></td> 
  </tr> 
  <!-- BEGIN liste --> 
  <tr> 
    <td><a href="{liste_group_bas.liste.URL}">{liste_group_bas.liste.NOM}</a></td> 
    <td>{liste_group_bas.liste.COTE}</td> 
    <td nowrap>{liste_group_bas.liste.MODIF}</td> 
    <td>{liste_group_bas.liste.INFO}</td> 
      <td> 
    <form method="post" action="{ICI}"> 
          <input name="Supprimer_fichier" type="submit" value="{liste_group_bas.liste.SUPPRIMER}" /> 
          <input name="for_fichier" type="hidden" value="{liste_group_bas.liste.FOR}" /> 
          <input name="Editer_fichier" type="submit" value="{liste_group_bas.liste.EDITER}" />
	</form> 
		</td> 
  </tr> 
  <!-- END liste --> 
<!-- END liste_group_bas --> 
</table>
</div>
</div>
</div>
<SCRIPT language="JavaScript">
<!--
if (trouve('for_fichier_form').value.length != 0)
{
	toggle_msg('fichier', '', '');
}
if (trouve('for_group_form').value.length != 0)
{
	toggle_msg('group', '', '');
}
-->
</script> 
