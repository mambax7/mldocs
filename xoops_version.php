<?php
// $Id: xoops_version.php,v 0.86 2005/07/06 12:00 gabybob MLdocs Exp $
// modification 2009/06/03  gabybob
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//                       <http://www.byoos.fr/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
$modversion['name'] = _MI_MLDOCS_NAME;
$modversion['version'] = '0.91';
$modversion['description'] = _MI_MLDOCS_DESC;
$modversion['author'] = "Gabriel BOBARD";
$modversion['help'] = "not yet";
$modversion['license'] = "COPYRIGHT BYOOS solutions";
$modversion['official'] = 0.91;
$modversion['image'] = "images/mldocs_slogo.png";
$modversion['dirname'] = "mldocs";

// Extra stuff for about page
$modversion['release_date']     = '2010/02/19';
$modversion['version_info']     = 'Stable';
$modversion['creator']          = 'BYOOS solutions';
$modversion['demo_site']        = 'http://www.byoos.fr';
$modversion['official_site']    = 'http://www.byoos.fr';
$modversion['bug_url']          = '';
$modversion['feature_url']      = '';
$modversion['questions_email']  = 'contact@byoos.fr';

// Developers
$modversion['contributors']['developers'][0]['name']        = "Gabriel BOBARD";
$modversion['contributors']['developers'][0]['uname']       = "gabybob";
$modversion['contributors']['developers'][0]['email']       = "contact@byoos.fr";
$modversion['contributors']['developers'][0]['website']     = "http://www.byoos.fr";
$modversion['contributors']['developers'][1]['name']        = "MEMONGO Serge Bruno";
$modversion['contributors']['developers'][1]['uname']       = "memseb";
$modversion['contributors']['developers'][1]['email']       = "memseb2002@yahoo.fr";
$modversion['contributors']['developers'][1]['website']     = "http://mldocs.org";

$modversion['contributors']['developers'][2]['name']        = "";
$modversion['contributors']['developers'][2]['uname']       = "";
$modversion['contributors']['developers'][2]['email']       = "";
$modversion['contributors']['developers'][2]['website']     = "";

// Translators

$modversion['contributors']['translators'][1]['language']   = "French";
$modversion['contributors']['translators'][1]['name']       = "";
$modversion['contributors']['translators'][1]['uname']      = "gabybob";
$modversion['contributors']['translators'][1]['email']      = "contact@byoos.fr";
$modversion['contributors']['translators'][1]['website']    = "";


// Testers
$modversion['contributors']['testers'][0]['name']       = "Gabriel BOBARD";
$modversion['contributors']['testers'][0]['uname']      = "gabybob";
$modversion['contributors']['testers'][0]['email']      = "contact@byoos.fr";
$modversion['contributors']['testers'][0]['website']    = "";

$modversion['contributors']['testers'][1]['name']       = "Serge bruno";
$modversion['contributors']['testers'][1]['uname']      = "memseb";
$modversion['contributors']['testers'][1]['email']      = "memseb2002@yahoo.fr";
$modversion['contributors']['testers'][1]['website']    = "";


// Documenters
$modversion['contributors']['documenters'][0]['name']       = "Gabriel BOBARD";
$modversion['contributors']['documenters'][0]['uname']      = "gabybob";
$modversion['contributors']['documenters'][0]['email']      = "contact@byoos.fr";
$modversion['contributors']['documenters'][0]['website']    = "";

$modversion['contributors']['code'][0]['name']       = "Serge bruno";
$modversion['contributors']['code'][0]['uname']      = "smemseb";
$modversion['contributors']['code'][0]['email']      = "memseb2002@yahoo.fr";
$modversion['contributors']['code'][0]['website']    = "";
/*
$modversion['contributors']['code'][1]['name']       = "";
$modversion['contributors']['code'][1]['uname']      = "";
$modversion['contributors']['code'][1]['email']      = "";
$modversion['contributors']['code'][1]['website']    = "";
*/

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mldocsMysql.sql";
//$modversion['sqlfile']['postgresql'] = "sql/mldocsPgsql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0]    = "mldocs_departments";
$modversion['tables'][1]    = "mldocs_files";
$modversion['tables'][2]    = "mldocs_logmessages";
$modversion['tables'][3]    = "mldocs_responses";
$modversion['tables'][4]    = "mldocs_staff";
$modversion['tables'][5]    = "mldocs_staffreview";
$modversion['tables'][6]    = "mldocs_archives";
$modversion['tables'][7]    = "mldocs_jstaffdept";
$modversion['tables'][8]    = "mldocs_responsetemplates";
$modversion['tables'][9]   = "mldocs_mimetypes";
$modversion['tables'][10]   = 'mldocs_department_mailbox';
$modversion['tables'][11]   = 'mldocs_roles';
$modversion['tables'][12]   = 'mldocs_staffroles';
$modversion['tables'][13]   = "mldocs_meta";
$modversion['tables'][14]   = "mldocs_mailevent";
$modversion['tables'][15]   = "mldocs_archive_submit_emails";
$modversion['tables'][16]   = "mldocs_status";
$modversion['tables'][17]   = "mldocs_saved_searches";
$modversion['tables'][18]   = "mldocs_archive_field_departments";
$modversion['tables'][19]   = "mldocs_notifications";
$modversion['tables'][20]   = "mldocs_archive_fields";
$modversion['tables'][21]   = "mldocs_archive_values";
$modversion['tables'][22]   = "mldocs_archive_lists";


