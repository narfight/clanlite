<form action="{ICI}" method="post"> 
	<div class="big_cadre">
		<h1>{TITRE}</h1>
		<div class="big_cadre">
			<h1>{TITRE_CONFIG_BASE}</h1>
			<div class="visible">
				<p>
					<span><label for="tag">{TXT_TAG}&nbsp;:</label></span>
					<span><input name="tag" id="tag" type="text" value="{TAG}" onblur="formverif(this.id,'nbr','3')" /></span>
				</p>
				<p>
					<span><label for="nom_clan">{TXT_NOM_CLAN}&nbsp;:</label></span>
					<span><input name="nom_clan" type="text" id="nom_clan" value="{NOM_CLAN}" onblur="formverif(this.id,'nbr','3')" /></span>
				</p>
				<p>
					<span><label for="id_membre_match">{TXT_USER_MATCH}&nbsp;:</label></span>
					<span>
						<select name="id_membre_match" id="id_membre_match" onblur="formverif(this.id,'autre','')"> 
							<option value"">{TXT_CHOISIR}</option> 
							<!-- BEGIN list_membre_match --> 
							<option value="{list_membre_match.ID}" {list_membre_match.SELECTED_ID_MATCH}>{list_membre_match.NOM}</option> 
							<!-- END list_membre_match --> 
						</select>
					</span>
				</p>
				<p>
					<span><label for="show_grade">{TXT_SHOW_GRADE}&nbsp;:</label></span>
					<span>
						<select name="show_grade" id="show_grade" onblur="formverif(this.id,'autre','')" onchange="toggle_msg('limite_inscription_div', this.id, '2', 'value')"> 
							<option value"">{TXT_CHOISIR}</option> 
							<option value="1" {SHOW_GRADE_1}>{TXT_OUI}</option> 
							<option value="0" {SHOW_GRADE_0}>{TXT_NON}</option> 
						</select>
					</span>
				</p>
				<p>
					<span><label for="master_mail">{TXT_MAIL}&nbsp;:</label></span>
					<span><input name="master_mail" type="text" id="master_mail" value="{MAIL}" onblur="formverif(this.id,'mail','')" /></span>
				</p>
				<p>
					<span><label for="reglement">{TXT_REGLEMENT}&nbsp;:</label></span>
				</p>
				<p>
					<div class="bt-bbcode">
						<!-- BEGIN bt_bbcode_liste -->
						<input type="button" onmouseup="bbcode_insert('{bt_bbcode_liste.START}','{bt_bbcode_liste.END}', 'reglement');" title="{bt_bbcode_liste.HELP}"  value="{bt_bbcode_liste.INDEX}" />
						<!-- END bt_bbcode_liste -->				
					</div>
					<div class="smilies">
						<!-- BEGIN poste_smilies_liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.TXT}','reglement')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
						<!-- BEGIN more -->
						<a href="javascript:toggle_msg('smilies_more_reglement', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
						<div id="smilies_more_reglement" style="display: none;">
							<!-- BEGIN liste -->
							<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','reglement')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
							<!-- END liste -->
						</div>
						<!-- END more -->
						<!-- END poste_smilies_liste -->
					</div>
					<div class="big_texte"><textarea name="reglement" cols="40" rows="10" id="reglement" onblur="formverif(this.id,'nbr','20')">{REGLEMENT}</textarea></div>
				</p>
				<p>
					<span><input type="submit" name="Submit" value="{BT_EDITER}" /></span>
				</p>
			</div>
		</div>
		<div class="big_cadre">
			<h1>{TITRE_INSCRIPTION}</h1>
			<div class="visible">
				<p>
					<span><label for="msg_bienvenu">{TXT_MSG_BIENVENU}&nbsp;:</label></span>
				</p>
				<p>
					<div class="bt-bbcode">
						<!-- BEGIN bt_bbcode_liste -->
						<input type="button" onmouseup="bbcode_insert('{bt_bbcode_liste.START}','{bt_bbcode_liste.END}', 'msg_bienvenu');" title="{bt_bbcode_liste.HELP}"  value="{bt_bbcode_liste.INDEX}" />
						<!-- END bt_bbcode_liste -->				
					</div>
					<div class="smilies">
						<!-- BEGIN poste_smilies_liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.TXT}','msg_bienvenu')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
						<!-- BEGIN more -->
						<a href="javascript:toggle_msg('smilies_more_msg_bienvenu', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
						<div id="smilies_more_msg_bienvenu" style="display: none;">
							<!-- BEGIN liste -->
							<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','msg_bienvenu')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
							<!-- END liste -->
						</div>
						<!-- END more -->
						<!-- END poste_smilies_liste -->
					</div>
					<div class="big_texte"><textarea name="msg_bienvenu" cols="40" rows="10" id="msg_bienvenu" onblur="formverif(this.id,'nbr','20')">{MSG_BIENVENU}</textarea></div>
				</p>
				<p>
					<span><label for="inscription">{TXT_INSCRI}&nbsp;:</label></span>
					<span>
						<select name="inscription" id="inscription" onblur="formverif(this.id,'autre','')" onchange="toggle_msg('limite_inscription_div', this.id, '2', 'value')"> 
							<option value"">{TXT_CHOISIR}</option> 
							<option value="1" {SELECT_INSCI_1}>{TXT_OUI}</option> 
							<option value="0" {SELECT_INSCI_0}>{TXT_NON}</option> 
							<option value="2" {SELECT_INSCI_2}>{TXT_INSCRI_LIMIT}</option> 
						</select>
					</span>
				</p>
				<div id="limite_inscription_div">
					<p>
						<span><label for="limite_inscription">{TXT_LIMITE}&nbsp;:</label></span>
						<span><input name="limite_inscription" type="text" id="limite_inscription" value="{LIMITE}" size="2" onblur="formverif(this.id,'chiffre','')" /></span>
					</p>
				</div>
				<p>
					<span><label for="recrutement_alert">{TXT_RECRUTEMENT_ALERT}&nbsp;:</label></span>
					<span>
						<select name="recrutement_alert" id="recrutement_alert" onblur="formverif(this.id,'autre','')">
							<option value"">{TXT_CHOISIR}</option> 
							<option value="1" {RECRUTEMENT_ALERT_OUI}>{TXT_OUI}</option>
							<option value="0" {RECRUTEMENT_ALERT_NON}>{TXT_NON}</option>
						</select>
					</span>
				</p>
				<p>
					<span><input type="submit" name="Submit" value="{BT_EDITER}" /></span>
				</p>
			</div>
		</div>
		<div class="big_cadre">
			<h1>{TITRE_CONFIG_AVANCEE}</h1>
			<div class="visible">
				<p>
					<span><label for="site_domain">{TXT_URL_SITE_DOMAIN}&nbsp;:</label></span>
					<span><input name="site_domain" type="text" id="site_domain" value="{URL_SITE_DOMAIN}" onblur="formverif(this.id,'nbr','3')" /></span>
				</p>
				<p>
					<span><label for="site_path">{TXT_URL_SITE_PATH}&nbsp;:</label></span>
					<span><input name="site_path" type="text" id="site_path" value="{URL_SITE_PATH}" onblur="formverif(this.id,'nbr','3')" /></span>
				</p>
				<p>
					<span><label for="url_forum">{TXT_URL_FORUM}&nbsp;:</label></span>
					<span><input name="url_forum" type="text" id="url_forum" value="{URL_FORUM}" onblur="formverif(this.id,'nbr','3')" /></span>
				</p>
				<p>
					<span><label for="time_cook">{TXT_TIME_COOK}&nbsp;:</label></span>
					<span><input name="time_cook" type="text" id="time_cook" value="{TIME_COOK}" maxlength="10" onblur="formverif(this.id,'chiffre','')" /></span>
				</p>
				<p>
					<span><label for="langue">{TXT_LANGUE}&nbsp;:</label></span>
					<span>
						<select name="langue" id="langue" onblur="formverif(this.id,'autre','')">
							<option value"">{TXT_CHOISIR}</option> 
							<!-- BEGIN langue -->
							<option value="{langue.VALUE}" {langue.SELECTED}>{langue.NAME}</option>
							<!-- END langue -->
						</select>
					</span>
				</p>
				<p>
					<span><label for="skin">{TXT_SKIN}&nbsp;:</label></span>
					<span>
						<select name="skin" id="skin" onblur="formverif(this.id,'autre','')">
							<!-- BEGIN skin -->
							<option value="{skin.VALUE}" {skin.SELECTED}>{skin.NAME}</option>
							<!-- END skin -->
						</select>
					</span>
				</p>
				<p>
					<span><label for="objet_par_page">{TXT_OBJET_PAR_PAGE}&nbsp;:</label></span>
					<span><input name="objet_par_page" type="text" id="objet_par_page" value="{OBJET_PAR_PAGE}" size="4" maxlength="3" onblur="formverif(this.id,'chiffre','60')"> <img src="../images/smilies/question.gif" onmouseover="poplink('{TXT_HELP_OBJET_PAR_PAGE}',event)" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></span>
				</p>
				<p>
					<span><label for="scan_game_server">{TXT_SCAN_GAME_SERVER}&nbsp;:</label></span>
					<span>
						<select name="scan_game_server" id="scan_game_server" onblur="formverif(this.id,'autre','')">
							<option value"">{TXT_CHOISIR}</option> 
							<option value="udp" {SELECT_SCAN_UDP}>{TXT_SCAN_GAME_SERVER_UDP}</option>
							<option value="http" {SELECT_SCAN_HTTP}>{TXT_SCAN_GAME_SERVER_HTTP}</option>
						</select><img src="../images/smilies/question.gif" onmouseover="poplink('{TXT_HELP_SCAN_GAME_SERVER}',event)" onmouseout="kill_poplink()" alt="{ALT_AIDE}" />
					</span>
				</p>
				<p>
					<span><label for="refresh">{TXT_REFRESH}&nbsp;:</label></span>
					<span><input name="refresh" type="text" id="refresh" value="{REFRESH}" size="4" maxlength="3" onblur="formverif(this.id,'chiffre','60')"> <img src="../images/smilies/question.gif" onmouseover="poplink('{TXT_HELP_REFRESH}',event)" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></span>
				</p>
				<p>
					<span><label for="time_zone">{TXT_TIME_ZONE}&nbsp;:</label></span>
					<span>
						<select name="time_zone" id="time_zone" onblur="formverif(this.id,'autre','')">
							<option value"">{TXT_CHOISIR}</option> 
							<option value="-12" {TIME_ZONE_-12}>{TXT_TIME_ZONE_-12}</option>
							<option value="-11" {TIME_ZONE_-11}>{TXT_TIME_ZONE_-11}</option>
							<option value="-10" {TIME_ZONE_-10}>{TXT_TIME_ZONE_-10}</option>
							<option value="-9" {TIME_ZONE_-9}>{TXT_TIME_ZONE_-9}</option>
							<option value="-8" {TIME_ZONE_-8}>{TXT_TIME_ZONE_-8}</option>
							<option value="-7" {TIME_ZONE_-7}>{TXT_TIME_ZONE_-7}</option>
							<option value="-6" {TIME_ZONE_-6}>{TXT_TIME_ZONE_-6}</option>
							<option value="-5" {TIME_ZONE_-5}>{TXT_TIME_ZONE_-5}</option>
							<option value="-4" {TIME_ZONE_-4}>{TXT_TIME_ZONE_-4}</option>
							<option value="-3.5" {TIME_ZONE_-3_5}>{TXT_TIME_ZONE_-3_5}</option>
							<option value="-3" {TIME_ZONE_-3}>{TXT_TIME_ZONE_-3}</option>
							<option value="-2" {TIME_ZONE_-2}>{TXT_TIME_ZONE_-2}</option>
							<option value="-1" {TIME_ZONE_-1}>{TXT_TIME_ZONE_-1}</option>
							<option value="0" {TIME_ZONE_0}>{TXT_TIME_ZONE_0}</option>
							<option value="1" {TIME_ZONE_1}>{TXT_TIME_ZONE_1}</option>
							<option value="2" {TIME_ZONE_2}>{TXT_TIME_ZONE_2}</option>
							<option value="3" {TIME_ZONE_3}>{TXT_TIME_ZONE_3}</option>
							<option value="3.5" {TIME_ZONE_3_5}>{TXT_TIME_ZONE_3_5}</option>
							<option value="4" {TIME_ZONE_4}>{TXT_TIME_ZONE_4}</option>
							<option value="4.5" {TIME_ZONE_4_5}>{TXT_TIME_ZONE_4_5}</option>
							<option value="5" {TIME_ZONE_5}>{TXT_TIME_ZONE_5}</option>
							<option value="5.5" {TIME_ZONE_5_5}>{TXT_TIME_ZONE_5_5}</option>
							<option value="5.75" {TIME_ZONE_5_75}>{TXT_TIME_ZONE_5_75}</option>
							<option value="6" {TIME_ZONE_6}>{TXT_TIME_ZONE_6}</option>
							<option value="6.5" {TIME_ZONE_6_5}>{TXT_TIME_ZONE_6_5}</option>
							<option value="7" {TIME_ZONE_7}>{TXT_TIME_ZONE_7}</option>
							<option value="8" {TIME_ZONE_8}>{TXT_TIME_ZONE_8}</option>
							<option value="9" {TIME_ZONE_9}>{TXT_TIME_ZONE_9}</option>
							<option value="9.5" {TIME_ZONE_9_5}>{TXT_TIME_ZONE_9_5}</option>
							<option value="10" {TIME_ZONE_10}>{TXT_TIME_ZONE_10}</option>
							<option value="11" {TIME_ZONE_11}>{TXT_TIME_ZONE_11}</option>
							<option value="12" {TIME_ZONE_12}>{TXT_TIME_ZONE_12}</option>
							<option value="13" {TIME_ZONE_13}>{TXT_TIME_ZONE_13}</option>
						</select>
					</span>
				</p>
				<p>
					<span><label for="heure_ete">{TXT_HEURE_ETE}&nbsp;:</label></span>
					<span>
						<select name="heure_ete" id="heure_ete" onblur="formverif(this.id,'autre','')">
							<option value"">{TXT_CHOISIR}</option> 
							<option value="1" {HEURE_ETE_1}>{TXT_OUI}</option>
							<option value="0" {HEURE_ETE_0}>{TXT_NON}</option>
						</select>
					</span>
				</p>
				<p>
					<span><input type="submit" name="Submit" value="{BT_EDITER}" /></span>
				</p>
			</div>
		</div>
		<div class="big_cadre">
			<h1>{TXT_SEND_MAIL_TITRE}</h1>
			<div class="visible">
				<p>
					<span><label for="send_mail">{TXT_SEND_MAIL}&nbsp;:</label></span>
					<span>
						<select name="send_mail" id="send_mail" onblur="formverif(this.id,'autre','')" onchange="toggle_msg('partie_smtp', this.id, 'smtp', 'value')">
							<option value"">{TXT_CHOISIR}</option> 
							<option value="php" {SEND_MAIL_PAR_PHP}>{TXT_SEND_PHP}</option>
							<option value="smtp" {SEND_MAIL_PAR_SMTP}>{TXT_SEND_SMTP}</option>
						</select>
					</span>
				</p>
				<div id="partie_smtp">
					<p>
						<span><label for="smtp_ip">{TXT_SMTP_IP}&nbsp;:</label></span>
						<span><input name="smtp_ip" type="text" id="smtp_ip" value="{SMTP_IP}" onblur="formverif(this.id,'nbr','9')" /></span>
					</p>
					<p>
						<span><label for="smtp_port">{TXT_SMTP_PORT}&nbsp;:</label></span>
						<span><input name="smtp_port" type="text" id="smtp_port" value="{SMTP_PORT}" onblur="formverif(this.id,'nbr','9')" /></span>
					</p>
					<p>
						<span><label for="smtp_login">{TXT_SMTP_LOGIN}&nbsp;:</label></span>
						<span><input name="smtp_login" type="text" id="smtp_login" value="{SMTP_LOGIN}" onblur="formverif(this.id,'nbr','9')" /></span>
					</p>
					<p>
						<span><label for="smtp_code">{TXT_SMTP_CODE}&nbsp;:</label></span>
						<span><input name="smtp_code" type="text" id="smtp_code" value="{SMTP_CODE}" onblur="formverif(this.id,'nbr','9')" /></span>
					</p>
				</div>
				<p>
					<span><input type="submit" name="Submit" value="{BT_EDITER}" /></span>
				</p>
			</div>
		</div>
	</div>
</form>
<SCRIPT language="JavaScript">
	<!--
	toggle_msg('partie_smtp', 'send_mail', 'smtp', 'value');
	toggle_msg('limite_inscription_div', 'inscription', '2', 'value');
	-->
</script> 