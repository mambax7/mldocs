<?php
//$Id: main.php,v 1.114 2005/10/19 18:56:37 eric_juden Exp $

define('_MLDOCS_CATEGORY1', 'Assign Ownership');
define('_MLDOCS_CATEGORY2', 'Delete Responses');
define('_MLDOCS_CATEGORY3', 'Delete Archives');
define('_MLDOCS_CATEGORY4', 'Log Users\' Archives');
define('_MLDOCS_CATEGORY5', 'Modify Responses');
define('_MLDOCS_CATEGORY6', 'Modify Archive Information');

define('_MLDOCS_SEC_ARCHIVE_ADD', 0);
define('_MLDOCS_SEC_ARCHIVE_EDIT', 1);
define('_MLDOCS_SEC_ARCHIVE_DELETE', 2);
define('_MLDOCS_SEC_ARCHIVE_OWNERSHIP', 3);
define('_MLDOCS_SEC_ARCHIVE_STATUS', 4);
define('_MLDOCS_SEC_ARCHIVE_PRIORITY', 5);
define('_MLDOCS_SEC_ARCHIVE_LOGUSER', 6);
define('_MLDOCS_SEC_RESPONSE_ADD', 7);
define('_MLDOCS_SEC_RESPONSE_EDIT', 8);
define('_MLDOCS_SEC_ARCHIVE_MERGE', 9);
define('_MLDOCS_SEC_FILE_DELETE', 10);

define('_MLDOCS_SEC_TEXT_ARCHIVE_ADD', 'Add Archives');
define('_MLDOCS_SEC_TEXT_ARCHIVE_EDIT', 'Modify Archives');
define('_MLDOCS_SEC_TEXT_ARCHIVE_DELETE', 'Delete Archives');
define('_MLDOCS_SEC_TEXT_ARCHIVE_OWNERSHIP', 'Change Archive Ownership');
define('_MLDOCS_SEC_TEXT_ARCHIVE_STATUS', 'Change Archive Status');
define('_MLDOCS_SEC_TEXT_ARCHIVE_PRIORITY', 'Change Archive Priority');
define('_MLDOCS_SEC_TEXT_ARCHIVE_LOGUSER', 'Log Archive for User');
define('_MLDOCS_SEC_TEXT_RESPONSE_ADD', 'Add Response');
define('_MLDOCS_SEC_TEXT_RESPONSE_EDIT', 'Modify Response');
define('_MLDOCS_SEC_TEXT_ARCHIVE_MERGE', 'Merge Archives');
define('_MLDOCS_SEC_TEXT_FILE_DELETE', 'Delete File Attachments');

define('_MLDOCS_JSC_TEXT_DELETE', 'Are you sure you want to delete this archive?');

