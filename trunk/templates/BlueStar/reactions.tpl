<div class="big_cadre">
	<h1>{TITRE_REACTION}</h1>
  <!-- BEGIN reactions --> 
  <div class="news"> 
    <h2>R�action de <a href="{reactions.BY_URL}"  onclick="window.open('{reactions.BY_URL}');return false;">{reactions.BY}</a></h2> 
    <!-- BEGIN admin --> 
    <ul class="header"> 
	  <li><a href="reaction.php?action=dell&amp;for={reactions.ID}&amp;view={reactions.FOR}">{DELL_REACTION}</a></li> 
    </ul> 
    <!-- END admin --> 
    {reactions.REACTION}
  </div> 
  <!-- END reactions --> 
</div>
<form method="post" action="reaction.php"> 
<div class="big_cadre">
	<h1>{ADD_COMMENTAIRE}</h1>
	<p>
		<span><label for="nom_p">{FORM_LOGIN}&nbsp;:</label></span>
		<span><input name="nom_p" type="text" id="nom_p" value="{USER}" onBlur="formverif(this.id,'nbr','2')" /></span>
	</p>
	<p>
		<span><label for="code_p">{FORM_PSW}&nbsp;:</label></span>
		<span><input name="code_p" type="password" id="code_p" onBlur="formverif(this.id,'nbr','2')" />(si vous etes un {TAG})</span>
	</p>
	<p>
		<span><label for="email_p">{FORM_MAIL}&nbsp;:</label></span>
		<span><input name="email_p" type="text" id="email_p" value="{MAIL}" onBlur="formverif(this.id,'mail','')" /></span>
	</p>
	<p>
		<span><label for="reaction">{FORM_MESSAGE}&nbsp;:</label></span>
	</p>
	<p>
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
		<div class="big_texte"><textarea name="reaction" id="reaction" cols="40" rows="10" wrap="VIRTUAL" onBlur="formverif(this.id,'nbr','2')">{REACTION}</textarea></div>
	</p>
	<p>
        <input name="send" type="submit" id="send" value="{FORM_ENVOYER}" />	
        <input name="for" type="hidden" id="for" value="{FOR}" />
    </p>
</div>
</form>