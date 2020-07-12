<?php
/*$Id: functions.php,v 1.83.2.1 2005/08/03 16:04:19 gabybob Exp $
* modification BYOOS solutions le 05 juillet 2006 version a 13:30 Gabriel
*just as double_explode functions akin to explode, so too does
*  double_implode to implode
* 
*/

// fonction de téléchargement de fichier 
function downloadFile($chemin) 
{
    if ((!file_exists($chemin)) && (!@fclose(@fopen($chemin, "r")))) die('Erreur: fichier incorrect');
    $filename = stripslashes(basename($chemin));
    $user_agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
    header("Content-type: application/force-download");
    header(((is_integer(strpos($user_agent,"msie")))&&(is_integer(strpos($user_agent,"win"))))?"Content-Disposition: filename=\"$filename\"":"Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Description: Telechargement de Fichier");
    @readfile($chemin);
    die();

}
// création d'une image PNG à partir de tiff
function createPicsPng ($img, $pathsrc, $pathdest) 
{

  if(!file_exists($pathdest."/".$img.".png"))
	{
    if(PHP_OS=='WINNT') { 
      $ret = passthru("tiff2png.exe -destdir  ".$pathdest." ".$pathsrc);
      }
    elseif(PHP_OS=='Linux') {
       $ret = passthru("/usr/local/bin/cgi-bin/tiff2png-static -destdir  ".$pathdest." ".$pathsrc);
     }
   } else { 
    return  false;
    } 
   return true; 
}


function double_implode($first_break, $second_break, $array)
{
   $string = "";
   $k=0;
   $num_length = count($array);

   foreach ($array as $key => $value)
   {
       // if the element of the main array is an array
       if (is_array($array[$key]))
           {
           // append the string of the converted arary to
           // the string being constructed of the whole
           // main array
           $string .= implode($second_break, $array[$key]);
           }
       else
       {
           // append the element to the string
           $string .= $array[$key];
       }

       $k++;

//change here!
       // append the delimiting character to the string
       if ($k<$num_length)
           $string .= $first_break;
       }

   return $string;
}

// this is a replacement for the internal explode function so that
//  strings representing 2D arrays (ie matrices) maybe made again
//  into their array format
function double_explode($first_break,$second_break,$string)
{
   // creates array based on the first division character
   $array = explode($first_break, $string);
  
   // loops through the created array in search of any strings
   //  that need to be converted to arrays
   for ($k=0; $k < count($array); $k++)
   {
       // the number of times the second division character
       //  is present
       $count = substr_count($array[$k], $second_break);
       // if the second division character is present; ie,
       //  if the string needs to be converted to an array
       if ($count>0)
       {
           // creates array from string and puts it in
           //  the main array where the string was
           $array[$k] = explode($second_break, $array[$k]);
       }
   }

   return $array;
}

/**
 * @function read_dir
 * @author 	Nicolas Perriault - www.prendreuncafe.com
 * modifié par BYOOS solutions 17 avril 2006 gabriel 
 * @version 0.2
 * <p>Read the files list of a folder recursively and returns it as an array.</p>
 * @param string	path		Chemin du repertoire Ã  lister recursivement
 * @param boolean	full_list	Afficher les entrÃ©es . et ..
 *
 */

function read_dir($path='.', $full_list=false) {
  $hMime =& mldocsGetHandler('mimetype');
	$out = array();
	$i = 0;
	$path = substr($path, strlen($path) - 1, strlen($path)) !== '/' ? $path.'/' : $path;
	//echo $path; 
	if (!is_dir($path) || !$handle = @dir($path)) {
		trigger_error('\''.$path.'\' doesn\'t exists or is not a valid directory', E_USER_ERROR);
	} else {
		while ($entry = $handle->read()) {
			if(substr ( $entry  , 0  , 1 )<>".")  { //si le fichier commence par un point alors ignorer
          if ($full_list == true || ($entry !== "." && $entry !== "..")) {
    				$path_to_entry = $path.'/'.$entry;
    				if ($entry !== '.' && $entry !== '..' && @is_dir($path_to_entry)) {
    					//$out[$entry] = read_dir($path_to_entry, $full_list); //lecture recursive des répertoires
    				} else {
    					$out [$i]['name'] =$entry;
              $out [$i]['tmp_name'] = $path_to_entry;
              $out[$i]['type'] =  $hMime->checkxMimeTypes($entry);// type MIME récupéré dans le main
              $out [$i]['size'] = filesize($path_to_entry);
              $out [$i]['error'] = 0;
   				 $i++;
    				}
    			}
      }
		}
	}
	return $out;
}

// efface les fichiers du répertoire $path
function deletexFile($path='.', $full_list=false) {
  
	$out = false;
	$i = 0;
	$path = substr($path, strlen($path) - 1, strlen($path)) !== '/' ? $path.'/' : $path;
	if (!is_dir($path) || !$handle = @dir($path)) {
		trigger_error('\''.$path.'\' doesn\'t exists or is not a valid directory', E_USER_ERROR);
	} else {
		while ($entry = $handle->read()) {
			if(substr ( $entry  , 0  , 1 )<>".")  { //si le fichier commence par un point alors ignorer
          if ($full_list == true || ($entry !== "." && $entry !== "..")) {
    				$path_to_entry = $path.'/'.$entry;
    				if ($entry !== '.' && $entry !== '..' && @is_dir($path_to_entry)) {
    					//$out[$entry] = read_dir($path_to_entry, $full_list); //lecture recursive des répertoires
    				} else {
              if (is_file($path_to_entry)) {
                $out = unlink($path_to_entry);
               }
              $i++;
    				}
    			}
      }
		}
	}
	return $out;
}


/**
 * Format a time as 'x' years, 'x' weeks, 'x' days, 'x' hours, 'x' minutes, 'x' seconds
 *
 * @param int $time UNIX timestamp
 * @return string formatted time
 *
 * @access public
 */
