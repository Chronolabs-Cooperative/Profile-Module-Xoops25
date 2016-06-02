<?php

	xoops_load('xoopscache');
	
	function profile_social_supported() {
		$ret = array();
		if (!empty($GLOBALS['profileModuleConfig']['linkedin_app_key'])&&!empty($GLOBALS['profileModuleConfig']['linkedin_app_secret']))
			$ret['linkedin'] = true;
		else 
			$ret['linkedin'] = false;
		if (!empty($GLOBALS['profileModuleConfig']['twitter_app_key'])&&!empty($GLOBALS['profileModuleConfig']['twitter_app_secret']))
			$ret['twitter'] = true;
		else 
			$ret['twitter'] = false;
		if (!empty($GLOBALS['profileModuleConfig']['facebook_app_id'])&&!empty($GLOBALS['profileModuleConfig']['facebook_app_secret']))
			$ret['facebook'] = true;
		else 
			$ret['facebook'] = false;
		return $ret;
	}
	
	function profile_getfields()
	{
		if (!$fields = XoopsCache::read($GLOBALS['profileModule']->getVar('dirname').'_fields')) {
			if (!$fields = XoopsCache::read($GLOBALS['profileModule']->getVar('dirname').'_fields_cache')) {
				$fields = array();
				foreach($GLOBALS['profileModuleConfig']['display'] as $id => $field)	{
					$fields[$id]['weight'] = 1;
					$fields[$id]['field'] = $field;	
				}	
				XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields', $fields, 8000);
				XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields_cache', $fields, 8000*1000);
				XoopsCache::write($GLOBALS['profileModule']->getVar('dirname').'_fields', $fields, 8000);
				XoopsCache::write($GLOBALS['profileModule']->getVar('dirname').'_fields_cache', $fields, 8000*1000);
			} else {
				XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields', $fields, 8000);
				XoopsCache::delete($GLOBALS['profileModule']->getVar('dirname').'_fields_cache', $fields, 8000*1000);
				XoopsCache::write($GLOBALS['profileModule']->getVar('dirname').'_fields', $fields, 8000);
				XoopsCache::write($GLOBALS['profileModule']->getVar('dirname').'_fields_cache', $fields, 8000*1000);
			}
		}
		return $fields;	
	}
	
	function profile_get_curl($url) {
		$ch 		= curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER,	 	$header);
		curl_setopt($ch, CURLOPT_USERAGENT,		 	$GLOBALS['profileModuleConfig']['user_agent']);
		curl_setopt($ch, CURLOPT_URL, 			 	$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 	true);
		curl_setopt($ch, CURLOPT_HEADER, 		 	true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 	$GLOBALS['profileModuleConfig']['curl_ssl_verify']);
		curl_setopt($ch, CURLOPT_VERBOSE, 			$GLOBALS['profileModuleConfig']['curl_verbose']);
		curl_setopt($ch, CURLOPT_TIMEOUT, 		 	$GLOBALS['profileModuleConfig']['curl_timeout']);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 	$GLOBALS['profileModuleConfig']['curl_connection_timeout']);
		$txt = curl_exec($ch);
		if ($txt === false) {
			$error = curl_error($ch);
			curl_close($ch);
			throw new OAuthException2('CURL error: ' . $error);
		} 
		curl_close($ch);
		return $txt;
	}
	
	function profile_orderfields($fields, $fieldnamelist = false) {
		$weights = array();
		foreach($fields as $id => $field){
			$weights[] = $field['weight'];
		}
		$weights = array_unique($weights);
		sort($weights);
		$ret = array();
		foreach($weights as $id => $weight) {
			foreach($fields as $id => $field){
				if ($field['weight'] == $weight) {
					if ($fieldnamelist==false)
						$ret[] = $field;	
					else
						$ret[] = $field['field'];							
				}
			}
		}
		return $ret;	
	}

	function profile_adminMenu ($page, $currentoption = 0)  {
		$module_handler = xoops_gethandler('module');
		$GLOBALS['profileModule'] = $module_handler->getByDirname('profile');
		  /* Nice buttons styles */
		echo "
	    	<style type='text/css'>
			#form {float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$GLOBALS['profileModule']->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;}
			 	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
	    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$GLOBALS['profileModule']->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 0px; border-bottom: 1px solid black; }
	    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
			  #buttonbar li { display:inline; margin:0; padding:0; }
			  #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/".$GLOBALS['profileModule']->getVar('dirname')."/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px;  text-decoration:none; }
			  #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/".$GLOBALS['profileModule']->getVar('dirname')."/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
			  /* Commented Backslash Hack hides rule from IE5-Mac \*/
			  #buttonbar a span {float:none;}
			  /* End IE5-Mac hack */
			  #buttonbar a:hover span { color:#333; }
			  #buttonbar #current a { background-position:0 -150px; border-width:0; }
			  #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
			  #buttonbar a:hover { background-position:0% -150px; }
			  #buttonbar a:hover span { background-position:100% -150px; }
			  </style>";
		
		$myts = &MyTextSanitizer::getInstance();
		$tblColors = Array();
		if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$GLOBALS['profileModule']->getVar('dirname').'/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php')) {
			include_once XOOPS_ROOT_PATH . '/modules/'.$GLOBALS['profileModule']->getVar('dirname').'/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php';
		} else {
			include_once XOOPS_ROOT_PATH . '/modules/'.$GLOBALS['profileModule']->getVar('dirname').'/language/english/modinfo.php';
		}
		echo "<div id='buttontop'>";
		echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
		echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $GLOBALS['profileModule']->getVar('mid') . "\">" . _PREFERENCES . "</a></td>";
		echo "<td style='font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>" . $myts->displayTarea($GLOBALS['profileModule']->name()) ."</td>";
		echo "</tr></table>";
		echo "</div>";
		echo "<div id='buttonbar'>";
		echo "<ul>";
		foreach ($GLOBALS['profileModule']->getAdminMenu() as $key => $value) {
			$tblColors[$key] = '';
			$tblColors[$currentoption] = 'current';
		  	echo "<li id='" . $tblColors[$key] . "'><a href=\"" . XOOPS_URL . "/modules/".$GLOBALS['profileModule']->getVar('dirname')."/".$value['link']."\"><span>" . $value['title'] . "</span></a></li>";
		}
			 
		echo "</ul></div>";
		echo "<div id='navigation' style=\"clear:both;height:48px;\">";
		$indexAdmin = new ModuleAdmin();
		echo $indexAdmin->addNavigation($page);
		echo "</div>";
	  	
 	}
  
	function profile_footer_adminMenu()
	{
		echo "<div align=\"center\"><a href=\"http://www.xoops.org\" target=\"_blank\"><img src=" . XOOPS_URL . '/' . $GLOBALS['profileModule']->getInfo('icons32') . '/xoopsmicrobutton.gif'.' '." alt='XOOPS' title='XOOPS'></a></div>";
		echo "<div class='center smallsmall italic pad5'><strong>" . $GLOBALS['profileModule']->getVar("name") . "</strong> is maintained by the <a class='tooltip' rel='external' href='http://www.xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a> and <a class='tooltip' rel='external' href='http://www.chronolabs.coop/' title='Visit Chronolabs Co-op'>Chronolabs Co-op</a></div>";
	}
	
	function profile_getIP() {
	    $ip = $_SERVER['REMOTE_ADDR'];
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    return $ip;
	}

	if (!function_exists("profile_object2array")) {
		function profile_object2array($objects) {
			$ret = array();
			foreach((array)$objects as $key => $value) {
				if (is_object($value)) {
					$ret[$key] = profile_object2array($value);
				} elseif (is_array($value)) {
					$ret[$key] = profile_object2array($value);
				} else {
					$ret[$key] = $value;
				}
			}
			return $ret;
		}
	}

	if (!function_exists("profile_getandwrite")) {
		function profile_getandwrite($url, $writepathfile) {
			$module_handler = xoops_gethandler('module');
			$config_handler = xoops_gethandler('config');
			if (!isset($GLOBALS['profileModule']))
				$GLOBALS['profileModule'] = $module_handler->getByDirname('profile');
			if (!isset($GLOBALS['profileModuleConfig']))
				$GLOBALS['profileModuleConfig'] = $config_handler->getConfigList($GLOBALS['profileModule']->getVar('mid'));
		
			$data = profile_get_curl($url); 
			
			// Clears Existing Data
			if (file_exists($writepathfile)) {
				unlink($writepathfile);
			}
			// Writes file
			$file = fopen($writepathfile, 'w+');
			fwrite($file, $data, strlen($data));
			fclose($file);
			
			return true;
		}
	}
?>