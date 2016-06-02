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

function profile_checkpasskey($key) {

	$minseed = strtotime(date('Y-m-d h:i'));
	$diff = intval((120/2)*60);
	for($step=($minseed-$diff);$step<($minseed+$diff);$step++)
		if ($key==md5(XOOPS_LICENSE_KEY.date('Ymdhi', $step)))
			return true;
	return false;

}

header('Content-type: application/json');

include ('header.php');

$GLOBALS['xoopsLogger']->activated = false;

xoops_load('XoopsUserUtility');
$myts =& MyTextSanitizer::getInstance();

foreach($_GET as $id => $val)
	${$id} = $val;

if (!function_exists('json_encode')) {
	if (!class_exists('services_JSON'))
		include $GLOBALS['xoops']->path('/modules/profile/include/JSON.php');
	$json = new services_JSON();
}

set_time_limit(120);

if (!profile_checkpasskey($passkey)) { 
	$values['innerhtml']['passnotice'] = _PROFILE_VALIDATE_PASSKEYFAILED;
	$values['disable']['submit'] = 'true';
	if (!function_exists('json_encode')) {	
		print $json->encode($values);
	} else {
		print json_encode($values);
	}
	exit(0);
}


$field_handler =& xoops_getmodulehandler('field', 'profile');
$field = $field_handler->get($field_id);
$validation_handler =& xoops_getmodulehandler('validation', 'profile');
$criteria = new Criteria('`rule_id`','('.implode(',', $field->getVar('field_options')).')', 'IN');
$criteria->setSort('`weight`');
$validations = $validation_handler->getObjects($criteria, '*', true);
$pass=false;
$fail=false;
foreach($validations as $rule_id => $validation){
	if ($pass==false)
	switch($validation->getVar('type')) {
	case 'regex':
		if (!preg_match($validation->getVar('action'), $value)) {
			$fail=true;
		} else {
			$pass=true;
		}
	break;
	case 'match':
		if ($validation->getVar('action')!=$value) {
			$fail=true;
		} else {
			$pass=true;
		}
	break;
	case 'sql':
		$sql = $myts->undoHtmlSpecialChars(strval($validation->getVar('action')));
		
		$sql = str_replace('[value]', $value, $sql);
		
		$i=strpos($sql, '[');
		while($i != 0) {
			$elements[] = substr($sql, $i+1, strpos($sql, ']', $i+1)-$i-1);	
			$i = strpos($sql, '[', $i+1);
		}
		foreach($elements as $id => $element) {
			if (strpos($element , '|')) {
				$fields = explode('|', $element);
				foreach($fields as $fid => $field) {
					if (isset($_GET[$field])) {
						$sql = str_replace('['.$element.']', $_GET[$field], $sql);
					}
				}
			} elseif (strlen($element)>0) {
				if (isset($_GET[$element])) {
					$sql = str_replace('['.$element.']', $_GET[$element], $sql);
				}		
			}
		}
			
		if ($result=$GLOBALS['xoopsDB']->queryF($sql)) {
				
			list($count) = $GLOBALS['xoopsDB']->fetchRow($result);
			
			if ($count!=0) {
				$pass=true;
			} else {
				$fail=true;			
			}
		}
	break;		
	}
}

if ($pass!=false){
	$values['innerhtml']['passnotice'] = _PROFILE_VALIDATE_PASS;
	$values['disable']['submit'] = 'false';	
} else {	
	$values['innerhtml']['passnotice'] = _PROFILE_VALIDATE_FAIL;
	$values['disable']['submit'] = 'true';	
}

if (!function_exists('json_encode')) {
	print $json->encode($values);
} else {
	print json_encode($values);
}
?>