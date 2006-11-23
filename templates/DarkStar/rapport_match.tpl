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