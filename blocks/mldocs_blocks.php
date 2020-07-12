<?php
//$Id: mldocs_blocks.php,v 1.61 2005/10/05 17:51:21 ackbarr Exp $
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

if (!defined('MLDOCS_CONSTANTS_INCLUDED')) {
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
}

include_once(MLDOCS_BASE_PATH.'/functions.php');
include_once(MLDOCS_CLASS_PATH.'/session.php');
mldocsIncludeLang('main');

function b_mldocs_open_show($options)
{
    global $xoopsUser;
    
    $max_char_in_title = $options[0];
    
    if($xoopsUser){
        $uid = $xoopsUser->getVar('uid');   // Get uid
        $block = array();
        $hArchives =& mldocsGetHandler('archive');  // Get archive handler
        $hStaff =& mldocsGetHandler('staff');
        if($isStaff =& $hStaff->isStaff($xoopsUser->getVar('uid'))){
            $crit = new CriteriaCompo(new Criteria('ownership', $uid));
            $crit->add(new Criteria('status', 2, '<'));
            $crit->setOrder('DESC');
            $crit->setSort('priority, posted');
            $crit->setLimit(5);
            $archives =& $hArchives->getObjects($crit);
            
            foreach($archives as $archive){
                $overdue = false;
                if($archive->isOverdue()){
                    $overdue = true;
                }
                $block['archive'][] = array('id'=>$archive->getVar('id'),
                                           'uid'=>$archive->getVar('uid'),
                                           'subject'=>$archive->getVar('subject'),
                                           'truncSubject'=>xoops_substr($archive->getVar('subject'), 0, $max_char_in_title),
                                           'description'=>$archive->getVar('description'),
                                           //'department'=>$department->getVar('department'),
                                           'priority'=>$archive->getVar('priority'),
                                           'status'=>$archive->getVar('status'),
                                           'posted'=>$archive->posted(),
                                           //'ownership'=>$owner->getVar('uname'),
                                           'closedBy'=>$archive->getVar('closedBy'),
                                           'totalTimeSpent'=>$archive->getVar('totalTimeSpent'),
                                           //'uname'=>$user->getVar('uname'),
                                           'userinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $archive->getVar('uid'),
                                           //'ownerinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $archive->getVar('ownership'),
                                           'url'=>XOOPS_URL . '/modules/mldocs/archive.php?id=' . $archive->getVar('id'),
                                           'overdue' => $overdue);
            }
            
            $block['isStaff'] = true;
            $block['viewAll'] = XOOPS_URL . '/modules/mldocs/index.php?op=staffViewAll';
            $block['viewAllText'] = _MB_MLDOCS_TEXT_VIEW_ALL_OPEN;
            $block['priorityText'] = _MB_MLDOCS_TEXT_PRIORITY;
            $block['noArchives'] = _MB_MLDOCS_TEXT_NO_ARCHIVES;
        } else {
            $crit = new CriteriaCompo(new Criteria('uid', $uid));
            $crit->add(new Criteria('status', 2, '<'));
            $crit->setOrder('DESC');
            $crit->setSort('priority, posted');
            $crit->setLimit(5);
            $archives =& $hArchives->getObjects($crit);
            $hDepartments =& mldocsGetHandler('department');
            
            foreach($archives as $archive){
                //$department =& $hDepartments->get($archive->getVar('department'));
                $block['archive'][] = array('id'=>$archive->getVar('id'),
                                           'uid'=>$archive->getVar('uid'),
                                           'subject'=>$archive->getVar('subject'),
                                           'truncSubject'=>xoops_substr($archive->getVar('subject'), 0, $max_char_in_title),
                                           'description'=>$archive->getVar('description'),
                                           //'department'=>($department->getVar('department'),
                                           'priority'=>$archive->getVar('priority'),
                                           'status'=>$archive->getVar('status'),
                                           'posted'=>$archive->posted(),
                                           //'ownership'=>$owner->getVar('uname'),
                                           'closedBy'=>$archive->getVar('closedBy'),
                                           'totalTimeSpent'=>$archive->getVar('totalTimeSpent'),
                                           //'uname'=>$user->getVar('uname'),
                                           'userinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $archive->getVar('uid'),
                                           //'ownerinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $archive->getVar('ownership'),
                                           'url'=>XOOPS_URL . '/modules/mldocs/archive.php?id=' . $archive->getVar('id'));
            }
        }
        $block['numArchives'] = count($archives);
        $block['noArchives'] = _MB_MLDOCS_TEXT_NO_ARCHIVES;
        unset($archives);
        $block['picPath'] = XOOPS_URL . '/modules/mldocs/images/';
        return $block;
    }
}

