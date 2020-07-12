<?php
//$Id: admin.php,v 1.76 2005/10/04 19:38:57 eric_juden Exp $

//Menu choices
define('_AM_MLDOCS_ADMIN_TITLE', '%s Administrator Menu');
define('_AM_MLDOCS_BLOCK_TEXT', 'Manage Blocks');
define('_AM_MLDOCS_MENU_MANAGE_DEPARTMENTS', 'Manage Departments');
define('_AM_MLDOCS_MENU_MANAGE_STAFF', 'Manage Staff');
define('_AM_MLDOCS_MENU_MODIFY_EMLTPL', 'Modify Email Templates');
define('_AM_MLDOCS_MENU_MODIFY_ARCHIVE_FIELDS', 'Modify Archive Fields');
define('_AM_MLDOCS_MENU_GROUP_PERM', 'Group Permissions');
define('_AM_MLDOCS_MENU_MIMETYPES', 'Mimetype Management');
define('_AM_MLDOCS_MENU_PREFERENCES', 'Preferences');
define('_AM_MLDOCS_MENU_ADD_STAFF', 'Add Staff');
define('_AM_MLDOCS_UPDATE_MODULE', 'Update Module');
define('_AM_MLDOCS_MENU_MANAGE_ROLES', 'Manage Roles');
define('_AM_MLDOCS_TEXT_MANAGE_NOTIFICATIONS', 'Manage Notifications');

define('_AM_MLDOCS_SEC_ARCHIVE_ADD', 0);
define('_AM_MLDOCS_SEC_ARCHIVE_EDIT', 1);
define('_AM_MLDOCS_SEC_ARCHIVE_DELETE', 2);
define('_AM_MLDOCS_SEC_ARCHIVE_OWNERSHIP', 3);
define('_AM_MLDOCS_SEC_ARCHIVE_STATUS', 4);
define('_AM_MLDOCS_SEC_ARCHIVE_PRIORITY', 5);
define('_AM_MLDOCS_SEC_ARCHIVE_LOGUSER', 6);
define('_AM_MLDOCS_SEC_RESPONSE_ADD', 7);
define('_AM_MLDOCS_SEC_RESPONSE_EDIT', 8);
define('_AM_MLDOCS_SEC_ARCHIVE_MERGE', 9);
define('_AM_MLDOCS_SEC_FILE_DELETE', 10);

define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_ADD', 'Add Archives');
define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_EDIT', 'Modify Archives');
define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_DELETE', 'Delete Archives');
define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_OWNERSHIP', 'Change Archive Ownership');
define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_STATUS', 'Change Archive Status');
define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_PRIORITY', 'Change Archive Priority');
define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_LOGUSER', 'Log Archive for User');
define('_AM_MLDOCS_SEC_TEXT_RESPONSE_ADD', 'Add Response');
define('_AM_MLDOCS_SEC_TEXT_RESPONSE_EDIT', 'Modify Response');
define('_AM_MLDOCS_SEC_TEXT_ARCHIVE_MERGE', 'Merge Archives');
define('_AM_MLDOCS_SEC_TEXT_FILE_DELETE', 'Delete File Attachments');

// Admin Menu
define('_AM_MLDOCS_ADMIN_ABOUT', 'About');
define('_AM_MLDOCS_ADMIN_GOTOMODULE', 'Go To Module');

//Permissions
define('_AM_MLDOCS_GROUP_PERM', 'Group Permissions');
define('_AM_MLDOCS_GROUP_PERM_TITLE', 'Modify Group Permissions');
define('_AM_MLDOCS_GROUP_PERM_NAME', 'Permissions');
define('_AM_MLDOCS_GROUP_PERM_DESC', 'Select service(s) that each group should be allowed to modify');

// Messages
define('_AM_MLDOCS_MESSAGE_STAFF_UPDATE_ERROR', 'Error: staff not updated');
define('_AM_MLDOCS_MESSAGE_FILE_READONLY', 'This file is read-only. Please make the modules/mldocs/language/english/mail_templates folder writable');
define('_AM_MLDOCS_MESSAGE_FILE_UPDATED', 'File updated successfully');
define('_AM_MLDOCS_MESSAGE_FILE_UPDATED_ERROR', 'Error: file not updated');
define('_AM_MLDOCS_MESSAGE_ROLE_INSERT', 'Role inserted successfully.');
define('_AM_MLDOCS_MESSAGE_ROLE_INSERT_ERROR', 'Error: role was not created.');
define('_AM_MLDOCS_MESSAGE_ROLE_DELETE', 'Role deleted successfully.');
define('_AM_MLDOCS_MESSAGE_ROLE_DELETE_ERROR', 'Error: role was not removed.');
define('_AM_MLDOCS_MESSAGE_ROLE_UPDATE', 'Role updated successfully.');
define('_AM_MLDOCS_MESSAGE_ROLE_UPDATE_ERROR', 'Error: role was not updated.');
define('_AM_MLDOCS_MESSAGE_DEPT_STORE', 'Department permissions stored successfully.');
define('_AM_MLDOCS_MESSAGE_DEPT_STORE_ERROR', 'Error: department permissions were not stored.');
define('_AM_MLDOCS_MESSAGE_DEF_ROLES', 'Default permission roles were added successfully.');
define('_AM_MLDOCS_MESSAGE_DEF_ROLES_ERROR', 'Default permission roles were not added.');
define('_AM_MLDOCS_MESSAGE_NO_DEPT', 'Error: no department specified');
define('_AM_MLDOCS_MESSAGE_NO_DESC', 'Error: you did not specify a description.');
define('_AM_MESSAGE_ADD_STATUS_ERR', 'Error: status was not added.');
define('_AM_MESSAGE_EDIT_STATUS_ERR', 'Error: status was not updated.');
define('_AM_MLDOCS_DEL_STATUS_ERR', 'Error: status was not deleted.');
define('_AM_MLDOCS_STATUS_HASARCHIVES_ERR', 'Error: please update archives using this status.');
define('_AM_MLDOCS_MESSAGE_NO_ID', 'Error: id was not specified.');
define('_AM_MLDOCS_MESSAGE_NO_VALUE', 'Error: the mimetype value was not specified.');
define('_AM_MLDOCS_MESSAGE_EDIT_MIME_ERROR', 'Error: the mimetype was not updated.');
define('_AM_MLDOCS_MESSAGE_DELETE_MIME_ERROR', 'Error: the mimetype was not deleted.');
define('_AM_MLDOCS_MESSAGE_ADD_MIME_ERROR', 'Error: the mimetype was not added.');