define('_MLDOCS_MESSAGE_ADD_DEPT', 'Department added successfully');
define('_MLDOCS_MESSAGE_ADD_DEPT_ERROR', 'Error: department was not added');
define('_MLDOCS_MESSAGE_UPDATE_DEPT', 'Department successfully updated');
define('_MLDOCS_MESSAGE_UPDATE_DEPT_ERROR', 'Error: department was not updated');
define('_MLDOCS_MESSAGE_DEPT_DELETE', 'Department was successfully deleted');
define('_MLDOCS_MESSAGE_DEPT_DELETE_ERROR', 'Error: department was not deleted');
define('_MLDOCS_MESSAGE_ADDSTAFF_ERROR', 'Error: staff member was not added');
define('_MLDOCS_MESSAGE_ADDSTAFF', 'Staff member was successfully added');
define('_MLDOCS_MESSAGE_STAFF_DELETE', 'Staff member was successfully deleted');
define('_MLDOCS_MESSAGE_STAFF_DELETE_ERROR', 'Staff member was not deleted');
define('_MLDOCS_MESSAGE_EDITSTAFF', 'Staff member profile was successfully updated');
define('_MLDOCS_MESSAGE_EDITSTAFF_ERROR', 'Error: staff member was not updated');
define('_MLDOCS_MESSAGE_EDITSTAFF_NOCLEAR_ERROR', 'Error: old departments not removed');
define('_MLDOCS_MESSAGE_DEPT_EXISTS', 'Department already exists');
define('_MLDOCS_MESSAGE_ADDARCHIVE', 'Archive was successfully logged');
define('_MLDOCS_MESSAGE_ADDARCHIVE_ERROR', 'Error: archive was not logged');
define('_MLDOCS_MESSAGE_LOGMESSAGE_ERROR', 'Error: action was not logged to database');
define('_MLDOCS_MESSAGE_UPDATE_PRIORITY', 'Archive priority updated successfully');
define('_MLDOCS_MESSAGE_UPDATE_PRIORITY_ERROR', 'Error: archive priority was not updated');
define('_MLDOCS_MESSAGE_UPDATE_STATUS', 'Archive status updated successfully');
define('_MLDOCS_MESSAGE_UPDATE_STATUS_ERROR', 'Error: archive status was not updated');
define('_MLDOCS_MESSAGE_UPDATE_DEPARTMENT', 'Archive department updated successfully');
define('_MLDOCS_MESSAGE_UPDATE_DEPARTMENT_ERROR', 'Error: Archive department was not updated');
define('_MLDOCS_MESSAGE_CLAIM_OWNER', 'You have claimed the ownership of the archive');
define('_MLDOCS_MESSAGE_CLAIM_OWNER_ERROR', 'Error: archive ownership was not claimed');
define('_MLDOCS_MESSAGE_ASSIGN_OWNER', 'You have successfully assigned the ownership');
define('_MLDOCS_MESSAGE_ASSIGN_OWNER_ERROR', 'Error: archive ownership was not assigned');
define('_MLDOCS_MESSAGE_UPDATE_OWNER', 'You have successfully updated the ownership of the archive.');
define('_MLDOCS_MESSAGE_ADDFILE', 'File uploaded successfully');
define('_MLDOCS_MESSAGE_ADDFILE_ERROR', 'Error: file was not uploaded');
define('_MLDOCS_MESSAGE_ADDRESPONSE', 'Response added successfully');
define('_MLDOCS_MESSAGE_ADDRESPONSE_ERROR', 'Error: response was not added');
define('_MLDOCS_MESSAGE_UPDATE_CALLS_CLOSED_ERROR', 'Error: callsClosed field not updated');
define('_MLDOCS_MESSAGE_ALREADY_OWNER', '%s is already the owner of this archive');
define('_MLDOCS_MESSAGE_ALREADY_STATUS', 'Archive is already set to this status');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVE', 'Archive deleted successfully');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVE_ERROR', 'Error: archive was not deleted');
define('_MLDOCS_MESSAGE_ADD_SIGNATURE', 'Signature added successfully');
define('_MLDOCS_MESSAGE_ADD_SIGNATURE_ERROR', 'Error: signature not updated');
define('_MLDOCS_MESSAGE_RESPONSE_TPL', 'Pre-Defined responses updated successfully');
define('_MLDOCS_MESSAGE_RESPONSE_TPL_ERROR', 'Error: responses not updated');
define('_MLDOCS_MESSAGE_DELETE_RESPONSE_TPL', 'Pre-Defined response deleted successfully');
define('_MLDOCS_MESSAGE_DELETE_RESPONSE_TPL_ERROR', 'Error: Pre-Defined response not deleted');
define('_MLDOCS_MESSAGE_ADD_STAFFREVIEW', 'Review successfully added');
define('_MLDOCS_MESSAGE_ADD_STAFFREVIEW_ERROR', 'Error: review was not added');
define('_MLDOCS_MESSAGE_UPDATE_STAFF_ERROR', 'Error: staff member info not updated');
define('_MLDOCS_MESSAGE_UPDATE_SIG_ERROR', 'Error: signature not updated');
define('_MLDOCS_MESSAGE_UPDATE_SIG', 'Signature updated');
define('_MLDOCS_MESSAGE_EDITARCHIVE', 'Archive updated');
define('_MLDOCS_MESSAGE_EDITARCHIVE_ERROR', 'Error: archive not updated');
define('_MLDOCS_MESSAGE_USER_MOREINFO', 'Archive updated successfully.');
define('_MLDOCS_MESSAGE_USER_MOREINFO_ERROR', 'Error: information was not added');
define('_MLDOCS_MESSAGE_USER_NO_INFO', 'Error: you did not submit any new information');
define('_MLDOCS_MESSAGE_EDITRESPONSE', 'Response successfully updated');
define('_MLDOCS_MESSAGE_EDITRESPONSE_ERROR', 'Error: response not updated');
define('_MLDOCS_MESSAGE_NOTIFY_UPDATE', 'Notifications successfully updated');
define('_MLDOCS_MESSAGE_NOTIFY_UPDATE_ERROR', 'Notifications were not updated');
define('_MLDOCS_MESSAGE_NO_NOTIFICATIONS', 'User had no notifications');
define('_MLDOCS_MESSAGE_NO_DEPTS', 'Error: no departments set up. Contact administrator.');
define('_MLDOCS_MESSAGE_NO_STAFF', 'Error: no staff members set up. Contact administrator.');
define('_MLDOCS_MESSAGE_ARCHIVE_REOPEN', 'Archive re-opened successfully.');
define('_MLDOCS_MESSAGE_ARCHIVE_REOPEN_ERROR', 'Error: archive was not re-opened.');
define('_MLDOCS_MESSAGE_ARCHIVE_CLOSE', 'Archive closed successfully.');
define('_MLDOCS_MESSAGE_ARCHIVE_CLOSE_ERROR', 'Error: archive was not closed.');
define('_MLDOCS_MESSAGE_NOT_USER', 'Error: you cannot make changes to this archive.');
define('_MLDOCS_MESSAGE_NO_ARCHIVES', 'Error: No Archives selected.');
define('_MLDOCS_MESSAGE_NOOWNER', 'No owner');
define('_MLDOCS_MESSAGE_UNKNOWN', 'Unknown');
define('_MLDOCS_MESSAGE_WRONG_MIMETYPE', 'Error: filetype is not allowed. Please re-submit.');
define('_MLDOCS_MESSAGE_NO_UID', 'Error: no uid specified');
define('_MLDOCS_MESSAGE_NO_PRIORITY', 'Error: no priority specified');
define('_MLDOCS_MESSAGE_FILE_ERROR', 'Error: Unable to store uploaded file for the following reasons:<br />%s');
define('_MLDOCS_MESSAGE_UPDATE_EMAIL_ERROR', 'Error: email was not updated');
define('_MLDOCS_MESSAGE_ARCHIVE_DELETE_CNFRM', 'Are you sure you want to delete these archives?');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVES', 'Archives deleted successfully');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVES_ERROR', 'Error: archives were not deleted');
define('_MLDOCS_MESSAGE_VALIDATE_ERROR', 'Your archive has errors, please correct and submit again.');
define('_MLDOCS_MESSAGE_UNAME_TAKEN', ' is already in use.');
define('_MLDOCS_MESSAGE_INVALID', ' is invalid.');
define('_MLDOCS_MESSAGE_REQUIRED', ' is required.');
define('_MLDOCS_MESSAGE_LONG', ' is too long.');
define('_MLDOCS_MESSAGE_SHORT', ' is too short.');
define('_MLDOCS_MESSAGE_NOT_ENTERED', ' was not entered.');
define('_MLDOCS_MESSAGE_NOT_NUMERIC', ' is not numeric.');
define('_MLDOCS_MESSAGE_RESERVED', ' is reserved.');
define('_MLDOCS_MESSAGE_NO_SPACES', ' should not have spaces');
define('_MLDOCS_MESSAGE_NOT_SAME', ' is not the same.');
define('_MLDOCS_MESSAGE_NOT_SUPPLIED', ' is not supplied.');
define('_MLDOCS_MESSAGE_CREATE_USER_ERROR', 'User not created');
define('_MLDOCS_MESSAGE_NO_REGISTER', 'Please login to your account to submit a archive.');
define('_MLDOCS_MESSAGE_NEW_USER_ERR', 'Error: your user account was not created.');
define('_MLDOCS_MESSAGE_EMAIL_USED', 'Error: email has already been registered.');
define('_MLDOCS_MESSAGE_DELETE_FILE_ERR', 'Error: file was not deleted.');
define('_MLDOCS_MESSAGE_DELETE_SEARCH_ERR', 'Error: search was not deleted.');

