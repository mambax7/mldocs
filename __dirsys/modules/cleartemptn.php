<?php


// ces 3 variables sont indispensable
$ModuleTitle = "Vider le Cache";                        // titre affiché dans larbre
$ModuleIco = "cleartemptn/icon.gif";                           // chemin vers l'icone a coté du titre dans larbre
$EnableModule = TRUE;                                   // active ou desactive le module
$AdminModule = true;

if(isset($CONFIG['WRITE_TN']) && $CONFIG['WRITE_TN']===FALSE) $EnableModule = FALSE;
//cette condition permet au script de savoir si il dois inclure ou non le fichier du module!
if(dirname(__FILE__)==getcwd()) include(getcwd().'/cleartemptn/index.php');

?>
