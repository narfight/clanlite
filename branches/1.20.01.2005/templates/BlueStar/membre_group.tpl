<!-- BEGIN cadre -->
<div class="big_cadre">
	<h1>{cadre.NOM_SECTION}</h1>
	<div class="news">
		<table class="table">
			<thead>
				<tr>
					<th>{NOM_SEX}</th>
					<!-- BEGIN grade -->
					<th>{cadre.grade.GRADE}</th>
					<!-- END grade -->
					<th>{ROLE}</th>
					<th>{MSN}</th>
					<th>{PROFIL}</th>
				</tr>
			</thead>
			<!-- BEGIN total -->
			<thead>
				<tr class="sous-cellule">
					<!-- BEGIN grade -->
					<th colspan="5" class="sous-cellule">{cadre.total.NOM_EQUIPE}</th>
					<!-- END grade -->
					<!-- BEGIN no_grade -->
					<th colspan="4" class="sous-cellule">{cadre.total.NOM_EQUIPE}</th>
					<!-- END no_grade -->
				</tr>
			</thead>
			<!-- BEGIN listage -->
			<tr>
				<td><a href="{cadre.total.listage.PROFIL_U}"><span class="{cadre.total.listage.SEX}">{cadre.total.listage.NOM}</span></a></td>
				<!-- BEGIN grade -->
				<td>{cadre.total.listage.grade.GRADE}</td>
				<!-- END grade -->
				<td>{cadre.total.listage.ROLE}</td>
				<td><a href='javascript:DoInstantMessage("{cadre.total.listage.IM}","{cadre.total.listage.NOM}");'><img src="../images/icon_msnm.gif" alt="{ALT_MSN}" /></a></td>
				<td><a href="{cadre.total.listage.PROFIL_U}"><img src="../images/smal-info.gif" width="16" height="16" alt="{ALT_PROFIL}" /></a></td>
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
		{info.DETAIL}
	</div>
	<!-- END info -->
</div>