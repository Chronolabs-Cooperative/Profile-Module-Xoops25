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
 * @version         $Id: xoops_version.php 4361 2010-02-09 23:36:33Z trabis $
 */

/**
 * This is a temporary solution for merging XOOPS 2.0 and 2.2 series
 * A thorough solution will be available in XOOPS 3.0
 *
 */
error_reporting(0);
$modversion = array();
$modversion['name'] = _PROFILE_MI_NAME;
$modversion['version'] = 1.78;
$modversion['description'] = _PROFILE_MI_DESC;
$modversion['author'] = "Jan Pedersen; Taiwen Jiang; alfred; Wishcraft";
$modversion['credits'] = "Ackbarr, mboyden, marco, mamba, wishcraft, etc.";
$modversion['license'] = "GPL see XOOPS LICENSE";
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = "profile";
$modversion['website'] = "www.xoops.org";

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';

$modversion['release_info'] = "Stable 2012/04/19";
$modversion['release_file'] = XOOPS_URL."/modules/profile/docs/changelog.txt";
$modversion['release_date'] = "2012/04/19";

$modversion['author_realname'] = "Simon Antony Roberts";
$modversion['author_website_url'] = "http://www.chronolabs.coop";
$modversion['author_website_name'] = "Chronolabs Australia";
$modversion['author_email'] = "simon@chronolabs.coop";
$modversion['demo_site_url'] = "Chronolabs Australia";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "http://www.chronolabs.coop/forums/viewforum.php?forum=30";
$modversion['support_site_name'] = "Chronolabs";
$modversion['submit_bug'] = "http://www.chronolabs.coop/forums/viewforum.php?forum=30";
$modversion['submit_feature'] = "http://www.chronolabs.coop/forums/viewforum.php?forum=30";
$modversion['usenet_group'] = "sci.chronolabs";
$modversion['maillist_announcements'] = "";
$modversion['maillist_bugs'] = "";
$modversion['maillist_features'] = "";


// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/dashboard.php";
$modversion['adminmenu'] = "admin/menu.php";

// Scripts to run upon installation or update
$modversion['onInstall'] = "include/install.php";
$modversion['onUpdate'] = "include/update.php";

// Menu
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _PROFILE_MI_DIRECTORY;
$modversion['sub'][1]['url'] = "directory.php";

if ($GLOBALS['xoopsUser']) {
    $modversion['sub'][2]['name'] = _PROFILE_MI_EDITACCOUNT;
    $modversion['sub'][2]['url'] = "edituser.php";
    $modversion['sub'][3]['name'] = _PROFILE_MI_PAGE_SEARCH;
    $modversion['sub'][3]['url'] = "search.php";
    $modversion['sub'][4]['name'] = _PROFILE_MI_CHANGEPASS;
    $modversion['sub'][4]['url'] = "changepass.php";
}

// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][1] = "profile_category";
$modversion['tables'][2] = "profile_profile";
$modversion['tables'][3] = "profile_field";
$modversion['tables'][4] = "profile_visibility";
$modversion['tables'][5] = "profile_regstep";
$modversion['tables'][6] = "proflile_validation";
$modversion['tables'][7] = "proflile_oauth";
$modversion['tables'][8] = "profile_oauth_server_token";
$modversion['tables'][9] = "profile_oauth_server_nonce";
$modversion['tables'][10] = "profile_oauth_server_registry";
$modversion['tables'][11] = "profile_oauth_consumer_token";
$modversion['tables'][12] = "profile_oauth_consumer_registry";
$modversion['tables'][13] = "profile_oauth_log";


// Comments
$modversion['hasComments'] = true;
$modversion['comments']['itemName'] = 'uid';
$modversion['comments']['pageName'] = 'userinfo.php';

