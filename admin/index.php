<?php   
/*$Id: index.php,v 1.142 2005/05/09 20:23:21 eric_juden Exp $
  modification de gabybob  16 aout 2007  BYOOS solutions */
include('../../../include/cp_header.php');          
       
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');

include_once('admin_header.php');    
global $HTTP_GET_VARS, $xoopsModule;
$module_id = $xoopsModule->getVar('mid');

$op = 'default';

if ( isset( $_REQUEST['op'] ) )
{
    $op = $_REQUEST['op'];
}

switch ( $op )
{
    case "about":
        about();
        break;
        
    case "mailEvents":
        mailEvents();
        break;
          
    case "searchMailEvents":
        searchMailEvents();
        break;

    case "blocks":
        require 'myblocksadmin.php';
        break;
        
	case "createdir":
	    createdir();
    	break;
    
    case "setperm":
        setperm();
        break;
    
    case "manageFields":
        manageFields();
        break;
               
    default:
        mldocs_default();
        break;
}

function modifyArchiveFields()
{
    //xoops_cp_header();
        //echo "not created yet";
    xoops_cp_footer();
}

function displayEvents($mailEvents, $mailboxes)
{
    echo "<table width='100%' cellspacing='1' class='outer'>";
    if(count($mailEvents) > 0){
        echo "<tr><th colspan='4'>"._AM_MLDOCS_TEXT_MAIL_EVENTS."</th></tr>";
        echo "<tr class='head'><td>"._AM_MLDOCS_TEXT_MAILBOX."</td>
                              <td>"._AM_MLDOCS_TEXT_EVENT_CLASS."</td>
                              <td>"._AM_MLDOCS_TEXT_DESCRIPTION."</td>
                              <td>"._AM_MLDOCS_TEXT_TIME."</td>
             </tr>";
        
        $class = 'odd';
        foreach($mailEvents as $event){
            echo "<tr class='". $class ."'><td>".$mailboxes[$event->getVar('mbox_id')]->getVar('emailaddress')."</td>
                      <td>".mldocsGetEventClass($event->getVar('event_class'))."</td>
                      <td>".$event->getVar('event_desc')."</td>
                      <td>".$event->posted()."</td>
                  </tr>";
            $class = ($class == 'odd') ? 'even' : 'odd';
        }
        
    } else {
        echo "<tr><th>"._AM_MLDOCS_TEXT_MAIL_EVENTS."</th></tr>";
        echo "<tr><td class='odd'>"._AM_MLDOCS_NO_EVENTS."</td></tr>";
    }
    echo "</table><br />";
    echo "<a href='index.php?op=searchMailEvents'>"._AM_MLDOCS_SEARCH_EVENTS."</a>";
}
    

function mailEvents()
{
    global $oAdminButton;
    // Will display the last 50 mail events
    $hMailEvent =& mldocsGetHandler('mailEvent');
    $hDeptMbox =& mldocsGetHandler('departmentMailBox');
    $mailboxes =& $hDeptMbox->getObjects(null, true);
    
    $crit = new Criteria('', '');
    $crit->setLimit(50);
    $crit->setOrder('DESC');
    $crit->setSort('posted');
    $mailEvents =& $hMailEvent->getObjects($crit);
    
    xoops_cp_header();
    echo $oAdminButton->renderButtons('mailEvents');
    
    displayEvents($mailEvents, $mailboxes);
    
    mldocs_adminFooter();
    xoops_cp_footer();
}

