<form method="post" action="{ICI}">
	<input type="hidden" name="id" value="{ID}" />
	<!-- BEGIN admin -->
	<div class="big_cadre" id="simple">
		<h1>{admin.TITRE}</h1>
		<div class="visible">
			<p>
				<span><label for="pv">{admin.TXT_POUVOIR}&nbsp;:</label></span>
				<span>
					<select name="pv" id="pv" onblur="formverif(this.id,'autre','')">
						<option value"">{TXT_CHOISIR}</option>
						<option value="news" {admin.DESACTIVE_SELECT}>{admin.TXT_DESACTIVE}</option>
						<option value="user" {admin.USER_SELECT}>{admin.TXT_USER}</option> <option value="admin" {admin.ADMIN_SELECT}>{admin.TXT_ADMIN}</option>
					</select>*
				</span>
			</p>
			<!-- BEGIN grade -->
			<p>
				<span><label for="grade">{admin.grade.TXT_GRADE}&nbsp;:</label></span>
				<span>
					<select name="grade" id="grade" onblur="formverif(this.id,'autre','')">
						<option value"">{TXT_CHOISIR}</option>
						<!-- BEGIN grade_liste -->
						<option value="{admin.grade.grade_liste.ID}" {admin.grade.grade_liste.SELECTED}>{admin.grade.grade_liste.NOM}</option>
						<!-- END grade_liste -->
					</select>*
				</span>
			</p>
			<!-- END grade -->
			<!-- BEGIN no_grade -->
			<input name="grade" type="hidden" value="{admin.no_grade.GRADE}">
			<!-- END no_grade -->
			<p>
				<span><label for="team">{admin.TXT_SECTION}&nbsp;:</label></span>
				<span>
					<select name="section" id="section" onblur="formverif(this.id,'autre','')">
						<option value"">{TXT_CHOISIR}</option>
						<!-- BEGIN section -->
						<option value="{admin.section.ID}" {admin.section.SELECTED}>{admin.section.NOM}</option>
						<!-- END section -->
					</select>*
				</span>
			</p>
			<p>
				<span><label for="equipe">{admin.TXT_EQUIPE}&nbsp;:</label></span>
				<span>
					<select name="equipe" id="equipe" onblur="formverif(this.id,'autre','')">
						<option value"">{TXT_CHOISIR}</option>
						<!-- BEGIN equipe -->
						<option value="{admin.equipe.ID}" {admin.equipe.SELECTED}>{admin.equipe.NOM}</option>
						<!-- END equipe -->
					</select>*
				</span>
			</p>
			<p>
				<span><label for="roles">{admin.TXT_ROLE}&nbsp;:</label></span>
				<span><input name="roles" type="text" id="roles" value="{admin.ROLE}" onblur="formverif(this.id,'nbr','2')" />*</span>
			</p>
			<p>
				<span><label for="user_date">{admin.TXT_DATE}&nbsp;:</label></span>
				<span><input name="udate1" id="udate1" type="text" value="{admin.UJOURS}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','31')" />/<input name="udate2" id="udate2" type="text" value="{admin.UMOIS}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','12')" />/<input name="udate3" id="udate3" type="text" value="{admin.UANNEE}" size="4" maxlength="4" onblur="formverif(this.id,'chiffre','')" /></span>
			</p>
		</div>
	</div>
	<!-- END admin -->
	<div class="big_cadre" id="simple">
		<h1>{TITRE}</h1>
			<div class="visible">
			<p>
				<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom" id="nom" type="text" value="{NOM}" onblur="formverif(this.id,'nbr','2')" />*</span>
			</p>
			<p>
				<span><label for="prenom">{TXT_PRENOM}&nbsp;:</label></span>
				<span><input name="prenom" type="text" id="prenom" value="{PRENOM}" onblur="formverif(this.id,'nbr','2')" />*</span>
			</p>
			<p>
				<span><label for="user1">{TXT_LOGIN}&nbsp;:</label></span>
				<span><input type="text" name="user1" value="{LOGIN}" id="user1" onblur="formverif(this.id,'nbr','2')" />*</span>
			</p>
			<p>
				<span><label for="psw">{TXT_CODE}&nbsp;:</label></span>
				<span><input type="password" name="psw" id="psw" onblur="formverif(this.id,'nbr','2')" />*</span>
			</p>
			<p>
				<span><label for="psw2">{TXT_RE_CODE}&nbsp;:</label></span>
				<span><input type="password" name="psw2" id="psw2" onblur="formverif(this.id,'comparer','psw')" />*</span>
			</p>
			<p>
				<span><label for="mail">{TXT_MAIL}&nbsp;:</label></span>
				<span><input type="text" name="mail" value="{MAIL}" id="mail" onblur="formverif(this.id,'mail','')" />*</span>
			</p>
			<p>
				<span><label for="icq">{TXT_MSN}&nbsp;:</label></span>
				<span><input name="icq" type="text" id="icq" value="{MSN}" onblur="formverif(this.id,'mail','')" />*</span>
			</p>
			<p>
				<span><label for="sex homme">{TXT_SEX}&nbsp;:</label></span>
				<span><input type="radio" name="sex" id="sex homme" value="Homme" {HOMME} />{TXT_HOMME}<input type="radio" name="sex" id"sex femme" value="Femme" {FEMME} />{TXT_FEMME}*</span>
			</p>
			<p>
				<span><label for="age_d">{TXT_NAISSANCE}&nbsp;:</label></span>
				<span>
					<input name="age_d" id="age_d" type="text" value="{AGE_D}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','31')" />
					<input name="age_m" id="age_m" type="text" value="{AGE_M}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','12')" />
					<input name="age_y" id="age_y" type="text" value="{AGE_Y}" size="4" maxlength="4" onblur="formverif(this.id,'chiffre','')" />
					{DATE_FORMAT}*
				</span>
			</p>
			<p>
				<span><label for="langue_form">{TXT_LANGUE}&nbsp;:</label></span>
				<span>
					<select name="langue_form" id="langue_form" onblur="formverif(this.id,'autre','0')">
						<option value"">{TXT_CHOISIR}</option>
						<!-- BEGIN langue -->
						<option value="{langue.VALUE}" {langue.SELECTED}>{langue.NAME}</option>
						<!-- END langue -->
					</select>*
				</span>
			</p>
			<p>
				<span><label for="web">{TXT_WEB}&nbsp;:</label></span>
				<span><input name="web" id="web" type="text" value="{WEB}" onblur="formverif(this.id,'nbr','2')" /></span>
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
					<select name="arme" id="arme" onchange="document.images['img_arme'].src = '../images/armes/' + this.value;" onblur="formverif(this.id,'autre','0.gif')">
						<option value="0.gif">{TXT_CHOISIR}</option>
						<!-- BEGIN armes -->
						<option value="{armes.VALUE}" {armes.SELECTED}>{armes.NOM}</option>
						<!-- END armes -->
					</select>
					<img src="../images/armes/{ARME}" name="img_arme" id="img_arme" alt="{ALT_ARME}" />*
				</span>
			</p>
			<p>
				<span><label for="texte">{TXT_TEXTE}&nbsp;:</label></span>
				<span><input name="texte" id="texte" type="text" value="{TEXTE}" size="40" onblur="formverif(this.id,'nbr','2')" />*</span>
			</p>
			<p>
				<span><label for="perso">{TXT_IMAGE}&nbsp;:</label></span>
				<span>
					<select name="perso" id="perso" onchange="document.images['user_flag'].src = '../images/personnages/' + this.value;" onblur="formverif(this.id,'autre','0.gif')">
						<option value="0.gif">{TXT_CHOISIR}</option>
						<!-- BEGIN images -->
						<option value="{images.FICHIER}" {images.SELECTED}>{images.VALUE}</option>
						<!-- END images -->
					</select>
					<img src="../images/personnages/{IMAGE}" name="user_flag" id="user_flag" alt="{ALT_IMAGE}" />*
				</span>
			</p>
			<p>
				<span><label for="histoire">{TXT_HISTOIRE}&nbsp;:</label></span>
				<span><textarea name="histoire" id="histoire" cols="30" rows="4" onblur="formverif(this.id,'nbr','10')">{HISTOIRE}</textarea>*</span>
			</p>
			<p><input type="submit" name='Submit' value="{BT_ENVOYER}" /></p>
		</div>
	</div>
</form>