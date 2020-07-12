<?php
#  +------------------ explorer ---------------------------+
#  |   SCRIPT Entierement Ecrit par Jean Charles MAMMANA   |
#  |   Url : http://www.jbc-explorer.com                   |
#  |   Contact : jc_mammana@hotmail.com                    |
#  |                                                       |
#  |   Tous les scripts utilisé dans ce projet             |
#  |   sont en libre utilisation.                          |
#  |   Tous droits de modifications sont autorisé          |
#  |   à condition de m'en informer comme précisé          |
#  |   dans les termes du contrat de la licence GPL        |
#  |                                                       |
#  +-------------------------------------------------------+

@session_start();

include_once('./config.inc.php');
include_once('./listing.inc.php');

$auth = false;
$fileListToHide = file("hide.php");

if(file_exists('modules/auth/func.inc.php')){
        include_once('./modules/auth/func.inc.php');
}


// Définition du chemin du dossier

$pass = substr($CONFIG['DOCUMENT_ROOT'], 0, -1);
foreach ($_GET as $k => $v) {
        if(!is_numeric($k)) continue;
        $pass = $pass."/".$_GET[$k];
}
$info = file_library($pass);
if (!file_exists($pass.'/.dirinfo')) DirInfoTime ($pass,'0');

// Fin Définition du chemin du dossier

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>tree</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/<?php echo $CONFIG['CSS'] ?>" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
function TestFrame(){
        <?php
                $path = '';
                if(!empty($_GET)){
                        $path = "?".http_build_query($_GET,'');
                }
        ?>
        if(!(parent.frames["tree"] && parent.frames["main"])){
                location.replace("../explore.php<?php echo $path ?>");
        }
}

/*************************************************
** Permet d'afficher ou non une portion de page **
*************************************************/
function close_open(img, id)
{  if (document.getElementById(id).style.display == "")
  {  document.getElementById(id).style.display = "none";
    img.src = "./icones/win/plus.gif";
  }  else
    {  document.getElementById(id).style.display = "";
      img.src = "./icones/win/moins.gif";
    }
}

TestFrame();

