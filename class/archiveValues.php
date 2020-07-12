<?php
//$Id: archiveValues.php,v 1.9 2005/10/05 17:51:21 ackbarr Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
if (!defined('MLDOCS_CONSTANTS_INCLUDED')) {
    exit();
}

require_once(MLDOCS_CLASS_PATH.'/mldocsBaseObjectHandler.php');
mldocsIncludeLang('admin');

/**
 * mldocsArchiveValues class
 *
 * Metadata that represents a custom value created for mldocs
 *
 * @author Eric Juden <eric@3dev.org>
 * @access public
 * @package mldocs
 */
class mldocsArchiveValues extends XoopsObject
{   
    var $_fields = array();
     
    /**
     * Class Constructor
     *
     * @param mixed $archiveid null for a new object, hash table for an existing object
     * @return none
     * @access public
     */
    function mldocsArchiveValues($id = null)
    {        
        $this->initVar('archiveid', XOBJ_DTYPE_INT, null, false);
        
        $hFields =& mldocsGetHandler('archiveField');
        $fields =& $hFields->getObjects(null, true);
        
        foreach($fields as $field){
            $key = $field->getVar('fieldname');
            $datatype = $this->_getDataType($field->getVar('datatype'), $field->getVar('controltype'));
            $value = $this->_getValueFromXoopsDataType($datatype);
            $required = $field->getVar('required');
            $maxlength = ($field->getVar('fieldlength') < 50 ? $field->getVar('fieldlength') : 50);
            $options = '';
            
            $this->initVar($key, $datatype, null, $required, $maxlength, $options);
            
            $this->_fields[$key] = (($field->getVar('datatype') == _MLDOCS_DATATYPE_TEXT) ? "%s" : "%d");
        }
        $this->_fields['archiveid'] = "%u";


        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
			$this->setNew();
		}
    }
    
    function _getDataType($datatype, $controltype)
    {      
        switch($controltype)
        {            
            case MLDOCS_CONTROL_TXTBOX:
                return $this->_getXoopsDataType($datatype);
                break;
            
            case MLDOCS_CONTROL_TXTAREA:
                return $this->_getXoopsDataType($datatype);
                break;
            
            case MLDOCS_CONTROL_SELECT:
                    return XOBJ_DTYPE_TXTAREA;
                break;
            
            case MLDOCS_CONTROL_YESNO:
                    return XOBJ_DTYPE_INT;
                break;
            
            case MLDOCS_CONTROL_RADIOBOX:
                    return XOBJ_DTYPE_TXTBOX;
                break;
                
            case MLDOCS_CONTROL_DATETIME:
                return $this->_getXoopsDataType($datatype);
                break;
                
            case MLDOCS_CONTROL_FILE:
                return XOBJ_DTYPE_TXTBOX;
                break;
                
            default:
                return XOBJ_DTYPE_TXTBOX;
                break;
        }
    }
    
    function _getXoopsDataType($datatype)
    {
        switch($datatype)
        {
            case _MLDOCS_DATATYPE_TEXT:
                    return XOBJ_DTYPE_TXTBOX;
                break;
                
            case _MLDOCS_DATATYPE_NUMBER_INT:
                    return XOBJ_DTYPE_INT;
                break;
                
            case _MLDOCS_DATATYPE_NUMBER_DEC:
                    return XOBJ_DTYPE_OTHER;
                break;
            
            default:
                    return XOBJ_DTYPE_TXTBOX;
                break;
        }
    }
    
    function _getValueFromXoopsDataType($datatype)
    {
        switch($datatype)
        {
            case XOBJ_DTYPE_TXTBOX:
            case XOBJ_DTYPE_TXTAREA:
                return '';
                break;
            
            case XOBJ_DTYPE_INT:
                return 0;
                break;
            
            case XOBJ_DTYPE_OTHER:
                return 0.0;
                break;
                
            default:
                return null;
                break;
        }
    }
    
    function getArchiveFields()
    {
        return $this->_fields;
    }
}

class mldocsArchiveValuesHandler extends mldocsBaseObjectHandler
{
    /**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	 var $classname = 'mldocsArchiveValues';
	
	/**
	 * DB Table Name
	 *
	 * @var 		string
	 * @access 	private
	 */
	var $_dbtable = 'mldocs_archive_values';
	var $id = 'archiveid';
	var $_idfield = 'archiveid';
	
	/**
	 * Constructor
	 *
	 * @param	object   $db    reference to a xoopsDB object
	 */
	function mldocsArchiveValuesHandler(&$db) 
	{
		parent::init($db);
    }
	
	function _insertQuery(&$obj)
	{
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {     // Assumes cleanVars has already been called
            ${$k} = $v;
        }
        
        $myFields = $obj->getArchiveFields();    // Returns array[$fieldname] = %s or %d for all custom fields
      
        $count = 1;
        $sqlFields = "";
        $sqlVars = "";
        foreach($myFields as $myField=>$datatype){      // Create sql name and value pairs
            if(isset(${$myField}) && ${$myField} != null){                
                if($count > 1){								// If we have been through the loop already
                    $sqlVars .= ", ";
                    $sqlFields .= ", ";
                }
                $sqlFields .= $myField;
                if($datatype == "%s"){              		// If this field is a string
                    $sqlVars .= $this->_db->quoteString(${$myField});     // Add text to sqlVars string
                } else {                                	// If this field is a number
                    $sqlVars .= ${$myField};      // Add text to sqlVars string
                }
                $count++;
            }
        }
        // Create sql statement
        $sql = "INSERT INTO ". $this->_db->prefix($this->_dbtable)." (" . $sqlFields .") VALUES (". $sqlVars .")";
          
        return $sql;
	}
	
	function _updateQuery(&$obj)
	{
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        
        $myFields = $obj->getArchiveFields();    // Returns array[$fieldname] = %s or %u for all custom fields
        $count = 1;
        $sqlVars = "";
        foreach($myFields as $myField=>$datatype){      // Used to create sql field and value substrings
            if(isset(${$myField}) && ${$myField} != null){                
                if($count > 1){								// If we have been through the loop already
                    $sqlVars .= ", ";
                }
                if($datatype == "%s"){              		// If this field is a string
                    $sqlVars .= $myField ." = ". $this->_db->quoteString(${$myField});     // Add text to sqlVars string
                } else {                                	// If this field is a number
                    $sqlVars .= $myField ." = ". ${$myField};      // Add text to sqlVars string
                }
                $count++;
            }
        }
        
        // Create update statement
        $sql = "UPDATE ". $this->_db->Prefix($this->_dbtable)." SET ". $sqlVars ." WHERE archiveid = ". $obj->getVar('archiveid');

        return $sql;	    
	}
	
	
	function _deleteQuery(&$obj)
	{
        $sql = sprintf("DELETE FROM %s WHERE archiveid = %u", $this->_db->prefix($this->_dbtable), $obj->getVar($this->id));
	    return $sql;
	}
}
?>