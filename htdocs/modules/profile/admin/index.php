<?php
// $Id: index.php 8066 2011-11-06 05:09:33Z beckmi $
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
// Author: Raul Recio (AKA UNFOR)                                            //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

include_once 'admin_header.php';
xoops_cp_header();

$indexAdmin = new ModuleAdmin();
//-----------------------
// $xpPartnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));

// $totalPartners = $xpPartnerHandler->getCount();
// $totalNonActivePartners = $xpPartnerHandler->getCount(new Criteria('status', 0, '='));
// $totalActivePartners = $totalPartners - $totalNonActivePartners;

// $indexAdmin->addInfoBox(_MD_XPARTNERS_DASHBOARD);

// $indexAdmin->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD, "<infolabel>" ._MD_XPARTNERS_TOTALACTIVE. "</infolabel>", $totalActivePartners, 'Green');
// $indexAdmin->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD,  "<infolabel>" ._MD_XPARTNERS_TOTALNONACTIVE. "</infolabel>", $totalNonActivePartners, 'Red');
// $indexAdmin->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD,  "<infolabel>" ._MD_XPARTNERS_TOTALPARTNERS. "</infolabel><infotext>", $totalPartners."</infotext>");
//----------------------------

echo $indexAdmin->addNavigation('index.php');
echo $indexAdmin->renderIndex();

include 'admin_footer.php';
//xoops_cp_footer();