<?php
// $Id: modinfo.php 2980 2009-03-15 22:27:16Z beckmi $
// _LANGCODE: en
// _CHARSET : UTF-8
// Translator: XOOPS Translation Team

define("_PROFILE_MI_NAME","User Profile");
define("_PROFILE_MI_DESC","Module for managing custom user profile fields");

//Main menu links
define("_PROFILE_MI_EDITACCOUNT","Edit Account");
define("_PROFILE_MI_CHANGEPASS","Change Password");
define("_PROFILE_MI_CHANGEMAIL","Change Email");

//Admin links
define("_PROFILE_MI_INDEX","Index");
define("_PROFILE_MI_CATEGORIES","Categories");
define("_PROFILE_MI_FIELDS","Fields");
define("_PROFILE_MI_USERS","Users");
define("_PROFILE_MI_STEPS","Registration Steps");
define("_PROFILE_MI_PERMISSIONS","Permissions");
define("_PROFILE_MI_VALIDATION","Validation");
define('_PROFILE_MI_DIRECTORY',"Directory");

//User Profile Category
define("_PROFILE_MI_CATEGORY_TITLE","User Profile");
define("_PROFILE_MI_CATEGORY_DESC","For those user fields");

//User Profile Fields
define("_PROFILE_MI_URL_TITLE","Website");

//Configuration categories
define("_PROFILE_MI_CAT_SETTINGS","General Settings");
define("_PROFILE_MI_CAT_SETTINGS_DSC","");
define("_PROFILE_MI_CAT_USER","User Settings");
define("_PROFILE_MI_CAT_USER_DSC","");

//Configuration items
define("_PROFILE_MI_PROFILE_SEARCH","Show latest activities on user profile");

//Pages
define("_PROFILE_MI_PAGE_INFO","User Info");
define("_PROFILE_MI_PAGE_EDIT","Edit User");
define("_PROFILE_MI_PAGE_SEARCH","Search");

define("_PROFILE_MI_STEP_BASIC","Basic");
define("_PROFILE_MI_STEP_COMPLEMENTARY","Complementary");

define("_PROFILE_MI_CATEGORY_PERSONAL","Personal");
define("_PROFILE_MI_CATEGORY_MESSAGING","Messaging");
define("_PROFILE_MI_CATEGORY_SETTINGS","Settings");
define("_PROFILE_MI_CATEGORY_COMMUNITY","Community");

define("_PROFILE_MI_NEVER_LOGGED_IN","Never logged in");

define('_PROFILE_MI_TITLE','Title of Page');
define('_PROFILE_MI_TITLE_DESC','Edit the Title of index page');
define('_PROFILE_MI_DESCRIPTION','Description on page.');
define('_PROFILE_MI_DESCRIPTION_DESC','Edit the description of index page');
define('_PROFILE_MI_CLICKABLE','Allow Clickable Links.');
define('_PROFILE_MI_CLICKABLE_DESC','');
define('_PROFILE_MI_GROUPS','Display Groups');
define('_PROFILE_MI_GROUPS_DESC','Display Groups on Directory');
define('_PROFILE_MI_DISPLAY','Display Fields in a Directory');
define('_PROFILE_MI_DISPLAY_DESC','Display Fields in Directory (Update module to display newly added fields)');

// Version 1.68
define('_PROFILE_MI_PUBLICKEY','Public Captcha Key');
define('_PROFILE_MI_PRIVATEKEY','Private Captcha Key');
define('_PROFILE_MI_PUBLICKEY_DESC','Public <a href="http://www.recaptcha.net">Re-Captcha.net</a> Key');
define('_PROFILE_MI_PRIVATEKEY_DESC','Private <a href="http://www.recaptcha.net">Re-Captcha.net</a> Key');

//Version 1.69
define('_PROFILE_MI_FIELD_IP','Your <strong>IP Address of %s</strong> will be recorded.');
define('_PROFILE_MI_FIELD_PROXYIP','Your <strong>Proxy IP Address of %s</strong> will be recorded.');
define('_PROFILE_MI_FIELD_NETWORKADDY','Your <strong>Netbios Address of %s</strong> will be recorded.');

