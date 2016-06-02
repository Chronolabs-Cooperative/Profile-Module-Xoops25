<?php
// $Id: admin.php 4751 2010-05-01 15:35:45Z trabis $
// _LANGCODE: en
// _CHARSET : UTF-8
// Translator: XOOPS Translation Team

define("_PROFILE_AM_FIELD","Field");
define("_PROFILE_AM_FIELDS","Fields");
define("_PROFILE_AM_CATEGORY","Category");
define("_PROFILE_AM_STEP","Step");

define("_PROFILE_AM_SAVEDSUCCESS","%s saved successfully");
define("_PROFILE_AM_DELETEDSUCCESS","%s deleted successfully");
define("_PROFILE_AM_RUSUREDEL","Are you sure you want to delete %s");
define("_PROFILE_AM_FIELDNOTCONFIGURABLE","The field is not configurable.");

define("_PROFILE_AM_ADD","Add %s");
define("_PROFILE_AM_EDIT","Edit %s");
define("_PROFILE_AM_TYPE","Field Type");
define("_PROFILE_AM_VALUETYPE","Value Type");
define("_PROFILE_AM_NAME","Name");
define("_PROFILE_AM_TITLE","Title");
define("_PROFILE_AM_DESCRIPTION","Description");
define("_PROFILE_AM_REQUIRED","Required?");
define("_PROFILE_AM_MAXLENGTH","Maximum Length");
define("_PROFILE_AM_WEIGHT","Weight");
define("_PROFILE_AM_DEFAULT","Default");
define("_PROFILE_AM_NOTNULL","Not Null?");

define("_PROFILE_AM_ARRAY","Array");
define("_PROFILE_AM_EMAIL","Email");
define("_PROFILE_AM_INT","Integer");
define("_PROFILE_AM_TXTAREA","Text Area");
define("_PROFILE_AM_TXTBOX","Text field");
define("_PROFILE_AM_URL","URL");
define("_PROFILE_AM_OTHER","Other");
define("_PROFILE_AM_FLOAT","Floating Point");
define("_PROFILE_AM_DECIMAL","Decimal Number");
define("_PROFILE_AM_UNICODE_ARRAY","Unicode Array");
define("_PROFILE_AM_UNICODE_EMAIL","Unicode Email");
define("_PROFILE_AM_UNICODE_TXTAREA","Unicode Text Area");
define("_PROFILE_AM_UNICODE_TXTBOX","Unicode Text field");
define("_PROFILE_AM_UNICODE_URL","Unicode URL");

define("_PROFILE_AM_PROF_VISIBLE_ON","Field visible on these groups' profile");
define("_PROFILE_AM_PROF_VISIBLE_FOR","Field visible on profile for these groups");
define("_PROFILE_AM_PROF_VISIBLE","Visibility");
define("_PROFILE_AM_PROF_EDITABLE","Field editable from profile");
define("_PROFILE_AM_PROF_REGISTER","Show in registration form");
define("_PROFILE_AM_PROF_SEARCH","Searchable by these groups");
define("_PROFILE_AM_PROF_ACCESS","Profile accessible by these groups");
define("_PROFILE_AM_PROF_ACCESS_DESC", 
        "<ul>" .
        "<li>Admin groups: If a user belongs to admin groups, the current user has access if and only if one of the current user's groups is allowed to access admin group; else</li>" .
        "<li>Non basic groups: If a user belongs to one or more non basic groups (NOT admin, user, anonymous), the current user has access if and only if one of the current user's groups is allowed to allowed to any of the non basic groups; else</li>" .
        "<li>User group: If a user belongs to User group only, the current user has access if and only if one of his groups is allowed to access User group</li>" .
        "</ul>");

define("_PROFILE_AM_FIELDVISIBLE","The field ");
define("_PROFILE_AM_FIELDVISIBLEFOR"," is visible for ");
define("_PROFILE_AM_FIELDVISIBLEON"," viewing a profile of ");
define("_PROFILE_AM_FIELDVISIBLETOALL","- Everyone");
define("_PROFILE_AM_FIELDNOTVISIBLE","is not visible");

define("_PROFILE_AM_CHECKBOX","Checkbox");
define("_PROFILE_AM_GROUP","Group Select");
define("_PROFILE_AM_GROUPMULTI","Group Multi Select");
define("_PROFILE_AM_LANGUAGE","Language Select");
define("_PROFILE_AM_RADIO","Radio Buttons");
define("_PROFILE_AM_SELECT","Select");
define("_PROFILE_AM_SELECTMULTI","Multi Select");
define("_PROFILE_AM_TEXTAREA","Text Area");
define("_PROFILE_AM_DHTMLTEXTAREA","DHTML Text Area");
define("_PROFILE_AM_TEXTBOX","Text Field");
define("_PROFILE_AM_TIMEZONE","Timezone");
define("_PROFILE_AM_YESNO","Radio Yes/No");
define("_PROFILE_AM_DATE","Date");
define("_PROFILE_AM_AUTOTEXT","Auto Text");
define("_PROFILE_AM_DATETIME","Date and Time");
define("_PROFILE_AM_LONGDATE","Long Date");

define("_PROFILE_AM_ADDOPTION","Add Option");
define("_PROFILE_AM_REMOVEOPTIONS","Remove Options");
define("_PROFILE_AM_KEY","Value to be stored");
define("_PROFILE_AM_VALUE","Text to be displayed");

