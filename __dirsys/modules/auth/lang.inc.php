<?php
# Fichier de definition du vocabulaire pour le module d'authentification

switch($CONFIG['SYS_LANG'])
    {
    case 'fr' :
                $LANGUE['nom_module'] = 'Authentification';
                $LANGUE['login'] = 'Identifiant';
                $LANGUE['pass'] = 'Mot de passe';
                $LANGUE['accesok'] = 'Acces autorisé';
                $LANGUE['accesrf'] = 'Acces refusé';
                $LANGUE['status'] = 'Etat';
                $LANGUE['status_initial'] = 'Veuillez vous identifier';
                $LANGUE['nofile'] = '<font color="red">ATTENTION</font><br>Veuillez définir vos identifiants pour sécuriser le site!';
                $LANGUE['status_creation'] = "Le fichier n'existait pas! il vient d'être créé avec vos identifiants! Veuillez vous relogger";
                $LANGUE['status_no_droit'] = "Impossible de créer le fichier! Veuillez vérifier que vous avez les droits d'écriture sur le serveur";
                $LANGUE['valider'] = 'Valider';
                $LANGUE['suppr'] = "Supprimer le fichier 'auth.inc.php'";
                $LANGUE['supprok'] = "Suppression du fichier 'auth.inc.php' effectuée";
                $LANGUE['supprko'] = "Suppression du fichier 'auth.inc.php' impossible";
                break;
        case 'eng' :
                $LANGUE['nom_module'] = 'Authentification';
                $LANGUE['login'] = 'Login';
                $LANGUE['pass'] = 'Password';
                $LANGUE['accesok'] = 'access authorized';
                $LANGUE['accesrf'] = 'Access refused';
                $LANGUE['status'] = 'Status';
                $LANGUE['status_initial'] = 'Please be identified';
                $LANGUE['status_creation'] = "The file did'nt exist! It has been just created with your identifiers! Please be identified";
                $LANGUE['status_no_droit'] = "Impossible to create the file!Please check that you have the rights of writing on the server";
                $LANGUE['valider'] = 'Submit';
                $LANGUE['suppr'] = "Delete 'auth.inc.php' file";
                $LANGUE['supprok'] = "File 'auth.inc.php' is deleted";
                $LANGUE['supprko'] = "Cannot to delete";
                $LANGUE['nofile'] = '<font color="red">WARNING</font><br>Please define your identifiers to make safe the site!';
                break;

        case 'de' :
                $LANGUE['nom_module'] = 'Als echt erkennen';
                $LANGUE['login'] = 'Logon';
                $LANGUE['pass'] = 'Kennwort';
                $LANGUE['accesok'] = 'Erlaubter zugang';
                $LANGUE['accesrf'] = 'Abgelehnter zugang';
                $LANGUE['status'] = 'Status';
                $LANGUE['status_initial'] = 'Identifizieren Sie sich bitte';
                $LANGUE['status_creation'] = "Die Kartei bestand nicht! es soeben entstand mit Ihren identifiants! Identifizieren Sie sich bitte";
                $LANGUE['status_no_droit'] = "Unmöglich die Kartei zu schaffen! Prüfen Sie bitte, daß Sie die Schriftrechte auf dem Host haben";
                $LANGUE['valider'] = 'reichen Sie ein';
                $LANGUE['suppr'] = "Die Kartei 'auth.inc.php' abschaffen";
                //-- A traduire /!\
                $LANGUE['supprok'] = "Durchgeführte Abschaffung der Kartei 'auth.inc.php'";
                $LANGUE['supprko'] = "Abschaffung der unmöglichen Kartei 'auth.inc.php'";
                $LANGUE['nofile'] = '<font color="red">BEACHTUNG</font><br>definieren Sie bitte Ihre identifiants, um den Standort sicherzustellen!';
                break;

        default :
                die('<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERREUR-</b><br />Probleme de selection de la langue dans le fichier \'config.inc.php\'</font>');
        }

?>


