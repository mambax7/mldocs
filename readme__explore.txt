+-----------------------------------------------------+
|  SCRIPT Entierement Ecrit par Jean Charles MAMMANA  |
|            http://www.jbc-explorer.com              |
+-----------------------------------------------------+



Installation :
Il suffit de placer tout les fichiers contenu dans l'archive ZIP a la racine de votre site!
Puis vous placez vos répertoires et fichiers dans le site.
IMPORTANT : Lisez ce fichier texte et le fichier de configuration avant de venir me poser des questions...


Configuration :
Vous pouvez modifier les paramètres dans le fichier'config.inc.php'
En cas de doutes vous pouvez laisser les paramètres par défaut!
Chaque module ralenti l'exécution du script, veuillez voir avec votre hébergeur (testé sur free sans aucun problèmes, ça rame un peu beaucoup aux heures de pointe).
Vous pouvez rajouter des types de fichiers dans la base de donnée de l'explorer, il faut éditer le fichier 'filelibrary.inc.php' (penser a rajouter les icônes dans le répertoire '.dirsys')




Historique :
Version 1.00 :
Explorateur de fichiers avec arbre d'arborescence, descripteur de fichier, reconnaissance de type.

Version 1.50 :
Insertion d'un module débrayable permettant la visualisation des images de type jpg, bmp et gif avec prechargement automatisé de l'image suivante.

Version 2.05 : 
Module de gestion et création de vignettes uniquement avec le format jpg (restriction PHP).
Possibilité de configurer la taille des vignettes ainsi que leur qualité (affichage en 256couleur : restriction PHP)

Version 2.20 :
Module de lecture des Exif pour les JPG qui en contienne.
Correction de bug (encore).

Version 2.50 :
Création dans le module browser, de nouvelles options tel que l’adaptation de limage à la taille de l'écran (comme sur winXP)
creation d'un slideshow en fullscreen :)
Apparition de nouveaux bug (et oui, sinon c’est pas drôle)

Version 2.90 :
Allègement du code Html
Ajout du support multi langue partiel : support actuel : français, anglais, allemand
(Cherche traducteurs pour m'aider à ajouter de nouvelles langues)
Correction de bug.

Version 2.94 :
Passage du code html a la version 4
Gain d'adaptation en fonction de l'hébergeur


Version 2.96
Après une bonne 15aine de mails me demandant comment faire pour cacher le répertoire système (z_system) de l’explorer, j’ai rajouter 4lignes de codes permettant de le cacher (voir fichier de configuration : config.inc.php)


Version 3.00
Vous me lavez tous demandé : je l'ai fait!!!
Possibilité de skiner l’explorer : 3 jeux d'icônes : windowsXP, KDE aqua, KDE crystal.
Aller dans le fichier de configuration pour modifier le jeu des icônes.

Version 3.05
Ajout d'un 4em jeu icône
Mode aléatoire des jeux d'icône en fonction des jours de la semaine

Version 3.07
Il semblerai q'un problème de compatibilité de charset (conversion ISO-8859-1 vers UTF-8) plante l’affichage des images (et du slideshow) avec certaine configuration de serveur (bug découvert sur apache 2).
Bref : bug corrigé :)

Version 3.08
Bah alors???
Il y a un énorme bug et personne ne me prévient???
Alalaa!! Bon, lorsque les registerglobal étaient à ‘on’, tout allait bien, mais lorsque elles étaient à ‘off’, plus rien marchait...
Bref, ça c'était avant ;)
selection (manuelle) de la fonction de creation des vignettes! (consulter config.inc.php pour plus dinformations)


Version 3.10
Correction de bug : compatibilité sur certains hebergeurs
creation d'un systeme antipub pour certain hebergeur comme multimaninia, mais le resultat n'est pas garentis a 100%


Version 3.11
Correction de bug : compatibilité sur certains hebergeurs
tiscali offrant une version de php dirons nous prehistorique, il a fallu adapter le code :)
maintenant ca marche meme chez les hebergeur dinosores :)

Version 4.00
Correction de bug de gestions des images et des vignettes
portabilité du programme sur Mozilla!

Version 4.10
Correction dun bug apparut suite a la modification de la configuration de PHP!
des messages de WARNING informant quil y a des probleme apparraissaient sans pour autant modifier le comportement du programme.
les messages ne devraient desormais plus apparaitre!

