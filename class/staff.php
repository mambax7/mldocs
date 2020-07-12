<?php
//$Id: staff.php,v 1.40 2005/10/07 21:03:17 eric_juden Exp $
// modif byoos 2007/09/25  gabriel_bobard
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
if (!defined('MLDOCS_CLASS_PATH')) {
    exit();
}

require_once(MLDOCS_CLASS_PATH.'/mldocsBaseObjectHandler.php');
require_once(MLDOCS_CLASS_PATH.'/notificationService.php');

/**
 * mldocsStaff class
 *
 * @author Eric Juden <ericj@epcusa.com> 
 * @access public
 * @package mldocs
 */

require_once(MLDOCS_CLASS_PATH.'/session.php');

class mldocsStaff extends XoopsObject {
    function mldocsStaff($id = null) 
	{
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('responseTime', XOBJ_DTYPE_INT, null, false);
        $this->initVar('numReviews', XOBJ_DTYPE_INT, null, false);
        $this->initVar('callsClosed', XOBJ_DTYPE_INT, null, false);
        $this->initVar('attachSig', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rating', XOBJ_DTYPE_INT, null, false);
        $this->initVar('allDepartments', XOBJ_DTYPE_INT, null, false);
        $this->initVar('archivesResponded', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('notify', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('permTimestamp', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('deptUserdef', XOBJ_DTYPE_INT, 0, false);        
        
        if (isset($id)) {
			if (is_array($id)) {
				$this->assignVars($id);
			}
		} else {
			$this->setNew();
		}
	}
	
   /**
    * Used to make sure that the user has rights to do an action
    *
    * @param int $task
    * @param int $deptid id of department
    *
    * @return TRUE if success, FALSE if failure
    *
    * @access public
    */
	function checkRoleRights($task, $deptid = 0)
    {
        
        $task = intval($task);
        if(isset($deptid)){
            $deptid = intval($deptid);
        }
       
        $_mldocsSession = new Session();
        
        if (!$rights = $_mldocsSession->get("mldocs_staffRights")) {
            $rights = $this->getAllRoleRights();
            $_mldocsSession->set("mldocs_staffRights", $rights);
        }
         
        if (isset($rights[$deptid])) {
            $hasRights = ($rights[$deptid]['tasks'] & pow(2, $task)) > 0 ;
            return $hasRights;
        } else {
            //no permission in department
            return false;
        }
    }
    
    function getAllRoleRights()
    {
        $perms = array();
        $hStaff =& mldocsGetHandler('staff');
        $hRole  =& mldocsGetHandler('role');
        $roles  =& $hRole->getObjects(null, true);
        $staffRoles =& $hStaff->getRoles($this->getVar('uid'));
        foreach($staffRoles as $role) {
            $deptid = $role->getVar('deptid');
            $roleid = $role->getVar('roleid');
            
            if (isset($roles[$roleid])) {
                $perms[$deptid]['roles'][$roleid] = $roles[$roleid]->getVar('tasks');
                if (isset($perms[$deptid]['tasks'])) {
                    $perms[$deptid]['tasks'] |= intval($roles[$roleid]->getVar('tasks'));
                } else {
                    $perms[$deptid]['tasks'] = intval($roles[$roleid]->getVar('tasks'));
                }
            }
        }
        
        return $perms; 
    }

    function resetRoleRights()
    {
        $_mldocsSession = new Session();
        $_mldocsSession->del("mldocs_staffRights");
        return true;
    }
}

/**
 * mldocsStaffHandler class
 *
 * Staff Handler for mldocsStaff class
 *
 * @author Eric Juden <ericj@epcusa.com> &
 * @access public
 * @package mldocs
 */
 
class mldocsStaffHandler extends mldocsBaseObjectHandler {
	
	/**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	var $classname = 'mldocsstaff';
	
    /**
     * DB table name
     * 
     * @var string
     * @access private
     */
     var $_dbtable = 'mldocs_staff';
	
	/**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */	
	function mldocsStaffHandler(&$db)
	{
	    parent::init($db);
    }
    
    
    /**
    * retrieve a staff object from the database
    * @param int $uid user id
    * @return object {@link mldocsStaff}
    * @access public
    */
    function &getByUid($uid)
    {
        $uid = intval($uid);
        if($uid > 0) {
            $sql = $this->_selectQuery(new Criteria('uid', $uid));
            if(!$result = $this->_db->query($sql)) {
                return false;
            }
            if($arr = $this->_db->fetchArray($result)) {
                $obj = new $this->classname($arr);
                return $obj;
            }
        }
        return false;
    }
    
   /**
    * Add user to a new role
    *
    * @param int $uid user id
    * @param int $roleid role id
    * @param int $deptid department id
    *
    * @return TRUE if success, FALSE if failure
    * @access public
    */
    function addStaffRole($uid, $roleid, $deptid)
    {
        $hStaffRole =& mldocsGetHandler('staffRole');
        $role =& $hStaffRole->create();
        $role->setVar('uid', $uid);
        $role->setVar('roleid', $roleid);
        $role->setVar('deptid', $deptid);
        if(!$hStaffRole->insert($role)){
            return false;
        }
        return true;
    }
   /**
    * Retrive all of the roles of current staff member
    *
    * @return object {@link mldocsStaffRoles}, FALSE if failure
    *
    * @access public
    *
    */
    function &getRoles($uid, $id_as_key = false)
    {
        $uid = intval($uid);
        $hStaffRole =& mldocsGetHandler('staffRole');
        
        if(!$roles =& $hStaffRole->getObjectsByStaff($uid, $id_as_key)){
            return false;
        }
        return $roles;
    }
    
    function clearRoles()
    {
        $_mldocsSession = new Session();
        
        if($myRoles =& $_mldocsSession->get("mldocs_hasRights")){
            $_mldocsSession->del("mldocs_hasRights");
            return true;
        }
        return false;
    }
    
   /**
    * Retrieve all of the roles of current department for staff member
    *
    * @return object {@link mldocsStaffRoles}, FALSE if failure
    *
    * @access public
    */
    function &getRolesByDept($uid, $deptid, $id_as_key = false)
    {
        $uid = intval($uid);
        $deptid = intval($deptid);
        $hStaffRole =& mldocsGetHandler('staffRole');
        
        $crit = new CriteriaCompo(new Criteria('uid', $uid));
        $crit->add(new Criteria('deptid', $deptid));
        
        if(!$roles =& $hStaffRole->getObjects($crit, $id_as_key)){
            return false;
        }
        return $roles;
    }
    
   /**
    * Remove user from a role
    *
    * @param int $uid user id
    * @param int $roleid role id
    * @param int $deptid department id
    *
    * @return TRUE if success, FALSE if failure
    * @access public
    */
    function removeStaffRoles($uid)
    {
        $hStaffRole =& mldocsGetHandler('staffRole');
        $crit = new Criteria('uid', $uid);
        
        return $hStaffRole->deleteAll($crit);
    }
    
   /**
    * Check if a user is in a particular role
    *
    * @param int $uid user id
    * @param int $roleid role id
    *
    * @return TRUE on success, FALSE on failure
    * @access public
    */
    function staffInRole($uid, $roleid)
    {
        $hStaffRole =& mldocsGetHandler('staffRole');
        if(!$inRole = $hStaffRole->staffInRole($uid, $roleid)){
            return false;
        }
        return true;
    }    
    
   /**
    * Retrieve amount of time spent by staff member
    * @param int $uid user id
    * @return int $timeSpent
    * @access public
    */
    function &getTimeSpent($uid = 0)
    {
        $hResponses =& mldocsGetHandler('responses');
        if(!$uid == 0){
            $uid = intval($uid);
            $crit = new Criteria('uid', $uid);
            $responses =& $hResponses->getObjects($crit);
        } else {
            $responses =& $hResponses->getObjects();
        }
        $timeSpent = 0;
        foreach($responses as $response){
            $newTime = $response->getVar('timeSpent');
            $timeSpent = $timeSpent + $newTime;
        }
        return $timeSpent;
    }
    
    	
	function &getByAllDepts()
    {
        $ret = $this->getObjects(new Criteria('allDepartments', 1), true);
        return $ret;
    }
        
 	function &getByAllProfils()
    {
        $ret = $this->getObjects(new Criteria('allProfilelots', 1), true);
        return $ret;
    }
           
   /**
    * creates new staff member
    *
    * @access public
    */
    function addStaff($uid, $email) //, $allDepts = 0
    {
        
        $notify = new mldocs_notificationService();
        $staff =& $this->create();
        $staff->setVar('uid', $uid);
        $staff->setVar('email', $email);
        $numNotify = $notify->getNumDeptNotifications();
        $staff->setVar('notify', pow(2, $numNotify)-1);
        $staff->setVar('permTimestamp', time());
        return $this->insert($staff);
    }
    
   /**
    * checks to see if the user is a staff member
    *
    * @param int $uid User ID to look for
    * @return bool TRUE if user is a staff member, false if not
    */
    function isStaff($uid)
    {
        $count = $this->getCount(new Criteria('uid', intval($uid)));
        return ($count > 0);
    }

    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, uid, email, responseTime, numReviews, callsClosed, attachSig, rating, allDepartments, archivesResponded, notify, permTimestamp, deptUserdef) VALUES (%u, %u, %s, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u)",
            $this->_db->prefix($this->_dbtable), $id, $uid, $this->_db->quoteString($email), $responseTime, $numReviews, $callsClosed, $attachSig, $rating, $allDepartments, $archivesResponded, $notify, $permTimestamp, $deptUserdef);
            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET uid = %u, email = %s, responseTime = %u, numReviews = %u, callsClosed = %u, attachSig = %u, rating = %u, allDepartments = %u, archivesResponded = %u, notify = %u, permTimestamp = %u, deptUserdef = %u WHERE id = %u",
            $this->_db->prefix($this->_dbtable), $uid, $this->_db->quoteString($email), $responseTime, $numReviews, $callsClosed, $attachSig, $rating, $allDepartments, $archivesResponded, $notify, $permTimestamp, $deptUserdef, $id);

        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        return $sql;
    }
    
    
    /**
	 * delete a staff member from the database
	 * 
	 * @param object $obj reference to the {@link mldocsStaff} obj to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 * @access	public
	 */    
    function delete(&$obj, $force = false)
	{
		if (strcasecmp($this->classname, get_class($obj)) != 0) {
			return false;
		}
		
		// Clear Department Membership
		$hMembership =& mldocsGetHandler('membership');
		if (!$hMembership->clearStaffMembership($obj->getVar('uid'))){
			return false;
		}
		
		// Remove archive lists
		$hArchiveList =& mldocsGetHandler('archiveList');
		$crit = new Criteria('uid', $obj->getVar('uid'));
		if(!$hArchiveList->deleteAll($crit)){
		    return false;
		}
		
		// Remove saved searches
		$hSavedSearch =& mldocsGetHandler('savedSearch');
		if(!$hSavedSearch->deleteAll($crit)){   // use existing crit object
		    return false;
		}
		
		// Clear permission roles
		if(!$this->removeStaffRoles($obj->getVar('uid'))){
		    return false;
		}
	    
	    $ret = parent::delete($obj, $force);
		return $ret;
	}


