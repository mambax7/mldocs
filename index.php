<?php
/*$Id: index.php,v 0.53 2005/11/16 16:04:19 eric_juden Exp $
  modification gabybob pour BYOOS    2007/02/011 11:51                      */
require_once('header.php');
require_once(MLDOCS_CLASS_PATH.'/logService.php');
require_once(MLDOCS_CLASS_PATH.'/notificationService.php');
require_once(MLDOCS_CLASS_PATH.'/cacheService.php');
require_once(MLDOCS_CLASS_PATH.'/staffService.php');
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');

// Setup event handlers for page
$_eventsrv->advise('batch_dept', mldocs_logService::singleton());
$_eventsrv->advise('batch_dept', mldocs_notificationService::singleton());
$_eventsrv->advise('batch_priority', mldocs_logService::singleton());
$_eventsrv->advise('batch_priority', mldocs_notificationService::singleton());
$_eventsrv->advise('batch_status', mldocs_logService::singleton());
$_eventsrv->advise('batch_status', mldocs_notificationService::singleton());
$_eventsrv->advise('batch_status', mldocs_cacheService::singleton());
$_eventsrv->advise('batch_status', mldocs_staffService::singleton());
$_eventsrv->advise('batch_owner', mldocs_logService::singleton());
$_eventsrv->advise('batch_owner', mldocs_notificationService::singleton());
$_eventsrv->advise('batch_response', mldocs_logService::singleton());
$_eventsrv->advise('batch_response', mldocs_notificationService::singleton());
$_eventsrv->advise('batch_response', mldocs_staffService::singleton());
$_eventsrv->advise('batch_delete_archive', mldocs_notificationService::singleton());

//Initialise Necessary Data Handler Classes
$hStaff       =& mldocsGetHandler('staff');
$hXoopsMember =& xoops_gethandler('member');        
$hDepartments =& mldocsGetHandler('department');
$hMembership  =& mldocsGetHandler('membership');
$hArchives     =& mldocsGetHandler('archive');
$hArchiveList  =& mldocsGetHandler('archiveList');
$hSavedSearch =& mldocsGetHandler('savedSearch');

//Determine default 'op' (if none is specified)
$uid     = 0;
if ($xoopsUser) {
    $uid = $xoopsUser->getVar('uid');
    if ($mldocs_isStaff) {
        $op = 'staffMain';
    } else {
        $op = 'userMain';
    }
} else {
    $op = 'anonMain';
}

// Page Global Variables
$status_opt   = array(_MLDOCS_TEXT_SELECT_ALL => -1, _MLDOCS_STATUS0 => 0, _MLDOCS_STATUS1 => 1, _MLDOCS_STATUS2 => 2);
$state_opt    = array(_MLDOCS_TEXT_SELECT_ALL => -1, _MLDOCS_STATE1 => 1, _MLDOCS_STATE2 => 2);
$sort_columns = array();
$sort_order   = array('ASC', 'DESC');
$vars         = array('op', 'limit', 'start', 'sort', 'order', 'refresh');
$all_users    = array();
$refresh      = $start = $limit = 0;
$sort         = '';
$order        = '';

//Initialize Variables
foreach ($vars as $var) {
    if (isset($_REQUEST[$var])) {
        $$var = $_REQUEST[$var];
    }
}

//Ensure Criteria Fields hold valid values
$limit = intval($limit);
$start = intval($start);
$sort  = strtolower($sort);
$order = (in_array(strtoupper($order), $sort_order) ? $order : 'ASC');

$displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed

switch($op) {

case 'staffMain':              
    staffmain_display();
    break;

case 'staffViewAll':
    staffviewall_display();
    break;

case 'userMain':
    usermain_display();
    break;
    
case 'userViewAll':
    userviewall_display();
    break;

case 'setdept':
    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }
    
    
    if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_EDIT)){
        $message = _MLDOCS_MESSAGE_NO_EDIT_ARCHIVE;
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, $message);
    }
    
    if (isset($_POST['setdept'])) {
        setdept_action();
    } else {
        setdept_display();     
    }
    break;

case 'setpriority':
    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }
    
    if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_PRIORITY)){
        $message = _MLDOCS_MESSAGE_NO_CHANGE_PRIORITY;
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, $message);
    }
    
    if (isset($_POST['setpriority'])) {
        setpriority_action();
    } else {
        setpriority_display();
    }
    break;

case 'setstatus':
    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }
    
    if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_STATUS)){
        $message = _MLDOCS_MESSAGE_NO_CHANGE_STATUS;
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, $message);
    }
    
    if (isset($_POST['setstatus'])) {
        setstatus_action();
    } else {
        setstatus_display();
    }
    break;

case 'setowner':
    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }
    
    if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_OWNERSHIP)){
        $message = _MLDOCS_MESSAGE_NO_CHANGE_OWNER;
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, $message);
    }
    
    if (isset($_POST['setowner'])) {
        setowner_action();
    } else {
        setowner_display();
    }
    break;

case 'addresponse':
    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }
    
    if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_RESPONSE_ADD)){
        $message = _MLDOCS_MESSAGE_NO_ADD_RESPONSE;
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, $message);
    }
    
    if (isset($_POST['addresponse'])) {
        addresponse_action();
    } else {
        addresponse_display();
    }
    break;

case 'delete':
    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }
    
    if(!$hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_DELETE)){
        $message = _MLDOCS_MESSAGE_NO_DELETE_ARCHIVE;
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, $message);
    }
    
    if (isset($_POST['delete'])) {
        delete_action();
    } else {
        delete_display();
    }
    break;
    
case 'anonMain':
    $config_handler =& xoops_gethandler('config');
    $xoopsConfigUser = array();
    $crit = new CriteriaCompo(new Criteria('conf_name', 'allow_register'), 'OR');
    $crit->add(new Criteria('conf_name', 'activation_type'), 'OR');
    $myConfigs =& $config_handler->getConfigs($crit);
    
    foreach($myConfigs as $myConf){
        $xoopsConfigUser[$myConf->getVar('conf_name')] = $myConf->getVar('conf_value');
    }
    
    if ($xoopsConfigUser['allow_register'] == 0) {
    	header("Location: ".MLDOCS_BASE_URL."/error.php");
    } else {
        header("Location: ".MLDOCS_BASE_URL."/addArchive.php");
    }
    exit();
    break;
default:
    redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3);
    break;
}
/**
 * Perform data validation and update data store
 */