define('_PROFILE_MI_CHECKIP','Check IP address of registeer.');
define('_PROFILE_MI_CHECKPROXYIP','Check Proxy IP address of registeer');
define('_PROFILE_MI_CHECKNETWORKADDY','Check Network Address of Registeer');
define('_PROFILE_MI_CHECKIP_DESC','This Requires an <em>IP Field</em> to be added to the form. (Suggest turn off for all edit)');
define('_PROFILE_MI_CHECKPROXYIP_DESC','This Requires an <em>Proxy IP Field</em> to be added to the form. (Suggest turn off for all edit)');
define('_PROFILE_MI_CHECKNETWORKADDY_DESC','This Requires an <em>Network Address Field</em> to be added to the form. (Suggest turn off for all edit)');

//Version 1.72
//Admin links
define('_PROFILE_MI_DASHBOARD','Dashboard');
define('_PROFILE_MI_ABOUT','About Module');

//Preferences
define('_PROFILE_MI_LOCAL','Use IP Loaction Arrays and Only Allow Registration');
define('_PROFILE_MI_LOCAL_DESC','You need to have an IPDB API Key to use IP Localisation, remember to set your localisation areas with the 3 settings below to at least countries.');
define('_PROFILE_MI_IPDB_APIKEY','IPDB API Key');
define('_PROFILE_MI_IPDB_APIKEY_DESC','Register at <a href="http://ipinfodb.com/register.php">IPDB Registration</a> to recieve an API Key');
define('_PROFILE_MI_COUNTRYCODE','Registrations allowed from Country');
define('_PROFILE_MI_COUNTRYCODE_DESC','This is the country which registration is allowed by. [Seperate with a selection of ctrl + click]');
define('_PROFILE_MI_DISTRICT','Registration Allowed Postcode (US/CA Only)');
define('_PROFILE_MI_DISTRICT_DESC','This is the postcode/zip of the district the registration is done from [Seperate with a pipe symbol]');
define('_PROFILE_MI_CITY','Registration Area City');
define('_PROFILE_MI_CITY_DESC','This is the city the Registration is done from (US/CA Only) [Seperate with a pipe symbol]');
define('_PROFILE_MI_HTACCESS','HTAccess SEO (see htaccess. in /docs)');
define('_PROFILE_MI_HTACCESS_DESC','You need to alter your .htaccess for this.');
define('_PROFILE_MI_BASEURL','Base of URL for SEO (alter htaccess. in /docs)');
define('_PROFILE_MI_BASEURL_DESC','Base path of SEO');
define('_PROFILE_MI_ENDOFURL','End of URL for HTML (alter htaccess. in /docs)');
define('_PROFILE_MI_ENDOFURL_DESC','End of URL for standard output.');

//Version 1.75
//Preferences
define('_PROFILE_MI_SPEEDTEST','Support Speed Test Version 1.03+');
define('_PROFILE_MI_SPEEDTEST_DESC','Allow for testing of speed to set minimal speed for registering.');
define('_PROFILE_MI_TEST_UPLINK','Restrict Upload Speed');
define('_PROFILE_MI_TEST_DOWNLINK','Restrict Download Speed');
define('_PROFILE_MI_SPEEDTEST_TEST','Speed Test Restrictions');
define('_PROFILE_MI_SPEEDTEST_TEST_DESC','This is the options people need to pass for registering with site.');
define('_PROFILE_MI_SPEEDTEST_UPLINK','Minimum Upload Speed (Mbps)');
define('_PROFILE_MI_SPEEDTEST_UPLINK_DESC','This is the minimum upload speed people must have to register with site, if upload restriction is in place.');
define('_PROFILE_MI_SPEEDTEST_DOWNLINK','Minimum Download Speed (Mbps)');
define('_PROFILE_MI_SPEEDTEST_DOWNLINK_DESC','This is the minimum download speed people must have to register with site, if download restriction is in place.');

