<?php
//$Id: modinfo.php,v 1.68 2005/11/01 16:58:36 eric_juden Exp $
define('_MI_MLDOCS_NAME', 'mldocs');
define('_MI_MLDOCS_DESC', 'Used to store client requests for help with their problems');

//Trad memseb@2007
//begin
if (!defined('MLDOCS_CONSTANTS_ARCHIVE')) {
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
define('_MI_MLDOCS_PATH_UPLOADS_DFLT',   MLDOCS_BASE_PATH . '/default/uploads' );
define('_MI_MLDOCS_PATH_BANNETTE_DFLT',  MLDOCS_BASE_PATH . '/default/bannette');
define('_MI_MLDOCS_PATH_ARCHIVE_DFLT',    MLDOCS_BASE_PATH . '/default/archives' );
define('_MI_MLDOCS_URL_BANNETTE_DFLT',   MLDOCS_BASE_URL  . '/default/bannette');
define('_MI_MLDOCS_PATH_CGI_BIN_DFLT',   MLDOCS_BASE_PATH . '/cgi-bin');
define('MLDOCS_CONSTANTS_ARCHIVE', 1);
}
//end Trad memseb@2007

//Template variables
define('_MI_MLDOCS_TEMP_ADDARCHIVE', 'Template for addArchive.php');
define('_MI_MLDOCS_TEMP_SEARCH', 'Template for search.php');
define('_MI_MLDOCS_TEMP_STAFF_INDEX', 'Staff template for index.php');
define('_MI_MLDOCS_TEMP_STAFF_PROFILE', 'Template for profile.php');
define('_MI_MLDOCS_TEMP_STAFF_ARCHIVEDETAILS', 'Staff template for archive.php');
define('_MI_MLDOCS_TEMP_USER_INDEX', 'User template for index.php');
define('_MI_MLDOCS_TEMP_USER_ARCHIVEDETAILS', 'User template for archive.php');
define('_MI_MLDOCS_TEMP_STAFF_RESPONSE', 'Template for response.php');
define('_MI_MLDOCS_TEMP_LOOKUP', 'Template for lookup.php');
define('_MI_MLDOCS_TEMP_STAFFREVIEW', 'Template for reviewing a staff member');
define('_MI_MLDOCS_TEMP_EDITARCHIVE', 'Template for editing a archive');
define('_MI_MLDOCS_TEMP_EDITRESPONSE', 'Template for editing a response');
define('_MI_MLDOCS_TEMP_ANNOUNCEMENT', 'Template for announcements');
define('_MI_MLDOCS_TEMP_STAFF_HEADER', 'Template for staff menu options');
define('_MI_MLDOCS_TEMP_USER_HEADER', 'Template for user menu options');
define('_MI_MLDOCS_TEMP_PRINT', 'Template for printer-friendly archive page');
define('_MI_MLDOCS_TEMP_STAFF_ALL', 'Template for Staff View All Page');
define('_MI_MLDOCS_TEMP_STAFF_ARCHIVE_TABLE', 'Template to display staff archives');
define('_MI_MLDOCS_TEMP_SETDEPT', 'Template for Set Department Page');
define('_MI_MLDOCS_TEMP_SETPRIORITY', 'Template for Set Priority Page');
define('_MI_MLDOCS_TEMP_SETOWNER', 'Template for Set Owner Page');
define('_MI_MLDOCS_TEMP_SETSTATUS', 'Template for Set Status Page');
define('_MI_MLDOCS_TEMP_DELETE', 'Template for Batch Archive Delete Page');
define('_MI_MLDOCS_TEMP_BATCHRESPONSE', 'Template for Batch Add Response Page');
define('_MI_MLDOCS_TEMP_ANON_ADDARCHIVE', 'Template for anonymous user add archive page');
define('_MI_MLDOCS_TEMP_ERROR', 'Template for error page');
define('_MI_MLDOCS_TEMP_EDITSEARCH', 'Template for editing a saved search.');
define('_MI_MLDOCS_TEMP_USER_ALL', 'Template for user view all page');


