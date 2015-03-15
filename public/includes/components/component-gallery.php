<?php
/**
 * Creates a multipurpose gallery that can be shown as thumbnail, grid, gridset, and with lightbox and captions
 *
 * @since    1.0.0
 */

class AesopCoreGallery {

<<<<<<< HEAD
	function __construct(){

		add_shortcode( 'aesop_gallery',  array($this,'aesop_post_gallery') );
=======
	function __construct() {

		add_shortcode( 'aesop_gallery',  array( $this, 'aesop_post_gallery' ) );
>>>>>>> release/1.5.1

	}

	/**
	 * Main gallery component
	 *
	 * @since    1.0.0
	 */
<<<<<<< HEAD
	function aesop_post_gallery($atts, $content = null){
=======
	public function aesop_post_gallery( $atts ) {
>>>>>>> release/1.5.1

		global $post;

		// attributes
<<<<<<< HEAD
		$defaults 	= array('id'	=> '','a_type' => '');
		$atts 		= shortcode_atts( $defaults, $atts );
=======
		$defaults  = array( 'id' => '', 'a_type' => '' );
		$atts   = shortcode_atts( $defaults, $atts );
>>>>>>> release/1.5.1

		// gallery ID
		$gallery_id = isset( $atts['id'] ) ? (int) $atts['id'] : false;

		// alias to new atts type
		// let this be used multiple times
		static $instance = 0;
		$instance++;
<<<<<<< HEAD
		$unique 	= sprintf( '%s-%s', $gallery_id, $instance );

		// get gallery images and custom attrs
		$image_ids 	= get_post_meta( $gallery_id,'_ase_gallery_images', true );
		$image_ids	= array_map( 'intval', explode( ',', $image_ids ) );

		$type 		= get_post_meta( $gallery_id,'aesop_gallery_type', true );
		$width 		= get_post_meta( $gallery_id,'aesop_gallery_width', true );
=======
		$unique  = sprintf( '%s-%s', $gallery_id, $instance );

		// get gallery images and custom attrs
		$image_ids  = get_post_meta( $gallery_id, '_ase_gallery_images', true );
		$image_ids = array_map( 'intval', explode( ',', $image_ids ) );

		$type   = get_post_meta( $gallery_id, 'aesop_gallery_type', true );
		$width   = get_post_meta( $gallery_id, 'aesop_gallery_width', true );
>>>>>>> release/1.5.1

		// gallery caption
		$gallery_caption = get_post_meta( $gallery_id, 'aesop_gallery_caption', true );

		ob_start();

<<<<<<< HEAD
			do_action( 'aesop_gallery_before', $type, $gallery_id ); // action

			?><div id="aesop-gallery-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'gallery', $gallery_id, $atts );?> class="aesop-component aesop-gallery-component aesop-<?php echo esc_attr( $type );?>-gallery-wrap <?php if ( empty( $gallery_id ) ) { echo 'empty-gallery'; }?> "><?php

				do_action( 'aesop_gallery_inside_top', $type, $gallery_id ); // action

		if ( ! empty($image_ids) ) {
=======
		do_action( 'aesop_gallery_before', $type, $gallery_id ); // action

		?><div id="aesop-gallery-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'gallery', $gallery_id, $atts );?> class="aesop-component aesop-gallery-component aesop-<?php echo esc_attr( $type );?>-gallery-wrap <?php if ( empty( $gallery_id ) ) { echo 'empty-gallery'; }?> "><?php

		do_action( 'aesop_gallery_inside_top', $type, $gallery_id ); // action

		if ( ! empty( $image_ids ) ) {
>>>>>>> release/1.5.1

			switch ( $type ) {
				case 'thumbnail':
					$this->aesop_thumb_gallery( $gallery_id, $image_ids, $width );
<<<<<<< HEAD
				break;
=======
					break;
>>>>>>> release/1.5.1
				case 'grid':
					$this->aesop_grid_gallery( $gallery_id, $image_ids, $width );
					break;
				case 'stacked':
<<<<<<< HEAD
					$this->aesop_stacked_gallery( $gallery_id, $image_ids, $width, $unique );
					break;
				case 'sequence':
					$this->aesop_sequence_gallery( $gallery_id, $image_ids, $width );
=======
					$this->aesop_stacked_gallery( $image_ids, $unique );
					break;
				case 'sequence':
					$this->aesop_sequence_gallery( $image_ids );
>>>>>>> release/1.5.1
					break;
				case 'photoset':
					$this->aesop_photoset_gallery( $gallery_id, $image_ids, $width );
					break;
				default:
					$this->aesop_grid_gallery( $gallery_id, $image_ids, $width );
					break;
			}

			if ( $gallery_caption ) {
				printf( '<p class="aesop-component-caption">%s</p>', esc_html( $gallery_caption ) );
			}

			// provide the edit link to the backend edit if Aesop Editor is not active
<<<<<<< HEAD
			if ( ! class_exists( 'Lasso' ) && is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
				$url = admin_url( 'post.php?post='.$gallery_id.'&action=edit' );
				$edit_gallery = __( 'edit gallery', 'aesop-core' );
				printf( '<a class="aesop-gallery-edit aesop-content" href="%s" target="_blank" title="%s">(%s)</a>',$url, $edit_gallery, $edit_gallery );
			}
		}//end if

		if ( empty( $gallery_id ) && is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
=======
			if ( ! class_exists( 'Lasso' ) && is_user_logged_in() && current_user_can( 'edit_post', $gallery_id ) ) {
				$url = admin_url( 'post.php?post='.$gallery_id.'&action=edit' );
				$edit_gallery = __( 'edit gallery', 'aesop-core' );
				printf( '<a class="aesop-gallery-edit aesop-content" href="%s" target="_blank" title="%s">(%s)</a>', $url, $edit_gallery, $edit_gallery );
			}
		}//end if

		if ( empty( $gallery_id ) && is_user_logged_in() && current_user_can( 'edit_post', $gallery_id ) ) {
>>>>>>> release/1.5.1

			if ( class_exists( 'Lasso' ) ) {

				?><div contenteditable="false" class="lasso--empty-component"><?php
<<<<<<< HEAD
					_e( 'Setup a gallery by clicking the <span class="lasso-icon-gear"></span> icon above.', 'aesop-core' );
=======
				_e( 'Setup a gallery by clicking the <span class="lasso-icon-gear"></span> icon above.', 'aesop-core' );
>>>>>>> release/1.5.1
				?></div><?php

			} else {

				?><div class="aesop-error aesop-content"><?php
<<<<<<< HEAD
					_e( 'This gallery is empty! It\'s also possible that you simply have the wrong gallery ID.', 'aesop-core' );
=======
				_e( 'This gallery is empty! It\'s also possible that you simply have the wrong gallery ID.', 'aesop-core' );
>>>>>>> release/1.5.1
				?></div><?php

			}
		}

<<<<<<< HEAD
				do_action( 'aesop_gallery_inside_bottom', $type, $gallery_id ); // action
=======
		do_action( 'aesop_gallery_inside_bottom', $type, $gallery_id ); // action
>>>>>>> release/1.5.1

		?></div><?php

<<<<<<< HEAD
			do_action( 'aesop_gallery_after', $type, $gallery_id ); // action
=======
		do_action( 'aesop_gallery_after', $type, $gallery_id ); // action
>>>>>>> release/1.5.1

		return ob_get_clean();

	}

	/**
	 * Draws a thumbnail gallery using fotorama
	 *
	 * @since    1.0.0
	 */
<<<<<<< HEAD
	function aesop_thumb_gallery($gallery_id, $image_ids, $width){

		$thumbs 	= get_post_meta( $gallery_id, 'aesop_thumb_gallery_hide_thumbs', true ) ? sprintf( 'data-nav=false' ) : sprintf( 'data-nav=thumbs' );
		$autoplay 	= get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true ) ? sprintf( 'data-autoplay="%s"', get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true ) ) : null;
=======
	public function aesop_thumb_gallery( $gallery_id, $image_ids, $width ) {

		$thumbs  = get_post_meta( $gallery_id, 'aesop_thumb_gallery_hide_thumbs', true ) ? sprintf( 'data-nav=false' ) : sprintf( 'data-nav=thumbs' );
		$autoplay  = get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true ) ? sprintf( 'data-autoplay="%s"', get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true ) ) : null;
>>>>>>> release/1.5.1
		$transition = get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition', true ) ? get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition', true ) : 'crossfade';

