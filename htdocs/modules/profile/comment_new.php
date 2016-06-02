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
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
	// Get link title
	$member_handler =& xoops_gethandler('member');
	$user  = $member_handler->getUser($com_itemid);
	if (is_object($user)) {
		$name = $user->getVar('uname');
	    $name .= (strlen($user->getVar('name'))>0)?' - ' . $user->getVar('name'):'';
	};
    $com_replytitle = _RE.' '.$name;
    include XOOPS_ROOT_PATH.'/include/comment_new.php';
}
?>