// Block variables
define('_MI_MLDOCS_BNAME1', 'My Open Archives');
define('_MI_MLDOCS_BNAME1_DESC', 'Displays a list of the user\'s open archives');
define('_MI_MLDOCS_BNAME2', 'Department Archives');
define('_MI_MLDOCS_BNAME2_DESC', 'Displays the number of open archives for each department.');
define('_MI_MLDOCS_BNAME3', 'Recently Viewed Archives');
define('_MI_MLDOCS_BNAME3_DESC', 'Displays the archives a staff member has recently viewed.');
define('_MI_MLDOCS_BNAME4', 'Archive Actions');
define('_MI_MLDOCS_BNAME4_DESC', 'Displays all actions a staff member can do to a archive');
define('_MI_MLDOCS_BNAME5', 'Archive Main Actions');
define('_MI_MLDOCS_BNAME5_DESC', 'Displays main actions for archiveing system');

// Config variables
define('_MI_MLDOCS_TITLE', 'Helpdesk Title');
define('_MI_MLDOCS_TITLE_DSC', 'Give your helpdesk a name:');
define('_MI_MLDOCS_UPLOAD', 'Upload Directory');
define('_MI_MLDOCS_UPLOAD_DSC', 'Path where user stores files that are added to a archive');
define('_MI_MLDOCS_ALLOW_UPLOAD', 'Allow Uploads');
define('_MI_MLDOCS_ALLOW_UPLOAD_DSC', 'Allow users to add a file to their archive requests?');
define('_MI_MLDOCS_UPLOAD_SIZE', 'Upload Size');
define('_MI_MLDOCS_UPLOAD_SIZE_DSC', 'Max size of upload (in bytes)');
define('_MI_MLDOCS_UPLOAD_WIDTH', 'Upload Width');
define('_MI_MLDOCS_UPLOAD_WIDTH_DSC', 'Max width of upload (in pixels)');
define('_MI_MLDOCS_UPLOAD_HEIGHT', 'Upload Height');
define('_MI_MLDOCS_UPLOAD_HEIGHT_DSC', 'Max height of upload (in pixels)');
define('_MI_MLDOCS_NUM_ARCHIVE_UPLOADS', 'Max Number of Files to Upload');
define('_MI_MLDOCS_NUM_ARCHIVE_UPLOADS_DSC', 'This is the maximum number of files that can be uploaded to a archive on archive submission (does not include file custom fields).');
define('_MI_MLDOCS_ANNOUNCEMENTS', 'Announcements News Topic');
//define('_MI_MLDOCS_ANNOUNCEMENTS_DSC', 'This is the news topic that pulls announcements for mldocs. Update the xHelp module to see newly added news categories');
define('_MI_MLDOCS_ANNOUNCEMENTS_DSC', "This is the news topic that pulls announcements for mldocs. <a href='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/mldocs/install.php?op=updateTopics\", \"xoops_module_install_mldocs\",400, 300);'>Click here</a> to update the news categories.");
define('_MI_MLDOCS_ANNOUNCEMENTS_NONE', '***Disable announcements***');
define('_MI_MLDOCS_ALLOW_REOPEN', 'Allow Archive Re-open');
define('_MI_MLDOCS_ALLOW_REOPEN_DSC', 'Allow users to re-open a archive after it has been closed?');
define('_MI_MLDOCS_STAFF_TC', 'Staff Index Archive Count');
define('_MI_MLDOCS_STAFF_TC_DSC', 'How many archives should be displayed for each section on the staff index page?');
define('_MI_MLDOCS_STAFF_ACTIONS', 'Staff Actions');
define('_MI_MLDOCS_STAFF_ACTIONS_DSC', 'What style would you like the staff actions to show up as? Inline is the default, Block-Style requires you to enable the Staff Actions block.');
define('_MI_MLDOCS_ACTION1', 'Inline-Style');
define('_MI_MLDOCS_ACTION2', 'Block-Style');
define('_MI_MLDOCS_DEFAULT_DEPT', 'Default Department');
define('_MI_MLDOCS_DEFAULT_DEPT_DSC', "This will be the default department that is selected in the list when adding a archive. <a href='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/mldocs/install.php?op=updateDepts\", \"xoops_module_install_mldocs\",400, 300);'>Click here</a> to update the departments.");
define('_MI_MLDOCS_OVERDUE_TIME', 'Archive Overdue Time');
define('_MI_MLDOCS_OVERDUE_TIME_DSC', 'This determines how long the staff have to finish a archive before it is late (in hours).');
define('_MI_MLDOCS_ALLOW_ANON', 'Allow Anonymous User Archive Submission');
define('_MI_MLDOCS_ALLOW_ANON_DSC', 'This allows anyone to create a archive on your site. When an anonymous user submits a archive, they are also prompted to create an account.');
define('_MI_MLDOCS_APPLY_VISIBILITY', 'Apply department visibility to staff members?');
define('_MI_MLDOCS_APPLY_VISIBILITY_DSC', 'This determines if staff are limited to what departments they can submit archives to. If "yes" is selected, staff members will be limited to submitting archives to departments where the XOOPS group they belong to is selected.');
define('_MI_MLDOCS_DISPLAY_NAME', 'Display username or real name?');
define('_MI_MLDOCS_DISPLAY_NAME_DSC', 'This allows for the real name to be shown in all places where the username would normally be (username will display if there is no real name).');
define('_MI_MLDOCS_USERNAME', 'Username');
define('_MI_MLDOCS_REALNAME', 'Real Name');

