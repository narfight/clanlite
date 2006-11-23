<div class="big_cadre" id="simple">
	<h1>{TITRE_MATCH} : {SECTION}</h1>
	<div class="news">
		<!-- BEGIN titre_inscrit -->
		<h2 class="toggle_titre">{titre_inscrit.TXT}</h2>
		<!-- END titre_inscrit -->
		<!-- BEGIN match_inscrit -->
	  <h3><input value="{VOIR}" name="voir_{match_inscrit.FOR}" type="button" onClick="toggle('{match_inscrit.FOR}')"> {CONTRE} {match_inscrit.CLAN}</h3>
		<div id="toggle_{match_inscrit.FOR}" style="display:none">
			<p>
				<span class="nom_liste">{TXT_MATCH_CLASS} :</span>
				<span class="reponce">{match_inscrit.CLASS}</span>
			</p>
			<p>
				<span class="nom_liste">{DATE} :</span>
				<span class="reponce">{match_inscrit.DATE}</span>
			</p>
			<p>
				<span class="nom_liste">{HEURE} :</span>
				<span class="reponce">{match_inscrit.HEURE}</span>
			</p>
			<p>
				<span class="nom_liste">{NBR_JOUEURS} :</span>
				<span class="reponce">{match_inscrit.NB_JOUEURS}/{match_inscrit.SUR}</span>
			</p>
			<p>
				<span class="nom_liste">{HEURE_CHAT} :</span>
				<span class="reponce">{match_inscrit.CHAT}</span>
			</p>
			<p>
				<span class="nom_liste">{QUELLE_SECTION} :</span>
				<span class="reponce">{match_inscrit.SECTION}</span>
			</p>
			<p>
				<span class="nom_liste">{VOIR} :</span>
				<span class="reponce">{match_inscrit.INFO}</span>
			</p>
			<p>
				<span class="nom_liste">{MSG_PRIVE} :</span>
				<span class="reponce">{match_inscrit.PRIVER}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_MAP} :</span>
				<span class="reponce">
					<ul>
						<!-- BEGIN map_list -->
						<li>{match_inscrit.map_list.NOM}</li>
						<!-- END map_list -->
						<!-- BEGIN map_list_url -->
						<li><a href="{match_inscrit.map_list_url.URL}">{match_inscrit.map_list_url.NOM}</a></li>
						<!-- END map_list_url -->
					</ul>
				</span>
			</p>
			<p>
				<span class="nom_liste">{TEAM_OK} :</span>
				<span class="reponce">
					<!-- BEGIN ok -->
					{match_inscrit.ok.NOM},
					<!-- END ok -->
				</span>
			</p>
			<p>
				<span class="nom_liste">{TEAM_RESERVE} :</span>
				<span class="reponce">
					<!-- BEGIN reserve -->
					{match_inscrit.reserve.NOM},
					<!-- END reserve -->
				</span>
			</p>
			<p>
				<span class="nom_liste">{TEAM_DEMANDE} :</span>
				<span class="reponce">
					<!-- BEGIN demande -->
					{match_inscrit.demande.NOM},
					<!-- END demande -->
				</span>
			</p>
			<form action="{ICI}" method="post">
				<input type="submit" name="Submit" value="{ADD_DELL_DEMANDE}" />
				<input name="match" type="hidden" id="match" value="{match_inscrit.FOR}" />
			</form>
		</div>
		<!-- END match_inscrit -->
		<!-- BEGIN titre_pas_inscrit -->
		<h2 class="toggle_titre">{titre_pas_inscrit.TXT}</h2>
		<!-- END titre_pas_inscrit -->
		<!-- BEGIN match_pas_inscrit -->
	  <h3><input value="{VOIR}" name="voir_{match_pas_inscrit.FOR}" type="button" onClick="toggle('{match_pas_inscrit.FOR}')"> {CONTRE} {match_pas_inscrit.CLAN}</h3>
		<div id="toggle_{match_pas_inscrit.FOR}" style="display:none">
			<p>
				<span class="nom_liste">{TXT_MATCH_CLASS} :</span>
				<span class="reponce">{match_pas_inscrit.CLASS}</span>
			</p>			<p>
				<span class="nom_liste">{DATE} :</span>
				<span class="reponce">{match_pas_inscrit.DATE}</span>
			</p>
			<p>
				<span class="nom_liste">{HEURE} :</span>
				<span class="reponce">{match_pas_inscrit.HEURE}</span>
			</p>
			<p>
				<span class="nom_liste">{NBR_JOUEURS} :</span>
				<span class="reponce">{match_pas_inscrit.NB_JOUEURS}/{match_pas_inscrit.SUR}</span>
			</p>
			<p>
				<span class="nom_liste">{HEURE_CHAT} :</span>
				<span class="reponce">{match_pas_inscrit.CHAT}</span>
			</p>
			<p>
				<span class="nom_liste">{QUELLE_SECTION} :</span>
				<span class="reponce">{match_pas_inscrit.SECTION}</span>
			</p>
			<p>
				<span class="nom_liste">{VOIR} :</span>
				<span class="reponce">{match_pas_inscrit.INFO}</span>
			</p>
			<p>
				<span class="nom_liste">{MSG_PRIVE} :</span>
				<span class="reponce">{match_pas_inscrit.PRIVER}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_MAP} :</span>
				<span class="reponce">
					<ul>
						<!-- BEGIN map_list -->
						<li>{match_pas_inscrit.map_list.NOM}</li>
						<!-- END map_list -->
						<!-- BEGIN map_list_url -->
						<li><a href="{match_pas_inscrit.map_list_url.URL}">{match_pas_inscrit.map_list_url.NOM}</a></li>
						<!-- END map_list_url -->
					</ul>
				</span>
			</p>
			<p>
				<span class="nom_liste">{TEAM_OK} :</span>
				<span class="reponce">
					<!-- BEGIN ok -->
					{match_pas_inscrit.ok.NOM},
					<!-- END ok -->
				</span>
			</p>
			<p>
				<span class="nom_liste">{TEAM_RESERVE} :</span>
				<span class="reponce">
					<!-- BEGIN reserve -->
					{match_pas_inscrit.reserve.NOM},
					<!-- END reserve -->
				</span>
			</p>
			<p>
				<span class="nom_liste">{TEAM_DEMANDE} :</span>
				<span class="reponce">
					<!-- BEGIN demande -->
					{match_pas_inscrit.demande.NOM},
					<!-- END demande -->
				</span>
			</p>
			<form action="{ICI}" method="post">
				<input type="submit" name="Submit" value="{ADD_DELL_DEMANDE}" />
				<input name="match" type="hidden" id="match" value="{match_pas_inscrit.FOR}" />
			</form>
		</div>
		<!-- END match_pas_inscrit -->
		<!-- BEGIN no_match -->
		{no_match.TXT}
		<!-- END no_match -->
	</div>
</div>
<!-- BEGIN regarder -->
<script type="text/javascript">
<!--//--><![CDATA[//><!--
	toggle('{regarder.FOR}')
//--><!]]>
</script>
<!-- END regarder -->