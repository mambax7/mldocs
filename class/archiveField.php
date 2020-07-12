<?php
//$Id: archiveField.php,v 1.11 2005/09/07 14:56:56 eric_juden Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
if (!defined('MLDOCS_CONSTANTS_INCLUDED')) {
    exit();
}

require_once(MLDOCS_CLASS_PATH.'/mldocsBaseObjectHandler.php');



/**
 * mldocsArchiveField class
 *
 * Metadata that represents a custom field created for mldocs
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
class mldocsArchiveField extends XoopsObject
{
    var $_departments = array();
    /**
     * Class Constructor
     *
     * @param mixed $id null for a new object, hash table for an existing object
     * @return none
     * @access public
     */
    function mldocsArchiveField($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 64);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('fieldname', XOBJ_DTYPE_TXTBOX, null, true, 64);
        $this->initVar('controltype', XOBJ_DTYPE_INT,  MLDOCS_CONTROL_TXTBOX, true);
        $this->initVar('datatype', XOBJ_DTYPE_TXTBOX, null, true, 64);
        $this->initVar('required', XOBJ_DTYPE_INT, false, true);
        $this->initVar('fieldlength', XOBJ_DTYPE_INT, 255, true);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('fieldvalues', XOBJ_DTYPE_ARRAY, null, false);
        $this->initVar('defaultvalue', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('validation', XOBJ_DTYPE_TXTBOX, null, false);

        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
			$this->setNew();
		}
    }

   
    /**
     * Get the array of possible values for this custom field
     * @return array A hash table of name/value pairs for the field
     * @access public
     */
    function getValues()
    {
        $this->getVar('fieldvalues');           
    }
    
    function addValidator($validator)
    {
        
    }
    
    function setValues($val_arr)
    {
        $this->setVar('fieldvalues', $val_arr);
    }
    
    function addValues($val_arr) 
    {
        if (is_array($val_arr)) {
            $values = @$this->getVar('fieldvalues');
            if (!is_array($values)) {
                $values = array();
            }
            foreach ($val_arr as $value=>$desc) {
                $values[$value] = $desc;
            }
            $this->setVar('fieldvalues', $values);
        }
    }
    
    function addValue($desc, $value=null)
    {
        //Add value to array
        $values =& $this->getVar('fieldvalues');  
        $values[$desc] = $value;
        $this->setVar('fieldvalues', $values);
    }
    
    
    function addDepartment($dept)
    {
        $dept = intval($dept);
        $this->_departments[$dept] = $dept;    
    }
    
    function addDepartments(&$dept_arr)
    {
        if (!is_array($dept_arr) || count($dept_arr) == 0) {
            return false;
        }
        foreach ($dept_arr as $dept)
        {
            $dept = intval($dept);
            $this->_departments[$dept] = $dept;      
        }
    }
    
    function removeDepartment($dept)
    {
        $dept = intval($dept);
        $this->_departments[$dept] = 0;
    }
    
    function &getDepartments()
    {
        return $this->_departments;
    }
}

class mldocsArchiveFieldHandler extends mldocsBaseObjectHandler
{
    /**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	 var $classname = 'mldocsArchiveField';
	
	/**
	 * DB Table Name
	 *
	 * @var 		string
	 * @access 	private
	 */
	var $_dbtable = 'mldocs_archive_fields';
	var $id = 'id';
	
	/**
	 * Constructor
	 *
	 * @param	object   $db    reference to a xoopsDB object
	 */
	function mldocsArchiveFieldHandler(&$db) 
	{
		parent::init($db);
    } 
	
