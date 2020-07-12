<?php
//$Id: archive.php,v 1.73.2.1 2005/11/16 16:04:19 eric_juden Exp $
//     modification  9 mai 2006  BYOOS solutions  gabriel
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
 * mldocsArchive class
 *
 * Information about an individual archive
 *
 * <code>
 * $hArchive =& mldocsGetHandler('archive');
 * $archive =& $hArchive->get(1);
 * $archive_id = $archive->getVar('id');
 * $responses =& $archive->getResponses();
  * echo $archive->lastUpdated();
 * </code>
 *
 * @author Eric Juden <ericj@epcusa.com>
 * @access public
 * @package mldocs
 */

class mldocsArchive extends XoopsObject {
    function mldocsArchive($id = null)
    {
       $this->initVar('id', XOBJ_DTYPE_INT, null, false);
       $this->initVar('uid', XOBJ_DTYPE_INT, null, false); 
       $this->initVar('repid', XOBJ_DTYPE_INT, null, false);  
       $this->initVar('lotid', XOBJ_DTYPE_INT, null, false);   
       $this->initVar('codearchive', XOBJ_DTYPE_TXTBOX, null, true, 15);         // will store Xoops user id
       $this->initVar('subject', XOBJ_DTYPE_TXTBOX, null, true, 100);
       $this->initVar('description', XOBJ_DTYPE_TXTAREA, null, false, 1000000);
       $this->initVar('department', XOBJ_DTYPE_INT, null, false);
       $this->initVar('priority', XOBJ_DTYPE_INT, null, false);
       $this->initVar('status', XOBJ_DTYPE_INT, null, false);
       $this->initVar('lastUpdated', XOBJ_DTYPE_INT, null, false);
       $this->initVar('posted', XOBJ_DTYPE_INT, null, false);
       $this->initVar('ownership', XOBJ_DTYPE_INT, null, false);                // will store Xoops user id
       $this->initVar('closedBy', XOBJ_DTYPE_INT, null, false);                 // will store Xoops user id
       $this->initVar('totalTimeSpent', XOBJ_DTYPE_INT, null, false);
       $this->initVar('userIP', XOBJ_DTYPE_TXTBOX, null, false, 25);
       $this->initVar('elapsed', XOBJ_DTYPE_INT, null, false);
       $this->initVar('lastUpdate', XOBJ_DTYPE_INT, null, false);
       $this->initVar('emailHash',XOBJ_DTYPE_TXTBOX, '', true, 100);
       $this->initVar('email',XOBJ_DTYPE_TXTBOX, '', true, 100);
       $this->initVar('serverid',XOBJ_DTYPE_INT, null, false);                 //will store email server this was picked up from
       $this->initVar('overdueTime', XOBJ_DTYPE_INT, null, false);
          
       if (isset($id)) {
			if (is_array($id)) {
				$this->assignVars($id);
			}
		} else {
			$this->setNew();
		} 
    }
    
    
    /**
	 * retrieve the department object associated with this archive
	 * 
	 * @return object {@link mldocsDepartment} object
	 * @access	public	
	 */	

    function getDepartment()
    {
        $hDept =& mldocsGetHandler('department');
        return $hDept->get($this->getVar('department'));
    }

    /**
  * create an md5 hash based on the ID and emailaddress. Use this as a lookup key when trying to find a archive.
  *
  * @param text $email
  * @return none
  * @access public
  */
  function createEmailHash($email){
    if ($this->getVar('posted')==''){
      $this-setVar('posted',time());
    }
    $hash = $this->getVar('posted').'-'.$email;
    $hash = md5($hash);
    //
    $this->setVar('email',$email);
    $this->setVar('emailHash',$hash);
  }

 
	   /**
	 * setup next repid in  archive object
	 * 
	 * @return array of {@link mldocsArchive} objects
	 * @access	public	
	 */    
    function setNextRepidArchive()
    {
  
            return $repid;
    }

    /**
	 * retrieve all  archive object
	 * 
	 * @return array of {@link mldocsArchive} objects
	 * @access	public	
	 */    
    function getLastRepid()
    {
       $arr = array();
        $hArchives =& mldocsGetHandler('archive');
 
        return $arr ;
    }

