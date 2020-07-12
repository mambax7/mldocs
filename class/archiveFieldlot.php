<?php
//$Id: archiveFieldlots.php,v 1.11 2005/09/07 14:56:56 gabybob Exp $
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
 * mldocsArchiveFieldlot class
 *
 * Metadata that represents a custom field created for mldocs
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
class mldocsArchiveFieldlot extends XoopsObject
{
    var $_profilelots = array();
    /**
     * Class Constructor
     *
     * @param mixed $id null for a new object, hash table for an existing object
     * @return none
     * @access public
     */
    function mldocsArchiveFieldlot($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 64);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('fieldname', XOBJ_DTYPE_TXTBOX, null, true, 64);
        $this->initVar('controltype', XOBJ_DTYPE_INT,  MLDOCS_CONTROL_TXTBOX, true);
        $this->initVar('datatype', XOBJ_DTYPE_TXTBOX, null, true, 64);
        $this->initVar('required', XOBJ_DTYPE_INT, false, true);
        $this->initVar('fieldlotlength', XOBJ_DTYPE_INT, 255, true);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('fieldlotvalues', XOBJ_DTYPE_ARRAY, null, false);
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
     * Get the array of possible values for this custom fieldlot
     * @return array A hash table of name/value pairs for the fieldlot
     * @access public
     */
    function getValues()
    {
        $this->getVar('fieldlotvalues');           
    }
    
    function addValidator($validator)
    {
        
    }
    
    function setValues($val_arr)
    {
        $this->setVar('fieldlotvalues', $val_arr);
    }
    
    function addValues($val_arr) 
    {
        if (is_array($val_arr)) {
            $values = @$this->getVar('fieldlotvalues');
            if (!is_array($values)) {
                $values = array();
            }
            foreach ($val_arr as $value=>$desc) {
                $values[$value] = $desc;
            }
            $this->setVar('fieldlotvalues', $values);
        }
    }
    
    function addValue($desc, $value=null)
    {
        //Add value to array
        $values =& $this->getVar('fieldlotvalues');  
        $values[$desc] = $value;
        $this->setVar('fieldlotvalues', $values);
    }
    
    
    function addDepartment($profil)
    {
        $profil = intval($profil);
        $this->_profilelots[$profil] = $profil;    
    }
    
    function addProfilelots(&$profil_arr)
    {
        if (!is_array($profil_arr) || count($profil_arr) == 0) {
            return false;
        }
        foreach ($profil_arr as $profil)
        {
            $profil = intval($profil);
            $this->_profilelots[$profil] = $profil;      
        }
    }
    
    function removeProfilelot($profil)
    {
        $profil = intval($profil);
        $this->_profilelots[$profil] = 0;
    }
    
    function &getProfilelots()
    {
        return $this->_profilelots;
    }
}

class mldocsArchiveFieldlotHandler extends mldocsBaseObjectHandler
{
    /**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	 var $classname = 'mldocsArchiveFieldlot';
	
	/**
	 * DB Table Name
	 *
	 * @var 		string
	 * @access 	private
	 */
	var $_dbtable = 'mldocs_archive_fieldlots';
	var $id = 'id';
	
	/**
	 * Constructor
	 *
	 * @param	object   $db    reference to a xoopsDB object
	 */
	function mldocsArchiveFieldlotHandler(&$db) 
	{
		parent::init($db);
    } 
	
