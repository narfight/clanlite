<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}" class="visible">
		<p>
			<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
			<span><input name="nom" id="nom" type="text" value="{NOM}" onblur="formverif(this.id, 'nbr', '4')" />*</span>
		</p>
		<p>
			<span><label for="prenom">{TXT_PRENOM}&nbsp;:</label></span>
			<span><input name="prenom" type="text" id="prenom" value="{PRENOM}" onblur="formverif(this.id, 'nbr', '2')" />*</span>
		</p>
		<p>
			<span><label for="user1">{TXT_LOGIN}&nbsp;:</label></span>
			<span><input type="text" name="user1" value="{LOGIN}" id="user1" onblur="formverif(this.id, 'nbr', '4')" />*</span>
		</p>
		<p>
			<span><label for="psw_news_user">{TXT_CODE}&nbsp;:</label></span>
			<span><input type="password" name="psw" id="psw_news_user" onblur="formverif(this.id, 'nbr', '1')" />*</span>
		</p>
		<p>
			<span><label for="psw2">{TXT_RE_CODE}&nbsp;:</label></span>
			<span><input type="password" name="psw2" id="psw2" onblur="formverif(this.id, 'comparer', 'psw')" />*</span>
		</p>
		<p>
			<span><label for="mail">{TXT_MAIL}&nbsp;:</label></span>
			<span><input type="text" name="mail" value="{MAIL}" id="mail" onblur="formverif(this.id, 'mail', '')" />*</span>
		</p>
		<p>
			<span><label for="icq">{TXT_MSN}&nbsp;:</label></span>
			<span><input name="icq" type="text" id="icq" value="{MSN}" onblur="formverif(this.id, 'mail', '')" />*</span>
		</p>
		<p>
			<span><label for="sex_homme">{TXT_SEX}&nbsp;:</label></span>
			<span><input type="radio" name="sex" id="sex_homme" value="Homme" {CHECKED_SEX_HOMME} />{TXT_HOMME}<input type="radio" name="sex" id="sex_femme" value="Femme" {CHECKED_SEX_FEMME} />{TXT_FEMME} *</span>
		</p>
		<p>
			<span><label for="age_d">{TXT_NAISSANCE}&nbsp;:</label></span>
			<span><input name="age_d" id="age_d" type="text" value="{AGE_D}" size="2" maxlength="2" onblur="formverif(this.id, 'chiffre', '31')" />
			<input name="age_m" id="age_m" type="text" value="{AGE_M}" size="2" maxlength="2" onblur="formverif(this.id, 'chiffre', '12')" />
			<input name="age_y" id="age_y" type="text" value="{AGE_Y}" size="4" maxlength="4" onblur="formverif(this.id, 'chiffre', '')" />
			{DATE_FORMAT}*</span>
		</p>
		<p>
			<span><label for="langue_form">{TXT_LANGUE}&nbsp;:</label></span>
			<span>
				<select name="langue_form" id="langue_form">
					<!-- BEGIN langue -->
					<option value="{langue.VALUE}" {langue.SELECTED} >{langue.NAME}</option>
					<!-- END langue -->
				</select>*
			</span>
		</p>
		<p>
			<span><label for="web">{TXT_WEB}&nbsp;:</label></span>
			<span><input name="web" id="web" type="text" value="{WEB}" onblur="formverif(this.id, 'nbr', '6')" /></span>
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
			<span><label for="heure_ete_1">{TXT_HEURE_ETE}&nbsp;:</label></span>
			<span><input type="radio" name="heure_ete" id="heure_ete_1" value="1" {CHECKED_HEURE_ETE_1} />{TXT_OUI}<input type="radio" name="heure_ete" id="heure_ete_0" value="0" {CHECKED_HEURE_ETE_0} />{TXT_NON} *</span>
		</p>
		<p>
			<span><label for="arme">{TXT_ARME}&nbsp;:</label></span>
			<span>
				<select name="arme" id="arme_select" onchange="document.images['arme'].src = '../images/armes/' + this.value;">
					<option value="0.gif">{TXT_CHOISIR}</option>
					<!-- BEGIN armes -->
					<option value="{armes.VALEUR}" {armes.SELECTED}>{armes.NOM}</option>
					<!-- END armes -->
				</select>
				<img src="../images/armes/{DEFAULT_ARMES}" id="arme" alt="{ALT_AMRE}" />*
			</span>
		</p>
		<p>
			<span><label for="texte">{TXT_TEXTE}&nbsp;:</label></span>
			<span><input name="texte" id="texte" type="text" value="{TEXTE}" size="40" onblur="formverif(this.id, 'nbr', '6')" />*</span>
		</p>
		<p>
			<span>
				<label for="perso">{TXT_IMAGE}&nbsp;:</label>
			</span>
			<span>
				<select name="perso" id="perso" onchange="document.images['user_flag'].src = '../images/personnages/' + this.value;">
					<option value="{DEFAULT_IMG}">{TXT_CHOISIR}</option>
					<!-- BEGIN images -->
					<option value="{images.FICHIER}" {images.SELECTED}>{images.FICHIER}</option>
					<!-- END images -->
				</select>
				<img src="../images/personnages/{DEFAULT_IMAGE}" id="user_flag"  alt="{ALT_IMAGE}" />*
			</span>
		</p>
		<p>
			<span><label for="histoire">{TXT_HISTOIRE}&nbsp;:</label></span>
		</p>
		<p>
			<div class="smilies">
				<!-- BEGIN poste_smilies_liste -->
				<a href="javascript:emoticon('{poste_smilies_liste.TXT}','histoire')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
				<!-- BEGIN more -->
				<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
				<div id="smilies_more" style="display: none;">
					<!-- BEGIN liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','histoire')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
					<!-- END liste -->
				</div>
				<!-- END more -->
				<!-- END poste_smilies_liste -->
			</div>
			<div class="big_texte"><textarea name="histoire" id="histoire" cols="40" rows="10" onblur="formverif(this.id, 'nbr', '10')">{HISTOIRE}</textarea>*</div>
		</p>
		<p><input {BLOCK} type="submit" name='Submit' value="{BT_ENVOYER}" /></p>
	</form>
</div>