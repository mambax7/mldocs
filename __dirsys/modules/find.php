<?php

if(isset($LANGUE))
// ces 3 variables sont indispensable
$ModuleTitle = $LANGUE['find'];
$ModuleIco = "find/find.gif";
$EnableModule = true;
$AdminModule = false;

//cette condition permet au script de savoir si il dois inclure ou non le fichier du module!
if (dirname(__FILE__)==getcwd())
   include('find/index_find.php');

?>
