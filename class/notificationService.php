<?php
//$Id: notificationService.php,v 1.87 2005/10/07 15:00:31 eric_juden Exp $
if (!defined('MLDOCS_CONSTANTS_INCLUDED')) {
    exit();
}

include_once(MLDOCS_BASE_PATH.'/functions.php');
/**
 * mldocs_notificationService class
 *
 * Part of the Messaging Subsystem.  Uses the xoopsNotificationHandler class to send emails to users
 *
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
 
class mldocs_notificationService
{ 
    /**
     * Instance of the staff object
     *
     * @var object
     * @access private
     */
     var $_hStaff;
    
    /**
     * Instance of the xoops text sanitizer
     *
     * @var object
     * @access private
     */
    var $_ts;
    
    /**
     * Path to the mail_template directory
     *
     * @var string
     * @access private
     */
    var $_template_dir = '';
    
    /**
     * Instance of the module object
     *
     * @var object
     * @access private
     */
    var $_module;
    
    /**
     * Instance of the notification object
     *
     * @var object
     * @access private
     */
    var $_hNotification;
    
    /**
     * Instance of the status object
     *
     * @var object
     * @access private
     */
    var $_hStatus;
         
    /**
	 * Class Constructor
	 * 
	 * @access	public	
	 */	    
    function mldocs_notificationService()
    {
        global $xoopsConfig, $xoopsModule;
        
        $this->_ts     =& MyTextSanitizer::getInstance();
        $this->_template_dir = $this->_getTemplateDir($xoopsConfig['language']);
        $this->_module =& mldocsGetModule();
        $this->_hStaff =& mldocsGetHandler('staff');
        $this->_hNotification =& mldocsGetHandler('notification');
        $this->_hStatus =& mldocsGetHandler('status');
    }
    
    /**
     * Retrieve the email_template object that is requested
     *
     * @param int $category ID of item
     * @param string $event name of event
     * @param object $module $xoopsModule object
     *
     * @access private
     */
    function _getEmailTpl($category, $event, $module, &$template_id)
    {
        $templates =& $module->getInfo('_email_tpl');   // Gets $modversion['_email_tpl'] array from xoops_version.php
        
        foreach($templates as $tpl_id=>$tpl){
            if($tpl['category'] == $category && $tpl['name'] == $event){
                $template_id = $tpl_id;
                return $tpl;
            }
        }
        return false;
    }
    
    /*
     * Returns a group of $staffRole objects
     *
     * @access int $dept ID of department
     * @access array $aMembers array of all possible staff members
     *
     * @access private
     */
    function &_getStaffRoles($dept, $aMembers)
    {
        $hStaffRole =& mldocsGetHandler('staffRole');
        
        // Retrieve roles of all members
        $crit = new CriteriaCompo(new Criteria('uid', "(".implode($aMembers, ',').")", "IN"));
        $crit->add(new Criteria('deptid', $dept));
        $staffRoles =& $hStaffRole->getObjects($crit, false);    // array of staff role objects
        
        return $staffRoles;
    }
    
    /*
     * Gets a list of staff members that have the notification selected
     *
     * @access object $staffRoles staffRole objects
     * @access array $aMembers array of all possible staff members
     * @access array $staff_options array of acceptable departments
     *
     * @access private
     */
    function &_getEnabledStaff(&$staffRoles, $aMembers, $staff_options)
    {
        // Get only staff members that have permission for this notification
        $enabled_staff = array();
        foreach($aMembers as $aMember){
            foreach($staffRoles as $staffRole){
             	if ($staffRole->getVar('uid') == $aMember && in_array($staffRole->getVar('roleid'),$staff_options)){
             		$enabled_staff[$aMember] = $aMember;
                    break;
                }
            }
        }
        unset($aMembers);
        return $enabled_staff;
    }
    
    /*
     * Used to retrieve a list of xoops user objects
     * 
     * @param array $enabled_staff array of staff members that have the notification enabled
     * 
     * @access private
     */
    function &_getXoopsUsers($enabled_staff, $active_only = true)
    {
        $xoopsUsers = array();
        $hMember =& xoops_gethandler('member');
        if(count($enabled_staff) > 0){
            $crit = new CriteriaCompo(new Criteria('uid', "(".implode($enabled_staff, ',').")", "IN"));
        } else {
            return $xoopsUsers;
        }
        if ($active_only) {
					$crit->add(new Criteria('level', 0, '>'));
			  }        	
        $xoopsUsers =& $hMember->getUsers($crit, true);      // xoopsUser objects
        unset($enabled_staff);
        
        return $xoopsUsers;
    }
    
    /*
     * Returns only the accepted staff members after having their permissions checked
     * 
     * @param array $aMembers array of all possible staff members
     * @param object $archive mldocs_archive object
     * @param object $settings mldocs_notification object
     * @param int $submittedBy ID of archive submitter
     * @return array of XoopsUser objects
     * 
     * @access private
     */
    function &_checkStaffSetting($aMembers, &$archive, &$settings, $submittedBy)
    {   
        $submittedBy = intval($submittedBy);
        if(is_object($archive)){
            $dept = $archive->getVar('department');
        } else {
            $dept = $archive;
        }
        $staff_setting = $settings->getVar('staff_setting');
        $staff_options = $settings->getVar('staff_options');
        
        $staffRoles =& $this->_getStaffRoles($dept, $aMembers);     // Get list of the staff members' roles
        $enabled_staff =& $this->_getEnabledStaff($staffRoles, $aMembers, $staff_options);
        $xoopsUsers =& $this->_getXoopsUsers($enabled_staff);
        
        return $xoopsUsers;
    }
    
    /*
     * Returns an array of staff UID's
     *
     * @access object $members mldocs_staff objects
     * @access boolean $removeSubmitter
     *
     * @access private
     */
    function &_makeMemberArray(&$members, $submittedBy, $removeSubmitter = false)
    {
        $aMembers = array();
        $submittedBy = intval($submittedBy);
        foreach($members as $member){   // Full list of dept members
            if($removeSubmitter){
                if($member->getVar('uid') == $submittedBy){ // Remove the staff member that submitted from the email list
                    continue;
                } else {
                    $aMembers[$member->getVar('uid')] = $member->getVar('uid');
                }
            } else {
                $aMembers[$member->getVar('uid')] = $member->getVar('uid');
            }
        }
        return $aMembers;
    }
    
    /**
     * Returns emails of staff belonging to an event
     * 
     * @param int $dept ID of department
     * @param int $event_id bit_value of event
     * @param int $submittedBy ID of user submitting event - should only be used when there is a response
     *
     * @access private
     */
    function &_getSubscribedStaff(&$archive, $event_id, &$settings, $submittedBy = null)
    {
        global $xoopsUser;
        
    	$arr = array();
        $hMembership =& mldocsGetHandler('membership');
        $hMember =& xoops_gethandler('member');
        
        if(is_object($archive)){
            if(!$submittedBy){
                $submittedBy = $archive->getVar('uid');
            }
            $owner = $archive->getVar('ownership');
            $dept = $archive->getVar('department');
        } else {
            $dept = intval($archive);
        }
        $submittedBy = intval($submittedBy);

        $staff_setting = $settings->getVar('staff_setting');
        $staff_options = $settings->getVar('staff_options');
        switch($staff_setting){
            case MLDOCS_NOTIF_STAFF_DEPT:   // Department Staff can receive notification
                $members =& $hMembership->membershipByDept($dept);  // mldocsStaff objects
                $aMembers =& $this->_makeMemberArray($members, $submittedBy, true);
                $xoopsUsers =& $this->_checkStaffSetting($aMembers, $archive, $settings, $submittedBy);                
            break;
            
            case MLDOCS_NOTIF_STAFF_OWNER:   // Archive Owner can receive notification
                $members =& $hMembership->membershipByDept($dept);
                if($archive->getVar('ownership') <> 0){      // If there is a archive owner
                    $archive_owner = $archive->getVar('ownership');
                    $aMembers[$archive_owner] = $archive_owner;
                    $crit = new Criteria('uid', "(".implode($aMembers, ',').")", "IN");
                    unset($aMembers);
                    $xoopsUsers =& $hMember->getUsers($crit, true);      // xoopsUser objects
                } else {                                    // If no archive owner, send to dept staff
                    $aMembers =& $this->_makeMemberArray($members, true);
                    $xoopsUsers =& $this->_checkStaffSetting($aMembers, $archive, $settings, $submittedBy);
                }
            break;
            
            case MLDOCS_NOTIF_STAFF_NONE:   // Notification is turned off
            Default:
                return $arr;
        }
                
        //Sort users based on Notification Preference
        foreach($xoopsUsers as $xUser){
        $cMember =& $members[$xUser->getVar('uid')];
            
            if(isset($cMember) && ($xUser->uid() != $xoopsUser->uid())){
            	if($this->_isSubscribed($cMember, $event_id)){
                    if($xUser->getVar('notify_method') == 2){       // Send by email
                        $arr['email'][] = $members[$xUser->getVar('uid')]->getVar('email');
                    } elseif($xUser->getVar('notify_method') == 1){ // Send by pm
                        $arr['pm'][] = $xUser;
                    }
                }
            }
        }
        return $arr;
    }
    
    /**
     * Returns emails of users belonging to a archive
     * 
     * @param int $archiveid ID of archive
     * @access private
     */
    function &_getSubscribedUsers($archiveid)
    {
        global $xoopsUser; 
        
    	$archiveid = intval($archiveid);
        
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $hMember =& xoops_gethandler('member');
        $crit = new CriteriaCompo(new Criteria('archiveid', $archiveid));
        $crit->add(new Criteria('suppress', 0));
        // email needs to be different then the user's email performing this action
        $crit->add(new Criteria('email', $xoopsUser->email(), '<>')); 
        $users =& $hArchiveEmails->getObjects($crit);    // mldocs_archiveEmail objects
        
        $aUsers = array();
        $arr = array();
        foreach($users as $user){
            if($user->getVar('uid') != 0){
                $aUsers[$user->getVar('email')] = $user->getVar('uid');
            } else {
                // Add users with just email to array
                $arr['email'][] = $user->getVar('email');
            }
        }
        
        $xoopsUsers = array();
        if(!empty($aUsers)){
            $crit = new Criteria('uid', "(".implode($aUsers, ',').")", "IN");
            $xoopsUsers =& $hMember->getUsers($crit, true);  // xoopsUser objects
        }
        unset($aUsers);
        
        // Add users with uid
        foreach($xoopsUsers as $xUser){  // Find which method user prefers for sending message
            if($xUser->getVar('notify_method') == 2){
                $arr['email'][] = $xUser->getVar('email');
            } elseif($xUser->getVar('notify_method') == 1) {
                $arr['pm'][] = $xUser;
            }
        }
        return $arr;
    }
    
    /**
     * Checks to see if the staff member is subscribed to receive the notification for this event
     *
     * @param int/object $user userid/staff object of staff member
     * @param int $event_id value of the the event
     * @return bool true is suscribed, false if not
     *
     * @access private
     */
    function _isSubscribed($user, $event_id)
    {
        if(!is_object($user)){          //If user is not an object, retrieve a staff object using the uid
            if(is_numeric($user)){
                $uid = $user;
                $hStaff =& mldocsGetHandler('staff');
                if(!$user =& $hStaff->getByUid($uid)){
                    return false;
                }
            }
        }
        
        if($user->getVar('notify') & (pow(2, $event_id))){     // If staff has proper bit_value
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Retrieve a user's email address
     * 
     * @param int $uid user's id
     * @return string $member's email 
     *
     * @access private
     */
    function _getUserEmail($uid)
    {
        global $xoopsUser;
        $arr = array();
        $uid = intval($uid);
        
        if($uid == $xoopsUser->getVar('uid')){      // If $uid == current user's uid
            if($xoopsUser->getVar('notify_method') == 2){
                $arr['email'][] = $xoopsUser->getVar('email');     // return their email
            } elseif($xoopsUser->getVar('notify_method') == 1){
                $arr['pm'][] = $xoopsUser;
            }
        } else {
            $hMember =& xoops_gethandler('member');     //otherwise...
            if($member =& $hMember->getUser($uid)){
                if($member->getVar('notify_method') == 2) {
                    $arr['email'][] = $member->getVar('email');
                } elseif($member->getVar('notify_method') == 1) {
                    $arr['pm'][] = $member;
                }
            } else {
                $arr['email'][] = '';
            }
        }
        return $arr;
    }
    
    /**
     * Retrieves a staff member's email address
     *
     * @param int $uid user's id
     * @return string $staff member's email
     *
     * @access private
     */
    function _getStaffEmail($uid, $dept, $staff_options)
    {  
        $uid = intval($uid);
        $dept = intval($dept);
        $hMember =& xoops_gethandler('member');
        $arr = array();
        
        // Check staff roles to staff options making sure the staff has permission
        $staffRoles =& $this->_hStaff->getRolesByDept($uid, $dept, true);
        $bFound = true;
        foreach($staff_options as $option){
            if(array_key_exists($option, $staffRoles)){
                $bFound = true;
                break;
            } else {
                $bFound = false;
            }
        }
        if(!$bFound){
            return $arr;
        }
        
        if($staff =& $this->_hStaff->getByUid($uid)){        
            if($member =& $hMember->getUser($uid)){
                if($member->getVar('notify_method') == 2) {
                    $arr['email'][] = $staff->getVar('email');
                } elseif($member->getVar('notify_method') == 1) {
                    $arr['pm'][] = $member;
                }
            } else {
                $arr['email'][] = '';
            }
        } else {
            $arr['email'][] = '';
        }
        return $arr;
    }
    
    /**
     * Send pm and email notifications to selected users
     *
     * @param object $email_tpl object returned from _getEmailTpl() function
     * @param array $sendTo emails and xoopsUser objects
     * @param array $tags array of notification information
     * @return bool TRUE if success, FALSE if no success
     *
     * @access private
     */
    function _sendEvents($email_tpl, $sendTo, $tags, $fromEmail = '')
    {
        $ret = true;
        if(array_key_exists('pm', $sendTo)){
            $ret = $ret && $this->_sendEventPM($email_tpl, $sendTo, $tags, $fromEmail = '');
        }
        
        if(array_key_exists('email', $sendTo)){
            $ret = $ret && $this->_sendEventEmail($email_tpl, $sendTo, $tags, $fromEmail = '');
        }
        return $ret;
    }
    
    /**
     * Send the pm notification to selected users
     *
     * @param object $email_tpl object returned from _getEmailTpl() function
     * @param array $sendTo xoopsUser objects
     * @param array $tags array of notification information
     * @return bool TRUE if success, FALSE if no success
     *
     * @access private
     */
    function _sendEventPM($email_tpl, $sendTo, $tags, $fromEmail = '')
    {
        $notify_pm = '';
        global $xoopsConfig, $xoopsUser;
        
        $notify_pm = $sendTo['pm'];
        		
		$tags = array_merge($tags, $this->_getCommonTplVars());          // Retrieve the common template vars and add to array
        $xoopsMailer =& getMailer();            
        $xoopsMailer->usePM();
        
        foreach($tags as $k=>$v){
            $xoopsMailer->assign($k, preg_replace("/&amp;/i", '&', $v));    
        }
        $xoopsMailer->setTemplateDir($this->_template_dir);             // Set template dir
        $xoopsMailer->setTemplate($email_tpl['mail_template']. ".tpl"); // Set the template to be used
        
        $config_handler =& xoops_gethandler('config');
        $hMember =& xoops_gethandler('member');
        $xoopsMailerConfig =& $config_handler->getConfigsByCat(XOOPS_CONF_MAILER);
	    $xoopsMailer->setFromUser($hMember->getUser($xoopsMailerConfig['fromuid']));
        $xoopsMailer->setToUsers($notify_pm);
        $xoopsMailer->setSubject($email_tpl['mail_subject']);           // Set the subject of the email
        $xoopsMailer->setFromName($xoopsConfig['sitename']);            // Set a from address
        $success = $xoopsMailer->send(true);
        
        return $success;
    }
    
    /**
     * Send the mail notification to selected users
     *
     * @param object $email_tpl object returned from _getEmailTpl() function
     * @param array $sendTo emails returned from _getSubscribedStaff() function
     * @param array $tags array of notification information
     * @return bool TRUE if success, FALSE if no success
     *
     * @access private
     */
    function _sendEventEmail($email_tpl, $sendTo, $tags, $fromEmail = '')
    {        
        $notify_email = '';
        global $xoopsConfig;
        
        $notify_email = $sendTo['email'];

        $tags = array_merge($tags, $this->_getCommonTplVars());          // Retrieve the common template vars and add to array
        $xoopsMailer =& getMailer();            
        $xoopsMailer->useMail();
        
        foreach($tags as $k=>$v){
            $xoopsMailer->assign($k, preg_replace("/&amp;/i", '&', $v));    
        }
        $xoopsMailer->setTemplateDir($this->_template_dir);             // Set template dir
        $xoopsMailer->setTemplate($email_tpl['mail_template']. ".tpl"); // Set the template to be used
        if (strlen($fromEmail) > 0) {
            $xoopsMailer->setFromEmail($fromEmail);
        }
        $xoopsMailer->setToEmails($notify_email);                           // Set who the email goes to
        $xoopsMailer->setSubject($email_tpl['mail_subject']);           // Set the subject of the email
        $xoopsMailer->setFromName($xoopsConfig['sitename']);            // Set a from address
        $success = $xoopsMailer->send(true);
        
        return $success;
    }
    
    /**
     * Get a list of the common constants required for notifications
     *
     * @return array $tags
     *
     * @access private
     */
    function &_getCommonTplVars()
    {
        global $xoopsConfig;
        $tags = array();
        $tags['X_MODULE'] = $this->_module->getVar('name');
        $tags['X_SITEURL'] = MLDOCS_SITE_URL;
        $tags['X_SITENAME'] = $xoopsConfig['sitename'];
        $tags['X_ADMINMAIL'] = $xoopsConfig['adminmail'];
        $tags['X_MODULE_URL'] = MLDOCS_BASE_URL . '/';
        
        return $tags;
    }
    
    /**
     * Retrieve the directory where mail templates are stored
     *
     * @param string $language language used for xoops
     * @return string $template_dir
     * 
     * @access private
     */
    function _getTemplateDir($language)
    {
        $path = XOOPS_ROOT_PATH .'/modules/mldocs/language/'. $language .'/mail_template';
        if(is_dir($path)){
            return $path;
        } else {
            return XOOPS_ROOT_PATH .'/modules/mldocs/language/english/mail_template';
        }
    }
    
    /**
     * Returns the number of department notifications
     *
     * @return int $num number of department notifications
     *
     * @access public
     */
    function getNumDeptNotifications()
    {
        $num = 0;
        $templates =& $this->_module->getInfo('_email_tpl');
        foreach($templates as $template){
            if($template['category'] == 'dept'){
                $num++;
            }
        }
        return ($num);
    }

    /**
     * Returns the email address of the person causing the fire of the event
     *
     * @param int $uid uid of the user
     * @return string email of user
     *
     * @access private
     */
    function _getEmail($uid)
    {
        if(!$isStaff = $this->_hStaff->isStaff($uid)){
            return $this->_getUserEmail($uid);   
        } else {
            return $this->_getStaffEmail($uid);
        }
    }    
    
    /**
	 * Callback function for the 'new_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */
    function new_archive($args)  // Notification #1
    {
        global $isStaff;
        // Send Email to Department Staff members
        // Send Confirm Email to submitter (users only)
        
        global $xoopsUser, $xoopsModuleConfig;
        list($archive) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
       
        $tags = array();
        $tags['ARCHIVE_ID'] = $archive->getVar('id');
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        $tags['ARCHIVE_DESCRIPTION'] = $this->_ts->stripslashesGPC($archive->getVar('description', 'n'));
        $tags['ARCHIVE_PRIORITY'] = mldocsGetPriority($archive->getVar('priority'));
        $tags['ARCHIVE_POSTED'] = $archive->posted();
        $tags['ARCHIVE_CREATED'] = mldocsGetUsername($archive->getVar('uid'), $displayName);
		$tags['ARCHIVE_SUPPORT_KEY'] = ($archive->getVar('serverid') ? '{'.$archive->getVar('emailHash').'}' : '');
		$tags['ARCHIVE_URL'] = MLDOCS_BASE_URL .'/archive.php?id='.$archive->getVar('id');
		$tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_NEWARCHIVE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){    // If staff notification is enabled
            if($email_tpl = $this->_getEmailTpl('dept', 'new_archive', $this->_module, $template_id)){  // Send email to dept members
                $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
        
        if($user_setting <> MLDOCS_NOTIF_USER_NO){     // If user notification is enabled
            if ($archive->getVar('serverid') > 0) {
                //this archive has been submitted by email
                //get department email address
                $hServer =& mldocsGetHandler('departmentMailBox');
                $server =& $hServer->get($archive->getVar('serverid'));
                //
                $tags['ARCHIVE_SUPPORT_EMAIL'] = $server->getVar('emailaddress');
                //
                if($email_tpl = $this->_getEmailTpl('archive', 'new_this_archive_via_email', $this->_module, $template_id)){
                    //$sendTo = $this->_getEmail($archive->getVar('uid'));
                    $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                    $success = $this->_sendEvents($email_tpl, $sendTo, $tags, $server->getVar('emailaddress')); 
                }
            } else { //this archive has been submitted via the website
                if(!$isStaff){
                    if($email_tpl = $this->_getEmailTpl('archive', 'new_this_archive', $this->_module, $template_id)) {    // Send confirm email to submitter
                        //$sendTo = $this->_getEmail($archive->getVar('uid'));
                        //$sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                        $sendTo = $this->_getUserEmail($archive->getVar('uid'));   // Will be the only person subscribed
                        $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                    }
                }
            }
        }
    }

    /**
   * Callback function for the 'new_user_by_email' event
   * @param  array  $args Array of arguments passed to EventService
   * @access  public
   */
    function new_user_by_email($args)
    {
        // Send Welcome Email to submitter
        //global $xoopsUser;
        list($password, $user) = $args;
        $tags = array();
        $tags['XOOPS_USER_NAME']     = $user->getVar('uname');
        $tags['XOOPS_USER_EMAIL']    = $user->getVar('email');
        $tags['XOOPS_USER_ID']       = $user->getVar('uname');
        $tags['XOOPS_USER_PASSWORD'] = $password;
        $tags['X_UACTLINK']          = MLDOCS_SITE_URL ."/user.php?op=actv&id=".$user->getVar("uid")."&actkey=".$user->getVar('actkey');
        
        if($email_tpl = $this->_getEmailTpl('archive', 'new_user_byemail', $this->_module, $template_id)){
            $sendTo = $this->_getUserEmail($user->getVar('uid'));
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
    }
    
    /**
	 * Callback function for the 'new_user_activation0' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */
    function new_user_activation0($args)
    {
        list($password, $newuser) = $args;
        
        global $xoopsConfig;
        $newid = $newuser->getVar('uid');
		$uname = $newuser->getVar('uname');
		$email = $newuser->getVar('email');
        
        $tags = array();
        $tags['XOOPS_USER_NAME']     = $newuser->getVar('uname');
        $tags['XOOPS_USER_EMAIL']    = $newuser->getVar('email');
        $tags['XOOPS_USER_ID']       = $newuser->getVar('uname');
        $tags['XOOPS_USER_PASSWORD'] = $password;
        $tags['X_UACTLINK']          = MLDOCS_SITE_URL ."/user.php?op=actv&id=".$newuser->getVar("uid")."&actkey=".$newuser->getVar('actkey');
        
        if($email_tpl = $this->_getEmailTpl('archive', 'new_user_byemail', $this->_module, $template_id)){
            $sendTo = $this->_getUserEmail($newuser->getVar('uid'));
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
    }
    
    /**
	 * Callback function for the 'new_user_activation1' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */
    function new_user_activation1($args)
    {
        list($password, $user) = $args;
        
        $tags = array();
        $tags['XOOPS_USER_NAME']     = $user->getVar('uname');
        $tags['XOOPS_USER_EMAIL']    = $user->getVar('email');
        $tags['XOOPS_USER_ID']       = $user->getVar('uname');
        $tags['XOOPS_USER_PASSWORD'] = $password;
        
        if($email_tpl = $this->_getEmailTpl('archive', 'new_user_activation1', $this->_module, $template_id)){
            $sendTo = _getUserEmail($user->getVar('uid'));
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
        
        $_POST['uname'] = $user->getVar('uname');
        $_POST['pass'] = $password;
        
        // For backward compatibility
        $HTTP_POST_VARS['uname'] = $user->getVar('uname');
        $HTTP_POST_VARS['pass'] = $password;
        
        
        $filename = XOOPS_ROOT_PATH.'/kernel/authenticationservice.php';
        $foldername = XOOPS_ROOT_PATH.'/include/authenticationservices';
        if(file_exists($filename) && file_exists($foldername)){     // check for ldap authentication hack
            if($authentication_service =& xoops_gethandler('authenticationservice')){
                $authentication_service->checkLogin();
            } else {
                include_once XOOPS_ROOT_PATH.'/include/checklogin.php';
            }
        } else {
            include_once XOOPS_ROOT_PATH.'/include/checklogin.php';
        }
    }
    
    /**
	 * Callback function for the 'new_user_activation2' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */
    function new_user_activation2($args)
    {
        list($password, $user) = $args;
        
        global $xoopsConfig;
        $newid = $user->getVar('uid');
		$uname = $user->getVar('uname');
		$email = $user->getVar('email');
        
        $tags = array();
        $tags['XOOPS_USER_NAME']     = $user->getVar('uname');
        $tags['XOOPS_USER_EMAIL']    = $user->getVar('email');
        $tags['XOOPS_USER_ID']       = $user->getVar('uname');
        $tags['XOOPS_USER_PASSWORD'] = $password;
        
        if($email_tpl = $this->_getEmailTpl('archive', 'new_user_activation2', $this->_module, $template_id)){
            $sendTo = _getUserEmail($user->getVar('uid'));
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
    }
    
    /**
	 * Callback function for the 'user_email_error' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */
    function user_email_error($args)
    {
        list($parsed) = $args;
        
        $email = $parsed->getEmail();
        
        $tags = array();
        $tags['XOOPS_USER_EMAIL']   = $email;
        $tags['ARCHIVE_SUBJECT']     = $parsed->getSubject();
        $tags['EMAIL_NAME']         = $parsed->getName();
        $tags['EMAIL_MSG']          = $parsed->getMsg();
        
        if($email_tpl = $this->_getEmailTpl('archive', 'user_email_error', $this->_module, $template_id)){
            $sendTo = $email;
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
    }
    
    /**
    * Callback function for the 'new_response' event
    * @param array $args Array of arguments passed to EventService
    * @access public
    * @todo create constants for the different notification settings.
    */
    function new_response($args)    // Notification #4
    {
        
        // If response is from staff member, send message to archive submitter
        // If response is from submitter, send message to owner, if no owner, send to department
        
        global $xoopsUser, $xoopsConfig, $xoopsModuleConfig;
        list($archiveInfo, $response) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        if(!is_object($archiveInfo) && $archiveInfo == 0){
            $hArchive =& mldocsGetHandler('archive');
            $archiveInfo =& $hArchive->get($response->getVar('archiveid'));
        }
        
        $b_email_archive = false;
        $from = '';
        
        $tags = array();
        $tags['ARCHIVE_ID'] = $archiveInfo->getVar('id');
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archiveInfo->getVar('id');
        $tags['ARCHIVE_RESPONSE'] = $this->_ts->stripslashesGPC($response->getVar('message', 'n'));
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archiveInfo->getVar('subject', 'n'));
        $tags['ARCHIVE_TIMESPENT'] = $response->getVar('timeSpent');
        $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archiveInfo->getVar('status'));
        $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
        $tags['ARCHIVE_RESPONDER'] = mldocsGetUsername($xoopsUser->getVar('uid'), $displayName);
        $tags['ARCHIVE_POSTED'] = $response->posted('m');
        $tags['ARCHIVE_SUPPORT_KEY'] = '';
        $tags['ARCHIVE_SUPPORT_EMAIL'] = $xoopsConfig['adminmail'];
        
        if ($archiveInfo->getVar('serverid') > 0) {
            $hServer =& mldocsGetHandler('departmentMailBox');
            
            if ($server =& $hServer->get($archiveInfo->getVar('serverid'))) {
                $from = $server->getVar('emailaddress');
                $tags['ARCHIVE_SUPPORT_KEY'] = '{'.$archiveInfo->getVar('emailHash').'}';
                $tags['ARCHIVE_SUPPORT_EMAIL'] = $from;
	        }
        }
        $owner = $archiveInfo->getVar('ownership');
        if($owner == 0){
            $tags['ARCHIVE_OWNERSHIP'] = _MLDOCS_NO_OWNER;
        } else {
            $tags['ARCHIVE_OWNERSHIP'] = mldocsGetUsername($owner, $displayName);
        }
        $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archiveInfo->getVar('department')));
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_NEWRESPONSE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');

        $sendTo = array();
        $hMember =& xoops_gethandler('member');
        $response_user =& $hMember->getUser($response->getVar('uid'));
        $response_email = $response_user->getVar('email');

        $aUsers =& $this->_getSubscribedUsers($archiveInfo->getVar('id'));
        
        if(in_array($response_email, $aUsers)){  // If response from a submitter, send to staff and other submitters
            if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){        // Staff notification is enabled
                if($email_tpl = $this->_getEmailTpl('dept', 'new_response', $this->_module, $template_id)){       // Send to staff members
                    $sendTo =& $this->_getSubscribedStaff($archiveInfo, $email_tpl['bit_value'], $settings, $response->getVar('uid'));
                    $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                }
            }
            unset($aUsers[$archiveInfo->getVar('uid')]); // Remove response submitter from array
            $sendTo = $aUsers;                    // Get array of user emails to send 
        } else {    // If response from staff, send to submitters
            // Also send to staff members if no owner
            if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){    // If notification is on
                if($email_tpl = $this->_getEmailTpl('dept', 'new_response', $this->_module, $template_id)){       // Send to staff members
                    if($archiveInfo->getVar('ownership') == 0){
                        $sendTo =& $this->_getSubscribedStaff($archiveInfo, $email_tpl['bit_value'], $settings, $response->getVar('uid'));
                    }
                    $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                }
            }
            $sendTo = $aUsers;
        }
        if($user_setting <> 2 && $response->getVar('private') == 0){
            if($email_tpl = $this->_getEmailTpl('archive', 'new_this_response', $this->_module, $template_id)){    // Send to users
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags, $from);
            }
        }
    }
        
     /**
	 * Callback function for the 'update_priority' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */   
    function update_priority($args)     // Notification #7
    {
        //notify staff department of change
        //notify submitter
        global $xoopsUser;
        list($archive, $oldpriority) = $args;
       
        $tags = array();
        $tags['ARCHIVE_ID'] = $archive->getVar('id');
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archive->getVar('id');
        // Added by marcan to get the archive's subject available in the mail template
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        // End of addition by marcan 
        $tags['ARCHIVE_OLD_PRIORITY'] = mldocsGetPriority($oldpriority);
        $tags['ARCHIVE_PRIORITY'] = mldocsGetPriority($archive->getVar('priority'));
        $tags['ARCHIVE_UPDATEDBY'] = $xoopsUser->getVar('uname');
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITPRIORITY);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($email_tpl = $this->_getEmailTpl('dept', 'changed_priority', $this->_module, $template_id)){   // Notify staff dept 
            $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings);
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
        if($email_tpl = $this->_getEmailTpl('archive', 'changed_this_priority', $this->_module, $template_id)){    // Notify submitter
            $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }            
    }

    /**
	 * Callback function for the 'update_status' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */        
    function update_status($args)
    {
        //notify staff department of change
        //notify submitter
        global $xoopsUser;
        list($archive, $oldstatus, $newstatus) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $tags = array();
        $tags['ARCHIVE_ID'] = $archive->getVar('id');
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archive->getVar('id');
        // Added by marcan to get the archive's subject available in the mail template
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        // End of addition by marcan 
        $tags['ARCHIVE_OLD_STATUS'] = $oldstatus->getVar('description');
        $tags['ARCHIVE_OLD_STATE'] = mldocsGetState($oldstatus->getVar('state'));
        $tags['ARCHIVE_STATUS'] = $newstatus->getVar('description');
        $tags['ARCHIVE_STATE'] = mldocsGetState($newstatus->getVar('state'));
        $tags['ARCHIVE_UPDATEDBY'] = $xoopsUser->getVar('uname');
        $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITSTATUS);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($email_tpl = $this->_getEmailTpl('dept', 'changed_status', $this->_module, $template_id)){        
            $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings);
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
        if($email_tpl = $this->_getEmailTpl('archive', 'changed_this_status', $this->_module, $template_id)){        
            //$sendTo = $this->_getEmail($archive->getVar('uid'));
            $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
            $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
        }
    }

    /**
	 * Callback function for the 'update_owner' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */            
    function update_owner($args)    // Notification #8
    {
        //notify old owner, if assigned
        //notify new owner
        //notify submitter
        global $xoopsUser, $xoopsModuleConfig;
        list($archive, $oldOwner) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
        
        $tags = array();
        $tags['ARCHIVE_ID'] = $archive->getVar('id');
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archive->getVar('id');
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        $tags['ARCHIVE_DESCRIPTION'] = $this->_ts->stripslashesGPC($archive->getVar('description', 'n'));
        $tags['ARCHIVE_OWNER'] = mldocsGetUsername($archive->getVar('ownership'), $displayName);
        $tags['SUBMITTED_OWNER'] = $xoopsUser->getVar('uname');
        $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archive->getVar('status'));
        $tags['ARCHIVE_PRIORITY'] = mldocsGetPriority($archive->getVar('priority'));
        $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITOWNER);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        $staff_options = $settings->getVar('staff_options');
        
        $sendTo = array();
        if($staff_setting == MLDOCS_NOTIF_STAFF_OWNER){
            if(isset($oldOwner) && $oldOwner <> _MLDOCS_NO_OWNER){                               // If there was an owner
                if($email_tpl = $this->_getEmailTpl('dept', 'new_owner', $this->_module, $template_id)){      // Send them an email 
                    if($this->_isSubscribed($oldOwner, $email_tpl['bit_value'])){    // Check if the owner is subscribed
                        $sendTo = $this->_getStaffEmail($oldOwner, $archive->getVar('department'), $staff_options);
                        $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                    }
                }        
            }
            if($archive->getVar('ownership') <> $xoopsUser->getVar('uid') && $archive->getVar('ownership') <> 0){ // If owner is not current user
                if($email_tpl = $this->_getEmailTpl('dept', 'new_owner', $this->_module, $template_id)){      // Send new owner email
                    if($this->_isSubscribed($archive->getVar('ownership'), $email_tpl['bit_value'])){    // Check if the owner is subscribed
                        $sendTo = $this->_getStaffEmail($archive->getVar('ownership'), $archive->getVar('department'), $staff_options);
                        $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                    }
                }
            }
        } elseif ($staff_setting == MLDOCS_NOTIF_STAFF_DEPT){ // Notify entire department
            if($email_tpl = $this->_getEmailTpl('dept', 'new_owner', $this->_module, $template_id)){        
                $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
        
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            if($email_tpl = $this->_getEmailTpl('archive', 'new_this_owner', $this->_module, $template_id)){   // Send to archive submitter
                $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }    
        }
    }
    
    /**
	 * Callback function for the 'close_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */
    function close_archive($args)
    {
        global $xoopsUser;
        list($archive) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $tags = array();
        $tags['ARCHIVE_ID'] = $archive->getVar('id');
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        $tags['ARCHIVE_DESCRIPTION'] = $this->_ts->stripslashesGPC($archive->getVar('description', 'n'));
        $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archive->getVar('status'));
        $tags['ARCHIVE_CLOSEDBY'] = $xoopsUser->getVar('uname');
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL .'/archive.php?id='.$archive->getVar('id');
        $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_CLOSEARCHIVE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        $sendTo = array();
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            if($email_tpl = $this->_getEmailTpl('dept', 'close_archive', $this->_module, $template_id)){        // Send to department, not to staff member
                $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
        
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            if($xoopsUser->getVar('uid') <> $archive->getVar('uid')){        // If not closed by submitter
                if($email_tpl = $this->_getEmailTpl('archive', 'close_this_archive', $this->_module, $template_id)){        // Send to submitter
                    //$sendTo = $this->_getEmail($archive->getVar('uid'));
                    $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                    $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                }
            }
        }
    }    

    /**
	 * Callback function for the 'delete_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */            
    function delete_archive($args)
    {
        //notify staff department
        //notify submitter
        global $xoopsUser, $xoopsModule;
        list($archive) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $tags = array();
        $tags['ARCHIVE_ID'] = $archive->getVar('id');
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        $tags['ARCHIVE_DESCRIPTION'] = $this->_ts->stripslashesGPC($archive->getVar('description', 'n'));
        $tags['ARCHIVE_PRIORITY'] = mldocsGetPriority($archive->getVar('priority'));
        $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archive->getVar('status'));
        $tags['ARCHIVE_POSTED'] = $archive->posted();
        $tags['ARCHIVE_DELETEDBY'] = $xoopsUser->getVar('uname');
        $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_DELARCHIVE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            if($email_tpl = $this->_getEmailTpl('dept', 'removed_archive', $this->_module, $template_id)){ // Send to dept staff  
                $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
        
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            $status =& $this->_hStatus->get($archive->getVar('status'));
            if($status->getVar('state') <> 2){
                if($email_tpl = $this->_getEmailTpl('archive', 'removed_this_archive', $this->_module, $template_id)){  // Send to submitter
                    //$sendTo = $this->_getEmail($archive->getVar('uid'));
                    $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                    $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                }
            }
        }
    }
    
    /**
	 * Callback function for the 'edit_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */           
    function edit_archive($args)
    {
        //notify staff department of change
        //notify submitter
        global $xoopsUser;
        $hDept  =& mldocsGetHandler('department');
        list($oldArchive, $archiveInfo) = $args;
        
        $tags = array();
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archiveInfo->getVar('id');
        $tags['ARCHIVE_OLD_SUBJECT'] = $this->_ts->stripslashesGPC($oldArchive['subject']);
        $tags['ARCHIVE_OLD_DESCRIPTION'] = $this->_ts->stripslashesGPC($oldArchive['description']);
        $tags['ARCHIVE_OLD_PRIORITY'] = mldocsGetPriority($oldArchive['priority']);
        $tags['ARCHIVE_OLD_STATUS'] = $oldArchive['status'];
        $tags['ARCHIVE_OLD_DEPARTMENT'] = $oldArchive['department'];
        $tags['ARCHIVE_OLD_DEPTID'] = $oldArchive['department_id'];
        
        $tags['ARCHIVE_ID'] = $archiveInfo->getVar('id');
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archiveInfo->getVar('subject', 'n'));
        $tags['ARCHIVE_DESCRIPTION'] = $this->_ts->stripslashesGPC($archiveInfo->getVar('description', 'n'));
        $tags['ARCHIVE_PRIORITY'] = mldocsGetPriority($archiveInfo->getVar('priority'));
        $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archiveInfo->getVar('status'));
        $tags['ARCHIVE_MODIFIED'] = $xoopsUser->getVar('uname');
        if($tags['ARCHIVE_OLD_DEPTID'] <> $archiveInfo->getVar('department')){
            $department =& $hDept->get($archiveInfo->getVar('department'));
            $tags['ARCHIVE_DEPARTMENT'] =& $department->getVar('department');
        } else {
            $tags['ARCHIVE_DEPARTMENT'] = $tags['ARCHIVE_OLD_DEPARTMENT'];
        }
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITARCHIVE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            if($email_tpl = $this->_getEmailTpl('dept', 'modified_archive', $this->_module, $template_id)){            // Send to dept staff
                $sendTo =& $this->_getSubscribedStaff($archiveInfo, $email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            if($email_tpl = $this->_getEmailTpl('archive', 'modified_this_archive', $this->_module, $template_id)){     // Send to archive submitter
                $sendTo = $this->_getSubscribedUsers($archiveInfo->getVar('id'));
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
    }
    
    /**
	 * Callback function for the 'edit_response' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */             
    function edit_response($args)
    {
        //if not modified by response submitter, notify response submitter
        //notify archive submitter
        global $xoopsUser, $xoopsModuleConfig;
        
        list($archive, $response, $oldarchive, $oldresponse) = $args;
        $hDepartments =& mldocsGetHandler('department');
        $displayName =& $xoopsModuleCofnig['mldocs_displayName'];    // Determines if username or real name is displayed
        
        $tags = array();
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archive->getVar('id');
        $tags['ARCHIVE_OLD_RESPONSE']  = $this->_ts->stripslashesGPC($oldresponse->getVar('message', 'n'));
        $tags['ARCHIVE_OLD_TIMESPENT'] = $oldresponse->getVar('timeSpent');
        $tags['ARCHIVE_OLD_STATUS']    = mldocsGetStatus($oldarchive->getVar('status'));
        $tags['ARCHIVE_OLD_RESPONDER'] = mldocsGetUsername($oldresponse->getVar('uid'), $displayName);
        $owner = $oldarchive->getVar('ownership');
        $tags['ARCHIVE_OLD_OWNERSHIP'] = ($owner = 0 ? _MLDOCS_NO_OWNER : mldocsGetUsername($owner, $displayName));
        $tags['ARCHIVE_ID'] = $archive->getVar('id');
        $tags['RESPONSE_ID'] = $response->getVar('id');
        $tags['ARCHIVE_RESPONSE'] = $this->_ts->stripslashesGPC($response->getVar('message', 'n'));
        $tags['ARCHIVE_TIMESPENT'] = $response->getVar('timeSpent');
        $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archive->getVar('status'));
        $tags['ARCHIVE_RESPONDER'] = $xoopsUser->getVar('uname');
        $tags['ARCHIVE_POSTED'] = $response->posted();
        $owner = $archive->getVar('ownership');    
        $tags['ARCHIVE_OWNERSHIP'] = ($owner = 0 ? _MLDOCS_NO_OWNER : mldocsGetUsername($owner, $displayName));
        $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
        
        // Added by marcan to get the archive's subject available in the mail template
        $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        // End of addition by marcan         
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITRESPONSE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            if($email_tpl = $this->_getEmailTpl('dept', 'modified_response', $this->_module, $template_id)){  // Notify dept staff
                $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings, $response->getVar('uid'));
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
                
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            if($response->getVar('private') == 0){  // Make sure if response is private, don't sent to user
                if($email_tpl = $this->_getEmailTpl('archive', 'modified_this_response', $this->_module, $template_id)){   // Notify archive submitter
                    $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                    $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
                }
            }
        }
    }

    /**
	 * Callback function for the 'batch_dept' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return TRUE if success, FALSE if failure
	 * @access	public
	 */
    function batch_dept($args)
    {
        global $xoopsUser;
        
        list($oldArchives, $dept) = $args;
        $hDept =& mldocsGetHandler('department');
        $sDept =& $hDept->getNameById($dept);
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITARCHIVE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            if($dept_email_tpl = $this->_getEmailTpl('dept', 'modified_archive', $this->_module, $template_id)){            // Send to dept staff
                $deptEmails =& $this->_getSubscribedStaff($dept, $dept_email_tpl['bit_value'], $settings, $xoopsUser->getVar('uid'));
            }
        } else {
            $dept_email_tpl = false;
        }
        
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            $user_email_tpl = $this->_getEmailTpl('archive', 'modified_this_archive', $this->_module, $template_id);
        } else {
            $user_email_tpl = false;
        }
        
        foreach($oldArchives as $oldArchive) {
                       
            
            $tags = array();
            $tags['ARCHIVE_OLD_SUBJECT'] = $this->_ts->stripslashesGPC($oldArchive->getVar('subject', 'n'));
            $tags['ARCHIVE_OLD_DESCRIPTION'] = $this->_ts->stripslashesGPC($oldArchive->getVar('description', 'n'));
            $tags['ARCHIVE_OLD_PRIORITY'] = mldocsGetPriority($oldArchive->getVar('priority'));
            $tags['ARCHIVE_OLD_STATUS'] = mldocsGetStatus($oldArchive->getVar('status'));
            $tags['ARCHIVE_OLD_DEPARTMENT'] = $hDept->getNameById($oldArchive->getVar('department'));
            $tags['ARCHIVE_OLD_DEPTID'] = $oldArchive->getVar('department');
            
            $tags['ARCHIVE_ID'] = $oldArchive->getVar('id');
            $tags['ARCHIVE_SUBJECT'] = $tags['ARCHIVE_OLD_SUBJECT'];
            $tags['ARCHIVE_DESCRIPTION'] = $tags['ARCHIVE_OLD_DESCRIPTION'];
            $tags['ARCHIVE_PRIORITY'] = $tags['ARCHIVE_OLD_PRIORITY'];
            $tags['ARCHIVE_STATUS'] = $tags['ARCHIVE_OLD_STATUS'];
            $tags['ARCHIVE_MODIFIED'] = $xoopsUser->getVar('uname');
            $tags['ARCHIVE_DEPARTMENT'] = $sDept;
            $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$oldArchive->getVar('id');

            if ($dept_email_tpl) {
                $deptEmails =& $this->_getSubscribedStaff($oldArchive, $dept_email_tpl['bit_value'], $settings, $xoopsUser->getVar('uid'));
                $success = $this->_sendEvents($dept_email_tpl, $deptEmails, $tags);
            }
            if ($user_email_tpl) {
                //$sendTo = $this->_getEmail($oldArchive->getVar('uid'));
                $sendTo = $this->_getSubscribedUsers($oldArchive->getVar('id'));
                $success = $this->_sendEvents($user_email_tpl, $sendTo, $tags);
            }

        }
        return true;
    }
    
    /**
	 * Callback function for the 'batch_priority' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return TRUE if success, FALSE if failure
	 * @access	public
	 */
    function batch_priority($args)
    {
        global $xoopsUser;
        
        list($archives, $priority) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITPRIORITY);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            $dept_email_tpl =& $this->_getEmailTpl('dept', 'changed_priority', $this->_module, $template_id);
        } else {
            $dept_email_tpl = false;
        }
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            $user_email_tpl =& $this->_getEmailTpl('archive', 'changed_this_priority', $this->_module, $template_id);
        } else {
            $user_email_tpl = false;
        }
        $uname          = $xoopsUser->getVar('uname');
        $uid            = $xoopsUser->getVar('uid');
        $priority       = mldocsGetPriority($priority);
        
        foreach($archives as $archive) {
            $tags = array();
            $tags['ARCHIVE_ID'] = $archive->getVar('id');
            $tags['ARCHIVE_OLD_PRIORITY'] = mldocsGetPriority($archive->getVar('priority'));
            $tags['ARCHIVE_PRIORITY'] = $priority;
            $tags['ARCHIVE_UPDATEDBY'] = $uname;
            $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL .'/archive.php?id='.$archive->getVar('id'); 
        	// Added by marcan to get the archive's subject available in the mail template
        	$tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        	// End of addition by marcan             
        	$tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
        
            if ($dept_email_tpl) {
                $sendTo =& $this->_getSubscribedStaff($archive, $dept_email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($dept_email_tpl, $sendTo, $tags);
            }
            
            if ($user_email_tpl) {
                //$sendTo = $this->_getEmail($archive->getVar('uid'));
                $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                $success = $this->_sendEvents($user_email_tpl, $sendTo, $tags);
            }
            unset($tags);
        }
         
    }
    
    /**
	 * Callback function for the 'batch_owner' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return TRUE if success, FALSE if failure
	 * @access	public
	 */
    function batch_owner($args)
    {
        //notify old owner, if assigned
        //notify new owner
        //notify submitter
        global $xoopsUser, $xoopsModuleConfig;
        list($archives, $owner) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITOWNER);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        $staff_options = $settings->getVar('staff_options');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            $dept_email_tpl = $this->_getEmailTpl('dept', 'new_owner', $this->_module, $template_id);
        } else {
            $dept_email_tpl = false;
        }
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            $user_email_tpl = $this->_getEmailTpl('archive', 'new_this_owner', $this->_module, $template_id);
        } else {
            $user_email_tpl = false;
        }
        $new_owner      = mldocsGetUsername($owner, $displayName);
        $submitted_by   = $xoopsUser->getVar('uname');
        $uid            = $xoopsUser->getVar('uid');
        
        foreach($archives as $archive) {        
            $tags = array();
            $tags['ARCHIVE_ID'] = $archive->getVar('id');
            $tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
            $tags['ARCHIVE_DESCRIPTION'] = $this->_ts->stripslashesGPC($archive->getVar('description', 'n'));
            $tags['ARCHIVE_OWNER'] = $new_owner;
            $tags['SUBMITTED_OWNER'] = $submitted_by;
            $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archive->getVar('status'));
            $tags['ARCHIVE_PRIORITY'] = mldocsGetPriority($archive->getVar('priority'));
            $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archive->getVar('id');
            $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
            
            $sendTo = array();
            if($archive->getVar('ownership') <> 0){                               // If there was an owner
                if($dept_email_tpl){      // Send them an email 
                    if($this->_isSubscribed($archive->getVar('ownership'), $dept_email_tpl['bit_value'])){    // Check if the owner is subscribed 
                        $sendTo = $this->_getStaffEmail($archive->getVar('ownership'), $archive->getVar('department'), $staff_options);
                        $success  = $this->_sendEvents($dept_email_tpl, $sendTo, $tags);
                    }
                }
            }
            if ($owner <> $uid) {
                if ($dept_email_tpl) { // Send new owner email
                    if($this->_isSubscribed($owner, $dept_email_tpl['bit_value'])){    // Check if the owner is subscribed
                        $sendTo = $this->_getStaffEmail($owner, $archive->getVar('department'), $staff_options);
                        $success  = $this->_sendEvents($dept_email_tpl, $sendTo, $tags);
                    }
                }
            }
            if ($user_email_tpl) {
                //$sendTo = $this->_getEmail($archive->getVar('uid'));
                $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                $success  = $this->_sendEvents($user_email_tpl, $sendTo, $tags);
            }
        }
        return true;
    }

    /**
	 * Callback function for the 'batch_status' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return TRUE if success, FALSE if failure
	 * @access	public
	 */
    function batch_status($args)
    {
        //notify staff department of change
        //notify submitter
        global $xoopsUser;
        list($archives, $newstatus) = $args;
        $hDepartments =& mldocsGetHandler('department');
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_EDITSTATUS);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            $dept_email_tpl =& $this->_getEmailTpl('dept', 'changed_status', $this->_module, $template_id);
        } else {
            $dept_email_tpl = false;
        }
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            $user_email_tpl =& $this->_getEmailTpl('archive', 'changed_this_status', $this->_module, $template_id);
        } else {
            $user_email_tpl = false;
        }
        $sStatus        = mldocsGetStatus($newstatus);
        $uname          = $xoopsUser->getVar('uname');
        $uid            = $xoopsUser->getVar('uid');
        
        foreach($archives as $archive) {
            $tags = array();
            $tags['ARCHIVE_ID'] = $archive->getVar('id');
            $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archive->getVar('id');
            
        	// Added by marcan to get the archive's subject available in the mail template
        	$tags['ARCHIVE_SUBJECT'] = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
        	// End of addition by marcan 
                    
            $tags['ARCHIVE_OLD_STATUS'] = mldocsGetStatus($archive->getVar('status'));
            $tags['ARCHIVE_STATUS'] = $sStatus;
            $tags['ARCHIVE_UPDATEDBY'] = $uname;
            $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
            
            if ($dept_email_tpl) {
                $sendTo =& $this->_getSubscribedStaff($archive, $dept_email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($dept_email_tpl, $sendTo, $tags);
            }
            if ($user_email_tpl) {
                $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                $success = $this->_sendEvents($user_email_tpl, $sendTo, $tags);
            }
        }
        return true;
    }
    
    /**
	 * Callback function for the 'batch_delete_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return TRUE if success, FALSE if failure
	 * @access	public
	 */
    function batch_delete_archive($args)
    {
        //notify staff department
        //notify submitter (if archive is not closed)
        global $xoopsUser, $xoopsModule;
        list($archives) = $args;
        
        $uname   = $xoopsUser->getVar('uname');
        $uid     = $xoopsUser->getVar('uid');
        $hStaff  =& mldocsGetHandler('staff'); 
        $isStaff = $hStaff->isStaff($uid);
        $hDepartments =& mldocsGetHandler('department');
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_DELARCHIVE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            $dept_email_tpl = $this->_getEmailTpl('dept', 'removed_archive', $this->_module, $template_id);
        } else {
            $dept_email_tpl = false;
        }
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            $user_email_tpl = $this->_getEmailTpl('archive', 'removed_this_archive', $this->_module, $template_id);
        } else {
            $user_email_tpl = false;
        }
        
        foreach($archives as $archive) {
            $tags = array();
            $tags['ARCHIVE_ID']          = $archive->getVar('id');
            $tags['ARCHIVE_SUBJECT']     = $this->_ts->stripslashesGPC($archive->getVar('subject', 'n'));
            $tags['ARCHIVE_DESCRIPTION'] = $this->_ts->stripslashesGPC($archive->getVar('description', 'n'));
            $tags['ARCHIVE_PRIORITY']    = mldocsGetPriority($archive->getVar('priority'));
            $tags['ARCHIVE_STATUS']      = mldocsGetStatus($archive->getVar('status'));
            $tags['ARCHIVE_POSTED']      = $archive->posted();
            $tags['ARCHIVE_DELETEDBY']   = $uname;
            $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
            
            if ($dept_email_tpl) {
                $sendTo =& $this->_getSubscribedStaff($archive, $dept_email_tpl['bit_value'], $settings);
                $success  = $this->_sendEvents($dept_email_tpl, $sendTo, $tags);
            }
        
            if($user_email_tpl){
                $status =& $this->_hStatus->get($archive->getVar('status'));
                if((!$isStaff && $status->getVar('state') <> 2) || ($isStaff)) {           // Send to archive submitter
                    //$sendTo = $this->_getEmail($archive->getVar('uid'));
                    $sendTo = $this->_getSubscribedUsers($archive->getVar('id'));
                    $success  = $this->_sendEvents($user_email_tpl, $sendTo, $tags);
                }
            }
        }
        return true;
    }
    
    /**
	 * Callback function for the 'batch_response' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return TRUE if success, FALSE if failure
	 * @access	public
	 */
    function batch_response($args)
    {
        global $xoopsUser, $xoopsConfig, $xoopsModuleConfig;
        list($archives, $response, $timespent, $private) = $args; 
        
        $displayName =& $xoopsModuleConfig['mldocs_displayName'];    // Determines if username or real name is displayed
        
        $response = $this->_ts->stripslashesGPC($response);
        $uname    = $xoopsUser->getVar('uname');
        $uid      = $xoopsUser->getVar('uid');
        $updated  = formatTimestamp(time(), 'm');
        $hMBoxes =& mldocsGetHandler('departmentMailBox');
        $mBoxes =& $hMBoxes->getObjects(null, true);
        $hDepartments =& mldocsGetHandler('department');
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_NEWRESPONSE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        $staff_options = $settings->getVar('staff_options');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            $dept_email_tpl = $this->_getEmailTpl('dept', 'new_response', $this->_module, $template_id);
        } else {
            $dept_email_tpl = false;
        }
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            $user_email_tpl = $this->_getEmailTpl('archive', 'new_this_response', $this->_module, $template_id);
        } else {
            $user_email_tpl = false;
        }
        
        foreach($archives as $archive) {
            $bFromEmail = false;
            $tags = array();
            $tags['ARCHIVE_ID'] = $archive->getVar('id');
            $tags['ARCHIVE_RESPONSE'] = $response;
            $tags['ARCHIVE_SUBJECT'] = $archive->getVar('subject');
            $tags['ARCHIVE_TIMESPENT'] = $timespent;
            $tags['ARCHIVE_STATUS'] = mldocsGetStatus($archive->getVar('status'));
            $tags['ARCHIVE_RESPONDER'] = $uname;
            $tags['ARCHIVE_POSTED'] = $updated;
            $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$archive->getVar('id');
            $tags['ARCHIVE_DEPARTMENT'] = $this->_ts->stripslashesGPC($hDepartments->getNameById($archive->getVar('department')));
            
            $owner = $archive->getVar('ownership');
            if($owner == 0){
                $tags['ARCHIVE_OWNERSHIP'] = _MLDOCS_NO_OWNER;
            } else {
                $tags['ARCHIVE_OWNERSHIP'] = mldocsGetUsername($owner, $displayName);
            }
            
            if ($archive->getVar('serverid') > 0) {
                //Archive was submitted via email
                $mBox =& $mBoxes[$archive->getVar('serverid')];
                if (is_object($mBox)) {
                    $bFromEmail = true;
                }
            }
            
            if ($bFromEmail) {
                $from = $server->getVar('emailaddress');
                $tags['ARCHIVE_SUPPORT_EMAIL'] = $from;
                $tags['ARCHIVE_SUPPORT_KEY'] = '{'.$archive->getVar('emailHash').'}';
            } else {
                $from = '';
                $tags['ARCHIVE_SUPPORT_EMAIL'] = $xoopsConfig['adminmail'];
                $tags['ARCHIVE_SUPPORT_KEY'] = '';
            }

                
            $sendTo = array();
            if($archive->getVar('uid') <> $uid && $private == 0){ // If response from staff member
                if ($private == 0) {
                    if($user_email_tpl){
                        $sendTo = $this->_getUserEmail($archive->getVar('uid'));
                        $success  = $this->_sendEvents($user_email_tpl, $sendTo, $tags, $from);
                    }
                } else {
                    if ($dept_email_tpl) {
                        if ($archive->getVar('ownership') <> 0) {
                            $sendTo = $this->_getStaffEmail($owner, $archive->getVar('department'), $staff_options);
                        } else {
                            $sendTo = $this->_getSubscribedStaff($archive, $dept_email_tpl['bit_value'], $settings);
                        }
                    }
                }
            } else {        // If response from submitter
                if($dept_email_tpl) {
                    if($archive->getVar('ownership') <> 0){  // If archive has owner, send to owner
                        if($this->_isSubscribed($owner, $email_tpl['bit_value'])){    // Check if the owner is subscribed
                            $sendTo = $this->_getStaffEmail($owner, $archive->getVar('department'), $staff_options);
                        }
                    } else {                                    // If archive has no owner, send to department
                        $sendTo =& $this->_getSubscribedStaff($archive, $dept_email_tpl['bit_value'], $settings);
                    }
                    $success = $this->_sendEvents($dept_email_tpl, $sendTo, $tags);
                }
            }
        }           
    }
    
    /**
	 * Callback function for the 'merge_archives' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @access	public
	 */ 
    function merge_archives($args)   // Notification #10
    {
        global $xoopsUser;
        list($archive1, $archive2, $newArchive) = $args;
        $hArchive =& mldocsGetHandler('archive');
        $archive =& $hArchive->get($newArchive);
        
        $tags = array();
        $tags['ARCHIVE_MERGER'] = $xoopsUser->getVar('uname');
        $tags['ARCHIVE1'] = $archive1;
        $tags['ARCHIVE2'] = $archive2;
        $tags['ARCHIVE_URL'] = MLDOCS_BASE_URL . '/archive.php?id='.$newArchive;
        
        $settings =& $this->_hNotification->get(MLDOCS_NOTIF_MERGEARCHIVE);
        $staff_setting = $settings->getVar('staff_setting');
        $user_setting = $settings->getVar('user_setting');
        
        if($staff_setting <> MLDOCS_NOTIF_STAFF_NONE){
            if($email_tpl = $this->_getEmailTpl('dept', 'merge_archive', $this->_module, $template_id)){   // Send email to dept members
                $sendTo =& $this->_getSubscribedStaff($archive, $email_tpl['bit_value'], $settings);
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
        
        if($user_setting <> MLDOCS_NOTIF_USER_NO){
            if($email_tpl = $this->_getEmailTpl('archive', 'merge_this_archive', $this->_module, $template_id)) {    // Send confirm email to submitter
                //$sendTo = $this->_getEmail($archive->getVar('uid'));
                $sendTo =& $this->_getSubscribedUsers($newArchive);
                $success = $this->_sendEvents($email_tpl, $sendTo, $tags);
            }
        }
    }
            
     /**
	 * Only have 1 instance of class used
	 * @return object {@link mldocs_notificationService}
	 * @access	public
	 */
    
    function &singleton()
    {
        // Declare a static variable to hold the object instance
        static $instance; 

        // If the instance is not there, create one
        if(!isset($instance)) { 
            $instance =& new mldocs_notificationService(); 
        }
        return($instance); 
    }  
}
?>