// User management
define("_PROFILE_AM_EDITUSER","Edit User");
define("_PROFILE_AM_SELECTUSER","Select User");
define("_PROFILE_AM_ADDUSER","Add User");
define("_PROFILE_AM_THEME","Theme");
define("_PROFILE_AM_RANK","Rank");
define("_PROFILE_AM_USERDONEXIT","User doesn't exist!");
define("_PROFILE_MA_USERLEVEL","User Level");

define("_PROFILE_MA_ACTIVE","Active");
define("_PROFILE_MA_INACTIVE","Inactive");
define("_PROFILE_AM_USERCREATED","User Created");

define("_PROFILE_AM_CANNOTDELETESELF","Deleting your own account is not allowed - use your profile page to delete your own account");
define("_PROFILE_AM_CANNOTDELETEADMIN","Deleting an administrator account is not allowed");

define("_PROFILE_AM_NOSELECTION","No user selected");
define("_PROFILE_AM_USER_ACTIVATED","User activated");
define("_PROFILE_AM_USER_DEACTIVATED","User deactivated");
define("_PROFILE_AM_USER_NOT_ACTIVATED","Error: User NOT activated");
define("_PROFILE_AM_USER_NOT_DEACTIVATED","Error: User NOT deactivated");

define("_PROFILE_AM_STEPNAME","Step name");
define("_PROFILE_AM_STEPORDER","Step order");
define("_PROFILE_AM_STEPSAVE","Save after step");
define("_PROFILE_AM_STEPINTRO","Step description");

define('_PROFILE_AM_VALIDATIONNAME','Validation Rule');
define('_PROFILE_AM_VALIDATION','Validation (JSON)');
define('_PROFILE_AM_VALIDATION2','Validation (POST)');
define('_AM_NOTHING_SELECTED','Nothing Selected');

define("_AM_RULE_ID","Rule ID");
define("_AM_RULE_TYPE","Rule Type");
define("_AM_RULE_WEIGHT","Rule Weight");
define("_AM_RULE_ACTION","Function run on Rule");
define("_AM_FORM_WEIGHT","Weight");
define("_AM_FORM_TYPE","Function Type");
define("_AM_FORM_TYPE_DESC","This is the type of function used in this validation.");
define("_AM_FORM_ACTION","Function/Action:");
define("_AM_FORM_VALIDATION_NEW","New validation rule!");
define("_AM_FORM_VALIDATION_EDIT","Edit validation rule!");
define("_AM_FORM_LISTINGRULES","These are the current validation rules!");
define("_AM_RULE_NEW","Create new validation!");

define("_AM_ACTION","Action Item");
define("_AM_RESET_ORDER","Save Order");
define("_AM_SAVE","Save");

define('_PROFILE_AM_VALIDATION_RULES','Actionable Validation Rules');
define('_PROFILE_AM_VALIDATION_NORULES','<strong><em>You have no validation rules defined to select for this field to function on please define some by <a href="'.XOOPS_URL.'/modules/profile/admin/validation.php">clicking here</a>!</em></strong>');
define('_PROFILE_AM_PROF_DIRECTORY','Directory');
define('_PROFILE_AM_PERMISSIONS_DIRECTORY','Directory Permissions');
define('_PROFILE_AM_DIRECTORYORDER','Directory Field Order');
define('_PROFILE_AM_ORDER','Weight');
define('_PROFILE_AM_MSG_FIELDORDERSAVED','Field Order has been Saved Successfully!');
define('_PROFILE_AM_MSG_FIELDORDER_RESET','Field Order Reset!');

//Version 1.69
define('_PROFILE_AM_IP','IP Address');
define('_PROFILE_AM_PROXYIP','Proxy IP Address');
define('_PROFILE_AM_NETWORKADDY','Network Address');

//Version 1.72
//Dashboard
define('_PROFILE_AM_ADMIN_COUNTS','Profile User Statistics');
define('_PROFILE_AM_ADMIN_THEREARE_USERSACTIVE','Users active: %s');
define('_PROFILE_AM_ADMIN_THEREARE_USERINACTIVE','Inactive users: %s');
define('_PROFILE_AM_ADMIN_THEREARE_USERLASTREGISTERED','Active User last Registered: %s');
define('_PROFILE_AM_ADMIN_THEREARE_USERLASTLOGGEDON','Active User last logged on: %s');
define('_PROFILE_AM_ADMIN_THEREARE_USERREGINMONTH','Users Activated and Registered Last Month: %s');
define('_PROFILE_AM_ADMIN_THEREARE_USERREGIN6MONTH','Users Activated and Registered Last 6 Months: %s');
define('_PROFILE_AM_ADMIN_THEREARE_USERREGIN12MONTH','Users Activated and Registered Last 12 Months: %s');
define('_PROFILE_AM_ADMIN_THEREARE_USERFIELDS','System Fields: %s');
define('_PROFILE_AM_ADMIN_THEREARE_CUSTOMFIELDS','Custom User Fields: %s');
define('_PROFILE_AM_ADMIN_THEREARE_REGISTRATIONSTEPS','Registration Steps: %s');
define('_PROFILE_AM_ADMIN_THEREARE_VALIDATION','Validation Scripts: %s');
define('_PROFILE_AM_ADMIN_THEREARE_FIELDVISIBLEPERCENTAGE',' has %s visible custom fields in the user profile!');

//About
define('_PROFILE_AM_ABOUT_MAKEDONATE','Make donation to Chronolabs co-op');
?>
