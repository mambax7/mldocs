<?php
// --------------------------------------------------------------
// viewFile.php  par BYOOS solutions  le 6 mai 2006 Gabriel
// modification le 05 juillet 2006  Gabriel
require('../../mainfile.php');
require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/viewer.php');

if (!defined('MLDOCS_CONSTANTS_INCLUDED')) 
{
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
}

include_once(MLDOCS_BASE_PATH.'/functions.php');



// récupération des identifiants de l utilisateur
if(!$xoopsUser) 
{
    redirect_header(XOOPS_URL .'/user.php', 3);
}



// recupération des informations sur le fichier
$hFiles   =& mldocsGetHandler('file');
$hArchive  =& mldocsGetHandler('archive');
$hStaff   =& mldocsGetHandler('staff');

$uid = $xoopsUser->getVar('uid');
$username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur

if(isset($_GET['id']))
{
    $mldocs_id = intval($_GET['id']);


    $file     =& $hFiles->get($mldocs_id);
    $mimeType = $file->getVar('mimetype');
    $archive   =& $hArchive->get($file->getVar('archiveid'));
    $repstr = mldocsMakeRepstr($archive->getVar('repid'));
    $filename_full = $file->getVar('filename');
    
    // -- sécurité --
    // de base personne ne vois les fichiers
    
    $viewFile = false;
    
    // seuls les membres, les admins ou ceux qui ont postés ces archives ont les droits de consultations
    if ($archive->getVar('uid') == $xoopsUser->getVar('uid')) {
        $viewFile = true;
    } elseif ($hStaff->isStaff($xoopsUser->getVar('uid'))) {
        $viewFile = true;
    } elseif ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
        $viewFile = true;
    }
    
    // sinon message d'erreur
    if (!$viewFile) 
    {
        redirect_header(MLDOCS_BASE_URL.'/index.php', 3, _NO_PERM);
    }

    
    // verification du nom du fichier par rapport aux info présentes dans la BD ( à vérifier )
    if($file->getVar('responseid') > 0)
    {
        $removeText = $file->getVar('archiveid').$repstr."_".$file->getVar('responseid')."_";
    } else {
        $removeText = $file->getVar('archiveid').$repstr."_";
    }
    $filename = str_replace($removeText, ' ', $filename_full);
    
    // renvoie le chemin absolu du fichier
    $fileAbsPath = MLDOCS_ARCHIVE_PATH.'/'.$repstr.'/' . $filename_full;
    
    // action à effectuer en fonction du type mime du fichier sélectionné
    if(isset($mimeType))
    {
      //echo $mimeType . "<br>";

      switch ($mimeType)
      {
      
      	case 'text/plain':
    	// Open the file
        $fp = fopen($fileAbsPath, "r");
        // Write file to browser
        fpassthru($fp);
        break;
    	case 'image/gif':
    	case 'image/jpeg':
    	case 'image/png':
      $pathdest = MLDOCS_CACHE_IMG_PATH;
      $pathsrc = MLDOCS_ARCHIVE_PATH . '/' . $repstr ;
      $chmod = 0775;
     	if(!is_dir($pathdest))
      {
      	mkdir($pathdest);
      	@chmod($pathdest, $chmod);
     	}
     	$delResponse = deletexFile($pathdest); // vide le dossier temporaire

      $filename = $file->getVar('filename');
      $nom_vue = substr($filename, 0 , strlen($filename) - 4);
      $fileAbsPath = $pathsrc . '/' . $filename;
 
 /*
        echo "path source full :".$fileAbsPath."<br>";
      	echo "username :".$username."<br>";
      	echo "nom image :".$nom_vue."<br>";
      	echo "path dest :".$pathdest."<br>";
*/
      // création de la vue au format PNG pour le temps de l'affichage
      $ret = createPicsPng ($nom_vue, $fileAbsPath, $pathdest) ;
         if (!copy($fileAbsPath, $pathdest. '/' . $filename))
            {
             // message d'erreur
          	$message  = 'Le fichier : '.$filename.' ne peut être copié';
          	redirect_header(MLDOCS_BASE_URL."/index.php", 5, $message);
            } 

      //$urlExplore = "/explore.php?0=bannette&1=" . $username ."&2=tmp_img";
      $urlExplore = "/viewer.php?show_heading=list&dir=cache";
      header("Location: ".MLDOCS_BASE_URL . $urlExplore);     	
    	
    	
    	
    	break;
    	
     	case 'image/tif':
    
      $pathdest = MLDOCS_CACHE_IMG_PATH ;
      $pathsrc = MLDOCS_ARCHIVE_PATH . '/' . $repstr ;
      
     	if(!is_dir($pathdest))
      {
      	mkdir($pathdest);
     	}
     	$delResponse = deletexFile($pathdest); // vide le dossier temporaire

      $filename = $file->getVar('filename');
      $nom_vue = substr($filename, 0 , strlen($filename) - 4);
      $fileAbsPath = $pathsrc . '/' . $filename;
 
 /*      
            echo "path src : " . $pathsrc ."<br>"; // BOBdebug
            echo "path source full :".$fileAbsPath."<br>";
      	echo "username :".$username."<br>";
      	echo "nom image :".$nom_vue."<br>";
      	echo "path dest :".$pathdest."<br>";
*/

      // création de la vue au format PNG pour le temps de l'affichage
      $ret = createPicsPng ($nom_vue, $fileAbsPath, $pathdest) ;

      //$urlExplore = "/explore.php?0=bannette&1=" . $username ."&2=tmp_img";
      $urlExplore = "/viewer.php?show_heading=list&dir=cache";
      header("Location: ".MLDOCS_BASE_URL . $urlExplore);

        break;
/*        
        case 'application/pdf':
        header("Content-Disposition:  filename=" . $fileAbsPath);
        break;
*/     
        default:
    	// download le fichier 
    	downloadFile ($fileAbsPath);
    	break;  
    	  
      }
      
    } 
    else 
    {
    	// message d'erreur
    	$message  = 'Le type de fichier :'.$mimeType.'ne peut être ouvert';
    	redirect_header(MLDOCS_BASE_URL."/index.php", 5, $message);
    	
    }
} else { // traite le lot d images au format TIFF et convertir en PNG
      if(isset($_GET['archiveid']))
      {
      $archive_id = intval($_GET['archiveid']);
      //echo "archive_id = " . $archive_id . "<br>";
      $archive   =& $hArchive-> get($archive_id);
      $repstr = mldocsMakeRepstr($archive->getVar('repid'));
      //echo "rep : " . $repstr . "<br>";
      $files = $archive->getFiles();
      $pathsrc = MLDOCS_ARCHIVE_PATH . '/' . $repstr ;
      $pathdest = MLDOCS_CACHE_IMG_PATH ;
      
     	if(!is_dir($pathdest))
      {
      	mkdir($pathdest);
     	}
     	$delResponse = deletexFile($pathdest); // vide le dossier temporaire

      foreach($files as $key=>$file){
        $filename = $file->getVar('filename');
        $mimeType = $file->getVar('mimetype');
        $nom_vue = substr($filename, 0 , strlen($filename) - 4);
        $fileAbsPath = $pathsrc . '/' . $filename;
/*
		echo "path src : " . $pathsrc ."<br>"; // BOBdebug
        	echo "path source full :".$fileAbsPath."<br>";
      	echo "username :".$username."<br>";
      	echo "nom image :".$nom_vue."<br>";
      	echo "path dest :".$pathdest."<br>";
*/
        // action à effectuer en fonction du type mime du fichier sélectionné
        if(isset($mimeType))
        {
              
        
              switch ($mimeType)
              {
              
              case 'text/plain':

                    //non traité pour le moment
                  break;

              case 'image/gif' :
              case 'image/jpeg':
              case 'image/png' :
                 if (!copy($fileAbsPath, $pathdest. '/' . $filename))
                 {
                     // message d'erreur
                  	$message  = 'Le fichier : '.$filename.' ne peut être copié';
                  	redirect_header(MLDOCS_BASE_URL."/index.php", 5, $message);
                 } 
    
              	break;
              	
              case 'image/tif':
                // création de la vue au format PNG pour le temps de l'affichage
                $ret = createPicsPng ($nom_vue, $fileAbsPath, $pathdest);

              	break;

		  default:
                // cas non traité pour le moment
              	// download le fichier 
              	//downloadFile ($fileAbsPath);
            	break; 
              } 
        }
      //$urlExplore = "/explore.php?0=bannette&1=" . $username ."&2=tmp_img";
      
      $urlExplore = "/viewer.php?show_heading=list&dir=cache";
      header("Location: ".MLDOCS_BASE_URL . $urlExplore);
	}
   }
}
?>
