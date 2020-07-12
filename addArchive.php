<?php
//$Id: addArchive.php,v 1.81 2005/10/21 15:42:04 eric_juden Exp $
// modification BYOOS solutions 2009/06/04  gabriel_bobard

if(isset($_GET['deptid'])){
    $dept_id = intval($_GET['deptid']);
}

if(isset($_GET['view_id'])){
    $view_id = intval($_GET['view_id']);
    setCookie("mldocs_logMode", $view_id,time()+60*60*24*30);
    if(isset($dept_id)){
        header("Location: addArchive.php&deptid=$dept_id");
    } else {
        header("Location: addArchive.php");
    }
} else {    
    if(!isset($_COOKIE['mldocs_logMode'])){
        setCookie("mldocs_logMode", 1, time()+60*60*24*30);
    } else {
        setCookie("mldocs_logMode", $_COOKIE['mldocs_logMode'], time()+60*60*24*30);
    }
}

require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/notificationService.php');
require_once(MLDOCS_CLASS_PATH.'/logService.php');
require_once(MLDOCS_CLASS_PATH.'/cacheService.php');

$_eventsrv->advise('new_archive', mldocs_notificationService::singleton());
$_eventsrv->advise('new_archive', mldocs_logService::singleton());
$_eventsrv->advise('new_archive', mldocs_cacheService::singleton());
$_eventsrv->advise('new_response', mldocs_logService::singleton());
$_eventsrv->advise('new_response', mldocs_notificationService::singleton());
$_eventsrv->advise('update_owner', mldocs_notificationService::singleton());
$_eventsrv->advise('update_owner', mldocs_logService::singleton());

$hArchive =& mldocsGetHandler('archive');
$hStaff =& mldocsGetHandler('staff');
$hGroupPerm =& xoops_gethandler('groupperm');
$hMember =& xoops_gethandler('member');
$hMembership =& mldocsGetHandler('membership');
$hFieldDept =& mldocsGetHandler('archiveFieldDepartment');


$module_id = $xoopsModule->getVar('mid'); 

