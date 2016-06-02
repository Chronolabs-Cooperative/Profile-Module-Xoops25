<?php

	function b_profile_all_block_signin_show($options) {
		include_once($GLOBALS['xoops']->path('/modules/profile/include/functions.php'));
		$social = profile_social_supported();
		$_SESSION['oauth']['twitter']['authorized'] = (isset($_SESSION['oauth']['twitter']['authorized'])) ? $_SESSION['oauth']['twitter']['authorized'] : FALSE;
		if ($_SESSION['oauth']['twitter']['authorized']===true)	
			$social['twitter']=false;
		$_SESSION['oauth']['facebook']['authorized'] = (isset($_SESSION['oauth']['facebook']['authorized'])) ? $_SESSION['oauth']['facebook']['authorized'] : FALSE;
		if ($_SESSION['oauth']['facebook']['authorized']===true)	
			$social['facebook']=false;
		$_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
		if ($_SESSION['oauth']['linkedin']['authorized']===true)	
			$social['linkedin']=false;
		xoops_loadLanguage('blocks', 'profile');
		return array_merge($social, array('display' => ($social['linkedin']===true||$social['facebook']===true||$social['twitter']===true?true:false)));		
	}
	
	function b_profile_all_block_signin_edit($options) {
		
	}
	
?>