function mldocsFormatTime($time)
{
    $values = mldocsGetElapsedTime($time);
    
    foreach($values as $key=>$value) {
        $$key = $value;
    }
    
    $ret = array();
    if ($years) {
        $ret[] = $years . ' ' . ($years == 1 ? _MLDOCS_TIME_YEAR : _MLDOCS_TIME_YEARS);
    }
    
    if ($weeks) {
        $ret[] = $weeks . ' ' . ($weeks == 1 ? _MLDOCS_TIME_WEEK : _MLDOCS_TIME_WEEKS);
    }
        
    if ($days) {
        $ret[] = $days . ' ' . ($days == 1 ? _MLDOCS_TIME_DAY : _MLDOCS_TIME_DAYS);
    }
    
    if ($hours) {
        $ret[] = $hours . ' ' . ($hours == 1 ? _MLDOCS_TIME_HOUR : _MLDOCS_TIME_HOURS);
    }
    
    if ($minutes) {
        $ret[] = $minutes . ' ' . ($minutes == 1 ? _MLDOCS_TIME_MIN : _MLDOCS_TIME_MINS);
    }
    
    $ret[] = $seconds . ' ' . ($seconds == 1 ? _MLDOCS_TIME_SEC : _MLDOCS_TIME_SECS);
    return implode(', ', $ret);
}

/** 
 * Changes UNIX timestamp into array of time units of measure
 *
 * @param int $time UNIX timestamp
 * @return array $elapsed_time
 *
 * @access public
 */        
function mldocsGetElapsedTime($time)
{    
    //Define the units of measure
    $units = array('years' => (365*60*60*24) /*Value of Unit expressed in seconds*/,
        'weeks' => (7*60*60*24),
        'days' => (60*60*24),
        'hours' => (60*60),
        'minutes' => 60,
        'seconds' => 1);
    
    $local_time   = $time;  
    $elapsed_time = array();
    
    //Calculate the total for each unit measure
    foreach($units as $key=>$single_unit) {
        $elapsed_time[$key] = floor($local_time / $single_unit);
        $local_time -= ($elapsed_time[$key] * $single_unit);
    }
    
    return $elapsed_time;
}

// transforme le numérique $repid en str repstr sur 2 positions

function mldocsMakeRepstr($repid)
{
  
      if ($repid<10)
        {
        $repstr='0'.strval($repid);
        }
        else {
        $repstr = strval($repid);
        }
    return $repstr;
}


/**
 * Generate mldocs URL
 *
 * @param string $page
 * @param array $vars
 * @return
 *
 * @access public
 */
function mldocsMakeURI($page, $vars = array(), $encodeAmp = true)
{
    $joinStr = '';
    
    $amp = ($encodeAmp ? '&amp;': '&');
    
    if (! count($vars)) {
        return $page;
    }
    $qs = '';
    foreach($vars as $key=>$value) {
        $qs .= $joinStr . $key . '=' . $value;
        $joinStr = $amp;
    }
    return $page . '?'. $qs;
}

/**
 * Changes a archive priority (int) into its string equivalent
 *
 * @param int $priority
 * @return string $priority
 *
 * @access public
 */    
function mldocsGetPriority($priority)
{
    switch($priority){
        case 1:
            return _MLDOCS_TEXT_PRIORITY1;
            break;
        case 2:
            return _MLDOCS_TEXT_PRIORITY2;
            break;
        case 3:
            return _MLDOCS_TEXT_PRIORITY3;
            break;
        case 4:
            return _MLDOCS_TEXT_PRIORITY4;
            break;
        case 5:
            return _MLDOCS_TEXT_PRIORITY5;
            break;
        Default:
            return $priority;
   }
            
}

/**
 * Gets a archives state (unresolved/resolved)
 *
 * @param int $state
 * @return string $state
 *
 * @access public
 */
function mldocsGetState($state)
{
    $state = intval($state);
    
    switch($state){
        case 1:
            return _MLDOCS_STATE1;
        break;
        
        case 2:
            return _MLDOCS_STATE2;
        break;
        
        Default:
            return $state;
    }
}

/**
 * Changes a archive status (int) into its string equivalent
 * Do not use this function in loops
 *
 * @param int $status
 * @return string $status
 *
 * @access public
 */
function mldocsGetStatus($status)
{
    static $aStatus;
    
    $status = intval($status);
    $hStatus =& mldocsGetHandler('status');
    if (!$aStatus) {
        $aStatus = $hStatus->getObjects(null, true);
    }
    
    $obj =& $aStatus[$status];
    
    if (is_object($obj)) {
        return $obj->getVar('description');
    } else {
        return $status;
    }
}

/**
 * Changes a response rating (int) into its string equivalent
 *
 * @param int $rating
 * @return string $rating
 *
 * @access public
 */
function mldocsGetRating($rating)
{
    switch($rating){
        case 0:
            return _MLDOCS_RATING0;
            break;
        case 1:
            return _MLDOCS_RATING1;
            break;
        case 2:
            return _MLDOCS_RATING2;
            break;
        case 3:
            return _MLDOCS_RATING3;
            break;
        case 4:
            return _MLDOCS_RATING4;
            break;
        case 5:
            return _MLDOCS_RATING5;
        Default:
            return $rating;
    }
}

function mldocsGetEventClass($class)
{
    switch($class){
        case 0:
            return _MLDOCS_MAIL_CLASS0;
            break;
        case 1:
            return _MLDOCS_MAIL_CLASS1;
            break;
        case 2:
            return _MLDOCS_MAIL_CLASS2;
            break;
        case 3:
            return _MLDOCS_MAIL_CLASS3;
            break;
        Default:
            return $class;
    }
}

/**
 * Move specified archives into department
 *
 * @param array $archives  array of archive ids (int)
 * @param int $dept  department ID
 * @return bool True on success, False on error
 *
 * @access public
 */
function mldocsSetDept($archives, $dept)
{
    $hArchive =& mldocsGetHandler('archive');
    $crit    = new Criteria('id', "(". implode($archives, ',') .")", "IN");
    return $hArchive->updateAll('department', intval($dept), $crit);      
}

/**
 * Set specified archives to a priority
 *
 * @param array $archives  array of archive ids (int)
 * @param int $priority  priority value
 * @return bool True on success, False on error
 *
 * @access public
 */
function mldocsSetPriority($archives, $priority)
{
    $hArchive =& mldocsGetHandler('archive');
    $crit    = new Criteria('id', "(". implode($archives, ',') .")", 'IN');
    return $hArchive->updateAll('priority', intval($priority), $crit);      
}

/**
 * Set specified archives to a status
 *
 * @param array $archives  array of archive ids (int)
 * @param int $status  status value
 * @return bool True on success, False on error
 *
 * @access public
 */