function setdept_action()
{
    global $_eventsrv;
	
	//Sanity Check: archives and department are supplied
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
    
    if (!isset($_POST['department'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_DEPARTMENT);
    }
    
    $archives  = _cleanArchives($_POST['archives']);
    $oArchives =& mldocsGetArchives($archives);
    $ret      = mldocsSetDept($archives, $_POST['department']);
    if ($ret) {
        $_eventsrv->trigger('batch_dept', array(@$oArchives, $_POST['department']));
        if (count($oArchives)>1) {
            redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_UPDATE_DEPARTMENT);
        } else {
            redirect_header(MLDOCS_BASE_URL."/archive.php?id=".$oArchives[0]->getVar('id'), 3, _MLDOCS_MESSAGE_UPDATE_DEPARTMENT);
        }
        end();
    }
    redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_UPDATE_DEPARTMENT_ERROR);
}

/**
 * Render form for the setdept archive action
 */
function setdept_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;

        
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
        
    $hDepartments =& mldocsGetHandler('department');
    $depts = $hDepartments->getObjects();
    $tplDepts = array();
    foreach ($depts as $dept) {
        $tplDepts[$dept->getVar('id')] = $dept->getVar('department');
    }
    unset($depts);
    
    
    
    $xoopsOption['template_main'] = 'mldocs_setdept.html';   // Set template
    require(XOOPS_ROOT_PATH.'/header.php');                  // Include the page header       
    $xoopsTpl->assign('mldocs_department_options', $tplDepts);
    $xoopsTpl->assign('mldocs_archives', implode($_POST['archives'], ',')); 
    require(XOOPS_ROOT_PATH.'/footer.php');   
}

function setpriority_action()
{
    global $_eventsrv;
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
    
    if (!isset($_POST['priority'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_PRIORITY);
    }
    $archives  = _cleanArchives($_POST['archives']);
    $oArchives =& mldocsGetArchives($archives);
    $ret      = mldocsSetPriority($archives, $_POST['priority']);
    if ($ret) {
        $_eventsrv->trigger('batch_priority', array(@$oArchives, $_POST['priority']));
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_UPDATE_PRIORITY);
    }
    redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_UPDATE_PRIORITY_ERROR); 
}

function setpriority_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
        
    //Make sure that some archives were selected        
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
        
    //Get Array of priorities/descriptions
    $aPriority  = array(1 => _MLDOCS_PRIORITY1, 2 => _MLDOCS_PRIORITY2, 3 => _MLDOCS_PRIORITY3, 4 => _MLDOCS_PRIORITY4, 5 => _MLDOCS_PRIORITY5);
        
    $xoopsOption['template_main'] = 'mldocs_setpriority.html';    // Set template
    require(XOOPS_ROOT_PATH.'/header.php');
    $xoopsTpl->assign('mldocs_priorities_desc', $aPriority);
    $xoopsTpl->assign('mldocs_priorities', array_keys($aPriority));
    $xoopsTpl->assign('mldocs_priority', 4);
    $xoopsTpl->assign('mldocs_imagePath', MLDOCS_IMAGE_URL .'/');
    $xoopsTpl->assign('mldocs_archives', implode($_POST['archives'], ','));
    require(XOOPS_ROOT_PATH.'/footer.php');
}

function setstatus_action()
{
    global $_eventsrv;
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
    
    if (!isset($_POST['status'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_STATUS);
    }
    $archives  = _cleanArchives($_POST['archives']);
    $oArchives =& mldocsGetArchives($archives);
    $ret      = mldocsSetStatus($archives, $_POST['status']);
    if ($ret) {
        $_eventsrv->trigger('batch_status', array(&$oArchives, $_POST['status']));
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_UPDATE_STATUS);
        end();
    }    
    redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_UPDATE_STATUS_ERROR);
    
}

function setstatus_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    $hStatus =& mldocsGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setOrder('ASC');
    $crit->setSort('description');
    $statuses =& $hStatus->getObjects($crit);
        
    //Make sure that some archives were selected        
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
    
    //Get Array of Status/Descriptions
    $aStatus = array();
    foreach($statuses as $status){
        $aStatus[$status->getVar('id')] = $status->getVar('description');
    }
        
    $xoopsOption['template_main'] = 'mldocs_setstatus.html'; // Set template
    require(XOOPS_ROOT_PATH.'/header.php');
    $xoopsTpl->assign('mldocs_status_options', $aStatus);
    $xoopsTpl->assign('mldocs_archives', implode($_POST['archives'], ','));
    require(XOOPS_ROOT_PATH.'/footer.php');
}

function setowner_action()
{
    global $_eventsrv;
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
    
    if (!isset($_POST['owner'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_OWNER);
    }
    $archives  = _cleanArchives($_POST['archives']);
    $oArchives = mldocsGetArchives($archives);
    $ret      = mldocsSetOwner($archives, $_POST['owner']);
   
    if ($ret) {
        $_eventsrv->trigger('batch_owner', array(&$oArchives, $_POST['owner']));
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_ASSIGN_OWNER);
        end();
    }    
    redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_ASSIGN_OWNER_ERROR);
}

function setowner_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
                
    //Make sure that some archives were selected        
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
        
    $hArchives     =& mldocsGetHandler('archive');
    $hMember      =& mldocsGetHandler('membership');
    $hXoopsMember =& xoops_gethandler('member');
        
    $depts = $hArchives->getArchiveDepartments($_POST['archives']);
    $users =& $hMember->membershipByDept($depts);
    
    $aOwners = array();
    foreach($users as $user){
        $aOwners[$user->getVar('uid')] = $user->getVar('uid');
    }
    $crit  = new Criteria('uid', "(". implode(array_keys($aOwners), ',') .")", 'IN');
    $owners =& mldocsGetUsers($crit, $xoopsModuleConfig['mldocs_displayName']);
        
    $a_users = array();
    foreach($owners as $owner_id=>$owner_name) {
        $a_users[$owner_id] = $owner_name;
    }
    unset($users);
    unset($owners);
    unset($aOwners);
        
    $xoopsOption['template_main'] = 'mldocs_setowner.html'; // Set template
    require(XOOPS_ROOT_PATH.'/header.php');
    $xoopsTpl->assign('mldocs_staff_ids', $a_users);
    $xoopsTpl->assign('mldocs_archives', implode($_POST['archives'], ','));
    require(XOOPS_ROOT_PATH.'/footer.php'); 
}