// Tables created by sql file (without prefix!)
$modversion['tables'][23]    = "mldocs_profilelots";
$modversion['tables'][24]   = "mldocs_archive_fieldlots";
$modversion['tables'][25]   = "mldocs_archive_fieldlots_profilelots";




// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Templates
$modversion['templates'][1]['file'] = 'mldocs_staff_header.html';
$modversion['templates'][1]['description'] = _MI_MLDOCS_TEMP_STAFF_HEADER;
$modversion['templates'][2]['file'] = 'mldocs_user_header.html';
$modversion['templates'][2]['description'] = _MI_MLDOCS_TEMP_USER_HEADER;
$modversion['templates'][3]['file'] = 'mldocs_staff_archive_table.html';
$modversion['templates'][3]['description'] = _MI_MLDOCS_TEMP_STAFF_ARCHIVE_TABLE;
$modversion['templates'][4]['file'] = 'mldocs_addArchive.html';
$modversion['templates'][4]['description'] = _MI_MLDOCS_TEMP_ADDARCHIVE;
$modversion['templates'][5]['file'] = 'mldocs_search.html';
$modversion['templates'][5]['description'] = _MI_MLDOCS_TEMP_SEARCH;
$modversion['templates'][6]['file'] = 'mldocs_staff_index.html';
$modversion['templates'][6]['description'] = _MI_MLDOCS_TEMP_STAFF_INDEX;
$modversion['templates'][7]['file'] = 'mldocs_staffReview.html';
$modversion['templates'][7]['description'] = _MI_MLDOCS_TEMP_STAFFREVIEW;
$modversion['templates'][8]['file'] = 'mldocs_staff_profile.html';
$modversion['templates'][8]['description'] = _MI_MLDOCS_TEMP_STAFF_PROFILE;
$modversion['templates'][9]['file'] = 'mldocs_staff_archiveDetails.html';
$modversion['templates'][9]['description'] = _MI_MLDOCS_TEMP_STAFF_ARCHIVEDETAILS;
$modversion['templates'][10]['file'] = 'mldocs_user_index.html';
$modversion['templates'][10]['description'] = _MI_MLDOCS_TEMP_USER_INDEX;
$modversion['templates'][11]['file'] = 'mldocs_user_archiveDetails.html';
$modversion['templates'][11]['description'] = _MI_MLDOCS_TEMP_USER_ARCHIVEDETAILS;
$modversion['templates'][12]['file'] = 'mldocs_response.html';
$modversion['templates'][12]['description'] = _MI_MLDOCS_TEMP_STAFF_RESPONSE;
$modversion['templates'][13]['file'] = 'mldocs_lookup.html';
$modversion['templates'][13]['description'] = _MI_MLDOCS_TEMP_LOOKUP;
$modversion['templates'][14]['file'] = 'mldocs_editArchive.html';
$modversion['templates'][14]['description'] = _MI_MLDOCS_TEMP_EDITARCHIVE;
$modversion['templates'][15]['file'] = 'mldocs_editResponse.html';
$modversion['templates'][15]['description'] = _MI_MLDOCS_TEMP_EDITRESPONSE;
$modversion['templates'][16]['file'] = 'mldocs_announcement.html';
$modversion['templates'][16]['description'] = _MI_MLDOCS_TEMP_ANNOUNCEMENT;
$modversion['templates'][17]['file'] = 'mldocs_print.html';
$modversion['templates'][17]['description'] = _MI_MLDOCS_TEMP_PRINT;
$modversion['templates'][18]['file'] = 'mldocs_staff_viewall.html';
$modversion['templates'][18]['description'] = _MI_MLDOCS_TEMP_STAFF_ALL;
$modversion['templates'][19]['file'] = 'mldocs_setdept.html';
$modversion['templates'][19]['description'] = _MI_MLDOCS_TEMP_SETDEPT;
$modversion['templates'][20]['file'] = 'mldocs_setpriority.html';
$modversion['templates'][20]['description'] = _MI_MLDOCS_TEMP_SETPRIORITY;
$modversion['templates'][21]['file'] = 'mldocs_setowner.html';
$modversion['templates'][21]['description'] = _MI_MLDOCS_TEMP_SETOWNER;
$modversion['templates'][22]['file'] = 'mldocs_setstatus.html';
$modversion['templates'][22]['description'] = _MI_MLDOCS_TEMP_SETSTATUS;
$modversion['templates'][23]['file'] = 'mldocs_deletearchives.html';
$modversion['templates'][23]['description'] = _MI_MLDOCS_TEMP_DELETE;
$modversion['templates'][24]['file'] = 'mldocs_batch_response.html';
$modversion['templates'][24]['description'] = _MI_MLDOCS_TEMP_BATCHRESPONSE;
$modversion['templates'][25]['file'] = 'mldocs_anon_addArchive.html';
$modversion['templates'][25]['description'] = _MI_MLDOCS_TEMP_ANON_ADDARCHIVE;
$modversion['templates'][26]['file'] = 'mldocs_error.html';
$modversion['templates'][26]['description'] = _MI_MLDOCS_TEMP_ERROR;
$modversion['templates'][27]['file'] = 'mldocs_editSearch.html';
$modversion['templates'][27]['description'] = _MI_MLDOCS_TEMP_EDITSEARCH;
$modversion['templates'][28]['file'] = 'mldocs_user_viewall.html';
$modversion['templates'][28]['description'] = _MI_MLDOCS_TEMP_USER_ALL;

