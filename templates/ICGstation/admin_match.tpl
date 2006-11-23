<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span>
				<label for="class">{TXT_MATCH_CLASS}&nbsp;:</label>
				</span>
				<span>
					<input name="class" type="text" id="class" value="{CLASS}" onblur="formverif(this.id,'nbr','3')" />
					<select name="pre-class" id="pre-class" onchange="trouve('class').value = this.value;">
						<option value="">{CHOISIR_CLASS}</option>
						<!-- BEGIN liste_class -->
						<option value="{liste_class.VALEUR}">{liste_class.VALEUR}</option>
						<!-- END liste_class -->
					</select> ({OPTIONNEL})
				</span>
			</p>
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
				<span><input name="joueur" id="joueur" type="text" value="{NOMBRE_J}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','')" /></span>
			</p>
			<p>
				<span>
					<label for="liste_map[0]">{TXT_MAP}&nbsp;:</label>
				</span>
				<span>
					<a href="{TXT_ADD_MAP_URL}">{TXT_ADD_MAP}</a>
					<ul>
						<!-- BEGIN liste_map -->
						<li>
							<select name="liste_map[{liste_map.ID}]" id="liste_map[{liste_map.ID}]" onblur="formverif(this.id,'change','-1')"> 
								<option value="-1">{CHOISIR}</option> 
								<!-- BEGIN map_select --> 
								<option value="{liste_map.map_select.ID}" {liste_map.map_select.SELECTED}>{liste_map.map_select.VALEUR}</option> 
								<!-- END map_select --> 
							</select>
						</li>
						<!-- END liste_map -->
						<!-- BEGIN liste_map_last -->
						<li>
							<select name="liste_map[{liste_map_last.ID}]" id="liste_map[{liste_map_last.ID}]" onblur="formverif(this.id,'change','-1')"> 
								<option value="-1">{CHOISIR}</option> 
								<!-- BEGIN map_select --> 
								<option value="{liste_map_last.map_select.ID}" {liste_map_last.map_select.SELECTED}>{liste_map_last.map_select.VALEUR}</option> 
								<!-- END map_select --> 
							</select>
							<input type="submit" name="add_map" value="{liste_map_last.ADD}" /><input type="submit" name="dell_map" value="{liste_map_last.DELL}" />
						</li>
						<!-- END liste_map_last -->
					</ul>
				</span>
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
				<span><label for="infoe">{MSG_PRIVE}&nbsp;:</label></span>
			</p>
			<p>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','priver')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more_prive', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more_prive" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','priver')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="priver" cols="40" rows="10" id="priver" onblur="formverif(this.id,'nbr','10')">{PRIVER}</textarea></div>
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
		</form>
	</div>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news">
		<!-- BEGIN class -->
		<h2>{class.TITRE}</h2>
		<!-- BEGIN match -->
		<form method="post" action="{ICI}"> 
			<input name="id_match" type="hidden" value="{class.match.FOR}"> 
			<h2 class="toggle_titre"><input value="{VOIR}" name="voir_{class.match.FOR}" type="button" onClick="toggle('{class.match.FOR}')"> <input type="submit" name="del" value="{SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />&nbsp;<input name="Editer" type="submit" value="{EDITER}" />&nbsp;{class.match.CONTRE} {class.match.CLAN}<a name="{class.match.FOR}"></a></h2>
		</form> 
		<div id="toggle_{class.match.FOR}" style="display:none">
			<p>
				<span class="nom_liste">{TXT_DATE} :</span>
				<span class="reponce">{class.match.DATE}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_HEURE} :</span>
				<span class="reponce">{class.match.HEURE}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_NBR_JOUEUR} :</span>
				<span class="reponce">{class.match.NB_JOUEURS}/{class.match.SUR}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_HEURE_CHAT} :</span>
				<span class="reponce">{class.match.CHAT}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_SECTION} :</span>
				<span class="reponce">{class.match.SECTION}</span>
			</p>
			<p>
				<span class="nom_liste">{VOIR} :</span>
				<span class="reponce">{class.match.INFO}</span>
			</p>
			<p>
				<span class="nom_liste">{MSG_PRIVE} :</span>
				<span class="reponce">{class.match.PRIVER}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_MAP} :</span>
				<span class="reponce">
					<ul>
						<!-- BEGIN map_list -->
						<li>{class.match.map_list.NOM}</li>
						<!-- END map_list -->
					</ul>
				</span>
			</p>
			<h3>{TEAM_OK}</h3> 
			<!-- BEGIN ok --> 
			<form method="post" action="{ICI}#{class.match.FOR}">
				<span><input name="demande" type="submit" value="{ADD_TEAM_DEMANDE}" /><input name="reserve" type="submit" value="{ADD_TEAM_RESERVE}" /><input name="for" type="hidden" value="{class.match.ok.ID}" /></span>
				<span>{class.match.ok.NOM}</span>
			</form>
			<!-- END ok -->
			<h3>{TEAMS_RESERVE}</h3> 
			<!-- BEGIN reserve --> 
			<form method="post" action="{ICI}#{class.match.FOR}">
				<span><input name="demande" type="submit" value="{ADD_TEAM_DEMANDE}" /><input name="for" type="hidden" value="{class.match.reserve.ID}" /><input name="ok" type="submit" value="{ADD_TEAM_OK}" /></span>
				<span>{class.match.reserve.NOM}</span>
			</form>
			<!-- END reserve -->
			<h3>{TEAM_DEMANDE}</h3> 
			<!-- BEGIN demande --> 
			<form method="post" action="{ICI}#{class.match.FOR}">
				<span><input name="ok" type="submit" value="{ADD_TEAM_OK}" /><input name="for" type="hidden" value="{class.match.demande.ID}" /><input name="reserve" type="submit" value="{ADD_TEAM_RESERVE}" /></span>
				<span>{class.match.demande.NOM}</span>
			</form>
			<!-- END demande -->
		  </div>
		<!-- END match -->
		<!-- END class -->
		<!-- BEGIN no_match -->
		{no_match.TXT}
		<!-- END no_match -->
		</div>
	</div>
</div>