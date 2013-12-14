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
			'name'                		=> _x( 'Aesop Galleries', 'Post Type General Name', 'aesop-core' ),
			'singular_name'       		=> _x( 'Gallery', 'Post Type Singular Name', 'aesop-core' ),
			'menu_name'           		=> __( 'Aesop Galleries', 'aesop-core' ),
			'parent_item_colon'   		=> __( 'Parent Gallery:', 'aesop-core' ),
			'all_items'           		=> __( 'All Galleries', 'aesop-core' ),
			'view_item'           		=> __( 'View Gallery', 'aesop-core' ),
			'add_new_item'        		=> __( 'Add New Gallery', 'aesop-core' ),
			'add_new'             		=> __( 'New Gallery', 'aesop-core' ),
			'edit_item'           		=> __( 'Edit Gallery', 'aesop-core' ),
			'update_item'         		=> __( 'Update Gallery', 'aesop-core' ),
			'search_items'        		=> __( 'Search Galleries', 'aesop-core' ),
			'not_found'           		=> __( 'No Galleries found', 'aesop-core' ),
			'not_found_in_trash'  		=> __( 'No Galleries found in Trash', 'aesop-core' ),
		);
		$args = array(
			'label'               		=> __( 'Aesop Galleries', 'aesop-core' ),
			'description'         		=> __( 'Create responsive boxes', 'aesop-core' ),
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
	    $defaults['aesop_gallery'] = __('Gallery Shortcode','aesop-core');
	    return $defaults;
	}

	function col_content($column_name, $post_ID) {
	    if ($column_name == 'aesop_gallery') {
	        printf('[aesop_gallery id="%s"]',$post_ID);
	    }
	}
}
new AesopGalleryComponentAdmin;