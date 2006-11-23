<div class="big_cadre">
	<h1>{TITRE}</h1>
    <form method="post" action="{ICI}"> 
	<div class="big_cadre">
	<h1>{TITRE_GESTION}</h1>
	<p>
		<span><label for="ordre">{TXT_PUISSANCE}&nbsp;:</label></span>
		<span><input name="ordre" type="text" id="ordre" value="{ORDRE}" onBlur="formverif(this.id,'chiffre','')" /></span>
	</p>
	<p>
		<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
		<span><input name="nom" type="text" id="nom" value="{NOM}" onBlur="formverif(this.id,'nbr','3')" /></span>
	</p>
	<p>
		<span>
            <!-- BEGIN editer --> 
            <input name="Editer" type="submit" id="Editer" value="{editer.EDITER}"> 
            <!-- END editer --> 
            <!-- BEGIN rajouter --> 
            <input name="Envoyer" type="submit" id="Envoyer" value="{rajouter.ENVOYER}"> 
            <!-- END rajouter --> 
            <input name="for" type="hidden" id="for" value="{ID}"> 
		</span>
	</p>
</div>
</form>
<div class="big_cadre">
<h1>{TITRE_LISTE}</h1>
<div class="news">
<table class="table"> 
  <tr class="table-titre"> 
    <td>{TXT_PUISSANCE}</td> 
    <td>{TXT_NOM}</td> 
    <td>{ACTION}</td> 
  </tr> 
  <!-- BEGIN liste --> 
  <tr> 
    <td>{liste.ORDRE}</td> 
    <td>{liste.NOM}</td> 
      <td>
	    <form action="{ICI}" method="post"> 
          <input name="dell" type="submit" id="dell" value="{liste.SUPPRIMER}" onClick="return demande('{TXT_CON_DELL}')" /> 
          <input name="for" type="hidden" value="{liste.ID}" /> 
          <input name="edit" type="submit" value="{liste.EDITER}" /> 
		</form></td> 
  </tr> 
  <!-- END liste --> 
</table>
</div>
</div>
</div>