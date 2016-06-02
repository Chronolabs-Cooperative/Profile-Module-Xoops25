<?php

/**
 * oauth-php: Example OAuth client for accessing Google Docs
 *
 * @author BBG
 *
 * 
 * The MIT License
 * 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/mainfile.php');

include_once dirname(dirname(dirname(__FILE__)))."/include/functions.php";
include_once dirname(dirname(dirname(__FILE__)))."/include/oauth/OAuthStore.php";
include_once dirname(dirname(dirname(__FILE__)))."/include/oauth/OAuthRequester.php";

$_SESSION['oAuthFunction'] = basename(dirname(__FILE__));

//  Init the OAuthStore
$oauth_handler = xoops_getmodulehandler('oauth', 'profile');

try
{
	//  STEP 1:  If we do not have an OAuth token yet, go get one
	if (!isset($_GET["oauth_token"]))
	{
		$getAuthTokenParams = array('oauth_callback' 	=> $oauth_handler->_twitter_api_config['callback_url'],
									'oauth_nonce'		=>	md5(microtime()),
									'oauth_timestamp'	=>	time());
		// get a request token
		$tokenResultParams = OAuthRequester::requestRequestToken($oauth_handler->_twitter_api_config['consumer_key'], 0, $getAuthTokenParams);
		//  redirect to the google authorization page, they will redirect back
		header("Location: " . $oauth_handler->_twitter_api_config['authorize_uri'] . "?oauth_token=" . $tokenResultParams['token']);
	}
	else {
		//  STEP 2:  Get an access token
		$oauthToken = $_GET["oauth_token"];
		// echo "oauth_verifier = '" . $oauthVerifier . "'<br/>";
		$tokenResultParams = $_GET;
		try {
		    OAuthRequester::requestAccessToken($oauth_handler->_twitter_api_config['consumer_key'], $oauthToken, 0, 'POST', $_GET);
		    $_SESSION['oauth']['twitter']['authorized'] = true;
		}
		catch (OAuthException2 $e)
		{
			var_dump($e);
			$_SESSION['oauth']['twitter']['authorized'] = false;
		    return;
		}
		$tokenResultParams['count'] = 1;
		// now make the request. 
    	$request = new OAuthRequester('https://api.twitter.com/1/statuses/user_timeline.json' , 'GET', $tokenResultParams);
    	$result = $request->doRequest();
    	$ret = profile_object2array(json_decode($result['body']));
    	if (!empty($ret[0]['user']['id_str'])) {
			
			$user = $oauth_handler->getOAuthUser_Twitter($ret[0]['user']['id_str'], $ret[0]['user']['name'], $ret[0]['user']['screen_name'], $ret[0]['user']['profile_image_url']);
		
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
   		header('Location: ' . XOOPS_URL.'/modules/profile/signed.php?op=twitter'); 	
   	}
}
catch(OAuthException2 $e) {
	echo "OAuthException:  " . $e->getMessage();
	var_dump($e);
}
?>