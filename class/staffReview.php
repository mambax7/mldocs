<?php
//$Id: staffReview.php,v 1.9 2005/02/15 16:58:03 ackbarr Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
if (!defined('MLDOCS_CLASS_PATH')) {
    exit();
}

require_once(MLDOCS_CLASS_PATH.'/mldocsBaseObjectHandler.php');

/**
 * mldocsStaffReview class
 *
 * @author Eric Juden <ericj@epcusa.com> 
 * @access public
 * @package mldocs
 */
class mldocsStaffReview extends XoopsObject {
    function mldocsStaffReview($id = null) 
	{
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('staffid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rating', XOBJ_DTYPE_INT, null, false);
        $this->initVar('comments', XOBJ_DTYPE_TXTAREA, null, false, 1024);
        $this->initVar('archiveid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('responseid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('submittedBy', XOBJ_DTYPE_INT, null, false);
        $this->initVar('userIP', XOBJ_DTYPE_TXTBOX, null, false, 255);
        
        if (isset($id)) {
			if (is_array($id)) {
				$this->assignVars($id);
			}
		} else {
			$this->setNew();
		}
	}
    
	/**
    * Gets a UNIX timestamp
    *
    * @return int Timestamp of last update
    * @access public
    */
	function posted()
	{
		return formatTimestamp($this->getVar('updateTime'));
	}
}

/**
 * mldocsStaffReviewHandler class
 *
 * StaffReview Handler for mldocsStaffReview class
 *
 * @author Eric Juden <ericj@epcusa.com> &
 * @access public
 * @package mldocs
 */
 
class mldocsStaffReviewHandler extends mldocsBaseObjectHandler {	
	/**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	var $classname = 'mldocsstaffreview';
	
    /**
     * DB table name
     * 
     * @var string
     * @access private
     */
     var $_dbtable = 'mldocs_staffreview';
	
	/**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */	
	function mldocsStaffReviewHandler(&$db)
	{
	    parent::init($db);
    }
    
            
   /**
    * retrieve a StaffReview object meeting certain criteria
    * @param int $archiveid ID of archive
    * @param int $responseid ID of response
    * @param int $submittedBy UID of archive submitter
    * @return object (@link mldocsStaffReview}
    * @access public
    */
    function &getReview($archiveid, $responseid, $submittedBy)
    {
        $archiveid = intval($archiveid);
        $responseid = intval($responseid);
        $submittedBy = intval($submittedBy);
        
        $crit = new CriteriaCompo(new Criteria('archiveid', $archiveid));
        $crit->add(new Criteria('submittedBy', $submittedBy));
        $crit->add(new Criteria('responseid', $responseid));
        $review = array();
        if(!$review =& $this->getObjects($crit)){
            return false;
        } else {
            return $review;
        }
    }
        
    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, staffid, rating, archiveid, responseid, comments, submittedBy, userIP) 
            VALUES (%u, %u, %u, %u, %u, %s, %u, %s)", $this->_db->prefix($this->_dbtable), $id, $staffid, $rating, 
            $archiveid, $responseid, $this->_db->quoteString($comments), $submittedBy, $this->_db->quoteString($userIP));

            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET staffid = %u, rating = %u, archiveid = %u, responseid = %u, comments = %s, submittedBy = %u, userIP = %s
                WHERE id = %u", $this->_db->prefix($this->_dbtable), $staffid, $rating, $archiveid, $responseid,
                $this->_db->quoteString($comments), $submittedBy, $this->_db->quoteString($userIP), $id);
                
        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        return $sql;
    }
    

}
?>