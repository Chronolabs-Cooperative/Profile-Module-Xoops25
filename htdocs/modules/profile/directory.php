<?php

	include('header.php');

	error_reporting(0);
	$myts =& MyTextSanitizer::getInstance();
	
	$gperm_handler =& xoops_gethandler('groupperm');
	$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
	
	$module_handler =& xoops_gethandler('module');
	$xoModule = $module_handler->getByDirname('profile');
	$modid = $xoModule->getVar('mid');
	
	$op = (isset($_REQUEST['op']))?strtolower($_REQUEST['op']):'directory';
	$fct = (isset($_REQUEST['fct']))?strtolower($_REQUEST['fct']):'list';	
	$groupid = (isset($_GET['groupid'])?intval($_GET['groupid']):0);

	if ($GLOBALS['profileModuleConfig']['htaccess']&&empty($_POST)) {
		$url = XOOPS_URL.'/'.$GLOBALS['profileModuleConfig']['baseurl'].'/directory,'.$op.','.$fct.','.$groupid.$GLOBALS['profileModuleConfig']['endofurl'];
		if (strpos($url, $_SERVER['REQUEST_URI'])==0) {
			header( "HTTP/1.1 301 Moved Permanently" ); 
			header('Location: '.$url);
			exit(0);
		}
	}
	
	if ($groupid>0)
		if (!$gperm_handler->checkRight('view_group', $groupid, $groups, $modid)) {
			redirect_header(XOOPS_URL, 10, _NOPERM);
			exit(0);
		}
	
	$xoopsOption['template_main'] = 'profile_directory_index.html';
	
	include(XOOPS_ROOT_PATH."/header.php");
	if (file_exists($GLOBALS['xoops']->path('modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))) {
		$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css', array('type'=>'text/css'));
	} else { 
		$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . $GLOBALS['profileModule']->getVar('dirname', 'n') . '/language/english/style.css', array('type'=>'text/css'));
	}
	
	global $profileModuleConfig, $xoopsUser;
			
	$group_handler =& xoops_gethandler('group');
	$directory = array();
	$groups_obj = $group_handler->getObjects(NULL, true, true);
	
	foreach($profileModuleConfig['groups'] as $id => $group)
	{
		$group_array = array();
		$group_array['id'] = $group;
		$desc = $groups_obj[$group]->getVar('description');
		$group_array['title'] = $groups_obj[$group]->getVar('name') . (!empty($desc)?' - ' . $desc:'');
		if ($gperm_handler->checkRight('view_group',$group,$groups, $modid))
			$directory['groups'][] = $group_array;
	}
	
	
	switch ($op) {
	case "search":
	
		$member_handler =& xoops_gethandler('member');
		$user_handler =& xoops_gethandler('user');
		$profile_handler =& xoops_getmodulehandler('profile', 'profile');
		$fields_handler =& xoops_getmodulehandler('field', 'profile');

		$fields = $fields_handler->loadFieldsloadFields();
		$fieldnames = $fields_handler->getUserVars();

		$criteria = new Criteria($_POST['field'], '%'.$_POST['term'].'%', 'LIKE');
		if (!in_array($_POST['field'], $fieldnames)){
			$users = $profile_handler->getObjects($criteria, true);
		} else {			
			$users = $user_handler->getObjects($criteria, true);
		}

		foreach($users as $uid => $user)
		{
			$item = array();
			$userobj = $user_handler->get($uid);
			$name = $userobj->getVar('name');
			if ($name=='')
				$name = $userobj->getVar('uname');
			if ($GLOBALS['profileModuleConfig']['profilesel'])
				$item['link'] = XOOPS_URL.'/userinfo.php?uid='.$uid;		
			$class=($class=='odd')?'even':'odd';
			$item['class'] = $class;		
			
			$profileobj = $profile_handler->get($uid);
			$j=0;
			foreach(profile_getfields() as $id => $field)
			{	
				$j++;
				if ($field['field']=='user_avatar') {
					if ($userobj->getVar('user_avatar'))
						$item['fields'][$j]['image'] = XOOPS_URL.'/uploads/'.$userobj->getVar('user_avatar');				
				} elseif ($field['field']=='name') {
					$item['fields'][$j]['text'] = $name;
				} elseif (!in_array($field['field'], $fieldnames)){
					$item['fields'][$j]['text'] = $profileobj->getVar($field['field']);
				} else {			
					$item['fields'][$j]['text'] = $userobj->getVar($field['field']);
				}
			}
			$items++;
			$directory['items'][$items] = $item;
		}


		break;
	case "directory":
	default:
		switch ($groupid)
		{
			default:
				
				$member_handler =& xoops_gethandler('member');
				$user_handler =& xoops_gethandler('user');
				$profile_handler =& xoops_getmodulehandler('profile', 'profile');
				$fields_handler =& xoops_getmodulehandler('field', 'profile');
						
				$fields = $fields_handler->loadFieldsloadFields();
				$fieldnames = $fields_handler->getUserVars();
		
				$users = $member_handler->getUsersByGroupLink(array($groupid), NULL, true, true);
				$class='odd';
				foreach($users as $uid => $user)
				{
					$item = array();
					$userobj = $user_handler->get($uid);
					$name = $userobj->getVar('name');
					if ($name=='')
						$name = $userobj->getVar('uname');
					if ($GLOBALS['profileModuleConfig']['profilesel'])
						$item['link'] = XOOPS_URL.'/userinfo.php?uid='.$uid;		
					$class=($class=='odd')?'even':'odd';
					$item['class'] = $class;		
					
					$profileobj = $profile_handler->get($uid);
					$j=0;
					foreach(profile_getfields() as $id => $field)
					{	
						$j++;
						if ($field['field']=='user_avatar') {
							if ($userobj->getVar('user_avatar'))
								$item['fields'][$j]['image'] = XOOPS_URL.'/uploads/'.$userobj->getVar('user_avatar');				
						} elseif ($field['field']=='name') {
							$item['fields'][$j]['text'] = $name;
						} elseif (!in_array($field['field'], $fieldnames)){
							$item['fields'][$j]['text'] = $profileobj->getVar($field['field']);
						} else {			
							$item['fields'][$j]['text'] = $userobj->getVar($field['field']);
						}
					}
					if (is_array($item['fields'][$j]['text']))
						$item['fields'][$j]['text'] = implode(', ', $item['fields'][$j]['text']);
						
					$items++;
					$directory['items'][$items] = $item;
				}
		}
		break;
	}
		
	foreach(profile_getfields() as $id => $field)
	{	
		if (!in_array($field['field'], $fieldnames)){
			if (defined('_PROFILE_LANG_'.strtoupper($field['field'])))
				$directory['fieldtitle'][] = constant('_PROFILE_LANG_'.strtoupper($field['field']));
			else
				$directory['fieldtitle'][] = 'define <strong>'.'_PROFILE_LANG_'.strtoupper($field['field']).'</strong>';				
		} else {
			if (defined('_PROFILE_LANG_'.strtoupper($field['field'])))
				$directory['fieldtitle'][] = constant('_PROFILE_LANG_'.strtoupper($field['field']));
			else
				$directory['fieldtitle'][] = 'define <strong>'.'_PROFILE_LANG_'.strtoupper($field['field']).'</strong>';				
		}
	
	}
	
	$directory['title'] = $GLOBALS['profileModuleConfig']['directory_title'];
	$directory['description'] = $GLOBALS['profileModuleConfig']['directory_description'];				
	$directory['searchform'] = profile_directory_search();
	$GLOBALS['xoopsTpl']->assign('directory', $directory);
	include(XOOPS_ROOT_PATH."/footer.php");	

?>
