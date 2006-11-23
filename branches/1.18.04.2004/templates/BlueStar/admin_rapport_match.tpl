<div class="big_cadre">
	<h1>{TITRE}</h1>
<form method="post" action="{ICI}"> 
<div class="big_cadre">
	<h1>{TITRE_GESTION}</h1>
	<p>
		<span><label for="importation">{IMPORTATION}&nbsp;:</label></span>
		<span><select name="importation" id="importation" onBlur="formverif(this.id,'change','nul')"> 
            <option value="nul" selected="selected">{CHOISIR}</option> 
            <!-- BEGIN liste_match --> 
            <option value="{liste_match.ID_MATCH}">{liste_match.NOM_MATCH}</option> 
            <!-- END liste_match --> 
          </select> <input type="submit" name="Submit" value="{ENVOYER}" /></span>
	</p>
	<p>
		<span><label for="jj">{DATE}&nbsp;:</label></span>
		<span><input name="jj" type="text" id="jj" value="{JJ}" size="2" onBlur="formverif(this.id,'chiffre','31')" />/<input name="mm" type="text" id="mm" value="{MM}" size="2" onBlur="formverif(this.id,'chiffre','12')" />/<input name="aaaa" type="text" id="aaaa" value="{AAAA}" size="4" onBlur="formverif(this.id,'chiffre','')" /></span>
	</p>
	<p>
		<span><label for="clan">{CONTRE}&nbsp;:</label></span>
		<span><input name="clan" type="text" id="clan" value="{CLAN}" onBlur="formverif(this.id,'nbr','2')" /></span>
	</p>
	<p>
		<span><label for="information">{DETAILS}&nbsp;:</label></span>
		<span><textarea name="information" rows="5" id="information" onBlur="formverif(this.id,'nbr','2')">{INFO}</textarea></span>
	</p>
	<p>
		<span><label for="score_clan">{SCORE}&nbsp;:</label></span>
		<span><input name="score_clan" type="text" id="score_clan" value="{SCORE_NOUS}" size="2" onBlur="formverif(this.id,'chiffre','')" /> -- <input name="score_mechant" type="text" id="score_mechant" value="{SCORE_MECHANT}" size="2" onBlur="formverif(this.id,'chiffre','')"></span>
	</p>
	<p>
		<span><label for="section">{SECTION}&nbsp;:</label></span>
		<span><select name="section" id="section" onBlur="formverif(this.id,'change','')"> 
            <option value="">{CHOISIR}</option> 
            <option value="0" {SELECTED_ALL}>{ALL_SECTION}</option> 
            <!-- BEGIN section --> 
            <option value="{section.ID}" {section.SELECTED}>{section.NOM}</option> 
            <!-- END section --> 
          </select></span>
	</p>
	<p>
		<span><label for="del_match">{DELL_IMPORTE}&nbsp;:</label></span>
		<span><input name="del_match" type="checkbox" id="del_match" value="oui" />
          <input name="id_match_del" type="hidden" id="id_match_del" value="{ID}" /></span>
	</p>
	<p>
		<span>
		    <input name="for" type="hidden" value="{ID}" /> 
            <!-- BEGIN editer --> 
            <input name="edit" type="submit" value="{editer.EDITER}" /> 
            <!-- END editer --> 
            <!-- BEGIN rajouter --> 
            <input name="envoyer" type="submit" value="{rajouter.ENVOYER}" /> 
            <!-- END rajouter --> 
</span>
	</p>
	</div>
</form>
<div class="big_cadre">
	<h1>{TITRE_LISTE}</h1>
<div class="news">
<table class="table"> 
  <tr class="table-titre"> 
    <td>{DATE}</td> 
    <td>{CONTRE}</td> 
    <td>{SCORE}</td> 
    <td>{DETAILS}</td> 
    <td>{ACTION}</td> 
  </tr> 
  <!-- BEGIN liste --> 
  <tr> 
    <td>{liste.DATE}</td> 
    <td>{liste.CLAN} -- {liste.SECTION}</td> 
    <td>{liste.SCORE_MECHANT} -- {liste.SCORE_NOUS}</td> 
    <td>{liste.INFO}</td> 
      <td><form method="post" action="{ICI}">
	  <input name="supprimer" type="submit" id="Supprimer" value="{liste.SUPPRIMER}" /> 
        <input name="id" type="hidden" id="id" value="{liste.ID}" /> 
        <input name="editer" type="submit" id="Editer" value="{liste.EDITER}" /></form></td> 
  </tr> 
  <!-- END liste --> 
</table>
</div>
</div>
</div>