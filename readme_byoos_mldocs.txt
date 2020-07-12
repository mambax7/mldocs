BYOOS solutions  entreprise informatique en logiciels libres S.S.L.L
05000  GAP  le 10 février 2007  http://www.byoos.fr  contact@byoos.fr ou gabybob@yahoo.fr


avant toutes choses, remerciements à Skalpa, Christian, pour l'aide apportée au cours de ce projet
=> http://frxoops.org/    --  http://xoops.org  --  http://www.xoopspro.com/modules/news/

remerciements à eric JUDEN ainsi qu'à l'équipe de 3dev (http://demo.3dev.org) pour le travail fourni sur xHelp


serveur web appache 2.0 et supérieur, php 4.2 php5 et supérieur, javascript 1.2, mysql 4 et 5 supporté

testé sous UBUNTU 6.06 + apache, php5 et mysql5 de la distribution => http://www.ubuntu-fr.org/
testé sous xampp 1.5.4a sous linux et windows XP => http://www.apachefriends.org/fr/xampp.html

MLdocs est une gestion électronique de document basée sur xHelp 0.77.

OBJET: Classement centralisé de la document de l'entreprise, (vue numérisée, production de documents bureautique format Open Office, MS office, pdf) 

le principe est de créer l'archive dans un département ou service (version initiale)
à cette archive il est possible de joindre des fichiers (vues numérisées et/ou documents) et de les visualiser ensuite à l'aide des plugins

LES PLUS => MLdocs se différencie d'un simple gestionnaire d'upload par 
la gestion de la bannette comme réceptacle de vue numérisées ou de dépôt de documents à production informatique.
le contenu de cette bannette est soit  sur le réseau INTRANET soit sur le réseau EXTRANET (option FTP)
à chaque indexation le contenu est indexé dans MLdocs, tranféré sur le serveur de production et la bannette vidée automatiquement.
Il est possible d'ajouter à ce dépôt de vue(s) annexe(s) par le chargement multi-fichiers AJAX


Caractéristiques de la version de base  v0.86

- indexation de une ou plusieurs vue(s) numérisées, documents *.opt, *.pdf, *.doc, *.xls,  ....
- création d'index personnalisés
- recherche par mots clés
- classement par service (département)
- visibilité de un ou plusieurs département(s)
- gestion des droits de l'utilisateur ou rôles
- gestion de la priorité
- gestion des réponses (mini workflow) une archive <=> une réponse
- classement centralisé des archives et rayonnage informatique
- plugin  explore (application PHP permettant la visualisation des vues numérisées et/ou documents)
version actuelle implémentée => 7.15, site Internet => http://www.jbc-explorer.com
- plugin  viewer (comparable à une galerie image) visualise les formats d'images  jpg, gif,bmp, png.
NOTA: le format d'image tiff n'est pas géré à l'affichage, celui ci est convertie au format png grâce 
au fichier binaire tiff2png http://www.libpng.org/pub/png/apps/tiff2png.html


version étendue

- gestion de l'indexation avec code à barres
- intégration OCR
- recherche plein text
- sauvegarde automatisée
- scellement numérique
- gestion de la version des documents
- reprise des archives (ajout, supression, modification)
- département par défaut pour l'utilisateur connecté

Installation

MLdocs respecte la procédure d'installation des modules XOOPS2.x

à minima :

une fois connecté comme admin xoops

créer un département de base ex: BYOOS
- créer un compte au nom admin
- l'ajouter comme utilisateur (staff) de la GED
- affecter le rôle de gestionnaire d'archives (ne pas oublier de lui donner la visibilité du département BYOOS

dans le menu admin-> préférences indiquer le chemin des répertoires ou seront copiés les vues numérisées ou documents.
un répertoire cgi-bin est présent dans la racine pour la conversion du format tiff en format png
deux fichier binaires sont disponibles un pour les plateformes linux/unix  l'autre pour windows

pour certains hébergeur le répertoire cgi-bin est fixe, il sera nécessaire de modifier le script /xoops2016/modules/mldocs/fonctions.php
attention aux ressources consommées par le convertisseur tiff2png, votre hégergeur peut vous envoyer une alerte de surchage CPU????
l'idéal  étant bien sûr le serveur dédié  ou l'Intranet.

Par ailleurs dans votre fichier php.ini, il est conseillé de placer "Resource Limits"=>memory_limit =  32Mo 
afin d'éviter la page blanche liée à l'occupation de la mémoire par la classe xoopsObject (les listes sont limitées à 30 lignes, la navgation suivante de fait par pas de 30 maxi.

dans cette version la modification d'une archive n'est pas permise  (option permettant d'ajouter ou de retirer des vues au rayonnage d'archives)

option d'affectation d'un département par défaut pour un utilisateur (fonction du username de connexion)

la version actuelle v0.86  est beta et utilisée en production depuis avril 2006, 
en fonction des retours d'information que nous aurons nous passerons en version v1.0 stable

Mldocs est le début d'une suite logiciel qui aura pour objectif de fournir les outils de traitement de l'information 
sur les bases du logiciel libre diffusé sous licence GPL ou Cecill 
=> http://www.cecill.info/licences.fr.html
=> http://fsffrance.org/gpl/gpl-fr.fr.html


bonne utilisation et merci d'utiliser le forum de byoos.fr pour les remontées d'informations
Gabriel