//Blocks
$i=0;
$i++;
$modversion['blocks'][$i]['file'] = "linkedin_signin.php";
$modversion['blocks'][$i]['name'] = 'Sign-in with LinkedIN' ;
$modversion['blocks'][$i]['description'] = "Allows users to sign in with linkedin";
$modversion['blocks'][$i]['show_func'] = "b_profile_linkedin_block_signin_show";
$modversion['blocks'][$i]['edit_func'] = "b_profile_linkedin_block_signin_edit";
$modversion['blocks'][$i]['options'] = "";
$modversion['blocks'][$i]['template'] = "profile_linkedin_block_signin.html" ;

$i++;
$modversion['blocks'][$i]['file'] = "twitter_signin.php";
$modversion['blocks'][$i]['name'] = 'Sign-in with Twitter' ;
$modversion['blocks'][$i]['description'] = "Allows users to sign in with Twitter";
$modversion['blocks'][$i]['show_func'] = "b_profile_twitter_block_signin_show";
$modversion['blocks'][$i]['edit_func'] = "b_profile_twitter_block_signin_edit";
$modversion['blocks'][$i]['options'] = "";
$modversion['blocks'][$i]['template'] = "profile_twitter_block_signin.html" ;

$i++;
$modversion['blocks'][$i]['file'] = "facebook_signin.php";
$modversion['blocks'][$i]['name'] = 'Sign-in with Facebook' ;
$modversion['blocks'][$i]['description'] = "Allows users to sign in with Facebook";
$modversion['blocks'][$i]['show_func'] = "b_profile_facebook_block_signin_show";
$modversion['blocks'][$i]['edit_func'] = "b_profile_facebook_block_signin_edit";
$modversion['blocks'][$i]['options'] = "";
$modversion['blocks'][$i]['template'] = "profile_facebook_block_signin.html" ;

$i++;
$modversion['blocks'][$i]['file'] = "all_signin.php";
$modversion['blocks'][$i]['name'] = 'Sign-in with Social networks' ;
$modversion['blocks'][$i]['description'] = "Allows users to sign in with Social Networks";
$modversion['blocks'][$i]['show_func'] = "b_profile_all_block_signin_show";
$modversion['blocks'][$i]['edit_func'] = "b_profile_all_block_signin_edit";
$modversion['blocks'][$i]['options'] = "";
$modversion['blocks'][$i]['template'] = "profile_all_block_signin.html" ;

// Config items
$i=1;
$modversion['config'][$i]['name'] = 'profile_search';
$modversion['config'][$i]['title'] = '_PROFILE_MI_PROFILE_SEARCH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;


$modversion['config'][] = array(
	'name'			=> 'directory_title',
	'title' 		=> '_PROFILE_MI_TITLE',
	'description'	=> '_PROFILE_MI_TITLE_DESC',
	'formtype'		=> 'textbox',
	'valuetype'		=> 'text',
	'default'		=> 'Directory of Organisations'
) ;

$modversion['config'][] = array(
	'name'			=> 'directory_description',
	'title' 		=> '_PROFILE_MI_DESCRIPTION',
	'description'	=> '_PROFILE_MI_DESCRIPTION_DESC',
	'formtype'		=> 'textarea',
	'valuetype'		=> 'text',
	'default'		=> ''
) ;

$modversion['config'][] = array(
	'name'			=> 'groups',
	'title' 		=> '_PROFILE_MI_GROUPS',
	'description'	=> '_PROFILE_MI_GROUPS_DESC',
	'formtype'		=> 'group_multi',
	'valuetype'		=> 'array',
	'default'		=> array(XOOPS_GROUP_ADMIN, XOOPS_GROUP_USERS)
) ;

$fields_handler =& xoops_getmodulehandler('field', 'profile');

$fields = $fields_handler->getObjects(NULL, true);
$fieldnames = array();

foreach ($fields as $id => $field)
	$fieldnames = array_merge($fieldnames, array($field->getVar('field_name') => $field->getVar('field_title')));


$fieldnames = array_merge($fieldnames, array('user_avatar' => 'User Avatar'));

$options = array();
foreach($fieldnames as $id => $fieldname)
	if (!is_numeric($id))
		$options[$fieldname] = $id;
	else
		$options[$fieldname] = $fieldname;

