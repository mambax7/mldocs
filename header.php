<?php
// modification BYOOS solutions le 04 juillet 2006 gabriel
require('../../mainfile.php');

if (!defined('MLDOCS_CONSTANTS_INCLUDED')) {
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
}

include_once(MLDOCS_BASE_PATH.'/functions.php');
require_once(MLDOCS_CLASS_PATH.'/session.php');
require_once(MLDOCS_CLASS_PATH.'/eventService.php');

$_mldocsSession = new Session();
$_eventsrv = mldocs_eventService::singleton();

$roleReset  = false;
$mldocs_isStaff    = false;
// récupère les répertoires bannette, archive
$config =& mldocsGetModuleConfig();
define('MLDOCS_UPLOADS_PATH',  $config['mldocs_pathUploads']);
define('MLDOCS_BANNETTE_PATH',  $config['mldocs_pathBannette']);
define('MLDOCS_ARCHIVE_PATH',  $config['mldocs_pathArchive']);
define('MLDOCS_BANNETTE_URL',  $config['mldocs_urlBannette']);
define('MLDOCS_UNIQUE_ARCHIVE',  $config['mldocs_uniqueCodeArchive']);
define('MLDOCS_ARCHIVE_ACTIONS',  $config['mldocs_staffArchiveAction']);
// Is the current user a staff member?
if($xoopsUser){
    $hStaff =& mldocsGetHandler('staff');
    if($mldocs_staff =& $hStaff->getByUid($xoopsUser->getVar('uid'))){
        $mldocs_isStaff = true;
        
        // Check if the staff member permissions have changed since the last page request
        if(!$myTime = $_mldocsSession->get("mldocs_permTime")){
            $roleReset = true;
        } else {
            $dbTime = $mldocs_staff->getVar('permTimestamp');
            if($dbTime > $myTime){
                $roleReset = true;
            }
        }
        
        // Update staff member permissions (if necessary)   
        if($roleReset){
            $updateRoles = $mldocs_staff->resetRoleRights();
            $_mldocsSession->set("mldocs_permTime", time());
        }
        
        //Retrieve the staff member's saved searches
        if(!$aSavedSearches =& $_mldocsSession->get("mldocs_savedSearches")){
            $aSavedSearches =& mldocsGetSavedSearches();
        }
    }
}

$mldocs_module_css = MLDOCS_BASE_URL . '/styles/mldocs.css';
$mldocs_module_header = '<link rel="stylesheet" type="text/css" media="all" href="'.$mldocs_module_css.'" /><!--[if gte IE 5.5000]><script src="iepngfix.js" language="JavaScript" type="text/javascript"></script><![endif]-->';

// @todo - this line is for compatiblity, remove once all references to $isStaff have been modified
$isStaff = $mldocs_isStaff;


?>