// Templates  bannette
$modversion['templates'][29]['file'] = 'mldocs_bannetteform.html';
$modversion['templates'][29]['description'] = 'Affiche le contenu de la bannette';

$modversion['templates'][30]['file'] = 'mldocs_Outilsform.html';
$modversion['templates'][30]['description'] = 'Utilitaires de gestion des archives';

$modversion['templates'][31]['file'] = 'mldocs_Testsform.html';
$modversion['templates'][31]['description'] = 'Application de tests et extentions';

// Blocks 
// Block that displays open archives
$modversion['blocks'][1]['file'] = "mldocs_blocks.php";
$modversion['blocks'][1]['name'] = _MI_MLDOCS_BNAME1;
$modversion['blocks'][1]['description'] = _MI_MLDOCS_BNAME1_DESC;
$modversion['blocks'][1]['show_func'] = "b_mldocs_open_show";
$modversion['blocks'][1]['edit_func'] = "b_mldocs_actions_edit";
$modversion['blocks'][1]['options'] = "19";
$modversion['blocks'][1]['template'] = 'mldocs_block_open.html';

// Block that displays staff performance
$modversion['blocks'][2]['file'] = "mldocs_blocks.php";
$modversion['blocks'][2]['name'] = _MI_MLDOCS_BNAME2;
$modversion['blocks'][2]['description'] = _MI_MLDOCS_BNAME2_DESC;
$modversion['blocks'][2]['show_func'] = "b_mldocs_performance_show";
$modversion['blocks'][2]['template'] = 'mldocs_block_performance.html';

// Block that displays recent archives
$modversion['blocks'][3]['file'] = 'mldocs_blocks.php';
$modversion['blocks'][3]['name'] = _MI_MLDOCS_BNAME3;
$modversion['blocks'][3]['description'] = _MI_MLDOCS_BNAME3_DESC;
$modversion['blocks'][3]['show_func'] = 'b_mldocs_recent_show';
$modversion['blocks'][3]['template'] = 'mldocs_block_recent.html';

// Block that displays recent archives
$modversion['blocks'][4]['file'] = 'mldocs_blocks.php';
$modversion['blocks'][4]['name'] = _MI_MLDOCS_BNAME4;
$modversion['blocks'][4]['description'] = _MI_MLDOCS_BNAME4_DESC;
$modversion['blocks'][4]['show_func'] = 'b_mldocs_actions_show';
$modversion['blocks'][4]['template'] = 'mldocs_block_actions.html';

// Block that displays main actions
$modversion['blocks'][5]['file'] = 'mldocs_blocks.php';
$modversion['blocks'][5]['name'] = _MI_MLDOCS_BNAME5;
$modversion['blocks'][5]['description'] = _MI_MLDOCS_BNAME5_DESC;
$modversion['blocks'][5]['show_func'] = 'b_mldocs_mainactions_show';
$modversion['blocks'][5]['template'] = 'mldocs_block_mainactions.html';
$modversion['blocks'][5]['edit_func'] = 'b_mldocs_mainactions_edit';
$modversion['blocks'][5]['options'] = '0|1';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_MLDOCS_PRODUCT;	// archive par lot
$modversion['sub'][1]['url'] = "addArchive.php";
$modversion['sub'][2]['name'] = _MI_MLDOCS_EXPLORE;	// read user  bannette 
$modversion['sub'][2]['url'] = "explore.php";
$modversion['sub'][3]['name'] = _MI_MLDOCS_BANNETTE;	// read user  bannette 
$modversion['sub'][3]['url'] = "archiveBannette.php";
$modversion['sub'][4]['name'] = _MI_MLDOCS_OUTILS;
$modversion['sub'][4]['url'] = "archiveOutils.php";
//$modversion['sub'][5]['name'] = _MI_MLDOCS_TESTS;
//$modversion['sub'][5]['url'] = "archiveBannette.php";	
// Search
$modversion['hasSearch'] = 0;