$i=0;
$i++;
$modversion['config'][$i] = array(
	'name'			=> 'display',
	'title' 		=> '_PROFILE_MI_DISPLAY',
	'description'	=> '_PROFILE_MI_DISPLAY_DESC',
	'formtype'		=> 'select_multi',
	'valuetype'		=> 'array',
	'options'		=> $options,
	'default'		=> array()
) ;
$i++;
$modversion['config'][$i] = array(
	'name'			=> 'check_ip',
	'title' 		=> '_PROFILE_MI_CHECKIP',
	'description'	=> '_PROFILE_MI_CHECKIP_DESC',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> '0',
	'options'		=> array()
) ;
$i++;
$modversion['config'][$i] = array(
	'name'			=> 'check_proxy_ip',
	'title' 		=> '_PROFILE_MI_CHECKPROXYIP',
	'description'	=> '_PROFILE_MI_CHECKPROXYIP_DESC',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> '0',
	'options'		=> array()
) ;

$i++;
$modversion['config'][$i] = array(
	'name'			=> 'check_network_addy',
	'title' 		=> '_PROFILE_MI_CHECKNETWORKADDY',
	'description'	=> '_PROFILE_MI_CHECKNETWORKADDY_DESC',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> '0',
	'options'		=> array()
) ;

$i++;
$modversion['config'][$i]['name'] = 'public_key';
$modversion['config'][$i]['title'] = '_PROFILE_MI_PUBLICKEY';
$modversion['config'][$i]['description'] = '_PROFILE_MI_PUBLICKEY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '6Lf10wcAAAAAAGnRb892iZ1cjJO4DZvzle97Qqt9';

$i++;
$modversion['config'][$i]['name'] = 'private_key';
$modversion['config'][$i]['title'] = '_PROFILE_MI_PRIVATEKEY';
$modversion['config'][$i]['description'] = '_PROFILE_MI_PRIVATEKEY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '6Lf10wcAAAAAAApaZlJbHHd1hvhVhfdt81sKYfb1';

$i++;
$modversion['config'][$i]['name'] = 'local';
$modversion['config'][$i]['title'] = '_PROFILE_MI_LOCAL';
$modversion['config'][$i]['description'] = '_PROFILE_MI_LOCAL_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'ipdb_apikey';
$modversion['config'][$i]['title'] = '_PROFILE_MI_IPDB_APIKEY';
$modversion['config'][$i]['description'] = '_PROFILE_MI_IPDB_APIKEY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();