define('_MLDOCS_MESSAGE_UPLOAD_ALLOWED_ERR', 'Error: file uploading is disabled for the module.');
define('_MLDOCS_MESSAGE_UPLOAD_ERR', 'File %s from %s was not stored because %s.');

define('_MLDOCS_MESSAGE_NO_ADD_ARCHIVE', 'You do not have permission to log archives.');
define('_MLDOCS_MESSAGE_NO_DELETE_ARCHIVE', 'You do not have permission to delete archives.');
define('_MLDOCS_MESSAGE_NO_EDIT_ARCHIVE', 'You do not have permission to edit archives.');
define('_MLDOCS_MESSAGE_NO_CHANGE_OWNER', 'You do not have permission to change the ownership.');
define('_MLDOCS_MESSAGE_NO_CHANGE_PRIORITY', 'You do not have permission to change the priority.');
define('_MLDOCS_MESSAGE_NO_CHANGE_STATUS', 'You do not have permission to change the status.');
define('_MLDOCS_MESSAGE_NO_ADD_RESPONSE', 'You do not have permission to add responses.');
define('_MLDOCS_MESSAGE_NO_EDIT_RESPONSE', 'You do not have permission to edit responses.');
define('_MLDOCS_MESSAGE_NO_MERGE', 'You do not have permission to merge archives.');
define('_MLDOCS_MESSAGE_NO_ARCHIVE2', 'Error: you did not specify a archive to merge with.');
define('_MLDOCS_MESSAGE_ADDED_EMAIL', 'Email added successfully.');
define('_MLDOCS_MESSAGE_ADDED_EMAIL_ERROR', 'Error: email was not added.');
define('_MLDOCS_MESSAGE_NO_EMAIL', 'Error: you did not specify an email to add.');
define('_MLDOCS_MESSAGE_ADD_EMAIL', 'Email notification was updated.');
define('_MLDOCS_MESSAGE_ADD_EMAIL_ERROR', 'Error: email was not updated.');
define('_MLDOCS_MESSAGE_NO_MERGE_ARCHIVE', 'You do not have permission to suppress an email.');
define('_MLDOCS_MESSAGE_NO_FILE_DELETE', 'You do not have permission to delete files.');
define('_MLDOCS_MESSAGE_NO_CUSTFLD_ADDED', 'Error: custom field values were not saved.');

define('_MLDOCS_ERROR_INV_ARCHIVE', 'Error: Invalid archive specified.  Please check the archive and try again!');
define('_MLDOCS_ERROR_INV_RESPONSE', 'Error: Invalid response specified. Please check the response and try again!');
define('_MLDOCS_ERROR_NODEPTPERM', 'You cannot submit a response on this archive. Reason: Not a staff member of this department.');
define('_MLDOCS_ERROR_INV_STAFF', 'Error: User is not a staff member.');
define('_MLDOCS_ERROR_INV_TEMPLATE', 'Error: Fill in both the template name and text before submitting');
define('_MLDOCS_ERROR_INV_USER', 'Error: you do not have permission to view this archive.');

define('_MLDOCS_TITLE_ADDARCHIVE', 'Log Archive');
define('_MLDOCS_TITLE_ADDRESPONSE', 'Add Response');
define('_MLDOCS_TITLE_EDITARCHIVE', 'Edit Archive Info');
define('_MLDOCS_TITLE_EDITRESPONSE', 'Edit Response');
define('_MLDOCS_TITLE_SEARCH', 'Search');

