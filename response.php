<?php
//$Id: response.php,v 1.62 2005/10/18 19:27:30 eric_juden Exp $
require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/notificationService.php');
require_once(MLDOCS_CLASS_PATH.'/logService.php');
require_once(MLDOCS_CLASS_PATH.'/cacheService.php');
require_once(MLDOCS_CLASS_PATH.'/staffService.php');

//Handlers for each event triggered by this script
$_eventsrv->advise('update_status', mldocs_notificationService::singleton());
$_eventsrv->advise('update_owner', mldocs_notificationService::singleton());
$_eventsrv->advise('update_owner', mldocs_logService::singleton());
$_eventsrv->advise('new_response', mldocs_logService::singleton());
$_eventsrv->advise('new_response', mldocs_notificationService::singleton());
$_eventsrv->advise('new_response', mldocs_staffService::singleton());
$_eventsrv->advise('close_archive', mldocs_logService::singleton());
$_eventsrv->advise('close_archive', mldocs_cacheService::singleton());
$_eventsrv->advise('close_archive', mldocs_staffService::singleton());
$_eventsrv->advise('reopen_archive', mldocs_logService::singleton());
$_eventsrv->advise('reopen_archive', mldocs_staffService::singleton());
$_eventsrv->advise('edit_response', mldocs_notificationService::singleton());
$_eventsrv->advise('edit_response', mldocs_logService::singleton());

if(!$xoopsUser){
   redirect_header(XOOPS_URL .'/user.php', 3);
}

$refresh = 0;
if(isset($_GET['refresh'])){
    $refresh = intval($_GET['refresh']);
}

$uid = $xoopsUser->getVar('uid');

// Get the id of the archive
if(isset($_GET['id'])){
    $archiveid = intval($_GET['id']);
}

if (isset($_GET['responseid'])) {
    $responseid = intval($_GET['responseid']);
}

$hArchive      =& mldocsGetHandler('archive');
$hResponseTpl =& mldocsGetHandler('responseTemplates');
$hMembership  =& mldocsGetHandler('membership');
$hResponse    =& mldocsGetHandler('responses');
$hStaff       =& mldocsGetHandler('staff');

if (!$archiveInfo =& $hArchive->get($archiveid)) {
    //Invalid archiveID specified
    redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_ERROR_INV_ARCHIVE);
}

$has_owner = $archiveInfo->getVar('ownership');

$op = 'staffFrm'; //Default Action for page

if(isset($_GET['op'])){
    $op = $_GET['op'];
}

if (isset($_POST['op'])) {
    $op = $_POST['op'];
}

