<OBJECT classid='clsid:B69003B3-C55E-4B48-836C-BC5946FC3B28' codeType='application/x-oleobject' height='1' id='MsgrObj' width='1'></OBJECT> 
<div class="big_cadre">
	<h1>{TITRE}</h1>
<!-- BEGIN notification -->
<form method="post" action="demande-match.php">
<div class="big_cadre">
	<h1>{notification.TITRE}</h1>
	<p>
		<span><label for="From">{notification.ADR_EXPEDITEUR}&nbsp;:</label></span>
		<span><input name="From" type="text" id="From" value="{notification.MASTER_MAIL}" onBlur="formverif(this.id,'mail','')" /></span>
	</p>
	<p>
		<span><label for="Reply">{notification.ADR_RETOUR}&nbsp;:</label></span>
		<span><input name="Reply" type="text" id="Reply" value="{notification.MASTER_MAIL}" onBlur="formverif(this.id,'mail','')" /></span>
	</p>
	<p>
		<span><label for="mail">{notification.ENVOYER_A}&nbsp;:</label></span>
		<span><input name="mail" type="text" id="mail" value="{notification.TO}" onBlur="formverif(this.id,'mail','')" /></span>
	</p>
	<p>
		<span><label for="jj">{notification.TXT}&nbsp;:</label></span>
		<span><textarea name="texte" id="texte" cols="40" rows="8" onBlur="formverif(this.id,'nbr','4')">{notification.TEXTE}</textarea></span>
	</p>
	<p>
		<span><input type="submit" name="envois_mail" value="{notification.ENVOYER}" /><input name="id" type="hidden" value="{notification.ID}" /><input name="envois" type="hidden" id="envois" value="{notification.ENVOIS}" /></span>
	</p>
</div>
</form>
<!-- END notification --> 
<div class="big_cadre">
	<h1>{TITRE_LISTE}</h1>
	<div class="news">
<table class="table">
  <tr class="table-titre">
    <td>{CLAN}</td>
    <td>{CONTACTER}</td>
    <td>{DATE}</td>
    <td>{HEURE}</td>
    <td>{NOMBRE_PAR_TEAM}</td>
    <td>{INFO}</td>
    <td>{ACTION}</td>
    <td>{REPONCE}</td>
  </tr>
  <!-- BEGIN propo -->
  <tr>
    <td><a href="http://{propo.URL_CLAN}" onclick="window.open('{propo.URL_CLAN}');return false;">{propo.CLAN}</a></td>
    <td><a href="mailto:{propo.MAIL}"><img src="../images/msg.gif" alt="{propo.ALT_MAIL}" /></a><a href='javascript:DoInstantMessage("{propo.NOM}","{propo.CLAN}");'><img src="../images/icon_msnm.gif" alt="{propo.ALT_MSN}" /></a></td>
    <td>{propo.DATE}</td>
    <td>{propo.TIME}</td>
    <td>{propo.VS}</td>
    <td>{propo.INFO}</span>
    </td>
    <form method="post" action="demande-match.php">
	<td>
        <input name="id" type="hidden" value="{propo.ID}" />
        <input name="voir" type="hidden" value="{propo.VOIR}" />
        <input type="submit" name="del" value="{propo.DELL}" />
    </td>
    <td><input type="submit" name="envois_oui" value="{propo.OUI}" />
	<input type="submit" name="envois_non" value="{propo.NON}" /></td>
	</form>
  </tr>
  <!-- END propo -->
</table>
</div>
</div>
</div>
