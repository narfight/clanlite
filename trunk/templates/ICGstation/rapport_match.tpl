<div class="big_cadre">
	<h1>{TITRE_MATCH_RAPPORT}</h1>
	<!-- BEGIN resume -->
	<div class="news">
		{resume.TXT_MATCH_WIN} : {resume.MATCH_WIN} ({resume.MATCH_WIN_PC}%)<br />
		{resume.TXT_MATCH_LOST} : {resume.MATCH_LOST} ({resume.MATCH_LOST_PC}%)<br />
		{resume.TXT_MATCH_NORM} : {resume.MATCH_NORM} ({resume.MATCH_NORM_PC}%)<br />
	</div>
	<!-- END resume -->
	<!-- BEGIN liste -->
	<div class="news">
		<h2><input value="{VOIR}" name="voir_{liste.ID}" type="button" onClick="toggle('{liste.ID}')" class="{liste.CLASS}"> {liste.TITRE}</h2>
		<div id="toggle_{liste.ID}" style="display:none">
			<p>
				<span class="nom_liste">{TXT_SECTION} :</span>
				<span class="reponce">{liste.SECTION}</span>
			</p>
						<p>
				<span class="nom_liste">{TXT_CONTRE} :</span>
				<span class="reponce">{liste.CONTRE}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_SCORE_NOUS} :</span>
				<span class="reponce">{liste.SCORE_NOUS}</span>
			</p>
			<p>
				<span class="nom_liste">{TXT_SCORE_MECHANT} :</span>
				<span class="reponce">{liste.SCORE_MECHANT}</span>
			</p>
			<p>
				<span class="nom_liste">{VOIR} :</span>
				<span class="reponce">{liste.INFO}</span>
			</p>
		</div>
	</div>
	<!-- END liste -->
	<!-- BEGIN no_match -->
	<div class="news">
		{no_match.TXT}
	</div>
	<!-- END no_match -->
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