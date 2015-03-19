# installation rapide #

Si vous possédez des connaissances basiques de l'utilisation de FTP et que vous avez la certitude que votre serveur ou votre hôte est compatible avec ClanLite 2, vous pouvez utiliser cette procédure d'installation rapide. Pour une explication plus détaillée, sautez ce chapitre et consultez la section 2 plus loin.

  1. Décompressez le fichier archive de ClanLite 2 dans un dossier de votre système local,
  1. Chargez tous les fichiers issus de cette archive (en conservant la structure de répertoires) dans un dossier accessible par le web sur votre serveur ou votre compte chez votre hébergeur,
  1. Modifiez les droits du fichier config.php et erreur\_sql.txt pour qu'ils soient modifiables par tous (chmod 666 ou -rw-rw-rw- via votre Client FTP),
  1. Avec votre explorateur web, pointez à l'endroit où vous avez placé ClanLite 2 en ajoutant install/install.php, par exemple http://www.mydomain.com/ClanLite2/install/install.php, http://www.mydomain.com/install/install.php etc,
  1. Renseignez toutes les informtions demandées et cliquez sur Envoyer,
  1. Modifiez les droits du fichier config.php pour qu'il ne soit modifiable que par vous-même (chmod 644 ou -rw-r--r-- via votre Client FTP),
  1. Cliquez sur le bouton Finir l'installation ou pointez de nouveau à l'endroit que vous aviez choisi précédemment,
  1. ClanLite 2 devrait maintenant être disponible, lisez tout de même la section 5 plus loin pour d'importantes instructions post-installation.

Si vous rencontrez des problèmes ou doutez de la marche à suivre pour une des étapes ci-dessus, consultez le reste de la document.
# Pré-requis #
L'installation de ClanLite 2 nécessite :
  * Un serveur web ou un compte sur un hôte web utilisant un des systèmes d'exploitation majeurs,
  * Un gestionnaire de base de données SQL MySQL (3.22 ou supérieure),
  * PHP (4.3.0 ou supérieur ou de préférence 4.x exécuté comme un module) avec support de la base de données que vous utilisez.

Si votre serveur ou votre compte ne remplit pas les pré-requis ci-dessus, il est à craindre que ClanLite 2.0 ne soit pas pour vous.
# Nouvelles Installations #
L'installation de ClanLite 2 dépend de votre serveur et votre gestionnaire de base de données. Si vous disposez d'un accès shell à votre compte (via telnet ou ssh par exemple) vous avez la possibilité de télécharger le fichier archive de ClanLite 2 (en mode binaire!) dans un répertoire de votre hôte afin de le décompresser.

Si vous n'avez pas d'accès shell ou ne désirez pas l'utiliser, vous devez décompresser le fichier archive de ClanLite 2 dans un répertoire local de votre système à l'aide de votre utilitaire favori (winzip, rar, zip, etc.) Ensuite, vous téléchargez via FTP **tous** les fichiers qui en sont extraits (en gardant la structure de répertoires et les noms des fichiers!) dans le répertoire approprié de votre hôte. Assurez-vous que la casse des noms de fichiers soit inchangée, NE forcez PAS tous les noms de fichiers en majuscules ou minuscules car cela entraînera des erreurs par la suite.

Tous les fichiers se terminant par .php, .inc, .sql, .cfg et .htm doivent être transférés en mode ascii, tandis que les fichiers images doivent l'être en mode binary (binaire). Si vous ne maîtrisez pas ces notions, merci de consulter la documentation de votre utilitaire client ftp. Dans la plupart des cas, tout ceci vous sera rendu transparent par votre utilitaire client ftp mais si vous rencontrez des problèmes par la suite, assurez-vous que les fichiers ont été transférés conformément à ce qui est décrit dans ce chapitre.

Une fois tous les fichiers téléchargés sur votre site, vous devez faire pointer votre explorateur à l'endroit choisi en ajoutant install/install.php. Par exemple, si le nom de votre domaine est www.mydomain.tld et que vous avez placé ClanLite 2 dans le répertoire /ClanLite2 situé à la racine, vous devez entrer http://www.mydomain.tld/ClanLite2/install/install.php dans l'explorateur. L'écran d'installation de ClanLite 2 devrait alors apparaître.

