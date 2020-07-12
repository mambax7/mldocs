<?php
//$Id: fieldlots.php,v 1.7 2006/02/17 16:16:40 gabybob Exp $
include('../../../include/cp_header.php');          
include_once('admin_header.php');           
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');
require_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');
require_once(MLDOCS_CLASS_PATH . '/mldocsForm.php');
require_once(MLDOCS_CLASS_PATH . '/mldocsFormRegex.php');

define('_MLDOCS_FIELD_MINLEN', 2);
define('_MLDOCS_FIELD_MAXLEN', 16777215);

global $xoopsModule;
$module_id = $xoopsModule->getVar('mid'); 

$op = 'default';

if ( isset( $_REQUEST['op'] ) )
{
    $op = $_REQUEST['op'];
}

switch ( $op )
{
    case "delfieldlot":
        deleteFieldlot();
        break;
    case "editfieldlot":
        editFieldlot();
        break;
   
    case "clearAddSession":
        clearAddSession();
        break;
        
    case "clearEditSession":
        clearEditSession();
        break;
        
    case "setFieldlotRequired":
        setFieldlotRequired();
        break;        
   
    case "manageFieldlots":
    default:
        manageFieldlots();
        break;
        
}

function manageFieldlots()
{
    global $oAdminButton, $imagearray;
    
    $session     =& Session::singleton();
    $regex_array =& _getRegexArray();
    $hFieldlots     =& mldocsGetHandler('archiveField');
   
    $start = $limit = 0;
    
    if (isset($_GET['limit'])) {
        $limit = intval($_GET['limit']);
    }
    
    if (isset($_GET['start'])) {
        $start = intval($_GET['start']);
    }
    
    if (!$limit) {
        $limit = 15;
    }
    
    if (!isset($_POST['addFieldlot'])) {
        $crit = new Criteria('','');
        $crit->setLimit($limit);
        $crit->setStart($start);
        $crit->setSort('weight');
        $crit->setOrder('ASC');
              
        $count = $hFieldlots->getCount($crit);
        $fieldlots =& $hFieldlots->getObjects($crit);
        
        //Display List of Current Fieldlots, form for new fieldlot
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manfieldlots');
        
        if ($count) {
            $nav = new XoopsPageNav($count, $limit, $start, 'start', "op=manageFieldlots&amp;limit=$limit");
 
            echo "<table width='100%' cellspacing='1' class='outer'>
                <tr><th colspan='7'><label>"._AM_MLDOCS_TEXT_MANAGE_FIELDLOTS."</label></th></tr>";
            echo "<tr class='head'>
                <td>"._AM_MLDOCS_TEXT_ID."</td>
                <td>"._AM_MLDOCS_TEXT_NAME."</td>
                <td>"._AM_MLDOCS_TEXT_DESCRIPTION."</td>
                <td>"._AM_MLDOCS_TEXT_FIELDNAME."</td>
                <td>"._AM_MLDOCS_TEXT_CONTROLTYPE."</td>
                <td>"._AM_MLDOCS_TEXT_REQUIRED."</td>
                <td>"._AM_MLDOCS_TEXT_ACTIONS."</td>
            </tr>";
        
            $req_link_params = array('op' => 'setFieldlotRequired', 
                'setrequired' => 1,
                'id' => 0);
        
            foreach ($fieldlots as $fieldlot) {
                $req_link_params['id'] = $fieldlot->getVar('id');
            
                if ($fieldlot->getVar('required')) {
                    $req_link_params['setrequired'] = 0;
                    $req_img = $imagearray['online'];
                    $req_title = _AM_MLDOCS_MESSAGE_DEACTIVATE;
                } else {
                    $req_link_params['setrequired'] = 1;
                    $req_img = $imagearray['offline'];
                    $req_title = _AM_MLDOCS_MESSAGE_ACTIVATE;
                }
                
                $edit_url = mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php',
                    array('op' => 'editfieldlot', 'id' => $fieldlot->getVar('id')));
                $del_url  = mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php',
                    array('op' => 'delfieldlot', 'id' => $fieldlot->getVar('id')));
                
                echo "<tr class='even'><td>".$fieldlot->getVar('id')."</td>
                    <td>".$fieldlot->getVar('name')."</td>
                    <td>".$fieldlot->getVar('description')."</td>
                    <td>".$fieldlot->getVar('fieldlotname')."</td>
                    <td>".mldocsGetControlLabel($fieldlot->getVar('controltype'))."</td>
                    <td><a href='".mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', $req_link_params)."' title='$req_title'>$req_img</a></td>
                    <td><a href='$edit_url'>{$imagearray['editimg']}</a>
                        <a href='$del_url'>{$imagearray['deleteimg']}</a></td>
                    </tr>";
                    

            }
            echo '</table>';
            //Render Page Nav
            echo "<div id='pagenav'>". $nav->renderNav(). "</div><br />";
        }
        
        //Get Custom Fieldlot From session (if exists)
        $fieldlot_info = $session->get('mldocs_addFieldlot');
        $fieldlot_errors = $session->get('mldocs_addFieldlotErrors');

        $hProfils =& mldocsGetHandler('department');
        $profils =& $hProfils->getObjects();
        
        foreach($profils as $obj) {
            $profilarr[$obj->getVar('id')] = $obj->getVar('department');
        }

        if (! $fieldlot_info === false) {
            //extract($fieldlot_info , EXTR_PREFIX_ALL , 'fld_');
            $fld_controltype = $fieldlot_info['controltype'];
            $fld_datatype = $fieldlot_info['datatype'];
            $fld_profilelots = $fieldlot_info['profilelots'];
            $fld_name = $fieldlot_info['name'];
            $fld_fieldlotname = $fieldlot_info['fieldlotname'];
            $fld_description = $fieldlot_info['description'];
            $fld_required = $fieldlot_info['required'];
            $fld_length = $fieldlot_info['length'];
            $fld_weight = $fieldlot_info['weight'];
            $fld_defaultvalue = $fieldlot_info['defaultvalue'];
            $fld_values = $fieldlot_info['values'];
            $fld_validation = $fieldlot_info['validation'];
        } else {
            $fld_controltype = '';
            $fld_datatype = '';
            $fld_departments = array_keys($profilarr);
            $fld_name = '';
            $fld_fieldlotname = '';
            $fld_description = '';
            $fld_required = '';
            $fld_length = '';
            $fld_weight = '';
            $fld_defaultvalue = '';
            $fld_values = '';
            $fld_validation = '';
        }
        
        if (! $fieldlot_errors === false) {
            mldocsRenderErrors($fieldlot_errors, mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'clearAddSession')));
        }
            
        //Add Fieldlot Form
        $controls = mldocsGetControlArray();
        $control_select =& new XoopsFormSelect(_AM_MLDOCS_TEXT_CONTROLTYPE, 'fld_controltype', $fld_controltype);
        foreach($controls as $key=>$control) {
            $control_select->addOption($key, $control['label']);
        }
        
        
        $datatypes = array(
            _MLDOCS_DATATYPE_TEXT => _MLDOCS_DATATYPE_TEXT,
            _MLDOCS_DATATYPE_NUMBER_INT => _MLDOCS_DATATYPE_NUMBER_INT,
            _MLDOCS_DATATYPE_NUMBER_DEC => _MLDOCS_DATATYPE_NUMBER_DEC);
            
        $datatype_select =& new XoopsFormSelect(_AM_MLDOCS_TEXT_DATATYPE, 'fld_datatype', $fld_datatype);
        $datatype_select->addOptionArray($datatypes);
        
        
        
        $profil_select =& new XoopsFormSelect(_AM_MLDOCS_TEXT_DEPARTMENTS, 'fld_departments', $fld_departments, 5, true);        
        foreach($profils as $obj) {
            $profil_select->addOptionArray($profilarr);
        }
        unset($profils);
        
        
        $form = new mldocsForm(_AM_MLDOCS_ADD_FIELD, 'add_fieldlot', mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'managefieldlots')));
        $nameEle = new XoopsFormText(_AM_MLDOCS_TEXT_NAME, 'fld_name', 30, 64, $fld_name);
        $nameEle->setDescription(_AM_MLDOCS_TEXT_NAME_DESC);
        $form->addElement($nameEle);
        
        $fieldlotnameEle = new XoopsFormText(_AM_MLDOCS_TEXT_FIELDNAME, 'fld_fieldlotname', 30, 64, $fld_fieldlotname);
        $fieldlotnameEle->setDescription(_AM_MLDOCS_TEXT_FIELDNAME_DESC);
        $form->addElement($fieldlotnameEle);
        
        $descriptionEle = new XoopsFormTextArea(_AM_MLDOCS_TEXT_DESCRIPTION, 'fld_description', $fld_description, 5, 60);
        $descriptionEle->setDescription(_AM_MLDOCS_TEXT_DESCRIPTION_DESC);
        $form->addElement($descriptionEle);
       
        $profil_select->setDescription(_AM_MLDOCS_TEXT_DEPT_DESC);
        $control_select->setDescription(_AM_MLDOCS_TEXT_CONTROLTYPE_DESC);
        $datatype_select->setDescription(_AM_MLDOCS_TEXT_DATATYPE_DESC);
       
        $form->addElement($profil_select);
        $form->addElement($control_select);
        $form->addElement($datatype_select);
        
        $required = new XoopsFormRadioYN(_AM_MLDOCS_TEXT_REQUIRED, 'fld_required', $fld_required);
        $required->setDescription(_AM_MLDOCS_TEXT_REQUIRED_DESC);
        $form->addElement($required);
        
        $lengthEle = new XoopsFormText(_AM_MLDOCS_TEXT_LENGTH, 'fld_length', 5, 5, $fld_length);
        $lengthEle->setDescription(_AM_MLDOCS_TEXT_LENGTH_DESC);
        $weightEle = new XoopsFormText(_AM_MLDOCS_TEXT_WEIGHT, 'fld_weight', 5, 5, $fld_weight);
        $weightEle->setDescription(_AM_MLDOCS_TEXT_WEIGHT_DESC);
        
        $form->addElement($lengthEle);
        $form->addElement($weightEle);
        
        $regex_control =& new mldocsFormRegex(_AM_MLDOCS_TEXT_VALIDATION, 'fld_valid', $fld_validation);
        $regex_control->addOptionArray($regex_array);
        $regex_control->setDescription(_AM_MLDOCS_TEXT_VALIDATION_DESC);
        
        $form->addElement($regex_control);
        
        $defaultValueEle = new XoopsFormText(_AM_MLDOCS_TEXT_DEFAULTVALUE, 'fld_defaultvalue', 30, 100, $fld_defaultvalue);
        $defaultValueEle->setDescription(_AM_MLDOCS_TEXT_DEFAULTVALUE_DESC);
        $form->addElement($defaultValueEle);
        $values = new XoopsFormTextArea(_AM_MLDOCS_TEXT_FIELDVALUES, 'fld_values', $fld_values, 5, 60);
        $values->setDescription(_AM_MLDOCS_TEXT_FIELDVALUES_DESC);
        $form->addElement($values);
        
        
        $btn_tray = new XoopsFormElementTray('');
        $btn_tray->addElement(new XoopsFormButton('', 'addFieldlot', _AM_MLDOCS_BUTTON_SUBMIT, 'submit'));
        
        $form->addElement($btn_tray);
        echo $form->render();
        
        mldocs_adminFooter();       
        xoops_cp_footer();
       
    } else {
        //Validate Fieldlot Information
        $has_errors = false;
        $hFieldlot =& mldocsGetHandler('archiveFieldlot');
        
        $values =& _parseValues($_POST['fld_values']);
        
        if (!$control = mldocsGetControl($_POST['fld_controltype'])) {
            $has_errors = true;
            $errors['fld_controltype'][] = _AM_MLDOCS_VALID_ERR_CONTROLTYPE;
        }
        
        $fld_needslength = $control['needs_length'];
        $fld_needsvalues = $control['needs_values'];
        
        
        //name fieldlot filled?
        if (trim($_POST['fld_name']) == '') {
            $has_errors = true;
            $errors['fld_name'][] = _AM_MLDOCS_VALID_ERR_NAME;
        }
        
        $fld_fieldlotname = sanitizeFieldName($_POST['fld_fieldlotname']);
       
        //fieldlotname filled
        if (trim($fld_fieldlotname) == '') {
            $has_errors = true;
            $errors['fld_fieldlotname'][] = _AM_MLDOCS_VALID_ERR_FIELDNAME;
        }
        
        
        //fieldlotname unique?
        $crit = new CriteriaCompo(new Criteria('fieldlotname', $fld_fieldlotname));
        if ($hFieldlot->getCount($crit)) {
            $has_errors = true;
            $errors['fld_fieldlotname'][] = _AM_MLDOCS_VALID_ERR_FIELDNAME_UNIQUE;
        }        
        
        //Length filled
        if (intval($_POST['fld_length']) == 0 && $fld_needslength == true) {
            $has_errors = true;
            $errors['fld_length'][] = sprintf(_AM_MLDOCS_VALID_ERR_LENGTH, 2, 16777215);
        }
        
        //Departments Chosen?
        
        //default value in value set?
        if (count($values)) {
            if (!in_array($_POST['fld_defaultvalue'], $values, true) && !array_key_exists($_POST['fld_defaultvalue'], $values) ) {
                $has_errors = true;
                $errors['fld_defaultvalue'][] = _AM_MLDOCS_VALID_ERR_DEFAULTVALUE;
            }
        
            //length larger than longest value?
            $length = intval($_POST['fld_length']);
            foreach($values as $key=>$value) {
                if (strlen($key) > $length) {
                    $has_errors = true;
                    $errors['fld_values'][] = sprintf(_AM_MLDOCS_VALID_ERR_VALUE_LENGTH, htmlentities($key), $length);
                }
            }
            
            //Values are all of the correct datatype?
        } elseif ($fld_needsvalues) {
            $has_errors = true;
            $errors['fld_values'][] = _AM_MLDOCS_VALID_ERR_VALUE;
        }
        
        
        
        if ($has_errors) {
            $afieldlot = array();
            
            $afieldlot['name'] = $_POST['fld_name'];
            $afieldlot['description'] = $_POST['fld_description'];
            $afieldlot['fieldlotname'] = $fld_fieldlotname;
            $afieldlot['departments'] = $_POST['fld_profilelots'];
            $afieldlot['controltype'] = $_POST['fld_controltype'];
            $afieldlot['datatype'] = $_POST['fld_datatype'];
            $afieldlot['required'] = $_POST['fld_required'];
            $afieldlot['weight'] = $_POST['fld_weight'];
            $afieldlot['defaultvalue'] = $_POST['fld_defaultvalue'];
            $afieldlot['values'] = $_POST['fld_values'];
            $afieldlot['length'] = $_POST['fld_length'];
            $afieldlot['validation'] = ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']);
            $session->set('mldocs_addFieldlot', $afieldlot);
            $session->set('mldocs_addFieldlotErrors', $errors);
            header('Location: '. mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php'));
            exit();
        }
        
        //Save fieldlot
        $hFieldlot =& mldocsGetHandler('archiveFieldlot');
        $fieldlot =& $hFieldlot->create();
        $fieldlot->setVar('name', $_POST['fld_name']);
        $fieldlot->setVar('description', $_POST['fld_description']);
        $fieldlot->setVar('fieldlotname', $fld_fieldlotname);
        $fieldlot->setVar('controltype', $_POST['fld_controltype']);
        $fieldlot->setVar('datatype', $_POST['fld_datatype']);
        $fieldlot->setVar('fieldlotlength', $_POST['fld_length']);
        $fieldlot->setVar('required', $_POST['fld_required']);
        $fieldlot->setVar('weight', $_POST['fld_weight']);
        $fieldlot->setVar('defaultvalue', $_POST['fld_defaultvalue']);
        $fieldlot->setVar('validation', ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']));
        $fieldlot->addValues($values);
        $fieldlot->addProfilelots($_POST['fld_profilelots']);
        
        
               
        if ($hFieldlot->insert($fieldlot)) {
            _clearAddSessionVars();
            redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php'), 3, _AM_MLDOCS_MSG_FIELD_ADD_OK);
            
        } else {
            $errors = $fieldlot->getHtmlErrors();
            redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php'), 3, _AM_MLDOCS_MSG_FIELD_ADD_ERR . $errors);
        }
    }
}

function _formatValues($values_arr)
{
    $ret = '';
    foreach($values_arr as $key=>$value) {
        $ret .= "$key=$value\r\n";
    }
    return $ret;            
}

function &_parseValues($raw_values)
{
    $_inValue = false;
    $values = array();
    
    if (strlen($raw_values) == 0) {
        return $values;
    }
    
    //Split values into name/value pairs
    $lines = explode("\r\n", $raw_values);
      
    //Parse each line into name=value
    foreach($lines as $line) {
        if (strlen(trim($line)) == 0) {
            continue(1);
        }
        $name = $value = '';
        $_inValue = false;
        $chrs = strlen($line);
        for ($i = 0; $i <= $chrs; $i++) {
            $chr = substr($line, $i, 1);
            if ($chr == '=' && $_inValue == false) {
                $_inValue=true;
            } else {
                if ($_inValue) {
                    $name .= $chr;
                } else {
                    $value .= $chr;
                }
            }
        }
        //Add value to array
        if ($value=='') {
            $values[$name]=$name;
        } else {
            $values[$value] = $name;
        }
        
        //Reset name / value vars
        $name = $value = ''; 
    }
    
    return $values;  
}

function deleteFieldlot()
{
    global $_eventsrv, $oAdminButton;
    if (!isset( $_REQUEST['id'])) {
        redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=> 'manageProfilelots'), false), 3, _AM_MLDOCS_MESSAGE_NO_FIELD);
    }
    
    $id = intval($_REQUEST['id']);
    
    if (!isset($_POST['ok'])) {
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manfieldlots');
        xoops_confirm(array('op' => 'delfieldlot', 'id' => $id, 'ok' => 1), MLDOCS_ADMIN_URL .'/fieldlots.php', sprintf(_AM_MLDOCS_MSG_FIELD_DEL_CFRM, $id));
        xoops_cp_footer();
    } else {
        $hFieldlots =& mldocsGetHandler('archiveFieldlot');
        $fieldlot =& $hFieldlots->get($id);
        if($hFieldlots->delete($fieldlot, true)){
            $_eventsrv->trigger('delete_fieldlot', array(&$fieldlot));
            header("Location: " . mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'manageFieldlots'), false));
            exit();
            
        } else {
            redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op' => 'manageFieldlots'), false), 3, $message);
        }
    }       
}

