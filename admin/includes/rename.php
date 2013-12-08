<?php

class aiCoreStrings {

	public function __construct(){

		add_action( 'admin_menu', 	array($this,'edit_admin_menus' ));
		add_action( 'init', 		array($this,'change_post_labels' ));
		add_filter( 'gettext', 		array($this,'kia_text_strings'), 20, 3 );

	}

	// REname Posts to Stories
	function edit_admin_menus() {

	    global $menu;
	    global $submenu;

	    $menu[5][0] = 'Stories'; // Change Posts to Recipes
	    $submenu['edit.php'][5][0] = 'All Stories';
	    $submenu['edit.php'][10][0] = 'Create a Story';
	    $submenu['edit.php'][15][0] = 'Collections'; // Rename categories to meal types
	    $submenu['edit.php'][16][0] = 'Collection Sets'; // Rename tags to ingredients
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

	function kia_text_strings( $translated_text, $text, $domain ) {

        switch ( $translated_text ) {

            case 'Add New Category' :

                $translated_text = __( 'Add New Collection', 'aesop-core' );
                break;

            case 'All Categories' :

                $translated_text = __( 'All Collections', 'aesop-core' );
                break;

            case 'Categories' :

                $translated_text = __( 'Collections', 'aesop-core' );
                break;
        }

	    return $translated_text;
	}

}
new aiCoreStrings;

