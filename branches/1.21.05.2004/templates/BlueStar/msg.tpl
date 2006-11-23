<!-- BEGIN msg -->
<div class="big_cadre">
	<h1>{msg.TYPE}</h1>
  <div class="news">{msg.TEXTE}</div>
</div>
<!-- END msg -->
<!-- BEGIN sql -->
<link rel='stylesheet' href='{sql.ROOT_PATH}templates/BlueStar/Library/styles.css' type='text/css'> 
<div class="big_cadre">
	<h1>{sql.TITRE}</h1>
		<p>
			<span>{sql.REQUETE_TXT}&nbsp;:</span>
			<span>{sql.REQUETE}</span>
		</p>
		<p>
			<span>{sql.ERROR_TXT}&nbsp;:</span>
			<span>{sql.ERROR}</span>
		</p>
		<p>
			<span>{sql.WHERE_TXT}&nbsp;:</span>
			<span>{sql.WHERE}</span>
		</p>
</div>
<!-- END sql --> 