$options = array("AFGHANISTAN" => "AF", "ALAND ISLANDS" => "AX", "ALBANIA" => "AL", "ALGERIA" => "DZ", "AMERICAN SAMOA" => "AS", "ANDORRA" => "AD", "ANGOLA" => "AO", "ANGUILLA" => "AI", "ANTARCTICA" => "AQ", "ANTIGUA AND BARBUDA" => "AG", "ARGENTINA" => "AR", "ARMENIA" => "AM", "ARUBA" => "AW", "AUSTRALIA" => "AU", "AUSTRIA" => "AT", "AZERBAIJAN" => "AZ", "BAHAMAS" => "BS", "BAHRAIN" => "BH", "BANGLADESH" => "BD", "BARBADOS" => "BB", "BELARUS" => "BY", "BELGIUM" => "BE", "BELIZE" => "BZ", "BENIN" => "BJ", "BERMUDA" => "BM", "BHUTAN" => "BT", "BOLIVIA, PLURINATIONAL STATE OF" => "BO", "BONAIRE, SAINT EUSTATIUS AND SABA" => "BQ", "BOSNIA AND HERZEGOVINA" => "BA", "BOTSWANA" => "BW", "BOUVET ISLAND" => "BV", "BRAZIL" => "BR", "BRITISH INDIAN OCEAN TERRITORY" => "IO", "BRUNEI DARUSSALAM" => "BN", "BULGARIA" => "BG", "BURKINA FASO" => "BF", "BURUNDI" => "BI", "CAMBODIA" => "KH", "CAMEROON" => "CM", "CANADA" => "CA", "CAPE VERDE" => "CV", "CAYMAN ISLANDS" => "KY", "CENTRAL AFRICAN REPUBLIC" => "CF", "CHAD" => "TD", "CHILE" => "CL", "CHINA" => "CN", "CHRISTMAS ISLAND" => "CX", "COCOS (KEELING) ISLANDS" => "CC", "COLOMBIA" => "CO", "COMOROS" => "KM", "CONGO" => "CG", "CONGO, THE DEMOCRATIC REPUBLIC OF THE" => "CD", "COOK ISLANDS" => "CK", "COSTA RICA" => "CR", "COTE D'IVOIRE" => "CI", "CROATIA" => "HR", "CUBA" => "CU", "CURACAO" => "CW", "CYPRUS" => "CY", "CZECH REPUBLIC" => "CZ", "DENMARK" => "DK", "DJIBOUTI" => "DJ", "DOMINICA" => "DM", "DOMINICAN REPUBLIC" => "DO", "ECUADOR" => "EC", "EGYPT" => "EG", "EL SALVADOR" => "SV", "EQUATORIAL GUINEA" => "GQ", "ERITREA" => "ER", "ESTONIA" => "EE", "ETHIOPIA" => "ET", "FALKLAND ISLANDS (MALVINAS)" => "FK", "FAROE ISLANDS" => "FO", "FIJI" => "FJ", "FINLAND" => "FI", "FRANCE" => "FR", "FRENCH GUIANA" => "GF", "FRENCH POLYNESIA" => "PF", "FRENCH SOUTHERN TERRITORIES" => "TF", "GABON" => "GA", "GAMBIA" => "GM", "GEORGIA" => "GE", "GERMANY" => "DE", "GHANA" => "GH", "GIBRALTAR" => "GI", "GREECE" => "GR", "GREENLAND" => "GL", "GRENADA" => "GD", "GUADELOUPE" => "GP", "GUAM" => "GU", "GUATEMALA" => "GT", "GUERNSEY" => "GG", "GUINEA" => "GN", "GUINEA-BISSAU" => "GW", "GUYANA" => "GY", "HAITI" => "HT", "HEARD ISLAND AND MCDONALD ISLANDS" => "HM", "HOLY SEE (VATICAN CITY STATE)" => "VA", "HONDURAS" => "HN", "HONG KONG" => "HK", "HUNGARY" => "HU", "ICELAND" => "IS", "INDIA" => "IN", "INDONESIA" => "ID", "IRAN, ISLAMIC REPUBLIC OF" => "IR", "IRAQ" => "IQ", "IRELAND" => "IE", "ISLE OF MAN" => "IM", "ISRAEL" => "IL", "ITALY" => "IT", "JAMAICA" => "JM", "JAPAN" => "JP", "JERSEY" => "JE", "JORDAN" => "JO", "KAZAKHSTAN" => "KZ", "KENYA" => "KE", "KIRIBATI" => "KI", "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF" => "KP", "KOREA, REPUBLIC OF" => "KR", "KUWAIT" => "KW", "KYRGYZSTAN" => "KG", "LAO PEOPLE'S DEMOCRATIC REPUBLIC" => "LA", "LATVIA" => "LV", "LEBANON" => "LB", "LESOTHO" => "LS", "LIBERIA" => "LR", "LIBYAN ARAB JAMAHIRIYA" => "LY", "LIECHTENSTEIN" => "LI", "LITHUANIA" => "LT", "LUXEMBOURG" => "LU", "MACAO" => "MO", "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF" => "MK", "MADAGASCAR" => "MG", "MALAWI" => "MW", "MALAYSIA" => "MY", "MALDIVES" => "MV", "MALI" => "ML", "MALTA" => "MT", "MARSHALL ISLANDS" => "MH", "MARTINIQUE" => "MQ", "MAURITANIA" => "MR", "MAURITIUS" => "MU", "MAYOTTE" => "YT", "MEXICO" => "MX", "MICRONESIA, FEDERATED STATES OF" => "FM", "MOLDOVA, REPUBLIC OF" => "MD", "MONACO" => "MC", "MONGOLIA" => "MN", "MONTENEGRO" => "ME", "MONTSERRAT" => "MS", "MOROCCO" => "MA", "MOZAMBIQUE" => "MZ", "MYANMAR" => "MM", "NAMIBIA" => "NA", "NAURU" => "NR", "NEPAL" => "NP", "NETHERLANDS" => "NL", "NEW CALEDONIA" => "NC", "NEW ZEALAND" => "NZ", "NICARAGUA" => "NI", "NIGER" => "NE", "NIGERIA" => "NG", "NIUE" => "NU", "NORFOLK ISLAND" => "NF", "NORTHERN MARIANA ISLANDS" => "MP", "NORWAY" => "NO", "OMAN" => "OM", "PAKISTAN" => "PK", "PALAU" => "PW", "PALESTINIAN TERRITORY, OCCUPIED" => "PS", "PANAMA" => "PA", "PAPUA NEW GUINEA" => "PG", "PARAGUAY" => "PY", "PERU" => "PE", "PHILIPPINES" => "PH", "PITCAIRN" => "PN", "POLAND" => "PL", "PORTUGAL" => "PT", "PUERTO RICO" => "PR", "QATAR" => "QA", "REUNION" => "RE", "ROMANIA" => "RO", "RUSSIAN FEDERATION" => "RU", "RWANDA" => "RW", "SAINT BARTHELEMY" => "BL", "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA" => "SH", "SAINT KITTS AND NEVIS" => "KN", "SAINT LUCIA" => "LC", "SAINT MARTIN (FRENCH PART)" => "MF", "SAINT PIERRE AND MIQUELON" => "PM", "SAINT VINCENT AND THE GRENADINES" => "VC", "SAMOA" => "WS", "SAN MARINO" => "SM", "SAO TOME AND PRINCIPE" => "ST", "SAUDI ARABIA" => "SA", "SENEGAL" => "SN", "SERBIA" => "RS", "SEYCHELLES" => "SC", "SIERRA LEONE" => "SL", "SINGAPORE" => "SG", "SINT MAARTEN (DUTCH PART)" => "SX", "SLOVAKIA" => "SK", "SLOVENIA" => "SI", "SOLOMON ISLANDS" => "SB", "SOMALIA" => "SO", "SOUTH AFRICA" => "ZA", "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS" => "GS", "SPAIN" => "ES", "SRI LANKA" => "LK", "SUDAN" => "SD", "SURINAME" => "SR", "SVALBARD AND JAN MAYEN" => "SJ", "SWAZILAND" => "SZ", "SWEDEN" => "SE", "SWITZERLAND" => "CH", "SYRIAN ARAB REPUBLIC" => "SY", "TAIWAN, PROVINCE OF CHINA" => "TW", "TAJIKISTAN" => "TJ", "TANZANIA, UNITED REPUBLIC OF" => "TZ", "THAILAND" => "TH", "TIMOR-LESTE" => "TL", "TOGO" => "TG", "TOKELAU" => "TK", "TONGA" => "TO", "TRINIDAD AND TOBAGO" => "TT", "TUNISIA" => "TN", "TURKEY" => "TR", "TURKMENISTAN" => "TM", "TURKS AND CAICOS ISLANDS" => "TC", "TUVALU" => "TV", "UGANDA" => "UG", "UKRAINE" => "UA", "UNITED ARAB EMIRATES" => "AE", "UNITED KINGDOM" => "GB", "UNITED STATES" => "US", "UNITED STATES MINOR OUTLYING ISLANDS" => "UM", "URUGUAY" => "UY", "UZBEKISTAN" => "UZ", "VANUATU" => "VU", "VENEZUELA, BOLIVARIAN REPUBLIC OF" => "VE", "VIET NAM" => "VN", "VIRGIN ISLANDS, BRITISH" => "VG", "VIRGIN ISLANDS, U.S." => "VI", "WALLIS AND FUTUNA" => "WF", "WESTERN SAHARA" => "EH", "YEMEN" => "YE0", "ZAMBIA" => "ZM", "ZIMBABWE" => "ZW");
$i++;
$modversion['config'][$i]['name'] = 'countrycodes';
$modversion['config'][$i]['title'] = '_PROFILE_MI_COUNTRYCODE';
$modversion['config'][$i]['description'] = '_PROFILE_MI_COUNTRYCODE_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array('AU'=>'AU','US'=>'US','UK'=>'UK');
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'districts';
$modversion['config'][$i]['title'] = '_PROFILE_MI_DISTRICT';
$modversion['config'][$i]['description'] = '_PROFILE_MI_DISTRICT_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'citys';
$modversion['config'][$i]['title'] = '_PROFILE_MI_CITY';
$modversion['config'][$i]['description'] = '_PROFILE_MI_CITY_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'speedtest';
$modversion['config'][$i]['title'] = '_PROFILE_MI_SPEEDTEST';
$modversion['config'][$i]['description'] = '_PROFILE_MI_SPEEDTEST_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;
$modversion['config'][$i]['options'] = array();

