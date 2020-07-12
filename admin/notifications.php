<?php
//$Id: notifications.php,v 1.3 2005/08/11 21:38:46 eric_juden Exp $
include('../../../include/cp_header.php');          
include_once('admin_header.php');
require_once(MLDOCS_CLASS_PATH.'/session.php');
$_mldocsSession = new Session();
$hNotification =& mldocsGetHandler('notification');

global $xoopsModule;
if(!$templates =& $_mldocsSession->get("mldocs_notifications")){
    $templates =& $xoopsModule->getInfo('_email_tpl');
    $_mldocsSession->set("mldocs_notifications", $templates);
}
$has_notifications = count($templates);

$aStaffSettings = array('2' => _AM_MLDOCS_STAFF_SETTING2, // '1' => _AM_MLDOCS_STAFF_SETTING1, -- removed because we don't need it
                            '3' => _AM_MLDOCS_STAFF_SETTING3, '4' => _AM_MLDOCS_STAFF_SETTING4);
$aUserSettings = array('1' => _AM_MLDOCS_USER_SETTING1, '2' => _AM_MLDOCS_USER_SETTING2);

// Also in profile.php
$aNotifications = array('1' => array('name' => _AM_MLDOCS_NOTIF_NEW_ARCHIVE, 
                                     'email_tpl' => array('1'=>$templates[1], 
                                                          '18'=>$templates[18], '20'=>$templates[20], '21'=>$templates[21], 
                                                          '22'=>$templates[22], '23'=>$templates[23], '24'=>$templates[24])),
                        '2' => array('name' => _AM_MLDOCS_NOTIF_DEL_ARCHIVE, 
                                     'email_tpl' => array('2'=>$templates[2], '12'=>$templates[12])),
                        '3' => array('name' => _AM_MLDOCS_NOTIF_MOD_ARCHIVE, 
                                     'email_tpl' => array('3'=>$templates[3], '13'=>$templates[13])),
                        '4' => array('name' => _AM_MLDOCS_NOTIF_NEW_RESPONSE, 
                                     'email_tpl' => array('4'=>$templates[4], '14'=>$templates[14])),
                        '5' => array('name' => _AM_MLDOCS_NOTIF_MOD_RESPONSE, 
                                     'email_tpl' => array('5'=>$templates[5], '15'=>$templates[15])),
                        '6' => array('name' => _AM_MLDOCS_NOTIF_MOD_STATUS, 
                                     'email_tpl' => array('6'=>$templates[6], '16'=>$templates[16])),
                        '7' => array('name' => _AM_MLDOCS_NOTIF_MOD_PRIORITY, 
                                     'email_tpl' => array('7'=>$templates[7], '17'=>$templates[17])),
                        '8' => array('name' => _AM_MLDOCS_NOTIF_MOD_OWNER, 
                                     'email_tpl' => array('8'=>$templates[8], '11'=>$templates[11])),
                        '9' => array('name' => _AM_MLDOCS_NOTIF_CLOSE_ARCHIVE, 
                                     'email_tpl' => array('9'=>$templates[9], '19'=>$templates[19])),
                        '10' => array('name' => _AM_MLDOCS_NOTIF_MERGE_ARCHIVE, 
                                     'email_tpl' => array('10'=>$templates[10], '25'=>$templates[25])));
$op = 'default';
if (isset($_REQUEST['op'])){
    $op = $_REQUEST['op'];
}

switch($op){
    case "edit":
        edit();
    break;
    
    case "manage":
        manage();
    break;
    
    case "modifyEmlTpl":
        modifyEmlTpl();
    break;
    
    Default:
        manage();
}