function searchMailEvents()
{
    global $oAdminButton;
    xoops_cp_header();
    echo $oAdminButton->renderButtons('mailEvents');
    
    if(!isset($_POST['searchEvents'])){
        
        $stylePath = include_once XOOPS_ROOT_PATH.'/include/calendarjs.php';
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.$stylePath.'" /><!--[if gte IE 5.5000]><script src="iepngfix.js" language="JavaScript" type="text/javascript"></script><![endif]-->';
    
        echo "<form method='post' action='".MLDOCS_ADMIN_URL."/index.php?op=searchMailEvents'>";
        
        echo "<table width='100%' cellspacing='1' class='outer'>";
        echo "<tr><th colspan='2'>"._AM_MLDOCS_SEARCH_EVENTS."</th></tr>";
        echo "<tr><td width='20%' class='head'>"._AM_MLDOCS_TEXT_MAILBOX."</td>
                  <td class='odd'><input type='text' size='55' name='email' class='formButton'></td></tr>";
        echo "<tr><td class='head'>"._AM_MLDOCS_TEXT_DESCRIPTION."</td>
                  <td class='even'><input type='text' size='55' name='description' class='formButton'></td></tr>";
        echo "<tr><td class='head'>"._AM_MLDOCS_SEARCH_BEGINEGINDATE."</td>
                  <td class='odd'><input type='text' name='begin_date' id='begin_date' size='10' maxlength='10' value='".formatTimestamp(time(), 'mysql')."' />
                                  <a href='' onclick='return showCalendar(\"begin_date\");'><img src='".MLDOCS_IMAGE_URL."/calendar.png' alt='Calendar image' name='calendar' style='vertical-align:bottom;border:0;background:transparent' /></a>&nbsp;";
        mldocsDrawHourSelect("begin_hour", 12);
        mldocsDrawMinuteSelect("begin_minute");
        mldocsDrawModeSelect("begin_mode");
        echo "<tr><td class='head'>"._AM_MLDOCS_SEARCH_ENDDATE."</td>
                  <td class='even'><input type='text' name='end_date' id='end_date' size='10' maxlength='10' value='".formatTimestamp(time(), 'mysql')."' />
                                  <a href='' onclick='return showCalendar(\"end_date\");'><img src='".MLDOCS_IMAGE_URL."/calendar.png' alt='Calendar image' name='calendar' style='vertical-align:bottom;border:0;background:transparent' /></a>&nbsp;";
        mldocsDrawHourSelect("end_hour", 12);
        mldocsDrawMinuteSelect("end_minute");
        mldocsDrawModeSelect("end_mode");
        echo "<tr><td class='foot' colspan='2'><input type='submit' name='searchEvents' value='"._AM_MLDOCS_BUTTON_SEARCH."' /></td></tr>";
        echo "</table>";
        echo "</form>";
        
        mldocs_adminFooter();
        xoops_cp_footer();
    } else {
        $hMailEvent =& mldocsGetHandler('mailEvent');
        $hDeptMbox =& mldocsGetHandler('departmentMailBox');
        $mailboxes =& $hDeptMbox->getObjects(null, true);
    
        $begin_date = explode( '-', $_POST['begin_date']);
        $end_date = explode('-', $_POST['end_date']);
        $begin_hour = mldocsChangeHour($_POST['begin_mode'], $_POST['begin_hour']);
        $end_hour = mldocsChangeHour($_POST['end_mode'], $_POST['end_hour']);
        
        // Get timestamps to search by
        $begin_time = mktime($begin_hour, $_POST['begin_minute'], 0, $begin_date[1], $begin_date[2], $begin_date[0]);
        $end_time = mktime($end_hour, $_POST['end_minute'], 0, $end_date[1], $end_date[2], $end_date[0]);
        
        $crit = new CriteriaCompo(new Criteria('posted', $begin_time, '>='));
        $crit->add(new Criteria('posted', $end_time, '<='));
        if($_POST['email'] != ''){
            $email = $_POST['email'];
            $crit->add(new Criteria('emailaddress', "%$email%", "LIKE", "d"));
        }
        if($_POST['description'] != ''){
            $description = $_POST['description'];
            $crit->add(new Criteria('event_desc', "%$description%", "LIKE"));
        }
        $crit->setOrder('DESC');
        $crit->setSort('posted');
        if(isset($email)){
            $mailEvents =& $hMailEvent->getObjectsJoin($crit);
        } else {
            $mailEvents =& $hMailEvent->getObjects($crit);
        }
        
        displayEvents($mailEvents, $mailboxes);
    
        mldocs_adminFooter();
        xoops_cp_footer();
    }
}