function addresponse_action()
{
    global $_eventsrv, $_mldocsSession;
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
    
    if (!isset($_POST['response'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_RESPONSE);
    }
    $private = isset($_POST['private']);
    
    $archives  =& _cleanArchives($_POST['archives']);
    $oArchives =& mldocsGetArchives($archives);
    $ret      = mldocsAddResponse($archives, $_POST['response'], $_POST['timespent'], $private);
    if ($ret) {
        $_mldocsSession->del('mldocs_batch_addresponse');
        $_mldocsSession->del('mldocs_batch_response');
        $_mldocsSession->del('mldocs_batch_timespent');
        $_mldocsSession->del('mldocs_batch_private');
        
        $_eventsrv->trigger('batch_response', array($oArchives, $_POST['response'], $_POST['timespent'], $private));
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_ADDRESPONSE);
        end();
    }
    redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_ADDRESPONSE_ERROR);    
    
}

function addresponse_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $_mldocsSession;
    $hResponseTpl =& mldocsGetHandler('responseTemplates');
    $archiveVar    = 'mldocs_batch_addresponse';        
    $tpl          = 0;
    $uid          = $xoopsUser->getVar('uid');
    
    //Make sure that some archives were selected
    if (!isset($_POST['archives'])) {
        if (!$archives = $_mldocsSession->get($archiveVar)) {
            redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
        }     
    } else {
        $archives = $_POST['archives'];
    }
    
    //Store archives in session so they won't be in URL
    $_mldocsSession->set($archiveVar, $archives);

    //Check if a predefined response was selected
    if (isset($_REQUEST['tpl'])) {
        $tpl = $_REQUEST['tpl'];
    }
        
    $xoopsOption['template_main'] = 'mldocs_batch_response.html';
    require(XOOPS_ROOT_PATH.'/header.php');
    $xoopsTpl->assign('mldocs_archives', implode($archives, ','));
    $xoopsTpl->assign('mldocs_formaction', basename(__FILE__));
    $xoopsTpl->assign('mldocs_imagePath', MLDOCS_IMAGE_URL .'/');
    $xoopsTpl->assign('mldocs_timespent', ($timespent =$_mldocsSession->get('mldocs_batch_timespent') ? $timespent: ''));
    $xoopsTpl->assign('mldocs_responseTpl', $tpl);
    
    //Get all staff defined templates
    $crit = new Criteria('uid', $uid);
    $crit->setSort('name');
    $responseTpl =& $hResponseTpl->getObjects($crit, true);
    
    //Fill Response Template Array
    $tpls = array();
    $tpls[0] = '------------------';
    
    foreach($responseTpl as $key=>$obj) {
        $tpls[$key] = $obj->getVar('name');
    }
    $xoopsTpl->assign('mldocs_responseTpl_options', $tpls);   
    //Get response message to display
    if (isset($responseTpl[$tpl])) {    // Display Template Text
        $xoopsTpl->assign('mldocs_response_message', $responseTpl[$tpl]->getVar('response', 'e'));
    } else {
        if ($response = $_mldocsSession->get('mldocs_batch_response')) {  //Display Saved Text
            $xoopsTpl->assign('mldocs_response_message', $response);
        }
    }
    
    //Private Message?
    $xoopsTpl->assign('mldocs_private', ($private = $_mldocsSession->get('mldocs_batch_private') ? $private : false));
     
    require(XOOPS_ROOT_PATH.'/footer.php');    
}

function delete_action()
{
    global $_eventsrv;
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }
    
    $archives  = _cleanArchives($_POST['archives']);
    $oArchives =& mldocsGetArchives($archives);
    $ret      = mldocsDeleteArchives($archives);
    if ($ret) {
        $_eventsrv->trigger('batch_delete_archive', array(@$oArchives));
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_DELETE_ARCHIVES);
        end();
    }
    redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _MLDOCS_MESSAGE_DELETE_ARCHIVES_ERROR);    
}

function delete_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
        
    //Make sure that some archives were selected
    if (!isset($_POST['archives'])) {
        redirect_header(MLDOCS_BASE_URL."/index.php", 3, _MLDOCS_MESSAGE_NO_ARCHIVES);
    }

    $hiddenvars = array('archives' => implode($_POST['archives'], ','), 
        'delete' => _MLDOCS_BUTTON_SET,
        'op' => 'delete');

    ob_start();
    xoops_confirm($hiddenvars, MLDOCS_BASE_URL."/".basename(__FILE__), _MLDOCS_MESSAGE_ARCHIVE_DELETE_CNFRM);
    $formtext = ob_get_contents();
    ob_end_clean();        
    $xoopsOption['template_main'] = 'mldocs_deletearchives.html';
    require(XOOPS_ROOT_PATH.'/header.php');
    $xoopsTpl->assign('mldocs_delform', $formtext);
    require(XOOPS_ROOT_PATH.'/footer.php');
}


/**
 * @todo make SmartyNewsRenderer class
 */
