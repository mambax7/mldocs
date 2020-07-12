<?php
//$Id: file.php,v 1.12 2005/08/17 21:07:14 eric_juden Exp $
// modifications par BYOOS solutions le 10 mai 2006 Gabriel
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
 * mldocsFile class
 *
 * @author Eric Juden <ericj@epcusa.com> 
 * @access public
 * @package mldocs
 */
 
 class mldocsFile extends XoopsObject {
    function mldocsFile($id = null) 
	{
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('archiveid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('responseid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('mimetype', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('checksumSHA1', XOBJ_DTYPE_TXTBOX, null, true, 255);
        
        if (isset($id)) {
			if (is_array($id)) {
				$this->assignVars($id);
			}
		} else {
			$this->setNew();
		}
	}
	
	function getFilePath()
	{
	    $path = MLDOCS_UPLOADS_PATH . '/'. $this->getVar('filename');
	    return $path;
	}
	
	function rename($archiveid, $responseid = 0)
	{
	    $archiveid = intval($archiveid);
	    $responseid = intval($responseid);
	    $old_archiveid = $this->getVar('archiveid');
	    $old_responseid = $this->getVar('responseid');
	    
	    $filename = $this->getVar('filename');
	    if(($old_responseid != 0) && ($responseid != 0)){   // Was a response and is going to be a response
	        $newFilename = str_replace("_".$old_responseid."_", "_".$responseid."_", $filename);
	        $newFilename = str_replace($old_archiveid."_", $archiveid."_", $newFilename);
	    } elseif(($old_responseid != 0) && ($responseid == 0)){ // Was a response and is part of the archive now
	        $newFilename = str_replace("_".$old_responseid."_", "_", $filename);
	        $newFilename = str_replace($old_archiveid."_", $archiveid."_", $newFilename);
	    } elseif(($old_responseid == 0) && ($responseid != 0)){  // Was part of the archive, now going to a response
	        $newFilename = str_replace($old_archiveid."_", $archiveid."_".$responseid."_", $filename);
	    } elseif(($old_responseid == 0) && ($responseid == 0)){  // Was part of the archive, and is part of the archive now
	        $newFilename = str_replace($old_archiveid."_", $archiveid."_", $filename);
	    }
	    
	    $hFile =& mldocsGetHandler('file');
	    $this->setVar('filename', $newFilename);
	    $this->setVar('archiveid', $archiveid);
	    $this->setVar('responseid', $responseid);
	    if($hFile->insert($this, true)){
	        $success = true;
	    } else {
	        $success = false;
	    }
	    
	    $ret = false;
	    if($success){
	        $ret = $this->renameAtFS($filename, $newFilename);
	    }
	    return $ret;
	}
	
	function renameAtFS($oldName, $newName)
	{
	    $ret = rename(MLDOCS_UPLOADS_PATH."/".$oldName, MLDOCS_UPLOADS_PATH."/".$newName);
	    
	    return $ret;
	}
	
}   //end of class

/**
 * mldocsFileHandler class
 *
 * File Handler for mldocsFile class
 *
 * @author Eric Juden <ericj@epcusa.com>
 * @access public
 * @package mldocs
 */
 
class mldocsFileHandler extends mldocsBaseObjectHandler {

	/**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	var $classname = 'mldocsfile';
	
    /**
     * DB table name
     * 
     * @var string
     * @access private
     */
     var $_dbtable = 'mldocs_files';
	
	/**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */	
	function mldocsFileHandler(&$db)
	{
	    parent::init($db);
    }
    
    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, filename, archiveid, responseid, mimetype,checksumSHA1) VALUES (%u, %s, %u, %d, %s, %s)",
            $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($filename), $archiveid, $responseid, $this->_db->quoteString($mimetype), $this->_db->quoteString($checksumSHA1));
            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET filename = %s, archiveid = %u, responseid = %d, mimetype = %s, checksumSHA1 = %s WHERE id = %u",
            $this->_db->prefix($this->_dbtable), $this->_db->quoteString($filename), $archiveid, $responseid, $this->_db->quoteString($mimetype), $this->_db->quoteString($checksumSHA1), $id);        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf("DELETE FROM %s WHERE id = %u", $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        return $sql;
    }
    
    function delete(&$obj, $force = false)
    {
        if(!$this->unlinkFile($obj->getFilePath())){
            return false;
        }
        $ret = parent::delete($obj, $force);           
        
        return $ret;
    }
    	
    /**
	 * delete file matching a set of conditions
	 * 
	 * @param object $criteria {@link CriteriaElement} 
	 * @return bool FALSE if deletion failed
	 * @access	public	 
	 */
	function deleteAll($criteria = null)
	{
	    $files =& $this->getObjects($criteria);
	    foreach($files as $file){
	        $this->unlinkFile($file->getFilePath());
	    }
	    
		$sql = 'DELETE FROM '.$this->_db->prefix($this->_dbtable);
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->_db->queryF($sql)) {
			return false;
		}
		return true;
	}
	
	function unlinkFile($file)
	{
	    $ret = false;
        if (is_file($file)) {
            $ret = unlink($file);
        }
	    
	    return $ret;
	}
}
?>
