<div class="big_cadre">
	<h1>{TITRE_CONNECTE}</h1>
<div class="news">
  <table class="table"> 
    <tr class="table-titre"> 
      <td nowrap>{ID}</td> 
      <td nowrap>{NOM_SEX}</td> 
      <td nowrap>{ACTION}</td> 
      <td nowrap>{PROFIL}</td> 
      <!-- BEGIN IP --> 
      <td nowrap>{IP}</td> 
      <!-- END IP --> 
    </tr> 
    <!-- BEGIN connecter --> 
    <tr> 
      <td>{connecter.ID}</td> 
      <td><span class="{connecter.SEX}">{connecter.USER}</span></td> 
      <td>{connecter.ACTION}</td> 
      <!-- BEGIN membre_connect -->
	  <td><a href="profil.php?link={connecter.ID}" onclick="window.open('profil.php?link={connecter.ID}');return false;"><img src="../images/smal-info.gif" width="16" height="16" /></a></td> 
      <!-- END membre_connect -->
      <!-- BEGIN no_membre_connect -->
	  <td>{NO_PROFIL}</td> 
      <!-- END no_membre_connect -->
      <!-- BEGIN admin --> 
      <td>{connecter.admin.IP}</td> 
      <!-- END admin --> 
    </tr> 
    <!-- END connecter --> 
  </table> 
</div>
</div>