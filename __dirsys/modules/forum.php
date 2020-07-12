<?php

// ces 3 variables sont indispensable
$ModuleTitle = "FAQ & Forum";
$ModuleIco = "forum/icone.gif";
$EnableModule = true;
$AdminModule = true;

//cette condition permet au script de savoir si il dois inclure ou non le fichier du module!
if (dirname(__FILE__)==getcwd())
   include('forum/index_forum.php');

?>