function getAnnouncements($topicid, $limit=5, $start=0)
{
    global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsTpl;
    $module_handler = xoops_gethandler('module');
   
    if(!$count =& $module_handler->getByDirname('news') || $topicid == 0){
        $xoopsTpl->assign('mldocs_useAnnouncements', false);
        return false;
    }
    include_once XOOPS_ROOT_PATH.'/modules/news/class/class.newsstory.php';
    $news_version = round($count->getVar('version') / 100, 2);
    
    switch ($news_version){
        case "1.1":
            $sarray = NewsStory::getAllPublished($limit, $start, $topicid);
        break;
            
        case "1.21":
        default:
            $sarray = NewsStory::getAllPublished($limit, $start, false, $topicid);        
    }
       
    $scount = count($sarray);
    for ( $i = 0; $i < $scount; $i++ ) {
    	$story = array();
    	$story['id'] = $sarray[$i]->storyid();
    	$story['poster'] = $sarray[$i]->uname();
    	if ( $story['poster'] != false ) {
    		$story['poster'] = "<a href='".XOOPS_URL."/userinfo.php?uid=".$sarray[$i]->uid()."'>".$story['poster']."</a>";
    	} else {
    		$story['poster'] = $xoopsConfig['anonymous'];
    	}
    	$story['posttime'] = formatTimestamp($sarray[$i]->published());
    	$story['text'] = $sarray[$i]->hometext();
    	$introcount = strlen($story['text']);
    	$fullcount = strlen($sarray[$i]->bodytext());
    	$totalcount = $introcount + $fullcount;
    	$morelink = '';
    	if ( $fullcount > 1 ) {
    		$morelink .= '<a href="'.XOOPS_URL.'/modules/news/article.php?storyid='.$sarray[$i]->storyid().'';
    		$morelink .= '">'._MLDOCS_ANNOUNCE_READMORE.'</a> | ';
    		//$morelink .= sprintf(_NW_BYTESMORE,$totalcount);
    		//$morelink .= ' | ';
    	}
    	$ccount = $sarray[$i]->comments();
    	$morelink .= '<a href="'.XOOPS_URL.'/modules/news/article.php?storyid='.$sarray[$i]->storyid().'';
        $morelink2 = '<a href="'.XOOPS_URL.'/modules/news/article.php?storyid='.$sarray[$i]->storyid().'';
    	if ( $ccount == 0 ) {
    		$morelink .= '">'._MLDOCS_COMMMENTS.'</a>';
    	} else {
    		if ( $fullcount < 1 ) {
    			if ( $ccount == 1 ) {
    				$morelink .= '">'._MLDOCS_ANNOUNCE_READMORE.'</a> | '.$morelink2.'">'._MLDOCS_ANNOUNCE_ONECOMMENT.'</a>';
    			} else {
    				$morelink .= '">'._MLDOCS_ANNOUNCE_READMORE.'</a> | '.$morelink2.'">';
    				$morelink .= sprintf(_MLDOCS_ANNOUNCE_NUMCOMMENTS, $ccount);
    				$morelink .= '</a>';
    			}
    		} else {
    			if ( $ccount == 1 ) {
    				$morelink .= '">'._MLDOCS_ANNOUNCE_ONECOMMENT.'</a>';
    			} else {
    				$morelink .= '">';
    				$morelink .= sprintf(_MLDOCS_ANNOUNCE_NUMCOMMENTS, $ccount);
    				$morelink .= '</a>';
    			}
    		}
    	}
    	$story['morelink'] = $morelink;
    	$story['adminlink'] = '';
    	if ( $xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()) ) {
    		$story['adminlink'] = $sarray[$i]->adminlink();
    	}
        //$story['mail_link'] = 'mailto:?subject='.sprintf(_NW_INTARTICLE,$xoopsConfig['sitename']).'&amp;body='.sprintf(_NW_INTARTFOUND, $xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/news/article.php?storyid='.$sarray[$i]->storyid();
    	$story['imglink'] = '';
    	$story['align'] = '';
    	if ( $sarray[$i]->topicdisplay() ) {
    		$story['imglink'] = $sarray[$i]->imglink();
    		$story['align'] = $sarray[$i]->topicalign();
    	}
    	$story['title'] = $sarray[$i]->textlink().'&nbsp;:&nbsp;'."<a href='".XOOPS_URL."/modules/news/article.php?storyid=".$sarray[$i]->storyid()."'>".$sarray[$i]->title()."</a>";
    	$story['hits'] = $sarray[$i]->counter();
    	// The line below can be used to display a Permanent Link image
        // $story['title'] .= "&nbsp;&nbsp;<a href='".XOOPS_URL."/modules/news/article.php?storyid=".$sarray[$i]->storyid()."'><img src='".XOOPS_URL."/modules/news/images/x.gif' alt='Permanent Link' /></a>";
    
    	$xoopsTpl->append('mldocs_announcements', $story);
    	$xoopsTpl->assign('mldocs_useAnnouncements', true);
    	unset($story);
    }
}

function getDepartmentName($dept)
{
    //BTW - I don't like that we rely on the global $depts variable to exist.
    // What if we moved this into the DepartmentsHandler class?
    global $depts;
    if(isset($depts[$dept])){     // Make sure that archive has a department
        $department = $depts[$dept]->getVar('department');
    } else {    // Else, fill it with 0
        $department = _MLDOCS_TEXT_NO_DEPT;
    }
    return $department;
}

function _cleanArchives($archives)
{
    $t_archives = explode(',', $archives);
    $ret   = array();
    foreach($t_archives as $archive) {
        $archive = intval($archive);
        if ($archive) {
            $ret[] = $archive;
        }
    }
    unset($t_archives);
    return $ret;
}