function edit()
{
    global $oAdminButton, $xoopsModule, $_mldocsSession, $aNotifications, $has_notifications, $aStaffSettings, 
    $aUserSettings, $hNotification;
    
    if(isset($_REQUEST['id'])){
        $id = intval($_REQUEST['id']);
    } else {
        // No id specified, return to manage page
        redirect_header(MLDOCS_ADMIN_URL."/notifications.php?op=manage", 3, _AM_MLDOCS_MESSAGE_NO_ID);
    }
    
    $settings =& $hNotification->get($id);
    
    xoops_cp_header();
    echo $oAdminButton->renderButtons('manNotify');
    $_mldocsSession->set("mldocs_return_page", substr(strstr($_SERVER['REQUEST_URI'], 'admin/'), 6));
    
    if(isset($_POST['save_notification'])){
        $settings->setVar('staff_setting', intval($_POST['staff_setting']));
        $settings->setVar('user_setting', intval($_POST['user_setting']));
        if($_POST['staff_setting'] == 2){
            $settings->setVar('staff_options', $_POST['roles']);
        } else {
            $settings->setVar('staff_options', array());
        }
        $hNotification->insert($settings, true);
        header("Location: ".MLDOCS_ADMIN_URL."/notifications.php?op=edit&id=$id");
    }
    
    // Retrieve list of email templates
    if(!$templates =& $_mldocsSession->get("mldocs_notifications")){
        $templates =& $xoopsModule->getInfo('_email_tpl');
        $_mldocsSession->set("mldocs_notifications", $templates);
    }
    $notification = $aNotifications[$id];
    
    $staff_settings = mldocsGetMeta("notify_staff{$id}");
    $user_settings = mldocsGetMeta("notify_user{$id}");
    $hRoles =& mldocsGetHandler('role');
    if($settings->getVar('staff_setting') == 2){
        $selectedRoles = $settings->getVar('staff_options');
    } else {
        $selectedRoles = array();
    }
    $roles =& $hRoles->getObjects();
    
    echo "<form method='post' action='".MLDOCS_ADMIN_URL."/notifications.php?op=edit&amp;id=".$id."'>";
    echo "<table width='100%' cellspacing='1' class='outer'>";
    echo "<tr><th colspan='2'>".$notification['name']."</th></tr>";
    echo "<tr><td class='head' width='20%'>"._AM_MLDOCS_TEXT_NOTIF_STAFF."</td>
              <td class='even' valign='top'>";
              echo "<table border='0'>";
              echo "<tr>";
                foreach($aStaffSettings as $value=>$setting){
                    echo "<td valign='top'>";
                    if($settings->getVar('staff_setting') == $value){
                        $checked = "checked='checked'";
                    } else {
                        $checked = '';
                    }
                    echo "<input type='radio' name='staff_setting' id='staff".$value."' value='".$value."' $checked />
                          <label for='staff".$value."'>".$setting."</label>&nbsp;";
                    if($value == 2){
                        echo "<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <select name='roles[]' multiple='multiple'>";
                        foreach($roles as $role){
                            $role_id = $role->getVar('id');
                            if(in_array($role_id, $selectedRoles)){
                                echo "<option value='".$role_id."' selected='selected'>".$role->getVar('name')."</option>";
                            } else {
                                echo "<option value='".$role_id."'>".$role->getVar('name')."</option>";
                            }
                        }
                        echo "</select>";
                    }
                    echo "</td>";
                }
              echo "</tr></table>";
              echo "</td>
          </tr>";
    echo "<tr><td class='head' width='20%'>"._AM_MLDOCS_TEXT_NOTIF_USER."</td>
              <td class='even'>";
                foreach($aUserSettings as $value=>$setting){
                    if($settings->getVar('user_setting') == $value){
                        $checked = "checked='checked'";
                    } else {
                        $checked = '';
                    }
                    echo "<input type='radio' name='user_setting' id='user".$value."' value='".$value."' $checked />
                          <label for='user".$value."'>".$setting."</label>&nbsp;";
                }
              echo "</td>
          </tr>";
    echo "<tr>
              <td class='head'></td>
              <td class='even'><input type='submit' name='save_notification' value='"._AM_MLDOCS_BUTTON_SUBMIT."' /></td>
          </tr>";
    echo "</table></form><br />";
    
    echo "<table width='100%' cellspacing='1' class='outer'>";
    echo "<tr><th colspan='3'>"._AM_MLDOCS_TEXT_ASSOC_TPL."</th></tr>";
    echo "<tr class='head'><td>"._AM_MLDOCS_TEXT_TEMPLATE_NAME."</td>
                           <td>"._AM_MLDOCS_TEXT_DESCRIPTION."</td>
                           <td>"._AM_MLDOCS_TEXT_ACTIONS."</td></tr>";
    foreach($notification['email_tpl'] as $template){
        echo "<tr class='even'>
                  <td>".$template['title']."</a></td><td>".$template['description']."</td>
                  <td><a href='".MLDOCS_ADMIN_URL."/notifications.php?op=modifyEmlTpl&amp;file=".$template['mail_template'].".tpl'>
                      <img src='".XOOPS_URL."/modules/mldocs/images/button_edit.png' title='"._AM_MLDOCS_TEXT_EDIT."' name='editNotification' /></a>
                  </td>
              </tr>";
    }
    echo "</table>";
    
    xoops_cp_footer();
}