function editFieldlot()
{
    global $oAdminButton;
    
    $eventsrv =& mldocs_eventService::singleton();
    $session  =& Session::singleton();
    $regex_array =& _getRegexArray();
    
    if (!isset( $_REQUEST['id'])) {
        redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=> 'manageProfilelots'), false), 3, _AM_MLDOCS_MESSAGE_NO_FIELD);
    }
    
    $fld_id = intval($_REQUEST['id']);
    $hFieldlot =& mldocsGetHandler('archiveFieldlot');
    if (! $fieldlot =& $hFieldlot->get($fld_id)) {
        redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=> 'manageProfilelots'), false), 3, _AM_MLDOCS_MESSAGE_NO_FIELD);
    }
       
    if (!isset($_POST ['editFieldlot'])) {
        //Get Custom Fieldlot From session (if exists)
        $fieldlot_info = $session->get('mldocs_editFieldlot_'.$fld_id);
        $fieldlot_errors = $session->get('mldocs_editFieldlotErrors_'.$fld_id);
              
        if ( ! $fieldlot_info === false) {
            $fld_controltype = $fieldlot_info['controltype'];
            $fld_datatype = $fieldlot_info['datatype'];
            $fld_profilelots = $fieldlot_info['profilelots'];
            $fld_name = $fieldlot_info['name'];
            $fld_fieldlotname = $fieldlot_info['fieldlotname'];
            $fld_description = $fieldlot_info['description'];
            $fld_required = $fieldlot_info['required'];
            $fld_length = $fieldlot_info['length'];
            $fld_weight = $fieldlot_info['weight'];
            $fld_defaultvalue = $fieldlot_info['defaultvalue'];
            $fld_values = $fieldlot_info['values'];
            $fld_validation = $fieldlot_info['validation'];            
        } else {
            $hFProfil =& mldocsGetHandler('archiveFieldlotProfilelot');
            $profils =& $hFProfil->profilelotsByFieldlot($fieldlot->getVar('id'), true);
            
            $fld_controltype = $fieldlot->getVar('controltype');
            $fld_datatype = $fieldlot->getVar('datatype');
            $fld_profilelots = array_keys($profils);
            $fld_name = $fieldlot->getVar('name');
            $fld_fieldlotname = $fieldlot->getVar('fieldlotname');
            $fld_description = $fieldlot->getVar('description');
            $fld_required = $fieldlot->getVar('required');
            $fld_length = $fieldlot->getVar('fieldlotlength');
            $fld_weight = $fieldlot->getVar('weight');
            $fld_defaultvalue = $fieldlot->getVar('defaultvalue');
            $fld_values = _formatValues($fieldlot->getVar('fieldlotvalues'));
            $fld_validation = $fieldlot->getVar('validation');
        }
        
        
        //Display Fieldlot modification
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manfieldlots');
        //Edit Fieldlot Form
        
        $controls = mldocsGetControlArray();
        $control_select =& new XoopsFormSelect(_AM_MLDOCS_TEXT_CONTROLTYPE, 'fld_controltype', $fld_controltype);
        $control_select->setDescription(_AM_MLDOCS_TEXT_CONTROLTYPE_DESC);
        foreach($controls as $key=>$control) {
            $control_select->addOption($key, $control['label']);
        }
        
        $datatypes = array(
            _MLDOCS_DATATYPE_TEXT => _MLDOCS_DATATYPE_TEXT,
            _MLDOCS_DATATYPE_NUMBER_INT => _MLDOCS_DATATYPE_NUMBER_INT,
            _MLDOCS_DATATYPE_NUMBER_DEC => _MLDOCS_DATATYPE_NUMBER_DEC);
            
        $datatype_select =& new XoopsFormSelect(_AM_MLDOCS_TEXT_DATATYPE, 'fld_datatype', $fld_datatype);
        $datatype_select->setDescription(_AM_MLDOCS_TEXT_DATATYPE_DESC);
        $datatype_select->addOptionArray($datatypes);
        
        $hProfils =& mldocsGetHandler('profilelot');
        $profils =& $hProfils->getObjects();
        $profil_select =& new XoopsFormSelect(_AM_MLDOCS_TEXT_DEPARTMENTS, 'fld_profilelots', $fld_profilelots, 5, true);        
        $profil_select->setDescription(_AM_MLDOCS_TEXT_DEPT_DESC);
        foreach($profils as $obj) {
            $profil_select->addOption($obj->getVar('id'), $obj->getVar('profilelot'));
        }
        unset($profils);
        
        if (! $fieldlot_errors === false) {
            mldocsRenderErrors($fieldlot_errors, mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'clearEditSession', 'id'=>$fld_id)));
        }
        
        $form = new mldocsForm(_AM_MLDOCS_EDIT_FIELD, 'edit_fieldlot', mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'editfieldlot', 'id'=>$fld_id)));
        
        $nameEle = new XoopsFormText(_AM_MLDOCS_TEXT_NAME, 'fld_name', 30, 64, $fld_name);
        $nameEle->setDescription(_AM_MLDOCS_TEXT_NAME_DESC);
        $form->addElement($nameEle);
        
        $fieldlotnameEle = new XoopsFormText(_AM_MLDOCS_TEXT_FIELDNAME, 'fld_fieldlotname', 30, 64, $fld_fieldlotname);
        $fieldlotnameEle->setDescription(_AM_MLDOCS_TEXT_FIELDNAME_DESC);
        $form->addElement($fieldlotnameEle);
        
        $descriptionEle = new XoopsFormTextArea(_AM_MLDOCS_TEXT_DESCRIPTION, 'fld_description', $fld_description, 5, 60);
        $descriptionEle->setDescription(_AM_MLDOCS_TEXT_DESCRIPTION_DESC);
        $form->addElement($descriptionEle);
       
        $form->addElement($profil_select);
        $form->addElement($control_select);
        $form->addElement($datatype_select);
        
        $required = new XoopsFormRadioYN(_AM_MLDOCS_TEXT_REQUIRED, 'fld_required', $fld_required);
        $required->setDescription(_AM_MLDOCS_TEXT_REQUIRED_DESC);
        $form->addElement($required);
        
        $lengthEle = new XoopsFormText(_AM_MLDOCS_TEXT_LENGTH, 'fld_length', 5, 5, $fld_length);
        $lengthEle->setDescription(_AM_MLDOCS_TEXT_LENGTH_DESC);
        $form->addElement($lengthEle);
        
        $widthEle = new XoopsFormText(_AM_MLDOCS_TEXT_WEIGHT, 'fld_weight', 5, 5, $fld_weight);
        $widthEle->setDescription(_AM_MLDOCS_TEXT_WEIGHT_DESC);
        $form->addElement($widthEle);
        
        $regex_control =& new mldocsFormRegex(_AM_MLDOCS_TEXT_VALIDATION, 'fld_valid', $fld_validation);
        $regex_control->setDescription(_AM_MLDOCS_TEXT_VALIDATION_DESC);
        $regex_control->addOptionArray($regex_array);
        
        $form->addElement($regex_control);
        
        $defaultValueEle = new XoopsFormText(_AM_MLDOCS_TEXT_DEFAULTVALUE, 'fld_defaultvalue', 30, 100, $fld_defaultvalue);
        $defaultValueEle->setDescription(_AM_MLDOCS_TEXT_DEFAULTVALUE_DESC);
        $form->addElement($defaultValueEle);
        $values = new XoopsFormTextArea(_AM_MLDOCS_TEXT_FIELDVALUES, 'fld_values', $fld_values, 5, 60);
        $values->setDescription(_AM_MLDOCS_TEXT_FIELDVALUES_DESC);
        $form->addElement($values);
        
        
        $btn_tray = new XoopsFormElementTray('');
        $btn_tray->addElement(new XoopsFormButton('', 'editFieldlot', _AM_MLDOCS_BUTTON_SUBMIT, 'submit'));
        $btn_tray->addElement(new XoopsFormButton('','cancel', _AM_MLDOCS_BUTTON_CANCEL));
        $btn_tray->addElement(new XoopsFormHidden('id', $fld_id));
        
        $form->addElement($btn_tray);
        echo $form->render();
        
        mldocs_adminFooter();          
        xoops_cp_footer();
    } else {
        //Validate Fieldlot Information
        $has_errors = false;
        $errors = array();
        $values =& _parseValues($_POST['fld_values']);
        
        if (!$control = mldocsGetControl($_POST['fld_controltype'])) {
            $has_errors = true;
            $errors['fld_controltype'][] = _AM_MLDOCS_VALID_ERR_CONTROLTYPE;
        }
        
        $fld_needslength = $control['needs_length'];
        $fld_needsvalues = $control['needs_values'];
        
        //name fieldlot filled?
        if (trim($_POST['fld_name']) == '') {
            $has_errors = true;
            $errors['fld_name'][] = _AM_MLDOCS_VALID_ERR_NAME;
        }
        
        //fieldlotname filled
        if (trim($_POST['fld_fieldlotname']) == '') {
            $has_errors = true;
            $errors['fld_fieldlotname'][] = _AM_MLDOCS_VALID_ERR_FIELDNAME;
        }
        
        //fieldlotname unique?
        $crit = new CriteriaCompo(new Criteria('id', $fld_id, '!='));
        $crit->add(new Criteria('fieldlotname', $_POST['fld_fieldlotname']));
        if ($hFieldlot->getCount($crit)) {
            $has_errors = true;
            $errors['fld_fieldlotname'][] = _AM_MLDOCS_VALID_ERR_FIELDNAME_UNIQUE;
        }

        //Length filled
        if (intval($_POST['fld_length']) == 0 && $fld_needslength == true) {
            $has_errors = true;
            $errors['fld_length'][] = sprintf(_AM_MLDOCS_VALID_ERR_LENGTH, _MLDOCS_FIELD_MINLEN, _MLDOCS_FIELD_MAXLEN);
        }        
        
        //default value in value set?
        if (count($values)) {
            if (!in_array($_POST['fld_defaultvalue'], $values, true) && !array_key_exists($_POST['fld_defaultvalue'], $values) ) {
                $has_errors = true;
                $errors['fld_defaultvalue'][] = _AM_MLDOCS_VALID_ERR_DEFAULTVALUE;
            }
        
            //length larger than longest value?
            $length = intval($_POST['fld_length']);
            foreach($values as $key=>$value) {
                if (strlen($key) > $length) {
                    $has_errors = true;
                    $errors['fld_values'][] = sprintf(_AM_MLDOCS_VALID_ERR_VALUE_LENGTH, htmlentities($key), $length);
                }
            }
        } elseif ($fld_needsvalues) {
            $has_errors = true;
            $errors['fld_values'][] = _AM_MLDOCS_VALID_ERR_VALUE;
        }
        
        if ($has_errors) {
            $afieldlot = array();
            $afieldlot['name'] = $_POST['fld_name'];
            $afieldlot['description'] = $_POST['fld_description'];
            $afieldlot['fieldlotname'] = $_POST['fld_fieldlotname'];
            $afieldlot['profilelots'] = $_POST['fld_profilelots'];
            $afieldlot['controltype'] = $_POST['fld_controltype'];
            $afieldlot['datatype'] = $_POST['fld_datatype'];
            $afieldlot['required'] = $_POST['fld_required'];
            $afieldlot['weight'] = $_POST['fld_weight'];
            $afieldlot['defaultvalue'] = $_POST['fld_defaultvalue'];
            $afieldlot['values'] = $_POST['fld_values'];
            $afieldlot['length'] = $_POST['fld_length'];
            $afieldlot['validation'] = ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']);
            $session->set('mldocs_editFieldlot_'.$fld_id, $afieldlot);
            $session->set('mldocs_editFieldlotErrors_'.$fld_id, $errors);
            //Redirect to edit page (display errors);
            header('Location: '. mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'editfieldlot', 'id'=>$fld_id), false));
            exit();
            
        }        
        //Store Modified Fieldlot info
        
        $fieldlot->setVar('name', $_POST['fld_name']);
        $fieldlot->setVar('description', $_POST['fld_description']);
        $fieldlot->setVar('fieldlotname', $_POST['fld_fieldlotname']);
        $fieldlot->setVar('controltype', $_POST['fld_controltype']);
        $fieldlot->setVar('datatype', $_POST['fld_datatype']);
        $fieldlot->setVar('fieldlotlength', $_POST['fld_length']);
        $fieldlot->setVar('required', $_POST['fld_required']);
        $fieldlot->setVar('weight', $_POST['fld_weight']);
        $fieldlot->setVar('defaultvalue', $_POST['fld_defaultvalue']);
        $fieldlot->setVar('validation', ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']));
        $fieldlot->setValues($values);
        $fieldlot->addProfilelots($_POST['fld_profilelots']);
        
        if ($hFieldlot->insert($fieldlot)) {
            _clearEditSessionVars($fld_id);
            redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php'), 3, _AM_MLDOCS_MSG_FIELD_UPD_OK);
        } else {
            redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'editfieldlot', 'id'=>$fld_id), false), 3, _AM_MLDOCS_MSG_FIELD_UPD_ERR);
        }
    }  
    
}

