<!-- BEGIN webpost_config -->
<form method="post" action="ts_webpost.php">
	<div class="big_cadre">
	<h1>{webpost_config.TITRE_M}</h1>
	<div class="news">
		<h2>{webpost_config.TITRE_AIDE}</h2>
		{webpost_config.TXT_AIDE}
	</div>
		<p>
			<span><label for="ip">{webpost_config.TXT_IP}&nbsp;:</label></span>
			<span><input name="ip" type="text" id="titre" value="{webpost_config.IP}" onblur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="port">{webpost_config.TXT_PORT}&nbsp;:</label></span>
			<span><input name="port" type="text" id="titre" value="{webpost_config.PORT}" onblur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span><label for="query_port">{webpost_config.TXT_QUERY_PORT}&nbsp;:</label></span>
			<span><input name="query_port" type="text" id="titre" value="{webpost_config.QUERY_PORT}" onblur="formverif(this.id,'nbr','3')" /></span>
		</p>
		<p>
			<span>
				<input name="id_module" type="hidden" id="id_module" value="{webpost_config.ID}" />
				<input name="Submit_module_webpost_centrale" type="submit" id="Submit_module_webpost_centrale" value="{webpost_config.EDITER}" /> 
			</span>
		</p>
	</div>
</form>
<!-- END webpost_config -->
<!-- BEGIN webpost_show -->
	<div class="big_cadre">
		<h1>{webpost_show.TITRE}</h1>
		<div class="news">
			{webpost_show.SERVER_NAME}
			<ul>
			<!-- BEGIN channel -->
				<li style="list-style-image:url(../images/modules_ts/channel{webpost_show.channel.PASSWORD_ICON}.gif)">{webpost_show.channel.CHANNEL_NAME}
					<ul>
					<!-- BEGIN sub_channel -->
						<li style="list-style-image:url(../images/modules_ts/channel{webpost_show.channel.sub_channel.PASSWORD_ICON}.gif)">{webpost_show.channel.sub_channel.NAME}
							<ul>
							<!-- BEGIN sub_user -->
								<li style="list-style-image:url(../images/modules_ts/{webpost_show.channel.sub_channel.sub_user.PLAYER_ICON}.gif)" onmouseover="poplink('dssdf',event)" onmouseout="kill_poplink()">{webpost_show.channel.sub_channel.sub_user.USER_NAME}</li>
							<!-- END sub_user -->
							</ul>
						</li>
					<!-- END sub_channel -->
					<!-- BEGIN user -->
						<li style="list-style-image:url(../images/modules_ts/{webpost_show.channel.user.PLAYER_ICON}.gif)" onmouseover="poplink('dssdf',event)" onmouseout="kill_poplink()">{webpost_show.channel.user.USER_NAME}</li>
					<!-- END user -->
					</ul>
				</li>
			<!-- END channel -->
			</ul>
		</div>
	</div>
<!-- END webpost_show -->