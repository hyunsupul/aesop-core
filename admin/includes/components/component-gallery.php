<?php
/**
 	* Filters custom meta box class to add cusotm meta to galelry component
 	*
 	* @since    1.0.0
*/
class AesopGalleryComponentAdmin {

	public function __construct(){

       	add_action('init',										array($this,'do_type'));
       	add_filter('manage_ai_galleries_posts_columns', 		array($this,'col_head'));
		add_action('manage_ai_galleries_posts_custom_column', 	array($this,'col_content'), 10, 2);
		add_filter('cmb_meta_boxes', 							array($this,'aesop_gallery_meta' ));

		// new
		add_action( 'add_meta_boxes', 							array($this,'new_gallery_box') );
		add_action( 'save_post',								array($this,'save_gallery_box'), 10, 3 );
	}


	/**
	 	* Creates an Aesop Galleries custom post type to manage all psot galleries
	 	*
	 	* @since    1.0.0
	*/
	function do_type() {

		$labels = array(
			'name'                		=> _x( 'Galleries','aesop-core' ),
			'singular_name'       		=> _x( 'Gallery','aesop-core' ),
			'menu_name'           		=> __( 'Galleries', 'aesop-core' ),
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
			'label'               		=> __( 'Galleries', 'aesop-core' ),
			'description'         		=> __( 'Create responsive galleries.', 'aesop-core' ),
			'menu_icon' 		  		=> AI_CORE_URL.'/admin/assets/img/icon.png',  // Icon Path
			'menu_position'				=> 15,
			'labels'              		=> $labels,
			'supports'            		=> array( 'title', 'editor' ),
			'hierarchical'        		=> false,
			'public'              		=> false,
 			'show_ui' 					=> true,
			'exclude_from_search'		=> true,
			'query_var' 				=> true,
			'can_export' 				=> true,
			'capability_type' 			=> 'post'
		);

		register_post_type( 'ai_galleries', apply_filters('ai_gallery_args', $args ) );

	}

	/**
	 	* Adds columns to the Aesop Galleries custom post type
	 	* Adds the shortcode for easy copy and past
	 	* Adds the posts that the shortcode is used in
	 	*
	 	* @since    1.0.0
	*/
	function col_head($defaults) {
	    $defaults['aesop_gallery'] = __('Gallery Code','aesop-core');
	    $defaults['used_in'] = __('Used In','aesop-core');
	    return $defaults;
	}

	/**
	 	* Callback for col_head
	 	* Lists the posts that contain the specific gallery
	 	*
	 	* @since    1.
	*/
	function col_content($column_name, $post_ID) {


	    if ('aesop_gallery' == $column_name) {
	        printf('[aesop_gallery id="%s"]',$post_ID);
	    }

	   	if ('used_in' == $column_name) {

			$pages = get_posts(array ('s' => '[aesop_gallery id="'.$post_ID.'"','post_type' => array ( 'page', 'post' ) ));

			$count = 0;

			if ( $pages ) :
				foreach ($pages as $page ) {

					$count ++;

					if ( has_shortcode( $page->post_content ,'aesop_gallery' ) ){

						echo '<a href="'.get_edit_post_link($page->ID).'" title="Edit" >'.$page->post_title.'</a>';

						if( $count != count($pages) ){
							echo  ', ';
						}
					}
				}
			endif;

	    }
	}

