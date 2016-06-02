<?php

	include ('header.php');
	
	if (!is_object($GLOBALS['xoopsUser']))
	{
		redirect_header(XOOPS_URL, 8, _NOPERM);
		exit;
	}
	
	if (strlen($GLOBALS['xoopsUser']->getVar('email'))>0)
	{
		redirect_header(XOOPS_URL, 8, _NOPERM);
		exit;
	}
	$error = '';
	if (!empty($_POST)) {
		if (checkEmail($_POST['email'])) {
			$member_handler = xoops_gethandler('member');
			$GLOBALS['xoopsUser']->setVar('email', $_POST['email']);
			$GLOBALS['xoopsUser']->setVar('pass', md5($pass = xoops_makepass()));
			$member_handler->insertUser($GLOBALS['xoopsUser'], true);
			setcookie($GLOBAL['xoopsConfig']['usercookie'], $GLOBALS['xoopsUser']->getVar('uid') . '-' . md5($GLOBALS['xoopsUser']->getVar('pass') . XOOPS_DB_NAME . XOOPS_DB_PASS . XOOPS_DB_PREFIX), time() + 31536000, '/', XOOPS_COOKIE_DOMAIN, 0);
			xoops_loadLanguage('email', 'profile');
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/profile/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('profile_email_user_created.html');
			$xoopsMailer->setSubject(sprintf(_EMAIL_PROFILE_CREATE_USER,  $GLOBALS['xoopsUser']->getVar('name')));						
			$xoopsMailer->assign("SITEURL", XOOPS_URL);
			$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
			$xoopsMailer->assign("EMAIL", $GLOBALS['xoopsUser']->getVar('email'));
			$xoopsMailer->assign("NAME", $GLOBALS['xoopsUser']->getVar('name'));
			$xoopsMailer->assign("UNAME", $GLOBALS['xoopsUser']->getVar('uname'));						
			$xoopsMailer->assign("PASS", $pass);
			$xoopsMailer->setToEmails(strtolower($_POST['email']));
			$success = $xoopsMailer->send();
			redirect_header(XOOPS_URL.'/modules/profile/userinfo.php', 8, _MN_MSG_EMAIL_SAVED_AND_PASSWORD_SENT);
			exit;
		}
		$error = _MN_MSG_INVALID_EMAIL_ADDRESS;
	}
	
	if ($GLOBALS['profileModuleConfig']['htaccess']&&empty($_POST)) {
		$url = XOOPS_URL.'/'.$GLOBALS['profileModuleConfig']['baseurl'].'/getemail'.$GLOBALS['profileModuleConfig']['endofurl'];
		if (strpos($url, $_SERVER['REQUEST_URI'])==0) {
			header( "HTTP/1.1 301 Moved Permanently" ); 
			header('Location: '.$url);
			exit(0);
		}
	}
	
	$xoopsOption['template_main'] = 'profile_get_email.html';
	include($GLOBALS['xoops']->path('/header.php'));
	if ($error!='') {
		xoops_error($error);
	}
	$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	$GLOBALS['xoopsTpl']->assign('form', profile_get_email());
	include($GLOBALS['xoops']->path('/footer.php'));
	
	?>