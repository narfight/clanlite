<div class="big_cadre">
	<h1>{TITRE}</h1>
	<!-- BEGIN liste_game_server -->
	<div class="news">
		<h2>{liste_game_server.TXT_IP} :{liste_game_server.IP}:{liste_game_server.PORT}</h2>
		<ul class="header">
			<li>{liste_game_server.TXT_PLACE} :<span class="reponce">{liste_game_server.PLAYER}/{liste_game_server.PLACE}</span></li>
			<li>{liste_game_server.TXT_GAME_TYPE} :<span class="reponce">{liste_game_server.GAME_TYPE}</span></li>
			<li>{liste_game_server.TXT_CURRENT_MAP} :<span class="reponce">{liste_game_server.CURRENT_MAP}</span></li>
		</ul>
		{liste_game_server.NAME}
		<div style="height: 30px; width: 1px"></div>
	</div>
	<!-- END liste_game_server -->
</div>
<!-- BEGIN multi_page --> 
<div class="parpage">
	<!-- BEGIN link_prev --> 
	<a href="serveur_game_list.php?limite={multi_page.link_prev.PRECEDENT}">{multi_page.link_prev.PRECEDENT_TXT}</a> 
	<!-- END link_prev --> 
	<!-- BEGIN num_p --> 
	<a href="serveur_game_list.php?{multi_page.num_p.URL}">{multi_page.num_p.NUM}</a>,
	<!-- END num_p --> 
	<!-- BEGIN link_next --> 
	<a href="serveur_game_list.php?limite={multi_page.link_next.SUIVANT}">{multi_page.link_next.SUIVANT_TXT}</a> 
	<!-- END link_next -->
</div>
<!-- END multi_page --> 