    /**
	 * retrieve all files attached to this archive object
	 * 
	 * @return array of {@link mldocsFile} objects
	 * @access	public	
	 */    
    function getFiles()
    {
        $arr = array();
        $id = intval($this->getVar('id'));
        if (!$id) {
            return arr;
        }
        
        $hFiles =& mldocsGetHandler('file');
        $crit   = new CriteriaCompo(new Criteria('archiveid', $id));
        $crit->setSort('responseid');
        $arr =& $hFiles->getObjects($crit);
        
        return $arr;
    }
        
    
    /**
	 * retrieve all responses attached to this archive object
	 * 
	 * @return array of {@link mldocsResponses} objects
	 * @access	public	
	 */	
	function getResponses($limit = 0, $start = 0) 
	{
		$arr = array();
		$id = intval($this->getVar('id'));
		if (!$id) {
			return $arr;
		}
		$hResponses =& mldocsGetHandler('responses');
		$criteria   =& new CriteriaCompo(new Criteria('archiveid', $id));
		$criteria->setSort('updateTime');
		$criteria->setOrder('DESC');
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		
		$arr =& $hResponses->getObjects($criteria);
				
		return $arr;
	}
	
	function getReviews($limit = 0, $start = 0)
	{
	    $arr = array();
	    $id = intval($this->getVar('id'));
	    if(!$id){
	        return $arr;
	    }
	    $hStaffReview =& mldocsGetHandler('staffReview');
	    $crit = new CriteriaCompo(new Criteria('archiveid', $id));
	    $crit->setSort('responseid');
	    $crit->setOrder('DESC');
	    $crit->setLimit($limit);
	    $crit->setStart($start);
	    
	    $arr =& $hStaffReview->getObjects($crit);
	    return $arr;
	}
	
	/**
	 * retrieve all log messages attached to this archive object
	 * 
	 * @return array of {@link mldocsLogMessages} objects
	 * @access	public	
	 */	
	function getLogs($limit = 0, $start = 0)
	{
	    $arr = array();
	    $id = intval($this->getVar('id'));
	    if(!$id) {
	        return $arr;
	    }
	    $hLogMessages =& mldocsGetHandler('logMessage');
	    $criteria     = new CriteriaCompo(new Criteria('archiveid', $id));
	    $criteria->setSort('lastUpdated');
	    $criteria->setOrder('DESC');
	    $criteria->setLimit($limit);
	    $criteria->setStart($start);
	    
	    $arr    =& $hLogMessages->getObjects($criteria);
	    return $arr;
	}
	
