<div class="big_cadre">
	<h1>{TITRE}</h1>
<form method="post" action="news.php"> 
<div class="big_cadre">
	<h1>{TITRE_GESTION}</h1>
	<p>
		<span><label for="titre">{TXT_TITRE}&nbsp;:</label></span>
		<span><input name="titre" id="titre" type="text" value="{TITRE_TITRE}" onBlur="formverif(this.id,'nbr','5')" /></span>
	</p>
	<p>
		<span><label for="texte">{TXT_CORPS}&nbsp;:</label></span>
	</p>
	<p>
		<div class="smilies">
			<!-- BEGIN poste_smilies_liste -->
			<a href="javascript:emoticon('{poste_smilies_liste.TXT}','texte')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
			<!-- BEGIN more -->
			<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
			<div id="smilies_more" style="display: none;">
				<!-- BEGIN liste -->
				<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','texte')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
				<!-- END liste -->
			</div>
			<!-- END more -->
			<!-- END poste_smilies_liste -->
		</div>
		<div class="big_texte"><textarea name="texte" id="texte" cols="40" rows="10" onBlur="formverif(this.id,'nbr','10')">{INFO}</textarea></div>
	</p>
	</p>
	<p>
		<span>
			<input name="for" type="hidden" value="{ID}" />
			<!-- BEGIN edit --> 
			<input type="submit" name="editer" value="{edit.EDITER}" /> 
			<!-- END edit --> 
			<!-- BEGIN rajouter --> 
			<input type="submit" name="ajouter" value="{rajouter.ENVOYER}" /> 
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
    <td>{TXT_DATE}</td> 
    <td>{TXT_CORPS}</td> 
    <td>{TXT_POSTEUR}</td> 
    <td>{ACTION}</td> 
  </tr> 
  <!-- BEGIN liste --> 
  <tr> 
    <td>{liste.DATE}</td> 
    <td><h2>{liste.TITRE}</h2>
      {liste.INFO}</td> 
    <td>{liste.POSTEUR}</td> 
      <td><form action="news.php" method="post">
	  <input name="dell" type="submit" id="dell" value="{liste.SUPPRIMER}" onClick="return demande('{TXT_CON_DELL}')" />
	  <input name="for" type="hidden" value="{liste.ID}" />
	  <input name="edit" type="submit" value="{liste.EDITER}" /></form></td> 
  </tr> 
  <!-- END liste --> 
</table>
</div>
</div>
</div>