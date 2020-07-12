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
include('config/lang.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Config</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/<?php echo $CONFIG['CSS'] ?>" rel="stylesheet" type="text/css">
<link href="config/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="0">
  <tr class="bande" > 
    <td class="miniatureliste" >[<b> <?php echo $LANGUE['Configuration']; ?> </b>]</td>
  </tr>
</table>
<br>
<?php
  if (CheckAuth('auth/auth.inc.php')!==1)
  {  echo '<br /><br /><br /><br /><div align="center" class="titre1">'.$LANGUE['accesrf'].'</div>'."\r\n";
     echo '</body>'."\r\n".'</html>';
     exit;
  }
?>
<form action="config/post.php" method="post">
  <table border="0" align="center" cellpadding="0" cellspacing="2">
    <tr> 
      <td> <?php echo $LANGUE['MAIN_TITLE'] ?> :</td>
      <td><input name="MAIN_TITLE" type="text" value="<?php echo $CONFIG['MAIN_TITLE'] ?>" class="form" ></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['SYS_LANG'] ?> : </td>
      <td> <select name="SYS_LANG" class="form" >
          <option value="fr" <?php if($CONFIG['SYS_LANG'] == 'fr') echo "selected" ?> >francais</option>
          <option value="eng" <?php if($CONFIG['SYS_LANG'] == 'eng') echo "selected" ?> >anglais</option>
          <option value="de" <?php if($CONFIG['SYS_LANG'] == 'de') echo "selected" ?> >allemand</option>
        </select> </td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['WIDTH_TREE_FRAME'] ?> :</td>
      <td><input name="WIDTH_TREE_FRAME" class="form" type="text" value="<?php echo $CONFIG['WIDTH_TREE_FRAME'] ?>" maxlength="3">
        px</td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['FRAME_BORDER'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td> <input type="radio" class="form" name="FRAME_BORDER" value="true"  <?php if($CONFIG['FRAME_BORDER'] == 'yes') echo "checked" ?>> 
              <?php echo $LANGUE['oui'] ?> </td>
            <td> <div align="right"> 
                <input type="radio" class="form" name="FRAME_BORDER" value="false" <?php if($CONFIG['FRAME_BORDER'] == 'no') echo "checked" ?> >
                <?php echo $LANGUE['non'] ?> </div></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['WIDTH_FRAME_BORDER'] ?> :</td>
      <td><input name="WIDTH_FRAME_BORDER" type="text" value="<?php echo $CONFIG['WIDTH_FRAME_BORDER'] ?>" class="form" maxlength="3" size="20" />
        px</td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['WIDTH_FRAME_SPACING'] ?> :</td>
      <td><input class="form" name="WIDTH_FRAME_SPACING" type="text" value="<?php echo $CONFIG['WIDTH_FRAME_SPACING'] ?>" maxlength="3">
        px</td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['SCROLING_TREE_FRAME'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" class="form" name="SCROLING_TREE_FRAME" value="YES" <?php if(strtolower($CONFIG['SCROLING_TREE_FRAME']) == "yes") echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="center"> <input type="radio" name="SCROLING_TREE_FRAME" class="form" value="NO" <?php if(strtolower($CONFIG['SCROLING_TREE_FRAME']) == "no") echo "checked";echo $CONFIG['SCROLING_TREE_FRAME']; ?> > 
              <?php echo $LANGUE['non'] ?> </td>
            <td align="right"> <input type="radio" name="SCROLING_TREE_FRAME" class="form" value="AUTO" <?php if(strtolower($CONFIG['SCROLING_TREE_FRAME']) == "") echo "checked" ?> > 
              <?php echo $LANGUE['auto'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['RESIZE_FRAME'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="RESIZE_FRAME" value="true"  <?php if($CONFIG['RESIZE_FRAME'] == '') echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="RESIZE_FRAME" value="false" <?php if($CONFIG['RESIZE_FRAME'] == 'noresize') echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['DOCUMENT_ROOT'] ?> :</td>
      <td><input name="DOCUMENT_ROOT" type="text" class="form" value="<?php echo SoustractPath($CONFIG['DOCUMENT_ROOT'],Win2UnixShlash(AddFirstSlashes(substr(dirname(__FILE__),0 , -35)))) ?>"></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['WIDTH_TD_SIZE'] ?> :</td>
      <td><input name="WIDTH_TD_SIZE" type="text" class="form" value="<?php echo $CONFIG['WIDTH_TD_SIZE'] ?>" maxlength="3">
        px</td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['WIDTH_TD_TYPE'] ?> :</td>
      <td><input name="WIDTH_TD_TYPE" type="text" class="form" value="<?php echo $CONFIG['WIDTH_TD_TYPE'] ?>" maxlength="3">
        px</td>
    </tr>
    <tr>
      <td> <?php echo $LANGUE['WIDTH_TD_DATE'] ?> :</td>
      <td><input name="WIDTH_TD_DATE" type="text" class="form" value="<?php echo $CONFIG['WIDTH_TD_DATE'] ?>" maxlength="3">
        px</td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['STYLE'] ?> : </td>
      <td> <select name="STYLE" class="form" >
          <option value="1" <?php if($CONFIG['STYLE'] == '1') echo "selected" ?> >WindowsXP</option>
          <option value="2" <?php if($CONFIG['STYLE'] == '2') echo "selected" ?> >Crystal</option>
          <option value="3" <?php if($CONFIG['STYLE'] == '3') echo "selected" ?> >Aqua</option>
          <option value="4" <?php if($CONFIG['STYLE'] == '4') echo "selected" ?> >Gorilla</option>
          <option value="0" >Random</option>
        </select> </td>
    </tr>
    <tr> 
        <td> <?php echo $LANGUE['CSS'] ?> : </td>
        <td> <select name="CSS" class="form" >
        <?php
                $dp = opendir('../styles/');
                while(($f = readdir($dp))!==false){
                        if($f[0] == '.') continue;
                        $tf = explode('.', $f);
                        $l = count($tf);
                        $ext = strtolower($tf[$l-1]);
                        if($ext != 'css') continue;
        ?>
        <option value="<?php echo $f ?>" <?php if($CONFIG['CSS'] == $f) echo "selected" ?> ><?php echo $f ?></option>
        <?php
                }
                closedir($dp);
        ?>
        </select> </td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['TOTALSIZE'] ?> :</td>
      <td><input name="TOTALSIZE" type="text" value="<?php echo ($CONFIG['TOTALSIZE']/1024/1024) ?>" class="form" >
        Mo </td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['MASK_TYPE_FILES'] ?>) :</td>
      <td><input name="MASK_TYPE_FILES" type="text" value="<?php echo $CONFIG['MASK_TYPE_FILES'] ?>" class="form" > 
      </td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['CHECK_MAJ'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr> 
            <td><input type="radio" name="CHECK_MAJ" value="true"  class="form"  <?php if($CONFIG['CHECK_MAJ'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="CHECK_MAJ" value="false" class="form"  <?php if($CONFIG['CHECK_MAJ'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['IMAGE_BROWSER'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="IMAGE_BROWSER" value="true"  class="form"  <?php if($CONFIG['IMAGE_BROWSER'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?></td>
            <td align="right"> <input type="radio" name="IMAGE_BROWSER" value="false" class="form"  <?php if($CONFIG['IMAGE_BROWSER'] == false) echo "checked" ?> > 
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>    <tr> 
      <td> <?php echo $LANGUE['AUTO_RESIZE'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="AUTO_RESIZE" value="true"  class="form"  <?php if($CONFIG['AUTO_RESIZE'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?></td>
            <td align="right"> <input type="radio" name="AUTO_RESIZE" value="false" class="form"  <?php if($CONFIG['AUTO_RESIZE'] == false) echo "checked" ?> > 
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['IMAGE_TN'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td> <input type="radio" name="IMAGE_TN" value="true" class="form"   <?php if($CONFIG['IMAGE_TN'] == true) echo "checked" ?> > 
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="IMAGE_TN" value="false" class="form"  <?php if($CONFIG['IMAGE_TN'] == false) echo "checked" ?> > 
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['GD2'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="GD2" value="true"  class="form"  <?php if($CONFIG['GD2'] == true) echo "checked" ?>>
              <?php echo $LANGUE['oui'] ?></td>
            <td align="right"> <input type="radio" name="GD2" value="false" class="form"  <?php if($CONFIG['GD2'] == false) echo "checked" ?> > 
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['IMAGE_JPG'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="IMAGE_JPG" value="true"  class="form"  <?php if($CONFIG['IMAGE_JPG'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="IMAGE_JPG" value="false" class="form"  <?php if($CONFIG['IMAGE_JPG'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['IMAGE_GIF'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="IMAGE_GIF" value="true" class="form"   <?php if($CONFIG['IMAGE_GIF'] == true) echo "checked" ?> > 
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="IMAGE_GIF" value="false" class="form"  <?php if($CONFIG['IMAGE_GIF'] == false) echo "checked" ?> > 
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['IMAGE_BMP'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="IMAGE_BMP" value="true"  class="form"  <?php if($CONFIG['IMAGE_BMP'] == true) echo "checked" ?> > 
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="IMAGE_BMP" value="false" class="form"  <?php if($CONFIG['IMAGE_BMP'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['IMAGE_TN_SIZE'] ?> :</td>
      <td><input name="IMAGE_TN_SIZE" type="text" class="form" value="<?php echo $CONFIG['IMAGE_TN_SIZE'] ?>" maxlength="3">
        px</td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['IMAGE_TN_COMPRESSION'] ?> :</td>
      <td><input name="IMAGE_TN_COMPRESSION" type="text" class="form"  value="<?php echo $CONFIG['IMAGE_TN_COMPRESSION'] ?>" maxlength="3">
        %</td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['NB_COLL_TN'] ?> :</td>
      <td><input name="NB_COLL_TN" type="text" class="form"  value="<?php echo $CONFIG['NB_COLL_TN'] ?>" maxlength="3"> 
      </td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['EXIF_READER'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="EXIF_READER" class="form"  value="true"  <?php if($CONFIG['EXIF_READER'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="EXIF_READER" class="form"  value="false" <?php if($CONFIG['EXIF_READER'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['SLIDE_SHOW'] ?> :</td>
      <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="SLIDE_SHOW" class="form"  value="true"  <?php if($CONFIG['SLIDE_SHOW'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?> </td>
            <td align="right"> <input type="radio" name="SLIDE_SHOW" class="form"  value="false" <?php if($CONFIG['SLIDE_SHOW'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['SLIDE_SHOW_INT'] ?> :</td>
      <td><input name="SLIDE_SHOW_INT" type="text" class="form"  value="<?php echo $CONFIG['SLIDE_SHOW_INT'] ?>" maxlength="3">
        sec </td>
    </tr>
    <tr> 
      <td> <?php echo $LANGUE['DEBUG'] ?> :</td>
      <td> <table width="100%" border="0"  cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="DEBUG" class="form"  value="true"  <?php if($CONFIG['DEBUG'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?></td>
            <td align="right"> <input type="radio" name="DEBUG"  class="form" value="false" <?php if($CONFIG['DEBUG'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>    <tr> 
      <td> <?php echo $LANGUE['BACK'] ?> :</td>
      <td> <table width="100%" border="0"  cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="BACK" class="form"  value="true"  <?php if($CONFIG['BACK'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?></td>
            <td align="right"> <input type="radio" name="BACK"  class="form" value="false" <?php if($CONFIG['BACK'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>    <tr> 
      <td> <?php echo $LANGUE['WRITE_TN'] ?> :</td>
      <td> <table width="100%" border="0"  cellpadding="0" cellspacing="0">
          <tr> 
            <td><input type="radio" name="WRITE_TN" class="form"  value="true"  <?php if($CONFIG['WRITE_TN'] == true) echo "checked" ?> >
              <?php echo $LANGUE['oui'] ?></td>
            <td align="right"> <input type="radio" name="WRITE_TN"  class="form" value="false" <?php if($CONFIG['WRITE_TN'] == false) echo "checked" ?> >
              <?php echo $LANGUE['non'] ?> </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p align="center">
        <a href="config/hidemodule.php"><?php echo $LANGUE['MENU_HIDE'] ?></a>
        <br /><br />
    <input type="submit" class="form" value="<?php echo $LANGUE["MAJ"] ?>">
  </p>
</form>
</body>
</html>
