<!-- BEGIN match -->
	{TXT_DATE} : <span class="reponce">{DATE}</span><br />
	{TXT_HEURE} : <span class="reponce">{HEURE}</span><br />
	<span class="reponce">{SECTION}</span> VS <span class="reponce">{CONTRE}</span><br />
	<span class="reponce">{INFO}</span>
	{LIENS_MEMBRES}
<!-- END match -->
<!-- BEGIN match_liens_membres -->
	<a href="{URL}">{TEXTE}</a>
<!-- END match_liens_membres -->
<!-- BEGIN entrain -->
	{TXT_DATE} : <span class="reponce">{DATE}</span><br />
	{TXT_HEURE} : <span class="reponce">{HEURE}</span><br />
	{TXT_INFO} :<br />
	<span class="reponce">{INFO}</span>
<!-- END entrain -->
<!-- BEGIN last_match -->
	{TXT_DATE} : <span class="reponce">{DATE}</span><br />
	{TXT_CONTRE} : <span class="reponce">{CONTRE}</span><br />
	{TXT_PT_NOUS} : <span class="reponce">{PT_NOUS}</span><br />
	{TXT_PT_MECHANT} : <span class="reponce">{PT_MECHANT}</span><br />
	<a href="javascript:toggle_msg('last_match_resum', '', '')">{INFO_SHOW_INFO}</a>
	<div style="display: none;" id="last_match_resum">{INFO}</div>
<!-- END last_match -->
<!-- BEGIN connection -->
	<form method="post" action="{ICI}"> 
		<p>
			<span><label for="user_module">{LOGIN}&nbsp;:</label></span>
			<span><input name="user" type="text" id="user_module" onblur="formverif(this.id,'nbr','2')" /></span>
		</p>
		<p>
			<span><label for="psw_module">{CODE}&nbsp;:</label></span>
			<span><input name="psw" type="password" id="psw_module" onblur="formverif(this.id,'nbr','4')" /></span>
		</p>
		<p>
			<span><label for="save_code_login">{SAVE}&nbsp;:</label></span>
			<span><input name="save_code_login" type="checkbox" id="save_code_login" value="oui" /></span>
		</p>
		<p>
			<span>
				<input name="Submit" type="submit" value="{ENVOYER}" />
			</span>
		</p>
	</form>
<!-- END connection -->
<!-- BEGIN newsletter -->
	<form method="post" action="{ICI}"> 
		<p>
			<span><label for="mail_ns_{ID}">{MAIL}&nbsp;:</label></span>
			<span><input name="mail_ns" type="text" id="mail_ns_{ID}" onblur="formverif(this.id,'mail','')" /></span>
		</p>
		<p>
			<span><label for="mail_dell_{ID}">{DELL}&nbsp;:</label></span>
			<span><input id="mail_dell_{ID}" name="action" type="checkbox" value="dell" /></span>
		</p>
		<p>
			<span>
				<input name="Submit_newsletter" type="submit" value="{ENVOYER}" />
				<input name="id" type="hidden" value="{ID}" />
			</span>
		</p>
	</form>
<!-- END newsletter -->