	function _insertQuery(&$obj)
	{
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, name, description, fieldlotname, controltype, datatype, required, fieldlotlength, weight, fieldlotvalues, defaultvalue, validation)
            VALUES (%u, %s, %s, %s, %u, %s, %u, %u, %s, %s, %s, %s)", $this->_db->prefix($this->_dbtable), $id,
            $this->_db->quoteString($name), $this->_db->quoteString($description), $this->_db->quoteString($fieldlotname), $controltype, $this->_db->quoteString($datatype),
            $required, $fieldlotlength, $weight, $this->_db->quoteString($fieldlotvalues), $this->_db->quoteString($defaultvalue), $this->_db->quoteString($validation));
            
        return $sql;
	    
	}
	
	function _updateQuery(&$obj)
	{
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET name = %s, description = %s, fieldlotname = %s, controltype = %u, datatype = %s, required = %u, fieldlotlength = %u, weight = %u, fieldlotvalues = %s,
            defaultvalue = %s, validation = %s WHERE id = %u", $this->_db->prefix($this->_dbtable),
            $this->_db->quoteString($name), $this->_db->quoteString($description), $this->_db->quoteString($fieldlotname), $controltype, 
            $this->_db->quoteString($datatype), $required, $fieldlotlength, $weight, $this->_db->quoteString($fieldlotvalues), $this->_db->quoteString($defaultvalue),$this->_db->quoteString($validation), $id);
 
        return $sql;	    
	}
	
	
	function _deleteQuery(&$obj)
	{
        $sql = sprintf("DELETE FROM %s WHERE id = %u", $this->_db->prefix($this->_dbtable), $obj->getVar($this->id));
	    return $sql;
	}
	
	function insert(&$obj, $force = false)
	{
	    $hFProfil =& mldocsGetHandler('archiveFieldlotProfilelot');
        if(!$obj->isNew()) {
            $old_obj =& $this->get($obj->getVar('id'));
            
            $old_name = $old_obj->getVar('fieldlotname');
            $new_name = $obj->getVar('fieldlotname');
   
            $add_fieldlot = false;
            $alter_table = ($old_name != $new_name) || ($old_obj->getVar('fieldlotlength') != $obj->getVar('fieldlotlength')) || ($old_obj->getVar('controltype') != $obj->getVar('controltype')) || ($old_obj->getVar('datatype') != $obj->getVar('datatype'));
        } else {
            $add_fieldlot = true;
            $fieldlotname = $obj->getVar('fieldlotname');
        }
        
        //Store base object    
        if ($ret = parent::insert($obj, $force)) {
            //Update Joiner Records
            $ret2 = $hFProfil->removeFieldlotFromAllProfil($obj->getVar('id'));
        
            $profils =& $obj->getProfilelots();
        
            if (count($profils)) {
                $ret = $hFProfil->addProfilelotToFieldlot($profils, $obj->getVar('id'));
            }
        
            $mysql =& $this->_MysqlDBType($obj); 
        
            if ($add_fieldlot) {
                mldocsAddDBFieldlot('mldocs_archive_values', $fieldlotname, $mysql['fieldlottype'], $mysql['length']);
            } elseif ($alter_table) {
                mldocsRenameDBFieldlot('mldocs_archive_values', $old_name, $new_name, $mysql['fieldlottype'], $mysql['length']);
            }
        }
        return $ret;
            
	}
	
	function delete($obj, $force=false)
	{
	    //Remove FieldlotProfilelot Records
        $hFProfil =& mldocsGetHandler('archiveFieldlotProfilelot');
        if (!$ret = $hFProfil->removeFieldlotFromAllProfil($obj, $force)) {
            $obj->setErrors('Unable to remove fieldlot from profilelots');
        }
        
        //Remove values from archive values table
        if (!$ret = mldocsRemoveDBFieldlot('mldocs_archive_values', $obj->getVar('fieldlotname'))) {
            $obj->setErrors('Unable to remove fieldlot from archive values table');
        }
        
        //Remove obj from table
        $ret = parent::delete($obj, $force);
        return $ret;
    }        
    
    function getByProfil($profil)
    {
        $hFieldlotProfil =& mldocsGetHandler('archiveFieldlotProfilelot', 'mldocs');
        $ret =& $hFieldlotlotProfil->fieldlotsByProfilelot($profil);
        return $ret;
    }
    
    function _mysqlDBType($obj)
    {
        
        $controltype = $obj->getVar('controltype');
        $datatype    = $obj->getVar('datatype');
        $fieldlotlength = $obj->getVar('fieldlotlength');
        
        $mysqldb = array();
        $mysqldb['length'] = $fieldlotlength;
        switch ($controltype)
        {
            case MLDOCS_CONTROL_TXTBOX:
                
                switch($datatype)
                {
                    case _MLDOCS_DATATYPE_TEXT:
                        if ($fieldlotlength <=255) {
                            $mysqldb['fieldlottype'] = 'VARCHAR';
                        } elseif ($fieldlotlength <= 65535) {
                            $mysqldb['fieldlottype'] = 'TEXT';
                        } elseif ($fieldlotlength <= 16777215) {
                            $mysqldb['fieldlottype'] = 'MEDIUMTEXT';
                        } else {
                            $mysqldb['fieldlottype'] = 'LONGTEXT';
                        }
                        break;  
                
                    case _MLDOCS_DATATYPE_NUMBER_INT:
                        $mysqldb['fieldlottype'] = 'INT';
                        $mysqldb['length'] = 0;
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_DEC:
                        $mysqldb['fieldlottype'] = 'DECIMAL';
                        $mysqldb['length'] = '7,4';
                        
                    default:
                        $mysqldb['fieldlottype'] = 'VARCHAR';
                        $mysqldb['length'] = 255;
                        break;
                }
                break;
            
            case MLDOCS_CONTROL_TXTAREA:
                if ($fieldlotlength <=255) {
                    $mysqldb['fieldlottype'] = 'VARCHAR';
                } elseif ($fieldlotlength  <= 65535) {
                    $mysqldb['fieldlottype'] = 'TEXT';
                    $mysqldb['length'] = 0;
                } elseif ($fieldlotlength <= 16777215) {
                    $mysqldb['fieldlottype'] = 'MEDIUMTEXT';
                    $mysqldb['length'] = 0;
                } else {
                    $mysqldb['fieldlottype'] = 'LONGTEXT';
                    $mysqldb['length'] = 0;
                }
                break;
            
            case MLDOCS_CONTROL_SELECT:
                switch($datatype)
                {
                    case _MLDOCS_DATATYPE_TEXT:
                         if ($fieldlotlength <=255) {
                            $mysqldb['fieldlottype'] = 'VARCHAR';
                        } elseif ($fieldlotlength <= 65535) {
                            $mysqldb['fieldlottype'] = 'TEXT';
                        } elseif ($fieldlotlength <= 16777215) {
                            $mysqldb['fieldlottype'] = 'MEDIUMTEXT';
                        } else {
                            $mysqldb['fieldlottype'] = 'LONGTEXT';
                        }
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_INT:
                        $mysqldb['fieldlottype'] = 'INT';
                        $mysqldb['length'] = 0;
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_DEC:
                        $mysqldb['fieldlottype'] = 'DECIMAL';
                        $mysqldb['length'] = '7,4';
                        
                    default:
                        $mysqldb['fieldlottype'] = 'VARCHAR';
                        $mysqldb['length'] = 255;
                        break;
                }
                break;
            
            case MLDOCS_CONTROL_YESNO:
                $mysqldb['fieldlottype'] = 'TINYINT';
                $mysqldb['length'] = 1;
                break;
                
            case MLDOCS_CONTROL_RADIOBOX:
                switch($datatype)
                {
                    case _MLDOCS_DATATYPE_TEXT:
                         if ($fieldlotlength <=255) {
                            $mysqldb['fieldlottype'] = 'VARCHAR';
                        } elseif ($fieldlotlength <= 65535) {
                            $mysqldb['fieldlottype'] = 'TEXT';
                        } elseif ($fieldlotlength <= 16777215) {
                            $mysqldb['fieldlottype'] = 'MEDIUMTEXT';
                        } else {
                            $mysqldb['fieldlottype'] = 'LONGTEXT';
                        }
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_INT:
                        $mysqldb['fieldlottype'] = 'INT';
                        $mysqldb['length'] = 0;
                        break;
                    
                    case _MLDOCS_DATATYPE_NUMBER_DEC:
                        $mysqldb['fieldlottype'] = 'DECIMAL';
                        $mysqldb['length'] = '7,4';
                        
                    default:
                        $mysqldb['fieldlottype'] = 'VARCHAR';
                        $mysqldb['length'] = 255;
                        break;
                }
                break;
                
            case MLDOCS_CONTROL_DATETIME:
                $mysqldb['fieldlottype'] = 'INT';
                $mysqldb['length'] = 0;
                break;
            
            case MLDOCS_CONTROL_FILE:
                $mysqldb['fieldlottype'] = 'VARCHAR';
                $mysqldb['length'] = 255;
                break;
             
            default:
                $mysqldb['fieldlottype'] = 'VARCHAR';
                $mysqldb['length'] = 255;
                break;
        }
        return $mysqldb;           
    }
}
?>
