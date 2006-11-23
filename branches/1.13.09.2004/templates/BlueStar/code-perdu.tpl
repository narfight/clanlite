<form method="post" action="code-perdu.php"> 
<div class="big_cadre">
	<h1>{TITRE}</h1>
	<p>
		<span><label for="mail">{MAIL}&nbsp;:</label></span>
		<span><input name="mail" type="text" id="mail" size="15" onblur="formverif(this.id, 'mail', '')" /></span>
	</p>
	<p>
		<span><label for="activ_pw">{DEF_ACTIVATION}&nbsp;:</label></span>
		<span><input name="activ_pw" type="text" id="active_pw" size="15" onblur="formverif(this.id, 'nbr', '4')" /></span>
	</p>
	<p>
		<span><input name="Submit" type="submit" class="boutton" value="{BT_ENVOYER}" /></span>
	</p>
</div>
</form>