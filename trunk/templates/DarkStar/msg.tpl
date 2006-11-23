<!-- BEGIN msg -->
<div class="big_cadre">
	<h1>{msg.TYPE}</h1>
  <div class="news">{msg.TEXTE}</div>
</div>
<!-- END msg -->
<!-- BEGIN sql -->
<link rel='stylesheet' href='{sql.ROOT_PATH}templates/DarkStar/Library/styles.css' type='text/css'> 
<div class="big_cadre">
	<h1>Erreur de requete SQL</h1>
		<p>
			<span>Requette&nbsp;:</span>
			<span>{sql.REQUETE}</span>
		</p>
		<p>
			<span>Erreur reçue&nbsp;:</span>
			<span>{sql.ERROR}</span>
		</p>
		<p>
			<span>Localisation&nbsp;:</span>
			<span>Ligne {sql.LINE} dans {sql.FILE}</span>
		</p>
</div>
<!-- END sql --> 
<!-- BEGIN secu --> 
<form method="post" action="{secu.SITE}controle/entrer.php">
<div class="big_cadre">
	<h1>erreur de s&eacute;curit&eacute;e.</h1>
	<div class="news">Vous essayez d'entrer dans une partie Privée qui peux demander certain pouvoir, ou alors votre navigateur web a bloqué les cookies</div>
	<p>
		<span><label for="user">Votre login&nbsp;:</label></span>
		<span><input name="user" type="text" id="user" value="{USER}" onBlur="formverif(this.id,'nbr','2')" /></span>
	</p>
	<p>
		<span><label for="psw">Votre code&nbsp;:</label></span>
		<span><input name="psw" type="password" id="psw" onBlur="formverif(this.id,'nbr','4')" /></span>
	</p>
	<p>
		<span><label for="save_code_login">Ce souvenir de mon code/login&nbsp;:</label></span>
		<span><input name="save_code_login" type="checkbox" id="save_code_login" value="oui" />
		</span>
	</p>
	<p>
		<span><input name="Submit" type="submit" value="Connection" /></span>
		<span><a href='user/code-perdu.php'>vous avez perdu votre code ?</a></span>
	</p>
</div>
<input name="goto" type="hidden" id="goto" value="{secu.GOTO}" /> 
</form>
<!-- END secu --> 
