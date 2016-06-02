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
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         profile
 * @since           2.3.0
 * @author          Jan Pedersen
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: activate.php 4941 2010-07-22 17:13:36Z beckmi $
 */

$xoopsOption['pagetype'] = "user";
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'header.php';

include $GLOBALS['xoops']->path('header.php');
if (file_exists($GLOBALS['xoops']->path('modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))) {
	$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css', array('type'=>'text/css'));
} else { 
	$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/english/style.css', array('type'=>'text/css'));
}

if (!empty($_GET['id']) && !empty($_GET['actkey'])) {
    $id = intval($_GET['id']);
    $actkey = trim($_GET['actkey']);
    if (empty($id)) {
        redirect_header(XOOPS_URL, 1, '');
        exit();
    }
    $member_handler =& xoops_gethandler('member');
    $thisuser =& $member_handler->getUser($id);
    if (!is_object($thisuser)) {
        redirect_header(XOOPS_URL, 1, '');
        exit();
    }
    if ($thisuser->getVar('actkey') != $actkey) {
        redirect_header(XOOPS_URL . '/', 5, _US_ACTKEYNOT);
    } else {
        if ($thisuser->getVar('level') > 0) {
            redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n'). '/index.php', 5, _US_ACONTACT, false);
        } else {
        	if ($thisuser->getVar('level')>0) {
	        	$thisuser->setVar('level', 0);
	            if (false != $member_handler->insertUser($thisuser)) {
					$myts =& MyTextSanitizer::getInstance();
					$xoopsMailer = xoops_getMailer();
					$xoopsMailer->useMail();
					$xoopsMailer->setTemplate('deactivated.tpl');
					$xoopsMailer->assign('SITENAME', $GLOBALS['xoopsConfig']['sitename']);
					$xoopsMailer->assign('ADMINMAIL', $GLOBALS['xoopsConfig']['adminmail']);
					$xoopsMailer->assign('SITEURL', XOOPS_URL . "/");
					$xoopsMailer->setToUsers($thisuser);
					$xoopsMailer->setFromEmail($GLOBALS['xoopsConfig']['adminmail']);
					$xoopsMailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
					$xoopsMailer->setSubject(sprintf(_US_YOURACCOUNT, $GLOBALS['xoopsConfig']['sitename']) );
					include $GLOBALS['xoops']->path('header.php');
					if (!$xoopsMailer->send()) {
						printf(_US_ACTVMAILNG, $thisuser->getVar('uname') );
					} else {
						printf(_US_ACTVMAILOK, $thisuser->getVar('uname') );
					}
					include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'footer.php';
	            } else {
	                redirect_header(XOOPS_URL . '/index.php', 5, 'Deactivation failed!');
	            }
        	} else {
                redirect_header(XOOPS_URL . '/index.php', 5, 'Deactivation failed!');
            }
        }
    }
} else {
    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
    $form = new XoopsThemeForm('', 'form', 'deactivate.php');
    $form->addElement(new XoopsFormText(_US_EMAIL, 'email', 25, 255) );
    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit') );
    $form->display();
}

$xoBreadcrumbs[] = array('title' => _PROFILE_MA_REGISTER);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'footer.php';
?>