function mldocsSetStatus($archives, $status)
{
    $hArchive =& mldocsGetHandler('archive');
    $crit    = new Criteria('id', "(". implode($archives, ',') .")", 'IN');
    return $hArchive->updateAll('status', intval($status), $crit);         
}

/**
 * Assign specified archives to a staff member
 *
 * Assumes that owner is a member of all departments in specified archives
 *
 * @param array $archives  array of archive ids (int)
 * @param int $owner  uid of new owner
 * @return bool True on success, False on error
 *
 * @access public
 */
function mldocsSetOwner($archives, $owner)
{
    $hArchive =& mldocsGetHandler('archive');
    $crit    = new Criteria('id', "(". implode($archives, ',') .")", 'IN');
    return $hArchive->updateAll('ownership', intval($owner), $crit);         
}

/**
 * Add the response to each archive
 *
 *
 * @param array $archives array of archive ids (int)
 * @param string $response response text to add
 * @param int $timespent Number of minutes spent on archive
 * @param bool $private Should this be a private message?
 * @return bool True on success, False on error
 *
 * @access public
 */
function mldocsAddResponse($archives, $sresponse, $timespent = 0, $private = false)
{
    global $xoopsUser;
    $hResponse  =& mldocsGetHandler('responses');
    $hArchive    =& mldocsGetHandler('archive');
    $updateTime = time();
    $uid        = $xoopsUser->getVar('uid');
    $ret        = true;
    $userIP     = getenv("REMOTE_ADDR");
    foreach ($archives as $archiveid) {
        $response =& $hResponse->create();
        $response->setVar('uid', $uid);
        $response->setVar('archiveid', $archiveid);
        $response->setVar('message', $sresponse);
        $response->setVar('timeSpent', $timespent);
        $response->setVar('updateTime', $updateTime);
        $response->setVar('userIP', $userIP);
        $response->setVar('private', $private);
        $ret = $ret && $hResponse->insert($response);
        unset($response);
    }
    if ($ret) {
        $crit = new Criteria('id', "(". implode($archives, ',') .")", 'IN');
        $ret  = $hArchive->incrementAll('totalTimeSpent', $timespent, $crit);
        $ret  = $hArchive->updateAll('lastUpdated', $updateTime, $crit);
    }
    return $ret;
}

/**
 * Remove the specified archives
 *
 * @param array $archives array of archive ids (int)
 * @return bool True on success, False on error
 *
 * @access public
 */
function mldocsDeleteArchives($archives)
{
    $hArchive =& mldocsGetHandler('archive');
    $crit    = new Criteria('id', "(". implode($archives, ',') .")", 'IN');
    return $hArchive->deleteAll($crit);
}

/**
 * Retrieves an array of archives in one query
 *
 * @param array $archives array of archive ids (int)
 * @return array Array of archive objects
 *
 * @access public
 */
function &mldocsGetArchives(&$archives)
{
    $hArchive =& mldocsGetHandler('archive');
    $crit    = new Criteria('t.id', "(". implode($archives, ',') .")", 'IN');
    return $hArchive->getObjects($crit);
}

/**
 * Check if all supplied rules pass, and return any errors
 *
 * @param array $rules array of {@link Validator} classes
 * @param array $errors array of errors found (if any)
 * @return bool True if all rules pass, false if any fail
 *
 * @access public
 */
function mldocsCheckRules(&$rules, &$errors)
{
    $ret = true;
    if (is_array($rules)) {
        foreach($rules as $rule) {
            $ret = $ret && mldocsCheckRules($rule, $error);
            $errors = array_merge($errors, $error);      
        }
     } else {
        if (!$rules->isValid()) {
            $ret = false;
            $errors = $rules->getErrors();
        } else {
            $ret = true;
            $errors = array();
        }
     }
     return $ret; 
     
}

/**
 * Output the specified variable (for debugging)
 *
 * @param mixed $var Variable to output
 * @return void
 *
 * @access public
 */
