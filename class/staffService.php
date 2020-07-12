<?php
//$Id: staffService.php,v 1.10 2005/02/15 16:58:03 ackbarr Exp $

/**
 * mldocs_staffService class
 *
 * Part of the Messaging Subsystem.  Updates staff member information.
 *
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
 
class mldocs_staffService
{
     /**
     * Instance of the xoopsStaffHandler
     *    
     * @var	object
     * @access	private
     */
    var $_hStaff;  
    
    /**
	 * Class Constructor
	 * 
	 * @access	public	
	 */	    
    function mldocs_staffService()
    {
        $this->_hStaff =& mldocsGetHandler('staff');
    }
    
    /**
    * Callback function for the 'new_response' event
    * @param array $args Array of arguments passed to EventService
    * @return bool True on success, false on error
    * @access public
    */
    function new_response($args)
    {
        global $xoopsUser;
        list($archive, $response) = $args;
        
        //if first response for archive, update staff responsetime
        $hResponse   =& mldocsGetHandler('responses');
        $hMembership =& mldocsGetHandler('membership');
        if ($hResponse->getStaffResponseCount($archive->getVar('id')) == 1) {
            if ($hMembership->isStaffMember($response->getVar('uid'), $archive->getVar('department'))) {
                $responseTime = abs($response->getVar('updateTime') - $archive->getVar('posted'));
                $this->_hStaff->updateResponseTime($response->getVar('uid'), $responseTime);
            }
        }
                
    }
    
    function batch_response($args)
    {
        global $xoopsUser;
        list($archives, $response, $timespent, $private) = $args; 
        $update    = time();
        $uid       = $xoopsUser->getVar('uid');
        $hResponse =& mldocsGetHandler('responses');
        foreach ($archives as $archive) {        
            //if first response for archive, update staff responsetime
            
            $hMembership =& mldocsGetHandler('membership');
            if ($hResponse->getStaffResponseCount($archive->getVar('id')) == 1) {
                $responseTime = abs($update - $archive->getVar('posted'));
                $this->_hStaff->updateResponseTime($uid, $responseTime);
            }
        }

        
    }
    
    function batch_status($args)
    {
        global $xoopsUser;
        list($archives, $newstatus) = $args;
        
        $uid = $xoopsUser->getVar('uid');
        
        //Update Calls Closed if $newstatus = closed
        if ($newstatus == 2) {
            $this->_hStaff->increaseCallsClosed($uid, count($archives));
        }                
        
    }

    /**
    * Callback function for the 'close_archive' event
    * @param array $args Array of arguments passed to EventService
    * @return bool True on success, false on error
    * @access public
    */    
    function close_archive($args)
    {
        global $xoopsUser;
        list($archive) = $args;
        
        $hMembership =& mldocsGetHandler('membership');
        if ($hMembership->isStaffMember($archive->getVar('closedBy'), $archive->getVar('department'))) {
            $this->_hStaff->increaseCallsClosed($archive->getVar('closedBy'), 1);
        }
        return true;
    }

    /**
    * Callback function for the 'reopen_archive' event
    * @param array $args Array of arguments passed to EventService
    * @return bool True on success, false on error
    * @access public
    */        
    function reopen_archive($args)
    {
        list($archive) = $args;
        
        $hMembership =& mldocsGetHandler('membership');
        if ($hMembership->isStaffMember($archive->getVar('closedBy'), $archive->getVar('department'))) {
            $this->_hStaff->increaseCallsClosed($archive->getVar('closedBy'), -1);
        }
        return true;
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
        
        $hStaff =& mldocsGetHandler('staff');
        return $hStaff->updateRating($rating->getVar('staffid'), $rating->getVar('rating'));
    }
    
    function view_archive($args)
    {
        global $xoopsUser;
        list($archive) = $args;
        
        $value = array();
        
        //Store a list of recent archives in the mldocs_recent_archives cookie
        if (isset($_COOKIE['mldocs_recent_archives'])) {
            $oldvalue = explode(',', $_COOKIE['mldocs_recent_archives']);
        } else {
            $oldvalue = array();
        }
        
        $value[] = $archive->getVar('id');
               
        $value = array_merge($value, $oldvalue);
        $value = $this->_array_unique($value);
        $value = array_slice($value, 0, 5);
        //Keep this value for 15 days
        setcookie('mldocs_recent_archives', implode(',', $value), time()+15 * 24 * 60 * 60, '/'); 
    }

    function delete_staff($args)
    {
        $xoopsDB =& Database::getInstance();
        list($staff) = $args;
        
        //Reset the ownership for archives currently owned by staff member
        $sql = sprintf('UPDATE %s SET ownership = 0 WHERE ownership = %u', $xoopsDB->prefix('mldocs_archives'), $staff->getVar('uid'));
        $ret = $xoopsDB->query($sql);
        if (!$ret) {
            return false;
        }
        return true;
        
    } 
    
    /**
	 * Only have 1 instance of class used
	 * @return object {@link mldocs_staffService}
	 * @access	public
	 */
    function &singleton()
    {
        // Declare a static variable to hold the object instance
        static $instance; 

        // If the instance is not there, create one
        if(!isset($instance)) { 
            $instance =& new mldocs_staffService(); 
        }
        return($instance); 
    } 
    
    function _array_unique($array)
    {
        $out = array();
  
        //    loop through the inbound
        foreach ($array as $key=>$value) { 
            //    if the item isn't in the array
            if (!in_array($value, $out)) { //    add it to the array
                $out[$key] = $value;
            }
        }
  
        return $out;    
    }
}
?>