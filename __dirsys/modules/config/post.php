<?php

session_start();

include('../../config.inc.php');
include('../auth/func.inc.php');
include('lang.inc.php');

  if (CheckAuth('../auth/auth.inc.php')!==1)
  {  
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'."\r\n";
        echo '<html>'."\r\n".'<head>'."\r\n";
        echo '<title>Config</title>'."\r\n";
        echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'."\r\n";
        echo '<link href="../../styles/'.$CONFIG['CSS'].'" rel="stylesheet" type="text/css">'."\r\n";
        echo '</head>'."\r\n".'<body>'."\r\n";
        echo '<br /><br /><br /><br /><div align="center" class="titre1">'.$LANGUE['accesrf'].'</div>'."\r\n";
        echo '</body>'."\r\n".'</html>';
        exit;
  }

  /*
    unité :
     - 0 : non renomé
     - 1 : erreur de renomage
     - 2 : renommé correctement
     
     flottant :
     - 0 : non créé
     - 1 : erreur de creation
     - 2 : créé correctement

  */

$status = 0.0;

if(!file_exists('../../config.inc.php.bak'))
        if(rename('../../config.inc.php','../../config.inc.php.bak'))
                $status = 2.0;
        else
                $status = 1.0;

if($status !== 1.0){
        $fp = @fopen('../../config.inc.php',"w");
        if($fp === false){
                @unlink('../../config.inc.php');
                rename('../../config.inc.php.bak','../../config.inc.php');
                $status += 0.1;
        }
        else{
                $status += 0.2;
                $buff = '<?php'."\r\n";

                $buff .= '$CONFIG[\'MAIN_TITLE\'] = \'' . $_POST['MAIN_TITLE'] . '\';'."\r\n";
                $buff .= '$CONFIG[\'SYS_LANG\'] = \'' . $_POST['SYS_LANG'] . '\';'."\r\n";
                $buff .= '$CONFIG[\'WIDTH_TREE_FRAME\'] = ' . $_POST['WIDTH_TREE_FRAME'] . ';'."\r\n";
                $buff .= '$CONFIG[\'FRAME_BORDER\'] = ' . $_POST['FRAME_BORDER'] . ';'."\r\n";
                $buff .= '$CONFIG[\'WIDTH_FRAME_BORDER\'] = ' . $_POST['WIDTH_FRAME_BORDER'] . ';'."\r\n";
                $buff .= '$CONFIG[\'WIDTH_FRAME_SPACING\'] = ' . $_POST['WIDTH_FRAME_SPACING'] . ';'."\r\n";
                $buff .= '$CONFIG[\'SCROLING_TREE_FRAME\'] = \'' . $_POST['SCROLING_TREE_FRAME'] . '\';'."\r\n";
                $buff .= '$CONFIG[\'RESIZE_FRAME\'] = ' . $_POST['RESIZE_FRAME'] . ';'."\r\n";
                $buff .= '$CONFIG[\'DOCUMENT_ROOT\'] = \'' . $_POST['DOCUMENT_ROOT'] . '\';'."\r\n";
                $buff .= '$CONFIG[\'DIRSYS\'] = \'' . $CONFIG['DIRSYS'] . '\';'."\r\n";
                $buff .= '$CONFIG[\'WIDTH_TD_SIZE\'] = ' . $_POST['WIDTH_TD_SIZE'] . ';'."\r\n";
                $buff .= '$CONFIG[\'WIDTH_TD_TYPE\'] = ' . $_POST['WIDTH_TD_TYPE'] . ';'."\r\n";
                $buff .= '$CONFIG[\'WIDTH_TD_DATE\'] = ' . $_POST['WIDTH_TD_DATE'] . ';'."\r\n";
                $buff .= '$CONFIG[\'STYLE\'] = ' . $_POST['STYLE'] . ';'."\r\n";
                $buff .= '$CONFIG[\'CSS\'] = \'' . $_POST['CSS'] . '\';'."\r\n";
                $buff .= '$CONFIG[\'TOTALSIZE\'] = ' . $_POST['TOTALSIZE'] . ';'."\r\n";
                $buff .= '$CONFIG[\'MASK_TYPE_FILES\'] = \'' . $_POST['MASK_TYPE_FILES'] . '\';'."\r\n";
                $buff .= '$CONFIG[\'CHECK_MAJ\'] = ' . $_POST['CHECK_MAJ'] . ';'."\r\n";
                $buff .= '$CONFIG[\'IMAGE_BROWSER\'] = ' . $_POST['IMAGE_BROWSER'] . ';'."\r\n";
                $buff .= '$CONFIG[\'IMAGE_TN\'] = ' . $_POST['IMAGE_TN'] . ';'."\r\n";
                $buff .= '$CONFIG[\'GD2\'] = ' . $_POST['GD2'] . ';'."\r\n";
                $buff .= '$CONFIG[\'IMAGE_JPG\'] = ' . $_POST['IMAGE_JPG'] . ';'."\r\n";
                $buff .= '$CONFIG[\'IMAGE_GIF\'] = ' . $_POST['IMAGE_GIF'] . ';'."\r\n";
                $buff .= '$CONFIG[\'IMAGE_BMP\'] = ' . $_POST['IMAGE_BMP'] . ';'."\r\n";
                $buff .= '$CONFIG[\'IMAGE_TN_SIZE\'] = ' . $_POST['IMAGE_TN_SIZE'] . ';'."\r\n";
                $buff .= '$CONFIG[\'IMAGE_TN_COMPRESSION\'] = ' . $_POST['IMAGE_TN_COMPRESSION'] . ';'."\r\n";
                $buff .= '$CONFIG[\'NB_COLL_TN\'] = ' . $_POST['NB_COLL_TN'] . ';'."\r\n";
                $buff .= '$CONFIG[\'EXIF_READER\'] = ' . $_POST['EXIF_READER'] . ';'."\r\n";
                $buff .= '$CONFIG[\'SLIDE_SHOW\'] = ' . $_POST['SLIDE_SHOW'] . ';'."\r\n";
                $buff .= '$CONFIG[\'DEBUG\'] = ' . $_POST['DEBUG'] . ';'."\r\n";
                $buff .= '$CONFIG[\'SLIDE_SHOW_INT\'] = ' . $_POST['SLIDE_SHOW_INT'] . ';'."\r\n";
                $buff .= '$CONFIG[\'BACK\'] = ' . $_POST['BACK'] . ';'."\r\n";
                $buff .= '$CONFIG[\'WRITE_TN\'] = ' . $_POST['WRITE_TN'] . ';'."\r\n";
                $buff .= '$CONFIG[\'AUTO_RESIZE\'] = ' . $_POST['AUTO_RESIZE'] . ';'."\r\n";

                $CONFIG['activer_Message'] =($CONFIG['activer_Message'])?'true':'false';
                $buff .= '$CONFIG[\'activer_Message\'] = ' . $CONFIG['activer_Message'] . ';'."\r\n";

                $buff .= '$CONFIG[\'Message\'] = \'' . $CONFIG['Message'] . '\';'."\r\n";

                $buff .= '#-----------------------------------------------------------------------------'."\r\n";
                $buff .= '#-----------------------------------------------------------------------------'."\r\n";
                $buff .= '# NE PAS TOUCHER TOUT CE QUI SUIT'."\r\n";
                $buff .= 'if(!include_once(dirname(__FILE__).\'/lang.inc.php\'));'."\r\n";
                $buff .= 'if(!include_once(dirname(__FILE__).\'/functions.inc.php\'));'."\r\n";
                $buff .= 'if(!include_once(dirname(__FILE__).\'/makeconfig.inc.php\'));'."\r\n";

                $buff .= '?>';

                fwrite($fp,$buff);
                fclose($fp);
        }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Config</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<?php echo '<link href="../../styles/'.$CONFIG['CSS'].'" rel="stylesheet" type="text/css">'."\r\n"; ?>
</head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="0">
  <tr class="bande" > 
    <td class="miniatureliste" >[<b> <?php echo $LANGUE['Configuration']; ?> </b>]</td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<div align="center"><b>status :</b>
<?php
echo "<br>";
switch (floor($status)){
        case 1:
                echo $LANGUE['ERR1'];
                break;
        case 2:
                echo $LANGUE['ERR2'];
                break;
}
echo "<br>";
switch ((int)(($status-floor($status))*10)) {
        case 0:
                echo $LANGUE['ERR3'];
                break;
        case 1:
                echo $LANGUE['ERR4'];
                break;
        case 2:
                echo $LANGUE['ERR5'];
                break;
}

?><br />
<br />
<input type="button" value="- ok -" onclick="open('../../../index.php','_parent','')" class="form"></div>

</body>
</html>

