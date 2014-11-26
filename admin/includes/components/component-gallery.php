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
		add_action( 'admin_head',								array($this,'gallery_box_assets'));
		add_action( 'add_meta_boxes', 							array($this,'new_gallery_box') );
		add_action( 'save_post',								array($this,'save_gallery_box'), 10, 3 );


		// admin notice for upgrading
		add_action( 'admin_notices', 					array($this, 'upgrade_galleries_notice' ) );
		add_action( 'wp_ajax_upgrade_galleries', 		array($this, 'upgrade_galleries' ));
		add_action( 'admin_head',						array($this, 'upgrade_click_handle'));
	
		add_action( 'wp_ajax_ase_update_gallery', 		array($this, 'ase_update_gallery' ));
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
			'supports'            		=> array( 'title' ),
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
	*	Load the assets that we need for the gallery meta
	*	
	*	@since 1.4
	*/
	function gallery_box_assets(){

		if ( 'ai_galleries' == get_current_screen()->id ) {
			wp_enqueue_script('jquery-ui-sortable');
		}
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

		$ajax_nonce = wp_create_nonce('ase-update-gallery');

		echo '<div class="aesop-gallery-data" style="display: hidden;">';
			wp_nonce_field( 'ase_gallery_meta', 'ase_gallery_meta_nonce' );
		echo '</div>';

		// get the existing images for this post prior to 1.4, else get the id's set into post meta for 1.4
		if ( AI_CORE_VERSION < 1.4 ) {
			$get_image_ids 	= get_post_gallery( $post->ID, false);
			$image_ids 		= explode(',', $get_image_ids['ids']);
		} else {
			$get_image_ids 	= get_post_meta( $post->ID,'_ase_gallery_images', true);
			$image_ids 		= explode( ',', $get_image_ids );
		}

		?>
		<script>
			jQuery(document).ready(function($){

				var image 	= $('.ase-gallery-image'),
					gallery = $('#ase-gallery-images');

				$(image).on('click', 'i', function(){
					$(this).parent().remove();
					$(gallery).sortable('refresh');
				});

				$(gallery).sortable({
					containment: 'parent',
					cursor: 'move',
					opacity:0.8,
					update: function() {

					    var imageArray = $(this).sortable('toArray', { attribute: 'id' });

					    var data = {
					        action: 'ase_update_gallery',
					        nonce: '<?php echo $ajax_nonce;?>',
					        image_list: imageArray
					    };

					    $.ajax({
					        type: "POST",
					        url: ajaxurl,
					        data: data,
					        success: function(response) {
					        	console.log(response);
					        }
					    });
					}

				});
			});
		</script>
		<?php

		echo '<ul id="ase-gallery-images">';
			// loop through and display the images
			if ( !empty( $get_image_ids ) ):

				foreach ($image_ids as $image_id):

		            $image    =  wp_get_attachment_image_src($image_id, 'thumbnail', false);

		        	?>
		        	<li id="<?php echo $image_id;?>" class="ase-gallery-image">
		        		<i class="dashicons dashicons-no-alt"></i>
		           		<img src="<?php echo $image[0];?>">
		           	</li>
		           	<?php

				endforeach;

			else:

				echo '<a href="#">Add Images</a>';

			endif;

		echo '</ul>';

	}

	/**
	*
	*	Process fired on image sort used in render_gallery_box above
	*	@since 1.4
	*/
	function ase_update_gallery(){

		check_ajax_referer('ase-update-gallery','nonce');

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'ase_update_gallery' ) {

			var_dump($_POST);

		}

		exit();

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

	/**
	*
	*
	*	Map the old galleries to post meta
	*
	*	@since 1.4
	*/
	function upgrade_galleries_notice(){

		// only run if we have markers and have never upgraded
		//if ( get_option('ase_galleries_upgraded_to') < AI_CORE_VERSION && 'true' == self::aesop_check_for_galleries() ) {

			$out = '<div class="error"><p>';

			$out .= __( 'Welcome to Aesop Story Engine 1.4. We need to upgrade any galleries that you might have. Click <a id="aesop-upgrade-galleries" href="#">here</a> to start the upgrade process.', 'aesop-core' );

			$out .= '</p></div>';

			echo $out;

		//}
	}

	/**
	*
	*	When the user starts the upgrade process let's run a function to map the old gallery ids to psot meta
	*
	*	@since 1.4
	*/
	function upgrade_galleries(){

		check_ajax_referer( 'aesop-galleries-upgrade', 'security' );

		// get the posts with the maps shortode
		$posts = get_posts( array( 'post_type' => array('ai_galleries'), 'posts_per_page' => -1 ) );

		if ( $posts ) :
			foreach( $posts as $post ) {

				$id = $post->ID;

				$old_image_ids 		= get_post_gallery( $id, false);
				$old_image_ids 		= $old_image_ids['ids'];

				if ( ! empty ( $old_image_ids ) ) {
					add_post_meta( $id, '_ase_gallery_images', $old_image_ids );
				}
			}
		endif;

		echo 'ajax-success';

		exit;

	}
	/**
	*
	*	Handles the click function for upgrading the old gallery ids to post meta
	*
	*	@since 1.3
	*/
	function upgrade_click_handle(){

		$nonce = wp_create_nonce('aesop-galleries-upgrade');

		// only run if we have galleries and haven't yet upgraded
		//if ( get_option('ase_upgraded_to') < AI_CORE_VERSION && 'true' == self::aesop_check_for_galleries() ) { ?>
			<!-- Aesop Upgrade Galleries -->
			<script>
				jQuery(document).ready(function(){
				  	jQuery('#aesop-upgrade-galleries').click(function(e){

				  		e.preventDefault();

				  		var data = {
				            action: 'upgrade_galleries',
				            security: '<?php echo $nonce;?>'
				        };

					  	jQuery.post(ajaxurl, data, function(response) {
					  		if( response ){
					        	//location.reload();
					        	alert(response);
					  		}
					    });

				    });
				});
			</script>
		<?php // }
	}

	/**
	*
	*	Check to see if any galleries exist
	*
	*	@since 1.4
	*	@return bool true if galleries exist, false if not
	*/
	function aesop_check_for_galleries(){

		$galleries = get_posts( array( 'post_type' => array('ai_galleries'), 'posts_per_page' => -1 ) );

		if ( $galleries ) :
			$return = 'true';
		else:
			$return = 'false';
		endif;

		return $return;

	}

}
new AesopGalleryComponentAdmin;