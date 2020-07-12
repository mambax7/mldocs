<?PHP
include ('../../mainfile.php');
//include(XOOPS_ROOT_PATH.\u2019/header.php\u2019);
require_once('header.php');

$hArchive =& mldocsGetHandler('archive');
$hStaff =& mldocsGetHandler('staff');
$hGroupPerm =& xoops_gethandler('groupperm');
$hMember =& xoops_gethandler('member');
$hMembership =& mldocsGetHandler('membership');
$hFieldDept =& mldocsGetHandler('archiveFieldDepartment');

$module_id = $xoopsModule->getVar('mid'); 

if($xoopsUser){
    if(!isset($dept_id)){
        $dept_id = mldocsGetMeta("default_department");
    }

    if(isset($_GET['saveArchive']) && $_GET['saveArchive'] == 1){
        _saveArchive();
    }
    
   
        $xoopsOption['template_main'] = 'mldocs_bannetteform.html';             // Always set main template before including the header
        include(XOOPS_ROOT_PATH . '/header.php');      

        $hDepartments  =& mldocsGetHandler('department');    // Department handler
        $crit = new Criteria('','');
        $crit->setSort('department');
        $departments =& $hDepartments->getObjects($crit);
        if(count($departments) == 0){
            $message = _MLDOCS_MESSAGE_NO_DEPTS;
            redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
        }
        $aDept = array();
        $myGroups =& $hMember->getGroupsByUser($xoopsUser->getVar('uid'));
        if(($isStaff) && ($xoopsModuleConfig['mldocs_deptVisibility'] == 0)){     // If staff are not applied
            foreach($departments as $dept){
                $deptid = $dept->getVar('id');
                $aDept[] = array('id'=>$deptid,
                                 'department'=>$dept->getVar('department'));
            }
        } else {
            foreach($departments as $dept){
                $deptid = $dept->getVar('id');
                foreach($myGroups as $group){   // Check for user to be in multiple groups
                    if($hGroupPerm->checkRight(_MLDOCS_GROUP_PERM_DEPT, $deptid, $group, $module_id)){
                    		//Assign the first value to $dept_id incase the default department property not set
                    		if ($dept_id == null) {
                    			$dept_id = $deptid;
                    		}
                        $aDept[] = array('id'=>$deptid,
                                         'department'=>$dept->getVar('department'));
                        break;
                    }
                }
            }
        }

        // User Dept visibility check
        if(empty($aDept)){
            $message = _MLDOCS_MESSAGE_NO_DEPTS;
            redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
        }
        
        $xoopsTpl->assign('mldocs_isUser', true);
        
        if($isStaff){
            $checkStaff =& $hStaff->getByUid($xoopsUser->getVar('uid'));
            if(!$hasRights = $checkStaff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_ADD)){
                $message = _MLDOCS_MESSAGE_NO_ADD_ARCHIVE;
                redirect_header(MLDOCS_BASE_URL."/index.php", 3, $message);
            }
            unset($checkStaff);
            
            if($hasRights = $mldocs_staff->checkRoleRights(_MLDOCS_SEC_ARCHIVE_OWNERSHIP, $dept_id)){
               $staff =& $hMembership->xoopsUsersByDept($dept_id);
                
                $aOwnership = array();
                $aOwnership[0] = _MLDOCS_NO_OWNER;
                foreach($staff as $stf){
                    $aOwnership[$stf->getVar('uid')] = $stf->getVar('uname');
                }
                $xoopsTpl->assign('mldocs_aOwnership', $aOwnership);
            } else {
                $xoopsTpl->assign('mldocs_aOwnership', false);
            }
        }
        

        //gestion de la bannette archive par lots
        $TabFichier = array();// nom du fichier
        $TabFichierp = array(); //nom du fichier + repertoire
        $uid = $xoopsUser->getVar('uid');
        $username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur
        $dossier=(MLDOCS_BANNETTE_PATH."/".$username."/");  
   
        $has_mimes = false;
     
            //gestion de la bannette archive par lots
            $aUploadxFiles = array();// nom du fichier
            $uid = $xoopsUser->getVar('uid');
            $username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur
            $dossier=(MLDOCS_BANNETTE_PATH."/".$username."/");        
            $aUploadxFiles = read_dir($dossier);
            //print_r($aUploadxFiles);
            foreach($aUploadxFiles as $key=>$aFile){
                echo $aFile ['name'].'</br>' ;
                echo $aFile ['tmp_name'].'</br>';
                if (function_exists('mime_content_type')){
                echo $aFile ['type'].'</br>' ;
                }
                echo $aFile ['size'].'</br>' ;
                echo $aFile ['error'].'</br>' ;
                
            }
              
              if(PHP_OS=='WINNT')  {
                       $chaineNT= MLDOCS_BASE_PATH."/__TIFF/tiff2png.exe"." ".MLDOCS_BANNETTE_PATH."/gabybob/*.tif";
                       echo PHP_OS."<br>";
                       echo $chaineNT;
                       exec($chaineNT);
                       }
                        else    {
                        $chaineLINUX = MLDOCS_BASE_PATH."/__TIFF/tiff2png"." ".MLDOCS_BANNETTE_PATH."/".$username."/*.tif";
                        passthru("tiff2png"." ".MLDOCS_BANNETTE_PATH."/".$username."/*.tif");
                        }
                        
              
              //echo ("$username vous avez $nbvues fichier(s) dans la bannette<br>");
              $xoopsTpl->assign('mldocs_nbvues', $nbvues);
              $xoopsTpl->assign('mldocs_dossier', $dossier);
              $xoopsTpl->assign('mldocs_listefichier', $ListeF);
             
          
            
            
            
            // Get available mimetypes for file uploading
            $hMime =& mldocsGetHandler('mimetype');
            $mldocs =& mldocsGetModule();
            $mid = $mldocs->getVar('mid');
            if(!$isStaff){
                $crit = new Criteria('mime_user', 1);
            } else {
                $crit = new Criteria('mime_admin', 1);
            }
            $mimetypes =& $hMime->getObjects($crit);
            $mimes = '';
            foreach($mimetypes as $mime){
                if($mimes == ''){
                    $mimes = $mime->getVar('mime_ext');
                } else {                                      
                    $mimes .= ", " . $mime->getVar('mime_ext');
                }
            }
            $xoopsTpl->assign('mldocs_mimetypes', $mimes);
} else {    // If not a user
    $config_handler =& xoops_gethandler('config');
    //$xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
    $xoopsConfigUser = array();
    $crit = new CriteriaCompo(new Criteria('conf_name', 'allow_register'), 'OR');
    $crit->add(new Criteria('conf_name', 'activation_type'), 'OR');
    $myConfigs =& $config_handler->getConfigs($crit);
    
    foreach($myConfigs as $myConf){
        $xoopsConfigUser[$myConf->getVar('conf_name')] = $myConf->getVar('conf_value');
    }
    if ($xoopsConfigUser['allow_register'] == 0) {    // Use to doublecheck that anonymous users are allowed to register
    	header("Location: ".MLDOCS_BASE_URL."/error.php");    
    } else {
        header("Location: ".MLDOCS_BASE_URL."/anon_addArchive.php"); 
    }
    exit();
} 

