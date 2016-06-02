<?php

	include_once ('header.php');
	
	$oauth_handler = xoops_getmodulehandler('oauth', 'profile');
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:'facebook';
	
	switch ($op) {
		case 'linkedin':
	
			$response = $oauth_handler->_api_linkedin->profile('~:(id,first-name,last-name,picture-url)');
			if($response['success'] === TRUE) {
				set_time_limit(1200);
				$profile = profile_object2array(new SimpleXMLElement($response['linkedin']));
				if (!empty($profile['id'])) {
					
					$user = $oauth_handler->getOAuthUser_Linkedin($profile['id'], $profile['first-name'], $profile['last-name'], $profile['picture-url']);
		
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
				    header('Location: ' . XOOPS_URL.'/modules/profile/userinfo.php');
				}
				header('Location: ' . XOOPS_URL.'/modules/profile/user.php');
		    } else {
		        // request failed
		        echo "Error retrieving profile information:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response) . "</pre>";
		    }
		    break;
		case 'twitter':
			if (isset($_SESSION['xoopsUserId']))
		    	header('Location: ' . XOOPS_URL.'/modules/profile/userinfo.php');
		    else 
		    	header('Location: ' . XOOPS_URL.'/modules/profile/user.php');
			break;
		case 'facebook':
			if (isset($_SESSION['xoopsUserId']))
		    	header('Location: ' . XOOPS_URL.'/modules/profile/userinfo.php');
		    else 
		    	header('Location: ' . XOOPS_URL.'/modules/profile/user.php');
			break;			
	} 

?>
	