// Buttons
define('_AM_MLDOCS_BUTTON_DELETE', 'Delete');
define('_AM_MLDOCS_BUTTON_EDIT', 'Edit');
define('_AM_MLDOCS_BUTTON_SUBMIT', 'Submit');
define('_AM_MLDOCS_BUTTON_RESET', 'Reset');
define('_AM_MLDOCS_BUTTON_ADDSTAFF', 'Add Staff');
define('_AM_MLDOCS_BUTTON_UPDATESTAFF', 'Update Staff');
define('_AM_MLDOCS_BUTTON_CANCEL', 'Cancel');
define('_AM_MLDOCS_BUTTON_UPDATE', 'Update');
define('_AM_MLDOCS_BUTTON_CREATE_ROLE', 'Create New Role');
define('_AM_MLDOCS_BUTTON_CLEAR_PERMS', 'Clear Permissions');
//define('_AM_MLDOCS_BUTTON_ADD_DEPT', 'Add Department');

define('_AM_MLDOCS_EDIT_DEPARTMENT', 'Edit Department');
define('_AM_MLDOCS_EXISTING_DEPARTMENTS', 'Existing Departments');
define('_AM_MLDOCS_MANAGE_DEPARTMENTS', 'Manage Departments');
define('_AM_MLDOCS_MANAGE_STAFF', 'Manage Staff');
define('_AM_MLDOCS_EXISTING_STAFF', 'Existing Staff Members');
define('_AM_MLDOCS_ADD_STAFF', 'Add Staff Members');
define('_AM_MLDOCS_EDIT_STAFF', 'Edit Staff Member');
define('_AM_MLDOCS_INDEX', 'Index');
define('_AM_MLDOCS_DEPARTMENT_SERVERS', 'Department Mailbox');
define('_AM_MLDOCS_DEPARTMENT_SERVERS_EMAIL', 'Email Address');
define('_AM_MLDOCS_DEPARTMENT_SERVERS_TYPE', 'Mailbox Type');
define('_AM_MLDOCS_DEPARTMENT_SERVERS_PRIORITY', 'Default Archive Priority');
define('_AM_MLDOCS_DEPARTMENT_SERVERS_SERVERNAME', 'Server');
define('_AM_MLDOCS_DEPARTMENT_SERVERS_PORT', 'Port');
define('_AM_MLDOCS_DEPARTMENT_SERVERS_ACTION', 'Actions');
define('_AM_MLDOCS_DEPARTMENT_ADD_SERVER', 'Add Mailbox to monitor');
define('_AM_MLDOCS_DEPARTMENT_SERVER_USERNAME', 'Username');
define('_AM_MLDOCS_DEPARTMENT_SERVER_PASSWORD', 'Password');
define('_AM_MLDOCS_DEPARTMENT_SERVER_EMAILADDRESS', 'Reply-To Email Address');
define('_AM_MLDOCS_DEPARTMENT_NO_ID', 'Could not find Department ID. Aborting.');
define('_AM_MLDOCS_DEPARTMENT_SERVER_SAVED', 'Added Mailbox to Department.');
define('_AM_MLDOCS_DEPARTMENT_SERVER_ERROR', 'Error saving Mailbox to Department.');
define('_AM_MLDOCS_DEPARTMENT_SERVER_NO_ID', 'Department mailbox was not specified.');
define('_AM_MLDOCS_DEPARTMENT_SERVER_DELETED', 'Deleted mailbox from Department.');
define('_AM_MLDOCS_DEPARTMENT_SERVER_DELETE_ERROR', 'Error removing Mailbox from Department.');
define('_AM_MLDOCS_STAFF_ERROR_DEPTARTMENTS', 'You must assign a user to 1 or more departments before saving');
define('_AM_MLDOCS_STAFF_ERROR_ROLES', 'You must assign a user to 1 or more roles before saving');
define('_AM_MLDOCS_STAFF_ERROR_USERS', 'You must assign a user to be made a staff member.');
define('_AM_MLDOCS_STAFF_EXISTS', 'Error: this user is already a staff member.');

