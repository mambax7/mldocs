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

$Tlist = $_POST;

$TlistE = array();
while(list($Tk,$Tv) = each($Tlist)){
        $Tv = trim($Tv);
        if(empty($Tv)) continue;
        $TlistE[] = $Tv;
}
if(!file_exists('../../hide.php.bak')){
        if(!rename('../../hide.php','../../hide.php.bak')) die('erreur d\'ecriture');
}

$fp = fopen('../../hide.php',"w");
if($fp === false) die('erreur');

fwrite($fp,"<?php exit(); ?>\r\n\r\n");
while(list($TkE,$TvE) = each($TlistE)){
        fwrite($fp,$TvE."\r\n");
}

fclose($fp);

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
    <td class="miniatureliste" >[<b> <?php echo $LANGUE['MENU_HIDE']; ?> </b>]</td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<div align="center"><?php echo $LANGUE['ERR5'] ?><br /><br /><input type="button" value="- ok -" onclick="open('../../../index.php','_parent','')" class="form"></div>

</body>
</html>