if($xoopsUser){
//modif BYOOS 2007/09/25  dept by default for one user
    if(!isset($dept_id)){
            $checkStaff = $hStaff->getByUid($xoopsUser->getVar('uid'));
            if($checkStaff->getVar('deptUserdef') > 0){
                  $dept_id = $checkStaff->getVar('deptUserdef');
			    } else {
        				$dept_id = mldocsGetMeta("default_department");
				}
     }
     

    if(isset($_GET['saveArchive']) && $_GET['saveArchive'] == 1){
        _saveArchive();
    }
    
    if(!isset($_POST['addArchive'])){                           // Initial load of page
        $xoopsOption['template_main'] = 'mldocs_addArchive.html';             // Always set main template before including the header
        include(XOOPS_ROOT_PATH . '/header.php');
        
        $hDepartments  =& mldocsGetHandler('department');    // Department handler
        $crit = new Criteria('','');
        $crit->setSort('department');
        $departments =& $hDepartments->getObjects($crit);
        if(count($departments) == 0){
            $message = _MLDOCS_MESSAGE_NO_DEPTS;
            redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
        }
        $aDept = array();
        $myGroups =& $hMember->getGroupsByUser($xoopsUser->getVar('uid'));
        if(($isStaff) && ($xoopsModuleConfig['mldocs_deptVisibility'] == 0)){     // If staff are not applied
            foreach($departments as $dept){
                $deptid = $dept->getVar('id');
                $aDept[] = array('id'=>$deptid,
                                 'department'=>$dept->getVar('department'),
                                 'tagSubject'=>$dept->getVar('tagSubject'),
                                 'tagDescription'=>$dept->getVar('tagDescription'));
            }
        } else {
            foreach($departments as $dept){
                $deptid = $dept->getVar('id');
                foreach($myGroups as $group){   // Check for user to be in multiple groups
                    if($hGroupPerm->checkRight(_MLDOCS_GROUP_PERM_DEPT, $deptid, $group, $module_id)){
                    		//Assign the first value to $dept_id incase the default department property not set
                    		if ($dept_id == null) {
                    			$dept_id = $deptid;
                    		}
                        $aDept[] = array('id'=>$deptid,
                                         'department'=>$dept->getVar('department'),
                                         'tagSubject'=>$dept->getVar('tagSubject'),
                                         'tagDescription'=>$dept->getVar('tagDescription'));
                        break;
                    }
                }
            }
        }

        // User Dept visibility check
        if(empty($aDept)){
            $message = _MLDOCS_MESSAGE_NO_DEPTS;
            redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
        }

        $xoopsTpl->assign('mldocs_isUser', true);
        
        if($isStaff){
            $checkStaff =& $hStaff->getByUid($xoopsUser->getVar('uid'));
            if(!$hasRights = $checkStaff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_ADD)){
                $message = _MLDOCS_MESSAGE_NO_ADD_ARCHIVE;
                redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
            }
            unset($checkStaff);
            
            if($hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_OWNERSHIP, $dept_id)){
               $staff =& $hMembership->xoopsUsersByDept($dept_id);
                
                $aOwnership = array();
                $aOwnership[0] = _MLDOCS_NO_OWNER;
                foreach($staff as $stf){
                    $aOwnership[$stf->getVar('uid')] = $stf->getVar('uname');
                }
                $xoopsTpl->assign('mldocs_aOwnership', $aOwnership);
            } else {
                $xoopsTpl->assign('mldocs_aOwnership', false);
            }
        }
        
        // read a last record archive
        $crit = new Criteria('','');
        $crit->setSort('posted');
        $crit->setOrder('DESC');
        $crit->setLimit(1);
        $lastArchives = $hArchive->getObjects($crit);
        $hasLastArchives = count($lastArchives)>0;
       
        if ($hasLastArchives) {
            foreach($lastArchives as $arch){
        	    $aLastArchives[] = array('id'=>$arch->getVar('id'),
        	                            'codearchive'=>$arch->getVar('codearchive'),
        	                             ); 
            }
            $nextArchive = intval(trim($arch->getVar('codearchive')) + 1);
            //echo $arch->getVar('codearchive');
            //echo "<br>" . $nextArchive;exit();// byoos_debug
        } else {
            $nextArchive = date('Y', time()) . '0001' ;
        }
        $xoopsTpl->assign('mldocs_codearchive', $nextArchive );     
        unset($nextArchive);        
        
        $has_mimes = false;
        if($xoopsModuleConfig['mldocs_allowUpload']){
            // Get available mimetypes for file uploading
            $hMime =& mldocsGetHandler('mimetype');
            $mldocs =& mldocsGetModule();
            $mid = $mldocs->getVar('mid');
            if(!$isStaff){
                $crit = new Criteria('mime_user', 1);
            } else {
                $crit = new Criteria('mime_admin', 1);
            }
            $mimetypes =& $hMime->getObjects($crit);
            $mimes = '';
            $aMimetype = array();
             foreach($mimetypes as $key=>$mime){
              //traite la liste des extention de fichier autoris�es
                if($mimes == ''){
                    $mimes = $mime->getVar('mime_ext');
                } else {                                      
                    $mimes .= ", " . $mime->getVar('mime_ext');
                }
            }
            
            
            //gestion de la bannette archive par lots BYOOS solutions 12 avril 2006
            $UploadxFiles = array(); // tableau de structure $_FILES
            $uid = $xoopsUser->getVar('uid');
            $username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur
            $dossier=(MLDOCS_BANNETTE_PATH."/".$username."/");        
            $ListeF = '';
            $UploadxFiles = read_dir($dossier); // appel la fonction de lecture du repertoire bannette
            // retrouve le type MIME pour chaque extention de fichier autoris�
            foreach($UploadxFiles as $key=>$aFile){
                $UploadxFiles [$key] = $aFile;

                  // pr�pare la liste avant envoi vers le template  
                  if($ListeF == ''){
                            $ListeF = $aFile ['name'];
                     } else {                                      
                    $ListeF .= " ../.. " . $aFile ['name'];
                    }
            }
            $pos =  array_search($dept_id, $aDept); //retrouve le d�partement par d�faut
            $UploadxBannette = double_implode($first_break="||", $second_break="|", $UploadxFiles);//prepare l'envoi vers le template FORM
              //envoi les variables vers le formulaire de template
              $xoopsTpl->assign('mldocs_nbvues', count($UploadxFiles));
              $xoopsTpl->assign('mldocs_dossier', $dossier);
              $xoopsTpl->assign('mldocs_tagSubject', $aDept[$pos]['tagSubject']);
              $xoopsTpl->assign('mldocs_tagDescription', $aDept[$pos]['tagDescription']);
              $xoopsTpl->assign('mldocs_listefichier', $ListeF);
              $xoopsTpl->assign('mldocs_bannettefile', $UploadxBannette);
              $xoopsTpl->assign('mldocs_mimetypes', $mimes);
        }
        
        $xoopsTpl->assign('mldocs_has_logUser', false);
        if($isStaff){
            $checkStaff =& $hStaff->getByUid($xoopsUser->getVar('uid'));
            if($hasRights = $checkStaff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_LOGUSER)){
                $xoopsTpl->assign('mldocs_has_logUser', true);
            }
            unset($checkStaff);
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
    wl.customfieldsbydept(dept.value);\n";
    
    if($isStaff){
        $javascript .= "var w = new mldocsweblib(staffHandler);
        w.staffbydept(dept.value);\n";
    }