//-->
</script>
<style type="text/css">
<!--
body {
    margin-top: 10px;
}
-->
</style>
</head>
<body class="bback">
 <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
   <td height="23" colspan="3" class='Ctitre2' onclick="close_open(this, 'liste');" style="cursor:pointer">&nbsp;&nbsp;&nbsp;Liste des fichiers</td>
  </tr>
 </table>
 <div id="liste">
  <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td class='cadre'><img src="img/onepix.gif" width="1" height="1"></td>
    <td class='Ctitre2back'>
     <table width="100%"  border="0" cellspacing="0" cellpadding="4">
      <tr>
       <td>
        <table border="0" cellpadding="1" cellspacing="0">
         <tr>
          <td class='Ctitre2back'> <a href="arbre.php" onClick="open('list.php','main','')" ><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/disk.gif" alt="Serveur" title="Server" class="ico">&nbsp;<strong><?php echo $_SERVER['SERVER_NAME'] ?></strong></a><br>
          <?php listing($CONFIG['DOCUMENT_ROOT'],$_GET,$CONFIG,$LANGUE); ?></td>
         </tr>
        </table>
       </td>
      </tr>
     </table>
    </td>
    <td class='cadre'><img src="img/onepix.gif" width="1" height="1"></td>
   </tr>
   <tr class='cadre'>
    <td height="1"></td>
    <td height="1" width="202"></td>
    <td height="1"></td>
   </tr>
  </table>
 </div>
 <br>
 <!-- Définition du chemin du dossier -->
 <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
   <td height="23" colspan="3" class="Ctitre3" onclick="close_open(this, 'details');" style="cursor:pointer">&nbsp;&nbsp;&nbsp;Détails</td>
  </tr>
 </table>
 <div id="details">
  <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td class='cadre'><img src="img/onepix.gif" width="1" height="1"></td>
    <td class='Ctitre3back'>
     <table width="100%"  border="0" cellspacing="0" cellpadding="4">
      <tr>
       <td>
        <table border="0" cellpadding="1" cellspacing="0">
         <tr>
          <td colspan="2"><b><?php echo basename($pass).'</b>'; ?></td>
         </tr>
         <tr>
          <td><?php
               if ($pass == substr($CONFIG['DOCUMENT_ROOT'], 0, -1))
                  echo 'Dossier racine';
                  else
                    echo $info['type']; ?>
          </td>
         </tr>
         <tr>
          <td>&nbsp;</td>
         </tr><?php
               if(is_dir($pass)) {
                 if ($pass == substr($CONFIG['DOCUMENT_ROOT'], 0, -1)) {
                     include($pass."/.dirinfo");       
                         $ValueSize = substr($FolderSize, -2);
                         if($ValueSize = "Mo") {
                         $Pourcent = (int)(($CONFIG['TOTALSIZE'] - (substr($FolderSize, 0, -2)*1024*1024))/$CONFIG['TOTALSIZE']*100);
                         }
                         else if($ValueSize = "Go") {
                         $Pourcent = (int)(($CONFIG['TOTALSIZE'] - (substr($FolderSize, 0, -2)*1024*1024*1024))/$CONFIG['TOTALSIZE']*100);
                         } 
                         else if($ValueSize = "To") {
                         $Pourcent = (int)(($CONFIG['TOTALSIZE'] - (substr($FolderSize, 0, -2)*1024*1024*1024*1024))/$CONFIG['TOTALSIZE']*100);
                         }
                     echo DirInfoTime ($pass, "1").',&nbsp;'.$Pourcent.'% libre</td></tr>';
                 }else
                   echo DirInfoTime ($pass, "1").'</td></tr>';}
               if(is_file($pass) && ($info['ico']=="jpg" || $info['ico']=="bmp" || $info['ico']=="gif")){
                 $getdim = getimagesize($pass);
                 $dim = "Dimensions: ".$getdim['0']." * ".$getdim['1'];
                 echo "<tr><td>".$dim."</td></tr>";} ?>
         <tr>
          <td>Date de Modification : <?php datefixFRENCH($pass); ?></td>
         </tr>
         <?php if(is_file($pass)) { echo'<tr><td>Taille: '.$info['size'].'</td></tr>';} ?>
         <?php if(CheckAuth('modules/auth/auth.inc.php')===1) { echo'<tr><td>Attributs: '.substr(sprintf('%o', fileperms($pass)), -4).'</td></tr>';} ?>
        </table>
       </td>
      </tr>
     </table>
    </td>
    <td class='cadre'><img src="img/onepix.gif" width="1" height="1"></td>
   </tr>
   <tr class='cadre'>
    <td height="1"></td>
    <td height="1" width="202"></td>
    <td height="1"></td>
   </tr>
  </table>
 </div>
 <br>
 <!-- Fin de Définition du chemin du dossier -->
 <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td height="23" colspan="3" class="Ctitre3" onclick="close_open(this, 'modules');" style="cursor:pointer">&nbsp;&nbsp;&nbsp;Modules</td>
  </tr>
 </table>
 <div id="modules">
  <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="1" class='cadre'><img src="img/onepix.gif" width="1" height="1"></td>
    <td width="190" class='Ctitre3back'>
     <table width="100%"  border="0" cellspacing="0" cellpadding="4">
      <tr>
       <td>
        <table>
         <tr>
          <td><?php ListModules();?>
                <!-- Pour supprimer le lien "Information & Aide", supprimez simplement le fichier "info.php" :) //-->
          </td>
         </tr>
        </table>
       </td>
      </tr>
     </table>
    </td>
    <td width="1" class='cadre'><img src="img/onepix.gif" width="1" height="1"></td>
   </tr>
   <tr class='cadre'>
    <td height="1"></td>
    <td height="1" width="202"></td>
    <td height="1"></td>
   </tr>
  </table>
 </div>
<?php if ($CONFIG['activer_Message']){?>
 <br>
 <table width="100%">
  <tr>
   <td>
    <table class="message" align="center" >
     <tr>
      <td align="center"><br>'.$CONFIG['Message'].'<br><br></td>
     </tr>
    </table>
   </td>
  </tr>
 </table>
<?php } ?>
<?php if(file_exists("info.php")){ ?>
 <br>
 <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td height="23" colspan="3" class="Ctitre3" onclick="close_open(this, 'info');" style="cursor:pointer">&nbsp;&nbsp;&nbsp;Info</td>
  </tr>
 </table>
 <div id="info">
  <table width="204" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td class="cadre"><img src="img/onepix.gif" width="1" height="1"></td>
    <td class="Ctitre3back">
     <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
       <td>
        <table>
         <tr>
          <td><a href="info.php" target="main"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/hlp.gif" alt="Info" title="info" class="ico" ><?php echo $LANGUE['infocopy'] ?></a></td>
         </tr>
        </table>
       </td>
      </tr>
     </table>
    </td>
    <td class="cadre"><img src="img/onepix.gif" width="1" height="1"></td>
   </tr>
  <tr class="cadre">
   <td height="1"></td>
   <td height="1" width="202"></td>
   <td height="1"></td>
  </tr>
 </table>
</div>
<?php } ?>

<p>&nbsp;</p>
</body>
</html>
