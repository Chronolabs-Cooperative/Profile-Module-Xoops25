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
 * @version         $Id: permissions.php 5204 2010-09-06 20:10:52Z mageg $
 */
include 'header.php';
xoops_cp_header();
profile_adminMenu(basename(__FILE__), 5);

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "edit";

include_once $GLOBALS['xoops']->path( "/class/xoopsformloader.php" );
$opform = new XoopsSimpleForm('', 'opform', 'permissions.php', "get");
$op_select = new XoopsFormSelect("", 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOption('visibility', _PROFILE_AM_PROF_VISIBLE);
$op_select->addOption('edit', _PROFILE_AM_PROF_EDITABLE);
$op_select->addOption('search', _PROFILE_AM_PROF_SEARCH);
$op_select->addOption('access', _PROFILE_AM_PROF_ACCESS);
$op_select->addOption('directory', _PROFILE_AM_PROF_DIRECTORY);
$opform->addElement($op_select);
$opform->display();

$perm_desc = "";
switch ($op ) {
case "visibility":
    redirect_header("visibility.php", 0, _PROFILE_AM_PROF_VISIBLE);
    //header("Location: visibility.php");
    break;
case "directory":    
 	xoops_cp_header();
	include_once $GLOBALS['xoops']->path( '/class/xoopsform/grouppermform.php' );
	$result_view = $GLOBALS['xoopsDB']->query("SELECT groupid, name FROM ".$GLOBALS['xoopsDB']->prefix('groups')." ");
	if ($GLOBALS['xoopsDB']->getRowsNum($result_view)) {
		while ($myrow_view = $GLOBALS['xoopsDB']->fetcharray($result_view)) {
			$item_list_view['cid'] = $myrow_view['groupid'];
			$item_list_view['title'] = $myrow_view['name'];						
			$form_view = new XoopsGroupPermForm("", $GLOBALS['profileModule']->getVar('mid'), 'view_group', "<img id='toptableicon' src=".XOOPS_URL."/modules/".$GLOBALS['profileModule']->dirname()."/images/close12.gif alt='' /></a>&nbsp;"._PROFILE_AM_PERMISSIONS_DIRECTORY."</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">".ucfirst($mode)."</span>");
			$block_view[] = $item_list_view;
			foreach ($block_view as $itemlists) {
				$form_view->addItem($itemlists['cid'], $itemlists['title']);
			} 
		} 
	}
	echo $form_view->render();
	xoops_cp_footer();
	exit(0)	;
	break;
case "edit":
    $title_of_form = _PROFILE_AM_PROF_EDITABLE;
    $perm_name = "profile_edit";
    $restriction = "field_edit";
    $anonymous = false;
    break;
    
case "search":
    $title_of_form = _PROFILE_AM_PROF_SEARCH;
    $perm_name = "profile_search";
    $restriction = "";
    $anonymous = true;
    break;
    
case "access":
    $title_of_form = _PROFILE_AM_PROF_ACCESS;
    $perm_name = "profile_access";
    $perm_desc = _PROFILE_AM_PROF_ACCESS_DESC;
    $restriction = "";
    $anonymous = true;
    break;
}
$module_id = $GLOBALS['profileModule']->getVar('mid');
include_once $GLOBALS['xoops']->path( '/class/xoopsform/grouppermform.php' );
$form = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc, 'admin/permissions.php', $anonymous);

if ( $op == "access" ) {
    $member_handler =& xoops_gethandler('member');
    $glist = $member_handler->getGroupList();
    foreach (array_keys($glist) as $i ) {
        if ( $i != XOOPS_GROUP_ANONYMOUS ) {
            $form->addItem($i, $glist[$i]);
        }
    }
    
} else {
    $profile_handler =& xoops_getmodulehandler('profile');
    $fields = $profile_handler->loadFields();
    
    if ( $op != "search" ) {
        foreach (array_keys($fields) as $i ) {
            if ( $restriction == "" || $fields[$i]->getVar($restriction)  ) {
                $form->addItem($fields[$i]->getVar('field_id'), xoops_substr($fields[$i]->getVar('field_title'), 0, 25) );
            }
        }
    } else {
        $searchable_types = array('textbox',
        'select',
        'radio',
        'yesno',
        'date',
        'datetime',
        'timezone',
        'language');
        foreach (array_keys($fields) as $i ) {
            if ( in_array($fields[$i]->getVar('field_type'), $searchable_types)  ) {
                $form->addItem($fields[$i]->getVar('field_id'), xoops_substr($fields[$i]->getVar('field_title'), 0, 25) );
            }
        }
    }
}
$form->display();

profile_footer_adminMenu();
xoops_cp_footer();
?>