<?php
@session_start();
include('func.inc.php');
include('../config.inc.php');
include('lang.inc.php');
$statut = $LANGUE['status_initial'];

if(!file_exists('auth/auth.inc.php')) $statut = $LANGUE['nofile'];

if (!empty($_POST['login']) && !empty($_POST['password']))
{  switch(PutAuth($_POST['login'],$_POST['password'],'auth/auth.inc.php'))
   {   case -1:
          if (CreateAuthFile($_POST['login'],$_POST['password'],"auth/auth.inc.php"))
             $statut = $LANGUE['status_creation'];
             else
              $status = $LANGUE['status_no_droit'];
          break;
       case 0:
          $statut =  $LANGUE['accesrf'];
          break;
       case 1:
          $statut =  $LANGUE['accesok'];
          break;
   }
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Affichage</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/<?php echo $CONFIG['CSS'] ?>" rel="stylesheet" 
type="text/css">
</head>
<body>
  <table style="width:100%" border="0" cellpadding="1" cellspacing="0">
  <tr class="bande" >
   <td class="miniatureliste" >[<b> <?php echo $LANGUE['nom_module'] ?>
</b> ]</td>
  </tr>
</table>
<br /><br /><br /><br />
<form action="" method="post">
<table border="0" align="center">
  <tr>
   <td><?php echo $LANGUE['login'].' :'; ?></td>
   <td><input name="login" type="text"></td>
  </tr>
  <tr>
   <td><?php echo $LANGUE['pass'].' :'; ?></td>
   <td><input name="password" type="password"></td>
  </tr>
</table>
<div class="center"><input type="submit" name="log" value="<?php echo $LANGUE['valider'] ?>"></div>
</form>
<div class="titre1" align="center"><?php echo $LANGUE['status'].' : '.$statut;?></div>
<?php

    if ($statut == $LANGUE['accesok'])
    {  echo ' <form action="" method="post">';
       echo '  <div class="titre1" align="center">'."\n";
       echo "   <br><br><br>\n";
       echo '   <input type="submit" name="suppr" value="'.$LANGUE['suppr'].'" /><br>'."\n";
       echo '  </div>'."\n";
       echo ' </form>';
       echo '<script language="javascript">';
        echo "open('../arbre.php','tree','');";
        echo '</script>';
    }
    //-- On a cliqué sur le bouton suppr
    if (isset($_POST['suppr']))
    {  //-- suppr du fichier auth.inc.php
       $val = @unlink("auth/auth.inc.php");
       echo " <br><br><br><br>\n";
       echo ' <div class="titrre1" align="center">';
       if ($val)
          echo $LANGUE['supprok'];
          else
            echo $LANGUE['supprko'];
       echo "</div>\n";
    }
?>

</body>
</html>
