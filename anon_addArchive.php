<?php
//$Id: anon_addArchive.php,v 1.28 2005/10/21 15:42:04 eric_juden Exp $

require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/notificationService.php');
require_once(MLDOCS_CLASS_PATH.'/logService.php');
require_once(MLDOCS_CLASS_PATH.'/cacheService.php');

$language = $xoopsConfig['language'];
include_once(XOOPS_ROOT_PATH ."/language/$language/user.php");

$config_handler =& xoops_gethandler('config');
$xoopsConfigUser = array();
$crit = new CriteriaCompo(new Criteria('conf_name', 'allow_register'), 'OR');
$crit->add(new Criteria('conf_name', 'activation_type'), 'OR');
$myConfigs =& $config_handler->getConfigs($crit);

foreach($myConfigs as $myConf){
    $xoopsConfigUser[$myConf->getVar('conf_name')] = $myConf->getVar('conf_value');
}

$_eventsrv->advise('new_archive', mldocs_notificationService::singleton());
$_eventsrv->advise('new_archive', mldocs_logService::singleton());
$_eventsrv->advise('new_archive', mldocs_cacheService::singleton());
$_eventsrv->advise('new_user_by_email', mldocs_notificationService::singleton(), 'new_user_activation'.$xoopsConfigUser['activation_type']);

if($xoopsModuleConfig['mldocs_allowAnonymous'] == 0){
    header("Location: ".MLDOCS_BASE_URL."/error.php");
}

$hArchive =& mldocsGetHandler('archive');
$hGroupPerm =& xoops_gethandler('groupperm');
$hMember =& xoops_gethandler('member');
$hFieldDept =& mldocsGetHandler('archiveFieldDepartment');
$module_id = $xoopsModule->getVar('mid'); 

if ($xoopsConfigUser['allow_register'] == 0) {    // Use to doublecheck that anonymous users are allowed to register
	header("Location: ".MLDOCS_BASE_URL."/error.php");    
	exit();
}

if(!isset($dept_id)){
    $dept_id = mldocsGetMeta("default_department");
}

if(!isset($_POST['addArchive'])){
    $xoopsOption['template_main'] = 'mldocs_anon_addArchive.html';             // Always set main template before including the header
    include(XOOPS_ROOT_PATH . '/header.php');
    
    $hDepartments  =& mldocsGetHandler('department');    // Department handler
    $crit = new Criteria('','');
    $crit->setSort('department');
    $departments =& $hDepartments->getObjects($crit);
    if(count($departments) == 0){
        $message = _MLDOCS_MESSAGE_NO_DEPTS;
        redirect_header(MLDOCS_BASE_URL.'/index.php', 3, $message);
    }
    
    //XOOPS_GROUP_ANONYMOUS
    foreach($departments as $dept){
        $deptid = $dept->getVar('id');
        if($hGroupPerm->checkRight(_MLDOCS_GROUP_PERM_DEPT, $deptid, XOOPS_GROUP_ANONYMOUS, $module_id)){
            $aDept[] = array('id'=>$deptid,
                             'department'=>$dept->getVar('department'));
        }
    }
    if($xoopsModuleConfig['mldocs_allowUpload']){
        // Get available mimetypes for file uploading
        $hMime =& mldocsGetHandler('mimetype');
        $crit = new Criteria('mime_user', 1);
        $mimetypes =& $hMime->getObjects($crit);
        $mimes = '';
        foreach($mimetypes as $mime){
            if($mimes == ''){
                $mimes = $mime->getVar('mime_ext');
            } else {                                      
                $mimes .= ", " . $mime->getVar('mime_ext');
            }
        }
        $xoopsTpl->assign('mldocs_mimetypes', $mimes);
    }
    
    // Get current dept's custom fields
    $fields =& $hFieldDept->fieldsByDepartment($dept_id, true);
    
    if (!$savedFields =& $_mldocsSession->get('mldocs_custFields')) {
        $savedFields = array();
    }
    
    $aFields = array();
    foreach($fields as $field){
        $values = $field->getVar('fieldvalues');
        if ($field->getVar('controltype') == MLDOCS_CONTROL_YESNO) {
            $values = array(1 => _YES, 0 => _NO);
        }
        
        // Check for values already submitted, and fill those values in
        if(array_key_exists($field->getVar('fieldname'), $savedFields)){
            $defaultValue = $savedFields[$field->getVar('fieldname')];
        } else {
            $defaultValue = $field->getVar('defaultvalue');
        }
        
        $aFields[$field->getVar('id')] = 
            array('name' => $field->getVar('name'),
                  'desc' => $field->getVar('description'),
                  'fieldname' => $field->getVar('fieldname'),
                  'defaultvalue' => $defaultValue,
                  'controltype' => $field->getVar('controltype'),
                  'required' => $field->getVar('required'),
                  'fieldlength' => $field->getVar('fieldlength'),
                  'maxlength' => ($field->getVar('fieldlength') < 50 ? $field->getVar('fieldlength') : 50),
                  'weight' => $field->getVar('weight'),
                  'fieldvalues' => $values,
                  'validation' => $field->getVar('validation'));
    }
    $xoopsTpl->assign('mldocs_custFields', $aFields);
    if(!empty($aFields)){
        $xoopsTpl->assign('mldocs_hasCustFields', true);
    } else {
        $xoopsTpl->assign('mldocs_hasCustFields', false);
    }
    
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
        var tbl = gE('tblAddArchive');
        var beforeele = gE('addButtons');
        tbody = tbl.tBodies[0];
        mldocsFillCustomFlds(tbody, result, beforeele);
    }
}

