<div class="big_cadre" id="simple">
	<h1>{TITRE}</h1>
	<div class="big_cadre">
		<h1>{TITRE_CONFIGURATION}</h1>
		<div class="news" id="link_config"><a href="#config" onclick="toggle_msg('config-cadre', '', '');toggle_msg('link_config', '', '')" id="config" name="config">{CONFIGURATION}</a></div>		
		<div id="config-cadre" style="display: none;">
			<form method="post" action="{ICI}" class="visible">
				<p>
					<span>
					<label for="img_width">{TXT_SIZE_IMG}&nbsp;:</label>
					</span>
					<span><input name="img_width" type="text" id="img_width" value="{IMG_W}" /> x <input name="img_height" type="text" id="img_height" value="{IMG_H}" /></span>
				</p>
				<p>
					<span>
					<label for="tumb_width">{TXT_SIZE_TUMB}&nbsp;:</label>
					</span>
					<span><input name="tumb_width" type="text" id="tumb_width" value="{TUMB_W}" /> x <input name="tumb_height" type="text" id="tumb_height" value="{TUMB_H}" /></span>
				</p>
				<p>
					<span><label for="img_max_size">{TXT_MAX_SIZE}&nbsp;:</label></span>
					<span><input name="img_max_size" type="text" id="img_max_size" value="{MAX_IMG_SIZE}" /> {UNIT_BYTE}</span>
				</p>
				<p>
					<span>
						<input name="id_module" type="hidden" id="id_module" value="{ID}" />
						<input name="modify" type="submit" id="modify" value="{EDITER}" />
					</span>
				</p>
			</form>
		</div>
	</div>
	<div class="big_cadre">
		<h1>{TITRE_GESTION}</h1>
		<form enctype="multipart/form-data" action="{ICI}" method="post" class="visible">
			<p>
				<span><label for="img_width">{TXT_LINK}&nbsp;:</label></span>
				<span><input name="userfile" type="file" /></span>
			</p>
			<p>
				<span><label for="img_width">{TXT_COM_IMG}:</label></span>
				<span><input type="text" name="com_img" id="com_ing" /></span>
			</p>
			<p>
				<span>
					<input name="id_module" type="hidden" id="id_module" value="{ID}" />
					<input name="send" type="submit" id="send" value="{TXT_BTN_SEND}" />
				</span>
			</p>
		</form>
	</div>	
	<div class="big_cadre">
		<h1>{TITRE_LISTE}</h1>
		<table class="table">
			<thead>
				<tr>
					<th>{TXT_APERCU}</th>
					<th>{TXT_COM_IMG}</th>
					<th>{ACTION}</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN images -->
				<tr>
					<td><img src="{images.SRC_IMG}" width="{images.TUMB_W}" height="{images.TUMB_H}" alt="{images.COM_IMG}" /></td>
					<td>{images.COM_IMG}</td>
					<td>
						<form method="post" action="{images.ICI}">
							<input name="del" type="submit" id="del" value="{images.REMOVE}" onclick="return demande('{images.TXT_CON_DELL}')" />
							<input name="id_module" type="hidden" id="id_module" value="{ID}" />
							<input name="id" type="hidden" value="{images.ID}" />
						</form>
					</td>
				</tr>
				<!-- END images -->
			</tbody>
		</table>
	<!-- BEGIN multi_page -->
	<div class="parpage">
		<!-- BEGIN link_prev -->
		<a href="{multi_page.link_prev.PRECEDENT}&id_module={ID}&config_modul_admin=1">{multi_page.link_prev.PRECEDENT_TXT}</a>
		<!-- END link_prev -->
		<!-- BEGIN num_p -->
		<a href="{multi_page.num_p.URL}&id_module={ID}&config_modul_admin=1">{multi_page.num_p.NUM}</a>,
		<!-- END num_p -->
		<!-- BEGIN link_next -->
		<a href="{multi_page.link_next.SUIVANT}&id_module={ID}&config_modul_admin=1">{multi_page.link_next.SUIVANT_TXT}</a>
		<!-- END link_next -->
	</div>
	<!-- END multi_page -->
	</div>
</div>