/**
 * changes hour to am/pm
 *
 * @param int $mode, 1-am, 2-pm
 * @param int $hour hour of the day
 *
 * @return hour in 24 hour mode
 */
function mldocsChangeHour($mode, $hour)
{
    $mode = intval($mode);
    $hour = intval($hour);
    
    if($mode == 2){
        $hour = $hour + 12;
        return $hour;
    }
    return $hour;
}

function mldocsDrawHourSelect($name, $lSelect="-1")
{
    echo "<select name='".$name."'>";
    for($i = 1; $i <= 12; $i++){
        if($lSelect == $i){
            $selected = "selected='selected'";
        } else {
            $selected = '';
        }
        echo "<option value='".$i."'".$selected.">".$i."</option>";
    }
    echo "</select>";
}

function mldocsDrawMinuteSelect($name)
{
    $lSum = 0;
    
    echo "<select name='".$name."'>";
    for($i = 0; $lSum <= 50; $i++){
        if($i == 0){
            echo "<option value='00' selected='selected'>00</option>";
        } else {
            $lSum = $lSum + 5;
            echo "<option value='".$lSum."'>".$lSum."</option>";
        }
    }
    echo "</select>";
}
            
function mldocsDrawModeSelect($name, $sSelect='AM')
{
    echo "<select name='".$name."'>";
    if($sSelect == 'AM'){
        echo "<option value='1' selected='selected'>AM</option>";
        echo "<option value='2'>PM</option>";
    } else {
        echo "<option value='1'>AM</option>";
        echo "<option value='2' selected='selected'>PM</option>";
    }
}