// On Install
$modversion['onInstall'] = "install.php";

// Config
$modversion['config'][1]['name'] = 'mldocs_allowUpload';     // Allows users to upload files when adding a archive
$modversion['config'][1]['title'] = '_MI_MLDOCS_ALLOW_UPLOAD';
$modversion['config'][1]['description'] = '_MI_MLDOCS_ALLOW_UPLOAD_DSC';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 1;

$modversion['config'][2]['name'] = 'mldocs_uploadSize';      // Size of file upload allowed
$modversion['config'][2]['title'] = '_MI_MLDOCS_UPLOAD_SIZE';
$modversion['config'][2]['description'] = '_MI_MLDOCS_UPLOAD_SIZE_DSC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'string';
$modversion['config'][2]['default'] = '500000';

$modversion['config'][3]['name'] = 'mldocs_uploadWidth';      // Max width for upload
$modversion['config'][3]['title'] = '_MI_MLDOCS_UPLOAD_WIDTH';
$modversion['config'][3]['description'] = '_MI_MLDOCS_UPLOAD_WIDTH_DSC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'string';
$modversion['config'][3]['default'] = '3000';

$modversion['config'][4]['name'] = 'mldocs_uploadHeight';      // Max height for upload
$modversion['config'][4]['title'] = '_MI_MLDOCS_UPLOAD_HEIGHT';
$modversion['config'][4]['description'] = '_MI_MLDOCS_UPLOAD_HEIGHT_DSC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'string';
$modversion['config'][4]['default'] = '3000';

$modversion['config'][5]['name'] = 'mldocs_numArchiveUploads';      // Number of archive uploads allowed
$modversion['config'][5]['title'] = '_MI_MLDOCS_NUM_ARCHIVE_UPLOADS';
$modversion['config'][5]['description'] = '_MI_MLDOCS_NUM_ARCHIVE_UPLOADS_DSC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'int';
$modversion['config'][5]['default'] = '5';

$modversion['config'][6]['name'] = 'mldocs_allowReopen';     // Allows users to reopen archives
$modversion['config'][6]['title'] = '_MI_MLDOCS_ALLOW_REOPEN';
$modversion['config'][6]['description'] = '_MI_MLDOCS_ALLOW_REOPEN_DSC';
$modversion['config'][6]['formtype'] = 'yesno';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = 1;

$modversion['config'][7]['name'] = 'mldocs_announcements';   // Name of topic for announcments
$modversion['config'][7]['title'] = '_MI_MLDOCS_ANNOUNCEMENTS';
$modversion['config'][7]['description'] = '_MI_MLDOCS_ANNOUNCEMENTS_DSC';
$modversion['config'][7]['formtype'] = 'select';
$modversion['config'][7]['valuetype'] = 'string';
$modversion['config'][7]['default'] = '';

$modversion['config'][8]['name'] = 'mldocs_staffArchiveCount';
$modversion['config'][8]['title'] = '_MI_MLDOCS_STAFF_TC';
$modversion['config'][8]['description'] = '_MI_MLDOCS_STAFF_TC_DSC';
$modversion['config'][8]['formtype'] = 'select';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 10;
$modversion['config'][8]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20);

$modversion['config'][9]['name'] = 'mldocs_staffArchiveAction';
$modversion['config'][9]['title'] = '_MI_MLDOCS_STAFF_ACTIONS';
$modversion['config'][9]['description'] = '_MI_MLDOCS_STAFF_ACTIONS_DSC';
$modversion['config'][9]['formtype'] = 'select';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 1;
$modversion['config'][9]['options'] = array(_MI_MLDOCS_ACTION1 => 1, _MI_MLDOCS_ACTION2 => 2);

$modversion['config'][10]['name'] = 'mldocs_overdueTime';
$modversion['config'][10]['title'] = '_MI_MLDOCS_OVERDUE_TIME';
$modversion['config'][10]['description'] = '_MI_MLDOCS_OVERDUE_TIME_DSC';
$modversion['config'][10]['formtype'] = 'textbox';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = 0;