function manage()
{
    global $oAdminButton, $xoopsModule, $_mldocsSession, $aNotifications, $has_notifications, $xoopsDB, $aStaffSettings, 
    $aUserSettings, $hNotification;
    
    xoops_cp_header();
    echo $oAdminButton->renderButtons('manNotify');
    
    $settings =& $hNotification->getObjects(null, true);
    
    echo "<table width='100%' cellspacing='1' class='outer'>";
    echo "<tr><th colspan='3'>"._AM_MLDOCS_TEXT_MANAGE_NOTIFICATIONS."</th></tr>";
    if($has_notifications){
        echo "<tr class='head'>
                  <td>"._AM_MLDOCS_TEXT_NOTIF_NAME."</td>
                  <td>"._AM_MLDOCS_TEXT_SUBSCRIBED_MEMBERS."</td>
                  <td>"._AM_MLDOCS_TEXT_ACTIONS."</td>
              </tr>";
        foreach($aNotifications as $template_id=>$template){
            $cSettings = $settings[$template_id];
            $staff_setting = $cSettings->getVar('staff_setting');
            $user_setting = $cSettings->getVar('user_setting');
            
            // Build text of who gets notification
            if($user_setting == 1){
                if($staff_setting == 4){
                    $sSettings = _AM_MLDOCS_TEXT_SUBMITTER;
                } else {
                    $sSettings = $aStaffSettings[$staff_setting]." "._AM_MLDOCS_TEXT_AND." "._AM_MLDOCS_TEXT_SUBMITTER;
                }
            } else {
                if($staff_setting == 4){
                    $sSettings = '';
                } else {
                    $sSettings = $aStaffSettings[$staff_setting];
                }
            }
            // End Build text of who gets notification
            
            echo "<tr class='even'>
                     <td width='20%'>".$template['name']."</td>
                     <td>".$sSettings."</td>
                     <td>
                         <a href='notifications.php?op=edit&amp;id=".$template_id."'><img src='".XOOPS_URL."/modules/mldocs/images/button_edit.png' title='"._AM_MLDOCS_TEXT_EDIT."' name='editNotification' /></a>
                     </td>
                  </tr>";
        }
    } else {
        // No notifications found (Should never happen)
        echo "<tr><td class='even' colspan='3'>"._AM_MLDOCS_TEXT_NO_RECORDS."</td></tr>";
    }
    echo "</table>";
    
    xoops_cp_footer();
}