function b_mldocs_performance_show($options)
{
    global $xoopsUser, $xoopsDB;
    $dirname = 'mldocs';
    $block = array();
    
    if (!$xoopsUser) {
        return false;
    }
    
    //Determine if the GD library is installed
    $block['use_img'] = function_exists("imagecreatefrompng");

    $xoopsModule =& mldocsGetModule();
    
    if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
        $sql = sprintf(
            "SELECT COUNT(*) as ArchiveCount, d.department, d.id FROM %s t INNER JOIN %s d ON t.department = d.id  INNER JOIN %s s ON t.status = s.id WHERE s.state = 1 GROUP BY d.department, d.id ORDER BY d.department", 
            $xoopsDB->prefix('mldocs_archives'), $xoopsDB->prefix('mldocs_departments'), $xoopsDB->prefix('mldocs_status'));
    } else {
        $sql = sprintf(
            "SELECT COUNT(*) as ArchiveCount, d.department, d.id FROM %s t INNER JOIN %s j on t.department = j.department INNER JOIN %s d ON t.department = d.id INNER JOIN %s s on t.status = s.id WHERE s.state = 1 AND j.uid = %u GROUP BY d.department, d.id", 
            $xoopsDB->prefix('mldocs_archives'), $xoopsDB->prefix('mldocs_jStaffDept'), $xoopsDB->prefix('mldocs_departments'), $xoopsDB->prefix('mldocs_status'), $xoopsUser->getVar('uid'));
    }
    
    $ret = $xoopsDB->query($sql);
    
    $depts = array();
    $max_open = 0;
    while ($myrow = $xoopsDB->fetchArray($ret)) {
        $max_open = max($max_open,$myrow['ArchiveCount']);
        $url = mldocsMakeURI(MLDOCS_BASE_URL.'/index.php', array('op'=>'staffViewAll', 'dept'=>$myrow['id'], 'state'=>1));
        $depts[] = array('id'=>$myrow['id'], 'archives'=>$myrow['ArchiveCount'], 'name'=>$myrow['department'], 'url'=>$url);
    }
    
    if (count($depts) == 0) {
        return false;
    }
    
    if ($block['use_img']) {
        //Retrieve the image path for each department
        for($i = 0; $i < count($depts); $i++) {
            $depts[$i]['img'] = _mldocs_getDeptImg($depts[$i]['id'], $depts[$i]['archives'], $max_open, $i);
        }
    }
    
    $block['departments'] = $depts;
    
    return $block;
}

function _mldocs_getDeptImg($dept, $archives, $max, $counter = 0)
{
    $dept = intval($dept);
    $archives = intval($archives);
    $max = intval($max);
    $counter = intval($counter);
    
    $width = 60;   //Width of resulting image
    
    $cachedir_local = MLDOCS_CACHE_PATH .'/';
    $cachedir_www = MLDOCS_CACHE_URL .'/';
    $imgdir = MLDOCS_IMAGE_PATH.'/';
    $filename = "mldocs_perf_$dept.png";
    
    $colors = array('green', 'orange', 'red', 'blue');
    
    if (!is_file($cachedir_local.$filename)) {
        //Generate Progress Image
        $cur_color  = $colors[$counter % count($colors)];
        $bg         = @imagecreatefrompng($imgdir.'dept-bg.png');
        $fill       = @imagecreatefrompng($imgdir."dept-$cur_color.png");
        $bg_cap     = @imagecreatefrompng($imgdir.'dept-bg-cap.png');
        $fill_cap   = @imagecreatefrompng($imgdir.'dept-fill-cap.png');
        $fill_width = round((($width - imagesx($bg_cap)) * $archives) / $max) - imagesx($fill_cap);
        
        $image = imagecreatetruecolor($width, imagesy($bg));
        imagecopy($image, $bg, 0, 0, 0, 0, imagesx($bg), $width - imagesx($bg_cap));
        imagecopy($image, $bg_cap, $width - imagesx($bg_cap), 0, 0, 0, imagesx($bg_cap), imagesy($bg_cap));
        imagecopy($image, $fill, 0, 0, 0, 0, $fill_width, imagesy($fill));
        imagecopy($image, $fill_cap, $fill_width, 0, 0, 0, imagesx($fill_cap), imagesy($fill_cap));
        
        imagepng($image, $cachedir_local.$filename);
    }
    
    return ($cachedir_www.$filename);
}