// Admin Menu variables
define('_MI_MLDOCS_MENU_BLOCKS', 'Manage Blocks');
define('_MI_MLDOCS_MENU_MANAGE_DEPARTMENTS', 'Manage Departments');
define('_MI_MLDOCS_MENU_MANAGE_STAFF', 'Manage Staff');
define('_MI_MLDOCS_MENU_MODIFY_EMLTPL', 'Modify Email Templates');
define('_MI_MLDOCS_MENU_MODIFY_ARCHIVE_FIELDS', 'Modify Archive Fields');
define('_MI_MLDOCS_MENU_GROUP_PERM', 'Group Permissions');
define('_MI_MLDOCS_MENU_ADD_STAFF', 'Add Staff');
define('_MI_MLDOCS_MENU_MIMETYPES', 'Mimetype Management');
define('_MI_MLDOCS_MENU_CHECK_TABLES', 'Check Tables');
define('_MI_MLDOCS_MENU_MANAGE_ROLES', 'Manage Roles');
define('_MI_MLDOCS_MENU_MAIL_EVENTS', 'Mail Events');
define('_MI_MLDOCS_MENU_CHECK_EMAIL', 'Check Email');
define('_MI_MLDOCS_MENU_MANAGE_FILES', 'Manage Files');
define('_MI_MLDOCS_ADMIN_ABOUT', 'About');
define('_MI_MLDOCS_TEXT_MANAGE_STATUSES', 'Manage Statuses');
define('_MI_MLDOCS_TEXT_MANAGE_FIELDS', 'Manage Custom Fields');
define('_MI_MLDOCS_TEXT_NOTIFICATIONS', 'Manage Notifications');

//NOTIFICATION vars
define('_MI_MLDOCS_DEPT_NOTIFY','Department');
define('_MI_MLDOCS_DEPT_NOTIFYDSC','Notification options that apply to a certain department');

define('_MI_MLDOCS_ARCHIVE_NOTIFY','Archive');
define('_MI_MLDOCS_ARCHIVE_NOTIFYDSC','Notification options that apply to the current archive');

