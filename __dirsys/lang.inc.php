<?php
if(!isset($CONFIG['SYS_LANG'])) 
        $CONFIG['SYS_LANG'] = 'fr';

switch($CONFIG['SYS_LANG'])
	{
	case 'fr' :
                $LANGUE['Dossiers'] = 'Dossiers';
                $LANGUE['Nom'] = 'Nom';
                $LANGUE['Taille'] = 'Taille';
                $LANGUE['Type'] = 'Type';
                $LANGUE['Date'] = 'Modifié le';
                $LANGUE['Precedent'] = 'Precedent';
                $LANGUE['Suivant'] ='Suivant';
                $LANGUE['Taille_reelle'] = 'Taille reelle';
                $LANGUE['Ajuste'] = 'Ajusté';
                $LANGUE['Fermer'] = 'Fermer';
                $LANGUE['Retour'] = 'Retour';
                $LANGUE['Slide_Show'] = 'Slide Show';
                $LANGUE['TN_Erreur1'] = 'ERREUR';
                $LANGUE['TN_Erreur2'] = 'Erreur de creation';
                $LANGUE['TN_Erreur3'] = 'Format non supporté';
                $LANGUE['ERR_Violation'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERREUR-</b><br />Violation de parametres</font>';
                $LANGUE['ERR_Config'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERREUR-</b><br />Probleme de configuration du fichier config.inc.php</font>';
                $LANGUE['ERR_Session'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERREUR-</b><br />Probleme de Sessions, si vous etes chez free.fr, voyez la faq <a href="http://jcjcjcjc.free.fr/?action=faq" target="_parent">ici</a> !</font>';
                $LANGUE['infocopy'] = '&nbsp;Information &amp; Aide';
                $LANGUE['find'] = 'Rechercher un fichier';
                $LANGUE['Dir'] = 'Chemin';
		$LANGUE['Miniature'] = 'Miniature';
		$LANGUE['Liste'] = 'Liste';
                break;

        case 'eng' :
                $LANGUE['Dossiers'] = 'Folders';
                $LANGUE['Nom'] = 'Name';
                $LANGUE['Taille'] = 'Size';
                $LANGUE['Type'] = 'type';
                $LANGUE['Date'] = 'date';
                $LANGUE['Precedent'] = 'Last';
                $LANGUE['Suivant'] ='Next';
                $LANGUE['Taille_reelle'] = 'Real Size';
                $LANGUE['Ajuste'] = 'Strech to screen';
                $LANGUE['Fermer'] = 'Close';
                $LANGUE['Retour'] = 'Back';
                $LANGUE['Slide_Show'] = 'Slide Show';
                $LANGUE['TN_Erreur1'] = 'ERROR';
                $LANGUE['TN_Erreur2'] = 'Error of creating';
                $LANGUE['TN_Erreur3'] = 'File not found';
                $LANGUE['ERR_Violation'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERROR-</b><br />Acces Violation</font>';
                $LANGUE['ERR_Config'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERROR-</b><br />Bad configuration in config.inc.php</font>';
                $LANGUE['ERR_Session'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERROR-</b><br />No Sessions.</font>';
                $LANGUE['infocopy'] = '&nbsp;Information &amp; Help';
                $LANGUE['find'] = 'Find files';
                $LANGUE['Dir'] = 'Path';
		$LANGUE['Miniature'] = 'Thumbnail';
		$LANGUE['Liste'] = 'List';
                break;

        case 'de' :
                $LANGUE['Dossiers'] = 'Verzeichnisse';
                $LANGUE['Nom'] = 'Name';
                $LANGUE['Taille'] = 'Gr&ouml;&szlig;e';
                $LANGUE['Type'] = 'Typ';
                $LANGUE['Date'] = 'date';
                $LANGUE['Precedent'] = 'Last';
                $LANGUE['Suivant'] ='Next';
                $LANGUE['Taille_reelle'] = 'Real Size';
                $LANGUE['Ajuste'] = 'Strech to screen';
                $LANGUE['Fermer'] = 'Close';
                $LANGUE['Retour'] = 'Back';
                $LANGUE['Slide_Show'] = 'Slide Show';
                $LANGUE['TN_Erreur1'] = 'FEHLER';
                $LANGUE['TN_Erreur2'] = 'Error of creating';
                $LANGUE['TN_Erreur3'] = 'File not found';
                $LANGUE['ERR_Violation'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-FEHLER-</b><br />Falsche Parameter &uuml;bergeben.</font>';
                $LANGUE['ERR_Config'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-FEHLER-</b><br />In der Bearbeitung der Datei \"config.inc.php\" ist ein Fehler aufgetreten.</font>';
                $LANGUE['ERR_Session'] = '<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERROR-</b><br />No Sessions.</font>';
                $LANGUE['infocopy'] = '&nbsp;Information &amp; Help';
                $LANGUE['find'] = 'Eine Kartei zu suchen';
                $LANGUE['Dir'] = 'Path';
		$LANGUE['Miniature'] = 'Thumbnail';
		$LANGUE['Liste'] = 'List';
                break;


        default :
                die('<font size="1" face="MS Sans Serif, Courier, Arial" color="red" ><b>-ERREUR-</b><br />Probleme de selection de la langue dans le fichier \'config.inc.php\'</font>');
        }


?>
