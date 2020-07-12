<?php
/*
CheckAuth() retournera
-1 si le fichier auth.inc.php nexiste pas (il faut alors se logger pour le creer automatiquement
0  si l'acces est refusé
1  si l'acces est autorisé
*/
@session_start() or die('Impossible de creer de session!<br><b>Si vous le script est hebergé chez FREE, il est necessaire de creer un dossier \'sessions\' à la racine de votre site!</b>');

include('../config.inc.php');
include('auth/func.inc.php');
?>
<html>
<head>
<title>Vider le cache</title>
<link href="../styles/<?php echo $CONFIG['CSS'] ?>" rel="stylesheet" type="text/css">
<link href="cleartemptn/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    
<table border="0" cellpadding="1" cellspacing="0" width="100%" >
  <tr class="bande"> 
    <td>[ Vider le Cache ]</td>
  </tr>
</table>
<?php
        $status = '';

        if (CheckAuth('auth/auth.inc.php')!==1){  
                $status = "Acces Refusé";
        }

        if(empty($status))
                $handle_source = @opendir('../temp') or
                        $status = "Impossible d'ouvrir le dossier '.dirsys/temp'";

        if(empty($status))
		if(isset($_GET['empty'])){
				while (false !== ($zone_source = readdir($handle_source))){
                		if($zone_source[0] != '.') @unlink('../temp/'.$zone_source) or
        		              $status = "Impossible de supprimer les fichiers!";
        		        
                                $status = "Fichiers correctement effacés<br /><br /><br /><br /><br /><br /><br /><br />";
                        }
		
		}

        $i = 0;
        if(empty($status)){
                while (false !== ($zone_source = readdir($handle_source))){
                        if($zone_source[0] != '.') $i++;
                }

                echo '<br /><br /><br /><br /><br />';
                echo '<div align="center" class="titre1">Il y a '.$i.' fichiers actuellement ('.convertUnits(RecursiveSize('../temp')).').</div>';
        }

?>
<br><br><br>
<?php
        if(empty($status)){
?>
<form method="get" action="">
<center><input type="submit" value="Vider le Cache" name="empty" class="form"></center>
</form>
<?php
        }
?>
<br><br><div align="center" class="titre1"><?php echo $status ?></div><br><br>
<table  border="0" align="center" width="600" class="tn" >
  <tr> 
    <td><p align="left"><font size="2" face="Arial, Helvetica, sans-serif">Les 
        vignettes sont stock&eacute;es sur le disk du serveur pour l'alleger et 
        pour accelerer l'affichage!<br>
        La creation des vignettes ce fait automatiquement, cependant leur suppression 
        n'est pas automatique. Vous pouvez les supprimer manuellement en cliquant 
        sur le bouton ci-dessus!<br>
        En general il n'est pas necessaire de supprimer ces fichiers sauf si vous 
        effectuez d'importante mise &agrave; jour sur votre site, et que vous 
        avez retir&eacute; un grand nombre d'images (photos).</font></p></td>
  </tr>
</table>
</body>
</html>
