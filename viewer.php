<?php 
/*
// viewer.php  MLdocs viewer BYOOS solutions le 29 mai 2006 version 0.8.2
// Ècrit sur la base de php photo module 0.2.3
// modification 05 juillet 2006  gabriel
*/
require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/viewer.php');

if (!defined('MLDOCS_CONSTANTS_INCLUDED')) 
{
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
}

include_once(MLDOCS_BASE_PATH.'/functions.php');



// rÈcupÈration des identifiants de l utilisateur
if(!$xoopsUser) 
{
    redirect_header(XOOPS_URL .'/user.php', 3);
}

$uid = $xoopsUser->getVar('uid');
$username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur

//include_once(MLDOCS_BASE_PATH.'/conf.php');

//error_reporting(E_ALL); // afficher les erreurs
error_reporting(0); // ne pas afficher les erreurs


/* fonction qui renomme les dossiers comprenant des caractËres interdits */

function scan_invalid_char($dir2scan) {
	if ($handle = opendir($dir2scan)) {
	   while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && eregi("[]\[\‡·‚„‰Â¿¡¬√ƒ≈»… ÀËÈÍÎÃÕŒœÏÌÓÔ“”‘’÷ÚÛÙıˆŸ⁄€‹˘˙˚¸.!@#$%^&*+{}()'=$]", $file) && is_dir($dir2scan.'/'.$file)) {
				$newfilename = $file;
				$newfilename = eregi_replace("[]\[\.!@#$%^&*+{}()'=$]", "_", $newfilename);
				$newfilename = eregi_replace("[‡·‚„‰Â¿¡¬√ƒ≈]", "a", $newfilename);
				$newfilename = eregi_replace("[»… ÀËÈÍÎ]", "e", $newfilename);
				$newfilename = eregi_replace("[«Á]", "c", $newfilename);
				$newfilename = eregi_replace("[ÃÕŒœÏÌÓÔ]", "i", $newfilename);
				$newfilename = eregi_replace("[“”‘’÷ÚÛÙıˆ]", "o", $newfilename);
				$newfilename = eregi_replace("[Ÿ⁄€‹˘˙˚¸]", "u", $newfilename);
			   rename($dir2scan.'/'.$file, $dir2scan.'/'.$newfilename);
		   }
	   }
	   closedir($handle);
	}
}

//////////////////////////////////////////////////////////////////////////
//fonction pour crÈer une miniature de la 1Ëre image du sous dossier photo
//////////////////////////////////////////////////////////////////////////
function create_icon($dir2iconize) {
	$dir = PHOTOS_DIR."/".$dir2iconize; //chemin vers le rÈpertoire ‡ dont on doit crÈer l'icone
	if ($handle = opendir($dir)) {
		$cFile = 0;
		while (false !== ($file = readdir($handle))) {
			if($file != "." && $file != ".."){
				if(is_file($dir . "/" . $file)){
					$listFile[$cFile] = $file;
					$cFile++;
				}
			}
		}
	closedir($handle);
	}
	//$extract = scandir($dir);//scan des "array" du rÈpertoire
	$first_dir_item = $listFile[0]; // on extrait la valeur du premier fichier du rÈpertoire (aprËs"." et "..")
	list($width, $height, $type, $attr) = getimagesize($dir."/".$first_dir_item);//on liste les valeur de l'image
    $miniature = imagecreatetruecolor(ICO_WIDTH, ICO_HEIGHT);
	if ($type == 1) {
		$image = imagecreatefromgif($dir."/".$first_dir_item);
	}
	if ($type == 2) {
		$image = imagecreatefromjpeg($dir."/".$first_dir_item);
	}
	if ($type == 3) {
		$image = imagecreatefrompng($dir."/".$first_dir_item);
	}
	//imagecopyresampled(image de destination, image source, int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h);
	imagecopyresampled($miniature, $image, 0, 0,((($width - ICO_WIDTH)/2) <= ICO_WIDTH ? ICO_WIDTH-(($width - ICO_WIDTH)/2) : ($width - ICO_WIDTH)/2), ((($height - ICO_HEIGHT)/2) <= 0 ? ICO_HEIGHT-(($height - ICO_HEIGHT)/2) : ($height - ICO_HEIGHT)/2), ICO_WIDTH, ICO_HEIGHT, ICO_WIDTH*2, ICO_HEIGHT*2);
	imagejpeg($miniature, $dir."/".ICO_FILENAME, GLOBAL_JPG_QUALITY);
}

//////////////////////////////////////////////
//fonction pour crÈer le rÈpertoire miniatures
//////////////////////////////////////////////
function create_folder($dirwhere2folderize, $dir_name) {
	mkdir(PHOTOS_DIR."/".$dirwhere2folderize."/".$dir_name);
}