		// image size
		$size    = apply_filters( 'aesop_thumb_gallery_size', 'full' );

		?><div id="aesop-thumb-gallery-<?php echo esc_attr( $gallery_id );?>" class="fotorama" 	data-transition="<?php echo esc_attr( $transition );?>"
																			data-width="<?php echo esc_attr( $width );?>"
																			<?php echo esc_attr( $autoplay );?>
																			data-keyboard="true"
																			<?php echo esc_attr( $thumbs );?>
																			data-allow-full-screen="native"
																			data-click="true"><?php

<<<<<<< HEAD
																			foreach ( $image_ids as $image_id ):

																				$full    = wp_get_attachment_image_src( $image_id, $size, false );
																				$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
																				$caption 	= get_post( $image_id )->post_excerpt;

				?><img src="<?php echo esc_url( $full[0] );?>" data-caption="<?php echo esc_attr( $caption );?>" alt="<?php echo esc_attr( $alt );?>"><?php
=======
		foreach ( $image_ids as $image_id ):

			$full    = wp_get_attachment_image_src( $image_id, $size, false );
		$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$caption  = get_post( $image_id )->post_excerpt;

		?><img src="<?php echo esc_url( $full[0] );?>" data-caption="<?php echo esc_attr( $caption );?>" alt="<?php echo esc_attr( $alt );?>"><?php
>>>>>>> release/1.5.1

