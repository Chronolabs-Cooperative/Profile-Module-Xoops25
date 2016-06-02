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
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @author          Jan Pedersen
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: register.php 3988 2009-12-05 15:46:47Z trabis $
 */

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'header.php';

if ($GLOBALS['xoopsUser']) {
    header('location: '.XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/userinfo.php?uid= ' . $GLOBALS['xoopsUser']->getVar('uid'));
    exit();
}

if (!empty($_GET['op']) && in_array($_GET['op'], array('actv', 'activate'))) {
    header("location: ".XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . "/activate.php" . (empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING']));
    exit();
}

if (!empty($_GET['op']) && in_array($_GET['op'], array('deactv', 'deactivate'))) {
    header("location: ".XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . "/deactivate.php" . (empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING']));
    exit();
}

if ($GLOBALS['profileModuleConfig']['local']==true&&strlen($GLOBALS['profileModuleConfig']['ipdb_apikey'])>0) {
	if (!class_exists('ip2location_lite')) {
		include_once $GLOBALS['xoops']->path('modules/profile/include/ip2locationlite.class.php');
	}
	set_time_limit(120);
	$ipLite = new ip2location_lite;
	$ipLite->setKey($GLOBALS['profileModuleConfig']['ipdb_apikey']);
	//Get errors and locations
	$locations = $ipLite->getCity(profile_getIP());
	if (	!in_array(strtoupper($locations['countryCode']), $GLOBALS['profileModuleConfig']['countrycodes']) &&
			!in_array(ucfirst($locations['regionName']), explode('|',$GLOBALS['profileModuleConfig']['districts'])) && 
			!in_array(ucfirst($locations['cityName']), explode('|',$GLOBALS['profileModuleConfig']['citys']))) {
				
				$xoopsOption['template_main'] = 'profile_not_local.html';
				include $GLOBALS['xoops']->path('header.php');
				if (file_exists($GLOBALS['xoops']->path('modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))) {
					$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css', array('type'=>'text/css'));
				} else { 
					$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/english/style.css', array('type'=>'text/css'));
				}
				$GLOBALS['xoopsTpl']->assign('ip', profile_getIP());
				$GLOBALS['xoopsTpl']->assign('location', $locations);
				$GLOBALS['xoopsTpl']->assign('countrycodes', $GLOBALS['profileModuleConfig']['countrycodes']);
				$GLOBALS['xoopsTpl']->assign('districts', explode('|',$GLOBALS['profileModuleConfig']['districts']));
				$GLOBALS['xoopsTpl']->assign('citys', explode('|',$GLOBALS['profileModuleConfig']['citys']));
				include $GLOBALS['xoops']->path('footer.php');
				exit(0);			
				
			}
	    	
}

if ($GLOBALS['profileModuleConfig']['speedtest']==true) {
	$speedtest_handler = xoops_getmodulehandler('speedtest', 'speedtest');
	$criteria = new Criteria('`ip_string`', profile_getIP());
	if ($speedtest_handler->getCount($criteria)==0) {
		$_SESSION['profileDoSpeedtest'] = true;
		header("location: ".XOOPS_URL . '/modules/speedtest/download.php');
    	exit();	
	}
	$criteria->setSort('`downspeed`, `upspeed`');
	$criteria->setOrder('DESC');
	$criteria->setLimit(1);
	$speedtests = $speedtest_handler->getObjects($criteria, false);
	$downlink_passes = false;
	if (in_array('DOWNLINK', $GLOBALS['profileModuleConfig']['speedtest_test'])&&(($speedtests[0]->getVar('downspeed')/1024)>=$GLOBALS['profileModuleConfig']['speedtest_downlink'])) {
		$downlink_passes = true;
		$downlink_diff = (($speedtests[0]->getVar('downspeed')/1024)-$GLOBALS['profileModuleConfig']['speedtest_downlink']);
	} elseif (!in_array('DOWNLINK', $GLOBALS['profileModuleConfig']['speedtest_test'])) {
		$downlink_passes = true;
		$downlink_diff = 0;
	} elseif (in_array('DOWNLINK', $GLOBALS['profileModuleConfig']['speedtest_test'])&&(($speedtests[0]->getVar('downspeed')/1024)<$GLOBALS['profileModuleConfig']['speedtest_downlink'])) {
		$downlink_passes = false;
		$downlink_diff = ($GLOBALS['profileModuleConfig']['speedtest_downlink']-($speedtests[0]->getVar('downspeed')/1024));
	}
	$uplink_passes = false;
	if (in_array('UPLINK', $GLOBALS['profileModuleConfig']['speedtest_test'])&&(($speedtests[0]->getVar('upspeed')/1024)>=$GLOBALS['profileModuleConfig']['speedtest_uplink'])) {
		$uplink_passes = true;
		$uplink_diff = (($speedtests[0]->getVar('upspeed')/1024)-$GLOBALS['profileModuleConfig']['speedtest_uplink']);
	} elseif (!in_array('UPLINK', $GLOBALS['profileModuleConfig']['speedtest_test'])) {
		$uplink_passes = true;
		$uplink_diff = 0;
	} elseif (in_array('UPLINK', $GLOBALS['profileModuleConfig']['speedtest_test'])&&(($speedtests[0]->getVar('upspeed')/1024)<$GLOBALS['profileModuleConfig']['speedtest_uplink'])) {
		$uplink_passes = false;
		$uplink_diff = ($GLOBALS['profileModuleConfig']['speedtest_uplink']-($speedtests[0]->getVar('upspeed')/1024));
	}
	if ($uplink_passes!=true||$downlink_passes!=true) {
		$xoopsOption['template_main'] = 'profile_not_passed_speedtest.html';
		include $GLOBALS['xoops']->path('header.php');
		if (file_exists($GLOBALS['xoops']->path('modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))) {
			$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css', array('type'=>'text/css'));
		} else { 
			$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/english/style.css', array('type'=>'text/css'));
		}
		$GLOBALS['xoopsTpl']->assign('downlink_passes', $downlink_passes);
		$GLOBALS['xoopsTpl']->assign('uplink_passes', $uplink_passes);
		$GLOBALS['xoopsTpl']->assign('downlink_diff', number_format($downlink_diff,2));
		$GLOBALS['xoopsTpl']->assign('uplink_diff', number_format($uplink_diff,2));
		$GLOBALS['xoopsTpl']->assign('downlink_tested', number_format($speedtests[0]->getVar('downspeed')/1024, 2));
		$GLOBALS['xoopsTpl']->assign('uplink_tested', number_format($speedtests[0]->getVar('upspeed')/1024, 2));
		$GLOBALS['xoopsTpl']->assign('downlink_required', number_format($GLOBALS['profileModuleConfig']['speedtest_downlink'], 2));
		$GLOBALS['xoopsTpl']->assign('uplink_required', number_format($GLOBALS['profileModuleConfig']['speedtest_uplink'], 2));
		include $GLOBALS['xoops']->path('footer.php');
		exit(0);			
	}
	
}

xoops_load('XoopsUserUtility');
$myts =& MyTextSanitizer::getInstance();

$config_handler =& xoops_gethandler('config');
$GLOBALS['xoopsConfigUser'] = $config_handler->getConfigsByCat(XOOPS_CONF_USER);
if (empty($GLOBALS['xoopsConfigUser']['allow_register'])) {
    redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/index.php', 6, _US_NOREGISTER);
    exit();
}

$op = !isset($_REQUEST['op']) ? 'register' : $_REQUEST['op'];
$uid = isset($_POST['uid']) ? intval( $_POST['uid'] ) : 0;
$current_step = isset($_POST['step']) ? intval( $_POST['step'] ) : 0;

if ($op=='deactv') {
	$id = intval($_GET['id']);
	$actkey = trim($_GET['actkey']);
	if (empty($id)) {
		redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/index.php', 1, '');
		exit();
	}
	$member_handler =& xoops_gethandler('member');
	$thisuser =& $member_handler->getUser($id);
	if (!is_object($thisuser)) {
		exit();
	}
	if ($thisuser->getVar('actkey') != $actkey) {
		redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/index.php', 5, _US_ACTKEYNOT);
	} else {
		if ($thisuser->getVar('level') == 0) {
			redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/user.php', 5, _US_ACONTACT, false);
		} else {
			$thisuser->setVar('level', 0);
			if (!$member_handler->insertUser($thisuser, true)) {
				redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/index.php', 5, _US_DEACTFAILD);
			}
		}
	}
	redirect_header(XOOPS_URL.'/index.php', 1, 'Deactivated User');
	exit(0);
}

if ($GLOBALS['profileModuleConfig']['htaccess']&&empty($_POST)) {
	$url = XOOPS_URL.'/'.$GLOBALS['profileModuleConfig']['baseurl'].'/register,'.$op.','.$uid.','.$current_step.$GLOBALS['profileModuleConfig']['endofurl'];
	if (strpos($url, $_SERVER['REQUEST_URI'])==0) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.$url);
		exit(0);
	}
}
// First step is already secured by with the captcha Token so lets check the others
if ($current_step > 0 && !$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/user.php', 5, _PROFILE_MA_EXPIRED);
    exit();
}

$criteria = new CriteriaCompo();
$criteria->setSort("step_order");
$regstep_handler = xoops_getmodulehandler('regstep');

if (!$steps = $regstep_handler->getAll($criteria, null, false, false)) {
    redirect_header(XOOPS_URL . '/', 6, _PROFILE_MA_NOSTEPSAVAILABLE);
    exit();
}

foreach (array_keys($steps) as $key) {
    $steps[$key]['step_no'] = $key + 1;
}

$xoopsOption['template_main'] = 'profile_register.html';
include $GLOBALS['xoops']->path('header.php');
if (file_exists($GLOBALS['xoops']->path('modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))) {
	$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css', array('type'=>'text/css'));
} else { 
	$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/english/style.css', array('type'=>'text/css'));
}
$GLOBALS['xoopsTpl']->assign('steps', $steps);
$GLOBALS['xoopsTpl']->assign('lang_register_steps', _PROFILE_MA_REGISTER_STEPS);

$xoBreadcrumbs[] = array('link' => XOOPS_URL . "/modules/" . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/register.php', 'title' => _PROFILE_MA_REGISTER);
if (isset($steps[$current_step])) {
    $xoBreadcrumbs[] = array('title' => $steps[$current_step]['step_name']);
}

$member_handler =& xoops_gethandler('member');
$profile_handler = xoops_getmodulehandler('profile');

$fields = $profile_handler->loadFields();
$userfields = $profile_handler->getUserVars();

if ($uid == 0) {
    // No user yet? Create one and set default values.
    $newuser = $member_handler->createUser();
    $profile = $profile_handler->create();
    if (count($fields) > 0) {
        foreach (array_keys($fields) as $i) {
            $fieldname = $fields[$i]->getVar('field_name');
            if (in_array($fieldname, $userfields)) {
                $default = $fields[$i]->getVar('field_default');
                if ($default === '' || $default === null) {
                    continue;
                }
                $newuser->setVar($fieldname, $default);
            }
        }
    }
} else {
    // We already have a user? Just load it! Security is handled by token so there is no fake uid here.
    $newuser = $member_handler->getUser($uid);
    $profile = $profile_handler->get($uid);
}

// Lets merge current $_POST  with $_SESSION['profile_post'] so we can have access to info submited in previous steps
// Get all fields that we can expect from a $_POST inlcuding our private '_message_'
$fieldnames = array();
foreach (array_keys($fields) as $i ) {
    $fieldnames[] = $fields[$i]->getVar('field_name');
    $fieldtype[$fields[$i]->getVar('field_name')] = $fields[$i]->getVar('field_type');
    $fieldoptions[$fields[$i]->getVar('field_name')] = $fields[$i]->getVar('field_options');
}
$fieldnames = array_merge($fieldnames, $userfields);
$fieldnames[] = '_message_';

// Get $_POST that matches above criteria, we do not need to store step, tokens, etc
$postfields = array();
foreach ($fieldnames as $fieldname ) {
    if (isset($_POST[$fieldname])) {
        $postfields[$fieldname] = $_POST[$fieldname];
    }
}

if ($current_step == 0) {
    // Reset any previous session for first step
    $_SESSION['profile_post'] = array();
} else {
    // Merge current $_POST  with $_SESSION['profile_post']
    $_SESSION['profile_post'] = array_merge($_SESSION['profile_post'], $postfields);
    $_POST = array_merge($_SESSION['profile_post'], $_POST);
}

// Set vars from $_POST/$_SESSION['profile_post']
foreach (array_keys($fields) as $field) {
    if (!isset($_POST[$field])) {
        continue;
    }

    $value = $fields[$field]->getValueForSave($_POST[$field]);
    
    switch($fieldtype[$field]){
    	case 'ip':
    	case 'proxy-ip':
    	case 'network-addy':
    		if ($GLOBALS['profileModuleConfig']['check_'.str_replace('-', '_', $fieldtype[$field])]==true) {
    			$field_handler = xoops_getmodulehandler('field');
    			$criteria = new Criteria('field_type', $fieldtype[$field]);
    			$ips = $field_handler->getObjects($criteria);
    			$sql = "SELECT COUNT(*) FROM ". $GLOBALS['xoopsDB']->prefix('profile_profile').' WHERE ';
    			foreach($ips as $ip) {
    				if ($next = true)
    					$sql .= " OR ";
    				$sql .= "`".$ip->getVar('field_name')."` LIKE '".$_POST[$field]."'";
    				$next = true;
    			}
    			
    			list($count) = $GLOBALS['xoopsDB']->fetchRow($GLOBALS['xoopsDB']->queryF($sql));
    			if ($count>0)
    				$stop=sprintf(_PROFILE_MA_NETFOUND, $_POST[$field]);
    		}
    		break;
    	case 'validation2':
			$validation_handler =& xoops_getmodulehandler('validation', 'profile');
			$criteria = new Criteria('`rule_id`','('.implode(',', $fieldoptions[$field]).')', 'IN');
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
					$sql = str_replace('[value]', $_POST[$field], $sql);
					$i=strpos($sql, '[');
					while($i != 0) {
						$elements[] = substr($sql, $i+1, strpos($sql, ']', $i+1)-$i-1);	
						$i = strpos($sql, '[', $i+1);
					}
					foreach($elements as $id => $element) {
						if (strpos($element , '|')) {
							$fields = explode('|', $element);
							foreach($fields as $fid => $field) {
								if (isset($_POST[$field])) {
									$sql = str_replace('['.$element.']', $_POST[$field], $sql);
								}
							}
						} elseif (strlen($element)>0) {
							if (isset($_POST[$element])) {
								$sql = str_replace('['.$element.']', $_POST[$element], $sql);
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
			if ($pass==false) {
				$stop=_PROFILE_MA_VALIDATIONFAILED;
				include_once dirname(__FILE__) . '/include/forms.php';
			    $current_step = empty($stop) ? $current_step : $current_step - 1;
			    $reg_form = profile_getRegisterForm($newuser, $profile, $steps[$current_step]);
			    $reg_form->assign($GLOBALS['xoopsTpl']);
			    $GLOBALS['xoopsTpl']->assign('current_step', $current_step);
			    $GLOBALS['xoopsTpl']->assign('stop', $stop);
				include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'footer.php';
				exit(0);				
			}
    		break;
    }
    
    if (in_array($field, $userfields)) {
        $newuser->setVar($field, $value);
    } else {
        $profile->setVar($field, $value);
    }
}

$stop = '';

// Check user data at first step
if ($current_step == 1) {
    $uname = isset($_POST['uname']) ? $myts->stripSlashesGPC(trim($_POST['uname']) ) : '';
    $email = isset($_POST['email']) ? $myts->stripSlashesGPC(trim($_POST['email']) ) : '';
    $url = isset($_POST['url']) ? $myts->stripSlashesGPC(trim($_POST['url']) ) : '';
    $pass = isset($_POST['pass']) ? $myts->stripSlashesGPC(trim($_POST['pass']) ) : '';
    $vpass = isset($_POST['vpass']) ? $myts->stripSlashesGPC(trim($_POST['vpass']) ) : '';
    $agree_disc = (isset($_POST['agree_disc']) && intval($_POST['agree_disc']) ) ? 1 : 0;

    if ($GLOBALS['xoopsConfigUser']['reg_dispdsclmr'] != 0 && $GLOBALS['xoopsConfigUser']['reg_disclaimer'] != '') {
        if (empty($agree_disc)) {
            $stop .= _US_UNEEDAGREE . '<br />';
        }
    }

    $newuser->setVar('uname', $uname);
    $newuser->setVar('email', $email);
    $newuser->setVar('pass', $pass ? md5($pass) : '');
    $stop .= XoopsUserUtility::validate($newuser, $pass, $vpass);

	require_once( $GLOBALS['xoops']->path('/modules/profile/include/recaptchalib.php') );
	$resp = recaptcha_check_answer ($GLOBALS['profileModuleConfig']['private_key'], $_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
	if (!$resp->is_valid) {
		$stop .= _PROFILE_MN_NOSOLVEPUZZEL;
	}
}

// If the last step required SAVE or if we're on the last step then we will insert/update user on database
if ($current_step > 0 && empty($stop) && (!empty($steps[$current_step - 1]['step_save']) || !isset($steps[$current_step]))) {

    $isNew = $newuser->isNew();

    //Did created an user already? If not then let us set some extra info
    if ($isNew) {
        $uname = isset($_POST['uname']) ? $myts->stripSlashesGPC(trim($_POST['uname'])) : '';
        $email = isset($_POST['email']) ? $myts->stripSlashesGPC(trim($_POST['email'])) : '';
        $url = isset($_POST['url']) ? $myts->stripSlashesGPC(trim($_POST['url'])) : '';
        $pass = isset($_POST['pass']) ? $myts->stripSlashesGPC(trim($_POST['pass'])) : '';
        $newuser->setVar('uname', $uname);
        $newuser->setVar('email', $email);
        $newuser->setVar('pass', $pass ? md5($pass) : '');
        $actkey = substr(md5(uniqid(mt_rand(), 1) ), 0, 8);
        $newuser->setVar('actkey', $actkey, true);
        $newuser->setVar('user_regdate', time(), true);
        if ($GLOBALS['xoopsConfigUser']['activation_type'] == 1) {
            $newuser->setVar('level', 1, true);
        } else {
            $newuser->setVar('level', 0, true);
        }
    }

    // Insert/update user and check if we have succeded
    if (!$member_handler->insertUser($newuser)) {
        $stop .= _US_REGISTERNG . "<br />";
        $stop .= implode('<br />', $newuser->getErrors() );
    } else {
        // User inserted! Now insert custom profile fields
        $profile->setVar('profile_id', $newuser->getVar('uid') );
        $profile_handler->insert($profile);

        // We are good! If this is 'was' a new user then we handle notification
        if ($isNew) {
            if ($GLOBALS['xoopsConfigUser']['new_user_notify'] == 1 && !empty($GLOBALS['xoopsConfigUser']['new_user_notify_group'])) {
                $xoopsMailer =& xoops_getMailer();
                $xoopsMailer->reset();
                $xoopsMailer->useMail();
                $xoopsMailer->setToGroups($member_handler->getGroup($GLOBALS['xoopsConfigUser']['new_user_notify_group']));
                $xoopsMailer->setFromEmail($GLOBALS['xoopsConfig']['adminmail']);
                $xoopsMailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
                $xoopsMailer->setSubject(sprintf(_US_NEWUSERREGAT,$GLOBALS['xoopsConfig']['sitename']));
                $xoopsMailer->setBody(sprintf(_US_HASJUSTREG, $newuser->getVar('uname')));
                $xoopsMailer->send(true);
            }

            $message = "";
            if (!$member_handler->addUserToGroup(XOOPS_GROUP_USERS, $newuser->getVar('uid'))) {
                $message = _PROFILE_MA_REGISTER_NOTGROUP . "<br />";
            } else if ($GLOBALS['xoopsConfigUser']['activation_type'] == 1) {
                XoopsUserUtility::sendWelcome($newuser);
            } else if ($GLOBALS['xoopsConfigUser']['activation_type'] == 0) {
                $xoopsMailer =& xoops_getMailer();
                $xoopsMailer->reset();
                $xoopsMailer->useMail();
                $xoopsMailer->setTemplate('register.tpl');
                $xoopsMailer->assign('SITENAME', $GLOBALS['xoopsConfig']['sitename']);
                $xoopsMailer->assign('ADMINMAIL', $GLOBALS['xoopsConfig']['adminmail']);
                $xoopsMailer->assign('SITEURL', XOOPS_URL."/");
                $xoopsMailer->assign('X_UPASS', $_POST['vpass']);
                $xoopsMailer->setToUsers($newuser);
                $xoopsMailer->setFromEmail($GLOBALS['xoopsConfig']['adminmail']);
                $xoopsMailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
                $xoopsMailer->setSubject(sprintf(_US_USERKEYFOR, $newuser->getVar('uname')));
                if (!$xoopsMailer->send(true)) {
                    $_SESSION['profile_post']['_message_'] = 0;
                } else {
                    $_SESSION['profile_post']['_message_'] = 1;
                }
            } else if ($GLOBALS['xoopsConfigUser']['activation_type'] == 2) {
                $xoopsMailer =& xoops_getMailer();
                $xoopsMailer->reset();
                $xoopsMailer->useMail();
                $xoopsMailer->setTemplate('adminactivate.tpl');
                $xoopsMailer->assign('USERNAME', $newuser->getVar('uname'));
                $xoopsMailer->assign('USEREMAIL', $newuser->getVar('email'));
                $xoopsMailer->assign('USERACTLINK', XOOPS_URL . "/modules/" . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/activate.php?id=' . $newuser->getVar('uid') . '&actkey=' . $newuser->getVar('actkey', 'n'));
                $xoopsMailer->assign('SITENAME', $GLOBALS['xoopsConfig']['sitename']);
                $xoopsMailer->assign('ADMINMAIL', $GLOBALS['xoopsConfig']['adminmail']);
                $xoopsMailer->assign('SITEURL', XOOPS_URL . "/");
                $xoopsMailer->setToGroups($member_handler->getGroup($GLOBALS['xoopsConfigUser']['activation_group']));
                $xoopsMailer->setFromEmail($GLOBALS['xoopsConfig']['adminmail']);
                $xoopsMailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
                $xoopsMailer->setSubject(sprintf(_US_USERKEYFOR, $newuser->getVar('uname')));
                if (!$xoopsMailer->send()) {
                    $_SESSION['profile_post']['_message_'] = 2;
                } else {
                    $_SESSION['profile_post']['_message_'] = 3;
                }
            }
            if ($message) {
                $GLOBALS['xoopsTpl']->append('confirm',  $message);
            }
        }
    }
}

if (!empty($stop) || isset($steps[$current_step])) {
    include_once dirname(__FILE__) . '/include/forms.php';
    $current_step = empty($stop) ? $current_step : $current_step - 1;
    $reg_form = profile_getRegisterForm($newuser, $profile, $steps[$current_step]);
    $reg_form->assign($GLOBALS['xoopsTpl']);
    $GLOBALS['xoopsTpl']->assign('current_step', $current_step);
    $GLOBALS['xoopsTpl']->assign('stop', $stop);
} else {
    // No errors and no more steps, finish
    $GLOBALS['xoopsTpl']->assign('finish', _PROFILE_MA_REGISTER_FINISH);
    $GLOBALS['xoopsTpl']->assign('current_step', -1);
    if ( $GLOBALS['xoopsConfigUser']['activation_type'] == 1 && !empty($_SESSION['profile_post']['pass'])) {
        $GLOBALS['xoopsTpl']->assign('finish_login', _PROFILE_MA_FINISH_LOGIN);
        $GLOBALS['xoopsTpl']->assign('finish_uname', $newuser->getVar('uname'));
        $GLOBALS['xoopsTpl']->assign('finish_pass', htmlspecialchars($_SESSION['profile_post']['pass']));
    }
    if (isset($_SESSION['profile_post']['_message_'])) {
        //todo, if user is activated by admin, then we should inform it along with error messages.  _US_YOURREGMAILNG is not enough
        $messages = array(_US_YOURREGMAILNG, _US_YOURREGISTERED, _US_YOURREGMAILNG, _US_YOURREGISTERED2);
        $GLOBALS['xoopsTpl']->assign('finish_message', $messages[$_SESSION['profile_post']['_message_']]);
    }
    $_SESSION['profile_post'] = null;
}

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'footer.php';

?>