define('_MLDOCS_TEXT_SIZE', 'Size:');
define('_MLDOCS_TEXT_REALNAME', 'Real Name');
define('_MLDOCS_TEXT_ID', 'ID:');
define('_MLDOCS_TEXT_NAME', 'Username:');
define('_MLDOCS_TEXT_USER', 'User:');
define('_MLDOCS_TEXT_USERID', 'User ID:');
define('_MLDOCS_TEXT_LOOKUP', 'Lookup');
define('_MLDOCS_TEXT_LOOKUP_USER', 'Lookup User');
define('_MLDOCS_TEXT_EMAIL', 'Email:');
define('_MLDOCS_TEXT_ASSIGNTO', 'Assign To:');
define('_MLDOCS_TEXT_PRIORITY', 'Priority:');
define('_MLDOCS_TEXT_STATUS', 'Status:');
define('_MLDOCS_TEXT_SUBJECT', 'Subject:');
define('_MLDOCS_TEXT_DEPARTMENT', 'Department:');
define('_MLDOCS_TEXT_OWNER', 'Owner:');
define('_MLDOCS_TEXT_CLOSEDBY', 'Closed By:');
define('_MLDOCS_TEXT_NOTAPPLY', 'N/A');
define('_MLDOCS_TEXT_TIMESPENT', 'Time Spent:');
define('_MLDOCS_TEXT_DESCRIPTION', 'Description:');
define('_MLDOCS_TEXT_ADDFILE', 'Add File:');
define('_MLDOCS_TEXT_FILE', 'File:');
define('_MLDOCS_TEXT_RESPONSE', 'Response');
define('_MLDOCS_TEXT_RESPONSES', 'Responses');
define('_MLDOCS_TEXT_CLAIMOWNER', 'Claim Ownership:');
define('_MLDOCS_TEXT_CLAIM_OWNER', 'Claim Ownership');
define('_MLDOCS_TEXT_ARCHIVEDETAILS', 'Archive #%u Details');
define('_MLDOCS_TEXT_MINUTES', 'minutes');
define('_MLDOCS_TEXT_SEARCH', 'Search:');
define('_MLDOCS_TEXT_SEARCHBY', 'By:');
define('_MLDOCS_SEARCH_DESC', 'Description');
define('_MLDOCS_SEARCH_SUBJECT', 'Subject');
define('_MLDOCS_TEXT_NUMRESULTS', 'Number of Results Per Page:');
define('_MLDOCS_TEXT_RESULT1', '5');
define('_MLDOCS_TEXT_RESULT2', '10');
define('_MLDOCS_TEXT_RESULT3', '25');
define('_MLDOCS_TEXT_RESULT4', '50');
define('_MLDOCS_TEXT_SEARCH_RESULTS', 'Search Results');
define('_MLDOCS_TEXT_PREDEFINED_RESPONSES', 'Pre-Defined Responses:');
define('_MLDOCS_TEXT_PREDEFINED0', '-- Create Response --');
define('_MLDOCS_TEXT_NO_USERS', 'No users found');
define('_MLDOCS_TEXT_SEARCH_AGAIN', 'Search Again');
define('_MLDOCS_TEXT_LOGGED_BY', 'Logged By:');
define('_MLDOCS_TEXT_LOG_TIME', 'Log Time:');
define('_MLDOCS_TEXT_OWNERSHIP_DETAILS', 'Ownership Details');
define('_MLDOCS_TEXT_ACTIVITY_LOG', 'Activity Log');
define('_MLDOCS_TEXT_HELPDESK_ARCHIVE', 'Helpdesk Archive:');
define('_MLDOCS_TEXT_YES', 'Yes');
define('_MLDOCS_TEXT_NO', 'No');
define('_MLDOCS_TEXT_ALL_ARCHIVES', 'All Archives');
define('_MLDOCS_TEXT_HIGH_PRIORITY', 'Highest Priority Unassigned Archives');
define('_MLDOCS_TEXT_NEW_ARCHIVES', 'New Archives');
define('_MLDOCS_TEXT_MY_ARCHIVES', 'Open Archives Assigned to Me');
define('_MLDOCS_TEXT_SUBMITTED_ARCHIVES', 'My Submitted Archives');
define('_MLDOCS_TEXT_ANNOUNCEMENTS', 'Announcements');
define('_MLDOCS_TEXT_MY_PERFORMANCE', 'My Performance');
define('_MLDOCS_TEXT_RESPONSE_TIME', 'Average Response Time:');
define('_MLDOCS_TEXT_RATING', 'Rating:');
define('_MLDOCS_TEXT_NUMREVIEWS', 'Number of Reviews:');
define('_MLDOCS_TEXT_NUM_ARCHIVES_CLOSED', 'Number of Archives Closed:');
define('_MLDOCS_TEXT_TEMPLATE_NAME', 'Template Name:');
define('_MLDOCS_TEXT_MESSAGE', 'Message:');
define('_MLDOCS_TEXT_ACTIONS', 'Actions:');
define('_MLDOCS_TEXT_ACTIONS2', 'Actions');
define('_MLDOCS_TEXT_MY_NOTIFICATIONS', 'My Notifications');
define('_MLDOCS_TEXT_SELECT_ALL', 'Select All');
define('_MLDOCS_TEXT_USER_IP', 'User IP:');
define('_MLDOCS_TEXT_OWNERSHIP', 'Ownership');
define('_MLDOCS_TEXT_ASSIGN_OWNER', 'Assign Ownership');
define('_MLDOCS_TEXT_ARCHIVE', 'Archive');
define('_MLDOCS_TEXT_USER_RATING', 'User Rating:');
define('_MLDOCS_TEXT_EDIT_RESPONSE', 'Edit Response');
define('_MLDOCS_TEXT_FILE_ADDED', 'File Added:');
define('_MLDOCS_TEXT_ACTION', 'Action:');
define('_MLDOCS_TEXT_LAST_ARCHIVES', 'Last Submitted Archives from:');
define('_MLDOCS_TEXT_RATE_STAFF', 'Rate Staff Response');
define('_MLDOCS_TEXT_COMMENTS', 'Comments:');
define('_MLDOCS_TEXT_MY_OPEN_ARCHIVES', 'My Open Archives');
define('_MLDOCS_TEXT_RATE_RESPONSE', 'Rate Response?');
define('_MLDOCS_TEXT_RESPONSE_RATING', 'Response Rating:');
define('_MLDOCS_TEXT_REOPEN_ARCHIVE', 'Re-open Archive?');
define('_MLDOCS_TEXT_MORE_INFO', 'More Info Required?');
define('_MLDOCS_TEXT_REOPEN_REASON', 'Reason for re-opening (optional)');
define('_MLDOCS_TEXT_MORE_INFO2', 'Need to add more information to the archive? Fill it in here!');
define('_MLDOCS_TEXT_NO_DEPT', 'No Department');
define('_MLDOCS_TEXT_NOT_EMAIL', 'Email Address:');
define('_MLDOCS_TEXT_LAST_REVIEWS', 'Latest Staff Reviews:');
define('_MLDOCS_TEXT_SORT_ARCHIVES', 'Sort archives by this column');
define('_MLDOCS_TEXT_ELAPSED', 'Elapsed:');
define('_MLDOCS_TEXT_FILTERARCHIVES', 'Filter Archives:');
define('_MLDOCS_TEXT_LIMIT', 'Records per page');
define('_MLDOCS_TEXT_SUBMITTEDBY', 'Submitted By:');
define('_MLDOCS_TEXT_NO_INCLUDE', 'ANY');
define('_MLDOCS_TEXT_PRIVATE_RESPONSE', 'Private Response:');
define('_MLDOCS_TEXT_PRIVATE', 'Private');
define('_MLDOCS_TEXT_CLOSE_ARCHIVE', 'Close Archive?');
define('_MLDOCS_TEXT_ADD_SIGNATURE', 'Add signature to responses?');
define('_MLDOCS_TEXT_LASTUPDATE', 'Last Update:');
define('_MLDOCS_TEXT_BATCH_ACTIONS', 'Batch Actions:');
define('_MLDOCS_TEXT_BATCH_DEPARTMENT', 'Change Department');
define('_MLDOCS_TEXT_BATCH_PRIORITY', 'Change Priority');
define('_MLDOCS_TEXT_BATCH_STATUS', 'Change Status');
define('_MLDOCS_TEXT_BATCH_DELETE', 'Delete Archives');
define('_MLDOCS_TEXT_BATCH_RESPONSE', 'Respond');
define('_MLDOCS_TEXT_BATCH_OWNERSHIP', 'Take/Assign Ownership');
define('_MLDOCS_TEXT_UPDATE_COMP', 'Update Complete!');
define('_MLDOCS_TEXT_TOPICS_ADDED', 'Topics Added');
define('_MLDOCS_TEXT_DEPTS_ADDED', 'Departments Added');
define('_MLDOCS_TEXT_CLOSE_WINDOW', 'Close Window');
define('_MLDOCS_TEXT_USER_LOOKUP', 'User Lookup');
define('_MLDOCS_TEXT_EVENT', 'Event');
define('_MLDOCS_TEXT_AVAIL_FILETYPES', 'Available Filetypes');
define('_MLDOCS_TEXT_AVAIL_BANNETTE', ' File(s) in the bagg');
define('_MLDOCS_USER_REGISTER', 'User Registration');

