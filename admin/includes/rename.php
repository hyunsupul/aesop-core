<?php

class aiCoreStrings {

	public function __construct(){

		add_action( 'init', 		array($this,'change_post_labels' ));
		add_filter(  'gettext',  array($this,'replace_strings'  ));
		add_filter(  'ngettext',  array($this,'replace_strings'  ));

	}


	/**
	 * Change Post Labels
	 */
	function change_post_labels() {
	  	global $wp_post_types;

	  	// Get the post labels
	  	$postLabels = $wp_post_types['post']->labels;
	  	$postLabels->name = __('Stories','aesop-core');
	  	$postLabels->singular_name = __('Stories','aesop-core');
	  	$postLabels->add_new = __('Add Story','aesop-core');
	  	$postLabels->add_new_item = __('Add Story','aesop-core');
	  	$postLabels->edit_item = __('Edit Story','aesop-core');
	  	$postLabels->new_item = __('Stories','aesop-core');
	  	$postLabels->view_item = __('View Story','aesop-core');
	  	$postLabels->search_items = __('Search Stories','aesop-core');
	  	$postLabels->not_found = __('No Stories found','aesop-core');
	  	$postLabels->not_found_in_trash = __('No Stories found in Trash','aesop-core');
	}


	/**
	 * Change text strings
	 */

	function replace_strings( $translated ) {

        $words = array(
            'Add New Category' => 'Add New Collection',
            'Categories' => 'Collections',
            'category'	=> 'collection',
            'posts'	=> 'stories',
            'post' => 'story',
            'Post' => 'Story',
            'Username'	=> 'Collaborator Name',
            'Users'	=> 'Collaborators',
            'User'	=> 'Collaborator',
            'Add New User' => 'Add New Collaborator', // not working
            'Featured'		=>'Cover',
            'featured'		=> 'cover'

        );

	    $translated = str_ireplace(  array_keys($words),  $words,  $translated );
	    return $translated;
	}

}
new aiCoreStrings;

