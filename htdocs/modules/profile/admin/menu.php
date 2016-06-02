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
 * @version         $Id: menu.php 2021 2008-08-31 02:02:45Z phppp $
 */
$module_handler = xoops_gethandler('module');
$GLOBALS['profileModule'] = $module_handler->getByDirname('profile');
$adminmenu = array();	
$adminmenu[0]['title'] = _PROFILE_MI_DASHBOARD;
$adminmenu[0]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/about.png';
$adminmenu[0]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/about.png';
$adminmenu[0]['link'] = "admin/dashboard.php";
$adminmenu[1]['title'] = _PROFILE_MI_USERS;
$adminmenu[1]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.user.png';
$adminmenu[1]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.user.png';
$adminmenu[1]['link'] = "admin/user.php";
$adminmenu[2]['title'] = _PROFILE_MI_CATEGORIES;
$adminmenu[2]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.categories.png';
$adminmenu[2]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.categories.png';
$adminmenu[2]['link'] = "admin/category.php";
$adminmenu[3]['title'] = _PROFILE_MI_FIELDS;
$adminmenu[3]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.fields.png';
$adminmenu[3]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.fields.png';
$adminmenu[3]['link'] = "admin/field.php";
$adminmenu[4]['title'] = _PROFILE_MI_STEPS;
$adminmenu[4]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.step.png';
$adminmenu[4]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.step.png';
$adminmenu[4]['link'] = "admin/step.php";
$adminmenu[5]['title'] = _PROFILE_MI_PERMISSIONS;
$adminmenu[5]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.permissions.png';
$adminmenu[5]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.permissions.png';
$adminmenu[5]['link'] = "admin/permissions.php";
$adminmenu[6]['title'] = _PROFILE_MI_VALIDATION;
$adminmenu[6]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.validation.png';
$adminmenu[6]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.validation.png';
$adminmenu[6]['link'] = "admin/validation.php";
$adminmenu[7]['title'] = _PROFILE_MI_DIRECTORY;
$adminmenu[7]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.directory.png';
$adminmenu[7]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/profile.directory.png';
$adminmenu[7]['link'] = "admin/directory.php?op=order&fct=fields";
$adminmenu[8]['title'] = _PROFILE_MI_ABOUT;
$adminmenu[8]['icon'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/about.png';
$adminmenu[8]['image'] = '../../'.$GLOBALS['profileModule']->getInfo('icons32').'/about.png';
$adminmenu[8]['link'] = "admin/about.php";

?>