function b_mldocs_recent_show($options)
{
    if(!isset($_COOKIE['mldocs_recent_archives'])){
        return false;
    } else {
        $tmp   = $_COOKIE['mldocs_recent_archives'];
    }
    
    $block = array();
        
    if (strlen($tmp) > 0) {
        $tmp2 = explode(',', $tmp);
        
        $crit    = new Criteria('id', "(". $tmp . ")", 'IN', 't');
        $hArchive = mldocsGetHandler('archive');
        $archives = $hArchive->getObjects($crit, true);
        
        foreach ($tmp2 as $ele) {
            if (isset($archives[intval($ele)])) {
                $archive =& $archives[intval($ele)];
                
                $overdue = false;
                if($archive->isOverdue()){
                    $overdue = true;
                }
                
                $block['archives'][] = array('id' => $archive->getVar('id'), 
                            'trim_subject' => xoops_substr($archive->getVar('subject'), 0, 25),
                            'subject' => $archive->getVar('subject'),
                            'url' => XOOPS_URL . '/modules/mldocs/archive.php?id='.$archive->getVar('id'),
                            'overdue' => $overdue);
            }
        }  
        $block['archivecount'] = count($archives);
        return $block;   
    } else {
        return false;
    }
}

function b_mldocs_actions_show()
{   
    
    $_mldocsSession = new Session();
    global $archiveInfo, $xoopsUser, $xoopsModule, $xoopsModuleConfig, $archiveInfo, $staff, $xoopsConfig;
    
    $module_handler =& xoops_gethandler('module');
    $config_handler =& xoops_gethandler('config');
    $member_handler =& xoops_gethandler('member');
    $hArchives       =& mldocsGetHandler('archive');
    $hMembership    =& mldocsGetHandler('membership');
    $hStaff         =& mldocsGetHandler('staff');
    $hDepartment    =& mldocsGetHandler('department');
    
    //Don't show block for anonymous users or for non-staff members
    if (!$xoopsUser) {
        return false;
    }
    
    //Don't show block if outside the mldocs module'
    if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != 'mldocs') {
        return false;
    }
    
    $block = array();
    
    $myPage = $_SERVER['PHP_SELF'];
	$currentPage = substr(strrchr($myPage, "/"), 1);
    if(($currentPage <> 'archive.php') || ($xoopsModuleConfig['mldocs_staffArchiveAction'] <> 2)){
        return false;
    }
    
    if(isset($_GET['id'])){
        $block['archiveid'] = intval($_GET['id']);
    } else {
        return false;
    }
    
    //Use Global $archiveInfo object (if exists)
    if (!isset($archiveInfo)) {    
        $archiveInfo =& $hArchives->get($block['archiveid']);
    }
    

    
    
    if($xoopsModuleConfig['mldocs_staffArchiveAction'] == 2){
        $aOwnership = array();
        $aOwnership[] = array('uid' => 0,
                              'uname' => _MLDOCS_NO_OWNER);
        if(isset($staff)){
            foreach($staff as $stf){
                //** BTW - Need to have a way to get all XoopsUser objects for the staff in 1 shot
                //$own =& $member_handler->getUser($stf->getVar('uid'));    // Create user object
                $aOwnership[] = array('uid'=>$stf->getVar('uid'),
                                              'uname'=>'');
                $all_users[$stf->getVar('uid')] = '';
            }
        } else {
            return false;
        }
        
        $xoopsDB =& Database::getInstance();
        $users = array();
        
        //@Todo - why is this query here instead of using a function or the XoopsMemberHandler?
        $sql = sprintf("SELECT uid, uname, name FROM %s WHERE uid IN (%s)", $xoopsDB->prefix('users'), implode(array_keys($all_users), ','));
        $ret = $xoopsDB->query($sql);
        $displayName = $xoopsModuleConfig['mldocs_displayName'];
        while($member = $xoopsDB->fetchArray($ret)){
            if(($displayName == 2) && ($member['name'] <> '')){
                $users[$member['uid']] = $member['name'];
            } else {
                $users[$member['uid']] = $member['uname'];
            }
        }
        
        for($i=0;$i<count($aOwnership);$i++){
            if(isset($users[$aOwnership[$i]['uid']])){
                $aOwnership[$i]['uname'] = $users[$aOwnership[$i]['uid']];
            }
        }
        $block['ownership'] = $aOwnership;
    }
    
    $block['imagePath'] = MLDOCS_IMAGE_URL.'/';
    $block['mldocs_priorities']      = array(1, 2, 3, 4, 5);
    $block['mldocs_priorities_desc'] = array('5' => _MLDOCS_PRIORITY5, '4' => _MLDOCS_PRIORITY4,'3' => _MLDOCS_PRIORITY3, '2' => _MLDOCS_PRIORITY2, '1' => _MLDOCS_PRIORITY1);
    $block['archive_priority']  = $archiveInfo->getVar('priority');
    $block['archive_status']    = $archiveInfo->getVar('status');
    $block['mldocs_status0']    = _MLDOCS_STATUS0;
    $block['mldocs_status1']    = _MLDOCS_STATUS1;
    $block['mldocs_status2']    = _MLDOCS_STATUS2;
    $block['archive_ownership'] = $archiveInfo->getVar('ownership');
    
    $block['mldocs_has_changeOwner'] = false;
    if($archiveInfo->getVar('uid') == $xoopsUser->getVar('uid')){
        $block['mldocs_has_addResponse'] = true;
    } else {
        $block['mldocs_has_addResponse'] = false;
    }
    $block['mldocs_has_editArchive'] = false;
    $block['mldocs_has_deleteArchive'] = false;
    $block['mldocs_has_changePriority'] = false;
    $block['mldocs_has_changeStatus'] = false;
    $block['mldocs_has_editResponse'] = false;
    $block['mldocs_has_mergeArchive'] = false;
    $rowspan = 2;
    $checkRights = array(
        _MLDOCS_SEC_ARCHIVE_OWNERSHIP => array('mldocs_has_changeOwner', false),
        _MLDOCS_SEC_RESPONSE_ADD => array('mldocs_has_addResponse', false),
        _MLDOCS_SEC_ARCHIVE_EDIT => array('mldocs_has_editArchive', true),
        _MLDOCS_SEC_ARCHIVE_DELETE => array('mldocs_has_deleteArchive', true),
        _MLDOCS_SEC_ARCHIVE_MERGE => array('mldocs_has_mergeArchive', true),
        _MLDOCS_SEC_ARCHIVE_PRIORITY => array('mldocs_has_changePriority', false),
        _MLDOCS_SEC_ARCHIVE_STATUS => array('mldocs_has_changeStatus', false),
        _MLDOCS_SEC_RESPONSE_EDIT => array('mldocs_has_editResponse', false),
        _MLDOCS_SEC_FILE_DELETE => array('mldocs_has_deleteFile', false));
        
   
    $checkStaff =& $hStaff->getByUid($xoopsUser->getVar('uid'));
    // See if this user is accepted for this archive
    $hArchiveEmails =& mldocsGetHandler('archiveEmails');
    $crit = new CriteriaCompo(new Criteria('archiveid', $archiveInfo->getVar('id')));
    $crit->add(new Criteria('uid', $xoopsUser->getVar('uid')));
    $archiveEmails =& $hArchiveEmails->getObjects($crit);
    
    //Retrieve all departments
    $crit = new Criteria('','');
    $crit->setSort('department');
    $alldepts = $hDepartment->getObjects($crit);
    $aDept = array();
    foreach($alldepts as $dept){
        $aDept[$dept->getVar('id')] = $dept->getVar('department');
    }
    unset($alldepts);
    $block['departments'] =& $aDept;
    $block['departmentid'] = $archiveInfo->getVar('department');
    

    foreach ($checkRights as $right=>$desc) {
        if(($right == _MLDOCS_SEC_RESPONSE_ADD) && count($archiveEmails > 0)){
            $block[$desc[0]] = true;
            continue;
        }
        if(($right == _MLDOCS_SEC_ARCHIVE_STATUS) && count($archiveEmails > 0)){
            $block[$desc[0]] = true;
            continue;
        }
        if ($hasRights = $checkStaff->checkRoleRights($right, $archiveInfo->getVar('department'))) {
            $block[$desc[0]] = true;
            if ($desc[1]) {
                $rowspan ++;
            }
        }
        
    }
    
    $block['mldocs_actions_rowspan'] = $rowspan;
    
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
    
    $block['statuses'] = $aStatuses;
    
    return $block;
}

