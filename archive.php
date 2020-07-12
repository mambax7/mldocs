<?php
//$Id: archive.php,v 0.53 2006/03/03 18:10:37 eric_juden Exp $ 
// modifs BYOOS solutions le 11 juin 2006 Gabriel
// adaptation du module à la gestion des 100 répertoires d'archivage
require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/notificationService.php');
require_once(MLDOCS_CLASS_PATH.'/logService.php');
require_once(MLDOCS_CLASS_PATH.'/staffService.php');
require_once(MLDOCS_CLASS_PATH.'/cacheService.php');

$_eventsrv->advise('update_priority', mldocs_notificationService::singleton());
$_eventsrv->advise('update_priority', mldocs_logService::singleton());
$_eventsrv->advise('update_status', mldocs_notificationService::singleton());
$_eventsrv->advise('update_status', mldocs_logService::singleton());
$_eventsrv->advise('close_archive', mldocs_staffService::singleton());
$_eventsrv->advise('close_archive', mldocs_cacheService::singleton());
$_eventsrv->advise('close_archive', mldocs_logService::singleton());
$_eventsrv->advise('close_archive', mldocs_notificationService::singleton());
$_eventsrv->advise('new_response', mldocs_logService::singleton());
$_eventsrv->advise('new_response', mldocs_notificationService::singleton());
$_eventsrv->advise('edit_archive', mldocs_notificationService::singleton());
$_eventsrv->advise('edit_archive', mldocs_logService::singleton());
$_eventsrv->advise('update_owner', mldocs_notificationService::singleton());
$_eventsrv->advise('update_owner', mldocs_logService::singleton());
$_eventsrv->advise('delete_archive', mldocs_notificationService::singleton());
$_eventsrv->advise('delete_archive', mldocs_cacheService::singleton());
$_eventsrv->advise('reopen_archive', mldocs_staffService::singleton());
$_eventsrv->advise('reopen_archive', mldocs_cacheService::singleton());
$_eventsrv->advise('reopen_archive', mldocs_logService::singleton());
$_eventsrv->advise('view_archive', mldocs_staffService::singleton());
$_eventsrv->advise('merge_archives', mldocs_logService::singleton());
$_eventsrv->advise('merge_archives', mldocs_notificationService::singleton());
$_eventsrv->advise('delete_file', mldocs_logService::singleton());

$op = "user";

// Get the id of the archive
if(isset($_REQUEST['id'])){
    $mldocs_id = intval($_REQUEST['id']);
} else {
    redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_ERROR_INV_ARCHIVE);
}

if(isset($_GET['op'])){
    $op = $_GET['op'];
}

if(!$xoopsUser){
    redirect_header(XOOPS_URL .'/user.php?xoops_redirect='.htmlspecialchars($xoopsRequestUri), 3);     
}

$xoopsVersion = substr(XOOPS_VERSION, 6);
intval($xoopsVersion);

global $archiveInfo;
$hStaff         =& mldocsGetHandler('staff');
$member_handler =& xoops_gethandler('member');
$hArchives       =& mldocsGetHandler('archive');

if(!$archiveInfo     =& $hArchives->get($mldocs_id)){
    redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_ERROR_INV_ARCHIVE);
}

$displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed

$hDepartments   =& mldocsGetHandler('department');
$departments    =& $hDepartments->getObjects(null, true);
$user           =& $member_handler->getUser($archiveInfo->getVar('uid'));
$repstr         = mldocsMakeRepstr($archiveInfo->getVar('repid'));
$hStaffReview   =& mldocsGetHandler('staffReview');
$hResponses     =& mldocsGetHandler('responses'); 
$hMembership    =& mldocsGetHandler('membership'); 
$aResponses = array();
$all_users = array();

if (isset($departments[$archiveInfo->getVar('department')])) {
    $department = $departments[$archiveInfo->getVar('department')];
}

//Security Checkpoints to ensure no funny stuff
if (!$xoopsUser) {
    redirect_header(MLDOCS_BASE_URL."/index.php", 3, _NOPERM);
    exit();
}

$op = ($isStaff ? 'staff' : $op);

$has_archiveFiles = false;
$files = $archiveInfo->getFiles();
$aFiles = array();
foreach($files as $file){
    if($file->getVar('responseid') == 0){
        $has_archiveFiles = true;
    }
    
    $filename_full = $file->getVar('filename');
    if($file->getVar('responseid') != 0){
        $removeText = $file->getVar('archiveid').$repstr."_".$file->getVar('responseid')."_";
    } else {
        $removeText = $file->getVar('archiveid').$repstr."_";
    }
    $filename = str_replace($removeText, '', $filename_full);
    $filesize = round(filesize(MLDOCS_ARCHIVE_PATH."/".$repstr."/".$filename_full)/1024, 2);
    
    $aFiles[] = array('id'=>$file->getVar('id'),
                      'filename'=>$filename,
                      'filename_full'=>$filename_full,
                      'archiveid'=>$file->getVar('archiveid'),
                      'responseid'=>$file->getVar('responseid'),
                      'path'=>'viewFile.php?id='. $file->getVar('id'),
                      'size'=>$filesize." "._MLDOCS_SIZE_KB,
                      'checksumSHA1' =>$file->getVar('checksumSHA1'));         
}
$has_files = count($files) > 0;
unset($files);
$message = '';
       
