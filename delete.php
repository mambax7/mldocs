<?php
//$Id: delete.php,v 1.18 2005/03/03 16:26:04 eric_juden Exp $
require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/notificationService.php');
require_once(MLDOCS_CLASS_PATH.'/cacheService.php');
include_once(MLDOCS_BASE_PATH.'/functions.php');
$_eventsrv->advise('delete_archive', mldocs_notificationService::singleton());
$_eventsrv->advise('delete_archive', mldocs_cacheService::singleton());

/**
 * @todo move these into archive.php and profile.php respectivly
 */
if($xoopsUser){
    $uid = $xoopsUser->getVar('uid');
    
    if(isset($_POST['delete_archive'])){
        $hArchive =& mldocsGetHandler('archive');
        if(isset($_POST['archiveid'])){
            $mldocs_id = $_POST['archiveid'];
        }
        $archiveInfo =& $hArchive->get($mldocs_id);      // Retrieve archive information
        if($hArchive->delete(& $archiveInfo)){
            $message = _MLDOCS_MESSAGE_DELETE_ARCHIVE;
            $_eventsrv->trigger('delete_archive', array(&$archiveInfo));
        } else {
            $message = _MLDOCS_MESSAGE_DELETE_ARCHIVE_ERROR;
        }
        redirect_header(MLDOCS_BASE_URL.'/index.php', 3, $message);
    } elseif(isset($_POST['delete_responseTpl'])){ 
        //Should only the owner of a template be able to delete it?
        $hResponseTpl = mldocsGetHandler('responseTemplates');
        $displayTpl =& $hResponseTpl->get($_POST['tplID']);
        if ($xoopsUser->getVar('uid') != $displayTpl->getVar('uid')) {
            $message = _NOPERM;
        } else {
        
            if($hResponseTpl->delete($displayTpl)){
                $message = _MLDOCS_MESSAGE_DELETE_RESPONSE_TPL;
                $_eventsrv->trigger('delete_responseTpl', array($displayTpl));
            } else {
                $message = _MLDOCS_MESSAGE_DELETE_RESPONSE_TPL_ERROR;
            }
        }
        redirect_header(MLDOCS_BASE_URL."/profile.php", 3, $message);
    }
} else {    // If not a user
    redirect_header(XOOPS_URL .'/user.php', 3);
}

?>