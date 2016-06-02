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
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @version         $Id: header.php 4028 2009-12-12 10:24:41Z trabis $
 */

global $profileModule, $profileModuleConfig, $myts;

$xoopsOption['pagetype'] = 'user';
include dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'mainfile.php';

$GLOBALS['myts'] = MyTextSanitizer::getInstance();

$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$GLOBALS['profileModule'] = $module_handler->getByDirname('profile');
$GLOBALS['profileModuleConfig'] = $config_handler->getConfigList($GLOBALS['profileModule']->getVar('mid')); 

require_once $GLOBALS['xoops']->path('/modules/profile/include/functions.php');
require_once $GLOBALS['xoops']->path('/modules/profile/include/forms.php');

$xoBreadcrumbs = array();
$xoBreadcrumbs[] = array("title" => $GLOBALS['profileModule']->getVar('name'), "link" => XOOPS_URL . "/modules/" . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/');

//disable cache
$GLOBALS['xoopsConfig']['module_cache'][$GLOBALS['profileModule']->getVar('mid')] = 0;
error_reporting(E_ALL);
?>