define('_AM_MLDOCS_MBOX_POP3', 'POP3');
define('_AM_MLDOCS_MBOX_IMAP', 'IMAP');

define('_AM_MLDOCS_TEXT_ADD_DEPT', 'Add Department');
define('_AM_MLDOCS_TEXT_EDIT_DEPT', 'Edit Department Name');
define('_AM_MLDOCS_TEXT_EDIT', 'Edit');
define('_AM_MLDOCS_TEXT_DELETE', 'Delete');
define('_AM_MLDOCS_TEXT_SELECTUSER', 'Select Username');
define('_AM_MLDOCS_TEXT_DEPARTMENTS', 'Departments');
define('_AM_MLDOCS_TEXT_USER', 'Username');
define('_AM_MLDOCS_TEXT_ALL_DEPTS', 'All');
define('_AM_MLDOCS_TEXT_NO_DEPTS', 'None');
define('_AM_MLDOCS_TEXT_MAKE_DEPTS', 'You must add departments before adding staff!');
define('_AM_MLDOCS_LINK_ADD_DEPT', 'Add Departments');
define('_AM_MLDOCS_TEXT_TOP_CLOSERS', 'Top Closers');
define('_AM_MLDOCS_TEXT_WORST_CLOSERS', 'Worst Closers');
define('_AM_MLDOCS_TEXT_HIGH_PRIORITY', 'Open High-Priority Archives');
define('_AM_MLDOCS_TEXT_NO_OWNER', 'No Owner');
define('_AM_MLDOCS_TEXT_NO_DEPT', 'No Department');
define('_AM_MLDOCS_TEXT_RESPONSE_TIME', 'Fastest Response Time');
define('_AM_MLDOCS_TEXT_RESPONSE_TIME_SLOW', 'Slowest Response Time');
define('_AM_MLDOCS_TEXT_PRIORITY', 'Priority');
define('_AM_MLDOCS_TEXT_ELAPSED', 'Elapsed');
define('_AM_MLDOCS_TEXT_STATUS', 'Status');
define('_AM_MLDOCS_TEXT_SUBJECT', 'Subject');
define('_AM_MLDOCS_TEXT_DEPARTMENT', 'Department');
define('_AM_MLDOCS_TEXT_OWNER', 'Owner');
define('_AM_MLDOCS_TEXT_LAST_UPDATED', 'Last Updated');
define('_AM_MLDOCS_TEXT_LOGGED_BY', 'Logged By');
define('_AM_MLDOCS_TEXT_EXISTING_ROLES', 'Existing Roles');
define('_AM_MLDOCS_TEXT_NO_ROLES', 'No Roles Found');
define('_AM_MLDOCS_TEXT_ROLES', 'Roles');
define('_AM_MLDOCS_TEXT_CREATE_ROLE', 'Create New Role');
define('_AM_MLDOCS_TEXT_EDIT_ROLE', 'Edit Role');
define('_AM_MLDOCS_TEXT_NAME', 'Name');
define('_AM_MLDOCS_TEXT_PERMISSIONS', 'Permissions');
define('_AM_MLDOCS_TEXT_SELECT_ALL', 'Select All');
define('_AM_MLDOCS_TEXT_DEPT_PERMS', 'Customize Department Permissions');
define('_AM_MLDOCS_TEXT_CUSTOMIZE', 'Customize');
define('_AM_MLDOCS_TEXT_ACTIONS', 'Actions');
define('_AM_MLDOCS_TEXT_ID', 'ID');
define('_AM_MLDOCS_TEXT_LOOKUP_USER', 'Lookup User');
define('_AM_MLDOCS_TEXT_BY', 'By');
define('_AM_MLDOCS_TEXT_ASCENDING', 'Ascending');
define('_AM_MLDOCS_TEXT_DESCENDING', 'Descending');
define('_AM_MLDOCS_TEXT_SORT_BY', 'Sort By:');
define('_AM_MLDOCS_TEXT_ORDER_BY', 'Order By:');
define('_AM_MLDOCS_TEXT_NUMBER_PER_PAGE', 'Number Per Page:');
define('_AM_MLDOCS_TEXT_SEARCH_MIME', 'Search Mimetypes');
define('_AM_MLDOCS_TEXT_SEARCH_BY', 'Search By:');
define('_AM_MLDOCS_TEXT_SEARCH_TEXT', 'Search Text:');
define('_AM_MLDOCS_TEXT_GO_BACK_SEARCH', 'Back to Search');
define('_AM_MLDOCS_TEXT_FIND_USERS', 'Find User');

define('_AM_MLDOCS_SEARCH_BEGINEGINDATE', 'Begin Date');  
define('_AM_MLDOCS_SEARCH_ENDDATE', 'End Date');

define('_AM_MLDOCS_TEXT_ADD_STATUS', 'Add Status');
define('_AM_MLDOCS_TEXT_STATE', 'State');
define('_AM_MLDOCS_TEXT_MANAGE_STATUSES', 'Manage Statuses');
define('_AM_MLDOCS_TEXT_EDIT_STATUS', 'Edit Status');

