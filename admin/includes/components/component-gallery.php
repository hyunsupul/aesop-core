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

		// new
		add_action( 'admin_head',								array($this,'gallery_box_assets'));
		add_action( 'add_meta_boxes', 							array($this,'new_gallery_box') );
		add_action( 'save_post',								array($this,'save_gallery_box'), 10, 3 );

		// admin notice for upgrading
		add_action( 'admin_notices', 							array($this, 'upgrade_galleries_notice' ) );
		add_action( 'wp_ajax_upgrade_galleries', 				array($this, 'upgrade_galleries' ));
		add_action( 'admin_head',								array($this, 'upgrade_click_handle'));
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

		// images
		add_meta_box('ase_gallery_component',__( 'Add Images', 'aesop-core' ),array($this,'render_gallery_box'), 'ai_galleries','normal','core');

		// layout
		add_meta_box('ase_gallery_layout',__( 'Select Layout', 'aesop-core' ),array($this,'render_layout_box'), 'ai_galleries','normal','core');

		// global options
		add_meta_box('ase_gallery_options',__( 'Set Options', 'aesop-core' ),array($this,'render_options_box'), 'ai_galleries','normal','core');

	}

	/**
	* 	Render meta box used for the gallery
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
		//if ( AI_CORE_VERSION < 1.4 ) {
		if ( false ) {
			$get_image_ids 	= get_post_gallery( $post->ID, false);
			$image_ids 		= explode(',', $get_image_ids['ids']);
		} else {
			$get_image_ids 	= get_post_meta( $post->ID,'_ase_gallery_images', true);
			$image_ids 		= explode( ',', $get_image_ids );
		}

		?>
		<script>
			jQuery(document).ready(function($){

				var	gallery = $('#ase-gallery-images');

				$(document).on('click', '.ase-gallery-image > i.dashicons-no-alt', function(){
					$(this).parent().remove();
					gallery.sortable('refresh');
					ase_encode_gallery_items();
				});

				gallery.sortable({
					containment: 'parent',
					cursor: 'move',
					opacity: 0.8,
					placeholder: 'ase-gallery-drop-zone',
					forcePlaceholderSize:true,
					update: function(){
						var imageArray = $(this).sortable('toArray');
				  	$('#ase_gallery_ids').val( imageArray );
					}
				});

				function ase_string_encode(gData){
					return encodeURIComponent(JSON.stringify(gData));
				}

				function ase_string_decode(gData){
					return JSON.parse(decodeURIComponent(gData));
				}

				function ase_encode_gallery_items(){
					var imageArray = gallery.sortable('toArray');
				  $('#ase_gallery_ids').val( imageArray );
				}

				function ase_insert_gallery_item(id, url){

					var item_html = "<li id='" + id + "' class='ase-gallery-image'><i class='dashicons dashicons-no-alt'></i><i title='Edit Image Caption' class='dashicons dashicons-edit'></i><img src='" + url + "'></li>";
					$('#ase-gallery-images').append( item_html );
					gallery.sortable('refresh');
					ase_encode_gallery_items();
				}

				var ase_media_init = function(selector, button_selector)  {
				    var clicked_button = false;

				    $(selector).each(function (i, input) {
			        var button = $(input).children(button_selector);
			        button.click(function (event) {
		            event.preventDefault();
		            var selected_img;
		            clicked_button = $(this);

		            if(wp.media.frames.ase_frame) {
								  wp.media.frames.ase_frame.open();
								  return;
								}

		            wp.media.frames.ase_frame = wp.media({
							   title: 'Select Aesop Gallery Image',
							   multiple: true,
							   library: {
							      type: 'image'
							   },
							   button: {
							      text: 'Use Selected Images'
							   }
								});

		            var ase_media_set_image = function() {
								    var selection = wp.media.frames.ase_frame.state().get('selection');

								    if (!selection) {
								        return;
								    }

								    selection.each(function(attachment) {
								    	var id = attachment.id;
								    	var url = attachment.attributes.sizes.thumbnail.url;
								    	ase_insert_gallery_item(id, url);
								    });
								};

		            wp.media.frames.ase_frame.on('select', ase_media_set_image);
								wp.media.frames.ase_frame.open();
			       });
				   });
				};

				function ase_edit_gallery_item(id, url, editable){
					var item_html = "<li id='" + id + "' class='ase-gallery-image'><i class='dashicons dashicons-no-alt'></i><i title='Edit Image Caption' class='dashicons dashicons-edit'></i><img src='" + url + "'></li>";
					$(editable).replaceWith( item_html );
					gallery.sortable('refresh');
					ase_encode_gallery_items();
				}

				var ase_media_edit_init = function()  {
			    var clicked_button;

			    $(document).on('click', '.ase-gallery-image > i.dashicons-edit', function(event){
						event.preventDefault();
            var selected_img;
            clicked_button = $(this);

            if(wp.media.frames.ase_edit_frame) {
						  wp.media.frames.ase_edit_frame.open();
						  return;
						}

            wp.media.frames.ase_edit_frame = wp.media({
							title: 'Edit Image',
							multiple: false,
							library: {
							  type: 'image'
							},
							button: {
							  text: 'Update Selected Image'
							}
						});

						var ase_media_edit_image = function() {
					    var selection = wp.media.frames.ase_edit_frame.state().get('selection');

					    if (!selection) {
				        return;
					    }

					    // iterate through selected elements
					    selection.each(function(attachment) {
					    	var id = attachment.id;
					    	var url = attachment.attributes.sizes.thumbnail.url;
					    	ase_edit_gallery_item(id, url, clicked_button.parent());
					    });
						};

            // image selection event
            wp.media.frames.ase_edit_frame.on('select', ase_media_edit_image);
            wp.media.frames.ase_edit_frame.on('open',function(){
						  var selection = wp.media.frames.ase_edit_frame.state().get('selection');
            	attachment = wp.media.attachment( clicked_button.parent().attr('id') );
            	attachment.fetch();
    					selection.add( attachment ? [ attachment ] : [] );
            });
						wp.media.frames.ase_edit_frame.open();
			    });

				};

				ase_media_init('#ase-gallery-add-image', 'i');
				ase_media_edit_init();
				ase_encode_gallery_items();

			});
		</script>
		<?php

		echo '<a id="ase-gallery-add-image" class="ase-gallery-image-placeholder button-primary"><i class="dashicons dashicons-plus">Add Images</i></a>';

		echo '<ul id="ase-gallery-images">';

			if ( !empty( $get_image_ids ) ):
				foreach ($image_ids as $image_id):

		            $image    =  wp_get_attachment_image_src($image_id, 'thumbnail', false);

		        	?>
		        	<li id="<?php echo $image_id;?>" class="ase-gallery-image">
		        		<i class="dashicons dashicons-no-alt" title="Delete From Gallery"></i>
		        		<i class='dashicons dashicons-edit' title="Edit Image Caption"></i>
		           	<img src="<?php echo $image[0];?>">
		          </li>
		          <?php

				endforeach;

			endif;

		echo '</ul>';

		echo '<input type="hidden" id="ase_gallery_ids" name="ase_gallery_ids" value="">';

	}

	/**
	*
	*	Draw the metabox used to pick the layout of the gallery
	*
	*	@param WP_Post $post The post object.
	*	@since 1.4
	*/
	function render_layout_box( $post ) {

		$type = get_post_meta( $post->ID,'aesop_gallery_type', true);

      	?>

      	<script>
	      	jQuery(document).ready(function($){

				var value_check = function( value ){

	      			if ( 'grid' == value ) {
	      				$('.ase-gallery-opts--thumb').fadeOut();
	      				$('.ase-gallery-opts--photoset').fadeOut();
	      				$('.ase-gallery-opts--grid').fadeIn();
	      			} else {
	      				$('.ase-gallery-opts--grid').fadeOut();
	      			}

	      			if ( 'thumbnail' == value ) {
	      				$('.ase-gallery-opts--grid').fadeOut();
	      				$('.ase-gallery-opts--photoset').fadeOut();
	      				$('.ase-gallery-opts--thumb').fadeIn();
	      			} else {
	      				$('.ase-gallery-opts--thumb').fadeOut();
	      			}

	      			if ( 'photoset' == value ) {
	      				$('.ase-gallery-opts--grid').fadeOut();
	      				$('.ase-gallery-opts--thumb').fadeOut();
	      				$('.ase-gallery-opts--photoset').fadeIn();
	      			} else {
	      				$('.ase-gallery-opts--photoset').fadeOut();
	      			}
				}

	      		$('.ase-gallery-type-radio').each(function(){

	      			if ( $(this).is(':checked') ) {
	      				$(this).parent().addClass('selected');
						var value = $(this).val();
			      		value_check(value);

	      			}

	      		});

	      		$('.ase-gallery-layout-label').click(function(){
	      			$('.ase-gallery-layout-label').removeClass('selected');
	      			$(this).addClass('selected');
	      			var value = $(this).find('input').val();
	      			value_check(value);
	      		});

	      	});
      	</script>

      	<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="grid" <?php checked( $type, 'grid' ); ?> ><?php _e('Grid','aesop-core');?></label>
        <label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="thumbnail" <?php checked( $type, 'thumbnail' ); ?> ><?php _e('Thumbnail','aesop-core');?></label>
		<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="sequence" <?php checked( $type, 'sequence' ); ?> >Sequence</label>
		<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="photoset" <?php checked( $type, 'photoset' ); ?> ><?php _e('Photoset','aesop-core');?></label>
		<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="stacked" <?php checked( $type, 'stacked' ); ?> ><?php _e('Parallax','aesop-core');?></label>

        <?php do_action('aesop_add_gallery_type');

	}

	/**
	*
	*	Draw the metabox used to pick the layout of the gallery
	*
	*	@param WP_Post $post The post object.
	*	@since 1.4
	*/
	function render_options_box( $post ) {

		$id 			= $post->ID;

		// global
		$width 			= get_post_meta( $id, 'aesop_gallery_width', true );
		$caption 		= get_post_meta( $id, 'aesop_gallery_caption', true );

		// grid
		$grid_item_width = get_post_meta( $id, 'aesop_grid_gallery_width', true );

		// thumbnail
		$thumb_trans 	= get_post_meta( $id, 'aesop_thumb_gallery_transition', true );
		$thumb_speed 	= get_post_meta( $id, 'aesop_thumb_gallery_transition_speed', true );
		$thumb_hide 	= get_post_meta( $id, 'aesop_thumb_gallery_hide_thumbs', true );

		// photoset
		$photoset_layout = get_post_meta( $id, 'aesop_photoset_gallery_layout', true );
		$photoset_lb 	 = get_post_meta( $id, 'aesop_photoset_gallery_lightbox', true );

		?>
		<div class="ase-gallery-opts--global">

			<div class="ase-gallery-opts--single">
				<label for="aesop_gallery_width"><?php _e('Main Gallery Width','aesop-core');?></label>
				<p class="aesop-gallery-opts--desc"><?php _e('Adjust the overall width of the grid/thumbnail gallery. Acceptable values include 500px or 50%.','aesop-core');?></p>
				<input type="text" name="aesop_gallery_width" value="<?php echo esc_html($width);?>">
			</div>
			<div class="ase-gallery-opts--single">
				<label for="aesop_gallery_caption"><?php _e('Gallery Caption','aesop-core');?></label>
				<p class="aesop-gallery-opts--desc"><?php _e('Add an optional caption for the gallery.','aesop-core');?></p>
				<textarea name="aesop_gallery_caption"><?php echo esc_html($caption);?></textarea>
			</div>

		</div>
		<div class="ase-gallery-opts ase-gallery-opts--grid" style="display:none;">
			<h3><?php _e('Grid Options','aesop-core');?></h3>

			<div class="ase-gallery-opts--single">
				<label for="aesop_grid_gallery_width"><?php _e('Grid Gallery Width','aesop-core');?></label>
				<p class="aesop-gallery-opts--desc"><?php _e('Adjust the width of the individual grid items, only if using Grid gallery style. Default is 400.','aesop-core');?></p>
				<input type="text" name="aesop_grid_gallery_width" value="<?php echo (int) $grid_item_width;?>">
			</div>

		</div>
		<div class="ase-gallery-opts ase-gallery-opts--thumb" style="display:none;">
			<h3><?php _e('Thumbnail Options','aesop-core');?></h3>

			<div class="ase-gallery-opts--single">
				<label for="aesop_thumb_gallery_transition"><?php _e('Gallery Transition','aesop-core');?></label>
				<p class="aesop-gallery-opts--desc"><?php _e('Adjust the transition effect for the Thumbnail gallery. Default is slide.','aesop-core');?></p>
			   	<select name="aesop_thumb_gallery_transition">
			      <option value="crossfade" <?php selected( $thumb_trans, 'fade' ); ?>><?php _e('Fade','aesop-core');?></option>
			      <option value="slide" <?php selected( $thumb_trans, 'slide' ); ?>><?php _e('Slide','aesop-core');?></option>
			      <option value="dissolve" <?php selected( $thumb_trans, 'dissolve' ); ?>><?php _e('Dissolve','aesop-core');?></option>
			    </select>
			</div>

			<div class="ase-gallery-opts--single">
				<label for="aesop_thumb_gallery_transition_speed"><?php _e('Gallery Transition Speed','aesop-core');?></label>
				<p class="aesop-gallery-opts--desc"><?php _e('Activate slideshow by setting a speed for the transition.5000 = 5 seconds.','aesop-core');?></p>
				<input type="text" name="aesop_thumb_gallery_transition_speed" value="<?php echo (int) $thumb_speed;?>">
			</div>

			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_thumb_gallery_hide_thumbs" <?php if( $thumb_hide == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_thumb_gallery_hide_thumbs"><?php _e('Hide Gallery Thumbnails','aesop-core');?></label>
			</div>

		</div>
		<div class="ase-gallery-opts ase-gallery-opts--photoset" style="display:none;">
			<h3><?php _e('Photoset Options','aesop-core');?></h3>

			<div class="ase-gallery-opts--single">
				<label for="aesop-photoset-gallery-layout"><?php _e('Gallery Layout','aesop-core');?></label>
				<p class="aesop-gallery-opts--desc"><?php _e('Let\'s say you have 4 images in this gallery. If you enter 121 you will have one image on the top row, two images on the second row, and one image on the third row.','aesop-core');?></p>
				<input type="text" name="aesop_photoset_gallery_layout" value="<?php echo (int) $photoset_layout;?>">
			</div>

			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_photoset_gallery_lightbox" <?php if( $photoset_lb == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_photoset_gallery_lightbox"><?php _e('Enable Lightbox','aesop-core');?></label>
			</div>

		</div>
		<?php

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

		// gallery ids
		$gallery_ids   = isset( $_POST['ase_gallery_ids'] ) ? urldecode( $_POST['ase_gallery_ids'] ) : false;

		$type 			= isset( $_POST['aesop_gallery_type']) ? $_POST['aesop_gallery_type'] : false;

		// global
		$width 			= isset( $_POST['aesop_gallery_width'] ) ? $_POST['aesop_gallery_width'] : false;
		$caption 		= isset( $_POST['aesop_gallery_caption'] ) ? $_POST['aesop_gallery_caption'] : false;

		// grid
		$grid_item_width = isset( $_POST['aesop_grid_gallery_width'] ) ? $_POST['aesop_grid_gallery_width'] : false;

		// thumbnail
		$thumb_trans 	= isset( $_POST['aesop_thumb_gallery_transition'] ) ? $_POST['aesop_thumb_gallery_transition'] : false;
		$thumb_speed 	= isset( $_POST['aesop_thumb_gallery_transition_speed'] ) ? $_POST['aesop_thumb_gallery_transition_speed'] : false;
		$thumb_hide 	= isset( $_POST['aesop_thumb_gallery_hide_thumbs'] ) ? $_POST['aesop_thumb_gallery_hide_thumbs'] : false;

		// photoset
		$photoset_layout = isset( $_POST['aesop_photoset_gallery_layout'] ) ? $_POST['aesop_photoset_gallery_layout'] : false;
		$photoset_lb 	 = isset( $_POST['aesop_photoset_gallery_lightbox'] ) ? $_POST['aesop_photoset_gallery_lightbox'] : false;

		// safe to proceed
		delete_post_meta( $post_id, '_ase_gallery_images' );


		// gallery ids
		update_post_meta( $post_id, '_ase_gallery_images', $gallery_ids);

		// update gallery type
		update_post_meta( $post_id,'aesop_gallery_type',sanitize_text_field( trim( $type ) ) );

		// global
		update_post_meta( $post_id, 'aesop_gallery_width', sanitize_text_field($width) );
		update_post_meta( $post_id, 'aesop_gallery_caption', sanitize_text_field($caption) );

		// grid
		update_post_meta( $post_id, 'aesop_grid_gallery_width', absint($grid_item_width) );

		// thumbnail
		update_post_meta( $post_id, 'aesop_thumb_gallery_transition', sanitize_text_field($thumb_trans) );
		update_post_meta( $post_id, 'aesop_thumb_gallery_transition_speed', absint($thumb_speed) );
		update_post_meta( $post_id, 'aesop_thumb_gallery_hide_thumbs', $thumb_hide );

		// photoset
		update_post_meta( $post_id, 'aesop_photoset_gallery_layout', absint($photoset_layout) );
		update_post_meta( $post_id, 'aesop_photoset_gallery_lightbox', $photoset_lb );
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
		if ( get_option('ase_galleries_upgraded_to') < AI_CORE_VERSION && 'true' == self::aesop_check_for_galleries() ) {

			$out = '<div class="error"><p>';

			$out .= __( 'Welcome to Aesop Story Engine 1.4. We need to upgrade any galleries that you might have. Click <a id="aesop-upgrade-galleries" href="#">here</a> to start the upgrade process.', 'aesop-core' );

			$out .= '</p></div>';

			echo $out;

		}
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

		update_option( 'ase_galleries_upgraded_to', AI_CORE_VERSION );

		echo __('All done! Reloading page...','aesop-core');

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
		if ( get_option('ase_galleries_upgraded_to') < AI_CORE_VERSION && 'true' == self::aesop_check_for_galleries() ) { ?>
			<!-- Aesop Upgrade Galleries -->
			<script>
				jQuery(document).ready(function($){
				  	jQuery('#aesop-upgrade-galleries').click(function(e){

				  		e.preventDefault();

				  		var data = {
				            action: 'upgrade_galleries',
				            security: '<?php echo $nonce;?>'
				        };

					  	jQuery.post(ajaxurl, data, function(response) {
					  		if( response ){
					        	alert(response);
					        	location.reload();
					  		}
					    });

				    });
				});
			</script>
		<?php }
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