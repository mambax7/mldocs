<?php
//$id$

/**
 * Plugin Interface
 *
 * Defines the interface for mldocs plugins
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 * @todo Localization of meta information
 */
class mldocsPlugin {
    
    /**
     * Array of Plugin Meta Information
     * @access private
     * @var	array
     */
    var $_meta   = array();
    
    /**
     * Array of subscribed events
     * @var	array
     * @access private
     */
    var $_events = array();
    
    /**
     * A reference to a {@link mldocsEventService} object
     * @var	object     
     * @access private
     */
    var $_event_srv;
    
    /**
     * Class Constructor
     * @param object $event_srv a reference to a {@link mldocsEventService} object
     * @return void
     */
    function mldocsPlugin(&$event_srv)
    {
        $this->_event_srv           =& $event_srv;
    }
    
    /**
     * Retrieve the specified meta field
     * @param string $var name of variable to return
     * @return string if var is set, false if not
     * @access public
     */
    function getMeta($var)
    {
        return (isset($this->_meta[$var]) ? $this->_meta[$var] : false);
    }
    
    function setMeta($var, $value)
    {
        $this->_meta[$var] = $value;
    }
    
    
    /**
     * Initialization function, triggered when a plugin is "loaded" by the system
     * @return void
     * @access public
     */
    function onLoad()
    {
        //Initialize any event handlers
        $this->registerEventHandler('new_event', 'on_new_event');
    }
    
    /**
     * Destruction function, triggered when a plugin is "un-loaded" by the system
     * @return void
     * @access public
     */
    function onUnload()
    {   
        //Remove any registered events
        foreach($this->_events as $event_ctx=>$event_cookies) {
            foreach($event_cookies as $cookie) {
                $this->_event_srv->unadvise($event_ctx, $cookie);
            }
        }
    }
    
    /**
     * Add a function to be called when an event is triggered by the system
     * @access protected
     * @return void
     */
    function registerEventHandler($event_ctx, $event_func)
    {
        if (!isset($this->_events[$event_ctx])) {
            $this->_events[$event_ctx] = array();
        }
        
        $this->_events[$event_ctx][] = $this->_event_srv->advise($event_ctx, $this, $event_func);
    }
    
    
    /**
	 * Only have 1 instance of class used
	 * @return object {@link mldocsPlugin}
	 * @access	public
	 */
    function &singleton()
    {
        // Declare a static variable to hold the object instance
        static $instance; 

        // If the instance is not there, create one
        if(!isset($instance)) { 
            $instance =& new $this->getMeta('classname'); 
        }
        return($instance); 
    }
}


/**
 * Manages the retrieval, loading, and unloading of plugins
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package mldocs
 */
class mldocsPluginHandler
{
    /**
     * Database connection
     * 
     * @var	object
     * @access	private
     */
    var $_db;
    var $_active;
    var $_plugins;
   
    function mldocsPluginHandler(&$db)
    {
        $this->_db = $db;
        $this->_active = unserialize(mldocsGetMeta('plugins'));
    }
    
    function _pluginList() 
    {
        $plugins = array();    
        //Open Directory
        $d = @ dir(MLDOCS_PLUGIN_PATH);
        
        if ($d) {
	        while (false !== ($entry = $d->read()))
	            if ( !preg_match('|^\.+$|', $entry) && preg_match('|\.php$|', $entry) ) 
		            $plugins[] = basename(MLDOCS_PLUGIN_PATH.'/'.$entry, '.php');
		        }
		    }
		}
		return $plugins;
    }

    
    function getActivePlugins()
    {
        $plugin_files = $this->_pluginList();
        
        foreach($plugin_files as $plugin)
        {
            if (in_array($plugin, $this->_active)) {
            }    
        }
	}
  
    
    function activatePlugin($script)
    {
        
    }
    
    function deactivatePlugin($script)
    {
    
    }
    
    function getPluginInstance($filename)
    {
        if (!isset($this->_plugins[$filename])) {
		    if ( file_exists( $plug_file = MLDOCS_PLUGIN_PATH . '/' . $filename . '.php' ) ) {
			    include_once $plug_file;
		    }
		    $class = strtolower(MLDOCS_DIRNAME).ucfirst($filename);
		    if (class_exists($class)) {
			    $this->_plugins[$filename] = new $class($GLOBALS['_eventsrv']);
		    }
        }		    
        if (!isset($this->_plugins[$filename])) {
            trigger_error('Plugin does not exist<br />Module: '.MLDOCS_DIRNAME.'<br />Name: '.$filename, E_USER_ERROR);
        }
        return isset($this->_plugins[$filename]) ? $this->_plugins[$filename] : false;
	    
    }
    
}
?>