	function storeUpload($post_field, $response = null, $allowed_mimetypes = null) 
	{
	    global $xoopsUser, $xoopsDB, $xoopsModule;
        include_once (MLDOCS_CLASS_PATH.'/uploader.php');
        
         //echo "entre dans la fonction storeUpload<br>";
 
        $config =& mldocsGetModuleConfig();
        
	    $archiveid = $this->getVar('id');
	    
      $repstr = mldocsMakeRepstr($this->getVar('repid'));

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
        if(!is_dir(MLDOCS_ARCHIVE_PATH)){
            mkdir(MLDOCS_ARCHIVE_PATH, 0757);
        }
        
        $uploader = new XoopsMediaUploader(MLDOCS_ARCHIVE_PATH.'/'.$repstr.'/', $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
        if ($uploader->fetchMedia($post_field)) {
            if (!isset($response)) {
                $uploader->setTargetFileName($archiveid.$repstr."_". $uploader->getMediaName());
            } else {
                if($response > 0){
                    $uploader->setTargetFileName($archiveid.$repstr."_".$response."_".$uploader->getMediaName());
                } else {
                    $uploader->setTargetFileName($archiveid.$repstr."_". $uploader->getMediaName());
                }
            }
            if ($uploader->upload()) {
                $hFile =& mldocsGetHandler('file');
                $file =& $hFile->create();
                $file->setVar('filename', $uploader->getSavedFileName());
                $file->setVar('archiveid', $archiveid);
                $file->setVar('mimetype', $allowed_mimetypes);
                $file->setVar('checksumSHA1',sha1_file ( $uploader->getMediaTmpName() ));
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
	 global $_FILES, $_xFILES, $FlagTypeUpload;
	          
       //  echo "entre dand la fonction checkUpload<br>"; 

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
        $uploader = new XoopsMediaUploader(MLDOCS_ARCHIVE_PATH.'/', $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
        
        if ($uploader->fetchMedia($post_field)) {
            return true;
        } else {
            $errors = array_merge($errors, $uploader->getErrors(false));
            return false;
        }
	}
	/**
	 * determine last time the archive was updated relative to the current user
	 * 
	 * @return 	int	Timestamp of last update
	 * @access	public	
	 */		
	function lastUpdated($format="l")
	{
		return formatTimestamp($this->getVar('lastUpdated'), $format);
	}
	
	function posted($format="l")
	{
		return formatTimestamp($this->getVar('posted'), $format);
	}
    
    /**
     * return a simplified measurement of elapsed archive time
     *
     * @return string Elapsed time
     * @access public
     */
    function elapsed()
    {
        $tmp = mldocsGetElapsedTime($this->getVar('elapsed'));
        return $this->_prettyElapsed($tmp);
    }
    
    function lastUpdate()
    {
        $tmp = mldocsGetElapsedTime($this->getVar('lastUpdate'));
        return $this->_prettyElapsed($tmp);
    }
    
    function _prettyElapsed($time)
    {
        $useSingle = false;
        
        foreach ($time as $unit=>$value) {
            if ($value) {
                if ($value == 1) {
                    $useSingle = true;
                }
                switch($unit) {
                case 'years':
                    $unit_dsc = ($useSingle ? _MLDOCS_TIME_YEAR :_MLDOCS_TIME_YEARS);
                    break;
                case 'weeks':
                    $unit_dsc = ($useSingle ? _MLDOCS_TIME_WEEK :_MLDOCS_TIME_WEEKS);
                    break;
                case 'days':
                    $unit_dsc = ($useSingle ? _MLDOCS_TIME_DAY : _MLDOCS_TIME_DAYS);
                    break;
                case 'hours':
                    $unit_dsc = ($useSingle ? _MLDOCS_TIME_HOUR : _MLDOCS_TIME_HOURS);
                    break;
                case 'minutes':
                    $unit_dsc = ($useSingle ? _MLDOCS_TIME_MIN : _MLDOCS_TIME_MINS);
                    break;
                case 'seconds':
                    $unit_dsc = ($useSingle ? _MLDOCS_TIME_SEC : _MLDOCS_TIME_SECS);
                    break;
                default:
                    $unit_dsc = $unit;
                    break;
                }
                return "$value $unit_dsc";
                    
            }
        }            
    }
    
   /**
    * Determine if archive is overdue
    *
    * @return boolean
    * @access public
    */
    function isOverdue()
    {
        $config =& mldocsGetModuleConfig();
        $hStatus =& mldocsGetHandler('status');
        if (isset($config['mldocs_overdueTime'])) {
            $overdueTime = $config['mldocs_overdueTime'];
            
            if ($overdueTime) {
                $status =& $hStatus->get($this->getVar('status'));
                if ($status->getVar('state') == 1) {
                    if (time() > $this->getVar('overdueTime')) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    
    function addSubmitter($email, $uid, $suppress = 0)
    {
        $uid = intval($uid);
        
        if($email != ''){
            $hArchiveEmails =& mldocsGetHandler('archiveEmails');
            $tEmail =& $hArchiveEmails->create();
            
            $tEmail->setVar('archiveid', $this->getVar('id'));
            $tEmail->setVar('email', $email);
            $tEmail->setVar('uid', $uid);
            $tEmail->setVar('suppress', $suppress);
            
            if($hArchiveEmails->insert($tEmail)){
                return true;
            }
        }
        return false;
    }
    
    function merge($archive2_id)
    {
        global $xoopsDB;
        $archive2_id = intval($archive2_id);
        
        // Retrieve $archive2
        $hArchive =& mldocsGetHandler('archive');
        $mergeArchive =& $hArchive->get($archive2_id);
        
        // Figure out which archive is older
        if($this->getVar('posted') < $mergeArchive->getVar('posted')){   // If this archive is older than the 2nd archive
            $keepArchive =& $this;
            $loseArchive =& $mergeArchive;
        } else {
            $keepArchive =& $mergeArchive;
            $loseArchive =& $this;
        }

        $keep_id = $keepArchive->getVar('id');
        $lose_id = $loseArchive->getVar('id');

        // Copy archive subject and description of 2nd archive as response to $this archive
        $responseid = $keepArchive->addResponse($loseArchive->getVar('uid'), $keep_id, $loseArchive->getVar('subject', 'e')." - ".$loseArchive->getVar('description', 'e'),
                             $loseArchive->getVar('posted'), $loseArchive->getVar('userIP'));
        
        // Copy 2nd archive file attachments to $this archive
        $hFiles =& mldocsGetHandler('file');
        $crit = new Criteria('archiveid', $lose_id);
        $files =& $hFiles->getObjects($crit);
        foreach($files as $file){
            $file->rename($keep_id, $responseid);
        }
        $success = $hFiles->updateAll('archiveid', $keep_id, $crit);
        
        // Copy 2nd archive responses as responses to $this archive
        $hResponses =& mldocsGetHandler('responses');
        $crit = new Criteria('archiveid', $lose_id);
        $success = $hResponses->updateAll('archiveid', $keep_id, $crit);
        
        // Change file responseid to match the response added to merged archive
        $crit = new CriteriaCompo(new Criteria('archiveid', $lose_id));
        $crit->add(new Criteria('responseid', 0));
        $success = $hFiles->updateAll('responseid', $responseid, $crit);

        // Add 2nd archive submitter to $this archive via archiveEmails table
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new Criteria('archiveid', $lose_id);
        $success = $hArchiveEmails->updateAll('archiveid', $keep_id, $crit);
        
        // Remove $loseArchive
        $crit = new Criteria('id', $lose_id);
        if(!$hArchive->deleteAll($crit)){
            return false;
        }
        return $keep_id;
    }
    
    function &addResponse($uid, $archiveid, $message, $updateTime, $userIP, $private = 0, $timeSpent = 0, $ret_obj = false)
    {
        $uid = intval($uid);
        $archiveid = intval($archiveid);
        $updateTime = intval($updateTime);
        $private = intval($private);
        $timeSpent = intval($timeSpent);
        
        $hResponse =& mldocsGetHandler('responses');
        $newResponse =& $hResponse->create();
        $newResponse->setVar('uid', $uid);
        $newResponse->setVar('archiveid', $archiveid);
        $newResponse->setVar('message', $message);
        $newResponse->setVar('timeSpent', $timeSpent);
        $newResponse->setVar('updateTime', $updateTime);
        $newResponse->setVar('userIP', $userIP);
        $newResponse->setVar('private', $private);
        if($hResponse->insert($newResponse)){
            if($ret_obj){
                return $newResponse;
            } else {
                return $newResponse->getVar('id');
            }
        } 
        return false;
    }
    
    function &getCustFieldValues($includeEmptyValues = false)
    {
        $archiveid = $this->getVar('id');
        
        $hFields = mldocsGetHandler('archiveField');
        $fields =& $hFields->getObjects(null);                  // Retrieve custom fields
        
        $hFieldValues = mldocsGetHandler('archiveValues');
        $values =& $hFieldValues->get($archiveid);               // Retrieve custom field values
        $aCustFields = array();
        if(!empty($values)){                    // If no values for custom fields, don't run loop
            foreach($fields as $field){
                $fileid = '';
                $filename = '';
                
                if($values->getVar($field->getVar('fieldname')) != ""){     // If values for this field has something
                    $fieldvalues = $field->getVar('fieldvalues');           // Set fieldvalues
                    $value = $values->getVar($field->getVar('fieldname'));  // Value of current field
                    
                    if ($field->getVar('controltype') == MLDOCS_CONTROL_YESNO) {
                        $value = (($value == 1) ? _YES : _NO);
                    }
                    
                    if($field->getVar('controltype') == MLDOCS_CONTROL_FILE){
                        $file = split("_", $value);
                        $fileid = $file[0];
                        $filename = $file[1];
                    }
                    
                    if(is_array($fieldvalues)){
                        foreach($fieldvalues as $fkey=>$fvalue){
                            if($fkey == $value){
                                $value = $fvalue;
                            }
                        }
                    }
                
                    $aCustFields[$field->getVar('fieldname')] = 
                        array('id' => $field->getVar('id'),
                              'name' => $field->getVar('name'),
                              'description' => $field->getVar('description'),
                              'fieldname' => $field->getVar('fieldname'),
                              'controltype' => $field->getVar('controltype'),
                              'datatype' => $field->getVar('datatype'),
                              'required' => $field->getVar('required'),
                              'fieldlength' => $field->getVar('fieldlength'),
                              'weight' => $field->getVar('weight'),
                              'fieldvalues' => $fieldvalues,
                              'defaultvalue' => $field->getVar('defaultvalue'),
                              'validation' => $field->getVar('validation'),
                              'value' => $value,
                              'fileid' => $fileid,
                              'filename' => $filename
                             );
                } else {
                    if($includeEmptyValues){
                        $aCustFields[$field->getVar('fieldname')] = 
                            array('id' => $field->getVar('id'),
                                  'name' => $field->getVar('name'),
                                  'description' => $field->getVar('description'),
                                  'fieldname' => $field->getVar('fieldname'),
                                  'controltype' => $field->getVar('controltype'),
                                  'datatype' => $field->getVar('datatype'),
                                  'required' => $field->getVar('required'),
                                  'fieldlength' => $field->getVar('fieldlength'),
                                  'weight' => $field->getVar('weight'),
                                  'fieldvalues' => $field->getVar('fieldvalues'),
                                  'defaultvalue' => $field->getVar('defaultvalue'),
                                  'validation' => $field->getVar('validation'),
                                  'value' => '',
                                  'fileid' => $fileid,
                                  'filename' => $filename
                                 );
                    }
                }
            }
        }
        
        return $aCustFields;
    }
    
}   // end of class

class mldocsArchiveHandler extends mldocsBaseObjectHandler{
    /**
     * Name of child class
     * 
     * @var	string
     * @access	private
     */
	 var $classname = 'mldocsarchive';
	
	/**
	 * DB Table Name
	 *
	 * @var 		string
	 * @access 	private
	 */
	var $_dbtable = 'mldocs_archives';
	
	/**
	 * Constructor
	 *
	 * @param	object   $db    reference to a xoopsDB object
	 */
	function mldocsArchiveHandler(&$db) 
	{
		parent::init($db);
	}
		
	/**
    * retrieve an object from the database, based on. use in child classes
    * @param int $id ID
    * @return mixed object if id exists, false if not
    * @access public
    */
    function &get($id)
    {
        $id = intval($id);
        if($id > 0) {
            $sql = $this->_selectQuery(new Criteria('id', $id, '=', 't'));
            if(!$result = $this->_db->query($sql)) {
                return false;
            }
            $numrows = $this->_db->getRowsNum($result);
            if($numrows == 1) {
                $obj = new $this->classname($this->_db->fetchArray($result));
                return $obj;
            }
        }
        return false;
    }	
	
	/**
     * find a archive based on a hash
     *
     * @param text $hash
     * @return archive object
     * @access public
     */
    function getArchiveByHash($hash) {
        $sql = $this->_selectQuery(new Criteria('emailHash', $hash, '=', 't'));
        if(!$result = $this->_db->query($sql)) {
            return false;
        }
        $numrows = $this->_db->getRowsNum($result);
        if($numrows == 1) {
            $obj = new $this->classname($this->_db->fetchArray($result));
            return $obj;
        }
    }
    	
	/**
	* Retrieve the list of departments for the specified archives
	* @param mixed $archives can be a single value or array consisting of either archiveids or archive objects
	* @return array array of integers representing the ids of each department
	* @access public
	*/
	function getArchiveDepartments($archives)
	{
	    $a_archives = array();
	    $a_depts = array();
	    if (is_array($archives)) {
	        foreach ($archives as $archive) {
	            if (is_object($archive)) {
	                $a_archives[] = $archive->getVar('id');
	            } else {
	                $a_archives[] = intval($archive);
	            }
	         }
	     } else {
	        if (is_object($archives)) {
	            $a_archives[] = $archives->getVar('id');
	        } else {
	            $a_archives[] = intval($archives);
	        }
	     }
	     
	     $sql = sprintf('SELECT DISTINCT department FROM %s WHERE id IN (%s)', $this->_db->prefix('mldocs_archives'), implode($a_archives, ','));
	     $ret = $this->_db->query($sql);
	     
	     while ($temp = $this->_db->fetchArray($ret)) {
	        $a_depts[] = $temp['department'];
	     }
	     return $a_depts;	     
	}
	
	function &getObjectsByStaff($crit, $id_as_key = false, $hasCustFields = false) 
	{
        $sql = $this->_selectQuery($crit, true, $hasCustFields);
        if (is_object($crit)) {
            $limit = $crit->getLimit();
            $start = $crit->getStart();
        }
        
        $ret = $this->_db->query($sql, $limit, $start);
        $arr = array();
        while ($temp = $this->_db->fetchArray($ret)) {
            $archives = $this->create();
            $archives->assignVars($temp);
            if ($id_as_key) {
                $arr[$archives->getVar('id')] = $archives;
            } else {
                $arr[] = $archives;
            }
            unset($archives);
        }
        return $arr;
    }
    
    function &getMyUnresolvedArchives($uid, $id_as_key = false)
    {
        $uid = intval($uid);
        
        // Get all archiveEmail objects where $uid is found
        $hArchiveEmails =& mldocsGetHandler('archiveEmails');
        $crit = new Criteria('uid', $uid);
        $archiveEmails =& $hArchiveEmails->getObjectsSortedByArchive($crit);
        
        // Get friendly array of all archiveids needed
        $aArchiveEmails = array();
        foreach($archiveEmails as $archiveEmail){
            $aArchiveEmails[$archiveEmail->getVar('archiveid')] = $archiveEmail->getVar('archiveid');
        }
        unset($archiveEmails);
        
        // Get unresolved statuses and filter out the resolved statuses
        $hStatus =& mldocsGetHandler('status');
        $crit = new Criteria('state', 1);
        $statuses =& $hStatus->getObjects($crit, true);
        $aStatuses = array();
        foreach($statuses as $status){
            $aStatuses[$status->getVar('id')] = $status->getVar('id');
        }
        unset($statuses);
        
        // Get array of archives.
        // Only want archives that are unresolved.
        $crit  = new CriteriaCompo(new Criteria('t.id', "(". implode(array_keys($aArchiveEmails), ',') .")", 'IN'));
        $crit->add(new Criteria('t.status', "(". implode(array_keys($aStatuses), ',') .")", 'IN'));
        $archives =& $this->getObjects($crit, $id_as_key);
        
        // Return all archives
        return $archives;
    }
    
    function getObjectsByState($state, $id_as_key = false)
    {
        $crit = new Criteria('state', intval($state), '=', 's');
        $sql = $this->_selectQuery($crit, true);
        if (is_object($crit)) {
            $limit = $crit->getLimit();
            $start = $crit->getStart();
        }
        
        $ret = $this->_db->query($sql, $limit, $start);
        $arr = array();
        while ($temp = $this->_db->fetchArray($ret)) {
            $archives = $this->create();
            $archives->assignVars($temp);
            if ($id_as_key) {
                $arr[$archives->getVar('id')] = $archives;
            } else {
                $arr[] = $archives;
            }
            unset($archives);
        }
        return $arr;
    }
    
    function getCountByStaff($criteria, $hasCustFields = false)
    {
        if(!$hasCustFields){
            $sql = sprintf("SELECT COUNT(*) as ArchiveCount FROM %s t INNER JOIN %s j ON t.department = j.department INNER JOIN %s s ON t.status = s.id", $this->_db->prefix('mldocs_archives'), $this->_db->prefix('mldocs_jstaffdept'), $this->_db->prefix('mldocs_status')); 
        } else {
            $sql = sprintf("SELECT COUNT(*) as ArchiveCount FROM %s t INNER JOIN %s j ON t.department = j.department INNER JOIN %s s ON t.status = s.id INNER JOIN %s f ON t.id = f.archiveid ", $this->_db->prefix('mldocs_archives'), $this->_db->prefix('mldocs_jstaffdept'), $this->_db->prefix('mldocs_status'), $this->_db->prefix('mldocs_archive_values')); 
        }
        
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		
		if (!$result =& $this->_db->query($sql)) {
			return 0;
		}
		list($count) = $this->_db->fetchRow($result);
		return $count;
    }
	
	
	/**
    * Get all archives a staff member is in dept
    * @param int $uid staff user id
    * @param int $mode One of the '_QRY_STAFF_{X}' constants
    * @param int $start first record to return
    * @param int $limit number of records to return
    * @param string $sort Sort Field
    * @param string $order Sort Order
    * @return array array of {@link mldocsArchive}> objects
    * @access public
    * @todo Filter by Department, Status
    */
    function getStaffArchives($uid, $mode = -1, $start = 0, $limit = 0, $sort='', $order='')
    {
        $uid = intval($uid);
        $arr = array();
        $crit = new CriteriaCompo();
        $crit->setLimit(intval($limit));
        $crit->setStart(intval($start));
        switch($mode){
        case MLDOCS_QRY_STAFF_HIGHPRIORITY:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            $crit->add(new Criteria('state', 1, '=', 's'));
            $crit->add(new Criteria('ownership', 0, '=', 't'));
            $crit->setSort('t.priority, t.posted');
            break;
        
        case MLDOCS_QRY_STAFF_NEW:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            $crit->add(new Criteria('ownership', 0, '=', 't'));
            $crit->add(new Criteria('state', 1, '=', 's'));
            $crit->setSort('t.posted');
            $crit->setOrder('DESC');
            break;
            
        case MLDOCS_QRY_STAFF_MINE:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            $crit->add(new Criteria('ownership', $uid, '=', 't'));
            $crit->add(new Criteria('state', 1, '=', 's'));
            $crit->setSort('t.posted');
            break;

        case MLDOCS_QRY_STAFF_ALL:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            break;
            
        default:
            return $arr;
            break;
        }
        return $this->getObjectsByStaff($crit);
    }
    
    /**
    * Get number of archives based on staff membership
    * @param int $uid staff user id
    * @param int $mode 
    * @return int Number of archives
    * @access public
    * @todo Filter by Department, Status
    */
    function getStaffArchiveCount($uid, $mode = -1)
    {
        $crit = new CriteriaCompo();
        switch($mode){
        case MLDOCS_QRY_STAFF_HIGHPRIORITY:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            $crit->add(new Criteria('status', 2, '<', 't'));
            $crit->add(new Criteria('ownership', 0, '=', 't'));
            //$crit->add($crit2);
            $crit->setSort('t.priority, t.posted');
            break;
        
        case MLDOCS_QRY_STAFF_NEW:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            $crit->add(new Criteria('ownership', 0, '=', 't'));
            $crit->add(new Criteria('status', 2, '<', 't'));
            $crit->setSort('t.posted');
            $crit->setOrder('DESC');
            break;
            
        case MLDOCS_QRY_STAFF_MINE:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            $crit->add(new Criteria('ownership', $uid, '=', 't'));
            $crit->add(new Criteria('status', 2, '<', 't'));
            $crit->setSort('t.posted');
            break;

        case MLDOCS_QRY_STAFF_ALL:
            $crit->add(new Criteria('uid', $uid, '=', 'j'));
            break;
            
        default:
            return 0;
            break;
        }
        
        return $this->getCountByStaff($crit);
    }
    function _insertQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("INSERT INTO %s (id, uid, repid,lotid,codearchive, subject, description, department, priority, status, lastUpdated, ownership, closedBy, totalTimeSpent, posted, userIP, emailHash, email, serverid, overdueTime)
            VALUES (%u, %u, %u, %u, %s, %s, %s, %u, %u, %u, %u, %u, %u, %u, %u, %s, %s, %s, %u, %u)", $this->_db->prefix($this->_dbtable), $id,
            $uid, $repid, $lotid, $this->_db->quoteString($codearchive), $this->_db->quoteString($subject), $this->_db->quoteString($description), $department, $priority,
            $status, time(), $ownership, $closedBy, $totalTimeSpent, $posted, $this->_db->quoteString($userIP),$this->_db->quoteString($emailHash),$this->_db->quoteString($email), $serverid, $overdueTime);
            
        return $sql;
        
    }
    
    function _updateQuery(&$obj)
    {
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }
                
        $sql = sprintf("UPDATE %s SET codearchive = %s, subject = %s, description = %s, department = %u, priority = %u, status = %u, lastUpdated = %u, ownership = %u,
            closedBy = %u, totalTimeSpent = %u, userIP = %s, emailHash = %s, email = %s, serverid = %u, overdueTime = %u WHERE id = %u", $this->_db->prefix($this->_dbtable),
            $this->_db->quoteString($codearchive), $this->_db->quoteString($subject), $this->_db->quoteString($description), $department, $priority,
            $status, time(), $ownership, $closedBy, $totalTimeSpent, $this->_db->quoteString($userIP),$this->_db->quoteString($emailHash),$this->_db->quoteString($email), $serverid, $overdueTime, $id);
            
        return $sql;
    }
    
    function _deleteQuery(&$obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        return $sql;
    }
    	
	/**
	 * Create a "select" SQL query
	 * @param object $criteria {@link CriteriaElement} to match
	 * @return	string SQL query
	 * @access	private
	 */	
	function _selectQuery($criteria = null, $join = false, $hasCustFields = false)
	{
	    global $xoopsUser;
		if(!$join){
    		$sql = sprintf('SELECT t.*, (UNIX_TIMESTAMP() - t.posted) as elapsed, (UNIX_TIMESTAMP() - t.lastUpdated) 
    		                as lastUpdate  FROM %s t INNER JOIN %s s ON t.status = s.id', $this->_db->prefix($this->_dbtable),
    		                $this->_db->prefix('mldocs_status'));
	    } else {
	        if(!$hasCustFields){
    	        $sql = sprintf("SELECT t.*, (UNIX_TIMESTAMP() - t.posted) as elapsed, (UNIX_TIMESTAMP() - t.lastUpdated) 
    	                        as lastUpdate FROM %s t INNER JOIN %s j ON t.department = j.department INNER JOIN %s s 
    	                        ON t.status = s.id", $this->_db->prefix('mldocs_archives'), $this->_db->prefix('mldocs_jstaffdept'), 
    	                        $this->_db->prefix('mldocs_status')); 
    	    } else {
    	        $sql = sprintf("SELECT t.*, (UNIX_TIMESTAMP() - t.posted) as elapsed, (UNIX_TIMESTAMP() - t.lastUpdated) 
    	                        as lastUpdate FROM %s t INNER JOIN %s j ON t.department = j.department INNER JOIN %s s 
    	                        ON t.status = s.id INNER JOIN %s f ON t.id = f.archiveid", $this->_db->prefix('mldocs_archives'), 
    	                        $this->_db->prefix('mldocs_jstaffdept'), $this->_db->prefix('mldocs_status'), $this->_db->prefix('mldocs_archive_values'));
    	    }
	    }
	    if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
		}
		$sql = str_replace(MLDOCS_GLOBAL_UID, $xoopsUser->getVar('uid'), $sql);
		return $sql;
	}
	
	/**
	 * delete a archive from the database
	 * 
	 * @param object $obj reference to the {@link mldocsArchive} obj to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 * @access	public
	 */
	function delete(&$obj, $force = false)
	{
		if (strcasecmp($this->classname, get_class($obj)) != 0) {
			return false;
		}
		
		// Remove all archive responses first
		$hResponses  =& mldocsGetHandler('responses');
		if (!$hResponses->deleteAll(new Criteria('archiveid', $obj->getVar('id')))) {
			return false;
		}
	    
	    // Remove all files associated with this archive
	    $hFiles =& mldocsGetHandler('file');
	    if(!$hFiles->deleteAll(new Criteria('archiveid', $obj->getVar('id')))){
	        return false;
	    }
	    
	    // Remove custom field values for this archive
	    $hFieldValues =& mldocsGetHandler('archiveValues');
	    if(!$hFieldValues->deleteAll(new Criteria('archiveid', $obj->getVar('id')))){
	        return false;
	    }	
	    
	    $ret = parent::delete($obj, $force);
		return $ret;
	}
	


	/**
	 * increment a value to 1 field for archives matching a set of conditions
	 * 
	 * @param object $criteria {@link CriteriaElement} 
	 * @return bool FALSE if deletion failed
	 * @access	public	 
	 */		
	function incrementAll($fieldname, $fieldvalue, $criteria = null)
	{
	    $set_clause = is_numeric($fieldvalue) ? $fieldname.' = '. $fieldname .'+'.$fieldvalue : $fieldname.' = '.$fieldname .'+'.$this->_db->quoteString($fieldvalue);
	    $sql = 'UPDATE '.$this->_db->prefix($this->_dbtable).' SET '.$set_clause;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->_db->query($sql)) {
            return false;
        }
        return true;
    }
}   // end of handler class
?>