function staffmain_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $limit, $start, $refresh, $displayName, $mldocs_isStaff, $_mldocsSession, $_eventsrv, $mldocs_module_header;

    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }

    $mldocsConfig = mldocsGetModuleConfig();
    $aSavedSearches =& mldocsGetSavedSearches();
    $allSavedSearches =& mldocsGetGlobalSavedSearches();
    
    $hDepartments =& mldocsGetHandler('department');
    $hArchives     =& mldocsGetHandler('archive');
    $hArchiveList  =& mldocsGetHandler('archiveList');

    //Set Number of items in each section
    if ($limit == 0) {
        $limit = $mldocsConfig['mldocs_staffArchiveCount'];
    } elseif ($limit == -1) {
        $limit = 0;
    }
    $uid = $xoopsUser->getVar('uid');
    $depts       =& $hDepartments->getObjects(null, true);
    $priority    =& $hArchives->getStaffArchives($uid, MLDOCS_QRY_STAFF_HIGHPRIORITY, $start, $limit);
    $archiveLists =& $hArchiveList->getListsByUser($uid);
    $all_users   = array();
    
    $archives = array();
    $i = 0;
    foreach($archiveLists as $archiveList){
        $searchid = $archiveList->getVar('searchid');
        $crit     = $allSavedSearches[$searchid]['search'];
        $searchname = $allSavedSearches[$searchid]['name'];
        $searchOnCustFields = $allSavedSearches[$searchid]['hasCustFields'];
        $crit->setLimit($limit);
        $newArchives = $hArchives->getObjectsByStaff($crit, false, $searchOnCustFields);
        $archives[$i] = array();
        $archives[$i]['archives'] = array();
        $archives[$i]['searchid'] = $searchid;
        $archives[$i]['searchname'] = $searchname;
        $archives[$i]['tableid'] = _safeHTMLId($searchname);
        $archives[$i]['hasArchives'] = count($newArchives) > 0;
        $j = 0;
        foreach($newArchives as $archive){
            $dept = @$depts[$archive->getVar('department')];
            $archives[$i]['archives'][$j] = array('id'   => $archive->getVar('id'),
                            'uid'           => $archive->getVar('uid'),
                            'codearchive'   => xoops_substr($archive->getVar('codearchive'),0,15),
                            'subject'       => xoops_substr($archive->getVar('subject'),0,35),
                            'full_subject'  => $archive->getVar('subject'),
                            'description'   => $archive->getVar('description'),
                            'department'    => _safeDepartmentName($dept),
                            'departmentid'  => $archive->getVar('department'),
                            'departmenturl' => mldocsMakeURI('index.php', array('op' => 'staffViewAll', 'dept'=> $archive->getVar('department'))),
                            'priority'      => $archive->getVar('priority'),
                            'status'        => mldocsGetStatus($archive->getVar('status')),
                            'posted'        => $archive->posted(),
                            'ownership'     => _MLDOCS_MESSAGE_NOOWNER,
                            'ownerid'       => $archive->getVar('ownership'),
                            'closedBy'      => $archive->getVar('closedBy'),
                            'totalTimeSpent'=> $archive->getVar('totalTimeSpent'),
                            'uname'         => '',
                            'userinfo'      => MLDOCS_SITE_URL . '/userinfo.php?uid=' . $archive->getVar('uid'),
                            'ownerinfo'     => '',
                            'url'           => MLDOCS_BASE_URL . '/archive.php?id=' . $archive->getVar('id'),
                            'overdue'       => $archive->isOverdue());
            $all_users[$archive->getVar('uid')] = '';
            $all_users[$archive->getVar('ownership')] = '';
            $all_users[$archive->getVar('closedBy')] = '';
            $j++;
        }
        $i++;
        unset($newArchives);
    }
    
    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit  = new Criteria('uid', "(". implode(array_keys($all_users), ',') .")", 'IN');
        $users =& mldocsGetUsers($crit, $displayName);
    } else {
        $users = array();
    }        
    
	//Update archives with user information
    for($i=0; $i<count($archiveLists);$i++){
        for($j=0;$j<count($archives[$i]['archives']);$j++) {
           if (isset($users[ $archives[$i]['archives'][$j]['uid'] ])) {
                $archives[$i]['archives'][$j]['uname'] = $users[$archives[$i]['archives'][$j]['uid']];
            } else {
                $archives[$i]['archives'][$j]['uname'] = $xoopsConfig['anonymous'];
            }
            if ($archives[$i]['archives'][$j]['ownerid']) {
                if (isset($users[$archives[$i]['archives'][$j]['ownerid']])) {
                    $archives[$i]['archives'][$j]['ownership'] = $users[$archives[$i]['archives'][$j]['ownerid']];
                    $archives[$i]['archives'][$j]['ownerinfo'] = XOOPS_URL.'/userinfo.php?uid=' . $archives[$i]['archives'][$j]['ownerid'];
                }
            }
        }
    }
    
    $xoopsOption['template_main'] = 'mldocs_staff_index.html';   // Set template
    require(XOOPS_ROOT_PATH.'/header.php');                     // Include the page header    
    if($refresh > 0){
        $mldocs_module_header .= "<meta http-equiv=\"Refresh\" content=\"$refresh;url=".XOOPS_URL."/modules/mldocs/index.php?refresh=$refresh\">";
    }  
    $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
    $xoopsTpl->assign('mldocs_archiveLists', $archives);
    $xoopsTpl->assign('mldocs_hasArchiveLists', count($archives) > 0);
    $xoopsTpl->assign('mldocs_refresh', $refresh);  
    $xoopsTpl->assign('xoops_module_header',$mldocs_module_header);
    $xoopsTpl->assign('mldocs_imagePath', MLDOCS_IMAGE_URL .'/');
    $xoopsTpl->assign('mldocs_uid', $xoopsUser->getVar('uid'));
    $xoopsTpl->assign('mldocs_current_file', basename(__FILE__));
    $xoopsTpl->assign('mldocs_savedSearches', $aSavedSearches);
    $xoopsTpl->assign('mldocs_allSavedSearches', $allSavedSearches);
    
    getAnnouncements($mldocsConfig['mldocs_announcements']);
    
    require(XOOPS_ROOT_PATH.'/footer.php');
}

function _safeHTMLId($orig_text)
{
    //Only allow alphanumeric characters
    $match = array('/[^a-zA-Z0-9]]/', '/\s/');
    $replace = array('', '');
    
    $htmlID = preg_replace($match, $replace, $orig_text);
    
    return $htmlID;
}

function _safeDepartmentName($deptObj)
{
    if (is_object($deptObj)) {
        $department = $deptObj->getVar('department');
    } else {    // Else, fill it with 0
        $department = _MLDOCS_TEXT_NO_DEPT;
    }
    return $department;    
}