define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFY', 'Staff: New Archive');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYCAP', 'Notify me when archives get created');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYDSC', 'Receive notification when a new archive is created');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive created - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYTPL', 'dept_newarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFY', 'Staff: Delete Archive');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYCAP', 'Notify me when archives get deleted');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYDSC', 'Receive notification when a archive is deleted');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive deleted - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYTPL', 'dept_removedarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFY', 'Staff: Modified Archive');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYCAP', 'Notify me when archives get modified');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYDSC', 'Receive notification when a archive is deleted');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive modified - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYTPL', 'dept_modifiedarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFY', 'Staff: New Response');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYCAP', 'Notify me for new responses on my archives');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYDSC', 'Receive notification when a response is created');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYSBJ', '{X_MODULE} Archive response added - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYTPL', 'dept_newresponse_notify.tpl');

define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFY', 'Staff: Modified Response');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYCAP', 'Notify me when responses are modified');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYDSC', 'Receive notification when a response is modified');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYSBJ', '{X_MODULE} Archive response modified - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYTPL', 'dept_modifiedresponse_notify.tpl');

define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFY', 'Staff: Changed Archive Status');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYCAP', 'Notify me when the status of archives changes');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYDSC', 'Receive notification when the status of a archive is changed');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYSBJ', '{X_MODULE} Archive status changed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYTPL', 'dept_changedstatus_notify.tpl');

define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFY', 'Staff: Changed Archive Priority');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYCAP', 'Notify me when the priority of archives changes');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYDSC', 'Receive notification when the priority of a archive is changed');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYSBJ', '{X_MODULE} Archive priority changed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYTPL', 'dept_changedpriority_notify.tpl');

define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFY', 'Staff: New Archive Owner');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYCAP', 'Notify me when I gain or lose ownership of a archive');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYDSC', 'Receive notification when ownership of a archive is changed');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYSBJ', '{X_MODULE} Archive ownership changed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYTPL', 'dept_newowner_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFY', 'User: Archive Deleted');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYCAP', 'Notify me when this archive is deleted');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYDSC', 'Receive notification when this archive is deleted');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive Deleted - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYTPL', 'archive_removedarchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFY', 'User: Archive Modified');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYCAP', 'Notify me when this archive is modified');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYDSC', 'Receive notification when this archive is modified');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive modified - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYTPL', 'archive_modifiedarchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFY', 'User: New Response');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYCAP', 'Notify me when a response is created for this archive');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYDSC', 'Receive notification when a response is created for this archive');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYSBJ', 'RE: {ARCHIVE_SUBJECT} {ARCHIVE_SUPPORT_KEY}');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYTPL', 'archive_newresponse_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFY', 'User: Modified Response');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYCAP', 'Notify me when a response is modified for this archive');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYDSC', 'Receive notification when a response is modified for this archive');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYSBJ', '{X_MODULE} Archive response modified - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYTPL', 'archive_modifiedresponse_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFY', 'User: Changed Status');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYCAP', 'Notify me when the status of this archive is changed');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYDSC', 'Receive notification when the status of this archive is changed');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYSBJ', '{X_MODULE} Archive status changed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYTPL', 'archive_changedstatus_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFY', 'User: Changed Priority');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYCAP', 'Notify me when the priority of this archive is changed');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYDSC', 'Receive notification when the priority of this archive is changed');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYSBJ', '{X_MODULE} Archive priority changed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYTPL', 'archive_changedpriority_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFY', 'User: New Owner');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYCAP', 'Notify me when ownership has been changed for this archive');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYDSC', 'Receive notification when ownership has been changed for this archive');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYSBJ', '{X_MODULE} Archive ownership changed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYTPL', 'archive_newowner_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFY', 'User: New Archive');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYCAP', 'Confirm when a new archive is created');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYDSC', 'Receive notification when a new archive is created');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYSBJ', 'RE: {ARCHIVE_SUBJECT} {ARCHIVE_SUPPORT_KEY}');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYTPL', 'archive_newarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFY', 'Staff: Close Archive');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYCAP', 'Notify me when a archive is closed');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYDSC', 'Receive notification when a archive is closed');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive closed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYTPL', 'dept_closearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFY', 'User: Close Archive');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYCAP', 'Confirm when a archive is closed');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYDSC', 'Receive notification when a archive is closed');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive closed - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYTPL', 'archive_closearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFY', 'User: New User created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYCAP', 'Notify user that a new account has been created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYDSC', 'Receive notification when a new user is created from an email submission (Requires Activation)');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYSBJ', '{X_MODULE} New User Created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYTPL', 'archive_new_user_byemail.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFY', 'User: New User created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYCAP', 'Notify user that a new account has been created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYDSC', 'Receive notification when a new user is created from an email submission (Auto Activation)');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYSBJ', '{X_MODULE} New User Created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYTPL', 'archive_new_user_activation1.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFY', 'User: New User created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYCAP', 'Notify user that a new account has been created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYDSC', 'Receive notification when a new user is created from an email submission (Requires Admin Activation)');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYSBJ', '{X_MODULE} New User Created');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYTPL', 'archive_new_user_activation2.tpl');