echo count($aUploadxFiles);
// charge les vues de la bannette vers le serveur
if(count($aUploadxFiles) > 0){   // Has uploaded files? 
                foreach($aUploadxFiles as $key=>$aFile){
                    //$file = $archive->storeUploadx($key, null, $allowed_mimetypes);
                    //$_eventsrv->trigger('new_file', array(&$archive, &$file));
                }
            }
  
require(XOOPS_ROOT_PATH.'/footer.php'); 


// gere UPLOAD vers le rayonnage 00 - 99
function storeUploadx($post_field, $response = null, $allowed_mimetypes = null) 
	{
	    global $xoopsUser, $xoopsDB, $xoopsModule;
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
        if(!is_dir(MLDOCS_ARCHIVE_PATH)){
            mkdir(MLDOCS_ARCHIVE_PATH, 0757);
        }
        
        $uploader = new XoopsMediaUploader(MLDOCS_ARCHIVE_PATH.'/', $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
        if ($uploader->fetchMedia($post_field)) {
            if (!isset($response)) {
                $uploader->setTargetFileName($archiveid."_". $uploader->getMediaName());
            } else {
                if($response > 0){
                    $uploader->setTargetFileName($archiveid."_".$response."_".$uploader->getMediaName());
                } else {
                    $uploader->setTargetFileName($archiveid."_". $uploader->getMediaName());
                }
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
?> 
