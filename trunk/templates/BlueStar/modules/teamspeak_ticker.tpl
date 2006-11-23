<!-- BEGIN ts_ticker_corps -->
<marquee width="170" height="100" scrollamount="1" scrolldelay=20 direction="up" onMouseover="this.scrollAmount=0" onMouseout="this.scrollAmount=1">
{LISTE}
</marquee> 
<!-- END ts_ticker_corps --> 
<!-- BEGIN ts_ticker_boucle --> 
    <div class="{COLOR}">
		<span>[{CONNECTER}]</span>
		<span><a href="{URL_WEBPOST}listing.php?detail={IP}&amp;detailport={PORT}&amp;sort=server_name" onclick="window.open('{URL_WEBPOST}listing.php?detail={IP}&amp;detailport={PORT}&amp;sort=server_name');return false;">{NAME}</a></span>
	</div>
<!-- END ts_ticker_boucle --> 
<!-- BEGIN ts_ticker_config -->
	<form method="post" action="teamspeak_ticker.php">
		<div class="big_cadre">
		<h1>{ts_ticker_config.TITRE}</h1>
			<p>
				<span><label for="url">{ts_ticker_config.TICKER_NSD}&nbsp;:</label></span>
				<span><input name="url" type="text" id="url" value="{ts_ticker_config.URL}" onBlur="formverif(this.id,'nbr','3')"></span>
			</p>
			<p>
				<span><label for="url_webpost">{ts_ticker_config.WEBPOST}&nbsp;:</label></span>
				<span><input name="url_webpost" type="text" id="url" value="{ts_ticker_config.URL_WEBPOST}" onBlur="formverif(this.id,'nbr','3')"></span>
			</p>
			<p>
				<span>
					<input name="id_module" type="hidden" id="id_module" value="{ts_ticker_config.ID}" />
					<input name="Submit_module" type="submit" id="Submit_module" value="{ts_ticker_config.EDITER}" /> 
				</span>
			</p>
		</div>
	</form>
<!-- END ts_ticker_config -->
