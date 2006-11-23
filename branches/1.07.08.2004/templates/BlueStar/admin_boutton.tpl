<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="menu_boutton.php"> 
		<div class="big_cadre">
			<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="text">{TXT_TEXTE}&nbsp;:</label></span>
				<span><input name="text" type="text" id="text" value="{NOM}" onBlur="formverif(this.id,'nbr','2')" {DISABLED_URL} /></span>
			</p>
			<p>
				<span><label for="url">{TXT_URL}&nbsp;:</label></span>
				<span><input name="url" type="text" id="url" value="{URL}" onBlur="formverif(this.id,'nbr','10')" {DISABLED_URL} /></span>
			</p>
			<p>
				<span><label for="ordre">{TXT_ORDRE}&nbsp;:</label></span>
				<span><input name="ordre" type="text" id="ordre" value="{ORDRE}" size="4" onBlur="formverif(this.id,'chiffre','')" /></span>
			</p>
			<p>
				<span><label for="bouge">{TXT_DEFILER}&nbsp;:</label></span>
				<span><input name="bouge" type="checkbox" id="bouge" value="oui" {BOUGE} /><img src="../images/smilies/question.gif" onmouseover="poplink('{TXT_AIDE}',event)" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></span>
			</p>
			<p>
				<span><label for="frame">{TXT_FRAME}&nbsp;:</label></span>
				<span><input name="frame" type="checkbox" id="frame" value="oui" {FRAME} /></span>
			</p>
			<!-- BEGIN activation -->
			<p>
				<span><label for="activation_oui">{TXT_ETAT}&nbsp;:</label></span>
				<span>
					<input id="activation_oui" name="activation" type="radio" value="1" {activation.ACTIF} /> {activation.TXT_ACTIF}
					<input id="activation_non" name="activation" type="radio" value="0" {activation.DESACTIF} /> {activation.TXT_DESACTIF}
				</span>
			</p>
			<!-- END activation -->
			<p>
				<span>
					<!-- BEGIN editer --> 
					<input type="submit" name="Editer" value="{editer.EDITER}" /> 
					<!-- END editer --> 
					<!-- BEGIN rajouter --> 
					<input type="submit" name="Envoyer" value="{rajouter.ENVOYER}" /> 
					<!-- END rajouter --> 
					<input name="for" type="hidden" id="for" value="{ID}" />
					<input name="module_central" type="hidden" value="{MODULE_CENTRAL}" />
					<input name="liens_default" type="hidden" value="{LIENS_DEFAULT}" />
				</span>
			</p>
		</div>
	</form>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news">
			<table class="table"> 
				<tr class="table-titre"> 
					<td>{TXT_ORDRE}</td> 
					<td>{TXT_URL_LIGHT}</td> 
					<td>{TXT_ETAT}</td> 
					<td>{ACTION}</td> 
				</tr> 
				<!-- BEGIN liste --> 
				<tr> 
					<td>{liste.ORDRE}</td> 
					<td><a href="{liste.URL}" onclick="window.open('{liste.URL}');return false;">{liste.NOM}</a></td> 
					<td>{liste.ETAT}</td> 
					<td>
						<form action="menu_boutton.php" method="post"> 
							<input name="dell" type="submit" value="{liste.SUPPRIMER}" onClick="return demande('{TXT_CON_DELL}')" {liste.DISABLED_DELL} /> 
							<input name="for" type="hidden" value="{liste.ID}" /> 
							<input name="edit" type="submit" value="{liste.EDITER}" /> 
						</form> 
					</td>
				</tr> 
				<!-- END liste --> 
			</table>
		</div>
	</div>
</div>