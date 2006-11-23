<div class="big_cadre">
	<h1>{TITRE_MATCH} : {SECTION}</h1>
<div class="news">
<!-- BEGIN match -->
<h2 class="toggle_titre" onClick="toggle('{match.FOR}')">{CONTRE} {match.CLAN}</h2>
  <div id="toggle_{match.FOR}" style="display:none">
	  <ul class="header">
		<li>{DATE} <span class="reponce">{match.DATE}</span></li>
		<li>{HEURE} <span class="reponce">{match.HEURE}</span></li>
		<li>{NBR_JOUEURS}<span class="reponce">{match.NB_JOUEURS}/{match.SUR}</span></li>
		<li>{HEURE_CHAT} <span class="reponce">{match.CHAT}</span></li>
		<li>{QUELLE_SECTOIN} <span class="reponce">{match.SECTION}</span></li>
	  </ul>{match.INFO}
		<h3>{TEAM_OK}</h3> 
		<ul>
			<!-- BEGIN ok --> 
			<li>{match.ok.NOM}</li>
			<!-- END ok -->
			</ul>
			<h3>{TEAM_RESERVE}</h3> 
			<ul>
			<!-- BEGIN reserve --> 
			<li>{match.reserve.NOM}</li>
			<!-- END reserve -->
			</ul>
			<h3>{TEAM_DEMANDE}</h3> 
			<ul>
			<!-- BEGIN demande --> 
			<li>{match.demande.NOM}</li>
			<!-- END demande -->
		</ul>
		<form action="membre_match.php" method="post"> 
		  <input type="submit" name="Submit" value="{ADD_DELL_DEMANDE}" /> 
		  <input name="match" type="hidden" id="match" value="{match.FOR}" /> 
		</form>
	</div>
<!-- END match -->
</div></div>
