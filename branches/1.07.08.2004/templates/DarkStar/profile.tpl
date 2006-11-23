<OBJECT classid='clsid:B69003B3-C55E-4B48-836C-BC5946FC3B28' codeType='application/x-oleobject' height='1' id='MsgrObj' width='1'> </OBJECT> 
<div class="big_cadre">
	<h1>{TITRE_PROFIL}</h1>
	<div class="news">
		<p>
			<span class="nom_liste">{TXT_IMAGE} :</span>
			<span class="reponce"><img src="../images/personnages/{IMAGES}" alt="{ALT_IMAGE_PERSO}" /></span>
		</p>
		<p>
			<span class="nom_liste">{TXT_NOM} :</span>
			<span class="reponce">{NOM}</span>
		</p>
		<p>
			<span class="nom_liste">{TXT_PRENOM} :</span>
			<span class="reponce">{PRENOM}</span> 
		</p>
		<p>
			<span class="nom_liste">{TXT_LOGIN} :</span>
			<span class="reponce">{LOGIN}</span> 
		</p>
		<p>
			<span class="nom_liste">{TXT_SEX} :</span>
			<span class="reponce">{SEX}</span>  
		</p>
		<p>
			<span class="nom_liste">{TXT_AGE} :</span>
			<span class="reponce">{AGE}</span>  
		</p>
		<p>
			<span class="nom_liste">{TXT_WEB} :</span>
			<a href="{WEB}" onclick="window.open('{WEB}');return false;"><span class="reponce">{WEB}</span></a>  
		</p>
		<p>
			<span class="nom_liste">{TXT_MAIL} :</span>
			<a href='mailto:{MAIL}'><span class="reponce">{MAIL}</span></a> 
		</p>
		<p>
			<span class="nom_liste">{TXT_MSN} :</span>
			<a href='javascript:DoInstantMessage("{MSN}","{LOGIN}");'><img src="../images/icon_msnm.gif" alt="{TXT_MSN}" /></a> 
		</p>
		<p>
			<span class="nom_liste">{TXT_ARME} :</span>
			<img src="../images/armes/{ARME}" alt="{ALT_ARME}" />
		</p>
		<p>
			<span class="nom_liste">{TXT_LASTCONNECT} :</span>
			<span class="reponce">{LASTCONNECT}</span>
		</p>
		<p>
			<span class="nom_liste">{TXT_POUVOIR} :</span>
			<span class="reponce">{POUVOIR}</span>
		</p>
		<!-- BEGIN grade -->
		<p>
			<span class="nom_liste">{grade.TXT_GRADE} :</span>
			<span class="reponce">{grade.GRADE}</span>
		</p>
		<!-- END grade -->
		<p>
			<span class="nom_liste">{TXT_TEXT} :</span>
			<span class="reponce">{TEXT}</span> 
		</p>
		<p>
			<span class="nom_liste">{TXT_SECTION} :</span>
			<span class="reponce">{SECTION}</span> 
		</p>
		<p>
			<span class="nom_liste">{TXT_EQUIPE} :</span>
			<span class="reponce">{EQUIPE}</span> 
		</p>
		<p>
			<span class="nom_liste">{TXT_ROLES} :</span>
			<span class="reponce">{ROLES}</span>
		</p>
		<p>
			<span class="nom_liste">{TXT_HISTOIRE} :</span>
			<span class="reponce">{HISTOIRE}</span>
		</p>
		<!-- BEGIN nombre_md_titre --> 
		<img src="../images/medailles/medaille{nombre_md_titre.NOMBRE_MD}.gif" width="71" height="119" alt"{ALT_MEDAILLES}" />
		<!-- END nombre_md_titre --> 
	</div>
</div>