	/**
	 	* Adds custom gallery meta
	 	*
	 	* @since    1.0.0
	*/
	function aesop_gallery_meta( array $meta_boxes ) {

		$meta_boxes[] = array(
			'title' 	=> __('Gallery Options', 'aesop-core'),
			'pages' 	=> array('ai_galleries'),
			'fields' 	=> array(
				array(
					'id'             => 'aesop_gallery_width',
					'name'           => __('Main Gallery Width', 'aesop-core'),
					'type'           => 'text',
					'desc'			=> __('Adjust the overall width of the grid/thumbnail gallery. Acceptable values include <code>500px</code> or <code>50%</code>.','aesop-core'),
					'cols'			=> 6
				),
				array(
					'id'             => 'aesop_grid_gallery_width',
					'name'           => __('Gallery Grid Item Width', 'aesop-core'),
					'type'           => 'text',
					'desc'			=> __('Adjust the width of the individual grid items, only if using Grid gallery style.  Default is <code>400</code>.','aesop-core'),
					'cols'			=> 6
				),
				array(
					'id'             => 'aesop_gallery_caption',
					'name'           => __('Gallery Caption (optional)', 'aesop-core'),
					'type'           => 'textarea',
					'desc'			=> __('Add an optional caption for the gallery. ','aesop-core')
				)

			)
		);

		// thumbanil gallery options
		$meta_boxes[] = array(
			'title' 	=> __('Thumbnail Gallery Options', 'aesop-core'),
			'pages' 	=> array('ai_galleries'),
			'fields' 	=> array(
				array(
					'id'             => 'aesop_thumb_gallery_transition',
					'name'           => __('Transition Effect', 'aesop-core'),
					'type'           => 'select',
					'default'		=> 'slide',
					'options'		=> array(
						'slide'			=> __('Slide', 'aesop-core'),
						'crossfade'		=> __('Fade', 'aesop-core'),
						'dissolve'		=> __('Dissolve' , 'aesop-core')
					),
					'desc'			=> __('Adjust the transition effect for the Thumbnail gallery. Default is slide.','aesop-core'),
					'cols'			=> 6
				),
				array(
					'id'             => 'aesop_thumb_gallery_transition_speed',
					'name'           => __('Gallery Transition Speed', 'aesop-core'),
					'type'           => 'text',
					'desc'			=> __('Activate slideshow by setting a speed for the transition.<code>5000</code> = 5 seconds. ','aesop-core'),
					'cols'			=> 6
				),
				array(
					'id'             => 'aesop_thumb_gallery_hide_thumbs',
					'name'           => __('Hide Gallery Thumbnails', 'aesop-core'),
					'type'           => 'checkbox'
				)

			)

		);

		// photoset gallery options
		$meta_boxes[] = array(
			'title' 	=> __('Photoset Gallery Options', 'aesop-core'),
			'pages' 	=> array('ai_galleries'),
			'fields' 	=> array(
				array(
					'id'             => 'aesop_photoset_gallery_layout',
					'name'           => __('Gallery Layout', 'aesop-core'),
					'type'           => 'text_small',
					'default'		=> '',
					'desc'			=> __('Let\'s say you have 4 images in this gallery. If you enter <code>121</code> you will have one image on the top row, two images on the second row, and one image on the third row.','aesop-core')
				),
				array(
					'id'             => 'aesop_photoset_gallery_lightbox',
					'name'           => __('Enable Lightbox', 'aesop-core'),
					'type'           => 'checkbox'
				)

			)

		);
		return $meta_boxes;

	}

	/**
	*
	*
	*	New metabox to better manage images within galleries
	*
	*	@since 1.4
	*/
	function new_gallery_box(){

		add_meta_box('ase_gallery_component',__( 'Gallery Images', 'aesop-core' ),array($this,'render_gallery_box'), 'ai_galleries','normal','core');
	}

	/**
	* 	Render Meta Box content.
	*
	* 	@param WP_Post $post The post object.
	*	@since 1.4
	*
	*/
	function render_gallery_box( $post ){

		echo '<div class="aesop-gallery-data" style="display: hidden;">';
			wp_nonce_field( 'ase_gallery_meta', 'ase_gallery_meta_nonce' );
		echo '</div>';

		echo 'Wassup wassup new gallery stuffs here yo';
	}

	/**
	*
	* 	Save the meta when the post is saved.
	*
	* 	@param int $post_id The ID of the post being saved.
	*	@param post $post the post
	*	@since 1.4
	*
	*/
	function save_gallery_box( $post_id, $post, $update ) {

		// if nonce not set bail
		if ( ! isset( $_POST['ase_gallery_meta_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ase_gallery_meta_nonce'];
		$slug = 'ai_galleries';

		// check nonce, auto save, and make sure we're in our galleries psot type
		if ( !wp_verify_nonce( $nonce, 'ase_gallery_meta' ) || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || $slug != $post->post_type )
			return $post_id;

		// safe to proceed
	}

}
new AesopGalleryComponentAdmin;