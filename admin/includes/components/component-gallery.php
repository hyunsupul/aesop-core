<?php
/**
 * Filters custom meta box class to add cusotm meta to gallery component
 *
 * @since    1.0.0
 */
class AesopGalleryComponentAdmin {

	public function __construct() {

	    // Gallery custom post type registration has been moved to Aesop_Core
		//add_action( 'init',          array( $this, 'do_type' ) );
		add_filter( 'manage_ai_galleries_posts_columns',   array( $this, 'col_head' ) );
		add_action( 'manage_ai_galleries_posts_custom_column',  array( $this, 'col_content' ), 10, 2 );

		// new
		add_action( 'admin_head',        array( $this, 'gallery_box_assets' ) );
		add_action( 'add_meta_boxes',        array( $this, 'new_gallery_box' ) );
		add_action( 'save_post',        array( $this, 'save_gallery_box' ), 10, 2 );

		// admin notice for upgrading
		// removed notice
		//add_action( 'admin_notices',        array( $this, 'upgrade_galleries_notice' ) );
		add_action( 'wp_ajax_upgrade_galleries',     array( $this, 'upgrade_galleries' ) );
		add_action( 'admin_head',        array( $this, 'upgrade_click_handle' ) );
	}
	

	/**
	 * Adds columns to the Aesop Galleries custom post type
	 * Adds the shortcode for easy copy and paste
	 * Adds the posts that the shortcode is used in
	 *
	 * @since    1.0.0
	 */
	public function col_head( $defaults ) {
		$defaults['aesop_gallery'] = __( 'Gallery Code', 'aesop-core' );
		$defaults['used_in'] = __( 'Used In', 'aesop-core' );
		return $defaults;
	}

	/**
	 * Callback for col_head
	 * Lists the posts that contain the specific gallery
	 *
	 * @since    1.
	 */
	public function col_content( $column_name, $post_ID ) {

		if ( 'aesop_gallery' == $column_name ) {
			printf( '[aesop_gallery id="%s"]', $post_ID );
		}

		if ( 'used_in' == $column_name ) {

			$pages = get_posts( array ( 's' => '[aesop_gallery id="'.$post_ID.'"', 'post_type' => array ( 'page', 'post' ) ) );

			$count = 0;

			if ( $pages ) :
				foreach ( $pages as $page ) {

					$count ++;

					if ( has_shortcode( $page->post_content , 'aesop_gallery' ) ) {

						echo '<a href="'.get_edit_post_link( $page->ID ).'" title="Edit" >'.$page->post_title.'</a>';

						if ( $count != count( $pages ) ) {
							echo  ', ';
						}
					}
				}
			endif;

		}//end if
	}