    /**
	 * Adjust the # of calls closed for the given user by the given offset
	 * 
	 * @param int $uid User ID to modify
	 * @param int $offset Number of archives to add to current call count (Negative for decrementing)
	 * @return bool FALSE if query failed
	 * @access	public	 
	 */

    function increaseCallsClosed($uid, $offset = 1) 
    {
        if ($offset < 0) {
            $sql = sprintf( 'UPDATE %s SET callsClosed = callsClosed - %u WHERE uid = %u', $this->_db->prefix($this->_dbtable), abs($offset), $uid);
        } else {
            $sql = sprintf( 'UPDATE %s SET callsClosed = callsClosed + %u WHERE uid = %u', $this->_db->prefix($this->_dbtable), $offset, $uid);
        }            
        if (!$result = $this->_db->query($sql)) {
            return false;
        }
        return true;
    }
    
    /**
	 * Adjust the responseTime for the specified staff member
	 * 
	 * @param int $uid User ID to modify
	 * @param int $responseTime If $archiveCount is specified, the total # of response seconds, otherwise the number of seconds to add
	 * @param int $archiveCount If = 0, increments 'responseTime' and 'archivesResponded' otherwise, total # of archives
	 * @return bool FALSE if query failed
	 * @access	public	 
	 */
    function updateResponseTime($uid, $responseTime, $archiveCount=0)
    {
        if ($archiveCount == 0) {
            //Incrementing responseTime
            $sql = sprintf('UPDATE %s SET responseTime = responseTime + %u, archivesResponded = archivesResponded + 1 WHERE uid = %u', 
                $this->_db->prefix($this->_dbtable), $responseTime, $uid);
        } else {
            //Setting responseTime, archivesResponded
            $sql = sprintf('UPDATE %s SET responseTime = %u, archivesResponded = %u WHERE uid = %u',
                $this->_db->prefix($this->_dbtable), $responseTime, $archiveCount, $uid);
        }
        if (!$result = $this->_db->query($sql)) {
            return false;
        }
        return true;
    }
    
    /**
     * Adjust the rating for the specified staff member
     *
     * @param int $uid Staff ID to modify
     * @param int $rating If $numReviews is specified, the total # of rating points, otherwise the number of rating points to add
     * @param int $numReviews If = 0, increments 'rating' and 'numReviews', otherwise total # of reviews
     * @return bool FALSE if query failed
     * @access public
     */
    function updateRating($uid, $rating, $numReviews=0)
    {
        if ($numReviews == 0) {
            //Add New Review
            $sql = sprintf('UPDATE %s SET rating = rating + %u, numReviews = numReviews + 1 WHERE uid = %u',
                $this->_db->prefix($this->_dbtable), $rating, $uid);
        } else {
            //Set rating, numReviews to supplied values
            $sql = sprintf('UPDATE %s SET rating = %u, numReviews = %u WHERE uid = %u',
                $this->_db->prefix($this->_dbtable), $rating, $numReviews, $uid);
        }
        if (!$result = $this->_db->query($sql)) {
            return false;
        }
        return true;
    }
}

?>
