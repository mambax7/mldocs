<?php
//$Id: msgStore.php,v 1.13 2005/07/05 20:09:35 eric_juden Exp $


class mldocsEmailStore
{
    var $_hResponse;
    var $_hArchive;
    var $_hMailEvent;
    var $_errors;
    
    function mldocsEmailStore()
    {
        $this->_hResponse  =& mldocsGetHandler('responses');
        $this->_hArchive    =& mldocsGetHandler('archive');
        $this->_hMailEvent =& mldocsGetHandler('mailEvent');
        $this->_errors     = array();
    }
    
    function _setError($desc)
    {
        if(is_array($desc)){
            foreach($desc as $d) {
                $this->_errors[] = $d;
            }
        }
        $this->_errors[] = $desc;
    }
    
    function _getErrors()
    {
        if(count($this->_errors) > 0){
            return $this->_errors;
        } else {
            return 0;
        }
    }
    
    function clearErrors()
    {
        $this->_errors = array();
    }
    
    function renderErrors()
    {
            
    }
    
    /**
     * Store the parsed message in database
     * @access public
     * @param object $msg {@link mldocsParsedMsg} object Message to add
     * @param object $user {@link xoopsUser} object User that submitted message
     * @param object $mbox {@link mldocsDepartmentMailBox} object. Originating Mailbox for message
     * @return mixed Returns {@link mldocsArchive} object if new archive, {@link mldocsResponses} object if a response, and false if unable to save.
     */
    function &storeMsg(&$msg, &$user, &$mbox, &$errors)
    {
        //Remove any previous error messages
        $this->clearErrors();
        
        $type = $msg->getMsgType();
        switch($type) {
        case _MLDOCS_MSGTYPE_ARCHIVE:
            $obj =& $this->_hArchive->create();
            $obj->setVar('uid', $user->getVar('uid'));
            $obj->setVar('subject', $msg->getSubject());
            $obj->setVar('description', $msg->getMsg());
            $obj->setVar('department', $mbox->getVar('departmentid'));
            $obj->setVar('priority', $mbox->getVar('priority'));
            $obj->setVar('posted', time());
            $obj->setVar('serverid', $mbox->getVar('id'));
            $obj->setVar('userIP', 'via Email'); 
            $obj->setVar('email', $user->getVar('email')); 
            if(!$status = mldocsGetMeta("default_status")){
                mldocsSetMeta("default_status", "1");
                $status = 1;
            }
            $obj->setVar('status', $status);
            $obj->createEmailHash($msg->getEmail());
            if ($this->_hArchive->insert($obj)) {
                $obj->addSubmitter($user->getVar('email'), $user->getVar('uid'));
                $this->_saveAttachments($msg, $obj->getVar('id'));   
                
                $errors = $this->_getErrors();
                
                return array($obj);
            }
            break;
            
        case _MLDOCS_MSGTYPE_RESPONSE:
            if (!$archive = $this->_hArchive->getArchiveByHash($msg->getHash())) {
                $this->_setError(_MLDOCS_RESPONSE_NO_ARCHIVE);
                return false;
            }
            
            
            if ($msg->getEmail() != $archive->getVar('email')) {
                $this->_setError(sprintf(_MLDOCS_MISMATCH_EMAIL, $msg->getEmail(), $archive->getVar('email')));
                return false;
            }            
            
            $obj = $this->_hResponse->create();
            $obj->setVar('archiveid', $archive->getVar('id'));
            $obj->setVar('uid', $user->getVar('uid'));
            $obj->setVar('message', $msg->getMsg());
            $obj->setVar('updateTime', time());
            $obj->setVar('userIP', 'via Email');
            
            if ($this->_hResponse->insert($obj)) {
                
                $this->_saveAttachments($msg, $archive->getVar('id'), $obj->getVar('id'));                
                $archive->setVar('lastUpdated', time());
                $this->_hArchive->insert($archive);
                
                $errors = $this->_getErrors();
                
                return array($archive, $obj);
            }
            break;
            
        default:
            //Sanity Check, should never get here
            
        }
        return false;
    }
    
    function _saveAttachments($msg, $archiveid, $responseid = 0) 
    {
        global $xoopsModuleConfig;
        $attachments = $msg->getAttachments();
        $dir         = XOOPS_UPLOAD_PATH .'/mldocs';
        $prefix      = ($responseid != 0? $archiveid.'_'.$responseid.'_' : $archiveid.'_');
        $hMime       =& mldocsGetHandler('mimetype');
        $allowed_mimetypes = $hMime->getArray();
        
        if(!is_dir($dir)){
            mkdir($dir, 0757);
        }
        
        $dir .= '/';
        
        if($xoopsModuleConfig['mldocs_allowUpload']){
            $hFile =& mldocsGetHandler('file');
            foreach ($attachments as $attach) {
                $validators = array();
                
                //Create Temporary File
                $fname = $prefix.$attach['filename'];
                $fp = fopen($dir.$fname, 'w');
                fwrite($fp, $attach['content']);
                fclose($fp);
                
                $validators[] = new ValidateMimeType($dir.$fname, $attach['content-type'], $allowed_mimetypes);
                $validators[] = new ValidateFileSize($dir.$fname, $xoopsModuleConfig['mldocs_uploadSize']);
                $validators[] = new ValidateImageSize($dir.$fname, $xoopsModuleConfig['mldocs_uploadWidth'], $xoopsModuleConfig['mldocs_uploadHeight']);
                
                if (!mldocsCheckRules($validators, $errors)) {
                    //Remove the file
                    $this->_addAttachmentError($errors, $msg, $fname);
                    unlink($dir.$fname);
                } else {
                    //Add attachment to archive
                    
                    $file =& $hFile->create();
                    $file->setVar('filename', $fname);
                    $file->setVar('archiveid', $archiveid);
                    $file->setVar('mimetype', $attach['content-type']);
                    $file->setVar('responseid', $responseid);
                    $hFile->insert($file, true);
                }
            }
        } else {
            $this->_setError(_MLDOCS_MESSAGE_UPLOAD_ALLOWED_ERR);   // Error: file uploading is disabled
        }
    }
    
    function _addAttachmentError($errors, $msg, $fname)
    {
        if($errors <> 0){
            $aErrors = array();
            foreach($errors as $err){              
                if(in_array($err, $aErrors)){
                    continue;
                } else {
                    $aErrors[] = $err;
                }
            }
            $error = implode($aErrors, ', ');
            $this->_setError(sprintf(_MLDOCS_MESSAGE_UPLOAD_ERR, $fname, $msg->getEmail(), $error));
        }                
    }        
}
?>