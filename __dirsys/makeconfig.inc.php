<?php
if (isset ($HTTP_GET_VARS)) $_GET = &$HTTP_GET_VARS;
if (isset ($HTTP_SERVER_VARS)) $_SERVER = &$HTTP_SERVER_VARS;
if($CONFIG['DEBUG']) error_reporting(E_ALL);
else error_reporting(E_ALL ^ E_NOTICE);
if($CONFIG['FRAME_BORDER']) $CONFIG['FRAME_BORDER'] = 'yes'; else $CONFIG['FRAME_BORDER'] = 'no';
switch($CONFIG['SCROLING_TREE_FRAME']){case 'YES' :$CONFIG['SCROLING_TREE_FRAME'] = 'yes';break;case 'NO' :$CONFIG['SCROLING_TREE_FRAME'] = 'no';break;default :$CONFIG['SCROLING_TREE_FRAME'] = '';}
if(!$CONFIG['RESIZE_FRAME']) $CONFIG['RESIZE_FRAME'] = 'noresize'; else $CONFIG['RESIZE_FRAME'] = '';

$CONFIG['DIRSYS'] = RemoveLastSlashes(RemoveFirstChar($CONFIG['DIRSYS'],'/'));
$CONFIG['DIRSYSLEN'] = strlen($CONFIG['DIRSYS']);  // +1;
//echo "start = ".$CONFIG['DOCUMENT_ROOT']."<br>";
$CONFIG['ROOT'] =  Win2UnixShlash(AddLastSlashes(substr(dirname(__FILE__),0 , -$CONFIG['DIRSYSLEN'])));
$CONFIG['DOCUMENT_ROOT'] = Win2UnixShlash($CONFIG['ROOT'] . AddLastSlashes(RemoveFirstChar($CONFIG['DOCUMENT_ROOT'],'/')));
//echo "middle = ".$CONFIG['DOCUMENT_ROOT']."<br>";
$CONFIG['DOCUMENT_ROOT'] = AddLastSlashes(resolvePath($CONFIG['DOCUMENT_ROOT']));
//echo "end = ".$CONFIG['DOCUMENT_ROOT']."<br>";

$CONFIG['MASK_TYPE_FILES_TABLE'] = explode(',', $CONFIG['MASK_TYPE_FILES']);

if($CONFIG['STYLE'] == 0 ) { 
$day_style = getdate();
switch($day_style['wday']){
        case 0 : $CONFIG['STYLE'] = 1;break;
        case 1 : $CONFIG['STYLE'] = 2;break;
        case 2 : $CONFIG['STYLE'] = 3;break;
        case 3 : $CONFIG['STYLE'] = 2;break;
        case 4 : $CONFIG['STYLE'] = 1;break;
        case 5 : $CONFIG['STYLE'] = 4;break;
        case 6 : $CONFIG['STYLE'] = 2;break;
}
}
switch($CONFIG['STYLE']){ case 2:$CONFIG['ICO_FOLDER'] = "icones/crystal";break; case 3:$CONFIG['ICO_FOLDER'] = "icones/aqua";break; case 4:$CONFIG['ICO_FOLDER'] = "icones/gorilla";break; default:$CONFIG['ICO_FOLDER'] = "icones/win";}
if ($CONFIG['EXIF_READER']){ if(!function_exists('exif_read_data')) $CONFIG['EXIF_READER'] = FALSE; }
if(!function_exists('imagejpeg')) $CONFIG['IMAGE_TN'] = FALSE;
if($CONFIG['GD2']) {if (!function_exists('imagecreatetruecolor')) $CONFIG['GD2'] = FALSE;}
$CONFIG['TOTALSIZE'] = ($CONFIG['TOTALSIZE']*1024*1024);
?>
