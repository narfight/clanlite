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
		<h2>{DATE} : {liste.DATE}</h2>
		<ul class="header">
			<li>{TXT_SECTION} : <span class="reponce">{liste.SECTION}</span></li>
			<li>{TXT_CONTRE} : <span class="reponce">{liste.CONTRE}</span></li>
			<li>{TXT_SCORE_NOUS} : <span class="reponce">{liste.SCORE_NOUS}</span></li>
			<li>{TXT_SCORE_MECHANT} : <span class="reponce">{liste.SCORE_MECHANT}</span></li>
		</ul>{liste.INFO}
		<div style="height: 42px; width: 1px"></div>
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
	<a href="rapport_match.php?limite={multi_page.link_prev.PRECEDENT}">{multi_page.link_prev.PRECEDENT_TXT}</a>
	<!-- END link_prev -->
	<!-- BEGIN num_p -->
	<a href="rapport_match.php?{multi_page.num_p.URL}">{multi_page.num_p.NUM}</a>,
	<!-- END num_p -->
	<!-- BEGIN link_next -->
	<a href="rapport_match.php?limite={multi_page.link_next.SUIVANT}">{multi_page.link_next.SUIVANT_TXT}</a>
	<!-- END link_next -->
</div>
<!-- END multi_page -->