function mldocs_default()
{
    global $xoopsModuleConfig, $oAdminButton;
    xoops_cp_header();
    echo $oAdminButton->renderButtons('index');
    $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
    
    $stylePath = MLDOCS_BASE_URL.'/styles/mldocs.css';
    echo '<link rel="stylesheet" type="text/css" media="all" href="'.$stylePath.'" /><!--[if gte IE 5.5000]><script src="iepngfix.js" language="JavaScript" type="text/javascript"></script><![endif]-->';

    global $xoopsUser, $xoopsDB;
    $hArchives =& mldocsGetHandler('archive');
    $hStatus =& mldocsGetHandler('status');
    
    $crit = new Criteria('', '');
    $crit->setSort('description');
    $crit->setOrder('ASC');
    $statuses =& $hStatus->getObjects($crit);
    $table_class = array('odd', 'even');
    echo "<table border='0' width='100%'>";
    echo "<tr><td width='50%' valign='top'>";
    echo "<div id='archiveInfo'>";
    echo "<table border='0' width='95%' cellspacing='1' class='outer'>
          <tr><th colspan='2'>". _AM_MLDOCS_TEXT_ARCHIVE_INFO ."</th></tr>";
    $class = "odd";
    $totalArchives = 0;
    foreach($statuses as $status){
        $crit = new Criteria('status', $status->getVar('id'));
        $numArchives =& $hArchives->getCount($crit);
        $totalArchives += $numArchives;
        
        
        echo "<tr class='".$class."'><td>".$status->getVar('description')."</td><td>".$numArchives."</td></tr>";
        if($class == "odd"){
            $class = "even";
        } else {
            $class = "odd";
        }
    }
    echo "<tr class='foot'><td>"._AM_MLDOCS_TEXT_TOTAL_ARCHIVES."</td><td>".$totalArchives."</td></tr>";
    echo "</table></div><br />";
    
    $hStaff =& mldocsGetHandler('staff');
    $hResponses =& mldocsGetHandler('responses');
    echo "</td><td valign='top'>";    // Outer table
    echo "<div id='timeSpent'>";    // Start inner top-left cell
    echo "<table border='0' width='100%' cellspacing='1' class='outer'>
          <tr><th colspan='2'>". _AM_MLDOCS_TEXT_RESPONSE_TIME ."</th></tr>";
          
    $sql = sprintf('SELECT u.uid, u.uname, u.name, (s.responseTime / s.archivesResponded) as AvgResponseTime FROM %s u INNER JOIN %s s ON u.uid = s.uid WHERE archivesResponded > 0 ORDER BY AvgResponseTime', $xoopsDB->prefix('users'), $xoopsDB->prefix('mldocs_staff'));
    $ret = $xoopsDB->query($sql, MAX_STAFF_RESPONSETIME);
    $i = 0;
    while (list($uid, $uname, $name, $avgResponseTime) = $xoopsDB->fetchRow($ret)) {
        $class = $table_class[$i % 2];
        echo "<tr class='$class'><td>". mldocsCheckDisplayName($displayName, $name,$uname) ."</td><td align='right'>". mldocsFormatTime($avgResponseTime) ."</td></tr>";
        $i++;
    }
    echo "</table></div><br />"; // End inner top-left cell
    echo "</td></tr><tr><td valign='top'>"; // End first, start second cell
    
    //Get Calls Closed block
    $sql = sprintf('SELECT SUM(callsClosed) FROM %s', $xoopsDB->prefix('mldocs_staff'));
    $ret = $xoopsDB->query($sql);
    if (list($totalStaffClosed) = $xoopsDB->fetchRow($ret)) {
        if ($totalStaffClosed) {
            $sql = sprintf('SELECT u.uid, u.uname, u.name, s.callsClosed FROM %s u INNER JOIN %s s ON u.uid = s.uid WHERE s.callsClosed > 0 ORDER BY s.callsClosed DESC', $xoopsDB->prefix('users'), $xoopsDB->prefix('mldocs_staff'));
            $ret = $xoopsDB->query($sql, MAX_STAFF_CALLSCLOSED);
            echo "<div id='callsClosed'>";
            echo "<table border='0' width='95%' cellspacing='1' class='outer'>
                  <tr><th colspan='2'>". _AM_MLDOCS_TEXT_TOP_CLOSERS ."</th></tr>";
            $i = 0;
            while (list($uid, $uname, $name, $callsClosed) = $xoopsDB->fetchRow($ret)) {
                $class = $table_class[$i % 2];
                echo "<tr class='$class'><td>". mldocsCheckDisplayName($displayName, $name,$uname) ."</td><td align='right'>". $callsClosed. ' ('.round(($callsClosed/$totalStaffClosed)*100, 2) ."%)</td></tr>";
                $i++;
            }
            echo "</table></div><br />"; // End inner table top row
            echo "</td><td valign='top'>"; // End top row of outer table
            
            $sql = sprintf('SELECT u.uid, u.uname, u.name, (s.responseTime / s.archivesResponded) as AvgResponseTime FROM %s u INNER JOIN %s s ON u.uid = s.uid WHERE archivesResponded > 0 ORDER BY AvgResponseTime DESC', $xoopsDB->prefix('users'), $xoopsDB->prefix('mldocs_staff'));
            $ret = $xoopsDB->query($sql, MAX_STAFF_RESPONSETIME);
            echo "<div id='leastCallsClosed'>";
            echo "<table border='0' width='100%' cellspacing='1' class='outer'> 
                  <tr><th colspan='2'>". _AM_MLDOCS_TEXT_RESPONSE_TIME_SLOW ."</th></tr>";
            $i = 0;
            while (list($uid, $uname, $name, $avgResponseTime) = $xoopsDB->fetchRow($ret)) {
                $class = $table_class[$i % 2];
                echo "<tr class='$class'><td>". mldocsCheckDisplayName($displayName, $name,$uname) ."</td><td align='right'>". mldocsFormatTime($avgResponseTime) ."</td></tr>";
                $i++;
            }
            echo "</table></div>";  // End first cell, second row of inner table
        }
    }
    echo "</td></tr></table><br />";   // End second cell, second row of inner table
    
    $crit = new Criteria('state', '2', '<>', 's');
    $crit->setSort('priority');
    $crit->setOrder('ASC');
    $crit->setLimit(10);
    $highPriority =& $hArchives->getObjects($crit);
    $has_highPriority = (count($highPriority) > 0);
    if($has_highPriority){
        echo "<div id='highPriority'>";
        echo "<table border='0' width='100%' cellspacing='1' class='outer'>
              <tr><th colspan='8'>". _AM_MLDOCS_TEXT_HIGH_PRIORITY ."</th></tr>";
        echo "<tr class='head'><td>". _AM_MLDOCS_TEXT_PRIORITY ."</td><td>". _AM_MLDOCS_TEXT_ELAPSED ."</td><td>". _AM_MLDOCS_TEXT_STATUS ."</td><td>". _AM_MLDOCS_TEXT_SUBJECT ."</td><td>". _AM_MLDOCS_TEXT_DEPARTMENT ."</td><td>". _AM_MLDOCS_TEXT_OWNER ."</td><td>". _AM_MLDOCS_TEXT_LAST_UPDATED ."</td><td>". _AM_MLDOCS_TEXT_LOGGED_BY ."</td></tr>";
        $i = 0;
        foreach($highPriority as $archive){
               if($archive->isOverdue()){
                   $class = $table_class[$i % 2] . " overdue";
               } else {
                   $class = $table_class[$i % 2];
                }
               $priority_url = "<img src='".MLDOCS_IMAGE_URL."/priority". $archive->getVar('priority') .".png' alt='". $archive->getVar('priority') ."' />";
               $subject_url = sprintf("<a href='".MLDOCS_BASE_URL."/archive.php?id=". $archive->getVar('id') ."' target='_BLANK'>%s</a>", $archive->getVar('subject'));
               if($dept = $archive->getDepartment()){
                   $dept_url = sprintf("<a href='".MLDOCS_BASE_URL."/index.php?op=staffViewAll&amp;dept=". $dept->getVar('id') ."' target='_BLANK'>%s</a>", $dept->getVar('department'));
               } else {
                   $dept_url = _AM_MLDOCS_TEXT_NO_DEPT;
               }
               if($archive->getVar('ownership') <> 0){
                   $owner_url = sprintf("<a href='".XOOPS_URL."/userinfo.php?uid=". $archive->getVar('uid') ."' target='_BLANK'>%s</a>", mldocsGetUsername($archive->getVar('ownership'), $displayName));
               } else {
                   $owner_url = _AM_MLDOCS_TEXT_NO_OWNER;
               }
               $user_url = sprintf("<a href='".XOOPS_URL."/userinfo.php?uid=". $archive->getVar('uid') ."' target='_BLANK'>%s</a>", mldocsGetUsername($archive->getVar('uid'), $displayName));
               echo "<tr class='$class'><td>". $priority_url ."</td>
                         <td>". $archive->elapsed() ."</td>
                         <td>". mldocsGetStatus($archive->getVar('status')) ."</td>
                         <td>". $subject_url ."</td>
                         <td>". $dept_url ."</td>
                         <td>". $owner_url ." </td>
                         <td>". $archive->lastUpdated() ."</td>
                         <td>". $user_url ."</td>
                     </tr>";
              $i++;
        }
        echo "</table></div>";
    }
    // test la présence des 100 répertoires /archives/
    if (valideRepArchive()<1) {
        createRepArchive();
    }
    pathConfiguration();
    
    mldocs_adminFooter();
    xoops_cp_footer();
}
function valideRepArchive()
{
  // controle si un des repertoire est non valide
	for ($i = 0; $i < 10; $i++) //boucle des 100 repertoire d'archivage
	{
		for ($j = 0; $j < 10; $j++) 
		{
		  $path=(MLDOCS_ARCHIVE_PATH."/".$i.$j."/");
		  $res = mldocs_admin_getPathStatus($path,true);
    echo $res;
    if ($res < 1) {
    echo($path);
    return $res;
    exit();}
    }
 	}
	return $res;
}