define('_MLDOCS_TEXT_SETDEPT', 'Choose a department:');
define('_MLDOCS_TEXT_SETPRIORITY', 'Set the archive priority:');
define('_MLDOCS_TEXT_SETOWNER', 'Choose an owner:');
define('_MLDOCS_TEXT_SETSTATUS', 'Set the archive status:');
define('_MLDOCS_TEXT_MERGE_ARCHIVE', 'Merge Archives');
define('_MLDOCS_TEXT_MERGE_TITLE', 'Enter the archive ID you want to merge with.');
define('_MLDOCS_TEXT_EMAIL_NOTIFICATION', 'Email Notification:');
define('_MLDOCS_TEXT_EMAIL_NOTIFICATION_TITLE', 'Add an email address to be notified of archive updates.');
define('_MLDOCS_TEXT_RECEIVE_NOTIFICATIONS', 'Receive Notifications:');
define('_MLDOCS_TEXT_EMAIL_SUPPRESS', 'Emails are suppressed. Click to send email notifications.');
define('_MLDOCS_TEXT_EMAIL_NOT_SUPPRESS', 'Emails are being sent. Click to suppress.');
define('_MLDOCS_TEXT_ARCHIVE_NOTIFICATIONS', 'Archive Notifications');
define('_MLDOCS_TEXT_STATE', 'State:');
define('_MLDOCS_TEXT_BY_STATUS', 'By Status:');
define('_MLDOCS_TEXT_BY_STATE', 'By State:');
define('_MLDOCS_TEXT_SEARCH_OR', '-- OR --');
define('_MLDOCS_TEXT_VIEW1', 'Basic View');
define('_MLDOCS_TEXT_VIEW2', 'Advanced View');
define('_MLDOCS_TEXT_SAVE_SEARCH', 'Save Search?');
define('_MLDOCS_TEXT_SEARCH_NAME', 'Search Name:');
define('_MLDOCS_TEXT_SAVED_SEARCHES', 'Previously Saved Searches');
define('_MLDOCS_TEXT_SWITCH_TO', 'Switch To ');
define('_MLDOCS_TEXT_ADDITIONAL_INFO', 'Additional Information');

