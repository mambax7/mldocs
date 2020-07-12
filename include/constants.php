<?php
/*$Id: constants.php,v 0.53 2006/02/08 15:42:04 gabybob Exp $
modification le  16 août 2007  gabriel_bobard 

 *Global Application Constants
 *
 *@author gabybob pour BYOOS solutions
 *@access Public
 */

define('MLDOCS_DIR_NAME', 'mldocs');

define('MLDOCS_SITE_URL', XOOPS_URL);

//Application Folders
define('MLDOCS_BASE_PATH', XOOPS_ROOT_PATH.'/modules/'. MLDOCS_DIR_NAME);
define('MLDOCS_CLASS_PATH', MLDOCS_BASE_PATH.'/class');
define('MLDOCS_BASE_URL', MLDOCS_SITE_URL .'/modules/'. MLDOCS_DIR_NAME);
define('MLDOCS_INCLUDE_PATH', MLDOCS_BASE_PATH.'/include');
define('MLDOCS_INCLUDE_URL', MLDOCS_BASE_URL.'/include');
define('MLDOCS_IMAGE_PATH', MLDOCS_BASE_PATH.'/images');
define('MLDOCS_IMAGE_URL', MLDOCS_BASE_URL.'/images');
define('MLDOCS_ADMIN_URL', MLDOCS_BASE_URL.'/admin');
define('MLDOCS_ADMIN_PATH', MLDOCS_BASE_PATH.'/admin');
define('MLDOCS_PEAR_PATH', MLDOCS_CLASS_PATH.'/pear');
define('MLDOCS_CACHE_PATH', XOOPS_ROOT_PATH.'/cache');
define('MLDOCS_CACHE_URL', MLDOCS_SITE_URL .'/cache');
define('MLDOCS_SCRIPT_URL', MLDOCS_BASE_URL.'/scripts');
define('MLDOCS_JPSPAN_PATH', MLDOCS_INCLUDE_PATH.'/jpspan');
define('MLDOCS_UPLOADS_PATH', XOOPS_ROOT_PATH.'/uploads/'. MLDOCS_DIR_NAME);
define('MLDOCS_PHOTOS_URL', XOOPS_URL . '/uploads/'. MLDOCS_DIR_NAME);
/* definition des répertoires upload, archive, bannette  dans header.php
define('MLDOCS_UPLOADS_PATH',  $config['mldocs_pathUploads']);
define('MLDOCS_BANNETTE_PATH',  $config['mldocs_pathBannette']);
define('MLDOCS_ARCHIVE_PATH',  $config['mldocs_pathArchive']);
*/

define('MLDOCS_CACHE_IMG_PATH', XOOPS_ROOT_PATH.'/uploads/mldocs/cache');
define('MLDOCS_CACHE_IMG_URL', XOOPS_URL .'/uploads/mldocs/cache');


//Control Types
define('MLDOCS_CONTROL_TXTBOX',0);
define('MLDOCS_CONTROL_TXTAREA', 1);
define('MLDOCS_CONTROL_SELECT', 2);
define('MLDOCS_CONTROL_MULTISELECT', 3);
define('MLDOCS_CONTROL_YESNO', 4);
define('MLDOCS_CONTROL_CHECKBOX', 5);
define('MLDOCS_CONTROL_RADIOBOX', 6);
define('MLDOCS_CONTROL_DATETIME', 7);
define('MLDOCS_CONTROL_FILE', 8);

//Notification Settings
define('MLDOCS_NOTIF_STAFF_DEPT', 2);
define('MLDOCS_NOTIF_STAFF_OWNER', 3);
define('MLDOCS_NOTIF_STAFF_NONE', 4);

define('MLDOCS_NOTIF_USER_YES', 1);
define('MLDOCS_NOTIF_USER_NO', 2);

define('MLDOCS_NOTIF_NEWARCHIVE', 1);
define('MLDOCS_NOTIF_DELARCHIVE', 2);
define('MLDOCS_NOTIF_EDITARCHIVE', 3);
define('MLDOCS_NOTIF_NEWRESPONSE', 4);
define('MLDOCS_NOTIF_EDITRESPONSE', 5);
define('MLDOCS_NOTIF_EDITSTATUS', 6);
define('MLDOCS_NOTIF_EDITPRIORITY', 7);
define('MLDOCS_NOTIF_EDITOWNER', 8);
define('MLDOCS_NOTIF_CLOSEARCHIVE', 9);
define('MLDOCS_NOTIF_MERGEARCHIVE', 10);

define('MLDOCS_GLOBAL_UID', -999);   // refers to all users
define('MLDOCS_DEFAULT_PRIORITY', 4);

define('MLDOCS_CONSTANTS_INCLUDED', 1);

/*
Ce script offre la possibilité d'afficher des images de format GIF, JPG ou PNG.
*/
define('ALPHABETIC_ORDER', true); // Classer les fichiers et les dossiers par ordre alphabétique / false pour non classé
define('PHOTOS_DIR', MLDOCS_UPLOADS_PATH); // .$username nom du répertoire un seront stockés les sous répertoires de photos
define('THUMBS_DIR', 'miniatures'); // nom des répertoires contenant les fichiers de miniatures
define('ICO_FILENAME', '_icon.jpg'); // nom de l'icone créée à partir de la 1ère image de chaque répertoire
define('ICO_WIDTH', '225'); // largeur de l'image de l'icone en pixel / ne pas dépasser la moitié de l'image originale
define('ICO_HEIGHT', '75'); // hauteur de l'image de l'icone en pixel / ne pas dépasser la moitié de l'image originale
define('MINIATURE_MAXDIM', '120'); // largeur de l'image de miniature en pixel / ne pas dépasser la moitié de l'image originale
define('GLOBAL_JPG_QUALITY', '80'); // taux de compression des jpg créés
/* 
La capacité du script à créer vos miniatures photo dépend de la rapidité d'execution de votre serveur :
plus vous choisissez d'afficher de photos par page, plus il sera lent à la première execution.
Une fois créées, les photos restent sur le serveur.
 */
define('MINIATURES_PER_PAGE', 18); //nombre de miniatures à afficher par page
define('MINIATURES_PER_LINE', 6); //nombre de miniatures à afficher par ligne dans les tableaux
define('HOME_NAME', 'RETOUR - VISUALISATION DES IMAGES'); //nombre de miniatures à afficher par ligne dans les tableaux
define('ICO_PER_PAGE', 12); //nombre de miniatures à afficher par page
define('ICO_PER_LINE', 3); //nombre de miniatures à afficher par ligne dans les tableaux
define('IMAGE_STDDIM', '640'); // largeur de l'image de miniature en pixel / ne pas dépasser la moitié de l'image originale
define('IMAGE_400', '400'); // largeur de l'image de miniature en pixel / ne pas dépasser la moitié de l'image originale
define('IMAGE_800', '800'); // largeur de l'image de miniature en pixel / ne pas dépasser la moitié de l'image originale
define('PHOTONAME_MAXCHAR', 17); // Nb max de caractères pour un nom de photo

?>
