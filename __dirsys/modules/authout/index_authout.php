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
@session_start() or die('Impossible de creer de session!<br><b>Si vous le script est hebergé chez FREE, il est necessaire de creer un dossier \'sessions\' à la racine de votre site!</b>');

function UnSetAuth()
{
     $_SESSION['authLogin'] = "";
     $_SESSION['authPassword'] = "";
}

UnSetAuth();
echo '<script language="javascript">';
echo "open('../../explore.php','_parent','');";
echo '</script>';

?>

</body>
</html>