define('_MLDOCS_ROLE_NAME1', 'Archive Manager');
define('_MLDOCS_ROLE_NAME2', 'Support');
define('_MLDOCS_ROLE_NAME3', 'Browser');
define('_MLDOCS_ROLE_DSC1', 'Can do anything and everything');
define('_MLDOCS_ROLE_DSC2', 'Log archives and responses, change status and priority, and log archives for a user');
define('_MLDOCS_ROLE_DSC3', 'Can make no changes');
define('_MLDOCS_ROLE_VAL1', 2047);
define('_MLDOCS_ROLE_VAL2', 241);
define('_MLDOCS_ROLE_VAL3', 0);



// Archive.php - Actions
define('_MLDOCS_TEXT_SELECTED', 'With Selected:');
define('_MLDOCS_TEXT_ADD_RESPONSE', 'Add Response');
define('_MLDOCS_TEXT_EDIT_ARCHIVE', 'Edit Archive');
define('_MLDOCS_TEXT_DELETE_ARCHIVE', 'Delete Archive');
define('_MLDOCS_TEXT_PRINT_ARCHIVE', 'Print Archive');
define('_MLDOCS_TEXT_UPDATE_PRIORITY', 'Update Priority');
define('_MLDOCS_TEXT_UPDATE_STATUS', 'Update Status');

define('_MLDOCS_PIC_ALT_USER_AVATAR', 'User Avatar');

// Index.php - Auto Refresh Page vars
define('_MLDOCS_TEXT_AUTO_REFRESH0', 'No Auto Refresh');
define('_MLDOCS_TEXT_AUTO_REFRESH1', 'Auto Refresh Every 1 minute');
define('_MLDOCS_TEXT_AUTO_REFRESH2', 'Auto Refresh Every 5 minutes');
define('_MLDOCS_TEXT_AUTO_REFRESH3', 'Auto Refresh Every 10 minutes');
define('_MLDOCS_TEXT_AUTO_REFRESH4', 'Auto Refresh Every 30 minutes');
define('_MLDOCS_AUTO_REFRESH0', 0);          // Change these to
define('_MLDOCS_AUTO_REFRESH1', 60);         // adjust the values 
define('_MLDOCS_AUTO_REFRESH2', 300);        // in the select box
define('_MLDOCS_AUTO_REFRESH3', 600);
define('_MLDOCS_AUTO_REFRESH4', 1800);

define('_MLDOCS_MENU_MAIN', 'Summary');
define('_MLDOCS_MENU_LOG_ARCHIVE', 'Log Archive');
define('_MLDOCS_MENU_MY_PROFILE', 'My Profile');
define('_MLDOCS_MENU_ALL_ARCHIVES', 'View All Archives');
define('_MLDOCS_MENU_SEARCH', 'Search');

define('_MLDOCS_SEARCH_EMAIL', 'Email');
define('_MLDOCS_SEARCH_USERNAME', 'Username');
define('_MLDOCS_SEARCH_UID', 'User ID');

define('_MLDOCS_BUTTON_ADDRESPONSE', 'Add Response');
define('_MLDOCS_BUTTON_ADDARCHIVE', 'Log Archive');
define('_MLDOCS_BUTTON_EDITARCHIVE', 'Edit Archive');
define('_MLDOCS_BUTTON_RESET', 'Reset');
define('_MLDOCS_BUTTON_EDITRESPONSE', 'Update Response');
define('_MLDOCS_BUTTON_SEARCH', 'Search');
define('_MLDOCS_BUTTON_LOG_USER', 'Log For User');
define('_MLDOCS_BUTTON_FIND_USER', 'Find User');
define('_MLDOCS_BUTTON_SUBMIT', 'Submit');
define('_MLDOCS_BUTTON_DELETE', 'Delete');
define('_MLDOCS_BUTTON_UPDATE', 'Update');
define('_MLDOCS_BUTTON_UPDATE_PRIORITY', 'Update Priority');
define('_MLDOCS_BUTTON_UPDATE_STATUS', 'Update Status');
define('_MLDOCS_BUTTON_ADD_INFO', 'Add Info');
define('_MLDOCS_BUTTON_SET', 'Set');
define('_MLDOCS_BUTTON_ADD_EMAIL', 'Add Email');
define('_MLDOCS_BUTTON_RUN', 'Run');

define('_MLDOCS_PRIORITY1', 1);
define('_MLDOCS_PRIORITY2', 2);
define('_MLDOCS_PRIORITY3', 3);
define('_MLDOCS_PRIORITY4', 4);
define('_MLDOCS_PRIORITY5', 5);

