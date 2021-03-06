<?php
//$Id: status.php,v 1.3 2005/11/02 21:51:22 eric_juden Exp $
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
 * mldocsStatus class
 *
 * @author Eric Juden <ericj@epcusa.com> 
 * @access public
 * @package mldocs
 */ 
class mldocsStatus extends XoopsObject {
    function mldocsStatus($id = null) 
	{
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('state', XOBJ_DTYPE_INT, null, false);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 50);
        
        if (isset($id)) {
			if (is_array($id)) {
				$this->assignVars($id);
			}
		} else {
			$this->setNew();
		}
	}
}   //end of class

/**
 * mldocsStatusHandler class
 *
 * Status Handler for mldocsStatus class
 *
 * @author Eric Juden <ericj@epcusa.com> &
 * @access public
 * @package mldocs
 */
 
class mldocsStatusHandler extends mldocsBaseObjectHandler {
	/**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	var $classname = 'mldocsstatus';
	
    /**
     * DB table name
     * 
     * @var string
     * @access private
     */
     var $_dbtable = 'mldocs_status';
	
	/**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */	
	function mldocsStatusHandler(&$db)
	{
	    parent::init($db);
    }
    
    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, state, description) VALUES (%u, %u, %s)",
            $this->_db->prefix($this->_dbtable), $id, $state, $this->_db->quoteString($description));
            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET state = %u, description = %s WHERE id = %u",
                $this->_db->prefix($this->_dbtable), $state, $this->_db->quoteString($description), $id);
        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE ID = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        return $sql;
    }
    
    function &getStatusesByState($state)
    {
        $aStatuses = array();
        $state = intval($state);
        $crit = new Criteria('state', $state);
        $aStatuses =& $this->getObjects($crit, true);
        
        return $aStatuses;
    }
}
?>