<?php
//$Id: profile.php,v 1.41 2005/10/18 19:27:30 eric_juden Exp $
require_once('header.php');
include_once(MLDOCS_BASE_PATH.'/functions.php');

// Disable module caching in smarty
$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0;

if($xoopsUser){
    $responseTplID = 0;
    
    $op = 'default';
    if(isset($_REQUEST['op'])){
        $op = $_REQUEST['op'];
    }
    
    if(isset($_GET['responseTplID'])){
        $responseTplID = intval($_GET['responseTplID']);
    }
    
    $xoopsOption['template_main'] = 'mldocs_staff_profile.html';   // Set template
    require(XOOPS_ROOT_PATH.'/header.php');                     // Include the page header
    
    $numResponses = 0;
    $uid = $xoopsUser->getVar('uid');
    $hStaff =& mldocsGetHandler('staff');
    if (!$staff =& $hStaff->getByUid($uid)) {
        redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_ERROR_INV_STAFF);
        exit();
    }
    $hArchiveList =& mldocsGetHandler('archiveList');
    $hResponseTpl =& mldocsGetHandler('responseTemplates');
    $crit = new Criteria('uid', $uid);
    $crit->setSort('name');
    $responseTpl =& $hResponseTpl->getObjects($crit);
    
    foreach($responseTpl as $response){
        $aResponseTpl[] = array('id'=>$response->getVar('id'),
                              'uid'=>$response->getVar('uid'),
                              'name'=>$response->getVar('name'),
                              'response'=>$response->getVar('response'));
    }
    $has_responseTpl = count($responseTpl) > 0;
    unset($responseTpl);
    
    $displayTpl =& $hResponseTpl->get($responseTplID);
    
    switch($op){
        case "responseTpl":
            if(isset($_POST['updateResponse'])){
                if(isset($_POST['attachSig'])){
                    $staff->setVar('attachSig', $_POST['attachSig']);
                    if(!$hStaff->insert($staff)){
                        $message = _MLDOCS_MESSAGE_UPDATE_SIG_ERROR;
                    }
                }
                if($_POST['name'] == '' || $_POST['replyText'] == ''){
                    redirect_header(MLDOCS_BASE_URL."/profile.php", 3, _MLDOCS_ERROR_INV_TEMPLATE);
                }
                if($_POST['responseid'] != 0){
                    $updateTpl =& $hResponseTpl->get($_POST['responseid']);      
                } else {
                    $updateTpl =& $hResponseTpl->create();
                }
                $updateTpl->setVar('uid', $uid);
                $updateTpl->setVar('name',$_POST['name']);
                $updateTpl->setVar('response',$_POST['replyText']);
                if($hResponseTpl->insert($updateTpl)){
                    $message = _MLDOCS_MESSAGE_RESPONSE_TPL;
                } else {
                    $message = _MLDOCS_MESSAGE_RESPONSE_TPL_ERROR;
                }
                redirect_header(MLDOCS_BASE_URL."/profile.php", 3, $message);
            } else {        // Delete response template
                $hResponseTpl =& mldocsGetHandler('responseTemplates');
                $displayTpl =& $hResponseTpl->get($_POST['tplID']);
                if($hResponseTpl->delete($displayTpl)){
                    $message = _MLDOCS_MESSAGE_DELETE_RESPONSE_TPL;
                } else {
                    $message = _MLDOCS_MESSAGE_DELETE_RESPONSE_TPL_ERROR;
                }
                redirect_header(MLDOCS_BASE_URL."/profile.php", 3, $message);
            }
        break;
            
        case "updateNotification":
            $notArray = (is_array($_POST['notifications']) ?  $_POST['notifications'] : array(0));
            $notValue = array_sum($notArray);
            $staff->setVar('notify', $notValue);
            if(isset($_POST['email']) && $_POST['email'] <> $staff->getVar('email')){
                $staff->setVar('email', $_POST['email']);
            }
            if(!$hStaff->insert($staff)){
                $message = _MLDOCS_MESSAGE_UPDATE_EMAIL_ERROR;
                
            }
            $message = _MLDOCS_MESSAGE_NOTIFY_UPDATE;
            redirect_header(MLDOCS_BASE_URL."/profile.php", 3, $message);
            break;
            
        case "addArchiveList":
            if(isset($_POST['savedSearch']) && ($_POST['savedSearch'] != 0)){
                $searchid = intval($_POST['savedSearch']);
                $archiveList =& $hArchiveList->create();
                $archiveList->setVar('uid', $xoopsUser->getVar('uid'));
                $archiveList->setVar('searchid', $searchid);
                $archiveList->setVar('weight', $hArchiveList->createNewWeight($xoopsUser->getVar('uid')));
                
                if($hArchiveList->insert($archiveList)){
                    header("Location: ".MLDOCS_BASE_URL."/profile.php");
                } else {
                    redirect_header(MLDOCS_BASE_URL."/profile.php", 3, _MLDOCS_MSG_ADD_ARCHIVELIST_ERR);
                }
            }
        break;
        
        case "editArchiveList":
            if(isset($_REQUEST['id']) && $_REQUEST['id'] != 0){
                $listID = intval($_REQUEST['id']);
            } else {
                redirect_header(MLDOCS_BASE_URL."/profile.php", 3, _MLDOCS_MSG_NO_ID);
            }
        break;
        
        case "deleteArchiveList":
            if(isset($_REQUEST['id']) && $_REQUEST['id'] != 0){
                $listID = intval($_REQUEST['id']);
            } else {
                redirect_header(MLDOCS_BASE_URL."/profile.php", 3, _MLDOCS_MSG_NO_ID);
            }
            $archiveList =& $hArchiveList->get($listID);
            if($hArchiveList->delete($archiveList, true)){
                header("Location: ".MLDOCS_BASE_URL."/profile.php");
            } else {
                redirect_header(MLDOCS_BASE_URL."/profile.php", 3, _MLDOCS_MSG_DEL_ARCHIVELIST_ERR);
            }
        break;
        
        case "changeListWeight":
            if(isset($_REQUEST['id']) && $_REQUEST['id'] != 0){
                $listID = intval($_REQUEST['id']);
            } else {
                redirect_header(MLDOCS_BASE_URL."/profile.php", 3, _MLDOCS_MSG_NO_ID);
            }
            $up = false;
            if(isset($_REQUEST['up'])){
                $up = $_REQUEST['up'];
            }
            $hArchiveList->changeWeight($listID, $up);
            header("Location: ".MLDOCS_BASE_URL."/profile.php");
        break;
            
        default:
            $xoopsTpl->assign('mldocs_responseTplID', $responseTplID);
            $module_header = '<!--[if gte IE 5.5000]><script src="iepngfix.js" language="JavaScript" type="text/javascript"></script><![endif]-->';
            $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL .'/modules/mldocs/images/');
            $xoopsTpl->assign('mldocs_has_sig', $staff->getVar('attachSig'));
            if(isset($aResponseTpl)){
                $xoopsTpl->assign('mldocs_responseTpl', $aResponseTpl);
            } else {
                $xoopsTpl->assign('mldocs_responseTpl', 0);
            }
            $xoopsTpl->assign('mldocs_hasResponseTpl', (isset($aResponseTpl)) ? count($aResponseTpl) > 0 : 0);
            if(!empty($responseTplID)){
                $xoopsTpl->assign('mldocs_displayTpl_id', $displayTpl->getVar('id'));
                $xoopsTpl->assign('mldocs_displayTpl_name', $displayTpl->getVar('name'));
                $xoopsTpl->assign('mldocs_displayTpl_response', $displayTpl->getVar('response', 'e'));
            } else {
                $xoopsTpl->assign('mldocs_displayTpl_id', 0);
                $xoopsTpl->assign('mldocs_displayTpl_name', '');
                $xoopsTpl->assign('mldocs_displayTpl_response', '');
            }
            $xoopsTpl->assign('xoops_module_header', $module_header);
            $xoopsTpl->assign('mldocs_callsClosed', $staff->getVar('callsClosed'));
            $xoopsTpl->assign('mldocs_numReviews', $staff->getVar('numReviews'));
            $xoopsTpl->assign('mldocs_responseTime', mldocsFormatTime( ($staff->getVar('archivesResponded') ? $staff->getVar('responseTime') / $staff->getVar('archivesResponded') : 0)));
            $notify_method = $xoopsUser->getVar('notify_method');
            $xoopsTpl->assign('mldocs_notify_method', ($notify_method == 1) ? _MLDOCS_NOTIFY_METHOD1 : _MLDOCS_NOTIFY_METHOD2);
    
            if(($staff->getVar('rating') == 0) || ($staff->getVar('numReviews') == 0)){
                $xoopsTpl->assign('mldocs_rating', 0);
            } else {
                $xoopsTpl->assign('mldocs_rating', intval($staff->getVar('rating')/$staff->getVar('numReviews')));
            }
            $xoopsTpl->assign('mldocs_uid', $xoopsUser->getVar('uid'));
            $xoopsTpl->assign('mldocs_rating0', _MLDOCS_RATING0);
            $xoopsTpl->assign('mldocs_rating1', _MLDOCS_RATING1);
            $xoopsTpl->assign('mldocs_rating2', _MLDOCS_RATING2);
            $xoopsTpl->assign('mldocs_rating3', _MLDOCS_RATING3);
            $xoopsTpl->assign('mldocs_rating4', _MLDOCS_RATING4);
            $xoopsTpl->assign('mldocs_rating5', _MLDOCS_RATING5);
            $xoopsTpl->assign('mldocs_staff_email', $staff->getVar('email'));
            $xoopsTpl->assign('mldocs_savedSearches', $aSavedSearches);
            
            $myRoles =& $hStaff->getRoles($xoopsUser->getVar('uid'), true);
            $hNotification =& mldocsGetHandler('notification');
            $settings =& $hNotification->getObjects(null, true);
            
            $templates =& $xoopsModule->getInfo('_email_tpl');
            $has_notifications = count($templates);
            
            // Check that notifications are enabled by admin
            $i = 0;
            $staff_enabled = true;
            foreach($templates as $template_id=>$template){
                if($template['category'] == 'dept'){
                    $staff_setting = $settings[$template_id]->getVar('staff_setting');
                    if($staff_setting == 4){
                        $staff_enabled = false;
                    } elseif($staff_setting == 2){
                        $staff_options = $settings[$template_id]->getVar('staff_options');
                        foreach($staff_options as $role){
                            if(array_key_exists($role, $myRoles)){
                                $staff_enabled = true;
                                break;
                            } else {
                                $staff_enabled = false;
                            }
                        }
                    }
                    
                    $deptNotification[] = array('id'=> $template_id,
                                                'name'=>$template['name'],
                                                'category'=>$template['category'],
                                                'template'=>$template['mail_template'],
                                                'subject'=>$template['mail_subject'],
                                                'bitValue'=>(pow(2, $template['bit_value'])),
                                                'title'=>$template['title'],
                                                'caption'=>$template['caption'],
                                                'description'=>$template['description'],
                                                'isChecked'=>($staff->getVar('notify') & pow(2, $template['bit_value'])) > 0,
                                                'staff_setting'=> $staff_enabled);
                }
            }
            if($has_notifications){
                $xoopsTpl->assign('mldocs_deptNotifications', $deptNotification);
            } else {
                $xoopsTpl->assign('mldocs_deptNotifications', 0);
            }
                    
            $hReview  =& mldocsGetHandler('staffReview');
            $hMembers =& xoops_gethandler('member');
            $crit = new Criteria('staffid', $xoopsUser->getVar('uid'));
            $crit->setSort('id');
            $crit->setOrder('DESC');
            $crit->setLimit(5);
            
            $reviews =& $hReview->getObjects($crit);
            
            $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
            
            foreach ($reviews as $review) {
                $reviewer = $hMembers->getUser($review->getVar('submittedBy'));
                $xoopsTpl->append('mldocs_reviews', array('rating' => $review->getVar('rating'), 
                            'ratingdsc' => mldocsGetRating($review->getVar('rating')),
                            'submittedBy' => ($reviewer ? mldocsGetUsername($reviewer, $displayName) : $xoopsConfig['anonymous']),
                            'submittedByUID' => $review->getVar('submittedBy'),
                            'responseid' => $review->getVar('responseid'),
                            'comments' => $review->getVar('comments'),
                            'archiveid' => $review->getVar('archiveid')));
            }
            $xoopsTpl->assign('mldocs_hasReviews', (count($reviews) > 0));
            
            // Archive Lists
            $archiveLists =& $hArchiveList->getListsByUser($xoopsUser->getVar('uid'));
            $aMySavedSearches = array();
            $mySavedSearches = mldocsGetGlobalSavedSearches();
            $has_savedSearches = count($aMySavedSearches > 0);
            $archiveListCount = count($archiveLists);
            $aArchiveLists = array();
            $aUsedSearches = array();
            $eleNum = 0;
            foreach($archiveLists as $archiveList){
                $weight = $archiveList->getVar('weight');
                $searchid = $archiveList->getVar('searchid');
                $aArchiveLists[$archiveList->getVar('id')] = array('id' => $archiveList->getVar('id'),
                                                                 'uid' => $archiveList->getVar('uid'),
                                                                 'searchid' => $searchid,
                                                                 'weight' => $weight,
                                                                 'name' => $mySavedSearches[$archiveList->getVar('searchid')]['name'],
                                                                 'hasWeightUp' => (($eleNum != $archiveListCount - 1) ? true : false),
                                                                 'hasWeightDown' => (($eleNum != 0) ? true : false),
                                                                 'hasEdit' => (($mySavedSearches[$archiveList->getVar('searchid')]['uid'] != -999) ? true : false));
                $eleNum++;
                $aUsedSearches[$searchid] = $searchid;
            }
            unset($archiveLists);
            
            // Take used searches to get unused searches
            $aSearches = array();
            foreach($mySavedSearches as $savedSearch){
                if(!in_array($savedSearch['id'], $aUsedSearches)){
                    if($savedSearch['id'] != ""){
                        $aSearches[$savedSearch['id']] = $savedSearch;
                    }
                }
            }
            $hasUnusedSearches = count($aSearches) > 0;
            $xoopsTpl->assign('mldocs_archiveLists', $aArchiveLists);
            $xoopsTpl->assign('mldocs_hasArchiveLists', count($aArchiveLists) > 0);
            $xoopsTpl->assign('mldocs_unusedSearches', $aSearches);
            $xoopsTpl->assign('mldocs_hasUnusedSearches', $hasUnusedSearches);
            $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
        break;
    }
} else {
    redirect_header(XOOPS_URL .'/user.php', 3);
}

require(XOOPS_ROOT_PATH.'/footer.php');

?>