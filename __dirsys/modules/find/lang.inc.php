<?php
# Fichier de definition du vocabulaire pour le module de recherche

switch($CONFIG['SYS_LANG'])
    {
    case 'fr' :
                $LANGUE['Rechercher'] = 'Rechercher';
                $LANGUE['casesensitive'] = 'Recherche insensible aux minuscules/majuscules';
                break;
        case 'eng' :
                $LANGUE['Rechercher'] = 'Find';
                $LANGUE['casesensitive'] = 'Research insensitive with the tiny/capital letters';
                break;

        case 'de' :
                $LANGUE['Rechercher'] = 'Suchen';
                $LANGUE['casesensitive'] = 'Forschung, die an den winzigen Großbuchstaben gefühllos ist';
                break;

        default :
                die('<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERREUR-</b><br />Probleme de selection de la langue dans le fichier \'config.inc.php\'</font>');
        }

?>
