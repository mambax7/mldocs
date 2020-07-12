<?php
//$Id: department.php,v 1.20 2005/10/11 15:14:58 eric_juden Exp $
include('../../../include/cp_header.php');          
include_once('admin_header.php');           
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');
require_once(MLDOCS_CLASS_PATH . '/mldocsForm.php');
require_once(MLDOCS_CLASS_PATH . '/mldocsFormRadio.php');
require_once(MLDOCS_CLASS_PATH . '/mldocsFormCheckbox.php');

global $xoopsModule;
$module_id = $xoopsModule->getVar('mid');

$start = $limit = 0;   
if (isset($_REQUEST['limit'])) {
    $limit = intval($_REQUEST['limit']);
}
if (isset($_REQUEST['start'])) {
    $start = intval($_REQUEST['start']);
}
if (!$limit) {
    $limit = 15;
}
if(isset($_REQUEST['order'])){
    $order = $_REQUEST['order'];
} else {
    $order = "ASC";
}
if(isset($_REQUEST['sort'])) {
    $sort = $_REQUEST['sort'];
} else {
    $sort = "department";
}

$aSortBy = array('id' => _AM_MLDOCS_TEXT_ID, 'profilelot' => _AM_MLDOCS_TEXT_DEPARTMENT);
$aOrderBy = array('ASC' => _AM_MLDOCS_TEXT_ASCENDING, 'DESC' => _AM_MLDOCS_TEXT_DESCENDING);
$aLimitBy = array('10' => 10, '15' => 15, '20' => 20, '25' => 25, '50' => 50, '100' => 100);

$op = 'default';

if ( isset( $_REQUEST['op'] ) )
{
    $op = $_REQUEST['op'];
}

switch ( $op )
{
    case "activateMailbox":
        activateMailbox();
        break;        
        
    case "AddProfilelotServer":
        addProfilelotServer();
        break;
        
    case "DeleteProfilelotServer":
        DeleteProfilelotServer();
        break;
        
    case "deleteStaffProfil":
        deleteStaffProfil();
        break;
        
    case "editProfilelot":
        editProfilelot();
        break;
        
    case "EditProfilelotServer":
        EditProfilelotServer();
        break;
        
    case "manageProfilelots":
        manageProfilelots();
        break;
    
    case "testMailbox":
        testMailbox();
        break;
    
    case "clearAddSession":
        clearAddSession();
        break;
    
    case "clearEditSession":
        clearEditSession();
        break;
        
    case "updateDefault":
        updateDefault();
        break;
        
    default:
        header("Location: ".MLDOCS_BASE_URL."/admin/index.php");
        break;
}

function activateMailbox()
{
    $id = intval($_GET['id']);
    $setstate = intval($_GET['setstate']);
    
    $hMailbox =& mldocsGetHandler('profilelotMailBox');
    if ($mailbox =& $hMailbox->get($id)) {
        $url = MLDOCS_BASE_URL.'/admin/profilelot.php?op=editProfilelot&id='. $mailbox->getVar('profilelotid');
        $mailbox->setVar('active', $setstate);
        if ($hMailbox->insert($mailbox, true)) {
            header("Location: $url");
        } else {
            redirect_header($url, 3, _AM_MLDOCS_DEPARTMENT_SERVER_ERROR);
        }
    } else {
        redirect_header(MLDOCS_BASE_URL.'/admin/profilelot.php?op=manageProfilelots', 3, _MLDOCS_NO_MAILBOX_ERROR);
    }   
}

function addProfilelotServer()
{
  if(isset($_GET['id'])){
      $profilID = intval($_GET['id']);
  } else {
    redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 3, _AM_MLDOCS_DEPARTMENT_NO_ID);
  }


  $hProfilServers =& mldocsGetHandler('profilelotMailBox');
  $server = $hProfilServers->create();
  $server->setVar('profilelotid',$profilID);
  $server->setVar('emailaddress', $_POST['emailaddress']);
  $server->setVar('server',       $_POST['server']);
  $server->setVar('serverport',   $_POST['port']);
  $server->setVar('username',     $_POST['username']);
  $server->setVar('password',     $_POST['password']);
  $server->setVar('priority',     $_POST['priority']);
  //
  if ($hProfilServers->insert($server))   {
    header("Location: ".MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots");
  } else {
    redirect_header(MLDOCS_ADMIN_URL.'/profilelot.php?op=manageProfilelots', 3, _AM_MLDOCS_DEPARTMENT_SERVER_ERROR);
  }
}

function DeleteProfilelotServer() {
    global $oAdminButton;
    if(isset($_REQUEST['id'])){
        $emailID = intval($_REQUEST['id']);
    } else {
        redirect_header(MLDOCS_ADMIN_URL.'/profilelot.php?op=manageProfilelots', 3, _AM_MLDOCS_DEPARTMENT_SERVER_NO_ID);
    }
    
    $hProfilServers =& mldocsGetHandler('profilelotMailBox');
    $server       =& $hProfilServers->get($emailID);
    
    if (!isset($_POST['ok'])) {
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manProfil');
        xoops_confirm(array('op' => 'DeleteProfilelotServer', 'id' => $emailID, 'ok' => 1), MLDOCS_BASE_URL .'/admin/profilelot.php', sprintf(_AM_MLDOCS_MSG_DEPT_MBOX_DEL_CFRM, $server->getVar('emailaddress')));
        xoops_cp_footer();     
    } else {
        //get handler
        if ($hProfilServers->delete($server,true)) {
            header("Location: ".MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots");
        } else {
            redirect_header(MLDOCS_ADMIN_URL.'/profilelot.php?op=manageProfilelots', 3, _AM_MLDOCS_DEPARTMENT_SERVER_DELETE_ERROR);
        }
    }
}

function deleteStaffProfil()
{
    if(isset($_GET['profilid'])){
        $profilID = intval($_GET['profilid']);
    } else {
        redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 3, _AM_MLDOCS_MSG_NO_DEPTID);
    }
    if(isset($_GET['uid'])){
        $staffID = intval($_GET['uid']);
    } elseif(isset($_POST['staff'])){
        $staffID = $_POST['staff'];
    } else {
        redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=editProfilelot&profilid=$profilID", 3, _AM_MLDOCS_MSG_NO_UID);
    }
    
    $hMembership =& mldocsGetHandler('membership');
    if(is_array($staffID)){
        foreach($staffID as $sid){
            $ret = $hMembership->removeProfilFromStaff($profilID, $sid);
        }
    } else {
        $ret = $hMembership->removeProfilFromStaff($profilID, $staffID);
    }
    
    if($ret){
        header("Location: ".MLDOCS_ADMIN_URL."/profilelot.php?op=editProfilelot&profilid=$profilID");
    } else {
        redirect_header(MLDOCS_ADMIN_URL."/profilelot.php??op=editProfilelot&profilid=$profilID", 3, _AM_MLDOCS_MSG_REMOVE_STAFF_DEPT_ERR);
    }
}

