<?php
		
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/mainfile.php');
	
	$_SESSION['oAuthFunction'] = basename(dirname(__FILE__));
	
	$oauth_handler = xoops_getmodulehandler('oauth', 'profile');
	
	$_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_REQUEST[LINKEDIN::_GET_TYPE])) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';
  	switch($_REQUEST[LINKEDIN::_GET_TYPE]) {
    case 'initiate':
		$_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
		if(!isset($_GET[LINKEDIN::_GET_RESPONSE])|empty($_GET[LINKEDIN::_GET_RESPONSE])) {
			// LinkedIn hasn't sent us a response, the user is initiating the connection
			// send a request for a LinkedIn access token
			$response = $oauth_handler->_api_linkedin->retrieveTokenRequest();
			if($response['success'] === TRUE) {
				// store the request token
				$_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
	
				// redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
				header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
			} else {
				// bad token request
				echo "Request token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
			}
		} else {
			// LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
			$response = $oauth_handler->_api_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
			if($response['success'] === TRUE) {
				// the request went through without an error, gather user's 'access' tokens
				$_SESSION['oauth']['linkedin']['access'] = $response['linkedin'];
	
				// set the user as authorized for future quick reference
				$_SESSION['oauth']['linkedin']['authorized'] = TRUE;
	
				// redirect the user back to the demo page
				header('Location: ' . XOOPS_URL.'/modules/profile/signed.php?op=linkedin');
			} else {
				// bad token access
				echo "Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
			}
		}
		break;
	case 'revoke':
		/**
		 * Handle authorization revocation.
		 */

		// check the session
		if(!oauth_session_exists()) {
			throw new LinkedInException('This script requires session support, which doesn\'t appear to be working correctly.');
		}

		$oauth_handler->_api_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
		$response = $oauth_handler->_api_linkedin->revoke();
		if($response['success'] === TRUE) {
			// revocation successful, clear session
			session_unset();
			$_SESSION = array();
			if(session_destroy()) {
				// session destroyed
				header('Location: ' . XOOPS_URL);
			} else {
				// session not destroyed
				echo "Error clearing user's session";
			}
		} else {
			// revocation failed
			echo "Error revoking user's token:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
		}
		break;
  	}