/////////////////////////////////////////////////////////////////////
//fonction pour crÈer toutes les miniatures du rÈpertoire en question
/////////////////////////////////////////////////////////////////////
function create_newimage($dirname, $file2miniaturize, $dimensionmax, $dir_where2save, $file_prefixe) {
	$dir = PHOTOS_DIR."/".$dirname; //chemin vers le rÈpertoire ‡ dont on doit crÈer l'icone
	$dir_where2save = ($dir_where2save ? "/".$dir_where2save : "");
	$file_prefixe = ($file_prefixe ? $file_prefixe : "");
	list($width, $height, $type, $attr) = getimagesize($dir."/".$file2miniaturize);//on liste les valeur de l'image
	if ($width >= $height) {
	$newwidth = $dimensionmax;
	$newheight = ($dimensionmax*$height)/$width;
	} else {
	$newwidth = ($dimensionmax*$width)/$height;
	$newheight = $dimensionmax;
	}
    $miniature = imagecreatetruecolor($newwidth, $newheight);
	if ($type == 1) {
		$image = imagecreatefromgif($dir."/".$file2miniaturize);
	}
	if ($type == 2) {
		$image = imagecreatefromjpeg($dir."/".$file2miniaturize);
	}
	if ($type == 3) {
		$image = imagecreatefrompng($dir."/".$file2miniaturize);
	}
	imagecopyresampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagejpeg($miniature, $dir.$dir_where2save."/".$file_prefixe.$file2miniaturize, GLOBAL_JPG_QUALITY); 
}

/////////////////////////////////////////
//fonction pour tronquer un nom trop long
/////////////////////////////////////////
function wordTruncate($str) {
  $str_to_count = html_entity_decode($str);
  echo strlen($str_to_count);
  if (strlen($str_to_count) <= PHOTONAME_MAXCHAR) {
   return $str;
  } else { 
  $str2 = substr($str_to_count, 0, PHOTONAME_MAXCHAR - 3)."...";
  return htmlentities($str2);
  }
}
?>
<html>
<head>
  <title>module MLdocs viewer 0.8.2</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="global_style.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE=Javascript>
<!--
function inCell(cell, newcolor) {
	if (!cell.contains(event.fromElement)) {
		cell.bgColor = newcolor;
	}
}

