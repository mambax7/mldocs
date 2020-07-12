<?php
#  +------------------ explorer ---------------------------+
#  |   SCRIPT Entierement Ecrit par Jean Charles MAMMANA   |
#  |   Url : http://jcjcjcjc.free.fr                       |
#  |   Contact : jc_mammana@hotmail.com                    |
#  |                                                       |
#  |   Tous les scripts utilisé dans ce projet             |
#  |   sont sont en libre utilisation.                     |
#  |   Tous droits de modifications sont autorisé          |
#  |   à condition de m'en informer comme précisé          |
#  |   dans les termes du contrat de la licence GPL        |
#  |                                                       |
#  +-------------------------------------------------------+
// modification par BYOOS solutions  le 29 mai 2006 Gabriel
//@session_start();
$_SESSION['test_sessions'] = 'ok';
if (!isset($_SESSION['Arrivee']))
{  # Le visiteur arrive directement par ici, on sauvegarde son referer si il existe
   if (isset($_SERVER['HTTP_REFERER']))
      $_SESSION['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
      else
        $_SESSION['HTTP_REFERER'] = 'null';
   $nom_fichier_full = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/')+1);
   $nom_fichier = substr($nom_fichier_full, 0, strlen($nom_fichier_full)-4);
   $_SESSION['Arrivee'] = $nom_fichier;
}

// modifier cette ligne selon le nom du dossier systeme
require('../../mainfile.php');
require_once('header.php');
if (!defined('MLDOCS_CONSTANTS_INCLUDED')) 
{
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
}

include_once(MLDOCS_BASE_PATH.'/functions.php');
$hFiles   =& mldocsGetHandler('file');
// récupération des identifiants de l utilisateur
if(!$xoopsUser) 
{
    header("Location: ".MLDOCS_BASE_URL."/error.php"); 
    //redirect_header(XOOPS_URL .'/user.php?xoops_redirect='.htmlencode($xoopsRequestUri), 3);
}
//echo "base URL" . MLDOCS_BASE_URL;
include_once('./__dirsys/config.inc.php');

$query = '';
$path = $CONFIG['DOCUMENT_ROOT'];
if(!empty($_GET)){
        $query = "?".http_build_query($_GET,'');
        if(($pathT = makePath($_GET)) === false) die($LANGUE['ERR_Violation']);
        $path = resolvePath($CONFIG['DOCUMENT_ROOT'].$pathT['path']);
}

$showtn = SelectAffichType('',$path,$CONFIG);

if($showtn) $fileToOpen = 'showtn.php'.$query;
else $fileToOpen = 'list.php'.$query;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title><?php echo $CONFIG['MAIN_TITLE'] ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="1 month">
<meta name="author" content="gabybob">
<meta name="reply-to" content="contact@byoos.fr">
<meta name="owner" content="contact@byoos.fr">
<meta name="copyright" content="byoos">
<meta name="nom" content="gabybob">
<meta name="description" content="Explorateur de fichier web">
<meta name="keywords" content="explorateur, web, fichiers, explorer, icones, photos, images, photo, image, classement, classer, dossier, repertoir, systeme, GPL, licence, libre, EXIF, slideshow, BYOOS solutions, gabriel bobard">
<!-- document root : <?php echo $CONFIG['DOCUMENT_ROOT']; ?> //-->
</head>

<frameset cols="<?php echo $CONFIG['WIDTH_TREE_FRAME'] ?>,*" frameborder="<?php echo $CONFIG['FRAME_BORDER'] ?>" border="<?php echo $CONFIG['WIDTH_FRAME_BORDER'] ?>" framespacing="<?php echo $CONFIG['WIDTH_FRAME_SPACING'] ?>">
  <frame src="<?php echo $CONFIG['DIRSYS']; ?>/arbre.php<?php echo $query ?>" name="tree" scrolling="<?php echo $CONFIG['SCROLING_TREE_FRAME'] ?>" <?php echo $CONFIG['RESIZE_FRAME'] ?> >
  <frame src="<?php echo $CONFIG['DIRSYS']; ?>/<?php echo $fileToOpen; ?>" name="main">
</frameset>
<noframes><body>

</body></noframes>
</html>
<?include_once "../../footer.php";?>
