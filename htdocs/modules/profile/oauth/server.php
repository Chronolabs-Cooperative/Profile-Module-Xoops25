<?php

require_once(dirname(dirname(dirname(__FILE__))).'/mainfile.php');

$_SESSION['oAuthFunction'] = basename(dirname(__FILE__));

$oauth_handler = xoops_getmodulehandler('oauth', 'profile');
$oauth_handler->initialiseServer();
	
switch($GLOBALS['op'])
{
case 'request_token':
	$oauth_handler->server->requestToken();
	exit;

case 'access_token':
	$oauth_handler->server->accessToken();
	exit;

case 'authorize':
	try
	{
		$oauth_handler->server->authorizeVerify();
		$oauth_handler->server->authorizeFinish(true, $_SESSION['xoopsUserId']);
	}
	catch (OAuthException2 $e)
	{
		header('HTTP/1.1 400 Bad Request');
		header('Content-Type: text/plain');
		
		echo "Failed OAuth Request: " . $e->getMessage();
	}
	exit;
default:
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: text/plain');
	echo "Unknown request";
}