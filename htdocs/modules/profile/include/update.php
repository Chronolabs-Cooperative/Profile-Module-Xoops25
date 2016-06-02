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
 * @version         $Id: update.php 3704 2009-10-05 08:52:22Z wishcraft $
 */

function xoops_module_update_profile(&$module, $oldversion = null) 
{
    
    if ( $oldversion < 100 ) {
      
        // Drop old category table  
        $sql = "DROP TABLE " . $GLOBALS['xoopsDB']->prefix("profile_category");
        $GLOBALS['xoopsDB']->queryF($sql);
        
        // Drop old field-category link table
        $sql = "DROP TABLE " . $GLOBALS['xoopsDB']->prefix("profile_fieldcategory");
        $GLOBALS['xoopsDB']->queryF($sql);
        
        // Create new tables for new profile module
        $GLOBALS['xoopsDB']->queryFromFile(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname', 'n') . "/sql/mysql.sql");
        
        include_once dirname(__FILE__) . "/install.php";
        xoops_module_install_profile($module);
        $goupperm_handler =& xoops_getHandler("groupperm");
        
        $field_handler =& xoops_getModuleHandler('field', $module->getVar('dirname', 'n') );
        $skip_fields = $field_handler->getUserVars();
        $skip_fields[] = 'newemail';
        $skip_fields[] = 'pm_link';
        $sql = "SELECT * FROM `" . $GLOBALS['xoopsDB']->prefix("user_profile_field") . "` WHERE `field_name` NOT IN ('" . implode("', '", $skip_fields) . "')";
        $result = $GLOBALS['xoopsDB']->query($sql);
        $fields = array();
        while ($myrow = $GLOBALS['xoopsDB']->fetchArray($result)  ) {
            $fields[] = $myrow['field_name'];
            $object =& $field_handler->create();
            $object->setVars($myrow, true);
            $object->setVar('cat_id', 1);
            if ( !empty($myrow['field_register'])  ) {
                $object->setVar('step_id', 2);
            }
            if ( !empty($myrow['field_options'])  ) {
                $object->setVar('field_options', unserialize($myrow['field_options']) );
            }
            $field_handler->insert($object, true);
            
            $gperm_itemid = $object->getVar('field_id');
            $sql = "UPDATE " . $GLOBALS['xoopsDB']->prefix("group_permission") . " SET gperm_itemid = " . $gperm_itemid .
                    "   WHERE gperm_itemid = " . $myrow['fieldid'] .
                    "       AND gperm_modid = " . $module->getVar('mid') .
                    "       AND gperm_name IN ('profile_edit', 'profile_search')";
            $GLOBALS['xoopsDB']->queryF($sql);

            $groups_visible = $goupperm_handler->getGroupIds("profile_visible", $myrow['fieldid'], $module->getVar('mid') );
            $groups_show = $goupperm_handler->getGroupIds("profile_show", $myrow['fieldid'], $module->getVar('mid') );
            foreach ($groups_visible as $ugid ) {
                foreach ($groups_show as $pgid ) {
                    $sql = "INSERT INTO " . $GLOBALS['xoopsDB']->prefix("profile_visibility") . 
                        " (field_id, user_group, profile_group) " .
                        " VALUES " . 
                        " ({$gperm_itemid}, {$ugid}, {$pgid})";
                    $GLOBALS['xoopsDB']->queryF($sql);
                }
            }
            
            //profile_install_setPermissions($object->getVar('field_id'), $module->getVar('mid'), $canedit, $visible);
            unset($object);
        }
        
        // Copy data from profile table
        foreach ($fields as $field ) {
            $GLOBALS['xoopsDB']->queryF("UPDATE `" . $GLOBALS['xoopsDB']->prefix("profile_profile") . "` u, `" . $GLOBALS['xoopsDB']->prefix("user_profile") . "` p SET u.{$field} = p.{$field} WHERE u.profile_id=p.profileid");
        }
        
        // Drop old profile table
        $sql = "DROP TABLE " . $GLOBALS['xoopsDB']->prefix("user_profile");
        $GLOBALS['xoopsDB']->queryF($sql);
        
        // Drop old field module
        $sql = "DROP TABLE " . $GLOBALS['xoopsDB']->prefix("user_profile_field");
        $GLOBALS['xoopsDB']->queryF($sql);
        
        // Remove not used items
        $sql =  "DELETE FROM " . $GLOBALS['xoopsDB']->prefix("group_permission") . 
                "   WHERE `gperm_modid` = " . $module->getVar('mid') . " AND `gperm_name` IN ('profile_show', 'profile_visible')";
        $GLOBALS['xoopsDB']->queryF($sql);
    }

	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_validation')."` (
		`rule_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
		`weight` tinyint(5) unsigned DEFAULT '1',
		`type` enum('regex','sql','match') DEFAULT NULL,
		`action` tinytext,
		PRIMARY KEY (`rule_id`)
	) ENGINE=MyISAM;";
	$GLOBALS['xoopsDB']->queryF($sql);
	   
	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_oauth')."` (
	  `oauth_id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
	  `status` enum('valid','invalid') DEFAULT NULL,
	  `mode` enum('oauth','openid') DEFAULT NULL,
	  `type` enum('facebook','linkedin','twitter','openid') DEFAULT NULL,
	  `access_oauth_token` varchar(255) DEFAULT NULL,
	  `access_oauth_token_secret` varchar(255) DEFAULT NULL,
	  `access_oauth_expires_in` int(13) DEFAULT '0',
	  `request_oauth_token` varchar(255) DEFAULT NULL,
	  `request_oauth_token_secret` varchar(255) DEFAULT NULL,
	  `request_oauth_expires_in` int(13) DEFAULT '0',
	  `username` varchar(64) DEFAULT NULL,
	  `ip` varchar(64) DEFAULT NULL,
	  `netbios` varchar(255) DEFAULT NULL,
	  `uid` int(13) unsigned DEFAULT '0',
	  `created` int(13) unsigned DEFAULT '0',
	  `updated` int(13) unsigned DEFAULT '0',
	  `signedup` int(13) unsigned DEFAULT '0',
	  PRIMARY KEY (`oauth_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$GLOBALS['xoopsDB']->queryF($sql);
	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_oauth_log')."` (
	    olg_id                  int(11) not null auto_increment,
	    olg_osr_consumer_key    varchar(64) binary,
	    olg_ost_token           varchar(64) binary,
	    olg_ocr_consumer_key    varchar(64) binary,
	    olg_oct_token           varchar(64) binary,
	    olg_usa_id_ref          int(11),
	    olg_received            text not null,
	    olg_sent                text not null,
	    olg_base_string         text not null,
	    olg_notes               text not null,
	    olg_timestamp           timestamp not null default current_timestamp,
	    olg_remote_ip           bigint not null,
	
	    primary key (olg_id),
	    key (olg_osr_consumer_key, olg_id),
	    key (olg_ost_token, olg_id),
	    key (olg_ocr_consumer_key, olg_id),
	    key (olg_oct_token, olg_id),
	    key (olg_usa_id_ref, olg_id)
	    
	) engine=InnoDB default charset=utf8";
	$GLOBALS['xoopsDB']->queryF($sql);
	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_oauth_consumer_registry')."` (
	    ocr_id                  int(11) not null auto_increment,
	    ocr_usa_id_ref          int(11),
	    ocr_consumer_key        varchar(128) binary not null,
	    ocr_consumer_secret     varchar(128) binary not null,
	    ocr_signature_methods   varchar(255) not null default 'HMAC-SHA1,PLAINTEXT',
	    ocr_server_uri          varchar(255) not null,
	    ocr_server_uri_host     varchar(128) not null,
	    ocr_server_uri_path     varchar(128) binary not null,
	
	    ocr_request_token_uri   varchar(255) not null,
	    ocr_authorize_uri       varchar(255) not null,
	    ocr_access_token_uri    varchar(255) not null,
	    ocr_timestamp           timestamp not null default current_timestamp,
	
	    primary key (ocr_id),
	    unique key (ocr_consumer_key, ocr_usa_id_ref, ocr_server_uri),
	    key (ocr_server_uri),
	    key (ocr_server_uri_host, ocr_server_uri_path),
	    key (ocr_usa_id_ref)
	
	) engine=InnoDB default charset=utf8";
	$GLOBALS['xoopsDB']->queryF($sql);
	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_oauth_consumer_token')."` (
	    oct_id                  int(11) not null auto_increment,
	    oct_ocr_id_ref          int(11) not null,
	    oct_usa_id_ref          int(11) not null,
	    oct_name                varchar(64) binary not null default '',
	    oct_token               varchar(64) binary not null,
	    oct_token_secret        varchar(64) binary not null,
	    oct_token_type          enum('request','authorized','access'),
	    oct_token_ttl           datetime not null default '9999-12-31',
	    oct_timestamp           timestamp not null default current_timestamp,
	
	    primary key (oct_id),
	    unique key (oct_ocr_id_ref, oct_token),
	    unique key (oct_usa_id_ref, oct_ocr_id_ref, oct_token_type, oct_name),
		key (oct_token_ttl),
	
	    foreign key (oct_ocr_id_ref) references oauth_consumer_registry (ocr_id)
	        on update cascade
	        on delete cascade
	
	) engine=InnoDB default charset=utf8";
	$GLOBALS['xoopsDB']->queryF($sql);
	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_oauth_server_registry')."` (
	    osr_id                      int(11) not null auto_increment,
	    osr_usa_id_ref              int(11),
	    osr_consumer_key            varchar(64) binary not null,
	    osr_consumer_secret         varchar(64) binary not null,
	    osr_enabled                 tinyint(1) not null default '1',
	    osr_status                  varchar(16) not null,
	    osr_requester_name          varchar(64) not null,
	    osr_requester_email         varchar(64) not null,
	    osr_callback_uri            varchar(255) not null,
	    osr_application_uri         varchar(255) not null,
	    osr_application_title       varchar(80) not null,
	    osr_application_descr       text not null,
	    osr_application_notes       text not null,
	    osr_application_type        varchar(20) not null,
	    osr_application_commercial  tinyint(1) not null default '0',
	    osr_issue_date              datetime not null,
	    osr_timestamp               timestamp not null default current_timestamp,
	
	    primary key (osr_id),
	    unique key (osr_consumer_key),
	    key (osr_usa_id_ref)
	) engine=InnoDB default charset=utf8";
	$GLOBALS['xoopsDB']->queryF($sql);
	
	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_oauth_server_nonce')."` (
	    osn_id                  int(11) not null auto_increment,
	    osn_consumer_key        varchar(64) binary not null,
	    osn_token               varchar(64) binary not null,
	    osn_timestamp           bigint not null,
	    osn_nonce               varchar(80) binary not null,
	
	    primary key (osn_id),
	    unique key (osn_consumer_key, osn_token, osn_timestamp, osn_nonce)
	) engine=InnoDB default charset=utf8";
	$GLOBALS['xoopsDB']->queryF($sql);
	$sql =  "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('profile_oauth_server_token')."` (
	    ost_id                  int(11) not null auto_increment,
	    ost_osr_id_ref          int(11) not null,
	    ost_usa_id_ref          int(11) not null,
	    ost_token               varchar(64) binary not null,
	    ost_token_secret        varchar(64) binary not null,
	    ost_token_type          enum('request','access'),
	    ost_authorized          tinyint(1) not null default '0',
		ost_referrer_host       varchar(128) not null default '',
		ost_token_ttl           datetime not null default '9999-12-31',
	    ost_timestamp           timestamp not null default current_timestamp,
	    ost_verifier            char(10),
	    ost_callback_url        varchar(512),
	
		primary key (ost_id),
	    unique key (ost_token),
	    key (ost_osr_id_ref),
		key (ost_token_ttl),
	
		foreign key (ost_osr_id_ref) references oauth_server_registry (osr_id)
	        on update cascade
	        on delete cascade
	
	) engine=InnoDB default charset=utf8";
	$GLOBALS['xoopsDB']->queryF($sql);
    $profile_handler =& xoops_getModuleHandler("profile", $module->getVar('dirname', 'n') );
    $profile_handler->cleanOrphan($GLOBALS['xoopsDB']->prefix("users"), "uid", "profile_id");
    $field_handler =& xoops_getModuleHandler('field', $module->getVar('dirname', 'n') );
    $user_fields = $field_handler->getUserVars();
    $criteria = new Criteria("field_name", "('" . implode("', '", $user_fields) . "')", "IN");
    $field_handler->updateAll("field_config", 0, $criteria);
    
    return true;
}
?>