<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
		<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="text">{TXT_TEXT}&nbsp;:</label></span>
			</p>
			<p>
				<div class="bt-bbcode">
					<!-- BEGIN bt_bbcode_liste -->
					<input type="button" onmouseup="bbcode_insert('{bt_bbcode_liste.START}','{bt_bbcode_liste.END}', 'text');" title="{bt_bbcode_liste.HELP}"  value="{bt_bbcode_liste.INDEX}" />
					<!-- END bt_bbcode_liste -->				
				</div>
				<div class="smilies">
					<!-- BEGIN poste_smilies_liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.TXT}','text')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
					<!-- BEGIN more -->
					<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
					<div id="smilies_more" style="display: none;">
						<!-- BEGIN liste -->
						<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','text')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
						<!-- END liste -->
					</div>
					<!-- END more -->
					<!-- END poste_smilies_liste -->
				</div>
				<div class="big_texte"><textarea name="text" cols="40" rows="10" id="text" onblur="formverif(this.id,'nbr','10')">{TEXT}</textarea></div>
			</p>
			<p>
				<span><label for="cyclique">{TXT_CYCLIQUE}&nbsp;:</label></span>
				<span><input name="cyclique" id="cyclique" {CYCLIQUE} type="checkbox" value="1"></span>
			</p>
			<p>
				<span><label for="jour">{TXT_DATE}&nbsp;:</label>
				</span>
				<span><input name="jour" type="text" id="jour" value="{JOUR}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','31')" />/<input name="mois" type="text" id="mois" value="{MOIS}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','12')" />/<input name="annee" type="text" id="year" value="{ANNEE}" size="4" maxlength="4" onblur="formverif(this.id,'chiffre','')" />
				(jj/mm/yyyy)</span>
			</p>
			<p>
				<span><label for="heure">{TXT_HEURE}&nbsp;:</label>
				</span>
				<span><input name="heure" type="text" id="heure" value="{HEURE}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','24')" />H<input name="minute" type="text" id="minute" value="{MINUTE}" size="2" maxlength="2" onblur="formverif(this.id,'chiffre','60')" /></span>
			</p>
			<p>
				<span>
					<!-- BEGIN editer --> 
					<input type="submit" name="Editer" value="{BT_EDITER}" /> 
					<!-- END editer --> 
					<!-- BEGIN rajouter --> 
					<input type="submit" name="Envoyer" value="{BT_ENVOYER}" /> 
					<!-- END rajouter --> 
					<input name="for" type="hidden" value="{ID}" />
				</span>
			</p>
		</form>
	</div>
	<div class="big_cadre">
		<h1>{TITRE_LIST}</h1>
		<div class="news">
			<table class="table"> 
				<thead>
					<tr>
						<th>{DATE}</th>
						<th>{TXT_CYCLIQUE_SORT}</th>
						<th>{TXT_TEXT}</th>
						<th>{ACTION}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste -->
					<tr>
						<td>{liste.DATE}</td>
						<td>{liste.CYCLIQUE}</td>
						<td>{liste.TEXT}</td>
						<td>
							<form action="{ICI}" method="post">
								<input name="dell" type="submit" value="{BT_DELL}" onclick="return demande('{TXT_CON_DELL}')" />
								<input name="for" type="hidden" value="{liste.ID}" />
								<input name="edit" type="submit" value="{BT_EDITER}" />
							</form>
						</td>
					</tr>
					<!-- END liste -->
				</tbody>
			</table>
		</div>
	</div>
</div>