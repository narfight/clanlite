<div class="big_cadre">
	<h1>{TITRE_CALENDRIER} <br /><a href="calendrier.php?mois={MOIS_MOINS}&annee={CURRENT_ANNEE}"><<</a> {CURRENT_MOIS} {CURRENT_ANNEE} <a href="calendrier.php?mois={MOIS_PLUS}&annee={CURRENT_ANNEE}">>></a></h1>
	<table class="table">
		<thead>
			<tr>
				<th>{LUNDI}</th>
				<th>{MARDI}</th>
				<th>{MERCREDI}</th>
				<th>{JEUDI}</th>
				<th>{VENDREDI}</th>
				<th>{SAMEDI}</th>
				<th>{DIMANCHE}</th>
			</tr>
		</thead>
		<!-- BEGIN semaine -->
		<thead>
			<tr class="sous-cellule">
				<td width="80" class="{semaine.CLASS_1}">{semaine.NUM_1}</td>
				<td width="80" class="{semaine.CLASS_2}">{semaine.NUM_2}</td>
				<td width="80" class="{semaine.CLASS_3}">{semaine.NUM_3}</td>
				<td width="80" class="{semaine.CLASS_4}">{semaine.NUM_4}</td>
				<td width="80" class="{semaine.CLASS_5}">{semaine.NUM_5}</td>
				<td width="80" class="{semaine.CLASS_6}">{semaine.NUM_6}</td>
				<td width="80" class="{semaine.CLASS_7}">{semaine.NUM_7}</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td height="60" class="{semaine.CLASS_1}">{semaine.INFO_1}</td>
				<td width="80" height="60" class="{semaine.CLASS_2}">{semaine.INFO_2}</td>
				<td width="80" height="60" class="{semaine.CLASS_3}">{semaine.INFO_3}</td>
				<td width="80" height="60" class="{semaine.CLASS_4}">{semaine.INFO_4}</td>
				<td width="80" height="60" class="{semaine.CLASS_5}">{semaine.INFO_5}</td>
				<td width="80" height="60" class="{semaine.CLASS_6}">{semaine.INFO_6}</td>
				<td width="80" height="60" class="{semaine.CLASS_7}">{semaine.INFO_7}</td>
			</tr>
		</tbody>
		<!-- END semaine -->
  </table>
</div>