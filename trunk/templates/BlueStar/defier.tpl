<div class="big_cadre">
	<h1>{TITRE_DEFIT}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="mail_demande">{MAIL}&nbsp;:</label></span>
				<span><input name="mail_demande" type="text" id="mail_demande" onblur="formverif(this.id,'mail','')" value="{FORM_MAIL}" /></span>
			</p>
			<p>
				<span><label for="msn_demandeur">{MSN}&nbsp;:</label></span>
				<span><input name="msn_demandeur" type="text" id="msn_demandeur" onblur="formverif(this.id,'mail','')" value="{FORM_MSN}" /></span>
			</p>
			<p>
				<span><label for="clan">{NOM_CLAN_ADV}&nbsp;:</label></span>
				<span><input name="clan" type="text" id="clan" onblur="formverif(this.id,'nbr','2')" value="{FORM_CLAN}" /></span>
			</p>
			<p>
				<span><label for="url_clan">{URL_CLAN_ADV}&nbsp;:</label></span>
				<span><input name="url_clan" type="text" id="url_clan" onblur="formverif(this.id,'nbr','4')" value="{FORM_URL_CLAN}" /></span>
			</p>
			<p>
				<span><label for="jours">{DATE}&nbsp;:</label></span>
				<span>
					<select name="jours" id="jours" onblur="formverif(this.id,'autre','0')">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="5">4</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
						<option value="31">31</option>
						<option value="0" selected="selected">{JOUR}</option>
					</select>
					/
					<select name="mois" id="mois" onblur="formverif(this.id,'autre','-1')">
						<option value="-1">{MOIS}</option>
						<option value="1">{JANVIER}</option>
						<option value="2">{FEVRIER}</option>
						<option value="3">{MARS}</option>
						<option value="4">{AVRIL}</option>
						<option value="5">{MAI}</option>
						<option value="6">{JUIN}</option>
						<option value="7">{JUILLET}</option>
						<option value="8">{AOUT}</option>
						<option value="9">{SEPTEMBRE}</option>
						<option value="10">{OCTOBRE}</option>
						<option value="11">{NOVEMBRE}</option>
						<option value="12">{DECEMBRE}</option>
					</select>
				</span>
			</p>
			<p>
				<span><label for="heure">{HEURE_DEFIT}&nbsp;:</label></span>
				<span>
					<select name="heure" id="heure" onblur="formverif(this.id,'autre','0')">
						<option value="0">{HEURE}</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="5">4</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
					</select>
					:
					<select name="min" id="nim" onblur="formverif(this.id,'autre','-1')">
						<option value="-1">{MINUTE}</option>
						<option value="00">00</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
					</select>
				</span>
			</p>
			<p>
				<span><label for="psw">{NBR_JOUEUR}&nbsp;:</label></span>
				<span>
					<select name="joueurs" id="joueurs" onFocus="formverif(this.id,'autre','0')">
						<option value="0">{TXT_CHOISIR}</option>
						<!-- BEGIN liste_nbr_players -->
						<option value="{liste_nbr_players.NUM}" {liste_nbr_players.SELECTED}>{liste_nbr_players.NUM}</option>
						<!-- END liste_nbr_players -->
					</select>
				</span>
			</p>
			<p>
				<span><label for="info_match">{INFO_PLUS}&nbsp;:</label></span>
			</p>
			<p>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','info_match')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','info_match')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="info_match" id="info_match" cols="40" rows="10" onblur="formverif(this.id,'nbr','10')">{FORM_INFO_PLUS}</textarea></div>
			</p>
			<p>
				<span><input type="submit" name="submit" value="{ENVOYER}" /></span>
			</p>
	</form>
</div>