Version 4.20
Correction de 2 bugs :
impossibilité de nommer un repertoir avec le nom "0"
warning affiché quand on place le script a la racine d'un site!
ajout :
possibilité de cacher les fichiers/repertoirs de la meme maniere que sur linux, en les faisant commencer par un point (.)

version 5.00
correction de lordre d'affichage (repertoir puis fichiers)
classement par ordre alphabetique.
affichage de la date de modification.
netoyage du code!
refonte de la structure phisique du programme.
module de verification de mise a jours.

version 5.00b
amelioration du gestionnaire de mise a jour!

version 5.10
correction de bug
ajout du support png

version 5.20
correction de bug : filtre de type de fichier par extensions
debut d'adaptation du code html en xhtml
suppression du module "antipub lycos" ;)
ajout d'un module d'information de lespace occupé/libre
correction d'un bug : affichage au demarrage en vignette
ajout d'un module de recherche de fichier

version 5.25
correction de bug : slideshow ok sur mozilla
correction de bug : retour a la 1ere image en fin de slideshow
correction de bug : possibilité de modifier le root de lexploreur /!\ voir config.inc.php pour plus d'info

version 5.30
correction de bug : bug erreur 404 sur certains serveurs

version 5.35
correction de bug : bug erreur 404 sur certains serveurs (encore)

version 5.35b
correction de bug : encore le meme bug (il commence a m'enerver cuilà)

version 5.4
correction de bug : affichage centré des vignettes sur IE
ajout : possibilité de swapper entre les vignettes et la liste
ajout : 3 styles css configurable dans le fichier de config
ajout : zone html en dessous de l'arbre pour y mettre ce que vous voulez (voir fichier de config)
-- Je remercie blc29 (http://www.bbc-grc.com/) pour son travail sur les styles du script!--

version 5.50
ajout : gestionnaire de modules a acces libre/securisé!
/!\ : pour toutes les info, regardez les fichiers situé dans le repertoir 'module'


version 5.50b
ajout : possibilité d'activer ou non un module (editer le fichier correspondant au module)
bug : probleme d'affichage avec IE corrigé
bug : fautes d'orthographeuh

version 5.80
ajout : nouveaux modules
correction de bug : en tous genre!!!

version 5.85
ajout de 2 nouvelles options : 
- fleche retour
- autoresize pour laffichage des images!
correction dun petit probleme sur le module authentification

version 6.0
correction de l'affichage de notice
correction d'un bug de selection vignettes/liste
modification de la gestion des chemins ( a mort les chmod() )
/!\ il est maintenant impossible de definir un root inferieur a l'emplacement du script ( ../ )
insertion de l'atribut 'title' dans les tag <img>
mise en cache des vignettes!
correction dun bug d'affichage des vignettes
nouveaux modules
gestionnaire de camouflages de fichiers/repertoirs
/!\ voir fichier hide.php pour la liste des fichiers/dossiers caché!
reecriture complete de l'arbre (pfiou)

version 6.00b
correction de warning
ajout d'un module : compteur de visites (merci XaV pour ce module)

version 6.10
Correction de bug :
- le module find ne cachait pas les fichiers caché par le module hide!
- le module 'info et aide' disparaissait si le root etait different de '/'
mise a jours du compteur de visites (merci XaV pour ce module)
les modules admin n'apparaissent que lorsque on est loggé!
(dailleur merci a Xav pour toutes les mises a jours de cette version!)

version 6.20
- ajout de nouvelles icones 32*32px pour certains themes!
- insertion du module d'upload (merci a sanid pour son module)

version 6.20b
- correction d'une faille de securité minime dans le module upload
- correction de bugs mineurs


version 6.21
- ouverture d'un site dedié a l'explorer : http://jcjcjcjc.free.fr/
- suppression des modules non indispensable de l'archive
- correction d'un bug lié a la mise en cache des vignettes
- info : si un point noir apparait en bas a droite de chaque vignette 
	cest que la mise en cache n'est pas possible. veuillez soit la
	desactiver, soit verifier d'ou vien le probleme (consulter la faq)
- un nouveau theme


version 7.00 Alpha
Cette version est actuellement en phase de test! veuillez utiliser le forum pour signaler tout problemes ou bug!

- modification de l'algorithme de recherche de vignettes cache (accelleration fois 10)
- reecriture de la fonction de reecriture de chemin canonique (on peut maintenant definir un root n'importe où (a condition qu'il soit visible par le serveur))
- possibilité de demarrer l'explorer ailleur qu'a la racine en passant le chemin par url : http://monsite.com/explorer/index.php?0=mondossier&1=sousdossier
- gestion des frames amelioré
- verification du support des sessions au demarrage du script
- remplacement des include par include_once
- reecriture complete de la gestion des images
- reecriture du code javascript
- fonctions renommé et modifié
- liste des modules affiché par ordre alphabetique
- ajout de 2 nouvelles variables de configuration : $CONFIG['ROOT'] et $CONFIG['DIRSYS']
- le module de config recherche automatiquement les themes css dans le dossier 'styles'

version 7.01
- correction d'un bug du prechargement des images
- transparence de la bulle des informations exif

version 7.05
- correction du probleme d'affichage d'erreur sur la 1ere page sur certains hebergeurs (OVH)
- il etait impossible de nommer un dossier avec le caractere "+" : corrigé :) 
- les fichiers modifié pour cette release sont : list.inc.php, showpict.inc.php