// Version 1.78
define('_PROFILE_MI_LINKEDIN_APP_KEY','Linked-in Application Key - <a href="https://www.linkedin.com/secure/developer">Get Key</a>');
define('_PROFILE_MI_LINKEDIN_APP_KEY_DESC','This is the main application key for OAuth');
define('_PROFILE_MI_LINKEDIN_APP_SECRET','Linked-in Application Secret - <a href="https://www.linkedin.com/secure/developer">Get Secret</a>');
define('_PROFILE_MI_LINKEDIN_APP_SECRET_DESC','This is the main application secret for OAuth');
define('_PROFILE_MI_LINKEDIN_CALLBACK_URL','Your site callback URL for Linked-In');
define('_PROFILE_MI_LINKEDIN_CALLBACK_URL_DESC','Change this if your callback url is SEO or somewhere different than default otherwise don\'t change if your unsure.');
define('_PROFILE_MI_TWITTER_APP_KEY','Twitter Consumer Key - <a href="https://dev.twitter.com">Get Consumer Key</a>');
define('_PROFILE_MI_TWITTER_APP_KEY_DESC','This is the main application key for OAuth');
define('_PROFILE_MI_TWITTER_APP_SECRET','Twitter Consumer Secret - <a href="https://dev.twitter.com">Get Consumer Secret</a>');
define('_PROFILE_MI_TWITTER_APP_SECRET_DESC','This is the main application secret for OAuth');
define('_PROFILE_MI_TWITTER_CALLBACK_URL','Your site callback URL for Twitter');
define('_PROFILE_MI_TWITTER_CALLBACK_URL_DESC','Change this if your callback url is SEO or somewhere different than default otherwise don\'t change if your unsure.');
define('_PROFILE_MI_FACEBOOK_APP_ID','Facebook Application ID - <a href="https://developers.facebook.com/apps">Get App ID</a>');
define('_PROFILE_MI_FACEBOOK_APP_ID_DESC','This is the main application id for OAuth2');
define('_PROFILE_MI_FACEBOOK_APP_SECRET','Facebook Application Secret - <a href="https://developers.facebook.com/apps">Get App Secret</a>');
define('_PROFILE_MI_FACEBOOK_APP_SECRET_DESC','This is the main application secret for OAuth2');
define('_PROFILE_MI_FACEBOOK_CALLBACK_URL','Your site callback URL for Facebook');
define('_PROFILE_MI_FACEBOOK_CALLBACK_URL_DESC','Change this if your callback url is SEO or somewhere different than default otherwise don\'t change if your unsure.');

define('_PROFILE_MI_USER_AGENT','cURL User-agent');
define('_PROFILE_MI_USER_AGENT_DESC','This is the useragent used when cURL is instanciated');
define('_PROFILE_MI_CURL_CONNECTION_TIMEOUT','cURL DNS Connection Timeout');
define('_PROFILE_MI_CURL_CONNECTION_TIMEOUT_DESC','This is the number of seconds a DNS has to respond with cURL');
define('_PROFILE_MI_CURL_TIMEOUT','cURL Communication Timeout');
define('_PROFILE_MI_CURL_TIMEOUT_DESC','This is the number of seconds a server has to respond before cURL timesout');
define('_PROFILE_MI_CURL_SSL_VERIFY_PEER','cURL Validates SSL Certificates');
define('_PROFILE_MI_CURL_SSL_VERIFY_PEER_DESC','When this is enabled you must have a valid SSL Certificate when connecting with cURL to https://');
define('_PROFILE_MI_CURL_VERBOSE','cURL is Verbose');
define('_PROFILE_MI_CURL_VERBOSE_DESC','This is the option you can turn on to make cURL behave verbosely!');

// Emails
define('_PROFILE_MI_NO_EMAIL_ADDRESS_WITH_USER','There is no email address associated with this account, please assign one now!');
?>