function b_mldocs_actions_edit($options)
{
	$form = "<table>";
	$form .= "<tr>";
	$form .= "<td>" . _MB_MLDOCS_TRUNCATE_TITLE . "</td>";
	$form .= "<td>" . "<input type='text' name='options[]' value='" . $options[0] . "' /></td>";
	$form .= "</tr>";
	$form .= "</table>";
	
	return $form;
}

function b_mldocs_mainactions_show($options)
{   
    
    global $xoopsUser, $isStaff;
	$dirname = 'mldocs';
	$block['linkPath'] = MLDOCS_BASE_URL.'/';
    $block['imagePath'] = MLDOCS_IMAGE_URL.'/';
    $block['menustyle'] = $options[0];
    $block['showicon'] = !$block['menustyle'] && $options[1];
    $block['startitem'] = !$block['menustyle'] ? '<li>' : '';
    $block['enditem'] = !$block['menustyle'] ? '</li>' : '';
    $block['startblock'] = !$block['menustyle'] ? '<ul>' : '<table cellspacing="0"><tr><td id="usermenu">';
    $block['endblock'] = !$block['menustyle'] ? '</ul>' : '</td></tr></table>';
	$block['savedSearches'] = false;
	$block['items'][0] = array( 'link' => 'anon_addArchive.php', 'image' => 'addArchive.png', 'text' => _MLDOCS_MENU_LOG_ARCHIVE );
        
	if($xoopsUser){
		$block['items'][0] = array( 'link' => 'index.php', 'image' => 'main.png', 'text' => _MLDOCS_MENU_MAIN );
		$block['items'][1] = array( 'link' => 'addArchive.php', 'image' => 'addArchive.png', 'text' => _MLDOCS_MENU_LOG_ARCHIVE );
		$block['items'][2] = array( 'link' => 'index.php?viewAllArchives=1&op=userViewAll', 'image' => 'archive.png', 'text' => _MLDOCS_MENU_ALL_ARCHIVES );
	    $hStaff =& mldocsGetHandler('staff');
	    if($mldocs_staff =& $hStaff->getByUid($xoopsUser->getVar('uid'))){
	        $block['whoami'] = 'staff';
	        $block['items'][3] = array( 'link' => 'search.php', 'image' => 'search2.png', 'text' => _MLDOCS_MENU_SEARCH );
       		$block['items'][4] = array( 'link' => 'profile.php', 'image' => 'profile.png', 'text' => _MLDOCS_MENU_MY_PROFILE );
			$block['items'][2] = array( 'link' => 'index.php?viewAllArchives=1&op=staffViewAll', 'image' => 'archive.png', 'text' => _MLDOCS_MENU_ALL_ARCHIVES );
	        $hSavedSearch =& mldocsGetHandler('savedSearch');
			$savedSearches =& $hSavedSearch->getByUid($xoopsUser->getVar('uid'));
			$aSavedSearches = array();
			foreach($savedSearches as $sSearch){
				$aSavedSearches[$sSearch->getVar('id')] = array('id' => $sSearch->getVar('id'),
																'name' => $sSearch->getVar('name'),
																'search' => $sSearch->getVar('search'),
																'pagenav_vars' => $sSearch->getVar('pagenav_vars'));
			}
			$block['savedSearches'] = (count($aSavedSearches) < 1) ? false : $aSavedSearches;
		}
	}
    
    return $block;
}

function b_mldocs_mainactions_edit($options)
{	
	$form  = "<table border='0'>";
	
	// Menu style
	$form .= "<tr><td>"._MB_MLDOCS_TEXT_MENUSTYLE."</td><td>";
	$form .= "<input type='radio' name='options[0]' value='0'".(($options[0]==0)?" checked='checked'":"")." />"._MB_MLDOCS_OPTION_MENUSTYLE1."";
	$form .= "<input type='radio' name='options[0]' value='1'".(($options[0]==1)?" checked='checked'":"")." />"._MB_MLDOCS_OPTION_MENUSTYLE2."</td></tr>";

	// Auto select last items
	$form .= "<tr><td>"._MB_MLDOCS_TEXT_SHOWICON."</td><td>";
	$form .= "<input type='radio' name='options[1]' value='0'".(($options[1]==0)?" checked='checked'":"")." />"._NO."";
	$form .= "<input type='radio' name='options[1]' value='1'".(($options[1]==1)?" checked='checked'":"")." />"._YES."</td></tr>";
		
	$form .= "</table>";
	return $form;
}

?>