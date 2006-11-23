<div class="big_cadre">
	<h1>{TITRE_NEWS}</h1>
	<div class="news">
		<h2>{POSTE_LE} {DATE} {PAR} {BY}</h2>
		{TEXT}
	</div>
</div>
<div class="big_cadre">
	<h1>{TITRE_REACTION}</h1>
	<!-- BEGIN reactions -->
	<div class="news">
		<h2><a href="{reactions.BY_URL}">{reactions.BY}</a></h2>
		<!-- BEGIN admin -->
		<ul class="header">
			<li><a href="{reactions.admin.DELL_REACTION_U}">{reactions.admin.DELL_REACTION}</a></li>
		</ul>
		<!-- END admin -->
		{reactions.REACTION}
	</div>
	<!-- END reactions -->
</div>
<div class="big_cadre">
	<h1>{ADD_COMMENTAIRE}</h1>
	<form method="post" action="{ICI}" class="visible">
		<!-- BEGIN login -->
		<a name="showlogin"></a>
		<div class="news"><a href="#showlogin" onclick="toggle_msg('code', '', '');toggle_msg('mail', '', '')">{login.LOGIN}</a></div>
			<p>
				<span><label for="login">{login.FORM_LOGIN}&nbsp;:</label></span>
				<span><input name="nom_p" type="text" id="login" value="{USER}" onblur="formverif(this.id,'nbr','2')" /></span>
			</p>
		<div id="mail">
			<p>
				<span><label for="email_p">{login.FORM_MAIL}&nbsp;:</label></span>
				<span><input name="email_p" type="text" id="email_p" value="{MAIL}" onblur="formverif(this.id,'mail','')" /></span>
			</p>
		</div>	
		<div id="code" style="display:none">
			<p>
				<span><label for="code_p">{login.FORM_PSW}&nbsp;:</label></span>
				<span><input name="code_p" type="password" id="code_p" onblur="formverif(this.id,'nbr','2')" /></span>
			</p>
		</div>
		<!-- END login -->
		<p>
			<span><label for="reaction">{FORM_MESSAGE}&nbsp;:</label></span>
		</p>
		<p>
			<div class="bt-bbcode">
				<!-- BEGIN bt_bbcode_liste -->
				<input type="button" onmouseup="bbcode_insert('{bt_bbcode_liste.START}','{bt_bbcode_liste.END}', 'reaction');" title="{bt_bbcode_liste.HELP}"  value="{bt_bbcode_liste.INDEX}" />
				<!-- END bt_bbcode_liste -->				
			</div>
			<div class="smilies">
				<!-- BEGIN poste_smilies_liste -->
				<a href="javascript:emoticon('{poste_smilies_liste.TXT}','reaction')"><img src="{poste_smilies_liste.IMG}" alt="{poste_smilies_liste.ALT}" width="{poste_smilies_liste.WIDTH}"  height="{poste_smilies_liste.HEIGHT}" /></a>
				<!-- BEGIN more -->
				<a href="javascript:toggle_msg('smilies_more', '', '')">{poste_smilies_liste.more.MORE_SMILIES}</a>
				<div id="smilies_more" style="display: none;">
					<!-- BEGIN liste -->
					<a href="javascript:emoticon('{poste_smilies_liste.more.liste.TXT}','reaction')"><img src="{poste_smilies_liste.more.liste.IMG}" alt="{poste_smilies_liste.more.liste.ALT}" width="{poste_smilies_liste.more.liste.WIDTH}"  height="{poste_smilies_liste.more.liste.HEIGHT}" /></a>
					<!-- END liste -->
				</div>
				<!-- END more -->
				<!-- END poste_smilies_liste -->
		</div>
			<div class="big_texte"><textarea name="reaction" id="reaction" cols="40" rows="10" onblur="formverif(this.id,'nbr','2')">{REACTION}</textarea></div>
		</p>
		<p>
			<input name="send" type="submit" id="send" value="{FORM_ENVOYER}" />
			<input name="for" type="hidden" id="for" value="{FOR}" />
		</p>
	</form>
</div>