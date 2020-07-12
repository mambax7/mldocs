<?php
//$Id: staffReview.php,v 1.14 2005/10/18 19:27:30 eric_juden Exp $
require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/logService.php');
require_once(MLDOCS_CLASS_PATH.'/staffService.php');

$_eventsrv->advise('new_response_rating', mldocs_logService::singleton());
$_eventsrv->advise('new_response_rating', mldocs_staffService::singleton());

if($xoopsUser){
    if(isset($_POST['submit'])){
        if(isset($_POST['staffid'])){
            $staffid = intval($_POST['staffid']);
        }
        if(isset($_POST['archiveid'])){
            $archiveid = intval($_POST['archiveid']);
        }
        if(isset($_POST['responseid'])){
            $responseid = intval($_POST['responseid']);
        }
        if(isset($_POST['rating'])){
            $rating = intval($_POST['rating']);   
        }
        if(isset($_POST['comments'])){
            $comments = $_POST['comments'];
        }
        $hStaffReview =& mldocsGetHandler('staffReview');
        $review =& $hStaffReview->create();
        $review->setVar('staffid', $staffid);
        $review->setVar('rating', $rating);
        $review->setVar('archiveid', $archiveid);
        $review->setVar('responseid', $responseid);
        $review->setVar('comments', $comments);
        $review->setVar('submittedBy', $xoopsUser->getVar('uid'));
        $review->setVar('userIP', getenv("REMOTE_ADDR"));
        if($hStaffReview->insert($review)){
            $message = _MLDOCS_MESSAGE_ADD_STAFFREVIEW;
            $_eventsrv->trigger('new_response_rating', array(&$review));
        } else {
            $message = _MLDOCS_MESSAGE_ADD_STAFFREVIEW_ERROR;
        }
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=$archiveid", 3, $message);
    } else {
        $xoopsOption['template_main'] = 'mldocs_staffReview.html';   // Set template
        require(XOOPS_ROOT_PATH.'/header.php');                     // Include
        
        if(isset($_GET['staff'])){
            $xoopsTpl->assign('mldocs_staffid', intval($_GET['staff']));
        }
        if(isset($_GET['archiveid'])){
            $xoopsTpl->assign('mldocs_archiveid', intval($_GET['archiveid']));
        }
        if(isset($_GET['responseid'])){
            $xoopsTpl->assign('mldocs_responseid', intval($_GET['responseid']));
        }
        
        $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL . '/modules/mldocs/images/');
        $xoopsTpl->assign('xoops_module_header', $mldocs_module_header);
        $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
        
        require(XOOPS_ROOT_PATH.'/footer.php');
    }
} else {    // If not a user
    redirect_header(XOOPS_URL .'/user.php', 3);
}
?>