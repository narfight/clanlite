<!-- BEGIN details -->
<div class="big_cadre">
	<h1>{details.NAME}</h1>
	<p>
		<span>{TXT_IP}&nbsp;:</span>
		<span class="reponce"><a href="{details.JOINERURI}">{details.IP}:{details.PORT}</a></span>
	</p>
	<p>
		<span>{TXT_NAME}&nbsp;:</span>
		<span class="reponce">{details.NAME}</span>
	</p>
	<p>
		<span>{TXT_VERSION}&nbsp;:</span>
		<span class="reponce">{details.VERSION}</span>
	</p>
	<p>
		<span>{TXT_GAME_TYPE}&nbsp;:</span>
		<span class="reponce">{details.GAME_TYPE}</span>
	</p>
	<p>
		<span>{TXT_PASSWORD}&nbsp;:</span>
		<span class="reponce">{details.PASSWORD}</span>
	</p>
	<!-- BEGIN min_max_ping -->
	<p>
		<span>{details.min_max_ping.TXT_ENTRE_PING}&nbsp;:</span>
		<span class="reponce">{details.min_max_ping.MIN_PING}</span> et <span class="reponce">{details.min_max_ping.MAX_PING}</span>
	</p>
	<!-- END min_max_ping -->
	<p>
		<span>{TXT_PLACE}&nbsp;:</span>
		<span class="reponce">{details.PLAYER}/{details.PLACE}</span>
	</p>
	<!-- BEGIN list_map -->
	<p>
		<span>{details.list_map.TXT_ROTATION}&nbsp;:</span>
		<span class="reponce">
			<ul>
			<!-- BEGIN map -->
				<li>
					<!-- BEGIN bouttons_oui -->
					<a href="{details.list_map.map.bouttons_oui.URL}">{details.list_map.map.NOM}</a>
					<!-- END bouttons_oui -->
					<!-- BEGIN bouttons_non -->
					{details.list_map.map.NOM}
					<!-- END bouttons_non -->
				</li>
			<!-- END map -->
			</ul>
		</span>
	</p>
	<!-- END list_map -->
	<p>
		<span>{TXT_CURRENT_MAP}&nbsp;:</span>
		<span class="reponce">
			<!-- BEGIN url_map -->
			<a href="{details.url_map.URL}">{details.url_map.NOM}</a>
			<!-- END url_map -->
			<!-- BEGIN no_url_map -->
			{details.no_url_map.NOM}
			<!-- END no_url_map -->
			<img src="{details.PICS_MAP}" {details.PICS_MAP_TAILLE} alt="{details.ALT_PICS_MAP}" />
		</span>
	</p>
	<!-- BEGIN next_map -->
	<p>
		<span>{details.next_map.TXT_NEXT_MAP}&nbsp;:</span>
		<span class="reponce">{details.next_map.NEXT_MAP}</span>
	</p>
	<!-- END next_map -->
	<!-- BEGIN objectif -->
	<p>
		<span>{TXT_OBJ_AXIS}&nbsp;:</span>
		<span class="reponce">{details.objectif.OBJ_1_AXIS}<br />{details.objectif.OBJ_2_AXIS}<br />{details.objectif.OBJ_3_AXIS}</span>
	</p>
	<p>
		<span>{TXT_OBJ_ALLIER}&nbsp;:</span>
		<span class="reponce">{details.objectif.OBJ_1_ALLIER}<br />{details.objectif.OBJ_2_ALLIER}<br />{details.objectif.OBJ_3_ALLIER}</span>
	</p>
	<!-- END objectif -->
	<p>
		<span>{LISTE_JOUEUR}&nbsp;:</span>
		<span>
			<table class="table">
				<thead>
					<tr>
						<th>{NAME_JOUEUR}</th>
						<!-- BEGIN tete_score -->
						<th>{details.tete_score.SCORE}</th>
						<!-- END tete_score -->
						<!-- BEGIN tete_enemy -->
						<th>{details.tete_enemy.ENEMY}</th>
						<!-- END tete_enemy -->
						<!-- BEGIN tete_kia -->
						<th>{details.tete_kia.KIA}</th>
						<!-- END tete_kia -->
						<!-- BEGIN tete_frags -->
						<th>{details.tete_frags.FRAGS}</th>
						<!-- END tete_frags -->
						<!-- BEGIN tete_ping -->
						<th>{details.tete_ping.PING}</t>
						<!-- END tete_ping -->
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN players -->
					<tr>
						<td>{details.players.NAME}</td>
						<!-- BEGIN list_score -->
						<td>{details.players.list_score.SCORE}</td>
						<!-- END list_score -->
						<!-- BEGIN list_enemy -->
						<td>{details.players.list_enemy.ENEMY}</td>
						<!-- END list_enemy -->
						<!-- BEGIN list_kia -->
						<td>{details.players.list_kia.KIA}</td>
						<!-- END list_kia -->
						<!-- BEGIN list_frags -->
						<td>{details.players.list_frags.FRAGS}</td>
						<!-- END list_frags -->
						<!-- BEGIN list_ping -->
						<td>{details.players.list_ping.PING}</td>
						<!-- END list_ping -->
					</tr>
					<!-- END players -->
				</tbody>
			</table>
		</span>
	</p>
</div>
<!-- END details -->
<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="news">
		<table class="table">
			<thead>
				<tr>
					<th>{TXT_NAME}</th>
					<th>{TXT_PLACE}</th>
					<th>{TXT_GAME_TYPE}</th>
					<th>{TXT_CURRENT_MAP}</th>
				</tr>
			</thead>
			<!-- BEGIN liste_game_server -->
			<thead>
				<tr class="sous-cellule">
					<th colspan="4">{liste_game_server.TITRE_GROUP}</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN liste -->
				<tr>
					<td><a href="{liste_game_server.liste.LINK}">{liste_game_server.liste.NAME}</a></td>
					<td>{liste_game_server.liste.PLAYER}/{liste_game_server.liste.PLACE}</td>
					<td>{liste_game_server.liste.GAME_TYPE}</td>
					<td>{liste_game_server.liste.CURRENT_MAP}</td>
				</tr>
				<!-- END liste -->
			</tbody>
			<!-- END liste_game_server -->
		</table>
	</div>
</div>
<!-- BEGIN multi_page -->
<div class="parpage">
	<!-- BEGIN link_prev -->
	<a href="{multi_page.link_prev.PRECEDENT}">{multi_page.link_prev.PRECEDENT_TXT}</a>
	<!-- END link_prev -->
	<!-- BEGIN num_p -->
	<a href="{multi_page.num_p.URL}">{multi_page.num_p.NUM}</a>,
	<!-- END num_p -->
	<!-- BEGIN link_next -->
	<a href="{multi_page.link_next.SUIVANT}">{multi_page.link_next.SUIVANT_TXT}</a>
	<!-- END link_next -->
</div>
<!-- END multi_page -->