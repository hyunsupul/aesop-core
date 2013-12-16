<?php

class aiCorePostScreenClean {

	public function __construct(){

		add_action( 'do_meta_boxes', array($this,'replace_category_box'));
		add_action('admin_menu', array($this,'remove_tag_box'));
		add_filter( 'manage_edit-post_columns', array($this,'my_columns_filter'), 10, 1 );

	}

	/**
	 	* Change Category to Collections
	*/

	function replace_category_box()  {
	    remove_meta_box( 'categorydiv', 'post', 'side' );
	    add_meta_box('categorydiv', __('Collections'), 'post_categories_meta_box', 'post', 'side', 'low');
	}

	/**
	 	*  Remove tags box from post screen
	 	*  Remove featured image from pages
	*/
	function remove_tag_box() {

	    remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' );

	    // remove our "featured image story cover" from pages
	    remove_post_type_support( 'page', 'thumbnail' );
	}

	/**
	 	* Remove tags column from posts edit screen
	*/
	function my_columns_filter( $columns ) {

	    unset($columns['tags']);

	    return $columns;
	}

}
new aiCorePostScreenClean;

