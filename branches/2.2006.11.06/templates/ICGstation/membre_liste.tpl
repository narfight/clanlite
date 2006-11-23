<div class="big_cadre" id="simple">
	<h1>{TITRE_LISTE_MEMBRES}</h1>
	<div class="news">
		<table align="center" class="table">
			<thead>
				<tr>
					<!-- BEGIN del_tete -->
					<th>{del_tete.SUPPRIMER}</th>
					<!-- END del_tete -->
					<th>{NUM}</th>
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
						<form method="post" action="{ICI}">
							<input name="del" type="submit" id="del" value=" X " onclick="return demande('{TXT_CON_DELL}')" />
							<input name="id" type="hidden" value="{liste.ID}" />
						</form>
					</td>
					<!-- END del -->
					<td>{liste.NOMBRE}</td>
					<td><span class="{liste.SEX}">{liste.USER}</span></td>
					<td><a href='javascript:DoInstantMessage("{liste.MSN}","{liste.USER}");'><img src="../images/icon_msnm.gif" alt="{ALT_MSN}" /></a></td>
					<td><a href="{liste.PROFIL_U}"> <img src="../images/smal-info.gif" width="16" height="16" alt="{ALT_PROFIL}" /></a></td>
					<!-- BEGIN edit_profil -->
					<td>
						<form method="post" action="{liste.edit_profil.ICI_EDIT}">
							<input type="submit" name="editer" value="{liste.EDITER}" />
							<input name="id" type="hidden" value="{liste.ID}" />
						</form>
						<!-- END edit_profil -->
					</td>
						<!-- BEGIN edit_medail -->
					<td>
						<form method="post" action="{liste.edit_medail.ICI_MEDAIL}">
							<input type="submit" name="editer" value="{liste.EDITER}" />
							<input name="id" type="hidden" value="{liste.ID}" />
						</form>
					</td>
						<!-- END edit_medail -->
						<!-- BEGIN admin -->
					<td>
						<form method="post" action="{liste.admin.ICI_POUVOIR}">
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