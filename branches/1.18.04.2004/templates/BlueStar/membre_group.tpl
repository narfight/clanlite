<OBJECT classid="clsid:B69003B3-C55E-4B48-836C-BC5946FC3B28" codeType="application/x-oleobject" height="1" id="MsgrObj" width="1"></OBJECT>
<!-- BEGIN cadre --> 
<div class="big_cadre">
	<h1>{cadre.NOM_SECTION}</h1>
<div class="news"> 
    <table class="table">
      <tr class="table-titre">
        <td>{NOM_SEX}</td>
        <td>{GRADE}</td>
        <td>{ROLE}</td>
        <td>{MSN}</td>
        <td>{PROFIL}</td>
      <!-- BEGIN total -->
      <tr>
        <td colspan="5" class="sous-cellule">{cadre.total.NOM_EQUIPE}</td>
      </tr>
      <!-- BEGIN listage -->
      <tr>
        <td><div class="{cadre.total.listage.SEX}">{cadre.total.listage.NOM}</div></td>
        <td>{cadre.total.listage.GRADE}</td>
        <td>{cadre.total.listage.ROLE}</td>
        <td><a href='javascript:DoInstantMessage("{cadre.total.listage.IM}","{cadre.total.listage.NOM}");'><img src="../images/icon_msnm.gif" alt="{ALT_MSN}" /></a></td>
        <td><a href="profil.php?link={cadre.total.listage.ID}"> <img src="../images/smal-info.gif" width="16" height="16" alt="{ALT_PROFIL}" /></a></td>
      </tr>
      <!-- END listage -->
      <!-- END total -->
    </table>
  </div> 
</div>
  <!-- END cadre --> 
<div class="big_cadre">
	<h1>{DEF_EQUIPE}</h1>
    <!-- BEGIN info --> 
  <div class="news"> 
    <h2>{info.NOM}</h2> 
    {info.DETAIL}</div> 
    <!-- END info -->
</div>