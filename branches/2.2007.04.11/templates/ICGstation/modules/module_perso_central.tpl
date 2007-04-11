<div class="big_cadre" id="simple">
	<h1>{TITRE}</h1>
	<form method="post" action="module_perso_central.php" class="visible">
		<p>
			<span><label for="titre">{TXT_TITRE}&nbsp;:</label></span>
			<span><input name="titre" type="text" id="titre" value="{TITRE}" onblur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="contenu">{TXT_CONTENU}&nbsp;:</label></span>
			<span><textarea name="contenu" cols="40" rows="10" id="contenu" onblur="formverif(this.id,'nbr','10')">{CONTENU}</textarea></span>
		</p>
		<p>
			<span>
				<input name="id_module" type="hidden" id="id_module" value="{ID}" />
				<input name="Submit_module_p_centrale" type="submit" id="Submit_module_p_centrale" value="{EDITER}" /> 
			</span>
		</p>
	</form>
</div>