$options = array(_PROFILE_MI_TEST_UPLINK => "UPLINK", _PROFILE_MI_TEST_DOWNLINK => "DOWNLINK");
$i++;
$modversion['config'][$i]['name'] = 'speedtest_test';
$modversion['config'][$i]['title'] = '_PROFILE_MI_SPEEDTEST_TEST';
$modversion['config'][$i]['description'] = '_PROFILE_MI_SPEEDTEST_TEST_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array('DOWNLINK'=>'DOWNLINK');
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'speedtest_uplink';
$modversion['config'][$i]['title'] = '_PROFILE_MI_SPEEDTEST_UPLINK';
$modversion['config'][$i]['description'] = '_PROFILE_MI_SPEEDTEST_UPLINK_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '1.95';
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'speedtest_downlink';
$modversion['config'][$i]['title'] = '_PROFILE_MI_SPEEDTEST_DOWNLINK';
$modversion['config'][$i]['description'] = '_PROFILE_MI_SPEEDTEST_DOWNLINK_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '1.95';
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_PROFILE_MI_HTACCESS";
$modversion['config'][$i]['description'] = "_PROFILE_MI_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_PROFILE_MI_BASEURL";
$modversion['config'][$i]['description'] = "_PROFILE_MI_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'user';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_PROFILE_MI_ENDOFURL";
$modversion['config'][$i]['description'] = "_PROFILE_MI_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

