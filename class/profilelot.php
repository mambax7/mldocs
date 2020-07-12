<?php
//$Id: profilelot.php,v 1.11 2005/02/15 16:58:02 ackbarr Exp $
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
 * mldocsProfilelot class
 *
 * @author Eric Juden <ericj@epcusa.com> 
 * @access public
 * @package mldocs
 */ 
class mldocsProfilelot extends XoopsObject {
    function mldocsProfilelot($id = null) 
	{
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('profilelot', XOBJ_DTYPE_TXTBOX, null, false, 35);
        
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
 * mldocsProfilelotHandler class
 *
 * Profilelot Handler for mldocsProfilelot class
 *
 * @author Eric Juden <ericj@epcusa.com> &
 * @access public
 * @package mldocs
 */
 
class mldocsProfilelotHandler extends mldocsBaseObjectHandler {
	/**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	var $classname = 'mldocsprofilelot';
	
    /**
     * DB table name
     * 
     * @var string
     * @access private
     */
     var $_dbtable = 'mldocs_profilelots';
	
	/**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */	
	function mldocsProfilelotHandler(&$db)
	{
	    parent::init($db);
    }
            
    function getNameById($id)
    {
        $tmp =& $this->get($id);
        if ($tmp) {
            return $tmp->getVar('profilelot');
        } else {
            return _MLDOCS_TEXT_NO_DEPT;
        }   
    }
    
    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, profilelot) VALUES (%u, %s)",
            $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($profilelot));
            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET profilelot = %s WHERE id = %u",
                $this->_db->prefix($this->_dbtable), $this->_db->quoteString($profilelot), $id);
        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        return $sql;
    }
}
?>
