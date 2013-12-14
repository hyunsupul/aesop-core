<?php

class AesopCoreNextPageBtn {

	function __construct(){
		add_filter('mce_buttons',array($this,'wysiwyg_editor'));
	}

	function wysiwyg_editor($mce_buttons) {
	    $pos = array_search('wp_more',$mce_buttons,true);
	    if ($pos !== false) {
	        $tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
	        $tmp_buttons[] = 'wp_page';
	        $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
	    }
	    return $mce_buttons;
	}

}
new AesopCoreNextPageBtn;
