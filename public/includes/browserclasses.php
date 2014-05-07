<?php
/**
 	* 	Apply body classes based on device
 	*
 	* 	@since    1.0.0
 	*	@return    $classes
 */
class AesopBrowserClasses {

	function __construct() {

		add_filter('body_class',		array($this,'browser_body_class'));
	}

	// add conditional statements for mobile devices
	function is_ipad() {
		$is_ipad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
		if ($is_ipad)
			return true;
		else return false;
	}

	function is_silk_kindle(){
		$user_agent = trim(strtolower($_SERVER['HTTP_USER_AGENT']));
		if( strrpos( $user_agent,'silk/' ) != false && strrpos(  $user_agent,'silk-accelerated=' ) != false )
			return true;
		else return false;
	}
	function is_iphone() {
		$cn_is_iphone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
		if ($cn_is_iphone)
			return true;
		else return false;
	}
	function is_ipod() {
		$cn_is_iphone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPod');
		if ($cn_is_iphone)
			return true;
		else return false;
	}
	function is_ios() {
		if ($this->is_iphone() || $this->is_ipad() || $this->is_ipod())
			return true;
		else return false;
	}
	/*
	function is_android() { // detect ALL android devices
		$is_android = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
		if ($is_android)
			return true;
		else return false;
	}
	function is_android_mobile() { // detect ALL android devices
		$is_android   = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
		$is_android_m = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile');
		if ($is_android && $is_android_m)
			return true;
		else return false;
	}
	function is_android_tablet() { // detect android tablets
		if (is_android() && !is_android_mobile())
			return true;
		else return false;
	}
	*/
	function is_mobile_device() { // detect ALL mobile devices
		if ( is_iphone() || is_ipod() )
			return true;
		else return false;
	}
	function is_tablet() { // detect ALL tablets
		if ( is_ipad() || is_silk_kindle() )
			return true;
		else return false;
	}
	function browser_body_class($classes) {

		global $is_gecko, $is_IE, $is_opera, $is_safari, $is_chrome, $is_iphone;
		if(!wp_is_mobile()) {
			if($is_gecko) $classes[] = 'browser-gecko';
			elseif($is_opera) $classes[] = 'browser-opera';
			elseif($is_safari) $classes[] = 'browser-safari';
			elseif($is_chrome) $classes[] = 'browser-chrome';
	        elseif($is_IE) {
	            $classes[] = 'browser-ie';
	            if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
	            $classes[] = 'ie-version-'.$browser_version[1];
	        }
			else $classes[] = 'browser-unknown';
		} else {
	    	if($this->is_iphone()) $classes[] = 'browser-iphone';
	        elseif($this->is_ipad()) $classes[] = 'browser-ipad';
	        elseif($this->is_ipod()) $classes[] = 'browser-ipod';
	        //elseif($this->is_android()) $classes[] = 'browser-android';
	        elseif($this->is_tablet()) $classes[] = 'device-tablet';
	        elseif($this->is_mobile_device()) $classes[] = 'device-mobile';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false) $classes[] = 'browser-kindle';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false) $classes[] = 'browser-blackberry';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false) $classes[] = 'browser-opera-mini';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) $classes[] = 'browser-opera-mobi';
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== false) $classes[] = 'os-windows';
	        //elseif($this->is_android()) $classes[] = 'os-android';
	        elseif($this->is_ios()) $classes[] = 'os-ios';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== false) $classes[] = 'os-mac';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== false) $classes[] = 'os-linux';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false) $classes[] = 'os-kindle';
	        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false) $classes[] = 'os-blackberry';
		return $classes;

	    $classes[] = 'aesop-core';

	    return $classes;

	}

}

new AesopBrowserClasses;