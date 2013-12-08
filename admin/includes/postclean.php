<?php

class aiCorePostScreenClean {

	public function __construct(){

		add_action( 'do_meta_boxes', array($this,'replace_category_box'));
		add_action('admin_menu', array($this,'remove_tag_box'));

	}

	/**
	 * Change Category to Collections
	 */

	function replace_category_box()  {
	    remove_meta_box( 'categorydiv', 'post', 'side' );
	    add_meta_box('categorydiv', __('Collections'), 'post_categories_meta_box', 'post', 'side', 'low');
	}


	function remove_tag_box() {

	    remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' );

	}

}
new aiCorePostScreenClean;