$modversion['config'][11]['name'] = 'mldocs_allowAnonymous';     // Allows anonymous user submission
$modversion['config'][11]['title'] = '_MI_MLDOCS_ALLOW_ANON';
$modversion['config'][11]['description'] = '_MI_MLDOCS_ALLOW_ANON_DSC';
$modversion['config'][11]['formtype'] = 'yesno';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 0;

$modversion['config'][12]['name'] = 'mldocs_deptVisibility';     // Apply dept visibility to staff members
$modversion['config'][12]['title'] = '_MI_MLDOCS_APPLY_VISIBILITY';
$modversion['config'][12]['description'] = '_MI_MLDOCS_APPLY_VISIBILITY_DSC';
$modversion['config'][12]['formtype'] = 'yesno';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 0;

$modversion['config'][13]['name'] = 'mldocs_displayName';
$modversion['config'][13]['title'] = '_MI_MLDOCS_DISPLAY_NAME';
$modversion['config'][13]['description'] = '_MI_MLDOCS_DISPLAY_NAME_DSC';
$modversion['config'][13]['formtype'] = 'select';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 1;
$modversion['config'][13]['options'] = array(_MI_MLDOCS_USERNAME => 1, _MI_MLDOCS_REALNAME => 2);

$modversion['config'][14]['name'] = 'mldocs_pathBannette';     // config chemin bannette
$modversion['config'][14]['title'] = '_MI_MLDOCS_PATH_BANNETTE';
$modversion['config'][14]['description'] = '_MI_MLDOCS_PATH_BANNETTE_DSC';
$modversion['config'][14]['formtype'] = 'textbox';
$modversion['config'][14]['valuetype'] = 'string';
$modversion['config'][14]['default'] = _MI_MLDOCS_PATH_BANNETTE_DFLT;

$modversion['config'][15]['name'] = 'mldocs_pathArchive';     // config chemin archives
$modversion['config'][15]['title'] = '_MI_MLDOCS_PATH_ARCHIVE';
$modversion['config'][15]['description'] = '_MI_MLDOCS_PATH_ARCHIVE_DSC';
$modversion['config'][15]['formtype'] = 'textbox';
$modversion['config'][15]['valuetype'] = 'string';
$modversion['config'][15]['default'] = _MI_MLDOCS_PATH_ARCHIVE_DFLT;

$modversion['config'][16]['name'] = 'mldocs_pathUploads';     // config upload mldocs
$modversion['config'][16]['title'] = '_MI_MLDOCS_UPLOADS';
$modversion['config'][16]['description'] = '_MI_MLDOCS_UPLOADS_DSC';
$modversion['config'][16]['formtype'] = 'textbox';
$modversion['config'][16]['valuetype'] = 'string';
$modversion['config'][16]['default'] = _MI_MLDOCS_PATH_UPLOADS_DFLT;

$modversion['config'][17]['name'] = 'mldocs_urlBannette';     // config url bannette
$modversion['config'][17]['title'] = '_MI_MLDOCS_URL_BANNETTE';
$modversion['config'][17]['description'] = '_MI_MLDOCS_URL_BANNETTE_DSC';
$modversion['config'][17]['formtype'] = 'textbox';
$modversion['config'][17]['valuetype'] = 'string';
$modversion['config'][17]['default'] = _MI_MLDOCS_URL_BANNETTE_DFLT;

$modversion['config'][18]['name'] = 'mldocs_pathcgi_bin';     // config path cgi-bin
$modversion['config'][18]['title'] = '_MI_MLDOCS_PATH_CGI_BIN';
$modversion['config'][18]['description'] = '_MI_MLDOCS_PATH_CGI_BIN_DSC';
$modversion['config'][18]['formtype'] = 'textbox';
$modversion['config'][18]['valuetype'] = 'string';
$modversion['config'][18]['default'] = _MI_MLDOCS_PATH_CGI_BIN_DFLT;

$modversion['config'][19]['name'] = 'mldocs_uniqueCodeArchive';     // code archives unique ? yes / no
$modversion['config'][19]['title'] = '_MI_MLDOCS_UNIQUE_ARCHIVE';
$modversion['config'][19]['description'] = '_MI_MLDOCS_UNIQUE_ARCHIVE_DSC';
$modversion['config'][19]['formtype'] = 'yesno';
$modversion['config'][19]['valuetype'] = 'int';
$modversion['config'][19]['default'] = 0;

