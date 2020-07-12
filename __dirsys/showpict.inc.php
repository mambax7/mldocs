<?php
#------------- creation du tableau chemin -----------------
        $tFilePath = array();
        $i = 0;
        while(list($k,) = each($_GET)){
                if(!is_numeric($k) && $k != 'last') continue;
                $tFilePath[$i] = $_GET[$k];
                $i++;
        }
        $fileName = stripslashes($tFilePath[count($tFilePath)-1]);
        unset($tFilePath[count($tFilePath)-1]);
        
# $fileName     : nom du fichier a afficher
# $tFilePath    : tableau contenant le chemin a partir du document_root


#------------- creation du chemin relatif -----------------
        $ExplorerPath = $CONFIG['ROOT'];

        $_TfilePath = makePath($tFilePath);
        $filePath = $CONFIG['DOCUMENT_ROOT'].Win2UnixShlash($_TfilePath['path']);
        $filePath = resolvePath($filePath);

# $ExplorerPath : chemin absolut jusqu'a l'explorer
# $filePath     : chemin absolut jusqu'au fichier a afficher


#--------- listing des fichiers du repertoire -------------
        $_fileListToHide = file("hide.php");
        $tListFiles = array();
        $index = $i = 0;
        $fp = @opendir($filePath) or die($LANGUE['ERR_Config']);
        while (false !== ($fn = readdir($fp))){

                $fi = file_library(AddLastSlashes($filePath).$fn);
                if(($fi['ico']=='jpg' || $fi['ico']=='bmp' || $fi['ico']=='gif') && $fn[0]!='.' ){
                        if(parseListToHide($_fileListToHide,AddLastSlashes($filePath).$fn,$CONFIG)) continue;
                        $tListFiles[$i] = $fn;
                        $i++;
                }
        }
        closedir($fp);
        iSort($tListFiles);
        $index = array_search($fileName,$tListFiles);

# $tListFiles   : tableau contenant la liste des images a afficher
# $index        : index du tableau $tListFiles contenant l'image a afficher

#--------------- creation des liens --------------------

$a =  SoustractPath($CONFIG['DOCUMENT_ROOT'],$ExplorerPath);
$b =  SoustractPath($filePath,$CONFIG['DOCUMENT_ROOT']);

$_tcFilePath = $tFilePath;

$link = EncodeForUrl('..'.RemoveLastSlashes($a).$b.$tListFiles[$index]);
$_tcFilePath['last'] = $tListFiles[$index];
$query = http_build_query($_tcFilePath,'');

if(isset($tListFiles[$index+1])){
        $linkNext = EncodeForUrl('..'.RemoveLastSlashes($a).$b.$tListFiles[$index+1]);
        $_tcFilePath['last'] = $tListFiles[$index+1];
}
else{
        $linkNext = EncodeForUrl('..'.RemoveLastSlashes($a).$b.$tListFiles[0]);
        $_tcFilePath['last'] = $tListFiles[0];
}
$queryNext = http_build_query($_tcFilePath,'');
        
if(isset($tListFiles[$index-1])){
        $linkPrevious = EncodeForUrl('..'.RemoveLastSlashes($a).$b.$tListFiles[$index-1]);
        $_tcFilePath['last'] = $tListFiles[$index-1];
}
else{
        $linkPrevious = EncodeForUrl('..'.RemoveLastSlashes($a).$b.$tListFiles[count($tListFiles)-1]);
        $_tcFilePath['last'] = $tListFiles[count($tListFiles)-1];
}
$queryPrevious = http_build_query($_tcFilePath,'');

$queryDir = http_build_query($tFilePath,'');

# $link,$linkNext,$linkPrevious         : contiennent les chemin url encodé pour les liens html
# $query,$queryNext,$queryPrevious      : contiennent les requetes $_GET
# $queryDir                             : contient la requete $_GET pour le dossier


#-- recuperation des dimensions de l'image a afficher --

        if( ($tInfoImg = @getimagesize(AddLastSlashes($filePath).$fileName)) !== false){
                $widthImg = $tInfoImg[0];
                $heightImg = $tInfoImg[1];
        }
        else{
                $widthImg = 200;
                $heightImg = 200;
                $link = 'img/404.gif';
        }

#  $widthImg    : largeur de l'image a afficher
#  $heightImg   : hauteur de l'image a afficher


#--------------- metadonnee exif -----------------------

        $exif = false;
        if($CONFIG['EXIF_READER']) $exif = exif(AddLastSlashes($filePath).$fileName);

# $exif : retourne la chaine de caractere contenant les donnees exif
#-------------------------------------------------------
?>
