<?php

	require_once(dirname(dirname(dirname(__FILE__))).'/header.php');
	$_SESSION['oAuthFunction'] = basename(dirname(__FILE__));

	session_start();
   	$code = $_REQUEST["code"];

   	if(empty($code)) {
     	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     	$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       		. $GLOBALS['profileModuleConfig']['facebook_app_id'] . "&redirect_uri=" . urlencode($GLOBALS['profileModuleConfig']['facebook_callback_url']) . "&state="
       		. $_SESSION['state'];
     	echo("<script> top.location.href='" . $dialog_url . "'</script>");
   	}

   	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
   		$_SESSION['oauth']['facebook']['request']['oauth_token'] = $code;
     	$token_url = "https://graph.facebook.com/oauth/access_token?"
       		. "client_id=" . $GLOBALS['profileModuleConfig']['facebook_app_id'] . "&redirect_uri=" . urlencode($GLOBALS['profileModuleConfig']['facebook_callback_url'])
       		. "&client_secret=" . $GLOBALS['profileModuleConfig']['facebook_app_secret'] . "&code=" . $code;

     	$response = profile_get_curl($token_url);
     	$params = null;
     	parse_str($response, $params);
		$_SESSION['oauth']['facebook']['access']['oauth_token'] = $params['access_token'];
     	$graph_url = "https://graph.facebook.com/me?fields=id,name,picture,link,username&access_token=" 
       		. $params['access_token'];

     	$user = profile_object2array(json_decode(profile_get_curl($graph_url)));
     	if (!empty($ret['id'])) {
			$_SESSION['oauth']['facebook']['authorized'] = true;
			$user = $oauth_handler->getOAuthUser_Facebook($ret['id'], $ret['name'], $ret['username'], $ret['link'], $ret['picture']);
		
			// Regenrate a new session id and destroy old session
		    $GLOBALS["sess_handler"]->regenerate_id(true);
		    $_SESSION['xoopsUserId'] = $user->getVar('uid');
		    $_SESSION['xoopsUserGroups'] = $user->getGroups();
		    $user_theme = $user->getVar('theme');
		    if (in_array($user_theme, $xoopsConfig['theme_set_allowed'])) {
		        $_SESSION['xoopsUserTheme'] = $user_theme;
		    }
				
		    // Set cookie for rememberme
		    if (!empty($GLOBAL['xoopsConfig']['usercookie'])) {
				setcookie($GLOBAL['xoopsConfig']['usercookie'], $_SESSION['xoopsUserId'] . '-' . md5($user->getVar('pass') . XOOPS_DB_NAME . XOOPS_DB_PASS . XOOPS_DB_PREFIX), time() + 31536000, '/', XOOPS_COOKIE_DOMAIN, 0);
		    }
	
    	}
   		header('Location: ' . XOOPS_URL.'/modules/profile/signed.php?op=facebook');;
   	} else {
     	echo("The state does not match. You may be a victim of CSRF.");
   	}