// Email templates
$modversion['_email_tpl'][1]['name'] = 'new_archive';        // Add archive
$modversion['_email_tpl'][1]['category'] = 'dept';
$modversion['_email_tpl'][1]['mail_template'] = 'dept_newarchive_notify';
$modversion['_email_tpl'][1]['mail_subject'] = _MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][1]['bit_value'] = 0;
$modversion['_email_tpl'][1]['title'] = _MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFY;
$modversion['_email_tpl'][1]['caption'] = _MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][1]['description'] = _MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][2]['name'] = 'removed_archive';    // Delete archive
$modversion['_email_tpl'][2]['category'] = 'dept';
$modversion['_email_tpl'][2]['mail_template'] = 'dept_removedarchive_notify';
$modversion['_email_tpl'][2]['mail_subject'] = _MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][2]['bit_value'] = 1;
$modversion['_email_tpl'][2]['title'] = _MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFY;
$modversion['_email_tpl'][2]['caption'] = _MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][2]['description'] = _MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][3]['name'] = 'modified_archive';   // Edit archive information
$modversion['_email_tpl'][3]['category'] = 'dept';
$modversion['_email_tpl'][3]['mail_template'] = 'dept_modifiedarchive_notify';
$modversion['_email_tpl'][3]['mail_subject'] = _MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][3]['bit_value'] = 2;
$modversion['_email_tpl'][3]['title'] = _MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFY;
$modversion['_email_tpl'][3]['caption'] = _MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][3]['description'] = _MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][4]['name'] = 'new_response'; 
$modversion['_email_tpl'][4]['category'] = 'dept';         // All archives
$modversion['_email_tpl'][4]['mail_template'] = 'dept_newresponse_notify';
$modversion['_email_tpl'][4]['mail_subject'] = _MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYSBJ;
$modversion['_email_tpl'][4]['bit_value'] = 3;
$modversion['_email_tpl'][4]['title'] = _MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFY;
$modversion['_email_tpl'][4]['caption'] = _MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYCAP;
$modversion['_email_tpl'][4]['description'] = _MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYDSC;

$modversion['_email_tpl'][5]['name'] = 'modified_response';
$modversion['_email_tpl'][5]['category'] = 'dept';         // All archives
$modversion['_email_tpl'][5]['mail_template'] = 'dept_modifiedresponse_notify';
$modversion['_email_tpl'][5]['mail_subject'] = _MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYSBJ;
$modversion['_email_tpl'][5]['bit_value'] = 4;
$modversion['_email_tpl'][5]['title'] = _MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFY;
$modversion['_email_tpl'][5]['caption'] = _MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYCAP;
$modversion['_email_tpl'][5]['description'] = _MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYDSC;

$modversion['_email_tpl'][6]['name'] = 'changed_status';     // Update status
$modversion['_email_tpl'][6]['category'] = 'dept';         // All archives
$modversion['_email_tpl'][6]['mail_template'] = 'dept_changedstatus_notify';
$modversion['_email_tpl'][6]['mail_subject'] = _MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYSBJ;
$modversion['_email_tpl'][6]['bit_value'] = 5;
$modversion['_email_tpl'][6]['title'] = _MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFY;
$modversion['_email_tpl'][6]['caption'] = _MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYCAP;
$modversion['_email_tpl'][6]['description'] = _MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYDSC;

$modversion['_email_tpl'][7]['name'] = 'changed_priority';     // Update priority
$modversion['_email_tpl'][7]['category'] = 'dept';         // All archives
$modversion['_email_tpl'][7]['mail_template'] = 'dept_changedpriority_notify';
$modversion['_email_tpl'][7]['mail_subject'] = _MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYSBJ;
$modversion['_email_tpl'][7]['bit_value'] = 6;
$modversion['_email_tpl'][7]['title'] = _MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFY;
$modversion['_email_tpl'][7]['caption'] = _MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYCAP;
$modversion['_email_tpl'][7]['description'] = _MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYDSC;

$modversion['_email_tpl'][8]['name'] = 'new_owner';
$modversion['_email_tpl'][8]['category'] = 'dept';         // All archives
$modversion['_email_tpl'][8]['mail_template'] = 'dept_newowner_notify';
$modversion['_email_tpl'][8]['mail_subject'] = _MI_MLDOCS_DEPT_NEWOWNER_NOTIFYSBJ;
$modversion['_email_tpl'][8]['bit_value'] = 7;
$modversion['_email_tpl'][8]['title'] = _MI_MLDOCS_DEPT_NEWOWNER_NOTIFY;
$modversion['_email_tpl'][8]['caption'] = _MI_MLDOCS_DEPT_NEWOWNER_NOTIFYCAP;
$modversion['_email_tpl'][8]['description'] = _MI_MLDOCS_DEPT_NEWOWNER_NOTIFYDSC;

