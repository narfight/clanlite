<!-- BEGIN voter -->
<form method="post" action="{ICI}">
	<div class="big_cadre">
		<h1>{voter.TITRE_VOTRE}</h1>
		<div class="news">{voter.VOTE_EXPLICATION}
			<select name="select">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5" selected="selected">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select><br />
			<input name="send_vote" type="submit" id="send_vote" value="{voter.ENVOYER}" />
			<input name="for" type="hidden" id="for" value="{voter.FOR}" />
		</div>
	</div>
</form>
<!-- END voter -->
<!-- BEGIN tete -->
<br />
<div class="big_cadre">
	<h1>{TITRE_DOWNLOAD}</h1>
	<div class="news">
	<!-- BEGIN group -->
		<h2>
			<a href="{tete.group.GROUP_U}">{tete.group.INFO_GROUP}</a>
			<!-- BEGIN psw -->
			<img src="{tete.group.psw.PATH_ROOT}images/password.png" height="32" width="32" alt="{tete.group.psw.ALT}" />
			<!-- END psw -->
		</h2>
		{tete.group.INFO_GROUP_DETAIL}
		<!-- END group -->
		<h2><a href="{TOP_10_U}">{TOP_10}</a></h2>
		{TOP_10_DEF}
	</div>
</div>
<a name="debut"></a>
<!-- END tete -->
<!-- BEGIN liste_fichiers -->
<div class="big_cadre">
	<h1>{liste_fichiers.LISTE_DLL}</h1>
	<div class="news"> 
		<!-- BEGIN pas_vide -->
    	<h2>{liste_fichiers.pas_vide.NOM}</h2> 
    	<ul class="header"> 
			<li>{liste_fichiers.pas_vide.TXT_LAST_MODIF}: <span class="reponce">{liste_fichiers.pas_vide.LAST_MODIF}</span></li> 
			<li>{liste_fichiers.pas_vide.TXT_COTE}: <span class="reponce">{liste_fichiers.pas_vide.COTE}</span></li> 
			<li>{liste_fichiers.pas_vide.TXT_NB_TELECHARGER}: <span class="reponce">{liste_fichiers.pas_vide.NB_TELECHARGER} fois</span></li> 
		</ul>
		{liste_fichiers.pas_vide.DETAIL}
		<form action="{ICI}" method="post"> 
			<input name="voter" type="submit" id="voter_{liste_fichiers.pas_vide.FOR}" value="{liste_fichiers.pas_vide.VOTER}" />
			<input name="dll" type="submit" id="dll_{liste_fichiers.pas_vide.FOR}" value="{liste_fichiers.pas_vide.TELECHARGER}" />
			<input name="for" type="hidden" id="for_{liste_fichiers.pas_vide.FOR}" value="{liste_fichiers.pas_vide.FOR}" />
			<!-- BEGIN psw -->
			<br />{liste_fichiers.pas_vide.psw.TXT}: <input name="password" type="password" id="password_{liste_fichiers.pas_vide.FOR}" />
			<!-- END psw -->
			<input name="for_rep" type="hidden" id="for_rep_{liste_fichiers.pas_vide.FOR}" value="{liste_fichiers.pas_vide.FOR_REP}" />
		</form>
		<div style="height: 40px; width: 1px"></div>
		<!-- END pas_vide -->
	</div> 
</div>
<!-- END liste_fichiers -->
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