switch ($op) {
    
case 'staffAdd':
    //0. Check that the user can perform this action
    $message = '';
    $url = MLDOCS_BASE_URL.'/index.php';
    $hasErrors = false;
    $errors = array();
    $uploadFile = $archiveReopen = $changeOwner = $archiveClosed = $newStatus = false;
    
    if ($isStaff) {
        // Check if staff has permission to respond to the archive
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new CriteriaCompo(new Criteria('archiveid', $archiveid));
        $crit->add(new Criteria('uid', $xoopsUser->getVar('uid')));
        $archiveEmails =& $hArchiveEmails->getObjects($crit);
        if(count($archiveEmails > 0) || $mldocs_staff->checkRoleRights(_MLDOCS_SEC_RESPONSE_ADD, $archiveInfo->getVar('department'))){
            //1. Verify Response fields are filled properly
            require_once(MLDOCS_CLASS_PATH.'/validator.php');
            $v = array();
            $v['response'][] = new ValidateLength($_POST['response'], 2, 50000);
            $v['timespent'][] = new ValidateNumber($_POST['timespent']);
        
            if($xoopsModuleConfig['mldocs_allowUpload'] && is_uploaded_file($_FILES['userfile']['tmp_name'])){
                $hMime =& mldocsGetHandler('mimetype');
                //Add File Upload Validation Rules
                $v['userfile'][] = new ValidateMimeType($_FILES['userfile']['name'], $_FILES['userfile']['type'], $hMime->getArray());
                $v['userfile'][] = new ValidateFileSize($_FILES['userfile']['tmp_name'], $xoopsModuleConfig['mldocs_uploadSize']);
                $v['userfile'][] = new ValidateImageSize($_FILES['userfile']['tmp_name'], $xoopsModuleConfig['mldocs_uploadWidth'], $xoopsModuleConfig['mldocs_uploadHeight']);
                $uploadFile = true;
            }
            
            
            // Perform each validation
            $fields = array();
            $errors = array();
            foreach($v as $fieldname=>$validator) {
                if (!mldocsCheckRules($validator, $errors)) {
                    $hasErrors = true;
                    //Mark field with error
                    $fields[$fieldname]['haserrors'] = true;
                    $fields[$fieldname]['errors'] = $errors;
                } else {
                    $fields[$fieldname]['haserrors'] = false;
                }
            }  
        
            if ($hasErrors) {
                //Store field values in session
                //Store error messages in session
                _setResponseToSession($archiveInfo, $fields);
                //redirect to response.php?op=staffFrm
                header("Location: ". MLDOCS_BASE_URL."/response.php?op=staffFrm&id=$archiveid");
                exit();
            }
            
            //Check if status changed
            if ($_POST['status'] <> $archiveInfo->getVar('status')) {
                $hStatus =& mldocsGetHandler('status');
                $oldStatus = $hStatus->get($archiveInfo->getVar('status'));
                $newStatus = $hStatus->get(intval($_POST['status']));
                
                if ($oldStatus->getVar('state') == 1 && $newStatus->getVar('state') == 2) {
                    $archiveClosed = true;
                } elseif ($oldStatus->getVar('state') ==2  && $newStatus->getVar('state') == 1) {
                    $archiveReopen = true;
                }
                $archiveInfo->setVar('status', intval($_POST['status']));
            }
            
            //Check if user claimed ownership
            if (isset($_POST['claimOwner'])) {
                $ownerid = intval($_POST['claimOwner']);
                if ($ownerid > 0) {
                    $oldOwner = $archiveInfo->getVar('ownership');
                    $archiveInfo->setVar('ownership', $ownerid);
                    $changeOwner = true;
                }
            }
                
            //2. Fill Response Object
            $response =& $hResponse->create();
            $response->setVar('uid', $xoopsUser->getVar('uid'));
            $response->setVar('archiveid', $archiveid);
            $response->setVar('message', $_POST['response']);
            $response->setVar('timeSpent', $_POST['timespent']);
            $response->setVar('updateTime', $archiveInfo->getVar('lastUpdated'));
            $response->setVar('userIP', getenv("REMOTE_ADDR"));
            if(isset($_POST['private'])){
                $response->setVar('private', $_POST['private']);
            }
          
            //3. Store Response Object in DB
            if ($hResponse->insert($response)) {
                $_eventsrv->trigger('new_response', array(&$archiveInfo, &$response));
            } else {
                //Store response fields in session
                _setResponseToSession($archiveInfo,$fields);
                //Notify user of error (using redirect_header())'
                redirect_header(MLDOCS_BASE_URL."/archive.php?id=$archiveid", 3, _MLDOCS_MESSAGE_ADDRESPONSE_ERROR);
            }
            
            //4. Update Archive object
            if (isset($_POST['timespent'])) {
                $oldspent = $archiveInfo->getVar('totalTimeSpent');
                $archiveInfo->setVar('totalTimeSpent', $oldspent + intval($_POST['timespent']));
            }
            $archiveInfo->setVar('lastUpdated', time());
            
            //5. Store Archive Object
            if ($hArchive->insert($archiveInfo)) {
                if ($newStatus) {
                    $_eventsrv->trigger('update_status', array(&$archiveInfo, &$oldStatus, &$newStatus));
                }
                if ($archiveClosed) {
                    $_eventsrv->trigger('close_archive', array(&$archiveInfo));
                }
                if ($archiveReopen) {
                    $_eventsrv->trigger('reopen_archive', array(&$archiveInfo));
                }
                if ($changeOwner) {
                    $_eventsrv->trigger('update_owner', array(&$archiveInfo, $oldOwner));
                }
            } else {
                //Archive Update Error
                redirect_header(MLDOCS_BASE_URL."/response.php?op=staffFrm&id=$archiveid", 3, _MLDOCS_MESSAGE_EDITARCHIVE_ERROR);
                exit();
            }
                
            //6. Save Attachments
            if ($uploadFile) {
                $allowed_mimetypes = $hMime->checkMimeTypes('userfile');
                if (!$file = $archiveInfo->storeUpload('userfile', $response->getVar('id'), $allowed_mimetypes)) {           
                    redirect_header(MLDOCS_BASE_URL."/archive.php?id=$archiveid", 3, _MLDOCS_MESSAGE_ADDFILE_ERROR);            
                    exit();
                }
            }    
            
            //7. Success, clear session, redirect to archive    
            _clearResponseFromSession();
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$archiveid", 3, _MLDOCS_MESSAGE_ADDRESPONSE);
        } else {
            redirect_header($url, 3, _MLDOCS_ERROR_NODEPTPERM);
            exit();
        }
    }
    break;

    

case 'staffFrm':
    $isSubmitter = false;
    $isStaff = $hMembership->isStaffMember($xoopsUser->getVar('uid'), $archiveInfo->getVar('department'));
    
    // Check if staff has permission to respond to the archive
    $hArchiveEmails =& mldocsGetHandler('archiveEmails');
    $crit = new CriteriaCompo(new Criteria('archiveid', $archiveid));
    $crit->add(new Criteria('uid', $xoopsUser->getVar('uid')));
    $archiveEmails =& $hArchiveEmails->getObjects($crit);
    if(count($archiveEmails) > 0){
        $isSubmitter = true;
    }
    if($isSubmitter || $mldocs_staff->checkRoleRights(_MLDOCS_SEC_RESPONSE_ADD, $archiveInfo->getVar('department'))){
        $hStatus =& mldocsGetHandler('status');
        $crit = new Criteria('', '');
        $crit->setSort('description');
        $crit->setOrder('ASC');
        $statuses =& $hStatus->getObjects($crit);
        $aStatuses = array();
        foreach($statuses as $status){
            $aStatuses[$status->getVar('id')] = array('id' => $status->getVar('id'),
                                                      'desc' => $status->getVar('description'),
                                                      'state' => $status->getVar('state'));
        }
            
        $xoopsOption['template_main'] = 'mldocs_response.html';   // Set template
        require(XOOPS_ROOT_PATH.'/header.php');
        
        $xoopsTpl->assign('mldocs_allowUpload', $xoopsModuleConfig['mldocs_allowUpload']);
        $xoopsTpl->assign('mldocs_has_owner', $has_owner);
        $xoopsTpl->assign('mldocs_currentUser', $xoopsUser->getVar('uid'));
        $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL . '/modules/mldocs/images/');
        $xoopsTpl->assign('mldocs_archiveID', $archiveid);
        $xoopsTpl->assign('mldocs_archive_status', $archiveInfo->getVar('status'));
        $xoopsTpl->assign('mldocs_archive_description', $archiveInfo->getVar('description')); 
        $xoopsTpl->assign('mldocs_archive_subject', $archiveInfo->getVar('subject'));
        $xoopsTpl->assign('mldocs_statuses', $aStatuses);
        $xoopsTpl->assign('mldocs_isSubmitter', $isSubmitter);
        $xoopsTpl->assign('mldocs_archive_details', sprintf(_MLDOCS_TEXT_ARCHIVEDETAILS, $archiveInfo->getVar('id')));
        $xoopsTpl->assign('mldocs_savedSearches', $aSavedSearches);
        
        $aElements = array();
        if($validateErrors =& $_mldocsSession->get('mldocs_validateError')){
            $errors = array();
            foreach($validateErrors as $fieldname=>$error){
                if(!empty($error['errors'])){
                    $aElements[] = $fieldname;
                    foreach($error['errors'] as $err){
                        $errors[$fieldname] = $err;
                    }
                }
            }
            $xoopsTpl->assign('mldocs_errors', $errors);
        } else {
            $xoopsTpl->assign('mldocs_errors', null);
        }
        
        $elements = array('response', 'timespent');
        foreach($elements as $element){         // Foreach element in the predefined list
            $xoopsTpl->assign("mldocs_element_$element", "formButton");
            foreach($aElements as $aElement){   // Foreach that has an error
                if($aElement == $element){      // If the names are equal
                    $xoopsTpl->assign("mldocs_element_$element", "validateError");
                    break;
                }   
            }
        }     
    
        //Get all staff defined templates
        $crit = new Criteria('uid', $uid);
        $crit->setSort('name');
        $responseTpl =& $hResponseTpl->getObjects($crit, true);
        
        $xoopsTpl->append('mldocs_responseTpl_values', '------------------');
        $xoopsTpl->append('mldocs_responseTpl_ids', 0);
        
        foreach($responseTpl as $obj) {
            $xoopsTpl->append('mldocs_responseTpl_values', $obj->getVar('name'));
            $xoopsTpl->append('mldocs_responseTpl_ids', $obj->getVar('id'));
        }
        $xoopsTpl->assign('mldocs_hasResponseTpl', (isset($responseTpl) ? count($responseTpl) > 0 : 0));
        $xoopsTpl->append('mldocs_responseTpl_selected', $refresh);
        $xoopsTpl->assign('mldocs_templateID', $refresh);
        
        //Format Response Message Var
        $message = '';
        if($refresh) {
            if($displayTpl = $responseTpl[$refresh]) {
                $message = $displayTpl->getVar('response', 'e');
            }    
        }
        if ($temp = $_mldocsSession->get('mldocs_response_message')) {
            $message = $temp;
        }
        
        //Fill Response Fields (if set in session)
        if ($_mldocsSession->get('mldocs_response_archiveid')) {
            $xoopsTpl->assign('mldocs_response_archiveid', $_mldocsSession->get('mldocs_response_archiveid'));
            $xoopsTpl->assign('mldocs_response_message', $message);
            $xoopsTpl->assign('mldocs_response_status', $_mldocsSession->get('mldocs_response_status'));
            $xoopsTpl->assign('mldocs_archive_status', $_mldocsSession->get('mldocs_response_status'));
            $xoopsTpl->assign('mldocs_response_ownership', $_mldocsSession->get('mldocs_response_ownership'));
            $xoopsTpl->assign('mldocs_response_timespent', $_mldocsSession->get('mldocs_response_timespent'));
            $xoopsTpl->assign('mldocs_response_private', $_mldocsSession->get('mldocs_response_private'));
        }
        $xoopsTpl->assign('xoops_module_header', $mldocs_module_header);
        $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
        require(XOOPS_ROOT_PATH.'/footer.php');
    }
    break;