$i++;
$modversion['config'][$i]['name'] = 'user_agent';
$modversion['config'][$i]['title'] = "_PROFILE_MI_USER_AGENT";
$modversion['config'][$i]['description'] = "_PROFILE_MI_USER_AGENT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Mozilla/5.0 ('.XOOPS_VERSION.'; cURL; PHP '.PHP_VERSION.') Profile/'.$modversion['version'];

$i++;
$modversion['config'][$i]['name'] = 'curl_connection_timeout';
$modversion['config'][$i]['title'] = "_PROFILE_MI_CURL_CONNECTION_TIMEOUT";
$modversion['config'][$i]['description'] = "_PROFILE_MI_CURL_CONNECTION_TIMEOUT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;

$i++;
$modversion['config'][$i]['name'] = 'curl_timeout';
$modversion['config'][$i]['title'] = "_PROFILE_MI_CURL_TIMEOUT";
$modversion['config'][$i]['description'] = "_PROFILE_MI_CURL_TIMEOUT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;

$i++;
$modversion['config'][$i]['name'] = 'curl_ssl_verify';
$modversion['config'][$i]['title'] = "_PROFILE_MI_CURL_SSL_VERIFY_PEER";
$modversion['config'][$i]['description'] = "_PROFILE_MI_CURL_SSL_VERIFY_PEER_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;

$i++;
$modversion['config'][$i]['name'] = 'curl_verbose';
$modversion['config'][$i]['title'] = "_PROFILE_MI_CURL_VERBOSE";
$modversion['config'][$i]['description'] = "_PROFILE_MI_CURL_VERBOSE_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;