define('_AM_MLDOCS_TEXT_NO_RECORDS', 'No Records Found');
define('_AM_MLDOCS_TEXT_MAIL_EVENTS', 'Mail Events');
define('_AM_MLDOCS_TEXT_MAILBOX', 'Mailbox');
define('_AM_MLDOCS_TEXT_EVENT_CLASS', 'Event Class');
define('_AM_MLDOCS_TEXT_TIME', 'Time');
define('_AM_MLDOCS_NO_EVENTS', 'No Events Found');
define('_AM_MLDOCS_SEARCH_EVENTS', 'Search Mail Events');
define('_AM_MLDOCS_BUTTON_SEARCH', 'Search');
define('_AM_MLDOCS_BUTTON_TEST', 'Test');
define('_AM_MLDOCS_POSITION', 'Position');
define('_AM_MLDOCS_TEXT_MANAGE_FILES', 'Manage Files');
define('_AM_MLDOCS_TEXT_ARCHIVEID', 'Archive ID');
define('_AM_MLDOCS_TEXT_FILENAME', 'Filename');
define('_AM_MLDOCS_TEXT_MIMETYPE', 'Mimetype');
define('_AM_MLDOCS_TEXT_TOTAL_USED_SPACE', 'Total Used Space');
define('_AM_MLDOCS_TEXT_SIZE', 'Size');
define('_AM_MLDOCS_TEXT_DELETE_RESOLVED', 'Delete attachments from resolved archives?');
define('_AM_MLDOCS_TEXT_NO_FILES', 'No Files Found');
define('_AM_MLDOCS_TEXT_RESOLVED_ATTACH', 'Resolved Attachments');
define('_AM_MLDOCS_TEXT_ALL_ATTACH', 'All Attachments');
define('_AM_MLDOCS_TEXT_MAINTENANCE', 'Maintenance Tasks');
define('_AM_MLDOCS_TEXT_ORPHANED', 'Remove orphaned staff records from mldocs_staff table?');
define('_AM_MLDOCS_TEXT_DELETE_STAFF_DEPT', 'Remove staff from department');
define('_AM_MLDOCS_MSG_NO_DEPTID', 'Error: no department id was specified.');
define('_AM_MLDOCS_MSG_NO_UID', 'Error: no user was specified.');
define('_AM_MLDOCS_MSG_REMOVE_STAFF_DEPT_ERR', 'Error: staff was not removed from department.');
define('_AM_MLDOCS_TEXT_DEFAULT', 'Default');
define('_AM_MLDOCS_TEXT_MAKE_DEFAULT_DEPT', 'Make this default department');
define('_AM_MLDOCS_TEXT_DEFAULT_DEPT', 'Default Department');
define('_AM_MLDOCS_MSG_CHANGED_DEFAULT_DEPT', 'Updated the default department.');

