<!-- BEGIN admin -->
<div class="big_cadre">
	<h1>{admin.TITRE}</h1>
	<div class="news">
		<!-- BEGIN update -->
		<h2>{admin.update.TITRE}</h2>
		{admin.update.TEXTE}
		<form action="{admin.update.ICI}" method="post">
			<input name="toggle_get_version" type="submit" value="{admin.update.TXT_TOGGLE}" />
		</form>
		<!-- END upadte -->
		<h2>{admin.INFO_ADMIN}</h2>
		<ul>
			<li>{admin.TXT_NOMBRE_USER} :<span class="reponce">{admin.NOMBRE_USER}</span></li>
			<li>{admin.TXT_NOMBRE_MATCH} :<span class="reponce">{admin.NOMBRE_MATCH}</span></li>
			<li>{admin.TXT_NOMBRE_OLD_MATCH} :<span class="reponce">{admin.NOMBRE_OLD_MATCH}</span></li>
			<li>{admin.TXT_NOMBRE_DEMANDE_MATCH} :<span class="reponce">{admin.NOMBRE_DEMANDE_MATCH}</span></li>
		</ul>
		<h2>{admin.INFO_ADMIN_MEMBRE}</h2>
		<table class="table">
			<thead>
				<tr>
					<th>{admin.SEX_NOM}</th>
					<th>{admin.SECTION}</th>
					<th>{admin.EQUIPE}</th>
					<th>{admin.POUVOIR}</th>
					<th>{admin.PROFIL}</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN nul_part -->
				<tr>
					<td><span class="{admin.nul_part.SEX}">{admin.nul_part.NOM}</span></td>
					<td>{admin.nul_part.SECTION}</td>
					<td>{admin.nul_part.EQUIPE}</td>
					<td>{admin.nul_part.PV}</td>
					<td>
						<form method="post" action="{admin.nul_part.ICI}">
							<input type="submit" name="editer" value="{admin.nul_part.BT_EDITER}" />
							<input name="id" type="hidden" value="{admin.nul_part.ID}" />
						</form>
					</td>
				</tr>
				<!-- END nul_part -->
			</tbody>
		</table>
	</div>
</div>
<!-- END admin -->
<div class="big_cadre">
	<h1>{TITRE}</h1>
	<div class="news">
		<!-- BEGIN entete_match -->
		<h2>{entete_match.MATCH_PLACE}</h2>
		<!-- END entete_match -->
		<!-- BEGIN cadre_match -->
		{cadre_match.MATCH_DISPO}
		<!-- END cadre_match -->
		<!-- BEGIN entrainement -->
		<h2>{entrainement.ENTRAI_PLACE}</h2>
		<ul>
			<li>{entrainement.TXT_DATE}: <span class="reponce">{entrainement.DATE}</span></li>
			<li>{entrainement.TXT_HEURE}: <span class="reponce">{entrainement.HEURE}</span></li>
			<li>{entrainement.TXT_INFO}: <span class="reponce">{entrainement.INFO}</span></li>
			<li>{entrainement.TXT_INFO_PV}: <span class="reponce">{entrainement.INFO_PV}</span></li>
		</ul>
		<!-- END entrainement -->
	</div>
</div>