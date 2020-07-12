<?php
//$Id: responses.php,v 1.17 2005/11/01 15:05:42 eric_juden Exp $
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
 * mldocsResponses class
 *
 * @author Eric Juden <ericj@epcusa.com> 
 * @access public
 * @package mldocs
 */
class mldocsResponses extends XoopsObject {
    function mldocsResponses($id = null) 
	{
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('archiveid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('message', XOBJ_DTYPE_TXTAREA, null, false, 1000000);
        $this->initVar('timeSpent', XOBJ_DTYPE_INT, null, false);
        $this->initVar('updateTime', XOBJ_DTYPE_INT, null, true);
        $this->initVar('userIP', XOBJ_DTYPE_TXTBOX, null, true, 35);
        $this->initVar('private', XOBJ_DTYPE_INT, null, false);
        
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
	function posted($format="l")
	{
		return formatTimestamp($this->getVar('updateTime'), $format);
	}
	
	function storeUpload($post_field, $response = null, $allowed_mimetypes = null) 
	{
	    //global $xoopsModuleConfig, $xoopsUser, $xoopsDB, $xoopsModule;
        include_once (MLDOCS_CLASS_PATH.'/uploader.php');
        $config =& mldocsGetModuleConfig();
        
	    $archiveid = $this->getVar('id');

        if(!isset($allowed_mimetypes)){
            $hMime =& mldocsGetHandler('mimetype');
            $allowed_mimetypes = $hMime->checkMimeTypes();
            if(!$allowed_mimetypes){
                return false;
            }
        }
                        
        $maxfilesize = $config['mldocs_uploadSize'];
        $maxfilewidth = $config['mldocs_uploadWidth'];
        $maxfileheight = $config['mldocs_uploadHeight'];
        if(!is_dir(MLDOCS_UPLOADS_PATH)){
            mkdir(MLDOCS_UPLOADS_PATH, 0757);
        }
        
        $uploader = new XoopsMediaUploader(MLDOCS_UPLOADS_PATH.'/', $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
        if ($uploader->fetchMedia($post_field)) {
            if (!isset($response)) {
                $uploader->setTargetFileName($archiveid."_". $uploader->getMediaName());
            } else {
                $uploader->setTargetFileName($archiveid."_".$response."_".$uploader->getMediaName());
            }
            if ($uploader->upload()) {
                $hFile =& mldocsGetHandler('file');
                $file =& $hFile->create();
                $file->setVar('filename', $uploader->getSavedFileName());
                $file->setVar('archiveid', $archiveid);
                $file->setVar('mimetype', $allowed_mimetypes);
                $file->setVar('responseid', (isset($response) ? intval($response) : 0));
                
                if($hFile->insert($file)){
                    return $file;
                } else {                       
                    return $uploader->getErrors();
                }
             
            } else {
                return $uploader->getErrors();
            }
	    }
	}
	
	function checkUpload($post_field, &$allowed_mimetypes, &$errors)
	{
	    //global $xoopsModuleConfig;
	    include_once (MLDOCS_CLASS_PATH.'/uploader.php');
	    $config =& mldocsGetModuleConfig();
	    $maxfilesize = $config['mldocs_uploadSize'];
        $maxfilewidth = $config['mldocs_uploadWidth'];
        $maxfileheight = $config['mldocs_uploadHeight'];
        $errors = array();
        
        if(!isset($allowed_mimetypes)){
            $hMime =& mldocsGetHandler('mimetype');
            $allowed_mimetypes = $hMime->checkMimeTypes($post_field);
            if(!$allowed_mimetypes){
                $errors[] = _MLDOCS_MESSAGE_WRONG_MIMETYPE;
                return false;
            }
        }
        $uploader = new XoopsMediaUploader(MLDOCS_UPLOADS_PATH.'/', $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
        
        if ($uploader->fetchMedia($post_field)) {
            return true;
        } else {
            $errors = array_merge($errors, $uploader->getErrors(false));
            return false;
        }
	}
}

/**
 * mldocsResponsesHandler class
 *
 * Response Handler for mldocsResponses class
 *
 * @author Eric Juden <ericj@epcusa.com> &
 * @access public
 * @package mldocs
 */
 
class mldocsResponsesHandler extends mldocsBaseObjectHandler {
	/**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	var $classname = 'mldocsresponses';
	
    /**
     * DB table name
     * 
     * @var string
     * @access private
     */
     var $_dbtable = 'mldocs_responses';
	
	/**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */	
	function mldocsResponsesHandler(&$db)
	{
	    parent::init($db);
    }
    
    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, uid, archiveid, message, timeSpent, updateTime, userIP, private) 
            VALUES (%u, %u, %u, %s, %u, %u, %s, %u)", $this->_db->prefix($this->_dbtable), $id, $uid, $archiveid,
            $this->_db->quoteString($message), $timeSpent, time(), $this->_db->quoteString($userIP), $private);
            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET uid = %u, archiveid = %u, message = %s, timeSpent = %u, 
            updateTime = %u, userIP = %s, private = %u WHERE id = %u", $this->_db->prefix($this->_dbtable), $uid, $archiveid,
            $this->_db->quoteString($message), $timeSpent, time(), 
            $this->_db->quoteString($userIP), $private, $id);
            
        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        return $sql;
    }        
	
	/**
	 * delete a response from the database
	 * 
	 * @param object $obj reference to the {@link mldocsResponse} obj to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 * @access	public
	 */
	function delete(&$obj, $force = false)
	{

	    // Remove file associated with this response
	    $hFiles =& mldocsGetHandler('file');
	    $crit = new CriteriaCompo(new Criteria('archiveid', $obj->getVar('archiveid')));
	    $crit->add(new Criteria('responseid', $obj->getVar('responseid')));
	    if(!$hFiles->deleteAll($crit)){
	        return false;
	    }
	    
        $ret = parent::delete($obj, $force);
        return $ret;
	}
	

	/**
	 * Get number of responses by staff members
	 * 
	 * @param int $archiveid archive to get count
	 * @return int Number of staff responses
	 * @access	public	 
	 */
	function getStaffResponseCount($archiveid)
	{
	    $sql = sprintf('SELECT COUNT(*) FROM %s r INNER JOIN %s s ON r.uid = s.uid WHERE r.archiveid = %u', 
	        $this->_db->prefix($this->_dbtable), $this->_db->prefix('mldocs_staff'), $archiveid);
	    
	    $ret = $this->_db->query($sql);
	    
	    list($count) = $this->_db->fetchRow($ret);
	    return $count;
	}
	
}
?>