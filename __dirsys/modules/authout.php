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
        $ModuleTitle = "Déconnexion";
        break;
    case 'eng' :
        $ModuleTitle = "Unlog";
        break;
    case 'de' :
        $ModuleTitle = "Unlog";
        break;
    default:
}
$ModuleIco = "authout/ico.png";
$EnableModule = true;
$AdminModule = true;                                    // module visible que pour l'administrateur

if (dirname(__FILE__)==getcwd())
   include('authout/index_authout.php');

?>