function staffviewall_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $mldocs_isStaff, $sort_order, $start, $limit, $mldocs_module_header, $state_opt, $aSavedSearches;
    if (!$mldocs_isStaff) {
        redirect_header(MLDOCS_BASE_URL."/".basename(__FILE__), 3, _NOPERM);
    }

	//Sanity Check: sort / order column valid
	$sort  = @$_REQUEST['sort'];
	$order = @$_REQUEST['order'];
	
	$sort_columns = array('id' => 'DESC', 'priority' => 'DESC', 'elapsed' => 'ASC', 'lastupdate' => 'ASC', 'status' => 'ASC', 'codearchive' => 'ASC' , 'department' => 'ASC', 'ownership' => 'ASC', 'uid' => 'ASC');
    $sort  = array_key_exists(strtolower($sort), $sort_columns) ? $sort : 'id';
    $order = (in_array(strtoupper($order), $sort_order) ? $order : $sort_columns[$sort]);
    
    $uid       = $xoopsUser->getVar('uid');    
    $dept      = intval(isset($_REQUEST['dept']) ? $_REQUEST['dept'] : 0);
    $codearchive = isset($_REQUEST['codearchive']) ? $_REQUEST['codearchive'] : '';
    $status    = intval(isset($_REQUEST['status']) ? $_REQUEST['status'] : -1);
    $ownership = intval(isset($_REQUEST['ownership']) ? $_REQUEST['ownership'] : -1);
    $state     = intval(isset($_REQUEST['state']) ? $_REQUEST['state'] : -1);
    
    $mldocsConfig  =& mldocsGetModuleConfig();
    $hArchives     =& mldocsGetHandler('archive');
    $hMembership  =& mldocsGetHandler('membership');
    
    if ($limit == 0) {
        $limit = $mldocsConfig['mldocs_staffArchiveCount'];
    } elseif ($limit == -1) {
        $limit = 0;
    }
	
	//Prepare Database Query and Querystring
    $crit     = new CriteriaCompo(new Criteria('uid', $uid, '=', 'j'));    
    $qs       = array('op' => 'staffViewAll', //Common Query String Values
		            'start' => $start,
		            'limit' => $limit);
 
    if ($dept) {
        $qs['dept'] = $dept;
        $crit->add(new Criteria('department', $dept, '=', 't'));
    }
    if($codearchive != ''){
        $qs['codearchive'] = $codearchive;
        $crit->add(new Criteria('codearchive', $codearchive, '=', 't'));
    }    
    if ($status != -1) {
        $qs['status'] = $status;
        $crit->add(new Criteria('status', $status, '=', 't'));
    }
    if ($ownership != -1) {
        $qs['ownership'] = $ownership;
        $crit->add(new Criteria('ownership', $ownership, '=', 't'));
    }
    
    if($state != -1){
        $qs['state'] = $state;
        $crit->add(new Criteria('state', $state, '=', 's'));
    }
    
    $crit->setLimit($limit);
    $crit->setStart($start);
    $crit->setSort($sort);
    $crit->setOrder($order);
	    
    //Setup Column Sorting Vars
    $tpl_cols = array();
    foreach ($sort_columns as $col=>$initsort) {
        $col_qs = array('sort' => $col);
		//Check if we need to sort by current column
        if ($sort == $col) {
            $col_qs['order'] = ($order == $sort_order[0] ? $sort_order[1]: $sort_order[0]);
            $col_sortby = true;
        } else {
            $col_qs['order'] = $initsort;
            $col_sortby = false;
        }
        $tpl_cols[$col] = array('url'=>mldocsMakeURI(basename(__FILE__), array_merge($qs, $col_qs)),
                        'urltitle' => _MLDOCS_TEXT_SORT_ARCHIVES,
                        'sortby' => $col_sortby,
                        'sortdir' => strtolower($col_qs['order']));
    }
    
       
    $allArchives  = $hArchives->getObjectsByStaff($crit, true);
    $count       = $hArchives->getCountByStaff($crit);
    $nav         = new XoopsPageNav($count, $limit, $start, 'start', "op=staffViewAll&amp;limit=$limit&amp;sort=$sort&amp;order=$order&amp;dept=$dept&amp;status=$status&amp;ownership=$ownership");
    $archives     = array();
    $allUsers    = array();
    $depts       =& $hMembership->membershipByStaff($xoopsUser->getVar('uid'), true);    //All Departments for Staff Member
    
    foreach($allArchives as $archive){
        $deptid = $archive->getVar('department');
        $archives[] = array('id'=>$archive->getVar('id'),
            'uid'=>$archive->getVar('uid'),
            'codearchive'       => xoops_substr($archive->getVar('codearchive'),0,15),
            'subject'       => xoops_substr($archive->getVar('subject'),0,35),
            'full_subject'  => $archive->getVar('subject'),
            'description'=>$archive->getVar('description'),
            'department'=>_safeDepartmentName($depts[$deptid]),
            'departmentid'=> $deptid,
            'departmenturl'=>mldocsMakeURI('index.php', array('op' => 'staffViewAll', 'dept'=> $deptid)),
            'priority'=>$archive->getVar('priority'),
            'status'=>mldocsGetStatus($archive->getVar('status')),
            'posted'=>$archive->posted(),
            'ownership'=>_MLDOCS_MESSAGE_NOOWNER,
            'ownerid' => $archive->getVar('ownership'),
            'closedBy'=>$archive->getVar('closedBy'),
            'closedByUname'=>'',
            'totalTimeSpent'=>$archive->getVar('totalTimeSpent'),
            'uname'=>'',
            'userinfo'=>MLDOCS_SITE_URL . '/userinfo.php?uid=' . $archive->getVar('uid'),
            'ownerinfo'=>'',
            'url'=>MLDOCS_BASE_URL . '/archive.php?id=' . $archive->getVar('id'),
            'elapsed' => $archive->elapsed(),
            'lastUpdate' => $archive->lastUpdate(),
            'overdue' => $archive->isOverdue());
        $allUsers[$archive->getVar('uid')] = '';
        $allUsers[$archive->getVar('ownership')] = '';
        $allUsers[$archive->getVar('closedBy')] = '';     
    }
    $has_allArchives = count($allArchives) > 0;
    unset($allArchives);
	
    //Get all member information needed on this page    
    $crit  = new Criteria('uid', "(". implode(array_keys($allUsers), ',') .")", 'IN');
    $users =& mldocsGetUsers($crit, $mldocsConfig['mldocs_displayName']);
	unset($allUsers);
	
	$staff_opt =& mldocsGetStaff($mldocsConfig['mldocs_displayName']);
    
    for($i=0;$i<count($archives);$i++) {
        if (isset($users[$archives[$i]['uid']])) {
            $archives[$i]['uname'] = $users[$archives[$i]['uid']]; 
        } else {
            $archives[$i]['uname'] = $xoopsConfig['anonymous'];
        }
        if ($archives[$i]['ownerid']) {
            if (isset($users[$archives[$i]['ownerid']])) {
                $archives[$i]['ownership'] = $users[$archives[$i]['ownerid']];
                $archives[$i]['ownerinfo'] = MLDOCS_SITE_URL.'/userinfo.php?uid=' . $archives[$i]['ownerid'];
            }
        }
        if ($archives[$i]['closedBy']) {
            if (isset($users[$archives[$i]['closedBy']])) {
                $archives[$i]['closedByUname'] = $users[$archives[$i]['closedBy']];
            }
        }
    }
                          
    $xoopsOption['template_main'] = 'mldocs_staff_viewall.html';   // Set template
    require(XOOPS_ROOT_PATH.'/header.php');                     // Include the page header
    
    $javascript = "<script type=\"text/javascript\" src=\"". MLDOCS_BASE_URL ."/include/functions.js\"></script>
<script type=\"text/javascript\" src='".MLDOCS_SCRIPT_URL."/changeSelectedState.php?client'></script>
<script type=\"text/javascript\">
<!--
function states_onchange()
{
    state = xoopsGetElementById('state');
    var sH = new mldocsweblib(stateHandler);
    sH.statusesbystate(state.value);
}

var stateHandler = {
    statusesbystate: function(result){
        var statuses = gE('status');
        mldocsFillSelect(statuses, result);
    }
}

function window_onload()
{
    mldocsDOMAddEvent(xoopsGetElementById('state'), 'change', states_onchange, true);
}

