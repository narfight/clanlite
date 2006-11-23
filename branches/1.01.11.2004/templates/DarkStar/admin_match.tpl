<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}">
		<div class="big_cadre">
			<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="clan">{TXT_CONTRE}&nbsp;:</label></span>
				<span><input name="clan" id="clan" type="text" value="{TEAM_ADV}" onblur="formverif(this.id,'nbr','2')" /></span>
			</p>
			<p>
				<span><label for="date1">{TXT_DATE}&nbsp;:</label></span>
				<span><input name="date1" id="date1" type="text" value="{JOURS}" size="2" maxlength="2"onblur="formverif(this.id,'chiffre','31')" />/<input name="date2" id="date2" type="text" value="{MOIS}" size="2" maxlength="2"onblur="formverif(this.id,'chiffre','12')" />/<input name="date3" id="date3" type="text" value="{ANNEE}" size="4" maxlength="4"onblur="formverif(this.id,'chiffre','')" /></span>
			</p>
			<p>
				<span><label for="heure_match">{TXT_HEURE}&nbsp;:</label></span>
				<span><input name="heure_match" id="heure_match" type="text" value="{HH}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','24')" />H<input name="minute_match" id="minute_match" type="text" value="{MM}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','60')" /></span>
			</p>
			<p>
				<span><label for="heure_msn">{TXT_HEURE_CHAT}&nbsp;:</label></span>
				<span><input name="heure_msn" id="heure_msn" type="text" value="{HEURE_CHAT}" onblur="formverif(this.id,'nbr','2')" /></span>
			</p>
			<p>
				<span><label for="section">{TXT_SECTION}&nbsp;:</label></span>
				<span>
					<select name="section" id="section" onblur="formverif(this.id,'change','-1')"> 
						<option value="-1">{CHOISIR}</option> 
						<option value="0" {SELECTED_ALL}>{ALL_SECTION}</option> 
						<!-- BEGIN section --> 
						<option value="{section.ID}" {section.SELECTED}>{section.NOM}</option> 
						<!-- END section --> 
					</select>
				</span>
			</p>
			<p>
				<span><label for="joueur">{TXT_NBR_JOUEUR}&nbsp;:</label></span>
				<span><input name="joueur" id="joueur" type="text" value="{NOMBRE_J}" size="2" maxlength="2" onblur="formverif(this.id,'nbr','2')" /></span>
			</p>
			<p>
				<span><label for="infoe">{TXT_DETAILS}&nbsp;:</label></span>
			</p>
			<p>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','infoe')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','infoe')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="infoe" cols="40" rows="10" id="infoe" onblur="formverif(this.id,'nbr','10')">{INFO}</textarea></div>
			</p>
			<p>
				<span>
					<input type="hidden" name="id_match" value="{ID_MATCH}" />
					<!-- BEGIN editer --> 
					<input type="submit" name="edit_save" value="{editer.EDITER}" />
					<!-- END editer --> 
					<!-- BEGIN rajouter --> 
					<input type="submit" name="Submit" value="{rajouter.ENVOYER}" />
					<!-- END rajouter --> 
				</span>
			</p>
		</div>
	</form> 
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news">
		<!-- BEGIN match -->
		<form method="post" action="{ICI}"> 
			<input name="id_match" type="hidden" value="{match.FOR}"> 
			<h2 class="toggle_titre" onclick="toggle('{match.FOR}')"><input type="submit" name="del" value="{match.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />&nbsp;<input name="Editer" type="submit" value="{match.EDITER}" />&nbsp;{match.CONTRE} {match.CLAN}<a name="{match.FOR}"></a></h2>
		</form> 
		<div id="toggle_{match.FOR}" style="display:none">
			<ul class="header">
				<li>{TXT_DATE} :<span class="reponce">{match.DATE}</span></li>
				<li>{TXT_HEURE} :<span class="reponce">{match.HEURE}</span></li>
				<li>{match.CONTRE} :<span class="reponce">{match.CLAN}</span></li>
				<li>{TXT_NBR_JOUEUR} :<span class="reponce">{match.NB_JOUEURS}/{match.SUR}</span></li>
				<li>{TXT_HEURE_CHAT} :<span class="reponce">{match.CHAT}</span></li>
				<li>{match.TXT_SECTION} :<span class="reponce">{match.SECTION}</span></li>
			</ul>{match.INFO}
			<h3>{match.TEAM_OK}</h3> 
			<!-- BEGIN ok --> 
			<form method="post" action="{ICI}#{match.FOR}">
				<span><input name="demande" type="submit" value="{match.ADD_TEAM_DEMANDE}" /><input name="reserve" type="submit" value="{match.ADD_TEAM_RESERVE}" /><input name="for" type="hidden" value="{match.ok.ID}" /></span>
				<span>{match.ok.NOM}</span>
			</form>
			<!-- END ok -->
			<h3>{match.TEAMS_RESERVE}</h3> 
			<!-- BEGIN reserve --> 
			<form method="post" action="{ICI}#{match.FOR}">
				<span><input name="demande" type="submit" value="{match.ADD_TEAM_DEMANDE}" /><input name="for" type="hidden" value="{match.reserve.ID}" /><input name="ok" type="submit" value="{match.ADD_TEAM_OK}" /></span>
				<span>{match.reserve.NOM}</span>
			</form>
			<!-- END reserve -->
			<h3>{match.TEAM_DEMANDE}</h3> 
			<!-- BEGIN demande --> 
			<form method="post" action="{ICI}#{match.FOR}">
				<span><input name="ok" type="submit" value="{match.ADD_TEAM_OK}" /><input name="for" type="hidden" value="{match.demande.ID}" /><input name="reserve" type="submit" value="{match.ADD_TEAM_RESERVE}" /></span>
				<span>{match.demande.NOM}</span>
			</form>
			<!-- END demande -->
		  </div>
		<!-- END match -->
		<!-- BEGIN no_match -->
		{no_match.TXT}
		<!-- END no_match -->
		</div>
	</div>
</div>