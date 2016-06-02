<?php
/**
 * Extended User Profile
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         profile
 * @since           2.3.0
 * @author          Jan Pedersen
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: forms.php 4751 2010-05-01 15:35:45Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

	function profile_get_email() {
		
		xoops_loadLanguage('forms', 'linkedinbomb');
		
		$sform = new XoopsThemeForm(_FRM_LINKEDIN_FORM_GET_EMAIL, 'email', 'getemail.php', 'post');
		
		if (empty($id)) $id = '0';
		
		$ele = array();	
		$ele['op'] = new XoopsFormHidden('op', 'email');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		
		$ele['email'] = new XoopsFormText(_FRM_LINKEDIN_FORM_EMAIL, 'email', 26,128);
		$ele['email']->setDescription(_FRM_LINKEDIN_FORM_DESC_EMAIL);
		
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('email');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
		
		return $sform->render();
		
	}	
	/**
	 * Get {@link XoopsThemeForm} for adding/editing fields
	 *
	 * @param object $field {@link ProfileField} object to get edit form for
	 * @param mixed $action URL to submit to - or false for $_SERVER['REQUEST_URI']
	 *
	 * @return object
	 */
	function profile_getFieldForm(&$field, $action = false)
	{
	    if ( $action === false ) {
	        $action = $_SERVER['REQUEST_URI'];
	    }
	    $title = $field->isNew() ? sprintf(_PROFILE_AM_ADD, _PROFILE_AM_FIELD) : sprintf(_PROFILE_AM_EDIT, _PROFILE_AM_FIELD);
	
	    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
	    $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
	
	    $form->addElement(new XoopsFormText(_PROFILE_AM_TITLE, 'field_title', 35, 255, $field->getVar('field_title', 'e')));
	    $form->addElement(new XoopsFormTextArea(_PROFILE_AM_DESCRIPTION, 'field_description', $field->getVar('field_description', 'e')));
	
	    if (!$field->isNew()) {
	        $fieldcat_id = $field->getVar('cat_id');
	    } else {
	        $fieldcat_id = 0;
	    }
	    $category_handler =& xoops_getmodulehandler('category');
	    $cat_select = new XoopsFormSelect(_PROFILE_AM_CATEGORY, 'field_category', $fieldcat_id);
	    $cat_select->addOption(0, _PROFILE_AM_DEFAULT);
	    $cat_select->addOptionArray($category_handler->getList());
	    $form->addElement($cat_select);
	    $form->addElement(new XoopsFormText(_PROFILE_AM_WEIGHT, 'field_weight', 10, 10, $field->getVar('field_weight', 'e')));
	    if ($field->getVar('field_config') || $field->isNew()) {
	        if (!$field->isNew()) {
	            $form->addElement(new XoopsFormLabel(_PROFILE_AM_NAME, $field->getVar('field_name')));
	            $form->addElement(new XoopsFormHidden('id', $field->getVar('field_id')));
	        } else {
	            $form->addElement(new XoopsFormText(_PROFILE_AM_NAME, 'field_name', 35, 255, $field->getVar('field_name', 'e')));
	        }
	
	        //autotext and theme left out of this one as fields of that type should never be changed (valid assumption, I think)
	        $fieldtypes = array(
	            'checkbox' => _PROFILE_AM_CHECKBOX,
	            'date' => _PROFILE_AM_DATE,
	            'datetime' => _PROFILE_AM_DATETIME,
	            'longdate' => _PROFILE_AM_LONGDATE,
	            'group' => _PROFILE_AM_GROUP,
	            'group_multi' => _PROFILE_AM_GROUPMULTI,
	            'language' => _PROFILE_AM_LANGUAGE,
	            'radio' => _PROFILE_AM_RADIO,
	            'select' => _PROFILE_AM_SELECT,
	            'select_multi' => _PROFILE_AM_SELECTMULTI,
	            'textarea' => _PROFILE_AM_TEXTAREA,
	            'dhtml' => _PROFILE_AM_DHTMLTEXTAREA,
	            'textbox' => _PROFILE_AM_TEXTBOX,
	            'timezone' => _PROFILE_AM_TIMEZONE,
	            'yesno' => _PROFILE_AM_YESNO,
				'validation' => _PROFILE_AM_VALIDATION,
	        	'validation2' => _PROFILE_AM_VALIDATION2,
    			'ip' => _PROFILE_AM_IP,
    			'proxy-ip' => _PROFILE_AM_PROXYIP,
    			'network-addy' => _PROFILE_AM_NETWORKADDY);
	
	        $element_select = new XoopsFormSelect(_PROFILE_AM_TYPE, 'field_type', $field->getVar('field_type', 'e'));
	        $element_select->addOptionArray($fieldtypes);
	
	        $form->addElement($element_select);
	
	        switch ($field->getVar('field_type')) {
	            case "textbox":
	                $valuetypes = array(
	                    XOBJ_DTYPE_ARRAY            => _PROFILE_AM_ARRAY,
	                    XOBJ_DTYPE_EMAIL            => _PROFILE_AM_EMAIL,
	                    XOBJ_DTYPE_INT              => _PROFILE_AM_INT,
	                    XOBJ_DTYPE_FLOAT            => _PROFILE_AM_FLOAT,
	                    XOBJ_DTYPE_DECIMAL          => _PROFILE_AM_DECIMAL,
	                    XOBJ_DTYPE_TXTAREA          => _PROFILE_AM_TXTAREA,
	                    XOBJ_DTYPE_TXTBOX           => _PROFILE_AM_TXTBOX,
	                    XOBJ_DTYPE_URL              => _PROFILE_AM_URL,
	                    XOBJ_DTYPE_OTHER    		=> _PROFILE_AM_OTHER,
	                    XOBJ_DTYPE_UNICODE_ARRAY 	=> _PROFILE_AM_UNICODE_ARRAY,
	                    XOBJ_DTYPE_UNICODE_TXTBOX 	=> _PROFILE_AM_UNICODE_TXTBOX,
	                    XOBJ_DTYPE_UNICODE_TXTAREA 	=> _PROFILE_AM_UNICODE_TXTAREA,
	                    XOBJ_DTYPE_UNICODE_EMAIL 	=> _PROFILE_AM_UNICODE_EMAIL,
	                    XOBJ_DTYPE_UNICODE_URL 		=> _PROFILE_AM_UNICODE_URL);
	
	                $type_select = new XoopsFormSelect(_PROFILE_AM_VALUETYPE, 'field_valuetype', $field->getVar('field_valuetype', 'e'));
	                $type_select->addOptionArray($valuetypes);
	                $form->addElement($type_select);
	                break;
					
				case "validation":
				case "validation2":
	                $valuetypes = array(
	                    XOBJ_DTYPE_TXTBOX           => _PROFILE_AM_TXTBOX);
	                $type_select = new XoopsFormSelect(_PROFILE_AM_VALUETYPE, 'field_valuetype', $field->getVar('field_valuetype', 'e'));
	                $type_select->addOptionArray($valuetypes);
	                $form->addElement($type_select);
	                break;
					
	            case "select":
	            case "radio":
	                $valuetypes = array(
	                    XOBJ_DTYPE_ARRAY            => _PROFILE_AM_ARRAY,
	                    XOBJ_DTYPE_EMAIL            => _PROFILE_AM_EMAIL,
	                    XOBJ_DTYPE_INT              => _PROFILE_AM_INT,
	                    XOBJ_DTYPE_FLOAT            => _PROFILE_AM_FLOAT,
	                    XOBJ_DTYPE_DECIMAL          => _PROFILE_AM_DECIMAL,
	                    XOBJ_DTYPE_TXTAREA          => _PROFILE_AM_TXTAREA,
	                    XOBJ_DTYPE_TXTBOX           => _PROFILE_AM_TXTBOX,
	                    XOBJ_DTYPE_URL              => _PROFILE_AM_URL,
	                    XOBJ_DTYPE_OTHER            => _PROFILE_AM_OTHER,
	                    XOBJ_DTYPE_UNICODE_ARRAY    => _PROFILE_AM_UNICODE_ARRAY,
	                    XOBJ_DTYPE_UNICODE_TXTBOX   => _PROFILE_AM_UNICODE_TXTBOX,
	                    XOBJ_DTYPE_UNICODE_TXTAREA  => _PROFILE_AM_UNICODE_TXTAREA,
	                    XOBJ_DTYPE_UNICODE_EMAIL    => _PROFILE_AM_UNICODE_EMAIL,
	                    XOBJ_DTYPE_UNICODE_URL      => _PROFILE_AM_UNICODE_URL);
	
	                $type_select = new XoopsFormSelect(_PROFILE_AM_VALUETYPE, 'field_valuetype', $field->getVar('field_valuetype', 'e'));
	                $type_select->addOptionArray($valuetypes);
	                $form->addElement($type_select);
	                break;
	        }
	
	        //$form->addElement(new XoopsFormRadioYN(_PROFILE_AM_NOTNULL, 'field_notnull', $field->getVar('field_notnull', 'e') ));
	
	        if ($field->getVar('field_type') == "select" || $field->getVar('field_type') == "select_multi" || $field->getVar('field_type') == "radio" || $field->getVar('field_type') == "checkbox") {
	            $options = $field->getVar('field_options');
	            if (count($options) > 0) {
	                $remove_options = new XoopsFormCheckBox(_PROFILE_AM_REMOVEOPTIONS, 'removeOptions');
	                $remove_options->columns = 3;
	                asort($options);
	                foreach (array_keys($options) as $key) {
	                    $options[$key] .= "[{$key}]";
	                }
	                $remove_options->addOptionArray($options);
	                $form->addElement($remove_options);
	            }
	
	            $option_text = "<table  cellspacing='1'><tr><td width='20%'>" . _PROFILE_AM_KEY . "</td><td>" . _PROFILE_AM_VALUE . "</td></tr>";
	            for ($i = 0; $i < 3; $i++) {
	                $option_text .= "<tr><td><input type='text' name='addOption[{$i}][key]' id='addOption[{$i}][key]' size='15' /></td><td><input type='text' name='addOption[{$i}][value]' id='addOption[{$i}][value]' size='35' /></td></tr>";
	                $option_text .= "<tr height='3px'><td colspan='2'> </td></tr>";
	            }
	            $option_text .= "</table>";
	            $form->addElement(new XoopsFormLabel(_PROFILE_AM_ADDOPTION, $option_text) );
	        } elseif ($field->getVar('field_type') == "validation" || $field->getVar('field_type') == "validation2" ) {
	        	
	        	$options = array();
	        	$validation_handler =& xoops_getmodulehandler('validation', 'profile');
				$criteria = new Criteria('`rule_id`','0', '<>');
				$criteria->setSort('`weight`');
				$validations = $validation_handler->getObjects($criteria, true);
				
				if (count($validations) > 0) 
					foreach($validations as $rule_id => $rule)
					   	$options[$rule_id] = $rule_id . ' - ' . $rule->getVar('type');
				   	
	            if (count($options) > 0) {
	                $field_options = new XoopsFormCheckBox(_PROFILE_AM_VALIDATION_RULES, 'field_validation_options[]', $field->getVar('field_options'));
	                $field_options->columns = 5;
	                asort($options);
	                $field_options->addOptionArray($options);
	                $form->addElement($field_options);
	            } else {
	            	$form->addElement(new XoopsFormLabel(_PROFILE_AM_VALIDATION_RULES, _PROFILE_AM_VALIDATION_NORULES));
	            }
	        	
	        }
	    }
		
	    if ($field->getVar('field_edit')) {
	        switch ($field->getVar('field_type')) {
	            case "textbox":
	            case "textarea":
	            case "dhtml":
	                $form->addElement(new XoopsFormText(_PROFILE_AM_MAXLENGTH, 'field_maxlength', 35, 35, $field->getVar('field_maxlength', 'e')));
	                $form->addElement(new XoopsFormTextArea(_PROFILE_AM_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
	                break;
	
	            case "checkbox":
	            case "select_multi":
	                $def_value = $field->getVar('field_default', 'e') != null ? unserialize($field->getVar('field_default', 'n')) : null;
	                $element = new XoopsFormSelect(_PROFILE_AM_DEFAULT, 'field_default', $def_value, 8, true);
	                $options = $field->getVar('field_options');
	                asort($options);
	                // If options do not include an empty element, then add a blank option to prevent any default selection
	                if (!in_array('', array_keys($options))) {
	                    $element->addOption('', _NONE);
	                }
	                $element->addOptionArray($options);
	                $form->addElement($element);
	                break;
	
	            case "select":
	            case "radio":
	                $def_value = $field->getVar('field_default', 'e') != null ? $field->getVar('field_default') : null;
	                $element = new XoopsFormSelect(_PROFILE_AM_DEFAULT, 'field_default', $def_value);
	                $options = $field->getVar('field_options');
	                asort($options);
	                // If options do not include an empty element, then add a blank option to prevent any default selection
	                if (!in_array('', array_keys($options))) {
	                    $element->addOption('', _NONE);
	                }
	                $element->addOptionArray($options);
	                $form->addElement($element);
	                break;
	
	            case "date":
	                $form->addElement(new XoopsFormTextDateSelect(_PROFILE_AM_DEFAULT, 'field_default', 15, $field->getVar('field_default', 'e')));
	                break;
	
	            case "longdate":
	                $form->addElement(new XoopsFormTextDateSelect(_PROFILE_AM_DEFAULT, 'field_default', 15, strtotime($field->getVar('field_default', 'e'))));
	                break;
	
	            case "datetime":
	                $form->addElement(new XoopsFormDateTime(_PROFILE_AM_DEFAULT, 'field_default', 15, $field->getVar('field_default', 'e')));
	                break;
	
	            case "yesno":
	                $form->addElement(new XoopsFormRadioYN(_PROFILE_AM_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
	                break;
	
	            case "timezone":
	                $form->addElement(new XoopsFormSelectTimezone(_PROFILE_AM_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
	                break;
	
	            case "language":
	                $form->addElement(new XoopsFormSelectLang(_PROFILE_AM_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
	                break;
	
	            case "group":
	                $form->addElement(new XoopsFormSelectGroup(_PROFILE_AM_DEFAULT, 'field_default', true, $field->getVar('field_default', 'e')));
	                break;
	
	            case "group_multi":
	                $form->addElement(new XoopsFormSelectGroup(_PROFILE_AM_DEFAULT, 'field_default', true, $field->getVar('field_default', 'e'), 5, true));
	                break;
	
	            case "theme":
	                $form->addElement(new XoopsFormSelectTheme(_PROFILE_AM_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
	                break;
	
	            case "autotext":
	                $form->addElement(new XoopsFormTextArea(_PROFILE_AM_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
	                break;
	        }
	    }
	
	    $groupperm_handler =& xoops_gethandler('groupperm');
	    $searchable_types = array(
	        'textbox',
	        'select',
	        'radio',
	        'yesno',
	        'date',
	        'datetime',
	        'timezone',
	        'language');
	    if (in_array($field->getVar('field_type'), $searchable_types)) {
	        $search_groups = $groupperm_handler->getGroupIds('profile_search', $field->getVar('field_id'), $GLOBALS['xoopsModule']->getVar('mid'));
	        $form->addElement(new XoopsFormSelectGroup(_PROFILE_AM_PROF_SEARCH, 'profile_search', true, $search_groups, 5, true) );
	    }
	    if ($field->getVar('field_edit') || $field->isNew()) {
	        if (!$field->isNew()) {
	            //Load groups
	            $editable_groups = $groupperm_handler->getGroupIds('profile_edit', $field->getVar('field_id'), $GLOBALS['xoopsModule']->getVar('mid'));
	        } else {
	            $editable_groups = array();
	        }
	        $form->addElement(new XoopsFormSelectGroup(_PROFILE_AM_PROF_EDITABLE, 'profile_edit', false, $editable_groups, 5, true));
	        $form->addElement(new XoopsFormRadioYN(_PROFILE_AM_REQUIRED, 'field_required', $field->getVar('field_required', 'e')));
	        $regstep_select = new XoopsFormSelect(_PROFILE_AM_PROF_REGISTER, 'step_id', $field->getVar('step_id', 'e'));
	        $regstep_select->addOption(0, _NO);
	        $regstep_handler = xoops_getmodulehandler('regstep');
	        $regstep_select->addOptionArray($regstep_handler->getList());
	        $form->addElement($regstep_select);
	    }
	    $form->addElement(new XoopsFormHidden('op', 'save') );
	    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
	
	    return $form;
	}
	
	/**
	* Get {@link XoopsThemeForm} for registering new users
	*
	* @param object $user {@link XoopsUser} to register
	* //@param int $step Which step we are at
	* @param profileRegstep $next_step
	*
	* @return object
	*/
	function profile_getRegisterForm(&$user, $profile, $step = null)
	{
	    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
	    if (empty($GLOBALS['xoopsConfigUser'])) {
	        $config_handler =& xoops_gethandler('config');
	        $GLOBALS['xoopsConfigUser'] = $config_handler->getConfigsByCat(XOOPS_CONF_USER);
	    }
	    $action = $_SERVER['REQUEST_URI'];
	    $step_no = $step['step_no'];
	    $use_token = $step['step_no'] > 0 ? true : false;
	    $reg_form = new XoopsThemeForm($step['step_name'], 'regform', $action, 'post', $use_token);
	
	    if ($step['step_desc']) {
	        $reg_form->addElement(new XoopsFormLabel('', $step['step_desc']));
	    }
	
	    if ($step_no == 1) {
	        //$uname_size = $GLOBALS['xoopsConfigUser']['maxuname'] < 35 ? $GLOBALS['xoopsConfigUser']['maxuname'] : 35;
	
	        $elements[0][] = array('element' => new XoopsFormText(_US_NICKNAME, 'uname', 35, $GLOBALS['xoopsConfigUser']['maxuname'], $user->getVar('uname', 'e')), 'required' => true);
	        $weights[0][] = 0;
	
	        $elements[0][] = array('element' => new XoopsFormText(_US_EMAIL, 'email', 35, 255, $user->getVar('email', 'e') ), 'required' => true);
	        $weights[0][] = 0;
	
	        $elements[0][] = array('element' => new XoopsFormPassword(_US_PASSWORD, 'pass', 35, 32, ''), 'required' => true);
	        $weights[0][] = 0;
	
	        $elements[0][] = array('element' => new XoopsFormPassword(_US_VERIFYPASS, 'vpass', 35, 32, ''), 'required' => true);
	        $weights[0][] = 0;
	    }
	
	    // Dynamic fields
	    $profile_handler =& xoops_getmodulehandler('profile');
	    $fields = $profile_handler->loadFields();
	
	    foreach (array_keys($fields) as $i) {
	        if ($fields[$i]->getVar('step_id') == $step['step_id']) {
	            $fieldinfo['element'] = $fields[$i]->getEditElement($user, $profile);
	            $fieldinfo['required'] = $fields[$i]->getVar('field_required');
	
	            $key = $fields[$i]->getVar('cat_id');
	            $elements[$key][] = $fieldinfo;
	            $weights[$key][] = $fields[$i]->getVar('field_weight');
	        }
	    }
	    ksort($elements);
	
	    // Get categories
	    $cat_handler =& xoops_getmodulehandler('category');
	    $categories = $cat_handler->getObjects(null, true, false);
	
	    foreach (array_keys($elements) as $k) {
	        array_multisort($weights[$k], SORT_ASC, array_keys($elements[$k]), SORT_ASC, $elements[$k]);
	        //$title = isset($categories[$k]) ? $categories[$k]['cat_title'] : _PROFILE_MA_DEFAULT;
	        //$desc = isset($categories[$k]) ? $categories[$k]['cat_description'] : "";
	        //$reg_form->insertBreak("<p>{$title}</p>{$desc}");
	        //$reg_form->addElement(new XoopsFormLabel("<h2>".$title."</h2>", $desc), false);
	        foreach (array_keys($elements[$k]) as $i) {
	            $reg_form->addElement($elements[$k][$i]['element'], $elements[$k][$i]['required']);
	        }
	    }
	    //end of Dynamic User fields
	
	    if ($step_no == 1 && $GLOBALS['xoopsConfigUser']['reg_dispdsclmr'] != 0 && $GLOBALS['xoopsConfigUser']['reg_disclaimer'] != '') {
	        $disc_tray = new XoopsFormElementTray(_US_DISCLAIMER, '<br />');
	        $disc_text = new XoopsFormLabel("", "<div style=\"padding: 5px;\">" . $GLOBALS["myts"]->displayTarea($GLOBALS['xoopsConfigUser']['reg_disclaimer'], 1) . "</div>");
	        $disc_tray->addElement($disc_text);
	        $agree_chk = new XoopsFormCheckBox('', 'agree_disc');
	        $agree_chk->addOption(1, _US_IAGREE);
	        $disc_tray->addElement($agree_chk);
	        $reg_form->addElement($disc_tray);
	    }
	
	    if ($step_no == 1) {
	    	include_once $GLOBALS['xoops']->path('/modules/profile/include/formrecaptcha.php');
	        $reg_form->addElement(new XoopsFormRecaptcha(_PROFILE_MA_PUZZEL, $GLOBALS['xoopsModuleConfig']['public_key']));
	    }
	
	    $reg_form->addElement(new XoopsFormHidden('uid', $user->getVar('uid')));
	    $reg_form->addElement(new XoopsFormHidden('step', $step_no) );
		if ($GLOBALS['ProfileHasValidation']==true) {
		   $submit = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		   $submit->setExtra(' disabled="disabled"');
		   $reg_form->addElement($submit);	 
		} else {
		   $reg_form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		}
	    return $reg_form;
	}
	


	/**
	* Get {@link XoopsThemeForm} for editing a user
	*
	* @param object $user {@link XoopsUser} to edit
	*
	* @return object
	*/
	function profile_getUserForm(&$user, $profile = null, $action = false)
	{
	    if ($action === false) {
	        $action = $_SERVER['REQUEST_URI'];
	    }
	    if (empty($GLOBALS['xoopsConfigUser'])) {
	        $config_handler =& xoops_gethandler('config');
	        $GLOBALS['xoopsConfigUser'] = $config_handler->getConfigsByCat(XOOPS_CONF_USER);
	    }
	
	    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
	
	    $title = $user->isNew() ? _PROFILE_AM_ADDUSER : _US_EDITPROFILE;
	
	    $form = new XoopsThemeForm($title, 'userinfo', $action, 'post', true);
	
	    $profile_handler =& xoops_getmodulehandler('profile');
	    // Dynamic fields
	    if (!$profile) {
	        $profile_handler =& xoops_getmodulehandler('profile', 'profile');
	        $profile = $profile_handler->get($user->getVar('uid') );
	    }
	    // Get fields
	    $fields = $profile_handler->loadFields();
	    // Get ids of fields that can be edited
	    $gperm_handler =& xoops_gethandler('groupperm');
	    $editable_fields = $gperm_handler->getItemIds('profile_edit', $GLOBALS['xoopsUser']->getGroups(), $GLOBALS['xoopsModule']->getVar('mid') );
	
	    if ($user->isNew() || $GLOBALS['xoopsUser']->isAdmin()) {
	        $elements[0][] = array('element' => new XoopsFormText(_US_NICKNAME, 'uname', 25, $GLOBALS['xoopsUser']->isAdmin() ? 60 : $GLOBALS['xoopsConfigUser']['maxuname'], $user->getVar('uname', 'e') ), 'required' => 1);
	        $email_text = new XoopsFormText('', 'email', 30, 60, $user->getVar('email'));
	    } else {
	        $elements[0][] = array('element' => new XoopsFormLabel(_US_NICKNAME, $user->getVar('uname') ), 'required' => 0);
	        $email_text = new XoopsFormLabel('', $user->getVar('email') );
	    }
	    $email_tray = new XoopsFormElementTray(_US_EMAIL, '<br />');
	    $email_tray->addElement($email_text, ($user->isNew() || $GLOBALS['xoopsUser']->isAdmin() ) ? 1 : 0);
	    $weights[0][] = 0;
	    $elements[0][] = array('element' => $email_tray, 'required' => 0);
	    $weights[0][] = 0;
	
	    if ($GLOBALS['xoopsUser']->isAdmin() && $user->getVar('uid') != $GLOBALS['xoopsUser']->getVar('uid')) {
	        //If the user is an admin and is editing someone else
	        $pwd_text = new XoopsFormPassword('', 'password', 10, 32);
	        $pwd_text2 = new XoopsFormPassword('', 'vpass', 10, 32);
	        $pwd_tray = new XoopsFormElementTray(_US_PASSWORD . '<br />' . _US_TYPEPASSTWICE);
	        $pwd_tray->addElement($pwd_text);
	        $pwd_tray->addElement($pwd_text2);
	        $elements[0][] = array('element' => $pwd_tray, 'required' => 0); //cannot set an element tray required
	        $weights[0][] = 0;
	
	        $level_radio = new XoopsFormRadio(_PROFILE_MA_USERLEVEL, 'level', $user->getVar('level'));
	        $level_radio->addOption(1, _PROFILE_MA_ACTIVE);
	        $level_radio->addOption(0, _PROFILE_MA_INACTIVE);
	        //$level_radio->addOption(-1, _PROFILE_MA_DISABLED);
	        $elements[0][] = array('element' => $level_radio, 'required' => 0);
	        $weights[0][] = 0;
	    }
	
	    $elements[0][] = array('element' => new XoopsFormHidden('uid', $user->getVar('uid') ), 'required' => 0);
	    $weights[0][] = 0;
	    $elements[0][] = array('element' => new XoopsFormHidden('op', 'save'), 'required' => 0);
	    $weights[0][] = 0;
	
	    $cat_handler = xoops_getmodulehandler('category');
	    $categories = array();
	    $all_categories = $cat_handler->getObjects(null, true, false);
	    $count_fields = count($fields);
	
	    foreach (array_keys($fields) as $i ) {
	        if ( in_array($fields[$i]->getVar('field_id'), $editable_fields)  ) {
	            // Set default value for user fields if available
	            if ($user->isNew()) {
	                $default = $fields[$i]->getVar('field_default');
	                if ($default !== '' && $default !== null) {
	                    $user->setVar($fields[$i]->getVar('field_name'), $default);
	                }
	            }
	
	            $fieldinfo['element'] = $fields[$i]->getEditElement($user, $profile);
	            $fieldinfo['required'] = $fields[$i]->getVar('field_required');
	
	            $key = $all_categories[$fields[$i]->getVar('cat_id')]['cat_weight'] * $count_fields + $fields[$i]->getVar('cat_id');
	            $elements[$key][] = $fieldinfo;
	            $weights[$key][] = $fields[$i]->getVar('field_weight');
	            $categories[$key] = $all_categories[$fields[$i]->getVar('cat_id')];
	        }
	    }
	
	    if ($GLOBALS['xoopsUser'] && $GLOBALS['xoopsUser']->isAdmin()) {
	        xoops_loadLanguage('admin', 'profile');
	        $gperm_handler =& xoops_gethandler('groupperm');
	        //If user has admin rights on groups
	        include_once $GLOBALS['xoops']->path('modules/system/constants.php');
	        if ($gperm_handler->checkRight('system_admin', XOOPS_SYSTEM_GROUP, $GLOBALS['xoopsUser']->getGroups(), 1)) {
	            //add group selection
	            $group_select = new XoopsFormSelectGroup(_US_GROUPS, 'groups', false, $user->getGroups(), 5, true);
	            $elements[0][] = array('element' => $group_select, 'required' => 0);
	            //set as latest;
	            $weights[0][] = $count_fields +1;
	        }
	    }
	
	    ksort($elements);
	    foreach (array_keys($elements) as $k) {
	        array_multisort($weights[$k], SORT_ASC, array_keys($elements[$k]), SORT_ASC, $elements[$k]);
	        $title = isset($categories[$k]) ? $categories[$k]['cat_title'] : _PROFILE_MA_DEFAULT;
	        $desc = isset($categories[$k]) ? $categories[$k]['cat_description'] : "";
	        $form->addElement(new XoopsFormLabel("<h3>{$title}</h3>", $desc), false);
	        foreach (array_keys($elements[$k]) as $i) {
	            $form->addElement($elements[$k][$i]['element'], $elements[$k][$i]['required']);
	        }
	    }
	
	    $form->addElement(new XoopsFormHidden('uid', $user->getVar('uid') ));
	    $form->addElement(new XoopsFormButton('', 'submit', _US_SAVECHANGES, 'submit'));
	    return $form;
	}

	/**
	* Get {@link XoopsThemeForm} for editing a step
	*
	* @param object $step {@link ProfileRegstep} to edit
	*
	* @return object
	*/
	function profile_getStepForm($step = null, $action = false)
	{
	    if ($action === false) {
	        $action = $_SERVER['REQUEST_URI'];
	    }
	    if (empty($GLOBALS['xoopsConfigUser'])) {
	        $config_handler =& xoops_gethandler('config');
	        $GLOBALS['xoopsConfigUser'] = $config_handler->getConfigsByCat(XOOPS_CONF_USER);
	    }
	    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
	
	    $form = new XoopsThemeForm(_PROFILE_AM_STEP, 'stepform', 'step.php', 'post', true);
	
	    if (!$step->isNew()) {
	        $form->addElement(new XoopsFormHidden('id', $step->getVar('step_id') ));
	    }
	    $form->addElement(new XoopsFormHidden('op', 'save') );
	    $form->addElement(new XoopsFormText(_PROFILE_AM_STEPNAME, 'step_name', 25, 255, $step->getVar('step_name', 'e')));
	    $form->addElement(new XoopsFormText(_PROFILE_AM_STEPINTRO, 'step_desc', 25, 255, $step->getVar('step_desc', 'e')));
	    $form->addElement(new XoopsFormText(_PROFILE_AM_STEPORDER, 'step_order', 10, 10, $step->getVar('step_order', 'e')));
	    $form->addElement(new XoopsFormRadioYN(_PROFILE_AM_STEPSAVE, 'step_save', $step->getVar('step_save', 'e')));
	    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
	
	    return $form;
	}

	function profile_directory_listorder()
	{
	
		xoops_load('XoopsFormLoader');
		
		$ret = '<h1>'._PROFILE_AM_DIRECTORYORDER.'</h1>';
		$ret .= '<form method="post" action="'.XOOPS_URL.'/modules/profile/admin/directory.php?op=save&fct=fields" enctype="multipart/form-data">';
		$ret .= '<table width="100%">';
		$ret .= '<tr class="head">';
		$ret .= '<td>'._PROFILE_AM_FIELD.'</td>';
		$ret .= '<td>'._PROFILE_AM_ORDER.'</td>';
		$ret .= '</tr>';
		
		if ($fields = profile_getfields()) {
			$class = 'odd';
			foreach($fields as $id => $field) {
				$class = ($class == 'odd')?'even':'odd';
				$ret .= '<tr class="'.$class.'">';
				$ret .= '<td>'.$field['field'].'</a></td>';
				$formobj_weight = new XoopsFormText('', 'weight['.$field['field'].']', 4, 4, $field['weight']);
				$ret .= '<td>'.$formobj_weight->render().'</td>';
				$ret .= '</tr>';
			}
		
		}
		
		$ret .= '<tr class="foot">';
		$ret .= '<td colspan="1"><input type="submit" value="'._SUBMIT.'"></form></td>';
		$ret .= '<td><form method="post" action="'.XOOPS_URL.'/modules/profile/admin/directory.php?op=reset&fct=fields" enctype="multipart/form-data"><input type="submit" value="'._RESET.'"></form></td>';
		$ret .= '</tr>';
		$ret .= '</table>';
		$ret .= '';
		
		return $ret;
	}
	
	function profile_directory_search()
	{
		xoops_load('XoopsFormLoader');
		
		$sform = new XoopsThemeForm(_PROFILE_AD_SEARCH, 'category', XOOPS_URL.'/modules/profile/directory.php?op=search', 'post');
			
		$sform->setExtra('enctype="multipart/form-data"');	
		
		$formobj = array();	
		$eletray = array();
		$sformobj = array();
		
		$sformobj['language']['text'] = new XoopsFormText('', 'term', 30, 128, $_POST['term']);
		$sformobj['language']['field'] = new XoopsFormSelect('', 'field', $_POST['field']);
		$sformobj['language']['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		foreach(profile_getfields() as $id => $field)
		{	
			if (defined('_PROFILE_LANG_'.strtoupper($field['field'])))
				$sformobj['language']['field']->addOption($field['field'],constant('_PROFILE_LANG_'.strtoupper($field['field'])));
			else
				$sformobj['language']['field']->addOption($field['field'],'_PROFILE_LANG_'.strtoupper($field['field']));
		}

		$formobj['language'] = new XoopsFormElementTray(_PROFILE_AD_SEARCH, '&nbsp;');
		$formobj['language']->addElement($sformobj['language']['text']);
		$formobj['language']->addElement($sformobj['language']['field']);
		$formobj['language']->addElement($sformobj['language']['submit']);
		$sform->addElement($formobj['language']);
		return $sform->render();
	}
?>