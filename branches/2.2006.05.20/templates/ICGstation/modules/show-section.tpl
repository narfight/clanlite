<!-- BEGIN module_config -->
	<div class="big_cadre" id="simple">
		<h1>{module_config.TITRE}</h1>
			<form method="post" action="{ICI}" class="visible">
			<p>
				<span><label for="section">{module_config.TXT_SECTION}&nbsp;:</label></span>
				<span>
					<select name="section" id="section" onblur="formverif(this.id,'autre','-1')">
						<option value"-1" >{module_config.CHOISIR}</option>
						<option value="0" {module_config.SELECTED_ALL}>{module_config.ALL_SECTION}</option>
						{module_config.LISTE}
					</select>
				</span>
			</p>
			<p>
				<span>
					<input name="id_module" type="hidden" id="id_module" value="{module_config.ID}" />
					<input name="Submit_module" type="submit" id="Editer" value="{module_config.EDITER}" /> 
				</span>
			</p>
		</form>
	</div>
<!-- END module_config -->
<!-- BEGIN liste -->
	<a href='javascript:DoInstantMessage("{IM}","{USER}");'><img src="{PATH_ROOT}images/icon_msnm.gif" alt="{ALT_MSN}" /></a>
	<a href="{PROFIL_U}"><span class="{SEX}">{USER}</span></a><br />
<!-- END liste -->
<!-- BEGIN total -->
	<div style="text-align: left">{LISTE}</div>
<!-- END total -->