if($isStaff) {
    //** BTW - What does $giveOwnership do here?
    $giveOwnership = false;
    if(isset($_GET['op'])){
        $op = $_GET['op'];
    } else {
        $op = "staff";
    }

    //Retrieve all responses to current archive
    $responses = $archiveInfo->getResponses();
    foreach($responses as $response){
        if($has_files){
            $hasFiles = false;
            foreach($aFiles as $file){
                if($file['responseid'] == $response->getVar('id')){
                    $hasFiles = true;
                    break;
                }
            }
        } else {
            $hasFiles = false;
        }
        
        $aResponses[] = array('id'=>$response->getVar('id'),
                          'uid'=>$response->getVar('uid'),
                          'uname'=>'',
                          'archiveid'=>$response->getVar('archiveid'),
                          'message'=>$response->getVar('message'),
                          'timeSpent'=>$response->getVar('timeSpent'),
                          'updateTime'=>$response->posted('m'),
                          'userIP'=>$response->getVar('userIP'),
                          'user_sig'=>'',
                          'user_avatar' => '',
                          'attachSig'=>'',
                          'staffRating'=>'',
                          'private'=>$response->getVar('private'),
                          'hasFiles' => $hasFiles);
        $all_users[$response->getVar('uid')] = '';
    }
    
    $all_users[$archiveInfo->getVar('uid')] = '';
    $all_users[$archiveInfo->getVar('ownership')] = '';
    $all_users[$archiveInfo->getVar('closedBy')] = '';
    
    $has_responses = count($responses) > 0;
    unset($responses);
    
    
    if($owner =& $member_handler->getUser($archiveInfo->getVar('ownership'))){
        $giveOwnership = true;
    }
    
    //Retrieve all log messages from the database
    $logMessage =& $archiveInfo->getLogs();
    
    $patterns = array();
    $patterns[] = '/pri:([1-5])/';
    $replacements = array();
    $replacements = '<img src="images/priority$1.png" alt="Priority: $1" />';
    
    
    foreach($logMessage as $msg){
        $aMessages[] = array('id'=>$msg->getVar('id'),
                             'uid'=>$msg->getVar('uid'),
                             'uname'=>'',
                             //'uname'=>(($msgLoggedBy)? $msgLoggedBy->getVar('uname'):$xoopsConfig['anonymous']),
                             'archiveid'=>$msg->getVar('archiveid'),
                             'lastUpdated'=>$msg->lastUpdated('m'),
                             'action'=>preg_replace($patterns, $replacements, $msg->getVar('action')));
        $all_users[$msg->getVar('uid')] = '';
    }
    //unset($logMessage);
    
    //For assign to ownership box
    $hMembership =& mldocsGetHandler('membership');
    
    global $staff;
    $staff = $hMembership->membershipByDept($archiveInfo->getVar('department'));
    
    $aOwnership = array();
    // Only run if actions are set to inline style
    if($xoopsModuleConfig['mldocs_staffArchiveAction'] == 1){
        $aOwnership[] = array('uid' => 0,
                              'uname' => _MLDOCS_NO_OWNER);
        foreach($staff as $stf){
            if($stf->getVar('uid') != 0){
                $aOwnership[] = array('uid'=>$stf->getVar('uid'),
                                      'uname'=>'');
        	    $all_users[$stf->getVar('uid')] = '';
        	}
        }
    }
    
    // Get list of user's last submitted archives
    $crit = new CriteriaCompo(new Criteria('uid', $archiveInfo->getVar('uid')));
    $crit->setSort('posted');
    $crit->setOrder('DESC');
    $crit->setLimit(10);
    $lastArchives =& $hArchives->getObjects($crit);
    foreach($lastArchives as $archive){
        
        $dept = $archive->getVar('department');
        if (isset($departments[$dept])) {
            $dept = $departments[$dept]->getVar('department');
            $hasUrl = true;
        } else {
            $dept = _MLDOCS_TEXT_NO_DEPT;
            $hasUrl = false;
        }
	    $aLastArchives[] = array('id'=>$archive->getVar('id'),
	                            'codearchive'=>$archive->getVar('codearchive'),
	                            'subject'=>$archive->getVar('subject'),
	                            'status'=>mldocsGetStatus($archive->getVar('status')),
	                            'department'=>$dept,
	                            'dept_url'=>($hasUrl ? XOOPS_URL . '/modules/mldocs/index.php?op=staffViewAll&amp;dept=' . $archive->getVar('department') : ''),
	                            'url'=>XOOPS_URL . '/modules/mldocs/archive.php?id=' . $archive->getVar('id')); 
    }
    $has_lastArchives = count($lastArchives);
}

