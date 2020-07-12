<?php
//$Id: archiveFieldDepartment.php,v 1.5 2005/10/03 19:13:08 eric_juden Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //

class mldocsArchiveFieldlotProfilelotHandler
{
    var $_db;
    var $_hFieldlot;
    var $_hProfil;
    
    /**
     * Constructor
     *
     * @param object &$db {@Link XoopsDatabase}
     * @access public
     */
    function mldocsArchiveFieldlotProfilelotHandler(&$db)
    {
        $this->_db =& $db;
        $this->_hFieldlot =& mldocsGetHandler('archiveFieldlot');
        $this->_hProfil  =& mldocsGetHandler('profilelot');
    }
    
    
    /**
     * Get every profilelot a fieldlot is "in"
     *
     * @param int $fieldlot Fieldlot ID
     * @param bool $id_as_key Should object ID be used as array key?
     * @return array array of {@Link mldocsProfilelot} objects
     * @access public
     */
    function profilelotsByFieldlot($fieldlot, $id_as_key = false)
    {
        $fieldlot = intval($fieldlot);
        $sql   = sprintf('SELECT d.* FROM %s d INNER JOIN %s j ON d.id = j.profilid WHERE j.fieldlotid = %u',
            $this->_db->prefix('mldocs_profilelots'), $this->_db->prefix('mldocs_archive_fieldlot_profilelots'), $fieldlot);
        $ret = $this->_db->query($sql);
        $arr = array();
        
        if($ret){
            while ($temp = $this->_db->fetchArray($ret)) {
                $profil =& $this->_hProfil->create();
                $profil->assignVars($temp);
                if ($id_as_key) {
                    $arr[$profil->getVar('id')] =& $profil;
                } else {
                    $arr[] =& $profil;
                }
                unset($temp);
                
            }
        }
        
        return $arr;
    }


    /**
     * Get every fieldlot in a profilelot
     *
     * @param int $profil Profilelot ID
     * @param bool $id_as_key Should object ID be used as array key?
     * @return array array of {@Link mldocsArchiveFieldlot} objects
     * @access public
     */
    function fieldlotsByProfilelot($profil, $id_as_key = false)
    {
        $profil = intval($profil);
        $sql   = sprintf('SELECT f.* FROM %s f INNER JOIN %s j ON f.id = j.fieldlotid WHERE j.profilid = %u ORDER BY f.weight',
            $this->_db->prefix('mldocs_archive_fieldlots'), $this->_db->prefix('mldocs_archive_fieldlot_profilelots'), $profil);
        $ret = $this->_db->query($sql);
        $arr = array();
        
        if($ret){
            while ($temp = $this->_db->fetchArray($ret)) {
                $fieldlot =& $this->_hFieldlot->create();
                $fieldlot->assignVars($temp);
                if ($id_as_key) {
                    $arr[$fieldlot->getVar('id')] =& $fieldlot;
                } else {
                    $arr[] =& $fieldlot;
                }
                unset($temp);
                
            }        
        }
        return $arr;
    }
    

    /**
    * Add the given fieldlot to the given profilelot
    *
    * @param mixed $staff single or array of uids or {@link mldocsArchiveFieldlot} objects
    * @param int $profilid Profilelot ID
    * @return bool True if successful, False if not
    * @access public
    */        
    function addFieldlotToProfilelot(&$fieldlot, $profilid)
    {
        if (!is_array($fieldlot)) {
            $ret = $this->_addMembership($fieldlot, $profilid);
        } else {
            foreach ($fieldlot as $var) {
                $ret = $this->_addMembership($var, $profilid);
                if (!$ret) {
                    break;
                }              
            }
        }
        return $ret;
    }
    
    /**
     * Add the given profilelot(s) to the given fieldlot
     *
     * @param mixed $profil single or array of profilelot id's or {@Link mldocsProfilelot} objects
     * @param int $fieldlot Fieldlot ID
     * @retnr bool True if successful, False if not
     * @access public
     */
    function addProfilelotToFieldlot($profil, $fieldlot)
    {
        if (!is_array($profil)) {
            $ret = $this->_addMembership($fieldlot, $profil);
        } else {
            foreach ($profil as $var) {
                $ret = $this->_addMembership($fieldlot, $var);
                if (!$ret) {
                    break;
                }
            }
        }
        return $ret;
    }
    
