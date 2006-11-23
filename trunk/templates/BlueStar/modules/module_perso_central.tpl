<form method="post" action="module_perso_central.php">
	<div class="big_cadre">
	<h1>{TITRE}</h1>
		<p>
			<span><label for="titre">{TXT_TITRE}&nbsp;:</label></span>
			<span><input name="titre" type="text" id="titre" value="{TITRE}" onBlur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="contenu">{TXT_CONTENU}&nbsp;:</label></span>
		</p>
		<p>
			<div class="smilies">
				<!-- BEGIN poste_smilies_liste -->
				<a href="javascript:emoticon('{poste_smilies_liste.TXT}','contenu')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
				<!-- BEGIN more -->
				<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
				<div id="smilies_more" style="display: none;">
					<!-- BEGIN liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','contenu')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
					<!-- END liste -->
				</div>
				<!-- END more -->
				<!-- END poste_smilies_liste -->
			</div>
			<div class="big_texte"><textarea name="contenu" cols="40" rows="10" id="contenu" onBlur="formverif(this.id,'nbr','10')">{CONTENU}</textarea></div>
		</p>
		<p>
			<span>
				<input name="id_module" type="hidden" id="id_module" value="{ID}" />
				<input name="Submit_module_p_centrale" type="submit" id="Submit_module_p_centrale" value="{EDITER}" /> 
			</span>
		</p>
	</div>
</form>