## Installation à partir d'une version ClanLite 1.x ##
**ATTENTION, NE** placez **PAS** les fichiers ClanLite 2 dans le même répertoire que les fichiers de ClanLite 1.x précédemment installée! Créer un nouveau dossier (ou déplacez l'ancien ClanLite 1.x), ne pas le faire vous expose à des erreurs d'exécution (runtime errors). Copiez ensuite le fichier config.php de la version 1 pour le mètre dans le répertoire de la version 2, une fois que cela est fait, vous pouvez lancer le fichier http://www.mydomain.tld/ClanLite2/install/update.php pour mètre à jour vos bases de données
## Saisie des données nécessaires ##
Une fois que vous avez atteint la page d'installation, vous avez à saisir plusieurs champs. Si vous ne disposez pas du Serveur MySQL, Type de base de donnée, etc. contactez votre hébergeur.
Le préfixe de base de données vous permet d'entrer quelques caractères, un nom court, etc. qui préfixera le nom de toutes les tables utilisées lors de l'installation. La valeur par défaut (clanlite_) est en général suffisant. Si vous disposez de plusieurs copies de ClanLite 2 utilisant la même base de données, modifiez ce paramètre ou vous risquez des erreurs lors de l'installation.
Les informations suivantes sont propres à votre site. Vous devez entrer le login admin, le code admin et le mail admin du compte administrateur initial (des administrateurs supplémentaires pourront être créés plus tard).
## Fin de l'installation ##
Une fois que vous avez vérifié toutes les données à saisir, cliquez sur "Envoyer". Le script d'installation crée et alimente toutes les tables nécessaires. L'installation essaye alors d'écrire dans le fichier config.php qui contiendra alors la configuration de base pour exécuter ClanLite 2. Si le script d'installation ne peut écrire dans config.php directement, il vous est possible de télécharger le fichier ou d'utiliser FTP pour le mettre à l'emplacement adéquat. Si vous choisissez de télécharger le fichier, il vous faut le recharger à l'emplacement du config.php existant sur votre serveur. Si vous essayez d'utiliser FTP via le script d'installation vous aurez à fournir des informations indispensables. Si FTP échoue vous pourrez télécharger le fichier et le recharger comme décrit précédemment.
Pendant la procédure d'installation de ClanLite 2 une vérification de la disponibilité du module de base de données de PHP est effectuée et le processus s'arrête si ce n'est pas le cas. Pour éviter cela, vérifiez que vous avez sélectionné la base de données correcte et/ou demandez conseil à votre hébergeur.
Ne poursuivez pas avant de terminer correctement l'installation et (si nécessaire) d'avoir recharger le fichier config.php mis à jour.
# Mise à jour depuis une précédente version de ClanLite 2 #
Si vous utilisez actuellement une précédente version stable de ClanLite 2, la mise à jour est directe. Attention: avant de mettre à jour, nous recommandons vivement de faire une sauvegarde complète de votre base de données et des fichiers ClanLite2! Si vous n'êtes pas sûr de la manière de procéder pour le faire, demandez conseil à votre hébergeur._

Si vous disposez de packs de langues différents du français, vous devez vérifier si une nouvelle version est disponible de même pour les thèmes au risque de ne plus voir certaine fonction. Un certain nombre de phrases manquantes ont été ajoutées, ce qui, même si ce n'est pas essentiel, profitera à vos utilisateurs. Notez que tous les packs de langues n'ont pas été mis à jour, préparez vous à vérifier périodiquement leur disponibilité.

La mise à jour de ClanLite 2 dépend de votre serveur et votre gestionnaire de base de données. Si vous disposez d'un accès shell à votre compte (via telnet ou ssh par exemple) vous avez la possibilité de télécharger le fichier archive de ClanLite 2 (en mode binaire!) dans un répertoire de votre hôte afin de le décompresser.

Si vous n'avez pas d'accès shell ou ne désirez pas l'utiliser, vous devez décompresser le fichier archive de ClanLite 2 dans un répertoire local de votre système à l'aide de votre utilitaire favori (winzip, rar, zip, etc.) Ensuite, vous téléchargez via FTP tous les fichiers qui en sont extraits (en gardant la structure de répertoires et les noms des fichiers!) dans le répertoire approprié de votre hôte. Assurez-vous que la casse des noms de fichiers soit inchangée, NE forcez PAS tous les noms de fichiers en majuscules ou minuscules car cela entraînera des erreurs par la suite. Attention: Pour facilité la mise à jours de ClanLite2, il est recommandé de ne pas envoyer sur le FTP le fichier config.php. Si vous le faites malgré tout, la mise à jour sera alors débuté par une étapes supplémentaire pour vous demander des informations pratiques.

Une fois tous les fichiers téléchargés sur votre site, vous devez faire pointer votre explorateur à l'endroit choisi en ajoutant install/update.php. Par exemple, si le nom de votre domaine est www.mydomain.tld et que vous avez placé ClanLite 2 dans le répertoire /ClanLite2 situé à la racine, vous devez entrer http://www.mydomain.tld/ClanLite2/install/update.php dans l'explorateur. L'écran de mise à jour de ClanLite 2 devrait alors apparaître.
# Tâches importantes à réaliser après toute installation #

Connectez vous en tant qu'administrateur (celui que vous avez spécifié pendant l'installation) et cliquez sur le lien "Administration" en bas de n'importe quelle page. Assurez-vous que les informations affichées dans Administration -> "Configuration générale" sont correctes !
# Copier/Editer/Distribuer ? #
Cette application est un logiciel opensource sous licence GPL. Merci de lire le code source et les fichiers du dossier Docs pour plus de détails.

Cette page issue du site phpbb.biz par Darthbob (et adapté à ClanLite 2) est soumise à la licence GNU FDL.
Permission vous est donnée de distribuer, modifier des copies de cette page tant que cette note apparaît clairement.

