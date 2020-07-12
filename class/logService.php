<?php
//$id$

/**
 * mldocs_logService class
 *
 * Part of the Messaging Subsystem.  Uses the mldocslogMessageHandler class for logging
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
 
class mldocs_logService
{
     /**
     * Instance of the mldocslogMessageHandler
     *    
     * @var	object
     * @access	private
     */
    var $_hLog;  
    
    
    /**
	 * Class Constructor
	 * 
	 * @access	public	
	 */	    
    function mldocs_logService()
    {
        $this->_hLog =& mldocsGetHandler('logMessage');
    }
    
    /**
	 * Callback function for the 'new_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */
    function new_archive($args)
    {
        global $xoopsUser;
        list($archive) = $args;
       
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $archive->getVar('uid'));
        $logMessage->setVar('archiveid', $archive->getVar('id'));
        $logMessage->setVar('lastUpdated', $archive->getVar('posted'));
        $logMessage->setVar('posted', $archive->getVar('posted'));
        
        if($xoopsUser->getVar('uid') == $archive->getVar('uid')){
            $logMessage->setVar('action', _MLDOCS_LOG_ADDARCHIVE);
        } else {
            // Will display who logged the archive for the user
            $logMessage->setVar('action', sprintf(_MLDOCS_LOG_ADDARCHIVE_FORUSER, $xoopsUser->getUnameFromId($archive->getVar('uid')), $xoopsUser->getVar('uname')));
        }
        
        return $this->_hLog->insert($logMessage);
    }
    
    /**
	 * Callback function for the 'update_priority' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */
    function update_priority($args)
    {
        global $xoopsUser;
        list($archive, $oldpriority) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archive->getVar('id'));
        $logMessage->setVar('lastUpdated', $archive->getVar('lastUpdated'));
        $logMessage->setVar('posted', $archive->getVar('posted'));
        $logMessage->setVar('action', sprintf(_MLDOCS_LOG_UPDATE_PRIORITY,  $oldpriority, $archive->getVar('priority')));
        return $this->_hLog->insert($logMessage);
    }

    /**
	 * Callback function for the 'update_status' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */    
    function update_status($args)
    {
        global $xoopsUser;
        list($archive, $oldstatus, $newstatus) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archive->getVar('id'));
        $logMessage->setVar('lastUpdated', $archive->getVar('lastUpdated'));
        $logMessage->setVar('posted', $archive->getVar('posted'));        
        $logMessage->setVar('action', sprintf(_MLDOCS_LOG_UPDATE_STATUS, $oldstatus->getVar('description'), $newstatus->getVar('description')));
        return $this->_hLog->insert($logMessage, true);
     }
     
   /**
    * Callback function for the 'update_owner' event
    * @param array $args Array of arguments passed to EventService
    * @returen bool True on success, false on error
    * @access public
    */
   function update_owner($args)
   {
        global $xoopsUser;
        list($archive, $oldowner) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archive->getVar('id'));
        $logMessage->setVar('lastUpdated', $archive->getVar('lastUpdated'));
        if ($xoopsUser->getVar('uid') == $archive->getVar('ownership')) {
            //User claimed ownership
            $logMessage->setVar('action', _MLDOCS_LOG_CLAIM_OWNERSHIP);
        } else {
            //Ownership was assigned
            $logMessage->setVar('action', sprintf(_MLDOCS_LOG_ASSIGN_OWNERSHIP, $xoopsUser->getUnameFromId($archive->getVar('ownership'))));
        }
        return $this->_hLog->insert($logMessage);
   }
   
     
   /**
    * Callback function for the reopen_archive event
    * @param array $args Array of arguments passed to EventService
    * @return bool True on success, false on error
    * @access public
    */
    function reopen_archive($args)
    {
        global $xoopsUser;
        list($archive) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archive->getVar('id'));
        $logMessage->setVar('lastUpdated', $archive->getVar('lastUpdated'));
        $logMessage->setVar('action', _MLDOCS_LOG_REOPEN_ARCHIVE);
        return $this->_hLog->insert($logMessage);
    }

    /**
    * Callback function for the close_archive event
    * @param array $args Array of arguments passed to EventService
    * @return bool True on success, false on error
    * @access public
    */    
    function close_archive($args)
    {
        global $xoopsUser;
        list($archive) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archive->getVar('id'));
        $logMessage->setVar('lastUpdated',$archive->getVar('lastUpdated'));
        $logMessage->setVar('action', _MLDOCS_LOG_CLOSE_ARCHIVE);
        return $this->_hLog->insert($logMessage);
    }
    
    /**
    * Callback function for the new_response event
    * @param array $args Array of arguments passed to EventService
    * @return bool True on success, false on error
    * @access public
    */
    function new_response(&$args)
    {
        global $xoopsUser;
        list($archive, $newResponse) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archive->getVar('id'));
        $logMessage->setVar('action', _MLDOCS_LOG_ADDRESPONSE);
        $logMessage->setVar('lastUpdated', $newResponse->getVar('updateTime'));
        return $this->_hLog->insert($logMessage);
    }

    /**
     * Callback function for the 'new_response_rating' event
     * @param array $args Array of arguments passed to EventService
     * @return bool True on success, false on error
     * @access public
    */
    function new_response_rating($args)
    {
        global $xoopsUser;
        list($rating) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $rating->getVar('archiveid'));
        $logMessage->setVar('action', sprintf(_MLDOCS_LOG_ADDRATING, $rating->getVar('responseid')));
        $logMessage->setVar('lastUpdated', time());
        return $this->_hLog->insert($logMessage);
    }
    /**
	 * Callback function for the 'edit_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */                 
    function edit_archive($args)
    {
        global $xoopsUser;
        list($oldArchive, $archiveInfo) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archiveInfo->getVar('id'));
        $logMessage->setVar('lastUpdated', $archiveInfo->getVar('posted'));
        $logMessage->setVar('posted', $archiveInfo->getVar('posted'));
        $logMessage->setVar('action', _MLDOCS_LOG_EDITARCHIVE);
        return $this->_hLog->insert($logMessage);
    }

    /**
	 * Callback function for the 'edit_response' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */             
    function edit_response($args)
    {
        global $xoopsUser;
        
        list($archive, $response, $oldarchive, $oldresponse) = $args;
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $response->getVar('archiveid'));
        $logMessage->setVar('lastUpdated', $response->getVar('updateTime'));
        $logMessage->setVar('action', sprintf(_MLDOCS_LOG_EDIT_RESPONSE, $response->getVar('id')));
        return $this->_hLog->insert($logMessage);
    } 
    
    function batch_dept($args)
    {
        global $xoopsUser;
        list($archives, $dept) = $args;
        $hDept   =& mldocsGetHandler('department');
        $deptObj =& $hDept->get($dept);
        
        foreach($archives as $archive) {
            $logMessage =& $this->_hLog->create();
            $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
            $logMessage->setVar('archiveid', $archive->getVar('id'));
            $logMessage->setVar('lastUpdated', time());
            $logMessage->setVar('action', sprintf(_MLDOCS_LOG_SETDEPT, $deptObj->getVar('department')));
            $this->_hLog->insert($logMessage);
            unset($logMessage);
        }
        return true;        
    }
    
    function batch_priority($args)
    {
        global $xoopsUser;
        list($archives, $priority) = $args;
        
        foreach($archives as $archive) {
            $logMessage =& $this->_hLog->create();
            $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
            $logMessage->setVar('archiveid', $archive->getVar('id'));
            $logMessage->setVar('lastUpdated', $archive->getVar('lastUpdated'));
            $logMessage->setVar('posted', $archive->getVar('posted'));
            $logMessage->setVar('action', sprintf(_MLDOCS_LOG_UPDATE_PRIORITY,  $archive->getVar('priority'), $priority));
            $this->_hLog->insert($logMessage);
        }
        return true;
    }
    
    function batch_owner($args)
    {
        global $xoopsUser;
        list($archives, $owner) = $args;
        $updated   = time();
        $ownername = ($xoopsUser->getVar('uid') == $owner ? $xoopsUser->getVar('uname') : $xoopsUser->getUnameFromId($owner));
        foreach ($archives as $archive) {
            $logMessage =& $this->_hLog->create();
            $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
            $logMessage->setVar('archiveid', $archive->getVar('id'));
            $logMessage->setVar('lastUpdated', $updated);
            if ($xoopsUser->getVar('uid') == $owner) {
                $logMessage->setVar('action', _MLDOCS_LOG_CLAIM_OWNERSHIP);
            } else {
                $logMessage->setVar('action', sprintf(_MLDOCS_LOG_ASSIGN_OWNERSHIP, $ownername));
            }
            $this->_hLog->insert($logMessage);
            unset($logMessage);
        }
        return true;
    }
    
    function batch_status($args)
    {
        global $xoopsUser; 
        list ($archives, $newstatus) = $args;
        $updated = time();
        $sStatus = mldocsGetStatus($newstatus);
        $uid     = $xoopsUser->getVar('uid');
        foreach ($archives as $archive) {
            $logMessage =& $this->_hLog->create();
            $logMessage->setVar('uid', $uid);
            $logMessage->setVar('archiveid', $archive->getVar('id'));
            $logMessage->setVar('lastUpdated', $updated); 
            $logMessage->setVar('action', sprintf(_MLDOCS_LOG_UPDATE_STATUS, mldocsGetStatus($archive->getVar('status')), $sStatus));
            $this->_hLog->insert($logMessage, true);
            unset($logMessage);
        }
        return true;
    }
    
    function batch_response($args)
    {
        global $xoopsUser;
        list($archives, $response, $timespent, $private) = $args;
        $updateTime = time();
        $uid        = $xoopsUser->getVar('uid');
        
        foreach($archives as $archive) {
            $logMessage =& $this->_hLog->create();
            $logMessage->setVar('uid', $uid);
            $logMessage->setVar('archiveid', $archive->getVar('id'));
            $logMessage->setVar('action', _MLDOCS_LOG_ADDRESPONSE);
            $logMessage->setVar('lastUpdated', $updateTime);
            $this->_hLog->insert($logMessage);
        }
        return true;
    }
    
    function merge_archives($args)
    {
        global $xoopsUser;
        list($archiveid, $mergeArchiveid, $newArchive) = $args;    // New archive only passed in to match function for notificationService
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $archiveid);
        $logMessage->setVar('action', sprintf(_MLDOCS_LOG_MERGEARCHIVES, $mergeArchiveid, $archiveid));
        $logMessage->setVar('lastUpdated', time());
        if($this->_hLog->insert($logMessage)){
            return true;
        }
        return false;
    }
    
    function delete_file($args)
    {
        global $xoopsUser;
        list($file) = $args;
        
        $filename = $file->getVar('filename');
        
        $logMessage =& $this->_hLog->create();
        $logMessage->setVar('uid', $xoopsUser->getVar('uid'));
        $logMessage->setVar('archiveid', $file->getVar('archiveid'));
        $logMessage->setVar('action', sprintf(_MLDOCS_LOG_DELETEFILE, $filename));
        $logMessage->setVar('lastUpdated', time());
        
        if($this->_hLog->insert($logMessage, true)){
            return true;
        }
        return false;
    }
    
     /**
	 * Only have 1 instance of class used
	 * @return object {@link mldocs_eventService}
	 * @access	public
	 */
    
    function &singleton()
    {
        // Declare a static variable to hold the object instance
        static $instance; 

        // If the instance is not there, create one
        if(!isset($instance)) { 
            $instance =& new mldocs_logService(); 
        } 
        return($instance); 
    }
}
?>