function mldocsDebug(&$var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

/**
 * Detemines if a table exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @return bool True if table exists, false if not
 *
 * @access public
 */
function mldocsTableExists($table)
{

    $bRetVal = false;
    //Verifies that a MySQL table exists
    $xoopsDB =& Database::getInstance();
    $realname = $xoopsDB->prefix($table);
    $ret = mysql_list_tables(XOOPS_DB_NAME, $xoopsDB->conn);
    while (list($m_table)=$xoopsDB->fetchRow($ret)) {
        
        if ($m_table ==  $realname) {
            $bRetVal = true;
            break;
        }
    }
    $xoopsDB->freeRecordSet($ret);
    return ($bRetVal);
}

/**
 * Gets a value from a key in the mldocs_meta table
 *
 * @param string $key
 * @return string $value
 *
 * @access public
 */
function mldocsGetMeta($key)
{
    $xoopsDB =& Database::getInstance();
    $sql = sprintf("SELECT metavalue FROM %s WHERE metakey=%s", $xoopsDB->prefix('mldocs_meta'), $xoopsDB->quoteString($key));
    $ret = $xoopsDB->query($sql);
    if (!$ret) {
        $value = false;
    } else {
        list($value) = $xoopsDB->fetchRow($ret);
        
    }
    return $value;
}

/**
 * Sets a value for a key in the mldocs_meta table
 *
 * @param string $key
 * @param string $value
 * @return bool TRUE if success, FALSE if failure
 *
 * @access public
 */ 
function mldocsSetMeta($key, $value)
{
    $xoopsDB =& Database::getInstance();
    if($ret = mldocsGetMeta($key)){   
        $sql = sprintf("UPDATE %s SET metavalue = %s WHERE metakey = %s", $xoopsDB->prefix('mldocs_meta'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
    } else {
        $sql = sprintf("INSERT INTO %s (metakey, metavalue) VALUES (%s, %s)", $xoopsDB->prefix('mldocs_meta'), $xoopsDB->quoteString($key), $xoopsDB->quoteString($value));
    }
    $ret = $xoopsDB->queryF($sql);
    if (!$ret) {
        return false;
    }
    return true;
}

/**
 * Checks to see if the email is already registered with a xoopsUser
 *
 * @param string $email
 * @return {@link xoopsUser} object if success, FALSE if failure
 *
 * @access public
 */
function &mldocsEmailIsXoopsUser($email)
{
    $hXoopsMember =& xoops_gethandler('member');
    $crit = new Criteria('email', $email);
    $crit->setLimit(1);
    
    $users =& $hXoopsMember->getUsers($crit);    
    if (count($users) > 0) {
        return $users[0];
    } else {
        return false;
    }
}

/**
 * Detemines if a field exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @param string $field the field name
 * @return mixed false if field does not exist, array containing field info if does
 *
 * @access public
 */
function mldocsFieldExists($table, $field)
{ 
    $xoopsDB =& Database::getInstance();
    $tblname = $xoopsDB->prefix($table);
    $ret     = $xoopsDB->query("DESCRIBE $tblname");
    
    if (!$ret) {
        return false;    
    }

    while ($row = $xoopsDB->fetchRow($ret)) {
        if(strcasecmp($row['Field'], $field) == 0) {
            return $row;
        }
    }
    return false;    
} 

/**
 * Creates a xoops account from an email address and password
 *
 * @param string $email
 * @param string $password
 * @return {@link xoopsUser} object if success, FALSE if failure
 *
 * @access public
 */
function &mldocsXoopsAccountFromEmail($email, $name, &$password, $level)
{
    $member_handler =& xoops_gethandler('member');
    
    $unamecount = 10;
    if (strlen($password) == 0) {
        $password = substr(md5(uniqid(mt_rand(), 1)), 0, 6);
    }
    
    $usernames = mldocsGenUserNames($email, $name, $unamecount);
    $newuser = false;
    $i = 0;
    while ($newuser == false) {
        $crit = new Criteria('uname', $usernames[$i]);
        $count = $member_handler->getUserCount($crit);
        if ($count == 0) {
            $newuser = true;
        } else {
            //Move to next username
            $i++;
            if ($i == $unamecount) {
                //Get next batch of usernames to try, reset counter
                $usernames = mldocsGenUserNames($email->getEmail(), $email->getName(), $unamecount);
                $i = 0;
            }
        }
        
    }
           
    $xuser =& $member_handler->createUser();
    $xuser->setVar("uname",$usernames[$i]);
    $xuser->setVar("loginname", $usernames[$i]);
    $xuser->setVar("user_avatar","blank.gif");
    $xuser->setVar('user_regdate', time());
    $xuser->setVar('timezone_offset', 0);
    $xuser->setVar('actkey',substr(md5(uniqid(mt_rand(), 1)), 0, 8));
    $xuser->setVar("email",$email);
    $xuser->setVar("name", $name);
    $xuser->setVar("pass", md5($password));
    $xuser->setVar('notify_method', 2);
	$xuser->setVar("level",$level);
    
    if ($member_handler->insertUser($xuser)){
        //Add the user to Registered Users group
        $member_handler->addUserToGroup(XOOPS_GROUP_USERS, $xuser->getVar('uid'));
    } else {
        return false;
    }
    
    return $xuser;
}

/**
 * Generates an array of usernames
 *
 * @param string $email email of user
 * @param string $name name of user
 * @param int $count number of names to generate
 * @return array $names
 *
 * @access public
 */
function mldocsGenUserNames($email, $name, $count=20)
{
    $names = array();
    $userid   = explode('@',$email);
    
    
    $basename = '';
    $hasbasename = false;
    $emailname = $userid[0];
    
    $names[] = $emailname;
    
    if (strlen($name) > 0) {
        $name = explode(' ', trim($name));
        if (count($name) > 1) {
            $basename = strtolower(substr($name[0], 0, 1) . $name[count($name) - 1]);
        } else {
            $basename = strtolower($name[0]);
        }
        $basename = xoops_substr($basename, 0, 60, ''); 
        //Prevent Duplication of Email Username and Name
        if (!in_array($basename, $names)) {
            $names[] = $basename;
            $hasbasename = true;
        }
    }
    
    $i = count($names);
    $onbasename = 1;
    while ($i < $count) {
        $num = mldocsGenRandNumber();
        if ($onbasename < 0 && $hasbasename) {
            $names[] = xoops_substr($basename, 0, 58, '').$num;
            
        } else {
            $names[] = xoops_substr($emailname, 0, 58, ''). $num;
        }
        $i = count($names);
        $onbasename = ~ $onbasename;
        $num = '';
    }
    
    return $names;
    
}

/**
 * Gives the random number generator a seed to start from
 *
 * @return void
 *
 * @access public
 */
function mldocsInitRand()
{
   static $randCalled = FALSE;
   if (!$randCalled)
   {
       srand((double) microtime() * 1000000);
       $randCalled = TRUE;
   }
}

/**
 * Creates a random number with a specified number of $digits
 *
 * @param int $digits number of digits
 * @return return int random number
 *
 * @access public
 */
function mldocsGenRandNumber($digits = 2)
{
    mldocsInitRand();
    $tmp = array();
    
    for ($i = 0; $i < $digits; $i++) {
        $tmp[$i] = (rand()%9);
    }
    return implode('', $tmp); 
}

/**
 * Converts int $type into its string equivalent
 *
 * @param int $type
 * @return string $type
 *
 * @access public
 */
function mldocsGetMBoxType($type)
{
    switch($type) {
    case _MLDOCS_MAILBOXTYPE_POP3:
        return 'POP3';
        break;
        
    case _MLDOCS_MAILBOXTYPE_IMAP:
        return 'IMAP';
        break;
    default:
        return 'NA';
        break;
    }
    
}

/**
 * Retrieve list of all staff members
 *
 * @return array {@link mldocsStaff} objects
 *
 * @access public
 */
function &mldocsGetStaff($displayName)
{
    $xoopsDB =& Database::getInstance();
    
    $sql = sprintf("SELECT u.uid, u.uname, u.name FROM %s u INNER JOIN %s s ON u.uid = s.uid ORDER BY u.uname", 
                    $xoopsDB->prefix('users'), $xoopsDB->prefix('mldocs_staff'));
    $ret = $xoopsDB->query($sql);
    
    $staff[-1] = _MLDOCS_TEXT_SELECT_ALL;
    $staff[0]  = _MLDOCS_NO_OWNER;
    while($member = $xoopsDB->fetchArray($ret)){
        $staff[$member['uid']] = mldocsCheckDisplayName($displayName, $member['name'],$member['uname']);
    }
    
    return $staff;
}

/**
 * Creates default roles in the mldocs_roles table
 *
 * @return TRUE if success, FALSE if failure
 *
 * @access public
 */
function mldocsCreateRoles()
{
    if(!defined('_MLDOCS_ROLE_NAME1')){
        mldocsIncludeLang('main', 'english');
    }
    
    $name1 = (defined('_MLDOCS_ROLE_NAME1') ? _MLDOCS_ROLE_NAME1 : 'Archive Manager');
    $name2 = (defined('_MLDOCS_ROLE_NAME2') ? _MLDOCS_ROLE_NAME2 : 'Support');
    $name3 = (defined('_MLDOCS_ROLE_NAME3') ? _MLDOCS_ROLE_NAME3 : 'Browser');
    
    $desc1 = (defined('_MLDOCS_ROLE_DSC1') ? _MLDOCS_ROLE_DSC1 : 'Can do anything and everything');
    $desc2 = (defined('_MLDOCS_ROLE_DSC2') ? _MLDOCS_ROLE_DSC2 : 'Log archives and responses, change status and priority, and log archives for a user');
    $desc3 = (defined('_MLDOCS_ROLE_DSC3') ? _MLDOCS_ROLE_DSC3 : 'Can make no changes');
    
    //** BTW - Does this need to be updated for the new role perm
    $val1 = (defined('_MLDOCS_ROLE_VAL1') ? _MLDOCS_ROLE_VAL1 : 2047);
    $val2 = (defined('_MLDOCS_ROLE_VAL2') ? _MLDOCS_ROLE_VAL2 : 241);
    $val3 = (defined('_MLDOCS_ROLE_VAL3') ? _MLDOCS_ROLE_VAL3 : 0);
    
    global $xoopsDB;
    $aRoles = array();
    $aRoles[1] = array('id'=>1, 'name'=> $name1, 'desc'=> $desc1, 'value'=> $val1);
    $aRoles[2] = array('id'=>2, 'name'=> $name2, 'desc'=> $desc2, 'value'=> $val2);
    $aRoles[3] = array('id'=>3, 'name'=> $name3, 'desc'=> $desc3, 'value'=> $val3);
    
    foreach($aRoles as $role){
        //** BTW - would it be better to use the RoleHandler in this case to create the db records?
        $sql = sprintf("INSERT INTO %s (id, name, description, tasks) VALUES (%u, %s, %s, %u)", 
                       $xoopsDB->prefix('mldocs_roles'), $role['id'], $xoopsDB->quotestring($role['name']), 
                       $xoopsDB->quotestring($role['desc']), $role['value']);
        $result = $xoopsDB->queryF($sql);
        if (!$result) {
            return false;
		}
    }
    return true;   
}

function mldocsCreateStatuses()
{
    if(!defined('_MLDOCS_STATUS0')){
        mldocsIncludeLang('main', 'english');
    }
    
    $status1 = (defined('_MLDOCS_STATUS0') ? _MLDOCS_STATUS0 : 'Open');
    $status2 = (defined('_MLDOCS_STATUS1') ? _MLDOCS_STATUS1 : 'Hold');
    $status3 = (defined('_MLDOCS_STATUS2') ? _MLDOCS_STATUS2 : 'Closed');
    
    $state1 = (defined('_MLDOCS_NUM_STATE1') ? _MLDOCS_NUM_STATE1 : 1);
    $state2 = (defined('_MLDOCS_NUM_STATE2') ? _MLDOCS_NUM_STATE2 : 2);
    
    global $xoopsDB;
    $aStatuses = array();
    $aStatuses[1] = array('id' => 1, 'description' => $status1, 'state' => $state1);
    $aStatuses[2] = array('id' => 2, 'description' => $status2, 'state' => $state1);
    $aStatuses[3] = array('id' => 3, 'description' => $status3, 'state' => $state2);
    
    $hStatus =& mldocsGetHandler('status');
    foreach($aStatuses as $status){
        $newStatus =& $hStatus->create();
        $newStatus->setVar('id', $status['id']);
        $newStatus->setVar('description', $status['description']);
        $newStatus->setVar('state', $status['state']);
        
        if(!$hStatus->insert($newStatus)){
            return false;
        }
    }
    return true;
}

function mldocs_adminFooter()
{
    $mldocs_imagePath = XOOPS_URL.'/modules/mldocs/images';
    echo "<br /><center><a target='_BLANK' href='http://www.byoos.fr'><img src='".$mldocs_imagePath."/mldocs_slogo.png'></a></center>";
}

/**
* Thanks to the NewBB2 Development Team and SmartFactory
*/
function &mldocs_admin_getPathStatus($path, $getStatus=false)
{
	if(empty($path)) return false;
	$url_path = urlencode($path);
	if(@is_writable($path)){
		$pathCheckResult = 1;
		$path_status = _AM_MLDOCS_PATH_AVAILABLE;
	}elseif(!@is_dir($path)){
		$pathCheckResult = -1;
		$path_status = _AM_MLDOCS_PATH_NOTAVAILABLE." [<a href=index.php?op=createdir&amp;path=$url_path>"._AM_MLDOCS_TEXT_CREATETHEDIR.'</a>]';
	}else{
		$pathCheckResult = -2;
		$path_status = _AM_MLDOCS_PATH_NOTWRITABLE." [<a href=index.php?op=setperm&amp;path=$url_path>"._AM_MLDOCS_TEXT_SETPERM.'</a>]';
	}
	if (!$getStatus) {
	 	return $path_status;
	} else {
		return $pathCheckResult;
	}
}

/**
* Thanks to the NewBB2 Development Team and SmartFactory
*/
function mldocs_admin_mkdir($target)
{
	// http://www.php.net/manual/en/function.mkdir.php
	// saint at corenova.com
	// bart at cdasites dot com
	if (is_dir($target)||empty($target)) return true; // best case check first
	if (file_exists($target) && !is_dir($target)) return false;
	if (mldocs_admin_mkdir(substr($target,0,strrpos($target,'/'))))
	  if (!file_exists($target)) return mkdir($target); // crawl back up & create dir tree
	return true;
}

/**
* Thanks to the NewBB2 Development Team and SmartFactory
*/
function mldocs_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}

function mldocsDirsize($dirName = '.', $getResolved = false)
{
    $dir = dir($dirName);
    $size = 0;
    
    if($getResolved){
        $hArchive =& mldocsGetHandler('archive');
        $hFile =& mldocsGetHandler('file');
        
        $archives =& $hArchive->getObjectsByState(1);
        
        $aArchives = array();
        foreach($archives as $archive){
            $aArchives[$archive->getVar('id')] = $archive->getVar('id');
        }
        
        // Retrieve all unresolved archive attachments
        $crit = new Criteria('archiveid', "(".implode($aArchives, ',') .")", "IN");
        $files = $hFile->getObjects($crit);
        $aFiles = array();
        foreach($files as $f){
            $aFiles[$f->getVar('id')] = $f->getVar('filename');
        }
    }
    
    while($file = $dir->read()){
        if($file != '.' && $file != '..'){
            if(is_dir($file)){
                $size += dirsize($dirName . '/' . $file);
            } else {
                if($getResolved){
                    if(!in_array($file, $aFiles)){     // Skip unresolved files
                        $size += filesize($dirName . '/' . $file);
                    }
                } else {
                    $size += filesize($dirName . '/' . $file);
                }
            }
        }
    }
    $dir->close();
    return mldocsPrettyBytes($size);
}

function mldocsPrettyBytes($bytes)
{
    $bytes = intval($bytes);
       
    if ($bytes >= 1099511627776) {
        $return = number_format($bytes / 1024 / 1024 / 1024 / 1024, 2);
        $suffix = _MLDOCS_SIZE_TB;
    } elseif ($bytes >= 1073741824) {
        $return = number_format($bytes / 1024 / 1024 / 1024, 2);
        $suffix = _MLDOCS_SIZE_GB;
    } elseif ($bytes >= 1048576) {
        $return = number_format($bytes / 1024 / 1024, 2);
        $suffix = _MLDOCS_SIZE_MB;
    } elseif ($bytes >= 1024) {
        $return = number_format($bytes / 1024, 2);
        $suffix = _MLDOCS_SIZE_KB;
    } else {
        $return = $bytes;
        $suffix = _MLDOCS_SIZE_BYTES;
    }

    $return .= " " . $suffix;
    return $return;
    
    
}
function mldocsAddDBField($table, $fieldname, $fieldtype='VARCHAR', $size=0, $attr=null)
{
    $xoopsDB =& Database::getInstance();
    
    $column_def = $fieldname;
    if ($size) {
        $column_def .= sprintf(' %s(%s)', $fieldtype, $size);
    } else {
        $column_def .= " $fieldtype";
    }
    if (is_array($attr)) {
        if (isset($attr['nullable']) && $attr['nullable'] == true) {
            $column_def .= ' NULL';
        } else {
            $column_def .= ' NOT NULL';
        }
       
        if (isset($attr['default'])) {
            $column_def .= ' DEFAULT '. $xoopsDB->quoteString($attr['default']);
        }
        
        if (isset($attr['increment'])) {
            $column_def .= ' AUTO_INCREMENT';
        }
        
        if (isset($attr['key'])) {
            $column_def .= ' KEY';
        }
        
        if (isset($attr['comment'])) {
            $column_def .= 'COMMENT '. $xoopsDB->quoteString($attr['comment']);
        }
    }
    
    $sql = sprintf('ALTER TABLE %s ADD COLUMN %s', $xoopsDB->prefix($table), $column_def);
    $ret = $xoopsDB->query($sql);
    return $ret;
}

function mldocsRenameDBField($table, $oldcol, $newcol, $fieldtype='VARCHAR', $size=0)
{  
    $xoopsDB =& Database::getInstance();
    $column_def = $newcol;
    $column_def .= ($size ? sprintf(' %s(%s)', $fieldtype, $size) : " $fieldtype");
    $sql = sprintf('ALTER TABLE %s CHANGE %s %s', $xoopsDB->prefix($table), $oldcol, $column_def);
    $ret = $xoopsDB->query($sql);
    return $ret;
}

function mldocsRemoveDBField($table, $column)
{
    $xoopsDB =& Database::getInstance();
    $sql = sprintf('ALTER TABLE %s DROP COLUMN `%s`', $xoopsDB->prefix($table), $column);
    $ret = $xoopsDB->query($sql);
    return $ret;
}

function mldocsResetDbTimestamp()
{
    $hStaff =& mldocsGetHandler('staff');
    $success = $hStaff->updateAll('permTimestamp', time());
    
    return $success;
}

function &mldocsGetModule()
{
    global $xoopsModule;
    static $_module;
    
    if (isset($_module)) {
        return $_module;
    }
    
    if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == MLDOCS_DIR_NAME) {
        $_module =& $xoopsModule;
    } else {
	    $hModule = &xoops_gethandler('module');
        $_module = &$hModule->getByDirname('mldocs');
    }
	return $_module;
}

function &mldocsGetModuleConfig()
{
	static $_config;
	
	if (isset($_config)) {
	    return $_config;
    }
    	    
	
	$hModConfig = &xoops_gethandler('config');
	$_module =& mldocsGetModule();
	
	$_config =& $hModConfig->getConfigsByCat(0, $_module->getVar('mid'));

	return $_config;
}

function &mldocsGetHandler($handler)
{
    $handler =& xoops_getmodulehandler($handler, MLDOCS_DIR_NAME);
    return $handler;
}

function mldocsGetControlLabel($control)
{
    if ($controlarr = mldocsGetControl($control)) {
        return $controlarr['label'];
    } else {
        return $control;
    }
    
}

function &mldocsGetControl($control)
{
    $controls = mldocsGetControlArray();
    if (isset($controls[$control])) {
        return $controls[$control];
    } else {
        return false;
    }
}
    

function &mldocsGetControlArray()
{
    $ret = array(
            MLDOCS_CONTROL_TXTBOX => array('label' =>  _MLDOCS_CONTROL_DESC_TXTBOX, 'needs_length' => true, 'needs_values' => false),
            MLDOCS_CONTROL_TXTAREA => array('label' => _MLDOCS_CONTROL_DESC_TXTAREA, 'needs_length' => true, 'needs_values' => false),
            MLDOCS_CONTROL_SELECT => array('label' => _MLDOCS_CONTROL_DESC_SELECT, 'needs_length' => true, 'needs_values' => true),
            //Search issues?
            //MLDOCS_CONTROL_MULTISELECT => _MLDOCS_CONTROL_DESC_MULTISELECT,
            MLDOCS_CONTROL_YESNO => array('label' => _MLDOCS_CONTROL_DESC_YESNO, 'needs_length' => false, 'needs_values' => false),
            //Search issues?
            //MLDOCS_CONTROL_CHECKBOX => _MLDOCS_CONTROL_DESC_CHECKBOX,
            MLDOCS_CONTROL_RADIOBOX => array('label' => _MLDOCS_CONTROL_DESC_RADIOBOX, 'needs_length' => true, 'needs_values' => true),
            MLDOCS_CONTROL_DATETIME => array('label' => _MLDOCS_CONTROL_DESC_DATETIME, 'needs_length' => false, 'needs_values' => false),
            MLDOCS_CONTROL_FILE => array('label' => _MLDOCS_CONTROL_DESC_FILE, 'needs_length' => false, 'needs_values' => false));
            
    return $ret;
}

function mldocsGetGlobalSavedSearches()
{
    global $xoopsUser, $_mldocsSession;
    if(!$xoopsUser){
        return false;
    }
    $hSavedSearch =& mldocsGetHandler('savedSearch');
    $savedSearches =& $hSavedSearch->getByUid($xoopsUser->getVar('uid'), true);
    $aSavedSearches = array();
    $mySavedSearches = array();
    foreach($savedSearches as $sSearch){
        $mySavedSearches[$sSearch->getVar('id')] = array('id' => $sSearch->getVar('id'),
                                  'uid' => $sSearch->getVar('uid'),
                                  'name' => $sSearch->getVar('name'),
                                  'search' => unserialize($sSearch->getVar('search')),
                                  'pagenav_vars' => $sSearch->getVar('pagenav_vars'),
                                  'hasCustFields' => $sSearch->getVar('hasCustFields'));
    }
    if(count($mySavedSearches) < 1){
        $mySavedSearches = false;
    }
    
    return $mySavedSearches;
}

function mldocsGetSavedSearches()
{
    global $xoopsUser, $_mldocsSession;
    if(!$xoopsUser){
        return false;
    }
    $hSavedSearch =& mldocsGetHandler('savedSearch');
    $savedSearches =& $hSavedSearch->getByUid($xoopsUser->getVar('uid'), false);
    $aSavedSearches = array();
    $mySavedSearches = array();
    foreach($savedSearches as $sSearch){
        $aSavedSearches[$sSearch->getVar('id')] = array('id' => $sSearch->getVar('id'),
                                  'uid' => $sSearch->getVar('uid'),
                                  'name' => $sSearch->getVar('name'),
                                  'search' => unserialize($sSearch->getVar('search')),
                                  'pagenav_vars' => $sSearch->getVar('pagenav_vars'),
                                  'hasCustFields' => $sSearch->getVar('hasCustFields'));
    }
    if(count($aSavedSearches) < 1){
        $aSavedSearches = false;
    }
    $_mldocsSession->set("mldocs_savedSearches", $aSavedSearches);
    
    return $aSavedSearches;
}

function mldocsCreateNotifications()
{
    $hRole =& mldocsGetHandler('role');
    $hNotification =& mldocsGetHandler('notification');
    
    // Get list of all roles
    $roles =& $hRole->getObjects();
    
    $aRoles = array();
    foreach($roles as $role){
        $aRoles[$role->getVar('id')] = $role->getVar('id');
    }
    
    $aNotify = array('1'=> array('staff'=>2, 'user'=>1),
                     '2'=> array('staff'=>2, 'user'=>1),
                     '3'=> array('staff'=>2, 'user'=>1),
                     '4'=> array('staff'=>3, 'user'=>1),
                     '5'=> array('staff'=>3, 'user'=>1),
                     '6'=> array('staff'=>2, 'user'=>1),
                     '7'=> array('staff'=>2, 'user'=>1),
                     '8'=> array('staff'=>3, 'user'=>2),
                     '9'=> array('staff'=>2, 'user'=>1),
                     '10'=> array('staff'=>2, 'user'=>1));
                     
    foreach($aNotify as $notif_id=>$notif){
        $template =& $hNotification->create();
        $template->setVar('notif_id', $notif_id);
        $template->setVar('staff_setting', $notif['staff']);
        $template->setVar('user_setting', $notif['user']);
        if($notif['staff'] == 2){
            $template->setVar('staff_options', $aRoles);
        } else {
            $template->setVar('staff_options', array());
        }
        $hNotification->insert($template, true);
    }
    return true;
}

function mldocsCreateDepartmentVisibility()
{
    $hDepartments  =& mldocsGetHandler('department');
    $hGroups =& xoops_gethandler('group');
    $hGroupPerm =& xoops_gethandler('groupperm');
    $xoopsModule =& mldocsGetModule();
    
    $module_id = $xoopsModule->getVar('mid');
    
    // Get array of all departments
    $departments =& $hDepartments->getObjects(null, true);
    
    // Get array of groups
    $groups =& $hGroups->getObjects(null, true);
    $aGroups = array();
    foreach($groups as $group_id=>$group){
        $aGroups[$group_id] = $group->getVar('name');
    }
    
    foreach($departments as $dept){
        $deptID = $dept->getVar('id');
        
        // Remove old group permissions
        $crit = new CriteriaCompo(new Criteria('gperm_modid', $module_id));
        $crit->add(new Criteria('gperm_itemid', $deptID));
        $crit->add(new Criteria('gperm_name', _MLDOCS_GROUP_PERM_DEPT));
        $hGroupPerm->deleteAll($crit);
        
        foreach($aGroups as $group=>$group_name){     // Add new group permissions
            $hGroupPerm->addRight(_MLDOCS_GROUP_PERM_DEPT, $deptID, $group, $module_id);
        }
        
        // Todo: Possibly add text saying, "Visibility for Department x set"
    }
    return true;
}

function &mldocsGetUsers($criteria = null, $displayName)
{
    $hUser =& xoops_gethandler('user');
    $users =& $hUser->getObjects($criteria, true);
    $ret = array();
    foreach (array_keys($users) as $i) {
        if(($displayName == 2) && ($users[$i]->getVar('name') <> '')){
            $ret[$i] = $users[$i]->getVar('name');
        } else {
            $ret[$i] = $users[$i]->getVar('uname');
        }    
    }
    return $ret;
}

/**
 * Retrieve a user's name or username depending on value of mldocs_displayName preference
 *
 * @param object $xUser {@link $xoopsUser object) or int {userid}
 * @param int $displayName {mldocs_displayName preference value}
 *
 * @return string {username or real name}
 *
 * @access public
 */
function mldocsGetUsername($xUser, $displayName)
{
    global $xoopsUser, $xoopsConfig;
    $user = false;
    $hMember =& xoops_getHandler('member');
    
    if(is_numeric($xUser)){
        if($xUser <> $xoopsUser->getVar('uid')){
            if($xUser == 0){
                return $xoopsConfig['anonymous'];
            }
            $user =& $hMember->getUser($xUser);
        } else {
            $user = $xoopsUser;
        }
    } elseif(is_object($xUser)){
        $user = $xUser;
    } else {
        return $xoopsConfig['anonymous'];
    }
    
    $ret = mldocsCheckDisplayName($displayName, $user->getVar('name'), $user->getVar('uname'));
    
    return $ret;
}

/**
 * Retrieve list of all staff members
 *
 * @param int $displayName {mldocs_displayName preference value}
 * @param string $name {user's real name}
 * @param string $uname {user's username}
 *
 * @return string {username or real name}
 *
 * @access public
 */
function mldocsCheckDisplayName($displayName, $name = '', $uname = '')
{
    if(($displayName == 2) && ($name <> '')){
        return $name;
    } else {
        return $uname;
    }
}

function mldocsGetSiteLanguage()
{
    global $xoopsConfig;
    if (isset($xoopsConfig) && isset($xoopsConfig['language'])) {
        $language = $xoopsConfig['language'];
    } else {
        $config_handler =& xoops_gethandler('config');
        $xoopsConfig =& $config_handler->getConfigsByCat(XOOPS_CONF);
        $language = $xoopsConfig['language'];
    }
    return $language;        
}

function mldocsIncludeLang($filename, $language = null)
{
    $lang_files = array('admin', 'blocks', 'main', 'modinfo');
    
    if (!in_array($filename, $lang_files)) {
        trigger_error("Invalid language file inclusion attempt", E_USER_ERROR);
    }
    
    if (is_null($language)) {
        $language = mldocsGetSiteLanguage();
    }
    
    if (file_exists(MLDOCS_BASE_PATH . "/language/$language/$filename.php")) {
        include_once(MLDOCS_BASE_PATH ."/language/$language/$filename.php");
    } else {
        if (file_exists(MLDOCS_BASE_PATH ."/language/english/$filename.php")) {
            include_once(MLDOCS_BASE_PATH ."/language/english/$filename.php");
        } else {
            trigger_error("Unable to load language file $filename", E_USER_NOTICE);
        }
    }                    
}

function mldocsCreateDefaultArchiveLists()
{
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
    
    $hSavedSearch =& mldocsGetHandler('savedSearch');
    $hArchiveList =& mldocsGetHandler('archiveList');
    $hStaff =& mldocsGetHandler('staff');

    $archiveLists = array(MLDOCS_QRY_STAFF_HIGHPRIORITY, MLDOCS_QRY_STAFF_NEW, MLDOCS_QRY_STAFF_MINE, MLDOCS_QRY_STAFF_ALL);
    $i = 1;
    foreach($archiveLists as $archiveList){
        $newSearch =& $hSavedSearch->create();
        $crit = new CriteriaCompo();
        switch($archiveList){
            case MLDOCS_QRY_STAFF_HIGHPRIORITY:
                $crit->add(new Criteria('uid', MLDOCS_GLOBAL_UID, '=', 'j'));
                $crit->add(new Criteria('state', 1, '=', 's'));
                $crit->add(new Criteria('ownership', 0, '=', 't'));
                $crit->setSort('t.priority, t.posted');
                $newSearch->setVar('name', _MLDOCS_TEXT_HIGH_PRIORITY);
                $newSearch->setVar('pagenav_vars', 'limit=50&state=1');
            break;
            
            case MLDOCS_QRY_STAFF_NEW:
                $crit->add(new Criteria('uid', MLDOCS_GLOBAL_UID, '=', 'j'));
                $crit->add(new Criteria('ownership', 0, '=', 't'));
                $crit->add(new Criteria('state', 1, '=', 's'));
                $crit->setSort('t.posted');
                $crit->setOrder('DESC');
                $newSearch->setVar('name', _MLDOCS_TEXT_NEW_ARCHIVES);
                $newSearch->setVar('pagenav_vars', 'limit=50&state=1');
            break;
            
            case MLDOCS_QRY_STAFF_MINE:
                $crit->add(new Criteria('uid', MLDOCS_GLOBAL_UID, '=', 'j'));
                $crit->add(new Criteria('ownership', MLDOCS_GLOBAL_UID, '=', 't'));
                $crit->add(new Criteria('state', 1, '=', 's'));
                $crit->setSort('t.posted');
                $newSearch->setVar('name', _MLDOCS_TEXT_MY_ARCHIVES);
                $newSearch->setVar('pagenav_vars', 'limit=50&state=1&ownership='.MLDOCS_GLOBAL_UID);
            break;
            
            case MLDOCS_QRY_STAFF_ALL:
                $crit->add(new Criteria('uid', MLDOCS_GLOBAL_UID, '=', 'j'));
                $crit->add(new Criteria('state', 1, '=', 's'));
                $crit->add(new Criteria('uid', MLDOCS_GLOBAL_UID, '=', 't'));
                $newSearch->setVar('name', _MLDOCS_TEXT_SUBMITTED_ARCHIVES);
                $newSearch->setVar('pagenav_vars', 'limit=50&state=1&submittedBy='.MLDOCS_GLOBAL_UID);
            break;
            
            default: 
                return false;
            break;
        }
        
        $newSearch->setVar('uid', MLDOCS_GLOBAL_UID);
        $newSearch->setVar('search', serialize($crit));
        $newSearch->setVar('hasCustFields', 0);
        $ret = $hSavedSearch->insert($newSearch, true);
        
        $staff =& $hStaff->getObjects(null, true);
        foreach($staff as $stf){
            $list =& $hArchiveList->create();
            $list->setVar('uid', $stf->getVar('uid'));
            $list->setVar('searchid', $newSearch->getVar('id'));
            $list->setVar('weight', $i);
            $ret = $hArchiveList->insert($list, true);
        }
        $i++;
    }
    return true;
}
?>
