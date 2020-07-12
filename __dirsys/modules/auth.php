<?php

if(isset($CONFIG))
switch($CONFIG['SYS_LANG'])
{
    case 'fr' :
        $ModuleTitle = "Authentification";
        break;
    case 'eng' :
        $ModuleTitle = "Authentification";
        break;
    case 'de' :
        $ModuleTitle = "Als echt erkennen";
        break;
    default:
}
$ModuleIco = "auth/ico.png";
$EnableModule = true;
$AdminModule = false;

if (dirname(__FILE__)==getcwd()){
        //chdir("auth");
        include('auth/index_auth.php');
}

?>