define('_MLDOCS_TEXT_PRIORITY1', 'High');
define('_MLDOCS_TEXT_PRIORITY2', 'Medium-High');
define('_MLDOCS_TEXT_PRIORITY3', 'Medium');
define('_MLDOCS_TEXT_PRIORITY4', 'Medium-Low');
define('_MLDOCS_TEXT_PRIORITY5', 'Low');

define('_MLDOCS_STATUS0', 'Open');
define('_MLDOCS_STATUS1', 'Hold');
define('_MLDOCS_STATUS2', 'Closed');

define('_MLDOCS_STATE1', 'Unresolved');
define('_MLDOCS_STATE2', 'Resolved');
define('_MLDOCS_NUM_STATE1', 1);
define('_MLDOCS_NUM_STATE2', 2);

define('_MLDOCS_RATING0', 'No rating');
define('_MLDOCS_RATING1', 'Poor');
define('_MLDOCS_RATING2', 'Below Average');
define('_MLDOCS_RATING3', 'Average');
define('_MLDOCS_RATING4', 'Above Average');
define('_MLDOCS_RATING5', 'Excellent');

// Log Messages
define('_MLDOCS_LOG_ADDARCHIVE', 'Archive logged');
define('_MLDOCS_LOG_ADDARCHIVE_FORUSER', 'Archive logged for %s by %s');
define('_MLDOCS_LOG_EDITARCHIVE', 'Archive information edited');
define('_MLDOCS_LOG_UPDATE_PRIORITY', 'Priority updated from pri:%u to pri:%u');
define('_MLDOCS_LOG_UPDATE_STATUS', 'Status updated from %s to %s');
define('_MLDOCS_LOG_CLAIM_OWNERSHIP', 'Claimed ownership');
define('_MLDOCS_LOG_ASSIGN_OWNERSHIP', 'Assigned ownership to %s');
define('_MLDOCS_LOG_ADDRESPONSE', 'Response added');
define('_MLDOCS_LOG_USER_MOREINFO', 'Added more information');
define('_MLDOCS_LOG_EDIT_RESPONSE', 'Response # %s edited');
define('_MLDOCS_LOG_REOPEN_ARCHIVE', 'Archive re-opened');
define('_MLDOCS_LOG_CLOSE_ARCHIVE', 'Archive closed');
define('_MLDOCS_LOG_ADDRATING', 'Rated Response %u');
define('_MLDOCS_LOG_SETDEPT', 'Assigned to %s department');
define('_MLDOCS_LOG_MERGEARCHIVES', 'Merged archive %s to %s');
define('_MLDOCS_LOG_DELETEFILE', 'File %s deleted');

// Error checking for no records in DB
define('_MLDOCS_NO_ARCHIVES_ERROR', 'No archives found');
define('_MLDOCS_NO_RESPONSES_ERROR', 'No responses found');
define('_MLDOCS_NO_MAILBOX_ERROR', 'Invalid Mailbox Specified');
define('_MLDOCS_NO_FILES_ERROR', 'No files found');

define('_MLDOCS_SIG_SPACER', '<br /><br />-------------------------------<br />');
define('_MLDOCS_COMMMENTS', 'Comments?');
define("_MLDOCS_ANNOUNCE_READMORE","Read More...");
define("_MLDOCS_ANNOUNCE_ONECOMMENT","1 comment");
define("_MLDOCS_ANNOUNCE_NUMCOMMENTS","%s comments");
define("_MLDOCS_ARCHIVE_MD5SIGNATURE", "Support Key:");


define('_MLDOCS_NO_OWNER', 'No Owner');
define('_MLDOCS_RESPONSE_EDIT', 'Response modified by %s on %s');

define('_MLDOCS_TIME_SECS', 'seconds');
define('_MLDOCS_TIME_MINS', 'minutes');
define('_MLDOCS_TIME_HOURS', 'hours');
define('_MLDOCS_TIME_DAYS', 'days');
define('_MLDOCS_TIME_WEEKS', 'weeks');
define('_MLDOCS_TIME_YEARS', 'years');

define('_MLDOCS_TIME_SEC', 'second');
define('_MLDOCS_TIME_MIN', 'minute');
define('_MLDOCS_TIME_HOUR', 'hour');
define('_MLDOCS_TIME_DAY', 'day');
define('_MLDOCS_TIME_WEEK', 'week');
define('_MLDOCS_TIME_YEAR', 'year');

define('_MLDOCS_MAILEVENT_CLASS0', 0);     // Connection message
define('_MLDOCS_MAILEVENT_CLASS1', 1);     // Parse message
define('_MLDOCS_MAILEVENT_CLASS2', 2);     // Storage message
define('_MLDOCS_MAILEVENT_CLASS3', 3);     // General message

define('_MLDOCS_MAILEVENT_DESC0', 'Could not connect to server.');
define('_MLDOCS_MAILEVENT_DESC1', 'Could not parse message.');
define('_MLDOCS_MAILEVENT_DESC2', 'Could not store message.');
define('_MLDOCS_MAILEVENT_DESC3', '');
define('_MLDOCS_MBOX_ERR_LOGIN', 'Connection failed to mail server: invalid login/password');
define('_MLDOCS_MBOX_INV_BOXTYPE', 'Specified mailbox type is not supported');

define('_MLDOCS_MAIL_CLASS0', 'Connection');
define('_MLDOCS_MAIL_CLASS1', 'Parsing');
define('_MLDOCS_MAIL_CLASS2', 'Storage');
define('_MLDOCS_MAIL_CLASS3', 'General');

