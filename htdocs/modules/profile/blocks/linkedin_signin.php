<?php

	function b_profile_linkedin_block_signin_show($options) {
		include_once($GLOBALS['xoops']->path('/modules/profile/include/functions.php'));
		$social = profile_social_supported();
		if (!$social['linkedin'])
			return false;
		$_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
		if ($_SESSION['oauth']['linkedin']['authorized']===true)	
			return false;
		xoops_loadLanguage('blocks', 'profile');
		return array('display' => ($_SESSION['oauth']['linkedin']['authorized']===false?true:false));		
	}
	
	function b_profile_linkedin_block_signin_edit($options) {
		
	}
	
?>