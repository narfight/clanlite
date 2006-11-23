<form method="post" action="{GOTO_U}"> 
	<div class="big_cadre">
		<h1>{TITRE}</h1>
		<!-- BEGIN erreur -->
		<div class="news">
			{erreur.TEXTE}
		</div>
		<!-- END erreur -->
		<p>
			<span><label for="user">{LOGIN}&nbsp;:</label></span>
			<span><input name="user" type="text" id="user" value="{USER}" onblur="formverif(this.id,'nbr','2')" /></span>
		</p>
		<p>
			<span><label for="psw">{CODE}&nbsp;:</label></span>
			<span><input name="psw" type="password" id="psw" onblur="formverif(this.id,'nbr','4')" /></span>
		</p>
		<p>
			<span><label for="save_code_login">{SAVE}&nbsp;:</label></span>
			<span><input name="save_code_login" type="checkbox" id="save_code_login" value="oui" /></span>
		</p>
		<p>
			<span>
				<input name="Submit" type="submit" value="{ENVOYER}" />
				<input name="goto" type="hidden" id="goto" value="{GOTO}" />
			</span>
			<span><a href="{LOST_U}">{LOST}</a></span>
		</p>
	</div>
</form>