define('_MLDOCS_GROUP_PERM_DEPT', 'mldocs_dept');
define('_MLDOCS_MISMATCH_EMAIL', '%s has been notified that their message was not stored. Support key matched, but message should have been sent from %s instead.');
define('_MLDOCS_MESSAGE_MERGE', 'Merge successfully completed.');
define('_MLDOCS_MESSAGE_MERGE_ERROR', 'Error: merge was not completed.');
define('_MLDOCS_RESPONSE_NO_ARCHIVE', 'No archive found for archive response');
define('_MLDOCS_MESSAGE_NO_ANON', 'Message from %s blocked, anonymous user archive submission disabled');
define('_MLDOCS_MESSAGE_EMAIL_DEPT_MBOX', 'Message from %s blocked, sender is a department mailbox');

define('_MLDOCS_SIZE_BYTES', 'Bytes');
define('_MLDOCS_SIZE_KB', 'KB');
define('_MLDOCS_SIZE_MB', 'MB');
define('_MLDOCS_SIZE_GB', 'GB');
define('_MLDOCS_SIZE_TB', 'TB');

define('_MLDOCS_TEXT_USER_NOT_ACTIVATED', 'User has not finished activation process.');

define('_MLDOCS_TEXT_ADMIN_DISABLED', '<em>[Disabled by Administrator]</em>');

define('_MLDOCS_TEXT_CURRENT_NOTIFICATION', 'Current Notification Method');
define('_MLDOCS_NOTIFY_METHOD1', 'Private Message');
define('_MLDOCS_NOTIFY_METHOD2', 'Email');

define('_MLDOCS_TEXT_ARCHIVE_LISTS', 'Archive Lists');
define('_MLDOCS_TEXT_LIST_NAME', 'List Name');
define('_MLDOCS_TEXT_CREATE_NEW_LIST', 'Create New List');
define('_MLDOCS_TEXT_NO_RECORDS', 'No Records Found');
define('_MLDOCS_TEXT_EDIT', 'Edit');
define('_MLDOCS_TEXT_DELETE', 'Delete');
define('_MLDOCS_TEXT_CREATE_SAVED_SEARCH', 'Create Saved Search');
define('_MLDOCS_MSG_ADD_ARCHIVELIST_ERR', 'Error: archive list was not created.');
define('_MLDOCS_MSG_DEL_ARCHIVELIST_ERR', 'Error: archive list was not deleted.');
define('_MLDOCS_MSG_NO_ID', 'Error: you did not specify an id.');
define('_MLDOCS_TEXT_VIEW_MORE_ARCHIVES', 'View More Archives');
define('_MLDOCS_MSG_NO_EDIT_SEARCH', 'Error: you are not allowed to modify this search.');
define('_MLDOCS_MSG_NO_DEL_SEARCH', 'Error: you are not allowed to delete this search.');

// Trad 20/05/2007    BYOOS solutions  memseb@2007
// bannette add
define("_CT_BANNETTEFORM","Manage bannet form");
define("_CT_THANKYOU","Welcome to our website!");
define("_CT_NAME","Name");
define("_CT_EMAIL","E-mail");
define("_CT_URL","bannet Url Link");
define("_CT_ICQ","bannet visit count");

define('_MLDOCS_SEC_ARCHIVE_ADD', 'Section Archive Add');
define('_MLDOCS_SEC_ARCHIVE_EDIT', 'Section Archive Edit');
define('_MLDOCS_SEC_ARCHIVE_DELETE', 'Section Archive Delete');
define('_MLDOCS_SEC_ARCHIVE_OWNERSHIP', 'Section Archive Ownership');
define('_MLDOCS_SEC_ARCHIVE_STATUS', 'Section Archive Status');
define('_MLDOCS_SEC_ARCHIVE_PRIORITY', 'Section Archive Priority');
define('_MLDOCS_SEC_ARCHIVE_LOGUSER', 'Section Archive Loguser');
define('_MLDOCS_SEC_RESPONSE_ADD', 'Section Response Add');
define('_MLDOCS_SEC_RESPONSE_EDIT', 'Section Response Edit');
define('_MLDOCS_SEC_ARCHIVE_MERGE', 'Section Archive Merge');
define('_MLDOCS_SEC_FILE_DELETE', 'Section File delete');
define('_MLDOCS_MSGTYPE_ARCHIVE', 'Message archive type');
define('_MLDOCS_MSGTYPE_RESPONSE', 'Message response type');
define('_MLDOCS_MAILBOXTYPE_IMAP', 'Imap');
define('_MLDOCS_MAILBOXTYPE_POP3', 'Pop3');
define('_MLDOCS_CONTROL_DESC_TXTBOX', 'Textbox');
define('_MLDOCS_CONTROL_DESC_SELECT', 'Select');
define('_MLDOCS_CONTROL_DESC_RADIOBOX', 'Radiobox');
define('_MLDOCS_CONTROL_DESC_YESNO', 'Yes or No');
define('_MLDOCS_CONTROL_DESC_DATETIME', 'Datetime');
define('_MLDOCS_CONTROL_DESC_FILE', 'File');
define('_MLDOCS_TEXT_CODEARCHIVE', 'Archive code');
define('_MLDOCS_TEXT_USER_LOOKUP', 'User Lookup');

?>