define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFY', 'User: Email Error');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYCAP', 'Notify user that their email was not stored');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYDSC', 'Receive notification when an email submission is not stored');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYSBJ', 'RE: {ARCHIVE_SUBJECT}');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYTPL', 'archive_email_error.tpl');

define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFY', 'Staff: Merge Archives');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYCAP', 'Notify me when archives are merged');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYDSC', 'Receive notification when archives are merged');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYSBJ', '{X_MODULE} Archives merged');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYTPL', 'dept_mergearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFY', 'User: Merge Archives');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYCAP', 'Notify me when archives are merged');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYDSC', 'Receive notification when archives are merged');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYSBJ', '{X_MODULE} Archives merged');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYTPL', 'archive_mergearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFY', 'User: New Archive By Email');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYCAP', 'Confirm when a new archive is created by email');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYDSC', 'Receive notification when a new archive is created by email');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYSBJ', 'RE: {ARCHIVE_SUBJECT} {ARCHIVE_SUPPORT_KEY}');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYTPL', 'archive_newarchive_byemail_notify.tpl');

// Be sure to add new mail_templates to array in admin/index.php - modifyEmlTpl()

//Trad memseb@2007
// Sub menus in main menu block
define('_MI_MLDOCS_PRODUCT','Log Archive');
define('_MI_MLDOCS_EXPLORE','Explore');
define('_MI_MLDOCS_BANNETTE','Bannette');
define('_MI_MLDOCS_OUTILS','Tools');
define('_MI_MLDOCS_TESTS','Tests');

define('_MI_MLDOCS_PATH_BANNETTE', 'Bannet Path');
define('_MI_MLDOCS_PATH_BANNETTE_DSC', 'file bannet position for every user');
define('_MI_MLDOCS_URL_BANNETTE', 'bannet url');
define('_MI_MLDOCS_URL_BANNETTE_DSC', 'banet file link for any user');
define('_MI_MLDOCS_PATH_ARCHIVE', 'Archive path');
define('_MI_MLDOCS_PATH_ARCHIVE_DSC', 'file archive production path');
define('_MI_MLDOCS_PATH_CGI-BIN', 'binary file position');
define('_MI_MLDOCS_PATH_CGI-BIN_DSC', 'binary file position (fullpath)');
define('_MI_MLDOCS_UNIQUE_ARCHIVE', 'make Archive code as unique key');
define('_MI_MLDOCS_UNIQUE_ARCHIVE_DSC', 'Allow or not to add an archive code several times');
define('_MI_MLDOCS_PATH_BANNETTE_DFLT', 'Bannet position Path Directory');


?>