function outCell(cell, newcolor) {
	if (!cell.contains(event.toElement)) {
		cell.bgColor = newcolor;
	}
}
//-->
</SCRIPT>
</head>
<body>
<?php 
$show_heading = (isset($_GET['show_heading']) ? $_GET['show_heading'] : "");
ini_set('max_execution_time', 120); //2 mn max
//echo "path dest_relatif :". PHOTOS_DIR ."<br>".exit();
switch ($show_heading) {
///////////////////////////////////////////////////////////////
//listing des rÈpertoires photos sur la page d'index par dÈfaut
///////////////////////////////////////////////////////////////
default:
scan_invalid_char(PHOTOS_DIR); //scan des rÈpertoires qui contiennent des caractËres interdits
// listage des rÈpertoires et fichiers
if ($handle = opendir(PHOTOS_DIR)) {
   $cDir = 0;
   $cFile = 0;
   while (false !== ($file = readdir($handle))) {
		if($file != "." && $file != ".." &&  $file != THUMBS_DIR && $file != IMAGE_STDDIM && $file != IMAGE_400 &&  $file != IMAGE_800){
//echo "path dest_relatif :". $file ."<br>".exit();			
if(is_dir(PHOTOS_DIR . "/" . $file)){
				$listDir[$cDir] = $file;
				$cDir++;
			}
			else{
				$listFile[$cFile] = $file;
				$cFile++;
			} 
		}
   }
   if (ALPHABETIC_ORDER == true) {
		usort($listDir,"strnatcmp");
	}
   closedir($handle);
}
//
$total_icons = count($listDir);
$totalPages = ceil($total_icons/ICO_PER_PAGE);
$page_num = (isset($_GET['page_num']) && $_GET['page_num'] !== "" && $_GET['page_num'] <= $totalPages ? $_GET['page_num'] : "1");
//redirect_header(MLDOCS_BASE_URL."/index.php", 5, $message);
?>
<div class="fdgris"><span class="Style1">//////<a href="<?php echo redirect_header(MLDOCS_BASE_URL."/index.php", 5, $message); ?>" class="Style2">&laquo;</a> &nbsp;|&nbsp;  <?php echo HOME_NAME ?></span></div>
<div class="fdcolor1" align="center">
<span class="Style2"><?php if ($page_num > 1) { ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo ($page_num-1); ?>" class="Style2">&laquo;</a> &nbsp;|&nbsp; <?php } 
  
for ($l =1; $l < $totalPages; $l++) {
	if ($page_num != $l) {
		?> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a> &nbsp;|&nbsp; <?php 
	} else {
	?> <b><?php echo $l; ?></b> &nbsp;|&nbsp; <?php 
	}
}
if ($page_num != $l) {
	?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a><?php
} else {
	?><b><?php echo $l; ?></b><?php
}
if ($page_num < $totalPages) { ?> &nbsp;|&nbsp; <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo ($page_num+1) ?>" class="Style2">&raquo;</a><?php } ?>
</span></div>
<br>
<table border="0" align="center" cellpadding="8" cellspacing="0">
	<tr>
<?php 
$separateurs = array('_', '-', '.');
$k=0; 
   for ($i = (ICO_PER_PAGE*$page_num) - ICO_PER_PAGE; $i < ($total_icons > (ICO_PER_PAGE*($page_num)) ? ICO_PER_PAGE*$page_num : $total_icons); $i++) {
	if ($listDir[$i] != "." && $listDir[$i] != ".." && $listDir[$i] != THUMBS_DIR && $listDir[$i] != IMAGE_STDDIM && $listDir[$i] != IMAGE_400 && $listDir[$i] != IMAGE_800 && is_dir(PHOTOS_DIR . "/" . $listDir[$i]) == true) {
	//crÈation du rÈpertoire miniatures et images
	if (!file_exists(PHOTOS_DIR . "/" . $listDir[$i] . "/" . THUMBS_DIR)) { 
		create_folder($listDir[$i], THUMBS_DIR);
	}
	if (!file_exists(PHOTOS_DIR . "/" . $listDir[$i] . "/" . IMAGE_STDDIM)) { 
		create_folder($listDir[$i], IMAGE_STDDIM);
	}
	if (!file_exists(PHOTOS_DIR . "/" . $listDir[$i] . "/" . IMAGE_800)) { 
		create_folder($listDir[$i], IMAGE_800);
	}
	if (!file_exists(PHOTOS_DIR . "/" . $listDir[$i]  . "/" . IMAGE_400)) { 
		create_folder($listDir[$i], IMAGE_400);
	}
		//crÈation de la miniature
		if (!file_exists(PHOTOS_DIR . "/" . $listDir[$i] . "/" . ICO_FILENAME)) { //si la miniature existe
			create_icon($listDir[$i]);
		}
		list($width, $height, $type, $attr) = getimagesize(PHOTOS_DIR . "/" . $listDir[$i]  . "/" . ICO_FILENAME);//on liste les valeurs de la miniature
		if ($width != ICO_WIDTH || $height != ICO_HEIGHT) { //on affiche
			create_icon($listDir[$i]);
		}
		?>
        <?php (is_int($k/ICO_PER_LINE) ? print "<tr>": print "");  ?>  
	<td>
		<table border="0" cellpadding="1" cellspacing="1" bgcolor="#666666">
		  <tr class="tddeco">
		    <td width="<?php echo ICO_WIDTH + 18; ?>" height="<?php echo ICO_HEIGHT + 18; ?>" align="center" valign="middle" class="tdover" onmouseover="this.style.borderColor='#666666'" onmouseout="this.style.borderColor='#FFFFFF'">
				<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $listDir[$i]; ?>"><img src="<?php echo PHOTOS_DIR . "/" . rawurlencode($listDir[$i]) . "/" . ICO_FILENAME ?>" alt="<?php echo str_replace($separateurs, ' ', $listDir[$i]); ?>" width="<?php echo ICO_WIDTH ?>" height="<?php echo ICO_HEIGHT ?>" border="0" class="imageborder"></a></td>
		  </tr>
		  <tr>
		    <td align="center"><span class="Style2"><?php 
			$titre_album = str_replace($separateurs, ' ', $listDir[$i]);
			$nbmots = explode(" ", $titre_album);
			$maxword2show = ((count($nbmots) < 6) ? count($nbmots) : 6);
			$wordnb = 0;
			while ($wordnb <$maxword2show) {
			echo  $nbmots[$wordnb] . " "; 
			$wordnb++;
			}
			echo ((count($nbmots) > 6) ? " ..." : "");
 			?></span></td>
		  </tr>
	  </table>
	  </td>
<?php
		//
	}
	$k++;
   }
?>
</table><br>
<div class="fdcolor1" align="center">
  <span class="Style2"><?php if ($page_num > 1) { ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo ($page_num-1); ?>" class="Style2">&laquo;</a> &nbsp;|&nbsp; <?php } 
  
  for ($l =1; $l < ceil($total_icons/ICO_PER_PAGE); $l++) {
	  if ($page_num != $l) {
	   ?> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a> &nbsp;|&nbsp; <?php 
	  } else {
	   ?> <b><?php echo $l; ?></b> &nbsp;|&nbsp; <?php 
	  }
  }
  if ($page_num != $l) {
  ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a><?php
  } else {
  ?><b><?php echo $l; ?></b><?php
  }
   if ($page_num < ( ceil(($total_icons)/ICO_PER_PAGE)) ) { ?> &nbsp;|&nbsp; <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo ($page_num+1) ?>" class="Style2">&raquo;</a><?php } ?>
  </span></div>
<?php 
break;

//////////////////////////////////////////////////////////
//listing des miniatures dans un rÈpertoire photo spÈcifiÈ
//////////////////////////////////////////////////////////
case ('list'):
$photodir = (isset($_GET['dir']) ? $_GET['dir'] : "");
	if (!isset($_GET['dir']) || $_GET['dir'] == "") {//on vÈrifie que le rÈpertoire photo existe bien ?>
		<table border="0" align="center" cellpadding="28" cellspacing="0">
		  <tr>
		    <td align="center"><span class="txtrouge">Vous devez spÈcifier un rÈpertoire photo !</span>
		      <p>
			<form method="post"><INPUT TYPE="button" VALUE="Retour" onClick="history.go(-1)"></form>
			</td>
		</tr>
	</table>
	<?php	
	break;
	}
//on supprime les slash, antislash et points possibles pour Èviter les failles de sÈcuritÈ
$photodir = preg_replace("/\\\\/", "", $photodir);
$str2clean = array("." => "", "/" => "");
$photodir = strtr($photodir, $str2clean);
$page_num = (isset($_GET['page_num']) ? $_GET['page_num'] : "1");//vÈrification que le numÈro de page existe bien
$dir = PHOTOS_DIR . "/" . $photodir; //chemin vers le rÈpertoire qui contient les miniatures
	//echo $dir;exit();
  if (!file_exists($dir)) {//on vÈrifie que le rÈpertoire photo existe bien ?>
		<table border="0" align="center" cellpadding="28" cellspacing="0">
		  <tr>
		    <td align="center"><span class="txtrouge">Ce r&eacute;pertoire photo n'existe pas !</span>
		      <p>
			<form method="post"><INPUT TYPE="button" VALUE="Retour" onClick="history.go(-1)"></form>
			</td>
		</tr>
	</table>
	<?php	
	break;
	}
	//crÈation du rÈpertoire miniatures et images
	if (!file_exists($dir . "/" . THUMBS_DIR)) { 
		create_folder($photodir, THUMBS_DIR);
	}
	if (!file_exists($dir . "/" . IMAGE_STDDIM)) { 
		create_folder($photodir, IMAGE_STDDIM);
	}
	if (!file_exists($dir . "/" . IMAGE_800)) { 
		create_folder($photodir, IMAGE_800);
	}
	if (!file_exists($dir . "/" . IMAGE_400)) { 
		create_folder($photodir, IMAGE_400);
	}
// listage des rÈpertoires et fichiers
if ($handle = opendir($dir)) {
   $cDir = 0;
   $cFile = 0;
   while (false !== ($file = readdir($handle))) {
	if($file != "." && $file != ".."){
		if(is_dir($dir . "/" . $file)){
			$listDir[$cDir] = $file;
			$cDir++;
		}
		else{
			$listFile[$cFile] = $file;
			$cFile++;
		}
	}
   }
   closedir($handle);
}
if (ALPHABETIC_ORDER == true) {
	usort($listFile,"strnatcmp");
}

//selon l'ordonnancement, on dÈtermine la bonne pagination de retour ‡ l'index principal.
if (ALPHABETIC_ORDER == true) {
	if ($handle = opendir(PHOTOS_DIR)) {
		$cDir = 0;
		while (false !== ($subdir = readdir($handle))) {
			//echo "PHOTOS_DIR" . $handle ;				
			//echo "  subdir" . $subdir;
			if($subdir != "." && $subdir != ".." && $subdir != THUMBS_DIR && $subdir != IMAGE_STDDIM && $subdir != IMAGE_400 && $subdir != IMAGE_800){
				if(is_dir(PHOTOS_DIR . "/" . $subdir)){
					$listDir[$cDir] = $subdir;
					$cDir++;
				}
			}
   		}
   closedir($handle);
	} 
usort($listDir,"strnatcmp");
$photoDirNba = 1;
	for ($b=0; $b <	count($listDir); $b++) {
		$ordertest[$photoDirNba] = $listDir[$b];
				if($ordertest[$photoDirNba] == $photodir){
				$dir_index = $photoDirNba;
				} else {
				$photoDirNba++;
				}
	}
} else {
// rÈcupÈration du numÈro du dossier photo
	if ($handle = opendir(PHOTOS_DIR)) {
	   $photoDirNbb = 1;
	   while (false !== ($photoDirectory = readdir($handle))) {
		if($photoDirectory != "." && $photoDirectory != ".." && $photoDirectory != THUMBS_DIR && $photoDirectory != IMAGE_STDDIM && $photoDirectory != IMAGE_400 && $photoDirectory != IMAGE_800){
			if(is_dir(PHOTOS_DIR . "/" . $photoDirectory)){
				if($photoDirectory == $photodir){
				$dir_index = $photoDirNbb;
				} else {
				$photoDirNbb++;
				}
			}
		}
   }
   closedir($handle);
}
}
$page_index = ceil($dir_index/ICO_PER_PAGE);
//
//on liste les miniatures
if ($handle = opendir($dir."/".THUMBS_DIR)) {
   $thumb = 0;
   while (false !== ($file = readdir($handle))) {
	if($file != "." && $file != ".."){
		if(is_file($dir."/".THUMBS_DIR . "/" . $file)){
			$extractthumbs[$thumb] = $file;
			$thumb++;
		}
	}
   }
   closedir($handle);
}
$valid = 0;
for ($i=0; $i <	count($listFile); $i++) {
	if ($listFile[$i] !== ICO_FILENAME) {
		$listvalidimg[$valid] = $listFile[$i];
		$valid++;
	}
}

$total_files = count($listvalidimg);// on compte le nombre d'ÈlÈments dans le dossier sans compter "." et ".."
$separateurs = array('_', '-', '.');
?>
<div class="fdgris"><span class="Style1">////// <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default&page_num=<?php echo $page_index; ?>" class="Style1"><?php echo HOME_NAME; ?></a> &raquo; <?php echo str_replace($separateurs, ' ', $photodir); ?>  / photos <?php echo (($page_num-1)*MINIATURES_PER_PAGE)+1; ?> ‡ <?php if ($page_num < ( ceil(($total_files)/MINIATURES_PER_PAGE)) ) { echo (($page_num)*MINIATURES_PER_PAGE); } else { echo $total_files; } ?>  sur <?php echo $total_files; ?> </span></div>
<div class="fdcolor1" align="center">
  <span class="Style2"><?php if ($page_num > 1) { ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo ($page_num-1) ?>" class="Style2">&laquo;</a> &nbsp;|&nbsp; <?php } 
  $l =1;
  while ($l < (ceil(($total_files)/MINIATURES_PER_PAGE)) ) {
  if ($page_num != $l) {
   ?> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a> &nbsp;|&nbsp; <?php 
  } else {
   ?> <b><?php echo $l; ?></b> &nbsp;|&nbsp; <?php 
  }
   $l++;
  }
  if ($page_num != $l) {
  ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a><?php
  } else {
  ?><b><?php echo $l; ?></b><?php
  }
   if ($page_num < ( ceil(($total_files)/MINIATURES_PER_PAGE)) ) { ?> &nbsp;|&nbsp; <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo ($page_num+1) ?>" class="Style2">&raquo;</a><?php } ?>
  </span></div>
<br>
<table border="0" align="center" cellpadding="8" cellspacing="0">
	<tr>
<?php 
//si les rÈfÈrences correspondent :
$total_thumbFloor = MINIATURES_PER_PAGE*$page_num;
$k=0; 
for ($i = $total_thumbFloor - MINIATURES_PER_PAGE; $i < ( ($total_files > $total_thumbFloor) ? $total_thumbFloor : $total_files); $i++) {//oncompte le nb d'ÈlÈments ‡ afficher selon le numÈro de page
		$fileexist = "";
		$j = 0;
			while ($j < ($total_files)) {
				if ("__".$listvalidimg[$i] == (isset($extractthumbs[$j]) ? $extractthumbs[$j] : "")) {
					$fileexist = $extractthumbs[$j];
				}
			$j++;
		   }
		$pos = strrpos($listvalidimg[$i], '.'); //calcule la position du point dans la chaine $document, ex. : 8
		$ext = strtolower(substr($listvalidimg[$i], $pos + 1));
			if (($ext == "jpeg" || $ext == "jpg" || $ext == "gif" || $ext == "png") && $listvalidimg[$i] !== ICO_FILENAME && ("__".$listvalidimg[$i] !== $fileexist)) { //si $document contient les extensions d'image et qu'il n'est pas icone/image du rÈpertoire
			   create_newimage($photodir, $listvalidimg[$i], MINIATURE_MAXDIM, THUMBS_DIR, "__");
		   }
		?>
        <?php (is_int($k/MINIATURES_PER_LINE) ? print "<tr>": print "");  ?>  
	<td>
		<table border="0" cellpadding="1" cellspacing="1" bgcolor="#666666">
		  <tr class="tddeco">
		    <td width="<?php echo MINIATURE_MAXDIM + 18; ?>" height="<?php echo MINIATURE_MAXDIM + 18; ?>" align="center" valign="middle" class="tdover" onmouseover="this.style.borderColor='#666666'" onmouseout="this.style.borderColor='#FFFFFF'"><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=detail&dir=<?php echo rawurlencode($photodir); ?>&photo=<?php echo $i+1; ?>"><img src="<?php echo MLDOCS_PHOTOS_URL ."/" . rawurlencode($photodir) . "/" . THUMBS_DIR . "/__".$listvalidimg[$i] ?>" border="0" alt="<?php echo $listvalidimg[$i]; ?>" class="imageborder"></a></td>
		  </tr>
		  <tr>
		    <td align="center"><span class="Style2"><?php echo $i+1 ."| " . wordTruncate($listvalidimg[$i]); ?></span></td>
		  </tr>
	  </table>
	  </td>
		<?php
		$k++;
}
?>
</table><br>
<div class="fdcolor1" align="center">
  <span class="Style2"><?php if ($page_num > 1) { ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo ($page_num-1) ?>" class="Style2">&laquo;</a> &nbsp;|&nbsp; <?php } 
  $l =1;
  while ($l < (ceil(($total_files)/MINIATURES_PER_PAGE)) ) {
  if ($page_num != $l) {
   ?> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a> &nbsp;|&nbsp; <?php 
  } else {
   ?> <b><?php echo $l; ?></b> &nbsp;|&nbsp; <?php 
  }
   $l++;
  }
  if ($page_num != $l) {
  ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo $l; ?>" class="Style2"><?php echo $l; ?></a><?php
  } else {
  ?><b><?php echo $l; ?></b><?php
  }
   if ($page_num < ( ceil(($total_files)/MINIATURES_PER_PAGE)) ) { ?> &nbsp;|&nbsp; <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir; ?>&page_num=<?php echo ($page_num+1) ?>" class="Style2">&raquo;</a><?php } ?>
  </span></div>
<?php 
 break;

////////////////////
//dÈtail de la photo
////////////////////
case ('detail'):
$photodir = (isset($_GET['dir']) ? $_GET['dir'] : "");
	if (!isset($_GET['dir']) || $_GET['dir'] == "") {//on vÈrifie que le rÈpertoire photo existe bien ?>
		<table border="0" align="center" cellpadding="28" cellspacing="0">
		  <tr>
		    <td align="center"><span class="txtrouge">Vous devez spÈcifier un rÈpertoire photo !</span>
		      <p>
			<form method="post"><INPUT TYPE="button" VALUE="Retour" onClick="history.go(-1)"></form>
			</td>
		</tr>
	</table>
	<?php	
	break;
	}
//on supprime les slash, antislash et points possibles pour Èviter les failles de sÈcuritÈ
$photodir = preg_replace("/\\\\/", "", $photodir);
$str2clean = array("." => "", "/" => "");
$photodir = strtr($photodir, $str2clean);
$dir = PHOTOS_DIR . "/" . $photodir; //chemin vers le rÈpertoire qui contient les miniatures
	if (!file_exists($dir)) {//on vÈrifie que le rÈpertoire photo existe bien ?>
		<table border="0" align="center" cellpadding="28" cellspacing="0">
		  <tr>
		    <td align="center"><span class="txtrouge">Ce r&eacute;pertoire photo n'existe pas !</span>
		      <p>
			<form method="post"><INPUT TYPE="button" VALUE="Retour" onClick="history.go(-1)"></form>
			</td>
		</tr>
	</table>
	<?php	
	break;
	}
$photo = (isset($_GET['photo']) ? $_GET['photo'] : "");
$dim = (isset($_GET['dim']) ? $_GET['dim'] : IMAGE_STDDIM);
$dir = PHOTOS_DIR . "/" . $photodir;
if ($handle = opendir($dir)) {
   $cFile = 1;
   while (false !== ($file = readdir($handle))) {
	if($file != "." && $file != ".."){
		if(is_file($dir . "/" . $file) && $file != ICO_FILENAME){
			$listFile[$cFile] = $file;
			$cFile++;
		}
	}
   }
   closedir($handle);
}
//  Je retrie par ordre alphabÈtique mais le tableau triÈ $listFile2 commence ‡ l'index 0.
// Je dÈcale l'index pour que le tableau $listFile commence ‡ 1, comme la variable $photo.
if (ALPHABETIC_ORDER == true)
{
	$listFile2 = $listFile;
	usort($listFile2,"strnatcmp");
	for ($i=0;$i < count($listFile2); $i++) {
		$listFile[$i+1] = $listFile2[$i];
	}
}
//
	if (!isset($_GET['photo']) || $_GET['photo'] == "" || !isset($listFile[$photo])) {//on vÈrifie que la photo existe bien ?>
		<table border="0" align="center" cellpadding="28" cellspacing="0">
		  <tr>
		    <td align="center"><span class="txtrouge">Il n'y a aucune photo ‡ afficher !</span>
		      <p>
			<form method="post"><INPUT TYPE="button" VALUE="Retour" onClick="history.go(-1)"></form>
			</td>
		</tr>
	</table>
	<?php	
	break;
	}
	//
if (!file_exists($dir . "/" . $dim . "/" . $listFile[$photo])) {
	create_newimage($photodir, $listFile[$photo], $dim, $dim, "");
} 
$total_images = count($listFile);// on compte le nombre d'ÈlÈments dans le dossier sans compter "." et ".."
list($width, $height, $type, $attr) = getimagesize($dir . "/" . $dim . "/" . $listFile[$photo]);
//on crÈÈ les miniatures si elles sont absentes
if ($photo > 1 && !file_exists(PHOTOS_DIR . "/" . $photodir . "/" . THUMBS_DIR . "/__" . $listFile[$photo-1])) {
	create_newimage($photodir, $listFile[$photo-1], MINIATURE_MAXDIM, THUMBS_DIR, "__");
}
if ($photo < $total_images && !file_exists(PHOTOS_DIR . "/" . $photodir . "/" . THUMBS_DIR . "/__" . $listFile[$photo+1])) {
	create_newimage($photodir, $listFile[$photo+1], MINIATURE_MAXDIM, THUMBS_DIR, "__");
}
$separateurs = array('_', '-', '.');
?>
<div class="fdgris"><span class="Style1">//////<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=default" class="Style1"><?php echo HOME_NAME ?></a> &raquo; <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=list&dir=<?php echo $photodir ?>&page_num=<?php echo ceil($photo/MINIATURES_PER_PAGE); ?>" class="Style1"><?php echo str_replace($separateurs, ' ', $photodir); ?></a> &raquo; photo : <?php echo $listFile[$photo]; ?> / n&deg;<?php echo $photo; ?> sur <?php echo $total_images; ?></span></div>
<br>
<table border="0" align="center" cellpadding="8" cellspacing="0">
  <tr>
    <td width="<?php echo MINIATURE_MAXDIM + 26; ?>" height="<?php echo MINIATURE_MAXDIM + 26; ?>">
	<?php if ($photo > 1) {?>
		<table border="0" cellpadding="1" cellspacing="1" bgcolor="#666666">
			<tr class="tddeco">
		  		<td width="<?php echo MINIATURE_MAXDIM + 18; ?>" height="<?php echo MINIATURE_MAXDIM + 18; ?>" align="center" valign="middle" class="tdover" onmouseover="this.style.borderColor='#666666'" onmouseout="this.style.borderColor='#FFFFFF'">
				<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=detail&dir=<?php echo $photodir; ?>&photo=<?php echo $photo-1; echo ($dim == IMAGE_STDDIM ? "" : "&dim=". $dim);?>"><img src="<?php echo MLDOCS_PHOTOS_URL . "/" . rawurlencode($photodir) . "/" . THUMBS_DIR . "/__" . $listFile[$photo-1]; ?>" alt="<?php echo $listFile[$photo-1]; ?>" border="0" class="imageborder"></a>
				</td>
			</tr>
	  	</table>
	<?php }?>
	</td><td>
		<table border="0" cellpadding="1" cellspacing="1" bgcolor="#666666">
		  <tr class="tddeco">
		    <td width="<?php echo $dim + 18; ?>" height="<?php echo $dim + 18; ?>" align="center" valign="middle" class="tdover" onmouseover="this.style.borderColor='#666666'" onmouseout="this.style.borderColor='#FFFFFF'">
			<?php if ($photo != "") { 
			if ($photo < $total_images) { ?><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=detail&dir=<?php echo $photodir; ?>&photo=<?php echo $photo+1; echo ($dim == IMAGE_STDDIM ? "" : "&dim=". $dim);?>"><?php } ?>
				<img src="<?php echo MLDOCS_PHOTOS_URL . "/" . rawurlencode($photodir) . "/" . $dim . "/" . $listFile[$photo]; ?>" alt="<?php echo $listFile[$photo]; ?>" <?php echo $attr; ?> border="0" class="imageborder">
			<?php if ($photo < $total_images) { ?></a><?php } 
			} else { echo "<span class=\"txtrouge\">Il n'y a aucune photo ‡ afficher</span>"; } ?>
			</td>
		  </tr>
		  <tr>
		    <td align="center"><span class="Style2"> 
			<?php if ($dim !== IMAGE_400) { ?>
			<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=detail&dir=<?php echo $photodir; ?>&photo=<?php echo $photo; ?>&dim=<?php echo IMAGE_400; ?>" class="Style2">400x300</a>
			<?php } else {  echo "<b>400x300</b>"; } ?>
			|| 
			<?php if ($dim !== IMAGE_STDDIM) { ?>
			<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=detail&dir=<?php echo $photodir; ?>&photo=<?php echo $photo; ?>&dim=<?php echo IMAGE_STDDIM; ?>" class="Style2">640x480</a>
			<?php } else {  echo "<b>640x480</b>"; } ?>
			|| 
			<?php if ($dim !== IMAGE_800) { ?>
			<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=detail&dir=<?php echo $photodir; ?>&photo=<?php echo $photo; ?>&dim=<?php echo IMAGE_800; ?>" class="Style2">800x600</a>
			<?php } else {  echo "<b>800x600</b>"; } ?>
			<?php
		if (exif_imagetype($dir.'/'.$listFile[$photo]) != IMAGETYPE_PNG && exif_imagetype($dir.'/'.$listFile[$photo]) != IMAGETYPE_GIF) {
				 ?><hr size="1" noshade><?php
	 			$exif = read_exif_data($dir.'/'.$listFile[$photo], 0, true);
				echo $exif["FILE"]["FileName"] . " || " . round(($exif["FILE"]["FileSize"]/1024), 0) . " Ko || RÈsolution originale : ".$exif["COMPUTED"]["Width"]." x ".$exif["COMPUTED"]["Height"]."<br>\n";
		   if (isset($exif["EXIF"]["DateTimeOriginal"]))  echo "Date et Heure : ".$exif["EXIF"]["DateTimeOriginal"]."<br>";
		   if (isset($exif["EXIF"]["ExposureTime"])) echo "Temps d'exposition : ".$exif["EXIF"]["ExposureTime"]." || ";
		   if (isset($exif["EXIF"]["ISOSpeedRatings"])) echo "ISO : ".$exif["EXIF"]["ISOSpeedRatings"]."<br>";
		   if (isset($exif["COMPUTED"]["ApertureFNumber"])) echo "Ouverture de la focale : ".$exif["COMPUTED"]["ApertureFNumber"]." || ";
		   if (isset($exif["EXIF"]["FocalLength"])) echo "Longueur de la focale : ".$exif["EXIF"]["FocalLength"]."\n";
		}
			 ?>
			</span>
			</td>
		  </tr>
	  </table>
	</td>
    <td width="<?php echo MINIATURE_MAXDIM + 26; ?>" height="<?php echo MINIATURE_MAXDIM + 26; ?>">
	<?php if ($photo < $total_images) {?>
		<table border="0" cellpadding="1" cellspacing="1" bgcolor="#666666">
			<tr class="tddeco">
		  		<td width="<?php echo MINIATURE_MAXDIM + 18; ?>" height="<?php echo MINIATURE_MAXDIM + 18; ?>" align="center" valign="middle" class="tdover" onmouseover="this.style.borderColor='#666666'" onmouseout="this.style.borderColor='#FFFFFF'">

				<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?show_heading=detail&dir=<?php echo $photodir; ?>&photo=<?php echo $photo+1; echo ($dim == IMAGE_STDDIM ? "" : "&dim=". $dim);?>"><img src="<?php echo MLDOCS_PHOTOS_URL . "/" . rawurlencode($photodir) . "/" . THUMBS_DIR . "/__" . $listFile[$photo+1]; ?>" alt="<?php echo $listFile[$photo+1]; ?>" border="0" class="imageborder"></a>
				</td>
			</tr>
	  	</table>
	<?php }?>
	</td>
  </tr>
</table>

<?php
break;
//fin du switch
}
?>
<div class="fdgris" align="right">
  <span class="Style2">MLdocs Module viewer 0.9.0 | auteur : <a href="http://www.byoos.fr" target="_blank" class="Style2" title="Graphiste - Concepteur multimedia">BYOOS solutions</a> | distribution sur : <a href="http://www.byoos.fr" target="_blank" class="Style2" title="Solutions de gestion documentaire">BYOOS.FR</a></span>
</div>
<noscript>

</noscript>
</body>
</html>
