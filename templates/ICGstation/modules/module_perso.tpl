<div class="big_cadre" id="simple">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}" class="visible">
		<p>
			<span><label for="contenu">{TXT_CONTENU}&nbsp;:</label></span>
			<span><textarea name="contenu" cols="40" rows="10" id="contenu" onblur="formverif(this.id,'nbr','10')">{CONTENU}</textarea></span>
		</p>
		<p>
			<span>
				<input name="id_module" type="hidden" id="id_module" value="{ID}" />
				<input name="Submit_module_perso_module" type="submit" id="Submit_module_perso_module" value="{EDITER}" /> 
			</span>
		</p>
	</form>
</div>