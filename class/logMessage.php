<?php
//$Id: logMessage.php,v 1.5 2005/02/15 16:58:02 ackbarr Exp $
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
 * mldocsLogMessage class
 *
 * @author Eric Juden <ericj@epcusa.com> 
 * @access public
 * @package mldocs
 */
 
 class mldocsLogMessage extends XoopsObject {
    function mldocsLogMessage($id = null) 
	{
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('archiveid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('lastUpdated', XOBJ_DTYPE_INT, null, true);
        $this->initVar('action', XOBJ_DTYPE_TXTBOX, null, true, 255);
        
        if (isset($id)) {
			if (is_array($id)) {
				$this->assignVars($id);
			}
		} else {
			$this->setNew();
		}
	}
	
	/**
	 * determine when the log message was updated
	 * 
	 * @return 	int	Timestamp of last update
	 * @access	public	
	 */		
	function lastUpdated()
	{
		return formatTimestamp($this->getVar('lastUpdated'));
	}
}   //end of class

/**
 * mldocsLogMessageHandler class
 *
 * LogMessage Handler for mldocsLogMessage class
 *
 * @author Eric Juden <ericj@epcusa.com> &
 * @access public
 * @package mldocs
 */
 
class mldocsLogMessageHandler extends mldocsBaseObjectHandler {
	/**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	var $classname = 'mldocslogmessage';
	
    /**
     * DB table name
     * 
     * @var string
     * @access private
     */
     var $_dbtable = 'mldocs_logmessages';
	
	/**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */	
	function mldocsLogMessageHandler(&$db)
	{
	    parent::init($db);
    }

    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, uid, archiveid, lastUpdated, action) VALUES (%u, %u, %u, %u, %s)",
            $this->_db->prefix($this->_dbtable), $id, $uid, $archiveid, time(), $this->_db->quoteString($action));
            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET uid = %u, archiveid = %u, lastUpdated = %u, action = %s WHERE id = %u",
            $this->_db->prefix($this->_dbtable), $uid, $archiveid, time(), $this->_db->quoteString($action), $id);
        
        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar($this->_idfield));
        return $sql;
    }
    
}
?>