function &_getRegexArray()
{
    $regex_array = array(
        '' => _AM_MLDOCS_TEXT_REGEX_CUSTOM,
        '^\d{3}-\d{3}-\d{4}$' => _AM_MLDOCS_TEXT_REGEX_USPHONE,
        '^\d{5}(-\d{4})?' => _AM_MLDOCS_TEXT_REGEX_USZIP,
        '^\w(?:\w|-|\.(?!\.|@))*@\w(?:\w|-|\.(?!\.))*\.\w{2,3}$' => _AM_MLDOCS_TEXT_REGEX_EMAIL);
        
    return $regex_array;
}

function setFieldlotRequired()
{
    
    $setRequired = intval($_GET['setrequired']);
    $id = intval($_GET['id']);
    
    $setRequired = ($setRequired <> 0 ?  1 : 0);
    
    $hFieldlot =& mldocsGetHandler('archiveFieldlot');
    
    if ($fieldlot =& $hFieldlot->get($id)) {
        $fieldlot->setVar('required', $setRequired);
        $ret = $hFieldlot->insert($fieldlot, true);
        if ($ret) {
            header('Location: ' . mldocsMakeURI(MLDOCS_ADMIN_URL .'/fieldlots.php'));
        } else {
            redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL .'/fieldlots.php'), 3, _AM_MLDOCS_MSG_FIELD_UPD_ERR);
        }
    } else {
        redirect_header(mldocsMakeURI(MLDOCS_ADMIN_URL .'/fieldlots.php'), 3, _AM_MLDOCS_MESSAGE_NO_FIELD);
    }
    
    
    
                
}

function clearAddSession()
{
    _clearAddSessionVars();
    header('Location: ' . mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php'));
}

function clearEditSession()
{
    $fieldlotid = $_REQUEST['id'];
    _clearEditSessionVars($fieldlotid);
    header('Location: ' . mldocsMakeURI(MLDOCS_ADMIN_URL.'/fieldlots.php', array('op'=>'editfieldlot', 'id'=>$fieldlotid), false));
}

function _clearAddSessionVars()
{
    $session = Session::singleton();
    $session->del('mldocs_addFieldlot');
    $session->del('mldocs_addFieldlotErrors');
}

function _clearEditSessionVars($id)
{
    $id = intval($id);
    $session = Session::singleton();
    $session->del("mldocs_editFieldlot_$id");
    $session->del("mldocs_editFieldlotErrors_$id");
}


?>
