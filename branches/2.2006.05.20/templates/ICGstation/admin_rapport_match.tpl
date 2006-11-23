<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="importation">{IMPORTATION}&nbsp;:</label></span>
				<span>
					<select name="importation" id="importation" onblur="formverif(this.id,'change','nul')">
						<option value="nul" selected="selected">{CHOISIR}</option>
						<!-- BEGIN liste_match -->
						<option value="{liste_match.ID_MATCH}" {liste_match.SELECTED}>{liste_match.NOM_MATCH}</option>
						<!-- END liste_match -->
						<!-- BEGIN group -->
						<optgroup label="{group.TITRE}">
							<!-- BEGIN liste_match -->
							<option value="{group.liste_match.ID_MATCH}" {group.liste_match.SELECTED}>{group.liste_match.NOM_MATCH}</option>
							<!-- END liste_match -->
						</optgroup>
						<!-- END group -->
				  	</select>
					<input type="submit" name="Submit" value="{ENVOYER}" />
					<input name="id_match_imp" type="hidden" value="{ID_MATCH_IMP}" />
				</span>
			</p>
			<p>
				<span><label for="del_match">{DELL_IMPORTE}&nbsp;:</label></span>
				<span><input name="del_match" type="checkbox" id="del_match" value="oui" {CHECKED} /></span>
			</p>
			<p>
				<span><label for="jj">{DATE}&nbsp;:</label></span>
				<span><input name="jj" type="text" id="jj" value="{JJ}" size="2" onblur="formverif(this.id,'chiffre','31')" />/<input name="mm" type="text" id="mm" value="{MM}" size="2" onblur="formverif(this.id,'chiffre','12')" />/<input name="aaaa" type="text" id="aaaa" value="{AAAA}" size="4" onblur="formverif(this.id,'chiffre','')" /></span>
			</p>
			<p>
				<span><label for="clan">{CONTRE}&nbsp;:</label></span>
				<span><input name="clan" type="text" id="clan" value="{CLAN}" onblur="formverif(this.id,'nbr','2')" /></span>
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
							</select><br />
							{PT_NOUS} : <input name="pt_nous[{liste_map.ID}]" type="text" id="pt_nous[{liste_map.ID}]" onblur="formverif(this.id,'chiffre','')" value="{liste_map.PT_NOUS}" size="4" maxlength="4" />
							{PT_EUX} : <input name="pt_eux[{liste_map.ID}]" type="text" id="pt_eux[{liste_map.ID}]" value="{liste_map.PT_EUX}" onblur="formverif(this.id,'chiffre','')" size="4" maxlength="4" />
						</li>
						<!-- END liste_map -->
						<!-- BEGIN liste_map_last -->
						<li>
							<select name="liste_map[{liste_map_last.ID}]" id="liste_map[{liste_map_last.ID}]" onblur="formverif(this.id,'change','-1')"> 
								<option value="-1">{CHOISIR}</option> 
								<!-- BEGIN map_select --> 
								<option value="{liste_map_last.map_select.ID}" {liste_map_last.map_select.SELECTED}>{liste_map_last.map_select.VALEUR}</option> 
								<!-- END map_select --> 
							</select><br />
							{PT_NOUS} : <input name="pt_nous[{liste_map_last.ID}]" type="text" id="pt_nous[{liste_map_last.ID}]" onblur="formverif(this.id,'chiffre','')" value="{liste_map_last.PT_NOUS}" size="4" maxlength="4" />
							{PT_EUX} : <input name="pt_eux[{liste_map_last.ID}]" type="text" id="pt_eux[{liste_map_last.ID}]" value="{liste_map_last.PT_EUX}" onblur="formverif(this.id,'chiffre','')" size="4" maxlength="4" /><br />
							<input type="submit" name="add_map" value="{liste_map_last.ADD}" /><input type="submit" name="dell_map" value="{liste_map_last.DELL}" />
						</li>
						<!-- END liste_map_last -->
					</ul>
				</span>
			</p>
			<p>
				<span><label for="information">{DETAILS}&nbsp;:</label></span>
			</p>
			<p>
		  <div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','information')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','information')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
		  </div>
				<div class="big_texte"><textarea name="information" cols="40" rows="10" id="information" onblur="formverif(this.id,'nbr','10')">{INFO}</textarea></div>
			</p>
			<p>
				<span><label for="score_clan">{SCORE}&nbsp;:</label></span>
				<span><input name="score_clan" type="text" id="score_clan" value="{SCORE_NOUS}" size="2" onblur="formverif(this.id,'chiffre','')" /> -- <input name="score_mechant" type="text" id="score_mechant" value="{SCORE_MECHANT}" size="2" onblur="formverif(this.id,'chiffre','')"></span>
			</p>
			<p>
				<span><label for="section">{SECTION}&nbsp;:</label></span>
				<span>
					<select name="section" id="section" onblur="formverif(this.id,'change','')">
						<option value"">{CHOISIR}</option>
						<option value="0" {SELECTED_ALL}>{ALL_SECTION}</option>
						<!-- BEGIN section -->
						<option value="{section.ID}" {section.SELECTED}>{section.NOM}</option>
						<!-- END section -->
					</select>
				</span>
			</p>
			<p>
				<span>
					<input name="for" type="hidden" value="{ID}" />
					<!-- BEGIN editer -->
					<input name="edit" type="submit" value="{editer.EDITER}" />
					<!-- END editer -->
					<!-- BEGIN rajouter -->
					<input name="envoyer" type="submit" value="{rajouter.ENVOYER}" />
					<!-- END rajouter -->
				</span>
			</p>
		</form>
	</div>
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<div class="news">
			<table class="table">
				<thead>
					<tr>
						<th>{DATE}</th>
						<th>{CONTRE}</th>
						<th>{SCORE}</th>
						<th>{DETAILS}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste -->
					<tr>
						<td>{liste.DATE}</td>
						<td>{liste.CLAN} -- {liste.SECTION}</td>
						<td>{liste.SCORE_MECHANT} -- {liste.SCORE_NOUS}</td>
						<td>{liste.INFO}</td>
						<td>
							<form method="post" action="{ICI}">
								<input name="supprimer" type="submit" id="Supprimer" value="{liste.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="id" type="hidden" id="id" value="{liste.ID}" />
								<input name="Editer" type="submit" id="Editer" value="{liste.EDITER}" />
							</form>
						</td>
					</tr>
					<!-- END liste -->
				</tbody>
			</table>
		</div>
	</div>
</div>