<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}">
		<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom" type="text" id="nom" value="{NOM}" onBlur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="module">{TXT_FICHIER}&nbsp;:</label></span>
				<span><select name="module" id="module" onBlur="formverif(this.id,'autre','')">
            <option value="">{TXT_CHOISIR}</option>
            <!-- BEGIN liste_module -->
            <option value="{liste_module.VALEUR}" {liste_module.SELECTED}>{liste_module.NOM}</option>
            <!-- END liste_module -->
          </select></span>
			</p>
			<p>
				<span><label for="num">{TXT_ORDRE}&nbsp;:</label></span>
				<span><input name="num" id="num" type="text" value="{ORDRE}" size="4" onBlur="formverif(this.id,'chiffre','')" /></span>
			</p>
			<p>
				<span><label for="position">{TXT_POSITION}&nbsp;:</label></span>
				<span><select name="position" id="position" onBlur="formverif(this.id,'autre','')">
            <option value="">{TXT_CHOISIR}</option>
            <option value="gauche" {SELECTED_GAUCHE}>{TXT_GAUCHE}</option>
            <option value="droite" {SELECTED_DROITE}>{TXT_DROITE}</option>
          </select></span>
			</p>
			<p>
				<span><label for="activation">{TXT_ETAT}&nbsp;:</label></span>
				<span><input id="activation" type="radio" name="activation" value="1" {ACTIVATION_1} />{TXT_ON} <input name="activation" type="radio" value="0" {ACTIVATION_0} />{TXT_OFF}</span>
			</p>
			<p>
				<span>
					<!-- BEGIN rajouter -->
					<input type="submit" name="envoyer" value="{rajouter.ENVOYER}" />
					<!-- END rajouter -->
					<!-- BEGIN edit -->
					<input type="submit" name="envois_edit" value="{edit.EDITER}" />
					<!-- END edit -->
					<input name="for" type="hidden" id="for" value="{ID}" />
				</span>
			</p>
		</div>
	</form>
<div class="big_cadre">
<h1>{TITRE_LISTE}</h1>
<div class="news"><table class="table"> 
  <tr class="table-titre"> 
    <td>{TXT_ORDRE}</td>
    <td>{TXT_NOM}</td>
    <td>{TXT_ETAT}</td>
    <td>{ACTION}</td>
  </tr>
   <tr>
    <td colspan="4" class="table-titre">{TXT_DROITE}</td>
  </tr>
  <!-- BEGIN liste_droite -->
  <tr>
    <td>{liste_droite.NUM}</td>
    <td>{liste_droite.NOM}</td>
      <td>{liste_droite.ETAT}</td>
      <td>
    <form action="{ICI}" method="post">
          <input name="Supprimer" type="submit" value="{liste_droite.SUPPRIMER}" />
          <input name="for" type="hidden" value="{liste_droite.ID}" />
          <input name="call_page" type="hidden" value="{liste_droite.CALL_PAGE}" />
          <input name="Editer" type="submit" value="{liste_droite.EDITER}" />
          </form></td>
  </tr>
  <!-- END liste_droite -->
   <tr>
    <td colspan="4" class="table-titre">{TXT_GAUCHE}</td>
  </tr>
 <!-- BEGIN liste_gauche -->
  <tr>
    <td>{liste_gauche.NUM}</td>
    <td>{liste_gauche.NOM}</td>
      <td>{liste_gauche.ETAT}</td>
      <td><form action="{ICI}" method="post">
          <input name="Supprimer" type="submit" value="{liste_gauche.SUPPRIMER}" />
          <input name="call_page" type="hidden" value="{liste_gauche.CALL_PAGE}" />
          <input name="for" type="hidden" value="{liste_gauche.ID}" />
          <input name="Editer" type="submit" value="{liste_gauche.EDITER}" /></form>
       </td>
  </tr>
  <!-- END liste_gauche -->
</table>
</div></div>
</div>