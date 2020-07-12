<?
// $Id: archiveOutils.php,v 1.0 2004/01/01  gabybob 2006/03/04
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include("header.php");
include(XOOPS_ROOT_PATH."/header.php");

        $xoopsOption['template_main'] = 'mldocs_outilsform.html';
        include XOOPS_ROOT_PATH."/header.php";
        //gestion de la bannette archive par lots
        $TabFichier = array();// nom du fichier
        $TabFichierp = array(); //nom du fichier + repertoire
        $uid = $xoopsUser->getVar('uid');
        $username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur
        $dossier=(MLDOCS_BANNETTE_PATH."/".$username."/");  
   
        $has_mimes = false;
     
            //gestion de la bannette archive par lots
            $TabFichier = array();// nom du fichier
            $TabFichierp = array(); //nom du fichier + repertoire
            $uid = $xoopsUser->getVar('uid');
            $username = $xoopsUser->getUnameFromId($uid); //recuperation du nom utilisateur
            $dossier=(MLDOCS_BANNETTE_PATH."/".$username."/");        
            if (is_dir($dossier)) 
            {
              $nbvues=0;
              $ListeF = '';
              if ($dh = opendir($dossier)) {
                while ($fichier = readdir ($dh)) {
                    if ($fichier != "." && $fichier != "..") {
                    $TabFichier[$nbvues] =$fichier;
                        $nbvues++;
                        if($ListeF == ''){
                              $ListeF = $fichier;
                         } else {                                      
                        $ListeF .= " ../.. " . $fichier;
            		        }
                      }
          		      $TabFichierp[$nbvues] = $dossier.$fichier;
                }
              closedir($dh);
              //echo ("$username vous avez $nbvues fichier(s) dans la bannette<br>");
              $xoopsTpl->assign('mldocs_nbvues', $nbvues);
              $xoopsTpl->assign('mldocs_dossier', $dossier);
              $xoopsTpl->assign('mldocs_listefichier', $ListeF);
              }
            }
            
            
            
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
    // fin du code de test
 if (empty($_POST['submit']) | !$GLOBALS['xoopsSecurity']->check()) {
    
    
    
    include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    
   // ici les infos du formulaire
    
    include XOOPS_ROOT_PATH."/footer.php";
} else {
  

    redirect_header(XOOPS_URL."/index.php",2,$messagesent);
}   
    
    
include(XOOPS_ROOT_PATH."/footer.php");
?>
