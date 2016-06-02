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
 * @since           2.5.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @version         $Id: dojsonvalidate.php 3988 2009-12-05 15:46:47Z wishcraft $
 */


include 'header.php';
$myts =& MyTextSanitizer::getInstance();
$op = isset($_REQUEST['op']) ? trim($_REQUEST['op']) : 'list';
$fct = isset($_REQUEST['fct']) ? trim($_REQUEST['fct']) : '';
$rule_id = isset($_REQUEST['rule_id']) ? intval($_REQUEST['rule_id']) : 0;

xoops_load('XoopsFormLoader');
switch($op){
	default:
	case 'list':
		xoops_cp_header();
		profile_adminMenu(basename(__FILE__), 6);
		$validation_handler =& xoops_getmodulehandler('validation', 'profile');
		$criteria = new Criteria('`weight`',1, '>=');
		$criteria->setSort('`weight`');
		$validations = $validation_handler->getObjects($criteria, true);
		$pass=false;
		$fail=false;
		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
			<table class="outer" cellspacing="1" width="100%">
				<tr><th colspan="5">'._AM_FORM_LISTINGRULES.'</th></tr>
				<tr>
					<td class="head" align="center">'._AM_RULE_ID.'</td>
					<td class="head" align="center">'._AM_RULE_TYPE.'</td>
					<td class="head" align="center">'._AM_RULE_WEIGHT.'</td>
					<td class="head" align="center">'._AM_RULE_ACTION.'</td>
					<td class="head" align="justify">'._AM_ACTION.'</td>
				</tr>';
		foreach($validations as $rule_id => $validation){		
			$class=($class!='even')?'even':'odd';
			echo '<tr>
					<td class="'.$class.'" align="center">'.$rule_id.'</td>
					<td class="'.$class.'" align="center">'.strtoupper($validation->getVar('type')).'</td>
					<td class="'.$class.'" align="center"><input name="weight['.$rule_id.']" value="'.$validation->getVar('weight').'" size="4" maxlength="4" type="text"><input name="ids['.$rule_id.']" value="'.$rule_id.'" type="hidden"></td>
					<td class="'.$class.'" align="center">'.$validation->getVar('action').'</td>
					<td class="'.$class.'" align="center"><a href="'.$_SERVER['PHP_SELF'].'?op=delete&rule_id='.$rule_id.'">'._DELETE.'</a>&nbsp;|&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?op=edit&rule_id='.$rule_id.'">'._EDIT.'</a></td>
				</tr>';
		}
		$submit = new XoopsFormButton('', 'submit', _AM_RESET_ORDER, 'submit');
		echo '
				<tr>
					<td class="foot"><a href="'.$_SERVER['PHP_SELF'].'?op=new">'._AM_RULE_NEW.'</a></td>
					<td class="foot" align="center">'.$submit->render().'</td>
					<td class="foot" colspan="3">&nbsp;</td>
				</tr>
				</table>';
		$hidden =& new XoopsFormHidden('op', 'saveorder');
		echo $hidden->render()."\n</form>\n";

		break;
	case 'new':
	case 'edit':


		$validation_handler =& xoops_getmodulehandler('validation', 'profile');

		xoops_cp_header();
		profile_adminMenu(basename(__FILE__), 6);

		//$xTheme->loadModuleAdminMenu(1);
		if( !empty($rule_id) ){
			$validate = $validation_handler->get($rule_id);
		}else{
			$validate = $validation_handler->create();
		}

		$text_form_weight = new XoopsFormText(_AM_FORM_WEIGHT, 'weight', 4, 4, $validate->getVar('weight'));
	
		$select_form_type = new XoopsFormSelect(_AM_FORM_TYPE, 'type', $validate->getVar('type'));
		$select_form_type->addOption('sql', 'Record Count SQL');
		$select_form_type->addOption('match', 'Match text');
		$select_form_type->addOption('regex', 'Regular Expression Test');		
		$select_form_type->setDescription(_AM_FORM_TYPE_DESC);
		
		$text_form_action = new XoopsFormTextArea(_AM_FORM_ACTION, 'action', $validate->getVar('action'), 20, 50);

		$hidden_rule_id = new XoopsFormHidden('rule_id', $rule_id);
		$hidden_op = new XoopsFormHidden('op', 'saveform');
		$submit = new XoopsFormButton('', 'submit', _AM_SAVE, 'submit');
		
		if( empty($rule_id) ){
			$caption = _AM_FORM_VALIDATION_NEW;
		}else{
			$caption = _AM_FORM_VALIDATION_EDIT;
		}
		
		$output = new XoopsThemeForm($caption, 'editform', $_SERVER['PHP_SELF']);
		$output->addElement($text_form_weight, true);
		$output->addElement($select_form_type);
		$output->addElement($text_form_action);
		$output->addElement($hidden_op);
		$output->addElement($hidden_rule_id);
		$output->addElement($submit);
		$output->display();
	break;

	case 'delete':
		if( empty($_POST['ok']) ){
			xoops_cp_header();
			profile_adminMenu(basename(__FILE__), 6);
			//$xTheme->loadModuleAdminMenu(0);
			xoops_confirm(array('op' => 'delete', 'rule_id' => $_GET['rule_id'], 'ok' => 1), $_SERVER['PHP_SELF'], sprintf(_PROFILE_AM_RUSUREDEL, _PROFILE_AM_VALIDATIONNAME));
		}else{
			$rule_id = intval($_POST['rule_id']);
			if( empty($rule_id) ){
				redirect_header($_SERVER['PHP_SELF'], 0, _AM_NOTHING_SELECTED);
			}
			$validation_handler =& xoops_getmodulehandler('validation', 'profile');
			$criteria = new Criteria('rule_id', $rule_id);
			$validation_handler->deleteAll($criteria);
			$validation_handler->deleteFormPermissions($rule_id);
			redirect_header($_SERVER['PHP_SELF'], 0, sprintf(_PROFILE_AM_SAVEDSUCCESS, _PROFILE_AM_VALIDATIONNAME));
		}
	break;

	case 'saveorder':
		$validation_handler =& xoops_getmodulehandler('validation', 'profile');
		if( !isset($_POST['ids']) || count($_POST['ids']) < 1 ){
			redirect_header($_SERVER['PHP_SELF'], 0, _AM_NOTHING_SELECTED);
		}
		extract($_POST);
		foreach( $ids as $id ){
			$validation =& $validation_handler->get($id);
			$validation->setVar('weight', $weight[$id]);
			$validation_handler->insert($validation, true);
		}
		redirect_header($_SERVER['PHP_SELF'], 0, sprintf(_PROFILE_AM_SAVEDSUCCESS, _PROFILE_AM_VALIDATIONNAME));
	break;

	case 'saveform':
		if( !isset($_POST['submit']) ){
			redirect_header($_SERVER['PHP_SELF'], 0, _AM_NOTHING_SELECTED);
		}
		$validation_handler =& xoops_getmodulehandler('validation', 'profile');
		$error = '';
		extract($_POST);
		if( !empty($rule_id) ){
			$form =& $validation_handler->get($rule_id);
		}else{
			$form =& $validation_handler->create();
		}
		$form->setVar('weight', $weight);
		$form->setVar('type', $type);
		$form->setVar('action', $action);
		if( !$ret = $validation_handler->insert($form) ){
			$error = $form->getHtmlErrors();
		}

		if( !empty($error) ){
			xoops_cp_header();
			//$xTheme->loadModuleAdminMenu(0);
			echo $error;
		}else{
			redirect_header($_SERVER['PHP_SELF'].'?op=edit&amp;rule_id='.$ret, 0, sprintf(_PROFILE_AM_SAVEDSUCCESS, _PROFILE_AM_VALIDATIONNAME));
		}
	break;
}
profile_footer_adminMenu();
xoops_cp_footer();
?>