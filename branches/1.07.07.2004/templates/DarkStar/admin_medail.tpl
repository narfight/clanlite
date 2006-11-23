<div class="big_cadre">
	<h1>{TITRE}</h1>
	<form method="post" action="editer-medail.php">
		<div class="big_cadre">
			<div class="news">
				<table class="table">
					<tr class="table-titre">
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
						<td>5</td>
					</tr>
					<tr>
						<td><img src="../images/medailles/medaille1.gif" /></td>
						<td><img src="../images/medailles/medaille2.gif" /></td>
						<td><img src="../images/medailles/medaille3.gif" /></td>
						<td><img src="../images/medailles/medaille4.gif" /></td>
						<td><img src="../images/medailles/medaille5.gif" /></td>
					</tr>
					<tr>
						<td><input name="medail1" type="checkbox" id="medail1" value="1" {M1} /></td>
						<td><input name="medail2" type="checkbox" id="medail2" value="1" {M2} /></td>
						<td><input name="medail3" type="checkbox" id="medail3" value="1" {M3} /></td>
						<td><input name="medail4" type="checkbox" id="medail4" value="1" {M4} /></td>
						<td><input name="medail5" type="checkbox" id="medail5" value="1" {M5} /></td>
					</tr>
					<tr class="table-titre">
						<td>6</td>
						<td>7</td>
						<td>8</td>
						<td>9</td>
						<td>10</td>
					</tr>
					<tr>
						<td><img src="../images/medailles/medaille6.gif" /></td>
						<td><img src="../images/medailles/medaille7.gif" /></td>
						<td><img src="../images/medailles/medaille8.gif" /></td>
						<td><img src="../images/medailles/medaille9.gif" /></td>
						<td><img src="../images/medailles/medaille10.gif" /></td>
					</tr>
					<tr>
						<td><input name="medail6" type="checkbox" id="medail6" value="1" {M6} /></td>
						<td><input name="medail7" type="checkbox" id="medail7" value="1" {M7} /></td>
						<td><input name="medail8" type="checkbox" id="medail8" value="1" {M8} /></td>
						<td><input name="medail9" type="checkbox" id="medail9" value="1" {M9} /></td>
						<td><input name="medail10" type="checkbox" id="medail10" value="1" {M10} /></td>
					</tr>
				</table>
				<p>
					<span>
						<input name="id" type="hidden" value="{ID}" />
						<input type="submit" name="Submit" value="{EDITER}" />
					</span>
				</p>
			</div>
		</div>
	</form>
</div>