function editProfilelot()
{
    $_mldocsSession = Session::singleton();
    global $imagearray, $xoopsModule, $oAdminButton, $limit, $start, $xoopsModuleConfig;
    $module_id = $xoopsModule->getVar('mid');
    $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
  
    $_mldocsSession->set("mldocs_return_page", substr(strstr($_SERVER['REQUEST_URI'], 'admin/'), 6));

    if(isset($_REQUEST["profilid"])){
        $profilID = $_REQUEST['profilid'];
    } else {
        redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 3, _AM_MLDOCS_MSG_NO_DEPTID);
    }
    
    $hProfilelots  =& mldocsGetHandler('profilelot');
    $hGroups =& xoops_gethandler('group');
    $hGroupPerm =& xoops_gethandler('groupperm');
    
    if(isset($_POST['updateProfil'])){
        $groups = (isset($_POST['groups']) ? $_POST['groups'] : array());
        
        $hasErrors = false;
        //Profilelot Name supplied?
        if (trim($_POST['newProfil']) == '') {
            $hasErrors = true;
            $errors['newProfil'][] = _AM_MLDOCS_MESSAGE_NO_DEPT;
        } else {
        
            //Profilelot Name unique?
            $crit = new CriteriaCompo(new Criteria('profilelot', $_POST['newProfil']));
            $crit->add(new Criteria('id', $profilID, '!='));
            if($existingProfils = $hProfilelots->getCount($crit)){
                $hasErrors = true;
                $errors['newProfil'][] = _MLDOCS_MESSAGE_DEPT_EXISTS;
                
            }
        }
        
        if ($hasErrors) {
            $session =& Session::singleton();
            //Store existing profil info in session, reload addition page
            $aProfil = array();
            $aProfil['newProfil'] = $_POST['newProfil'];
            $aProfil['groups'] = $groups;
            $session->set("mldocs_editProfilelot_$profilID", $aProfil);
            $session->set("mldocs_editProfilelotErrors_$profilID", $errors);
            header('Location: '. mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'editProfilelot', 'profilid'=>$profilID), false));
            exit();
        }        
        
        $profil =& $hProfilelots->get($profilID);
        
        $oldProfil = $profil;
        $groups = $_POST['groups'];
        
        // Need to remove old group permissions first
        $crit = new CriteriaCompo(new Criteria('gperm_modid', $module_id));
        $crit->add(new Criteria('gperm_itemid', $profilID));
        $crit->add(new Criteria('gperm_name', _MLDOCS_GROUP_PERM_DEPT));
        $hGroupPerm->deleteAll($crit);
        
        foreach($groups as $group){     // Add new group permissions
            $hGroupPerm->addRight(_MLDOCS_GROUP_PERM_DEPT, $profilID, $group, $module_id);
        }
        
        $profil->setVar('profilelot', $_POST['newProfil']);
            
        if($hProfilelots->insert($profil)){
            $message = _MLDOCS_MESSAGE_UPDATE_DEPT;
            
            // Update default profil
            if(isset($_POST['defaultProfil']) && ($_POST['defaultProfil'] == 1)){
                mldocsSetMeta("default_profilelot", $profil->getVar('id'));
            } else {
                $profils =& $hProfilelots->getObjects();
                $aProfils = array();
                foreach($profils as $dpt){
                    $aProfils[] = $dpt->getVar('id');
                }
                mldocsSetMeta("default_profilelot", $aProfils[0]);
            }
            
            // Edit configoption for profilelot
            $hConfigOption =& xoops_gethandler('configoption');
            $crit = new CriteriaCompo(new Criteria('confop_name', $oldProfil->getVar('profilelot')));
            $crit->add(new Criteria('confop_value', $oldProfil->getVar('id')));
            $confOption =& $hConfigOption->getObjects($crit);
                                    
            if(count($confOption) > 0){
                $confOption[0]->setVar('confop_name', $profil->getVar('profilelot'));
                
                if(!$hConfigOption->insert($confOption[0])){
                    redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 3, _AM_MLDOCS_MSG_UPDATE_CONFIG_ERR);
                }
            }
            _clearEditSessionVars($profilID);
            header("Location: ".MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots");
        } else {
            $message = _MLDOCS_MESSAGE_UPDATE_DEPT_ERROR . $profil->getHtmlErrors();
            redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 3, $message);
        }
        
    } else {
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manProfil');
        
        $profil =& $hProfilelots->get($profilID);
        
        $session =& Session::singleton();
        $sess_profil = $session->get("mldocs_editProfilelot_$profilID");
        $sess_errors = $session->get("mldocs_editProfilelotErrors_$profilID");
        
        //Display any form errors
        if (! $sess_errors === false) {
            mldocsRenderErrors($sess_errors, mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'clearEditSession', 'profilid'=>$profilID)));
        }
        
        // Get list of groups with permission
        $crit = new CriteriaCompo(new Criteria('gperm_modid', $module_id));
        $crit->add(new Criteria('gperm_itemid', $profilID));
        $crit->add(new Criteria('gperm_name', _MLDOCS_GROUP_PERM_DEPT));
        $group_perms =& $hGroupPerm->getObjects($crit);
        
        $aPerms = array();      // Put group_perms in usable format
        foreach($group_perms as $perm){
            $aPerms[$perm->getVar('gperm_groupid')] = $perm->getVar('gperm_groupid');
        }        
        
        if (! $sess_profil === false) {
            $fld_newProfil = $sess_profil['newProfil'];
            $fld_groups  = $sess_profil['groups'];
        } else {
            $fld_newProfil = $profil->getVar('profilelot');
            $fld_groups = $aPerms;
        }
                
        // Get list of all groups
        $crit = new Criteria('', '');
        $crit->setSort('name');
        $crit->setOrder('ASC');
        $groups =& $hGroups->getObjects($crit, true);
        
        $aGroups = array();
        foreach($groups as $group_id=>$group){
            $aGroups[$group_id] = $group->getVar('name');
        }
        asort($aGroups);    // Set groups in alphabetical order

        echo '<script type="text/javascript" src="'.XOOPS_URL.'/modules/mldocs/include/functions.js"></script>';        
        $form = new mldocsForm(_AM_MLDOCS_EDIT_DEPARTMENT, 'edit_profil', mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'editProfilelot', 'profilid' => $profilID)));
        $profil_name =& new XoopsFormText(_AM_MLDOCS_TEXT_EDIT_DEPT, 'newProfil', 20, 35, $fld_newProfil);
        $group_select =& new XoopsFormSelect(_AM_MLDOCS_TEXT_EDIT_DEPT_PERMS, 'groups', $fld_groups, 6, true);
        $group_select->addOptionArray($aGroups);
        $defaultProfilID = mldocsGetMeta("default_profilelot");
        $defaultProfil =& new mldocsFormCheckbox(_AM_MLDOCS_TEXT_DEFAULT_DEPT, 'defaultProfil', (($defaultProfilID == $profilID) ? 1 : 0), 'defaultProfil');
        $defaultProfil->addOption(1, "");
        $btn_tray = new XoopsFormElementTray('');
        $btn_tray->addElement(new XoopsFormButton('', 'updateProfil', _AM_MLDOCS_BUTTON_SUBMIT, 'submit')); 
        $form->addElement($profil_name);
        $form->addElement($group_select);
        $form->addElement($defaultProfil);
        $form->addElement($btn_tray);
        $form->setLabelWidth('20%');
        echo $form->render();
        
        // Get profil staff members
        $hMembership =& mldocsGetHandler('membership');
        $hMember =& xoops_gethandler('member');
        $hStaffRole =& mldocsGetHandler('staffRole');
        $hRole =& mldocsGetHandler('role');
        
        $staff = $hMembership->membershipByProfil($profilID, $limit, $start);
        $crit = new Criteria('j.profilelot', $profilID);
        $staffCount =& $hMembership->getCount($crit);
        $roles =& $hRole->getObjects(null, true);
              
        echo "<form action='".MLDOCS_ADMIN_URL."/profilelot.php?op=deleteStaffProfil&amp;profilid=".$profilID."' method='post'>";
        echo "<table width='100%' cellspacing='1' class='outer'>
              <tr><th colspan='".(3+count($roles))."'><label>". _AM_MLDOCS_MANAGE_STAFF ."</label></th></tr>";
              
        if($staffCount > 0){
            $aStaff = array();
            foreach($staff as $stf){
                $aStaff[$stf->getVar('uid')] = $stf->getVar('uid');     // Get array of staff uid
            }
            
            // Get user list
            $crit = new Criteria('uid', "(". implode($aStaff, ',') .")", "IN");
            //$members =& $hMember->getUserList($crit);
            $members =& mldocsGetUsers($crit, $displayName);
            
            // Get staff roles
            $crit = new CriteriaCompo(new Criteria('uid', "(". implode($aStaff, ',') .")", "IN"));
            $crit->add(new Criteria('profilid', $profilID));
            $staffRoles =& $hStaffRole->getObjects($crit);
            unset($aStaff);
            
            $staffInfo = array();
            foreach($staff as $stf){
                $staff_uid = $stf->getVar('uid');
                $staffInfo[$staff_uid]['uname'] = $members[$staff_uid];
                $aRoles = array();
                foreach($staffRoles as $role){
                    $role_id = $role->getVar('roleid');
                    if($role->getVar('uid') == $staff_uid){
                        $aRoles[$role_id] = $roles[$role_id]->getVar('name');
                    }    
                    $staffInfo[$staff_uid]['roles'] = implode($aRoles, ', ');
                }
            }
            $nav = new XoopsPageNav($staffCount, $limit, $start, 'start', "op=editProfilelot&amp;profilid=$profilID&amp;limit=$limit");
              
            echo "<tr class='head'><td rowspan='2'>"._AM_MLDOCS_TEXT_ID."</td><td rowspan='2'>"._AM_MLDOCS_TEXT_USER."</td><td colspan='".count($roles)."'>"._AM_MLDOCS_TEXT_ROLES."</td><td rowspan='2'>"._AM_MLDOCS_TEXT_ACTIONS."</td></tr>";
            echo "<tr class='head'>";
            foreach ($roles as $thisrole) echo "<td>".$thisrole->getVar('name')."</td>";
            echo "</tr>";
            foreach($staffInfo as $uid=>$staff){
                echo "<tr class='even'>
                          <td><input type='checkbox' name='staff[]' value='".$uid."' />".$uid."</td>
                          <td>".$staff['uname']."</td>";
 			foreach ($roles as $thisrole) {
 				echo "<td><img src='".MLDOCS_BASE_URL."/images/";
 				echo (in_array($thisrole->getVar('name'),explode(', ',$staff['roles']))) ? "on.png" : "off.png";
				echo "' /></td>";
			}
            echo "    <td>
                          <a href='".MLDOCS_ADMIN_URL."/staff.php?op=editStaff&amp;uid=".$uid."'><img src='".XOOPS_URL."/modules/mldocs/images/button_edit.png' title='"._AM_MLDOCS_TEXT_EDIT."' name='editStaff' /></a>&nbsp;
                          <a href='".MLDOCS_ADMIN_URL."/profilelot.php?op=deleteStaffProfil&amp;uid=".$uid."&amp;profilid=".$profilID."'><img src='".XOOPS_URL."/modules/mldocs/images/button_delete.png' title='"._AM_MLDOCS_TEXT_DELETE_STAFF_DEPT."' name='deleteStaffProfil' /></a>
                      </td>
                  </tr>";
            }
            echo "<tr>
                      <td class='foot' colspan='".(3+count($roles))."'>
                          <input type='checkbox' name='checkallRoles' value='0' onclick='selectAll(this.form,\"staff[]\",this.checked);' />
                          <input type='submit' name='deleteStaff' id='deleteStaff' value='"._AM_MLDOCS_BUTTON_DELETE."' />
                      </td>
                  </tr>";
            echo "</table></form>";
            echo "<div id='staff_nav'>".$nav->renderNav()."</div>";
        } else {
            echo "</table></form>";
        }
        
        //now do the list of servers
        $hProfilServers =& mldocsGetHandler('profilelotMailBox');
        $profilServers  =& $hProfilServers->getByProfilelot($profilID);
        //iterate
        if (count($profilServers) > 0) {
          echo "<br /><table width='100%' cellspacing='1' class='outer'>
               <tr>
                 <th colspan='5'><label>". _AM_MLDOCS_DEPARTMENT_SERVERS ."</label></th>
               </tr>
               <tr>
                 <td class='head' width='20%'><label>". _AM_MLDOCS_DEPARTMENT_SERVERS_EMAIL ."</label></td>
                 <td class='head'><label>". _AM_MLDOCS_DEPARTMENT_SERVERS_TYPE ."</label></td>
                 <td class='head'><label>". _AM_MLDOCS_DEPARTMENT_SERVERS_SERVERNAME ."</label></td>
                 <td class='head'><label>". _AM_MLDOCS_DEPARTMENT_SERVERS_PORT ."</label></td>
                 <td class='head'><label>". _AM_MLDOCS_DEPARTMENT_SERVERS_ACTION ."</label></td>
               </tr>";
          $i = 0;
          foreach($profilServers as $server){
            if ($server->getVar('active')) {
                $activ_link = '".MLDOCS_ADMIN_URL."/profilelot.php?op=activateMailbox&amp;setstate=0&amp;id='. $server->getVar('id');
                $activ_img = $imagearray['online'];
                $activ_title = _AM_MLDOCS_MESSAGE_DEACTIVATE;
            } else {
                $activ_link = '".MLDOCS_ADMIN_URL."/profilelot.php?op=activateMailbox&amp;setstate=1&amp;id='. $server->getVar('id');
                $activ_img = $imagearray['offline'];
                $activ_title = _AM_MLDOCS_MESSAGE_ACTIVATE;
            }

            echo '<tr class="even">
                   <td>'.$server->getVar('emailaddress').'</td>
                   <td>'.mldocsGetMBoxType($server->getVar('mboxtype')).'</td>
                   <td>'.$server->getVar('server').'</td>
                   <td>'.$server->getVar('serverport').'</td>
                   <td> <a href="'. $activ_link.'" title="'. $activ_title.'">'. $activ_img.'</a>
                        <a href="'.MLDOCS_ADMIN_URL.'/profilelot.php?op=EditProfilelotServer&amp;id='.$server->GetVar('id').'">'.$imagearray['editimg'].'</a>
                        <a href="'.MLDOCS_ADMIN_URL.'/profilelot.php?op=DeleteProfilelotServer&amp;id='.$server->GetVar('id').'">'.$imagearray['deleteimg'].'</a>
                        
                   </td>
                 </tr>';
          }
          echo '</table>';
        }
        //finally add Mailbox form
        echo "<br /><br />";
        
        $formElements = array('type_select', 'server_text', 'port_text', 'username_text', 'pass_text', 'priority_radio',
                              'email_text', 'btn_tray');
        $form = new mldocsForm(_AM_MLDOCS_DEPARTMENT_ADD_SERVER, 'add_server', mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'AddProfilelotServer', 'id' => $profilID)));
        
        $type_select =& new XoopsFormSelect(_AM_MLDOCS_DEPARTMENT_SERVERS_TYPE, 'mboxtype');
        $type_select->setExtra("id='mboxtype'");
        $type_select->addOption(_MLDOCS_MAILBOXTYPE_POP3, _AM_MLDOCS_MBOX_POP3);
        
        $server_text =& new XoopsFormText(_AM_MLDOCS_DEPARTMENT_SERVERS_SERVERNAME, 'server', 40, 50);
        $server_text->setExtra("id='txtServer'");
        
        $port_text =& new XoopsFormText(_AM_MLDOCS_DEPARTMENT_SERVERS_PORT, 'port', 5, 5, "110");
        $port_text->setExtra("id='txtPort'");
        
        $username_text =& new XoopsFormText(_AM_MLDOCS_DEPARTMENT_SERVER_USERNAME, 'username', 25, 50);
        $username_text->setExtra("id='txtUsername'");
        
        $pass_text =& new XoopsFormText(_AM_MLDOCS_DEPARTMENT_SERVER_PASSWORD, 'password', 25, 50);
        $pass_text->setExtra("id='txtPassword'");
        
        $priority_radio =& new mldocsFormRadio(_AM_MLDOCS_DEPARTMENT_SERVERS_PRIORITY, 'priority', MLDOCS_DEFAULT_PRIORITY);
        $priority_array = array('1' => "<label for='priority1'><img src='".MLDOCS_IMAGE_URL."/priority1.png' title='". mldocsGetPriority(1)."' alt='priority1' /></label>", 
                                '2' => "<label for='priority2'><img src='".MLDOCS_IMAGE_URL."/priority2.png' title='". mldocsGetPriority(2)."' alt='priority2' /></label>", 
                                '3' => "<label for='priority3'><img src='".MLDOCS_IMAGE_URL."/priority3.png' title='". mldocsGetPriority(3)."' alt='priority3' /></label>",
                                '4' => "<label for='priority4'><img src='".MLDOCS_IMAGE_URL."/priority4.png' title='". mldocsGetPriority(4)."' alt='priority4' /></label>", 
                                '5' => "<label for='priority5'><img src='".MLDOCS_IMAGE_URL."/priority5.png' title='". mldocsGetPriority(5)."' alt='priority5' /></label>");
        $priority_radio->addOptionArray($priority_array);
        
        $email_text =& new XoopsFormText(_AM_MLDOCS_DEPARTMENT_SERVER_EMAILADDRESS, 'emailaddress', 50, 255);
        $email_text->setExtra("id='txtEmailaddress'");
        
        $btn_tray = new XoopsFormElementTray('');
        $test_button =& new XoopsFormButton('', 'email_test', _AM_MLDOCS_BUTTON_TEST, 'button');
        $test_button->setExtra("id='test'");
        $submit_button =& new XoopsFormButton('', 'updateProfil2', _AM_MLDOCS_BUTTON_SUBMIT, 'submit');
        $cancel2_button =& new XoopsFormButton('', 'cancel2', _AM_MLDOCS_BUTTON_CANCEL, 'button');
        $cancel2_button->setExtra("onclick='history.go(-1)'");
        $btn_tray->addElement($test_button);
        $btn_tray->addElement($submit_button);
        $btn_tray->addElement($cancel2_button);
        
        $form->setLabelWidth('20%');
        foreach($formElements as $element){
            $form->addElement($$element);
        }
        echo $form->render();

        echo "<script type=\"text/javascript\" language=\"javascript\">
          <!--
          function mldocsEmailTest()
          {
            pop = openWithSelfMain(\"\", \"email_test\", 250, 150);
            frm = xoopsGetElementById(\"add_server\");
            newaction = \"profilelot.php?op=testMailbox\";
            oldaction = frm.action;
            frm.action = newaction;
            frm.target = \"email_test\";
            frm.submit();
            frm.action = oldaction;
            frm.target = \"main\";
            
          }
          
          mldocsDOMAddEvent(xoopsGetElementById(\"email_test\"), \"click\", mldocsEmailTest, false);
          
          //-->
          </script>";
        mldocs_adminFooter();
        xoops_cp_footer();
    }
}

function EditProfilelotServer()
{
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
    } else {
        redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 3);       // TODO: Make message for no mbox_id
    }
    
    $hProfilServers =& mldocsGetHandler('profilelotMailBox');
    $profilServer =& $hProfilServers->get($id);
    
    if(isset($_POST['updateMailbox'])){
        $profilServer->setVar('emailaddress', $_POST['emailaddress']);
        $profilServer->setVar('server',       $_POST['server']);
        $profilServer->setVar('serverport',   $_POST['port']);
        $profilServer->setVar('username',     $_POST['username']);
        $profilServer->setVar('password',     $_POST['password']);
        $profilServer->setVar('priority',     $_POST['priority']);
        $profilServer->setVar('active',       $_POST['activity']);
        
        if($hProfilServers->insert($profilServer)){
            header("Location: ".MLDOCS_ADMIN_URL."/profilelot.php?op=editProfilelot&profilid=".$profilServer->getVar('profilelotid'));
        } else {
            redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=editProfilelot&profilid=".$profilServer->getVar('profilelotid'),3);
        }
    } else {
        global $oAdminButton;
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manProfil');
        echo '<script type="text/javascript" src="'.XOOPS_URL.'/modules/mldocs/include/functions.js"></script>';
        echo "<form method='post' id='edit_server' action='profilelot.php?op=EditProfilelotServer&amp;id=".$id."'>
               <table width='100%' cellspacing='1' class='outer'>   
                 <tr>
                   <th colspan='2'><label>". _AM_MLDOCS_DEPARTMENT_EDIT_SERVER ."</label></th>
                 </tr>
                 <tr>
                   <td class='head' width='20%'><label for='mboxtype'>"._AM_MLDOCS_DEPARTMENT_SERVERS_TYPE."</label></td>
                   <td class='even'>
                     <select name='mboxtype' id='mboxtype' onchange='mldocsPortOnChange(this.options[this.selectedIndex].text, \"txtPort\")'>
                       <option value='"._MLDOCS_MAILBOXTYPE_POP3."'>"._AM_MLDOCS_MBOX_POP3."</option>
                       <!--<option value='"._MLDOCS_MAILBOXTYPE_IMAP."'>"._AM_MLDOCS_MBOX_IMAP."</option>-->
                     </select>
                   </td>
                 </tr>
                 <tr>
                   <td class='head'><label for='txtServer'>"._AM_MLDOCS_DEPARTMENT_SERVERS_SERVERNAME."</label></td>
                   <td class='even'><input type='text' id='txtServer' name='server' value='".$profilServer->getVar('server')."' size='40' maxlength='50' />
                 </tr>                 
                 <tr>
                   <td class='head'><label for='txtPort'>"._AM_MLDOCS_DEPARTMENT_SERVERS_PORT."</label></td>
                   <td class='even'><input type='text' id='txtPort' name='port' maxlength='5' size='5' value='".$profilServer->getVar('serverport')."' />
                 </tr>
                 <tr>
                   <td class='head'><label for='txtUsername'>"._AM_MLDOCS_DEPARTMENT_SERVER_USERNAME."</label></td>
                   <td class='even'><input type='text' id='txtUsername' name='username' value='".$profilServer->getVar('username')."' size='25' maxlength='50' />
                 </tr>
                 <tr>
                   <td class='head'><label for='txtPassword'>"._AM_MLDOCS_DEPARTMENT_SERVER_PASSWORD."</label></td>
                   <td class='even'><input type='text' id='txtPassword' name='password' value='".$profilServer->getVar('password')."' size='25' maxlength='50' />
                 </tr>                 
                 <tr>
                   <td width='38%' class='head'><label for='txtPriority'>"._AM_MLDOCS_DEPARTMENT_SERVERS_PRIORITY."</label></td>
                   <td width='62%' class='even'>";
        for($i = 1; $i < 6; $i++) {
                   $checked = '';
                   if($profilServer->getVar('priority') == $i){
                       $checked = 'checked="checked"';
                   }
                   echo("<input type=\"radio\" value=\"$i\" id=\"priority$i\" name=\"priority\" $checked />");
                   echo("<label for=\"priority$i\"><img src=\"../images/priority$i.png\" title=\"". mldocsGetPriority($i)."\" alt=\"priority$i\" /></label>");
        }
                   echo "</td>
                 </tr>
                 <tr>
                   <td class='head'><label for='txtEmailaddress'>"._AM_MLDOCS_DEPARTMENT_SERVER_EMAILADDRESS."</label></td>
                   <td class='even'><input type='text' id='txtEmailaddress' name='emailaddress' value='".$profilServer->getVar('emailaddress')."' size='50' maxlength='255' />
                 </tr>
                 <tr>
                   <td class='head'><label for='txtActive'>"._AM_MLDOCS_TEXT_ACTIVITY."</label></td>
                   <td class='even'>";
                            if($profilServer->getVar('active') == 1){
                                echo "<input type='radio' value='1' name='activity' checked='checked' />"._AM_MLDOCS_TEXT_ACTIVE."
                                      <input type='radio' value='0' name='activity' />"._AM_MLDOCS_TEXT_INACTIVE;
                            } else {
                                echo "<input type='radio' value='1' name='activity' />"._AM_MLDOCS_TEXT_ACTIVE."
                                      <input type='radio' value='0' name='activity' checked='checked' />"._AM_MLDOCS_TEXT_INACTIVE;
                            }
                                    
                 echo "</td>
                 </tr>
    
                 <tr class='foot'>
                   <td colspan='2'><div align='right'><span >
                       <input type='button' id='email_test' name='test' value='"._AM_MLDOCS_BUTTON_TEST."' class='formButton' />
                       <input type='submit' name='updateMailbox' value='"._AM_MLDOCS_BUTTON_SUBMIT."' class='formButton' />
                       <input type='button' name='cancel' value='"._AM_MLDOCS_BUTTON_CANCEL."' onclick='history.go(-1)' class='formButton' />
                   </span></div></td>
                 </tr>
               </table>
             </form>";
        echo "<script type=\"text/javascript\" language=\"javascript\">
          <!--
          function mldocsEmailTest()
          {
            pop = openWithSelfMain(\"\", \"email_test\", 250, 150);
            frm = xoopsGetElementById(\"edit_server\");
            newaction = \"profilelot.php?op=testMailbox\";
            oldaction = frm.action;
            frm.action = newaction;
            frm.target = \"email_test\";
            frm.submit();
            frm.action = oldaction;
            frm.target = \"main\";
            
          }
          
          mldocsDOMAddEvent(xoopsGetElementById(\"email_test\"), \"click\", mldocsEmailTest, false);
          
          //-->
          </script>";
          mldocs_adminFooter();
          xoops_cp_footer();
    }
}

function manageProfilelots()
{
    global $xoopsModule, $oAdminButton, $aSortBy, $aOrderBy, $aLimitBy, $order, $limit, $start, $sort;
    $module_id = $xoopsModule->getVar('mid');
    
    $hGroups =& xoops_gethandler('group');
    $hGroupPerm =& xoops_gethandler('groupperm');
    
    if(isset($_POST['addProfil'])){
        $hasErrors = false;
        $errors = array();
        $groups = (isset($_POST['groups']) ? $_POST['groups'] : array());
        $hProfilelots  =& mldocsGetHandler('profilelot');
        
        //Profilelot Name supplied?
        if (trim($_POST['newProfil']) == '') {
            $hasErrors = true;
            $errors['newProfil'][] = _AM_MLDOCS_MESSAGE_NO_DEPT;
        } else {
        
            //Profilelot Name unique?
            $crit = new Criteria('profilelot', $_POST['newProfil']);
            if($existingProfils = $hProfilelots->getCount($crit)){
                $hasErrors = true;
                $errors['newProfil'][] = _MLDOCS_MESSAGE_DEPT_EXISTS;
                
            }
        }
        
        if ($hasErrors) {
            $session =& Session::singleton();
            //Store existing profil info in session, reload addition page
            $aProfil = array();
            $aProfil['newProfil'] = $_POST['newProfil'];
            $aProfil['groups'] = $groups;
            $session->set('mldocs_addProfilelot', $aProfil);
            $session->set('mldocs_addProfilelotErrors', $errors);
            header('Location: '. mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'manageProfilelots'), false));
            exit();
        }
        
        $profilelot =& $hProfilelots->create();
        $profilelot->setVar('profilelot', $_POST['newProfil']);

        if($hProfilelots->insert($profilelot)){
            $profilID = $profilelot->getVar('id');
            foreach($groups as $group){     // Add new group permissions
                $hGroupPerm->addRight(_MLDOCS_GROUP_PERM_DEPT, $profilID, $group, $module_id);
            }
            
            // Set as default profilelot?
            if(isset($_POST['defaultProfil']) && ($_POST['defaultProfil'] == 1)){
                mldocsSetMeta("default_profilelot", $profilID);
            }
            
            $hStaff =& mldocsGetHandler('staff');
            $allProfilStaff =& $hStaff->getByAllProfils();
            if (count($allProfilStaff) > 0) {
                $hMembership =& mldocsGetHandler('membership');
                if($hMembership->addStaffToProfil($allProfilStaff, $profilelot->getVar('id'))){
                    $message = _MLDOCS_MESSAGE_ADD_DEPT;
                } else {
                    $message = _AM_MLDOCS_MESSAGE_STAFF_UPDATE_ERROR;
                }
            } else {
                $message = _MLDOCS_MESSAGE_ADD_DEPT;
            }
            
            // Add configoption for new profilelot
            $hConfig =& xoops_gethandler('config');
            $hConfigOption =& xoops_gethandler('configoption');
            
            $crit = new Criteria('conf_name', 'mldocs_defaultProfil');
            $config =& $hConfig->getConfigs($crit);
            
            if(count($config) > 0){
                $newOption =& $hConfigOption->create();
                $newOption->setVar('confop_name', $profilelot->getVar('profilelot'));
                $newOption->setVar('confop_value', $profilelot->getVar('id'));
                $newOption->setVar('conf_id', $config[0]->getVar('conf_id'));
                
                if(!$hConfigOption->insert($newOption)){
                    redirect_header(MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 3, _AM_MLDOCS_MSG_ADD_CONFIG_ERR);
                }
            }
            _clearAddSessionVars();
            header("Location: ".MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots");
        } else {
            $message = _MLDOCS_MESSAGE_ADD_DEPT_ERROR . $profilelot->getHtmlErrors();
        }
        
        $profilID = $profilelot->getVar('id');
        
        /* Not sure if this is needed. Already exists in if block above (ej)
        foreach($groups as $group){
            $hGroupPerm->addRight(_MLDOCS_GROUP_PERM_DEPT, $profilID, $group, $module_id);
        }
        */
        
        redirect_header(MLDOCS_ADMIN_URL.'/profilelot.php?op=manageProfilelots', 3, $message);
     } else {     
        $hProfilelots  =& mldocsGetHandler('profilelot');
        $crit = new Criteria('','');
        $crit->setOrder($order);
        $crit->setSort($sort);
        $crit->setLimit($limit);
        $crit->setStart($start);
        $total = $hProfilelots->getCount($crit);
        $profilelotInfo =& $hProfilelots->getObjects($crit);
        
        $nav = new XoopsPageNav($total, $limit, $start, 'start', "op=manageProfilelots&amp;limit=$limit");
        
        // Get list of all groups
        $crit = new Criteria('', '');
        $crit->setSort('name');
        $crit->setOrder('ASC');
        $groups =& $hGroups->getObjects($crit, true);
        
        $aGroups = array();
        foreach($groups as $group_id=>$group){
            $aGroups[$group_id] = $group->getVar('name');
        }
        asort($aGroups);    // Set groups in alphabetical order
        
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manProfil');
        
        $session =& Session::singleton();
        $sess_profil = $session->get('mldocs_addProfilelot');
        $sess_errors = $session->get('mldocs_addProfilelotErrors');
        
        //Display any form errors
        if (! $sess_errors === false) {
            mldocsRenderErrors($sess_errors, mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'clearAddSession'), false));
        }
        
        if (! $sess_profil === false) {
            $fld_newProfil = $sess_profil['newProfil'];
            $fld_groups  = $sess_profil['groups'];
        } else {
            $fld_newProfil = '';
            $fld_groups = array();
        }
        
        echo "<form method='post' action='".MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots'>";
        echo "<table width='100%' cellspacing='1' class='outer'>
              <tr><th colspan='2'><label for='newProfil'>". _AM_MLDOCS_LINK_ADD_DEPT ." </label></th></tr>";
        echo "<tr><td class='head' width='20%' valign='top'>". _AM_MLDOCS_TEXT_NAME ."</td><td class='even'>";
        echo "<input type='text' id='newProfil' name='newProfil' class='formButton' value='$fld_newProfil' /></td></tr>";
        echo "<tr><td class='head' width='20%' valign='top'>"._AM_MLDOCS_TEXT_EDIT_DEPT_PERMS."</td><td class='even'>";
        echo "<select name='groups[]' multiple='multiple'>";
                  foreach($aGroups as $group_id=>$group){
                      if (in_array($group_id, $fld_groups, true)) {
                        echo "<option value='$group_id' selected='selected'>$group</option>";
                      } else {
                        echo "<option value='$group_id'>$group</option>";
                      }
                  }
        echo "</select></td></tr>";
        echo "<tr><td class='head' width='20%' valign='top'>"._AM_MLDOCS_TEXT_DEFAULT_DEPT."?</td>
                  <td class='even'><input type='checkbox' name='defaultProfil' id='defaultProfil' value='1' /></td></tr>";
        echo "<tr><td class='foot' colspan='2'><input type='submit' name='addProfil' value='"._AM_MLDOCS_BUTTON_SUBMIT."' class='formButton' /></td></tr>";
        echo "</table><br />";
        echo "</form>";
        if($total > 0){     // Make sure there are profilelots
            echo "<form action='". MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots' style='margin:0; padding:0;' method='post'>";
            echo "<table width='100%' cellspacing='1' class='outer'>";
            echo "<tr><td align='right'>"._AM_MLDOCS_TEXT_SORT_BY." 
                          <select name='sort'>";
                        foreach($aSortBy as $value=>$text){
                            ($sort == $value) ? $selected = "selected='selected'" : $selected = '';
                            echo "<option value='$value' $selected>$text</option>";
                        }
                        echo "</select>
                        &nbsp;&nbsp;&nbsp;
                          "._AM_MLDOCS_TEXT_ORDER_BY."
                          <select name='order'>";
                        foreach($aOrderBy as $value=>$text){
                            ($order == $value) ? $selected = "selected='selected'" : $selected = '';
                            echo "<option value='$value' $selected>$text</option>";
                        }
                        echo "</select>
                          &nbsp;&nbsp;&nbsp;
                          "._AM_MLDOCS_TEXT_NUMBER_PER_PAGE."
                          <select name='limit'>";
                        foreach($aLimitBy as $value=>$text){
                            ($limit == $value) ? $selected = "selected='selected'" : $selected = '';
                            echo "<option value='$value' $selected>$text</option>";
                        }
                        echo "</select>
                          <input type='submit' name='profil_sort' id='profil_sort' value='"._AM_MLDOCS_BUTTON_SUBMIT."' />
                      </td>
                  </tr>";
            echo "</table></form>";
            echo "<table width='100%' cellspacing='1' class='outer'>
                  <tr><th colspan='4'>"._AM_MLDOCS_EXISTING_DEPARTMENTS."</th></tr>
                  <tr><td class='head'>"._AM_MLDOCS_TEXT_ID."</td><td class='head'>"._AM_MLDOCS_TEXT_DEPARTMENT."</td><td class='head'>"._AM_MLDOCS_TEXT_DEFAULT."</td><td class='head'>"._AM_MLDOCS_TEXT_ACTIONS."</td></tr>";
                  
            if(isset($profilelotInfo)){
                $defaultProfil = mldocsGetMeta("default_profilelot");
                foreach($profilelotInfo as $profil){
                    echo "<tr><td class='even'>". $profil->getVar('id')."</td><td class='even'>". $profil->getVar('profilelot') ."</td>";
                    if($profil->getVar('id') != $defaultProfil){
                        echo "<td class='even' width='10%'><a href='".MLDOCS_ADMIN_URL."/profilelot.php?op=updateDefault&amp;id=".$profil->getVar('id')."'><img src='".MLDOCS_IMAGE_URL."/off.png' alt='"._AM_MLDOCS_TEXT_MAKE_DEFAULT_DEPT."' title='"._AM_MLDOCS_TEXT_MAKE_DEFAULT_DEPT."' /></a></td>";
                    } else {
                        echo "<td class='even' width='10%'><img src='".MLDOCS_IMAGE_URL."/on.png'</td>";
                    }
                    //echo "<td class='even' width='10%'><img src='".MLDOCS_IMAGE_URL."/". (($profil->getVar('id') == $defaultProfil) ? "on.png" : "off.png")."'</td>";
                    echo "<td class='even' width='70'><a href='".MLDOCS_ADMIN_URL."/profilelot.php?op=editProfilelot&amp;profilid=".$profil->getVar('id')."'><img src='".XOOPS_URL."/modules/mldocs/images/button_edit.png' title='"._AM_MLDOCS_TEXT_EDIT."' name='editProfilelot' /></a>&nbsp;&nbsp;";
                    echo "<a href='".MLDOCS_ADMIN_URL."/delete.php?deleteProfil=1&amp;profilid=".$profil->getVar('id')."'><img src='".XOOPS_URL."/modules/mldocs/images/button_delete.png' title='"._AM_MLDOCS_TEXT_DELETE."' name='deleteProfilelot' /></a></td></tr>";
                }
                                    
            }
        }
        echo "</td></tr></table>";
        echo "<div id='profil_nav'>".$nav->renderNav()."</div>";
        mldocs_adminFooter();
        xoops_cp_footer();
    }
}

function testMailbox()
{
    $hProfilServers =& mldocsGetHandler('profilelotMailBox');
    $server = $hProfilServers->create();
    $server->setVar('emailaddress', $_POST['emailaddress']);
    $server->setVar('server',       $_POST['server']);
    $server->setVar('serverport',   $_POST['port']);
    $server->setVar('username',     $_POST['username']);
    $server->setVar('password',     $_POST['password']);
    $server->setVar('priority',     $_POST['priority']);    
    echo "<html>";
    echo "<head>";
    echo "<link rel='stylesheet' type='text/css' media'screen' href='".XOOPS_URL."/xoops.css' />
          <link rel='stylesheet' type='text/css' media='screen' href='". xoops_getcss() ."' />
          <link rel='stylesheet' type='text/css' media='screen' href='".XOOPS_URL."/modules/system/style.css' />";
    echo "</head>";
    echo "<body>";      
    echo "<table style='margin:0; padding:0;' class='outer'>";
    if (@$server->connect()) {
        //Connection Succeeded
        echo "<tr><td class='head'>Connection Successful!</td></tr>";
    } else {
        //Connection Failed
        echo "<tr class='head'><td>Connection Failed!</td></tr>";
        echo "<tr class='even'><td>". $server->getHtmlErrors()."</td></tr>";
    }
    echo "</table>";
    echo "</body>";
    echo "</html>";
}

function clearAddSession()
{
    _clearAddSessionVars();
    header('Location: ' . mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'manageProfilelots'), false));
}

function _clearAddSessionVars()
{
    $session = Session::singleton();
    $session->del('mldocs_addProfilelot');
    $session->del('mldocs_addProfilelotErrors');
}

function clearEditSession()
{
    $profilid = $_REQUEST['profilid'];
    _clearEditSessionVars($profilid);
    header('Location: ' . mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'editProfilelot', 'profilid'=>$profilid), false));
}

function _clearEditSessionVars($id)
{
    $id = intval($id);
    $session = Session::singleton();
    $session->del("mldocs_editProfilelot_$id");
    $session->del("mldocs_editProfilelotErrors_$id");
}

function updateDefault()
{
    $id = intval($_REQUEST['id']);
    mldocsSetMeta("default_profilelot", $id);
    header('Location: '. mldocsMakeURI(MLDOCS_ADMIN_URL.'/profilelot.php', array('op'=>'manageProfilelots'), false));
}
?>
