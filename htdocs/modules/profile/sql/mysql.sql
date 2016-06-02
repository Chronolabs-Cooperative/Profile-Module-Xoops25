CREATE TABLE `profile_category` (
  `cat_id`          smallint(5) unsigned    NOT NULL auto_increment,
  `cat_title`       varchar(255)            NOT NULL default '',
  `cat_description` text,
  `cat_weight`      smallint(5) unsigned    NOT NULL default '0',
  
  PRIMARY KEY  (`cat_id`)
) ENGINE=INNODB;

CREATE TABLE `profile_field` (
  `field_id`            int(12) unsigned        NOT NULL auto_increment,
  `cat_id`              smallint(5) unsigned    NOT NULL default '0',
  `field_type`          varchar(30)             NOT NULL default '',
  `field_valuetype`     tinyint(2) unsigned     NOT NULL default '0',
  `field_name`          varchar(255)            NOT NULL default '',
  `field_title`         varchar(255)            NOT NULL default '',
  `field_description`   text,
  `field_required`      tinyint(1) unsigned     NOT NULL default '0',
  `field_maxlength`     smallint(6) unsigned    NOT NULL default '0',
  `field_weight`        smallint(6) unsigned    NOT NULL default '0',
  `field_default`       text,
  `field_notnull`       tinyint(1) unsigned     NOT NULL default '0',
  `field_edit`          tinyint(1) unsigned     NOT NULL default '0',
  `field_show`          tinyint(1) unsigned     NOT NULL default '0',
  `field_config`        tinyint(1) unsigned     NOT NULL default '0',
  `field_options`       text,
  `step_id`             smallint(3) unsigned    NOT NULL default '0',
  
  PRIMARY KEY  (`field_id`),
  UNIQUE KEY `field_name` (`field_name`),
  KEY `step` (`step_id`, `field_weight`)
) ENGINE=INNODB;

CREATE TABLE `profile_visibility` (
  `field_id`        int(12) unsigned        NOT NULL default '0',
  `user_group`      smallint(5) unsigned    NOT NULL default '0',
  `profile_group`   smallint(5) unsigned    NOT NULL default '0',
  
  PRIMARY KEY (`field_id`, `user_group`, `profile_group`),
  KEY `visible` (`user_group`, `profile_group`)
) ENGINE=INNODB;

CREATE TABLE `profile_regstep` (
  `step_id`         smallint(3) unsigned    NOT NULL auto_increment,
  `step_name`       varchar(255)            NOT NULL DEFAULT '',
  `step_desc`       text,
  `step_order`      smallint(3) unsigned    NOT NULL default '0',
  `step_save`       tinyint(1) unsigned     NOT NULL default '0',
  
  PRIMARY KEY (`step_id`),
  KEY `sort` (`step_order`, `step_name`)
) ENGINE=INNODB;

CREATE TABLE `profile_profile` (
  `profile_id`      int(12) unsigned        NOT NULL default '0',
  
  PRIMARY KEY  (`profile_id`)
) ENGINE=INNODB;

CREATE TABLE `profile_validation` (
	`rule_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
	`weight` tinyint(5) unsigned DEFAULT '1',
	`type` enum('regex','sql','match') DEFAULT NULL,
	`action` tinytext,
	PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM;

CREATE TABLE `profile_oauth` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `profile_oauth_log` (
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
    
) engine=InnoDB default charset=utf8;

CREATE TABLE `profile_oauth_consumer_registry` (
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

) engine=InnoDB default charset=utf8;

CREATE TABLE `profile_oauth_consumer_token` (
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

) engine=InnoDB default charset=utf8;

CREATE TABLE `profile_oauth_server_registry` (
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
) engine=InnoDB default charset=utf8;


CREATE TABLE `profile_oauth_server_nonce` (
    osn_id                  int(11) not null auto_increment,
    osn_consumer_key        varchar(64) binary not null,
    osn_token               varchar(64) binary not null,
    osn_timestamp           bigint not null,
    osn_nonce               varchar(80) binary not null,

    primary key (osn_id),
    unique key (osn_consumer_key, osn_token, osn_timestamp, osn_nonce)
) engine=InnoDB default charset=utf8;

CREATE TABLE `profile_oauth_server_token` (
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

) engine=InnoDB default charset=utf8;



