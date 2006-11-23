<div class="big_cadre">
	<h1>{TITRE}</h1>
    <form method="post" action="{ICI}"> 
		<div class="big_cadre">
			<h1>{TITRE_GESTION}</h1>
			<p>
				<span><label for="ip">{TXT_SERVEUR_GAME_IP}&nbsp;:</label></span>
				<span><input name="ip" id="ip" type="text" value="{IP}" size="15" maxlength="15" onBlur="formverif(this.id,'nbr','6')" /></span>
			</p>
			<p>
				<span><label for="port">{TXT_SERVEUR_GAME_PORT}&nbsp;:</label></span>
				<span><input name="port" id="port" type="text" value="{PORT}" size="5" onBlur="formverif(this.id,'chiffre','')" /> <img src="../images/smilies/question.gif" onmouseover="poplink('{TXT_HELP_GAME_PORT}')" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></span>
			</p>
			<p>
				<span><label for="protocol">{TXT_SERVEUR_GAME_PROTOCOL}&nbsp;:</label></span>
				<span>
					<select name="protocol" id="protocol" onBlur="formverif(this.id,'autre','')"> 
						<option value="">{TXT_CHOISIR}</option> 
						<!-- BEGIN protocol_game_liste --> 
						<option value="{protocol_game_liste.VALUE}" {protocol_game_liste.SELECTED}>{protocol_game_liste.NAME}</option> 
						<!-- END protocol_game_liste --> 
					</select>
				</span>
			</p>
			<p>
				<span>
					  <!-- BEGIN edit --> 
					  <input name="envois_edit" type="submit" id="Editer" value="{edit.EDITER}" /> 
					  <!-- END edit --> 
					  <!-- BEGIN envoyer --> 
					  <input name="envoyer" type="submit" id="Envoyer" value="{envoyer.ENVOYER}" /> 
					  <!-- END envoyer --> 
					  <input name="for" type="hidden" id="for" value="{ID}" />
				</span>
			</p>
		</div>
    </form> 
<div class="big_cadre">
<h1>{TITRE_LISTE}</h1>
<div class="news"><table class="table"> 
  <tr class="table-titre"> 
    <td>{TXT_IP}</td> 
    <td>{TXT_PORT}</td> 
    <td>{TXT_PROTOCOL}</td> 
    <td>{ACTION}</td> 
  </tr> 
  <!-- BEGIN liste --> 
  <tr> 
    <td>{liste.IP}</td> 
    <td>{liste.PORT}</td> 
    <td>{liste.PROTOCOL}</td> 
      <td> 
    <form action="{ICI}" method="post"> 
          <input name="dell" type="submit" id="Supprimer" value="{liste.SUPPRIMER}" /> 
          <input name="for" type="hidden" value="{liste.ID}" /> 
          <input name="edit" type="submit" value="{liste.EDITER}" /> 
    </form></td> 
  </tr> 
  <!-- END liste --> 
</table></div></div>
</div>