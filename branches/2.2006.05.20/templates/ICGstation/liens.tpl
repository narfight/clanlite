<div class="big_cadre">
	<h1>{TITRE_LIENS}</h1>
	<!-- BEGIN selection -->
	<form action="{ICI}" method="post">
		<div class="news">
			<h2>{selection.TITRE}</h2>
			<span><label for="repertoire">{selection.TXT}&nbsp;:</label></span>
			<span>
				<select name="pre-selection" id="pre-selection">
					<option value="">{selection.CHOISIR}</option>
					<!-- BEGIN liste_selection -->
					<option value="{selection.liste_selection.VALUE}" {selection.liste_selection.SELECTED}>{selection.liste_selection.TXT}</option>
					<!-- END liste_selection -->
				</select>
			</span>
			<span><input type="submit" name="Submit" value="{BT_ENVOYER}" /></span>
		</div>
	</form>
	<!-- END selection -->
	<div class="news">
		<!-- BEGIN titre_repertoire -->
		<h2>{titre_repertoire.TITRE}</h2>
		<!-- END titre_repertoire -->
		<ul>
			<!-- BEGIN liens -->
			<li><a href="{liens.URL}" onclick="window.open('{liens.URL}');return false;">{liens.NOM}
			<!-- BEGIN image -->
			<br /><img src="{liens.IMAGE}" alt="{liens.NOM}" />
			<!-- END image -->
			</a></li>
			<!-- END liens -->
		</ul>
	</div>
</div>