case 'staffEdit':
    //Is current user staff member?
    if (!$hMembership->isStaffMember($xoopsUser->getVar('uid'), $archiveInfo->getVar('department'))) {
        redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_ERROR_NODEPTPERM);
        exit();
    }
    
    if (!$response =& $hResponse->get($responseid)) {
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=$archiveid", 3, _MLDOCS_ERROR_INV_RESPONSE);
    }
    
    if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_RESPONSE_EDIT, $archiveInfo->getVar('department'))){
        $message = _MLDOCS_MESSAGE_NO_EDIT_RESPONSE;
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=$archiveid", 3, $message);
    }
    
    $xoopsOption['template_main'] = 'mldocs_editResponse.html';             // Always set main template before including the header
    require(XOOPS_ROOT_PATH . '/header.php');
    
    $hStatus =& mldocsGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setSort('description');
    $crit->setOrder('ASC');
    $statuses =& $hStatus->getObjects($crit);
    $aStatuses = array();
    foreach($statuses as $status){
        $aStatuses[$status->getVar('id')] = array('id' => $status->getVar('id'),
                                                  'desc' => $status->getVar('description'),
                                                  'state' => $status->getVar('state'));
    }
    $xoopsTpl->assign('mldocs_statuses', $aStatuses);
    $xoopsTpl->assign('mldocs_responseid', $responseid);
    $xoopsTpl->assign('mldocs_archiveID', $archiveid);
    $xoopsTpl->assign('mldocs_responseMessage', $response->getVar('message', 'e'));
    $xoopsTpl->assign('mldocs_timeSpent', $response->getVar('timeSpent'));
    $xoopsTpl->assign('mldocs_status', $archiveInfo->getVar('status'));
    $xoopsTpl->assign('mldocs_has_owner', $has_owner);
    $xoopsTpl->assign('mldocs_responsePrivate', (($response->getVar('private') == 1) ? _MLDOCS_TEXT_YES : _MLDOCS_TEXT_NO));
    $xoopsTpl->assign('mldocs_currentUser', $uid);
    $xoopsTpl->assign('mldocs_allowUpload', 0);
    $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL . '/modules/mldocs/images/');
    //$xoopsTpl->assign('mldocs_text_subject', _MLDOCS_TEXT_SUBJECT);
    //$xoopsTpl->assign('mldocs_text_description', _MLDOCS_TEXT_DESCRIPTION);
    
    $aElements = array();
    $errors = array();
    if($validateErrors =& $_mldocsSession->get('mldocs_validateError')){
        foreach($validateErrors as $fieldname=>$error){
            if(!empty($error['errors'])){
                $aElements[] = $fieldname;
                foreach($error['errors'] as $err){
                    $errors[$fieldname] = $err;
                }
            }
        }
        $xoopsTpl->assign('mldocs_errors', $errors);
    } else {
        $xoopsTpl->assign('mldocs_errors', null);
    }
    
    $elements = array('response', 'timespent');
    foreach($elements as $element){         // Foreach element in the predefined list
        $xoopsTpl->assign("mldocs_element_$element", "formButton");
        foreach($aElements as $aElement){   // Foreach that has an error
            if($aElement == $element){      // If the names are equal
                $xoopsTpl->assign("mldocs_element_$element", "validateError");
                break;
            }
        }
    }   
    

    $hResponseTpl =& mldocsGetHandler('responseTemplates');          // Used to display responseTemplates
    $crit = new Criteria('uid', $uid);
    $crit->setSort('name');
    $responseTpl =& $hResponseTpl->getObjects($crit);
    
    $aResponseTpl = array();
    foreach($responseTpl as $response){
        $aResponseTpl[] = array('id'=>$response->getVar('id'),
            'uid'=>$response->getVar('uid'),
            'name'=>$response->getVar('name'),
            'response'=>$response->getVar('response'));
    }
    $has_responseTpl = count($responseTpl) > 0;
    unset($responseTpl);
    $displayTpl =& $hResponseTpl->get($refresh);
        
    $xoopsTpl->assign('mldocs_response_text', ($refresh !=0 ? $displayTpl->getVar('response', 'e') : ''));
    $xoopsTpl->assign('mldocs_responseTpl',  $aResponseTpl);
    $xoopsTpl->assign('mldocs_hasResponseTpl', count($aResponseTpl) > 0);
    $xoopsTpl->assign('mldocs_refresh', $refresh);
    $xoopsTpl->assign('xoops_module_header', $mldocs_module_header);
    $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
    
    require(XOOPS_ROOT_PATH.'/footer.php');                             //Include the page footer
    break;

