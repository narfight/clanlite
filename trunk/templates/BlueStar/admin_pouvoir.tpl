<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="{ICI}" class="visible">
		<table class="table">
			<thead>
				<tr>
					<th>{POUVOIR}</th>
					<th>{ACTION}</th>
				</tr>
			</thead>
			<tbody>
			<!-- BEGIN liste -->
			<tr>
				<td>{liste.INFO_POUVOIR}</td>
				<td>
					<input type="radio" name="activation{liste.NUM}" value="oui" {liste.ACTIVATION_1} />{liste.OUI}
					<input name="activation{liste.NUM}" type="radio" value="non" {liste.ACTIVATION_0} />{liste.NON}
				</td>
			</tr>
			<!-- END liste -->
			<tr>
				<td colspan="2">
					<input type="submit" name="envois_edit" value="{EDITER}" />
					<input name="id" type="hidden" value="{ID}" />
				</td>
			</tr>
	</table>
  </form> 
</div>