function createRepArchive()
{
if(file_exists(MLDOCS_ARCHIVE_PATH."/"))//si le repertoire archive existe on créé
{
	for ($i = 0; $i < 10; $i++) //creatin des 100 repertoire d'archivage
	{
		for ($j = 0; $j < 10; $j++) 
		{
		  $res = mldocs_admin_mkdir(MLDOCS_ARCHIVE_PATH."/".$i.$j."/");
		  $res = mldocs_admin_chmod(MLDOCS_ARCHIVE_PATH."/".$i.$j."/", 0755);
		}
	}
	return true;
}
else {
		return false;
		}
}

function pathConfiguration()
{
	global $xoopsModule, $xoopsConfig;
	
	// Upload and Images Folders
    $paths = array();
    $paths[_AM_MLDOCS_PATH_ARCHIVEATTACH] = MLDOCS_UPLOADS_PATH."/";
    $paths[_AM_MLDOCS_PATH_ARCHIVEPRODUCT] = MLDOCS_ARCHIVE_PATH."/";
    $paths[_AM_MLDOCS_PATH_ARCHIVEBANNETTE] = MLDOCS_BANNETTE_PATH."/";
    $paths[_AM_MLDOCS_PATH_CACHE_IMG] = MLDOCS_CACHE_IMG_PATH."/";
    $paths[_AM_MLDOCS_PATH_CONVERT] = MLDOCS_CONVERT_PATH."/";
    $paths[_AM_MLDOCS_PATH_EMAILTPL] = MLDOCS_BASE_PATH."/language/{$xoopsConfig['language']}";

	echo "<h3>"._AM_MLDOCS_PATH_CONFIG."</h3>";
	echo "<table width='100%' class='outer' cellspacing='1' cellpadding='3' border='0' ><tr>";
	echo "<td class='bg3'><b>" . _AM_MLDOCS_TEXT_DESCRIPTION . "</b></td>";
	echo "<td class='bg3'><b>" . _AM_MLDOCS_TEXT_PATH . "</b></td>";
	echo "<td class='bg3' align='center'><b>" . _AM_MLDOCS_TEXT_STATUS . "</b></td></tr>";

    foreach($paths as $desc=>$path) {
        echo "<tr><td class='odd'>$desc</td>";
	    echo "<td class='odd'>$path</td>";
	    echo "<td class='even' style='text-align: center;'>" . mldocs_admin_getPathStatus($path) . "</td></tr>";
	}
	 echo "<tr><td class='odd'>" . _AM_MLDOCS_PATH_ARCHIVE100DIR ."</td>";
	    echo "<td class='odd'>" . MLDOCS_ARCHIVE_PATH.'/' ."</td>";
	    echo "<td class='even' style='text-align: center;'>" . valideRepArchive() . "</td></tr>";
	echo "</table>";
	echo "<br />";
	
	echo "</div>";
}

function about()
{
    global $oAdminButton;
    xoops_cp_header();
    echo $oAdminButton->renderButtons();
    require_once(MLDOCS_ADMIN_PATH."/about.php");
}

function createdir()
{
    $path = $_GET['path'];
	$res = mldocs_admin_mkdir($path);
	
	$msg = ($res)?_AM_MLDOCS_PATH_CREATED:_AM_MLDOCS_PATH_NOTCREATED;
	redirect_header(MLDOCS_ADMIN_URL.'/index.php', 2, $msg . ': ' . $path);
	exit();
}

function setperm()
{
    $path = $_GET['path'];
    $res = mldocs_admin_chmod($path, 0777);
    $msg = ($res ? _AM_MLDOCS_PATH_PERMSET : _AM_MLDOCS_PATH_NOTPERMSET);
    redirect_header(MLDOCS_ADMIN_URL.'/index.php', 2, $msg . ': ' . $path);
    exit();
}
?>
