<?php
// $Id: directory.php 5204 2010-09-06 20:10:52Z mageg $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: XOOPS Foundation                                                  //
// URL: http://www.xoops.org/                                                //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

	include ('header.php');
	xoops_loadLanguage('admin', 'profile');
	
	switch ($_REQUEST['op']){
	case 'reset':
		XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields', $fields, 8000);
		XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields_cache', $fields, 8000*1000);
		redirect_header('directory.php?op='.'order'.'&fct='.'fields', 5, _PROFILE_AM_MSG_FIELDORDER_RESET);
		exit(0);
	case 'save':
		switch($_REQUEST['fct']) {
		case 'fields':
			$weights = $_POST['weight'];
			$fields = array();
			foreach($weights as $field => $weight){
				$fields[] = array('field' => $field, 'weight' => $weight);
			}
			$fields = profile_orderfields($fields, false);
						
			XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields', $fields, 8000);
			XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields_cache', $fields, 8000*1000);
			XoopsCache::write($GLOBALS['profileModule']->getVar('dirname').'_fields', $fields, 8000);
			XoopsCache::write($GLOBALS['profileModule']->getVar('dirname').'_fields_cache', $fields, 8000*1000);
			redirect_header('directory.php?op='.'order'.'&fct='.'fields', 5, _PROFILE_AM_MSG_FIELDORDERSAVED);
			exit(0);
		}
	default:
	case 'order':
		switch($_REQUEST['fct']) {
		default:
		case 'fields':
				xoops_cp_header();		
				profile_adminMenu('directory.php?op=order&fct=fields', 7);
				echo profile_directory_listorder();
				profile_footer_adminMenu();
				xoops_cp_footer();	
			break;	
		}
		break;

	}
?>