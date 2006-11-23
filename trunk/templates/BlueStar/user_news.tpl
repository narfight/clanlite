<form method="post" action="new-user.php">
<div class="big_cadre">
	<h1>{TITRE}</h1>
	<p>
		<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
		<span><input name="nom" id="nom" type="text" value="{NOM}" onBlur="formverif(this.id, 'nbr', '4')" />*</span>
	</p>
	<p>
		<span><label for="prenom">{TXT_PRENOM}&nbsp;:</label></span>
		<span><input name="prenom" type="text" id="prenom" value="{PRENOM}" onBlur="formverif(this.id, 'nbr', '2')" />*</span>
	</p>
	<p>
		<span><label for="user1">{TXT_LOGIN}&nbsp;:</label></span>
		<span><input type="text" name="user1" value="{LOGIN}" id="user1" onBlur="formverif(this.id, 'nbr', '4')" />*</span>
	</p>
	<p>
		<span><label for="psw">{TXT_CODE}&nbsp;:</label></span>
		<span><input type="password" name="psw" id="psw" onBlur="formverif(this.id, 'nbr', '1')" />*</span>
	</p>
	<p>
		<span><label for="psw2">{TXT_RE_CODE}&nbsp;:</label></span>
		<span><input type="password" name="psw2" id="psw2" onBlur="formverif(this.id, 'comparer', 'psw')" />*</span>
	</p>
	<p>
		<span><label for="mail">{TXT_MAIL}&nbsp;:</label></span>
		<span><input type="text" name="mail" value="{MAIL}" id="mail" onBlur="formverif(this.id, 'mail', '')" />*</span>
	</p>
	<p>
		<span><label for="icq">{TXT_MSN}&nbsp;:</label></span>
		<span><input name="icq" type="text" id="icq" value="{MSN}" onBlur="formverif(this.id, 'mail', '')" />*</span>
	</p>
	<p>
		<span><label for="sex_homme">{TXT_SEX}&nbsp;:</label></span>
		<span><input type="radio" name="sex" id="sex_homme" value="Homme" {CHECKED_SEX_HOMME} />{TXT_HOMME}<input type="radio" name="sex" id="sex_femme" value="Femme" {CHECKED_SEX_FEMME} />{TXT_FEMME} *</span>
	</p>
	<p>
		<span><label for="age_d">{TXT_NAISSANCE}&nbsp;:</label></span>
		<span><input name="age_d" id="age_d" type="text" value="{AGE_D}" size="2" maxlength="2" onBlur="formverif(this.id, 'chiffre', '31')" />
        <input name="age_m" id="age_m" type="text" value="{AGE_M}" size="2" maxlength="2" onBlur="formverif(this.id, 'chiffre', '12')" />
        <input name="age_y" id="age_y" type="text" value="{AGE_Y}" size="4" maxlength="4" onBlur="formverif(this.id, 'chiffre', '')" />
        {DATE_FORMAT}*</span>
	</p>
	<p>
		<span><label for="langue_form">{TXT_LANGUE}&nbsp;:</label></span>
		<span><select name="langue_form" id="langue_form">
  <!-- BEGIN langue -->
  <option value="{langue.VALUE}" {langue.SELECTED} >{langue.NAME}</option>
  <!-- END langue -->
</select>*</span>
	</p>
	<p>
		<span><label for="web">{TXT_WEB}&nbsp;:</label></span>
		<span>http://<input name="web" id="web" type="text" value="{WEB}" onBlur="formverif(this.id, 'nbr', '6')" />/</span>
	</p>
	<p>
		<span><label for="arme">{TXT_ARME}&nbsp;:</label></span>
		<span><select name="arme" id="arme_select" onChange="document.images['arme'].src = '../images/armes/' + this.value;" onBlur="formverif(this.id, 'autre', '0.gif')" >
          <option value="0.gif">{TXT_CHOISIR}</option>
          <!-- BEGIN armes -->
          <option value="{armes.VALEUR}" {armes.SELECTED}>{armes.NOM}</option>
          <!-- END armes -->
        </select><img src="../images/armes/0.gif" id="arme" alt="{ALT_AMRE}" />*</span>
	</p>
	<p>
		<span><label for="texte">{TXT_TEXTE}&nbsp;:</label></span>
		<span><input name="texte" id="texte" type="text" value="{TEXTE}" size="40" onBlur="formverif(this.id, 'nbr', '6')" />*</span>
	</p>
	<p>
		<span>
		<label for="perso">{TXT_IMAGE}&nbsp;:</label>
		</span> 
		<span><select name="perso" id="perso" onChange="document.images['user_flag'].src = '../images/personnages/' + this.value;" onBlur="formverif(this.id, 'autre', '0.gif')">
        <option value="0.gif">{TXT_CHOISIR}</option>
        <!-- BEGIN images -->
        <option value="{images.FICHIER}" {perso.SELECTED}>{images.FICHIER}</option>
        <!-- END images -->
       </select><img src="../images/personnages/0.jpeg" id="user_flag"  alt="{ALT_IMAGE}" />*</span>
	</p>
	<p>
		<span><label for="histoire">{TXT_HISTOIRE}&nbsp;:</label></span>
		<span><textarea name="histoire" id="histoire" cols="30" rows="4" onBlur="formverif(this.id, 'nbr', '10')">{HISTOIRE}</textarea>*</span>
	</p>
	<p><input {BLOCK} type="submit" name='Submit' value="{BT_ENVOYER}" /></p>
  </div>
    </form>