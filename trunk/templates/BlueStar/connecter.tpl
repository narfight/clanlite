<div class="big_cadre">
	<h1>{TITRE_CONNECTE}</h1>
	<div class="news">
		<table class="table">
			<thead>
				<tr>
					<th>{NOM_SEX}</th>
					<th>{ACTION}</th>
					<th>{PROFIL}</th>
					<!-- BEGIN IP -->
					<th>{IP}</th>
					<!-- END IP -->
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN connecter -->
				<tr>
					<td><span class="{connecter.SEX}">{connecter.USER}</span></td>
					<td>{connecter.ACTION}</td>
					<!-- BEGIN membre_connect -->
					<td><a href="{connecter.membre_connect.PROFIL_U}"><img src="../images/smal-info.gif" width="16" height="16" alt="{connecter.membre_connect.ALT_PROFIL}" /></a></td>
					<!-- END membre_connect -->
					<!-- BEGIN no_membre_connect -->
					<td>{NO_PROFIL}</td>
					<!-- END no_membre_connect -->
					<!-- BEGIN admin -->
					<td>{connecter.admin.IP}</td>
					<!-- END admin -->
				</tr>
				<!-- END connecter -->
			</tbody>
		</table>
	</div>
</div>