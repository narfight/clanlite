<div class="big_cadre">
	<h1>{TITRE} <img src="../images/smilies/question.gif" onmouseover="poplink('{HELP_TXT}',event)" onmouseout="kill_poplink()" alt="{ALT_AIDE}" /></h1>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
	    <form method="post" action="{ICI}" class="visible"> 
			<p>
				<span><label for="nom">{TXT_NOM}&nbsp;:</label></span>
				<span><input name="nom" type="text" id="nom" value="{NOM}" onblur="formverif(this.id,'nbr','3')" /></span>
			</p>
			<p>
				<span><label for="info">{TXT_DETAILS}&nbsp;:</label></span>
			</p>
			<p>
				<div class="bt-bbcode">
					<!-- BEGIN bt_bbcode_liste -->
					<input type="button" onmouseup="bbcode_insert('{bt_bbcode_liste.START}','{bt_bbcode_liste.END}', 'info');" title="{bt_bbcode_liste.HELP}"  value="{bt_bbcode_liste.INDEX}" />
					<!-- END bt_bbcode_liste -->				
				</div>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','info')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','info')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="info" cols="40" rows="10" id="info" onblur="formverif(this.id,'nbr','10')">{INFO}</textarea></div>
			</p>
			<p>
				<span>
						<!-- BEGIN envoyer --> 
						<input type="submit" name="Envoyer" value="{envoyer.ENVOYER}" /> 
						<!-- END envoyer --> 
						<!-- BEGIN edit --> 
						<input type="submit" name="Editer" value="{edit.EDITER}" /> 
						<!-- END edit --> 
						<input name="for" type="hidden" id="for" value="{ID}" />
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
						<th>{TXT_NOM}</th>
						<th>{TXT_DETAILS}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste -->
					<tr>
						<td>{liste.NOM}</td>
						<td>{liste.INFO}</td>
						<td>
							<form action="{ICI}" method="post">
								<input name="dell" type="submit" value="{liste.SUPPRIMER}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="for" type="hidden" value="{liste.ID}" />
								<input name="edit" type="submit" value="{liste.EDITER}" />
							</form>
						</td>
					</tr>
					<!-- END liste -->
				</tbody>
			</table>
		</div>
	</div>
</div>