$javascript .= "}

var staffHandler = {
    staffbydept: function(result){";
        if($isStaff){
            if (isset($_COOKIE['mldocs_logMode']) && $_COOKIE['mldocs_logMode'] == 2 && $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_OWNERSHIP, $dept_id)) {   
                $javascript .= "var sel = gE('owner');";
                $javascript .= "mldocsFillStaffSelect(sel, result);\n";
            }
        }
    $javascript .= "}
}

var fieldHandler = {
    customfieldsbydept: function(result){
        var tbl = gE('tblAddArchive');\n";
        if ($isStaff && isset($_COOKIE['mldocs_logMode']) && $_COOKIE['mldocs_logMode'] == 2) {       
            $javascript.="var beforeele = gE('privResponse');\n";
        } else {
            $javascript.="var beforeele = gE('addButtons');\n";
        }
        $javascript.="tbody = tbl.tBodies[0];\n";
        $javascript .="mldocsFillCustomFlds(tbody, result, beforeele);
    }
}

function window_onload()
{
    mldocsDOMAddEvent(xoopsGetElementById('departments'), 'change', departments_onchange, true);
}

window.setTimeout('window_onload()', 1500);
//-->
</script>";      
        $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
        $xoopsTpl->assign('mldocs_includeURL', MLDOCS_INCLUDE_URL);
        $xoopsTpl->assign('xoops_module_header', $javascript. $mldocs_module_header);
        $xoopsTpl->assign('mldocs_allowUpload', $xoopsModuleConfig['mldocs_allowUpload']);
        $xoopsTpl->assign('mldocs_text_lookup', _MLDOCS_TEXT_LOOKUP);
        $xoopsTpl->assign('mldocs_text_email', _MLDOCS_TEXT_EMAIL);
        $xoopsTpl->assign('mldocs_imagePath', XOOPS_URL . '/modules/mldocs/images/');
        $xoopsTpl->assign('mldocs_departments', $aDept);
        $xoopsTpl->assign('mldocs_current_file', basename(__file__));
        $xoopsTpl->assign('mldocs_priorities', array(5, 4, 3, 2, 1));
        $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));
        $xoopsTpl->assign('mldocs_default_priority', MLDOCS_DEFAULT_PRIORITY);
        $xoopsTpl->assign('mldocs_default_dept', $dept_id);
        $xoopsTpl->assign('mldocs_currentUser', $xoopsUser->getVar('uid'));
        $xoopsTpl->assign('mldocs_numArchiveUploads', $xoopsModuleConfig['mldocs_numArchiveUploads']);
        if(isset($_POST['logFor'])){
            $uid = $_POST['logFor'];
            $username = $xoopsUser->getUnameFromId($uid);
            $xoopsTpl->assign('mldocs_username', $username);
            $xoopsTpl->assign('mldocs_user_id', $uid);
        } else {
            $uid = $xoopsUser->getVar('uid');
            $username = $xoopsUser->getVar('uname');
            $xoopsTpl->assign('mldocs_username', $username);
            $xoopsTpl->assign('mldocs_user_id', $uid);
        }
        $xoopsTpl->assign('mldocs_isStaff', $isStaff);
        if(!isset($_COOKIE['mldocs_logMode'])){
            $xoopsTpl->assign('mldocs_logMode', 1);
        } else {
            $xoopsTpl->assign('mldocs_logMode', $_COOKIE['mldocs_logMode']);
        }
        
        if($isStaff){
            if(isset($_COOKIE['mldocs_logMode']) && $_COOKIE['mldocs_logMode'] == 2){
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
            }
            $xoopsTpl->assign('mldocs_savedSearches', $aSavedSearches);
        }
        
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
                        
        if ($archive =& $_mldocsSession->get('mldocs_archive')) {
            $xoopsTpl->assign('mldocs_archive_uid', $archive['uid']);
            $xoopsTpl->assign('mldocs_archive_username', $xoopsUser->getUnameFromId($archive['uid']));
            $xoopsTpl->assign('mldocs_archive_subject', stripslashes($archive['subject']));
            $xoopsTpl->assign('mldocs_archive_codearchive', stripslashes($archive['codearchive']));
            $xoopsTpl->assign('mldocs_archive_description', stripslashes($archive['description']));
            $xoopsTpl->assign('mldocs_archive_department', $archive['department']);
            $xoopsTpl->assign('mldocs_archive_priority', $archive['priority']);
        } else {
            $xoopsTpl->assign('mldocs_archive_uid', $uid);
            $xoopsTpl->assign('mldocs_archive_username', $username);
            $xoopsTpl->assign('mldocs_archive_subject', null);
            $xoopsTpl->assign('mldocs_archive_codearchive', null);
            $xoopsTpl->assign('mldocs_archive_description', null);
            $xoopsTpl->assign('mldocs_archive_department', null);
            $xoopsTpl->assign('mldocs_archive_priority', MLDOCS_DEFAULT_PRIORITY);
        }
        
        if($response =& $_mldocsSession->get('mldocs_response')){
            $xoopsTpl->assign('mldocs_response_uid', $response['uid']);
            $xoopsTpl->assign('mldocs_response_message', $response['message']);
            $xoopsTpl->assign('mldocs_response_timespent', $response['timeSpent']);
            $xoopsTpl->assign('mldocs_response_userIP', $response['userIP']);
            $xoopsTpl->assign('mldocs_response_private', $response['private']);
            $xoopsTpl->assign('mldocs_archive_status', $response['status']);
            $xoopsTpl->assign('mldocs_archive_ownership', $response['owner']);
        } else {
            $xoopsTpl->assign('mldocs_response_uid', null);
            $xoopsTpl->assign('mldocs_response_message', null);
            $xoopsTpl->assign('mldocs_response_timeSpent', null);
            $xoopsTpl->assign('mldocs_response_userIP', null);
            $xoopsTpl->assign('mldocs_response_private', null);
            $xoopsTpl->assign('mldocs_archive_status', 1);
            $xoopsTpl->assign('mldocs_archive_ownership', 0);
        }
        
        require(XOOPS_ROOT_PATH.'/footer.php');                             //Include the page footer
    } else { // apr�s le POST du formulaire
        
        if (MLDOCS_UNIQUE_ARCHIVE){// si le code archive est r�gl� sur unique, verifier si il n existe pas d�j�

            $codeArchive = array ();
            $crit = new CriteriaCompo(new Criteria('codearchive', $_POST['codearchive']));
            $crit->setSort('posted');
            $crit->setOrder('DESC');
            $codeArchive =& $hArchive->getObjects($crit);

            if (count($codeArchive) > 0 ){
                $message = _MLDOCS_MESSAGE_ADDARCHIVE_ERROR . "  " . $_POST['codearchive']; 
                redirect_header(MLDOCS_BASE_URL."/index.php", 5, $message);
                exit();
            }
        }
        $GLOBALS['_xFILES'] = array();
        $dept_id = intval($_POST['departments']);
        $FlagTypeUpload= false;// UPload en manuel par d�faut
        
        require_once(MLDOCS_CLASS_PATH.'/validator.php');
        $v = array();
        $v['codearchive'][] = new ValidateLength($_POST['codearchive'], 2, 15);
        $v['subject'][] = new ValidateLength($_POST['subject'], 2, 255);
        $v['description'][] = new ValidateLength($_POST['description'], 2);
        
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
        
        $crit = new Criteria('','');
        $crit->setSort('posted');
        $crit->setOrder('DESC');
        $crit->setLimit(1);
       
        $lastArchives =& $hArchive->getObjects($crit);

        if (count($lastArchives)>0) {
            foreach($lastArchives as $arch){
          
        	    $aLastArchives[] = array('id'=>$arch->getVar('id'),
        	                            'repid'=>$arch->getVar('repid'),
        	                            'codearchive'=>$arch->getVar('codearchive'),
        	                            'status'=>mldocsGetStatus($arch->getVar('status')),
        	                             ); 
            }
            $repid = (int) $arch->getVar('repid');
             if($repid==99){
                $repid=0; 
                $lot=$lot+1;
              } else {
                $repid = $arch->getVar('repid');
                $repid=$repid+1;
              }
        } else {
          $repid=0;
        }
        
        _saveArchive($aFields);      // Save archive information in a session
        
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
            header("Location: ".MLDOCS_BASE_URL."/addArchive.php");
            exit();
        }
        $archive =& $hArchive->create();

        
        $archive->setVar('uid', $_POST['user_id']);
        $archive->setVar('repid', $repid); // position dans le rayonnage r�pertoires disque
        $archive->setVar('codearchive', $_POST['codearchive']);
        $archive->setVar('subject', $_POST['subject']);
        $archive->setVar('description', $_POST['description']);
        $archive->setVar('department', $dept_id);
        $archive->setVar('priority', $_POST['priority']);
        if($isStaff && $_COOKIE['mldocs_logMode'] == 2){
            $archive->setVar('status', $_POST['status']);    // Set status
            if (isset($_POST['owner'])) {  //Check if user claimed ownership
                if ($_POST['owner'] > 0) {
                    $oldOwner = 0;
                    $_mldocsSession->set('mldocs_oldOwner', $oldOwner);
                    $archive->setVar('ownership', $_POST['owner']);
                    $_mldocsSession->set('mldocs_changeOwner', true);
                }
            }
            $_mldocsSession->set('mldocs_archive_ownership', $_POST['owner']);  // Store in session
        } else {
            $archive->setVar('status', 1);
        }
        $archive->setVar('posted', time());
        $archive->setVar('userIP', getenv("REMOTE_ADDR"));
        $archive->setVar('overdueTime', $archive->getVar('posted') + ($xoopsModuleConfig['mldocs_overdueTime'] *60*60));
        $aUploadFiles = array();// fichiers transf�r�s en manuel FORM
        $aUploadxFiles = array();// fichiers transf�r�s en automatique BANNETTE
        $_xFILES = array(); // tableau $GLOBALS
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
            if(!empty($_POST['bannettefile'])){
                $FlagTypeUpload= true;// UPload en automatique
                $string1 = $_POST['bannettefile'] ;
                $axFiles = double_explode($first_break="||", $second_break="|", $string1);
                foreach ($axFiles as $key => $axFile)
                 {
                  $axFile = $axFiles;
                         $_xFILES [$key]['name']     = $axFile [$key][0] ;
                         $_xFILES [$key]['tmp_name'] = $axFile [$key][1];
                         $_xFILES [$key]['type']    = $axFile[$key][2] ;
                         $_xFILES [$key]['size']    = $axFile [$key][3] ;
                         $_xFILES [$key]['error']    = $axFile[$key][4] ;
                   
                  if ($ret = $archive->checkUpload($key, $allowed_mimetypes, $errors)) {
                      $aUploadxFiles = $_xFILES;
                      } else {
                          $errorstxt = implode('<br />', $errors);
                          $message = sprintf(_MLDOCS_MESSAGE_FILE_ERROR, $errorstxt);
                          redirect_header(MLDOCS_BASE_URL."/addArchive.php", 5, $message);
                      }
                        /* zone affichage des variables  
                   echo    $_xFILES [$key]['name'] ."<br>"; 
                   echo    $_xFILES [$key]['tmp_name']."<br>"; 
                   echo    $_xFILES [$key]['type']."<br>"; 
                   echo    $_xFILES [$key]['type']."<br>"; 
                   echo    $_xFILES [$key]['error']."<br>"; 
                    */
                 }
            }//fin de traitement de la bannette
        }
        if($hArchive->insert($archive)){
            $_eventsrv->trigger('new_archive', array(&$archive));
            $hMember =& xoops_gethandler('member');
            $newUser =& $hMember->getUser($archive->getVar('uid'));
            $archive->addSubmitter($newUser->getVar('email'), $newUser->getVar('uid'));
           
            //echo "nbr de lignes INPUT form:".count($aUploadFiles)."<br>";
            if(count($aUploadFiles) > 0){   // Has uploaded files? 
                $FlagTypeUpload= false;
                foreach($aUploadFiles as $key=>$aFile){
                    //echo ($allowed_mimetypes)."type mime _FILES"."<br>";
                    $allowed_mimetypes = $aUploadFiles[$key]['type'];
                    $file = $archive->storeUpload($key, null, $allowed_mimetypes);
                    $_eventsrv->trigger('new_file', array(&$archive, &$file));
                }
            }
             //echo "nbr de lignes bannette:".count($aUploadxFiles)."<br>";
            if(count($aUploadxFiles) > 0){   // Has uploaded bannette files? 
                $FlagTypeUpload= true;// UPload en automatique
                foreach($aUploadxFiles as $key=>$axFile){
                    //echo $aUploadxFiles[$key]['type']."type mime _xFILES"."<br>";
                    $allowed_mimetypes = $aUploadxFiles[$key]['type'];
                    $xfile = $archive->storeUpload($key, null, $allowed_mimetypes);
                    $_eventsrv->trigger('new_file', array(&$archive, &$xfile));
                }
            }
    
            if ($_mldocsSession->get('mldocs_changeOwner')) {
                $oldOwner = $_mldocsSession->get('mldocs_oldOwner');
                $_eventsrv->trigger('update_owner', array(&$archive, $oldOwner));
                $_mldocsSession->del('mldocs_changeOwner');
                $_mldocsSession->del('mldocs_oldOwner');
                $_mldocsSession->del('mldocs_archive_ownership');
            }
            
            // Add response
            if($isStaff && $_COOKIE['mldocs_logMode'] == 2){     // Make sure user is a staff member and is using advanced form
                if($_POST['response'] != ''){                   // Don't run if no value for response
                    $hResponse =& mldocsGetHandler('responses');
                    $newResponse =& $hResponse->create();
                    $newResponse->setVar('uid', $xoopsUser->getVar('uid'));
                    $newResponse->setVar('archiveid', $archive->getVar('id'));
                    $newResponse->setVar('message', $_POST['response']);
                    $newResponse->setVar('timeSpent', $_POST['timespent']);
                    $newResponse->setVar('updateTime', $archive->getVar('posted'));
                    $newResponse->setVar('userIP', $archive->getVar('userIP'));
                    if(isset($_POST['private'])){
                        $newResponse->setVar('private', $_POST['private']);
                    }
                    if($hResponse->insert($newResponse)){
                        $_eventsrv->trigger('new_response', array(&$archive, &$newResponse));
                        $_mldocsSession->del('mldocs_response');
                    }
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
            $_mldocsSession->del('mldocs_validateError');
            $_mldocsSession->del('mldocs_custFields');
            $uid = $xoopsUser->getVar('uid');
            $username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur
            //echo $username;
            $dossier=(MLDOCS_BANNETTE_PATH."/".$username."/");
            $delResponse = deletexFile($dossier);
            // ajouter le test du retour effacement de la bannette
            $message = _MLDOCS_MESSAGE_ADDARCHIVE . " - " . $_POST['codearchive'];
        } else {
            //$_mldocsSession->set('mldocs_archive', $archive);
            $message = _MLDOCS_MESSAGE_ADDARCHIVE_ERROR . $archive->getHtmlErrors();     // Unsuccessfully added new archive
        }
        //exit();
        $FlagModeArchive = false;//archive en production
        if ($FlagModeArchive){
        redirect_header(MLDOCS_BASE_URL."/addArchive.php", 5, $message);}
        else {redirect_header(MLDOCS_BASE_URL."/index.php", 5, $message);}
    }
} else {    // If not a user
    $config_handler =& xoops_gethandler('config');
    //$xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
    $xoopsConfigUser = array();
    $crit = new CriteriaCompo(new Criteria('conf_name', 'allow_register'), 'OR');
    $crit->add(new Criteria('conf_name', 'activation_type'), 'OR');
    $myConfigs =& $config_handler->getConfigs($crit);
    
    foreach($myConfigs as $myConf){
        $xoopsConfigUser[$myConf->getVar('conf_name')] = $myConf->getVar('conf_value');
    }
    if ($xoopsConfigUser['allow_register'] == 0) {    // Use to doublecheck that anonymous users are allowed to register
    	header("Location: ".MLDOCS_BASE_URL."/error.php");    
    } else {
        header("Location: ".MLDOCS_BASE_URL."/anon_addArchive.php"); 
    }
    exit();
}

function _saveArchive($fields = "")
{
    global $_mldocsSession, $isStaff, $repid;
    $_mldocsSession->set('mldocs_archive', 
                  array('uid' => $_POST['user_id'],
                        'repid' => $repid,
                        'codearchive' => $_POST['codearchive'],
                        'subject' => $_POST['subject'],
                        'description' => htmlspecialchars($_POST['description'], ENT_QUOTES),
                        'department' => $_POST['departments'],
                        'priority' => $_POST['priority']));
                          
    if($isStaff && $_COOKIE['mldocs_logMode'] == 2){
        $_mldocsSession->set('mldocs_response', 
                      array('uid' => $_POST['user_id'],
                            'message' => $_POST['response'],
                            'timeSpent' => $_POST['timespent'],
                            'userIP' => getenv("REMOTE_ADDR"),
                            'private' => (isset($_POST['private'])) ? 1 : 0,
                            'status' => $_POST['status'],
                            'owner' => $_POST['owner']));
    }
    if($fields != ""){
        $_mldocsSession->set('mldocs_custFields', $fields);
    }
    
    return true;
}
?>
