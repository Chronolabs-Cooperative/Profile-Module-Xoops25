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
 * @version         $Id: user.php 3749 2009-10-17 14:23:04Z trabis $
 */

$xoopsOption['pagetype'] = 'user';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'header.php';

$op = 'main';

if (isset($_POST['op'])) {
    $op = trim($_POST['op']);
} else if (isset($_GET['op'])) {
    $op = trim($_GET['op']);
}

if ($op == 'login') {
    include_once $GLOBALS['xoops']->path('include/checklogin.php');
    exit();
}

if ($GLOBALS['profileModuleConfig']['htaccess']&&empty($_POST)) {
	$url = XOOPS_URL.'/'.$GLOBALS['profileModuleConfig']['baseurl'].'/control,'.urlencode($op).$GLOBALS['profileModuleConfig']['endofurl'];
	if (strpos($url, $_SERVER['REQUEST_URI'])==0) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.$url);
		exit(0);
	}
}

if ( $op == 'main' ) {
    if (!$GLOBALS['xoopsUser']) {
        $xoopsOption['template_main'] = 'profile_userform.html';
        include $GLOBALS['xoops']->path('header.php');
        if (file_exists($GLOBALS['xoops']->path('modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))) {
			$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css', array('type'=>'text/css'));
		} else { 
			$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/english/style.css', array('type'=>'text/css'));
		}
        $GLOBALS['xoopsTpl']->assign('lang_login', _LOGIN);
        $GLOBALS['xoopsTpl']->assign('lang_username', _USERNAME);
        if (isset($_GET['xoops_redirect'])) {
            $GLOBALS['xoopsTpl']->assign('redirect_page', htmlspecialchars(trim($_GET['xoops_redirect']), ENT_QUOTES));
        }
        if ($GLOBALS['xoopsConfig']['usercookie']) {
            $GLOBALS['xoopsTpl']->assign('lang_rememberme', _US_REMEMBERME);
        }
        $GLOBALS['xoopsTpl']->assign('lang_password', _PASSWORD);
        $GLOBALS['xoopsTpl']->assign('lang_notregister', _US_NOTREGISTERED);
        $GLOBALS['xoopsTpl']->assign('lang_lostpassword', _US_LOSTPASSWORD);
        $GLOBALS['xoopsTpl']->assign('lang_noproblem', _US_NOPROBLEM);
        $GLOBALS['xoopsTpl']->assign('lang_youremail', _US_YOUREMAIL);
        $GLOBALS['xoopsTpl']->assign('lang_sendpassword', _US_SENDPASSWORD);
        $GLOBALS['xoopsTpl']->assign('mailpasswd_token', $GLOBALS['xoopsSecurity']->createToken());
        
   		include_once($GLOBALS['xoops']->path('/modules/profile/include/functions.php'));
		$social = profile_social_supported();
		$_SESSION['oauth']['twitter']['authorized'] = (isset($_SESSION['oauth']['twitter']['authorized'])) ? $_SESSION['oauth']['twitter']['authorized'] : FALSE;
		if ($_SESSION['oauth']['twitter']['authorized']===true)	
			$social['twitter']=false;
		$_SESSION['oauth']['facebook']['authorized'] = (isset($_SESSION['oauth']['facebook']['authorized'])) ? $_SESSION['oauth']['facebook']['authorized'] : FALSE;
		if ($_SESSION['oauth']['facebook']['authorized']===true)	
			$social['facebook']=false;
		$_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
		if ($_SESSION['oauth']['linkedin']['authorized']===true)	
			$social['linkedin']=false;
		$GLOBALS['xoopsTpl']->assign('social', array_merge($social, array('display' => ($social['linkedin']===true||$social['facebook']===true||$social['twitter']===true?true:false))));
		
        include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'footer.php';
        exit();
    }
    if (!empty($_GET['xoops_redirect'])) {
        $redirect = trim($_GET['xoops_redirect']);
        $isExternal = false;
        if ($pos = strpos($redirect, '://')) {
            $xoopsLocation = substr( XOOPS_URL, strpos( XOOPS_URL, '://' ) + 3);
            if (strcasecmp(substr($redirect, $pos + 3, strlen($xoopsLocation)), $xoopsLocation)) {
                $isExternal = true;
            }
        }
        if (!$isExternal) {
            header('Location: ' . $redirect);
            exit();
        }
    }
    header('Location: '.XOOPS_URL.'/modules/profile/userinfo.php?uid=' . $GLOBALS['xoopsUser']->getVar('uid'));
    exit();
}

if ($op == 'logout') {
    $message = '';
    $_SESSION = array();
    session_destroy();
    setcookie($GLOBALS['xoopsConfig']['usercookie'], 0, -1, '/', XOOPS_COOKIE_DOMAIN, 0);
    setcookie($GLOBALS['xoopsConfig']['usercookie'], 0, - 1, '/');
    // clear entry from online users table
    if (is_object($GLOBALS['xoopsUser'])) {
        $online_handler =& xoops_gethandler('online');
        $online_handler->destroy($GLOBALS['xoopsUser']->getVar('uid'));
    }
    $message = _US_LOGGEDOUT . '<br />' . _US_THANKYOUFORVISIT;
    redirect_header(XOOPS_URL . '/', 1, $message);
    exit();
}

if ($op == 'actv') {
    $id = intval($_GET['id']);
    $actkey = trim($_GET['actkey']);
    redirect_header(XOOPS_URL."/modules/profile/activate.php?op=actv&amp;id={$id}&amp;actkey={$actkey}", 1, '');
    exit();
}

if ($op == 'delete') {
    $config_handler =& xoops_gethandler('config');
    $GLOBALS['xoopsConfigUser'] = $config_handler->getConfigsByCat(XOOPS_CONF_USER);
    if (!$GLOBALS['xoopsUser'] || $GLOBALS['xoopsConfigUser']['self_delete'] != 1) {
        redirect_header(XOOPS_URL . '/', 5, _US_NOPERMISS);
        exit();
    } else {
        $groups = $GLOBALS['xoopsUser']->getGroups();
        if (in_array(XOOPS_GROUP_ADMIN, $groups)){
            // users in the webmasters group may not be deleted
            redirect_header(XOOPS_URL . '/', 5, _US_ADMINNO);
            exit();
        }
        $ok = !isset($_POST['ok']) ? 0 : intval($_POST['ok']);
        if ($ok != 1) {
            include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'header.php';
            if (file_exists($GLOBALS['xoops']->path('modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))) {
				$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css', array('type'=>'text/css'));
			} else { 
				$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/english/style.css', array('type'=>'text/css'));
			}
            xoops_confirm(array('op' => 'delete', 'ok' => 1), XOOPS_URL.'/modules/profile/user.php', _US_SURETODEL . '<br/>' . _US_REMOVEINFO);
            include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'footer.php';
        } else {
            $del_uid = $GLOBALS['xoopsUser']->getVar("uid");
            $member_handler =& xoops_gethandler('member');
            if (false != $member_handler->deleteUser($GLOBALS['xoopsUser'])) {
                $online_handler =& xoops_gethandler('online');
                $online_handler->destroy($del_uid);
                xoops_notification_deletebyuser($del_uid);
                redirect_header(XOOPS_URL . '/', 5, _US_BEENDELED);
            }
            redirect_header(XOOPS_URL . '/', 5, _US_NOPERMISS);
        }
        exit();
    }
}
?>