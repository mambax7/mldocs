<?php
require('servicemain.php');

//Include mldocs Related Includes
require_once(MLDOCS_CLASS_PATH.'/eventService.php');

require(MLDOCS_CLASS_PATH.'/notificationService.php');
require(MLDOCS_CLASS_PATH.'/logService.php');
require(MLDOCS_CLASS_PATH.'/cacheService.php');
require(MLDOCS_CLASS_PATH.'/mailboxPOP3.php');
require(MLDOCS_CLASS_PATH.'/msgParser.php');
require(MLDOCS_CLASS_PATH.'/msgStore.php');
require(MLDOCS_CLASS_PATH.'/validator.php');

//Initialize mldocs objects
$msgParser  =& new mldocsEmailParser();
$msgStore   =& new mldocsEmailStore();
$hDeptBoxes =& mldocsGetHandler('departmentMailBox');
$hMailEvent =& mldocsGetHandler('mailEvent');
$hArchive    =& mldocsGetHandler('archive');

$_eventsrv = mldocs_eventService::singleton();
$_eventsrv->advise('new_archive', mldocs_notificationService::singleton());
$_eventsrv->advise('new_archive', mldocs_logService::singleton());
$_eventsrv->advise('new_archive', mldocs_cacheService::singleton());
$_eventsrv->advise('new_response', mldocs_logService::singleton());
$_eventsrv->advise('new_response', mldocs_notificationService::singleton());
$_eventsrv->advise('new_user_by_email', mldocs_notificationService::singleton());
$_eventsrv->advise('user_email_error', mldocs_notificationService::singleton());

//Get All Department Mailboxes
$deptmboxes =& $hDeptBoxes->getActiveMailboxes();

//Loop Through All Department Mailboxes
foreach($deptmboxes as $mbox) {
    $deptid = $mbox->getVar('departmentid');
    //Connect to the mailbox
    if ($mbox->connect()) {
        //Check for new messages
        if ($mbox->hasMessages()) {
            //Retrieve / Store each message
            while ($msg =& $mbox->getMessage()) {
                $msg_logs = array();
                $skip_msg = false;
                
                
                //Check if there are any errors parsing msg
                if ($parsed =& $msgParser->parseMessage($msg)) {
                    
                    //Sanity Check: Disallow emails from other department mailboxes
                    if (_isDepartmentEmail($parsed->getEmail())) {
                        $msg_logs[_MLDOCS_MAIL_CLASS3][] = sprintf(_MLDOCS_MESSAGE_EMAIL_DEPT_MBOX, $parsed->getEmail());    
                    } else {
                        
                        //Create new user account if necessary
                        
                        if (!$xoopsUser =& mldocsEmailIsXoopsUser($parsed->getEmail())) {
                            
                            if ($xoopsModuleConfig['mldocs_allowAnonymous']) {                   
                                switch($xoopsConfigUser['activation_type']){
                                    case 1:
                                        $level = 1;
                                    break;
                                    
                                    case 0:
                                    case 2:
                                    default:
                                        $level = 0;
                                }
                                $xoopsUser =& mldocsXoopsAccountFromEmail($parsed->getEmail(), $parsed->getName(), $password, $level);
                                $_eventsrv->trigger('new_user_by_email', array($password, $xoopsUser));
                            } else {
                                $msg_logs[_MLDOCS_MAIL_CLASS3][] = sprintf(_MLDOCS_MESSAGE_NO_ANON, $parsed->getEmail());
                                $skip_msg = true;
                            }
                        }
                        
                      
                        if ($skip_msg == false) {
                            //Store Message In Server
                            if($obj =& $msgStore->storeMsg($parsed, $xoopsUser, $mbox, $errors)) {
                                switch ($parsed->getMsgType()) {
                                case _MLDOCS_MSGTYPE_ARCHIVE:
                                    //Trigger New Archive Events
                                    $_eventsrv->trigger('new_archive', $obj);
                                    break;
                                case _MLDOCS_MSGTYPE_RESPONSE:
                                    //Trigger New Response Events
                                    $_eventsrv->trigger('new_response', array(0, $obj));
                                    break;
                                }        
                            //} else {        // If message not stored properly, log event                    
                            //    $storeEvent =& $hMailEvent->newEvent($mbox->getVar('id'), _MLDOCS_MAILEVENT_DESC2, _MLDOCS_MAILEVENT_CLASS2);
                            } else {
                                $msg_logs[_MLDOCS_MAILEVENT_CLASS2] =& $errors;
                            }
                        }
                    }
                } else {
                    $msg_logs[_MLDOCS_MAILEVENT_CLASS1][] = _MLDOCS_MAILEVENT_DESC1;
                }
                //Remove Message From Server
                $mbox->deleteMessage($msg);

                //Log Any Messages
                _logMessages($mbox->getVar('id'),$msg_logs);
               
            }
        }
        //Disconnect from Server
        $mbox->disconnect();
    } else {                        // If mailbox not connected properly, log event
        $connEvent =& $hMailEvent->newEvent($mbox->getVar('id'), _MLDOCS_MAILEVENT_DESC0, _MLDOCS_MAILEVENT_CLASS0);
    }
}


function _logMessages($mbox, $arr) 
{
    global $hMailEvent;
    foreach ($arr as $class=>$msg) {
        if (is_array($msg)) {
            $msg = implode("\r\n", $msg);
        }
        $event =& $hMailEvent->newEvent($mbox, $msg, $class);
    }
}

function _isDepartmentEmail($email)
{
    static $email_arr;
    
    if (!isset($email_arr)) {
        global $hDeptBoxes;
        $deptmboxes =& $hDeptBoxes->getObjects();
        $email_arr = array();
        foreach($deptmboxes as $obj) {
            $email_arr[] = $obj->getVar('emailaddress');
        }
        unset($deptmboxes);
    }
    
    $ret = in_array($email, $email_arr);
    return $ret;
}
    
?>