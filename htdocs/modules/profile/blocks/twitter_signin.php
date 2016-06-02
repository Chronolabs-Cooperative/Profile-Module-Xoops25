<?php

	function b_profile_twitter_block_signin_show($options) {
		include_once($GLOBALS['xoops']->path('/modules/profile/include/functions.php'));
		$social = profile_social_supported();
		if (!$social['twitter'])
			return false;
		$_SESSION['oauth']['twitter']['authorized'] = (isset($_SESSION['oauth']['twitter']['authorized'])) ? $_SESSION['oauth']['twitter']['authorized'] : FALSE;
		if ($_SESSION['oauth']['twitter']['authorized']===true)	
			return false;
		xoops_loadLanguage('blocks', 'profile');
		return array('display' => ($_SESSION['oauth']['twitter']['authorized']===false?true:false));		
	}
	
	function b_profile_twitter_block_signin_edit($options) {
		
	}
	
?>