window.setTimeout('window_onload()', 1500);
//-->
</script>";
    
    $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
    $xoopsTpl->assign('mldocs_imagePath', MLDOCS_IMAGE_URL .'/');
    $xoopsTpl->assign('mldocs_cols', $tpl_cols);
    $xoopsTpl->assign('mldocs_allArchives', $archives);
    $xoopsTpl->assign('mldocs_has_archives', $has_allArchives);
    $xoopsTpl->assign('mldocs_priorities', array(5, 4, 3, 2, 1));
    $xoopsTpl->assign('xoops_module_header',$javascript.$mldocs_module_header);
    $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));
    if($limit != 0){
        $xoopsTpl->assign('mldocs_pagenav', $nav->renderNav());
    }
    $xoopsTpl->assign('mldocs_limit_options', array(-1 => _MLDOCS_TEXT_SELECT_ALL, 10 => '10', 15 => '15', 20 => '20', 30 => '30'));
    $xoopsTpl->assign('mldocs_filter', array('department' => $dept,
            'status' => $status,
            'state' => $state,
            'ownership' => $ownership,
            'limit' => $limit,
            'start' => $start,
            'sort' => $sort,
            'order' => $order));
    
    $xoopsTpl->append('mldocs_department_values', 0);
    $xoopsTpl->append('mldocs_department_options', _MLDOCS_TEXT_SELECT_ALL);
    
    if($mldocsConfig['mldocs_deptVisibility'] == 1){    // Apply dept visibility to staff members?
        $hMembership =& mldocsGetHandler('membership');
        $depts =& $hMembership->getVisibleDepartments($xoopsUser->getVar('uid'));
    }
    
    foreach($depts as $mldocs_id=>$obj) {
        $xoopsTpl->append('mldocs_department_values', $mldocs_id);
        $xoopsTpl->append('mldocs_department_options', $obj->getVar('department'));
    }

    $xoopsTpl->assign('mldocs_ownership_options', array_values($staff_opt));
    $xoopsTpl->assign('mldocs_ownership_values', array_keys($staff_opt));
    $xoopsTpl->assign('mldocs_state_options', array_keys($state_opt));
    $xoopsTpl->assign('mldocs_state_values', array_values($state_opt));
    $xoopsTpl->assign('mldocs_savedSearches', $aSavedSearches);

    $hStatus =& mldocsGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setSort('description');
    $crit->setOrder('ASC');
    $statuses =& $hStatus->getObjects($crit);
    
    $xoopsTpl->append('mldocs_status_options', _MLDOCS_TEXT_SELECT_ALL);
    $xoopsTpl->append('mldocs_status_values', -1);
    foreach($statuses as $status){
        $xoopsTpl->append('mldocs_status_options', $status->getVar('description'));
        $xoopsTpl->append('mldocs_status_values', $status->getVar('id'));
    }

    $xoopsTpl->assign('mldocs_department_current', $dept);
    $xoopsTpl->assign('mldocs_status_current', $status);
    $xoopsTpl->assign('mldocs_current_file', basename(__FILE__));
    $xoopsTpl->assign('mldocs_text_allArchives', _MLDOCS_TEXT_ALL_ARCHIVES);
    
    require(XOOPS_ROOT_PATH.'/footer.php');
}

function usermain_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $mldocs_module_header;
    
    $xoopsOption['template_main'] = 'mldocs_user_index.html';    // Set template
    require(XOOPS_ROOT_PATH.'/header.php');                     // Include the page header
    
    $mldocsConfig = mldocsGetModuleConfig();
    $hStaff =& mldocsGetHandler('staff');
    
    $staffCount =& $hStaff->getObjects();
    if (count($staffCount) == 0) {
        $xoopsTpl->assign('mldocs_noStaff', true);
    }
    /**
     * @todo remove calls to these three classes and use the ones in beginning
     */
    $member_handler =& xoops_gethandler('member');        
    $hDepartments =& mldocsGetHandler('department');
    $hArchives =& mldocsGetHandler('archive');
        
    $userArchives =& $hArchives->getMyUnresolvedArchives($xoopsUser->getVar('uid'), true);
    
    foreach($userArchives as $archive){
        $aUserArchives[] = array('id'=>$archive->getVar('id'),
            'uid'=>$archive->getVar('uid'),
            'codearchive'=>$archive->getVar('codearchive'),
            'status'=>mldocsGetStatus($archive->getVar('status')),
            'priority'=>$archive->getVar('priority'),
            'posted'=>$archive->posted());
    }
    $has_userArchives = count($userArchives) > 0;        
    if($has_userArchives){ 
        $xoopsTpl->assign('mldocs_userArchives', $aUserArchives);
    } else {
        $xoopsTpl->assign('mldocs_userArchives', 0);
    }
    $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
    $xoopsTpl->assign('mldocs_has_userArchives', $has_userArchives);
    $xoopsTpl->assign('mldocs_priorities', array(5, 4, 3, 2, 1));
    $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));        
    $xoopsTpl->assign('mldocs_imagePath', MLDOCS_IMAGE_URL .'/');
    $xoopsTpl->assign('xoops_module_header',$mldocs_module_header);
        
    getAnnouncements($mldocsConfig['mldocs_announcements']);
        
    require(XOOPS_ROOT_PATH.'/footer.php');                     //Include the page footer    
}

