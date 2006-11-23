<form action="config.php" method="post" name="config" id="config"> 
	<div class="big_cadre">
		<h1>{TITRE}</h1>
		<p>
			<span><label for="tag">{TXT_TAG}&nbsp;:</label></span>
			<span><input name="tag" id="tag" type="text" value="{TAG}" onBlur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="nom_clan">{TXT_NOM_CLAN}&nbsp;:</label></span>
			<span><input name="nom_clan" type="text" id="nom_clan" value="{NOM_CLAN}" onBlur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="site_domain">{TXT_URL_SITE_DOMAIN}&nbsp;:</label></span>
			<span><input name="site_domain" type="text" id="site_domain" value="{URL_SITE_DOMAIN}" onBlur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="site_path">{TXT_URL_SITE_PATH}&nbsp;:</label></span>
			<span><input name="site_path" type="text" id="site_path" value="{URL_SITE_PATH}" onBlur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="url_forum">{TXT_URL_FORUM}&nbsp;:</label></span>
			<span><input name="url_forum" type="text" id="url_forum" value="{URL_FORUM}" onBlur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="master_mail">{TXT_MAIL}&nbsp;:</label></span>
			<span><input name="master_mail" type="text" id="master_mail" value="{MAIL}" onBlur="formverif(this.id,'mail','')" /></span>
		</p>
		<p>
			<span><label for="serveur_game_ip">{TXT_SEND_MAIL}&nbsp;:</label></span>
			<span>
			<span>
				<select name="send_mail" id="send_mail" onBlur="formverif(this.id,'autre','')" onChange="toggle_msg('partie_smtp', this.id, 'smtp', 'value')">
					<option value="">{TXT_CHOISIR}</option> 
					<option value="php" {SEND_MAIL_PAR_PHP}>{TXT_SEND_PHP}</option>
					<option value="smtp" {SEND_MAIL_PAR_SMTP}>{TXT_SEND_SMTP}</option>
				</select>
			</span>
			</span>
		</p>
		<div id="partie_smtp">
			<p>
				<span><label for="smtp_ip">{TXT_SMTP_IP}&nbsp;:</label></span>
				<span><input name="smtp_ip" type="text" id="serveur_game_ip" value="{SMTP_IP}" size="12" onBlur="formverif(this.id,'nbr','9')" /></span>
			</p>
			<p>
				<span><label for="smtp_port">{TXT_SMTP_PORT}&nbsp;:</label></span>
				<span><input name="smtp_port" type="text" id="serveur_game_ip" value="{SMTP_PORT}" size="12" onBlur="formverif(this.id,'nbr','9')" /></span>
			</p>
			<p>
				<span><label for="smtp_login">{TXT_SMTP_LOGIN}&nbsp;:</label></span>
				<span><input name="smtp_login" type="text" id="serveur_game_ip" value="{SMTP_LOGIN}" size="12" onBlur="formverif(this.id,'nbr','9')" /></span>
			</p>
			<p>
				<span><label for="smtp_code">{TXT_SMTP_CODE}&nbsp;:</label></span>
				<span><input name="smtp_code" type="text" id="serveur_game_ip" value="{SMTP_CODE}" size="12" onBlur="formverif(this.id,'nbr','9')" /></span>
			</p>
		</div>
		<p>
			<span><label for="time_cook">{TXT_TIME_COOK}&nbsp;:</label></span>
			<span><input name="time_cook" type="text" id="time_cook" value="{TIME_COOK}" size="10" maxlength="10" onBlur="formverif(this.id,'chiffre','')" /></span>
		</p>
		<p>
			<span><label for="id_membre_match">{TXT_USER_MATCH}&nbsp;:</label></span>
			<span>
				<select name="id_membre_match" id="id_membre_match" onBlur="formverif(this.id,'autre','')"> 
					<option value="">{TXT_CHOISIR}</option> 
					<!-- BEGIN list_membre_match --> 
					<option value="{list_membre_match.ID}" {list_membre_match.SELECTED_ID_MATCH}>{list_membre_match.NOM}</option> 
					<!-- END list_membre_match --> 
				</select>
			</span>
		</p>
		<p>
			<span><label for="inscription">{TXT_INSCRI}&nbsp;:</label></span>
			<span>
				<select name="inscription" id="inscription" onBlur="formverif(this.id,'autre','')" onChange="toggle_msg('limite_inscription_div', this.id, '2', 'value')"> 
					<option value="">{TXT_CHOISIR}</option> 
					<option value="1" {SELECT_INSCI_1}>{TXT_OUI}</option> 
					<option value="0" {SELECT_INSCI_0}>{TXT_NON}</option> 
					<option value="2" {SELECT_INSCI_2}>{TXT_INSCRI_LIMIT}</option> 
				</select>
			</span>
		</p>
		<div id="limite_inscription_div">
			<p>
				<span><label for="limite_inscription">{TXT_LIMITE}&nbsp;:</label></span>
				<span><input name="limite_inscription" type="text" id="limite_inscription" value="{LIMITE}" size="2" onBlur="formverif(this.id,'chiffre','')" /></span>
			</p>
		</div>
		<p>
			<span><label for="recrutement_alert">{TXT_RECRUTEMENT_ALERT}&nbsp;:</label></span>
			<span>
				<select name="recrutement_alert" id="recrutement_alert" onBlur="formverif(this.id,'autre','')">
					<option value="">{TXT_CHOISIR}</option> 
					<option value="1" {RECRUTEMENT_ALERT_OUI}>{TXT_OUI}</option>
					<option value="0" {RECRUTEMENT_ALERT_NON}>{TXT_NON}</option>
				</select>
			</span>
		</p>
		<p>
			<span><label for="langue">{TXT_LANGUE}&nbsp;:</label></span>
			<span>
				<select name="langue" id="langue" onBlur="formverif(this.id,'autre','')">
					<option value="">{TXT_CHOISIR}</option> 
					<!-- BEGIN langue -->
					<option value="{langue.VALUE}" {langue.SELECTED}>{langue.NAME}</option>
					<!-- END langue -->
				</select>
			</span>
		</p>
		<p>
			<span><label for="skin">{TXT_SKIN}&nbsp;:</label></span>
			<span>
				<select name="skin" id="skin" onBlur="formverif(this.id,'autre','')">
					<option value="">{TXT_CHOISIR}</option> 
					<!-- BEGIN skin -->
					<option value="{skin.VALUE}" {skin.SELECTED}>{skin.NAME}</option>
					<!-- END skin -->
				</select>
			</span>
		</p>
		<p>
			<span><label for="objet_par_page">{TXT_OBJET_PAR_PAGE}&nbsp;:</label></span>
			<span><input name="objet_par_page" type="text" id="objet_par_page" value="{OBJET_PAR_PAGE}" size="4" maxlength="3" onBlur="formverif(this.id,'chiffre','60')"> <img src="../images/smilies/question.gif" onmouseover="poplink('{TXT_HELP_OBJET_PAR_PAGE}',event)" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></span>
		</p>
		<p>
			<span><label for="list_game_serveur">{TXT_LIST_GAME_SERVEUR}&nbsp;:</label></span>
			<span>
				<select name="list_game_serveur" id="list_game_serveur" onBlur="formverif(this.id,'autre','')">
					<option value="">{TXT_CHOISIR}</option> 
					<option value="oui" {LIST_GAME_SERVEUR_OUI}>{TXT_OUI}</option>
					<option value="non" {LIST_GAME_SERVEUR_NON}>{TXT_NON}</option>
				</select>
			</span>
		</p>
		<p>
			<span><label for="reglement">{TXT_MSG_BIENVENU}&nbsp;:</label></span>
		</p>
		<p>
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
			<div class="big_texte"><textarea name="reglement" cols="40" rows="10" id="reglement" onBlur="formverif(this.id,'nbr','20')">{REGLEMENT}</textarea></div>
		</p>
		<p>
			<span><label for="msg_bienvenu">{TXT_REGLEMENT}&nbsp;:</label></span>
		</p>
		<p>
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
			<div class="big_texte"><textarea name="msg_bienvenu" cols="40" rows="10" id="msg_bienvenu" onBlur="formverif(this.id,'nbr','20')">{MSG_BIENVENU}</textarea></div>
		</p>
		<p>
			<span><label for="serveur">{TXT_SERVEUR_GAME}&nbsp;:</label></span>
			<span>	
				<select name="serveur" id="serveur" onBlur="formverif(this.id,'autre','')" onChange="toggle_msg('partie_serveur', this.id, '1', 'value')"> 
					<option value="">{TXT_CHOISIR}</option> 
					<option value="1" {SERVEUR_GAME_OUI}>{TXT_OUI}</option> 
					<option value="0" {SERVEUR_GAME_NON}>{TXT_NON}</option> 
				</select>
			</span>
		</p>
		<div id="partie_serveur">
			<p>
				<span><label for="serveur_game_ip">{TXT_SERVEUR_GAME_IP}&nbsp;:</label></span>
				<span><input name="serveur_game_ip" type="text" id="serveur_game_ip" value="{SERVEUR_GAME_IP}" size="12" onBlur="formverif(this.id,'nbr','9')" /></span>
			</p>
			<p>
				<span><label for="serveur_game_port">{TXT_SERVEUR_GAME_PORT}&nbsp;:</label></span>
				<span><input name="serveur_game_port" type="text" id="serveur_game_port" value="{SERVEUR_GAME_PORT}" size="5" onBlur="formverif(this.id,'chiffre','')" /> <img src="../images/smilies/question.gif" onmouseover="poplink('{TXT_HELP_GAME_PORT}')" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></span>
			</p>
			<p>
				<span><label for="serveur_game_protocol">{TXT_SERVEUR_GAME_PROTOCOL}&nbsp;:</label></span>
				<span>
					<select name="serveur_game_protocol" id="serveur_game_protocol" onBlur="formverif(this.id,'autre','')"> 
						<option value="">{TXT_CHOISIR}</option> 
						<!-- BEGIN protocol_game_liste --> 
						<option value="{protocol_game_liste.VALUE}" {protocol_game_liste.SELECTED}>{protocol_game_liste.NAME}</option> 
						<!-- END protocol_game_liste --> 
					</select>
				</span>
			</p>
			<p>
				<span><label for="serveur_game_info">Message visible sur la page serveur&nbsp;:</label></span>
			</p>
			<p>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','serveur_game_info')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more_serveur_game_info', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more_serveur_game_info" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','serveur_game_info')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="serveur_game_info" cols="40" rows="10" id="serveur_game_info" onBlur="formverif(this.id,'nbr','5')">{SERVEUR_GAME_INFO}</textarea></div>
			</p>
		</div>
		<p>
			<span><input type="submit" name="Submit" value="{BT_EDITER}" /></span>
		</p>
	</div>
</form>
<SCRIPT language="JavaScript">
	<!--
	toggle_msg('partie_smtp', 'send_mail', 'smtp', 'value');
	toggle_msg('partie_serveur', 'serveur', '1', 'value');
	toggle_msg('limite_inscription_div', 'inscription', '2', 'value');
	-->
</script> 
