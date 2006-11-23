<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" href="../templates/ICGstation/Library/styles.css" type="text/css" media="screen" />
	</head>
	<body>
		<!-- BEGIN lecteur -->
		<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="100%" height="16" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
			<param name="src" value="{lecteur.SRC}" />
			<param name="loop" value="{lecteur.LOOP}" />
			<param name="autoplay" value="{lecteur.AUTOPLAY}" />
			<embed src="{lecteur.SRC}" loop="{lecteur.LOOP}" autoplay="{lecteur.AUTOPLAY}" height="16" width="100%"></embed>
		</object>
		<!-- END lecteur -->
		<!-- BEGIN demande -->
		<div class="demande_mp3"><a href="lecteur_mp3.php?lecture=true">{demande.TXT}</a></div>
		<!-- END demande -->
	</body>
</html>