function userviewall_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $mldocs_module_header, $sort, $order, $sort_order, $limit, $start, $state_opt, $state;
    
    $xoopsOption['template_main'] = 'mldocs_user_viewall.html';    // Set template
    require(XOOPS_ROOT_PATH.'/header.php');                     // Include the page header

    //Sanity Check: sort column valid
    $sort_columns = array('id' => 'DESC', 'priority' => 'DESC', 'elapsed' => 'ASC', 'lastupdate' => 'ASC', 'status' => 'ASC', 'codearchive' => 'ASC' , 'department' => 'ASC', 'ownership' => 'ASC', 'uid' => 'ASC');
    $sort  = array_key_exists($sort, $sort_columns) ? $sort : 'id';
    $order = @$_REQUEST['order'];
    $order = (in_array(strtoupper($order), $sort_order) ? $order : $sort_columns[$sort]);
    $uid   = $xoopsUser->getVar('uid');
    
    $hDepartments =& mldocsGetHandler('department');
    $hArchives      =& mldocsGetHandler('archive');
    $hStaff       =& mldocsGetHandler('staff');
    
    $dept     = intval(isset($_REQUEST['dept']) ? $_REQUEST['dept'] : 0);
    $status   = intval(isset($_REQUEST['status']) ? $_REQUEST['status'] : -1);
    $state    = intval(isset($_REQUEST['state']) ? $_REQUEST['state'] : -1);
    $depts    =& $hDepartments->getObjects(null, true);
    
    if ($limit == 0) {
        $limit = 10;
    } elseif ($limit == -1) {
        $limit = 0;
    }
	
	//Prepare Database Query and Querystring
    $crit     = new CriteriaCompo(new Criteria ('uid', $uid));    
    $qs       = array('op' => 'userViewAll', //Common Query String Values
		            'start' => $start,
		            'limit' => $limit);
 
    if ($dept) {
        $qs['dept'] = $dept;
        $crit->add(new Criteria('department', $dept, '=', 't'));
    }
    if ($status != -1) {
        $qs['status'] = $status;
        $crit->add(new Criteria('status', $status, '=', 't'));
    }
    
    if($state != -1){
        $qs['state'] = $state;
        $crit->add(new Criteria('state', $state, '=', 's'));
    }
 
    $crit->setLimit($limit);
    $crit->setStart($start);
    $crit->setSort($sort);
    $crit->setOrder($order);
	    
    //Setup Column Sorting Vars
    $tpl_cols = array();
    foreach ($sort_columns as $col => $initsort) {
        $col_qs = array('sort' => $col);
		//Check if we need to sort by current column
        if ($sort == $col) {
            $col_qs['order'] = ($order == $sort_order[0] ? $sort_order[1]: $sort_order[0]);
            $col_sortby = true;
        } else {
            $col_qs['order'] = $initsort;
            $col_sortby = false;
        }
        $tpl_cols[$col] = array('url'=>mldocsMakeURI(basename(__FILE__), array_merge($qs, $col_qs)),
                        'urltitle' => _MLDOCS_TEXT_SORT_ARCHIVES,
                        'sortby' => $col_sortby,
                        'sortdir' => strtolower($col_qs['order']));
    }

    $xoopsTpl->assign('mldocs_cols', $tpl_cols);   
    $staffCount =& $hStaff->getObjects();
    if(count($staffCount) == 0){
        $xoopsTpl->assign('mldocs_noStaff', true);
    }

    $userArchives =& $hArchives->getObjects($crit);
    foreach($userArchives as $archive){
        $aUserArchives[] = array('id'=>$archive->getVar('id'),
                        'uid'=>$archive->getVar('uid'),
                        'codearchive'       => xoops_substr($archive->getVar('codearchive'),0,15),
                        'subject'       => xoops_substr($archive->getVar('subject'),0,35),
                        'full_subject'  => $archive->getVar('subject'),
                        'status'=>mldocsGetStatus($archive->getVar('status')),
                        'department'=>_safeDepartmentName($depts[$archive->getVar('department')]),
                        'departmentid'=> $archive->getVar('department'),
                        'departmenturl'=>mldocsMakeURI(basename(__FILE__), array('op' => 'userViewAll', 'dept'=> $archive->getVar('department'))),                        
                        'priority'=>$archive->getVar('priority'),
                        'posted'=>$archive->posted(),
                        'elapsed'=>$archive->elapsed());
    }
    $has_userArchives = count($userArchives) > 0;        
    if($has_userArchives){ 
        $xoopsTpl->assign('mldocs_userArchives', $aUserArchives);
    } else {
        $xoopsTpl->assign('mldocs_userArchives', 0);
    }
    
    $javascript = "<script type=\"text/javascript\" src=\"". MLDOCS_BASE_URL ."/include/functions.js\"></script>
<script type=\"text/javascript\" src='".MLDOCS_SCRIPT_URL."/changeSelectedState.php?client'></script>
<script type=\"text/javascript\">
<!--
function states_onchange()
{
    state = xoopsGetElementById('state');
    var sH = new mldocsweblib(stateHandler);
    sH.statusesbystate(state.value);
}

var stateHandler = {
    statusesbystate: function(result){
        var statuses = gE('status');
        mldocsFillSelect(statuses, result);
    }
}

function window_onload()
{
    mldocsDOMAddEvent(xoopsGetElementById('state'), 'change', states_onchange, true);
}

window.setTimeout('window_onload()', 1500);
//-->
</script>";
    
    $xoopsTpl->assign('mldocs_baseURL', MLDOCS_BASE_URL);
    $xoopsTpl->assign('mldocs_has_userArchives', $has_userArchives);
    $xoopsTpl->assign('mldocs_viewAll', true);
    $xoopsTpl->assign('mldocs_priorities', array(5, 4, 3, 2, 1));
    $xoopsTpl->assign('mldocs_priorities_desc', array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1));        
    $xoopsTpl->assign('mldocs_imagePath', MLDOCS_IMAGE_URL .'/');
    $xoopsTpl->assign('xoops_module_header',$javascript.$mldocs_module_header);
    $xoopsTpl->assign('mldocs_limit_options', array(-1 => _MLDOCS_TEXT_SELECT_ALL, 10 => '10', 15 => '15', 20 => '20', 30 => '30'));
    $xoopsTpl->assign('mldocs_filter', array('department' => $dept,
            'status' => $status,
            'limit' => $limit,
            'start' => $start,
            'sort' => $sort,
            'order' => $order,
            'state' => $state));
    $xoopsTpl->append('mldocs_department_values', 0);
    $xoopsTpl->append('mldocs_department_options', _MLDOCS_TEXT_SELECT_ALL);
    
    //$depts = getVisibleDepartments($depts);
    $hMembership =& mldocsGetHandler('membership');
    $depts =& $hMembership->getVisibleDepartments($xoopsUser->getVar('uid'));
    foreach($depts as $mldocs_id=>$obj) {
        $xoopsTpl->append('mldocs_department_values', $mldocs_id);
        $xoopsTpl->append('mldocs_department_options', $obj->getVar('department'));
    }
    
    $hStatus =& mldocsGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setSort('description');
    $crit->setOrder('ASC');
    $statuses =& $hStatus->getObjects($crit);
    
    $xoopsTpl->append('mldocs_status_options', _MLDOCS_TEXT_SELECT_ALL);
    $xoopsTpl->append('mldocs_status_values', -1);
    foreach($statuses as $status){
        $xoopsTpl->append('mldocs_status_options', $status->getVar('description'));
        $xoopsTpl->append('mldocs_status_values', $status->getVar('id'));
    } 

    $xoopsTpl->assign('mldocs_department_current', $dept);
    $xoopsTpl->assign('mldocs_status_current', $status);    
    $xoopsTpl->assign('mldocs_state_options', array_keys($state_opt));
    $xoopsTpl->assign('mldocs_state_values', array_values($state_opt));            
                
    require(XOOPS_ROOT_PATH.'/footer.php');
}
?>
