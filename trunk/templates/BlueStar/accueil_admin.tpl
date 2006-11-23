<form method="post" action="controle/entrer.php"> 
<div class="big_cadre">
	<h1>{TITRE}</h1>
	<p>
		<span><label for="user">{LOGIN}&nbsp;:</label></span>
		<span><input name="user" type="text" id="user" value="{USER}" onBlur="formverif(this.id,'nbr','2')" /></span>
	</p>
	<p>
		<span><label for="psw">{CODE}&nbsp;:</label></span>
		<span><input name="psw" type="password" id="psw" onBlur="formverif(this.id,'nbr','4')" /></span>
	</p>
	<p>
		<span><label for="save_code_login">{SAVE}&nbsp;:</label></span>
		<span><input name="save_code_login" type="checkbox" id="save_code_login" value="oui" />
		</span>
	</p>
	<p>
		<span><input name="Submit" type="submit" class="boutton" value="{ENVOYER}" /></span>
		<span><a href='user/code-perdu.php'>{LOST}</a></span>
	</p>
</div>
</form>