	function _insertQuery(&$obj)
	{
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, name, description, fieldname, controltype, datatype, required, fieldlength, weight, fieldvalues, defaultvalue, validation)
            VALUES (%u, %s, %s, %s, %u, %s, %u, %u, %s, %s, %s, %s)", $this->_db->prefix($this->_dbtable), $id,
            $this->_db->quoteString($name), $this->_db->quoteString($description), $this->_db->quoteString($fieldname), $controltype, $this->_db->quoteString($datatype),
            $required, $fieldlength, $weight, $this->_db->quoteString($fieldvalues), $this->_db->quoteString($defaultvalue), $this->_db->quoteString($validation));
            
        return $sql;
	    
	}
	
	function _updateQuery(&$obj)
	{
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET name = %s, description = %s, fieldname = %s, controltype = %u, datatype = %s, required = %u, fieldlength = %u, weight = %u, fieldvalues = %s,
            defaultvalue = %s, validation = %s WHERE id = %u", $this->_db->prefix($this->_dbtable),
            $this->_db->quoteString($name), $this->_db->quoteString($description), $this->_db->quoteString($fieldname), $controltype, 
            $this->_db->quoteString($datatype), $required, $fieldlength, $weight, $this->_db->quoteString($fieldvalues), $this->_db->quoteString($defaultvalue),$this->_db->quoteString($validation), $id);
 
        return $sql;	    
	}
	
	
	function _deleteQuery(&$obj)
	{
        $sql = sprintf("DELETE FROM %s WHERE id = %u", $this->_db->prefix($this->_dbtable), $obj->getVar($this->id));
	    return $sql;
	}
	
	function insert(&$obj, $force = false)
	{
	    $hFDept =& mldocsGetHandler('archiveFieldDepartment');
        if(!$obj->isNew()) {
            $old_obj =& $this->get($obj->getVar('id'));
            
            $old_name = $old_obj->getVar('fieldname');
            $new_name = $obj->getVar('fieldname');
   
            $add_field = false;
            $alter_table = ($old_name != $new_name) || ($old_obj->getVar('fieldlength') != $obj->getVar('fieldlength')) || ($old_obj->getVar('controltype') != $obj->getVar('controltype')) || ($old_obj->getVar('datatype') != $obj->getVar('datatype'));
        } else {
            $add_field = true;
            $fieldname = $obj->getVar('fieldname');
        }
        
        //Store base object    
        if ($ret = parent::insert($obj, $force)) {
            //Update Joiner Records
            $ret2 = $hFDept->removeFieldFromAllDept($obj->getVar('id'));
        
            $depts =& $obj->getDepartments();
        
            if (count($depts)) {
                $ret = $hFDept->addDepartmentToField($depts, $obj->getVar('id'));
            }
        
            $mysql =& $this->_MysqlDBType($obj); 
        
            if ($add_field) {
                mldocsAddDBField('mldocs_archive_values', $fieldname, $mysql['fieldtype'], $mysql['length']);
            } elseif ($alter_table) {
                mldocsRenameDBField('mldocs_archive_values', $old_name, $new_name, $mysql['fieldtype'], $mysql['length']);
            }
        }
        return $ret;
            
	}
	
	function delete($obj, $force=false)
	{
	    //Remove FieldDepartment Records
        $hFDept =& mldocsGetHandler('archiveFieldDepartment');
        if (!$ret = $hFDept->removeFieldFromAllDept($obj, $force)) {
            $obj->setErrors('Unable to remove field from departments');
        }
        
        //Remove values from archive values table
        if (!$ret = mldocsRemoveDBField('mldocs_archive_values', $obj->getVar('fieldname'))) {
            $obj->setErrors('Unable to remove field from archive values table');
        }
        
        //Remove obj from table
        $ret = parent::delete($obj, $force);
        return $ret;
    }        
    
    function getByDept($dept)
    {
        $hFieldDept =& mldocsGetHandler('archiveFieldDepartment', 'mldocs');
        $ret =& $hFieldDept->fieldsByDepartment($dept);
        return $ret;
    }
    
    function _mysqlDBType($obj)
    {
        
        $controltype = $obj->getVar('controltype');
        $datatype    = $obj->getVar('datatype');
        $fieldlength = $obj->getVar('fieldlength');
        
        $mysqldb = array();
        $mysqldb['length'] = $fieldlength;
        switch ($controltype)
        {
            case MLDOCS_CONTROL_TXTBOX:
                
                switch($datatype)
                {
                    case _MLDOCS_DATATYPE_TEXT:
                        if ($fieldlength <=255) {
                            $mysqldb['fieldtype'] = 'VARCHAR';
                        } elseif ($fieldlength <= 65535) {
                            $mysqldb['fieldtype'] = 'TEXT';
                        } elseif ($fieldlength <= 16777215) {
                            $mysqldb['fieldtype'] = 'MEDIUMTEXT';
                        } else {
                            $mysqldb['fieldtype'] = 'LONGTEXT';
                        }
                        break;  
                
                    case _MLDOCS_DATATYPE_NUMBER_INT:
                        $mysqldb['fieldtype'] = 'INT';
                        $mysqldb['length'] = 0;
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_DEC:
                        $mysqldb['fieldtype'] = 'DECIMAL';
                        $mysqldb['length'] = '7,4';
                        
                    default:
                        $mysqldb['fieldtype'] = 'VARCHAR';
                        $mysqldb['length'] = 255;
                        break;
                }
                break;
            
            case MLDOCS_CONTROL_TXTAREA:
                if ($fieldlength <=255) {
                    $mysqldb['fieldtype'] = 'VARCHAR';
                } elseif ($fieldlength  <= 65535) {
                    $mysqldb['fieldtype'] = 'TEXT';
                    $mysqldb['length'] = 0;
                } elseif ($fieldlength <= 16777215) {
                    $mysqldb['fieldtype'] = 'MEDIUMTEXT';
                    $mysqldb['length'] = 0;
                } else {
                    $mysqldb['fieldtype'] = 'LONGTEXT';
                    $mysqldb['length'] = 0;
                }
                break;
            
            case MLDOCS_CONTROL_SELECT:
                switch($datatype)
                {
                    case _MLDOCS_DATATYPE_TEXT:
                         if ($fieldlength <=255) {
                            $mysqldb['fieldtype'] = 'VARCHAR';
                        } elseif ($fieldlength <= 65535) {
                            $mysqldb['fieldtype'] = 'TEXT';
                        } elseif ($fieldlength <= 16777215) {
                            $mysqldb['fieldtype'] = 'MEDIUMTEXT';
                        } else {
                            $mysqldb['fieldtype'] = 'LONGTEXT';
                        }
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_INT:
                        $mysqldb['fieldtype'] = 'INT';
                        $mysqldb['length'] = 0;
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_DEC:
                        $mysqldb['fieldtype'] = 'DECIMAL';
                        $mysqldb['length'] = '7,4';
                        
                    default:
                        $mysqldb['fieldtype'] = 'VARCHAR';
                        $mysqldb['length'] = 255;
                        break;
                }
                break;
            
            case MLDOCS_CONTROL_YESNO:
                $mysqldb['fieldtype'] = 'TINYINT';
                $mysqldb['length'] = 1;
                break;
                
            case MLDOCS_CONTROL_RADIOBOX:
                switch($datatype)
                {
                    case _MLDOCS_DATATYPE_TEXT:
                         if ($fieldlength <=255) {
                            $mysqldb['fieldtype'] = 'VARCHAR';
                        } elseif ($fieldlength <= 65535) {
                            $mysqldb['fieldtype'] = 'TEXT';
                        } elseif ($fieldlength <= 16777215) {
                            $mysqldb['fieldtype'] = 'MEDIUMTEXT';
                        } else {
                            $mysqldb['fieldtype'] = 'LONGTEXT';
                        }
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_INT:
                        $mysqldb['fieldtype'] = 'INT';
                        $mysqldb['length'] = 0;
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_DEC:
                        $mysqldb['fieldtype'] = 'DECIMAL';
                        $mysqldb['length'] = '7,4';
                        
                    default:
                        $mysqldb['fieldtype'] = 'VARCHAR';
                        $mysqldb['length'] = 255;
                        break;
                }
                break;
                
            case MLDOCS_CONTROL_DATETIME:
                $mysqldb['fieldtype'] = 'INT';
                $mysqldb['length'] = 0;
                break;
            
            case MLDOCS_CONTROL_FILE:
                $mysqldb['fieldtype'] = 'VARCHAR';
                $mysqldb['length'] = 255;
                break;
             
            default:
                $mysqldb['fieldtype'] = 'VARCHAR';
                $mysqldb['length'] = 255;
                break;
        }
        return $mysqldb;           
    }
}
?>