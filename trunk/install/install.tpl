<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link href="../templates/ICGstation/Library/styles.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="../templates/ICGstation/images/favicon.gif" />
		<style type="text/css">
			<!--
			.erreur {color: red;FONT-WEIGHT: bold}
			.ok {color: green;FONT-WEIGHT: bold}
			.annulé {color: orange;FONT-WEIGHT: bold}
			-->
		</style>
		<script type="text/javascript" src="../templates/ICGstation/Library/lib.js"></script>
		<title>Installation</title>
	</head>
	<body>
		<div id="flash_poper" class="flash_poper"></div>
		<div class="cadre_largeur_admin">
			<div class="hautpage"><img src="../templates/ICGstation/images/banner.jpg" alt="logo" height="100" width="950" /></div>
			<h1 class="navbar">Installation de ClanLite</h1>
			<div class="colonne_gauche">
				<div class="module">
					<div class="module_titre">Avancement</div>
					<div class="module_cellule">
						<ul style="text-align:left">
							<!-- BEGIN install_menu -->
							<li>{install_menu.VERIF_B} Vérification {install_menu.VERIF_B_END}</li>
							<li>{install_menu.INSTALL_B} Configuration {install_menu.INSTALL_B_END}</li>
							<li>{install_menu.MYSQL_B} installation {install_menu.MYSQL_B_END}</li>
							<li>{install_menu.CONFIG_B} place config.php {install_menu.CONFIG_B_END}</li>
							<li>{install_menu.FIN_B} Note de fin {install_menu.FIN_B_END}</li>
							<!-- END install_menu -->
							<!-- BEGIN update_menu -->
							<li>{update_menu.PLACER_B} place config.php {update_menu.PLACER_B_END}</li>
							<li>{update_menu.UPDATE_B} Mise à jours {update_menu.UPDATE_B_END}</li>
							<!-- END update_menu -->
						</ul>
					</div>
					<div class="module_foot"></div>
				</div>
			</div>
			<div class="colonne_central">
				<div class="big_cadre">
					<!-- BEGIN verification -->
					<div id="choix_cadre">
						<h1>Que voulez-vous faire ?</h1>
						<div class="news">
							<form action="install.php?update=true" method="post">
								<p>
									<span>Métre à jours ClanLite :</span>
									<span><input name="update" type="submit" value="Mise à jours" /></span>
								</p>
							</form>
							<p>
								<span>Installer ClanLite :</span>
								<span><input name="install" type="button" value="Installer" onclick="toggle_msg('install_cadre', this.id, '', '');toggle_msg('choix_cadre', this.id, '', '')" /></span>
							</p>
						</div>
					</div>
					<div id="install_cadre" style="display: none">
						<h1>Vérification</h1>
						<div class="news">
							<h2>Essentiel pour ClanLite</h2>
							<ul>
								<li>Version du serveur PHP =< 4.3.0 : {verification.VERSION}</li>
							</ul>
							<h2>Pouvant ne pas étre présent</h2>
							<ul>
								<li>droit d'ecriture sur le fichier de config : {verification.CONFIG}</li>
								<li>Enregistrement des erreurs : {verification.ERREUR_SQL}</li>
								<li>envois de mail : {verification.MAIL}</li>
							</ul>
							<form action="install.php" method="post">
								<input name="etape" type="hidden" value="1" />
								<input name="install" type="submit" value="Continuer l'installation" />
							</form>
						</div>
					</div>
					<!-- END verification -->
					<!-- BEGIN configuration -->
					<h1>Configuration</h1>
					<div class="news">
						<form action="install.php{URL}" method="post">
							<h2>Configuration de la connection a MySQL</h2>
							<p>
								<span><label for="serveur_mysql">Serveur&nbsp;MySQL :</label></span>
								<span><input name="serveur_mysql" id="serveur_mysql" type="text" value="{configuration.MYSQL}" /></span>
							</p>
							<p>
								<span><label for="login_mysql">Type de base de donnée&nbsp;:</label></span>
								<span>
									<select name="db_type">
										<option value="mysql" {configuration.DB_TYPE_MYSQL}>MySQL</option>
										<option value="mysqli" {configuration.DB_TYPE_MYSQLI}>MySQLi</option>
									</select>
								</span>
							</p>
							<p>
								<span><label for="login_mysql">Identifiant&nbsp;:</label></span>
								<span><input name="login_mysql" id="login_mysql" type="text" value="{configuration.MYSQL_LOGIN}" /></span>
							</p>
							<p>
								<span><label for="code_mysql">Mot de passe&nbsp;:</label></span>
								<span><input name="code_mysql" id="code_mysql" type="password" value="{configuration.MYSQL_CODE}" /></span>
							</p>
							<p>
								<span><label for="bd_mysql">Base de donnée&nbsp;:</label></span>
								<span><input name="bd_mysql" id="bd_mysql" type="text" value="{configuration.MYSQL_DB}" /></span>
							</p>
							<p>
								<span>
								<label for="prefix_mysql">Préfixe des tables&nbsp;:</label>
								</span>
								<span><input name="prefix_mysql" id="prefix_mysql" type="text" value="{configuration.MYSQL_PREFIX}" /></span>
							</p>
							<p>
								<span><label for="skin">Skin du portail&nbsp;:</label></span>
								<span>
									<select name="skin" id="skin">
										<!-- BEGIN liste_skin -->
										<option value="{configuration.liste_skin.FILE}" {configuration.liste_skin.SELECTED}>{configuration.liste_skin.FILE}</option>
										<!-- END liste_skin -->
									</select>
								</span>
							</p>
							<!-- BEGIN profil -->
							<h2>Création du profil administrateur</h2>
							<p>
								<span><label for="user_login">Identifiant&nbsp;:</label></span>
								<span><input name="user_login" id="user_login" type="text" value="{configuration.USER_LOGIN}" /></span>
							</p>
							<p>
								<span>
								<label for="user_code">Mot de passe&nbsp;:</label>
								</span>
								<span><input name="user_code" id="user_code" type="password" value="{configuration.USER_CODE}" /></span>
							</p>
							<p>
								<span><label for="user_mail">Mail admin&nbsp;:</label></span>
								<span><input name="user_mail" id="user_mail" type="text" value="{configuration.USER_MAIL}" /></span>
							</p>
							<!-- END profil -->
							<p>
								<span>
									<input name="etape" type="hidden" value="2" />
									<input type="submit" name="connect_mysql" value="Envoyer" />
								</span>
							</p>
						</form>
					</div>
					<!-- END configuration -->
					<!-- BEGIN configuration_erreur -->
					<h1>Erreur</h1>
					<div class="news">
						<form action="install.php{URL}" method="post">
							<!-- BEGIN vide -->
							<p>Votre formulaire n'est pas complet !</p>
							<!-- END vide -->
							<!-- BEGIN mysql -->
							<p>
								<span class="erreur">{configuration_erreur.mysql.ERREUR}</span>
							</p>
							<!-- END mysql -->
							<p>
								<span>
									<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="{configuration_erreur.MYSQL}" />
									<input name="db_type" type="hidden" id="db_type" value="{configuration_erreur.DB_TYPE}" />
									<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="{configuration_erreur.MYSQL_PREFIX}" />
									<input name="login_mysql" type="hidden" id="login_mysql" value="{configuration_erreur.MYSQL_LOGIN}" />
									<input name="code_mysql" type="hidden" id="code_mysql" value="{configuration_erreur.MYSQL_CODE}" />
									<input name="bd_mysql" type="hidden" id="bd_mysql" value="{configuration_erreur.MYSQL_DB}" />
									<input name="user_login" type="hidden" id="user_login" value="{configuration_erreur.USER_LOGIN}" />
									<input name="user_code" type="hidden" id="user_code" value="{configuration_erreur.USER_CODE}" />
									<input name="user_mail" type="hidden" id="user_mail" value="{configuration_erreur.USER_MAIL}" />
									<input name="skin" type="hidden" id="skin" value="{configuration_erreur.SKIN}" />
									<input name="etape" type="hidden" value="1" />
									<input type="submit" name="install" value="Vérifier la configuration" />
								</span>
							</p>
						</form>
					</div>
					<!-- END configuration_erreur -->
					<!-- BEGIN install -->
					<h1>Installation</h1>
					<div class="news">
						<form action="install.php" method="post">
							<ul>
								<li>Connection à Mysql : <span class="ok">Connecté au serveur</span></li>
								<!-- BEGIN action -->
								<li>
									<a href="#" onclick="toggle_msg('{install.action.ID}', '', '')">[détails]</a> {install.action.TITRE} : {install.action.STATUS}
									<ul style="display:none" id="{install.action.ID}">
										<!-- BEGIN liste -->
										<li>{install.action.liste.ACTION} : {install.action.liste.RESULTAT}</li>
										<!-- END liste -->
									</ul>
								</li>
								<!-- END action -->
							</ul>
							<p>
								<span>
									<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="{install.MYSQL}" />
									<input name="db_type" type="hidden" id="db_type" value="{install.DB_TYPE}" />
									<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="{install.MYSQL_PREFIX}" />
									<input name="login_mysql" type="hidden" id="login_mysql" value="{install.MYSQL_LOGIN}" />
									<input name="code_mysql" type="hidden" id="code_mysql" value="{install.MYSQL_CODE}" />
									<input name="bd_mysql" type="hidden" id="bd_mysql" value="{install.MYSQL_DB}" />
									<input name="user_login" type="hidden" id="user_login" value="{install.USER_LOGIN}" />
									<input name="user_code" type="hidden" id="user_code" value="{install.USER_CODE}" />
									<input name="user_mail" type="hidden" id="user_mail" value="{install.USER_MAIL}" />
									<input name="skin" type="hidden" id="skin" value="{install.SKIN}" />
									<input name="etape" type="hidden" value="3" />
									<input type="submit" name="install" value="Mise en place du fichier config.php" />
								</span>
							</p>
						</form>
					</div>
					<!-- END install -->
					<!-- BEGIN nouvelle_version -->
					<h1>Mise à jour de ClanLite vers la version {nouvelle_version.VERSION}</h1>
					<div class="news">
						<!-- BEGIN erreur -->
						{nouvelle_version.erreur.TXT}
						<!-- END erreur -->
						<form action="../index.php" method="post">
						<!-- BEGIN normal -->
							<ul>
								<!-- BEGIN action -->
								<li>
									<a href="#" onclick="toggle_msg('{nouvelle_version.normal.action.ID}', '', '')">[détails]</a> {nouvelle_version.normal.action.TITRE}
									<ul style="display:none" id="{nouvelle_version.normal.action.ID}">
										<!-- BEGIN liste -->
										<li>{nouvelle_version.normal.action.liste.ACTION} : {nouvelle_version.normal.action.liste.RESULTAT}</li>
										<!-- END liste -->
									</ul>
							  </li>
								<!-- END action -->
							</ul>
							<!-- END normal -->
							<p>Prenez le temps de lire <a href="../DOCS/INSTALL.html#upgradeSTABLE">la documentation sur la mise à jour depuis une précédente version de ClanLite</a></p>
							<p>
								<span>
									<input type="submit" name="install" value="Retourner au portail" />
								</span>
							</p>
						</form>
					</div>
					<!-- END nouvelle_version -->
					<!-- BEGIN place -->
					<h1>Mise en place du fichier config.php</h1>
					<div class="news">
						<!-- BEGIN manuel_oui -->
						<form action="install.php{URL}" method="post">
							<ul>
								<li>Mise en place automatique : {place.manuel_oui.TXT}</li>
							</ul>
							<p>
								<span>
									<input type="submit" name="readme" value="Finir l'installation" />
									<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="{place.MYSQL}" />
									<input name="db_type" type="hidden" id="db_type" value="{place.DB_TYPE}" />
									<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="{place.MYSQL_PREFIX}" />
									<input name="login_mysql" type="hidden" id="login_mysql" value="{place.MYSQL_LOGIN}" />
									<input name="code_mysql" type="hidden" id="code_mysql" value="{place.MYSQL_CODE}" />
									<input name="bd_mysql" type="hidden" id="bd_mysql" value="{place.MYSQL_DB}" />
									<input name="user_login" type="hidden" id="user_login" value="{place.USER_LOGIN}" />
									<input name="user_code" type="hidden" id="user_code" value="{place.USER_CODE}" />
									<input name="user_mail" type="hidden" id="user_mail" value="{place.USER_MAIL}" />
								</span>
							</p>
						</form>
						<!-- END manuel_oui -->
						<!-- BEGIN manuel_non -->
						<form action="install.php{URL}" method="post">
							<ul>
								<li>Mise en place automatique : {place.manuel_non.TXT}</li>
							</ul>
							<p>La mise en place automatique &agrave; echou&eacute;. Vous pouvez t&eacute;l&eacute;charger le fichier config.php et le m&eacute;tre sur le FTP vous-m&ecirc;me et cliquer sur &quot;Finir l'installation&quot;.</p>
							<p>
								<span>
									<input type="submit" name="readme" value="Finir l'installation" />
									<input type="submit" name="dl_config_php" value="T&eacute;l&eacute;charger config.php" />
									<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="{place.MYSQL}" />
									<input name="db_type" type="hidden" id="db_type" value="{place.DB_TYPE}" />
									<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="{place.MYSQL_PREFIX}" />
									<input name="login_mysql" type="hidden" id="login_mysql" value="{place.MYSQL_LOGIN}" />
									<input name="code_mysql" type="hidden" id="code_mysql" value="{place.MYSQL_CODE}" />
									<input name="bd_mysql" type="hidden" id="bd_mysql" value="{place.MYSQL_DB}" />
									<input name="user_login" type="hidden" id="user_login" value="{place.USER_LOGIN}" />
									<input name="user_code" type="hidden" id="user_code" value="{place.USER_CODE}" />
									<input name="user_mail" type="hidden" id="user_mail" value="{place.USER_MAIL}" />
								</span>
							</p>
						</form>
						<!-- END manuel_non -->
					</div>
					<!-- END place -->
					<!-- BEGIN readme -->
					<h1>Note de fin</h1>
					<form action="../index.php" method="post">
						<div class="news">
							<p>Tous semble en ordre pour un bon fonctionnement de ClanLite, vous pouvez maintenent l'utiliser. Il serait bien de passer dans l'administration pour configurer au mieux votre portail.</p>
							<input name="install" type="submit" value="Aller sur le portail" />
						</div>
					</form>
					<!-- END readme -->
					<!-- BEGIN readme_erreur -->
					<h1>Erreur</h1>
					<form action="install.php{URL}" method="post">
						<div class="news">
							<p>Le fichier config.php n'est pas placé au bon endroit, vous devez retourner en arriére pour le placer correctement.</p>
							<input name="readme" type="submit" value="Revérifier" />
							<input name="send_config" type="submit" value="Recommencer l'envois de config.php" />
							<input name="serveur_mysql" type="hidden" id="serveur_mysql" value="{readme_erreur.MYSQL}" />
							<input name="db_type" type="hidden" id="db_type" value="{readme_erreur.DB_TYPE}" />
							<input name="prefix_mysql" type="hidden" id="prefix_mysql" value="{readme_erreur.MYSQL_PREFIX}" />
							<input name="login_mysql" type="hidden" id="login_mysql" value="{readme_erreur.MYSQL_LOGIN}" />
							<input name="code_mysql" type="hidden" id="code_mysql" value="{readme_erreur.MYSQL_CODE}" />
							<input name="bd_mysql" type="hidden" id="bd_mysql" value="{readme_erreur.MYSQL_DB}" />
							<input name="user_login" type="hidden" id="user_login" value="{readme_erreur.USER_LOGIN}" />
							<input name="user_code" type="hidden" id="user_code" value="{readme_erreur.USER_CODE}" />
							<input name="user_mail" type="hidden" id="user_mail" value="{readme_erreur.USER_MAIL}" />
						</div>
					</form>
					<!-- END readme_erreur -->
				</div>
			</div>
			<div class="copyright">
				<div class="cellule_copyright"></div>
			</div>
		</div>
	</body>
</htm>