// Mimetypes
define("_AM_MLDOCS_MIME_ID", "ID");
define("_AM_MLDOCS_MIME_EXT", "EXT");
define("_AM_MLDOCS_MIME_NAME", "Application Type");
define("_AM_MLDOCS_MIME_ADMIN", "Staff");
define("_AM_MLDOCS_MIME_USER", "User");
// Mimetype Form
define("_AM_MLDOCS_MIME_CREATEF", "Create Mimetype");
define("_AM_MLDOCS_MIME_MODIFYF", "Modify Mimetype");
define("_AM_MLDOCS_MIME_EXTF", "File Extension");
define("_AM_MLDOCS_MIME_NAMEF", "Application Type/Name<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter application associated with this extension.</span></div>");
define("_AM_MLDOCS_MIME_TYPEF", "Mimetypes<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter each mimetype associated with the file extension. Each mimetype must be seperated with a space.</span></div>");
define("_AM_MLDOCS_MIME_ADMINF", "Allowed Admin Mimetype");
define("_AM_MLDOCS_MIME_ADMINFINFO", "<b>Mimetypes that are available for Admin uploads</b>");
define("_AM_MLDOCS_MIME_USERF", "Allowed User Mimetype");
define("_AM_MLDOCS_MIME_USERFINFO", "<b>Mimetypes that are available for User uploads</b>");
define("_AM_MLDOCS_MIME_NOMIMEINFO", "No mimetypes selected.");
define("_AM_MLDOCS_MIME_FINDMIMETYPE", "Find New Mimetype?");
define("_AM_MLDOCS_MIME_EXTFIND", "Search File Extension<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter file extension you wish to search.</span></div>");
define("_AM_MLDOCS_MIME_INFOTEXT", "<ul><li>New mimetypes can be created, edit or deleted easily via this form.</li> 
	<li>Search for a new mimetypes via an external website.</li> 
	<li>View displayed mimetypes for Admin and User uploads.</li> 
	<li>Change mimetype upload status.</li></ul> 
	");

// Mimetype Buttons
define("_AM_MLDOCS_MIME_CREATE", "Create");
define("_AM_MLDOCS_MIME_CLEAR", "Reset");
define("_AM_MLDOCS_MIME_CANCEL", "Cancel");
define("_AM_MLDOCS_MIME_MODIFY", "Modify");
define("_AM_MLDOCS_MIME_DELETE", "Delete");
define("_AM_MLDOCS_MIME_FINDIT", "Get Extension!");
// Mimetype Database
define("_AM_MLDOCS_MIME_DELETETHIS", "Delete Selected Mimetype?");
define("_AM_MLDOCS_MIME_MIMEDELETED", "Mimetype %s has been deleted");
define("_AM_MLDOCS_MIME_CREATED", "Mimetype Information Created");
define("_AM_MLDOCS_MIME_MODIFIED", "Mimetype Information Modified");

define("_AM_MLDOCS_MINDEX_ACTION", "Action");
define("_AM_MLDOCS_MINDEX_PAGE", "<b>Page</b> ");

//image admin icon 
define("_AM_MLDOCS_ICO_EDIT","Edit This Item");
define("_AM_MLDOCS_ICO_DELETE","Delete This Item");
define("_AM_MLDOCS_ICO_ONLINE","Online");
define("_AM_MLDOCS_ICO_OFFLINE","Offline");
define("_AM_MLDOCS_ICO_APPROVED","Approved");
define("_AM_MLDOCS_ICO_NOTAPPROVED","Not Approved");

define("_AM_MLDOCS_ICO_LINK","Related Link");
define("_AM_MLDOCS_ICO_URL","Add Related URL");
define("_AM_MLDOCS_ICO_ADD","Add");
define("_AM_MLDOCS_ICO_APPROVE","Approve");
define("_AM_MLDOCS_ICO_STATS","Stats");

define("_AM_MLDOCS_ICO_IGNORE","Ignore");
define("_AM_MLDOCS_ICO_ACK","Broken Report Acknowledged");
define("_AM_MLDOCS_ICO_REPORT","Acknowledge Broken Report?");
define("_AM_MLDOCS_ICO_CONFIRM","Broken Report Confirmed");
define("_AM_MLDOCS_ICO_CONBROKEN","Confirm Broken Report?");

define("_AM_MLDOCS_UPLOADFILE", "File Uploaded Successfully");
define('_AM_MLDOCS_TEXT_ARCHIVE_INFO', 'Archive Information');
define('_AM_MLDOCS_TEXT_OPEN_ARCHIVES', 'Open Archives');
define('_AM_MLDOCS_TEXT_HOLD_ARCHIVES', 'Hold Archives');
define('_AM_MLDOCS_TEXT_CLOSED_ARCHIVES', 'Closed Archives');
define('_AM_MLDOCS_TEXT_TOTAL_ARCHIVES', 'Total Archives');

define('_AM_MLDOCS_TEXT_TEMPLATE_NAME', 'Template Name');
define('_AM_MLDOCS_TEXT_DESCRIPTION', 'Description');
define('_AM_MLDOCS_TEXT_PATH', 'Path');
define('_AM_MLDOCS_TEXT_GENERAL_TAGS', 'Common Tags');
define('_AM_MLDOCS_TEXT_GENERAL_TAGS1', 'X_SITEURL - URL of site');
define('_AM_MLDOCS_TEXT_GENERAL_TAGS2', 'X_SITENAME - name of site');
define('_AM_MLDOCS_TEXT_GENERAL_TAGS3', 'X_ADMINMAIL - administrator email address');
define('_AM_MLDOCS_TEXT_GENERAL_TAGS4', 'X_MODULE - name of module');
define('_AM_MLDOCS_TEXT_GENERAL_TAGS5', 'X_MODULE_URL - link to index page of the module');
define('_AM_MLDOCS_TEXT_TAGS_NO_MODIFY', 'Do not modify tags other than these listed!');

define('_AM_MLDOCS_CURRENTVER', 'Current Version <span class="currentVer">%s</span>');
define('_AM_MLDOCS_DBVER', 'Database Version <span class="dbVer">%s</span>');
define('_AM_MLDOCS_DB_NOUPDATE', 'Your database is up-to-date. No updates are necessary.');
define('_AM_MLDOCS_DB_NEEDUPDATE', 'Your database is out-of-date. Please upgrade your database tables!');
define('_AM_MLDOCS_UPDATE_NOW', 'Update Now!');
define('_AM_MLDOCS_DB_NEEDINSTALL', 'Your database is out of sync with the installed version. Please install the same version as the database');
define('_AM_MLDOCS_VERSION_ERR', 'Unable to determine previous version.');
define('_AM_MLDOCS_MSG_MODIFYTABLE', 'Modified table %s');
define('_AM_MLDOCS_MSG_MODIFYTABLE_ERR', 'Error modifying table %s');
define('_AM_MLDOCS_MSG_ADDTABLE', 'Added table %s');
define('_AM_MLDOCS_MSG_ADDTABLE_ERR', 'Error adding table %s');
define('_AM_MLDOCS_MSG_UPDATESTAFF', 'Updated staff #%s');
define('_AM_MLDOCS_MSG_UPDATESTAFF_ERR', 'Error updating staff #%s');
define('_AM_MLDOCS_UPDATE_DB', 'Updating Database');
define('_AM_MLDOCS_UPDATE_TO', 'Updating to version %s');
define('_AM_MLDOCS_UPDATE_OK', 'Successfully updated to version %s');
define('_AM_MLDOCS_UPDATE_ERR', 'Errors updating to version %s');
define('_AM_MLDOCS_MSG_UPD_PERMS', 'Staff #%s permissions added for department %s.');
define('_AM_MLDOCS_MSG_REMOVE_TABLE', 'Table %s was removed from your database.');
define('_AM_MLDOCS_MSG_GLOBAL_PERMS', 'Staff #%s has global permissions.');
define('_AM_MLDOCS_MSG_NOT_REMOVE_TABLE', 'Error: table %s was NOT removed from your database.');
define('_AM_MLDOCS_MSG_RENAME_TABLE', 'Table %s was renamed %s.');
define('_AM_MLDOCS_MSG_RENAME_TABLE_ERR', 'Error: table %s was not renamed.');
define('_AM_MLDOCS_MSG_UPDATE_ROLE', '%s role permissions have been updated.');
define('_AM_MLDOCS_MSG_UPDATE_ROLE_ERR', 'Error: %s role permissions were not updated.');
define('_AM_MLDOCS_MSG_DEPT_DEL_CFRM', 'Are you sure you want to delete department #%u?');
define('_AM_MLDOCS_MSG_STAFF_DEL_CFRM', 'Are you sure you want to remove staff #%u?');
define('_AM_MLDOCS_MSG_DEPT_MBOX_DEL_CFRM', 'Are you sure you want to delete the mailbox %s?');
define('_AM_MLDOCS_MSG_ADD_STATUS_ERR', 'Error: status \'%s\' was not added.');
define('_AM_MLDOCS_MSG_ADD_STATUS', 'Status \'%s\' was added.');
define('_AM_MLDOCS_MSG_CHANGED_STATUS', 'Archives updated with new status.');
define('_AM_MLDOCS_MSG_CHANGED_STATUS_ERR', 'Error: archive statuses not updated.');
define('_AM_MLDOCS_MSG_DELETE_RESOLVED', 'Are you sure you want to remove resolved archive attachments?');
define('_AM_MLDOCS_MSG_DELETE_FILE', 'Are you sure you want to remove this attachment?');
define('_AM_MLDOCS_MSG_ADD_CONFIG_ERR', 'Error: configuration value for department was not saved');
define('_AM_MLDOCS_MSG_UPDATE_CONFIG_ERR', 'Error: configuration value for department was not updated');
define('_AM_MLDOCS_MSG_CLEAR_ORPHANED_ERR', 'Your staff records are up to date.');
define('_AM_MLDOCS_MSG_UPDATE_SEARCH', 'Saved search #%u has been updated.');
define('_AM_MLDOCS_MSG_UPDATE_SEARCH_ERR', 'Error: saved search #%u was not updated.');

define('_AM_MLDOCS_TEXT_CONTRIB_INFO', 'Contributor Information');
define('_AM_MLDOCS_TEXT_DEVELOPERS', 'Developers');
define('_AM_MLDOCS_TEXT_TRANSLATORS', 'Translators');
define('_AM_MLDOCS_TEXT_TESTERS', 'Testers');
define('_AM_MLDOCS_TEXT_DOCUMENTER', 'Documenters');
define('_AM_MLDOCS_TEXT_CODE', 'Patches');
define('_AM_MLDOCS_TEXT_MODULE_DEVELOPMENT', 'Module Development Information');
define('_AM_MLDOCS_TEXT_DEMO_SITE', 'Demo Site');
define('_AM_MLDOCS_DEMO_SITE', 'MLdocs Demo Site');
define('_AM_MLDOCS_TEXT_OFFICIAL_SITE', 'Official Support Site');
define('_AM_MLDOCS_OFFICIAL_SITE', 'mldocs.org');
define('_AM_MLDOCS_TEXT_REPORT_BUG', 'Got a bug?');
define('_AM_MLDOCS_REPORT_BUG', 'Report Bug');
define('_AM_MLDOCS_TEXT_NEW_FEATURE', 'Got a feature?');
define('_AM_MLDOCS_NEW_FEATURE', 'New Feature');
define('_AM_MLDOCS_TEXT_QUESTIONS', 'Questions?');
define('_AM_MLDOCS_QUESTIONS', 'Ask module developers a question');
define('_AM_MLDOCS_TEXT_RELEASE_DATE', 'Release Date');
define('_AM_MLDOCS_TEXT_DISCLAIMER', 'Disclaimer');
define('_AM_MLDOCS_DISCLAIMER', 'WARNING: This module is still in Beta stage. It should not be used on a production site. The developers are not responsible for anything that may occur by using this module.');
define('_AM_MLDOCS_TEXT_CHANGELOG', 'Change Log');
define('_AM_MLDOCS_TEXT_EDIT_DEPT_PERMS', 'Department Visibility');

define('_AM_MLDOCS_PATH_CONFIG', "Module Directory Configuration");
define('_AM_MLDOCS_PATH_ARCHIVEATTACH', 'Archive Attachments');
define('_AM_MLDOCS_PATH_EMAILTPL', 'Email Templates');
define('_AM_MLDOCS_TEXT_CREATETHEDIR', 'Create the folder');
define('_AM_MLDOCS_TEXT_CREATE100DIR', 'Create 100 directories'); //memseb@2007
define('_AM_MLDOCS_TEXT_SETPERM', 'Set Permissions');

define('_AM_MLDOCS_PATH_AVAILABLE', "<span style='font-weight: bold; color: green;'>Available</span>");
define('_AM_MLDOCS_PATH_NOTAVAILABLE', "<span style='font-weight: bold; color: red;'>Not available</span>");
define('_AM_MLDOCS_PATH_NOTWRITABLE', "<span style='font-weight: bold; color: red;'>Not writable</span>");
define('_AM_MLDOCS_PATH_CREATED', "Folder successfully created");
define('_AM_MLDOCS_PATH_NOTCREATED', "The folder could not be created");
define('_AM_MLDOCS_MESSAGE_ACTIVATE', 'Toggle Active');
define('_AM_MLDOCS_MESSAGE_DEACTIVATE', 'Toggle Inactive');
define('_AM_MLDOCS_TEXT_ACTIVE', 'Active');
define('_AM_MLDOCS_TEXT_INACTIVE', 'In-Active');
define('_AM_MLDOCS_TEXT_ACTIVITY', 'Activity');
define('_AM_MLDOCS_DEPARTMENT_EDIT_SERVER', 'Update Department Mailbox');

define('_AM_MLDOCS_TEXT_MANAGE_FIELDS', 'Manage Custom Fields');
define('_AM_MLDOCS_TEXT_MANAGE_FIELDLOTS', 'Manage portion Fields');//Trad memseb@2007
define('_AM_MLDOCS_ADD_FIELD', 'Add Custom Field');
define('_AM_MLDOCS_EDIT_FIELD', 'Modify Custom Field');
define('_AM_MLDOCS_TEXT_NAME_DESC', 'Displayed field title');
define('_AM_MLDOCS_TEXT_FIELDNAME', 'Field Name');
define('_AM_MLDOCS_TEXT_FIELDNAME_DESC', 'DB field and HTML field name. Use alphabetic, numeric and "_" characters only.');
define('_AM_MLDOCS_TEXT_DESCRIPTION_DESC', 'Additional field information');
define('_AM_MLDOCS_TEXT_CONTROLTYPE', 'Control Type');
define('_AM_MLDOCS_TEXT_CONTROLTYPE_DESC', 'Type of HTML Control used');
define('_AM_MLDOCS_TEXT_DEPT_DESC', 'Show this field for which departments');
define('_AM_MLDOCS_TEXT_REQUIRED', 'Required');
define('_AM_MLDOCS_TEXT_REQUIRED_DESC', 'Should this field be required during archive addition?');
define('_AM_MLDOCS_TEXT_DATATYPE', 'Data type');
define('_AM_MLDOCS_TEXT_DATATYPE_DESC', 'Type of information stored');
define('_AM_MLDOCS_TEXT_VALIDATION', 'Validation');
define('_AM_MLDOCS_TEXT_VALIDATION_DESC', 'Use a regular expression to validate the data entered by the user.');
define('_AM_MLDOCS_TEXT_WEIGHT', 'Weight');
define('_AM_MLDOCS_TEXT_WEIGHT_DESC', 'Used for ordering custom fields');
define('_AM_MLDOCS_TEXT_FIELDVALUES', 'Field Value List');
define('_AM_MLDOCS_TEXT_FIELDVALUES_DESC', 'Example:<br />u=Unspecified<br />m=Male<br />f=Female<br /><br />This is used for select boxes or something with multiple values. The info before the = is the key, and the info after is the value.');
define('_AM_MLDOCS_TEXT_DEFAULTVALUE', 'Default Value');
define('_AM_MLDOCS_TEXT_DEFAULTVALUE_DESC', 'The default value that will be supplied in the custom field.<br />For a custom field that has more than 1 possible value, use the key of the element.');
define('_AM_MLDOCS_TEXT_LENGTH', 'Length');
define('_AM_MLDOCS_TEXT_LENGTH_DESC', 'Length of the custom field.');

define('_AM_MLDOCS_TEXT_REGEX_CUSTOM', 'Custom');
define('_AM_MLDOCS_TEXT_REGEX_USPHONE', 'Phone Number');
define('_AM_MLDOCS_TEXT_REGEX_USZIP', 'US Zip + 4');
define('_AM_MLDOCS_TEXT_REGEX_EMAIL', 'Email Address');

define('_MLDOCS_CONTROL_DESC_TXTBOX', 'Text Box');
define('_MLDOCS_CONTROL_DESC_TXTAREA', 'Multi-line Text Box');
define('_MLDOCS_CONTROL_DESC_SELECT', 'Select Box');
define('_MLDOCS_CONTROL_DESC_MULTISELECT', 'Multi-Select Box');
define('_MLDOCS_CONTROL_DESC_YESNO', 'Yes / No');
define('_MLDOCS_CONTROL_DESC_CHECKBOX', 'Checkbox');
define('_MLDOCS_CONTROL_DESC_RADIOBOX', 'Radiobox');
define('_MLDOCS_CONTROL_DESC_DATETIME', 'Date+Time');
define('_MLDOCS_CONTROL_DESC_FILE', 'File');

define('_MLDOCS_DATATYPE_TEXT', 'Text');
define('_MLDOCS_DATATYPE_NUMBER_INT', 'Number (INTEGER)');
define('_MLDOCS_DATATYPE_NUMBER_DEC', 'Number (Decimal)');

define('_AM_MLDOCS_MSG_FIELD_DEL_CFRM', 'Are you sure you want to remove field #%u?');
define('_AM_MLDOCS_VALID_ERR_CONTROLTYPE', 'Invalid Control Type Selected.');
define('_AM_MLDOCS_TEXT_SESSION_RESET', 'Reset Form');
define('_AM_MLDOCS_VALID_ERR_NAME', 'Name not set');
define('_AM_MLDOCS_VALID_ERR_FIELDNAME', 'Fieldname not set');
define('_AM_MLDOCS_VALID_ERR_FIELDNAME_UNIQUE', 'Fieldname must be unique');
define('_AM_MLDOCS_VALID_ERR_LENGTH', 'Length should be a number value between %u and %u');
define('_AM_MLDOCS_VALID_ERR_DEFAULTVALUE', 'Default value must be in option list');
define('_AM_MLDOCS_VALID_ERR_VALUE_LENGTH', 'Value "%s" is greater than the field length, %u characters');
define('_AM_MLDOCS_VALID_ERR_VALUE', 'You must supply a value set for this field');
define('_AM_MLDOCS_MSG_FIELD_ADD_OK', 'Field added successfully');
define('_AM_MLDOCS_MSG_FIELD_ADD_ERR', 'Errors occurred while adding the field');
define('_AM_MLDOCS_MSG_FIELD_UPD_OK', 'Field updated successfully');
define('_AM_MLDOCS_MSG_FIELD_UPD_ERR', 'Errors occurred while updating the field');
define('_AM_MLDOCS_MSG_SUBMISSION_ERR', 'Your submission has errors.  Please fix and submit again');
define('_AM_MLDOCS_MSG_NEED_UID', 'Error: you must first select a user.');

define('_AM_MLDOCS_TEXT_DEFAULT_STATUS', 'Default Status');

define('_AM_MLDOCS_VALID_ERR_MIME_EXT', 'File extension not set');
define('_AM_MLDOCS_VALID_ERR_MIME_NAME', 'Application Type/Name not set');
define('_AM_MLDOCS_VALID_ERR_MIME_TYPES', 'Mime types not set');

define('_AM_MLDOCS_TEXT_NOTIF_NAME', 'Notification Name');
define('_AM_MLDOCS_TEXT_SUBSCRIBED_MEMBERS', 'Subscribed Members');

define('_AM_MLDOCS_NOTIF_NEW_ARCHIVE', 'New Archive');
define('_AM_MLDOCS_NOTIF_DEL_ARCHIVE', 'Delete Archive');
define('_AM_MLDOCS_NOTIF_MOD_ARCHIVE', 'Modified Archive');
define('_AM_MLDOCS_NOTIF_NEW_RESPONSE', 'New Response');
define('_AM_MLDOCS_NOTIF_MOD_RESPONSE', 'Modified Response');
define('_AM_MLDOCS_NOTIF_MOD_STATUS', 'Changed Archive Status');
define('_AM_MLDOCS_NOTIF_MOD_PRIORITY', 'Changed Archive Priority');
define('_AM_MLDOCS_NOTIF_MOD_OWNER', 'Changed Archive Owner');
define('_AM_MLDOCS_NOTIF_CLOSE_ARCHIVE', 'Closed Archive');
define('_AM_MLDOCS_NOTIF_MERGE_ARCHIVE', 'Merge Archive');

//Used for Manage Notifications page
define('_AM_MLDOCS_STAFF_SETTING1', 'All Staff');
define('_AM_MLDOCS_STAFF_SETTING2', 'Department Staff');
define('_AM_MLDOCS_STAFF_SETTING3', 'Archive Owner');
define('_AM_MLDOCS_STAFF_SETTING4', 'Notification Off');
define('_AM_MLDOCS_USER_SETTING1', 'Notification On');
define('_AM_MLDOCS_USER_SETTING2', 'Notification Off');
define('_AM_MLDOCS_TEXT_SUBMITTER', 'Submitter');
define('_AM_MLDOCS_TEXT_NOTIF_STAFF', 'Staff Notification');
define('_AM_MLDOCS_TEXT_NOTIF_USER', 'User Notification');
define('_AM_MLDOCS_TEXT_ASSOC_TPL', 'Associated Templates');
define('_AM_MLDOCS_TEXT_AND', 'and');

//Trad memseb@2007
define('_AM_MLDOCS_PATH_ARCHIVEATTACH', 'Archive attachment path');
define('_AM_MLDOCS_PATH_ARCHIVEPRODUCT', 'Production archive path');
define('_AM_MLDOCS_PATH_ARCHIVE100DIR', '100 archives directories path');
define('_AM_MLDOCS_PATH_ARCHIVEBANNETTE', 'archive bannet path');
define('_AM_MLDOCS_PATH_CACHE_IMG', 'Pictures cache path');
define('_AM_MLDOCS_PATH_CONVERT', 'Conversion tool path');
define('_AM_MLDOCS_MENU_MANAGE_PROFILELOTS', 'Manage profile portion');
define('_AM_MLDOCS_TEXT_EDIT_SUBJECT', 'Edit Subject');
define('_AM_MLDOCS_TEXT_EDIT_DESCRIPTION', 'Edit Description');	
define('_AM_MLDOCS_TEXT_SELECT_DEPTUSERDEF', 'set default Department to user connected');
define('_AM_MLDOCS_TEXT_SELECT_AUCUN', 'none');
?>