$modversion['_email_tpl'][9]['name'] = 'close_archive';        // Close archive
$modversion['_email_tpl'][9]['category'] = 'dept';
$modversion['_email_tpl'][9]['mail_template'] = 'dept_closearchive_notify';
$modversion['_email_tpl'][9]['mail_subject'] = _MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][9]['bit_value'] = 8;
$modversion['_email_tpl'][9]['title'] = _MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFY;
$modversion['_email_tpl'][9]['caption'] = _MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][9]['description'] = _MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][10]['name'] = 'merge_archive';
$modversion['_email_tpl'][10]['category'] = 'dept';
$modversion['_email_tpl'][10]['mail_template'] = 'dept_mergearchive_notify';
$modversion['_email_tpl'][10]['mail_subject'] = _MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][10]['bit_value'] = 9;
$modversion['_email_tpl'][10]['title'] = _MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFY;
$modversion['_email_tpl'][10]['caption'] = _MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][10]['description'] = _MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][11]['name'] = 'new_this_owner';
$modversion['_email_tpl'][11]['category'] = 'archive';         // Individual archive
$modversion['_email_tpl'][11]['mail_template'] = 'archive_newowner_notify';
$modversion['_email_tpl'][11]['mail_subject'] = _MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYSBJ;
$modversion['_email_tpl'][11]['bit_value'] = 10;
$modversion['_email_tpl'][11]['title'] = _MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFY;
$modversion['_email_tpl'][11]['caption'] = _MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYCAP;
$modversion['_email_tpl'][11]['description'] = _MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYDSC;

$modversion['_email_tpl'][12]['name'] = 'removed_this_archive';
$modversion['_email_tpl'][12]['category'] = 'archive';        // Individual archive
$modversion['_email_tpl'][12]['mail_template'] = 'archive_removedarchive_notify';
$modversion['_email_tpl'][12]['mail_subject'] = _MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][12]['bit_value'] = 11;
$modversion['_email_tpl'][12]['title'] = _MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFY;
$modversion['_email_tpl'][12]['caption'] = _MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][12]['description'] = _MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][13]['name'] = 'modified_this_archive';
$modversion['_email_tpl'][13]['category'] = 'archive';        // Individual archive
$modversion['_email_tpl'][13]['mail_template'] = 'archive_modifiedarchive_notify';
$modversion['_email_tpl'][13]['mail_subject'] = _MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][13]['bit_value'] = 12;
$modversion['_email_tpl'][13]['title'] = _MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFY;
$modversion['_email_tpl'][13]['caption'] = _MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][13]['description'] = _MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][14]['name'] = 'new_this_response'; 
$modversion['_email_tpl'][14]['category'] = 'archive';         // Individual archive
$modversion['_email_tpl'][14]['mail_template'] = 'archive_newresponse_notify';
$modversion['_email_tpl'][14]['mail_subject'] = _MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYSBJ;
$modversion['_email_tpl'][14]['bit_value'] = 13;
$modversion['_email_tpl'][14]['title'] = _MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFY;
$modversion['_email_tpl'][14]['caption'] = _MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYCAP;
$modversion['_email_tpl'][14]['description'] = _MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYDSC;

$modversion['_email_tpl'][15]['name'] = 'modified_this_response'; 
$modversion['_email_tpl'][15]['category'] = 'archive';         // Individual archive
$modversion['_email_tpl'][15]['mail_template'] = 'archive_modifiedresponse_notify';
$modversion['_email_tpl'][15]['mail_subject'] = _MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYSBJ;
$modversion['_email_tpl'][15]['bit_value'] = 14;
$modversion['_email_tpl'][15]['title'] = _MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFY;
$modversion['_email_tpl'][15]['caption'] = _MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYCAP;
$modversion['_email_tpl'][15]['description'] = _MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYDSC;

$modversion['_email_tpl'][16]['name'] = 'changed_this_status';     // Update status
$modversion['_email_tpl'][16]['category'] = 'archive';         // Individual archive
$modversion['_email_tpl'][16]['mail_template'] = 'archive_changedstatus_notify';
$modversion['_email_tpl'][16]['mail_subject'] = _MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYSBJ;
$modversion['_email_tpl'][16]['bit_value'] = 15;
$modversion['_email_tpl'][16]['title'] = _MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFY;
$modversion['_email_tpl'][16]['caption'] = _MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYCAP;
$modversion['_email_tpl'][16]['description'] = _MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYDSC;

$modversion['_email_tpl'][17]['name'] = 'changed_this_priority';     // Update priority
$modversion['_email_tpl'][17]['category'] = 'archive';         // Individual archive
$modversion['_email_tpl'][17]['mail_template'] = 'archive_changedpriority_notify';
$modversion['_email_tpl'][17]['mail_subject'] = _MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYSBJ;
$modversion['_email_tpl'][17]['bit_value'] = 16;
$modversion['_email_tpl'][17]['title'] = _MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFY;
$modversion['_email_tpl'][17]['caption'] = _MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYCAP;
$modversion['_email_tpl'][17]['description'] = _MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYDSC;