function window_onload()
{
    mldocsDOMAddEvent(xoopsGetElementById('departments'), 'change', departments_onchange, true);
}

window.setTimeout('window_onload()', 1500);
//-->
</script>";      
        
    $xoopsTpl->assign('xoops_module_header', $javascript. $mldocs_module_header);
    $xoopsTpl->assign('mldocs_allowUpload', $xoopsModuleConfig['mldocs_allowUpload']);
    $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL . '/modules/mldocs/images/');
    $xoopsTpl->assign('mldocs_departments', $aDept);
    $xoopsTpl->assign('mldocs_current_file', basename(__file__));
    $xoopsTpl->assign('mldocs_priorities', array(5, 4, 3, 2, 1));
    $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));
    $xoopsTpl->assign('mldocs_default_priority', MLDOCS_DEFAULT_PRIORITY);
    $xoopsTpl->assign('mldocs_default_dept', mldocsGetMeta("default_department"));
    $xoopsTpl->assign('mldocs_includeURL', MLDOCS_INCLUDE_URL);
    $xoopsTpl->assign('mldocs_numArchiveUploads', $xoopsModuleConfig['mldocs_numArchiveUploads']);
    
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
    
    $elements = array('subject', 'description', 'email');
    foreach($elements as $element){         // Foreach element in the predefined list
        $xoopsTpl->assign("mldocs_element_$element", "formButton");
        foreach($aElements as $aElement){   // Foreach that has an error
            if($aElement == $element){      // If the names are equal
                $xoopsTpl->assign("mldocs_element_$element", "validateError");
                break;
            }
        }
    }     
                    
    if ($archive =& $_mldocsSession->get('mldocs_archive')) {
        $xoopsTpl->assign('mldocs_archive_codearchive', stripslashes($archive['codearchive']));
        $xoopsTpl->assign('mldocs_archive_subject', stripslashes($archive['subject']));
        $xoopsTpl->assign('mldocs_archive_description', stripslashes($archive['description']));
        $xoopsTpl->assign('mldocs_archive_department', $archive['department']);
        $xoopsTpl->assign('mldocs_archive_priority', $archive['priority']);
    } else {
        $xoopsTpl->assign('mldocs_archive_uid', null);
        $xoopsTpl->assign('mldocs_archive_username', null);
        $xoopsTpl->assign('mldocs_archive_codearchive', null);
        $xoopsTpl->assign('mldocs_archive_subject', null);
        $xoopsTpl->assign('mldocs_archive_description', null);
        $xoopsTpl->assign('mldocs_archive_department', null);
        $xoopsTpl->assign('mldocs_archive_priority', 4);
    }
    
    if($user =& $_mldocsSession->get('mldocs_user')){
        $xoopsTpl->assign('mldocs_uid', $user['uid']);
        $xoopsTpl->assign('mldocs_email', $user['email']);
    } else {
        $xoopsTpl->assign('mldocs_uid', null);
        $xoopsTpl->assign('mldocs_email', null);
    }
    include(XOOPS_ROOT_PATH . '/footer.php');  
} else {
    require_once(MLDOCS_CLASS_PATH.'/validator.php');
    
    $v = array();
    $v['codearchive'][] = new ValidateLength($_POST['codearchive'], 2, 15);
    $v['subject'][] = new ValidateLength($_POST['subject'], 2, 255);
    $v['description'][] = new ValidateLength($_POST['description'], 2);
    $v['email'][] = new ValidateEmail($_POST['email']);
    
    // Get current dept's custom fields
    $fields =& $hFieldDept->fieldsByDepartment($dept_id, true);
    $aFields = array();
    
    foreach($fields as $field){
        $values = $field->getVar('fieldvalues');
        if ($field->getVar('controltype') == MLDOCS_CONTROL_YESNO) {
            $values = array(1 => _YES, 0 => _NO);
        }
        $fieldname = $field->getVar('fieldname');
        
        if($field->getVar('controltype') != MLDOCS_CONTROL_FILE) {
            $checkField = $_POST[$fieldname];
        } else {
            $checkField = $_FILES[$fieldname];
        }
        
        $v[$fieldname][] = new ValidateRegex($checkField, $field->getVar('validation'), $field->getVar('required'));
        
        $aFields[$field->getVar('id')] = 
            array('name' => $field->getVar('name'),
                  'desc' => $field->getVar('description'),
                  'fieldname' => $field->getVar('fieldname'),
                  'defaultvalue' => $field->getVar('defaultvalue'),
                  'controltype' => $field->getVar('controltype'),
                  'required' => $field->getVar('required'),
                  'fieldlength' => $field->getVar('fieldlength'),
                  'maxlength' => ($field->getVar('fieldlength') < 50 ? $field->getVar('fieldlength') : 50),
                  'weight' => $field->getVar('weight'),
                  'fieldvalues' => $values,
                  'validation' => $field->getVar('validation'));
    }
    
    $_mldocsSession->set('mldocs_archive', 
        array('uid' => 0,
              'codearchive' => $_POST['codearchive'],
              'subject' => $_POST['subject'],
              'description' => htmlspecialchars($_POST['description'], ENT_QUOTES),
              'department' => $_POST['departments'],
              'priority' => $_POST['priority']));
    
    $_mldocsSession->set('mldocs_user',
        array('uid' => 0,
              'email' => $_POST['email']));
    
    if($fields != ""){
        $_mldocsSession->set('mldocs_custFields', $fields);
    }
    
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
        header("Location: ".MLDOCS_BASE_URL."/anon_addArchive.php");
        exit();
    }    
    
    //Check email address
    $user_added = false;
    if(!$xoopsUser =& mldocsEmailIsXoopsUser($_POST['email'])){      // Email is already used by a member
        switch($xoopsConfigUser['activation_type']){
            case 1:
                $level = 1;
            break;
            
            case 0:
            case 2:
            default:
                $level = 0;
        }
        
        if($anon_user =& mldocsXoopsAccountFromEmail($_POST['email'], '', $password, $level)){ // If new user created
            $member_handler =& xoops_gethandler('member');
            $xoopsUser =& $member_handler->loginUserMd5($anon_user->getVar('uname'), $anon_user->getVar('pass'));
            $user_added = true;
        } else {        // User not created
            $message = _MLDOCS_MESSAGE_NEW_USER_ERR;
            redirect_header(MLDOCS_BASE_URL.'/user.php', 3, $message);
        }
    }    
    $archive =& $hArchive->create();
    $archive->setVar('uid', $xoopsUser->getVar('uid'));
    $archive->setVar('codearchive', $_POST['codearchive']);
    $archive->setVar('subject', $_POST['subject']);
    $archive->setVar('description', $_POST['description']);
    $archive->setVar('department', $_POST['departments']);
    $archive->setVar('priority', $_POST['priority']);
    $archive->setVar('status', 1);
    $archive->setVar('posted', time());
    $archive->setVar('userIP', getenv("REMOTE_ADDR"));
    $archive->setVar('overdueTime', $archive->getVar('posted') + ($xoopsModuleConfig['mldocs_overdueTime'] *60*60));
            
    $aUploadFiles = array();
    if($xoopsModuleConfig['mldocs_allowUpload']){
        foreach($_FILES as $key=>$aFile){
            $pos = strpos($key, 'userfile');
            if($pos !== false && is_uploaded_file($aFile['tmp_name'])){     // In the userfile array and uploaded file?
                if ($ret = $archive->checkUpload($key, $allowed_mimetypes, $errors)) {
                    $aUploadFiles[$key] = $aFile;
                } else {
                    $errorstxt = implode('<br />', $errors);
                    $message = sprintf(_MLDOCS_MESSAGE_FILE_ERROR, $errorstxt);
                    redirect_header(MLDOCS_BASE_URL."/addArchive.php", 5, $message);
                }
            }
        }
    }
    
    if($hArchive->insert($archive)){
        $_eventsrv->trigger('new_archive', array(&$archive));
        $archive->addSubmitter($xoopsUser->getVar('email'), $xoopsUser->getVar('uid'));
        if(count($aUploadFiles) > 0){   // Has uploaded files? 
            foreach($aUploadFiles as $key=>$aFile){
                $file = $archive->storeUpload($key, null, $allowed_mimetypes);
                $_eventsrv->trigger('new_file', array(&$archive, &$file));
            }
        }
                
        // Add custom field values to db
        $hArchiveValues = mldocsGetHandler('archiveValues');
        $archiveValues = $hArchiveValues->create();
                
        foreach($aFields as $field){
            $fieldname = $field['fieldname'];
            $fieldtype = $field['controltype'];
                    
            if($fieldtype == MLDOCS_CONTROL_FILE){               // If custom field was a file upload
                if($xoopsModuleConfig['mldocs_allowUpload']){    // If uploading is allowed
                    if(is_uploaded_file($_FILES[$fieldname]['tmp_name'])){
                        if (!$ret = $archive->checkUpload($fieldname, $allowed_mimetypes, $errors)) {
                            $errorstxt = implode('<br />', $errors);
                            $message = sprintf(_MLDOCS_MESSAGE_FILE_ERROR, $errorstxt);
                            redirect_header(MLDOCS_BASE_URL."/addArchive.php", 5, $message);
                        }
                        if($file = $archive->storeUpload($fieldname, -1, $allowed_mimetypes)){
                            $archiveValues->setVar($fieldname, $file->getVar('id') . "_" . $_FILES[$fieldname]['name']);
                        }
                    }
                }
            } else {
                $fieldvalue = $_POST[$fieldname];
                $archiveValues->setVar($fieldname, $fieldvalue);
            }
        }
        $archiveValues->setVar('archiveid', $archive->getVar('id'));
                
        if(!$hArchiveValues->insert($archiveValues)){
            $message = _MLDOCS_MESSAGE_NO_CUSTFLD_ADDED;
        }
                
        $_mldocsSession->del('mldocs_archive');
        $_mldocsSession->del('mldocs_archive');
        $_mldocsSession->del('mldocs_user');
        $_mldocsSession->del('mldocs_validateError');
                
        $message = _MLDOCS_MESSAGE_ADDARCHIVE;
    } else {
        $message = _MLDOCS_MESSAGE_ADDARCHIVE_ERROR . $archive->getHtmlErrors();     // Unsuccessfully added new archive
    }
    if ($user_added) {            
        $_eventsrv->trigger('new_user_by_email', array($password, $xoopsUser));
    }        
            
    redirect_header(XOOPS_URL.'/user.php', 3, $message);
}  
?>
