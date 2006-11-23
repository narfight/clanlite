<OBJECT classid='clsid:B69003B3-C55E-4B48-836C-BC5946FC3B28' codeType='application/x-oleobject' height='1' id='MsgrObj' width='1'> </OBJECT> 
<div class="big_cadre"> 
<h1>{TITRE_LISTE_MEMBRES}</h1> 
<div class="news"> 
  <table align="center" class="table"> 
    <tr class="table-titre"> 
      <!-- BEGIN del_tete --> 
      <td>{del_tete.SUPPRIMER}</td> 
      <!-- END del_tete --> 
      <td>{NUM}</td> 
      <td>{ID}</td> 
      <td>{NOM_SEX}</td> 
      <td>{MSN}</td> 
      <td>{PROFIL}</td> 
      <!-- BEGIN profil_tete --> 
      <td>{profil_tete.PROFIL}</td> 
      <!-- END profil_tete --> 
      <!-- BEGIN medail_tete --> 
      <td>{medail_tete.MEDAILLES}</td> 
      <!-- END medail_tete --> 
      <!-- BEGIN admin_tete --> 
      <td>{admin_tete.POUVOIRS}</td> 
      <!-- END admin_tete --> 
    </tr> 
    <!-- BEGIN liste --> 
    <tr> 
      <!-- BEGIN del --> 
      <form method="post" action="liste-des-membres.php"> 
        <td> <input name="del" type="submit" id="del" value=" X " /> 
          <input name="id" type="hidden" value="{liste.ID}" /></td> 
      </form> 
      <!-- END del --> 
      <td>{liste.NOMBRE}</td> 
      <td>{liste.ID}</td> 
      <td><span class="{liste.SEX}">{liste.USER}</span></td> 
      <td><a href='javascript:DoInstantMessage("{liste.MSN}","{liste.USER}");'><img src="../images/icon_msnm.gif" /></a></td> 
      <td><a href="profil.php?link={liste.ID}"> <img src="../images/smal-info.gif" width="16" height="16" /></a></td> 
      <!-- BEGIN edit_profil --> 
      <form method="post" action="../administration/editer-user.php"> 
        <td><input type="submit" name="editer" value="editer" /> 
          <input name="id" type="hidden" value="{liste.ID}" /></td> 
      </form> 
      <!-- END edit_profil --> 
      <!-- BEGIN edit_medail --> 
      <td><form method="post" action="../administration/editer-medail.php">
	  	<input type="submit" name="editer" value="editer" /> 
        <input name="id" type="hidden" value="{liste.ID}" /></form></td> 
      <!-- END edit_medail --> 
      <!-- BEGIN admin --> 
        <td><form method="post" action="../administration/pouvoir.php">
			<input type="submit" name="editer" value="editer" /> 
          <input name="id" type="hidden" value="{liste.ID}" /></form></td> 
       
      <!-- END admin --> 
    </tr> 
    <!-- END liste --> 
  </table> 
</div> 
</div>