$modversion['_email_tpl'][18]['name'] = 'new_this_archive';        // Add archive
$modversion['_email_tpl'][18]['category'] = 'archive';
$modversion['_email_tpl'][18]['mail_template'] = 'archive_newarchive_notify';
$modversion['_email_tpl'][18]['mail_subject'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][18]['bit_value'] = 17;
$modversion['_email_tpl'][18]['title'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFY;
$modversion['_email_tpl'][18]['caption'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][18]['description'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][19]['name'] = 'close_this_archive';        // Close archive
$modversion['_email_tpl'][19]['category'] = 'archive';
$modversion['_email_tpl'][19]['mail_template'] = 'archive_closearchive_notify';
$modversion['_email_tpl'][19]['mail_subject'] = _MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][19]['bit_value'] = 18;
$modversion['_email_tpl'][19]['title'] = _MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFY;
$modversion['_email_tpl'][19]['caption'] = _MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][19]['description'] = _MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYDSC;

$modversion['_email_tpl'][20]['name'] = 'new_this_archive_via_email';        // Add archive  via email
$modversion['_email_tpl'][20]['category'] = 'archive';
$modversion['_email_tpl'][20]['mail_template'] = 'archive_newarchive_byemail_notify';
$modversion['_email_tpl'][20]['mail_subject'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYSBJ;
$modversion['_email_tpl'][20]['bit_value'] = 19;
$modversion['_email_tpl'][20]['title'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFY;
$modversion['_email_tpl'][20]['caption'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYCAP;
$modversion['_email_tpl'][20]['description'] = _MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYDSC;

$modversion['_email_tpl'][21]['name'] = 'new_user_byemail';        // Add archive  via email
$modversion['_email_tpl'][21]['category'] = 'archive';
$modversion['_email_tpl'][21]['mail_template'] = 'archive_new_user_byemail';
$modversion['_email_tpl'][21]['mail_subject'] = _MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYSBJ;
$modversion['_email_tpl'][21]['bit_value'] = 20;
$modversion['_email_tpl'][21]['title'] = _MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFY;
$modversion['_email_tpl'][21]['caption'] = _MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYCAP;
$modversion['_email_tpl'][21]['description'] = _MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYDSC;

$modversion['_email_tpl'][22]['name'] = 'new_user_activation1';
$modversion['_email_tpl'][22]['category'] = 'archive';
$modversion['_email_tpl'][22]['mail_template'] = 'archive_new_user_activation1';
$modversion['_email_tpl'][22]['mail_subject'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYSBJ;
$modversion['_email_tpl'][22]['bit_value'] = 21;
$modversion['_email_tpl'][22]['title'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFY;
$modversion['_email_tpl'][22]['caption'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYCAP;
$modversion['_email_tpl'][22]['description'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYDSC;

$modversion['_email_tpl'][23]['name'] = 'new_user_activation2';
$modversion['_email_tpl'][23]['category'] = 'archive';
$modversion['_email_tpl'][23]['mail_template'] = 'archive_new_user_activation2';
$modversion['_email_tpl'][23]['mail_subject'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYSBJ;
$modversion['_email_tpl'][23]['bit_value'] = 22;
$modversion['_email_tpl'][23]['title'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFY;
$modversion['_email_tpl'][23]['caption'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYCAP;
$modversion['_email_tpl'][23]['description'] = _MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYDSC;

$modversion['_email_tpl'][24]['name'] = 'user_email_error';
$modversion['_email_tpl'][24]['category'] = 'archive';
$modversion['_email_tpl'][24]['mail_template'] = 'archive_user_email_error';
$modversion['_email_tpl'][24]['mail_subject'] = _MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYSBJ;
$modversion['_email_tpl'][24]['bit_value'] = 23;
$modversion['_email_tpl'][24]['title'] = _MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFY;
$modversion['_email_tpl'][24]['caption'] = _MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYCAP;
$modversion['_email_tpl'][24]['description'] = _MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYDSC;

$modversion['_email_tpl'][25]['name'] = 'merge_this_archive';
$modversion['_email_tpl'][25]['category'] = 'archive';
$modversion['_email_tpl'][25]['mail_template'] = 'archive_mergearchive_notify';
$modversion['_email_tpl'][25]['mail_subject'] = _MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYSBJ;
$modversion['_email_tpl'][25]['bit_value'] = 24;
$modversion['_email_tpl'][25]['title'] = _MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFY;
$modversion['_email_tpl'][25]['caption'] = _MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYCAP;
$modversion['_email_tpl'][25]['description'] = _MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYDSC;

?>