case 'staffEditSave':
    require_once(MLDOCS_CLASS_PATH.'/validator.php');
    $v['response'][] = new ValidateLength($_POST['response'], 2, 50000);
    $v['timespent'][] = new ValidateNumber($_POST['timespent']);
    
    $responseStored = false;
    
    //Is current user staff member?
    if (!$hMembership->isStaffMember($xoopsUser->getVar('uid'), $archiveInfo->getVar('department'))) {
        redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_ERROR_NODEPTPERM);
        exit();
    }
    
    //Retrieve the original response
    if (!$response =& $hResponse->get($responseid)) {
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=".$archiveInfo->getVar('id'), 3, _MLDOCS_ERROR_INV_RESPONSE);
    }
    
    //Copy original archive and response objects
    $oldresponse    = $response;
    $oldarchive      = $archiveInfo;
    
    $url = "response.php?op=staffEditSave&amp;id=$archiveid&amp;responseid=$responseid";
    $archiveReopen = $changeOwner = $archiveClosed = $newStatus = false;
    
    //Store current fields in session
    $_mldocsSession->set('mldocs_response_archiveid', $oldresponse->getVar('archiveid'));
    $_mldocsSession->set('mldocs_response_uid', $response->getVar('uid'));
    $_mldocsSession->set('mldocs_response_message', $_POST['response']);
    
    //Check if the archive status has been changed
    if($_POST['status'] <> $archiveInfo->getVar('status')){
        $archiveInfo->setVar('status', $_POST['status']);
        $newStatus = true;
        
        if($_POST['status'] == 2) { //Closed Archive
            $archiveInfo->setVar('closedBy', $xoopsUser->getVar('uid'));
            $archiveClosed = true;
        }
        
        if($oldarchive->getVar('status') == 2) { //Archive reopened
            $archiveReopen = true;
        }
     }
    $_mldocsSession->set('mldocs_response_status', $archiveInfo->getVar('status'));        // Store in session
    
    //Check if the current user is claiming the archive
    if (isset($_POST['claimOwner']) && $_POST['claimOwner'] > 0) {
        if ($_POST['claimOwner'] != $oldarchive->getVar('ownership')) {
            $oldOwner = $oldarchive->getVar('ownership');
            $archiveInfo->setVar('ownership',$_POST['claimOwner']);
            $changeOwner = true;
        }
    }
    $_mldocsSession->set('mldocs_response_ownership', $archiveInfo->getVar('ownership'));  // Store in session
    
    // Check the timespent
    if (isset($_POST['timespent'])) {
        $timespent = intval($_POST['timespent']);
        $totaltime = $oldarchive->getVar('totalTimeSpent') - $oldresponse->getVar('timeSpent') + $timespent;
        $archiveInfo->setVar('totalTimeSpent', $totaltime);
        $response->setVar('timeSpent', $timespent);
    }
    $_mldocsSession->set('mldocs_response_timespent', $response->getVar('timeSpent'));
    $_mldocsSession->set('mldocs_responseStored', true);
    
    // Perform each validation
    $fields = array();
    $errors = array();
    foreach($v as $fieldname=>$validator){
        if(!mldocsCheckRules($validator, $errors)){
            // Mark field with error
            $fields[$fieldname]['haserrors'] = true;
            $fields[$fieldname]['errors'] = $errors;
        } else {
            $fields[$fieldname]['haserrors'] = false;
        }
    }
    
    if(!empty($errors)){
        $_mldocsSession->set('mldocs_validateError', $fields);
        $message = _MLDOCS_MESSAGE_VALIDATE_ERROR;
        header("Location: ".MLDOCS_BASE_URL."/response.php?id=$archiveid&responseid=". $response->getVar('id') ."&op=staffEdit");
        exit();
    }
    
    
     $archiveInfo->setVar('lastUpdated', time());
     
     if ($hArchive->insert($archiveInfo)) {
        if ($newStatus) {
            $_eventsrv->trigger('update_status', array(&$archiveInfo, $oldStatus));
        }
        if ($archiveClosed) {
            $_eventsrv->trigger('close_archive', array(&$archiveInfo));
        }
        if ($archiveReopen) {
            $_eventsrv->trigger('reopen_archive', array(&$archiveInfo));
        }
        if ($changeOwner) {
            $_eventsrv->trigger('update_owner', array(&$archiveInfo, $oldOwner));
        }
        
        $message = $_POST['response'];
        $message .= "\n".sprintf(_MLDOCS_RESPONSE_EDIT, $xoopsUser->getVar('uname'), $archiveInfo->lastUpdated());
        
        $response->setVar('message', $message);
        if(isset($_POST['timespent'])){
            $response->setVar('timeSpent', intval($_POST['timespent']));    
        }
        $response->setVar('updateTime', $archiveInfo->getVar('lastUpdated'));
        
        if ($hResponse->insert($response)) {
            $_eventsrv->trigger('edit_response', array(&$archiveInfo, &$response, &$oldarchive, &$oldresponse));
            $message = _MLDOCS_MESSAGE_EDITRESPONSE;
            $url = "archive.php?id=$archiveid";
            $responseStored = true;
        } else {
            $message = _MLDOCS_MESSAGE_EDITRESPONSE_ERROR;
        }
    } else {
        $message = _MLDOCS_MESSAGE_EDITARCHIVE_ERROR;
    }
    _clearResponseFromSession();
    redirect_header($url, 3, $message);
    
    
    break;

    
