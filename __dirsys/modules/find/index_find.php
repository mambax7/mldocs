<?php
        include('../config.inc.php');
        include('lang.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Affichage</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/<?php echo $CONFIG['CSS'] ?>" rel="stylesheet" type="text/css">
</head>
<body>
    <table border="0" cellpadding="1" cellspacing="0" width="100%" >
    <tr class="bande">
    <td colspan="2" ><?php echo $LANGUE['Nom'] ?></td>
    <td ><?php echo $LANGUE['Dir'] ?></td>
    <td style="width:<?php echo $CONFIG['WIDTH_TD_SIZE'] ?>px" align="right"><?php echo $LANGUE['Taille'] ?>&nbsp;</td>
    <td style="width:<?php echo $CONFIG['WIDTH_TD_TYPE'] ?>px" >&nbsp;<?php echo $LANGUE['Type'] ?></td>
    <td style="width:<?php echo $CONFIG['WIDTH_TD_DATE'] ?>px" >&nbsp;<?php echo $LANGUE['Date'] ?></td>
    </tr>
<?php

        $casesensitive = (empty($_POST['sensitive']))? false : true;
        if(!empty($_POST['find'])) $findMatch = FindRecursiv($CONFIG['DOCUMENT_ROOT'],$_POST['find'],$casesensitive);
        else $findMatch = array();

        while(list($key,$val) = each($findMatch)){
                $info = file_library($val);
                $nameOfFile = Win2UnixShlash(basename($val));
                $pathOfFile = Win2UnixShlash(dirname($val));
                //echo " - ";
                //echo Win2UnixShlash(substr(dirname(__FILE__),0,-20));
                //echo "<br>";
                //echo $_SERVER['PHP_SELF'] . ' - ' . __FILE__ . '<br> $complementPath : ';
                //echo $complementPath = substr(dirname($_SERVER['PHP_SELF']),0 , (-8)+(-8));
                //echo "<br> \$directoryFromRootExplorer = ";
                $directoryFromRootExplorer = SoustractPath($pathOfFile, Win2UnixShlash(substr(dirname(__FILE__),0,-20)));
                //echo "<br> \$relativPathOfFile = ";
                $relativPathOfFile = RemoveLastSlashes(SoustractPath($pathOfFile, Win2UnixShlash($CONFIG['DOCUMENT_ROOT'])));

               $TYPE_FILES_FORBIDDEN = FALSE;
                while (list($MASK_TYPE_FILES_TABLE_KEY,$MASK_TYPE_FILES_TABLE_VAL) = each($CONFIG['MASK_TYPE_FILES_TABLE'])) {
                        if($info['ext'] == $MASK_TYPE_FILES_TABLE_VAL) $TYPE_FILES_FORBIDDEN = TRUE;
                }
                reset($CONFIG['MASK_TYPE_FILES_TABLE']);
                if($TYPE_FILES_FORBIDDEN) continue;


       // -------- Creation des liens --------
                if($CONFIG['IMAGE_TN'] && SelectAffichType('',$val,$CONFIG)) $file_to_open = 'showtn.php'; else $file_to_open = 'list.php';


                if(is_dir($val)) {
                        $explodePath = explode('/',$relativPathOfFile.'/'.$nameOfFile);
                        unset($explodePath[0]);
                        $link = $file_to_open.'?'.http_build_query($explodePath,'');
                }


                if(is_file($val)) {
                        $link = EncodeForUrl($directoryFromRootExplorer.$nameOfFile);
                        $link = "..".$link;

                        if($info['ico']=='jpg' || $info['ico']=='bmp' || $info['ico']=='gif') {
                                $explodePath = explode('/',$relativPathOfFile.'/'.$nameOfFile);
                                $last = $explodePath[sizeof($explodePath)-1];
                                unset($explodePath[sizeof($explodePath)-1]);
                                unset($explodePath[0]);
                                $explodePath['last'] = $last;
                                $link = "showpict.php?".http_build_query($explodePath,'');
                        }
                }



?>
        <tr class="lien">
        <td style="width:16px"><a href="../<?php echo $link ?>"><img src="../<?php echo $CONFIG['ICO_FOLDER'].'/'.$info['ico'].'.gif' ?>" alt="<?php echo $info['ico'] ?>" ></a></td>
        <td><a href="../<?php echo $link ?>"><?php echo $nameOfFile; ?></a></td>
        <td><?php echo $relativPathOfFile.'/'; ?></td>
        <td style="width:<?php echo $CONFIG['WIDTH_TD_SIZE'] ?>px"  align="right" ><?php echo $info['size']; ?>&nbsp;</td>
        <td style="width:<?php echo $CONFIG['WIDTH_TD_TYPE'] ?>px" >&nbsp;<?php echo $info['type']; ?></td>
        <td style="width:<?php echo $CONFIG['WIDTH_TD_DATE'] ?>px" >&nbsp;<?php echo $info['date']; ?></td>
        </tr>
     
<?php
        }
?>
</table><br />
<table border="0" width="100%">
<tr>
    <td class="recherche" align="center"><?php echo $LANGUE['find']; ?></td>
  </tr>
<tr>
<td align="center">
<form name="form1" method="post" action="">
  <input name="find" type="text" value="" maxlength="128">
  <input type="submit" value="<?php echo $LANGUE['Rechercher']; ?>">
  <br />
  <input name="sensitive" type="checkbox" value="true" checked align="absmiddle" ><?php echo $LANGUE['casesensitive']; ?>
</form>
</td></tr></table>
</body>
</html>
