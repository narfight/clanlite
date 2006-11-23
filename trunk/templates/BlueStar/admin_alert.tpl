<div class="big_cadre">
	<h1>{TITRE}</h1>
<form method="post" action="alert.php"> 
	<div class="big_cadre">
	<h1>{TITRE_GESTION}</h1>
	<p>
		<span><label for="text">{TXT_TEXT}&nbsp;:</label></span>
		<span><textarea name="text" cols="30" rows="10" id="text" onBlur="formverif(this.id,'nbr','10')">{TEXT}</textarea></span>
	</p>
	<p>
		<span><label for="def">{TXT_AUTO_DEL}&nbsp;:</label></span>
		<span><input name="auto_del" id="auto_del" {AUTO_DEL} type="checkbox" value="oui" onChange="toggle_msg('auto_del_div', this.id, 'true', 'checked')"></span>
	</p>
	<div id="auto_del_div">
		<p>
			<span><label for="jour">{TXT_DEL_DATE}&nbsp;:</label></span>
			<span><input name="jour" type="text" id="jour" value="{JOUR}" size="2" maxlength="2" onBlur="formverif(this.id,'chiffre','31')" />/<input name="mois" type="text" id="mois" value="{MOIS}" size="2" maxlength="2" onBlur="formverif(this.id,'chiffre','12')" />/<input name="annee" type="text" id="year" value="{ANNEE}" size="4" maxlength="4" onBlur="formverif(this.id,'chiffre','')" />(mm/jj/yyyy)</span>
		</p>
		<p>
			<span><label for="heure">{TXT_DEL_HEURE}&nbsp;:</label></span>
			<span><input name="heure" type="text" id="heure" value="{HEURE}" size="2" maxlength="2" onBlur="formverif(this.id,'chiffre','24')" />H<input name="minute" type="text" id="minute" value="{MINUTE}" size="2" maxlength="2" onBlur="formverif(this.id,'chiffre','60')" /></span>
		</p>
	</div>
	<p>
	<span>
			<!-- BEGIN editer --> 
            <input type="submit" name="Editer" value="{BT_EDITER}" /> 
            <!-- END editer --> 
            <!-- BEGIN rajouter --> 
            <input type="submit" name="Envoyer" value="{BT_ENVOYER}" /> 
            <!-- END rajouter --> 
            <input name="for" type="hidden" value="{ID}" />
	</span>
</p>
</div>
</form>
<SCRIPT language="JavaScript">
<!--
toggle_msg('auto_del_div', 'auto_del', 'true', 'checked');
-->
</script> 
<div class="big_cadre">
<h1>{TITRE_LIST}</h1>
<div class="news"><table class="table"> 
  <tr class="table-titre"> 
    <td>{DATE}</td> 
    <td>{TXT_TEXT}</td> 
    <td>{ACTION}</td> 
  </tr> 
  <!-- BEGIN liste --> 
  <tr> 
    <td>{liste.DATE}</td> 
    <td>{liste.TEXT}</td> 
      <td><form action="alert.php" method="post">
          <input name="dell" type="submit" value="{BT_DELL}"> 
          <input name="for" type="hidden" value="{liste.ID}"> 
          <input name="edit" type="submit" value="{BT_EDITER}">
		  </form>
	  </td> 
  </tr> 
  <!-- END liste --> 
</table></div></div></div>
