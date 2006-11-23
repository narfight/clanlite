<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="mailiste.php">
		<p>
			<span><label for="subject">{TXT_SUBJECT}&nbsp;:</label></span>
			<span><input name="subject" id="subject" type="text" onBlur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="corps">{TXT_CORPS}&nbsp;:</label></span>
			<span>
			<textarea name="corps" cols="40" rows="10" id="corps" onBlur="formverif(this.id,'nbr','10')"></textarea>
			</span>
		</p>
		<p>
			<span>
					<input type="submit" name="Envoyer" value="{ENVOYER}" /> 
			</span>
		</p>
	</form>
</div>