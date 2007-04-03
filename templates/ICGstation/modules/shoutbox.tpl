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
<!-- BEGIN shoutbox_config -->
<div class="big_cadre" id="simple">
	<h1>{shoutbox_config.TITRE}</h1>
	<form method="post" action="{shoutbox_config.ICI}" class="visible">
		<p>
			<span><label for="nbr_lignes">{shoutbox_config.TXT_NBR_LIGNES}&nbsp;:</label></span>
			<span><input name="nbr_lignes" type="text" id="nbr_lignes" value="{shoutbox_config.NBR_LIGNES}" onblur="formverif(this.id,'chiffre','3')"></span>
		</p>
		<p>
			<span>
				<input name="id_module" type="hidden" id="id_module" value="{shoutbox_config.ID}" />
				<input name="Submit_shoutbox_config" type="submit" id="Editer" value="{shoutbox_config.EDITER}" /> <input name="Submit_shoutbox_vider" type="submit" value="{shoutbox_config.VIDER}" onclick="return demande('{shoutbox_config.TXT_CON_DELL}')" />
			</span>
		</p>
	</form>
</div>
<div class="big_cadre" id="simple">
	<h1>{shoutbox_config.TITRE_DEL}</h1>
		<div class="news">
			<table class="table">
				<thead>
					<tr>
						<th>{shoutbox_config.NOM}</th>
						<th>{shoutbox_config.MSG}</th>
						<th>{shoutbox_config.ACTION}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN liste -->
					<tr>
						<td>{shoutbox_config.liste.NOM}</td>
						<td>{shoutbox_config.liste.MSG}</td>
						<td>
							<form method="post" action="{shoutbox_config.ICI}">
								<input name="Supprimer_msg" type="submit" value="{shoutbox_config.SUPPRIMER}" onclick="return demande('{shoutbox_config.TXT_CON_DELL}')" />
								<input name="for_msg" type="hidden" value="{shoutbox_config.liste.FOR}" />
								<input name="id_module" type="hidden" id="id_module" value="{shoutbox_config.ID}" />
							</form>
						</td>
					</tr>
					<!-- END liste -->
				</tbody>
			</table>
		</div>
</div>
<!-- END shoutbox_config -->