<?php
//$id$

/**
 * xmedoo_eventService class
 *
 * Messaging Subsystem.  Notifies objects when events occur in the system
 *
 * <code>
 * $_eventsrv = new mldocs_eventService();
 * // Call $obj->callback($args) when a new archive is created
 * $_eventsrv->advise('new_archive', &$obj, 'callback');
 * // Call $obj2->somefunction($args) when a new archive is created
 * $_eventsrv->advise('new_archive', &$obj2, 'somefunction');
 * // .. Code to create new archive
 * $_eventsrv->trigger('new_archive', $new_archiveobj);
 * </code>
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
 
 class mldocs_eventService
 {
     /**
     * Array of all function callbacks
     *    
     * @var	array
     * @access	private
     */
    var $_ctx = array();

    /**
	 * Class Constructor
	 * 
	 * @access	public	
	 */	    
    function mldocs_eventService()
    {
        //Do Nothing
    }
 
	/**
	 * Add a new class function to be notified
	 * @param	string	$context Event used for callback
	 * @param	object	$obj The object that contains our callback function
	 * @param   string  $func Name of callback function. If empty uses context
	 * @return  int Event cookie, used for unadvise
	 * @access	public
	 */
    function advise($context, &$obj, $func = null)
    {
        if ($func == null) {
            $func = $context;
        }
        
        //Add Element to notification list
        $this->_ctx[$context][] = array($obj, $func);
        //Return element # in array
        return count($this->_ctx[$context]) - 1;
    }
    

	/**
	 * Remove a class function from the notification list
	 * @param	string	$context Event used for callback
	 * @param	int	$cookie The Event ID returned by mldocs_eventService::advise()
	 * @access	public
	 */
    function unadvise($context, $cookie)
    {
        $this->_ctx[$context][$cookie] = false;
    }
    
    /**
	 * Only have 1 instance of class used
	 * @return object {@link mldocs_eventService}
	 * @access	public
	 */
    function &singleton()
    {
        // Declare a static variable to hold the object instance
        static $instance; 

        // If the instance is not there, create one
        if(!isset($instance)) { 
            $instance =& new mldocs_eventService(); 
        } 
        return($instance); 
    }
    
  	/**
	 * Tell subscribed objects an event occurred in the system
	 * @param	string	$context Event raised by the system
	 * @param	array	$args Any arguments that need to be passed to the callback functions
	 * @access	public
	 */
    function trigger($context, $args)
    {
        if (isset($this->_ctx[$context])) {
            $_notlist = $this->_ctx[$context];
            foreach ($_notlist as $func) {
                if (is_callable($func, true, $func_name)) {
                    $func[0]->{$func[1]}($args);
                }
            }
        }
    }
}
?>
