<OBJECT classid='clsid:B69003B3-C55E-4B48-836C-BC5946FC3B28' codeType='application/x-oleobject' height='1' id='MsgrObj' width='1'> </OBJECT>
<div class="big_cadre">
	<h1>{TITRE_LISTE_MEMBRES}</h1>
	<div class="news">
		<table align="center" class="table">
			<thead>
				<tr>
					<!-- BEGIN del_tete -->
					<th>{del_tete.SUPPRIMER}</th>
					<!-- END del_tete -->
					<th>{NUM}</th>
					<th>{ID}</th>
					<th>{NOM_SEX}</th>
					<th>{MSN}</th>
					<th>{PROFIL}</th>
					<!-- BEGIN profil_tete -->
					<th>{profil_tete.PROFIL}</th>
					<!-- END profil_tete -->
					<!-- BEGIN medail_tete -->
					<th>{medail_tete.MEDAILLES}</th>
					<!-- END medail_tete -->
					<!-- BEGIN admin_tete -->
					<th>{admin_tete.POUVOIRS}</th>
					<!-- END admin_tete -->
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN liste -->
				<tr>
					<!-- BEGIN del -->
					<td>
						<form method="post" action="liste-des-membres.php">
							<input name="del" type="submit" id="del" value=" X " />
							<input name="id" type="hidden" value="{liste.ID}" />
						</form>
					</td>
					<!-- END del -->
					<td>{liste.NOMBRE}</td>
					<td>{liste.ID}</td>
					<td><span class="{liste.SEX}">{liste.USER}</span></td>
					<td><a href='javascript:DoInstantMessage("{liste.MSN}","{liste.USER}");'><img src="../images/icon_msnm.gif" /></a></td>
					<td><a href="profil.php?link={liste.ID}"> <img src="../images/smal-info.gif" width="16" height="16" /></a></td>
					<!-- BEGIN edit_profil -->
					<td>
						<form method="post" action="../administration/editer-user.php">
							<input type="submit" name="editer" value="{liste.EDITER}" />
							<input name="id" type="hidden" value="{liste.ID}" />
						</form>
						<!-- END edit_profil -->
					</td>
						<!-- BEGIN edit_medail -->
					<td>
						<form method="post" action="../administration/editer-medail.php">
							<input type="submit" name="editer" value="{liste.EDITER}" />
							<input name="id" type="hidden" value="{liste.ID}" />
						</form>
					</td>
						<!-- END edit_medail -->
						<!-- BEGIN admin -->
					<td>
						<form method="post" action="../administration/pouvoir.php">
							<input type="submit" name="editer" value="{liste.EDITER}" {liste.admin.DISABLED} />
							<input name="id" type="hidden" value="{liste.ID}" />
						</form>
					</td>
					<!-- END admin -->
				</tr>
				<!-- END liste -->
			</tbody>
		</table>
	</div>
</div>