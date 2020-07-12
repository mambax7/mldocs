<?php

/**
 * mldocsArchiveMailParser class
 *
 * Part of the email submission subsystem. Converts a parsed email into a archive
 *
 * @author Nazar Aziz <nazar@panthersoftware.com>
 * @access public
 * @depreciated
 * @package mldocs
 */
class mldocsArchiveMailParser 
{
    /**
     * Instance of Archive Object
     * @access private
     */
    var $_archive;
  
    /**
     * Class Constructor
     * @access public
     */  
    function mldocsArchiveMailParser() 
    {
        //any inits?
    }
  
    /**
     * Create a new archive object
     * @param object Reference to a {@link mldocsEmailParser} object
     * @param object Current {@link xoopsUser} object
     * @param object {@link mldocsDepartment} Archive Department
     * @param object {@link mldocsDepartmentEmailServer} Originating Email Server
     * @return bool
     * @access public
     */
    function createArchive(&$mailParser, &$xoopsUser, &$department, &$server) 
    {
        //get archive handler
        $hArchive =& mldocsGetHandler('archive');
        $archive  =& $hArchive->create();
        //
        $archive->setVar('uid',         $xoopsUser->uid());
        $archive->setVar('subject',     $mailParser->getSubject());
        $archive->setVar('department',  $department->getVar('id'));
        $archive->setVar('description', $mailParser->getBody());
        $archive->setVar('priority',    3);
        $archive->setVar('posted',      time());
        $archive->setVar('userIP',      _MLDOCS_EMAIL_SCANNER_IP_COLUMN);
        $archive->setVar('serverid',    $server->getVar('id'));
        $archive->createEmailHash($mailParser->getEmail());
        //
        if ($hArchive->insert($archive)){
            $this->_archive = $archive;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns the archive object for this email
     * @return object {@link mldocsArchive} Archive Object
     */
    function &getArchive() 
    {
        return $this->_archive;
    }

}

?>