function modifyEmlTpl()
{
    global $xoopsConfig, $oAdminButton, $_mldocsSession;
    
    if (is_dir(XOOPS_ROOT_PATH.'/modules/mldocs/language/'.$xoopsConfig['language'].'/mail_template')) {
        $opendir = opendir(XOOPS_ROOT_PATH.'/modules/mldocs/language/'.$xoopsConfig['language'].'/mail_template/');
        $dir = XOOPS_ROOT_PATH.'/modules/mldocs/language/'.$xoopsConfig['language'].'/mail_template/';
        $url = XOOPS_URL.'/modules/mldocs/language/'.$xoopsConfig['language'].'/mail_template/';  
    } else {
        $opendir = opendir(XOOPS_ROOT_PATH.'/modules/mldocs/language/english/mail_template/');
        $dir = XOOPS_ROOT_PATH.'/modules/mldocs/language/english/mail_template/';
        $url = XOOPS_URL.'/modules/mldocs/language/english/mail_template/';  
    }
    
    $notNames = array(
       _MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFY, _MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYDSC, _MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFY, _MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYDSC, _MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYTPL => array(_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFY, _MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYDSC, _MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYTPL),
       _MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYTPL => array(_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFY, _MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYDSC, _MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYTPL),
       _MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFY, _MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYDSC, _MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYTPL => array(_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFY, _MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYDSC, _MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYTPL),
       _MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYTPL => array(_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFY, _MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYDSC, _MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYTPL),
       _MI_MLDOCS_DEPT_NEWOWNER_NOTIFYTPL => array(_MI_MLDOCS_DEPT_NEWOWNER_NOTIFY, _MI_MLDOCS_DEPT_NEWOWNER_NOTIFYDSC, _MI_MLDOCS_DEPT_NEWOWNER_NOTIFYTPL),
       _MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFY, _MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYDSC, _MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFY, _MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFY, _MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFY, _MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFY, _MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFY, _MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFY, _MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFY, _MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFY, _MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFY, _MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFY, _MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFY, _MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFY, _MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFY, _MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFY, _MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYTPL),
       _MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFY, _MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYDSC, _MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYTPL),
       _MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYTPL => array(_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFY, _MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYDSC, _MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYTPL));
    
    $notKeys = array_keys($notNames);  
      
    while(($file = readdir($opendir)) != null) {  
        //Do not Display .  
         if (is_dir($file)) {  
            continue;  
        }  
          
        if (!in_array($file, $notKeys)) {  
            continue;  
        }  
     
        $aFile = Array();  
        $aFile['name'] = $notNames[$file][0];  
        $aFile['desc'] = $notNames[$file][1];  
        $aFile['filename'] = $notNames[$file][2];  
        $aFile['url'] = "index.php?op=modifyEmlTpl&amp;file=$file";  
        $aFiles[] = $aFile;  
    }
    
    if(!isset($_GET['file'])){  
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manNotify'); 
        echo "<table width='100%' border='0' cellspacing='1' class='outer'>
              <tr><th colspan='2'><label>". _AM_MLDOCS_MENU_MODIFY_EMLTPL ."</label></th></tr>
              <tr class='head'><td>". _AM_MLDOCS_TEXT_TEMPLATE_NAME ."</td><td>". _AM_MLDOCS_TEXT_DESCRIPTION ."</td></tr>";
        
        foreach($aFiles as $file){
            static $rowSwitch = 0;
            if($rowSwitch == 0){
                echo "<tr class='odd'><td><a href='".$file['url']."'>". $file['name'] ."</a></td><td>". $file['desc'] ."</td></tr>";
                $rowSwitch = 1;
            } else {
                echo "<tr class='even'><td><a href='".$file['url']."'>". $file['name'] ."</a></td><td>". $file['desc'] ."</td></tr>";
                $rowSwitch = 0;
            }
        }
        echo "</table>";
    } else {
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manNotify');
        foreach($aFiles as $file){
            if($_GET['file'] == $file['filename']){
                $myFileName = $file['filename'];
                $myFileDesc = $file['desc'];
                $myName = $file['name'];
                break;
            }
        }
        if(!$has_write = is_writable($dir.$myFileName)){
            $message = _AM_MLDOCS_MESSAGE_FILE_READONLY;
            $handle = fopen($dir.$myFileName, 'r');
            $fileSize = filesize($dir.$myFileName);
        } elseif(isset($_POST['editTemplate'])){
            $handle = fopen($dir.$myFileName, 'w+');
        } else {
            $handle = fopen($dir.$myFileName, 'r+');
            $fileSize = filesize($dir.$myFileName);
        }
        
        if(isset($_POST['editTemplate'])){
            if(isset($_POST['templateText'])){
                $text = $_POST['templateText'];    // Get new text for template
            } else {
                $text = '';
            }
            
            if(!$returnPage =& $_mldocsSession->get("mldocs_return_page")){
                $returnPage = false;
            }
            
            if(fwrite($handle, $text)){
                $message = _AM_MLDOCS_MESSAGE_FILE_UPDATED;
                $fileSize = filesize($dir.$myFileName);
                fclose($handle);
                if($returnPage){
                    header("Location: ".MLDOCS_ADMIN_URL."/$returnPage");
                } else {
                    header("Location: ".MLDOCS_ADMIN_URL."/notifications.php");
                }
            } else {
                $message = _AM_MLDOCS_MESSAGE_FILE_UPDATED_ERROR;
                $fileSize = filesize($dir.$myFileName);
                fclose($handle);
                if($returnPage){
                    redirect_header("Location: ".MLDOCS_ADMIN_URL."/$returnPage", 3, $message);
                } else {
                    redirect_header("Location: ".MLDOCS_ADMIN_URL."/notifications.php", 3, $message);
                }
            }
        }
        if(!$has_write){
            echo "<div id='readOnly' class='errorMsg'>";
            echo $message;
            echo "</div>";
        }
        
        echo "<form action='".MLDOCS_ADMIN_URL."/notifications.php?op=modifyEmlTpl&amp;file=".$myFileName."' method='post'>";
        echo "<table width='100%' border='0' cellspacing='1' class='outer'>
              <tr><th colspan='2'>".$myName."</th></tr>
              <tr><td colspan='2' class='head'>". $myFileDesc ."</td></tr>";
        
        echo "<tr class='odd'>
                  <td><textarea name='templateText' cols='40' rows='40'>". fread($handle, $fileSize) ."</textarea></td>
                  <td valign='top'>
                      <b>". _AM_MLDOCS_TEXT_GENERAL_TAGS ."</b>
                      <ul>
                        <li>". _AM_MLDOCS_TEXT_GENERAL_TAGS1 ."</li>
                        <li>". _AM_MLDOCS_TEXT_GENERAL_TAGS2 ."</li>
                        <li>". _AM_MLDOCS_TEXT_GENERAL_TAGS3 ."</li>
                        <li>". _AM_MLDOCS_TEXT_GENERAL_TAGS4 ."</li>
                        <li>". _AM_MLDOCS_TEXT_GENERAL_TAGS5 ."</li>
                      </ul>
                      <br />
                      <u>". _AM_MLDOCS_TEXT_TAGS_NO_MODIFY ."</u>
                  </td>
              </tr>";
        
        if($has_write){
            echo "<tr><td class='foot' colspan='2'><input type='submit' name='editTemplate' value='". _AM_MLDOCS_BUTTON_UPDATE ."' class='formButton' /></td></tr>";
        }
        echo "</table></form>";
    }
    mldocs_adminFooter();
    xoops_cp_footer();
}
?>