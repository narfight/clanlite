<div class="big_cadre">
	<h1>{TITRE}</h1>
	<!-- BEGIN apercu -->
	<div class="big_cadre">
		<h1>{apercu.TITRE}</h1>
		<div class="news">
			<h2>{apercu.SUBJECT}</h2>
			{apercu.CORPS}
		</div>
	</div>
	<!-- END apercu -->
	<div class="big_cadre">
		<h1>{TITRE}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="no_section">{TXT_FOR}&nbsp;:</label></span>
			</p>
			<p>
				<ul>
				<li><input name="no_section" type="checkbox" id ="no_section" value="1" {NO_SECTION_SELECTED} />
				<label for="no_section"> : {NO_SECTION}</label></li>
				<!-- BEGIN liste_send -->
				<li><input id="{liste_send.ID}" name="{liste_send.ID}" type="checkbox" value="1" {liste_send.SELECTED} /><label for="{liste_send.ID}"> : {liste_send.NOM}</label></li>
				<!-- END liste_send -->
				</ul>
			</p>
			<p>
				<span><label for="subject">{TXT_SUBJECT}&nbsp;:</label></span>
				<span><input name="subject" id="subject" type="text" value="{SUBJECT}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="corps">{TXT_CORPS}&nbsp;:</label></span>
				<span><textarea name="corps" cols="40" rows="10" id="corps" onblur="formverif(this.id,'nbr','10')">{CORPS}</textarea></span>
			</p>
			<p>
				<span><input type="submit" name="Envoyer" value="{ENVOYER}" /> <input type="submit" name="Apercu" value="{APERCU}" /></span>
			</p>
		</form>
	</div>
</div>