default:
    break;
}

function _setResponseToSession(&$archive, &$errors)
{
    global $xoopsUser, $_mldocsSession;
    $_mldocsSession->set('mldocs_response_archiveid', $archive->getVar('id'));
    $_mldocsSession->set('mldocs_response_uid', $xoopsUser->getVar('uid'));
    $_mldocsSession->set('mldocs_response_message', ( isset($_POST['response']) ? $_POST['response'] : '' ) );
    $_mldocsSession->set('mldocs_response_private', ( isset($_POST['private'])? $_POST['private'] : 0 ));    
    $_mldocsSession->set('mldocs_response_timespent', ( isset($_POST['timespent']) ? $_POST['timespent'] : 0 ));
    $_mldocsSession->set('mldocs_response_ownership', ( isset($_POST['claimOwner']) && intval($_POST['claimOwner']) > 0 ? $_POST['claimOwner'] : 0) );    
    $_mldocsSession->set('mldocs_response_status',  $_POST['status'] );
    $_mldocsSession->set('mldocs_response_private', $_POST['private'] );
    $_mldocsSession->set('mldocs_validateError', $errors);
}

function _clearResponseFromSession()
{
    global $_mldocsSession;
    $_mldocsSession->del('mldocs_response_archiveid');
    $_mldocsSession->del('mldocs_response_uid');
    $_mldocsSession->del('mldocs_response_message');
    $_mldocsSession->del('mldocs_response_timespent');
    $_mldocsSession->del('mldocs_response_ownership');
    $_mldocsSession->del('mldocs_response_status');
    $_mldocsSession->del('mldocs_response_private');
    $_mldocsSession->del('mldocs_validateError');
}
?>