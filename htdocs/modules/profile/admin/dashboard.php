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
	
	xoops_cp_header();		
	profile_adminMenu(basename(__FILE__), 0);
	$indexAdmin = new ModuleAdmin();
	$user_handler = xoops_gethandler('user', 'profile');
    $field_handler = xoops_getmodulehandler('field', 'profile');
    $regstep_handler = xoops_getmodulehandler('regstep', 'profile');
    $validation_handler = xoops_getmodulehandler('validation', 'profile');
    $visibility_handler = xoops_getmodulehandler('visibility', 'profile');
    $group_handler = xoops_gethandler('group');

 	$indexAdmin = new ModuleAdmin();	
    $indexAdmin->addInfoBox(_PROFILE_AM_ADMIN_COUNTS);
    $indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERSACTIVE."</label>", $user_handler->getCount(new Criteria('`level`', '0', '>')), 'Green');
    $indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERINACTIVE."</label>", $user_handler->getCount(new Criteria('`level`', '0', '=')), 'Green');
    $criteria = new CriteriaCompo(new Criteria('user_regdate','0', '>'));
    $criteria->add(new Criteria('`level`', '0', '>'));
    $criteria->setSort('`user_regdate`');
    $criteria->setOrder('DESC');
    $criteria->setLimit(1);
    $users = $user_handler->getObjects($criteria, false);
    if (is_object($users[0]))
   		$indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERLASTREGISTERED."</label>", date(_DATESTRING, $users[0]->getVar('user_regdate')) . ' - ' . $users[0]->getVar('uname'), 'Green');
   	$criteria = new CriteriaCompo(new Criteria('last_login','0', '>'));
   	$criteria->add(new Criteria('`level`', '0', '>'));
    $criteria->setSort('`last_login`');
    $criteria->setOrder('DESC');
    $criteria->setLimit(1);
    $users = $user_handler->getObjects($criteria, false);
    if (is_object($users[0]))
   		$indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERLASTLOGGEDON."</label>", date(_DATESTRING, $users[0]->getVar('last_login')) . ' - ' . $users[0]->getVar('uname'), 'Green');
	$criteria = new CriteriaCompo(new Criteria('user_regdate',time()-(60*60*7*4), '>'));
	$criteria->add(new Criteria('`user_regdate`', time(), '<'));
	$criteria->add(new Criteria('`level`', '0', '>'));
   	$indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERREGINMONTH."</label>", $user_handler->getCount($criteria), 'Orange');
	$criteria = new CriteriaCompo(new Criteria('user_regdate',time()-(60*60*7*4*6), '>'));
	$criteria->add(new Criteria('`user_regdate`', time(), '<'));
	$criteria->add(new Criteria('`level`', '0', '>'));
   	$indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERREGIN6MONTH."</label>", $user_handler->getCount($criteria), 'Orange');
	$criteria = new CriteriaCompo(new Criteria('user_regdate',time()-(60*60*7*4*12), '>'));
	$criteria->add(new Criteria('`user_regdate`', time(), '<'));
	$criteria->add(new Criteria('`level`', '0', '>'));
   	$indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERREGIN12MONTH."</label>", $user_handler->getCount($criteria), 'Orange');
    $totalFields = count($field_handler->getUserVars())+$field_handler->getCount(NULL);
    $indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_USERFIELDS."</label>", count($field_handler->getUserVars()), 'Green');
    $indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_CUSTOMFIELDS."</label>", $field_handler->getCount(NULL), 'Green');
	$indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_REGISTRATIONSTEPS."</label>", $regstep_handler->getCount(NULL), 'Green');
    $indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>"._PROFILE_AM_ADMIN_THEREARE_VALIDATION."</label>", $validation_handler->getCount(NULL), 'Green');
    
    foreach($group_handler->getObjects(NULL) as $group) {		    
    	$criteria = new Criteria('user_group', $group->getVar('groupid'));
    	$indexAdmin->addInfoBoxLine(_PROFILE_AM_ADMIN_COUNTS, "<label>".$group->getVar('name')._PROFILE_AM_ADMIN_THEREARE_FIELDVISIBLEPERCENTAGE."</label>", number_format($visibility_handler->getCount($criteria)/$field_handler->getCount(NULL)*100,2).'%', 'Blue');
    }
    
    echo $indexAdmin->renderIndex();
	profile_footer_adminMenu();
	xoops_cp_footer();	

?>