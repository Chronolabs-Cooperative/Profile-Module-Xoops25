<?php

	function b_profile_facebook_block_signin_show($options) {
		include_once($GLOBALS['xoops']->path('/modules/profile/include/functions.php'));
		$social = profile_social_supported();
		if (!$social['facebook'])
			return false;
		$_SESSION['oauth']['facebook']['authorized'] = (isset($_SESSION['oauth']['facebook']['authorized'])) ? $_SESSION['oauth']['facebook']['authorized'] : FALSE;
		if ($_SESSION['oauth']['facebook']['authorized']===true)	
			return false;
		xoops_loadLanguage('blocks', 'profile');
		return array('display' => ($_SESSION['oauth']['facebook']['authorized']===false?true:false));		
	}
	
	function b_profile_facebook_block_signin_edit($options) {
		
	}
	
?>