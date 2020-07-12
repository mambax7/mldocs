<?php
//$Id: mimetype.php,v 1.11 2005/02/28 17:39:04 eric_juden Exp $
// modification BYOOS le 25 avril 2006 gabriel
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
 * mldocsMimetype class
 *
 * Information about an individual mimetype
 *
 * <code>
 * $hMime =& mldocsGetHandler('mimetype', 'mldocs');
 * $mimetype =& $hMime->get(1);
 * $mime_id = $mimetype->getVar('id');
 * </code>
 *
 * @author Eric Juden <ericj@epcusa.com>
 * @access public
 * @package mldocs
 */

class mldocsMimetype extends XoopsObject {
    function mldocsMimetype($id = null)
    {
        $this->initVar('mime_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('mime_ext', XOBJ_DTYPE_TXTBOX, null, true, 60);
        $this->initVar('mime_types', XOBJ_DTYPE_TXTAREA, null, false, 1024);
        $this->initVar('mime_name', XOBJ_DTYPE_TXTBOX, NULL, true, 255);
        $this->initVar('mime_admin', XOBJ_DTYPE_INT, null, false);
        $this->initVar('mime_user', XOBJ_DTYPE_INT, null, false);
       
        if (isset($id)) {
		    if (is_array($id)) {
			    $this->assignVars($id);
			}
		} else {
			$this->setNew();
		} 
    }
}   // end of class

class mldocsMimetypeHandler extends mldocsBaseObjectHandler {
    /**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	 var $classname = 'mldocsmimetype';
	
	/**
	 * DB Table Name
	 *
	 * @var string
	 * @access private
	 */
	var $_dbtable = 'mldocs_mimetypes';
	
	/**
	 * Constructor
	 *
	 * @param object $db reference to a xoopsDB object
	 */
	function mldocsMimetypeHandler(&$db) 
	{
		parent::init($db);
	}
    
    /**
	 * retrieve a mimetype object from the database
	 * @param	int	$id	ID of mimetype
	 * @return	object	{@link mldocsMimetype}
	 * @access	public
	 */
	function &get($id)
	{
		$id = intval($id);
		if ($id > 0) {
			$sql = $this->_selectQuery(new Criteria('mime_id', $id));
			if (!$result = $this->_db->query($sql)) {
				return false;
			}
			$numrows = $this->_db->getRowsNum($result);
			if ($numrows == 1) {
				$obj = new $this->classname($this->_db->fetchArray($result));
				return $obj;
			}
		}
		return false;
	}
	
	/**
	 * retrieve objects from the database
	 * 
	 * @param object $criteria {@link CriteriaElement} conditions to be met
	 * @return array array of {@link mldocsMimetype} objects
	 * @access	public	
	 */	
	function &getObjects($criteria = null)
	{
		$ret    = array();
		$limit  = $start = 0;
		$sql    = $this->_selectQuery($criteria);
		if (isset($criteria)) {		
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}

		$result = $this->_db->query($sql, $limit, $start);
		// If no records from db, return empty array
		if (!$result) {
			return $ret;
		}
		
		// Add each returned record to the result array
		while ($myrow = $this->_db->fetchArray($result)) {
			$obj = new $this->classname($myrow);
			$ret[] =& $obj;
			unset($obj);
		}
		return $ret;
	}
	
