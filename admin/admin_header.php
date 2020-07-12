<?php
// modification  BYOOS solutions  le 5 juillet 2006 Gabriel
if (!defined('MLDOCS_CONSTANTS_INCLUDED')) {
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
}

require(MLDOCS_BASE_PATH.'/admin/admin_buttons.php');
require_once(MLDOCS_BASE_PATH.'/functions.php');
require_once(MLDOCS_INCLUDE_PATH.'/functions_admin.php');
require_once(MLDOCS_CLASS_PATH.'/session.php');
require_once(MLDOCS_CLASS_PATH.'/eventService.php');

include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

mldocsIncludeLang('main');
mldocsIncludeLang('modinfo');


global $xoopsModule;
$module_id = $xoopsModule->getVar('mid');
$oAdminButton = new AdminButtons();
$oAdminButton->AddTitle(sprintf(_AM_MLDOCS_ADMIN_TITLE, $xoopsModule->getVar('name')));
$oAdminButton->AddButton(_AM_MLDOCS_INDEX, MLDOCS_ADMIN_URL."/index.php", 'index');
$oAdminButton->AddButton(_AM_MLDOCS_MENU_MANAGE_DEPARTMENTS, MLDOCS_ADMIN_URL."/department.php?op=manageDepartments", 'manDept');
//$oAdminButton->AddButton(_AM_MLDOCS_MENU_MANAGE_PROFILELOTS, MLDOCS_ADMIN_URL."/profilelot.php?op=manageProfilelots", 'manProfil');
$oAdminButton->AddButton(_AM_MLDOCS_TEXT_MANAGE_FILES, MLDOCS_ADMIN_URL."/file.php?op=manageFiles", 'manFiles');
$oAdminButton->AddButton(_AM_MLDOCS_MENU_MANAGE_STAFF, MLDOCS_ADMIN_URL."/staff.php?op=manageStaff", 'manStaff');
$oAdminButton->AddButton(_AM_MLDOCS_TEXT_MANAGE_NOTIFICATIONS, MLDOCS_ADMIN_URL."/notifications.php", 'manNotify');
$oAdminButton->AddButton(_AM_MLDOCS_TEXT_MANAGE_STATUSES, MLDOCS_ADMIN_URL."/status.php?op=manageStatus", 'manStatus');
$oAdminButton->addButton(_AM_MLDOCS_TEXT_MANAGE_FIELDS, MLDOCS_ADMIN_URL.'/fields.php', 'manfields');
//$oAdminButton->addButton(_AM_MLDOCS_TEXT_MANAGE_FIELDLOTS, MLDOCS_ADMIN_URL.'/fieldlots.php', 'manfieldlots');
//$oAdminButton->AddButton(_AM_MLDOCS_MENU_MODIFY_ARCHIVE_FIELDS, "index.php?op=modifyArchiveFields", 'modTickFields');
$oAdminButton->addButton(_AM_MLDOCS_MENU_MIMETYPES, MLDOCS_ADMIN_URL."/mimetypes.php", 'mimetypes');
$oAdminButton->addButton(_AM_MLDOCS_TEXT_MAIL_EVENTS, MLDOCS_ADMIN_URL."/index.php?op=mailEvents", 'mailEvents');
$oAdminButton->AddTopLink(_AM_MLDOCS_MENU_PREFERENCES, XOOPS_URL ."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=". $module_id);
//$oAdminButton->AddTopLink(_AM_MLDOCS_BLOCK_TEXT, MLDOCS_ADMIN_URL."/index.php?op=blocks");
$oAdminButton->addTopLink(_AM_MLDOCS_UPDATE_MODULE, XOOPS_URL ."/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=mldocs");
$oAdminButton->addTopLink(_MI_MLDOCS_MENU_CHECK_TABLES, MLDOCS_ADMIN_URL."/upgrade.php?op=checkTables");
$oAdminButton->AddTopLink(_AM_MLDOCS_ADMIN_GOTOMODULE, MLDOCS_BASE_URL."/index.php");
$oAdminButton->AddTopLink(_AM_MLDOCS_ADMIN_ABOUT, MLDOCS_ADMIN_URL."/index.php?op=about");

$myts = &MyTextSanitizer::getInstance();
$_eventsrv = mldocs_eventService::singleton();

$imagearray = array(
	'editimg' => "<img src='". MLDOCS_IMAGE_URL ."/button_edit.png' alt='" . _AM_MLDOCS_ICO_EDIT . "' align='middle' />",
    'deleteimg' => "<img src='". MLDOCS_IMAGE_URL ."/button_delete.png' alt='" . _AM_MLDOCS_ICO_DELETE . "' align='middle' />",
    'online' => "<img src='". MLDOCS_IMAGE_URL ."/on.png' alt='" . _AM_MLDOCS_ICO_ONLINE . "' align='middle' />",
    'offline' => "<img src='". MLDOCS_IMAGE_URL ."/off.png' alt='" . _AM_MLDOCS_ICO_OFFLINE . "' align='middle' />",
	);

// Overdue time
require_once(MLDOCS_CLASS_PATH.'/session.php');
$_mldocsSession = new Session();

// récupère les répertoires bannette, archive
$config =& mldocsGetModuleConfig();

if (!strlen($config['mldocs_pathArchive'])){
define('MLDOCS_ARCHIVE_PATH', MLDOCS_BASE_PATH. "/default/archives");

} else {define('MLDOCS_ARCHIVE_PATH',  $config['mldocs_pathArchive']);}

if (!strlen($config['mldocs_pathBannette'])){
define('MLDOCS_BANNETTE_PATH',  MLDOCS_BASE_PATH. "/default/bannette");
} else {define('MLDOCS_BANNETTE_PATH',  $config['mldocs_pathBannette']);}

if (!strlen($config['mldocs_pathUploads'])){
define('MLDOCS_UPLOADS_PATH', MLDOCS_BASE_PATH. "/default/uploads");
} else {define('MLDOCS_UPLOADS_PATH',  $config['mldocs_pathUploads']);}

if (!strlen($config['mldocs_pathcgi-bin'])){
define('MLDOCS_CONVERT_PATH',  MLDOCS_BASE_PATH. "/cgi-bin");
} else {define('MLDOCS_CONVERT_PATH',  $config['mldocs_pathcgi-bin']);}

if(!$overdueTime = $_mldocsSession->get("mldocs_overdueTime")){
    $_mldocsSession->set("mldocs_overdueTime", $xoopsModuleConfig['mldocs_overdueTime']);
    $overdueTime = $_mldocsSession->get("mldocs_overdueTime");
}

if($overdueTime != $xoopsModuleConfig['mldocs_overdueTime']){
    $_mldocsSession->set("mldocs_overdueTime", $xoopsModuleConfig['mldocs_overdueTime']);   // Set new value for overdueTime
    
    // Change overdueTime in all of archives (OPEN & HOLD)
    $hArchives =& mldocsGetHandler('archive');
    $crit = new Criteria('status', 2, '<>');
    $archives =& $hArchives->getObjects($crit);
    $updatedArchives = array();
    foreach($archives as $archive){
        $archive->setVar('overdueTime', $archive->getVar('posted') + ($xoopsModuleConfig['mldocs_overdueTime'] *60*60));
        if(!$hArchives->insert($archive, true)){
            $updatedArchives[$archive->getVar('id')] = false; // Not used anywhere
        } else {
            $updatedArchives[$archive->getVar('id')] = true;  // Not used anywhere
        }
    }
}
?>
