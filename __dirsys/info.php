<?php
        include_once('./config.inc.php');
     
        $uptodate = false;
        
         /*  
        if($CONFIG['CHECK_MAJ']){
                $version = 715;  // Indicateur de version! ne pas toucher!
                $t = @file('http://www.jbc-explorer.com/system/version');
                if($t != false)
                if($t[0] > $version) $uptodate = true;
        }
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>INFO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/<?php echo $CONFIG['CSS'] ?>" rel="stylesheet" type="text/css">
</head>
<body>
<br>
<div class="center"><img src="img/jbc_explorer.gif" alt="web explorer"><p></p><p class="center"><b>Version 7.15</b></p>
<div class="borderinfo"><b>Liste des extensions actuellement cach&eacute;:</b>
  <div><?php echo $CONFIG['MASK_TYPE_FILES'] ?></div>
  <p></p>
  <div><b>Configuration :</b></div>
  <div><?php
		  if($CONFIG['IMAGE_BROWSER']) echo 'Browser activ&eacute;';
		  else echo 'Browser inactiv&eacute;';
		  ?></div>
<div><?php
		  echo "Langue selectionn&eacute; : '".$CONFIG['SYS_LANG']."'";
		  ?></div>
<div><?php
		  if($CONFIG['IMAGE_TN']) echo 'Vignettes activ&eacute;';
		  else echo 'Vignettes inactiv&eacute;';
		  ?></div>
<div><?php
		  if($CONFIG['EXIF_READER']) echo 'Lecteur EXIF activ&eacute;';
		  else echo 'Lecteur EXIF inactiv&eacute;';
		  ?></div>
<div><?php
		  if($CONFIG['SLIDE_SHOW']) echo 'Slide Show activ&eacute;, interval :'.$CONFIG['SLIDE_SHOW_INT'].'sec';
		  else echo 'Slide Show inactiv&eacute;';
		  ?></div>
<div><?php
		  if($CONFIG['GD2']) echo 'Support GD2 Activ&eacute;';
		  else echo 'Support GD2 D&eacute;sactiv&eacute;';
		  ?></div>
<div>
    <?php if($CONFIG['WRITE_TN']) echo 'Mise en cache des vignettes Activ&eacute;';
		  else echo 'Mise en cache des vignettes D&eacute;sactiv&eacute;';
		  ?></div>
<div>
    <?php if($CONFIG['IMAGE_JPG']) echo 'Support Jpeg Activ&eacute;';
		  else echo 'Support Jpeg D&eacute;sactiv&eacute;';
		  ?></div>
<div>
    <?php if($CONFIG['IMAGE_GIF']) echo 'Support Gif Activ&eacute;';
		  else echo 'Support Gif D&eacute;sactiv&eacute;';
		  ?></div>
<div>
    <?php if($CONFIG['IMAGE_BMP']) echo 'Support Bmp Activ&eacute;';
		  else echo 'Support Bmp D&eacute;sactiv&eacute;';
		  ?></div>
<div>
    <?php if($CONFIG['DEBUG']) echo 'Mode debug Activ&eacute;';
		  else echo 'Mode debug D&eacute;sactiv&eacute;';
		  ?></div>
<div>
    <?php if($CONFIG['CHECK_MAJ']) { echo 'Verification de mise a jour Activ&eacute;';if ($uptodate) echo ' [<b> Nouvelle version Disponible! </b> ]';else echo ' [<b> Version à jour. </b> ]';}
		  else echo 'Verification de mise a jour D&eacute;sactiv&eacute;';
		  ?></div>
</div>
<p></p>
<div class="borderinfo">
  <div><b>Espace Utilis&eacute; par le Script :</b></div>
<?php

        $TotalSize = $CONFIG['TOTALSIZE'];
        $UsedSize = RecursiveSize($CONFIG['DOCUMENT_ROOT']);
        if($TotalSize < $UsedSize) $TotalSize = $UsedSize;
        $FreeSize = $TotalSize - $UsedSize;

        echo '<div>Espace total :   '.convertUnits($TotalSize).'</div>';
        echo '<div>Espace utilis&eacute; : '.convertUnits($UsedSize).'</div>';
        echo '<div>Espace libre :   '.convertUnits($FreeSize).'</div>';

        $taille = 450;
        echo "<div class=\"center\">\n<img src=\"img/redsizestart.gif\" height=\"14\" alt=\"\">";
        echo '<img src="img/redsize.gif" width="'.(int)($UsedSize/$TotalSize*$taille).'" height="14" alt="">';
        echo '<img src="img/bluesize.gif"  width="'.(int)($FreeSize/$TotalSize*$taille).'" height="14" alt="">';
        echo "<img src=\"img/bluesizestart.gif\" height=\"14\" alt=\"\">\n</div>";
?>
</div><p></p>
<div class="borderinfo">
<div><b>Aide :</b></div>
    <div>Veuillez Consulter la FAQ et le Forum pour tous problemes ou questions!</div>
	  <div>Telechargement du Programme : <a href="http://www.byoos.fr/?action=download"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/disk.gif" alt="cliquez ici!!!" align="absmiddle" title="cliquez ici" ></a></div>
	</div>
<p></p>
<div class="borderinfo">Auteur du script : BYOOS solutions & MAMMANA Jean Charles.<br />
Site web : <a href="http://www.byoos.fr">http://wwwbyoos.fr/</a><br />
</div>
<?php
if ($uptodate) echo "<script language=\"javascript\">var v = confirm('Une Nouvelle version du script est disponible.\\ncliquez sur ok pour la telecharger.');if(v) open('http://mldocs.org/?action=download','_self','');</script>";
?>
<p></p></body>
</html>