    /**
     * Remove the given fieldlot(s) from the given profilelot
     *
     * @param mixed $fieldlot single or array of fieldlot ids or {@link mldocsArchiveFieldlot} objects
     * @param int $profilid Profilelot ID
     * @return bool True if successful, False if not
     * @access public
     */
    function removeFieldlotFromProfil(&$fieldlot, $profilid)
    {
        if (!is_array($fieldlot)) {
            $ret = $this->_removeMembership($fieldlot, $profilid);
        } else {
            foreach ($fieldlot as $var) {
                $ret = $this->_removeMembership($var, $profilid);
                if (!$ret) {
                    break;
                }
            }
        }
        return $ret;
    }

    /**
     * Remove the given profilelot(s) from the given fieldlot
     *
     * @param mixed $profil single or array of profilelot id's or {@link mldocsProfilelot} objects
     * @param int $fieldlot Fieldlot ID
     * @return bool True if successful, False if not
     * @access public
     */        
    function removeProfilFromFieldlot(&$profil, $fieldlot)
    {
        if (!is_array($profil)) {
            $ret = $this->_removeMembership($fieldlot, $profil);
        } else {
            foreach ($profil as $var) {
                $ret = $this->_removeMembership($fieldlot, $var);
                if (!$ret) {
                    break;
                }
            }
        }
        return $ret;
    }
    
    /**
     * Remove All Profilelots from a particular fieldlot
     * @param int $fieldlot Fieldlot ID
     * @return bool True if successful, False if not
     * @access public
     */
    function removeFieldlotFromAllProfil($fieldlot)
    {
        $fieldlot = intval($fieldlot);
        $crit = new Criteria('fieldlotid', $fieldlot);
        $ret = $this->deleteAll($crit);
        return $ret;         
    }
    
    /**
     * Remove All Profilelots from a particular fieldlot
     * @param int $fieldlot Fieldlot ID
     * @return bool True if successful, False if not
     * @access public
     */
    
    function removeProfilFromAllFieldlots($profil)
    {
        $profil = intval($profil);
        $crit = new Criteria('profilid', $profil);
        $ret = $this->deleteAll($crit);
        return $ret;
    }
    
    
    function deleteAll($criteria=null, $force=false)
    {
        $sql = 'DELETE FROM '.$this->_db->prefix('mldocs_archive_fieldlot_profilelots');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		
		if (!$force) {
		    $result = $this->_db->query($sql);
		} else {
		    $result = $this->_db->queryF($sql);
		}
		if (!$result) {
			return false;
		}
		return true;
    }
    
    /**
     * Add a fieldlot to a profilelot
     *
     * @param mixed $fieldlot fieldlotid or {@Link mldocsArchiveFieldlot} object
     * @param mixed $profil profilid or {@Link mldocsProfilelot} object
     * @return bool True if Successful, False if not
     * @access private
     */
    function _addMembership(&$fieldlot, &$profil)
    {
        $fieldlotid = $profilid = 0;
        
        if (is_object($fieldlot)) {
            $fieldlotid = $fieldlot->getVar('id');
        } else {
            $fieldlotid = intval($fieldlot);
        }
        
        if (is_object($profil)) {
            $profilid = $profil->getVar('id');
        } else {
            $profilid = intval($profil);
        }
        
        $ret = $this->_addJoinerRecord($fieldlotid, $profilid);
        return $ret;
    }

    function _addJoinerRecord($fieldlotid, $profilid)
    {
        $sql = sprintf('INSERT INTO %s (fieldlotid, profilid) VALUES (%u, %u)', 
            $this->_db->prefix('mldocs_archive_fieldlot_profilelots'), $fieldlotid, $profilid);
        $ret = $this->_db->query($sql);
        return $ret;
    }
    
    function _removeMembership(&$fieldlot, &$profil)
    {
        $fieldlotid = $profilid = 0;
        if (is_object($fieldlot)) {
            $fieldlotid = $fieldlot->getVar('id');
        } else {
            $fieldlotid = intval($fieldlot);
        }
        
        if (is_object($profil)) {
            $profilid = $profil->getVar('id');
        } else {
            $profilid = intval($profil);
        }
        
        $ret = $this->_removeJoinerRecord($fieldlotid, $profilid);
        return $ret;
    }        

    function _removeJoinerRecord($fieldlotid, $profilid)
    {
        $sql = sprintf('DELETE FROM %s WHERE fieldlotid = %u AND profilid = %u', 
            $this->_db->prefix('mldocs_archive_fieldlot_profilelots'), $fieldlotid, $profilid);
        $ret = $this->_db->query($sql);
        return $ret;
    }

        
}


?>