switch($op)
{
    case "addEmail":
        //TODO: Add email validator to make sure supplying a valid email address
    
        if($_POST['newEmail'] == ''){
            $message = _MLDOCS_MESSAGE_NO_EMAIL;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        
        if(!$newUser = mldocsEmailIsXoopsUser($_POST['newEmail'])){      // If a user doesn't exist with this email
            $user_id = 0;
        } else {
            $user_id = $newUser->getVar('uid');
        }
        
        // Check that the email doesn't already exist for this archive
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new CriteriaCompo(new Criteria('archiveid', $mldocs_id));
        $crit->add(new Criteria('email', $_POST['newEmail']));
        $existingUsers =& $hArchiveEmails->getObjects($crit);
        if(count($existingUsers) > 0){
            $message = _MLDOCS_MESSAGE_EMAIL_USED;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        
        // Create new archive email object
        $newSubmitter =& $hArchiveEmails->create();
        $newSubmitter->setVar('email', $_POST['newEmail']);
        $newSubmitter->setVar('uid', $user_id);
        $newSubmitter->setVar('archiveid', $mldocs_id);
        $newSubmitter->setVar('suppress', 0);
        if($hArchiveEmails->insert($newSubmitter)){
            $message = _MLDOCS_MESSAGE_ADDED_EMAIL;
            header("Location: ".MLDOCS_BASE_URL."/archive.php?id=$mldocs_id#emailNotification");
        } else {
            $message = _MLDOCS_MESSAGE_ADDED_EMAIL_ERROR;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id#emailNotification", 3, $message);
        }
    break;
    
    case "changeSuppress":
        if(!$isStaff){
            $message = _MLDOCS_MESSAGE_NO_MERGE_ARCHIVE;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }

        $hArchiveEmails =& mldocsGetHandler('archiveEmails');        
        $crit = new CriteriaCompo(new Criteria('archiveid', $_GET['id']));
        $crit->add(new Criteria('email', $_GET['email']));
        $suppressUser =& $hArchiveEmails->getObjects($crit);
        
        foreach($suppressUser as $sUser){
            if($sUser->getVar('suppress') == 0){
                $sUser->setVar('suppress', 1);
            } else {
                $sUser->setVar('suppress', 0);
            }
            if(!$hArchiveEmails->insert($sUser, true)){
                $message = _MLDOCS_MESSAGE_ADD_EMAIL_ERROR;
                redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id#emailNotification", 3, $message);
            }
        }
        header("Location: ".MLDOCS_BASE_URL."/archive.php?id=$mldocs_id#emailNotification");
    break;
    
    case "delete":
        if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_DELETE, $archiveInfo->getVar('department'))){
            $message = _MLDOCS_MESSAGE_NO_DELETE_ARCHIVE;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        if(isset($_POST['delete_archive'])){
            if($hArchives->delete($archiveInfo)){
                $message = _MLDOCS_MESSAGE_DELETE_ARCHIVE;
                $_eventsrv->trigger('delete_archive', array(&$archiveInfo));
            } else {
                $message = _MLDOCS_MESSAGE_DELETE_ARCHIVE_ERROR;
            }
        } else {
            $message = _MLDOCS_MESSAGE_DELETE_ARCHIVE_ERROR;
        }
        redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
    break;
    
    case "edit":
        if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_EDIT, $archiveInfo->getVar('department'))){
            $message = _MLDOCS_MESSAGE_NO_EDIT_ARCHIVE;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        $hDepartments  =& mldocsGetHandler('department');    // Department handler
        $custFields =& $archiveInfo->getCustFieldValues(true);
        
        if(!isset($_POST['editArchive'])){
            $xoopsOption['template_main'] = 'mldocs_editArchive.html';             // Always set main template before including the header
            require(XOOPS_ROOT_PATH . '/header.php');
            
            $crit = new Criteria('','');
            $crit->setSort('department');
            $departments =& $hDepartments->getObjects($crit);
            $hStaff =& mldocsGetHandler('staff'); 
            
            foreach($departments as $dept){
                $aDept[] = array('id'=>$dept->getVar('id'),
                                 'department'=>$dept->getVar('department'));
            }
                        
            // Form validation stuff
            $errors = array();
            $aElements = array();
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
            
            $elements = array('subject', 'description');
            foreach($elements as $element){         // Foreach element in the predefined list
                $xoopsTpl->assign("mldocs_element_$element", "formButton");
                foreach($aElements as $aElement){   // Foreach that has an error
                    if($aElement == $element){      // If the names are equal
                        $xoopsTpl->assign("mldocs_element_$element", "validateError");
                        break;
                    }
                }
            } 
            // end form validation stuff
            
            $javascript = "<script type=\"text/javascript\" src=\"". MLDOCS_BASE_URL ."/include/functions.js\"></script>
<script type=\"text/javascript\" src='".MLDOCS_SCRIPT_URL."/addArchiveDeptChange.php?client'></script>
<script type=\"text/javascript\">
<!--
function departments_onchange() 
{
    dept = xoopsGetElementById('departments');
    var wl = new mldocsweblib(fieldHandler);
    wl.customfieldsbydept(dept.value);
}

var fieldHandler = {
    customfieldsbydept: function(result){
        
        var tbl = gE('tblEditArchive');
        var staffCol = gE('staff');";
        $javascript.="var beforeele = gE('editButtons');\n";
        $javascript.="tbody = tbl.tBodies[0];\n";
        $javascript .="mldocsFillCustomFlds(tbody, result, beforeele);\n
    }
}

function window_onload()
{
    mldocsDOMAddEvent(xoopsGetElementById('departments'), 'change', departments_onchange, true);
}

mldocsDOMAddEvent(window, 'load', window_onload, true);
//-->
</script>";      
            if ($archive =& $_mldocsSession->get('mldocs_archive')) {
                $xoopsTpl->assign('mldocs_archiveID', $mldocs_id);
                $xoopsTpl->assign('mldocs_archive_codearchive', $archive['codearchive']);
                $xoopsTpl->assign('mldocs_archive_subject', $archive['subject']);
                $xoopsTpl->assign('mldocs_archive_description', $archive['description']);
                $xoopsTpl->assign('mldocs_archive_department', $archive['department']);
                $xoopsTpl->assign('mldocs_departmenturl', 'index.php?op=staffViewAll&amp;dept='. $archive['department']);
                $xoopsTpl->assign('mldocs_archive_priority', $archive['priority']);
            } else {
                $xoopsTpl->assign('mldocs_archiveID', $mldocs_id);
                $xoopsTpl->assign('mldocs_archive_codearchive', $archiveInfo->getVar('codearchive'));
                $xoopsTpl->assign('mldocs_archive_subject', $archiveInfo->getVar('subject'));
                $xoopsTpl->assign('mldocs_archive_description', $archiveInfo->getVar('description', 'e'));
                $xoopsTpl->assign('mldocs_archive_department', $archiveInfo->getVar('department'));
                $xoopsTpl->assign('mldocs_departmenturl', 'index.php?op=staffViewAll&amp;dept='. $archiveInfo->getVar('department'));
                $xoopsTpl->assign('mldocs_archive_priority', $archiveInfo->getVar('priority'));
            }
                                             
            //** BTW - why do we need mldocs_allowUpload in the template if it will be always set to 0?
            //$xoopsTpl->assign('mldocs_allowUpload', $xoopsModuleConfig['mldocs_allowUpload']);
            $xoopsTpl->assign('mldocs_allowUpload', 0);
            $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL . '/modules/mldocs/images/');
            $xoopsTpl->assign('mldocs_departments', $aDept);
            $xoopsTpl->assign('mldocs_priorities', array(5,4,3,2,1));
            $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));
            
            if(isset($_POST['logFor'])){
                $uid = $_POST['logFor'];
                $username = mldocsGetUsername($uid, $displayName);
                $xoopsTpl->assign('mldocs_username', $username);
                $xoopsTpl->assign('mldocs_user_id', $uid);
            } else {
                $xoopsTpl->assign('mldocs_username', mldocsGetUsername($xoopsUser->getVar('uid'), $displayName));
                $xoopsTpl->assign('mldocs_user_id', $xoopsUser->getVar('uid'));
            }
            // Used for displaying transparent-background images in IE
            $xoopsTpl->assign('xoops_module_header',$javascript . $mldocs_module_header);
            $xoopsTpl->assign('mldocs_isStaff', $isStaff);
            
            if ($savedFields =& $_mldocsSession->get('mldocs_custFields')) {
                $custFields = $savedFields;
            }                
            $xoopsTpl->assign('mldocs_hasCustFields', (!empty($custFields)) ? true : false);
            $xoopsTpl->assign('mldocs_custFields', $custFields);
            $xoopsTpl->assign('mldocs_uploadPath', MLDOCS_ARCHIVE_PATH);
            $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
            
            require(XOOPS_ROOT_PATH.'/footer.php');
        } else {
            require_once(MLDOCS_CLASS_PATH.'/validator.php');
            
            $v = array();
            $v['subject'][] = new ValidateLength($_POST['subject'], 2, 100);
            $v['description'][] = new ValidateLength($_POST['description'], 2, 50000);
            
            $aFields = array();
            foreach($custFields as $field){
                $fieldname = $field['fieldname'];
                $value = $_POST[$fieldname];
                
                $fileid = '';
                $filename = '';
                $file = '';
                if($field['controltype'] == MLDOCS_CONTROL_FILE){
                    $file = split("_", $value);
                    $fileid = ((isset($file[0]) && $file[0] != "") ? $file[0] : "");
                    $filename = ((isset($file[1]) && $file[1] != "") ? $file[1] : "");
                }
                
                if($field['validation'] != ""){
                    $v[$fieldname][] = new ValidateRegex($_POST[$fieldname], $field['validation'], $field['required']);
                }
                
                $aFields[$field['fieldname']] = 
                    array('id' => $field['id'],
                          'name' => $field['name'],
                          'description' => $field['description'],
                          'fieldname' => $field['fieldname'],
                          'controltype' => $field['controltype'],
                          'datatype' => $field['datatype'],
                          'required' => $field['required'],
                          'fieldlength' => $field['fieldlength'],
                          'weight' => $field['weight'],
                          'fieldvalues' => $field['fieldvalues'],
                          'defaultvalue' => $field['defaultvalue'],
                          'validation' => $field['validation'],
                          'value' => $value,
                          'fileid' => $fileid,
                          'filename' => $filename
                         );
            }
            unset($custFields);
            
            $_mldocsSession->set('mldocs_custFields', $aFields);
            $_mldocsSession->set('mldocs_archive', 
            array('subject' => $_POST['subject'],
                  'description' => htmlspecialchars($_POST['description'], ENT_QUOTES),
                  'department' => $_POST['departments'],
                  'priority' => $_POST['priority']));
                  
            // Perform each validation
            $fields = array();
            $errors = array();
            foreach($v as $fieldname=>$validator) {
                if (!mldocsCheckRules($validator, $errors)) {
                    //Mark field with error
                    $fields[$fieldname]['haserrors'] = true;
                    $fields[$fieldname]['errors'] = $errors;
                } else {
                    $fields[$fieldname]['haserrors'] = false;
                }
            }  
    
            if(!empty($errors)){
                $_mldocsSession->set('mldocs_validateError', $fields);
                $message = _MLDOCS_MESSAGE_VALIDATE_ERROR;
                header("Location: ".MLDOCS_BASE_URL."/archive.php?id=$mldocs_id&op=edit");
                exit();
            }
            
            $oldArchive = array('id'=>$archiveInfo->getVar('id'),
                              'codearchive'=>$archiveInfo->getVar('codearchive', 'n'),
                               'subject'=>$archiveInfo->getVar('subject', 'n'),
                               'description'=>$archiveInfo->getVar('description', 'n'),
                               'priority'=>$archiveInfo->getVar('priority'),
                               'status'=>mldocsGetStatus($archiveInfo->getVar('status')),
                               'department'=>$department->getVar('department'),
                               'department_id'=>$department->getVar('id'));
            
            // Change archive info to new info
            $archiveInfo->setVar('codearchive', $_POST['codearchive']);
            $archiveInfo->setVar('subject', $_POST['subject']);
            $archiveInfo->setVar('description', $_POST['description']);
            $archiveInfo->setVar('department', $_POST['departments']);
            $archiveInfo->setVar('priority', $_POST['priority']);
            $archiveInfo->setVar('posted', time());

            if($hArchives->insert($archiveInfo)){
                $_eventsrv->trigger('edit_archive', array(&$oldArchive, &$archiveInfo));
                $message = _MLDOCS_MESSAGE_EDITARCHIVE;     // Successfully updated archive
                
                // Update custom fields
                $hArchiveValues = mldocsGetHandler('archiveValues');
                $archiveValues = $hArchiveValues->get($mldocs_id);
                
                if(is_object($archiveValues)){
                    foreach($aFields as $field){
                        $archiveValues->setVar($field['fieldname'], $_POST[$field['fieldname']]);
                    }
                
                    if(!$hArchiveValues->insert($archiveValues)){
                        $message = _MLDOCS_MESSAGE_NO_CUSTFLD_ADDED;
                    }
                }
                
                $_mldocsSession->del('mldocs_archive');
                $_mldocsSession->del('mldocs_validateError');
                $_mldocsSession->del('mldocs_custFields');
            } else {
                $message = _MLDOCS_MESSAGE_EDITARCHIVE_ERROR . $archiveInfo->getHtmlErrors();     // Unsuccessfully updated archive
            }
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
    break;
    
    case "merge":
        if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_MERGE, $archiveInfo->getVar('department'))){
            $message = _MLDOCS_MESSAGE_NO_MERGE;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        if($_POST['archive2'] == ''){
            $message = _MLDOCS_MESSAGE_NO_ARCHIVE2;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        
        $archive2_id = intval($_POST['archive2']);
        if($newArchive = $archiveInfo->merge($archive2_id)){
            $returnArchive = $newArchive;
            $message = _MLDOCS_MESSAGE_MERGE;
            $_eventsrv->trigger('merge_archives', array($mldocs_id, $archive2_id, $returnArchive));
        } else {
            $returnArchive = $mldocs_id;
            $message = _MLDOCS_MESSAGE_MERGE_ERROR;
        }
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=$returnArchive", 3, $message);
        
    break;
    
    case "ownership":
        if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_OWNERSHIP, $archiveInfo->getVar('department'))){
            $message = _MLDOCS_MESSAGE_NO_CHANGE_OWNER;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
            
        if(isset($_POST['uid'])){
            $uid = intval($_POST['uid']);
        } else {
            $message = _MLDOCS_MESSAGE_NO_UID;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        if($archiveInfo->getVar('ownership') <> 0){
            $oldOwner = $archiveInfo->getVar('ownership');
        } else {
            $oldOwner = _MLDOCS_NO_OWNER;
        }
        
        $archiveInfo->setVar('ownership', $uid);
        $archiveInfo->setVar('lastUpdated', time());
        if($hArchives->insert($archiveInfo)){
            $_eventsrv->trigger('update_owner', array(&$archiveInfo, $oldOwner));
            $message = _MLDOCS_MESSAGE_UPDATE_OWNER; 
        }
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        
    break;
        
    case "print":
        $config_handler =& xoops_gethandler('config');
	    $xoopsConfigMetaFooter =& $config_handler->getConfigsByCat(XOOPS_CONF_METAFOOTER);
	    
        $patterns = array();
        $patterns[] = '/pri:([1-5])/';
        $replacements = array();
        $replacements = '<img src="images/priority$1print.png" />';
        
        foreach($logMessage as $msg){
            $msgLoggedBy =& $member_handler->getUser($msg->getVar('uid'));
            $aPrintMessages[] = array('id'=>$msg->getVar('id'),
                                 'uid'=>$msg->getVar('uid'),
                                 'uname'=>mldocsGetUsername($msgLoggedBy->getVar('uid'), $displayName),
                                 'archiveid'=>$msg->getVar('archiveid'),
                                 'lastUpdated'=>$msg->lastUpdated('m'),
                                 'action'=>preg_replace($patterns, $replacements, $msg->getVar('action')));
            $all_users[$msg->getVar('uid')] = '';
        }
        unset($logMessage);
        
        require_once XOOPS_ROOT_PATH.'/class/template.php';
        $xoopsTpl = new XoopsTpl();
        $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL .'/modules/mldocs/images/');
        $xoopsTpl->assign('mldocs_lang_userlookup', 'User Lookup');
        $xoopsTpl->assign('sitename', $xoopsConfig['sitename']);
        $xoopsTpl->assign('xoops_themecss', xoops_getcss());
        $xoopsTpl->assign('xoops_url', XOOPS_URL);
        $xoopsTpl->assign('mldocs_print_logMessages', $aPrintMessages);
        $xoopsTpl->assign('mldocs_archive_codearchive', $archiveInfo->getVar('codearchive'));
        $xoopsTpl->assign('mldocs_archive_subject', $archiveInfo->getVar('subject'));
        $xoopsTpl->assign('mldocs_archive_description', $archiveInfo->getVar('description'));
        $xoopsTpl->assign('mldocs_archive_department', $department->getVar('department'));
        $xoopsTpl->assign('mldocs_archive_priority', $archiveInfo->getVar('priority'));
        $xoopsTpl->assign('mldocs_archive_status', mldocsGetStatus($archiveInfo->getVar('status')));
        $xoopsTpl->assign('mldocs_archive_lastUpdated', $archiveInfo->lastUpdated('m'));
        $xoopsTpl->assign('mldocs_archive_posted', $archiveInfo->posted('m'));
        if($giveOwnership){
            $xoopsTpl->assign('mldocs_archive_ownerUid', $owner->getVar('uid'));
            $xoopsTpl->assign('mldocs_archive_ownership', mldocsGetUsername($owner, $displayName));
            $xoopsTpl->assign('mldocs_ownerinfo', XOOPS_URL . '/userinfo.php?uid=' . $owner->getVar('uid'));
        }
        $xoopsTpl->assign('mldocs_archive_closedBy', $archiveInfo->getVar('closedBy'));
        $xoopsTpl->assign('mldocs_archive_totalTimeSpent', $archiveInfo->getVar('totalTimeSpent'));
        $xoopsTpl->assign('mldocs_userinfo', XOOPS_URL . '/userinfo.php?uid=' . $archiveInfo->getVar('uid'));        
        $xoopsTpl->assign('mldocs_username', mldocsGetUsername($user, $displayName));
        $xoopsTpl->assign('mldocs_archive_details', sprintf(_MLDOCS_TEXT_ARCHIVEDETAILS, $mldocs_id));
        
        $custFields =& $archiveInfo->getCustFieldValues();
        $xoopsTpl->assign('mldocs_hasCustFields', (!empty($custFields)) ? true : false);
        $xoopsTpl->assign('mldocs_custFields', $custFields);

        if(isset($aMessages)){
            $xoopsTpl->assign('mldocs_logMessages', $aMessages);
        } else {
            $xoopsTpl->assign('mldocs_logMessages', 0);
        }
        $xoopsTpl->assign('mldocs_text_claimOwner', _MLDOCS_TEXT_CLAIM_OWNER);
        $xoopsTpl->assign('mldocs_aOwnership', $aOwnership);
        
        if($has_responses){
            $users = array(); 
            $_users = $member_handler->getUsers(new Criteria('uid', '('. implode(array_keys($all_users), ',') . ')', 'IN'), true);
            foreach ($_users as $key=>$_user) {
                if (($displayName == 2) && ($_user->getVar('name') <> '')) {
                    $users[$_user->getVar('uid')] = array('uname' => $_user->getVar('name'));
                } else {
                    $users[$_user->getVar('uid')] = array('uname' => $_user->getVar('uname'));
                }
            }
            unset($_users);
            
                    
            $myTs =& MyTextSanitizer::getInstance();
            //Update arrays with user information
            if(count($aResponses) > 0){
                for($i=0;$i<count($aResponses);$i++) {
                    if(isset($users[$aResponses[$i]['uid']])){      // Add uname to array
                        $aResponses[$i]['uname'] = $users[$aResponses[$i]['uid']]['uname'];
                    } else {
                        $aResponses[$i]['uname'] = $xoopsConfig['anonymous'];
                    }
                }
            }
            $xoopsTpl->assign('mldocs_aResponses', $aResponses);
        } else {
            $xoopsTpl->assign('mldocs_aResponses', 0);
        }
        $xoopsTpl->assign('mldocs_claimOwner', $xoopsUser->getVar('uid'));
        $xoopsTpl->assign('mldocs_hasResponses', $has_responses);
        $xoopsTpl->assign('xoops_meta_robots', $xoopsConfigMetaFooter['meta_robots']);
        $xoopsTpl->assign('xoops_meta_keywords', $xoopsConfigMetaFooter['meta_keywords']);
        $xoopsTpl->assign('xoops_meta_description', $xoopsConfigMetaFooter['meta_description']);
        $xoopsTpl->assign('xoops_meta_rating', $xoopsConfigMetaFooter['meta_rating']);
        $xoopsTpl->assign('xoops_meta_author', $xoopsConfigMetaFooter['meta_author']);
        $xoopsTpl->assign('xoops_meta_copyright', $xoopsConfigMetaFooter['meta_copyright']);

        $module_dir = $xoopsModule->getVar('mid');
        $xoopsTpl->display('db:mldocs_print.html');
        exit();
    break;
    
    case "updatePriority":
        if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_ADD)){
            $message = _MLDOCS_MESSAGE_NO_ADD_ARCHIVE;
            redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
        }
        
        if(isset($_POST['priority'])){
            $priority = $_POST['priority'];
        } else {
            $message = _MLDOCS_MESSAGE_NO_PRIORITY;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        $oldPriority = $archiveInfo->getVar('priority');
        $archiveInfo->setVar('priority', $priority);
        $archiveInfo->setVar('lastUpdated', time());
        if($hArchives->insert($archiveInfo)){
            $_eventsrv->trigger('update_priority', array(&$archiveInfo, $oldPriority));
            $message = _MLDOCS_MESSAGE_UPDATE_PRIORITY; 
        } else {
            $message = _MLDOCS_MESSAGE_UPDATE_PRIORITY_ERROR .". ";
        }
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
    break;
    
    case "updateStatus":
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new CriteriaCompo(new Criteria('archiveid', $mldocs_id));
        $crit->add(new Criteria('uid', $xoopsUser->getVar('uid')));
        $archiveEmails =& $hArchiveEmails->getObjects($crit);
		if(count($archiveEmails > 0) || $mldocs_staff->checkRoleRights(_MLDOCS_SEC_RESPONSE_ADD, $archiveInfo->getVar('department'))){
            if($_POST['response'] <> ''){
                $userIP     = getenv("REMOTE_ADDR");
                $newResponse =& $archiveInfo->addResponse($xoopsUser->getVar('uid'), $mldocs_id, $_POST['response'], 
                $archiveInfo->getVar('lastUpdated'), $userIP, 0, 0, true);
                        
                if(is_object($newResponse)){
                    $_eventsrv->trigger('new_response', array(&$archiveInfo, &$newResponse));
                    $message = _MLDOCS_MESSAGE_ADDRESPONSE;
                }
                else
                	$message = _MLDOCS_MESSAGE_ADDRESPONSE_ERROR;
        	$message .= '<br />';
            }
        }

        if(count($archiveEmails > 0) || $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_STATUS, $archiveInfo->getVar('department'))){
            $archive_close = $archive_reopen = false;
            $hStatus =& mldocsGetHandler('status');
            $hStaff =& mldocsGetHandler('staff');
            if($_POST['status'] != $archiveInfo->getVar('status')){  
                $oldStatus =& $hStatus->get($archiveInfo->getVar('status'));
                $archiveInfo->setVar('status', $_POST['status']);
                $archiveInfo->setVar('lastUpdated', time());
                
                // TODO: Change this to look for resolved archives
                // Retrieve status object using $_POST['status']
                $newStatus =& $hStatus->get(intval($_POST['status']));
                
                if($newStatus->getVar('state') == 2){    // RESOLVED
                    $archiveInfo->setVar('closedBy', $xoopsUser->getVar('uid'));     // Update closedBy field in Archive table
                    $archive_close = true;
                } elseif($oldStatus->getVar('state') == 2 && $newStatus->getVar('state') == 1){
                    $archive_reopen = true;
                    $archiveInfo->setVar('overdueTime', $archiveInfo->getVar('posted') + ($xoopsModuleConfig['mldocs_overdueTime'] *60*60));
                }
                
                if($hArchives->insert($archiveInfo, true)){
                    if ($archive_close) {
                        $_eventsrv->trigger('close_archive', array(&$archiveInfo)); 
                    } elseif($archive_reopen) {
                        $_eventsrv->trigger('reopen_archive', array(&$archiveInfo));
                    } else {
                        $_eventsrv->trigger('update_status', array(&$archiveInfo, &$oldStatus, &$newStatus));
                    }
                    $message .= _MLDOCS_MESSAGE_UPDATE_STATUS;
                } else {
                    $message .= _MLDOCS_MESSAGE_UPDATE_STATUS_ERROR .". ";
                } 
            } 
         } else {
            $message .= _MLDOCS_MESSAGE_NO_CHANGE_STATUS;
        }     
        redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
    break;
    
    case "staff":
        $hStatus =& mldocsGetHandler('status');
        $_eventsrv->trigger('view_archive', array(&$archiveInfo));
        $xoopsOption['template_main'] = 'mldocs_staff_archiveDetails.html';   // Set template
        require(XOOPS_ROOT_PATH.'/header.php');                     // Include
        
        //TODO: Wrap this into a class/function
        $xoopsDB =& Database::getInstance();
        $users = array();     
        $_users = $member_handler->getUsers(new Criteria('uid', "(". implode(array_keys($all_users), ',') . ")", 'IN'), true);
        foreach ($_users as $key=>$_user) {
            if (($displayName == 2) && ($_user->getVar('name') <> '')) {
                $users[$key] = array('uname' => $_user->getVar('name'),
                                'user_sig' => $_user->getVar('user_sig'),
                                'user_avatar' => $_user->getVar('user_avatar'));
            } else {
                $users[$key] = array('uname' => $_user->getVar('uname'),
                                'user_sig' => $_user->getVar('user_sig'),
                                'user_avatar' => $_user->getVar('user_avatar'));
              }
          }
 
        $crit = new Criteria('','');
        $crit->setSort('department');
        $alldepts = $hDepartments->getObjects($crit);
        foreach($alldepts as $dept){
            $aDept[$dept->getVar('id')] = $dept->getVar('department');
        }
        unset($_users);            
        $staff = array();       
        $_staff = $hStaff->getObjects(new Criteria('uid', "(". implode(array_keys($all_users), ',') . ")", 'IN'), true);
        foreach($_staff as $key=>$_user) {
            $staff[$key] = $_user->getVar('attachSig');
        }
        unset($_staff);
        $staffReviews =& $archiveInfo->getReviews();
    
        $myTs =& MyTextSanitizer::getInstance();
        //Update arrays with user information
        if(count($aResponses) > 0){
            for($i=0;$i<count($aResponses);$i++) {
            	if(isset($users[$aResponses[$i]['uid']])){      // Add uname to array
                $aResponses[$i]['uname'] = $users[$aResponses[$i]['uid']]['uname'];
                    $aResponses[$i]['user_sig'] = $myTs->displayTarea($users[$aResponses[$i]['uid']]['user_sig'], true);
                    $aResponses[$i]['user_avatar'] = XOOPS_URL .'/uploads/' . ($users[$aResponses[$i]['uid']]['user_avatar'] ? $users[$aResponses[$i]['uid']]['user_avatar'] : 'blank.gif');
                } else {
                    $aResponses[$i]['uname'] = $xoopsConfig['anonymous'];
                }
                $aResponses[$i]['staffRating'] = _MLDOCS_RATING0;
                
                if(isset($staff[$aResponses[$i]['uid']])){       // Add attachSig to array
                    $aResponses[$i]['attachSig'] = $staff[$aResponses[$i]['uid']];
                }
                
                if(count($staffReviews) > 0){                   // Add staffRating to array
                    foreach($staffReviews as $review){
                        if($aResponses[$i]['id'] == $review->getVar('responseid')){
                            $aResponses[$i]['staffRating'] = mldocsGetRating($review->getVar('rating'));
                        }
                    }
                }
            }
        }
        
        for($i=0;$i<count($aMessages);$i++){        // Fill other values for log messages
            if(isset($users[$aMessages[$i]['uid']])){
                $aMessages[$i]['uname'] = $users[$aMessages[$i]['uid']]['uname'];
            } else {
                $aMessages[$i]['uname'] = $xoopsConfig['anonymous'];
            }
        }
        
        if($xoopsModuleConfig['mldocs_staffArchiveAction'] == 1){
            for($i=0;$i<count($aOwnership);$i++){
                if(isset($users[$aOwnership[$i]['uid']])){
                    $aOwnership[$i]['uname'] = $users[$aOwnership[$i]['uid']]['uname'];
                }
            }
        }
        
        // Get list of users notified of changes to archive
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new Criteria('archiveid', $mldocs_id);
        $crit->setOrder('ASC');
        $crit->setSort('email');
        $notifiedUsers =& $hArchiveEmails->getObjects($crit);
        $aNotified = array();
        foreach($notifiedUsers as $nUser){
            $aNotified[] = array('email' => $nUser->getVar('email'),
                                 'suppress' => $nUser->getVar('suppress'),
                                 'suppressUrl' => XOOPS_URL."/modules/mldocs/archive.php?id=$mldocs_id&amp;op=changeSuppress&amp;email=".$nUser->getVar('email'));
        }
        
        $uid = $xoopsUser->getVar('uid');
        $xoopsTpl->assign('mldocs_uid', $uid);

        // Smarty variables
        $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
        $xoopsTpl->assign('mldocs_allowUpload', $xoopsModuleConfig['mldocs_allowUpload']);
        $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL .'/modules/mldocs/images/');
        $xoopsTpl->assign('xoops_module_header',$mldocs_module_header);
        $xoopsTpl->assign('mldocs_archiveID', $mldocs_id);
        $xoopsTpl->assign('mldocs_archive_uid', $archiveInfo->getVar('uid'));
        $submitUser =& $member_handler->getUser($archiveInfo->getVar('uid'));
        $xoopsTpl->assign('mldocs_user_avatar', XOOPS_URL .'/uploads/' .(($submitUser && $submitUser->getVar('user_avatar') != "")?$submitUser->getVar('user_avatar') : 'blank.gif'));
        $xoopsTpl->assign('mldocs_archive_codearchive', $archiveInfo->getVar('codearchive', 's'));
        $xoopsTpl->assign('mldocs_archive_subject', $archiveInfo->getVar('subject', 's'));
        $xoopsTpl->assign('mldocs_archive_description', $archiveInfo->getVar('description'));
        $xoopsTpl->assign('mldocs_archive_department', (isset($departments[$archiveInfo->getVar('department')]) ? $departments[$archiveInfo->getVar('department')]->getVar('department') : _MLDOCS_TEXT_NO_DEPT));
        $xoopsTpl->assign('mldocs_departmenturl', 'index.php?op=staffViewAll&amp;dept='. $archiveInfo->getVar('department'));
 		$xoopsTpl->assign('mldocs_departmentid', $archiveInfo->getVar('department'));
        $xoopsTpl->assign('mldocs_departments', $aDept);
 		$xoopsTpl->assign('mldocs_archive_priority', $archiveInfo->getVar('priority'));
        $xoopsTpl->assign('mldocs_archive_status', $archiveInfo->getVar('status'));
        $xoopsTpl->assign('mldocs_text_status', mldocsGetStatus($archiveInfo->getVar('status')));
        $xoopsTpl->assign('mldocs_archive_userIP', $archiveInfo->getVar('userIP'));
        $xoopsTpl->assign('mldocs_archive_lastUpdated', $archiveInfo->lastUpdated('m'));
        $xoopsTpl->assign('mldocs_priorities', array(5, 4, 3, 2, 1));
        $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));
        $xoopsTpl->assign('mldocs_archive_posted', $archiveInfo->posted('m'));
        if($giveOwnership){
            $xoopsTpl->assign('mldocs_archive_ownerUid', $owner->getVar('uid'));
            $xoopsTpl->assign('mldocs_archive_ownership', mldocsGetUsername($owner, $displayName));
            $xoopsTpl->assign('mldocs_ownerinfo', XOOPS_URL . '/userinfo.php?uid=' . $owner->getVar('uid'));
        }
        $xoopsTpl->assign('mldocs_archive_closedBy', $archiveInfo->getVar('closedBy'));
        $xoopsTpl->assign('mldocs_archive_totalTimeSpent', $archiveInfo->getVar('totalTimeSpent'));
        $xoopsTpl->assign('mldocs_userinfo', XOOPS_URL . '/userinfo.php?uid=' . $archiveInfo->getVar('uid')); 
        $xoopsTpl->assign('mldocs_username', (($user)?mldocsGetUsername($user, $displayName):$xoopsConfig['anonymous']));
        $xoopsTpl->assign('mldocs_userlevel', (($user)?$user->getVar('level'):0));
        $xoopsTpl->assign('mldocs_email', (($user)?$user->getVar('email'):''));
        $xoopsTpl->assign('mldocs_archive_details', sprintf(_MLDOCS_TEXT_ARCHIVEDETAILS, $mldocs_id));
        $xoopsTpl->assign('mldocs_notifiedUsers', $aNotified);
        $xoopsTpl->assign('mldocs_savedSearches', $aSavedSearches);

        if(isset($aMessages)){
            $xoopsTpl->assign('mldocs_logMessages', $aMessages);
        } else {
            $xoopsTpl->assign('mldocs_logMessages', 0);
        }
        $xoopsTpl->assign('mldocs_aOwnership', $aOwnership);
        if($has_responses){
            $xoopsTpl->assign('mldocs_aResponses', $aResponses);
        }
        if($has_files){
            $xoopsTpl->assign('mldocs_aFiles', $aFiles);
            $xoopsTpl->assign('mldocs_hasArchiveFiles', $has_archiveFiles);
            
        } else {
            $xoopsTpl->assign('mldocs_aFiles', false);
            $xoopsTpl->assign('mldocs_hasArchiveFiles', false);
        }
        $xoopsTpl->assign('mldocs_claimOwner', $xoopsUser->getVar('uid'));
        $xoopsTpl->assign('mldocs_hasResponses', $has_responses);
        $xoopsTpl->assign('mldocs_hasFiles', $has_files);
        $xoopsTpl->assign('mldocs_hasArchiveFiles', $has_archiveFiles);
        $xoopsTpl->assign('mldocs_filePath', MLDOCS_ARCHIVE_PATH);
        $module_dir = $xoopsModule->getVar('mid');
        $xoopsTpl->assign('mldocs_admin', $xoopsUser->isAdmin($module_dir));
        $xoopsTpl->assign('mldocs_has_lastSubmitted', $has_lastArchives);
        $xoopsTpl->assign('mldocs_lastSubmitted', $aLastArchives);
        $xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' - ' . $archiveInfo->getVar('subject'));
        $xoopsTpl->assign('mldocs_showActions', $xoopsModuleConfig['mldocs_staffArchiveAction']);
        
        $xoopsTpl->assign('mldocs_has_changeOwner', false);
        if($archiveInfo->getVar('uid') == $xoopsUser->getVar('uid')){
            $xoopsTpl->assign('mldocs_has_addResponse', true);
        } else {
            $xoopsTpl->assign('mldocs_has_addResponse', false);
        }
        $xoopsTpl->assign('mldocs_has_editArchive', false);
        $xoopsTpl->assign('mldocs_has_deleteArchive', false);
        $xoopsTpl->assign('mldocs_has_changePriority', false);
        $xoopsTpl->assign('mldocs_has_changeStatus', false);
        $xoopsTpl->assign('mldocs_has_editResponse', false);
        $xoopsTpl->assign('mldocs_has_mergeArchive', false);
        $colspan = 5;
        
        $checkRights = array(
            _MLDOCS_SEC_ARCHIVE_OWNERSHIP => array('mldocs_has_changeOwner', false),
            _MLDOCS_SEC_RESPONSE_ADD => array('mldocs_has_addResponse', true),
            _MLDOCS_SEC_ARCHIVE_EDIT => array('mldocs_has_editArchive', true),
            _MLDOCS_SEC_ARCHIVE_DELETE => array('mldocs_has_deleteArchive', true),
            _MLDOCS_SEC_ARCHIVE_MERGE => array('mldocs_has_mergeArchive', true),
            _MLDOCS_SEC_ARCHIVE_PRIORITY => array('mldocs_has_changePriority', true),
            _MLDOCS_SEC_ARCHIVE_STATUS => array('mldocs_has_changeStatus', false),
            _MLDOCS_SEC_RESPONSE_EDIT => array('mldocs_has_editResponse', false),
            _MLDOCS_SEC_FILE_DELETE => array('mldocs_has_deleteFile', false));
        
        // See if this user is accepted for this archive
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new CriteriaCompo(new Criteria('archiveid', $mldocs_id));
        $crit->add(new Criteria('uid', $xoopsUser->getVar('uid')));
        $archiveEmails =& $hArchiveEmails->getObjects($crit);
        
        foreach ($checkRights as $right=>$desc) {
            if(($right == _MLDOCS_SEC_RESPONSE_ADD) && (count($archiveEmails) > 0)){
                //Is this user in the archive emails list (should be treated as a user)
                $xoopsTpl->assign($desc[0], true);
                $colspan ++;
                continue;
            }
            if(($right == _MLDOCS_SEC_ARCHIVE_STATUS) && count($archiveEmails > 0)){
                //Is this user in the archive emails list (should be treated as a user)
                $xoopsTpl->assign($desc[0], true);
                $colspan ++;
                continue;
            }
            if ($hasRights = $mldocs_staff->checkRoleRights($right, $archiveInfo->getVar('department'))) {
                $xoopsTpl->assign($desc[0], true);
            } else {
                if ($desc[1]) {
                    $colspan --;
                }
                
            }
            
        }
        $xoopsTpl->assign('mldocs_actions_colspan', $colspan);
        
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
        
        $custFields =& $archiveInfo->getCustFieldValues();
        $xoopsTpl->assign('mldocs_hasCustFields', (!empty($custFields)) ? true : false);
        $xoopsTpl->assign('mldocs_custFields', $custFields);
        $xoopsTpl->assign('mldocs_uploadPath', MLDOCS_ARCHIVE_PATH);
        
        require(XOOPS_ROOT_PATH.'/footer.php'); 
    break;
    
    case "user":
        // Check if user has permission to view archive
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new CriteriaCompo(new Criteria('archiveid', $mldocs_id));
        $crit->add(new Criteria('uid', $xoopsUser->getVar('uid')));
        $archiveEmails =& $hArchiveEmails->getObjects($crit);
        if(count($archiveEmails) == 0){
            redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_ERROR_INV_USER);
        }
    
        $xoopsOption['template_main'] = 'mldocs_user_archiveDetails.html';   // Set template
        require(XOOPS_ROOT_PATH.'/header.php');                     // Include
        $responses = $archiveInfo->getResponses();
        foreach($responses as $response){
            $hasFiles = false;
            foreach($aFiles as $file){
                if($file['responseid'] == $response->getVar('id')){
                    $hasFiles = true;
                    break;
                }
            }
            
            $staffReview =& $hStaffReview->getReview($mldocs_id, $response->getVar('id'), $xoopsUser->getVar('uid'));
            if (count($staffReview) > 0) {
                $review = $staffReview[0];
            }
            $responseOwner =& $member_handler->getUser($response->getVar('uid'));
            
            $aResponses[] = array('id'=>$response->getVar('id'),
                                  'uid'=>$response->getVar('uid'),
                                  'uname'=>mldocsGetUsername($responseOwner, $displayName),
                                  'archiveid'=>$response->getVar('archiveid'),
                                  'message'=>$response->getVar('message'),
                                  'timeSpent'=>$response->getVar('timeSpent'),
                                  'updateTime'=>$response->posted('m'),
                                  'userIP'=>$response->getVar('userIP'),
                                  'rating'=>(isset($review)?mldocsGetRating($review->getVar('rating')):0),
                                  'user_sig'=>$responseOwner->getVar('user_sig'),
                                  'private'=>$response->getVar('private'), 
                                  'hasFiles' => $hasFiles,
                                  'user_avatar' => XOOPS_URL .'/uploads/' .(($responseOwner)?$responseOwner->getVar('user_avatar') : 'blank.gif'));
                                  
            $all_users[$response->getVar('uid')] = '';
        }
        
        if (isset($review)) {
            unset($review);
        }
        
        $has_responses = count($responses) > 0;
        unset($responses);
        
        // Smarty variables
        $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
        $reopenArchive = $xoopsModuleConfig['mldocs_allowReopen'] && $archiveInfo->getVar('status') == 2;
        $xoopsTpl->assign('mldocs_reopenArchive', $reopenArchive);
        $xoopsTpl->assign('mldocs_allowResponse', ($archiveInfo->getVar('status') != 2) || $reopenArchive);
        $xoopsTpl->assign('mldocs_imagePath', MLDOCS_IMAGE_URL .'/');
        $xoopsTpl->assign('xoops_module_header',$mldocs_module_header);
        $xoopsTpl->assign('mldocs_archiveID', $mldocs_id);
        $xoopsTpl->assign('mldocs_archive_uid', $archiveInfo->getVar('uid'));
        $xoopsTpl->assign('mldocs_archive_codearchive', $archiveInfo->getVar('codearchive'));
        $xoopsTpl->assign('mldocs_archive_subject', $archiveInfo->getVar('subject'));
        $xoopsTpl->assign('mldocs_archive_description', $archiveInfo->getVar('description'));
        $xoopsTpl->assign('mldocs_archive_department', $department->getVar('department'));
        $xoopsTpl->assign('mldocs_archive_priority', $archiveInfo->getVar('priority'));
        $xoopsTpl->assign('mldocs_archive_status', mldocsGetStatus($archiveInfo->getVar('status')));
        $xoopsTpl->assign('mldocs_archive_posted', $archiveInfo->posted('m'));
        $xoopsTpl->assign('mldocs_archive_lastUpdated', $archiveInfo->posted('m'));
        $xoopsTpl->assign('mldocs_userinfo', XOOPS_URL . '/userinfo.php?uid=' . $archiveInfo->getVar('uid'));
        $xoopsTpl->assign('mldocs_username', $user->getVar('uname'));
        $xoopsTpl->assign('mldocs_email', $user->getVar('email'));
        $xoopsTpl->assign('mldocs_priorities', array(5, 4, 3, 2, 1));
        $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));
        $xoopsTpl->assign('mldocs_uid', $xoopsUser->getVar('uid'));
        if($has_responses){
            $xoopsTpl->assign('mldocs_aResponses', $aResponses);
        }
        if($has_files){
            $xoopsTpl->assign('mldocs_aFiles', $aFiles);
            $xoopsTpl->assign('mldocs_hasArchiveFiles', $has_archiveFiles);     
        } else {
            $xoopsTpl->assign('mldocs_aFiles', false);
            $xoopsTpl->assign('mldocs_hasArchiveFiles', false);
        }
        $xoopsTpl->assign('mldocs_claimOwner', $xoopsUser->getVar('uid'));
        $xoopsTpl->assign('mldocs_hasResponses', $has_responses);
        $xoopsTpl->assign('mldocs_hasFiles', $has_files);
        $xoopsTpl->assign('mldocs_filePath', XOOPS_URL . '/uploads/mldocs/');
        $xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' - ' . $archiveInfo->getVar('subject'));
        $xoopsTpl->assign('mldocs_archive_details', sprintf(_MLDOCS_TEXT_ARCHIVEDETAILS, $mldocs_id));
        
        $custFields =& $archiveInfo->getCustFieldValues();
        $xoopsTpl->assign('mldocs_hasCustFields', (!empty($custFields)) ? true : false);
        $xoopsTpl->assign('mldocs_custFields', $custFields);
        $xoopsTpl->assign('mldocs_uploadPath', MLDOCS_ARCHIVE_PATH);
        $xoopsTpl->assign('mldocs_allowUpload', $xoopsModuleConfig['mldocs_allowUpload']);
        
        require(XOOPS_ROOT_PATH.'/footer.php');
    break;
    
    case "userResponse":
        if(isset($_POST['newResponse'])){
            // Check if user has permission to view archive
            $hArchiveEmails =& mldocsGetHandler('archiveEmails');
            $crit = new Criteria('archiveid', $mldocs_id);
            $archiveEmails =& $hArchiveEmails->getObjects($crit);
            $canChange = false;
            foreach($archiveEmails as $archiveEmail){
                if($xoopsUser->getVar('uid') == $archiveEmail->getVar('uid')){
                    $canChange = true;
                    break;
                }
            }

            $hStatus =& mldocsGetHandler('status');
            if($canChange){
                $oldStatus =& $hStatus->get($archiveInfo->getVar('status'));
                if($oldStatus->getVar('state') == 2){     //If the archive is resolved
                    $archiveInfo->setVar('closedBy', 0);
                    $archiveInfo->setVar('status', 1);
                    $archiveInfo->setVar('overdueTime', $archiveInfo->getVar('posted') + ($xoopsModuleConfig['mldocs_overdueTime'] *60*60));
                } elseif(isset($_POST['closeArchive']) && $_POST['closeArchive'] == 1){ // If the user closes the archive
                    $archiveInfo->setVar('closedBy', $archiveInfo->getVar('uid'));
                    $archiveInfo->setVar('status', 3);   // Todo: make moduleConfig for default resolved status?
                }
                $archiveInfo->setVar('lastUpdated', $archiveInfo->lastUpdated('m'));
                
                if($hArchives->insert($archiveInfo, true)){   // Insert the archive                  
                    $newStatus =& $hStatus->get($archiveInfo->getVar('status'));
                    
                    if($newStatus->getVar('state') == 2){
                        $_eventsrv->trigger('close_archive', array(&$archiveInfo));
                    }elseif($oldStatus->getVar('id') <> $newStatus->getVar('id') && $newStatus->getVar('state') <> 2){
                        $_eventsrv->trigger('update_status', array(&$archiveInfo, &$oldStatus, &$newStatus));
                    }
                }
                if($_POST['userResponse'] <> ''){       // If the user does not add any text in the response
                    $newResponse =& $hResponses->create();
                    $newResponse->setVar('uid', $xoopsUser->getVar('uid'));
                    $newResponse->setVar('archiveid', $mldocs_id);
                    $newResponse->setVar('message', $_POST['userResponse']);
            //      $newResponse->setVar('updateTime', $newResponse->posted('m'));
                    $newResponse->setVar('updateTime', time());
                    $newResponse->setVar('userIP', getenv("REMOTE_ADDR"));
                    
                    if($hResponses->insert($newResponse)){
                        $_eventsrv->trigger('new_response', array(&$archiveInfo, &$newResponse));
                        $message = _MLDOCS_MESSAGE_USER_MOREINFO;
                        
                        if($xoopsModuleConfig['mldocs_allowUpload']){    // If uploading is allowed
                            if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
                                if (!$ret = $archiveInfo->checkUpload('userfile', $allowed_mimetypes, $errors)) {
                                    $errorstxt = implode('<br />', $errors);
                                    
                                    $message = sprintf(_MLDOCS_MESSAGE_FILE_ERROR, $errorstxt);
                                    redirect_header(MLDOCS_BASE_URL."/addArchive.php", 5, $message);
                                }
                                $file = $archiveInfo->storeUpload('userfile', $newResponse->getVar('id'), $allowed_mimetypes);
                            }
                        }
                    } else {
                        $message = _MLDOCS_MESSAGE_USER_MOREINFO_ERROR;
                    }
                } else {
                    if($newStatus->getVar('state') != 2){
                        $message = _MLDOCS_MESSAGE_USER_NO_INFO;
                    } else {
                        $message = _MLDOCS_MESSAGE_UPDATE_STATUS;
                    }
                }
            } else {
                $message = _MLDOCS_MESSAGE_NOT_USER;   
            }
            redirect_header("archive.php?id=$mldocs_id", 3, $message);
        }
    break;
    
    case "deleteFile":
        if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_FILE_DELETE, $archiveInfo->getVar('department'))){
            $message = _MLDOCS_MESSAGE_NO_DELETE_FILE;
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, $message);
        }
        
        if(!isset($_GET['fileid'])){
            $message = '';
            redirect_header(MLDOCS_BASE_URL."/archive.phpid=$mldocs_id", 3, $message);
        }
        
        if(isset($_GET['field'])){      // Remove filename from custom field
            $field = $_GET['field'];
            $hArchiveValues =& mldocsGetHandler('archiveValues');
            $archiveValues =& $hArchiveValues->get($mldocs_id);
                
            $archiveValues->setVar($field, "");
            $hArchiveValues->insert($archiveValues, true);
        }
        
        $hFile =& mldocsGetHandler('file');
        $fileid = intval($_GET['fileid']);
        $file =& $hFile->get($fileid);
        
        if(!$hFile->delete($file, true)){
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=$mldocs_id", 3, _MLDOCS_MESSAGE_DELETE_FILE_ERR);       
        }
        $_eventsrv->trigger('delete_file', array(&$file)); 
        header("Location: ".MLDOCS_BASE_URL."/archive.php?id=$mldocs_id");
        
    break;
    
    default:
        redirect_header(MLDOCS_BASE_URL."/index.php", 3);
    break;
}
?>
