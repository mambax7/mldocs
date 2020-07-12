<?php
//$Id: cacheService.php,v 1.7 2005/02/15 16:58:02 ackbarr Exp $
/**
 * mldocs_cacheService class
 *
 * Part of the Messaging Subsystem.  Responsible for updating files in the XOOPS_ROOT_PATH/cache directory
 *
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
 
class mldocs_cacheService
{
     /**
     * Location of Xoops Cache Directory
     *    
     * @var	object
     * @access	private
     */
    var $_cacheDir;  
    
    
    /**
	 * Class Constructor
	 * 
	 * @access	public	
	 */	    
    function mldocs_cacheService()
    {
        $this->_cacheDir = MLDOCS_CACHE_PATH;
    }
    
    /**
	 * Callback function for the 'new_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */
    function new_archive($args)
    {
        
        return $this->_clearPerfImages();
    }

    /**
	 * Callback function for the 'close_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */    
    function close_archive($args)
    {
        return $this->_clearPerfImages();
    }
    
    /**
	 * Callback function for the 'delete_archive' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */  
    function delete_archive($args)
    {
        list($archive) = $args;
        if ($archive->getVar('status') == 0) {
            return $this->_clearPerfImages();   
        }
    }

   /**
    * Callback function for the reopen_archive event
    * @param array $args Array of arguments passed to EventService
    * @return bool True on success, false on error
    * @access public
    */
    function reopen_archive($args)
    {
        return $this->_clearPerfImages();   
    }

    /**
	 * Callback function for the 'new_department' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */    
    function new_department($args)
    {   
        return $this->_clearPerfImages();
    }

    /**
	 * Callback function for the 'delete_department' event
	 * @param	array	$args Array of arguments passed to EventService
	 * @return  bool True on success, false on error
	 * @access	public
	 */        
    function delete_department($args)
    {
        return $this->_clearPerfImages();
    }
    
    function batch_status($args)
    {
        return $this->_clearPerfImages();
    }
    
    /**
	 * Removes all cached images for the Department Performance block
	 * @return  bool True on success, false on error
	 * @access	private
	 */
    function _clearPerfImages()
    {
        //Remove all cached department queue images
        $opendir = opendir($this->_cacheDir);
        
        while(($file = readdir($opendir)) != null) {
            
            if (strpos($file, 'mldocs_perf_') === false) {
                continue;
            }
            
            unlink($this->_cacheDir.'/'.$file);
        }       
        return true;
    }
     /**
	 * Only have 1 instance of class used
	 * @return object {@link mldocs_cacheService}
	 * @access	public
	 */
    function &singleton()
    {
        // Declare a static variable to hold the object instance
        static $instance; 

        // If the instance is not there, create one
        if(!isset($instance)) { 
            $instance =& new mldocs_cacheService(); 
        } 
        return($instance); 
    }
}
?>