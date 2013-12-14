<?php
/**
 	* Filters custom meta box class to add cusotm meta to map component
 	*
 	* @since    1.0.0
*/
class AesopGalleryComponentAdmin {

	public function __construct(){

       	add_action('init',array($this,'do_type'));
       	add_filter('manage_ai_galleries_posts_columns', array($this,'col_head'));
		add_action('manage_ai_galleries_posts_custom_column', array($this,'col_content'), 10, 2);
	}

	function do_type() {

		$labels = array(
			'name'                		=> _x( 'Aesop Galleries', 'Post Type General Name', 'space-boxes' ),
			'singular_name'       		=> _x( 'Gallery', 'Post Type Singular Name', 'space-boxes' ),
			'menu_name'           		=> __( 'Aesop Galleries', 'space-boxes' ),
			'parent_item_colon'   		=> __( 'Parent Gallery:', 'space-boxes' ),
			'all_items'           		=> __( 'All Galleries', 'space-boxes' ),
			'view_item'           		=> __( 'View Gallery', 'space-boxes' ),
			'add_new_item'        		=> __( 'Add New Gallery', 'space-boxes' ),
			'add_new'             		=> __( 'New Gallery', 'space-boxes' ),
			'edit_item'           		=> __( 'Edit Gallery', 'space-boxes' ),
			'update_item'         		=> __( 'Update Gallery', 'space-boxes' ),
			'search_items'        		=> __( 'Search Galleries', 'space-boxes' ),
			'not_found'           		=> __( 'No Galleries found', 'space-boxes' ),
			'not_found_in_trash'  		=> __( 'No Galleries found in Trash', 'space-boxes' ),
		);
		$args = array(
			'label'               		=> __( 'Aesop Galleries', 'space-boxes' ),
			'description'         		=> __( 'Create responsive boxes', 'space-boxes' ),
			'menu_icon' 		  		=> AI_CORE_DIR.'/icon.png',  // Icon Path
			'labels'              		=> $labels,
			'supports'            		=> array( 'title', 'editor', ),
			'hierarchical'        		=> false,
			'public'              		=> false,
 			'show_ui' 					=> true,
			'exclude_from_search'		=> false,
			'query_var' 				=> true,
			'can_export' 				=> true,
		);
		register_post_type( 'ai_galleries', $args );

	}
	function col_head($defaults) {
	    $defaults['aesop_galleries'] = __('Galleries Shortcode','space-boxes');
	    return $defaults;
	}

	function col_content($column_name, $post_ID) {
	    if ($column_name == 'aesop_galleries') {
	        printf('[aesop_galleries id="%s"]',$post_ID);
	    }
	}
}
new AesopGalleryComponentAdmin;