		endforeach;

		?></div><?php
	}

	/**
	 * Draws a grid style gallery using wookmark
	 *
	 * @since    1.0.0
	 */
<<<<<<< HEAD
	function aesop_grid_gallery($gallery_id, $image_ids, $width){
=======
	public function aesop_grid_gallery( $gallery_id, $image_ids, $width ) {
>>>>>>> release/1.5.1

		$gridwidth  = get_post_meta( $gallery_id, 'aesop_grid_gallery_width', true ) ? get_post_meta( $gallery_id, 'aesop_grid_gallery_width', true ) : 400;

		// allow theme developers to determine the spacing between grid items
		$space = apply_filters( 'aesop_grid_gallery_spacing', 5 );
<<<<<<< HEAD

		// image size
		$size    = apply_filters( 'aesop_grid_gallery_size', 'large' );
=======
>>>>>>> release/1.5.1

?>
		<!-- Aesop Grid Gallery -->
		<script>
<<<<<<< HEAD
			jQuery(document).ready(function(){
			    jQuery('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>').imagesLoaded(function() {
			        var options = {
			          	autoResize: true,
			          	container: jQuery('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>'),
			          	offset: <?php echo (int) $space;?>,
			          	flexibleWidth: <?php echo (int) $gridwidth;?>
			        };
			        var handler = jQuery('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?> li');
			        jQuery(handler).wookmark(options);
=======
			jQuery(document).ready(function($){
			    $('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>').imagesLoaded(function() {
			        var options = {
			          	autoResize: true,
			          	container: $('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>'),
			          	offset: <?php echo (int) $space;?>,
			          	flexibleWidth: <?php echo (int) $gridwidth;?>
			        };
			        var handler = $('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?> li');
			        handler.wookmark(options);
>>>>>>> release/1.5.1
			    });
			});
		</script>
		<div id="aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>" class="aesop-grid-gallery aesop-grid-gallery" style="width:100%;max-width:<?php echo esc_attr( $width );?>;margin:0 auto;"><ul><?php
<<<<<<< HEAD

		foreach ( $image_ids as $image_id ):

				$getimage 		= wp_get_attachment_image( $image_id, 'aesop-grid-image', false, array('class' => 'aesop-grid-image') );
				$getimagesrc    = wp_get_attachment_image_src( $image_id, 'full' );
				$img_title 	  	= get_post( $image_id )->post_title;
				$caption 		= get_post( $image_id )->post_excerpt;
=======

		foreach ( $image_ids as $image_id ):
>>>>>>> release/1.5.1

			$getimage   = wp_get_attachment_image( $image_id, 'aesop-grid-image', false, array( 'class' => 'aesop-grid-image' ) );
		$getimagesrc    = wp_get_attachment_image_src( $image_id, 'full' );
		$img_title     = get_post( $image_id )->post_title;
		$caption   = get_post( $image_id )->post_excerpt;

<<<<<<< HEAD
			<li class="aesop-grid-gallery-item"><a class="aesop-lightbox" href="<?php echo $getimagesrc[0];?>" title="<?php echo esc_attr( $img_title );?>">
			<?php if ( $caption ){ ?>
					<span class="aesop-grid-gallery-caption"><?php echo $caption;?></span>
				<?php } ?>
			<span class="clearfix"><?php echo $getimage;?></span></a></li>
=======
?>
>>>>>>> release/1.5.1

				<li class="aesop-grid-gallery-item">
					<a class="aesop-lightbox" href="<?php echo esc_url( $getimagesrc[0] );?>" title="<?php esc_attr_e( $img_title );?>">
						<?php if ( $caption ) { ?>
							<span class="aesop-grid-gallery-caption"><?php echo aesop_component_media_filter( $caption );?></span>
						<?php } ?>
						<span class="clearfix"><?php echo $getimage;?></span>
					</a>
				</li>

				<?php

<<<<<<< HEAD
=======
		endforeach;

>>>>>>> release/1.5.1
		?></ul></div><?php
	}

	/**
	 * Draws a stacked parallax style gallery
	 *
	 * @since    1.0.0
<<<<<<< HEAD
	 */
	function aesop_stacked_gallery( $gallery_id, $image_ids, $width, $unique){

		?>
=======
	 * @param string $unique
	 */
	public function aesop_stacked_gallery( $image_ids, $unique ) {

?>
>>>>>>> release/1.5.1
		<!-- Aesop Stacked Gallery -->
		<script>
		jQuery(document).ready(function($){

			var stackedResizer = function(){
				$('.aesop-stacked-img').css({'height':($(window).height())+'px'});
			}
			stackedResizer();

			$(window).resize(function(){
				stackedResizer();
			});
		});
		</script>
		<?php

		$stacked_styles = 'background-size:cover;';
		$styles = apply_filters( 'aesop_stacked_gallery_styles_'.$unique, $stacked_styles );

		// image size
		$size    = apply_filters( 'aesop_stacked_gallery_size', 'full' );

		foreach ( $image_ids as $image_id ):

<<<<<<< HEAD
			$full    		= wp_get_attachment_image_src( $image_id, $size, false );
			$caption 		= get_post( $image_id )->post_excerpt;

		   	?>
           	<div class="aesop-stacked-img" style="background-image:url('<?php echo esc_url( $full[0] );?>');<?php echo $styles;?>">
           		<?php if ( $caption ){ ?>
           			<div class="aesop-stacked-caption"><?php echo esc_html( $caption );?></div>
=======
			$full      = wp_get_attachment_image_src( $image_id, $size, false );
			$caption   = get_post( $image_id )->post_excerpt;

?>
           	<div class="aesop-stacked-img" style="background-image:url('<?php echo esc_url( $full[0] );?>');<?php echo $styles;?>">
           		<?php if ( $caption ) { ?>
           			<div class="aesop-stacked-caption"><?php echo aesop_component_media_filter( $caption );?></div>
>>>>>>> release/1.5.1
           		<?php } ?>
           	</div>
           	<?php

		endforeach;

	}

	/**
	 * Draws a gallery with images in sequencal order
	 *
	 * @since    1.0.0
	 */
<<<<<<< HEAD
	function aesop_sequence_gallery( $gallery_id, $image_ids, $width ){
=======
	public function aesop_sequence_gallery( $image_ids ) {
>>>>>>> release/1.5.1

		// image size
		$size    = apply_filters( 'aesop_sequence_gallery_size', 'large' );

		// lazy loader class
		$lazy_holder = AI_CORE_URL.'/public/assets/img/aesop-lazy-holder.png';

		foreach ( $image_ids as $image_id ):

<<<<<<< HEAD
			$img     = wp_get_attachment_image_src( $image_id, $size, false,'' );
			$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$caption 	= get_post( $image_id )->post_excerpt;

			$lazy   = class_exists( 'AesopLazyLoader' ) && ! is_user_logged_in() ? sprintf( 'src="%s" data-src="%s" class="aesop-sequence-img aesop-lazy-img"',$lazy_holder, esc_url( $img[0] ) ) : sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );

		   	?>
=======
			$img     = wp_get_attachment_image_src( $image_id, $size, false, '' );
		$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$caption = get_post( $image_id )->post_excerpt;

		$lazy   = class_exists( 'AesopLazyLoader' ) && ! is_user_logged_in() ? sprintf( 'src="%s" data-src="%s" class="aesop-sequence-img aesop-lazy-img"', $lazy_holder, esc_url( $img[0] ) ) : sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );

?>
>>>>>>> release/1.5.1
           	<figure class="aesop-sequence-img-wrap">

           		<img <?php echo $lazy;?> alt="<?php echo esc_attr( $alt );?>">

           		<?php if ( $caption ) { ?>
<<<<<<< HEAD
           			<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo esc_html( $caption );?></figcaption>
=======
           			<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo aesop_component_media_filter( $caption );?></figcaption>
>>>>>>> release/1.5.1
           		<?php } ?>

           	</figure>
           	<?php

		endforeach;

	}

	/**
	 * Draws a photoset style gallery
	 *
	 * @since    1.0.9
	 */
<<<<<<< HEAD
	function aesop_photoset_gallery($gallery_id, $image_ids, $width){

		// allow theme developers to determine the spacing between grid items
		$space 	= apply_filters( 'aesop_grid_gallery_spacing', 5 );
=======
	public function aesop_photoset_gallery( $gallery_id, $image_ids, $width ) {

		// allow theme developers to determine the spacing between grid items
		$space  = apply_filters( 'aesop_grid_gallery_spacing', 5 );
>>>>>>> release/1.5.1

		// layout
		$layout = get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true ) ? get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true ) : '';

<<<<<<< HEAD
		$style 	= $width ? sprintf( 'style="max-width:%s;margin-left:auto;margin-right:auto;"', esc_attr( $width ) ) : null;
=======
		$style  = $width ? sprintf( 'style="max-width:%s;margin-left:auto;margin-right:auto;"', esc_attr( $width ) ) : null;
>>>>>>> release/1.5.1

		// lightbox
		$lightbox = get_post_meta( $gallery_id, 'aesop_photoset_gallery_lightbox', true );

		// image size
		$size    = apply_filters( 'aesop_photoset_gallery_size', 'large' );

?>
		<!-- Aesop Photoset Gallery -->
		<script>
<<<<<<< HEAD
			jQuery(window).load(function(){
				jQuery('.aesop-gallery-photoset').photosetGrid({
=======
			jQuery(window).load(function($){
				$('.aesop-gallery-photoset').photosetGrid({
>>>>>>> release/1.5.1
				  	gutter: "<?php echo absint( $space ).'px';?>",
				  	<?php if ( $lightbox ) { ?>
				  	highresLinks:true,
				  	<?php } ?>
				  	onComplete: function(){

				  		<?php if ( $lightbox ) { ?>
				  			$('.aesop-gallery-photoset a').addClass('aesop-lightbox').prepend('<i class="dashicons dashicons-search"></i>');

				  		<?php } ?>

					   	 	$('.aesop-gallery-photoset').attr('style', '');
					    	$(".photoset-cell img").each(function(){

							caption = $(this).attr('data-caption');

							if ( caption) {
								title = $(this).attr('title');
								$(this).after('<span class="aesop-photoset-caption"><span class="aesop-photoset-caption-title">' + title + '</span><span class="aesop-photoset-caption-caption">' + caption +'</span></span>');
								$('.aesop-photoset-caption').hide().fadeIn();

								$(this).closest('a').attr('title',title);
							}
						});
					}
				});
			});
		</script>

<<<<<<< HEAD
		<?php if ( $style ) {
			echo '<div class="aesop-gallery-photoset-width" '.$style.' >';
}

			?><div class="aesop-gallery-photoset" data-layout="<?php echo absint( $layout );?>" ><?php

foreach ( $image_ids as $image_id ):

	$full    	= wp_get_attachment_image_src( $image_id, $size, false );
	$alt     	= get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	$caption    = get_post( $image_id )->post_excerpt;
					$title 	  	= get_post( $image_id )->post_title;

	$lb_link    = $lightbox ? sprintf( 'data-highres="%s"', esc_url( $full[0] ) ) : null;

	?><img src="<?php echo esc_url( $full[0] );?>" <?php echo $lb_link;?> data-caption="<?php echo esc_attr( $caption );?>" title="<?php echo esc_attr( $title );?>" alt="<?php echo esc_attr( $alt );?>"><?php
=======
		<?php if ( $style !== null ) { echo '<div class="aesop-gallery-photoset-width" '.$style.' >'; }

		?><div class="aesop-gallery-photoset" data-layout="<?php echo absint( $layout );?>" ><?php

		foreach ( $image_ids as $image_id ) {

			$full     = wp_get_attachment_image_src( $image_id, $size, false );
			$alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$caption    = get_post( $image_id )->post_excerpt;
			$title     = get_post( $image_id )->post_title;

			$lb_link    = $lightbox ? sprintf( 'data-highres="%s"', esc_url( $full[0] ) ) : null;

			?><img src="<?php echo esc_url( $full[0] );?>" <?php echo $lb_link;?> data-caption="<?php echo esc_attr( $caption );?>" title="<?php echo esc_attr( $title );?>" alt="<?php echo esc_attr( $alt );?>"><?php
>>>>>>> release/1.5.1

		}

		?></div><?php

<<<<<<< HEAD
if ( $style ) {
	echo '</div>';
}
=======
		if ( $style !== null ) { echo '</div>'; }
>>>>>>> release/1.5.1

	}

}
new AesopCoreGallery;