$i++;
$modversion['config'][$i]['name'] = 'linkedin_group';
$modversion['config'][$i]['title'] = "_PROFILE_MI_LINKEDIN_GROUP";
$modversion['config'][$i]['description'] = "_PROFILE_MI_LINKEDIN_GROUP_DESC";
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = XOOPS_GROUP_USERS;

$i++;
$modversion['config'][$i]['name'] = 'linkedin_app_key';
$modversion['config'][$i]['title'] = "_PROFILE_MI_LINKEDIN_APP_KEY";
$modversion['config'][$i]['description'] = "_PROFILE_MI_LINKEDIN_APP_KEY_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'linkedin_app_secret';
$modversion['config'][$i]['title'] = "_PROFILE_MI_LINKEDIN_APP_SECRET";
$modversion['config'][$i]['description'] = "_PROFILE_MI_LINKEDIN_APP_SECRET_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'linkedin_callback_url';
$modversion['config'][$i]['title'] = "_PROFILE_MI_LINKEDIN_CALLBACK_URL";
$modversion['config'][$i]['description'] = "_PROFILE_MI_LINKEDIN_CALLBACK_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL.'/modules/profile/callback/linkedin/';

$i++;
$modversion['config'][$i]['name'] = 'twitter_group';
$modversion['config'][$i]['title'] = "_PROFILE_MI_TWITTER_GROUP";
$modversion['config'][$i]['description'] = "_PROFILE_MI_TWITTER_GROUP_DESC";
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = XOOPS_GROUP_USERS;

$i++;
$modversion['config'][$i]['name'] = 'twitter_app_key';
$modversion['config'][$i]['title'] = "_PROFILE_MI_TWITTER_APP_KEY";
$modversion['config'][$i]['description'] = "_PROFILE_MI_TWITTER_APP_KEY_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'twitter_app_secret';
$modversion['config'][$i]['title'] = "_PROFILE_MI_TWITTER_APP_SECRET";
$modversion['config'][$i]['description'] = "_PROFILE_MI_TWITTER_APP_SECRET_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'twitter_callback_url';
$modversion['config'][$i]['title'] = "_PROFILE_MI_TWITTER_CALLBACK_URL";
$modversion['config'][$i]['description'] = "_PROFILE_MI_TWITTER_CALLBACK_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL.'/modules/profile/callback/twitter/';

$i++;
$modversion['config'][$i]['name'] = 'facebook_group';
$modversion['config'][$i]['title'] = "_PROFILE_MI_FACEBOOK_GROUP";
$modversion['config'][$i]['description'] = "_PROFILE_MI_FACEBOOK_GROUP_DESC";
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = XOOPS_GROUP_USERS;

$i++;
$modversion['config'][$i]['name'] = 'facebook_app_id';
$modversion['config'][$i]['title'] = "_PROFILE_MI_FACEBOOK_APP_ID";
$modversion['config'][$i]['description'] = "_PROFILE_MI_FACEBOOK_APP_ID_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'facebook_app_secret';
$modversion['config'][$i]['title'] = "_PROFILE_MI_FACEBOOK_APP_SECRET";
$modversion['config'][$i]['description'] = "_PROFILE_MI_FACEBOOK_APP_SECRET_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'facebook_callback_url';
$modversion['config'][$i]['title'] = "_PROFILE_MI_FACEBOOK_CALLBACK_URL";
$modversion['config'][$i]['description'] = "_PROFILE_MI_FACEBOOK_CALLBACK_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL.'/modules/profile/callback/facebook/';

// Templates
$i = 0;

$i++;
$modversion['templates'][$i]['file'] = 'profile_breadcrumbs.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_form.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_admin_fieldlist.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_userinfo.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_admin_categorylist.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_search.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_results.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_admin_visibility.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_admin_steplist.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_register.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_changepass.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_editprofile.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_userform.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_avatar.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_email.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_directory_catlist.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_directory_index.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_directory_search.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_not_local.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_not_passed_speedtest.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'profile_get_email.html';
$modversion['templates'][$i]['description'] = '';

?>