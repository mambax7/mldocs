<?php

/*
voici comment ce presente un "loader" de module!
la condition est indispensable pour eviter que le loader n'execute lui meme le module!
vous pouvez appeler le module differement du loader tant que le repertoir porte le meme nom que le loader!
*/



// ces 3 variables sont indispensable
// la condition permet d'empeche un NOTICE lors de l'affichage du module
if(isset($CONFIG))
switch($CONFIG['SYS_LANG'])
{   default:
    case 'fr' :
        $ModuleTitle = "Configuration";
        break;
    case 'eng' :
        $ModuleTitle = "Configuration";
        break;
    case 'de' :
        $ModuleTitle = "Configuratie";
        break;
}

$ModuleIco = "config/ico.gif";                           // chemin vers l'icone a coté du titre dans larbre
$EnableModule = true;                                   // active ou desactive le module
$AdminModule = true;

//cette condition permet au script de savoir si il dois inclure ou non le fichier du module!
if(dirname(__FILE__)==getcwd()) include('config/index_config.php');

?>
