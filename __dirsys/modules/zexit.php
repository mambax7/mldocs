<?php
/*******************************************************************************************
*   Script du module déconnexion réalisé par XaV pour le projet JBC Explorer               *
*   Site web du projet : http://jcjcjcjc.free.fr/                                          *
*   Forum du projet : http://www.freescript.be/viewforum.php?forum=10                      *
*   Mon mail : xabi62@yahoo.fr                                                             *
*                                                                                          *
*   Le script permet de se déconnecter après s'être identifer.                             *
*                                                                                          *
*******************************************************************************************/

if(isset($CONFIG))
switch($CONFIG['SYS_LANG'])
{
    case 'fr' :
        $ModuleTitle = "Quitter";
        break;
    case 'eng' :
        $ModuleTitle = "Exit";
        break;
    case 'de' :
        $ModuleTitle = "Exit";
        break;
    default:
}
$ModuleIco = "zexit/close.png";
$EnableModule = true;
$AdminModule = False;                                    // module visible que pour l'administrateur

if (dirname(__FILE__)==getcwd())
   include('zexit/index_exit.php');

?>
