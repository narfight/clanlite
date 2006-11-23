<!-- BEGIN teamspeak_connection -->
<form action="{ICI}" method="post" id="chat">
	<ul style="margin: 0;padding-left: 0;list-style-type: none; text-align: center;">
		<li><label for="teamspeak_connection_name">{TXT_NOM}&nbsp;:</label></li>
		<li><input name="teamspeak_connection_name" id="teamspeak_connection_name" type="text" value="{NAME}" size="20" /></li>
		<li><label for="teamspeak_connection_login">{TXT_LOGIN}&nbsp;:</label></li>
		<li><input name="teamspeak_connection_login" id="teamspeak_connection_login" type="text" size="20" /></li>
		<li><label for="teamspeak_connection_code">{TXT_CODE}&nbsp;:</label></li>
		<li><input name="teamspeak_connection_code" id="teamspeak_connection_code" type="password" size="20" /></li>
		<li><label for="teamspeak_connection_channel">{TXT_CHANNEL}&nbsp;:</label></li>
		<li><input name="teamspeak_connection_channel" id="teamspeak_connection_channel" type="text" size="20" /></li>
		<li><label for="teamspeak_connection_channel_code">{TXT_CODE_CHANNEL}&nbsp;:</label></li>
		<li><input name="teamspeak_connection_channel_code" id="teamspeak_connection_channel_code" type="password" size="20" /></li>
		<li><input name="teamspeak_connection_ip" type="hidden" id="teamspeak_connection_ip" value="{IP}" /><input name="teamspeak_connection_port" id="teamspeak_connection_port" type="hidden" value="{PORT}" /><input name="teamspeak_connection_envois" id="teamspeak_connection_envois" type="submit" value="{CONNECTION}" /></li>
	</ul>
</form>
<!-- END teamspeak_connection --> 
<!-- BEGIN teamspeak_connection_config -->
<div class="big_cadre" id="simple">
	<h1>{teamspeak_connection_config.TITRE}</h1>
	<form method="post" action="{ICI}" class="visible">
		<p>
			<span><label for="ip_vocal">{teamspeak_connection_config.TXT_IP}&nbsp;:</label></span>
			<span><input name="ip_vocal" type="text" id="ip_vocal" value="{teamspeak_connection_config.IP}" onblur="formverif(this.id,'nbr','3')"></span>
		</p>
		<p>
			<span><label for="port_vocal">{teamspeak_connection_config.TXT_PORT}&nbsp;:</label></span>
			<span><input name="port_vocal" type="text" id="port_vocal" value="{teamspeak_connection_config.PORT}" onblur="formverif(this.id,'chiffre','')"></span>
		</p>
		<p>
			<span>
				<input name="id_module" type="hidden" id="id_module" value="{teamspeak_connection_config.ID}" />
				<input name="Submit_connect_ts_module" type="submit" id="Editer" value="{teamspeak_connection_config.EDITER}" /> 
			</span>
		</p>
	</form>
</div>
<!-- END teamspeak_connection_config -->