	/**
	 * Load the assets that we need for the gallery meta
	 *
	 * @since 1.4
	 */
	public function gallery_box_assets() {

		if ( 'ai_galleries' == get_current_screen()->id ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
	}
	/**
	 * New metabox to better manage images within galleries
	 *
	 * @since 1.4
	 */
	public function new_gallery_box() {

		// images
		add_meta_box( 'ase_gallery_component', __( 'Add Images', 'aesop-core' ), array( $this, 'render_gallery_box' ), 'ai_galleries', 'normal', 'core' );

		// layout
		add_meta_box( 'ase_gallery_layout', __( 'Select Layout', 'aesop-core' ), array( $this, 'render_layout_box' ), 'ai_galleries', 'normal', 'core' );

		// global options
		add_meta_box( 'ase_gallery_options', __( 'Set Options', 'aesop-core' ), array( $this, 'render_options_box' ), 'ai_galleries', 'normal', 'core' );

	}

	/**
	 * Render meta box used for the gallery
	 *
	 * @param WP_Post $post The post object.
	 * @since 1.4
	 *
	 */
	public function render_gallery_box( $post ) {

		echo '<div class="aesop-gallery-data" style="display: hidden;">';
		wp_nonce_field( 'ase_gallery_meta', 'ase_gallery_meta_nonce' );
		echo '</div>';

		// get the existing images for this post prior to 1.4, else get the IDs set into post meta for 1.4	
		$get_image_ids  = get_post_meta( $post->ID, '_ase_gallery_images', true );
		$image_ids   = explode( ',', $get_image_ids );


		echo '<a id="ase-gallery-add-image" class="ase-gallery-image-placeholder button-primary"><i class="dashicons dashicons-plus">Add Images</i></a>';

		echo '<ul id="ase-gallery-images">';

		if ( ! empty( $get_image_ids ) ):
			foreach ( $image_ids as $image_id ):

				$image    = wp_get_attachment_image_src( $image_id, 'thumbnail', false );

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
	 * Draw the metabox used to pick the layout of the gallery
	 *
	 * @param WP_Post $post The post object.
	 * @since 1.4
	 */
	public function render_layout_box( $post ) {

		$type = get_post_meta( $post->ID, 'aesop_gallery_type', true );

?>

      	<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="grid" <?php checked( $type, 'grid' ); ?> ><?php _e( 'Grid', 'aesop-core' );?></label>
        <label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="thumbnail" <?php checked( $type, 'thumbnail' ); ?> ><?php _e( 'Thumbnail', 'aesop-core' );?></label>
		<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="sequence" <?php checked( $type, 'sequence' ); ?> >Sequence</label>
		<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="photoset" <?php checked( $type, 'photoset' ); ?> ><?php _e( 'Photoset', 'aesop-core' );?></label>
		<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="stacked" <?php checked( $type, 'stacked' ); ?> ><?php _e( 'Parallax', 'aesop-core' );?></label>
		<label class="ase-gallery-layout-label"><input class="ase-gallery-type-radio" type="radio" name="aesop_gallery_type" value="hero" <?php checked( $type, 'hero' ); ?> ><?php _e( 'Hero', 'aesop-core' );?></label>
 
		
        <?php do_action( 'aesop_add_gallery_type' );

	}

	/**
	 * Draw the metabox used to pick the layout of the gallery
	 *
	 * @param WP_Post $post The post object.
	 * @since 1.4
	 */
	public function render_options_box( $post ) {

		$id    = $post->ID;

		// global
		$width    = get_post_meta( $id, 'aesop_gallery_width', true );
		$caption   = get_post_meta( $id, 'aesop_gallery_caption', true );

		// grid
		$grid_item_width = get_post_meta( $id, 'aesop_grid_gallery_width', true );
		$aesop_lightbox_text = get_post_meta( $id, 'aesop_lightbox_text', true );

		// thumbnail
		$thumb_trans  = get_post_meta( $id, 'aesop_thumb_gallery_transition', true );
		$thumb_speed  = get_post_meta( $id, 'aesop_thumb_gallery_transition_speed', true );
		$thumb_hide  = get_post_meta( $id, 'aesop_thumb_gallery_hide_thumbs', true );
		
		//sequence
		$sequence_panorama = get_post_meta( $id, 'aesop_sequence_gallery_panorama', true );
		$sequence_panorama_height = get_post_meta( $id, 'aesop_sequence_gallery_panorama_height', true ) ;
		$sequence_panorama_height = $sequence_panorama_height ? $sequence_panorama_height: 500;

		// photoset
		$photoset_layout = get_post_meta( $id, 'aesop_photoset_gallery_layout', true );
		$photoset_lb   = get_post_meta( $id, 'aesop_photoset_gallery_lightbox', true );
		
		//parallax
		$parallax_mobile_panorama = get_post_meta( $id, 'aesop_parallax_gallery_mobile_panorama', true );
		
		//hero
		$hero_content = get_post_meta( $id, 'aesop_hero_gallery_content', true );
		$hero_width_to_height_ratio = get_post_meta( $id, 'aesop_hero_gallery_height', true );
		$hero_trans  = get_post_meta( $id, 'aesop_hero_gallery_transition', true );
		// if hero option is not set use the thumb gallery option
		$hero_trans  = $hero_trans ? $hero_trans: $thumb_trans;
		$hero_speed  = get_post_meta( $id, 'aesop_hero_gallery_transition_speed', true );
		$hero_speed  = $hero_speed ? $hero_speed: $thumb_speed;
		$hero_anim_speed  = get_post_meta( $id, 'aesop_hero_gallery_transition_anim_speed', true );
		$hero_anim_speed  = $hero_anim_speed ? $hero_anim_speed: 1500;
		$hero_enable_nav  = get_post_meta( $id, 'aesop_hero_gallery_enable_nav', true );
		$hero_enable_full  = get_post_meta( $id, 'aesop_hero_gallery_enable_full', true );
		$aesop_hero_image_text = get_post_meta( $id, 'aesop_hero_image_text', true );

?>
		<div class="ase-gallery-opts--global">

			<div class="ase-gallery-opts--single">
				<label for="aesop_gallery_width"><?php _e( 'Main Gallery Width', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Adjust the overall width of the grid/thumbnail gallery. Acceptable values include 500px, 50%, 100% etc', 'aesop-core' );?></p>
				<input type="text" name="aesop_gallery_width" value="<?php echo esc_html( $width );?>">
			</div>
			<div class="ase-gallery-opts--single">
				<label for="aesop_gallery_caption"><?php _e( 'Gallery Caption', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Add an optional caption for the gallery.', 'aesop-core' );?></p>
				<textarea name="aesop_gallery_caption"><?php echo  $caption ;?></textarea>
			</div>

		</div>
		<div class="ase-gallery-opts ase-gallery-opts--grid" style="display:none;">
			<h3><?php _e( 'Grid Options', 'aesop-core' );?></h3>

			<div class="ase-gallery-opts--single">
				<label for="aesop_grid_gallery_width"><?php _e( 'Grid Gallery Width', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Adjust the width of the individual grid items, only if using Grid gallery style. Default is 400.', 'aesop-core' );?></p>
				<input type="text" name="aesop_grid_gallery_width" value="<?php echo (int) $grid_item_width;?>">
			</div>
			
			<div class="ase-gallery-opts--single">
				<label for="aesop_lightbox_text"><?php _e( 'Lightbox Text', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Text to display when the lightbox is open. The texts are read from the image property.', 'aesop-core' );?></p>
			   	<select name="aesop_lightbox_text">
			      <option value="title" <?php selected( $aesop_lightbox_text, 'title' ); ?>><?php _e( 'Title', 'aesop-core' );?></option>
			      <option value="caption" <?php selected( $aesop_lightbox_text, 'caption' ); ?>><?php _e( 'Caption', 'aesop-core' );?></option>
			      <option value="title_caption" <?php selected( $aesop_lightbox_text, 'title_caption' ); ?>><?php _e( 'Title+Caption', 'aesop-core' );?></option>
				  <option value="description" <?php selected( $aesop_lightbox_text, 'description' ); ?>><?php _e( 'Description', 'aesop-core' );?></option>
				  <option value="none" <?php selected( $aesop_lightbox_text, 'none' ); ?>><?php _e( 'None', 'aesop-core' );?></option>
			    </select>
			</div>
			

		</div>
		<div class="ase-gallery-opts ase-gallery-opts--thumb" style="display:none;">
			<h3><?php _e( 'Thumbnail Options', 'aesop-core' );?></h3>

			<div class="ase-gallery-opts--single">
				<label for="aesop_thumb_gallery_transition"><?php _e( 'Gallery Transition', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Adjust the transition effect for the Thumbnail gallery. Default is slide.', 'aesop-core' );?></p>
			   	<select name="aesop_thumb_gallery_transition">
			      <option value="crossfade" <?php selected( $thumb_trans, 'fade' ); ?>><?php _e( 'Fade', 'aesop-core' );?></option>
			      <option value="slide" <?php selected( $thumb_trans, 'slide' ); ?>><?php _e( 'Slide', 'aesop-core' );?></option>
			      <option value="dissolve" <?php selected( $thumb_trans, 'dissolve' ); ?>><?php _e( 'Dissolve', 'aesop-core' );?></option>
			    </select>
			</div>

			<div class="ase-gallery-opts--single">
				<label for="aesop_thumb_gallery_transition_speed"><?php _e( 'Gallery Transition Speed', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Activate slideshow by setting a speed for the transition.5000 = 5 seconds.', 'aesop-core' );?></p>
				<input type="text" name="aesop_thumb_gallery_transition_speed" value="<?php echo (int) $thumb_speed;?>">
			</div>

			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_thumb_gallery_hide_thumbs" <?php if ( $thumb_hide == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_thumb_gallery_hide_thumbs"><?php _e( 'Hide Gallery Thumbnails', 'aesop-core' );?></label>
			</div>

		</div>
		<div class="ase-gallery-opts ase-gallery-opts--sequence" style="display:none;">
			<h3><?php _e( 'Sequence Gallery Options', 'aesop-core' );?></h3>


			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_sequence_gallery_panorama" <?php if ( $sequence_panorama == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_sequence_gallery_panorama"><?php _e( 'Panorama Mode', 'aesop-core' );?></label>
			</div>
			<div class="ase-gallery-opts--single">
				<label for="aesop_sequence_gallery_panorama_height"><?php _e( 'Panorama Height', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Used Only When the Panorama Mode is On. Height of Each Panorama in Pixels.', 'aesop-core' );?></p>
				<input type="text" name="aesop_sequence_gallery_panorama_height" value="<?php echo (int) $sequence_panorama_height;?>">
			</div>

		</div>
		<div class="ase-gallery-opts ase-gallery-opts--photoset" style="display:none;">
			<h3><?php _e( 'Photoset Options', 'aesop-core' );?></h3>

			<div class="ase-gallery-opts--single">
				<label for="aesop-photoset-gallery-layout"><?php _e( 'Gallery Layout', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Let\'s say you have 4 images in this gallery. If you enter 121 you will have one image on the top row, two images on the second row, and one image on the third row.', 'aesop-core' );?></p>
				<input type="text" name="aesop_photoset_gallery_layout" value="<?php echo (int) $photoset_layout;?>">
			</div>

			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_photoset_gallery_lightbox" <?php if ( $photoset_lb == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_photoset_gallery_lightbox"><?php _e( 'Enable Lightbox', 'aesop-core' );?></label>
			</div>

			<div class="ase-gallery-opts--single">
				<label for="aesop_lightbox_text"><?php _e( 'Lightbox Text', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Text to display when the lightbox is open. The texts are read from the image property.', 'aesop-core' );?></p>
			   	<select name="aesop_lightbox_text">
			      <option value="title" <?php selected( $aesop_lightbox_text, 'title' ); ?>><?php _e( 'Title', 'aesop-core' );?></option>
			      <option value="caption" <?php selected( $aesop_lightbox_text, 'caption' ); ?>><?php _e( 'Caption', 'aesop-core' );?></option>
			      <option value="title_caption" <?php selected( $aesop_lightbox_text, 'title_caption' ); ?>><?php _e( 'Title+Caption', 'aesop-core' );?></option>
				  <option value="description" <?php selected( $aesop_lightbox_text, 'description' ); ?>><?php _e( 'Description', 'aesop-core' );?></option>
				  <option value="none" <?php selected( $aesop_lightbox_text, 'none' ); ?>><?php _e( 'None', 'aesop-core' );?></option>
			    </select>
			</div>

		</div>

		<div class="ase-gallery-opts ase-gallery-opts--parallax" style="display:none;">
			<h3><?php _e( 'Parallax Gallery Options', 'aesop-core' );?></h3>


			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_parallax_gallery_mobile_panorama" <?php if ( $parallax_mobile_panorama == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_parallax_gallery_mobile_panorama"><?php _e( 'Panorama Mode for Mobile', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Use Panorama Images for Mobile Devices', 'aesop-core' );?></p>

			</div>

		</div>
		
	    <div class="ase-gallery-opts ase-gallery-opts--hero" style="display: none;">
			<h3><?php _e( 'Hero Options', 'aesop-core' );?></h3>

			<div class="ase-gallery-opts--single" style="padding-top:20px">
				<label for="aesop_hero_gallery_transition"><?php _e( 'Gallery Transition', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Adjust the transition effect for the Hero gallery. Default is fade.', 'aesop-core' );?></p>
			   	<select name="aesop_hero_gallery_transition">
			      <option value="crossfade" <?php selected( $hero_trans, 'fade' ); ?>><?php _e( 'Fade', 'aesop-core' );?></option>
			      <option value="slide" <?php selected( $hero_trans, 'slide' ); ?>><?php _e( 'Slide', 'aesop-core' );?></option>
			      <option value="dissolve" <?php selected( $hero_trans, 'dissolve' ); ?>><?php _e( 'Dissolve', 'aesop-core' );?></option>
			    </select>
			</div>
			
			<div class="ase-gallery-opts--single" style="padding-top:20px">
				<label for="aesop_hero_gallery_transition_speed"><?php _e( 'Gallery Transition Speed', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Activate slideshow by setting a speed for the transition. 5000 = 5 seconds.', 'aesop-core' );?></p>
				<input type="text" name="aesop_hero_gallery_transition_speed" value="<?php echo (int) $hero_speed ? $hero_speed : 3000;?>">
			</div>
			
			<div class="ase-gallery-opts--single" style="padding-top:20px;">
				<label for="aesop_hero_gallery_content"><?php _e( 'Gallery Content', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Content displayed within the Hero gallery. You can use HTML tags with classes and styles.', 'aesop-core' );?></p>
				<textarea name="aesop_hero_gallery_content" style="width:90%;padding-right:20px;"><?php echo $hero_content; ?></textarea>
			</div>
			
			<div class="ase-gallery-opts--single" style="padding-top:20px">
				<label for="aesop_hero_gallery_height"><?php _e( 'Main Gallery Height', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Specify this if you want to control the height of the gallery. Acceptable values include 500px, 50%, 100% etc.', 'aesop-core' );?></p>
				<p class="aesop-gallery-opts--desc"><?php _e( 'If you enter a ratio, such as 800/600, the gallery would appear with a constant width/height ratio. This is useful if you want the galery to be responsive on mobile devices on portrait modes.', 'aesop-core' );?></p>
				<input type="text" name="aesop_hero_gallery_height" value="<?php echo $hero_width_to_height_ratio;?>">
			</div>
			
			<div class="ase-gallery-opts--single">
				<label for="aesop_hero_image_text"><?php _e( 'Image Text', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Text to display with each image. The texts are read from the image property.', 'aesop-core' );?></p>
			   	<select name="aesop_hero_image_text">
				  <option value="none" <?php selected( $aesop_hero_image_text, 'none' ); ?>><?php _e( 'None', 'aesop-core' );?></option>
			      <option value="title" <?php selected( $aesop_hero_image_text, 'title' ); ?>><?php _e( 'Title', 'aesop-core' );?></option>
			      <option value="caption" <?php selected( $aesop_hero_image_text, 'caption' ); ?>><?php _e( 'Caption', 'aesop-core' );?></option>
			      <option value="title_caption" <?php selected( $aesop_hero_image_text, 'title_caption' ); ?>><?php _e( 'Title+Caption', 'aesop-core' );?></option>
				  <option value="description" <?php selected( $aesop_hero_image_text, 'description' ); ?>><?php _e( 'Description', 'aesop-core' );?></option>
			    </select>
			</div>
			
			<div class="ase-gallery-opts--single" style="padding-top:20px">
				<label for="aesop_hero_gallery_transition_anim_speed"><?php _e( 'Gallery Transition Animation Speed', 'aesop-core' );?></label>
				<p class="aesop-gallery-opts--desc"><?php _e( 'Animation duration for transition in milliseconds.', 'aesop-core' );?></p>
				<input type="text" name="aesop_hero_gallery_transition_anim_speed" value="<?php echo (int) $hero_anim_speed ? $hero_anim_speed : 1500;?>">
			</div>

			
			
			
			
			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_hero_gallery_enable_nav" <?php if ( $hero_enable_nav == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_hero_gallery_enable_nav"><?php _e( 'Enable Navigation Controls', 'aesop-core' );?></label>
			</div>
			
			<div style="margin-top:30px"></div>
			<div class="ase-gallery-opts--single">
				<input type="checkbox" name="aesop_hero_gallery_enable_full" <?php if ( $hero_enable_full == true ) { ?>checked="checked"<?php } ?>>
				<label for="aesop_hero_gallery_enable_full"><?php _e( 'Enable Full Screen', 'aesop-core' );?></label>
			</div>
		</div>
		<?php

	}

	/**
	 *  Save the meta when the post is saved.
	 *
	 * @param integer $post_id The ID of the post being saved.
	 * @param post    $post    the post
	 * @since 1.4
	 *
	 */
	public function save_gallery_box( $post_id, $post ) {

		// if nonce not set bail
		if ( ! isset( $_POST['ase_gallery_meta_nonce'] ) ) {
			return $post_id; }

		$nonce = $_POST['ase_gallery_meta_nonce'];
		$slug = 'ai_galleries';

		// check nonce, auto save, and make sure we're in our galleries psot type
		if ( ! wp_verify_nonce( $nonce, 'ase_gallery_meta' ) || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || $slug != $post->post_type ) {
			return $post_id; }

		// gallery ids
		$gallery_ids   = isset( $_POST['ase_gallery_ids'] ) ? urldecode( $_POST['ase_gallery_ids'] ) : false;

		$type    = isset( $_POST['aesop_gallery_type'] ) ? $_POST['aesop_gallery_type'] : 'grid';

		// global
		$width    = isset( $_POST['aesop_gallery_width'] ) ? $_POST['aesop_gallery_width'] : false;
		$caption   = isset( $_POST['aesop_gallery_caption'] ) ? $_POST['aesop_gallery_caption'] : false;

		// grid
		$grid_item_width = isset( $_POST['aesop_grid_gallery_width'] ) ? $_POST['aesop_grid_gallery_width'] : false;
		$aesop_lightbox_text = isset( $_POST['aesop_lightbox_text'] ) ? $_POST['aesop_lightbox_text'] : false;

		// thumbnail
		$thumb_trans  = isset( $_POST['aesop_thumb_gallery_transition'] ) ? $_POST['aesop_thumb_gallery_transition'] : false;
		$thumb_speed  = isset( $_POST['aesop_thumb_gallery_transition_speed'] ) ? $_POST['aesop_thumb_gallery_transition_speed'] : false;
		$thumb_hide  = isset( $_POST['aesop_thumb_gallery_hide_thumbs'] ) ? $_POST['aesop_thumb_gallery_hide_thumbs'] : false;
		
		// sequence
		$sequence_panorama   = isset( $_POST['aesop_sequence_gallery_panorama'] ) ? $_POST['aesop_sequence_gallery_panorama'] : false;
		$sequence_panorama_height   = isset( $_POST['aesop_sequence_gallery_panorama_height'] ) ? $_POST['aesop_sequence_gallery_panorama_height'] : false;



		// photoset
		$photoset_layout = isset( $_POST['aesop_photoset_gallery_layout'] ) ? $_POST['aesop_photoset_gallery_layout'] : false;
		$photoset_lb   = isset( $_POST['aesop_photoset_gallery_lightbox'] ) ? $_POST['aesop_photoset_gallery_lightbox'] : false;
		
		// parallax
		$parallax_mobile_panorama   = isset( $_POST['aesop_parallax_gallery_mobile_panorama'] ) ? $_POST['aesop_parallax_gallery_mobile_panorama'] : false;

		// hero
		$hero_content = isset( $_POST['aesop_hero_gallery_content'] ) ? $_POST['aesop_hero_gallery_content'] : false;
		$hero_width_to_height_ratio = isset( $_POST['aesop_hero_gallery_height'] ) ? $_POST['aesop_hero_gallery_height'] : false;
        $hero_speed  = isset( $_POST['aesop_hero_gallery_transition_speed'] ) ? $_POST['aesop_hero_gallery_transition_speed'] : false;
		$hero_anim_speed  = isset( $_POST['aesop_hero_gallery_transition_anim_speed'] ) ? $_POST['aesop_hero_gallery_transition_anim_speed'] : false;
        $hero_trans  = isset( $_POST['aesop_hero_gallery_transition'] ) ? $_POST['aesop_hero_gallery_transition'] : false;
		$hero_enable_nav   = isset( $_POST['aesop_hero_gallery_enable_nav'] ) ? $_POST['aesop_hero_gallery_enable_nav'] : false;
		$hero_enable_full   = isset( $_POST['aesop_hero_gallery_enable_full'] ) ? $_POST['aesop_hero_gallery_enable_full'] : false;
		$aesop_hero_image_text = isset( $_POST['aesop_hero_image_text'] ) ? $_POST['aesop_hero_image_text'] : 'none';
	

		// safe to proceed
		delete_post_meta( $post_id, '_ase_gallery_images' );

		// gallery ids
		update_post_meta( $post_id, '_ase_gallery_images', $gallery_ids );

		// update gallery type
		update_post_meta( $post_id, 'aesop_gallery_type', sanitize_text_field( trim( $type ) ) );

		// global
		$allowed_html = array(
		  'a' => array(
			'href' => array(),
		  )
		);
		$caption = wp_kses( $caption, $allowed_html );
		update_post_meta( $post_id, 'aesop_gallery_width', sanitize_text_field( $width ) );
		update_post_meta( $post_id, 'aesop_gallery_caption', $caption  );

		// grid
		update_post_meta( $post_id, 'aesop_grid_gallery_width', absint( $grid_item_width ) );
		update_post_meta( $post_id, 'aesop_lightbox_text', $aesop_lightbox_text );

		// thumbnail
		update_post_meta( $post_id, 'aesop_thumb_gallery_transition', sanitize_text_field( $thumb_trans ) );
		update_post_meta( $post_id, 'aesop_thumb_gallery_transition_speed', absint( $thumb_speed ) );
		update_post_meta( $post_id, 'aesop_thumb_gallery_hide_thumbs', $thumb_hide );
		
		// sequence
		update_post_meta( $post_id, 'aesop_sequence_gallery_panorama', $sequence_panorama );
		update_post_meta( $post_id, 'aesop_sequence_gallery_panorama_height', $sequence_panorama_height );

		// photoset
		update_post_meta( $post_id, 'aesop_photoset_gallery_layout', absint( $photoset_layout ) );
		update_post_meta( $post_id, 'aesop_photoset_gallery_lightbox', $photoset_lb );
		
		// parallax
		update_post_meta( $post_id, 'aesop_parallax_gallery_mobile_panorama', $parallax_mobile_panorama );
		
		// hero width_to_height_ratio
		update_post_meta( $post_id, 'aesop_hero_gallery_content', aesop_component_media_filter( $hero_content ) );
		update_post_meta( $post_id, 'aesop_hero_gallery_height',  sanitize_text_field($hero_width_to_height_ratio) );
        update_post_meta( $post_id, 'aesop_hero_gallery_transition_speed', absint( $hero_speed ) );
		update_post_meta( $post_id, 'aesop_hero_gallery_transition_anim_speed', absint( $hero_anim_speed ) );
        update_post_meta( $post_id, 'aesop_hero_gallery_transition', sanitize_text_field( $hero_trans ) );
		update_post_meta( $post_id, 'aesop_hero_gallery_enable_nav', sanitize_text_field( $hero_enable_nav ) );
		update_post_meta( $post_id, 'aesop_hero_gallery_enable_full', sanitize_text_field( $hero_enable_full ) );
		update_post_meta( $post_id, 'aesop_hero_image_text', $aesop_hero_image_text );
	

	}


	/**
	 * Map the old galleries to post meta
	 *
	 * @since 1.4
	 */
	/*public function upgrade_galleries_notice() {

		// only run if we have markers and have never upgraded
		if ( ! get_option( 'ase_galleries_upgraded_to' ) && 'true' == self::aesop_check_for_galleries() && current_user_can('manage_options') ) {

			$out = '<div class="error aesop-notice"><p>';


			$out .= '</p></div>';

			echo $out;

		}
	}*/

	/**
	 * When the user starts the upgrade process let's run a function to map the old gallery ids to psot meta
	 *
	 * @since 1.4
	 */
	public function upgrade_galleries() {

		check_ajax_referer( 'aesop-galleries-upgrade', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// get the posts with the maps shortode
		$posts = get_posts( array( 'post_type' => array( 'ai_galleries' ), 'posts_per_page' => -1 ) );

		if ( $posts ) :
			foreach ( $posts as $post ) {

				$id = $post->ID;

				$old_image_ids   = get_post_gallery( $id, false );
				$old_image_ids   = $old_image_ids['ids'];

				if ( ! empty ( $old_image_ids ) ) {
					add_post_meta( $id, '_ase_gallery_images', $old_image_ids );
				}
			}
		endif;

		update_option( 'ase_galleries_upgraded_to', AI_CORE_VERSION );

		echo __( 'All done!', 'aesop-core' );

		exit;

	}
	/**
	 * Handles the click function for upgrading the old gallery ids to post meta
	 *
	 * @since 1.3
	 */
	public function upgrade_click_handle() {

		$nonce = wp_create_nonce( 'aesop-galleries-upgrade' );

		// only run if we have galleries and haven't yet upgraded
		if ( get_option( 'ase_galleries_upgraded_to' ) < AI_CORE_VERSION && 'true' == self::aesop_check_for_galleries() ) { ?>
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
		<?php }//end if
	}

	/**
	 * Check to see if any galleries exist
	 *
	 * @since 1.4
	 * @return string true if galleries exist, false if not
	 */
	public function aesop_check_for_galleries() {

		$galleries = get_posts( array( 'post_type' => array( 'ai_galleries' ) ) );

		if ( $galleries ) :
			$return = 'true';
		else :
			$return = 'false';
		endif;

		return $return;

	}

}
new AesopGalleryComponentAdmin;