	/**
	 * Format mime_types into array
	 * 
	 * @return array array of mime_types
	 * @access public
	 */
	function getArray($mime_ext = null)
	{
	    global $xoopsUser, $xoopsModule, $isStaff;
	    
	    $ret = array();
	    if ($xoopsUser && !$isStaff){
            // For user uploading
            $crit = new CriteriaCompo(new Criteria('mime_user', 1));   //$sql = sprintf("SELECT * FROM %s WHERE mime_user=1", $xoopsDB->prefix('mldocs_mimetypes'));   
        } elseif ($xoopsUser && $isStaff){
            // For staff uploading
            $crit = new CriteriaCompo(new Criteria('mime_admin', 1));  //$sql = sprintf("SELECT * FROM %s WHERE mime_admin=1", $xoopsDB->prefix('mldocs_mimetypes'));
        } else {
            return $ret;
        }
        if($mime_ext){
            $crit->add(new Criteria('mime_ext', $mime_ext));
        }
        $result =& $this->getObjects($crit);
        
        // If no records from db, return empty array
		if (!$result) {
			return $ret;
		}
		
		foreach($result as $mime){
		    $line = split(" ", $mime->getVar('mime_types'));
		    foreach($line as $row){
		        $allowed_mimetypes[] = array('type'=>$row, 'ext'=>$mime->getVar('mime_ext'));
		       
        }
		}
		return $allowed_mimetypes;
	}
   /**
    * Checks to see if the user uploading the file has permissions to upload this mimetype
    * @param $post_field file being uploaded
    * @return false if no permission, return mimetype if has permission
    * @access public
    */
	function checkMimeTypes($post_field)
	{
 global $_FILES, $_xFILES, $FlagTypeUpload;

  //echo "entre dand la fonction checkMimeTypes<br>";

	if (!$FlagTypeUpload){ // Upload manuel INPUT form
       $fname = $_FILES[$post_field]['name'];
       $_tmpFILES = $_FILES;
        } else { // si Upload automatique
        $fname = $_xFILES[$post_field]['name'];
        $_tmpFILES = $_xFILES;
        }
	      $farray = explode('.', $fname);
        $fextension = strtolower($farray[count($farray) -1]);
	    
        $allowed_mimetypes = $this->getArray();
        if(empty($allowed_mimetypes)){
            return false;
        }
        
        foreach($allowed_mimetypes as $mime){
            //echo "nom file :".$_tmpFILES[$post_field]['name']."<br>";
            //echo "mime type :".$mime['type']."<br>";
            //echo "mime type du fichier :".$_tmpFILES[$post_field]['type']."<br><br>";
            
            if($mime['type'] == $_tmpFILES[$post_field]['type']){
                $allowed_mimetypes = $mime['type'];
                break;   
            } else {
                $allowed_mimetypes = false;
            }
         
        }
        return $allowed_mimetypes;
    }

	   /**gestion du type mime en fonction de l extension 18 04 2006 gabriel
    * read the mime type function 
    * @param $filename file being uploaded
    * @return false if no exist, return mimetype if exist
    * @access public
  */  
	function checkxMimeTypes($fname)
	{
	$mime_type = array();
	$farray = explode('.', $fname);
  $fextension = strtolower($farray[count($farray) -1]);
  if($fextension){
        $crit = new CriteriaCompo(new Criteria('mime_ext', $fextension)); 
   }
    $result =& $this->getObjects($crit);
        
    // If no records from db, return empty array
		if (!$result) {
			return $ret;
		}
   if(count($result) ==1){
      	foreach($result as $mime){
          $mime_type = split(" ", $mime->getVar('mime_types'));
        }
   }  else {
    return false;
   }  
        return $mime_type[0];
}


	/**
	 * Create a "select" SQL query
	 * @param object $criteria {@link CriteriaElement} to match
	 * @return	string SQL query
	 * @access	private
	 */	
	function _selectQuery($criteria = null, $join = false)
	{
		if(!$join){
    		$sql = sprintf('SELECT * FROM %s', $this->_db->prefix($this->_dbtable));
	    } else {
	        $sql = sprintf("SELECT t.* FROM %s t INNER JOIN %s j ON t.department = j.department", $this->_db->prefix('mldocs_archives'), $this->_db->prefix('mldocs_jStaffDept')); 
	    }
	    if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
		}
		return $sql;
	}
	
	function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        $sql = sprintf("INSERT INTO %s (mime_id, mime_ext, mime_types, mime_name, mime_admin, mime_user) VALUES
               (%u, %s, %s, %s, %u, %u)", $this->_db->prefix($this->_dbtable), $mime_id, $this->_db->quoteString($mime_ext),
               $this->_db->quoteString($mime_types), $this->_db->quoteString($mime_name), $mime_admin, $mime_user);
        return $sql;        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        $sql = sprintf("UPDATE %s SET mime_ext = %s, mime_types = %s, mime_name = %s, mime_admin = %u, mime_user = %u WHERE 
               mime_id = %u", $this->_db->prefix($this->_dbtable), $this->_db->quoteString($mime_ext), 
               $this->_db->quoteString($mime_types), $this->_db->quoteString($mime_name), $mime_admin, $mime_user, $mime_id);
        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE mime_id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('mime_id'));
        return $sql;
    }
}   // end class
    
?>