version 7.12 Alpha 1
Cette version est actuellement en phase de test! veuillez utiliser le forum pour signaler tout problemes ou bug!

Fonctionnalités ajoutées:

- Module gestfiles. Gquick

- Styles windows XP. Psykokwak

- Utilisation de l'onglet informations sur les dossiers et fichiers en cours d'affichage: Polysosycs
	-Non en gras
	-Type de fichier ou dossier
	-Contenu X dossiers Y Fichiers, pour dossier seulement
	-Taille
	-Date de modification
	-Dimenssion pour images seulement
	-Droit pour admin uniquement
	-Affichage du pourcentage d'espace libre pour dossier root

- Installation de la fonction tri de XAV fonctionnant avec gestfiles. XAV

- Correction du bug de la flèche de retour avec la fonction de tri. Polysosycs

- Correction de l'affichage de la date d'origine et non la date de modification dans exigif. Anonyme

- Amélioration de la rapidité de création du fichier temporaire pour conserver les informations ralatives aux dossiers. Polysosycs

- Ajout de barre de séparation pour l'affichage de la liste entre les catégories nom, type, taille, date de modification. Polysosycs

- Mise à jour des informations relatives aux dossiers toutes les semaines. Polysosycs

- Déplier/Replier les onglets dans arbres.php scripts et idées de Xav. XAV

- Correction d'une faille de sécurité script de Psykokwak. Psykokwak

- Réecriture des styles.css avec l'ajout du style pour gestfiles. Polysosycs

- Ajout de fichier index.html vide dans tous les répertoires ne comportant pas de fichier index.php. Polysosycs

- Ajout des liens pour les référents pour le module compteur. XAV

Fichiers modifiés:

.dirsys/arbre.php
.dirsys/functions.inc.php
.dirsys/list.inc.php
.dirsys/list.php
.dirsys/listing.inc.php
.dirsys/showpict.php
.dirsys/showtn.php
.dirsys/tn.php
.dirsys/styles/style1.css
.dirsys/styles/style2.css
.dirsys/styles/style3.css
.dirsys/styles/style4.css
.dirsys/styles/styleXP1.css
.dirsys/styles/styleXP2.css 
.dirsys/modules/gestfiles/gestfiles.func.php
.dirsys/icones/win tous les icones: ajout du format .png pour la plupart.

Fichiers ajoutés:

index.html partout.



verion 7.13
- correction de bug en tout genre.


version 7.14
- correction de bug en tout genre.
- mise à jour des info sur le nouveau serveur (www.jbc-explorer.com)


version 7.15
- correction de problemes d'affichage de l'arbre sur IE.
- mise a jour des info sur le nouveau serveur




Merci à:

Gquick, Psykokwak, Polysosycs, XAV, et Anonyme pour leurs contributions à l'amélioration du srcipt.

Correction:

Bug avec la fonction dim dans le bloc informations sur les fichiers et dossiers.
Bug avec la fonction retour pour les filtres..
Bug Styles 1 à 4.
Bug Miniatures list, apparition d'informations inutiles.


Pour toute question ou rapport de bug, vous pouvez consulter le site du script : http://jcjcjcjc.free.fr/

