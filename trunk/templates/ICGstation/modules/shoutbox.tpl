<!-- BEGIN shoutbox -->
	<div style="text-align: left;width:100%; height: 300px; overflow:scroll;">{LISTE}</div>
	<hr />
	<form method="post" action="{ICI}"> 
		<p>
			<span><label for="shoutbox_user">{USER}&nbsp;:</label></span>
			<span><input name="shoutbox_user" type="text" id="shoutbox_user" onblur="formverif(this.id,'nbr','2')" value="{USER_DEFAULT}" /></span>
		</p>
		<p>
			<span><label for="shoutbox_msg">{MSG}&nbsp;:</label></span>
			<span><input name="shoutbox_msg" type="text" id="shoutbox_msg" onblur="formverif(this.id,'nbr','4')" /></span>
		</p>
		<p>
			<span>
				<input name="Submit_shoutbox" type="submit" value="{ENVOYER}" />
				<input name="id" type="hidden" value="{ID}" />
			</span>
		</p>
	</form>
<!-- END shoutbox -->
<!-- BEGIN liste_shoutbox -->
		<div><strong>{USER}</strong> : {MSG}</div>
<!-- END liste_shoutbox -->