<div class="big_cadre">
	<h1>{TITRE_SERVEUR}</h1>
	<p>
		<span>{TXT_IP}&nbsp;:</span>
		<span class="reponce">{IP}:{PORT}</span>
	</p>
	<p>
		<span>{TXT_NAME}&nbsp;:</span>
		<span class="reponce">{NAME}</span>
	</p>
	<p>
		<span>{TXT_VERSION}&nbsp;:</span>
		<span class="reponce">{VERSION}</span>
	</p>
	<p>
		<span>{TXT_GAME_TYPE}&nbsp;:</span>
		<span class="reponce">{GAME_TYPE}</span>
	</p>
	<p>
		<span>{TXT_PASSWORD}&nbsp;:</span>
		<span class="reponce">{PASSWORD}</span>
	</p>
	<!-- BEGIN min_max_ping -->
	<p>
		<span>{min_max_ping.TXT_ENTRE_PING}&nbsp;:</span>
		<span class="reponce">{min_max_ping.MIN_PING}</span> et <span class="reponce">{min_max_ping.MAX_PING}</span>
	</p>
	<!-- END min_max_ping -->
	<p>
		<span>{TXT_PLACE}&nbsp;:</span>
		<span class="reponce">{PLAYER}/{PLACE}</span>
	</p>
	<!-- BEGIN list_map -->
	<p>
		<span>{list_map.TXT_ROTATION}&nbsp;:</span>
		<span class="reponce">
			<ul>
			<!-- BEGIN map -->
				<li>
					<!-- BEGIN bouttons_oui -->
					<a href="{list_map.map.bouttons_oui.URL}">{list_map.map.NOM}</a>
					<!-- END bouttons_oui -->
					<!-- BEGIN bouttons_non -->
					{list_map.map.NOM}
					<!-- END bouttons_non -->
				</li>
			<!-- END map -->
			</ul>
		</span>
	</p>
	<!-- END list_map -->
	<p>
		<span>{TXT_CURRENT_MAP}&nbsp;:</span>
		<span class="reponce">{CURRENT_MAP} <img src="{PICS_MAP}" {PICS_MAP_TAILLE} alt="{ALT_PICS_MAP}" /></span>
	</p>
	<!-- BEGIN next_map -->
	<p>
		<span>{next_map.TXT_NEXT_MAP}&nbsp;:</span>
		<span class="reponce">{next_map.NEXT_MAP}</span>
	</p>
	<!-- END next_map -->
	<p>
		<span>{TXT_INFO}&nbsp;:</span>
		<span class="reponce">{INFO}</span>
	</p>
	<!-- BEGIN objectif -->
	<p>
		<span>{objectif.TXT_OBJ_AXIS}&nbsp;:</span>
		<span class="reponce">{objectif.OBJ_1_AXIS}<br />{objectif.OBJ_2_AXIS}<br />{objectif.OBJ_3_AXIS}</span>
	</p>
	<p>
		<span>{objectif.TXT_OBJ_ALLIER}&nbsp;:</span>
		<span class="reponce">{objectif.OBJ_1_ALLIER}<br />{objectif.OBJ_2_ALLIER}<br />{objectif.OBJ_3_ALLIER}</span>
	</p>
	<!-- END objectif -->
	<p>
		<span>{LISTE_JOUEUR}&nbsp;:</span>
		<span>
			<table class="table">
				<thead>
					<tr>
						<td>{NAME_JOUEUR}</td>
						<!-- BEGIN tete_score -->
						<td>{tete_score.SCORE}</td>
						<!-- END tete_score -->
						<!-- BEGIN tete_enemy -->
						<td>{tete_enemy.ENEMY}</td>
						<!-- END tete_enemy -->
						<!-- BEGIN tete_kia -->
						<td>{tete_kia.KIA}</td>
						<!-- END tete_kia -->
						<!-- BEGIN tete_frags -->
						<td>{tete_frags.FRAGS}</td>
						<!-- END tete_frags -->
						<!-- BEGIN tete_ping -->
						<td>{tete_ping.PING}</td>
						<!-- END tete_ping -->
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN players -->
					<tr>
						<td>{players.NAME}</td>
						<!-- BEGIN list_score -->
						<td>{players.list_score.SCORE}</td>
						<!-- END list_score -->
						<!-- BEGIN list_enemy -->
						<td>{players.list_enemy.ENEMY}</td>
						<!-- END list_enemy -->
						<!-- BEGIN list_kia -->
						<td>{players.list_kia.KIA}</td>
						<!-- END list_kia -->
						<!-- BEGIN list_frags -->
						<td>{players.list_frags.FRAGS}</td>
						<!-- END list_frags -->
						<!-- BEGIN list_ping -->
						<td>{players.list_ping.PING}</td>
						<!-- END list_ping -->
					</tr>
					<!-- END players -->
				</tbody>
			</table>
		</span>
	</p>
</div>