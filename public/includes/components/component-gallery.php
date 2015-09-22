<?php
/**
 * Creates a multipurpose gallery that can be shown as thumbnail, grid, gridset, and with lightbox and captions
 *
 * @since    1.0.0
 */

class AesopCoreGallery {

	function __construct() {

		add_shortcode( 'aesop_gallery',  array( $this, 'aesop_post_gallery' ) );

	}

	/**
	 * Main gallery component
	 *
	 * @since    1.0.0
	 */
	public function aesop_post_gallery( $atts ) {

		global $post;

		// attributes
		$defaults  = array( 'id' => '', 'a_type' => '' );
		$atts   = shortcode_atts( $defaults, $atts );

		// gallery ID
		$gallery_id = isset( $atts['id'] ) ? (int) $atts['id'] : false;

		// alias to new atts type
		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique  = sprintf( '%s-%s', $gallery_id, $instance );

		// get gallery images and custom attrs
		$image_ids  = get_post_meta( $gallery_id, '_ase_gallery_images', true );
		$image_ids = array_map( 'intval', explode( ',', $image_ids ) );

		$type   = get_post_meta( $gallery_id, 'aesop_gallery_type', true );
		$width   = get_post_meta( $gallery_id, 'aesop_gallery_width', true );

		// gallery caption
		$gallery_caption = get_post_meta( $gallery_id, 'aesop_gallery_caption', true );

		// custom classes
		$classes = aesop_component_classes( 'gallery', '' );

		ob_start();

		do_action( 'aesop_gallery_before', $type, $gallery_id, $atts, $unique ); // action

		?><div id="aesop-gallery-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'gallery', $gallery_id, $atts );?> class="aesop-component aesop-gallery-component aesop-<?php echo esc_attr( $type );?>-gallery-wrap <?php echo sanitize_html_class( $classes );?> <?php if ( empty( $gallery_id ) ) { echo 'empty-gallery'; }?> "><?php

		do_action( 'aesop_gallery_inside_top', $type, $gallery_id, $atts, $unique ); // action

		if ( ! empty( $image_ids ) ) {

			switch ( $type ) {
				case 'thumbnail':
					$this->aesop_thumb_gallery( $gallery_id, $image_ids, $width );
					break;
				case 'grid':
					$this->aesop_grid_gallery( $gallery_id, $image_ids, $width );
					break;
				case 'stacked':
					$this->aesop_stacked_gallery( $image_ids, $unique );
					break;
				case 'sequence':
					$this->aesop_sequence_gallery( $image_ids );
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

			if ( ! function_exists( 'lasso_editor_components' ) && is_user_logged_in() && current_user_can( 'edit_post', get_the_ID() ) ) {

				$url = admin_url( 'post.php?post='.$gallery_id.'&action=edit' );
				$edit_gallery = __( 'edit gallery', 'aesop-core' );
				printf( '<a class="aesop-gallery-edit aesop-content" href="%s" target="_blank" title="%s">(%s)</a>', $url, $edit_gallery, $edit_gallery );
			}
		}//end if

		if ( empty( $gallery_id ) && is_user_logged_in() && current_user_can( 'edit_post', get_the_ID() ) ) {

			if ( function_exists( 'lasso_editor_components' ) ) {

				?><div contenteditable="false" class="lasso--empty-component"><?php
				_e( 'Setup a gallery by clicking the <span class="lasso-icon-gear"></span> icon above.', 'aesop-core' );
				?></div><?php

			} else {

				?><div class="aesop-error aesop-content"><?php
				_e( 'This gallery is empty! It\'s also possible that you simply have the wrong gallery ID.', 'aesop-core' );
				?></div><?php

			}
		}

		do_action( 'aesop_gallery_inside_bottom', $type, $gallery_id, $atts, $unique ); // action

		?></div><?php

		do_action( 'aesop_gallery_after', $type, $gallery_id, $atts, $unique ); // action

		return ob_get_clean();

	}

	/**
	 * Draws a thumbnail gallery using fotorama
	 *
	 * @since    1.0.0
	 */
	public function aesop_thumb_gallery( $gallery_id, $image_ids, $width ) {

		$thumbs  = get_post_meta( $gallery_id, 'aesop_thumb_gallery_hide_thumbs', true ) ? sprintf( 'data-nav=false' ) : sprintf( 'data-nav=thumbs' );
		$autoplay  = get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true ) ? sprintf( 'data-autoplay="%s"', get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true ) ) : null;
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

		foreach ( $image_ids as $image_id ):

			$full    = wp_get_attachment_image_src( $image_id, $size, false );
		$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$caption  = get_post( $image_id )->post_excerpt;

		?><img src="<?php echo esc_url( $full[0] );?>" data-caption="<?php echo esc_attr( $caption );?>" alt="<?php echo esc_attr( $alt );?>"><?php

		endforeach;

		?></div><?php
	}

	/**
	 * Draws a grid style gallery using wookmark
	 *
	 * @since    1.0.0
	 */
	public function aesop_grid_gallery( $gallery_id, $image_ids, $width ) {

		$gridwidth  = get_post_meta( $gallery_id, 'aesop_grid_gallery_width', true ) ? get_post_meta( $gallery_id, 'aesop_grid_gallery_width', true ) : 400;

		// allow theme developers to determine the spacing between grid items
		$space = apply_filters( 'aesop_grid_gallery_spacing', 5 );

?>
		<!-- Aesop Grid Gallery -->
		<script>
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
			    });
			});
		</script>
		<div id="aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>" class="aesop-grid-gallery aesop-grid-gallery" style="width:100%;max-width:<?php echo esc_attr( $width );?>;margin:0 auto;"><ul><?php

		foreach ( $image_ids as $image_id ):

			$getimage   = wp_get_attachment_image( $image_id, 'aesop-grid-image', false, array( 'class' => 'aesop-grid-image' ) );
		$getimagesrc    = wp_get_attachment_image_src( $image_id, 'full' );
		$img_title     = get_post( $image_id )->post_title;
		$caption   = get_post( $image_id )->post_excerpt;

?>

				<li class="aesop-grid-gallery-item">
					<a class="aesop-lightbox" href="<?php echo esc_url( $getimagesrc[0] );?>" title="<?php esc_attr_e( $img_title );?>">
						<?php if ( $caption ) { ?>
							<span class="aesop-grid-gallery-caption"><?php echo aesop_component_media_filter( $caption );?></span>
						<?php } ?>
						<span class="clearfix"><?php echo $getimage;?></span>
					</a>
				</li>

				<?php

		endforeach;

		?></ul></div><?php
	}

	/**
	 * Draws a stacked parallax style gallery
	 *
	 * @since    1.0.0
	 * @param string $unique
	 */
	public function aesop_stacked_gallery( $image_ids, $unique ) {

		?>
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

		$stacked_styles = 'background-size:cover;background-position:center center';
		$styles = apply_filters( 'aesop_stacked_gallery_styles_'.$unique, $stacked_styles );

		// image size
		$size    = apply_filters( 'aesop_stacked_gallery_size', 'full' );

		foreach ( $image_ids as $image_id ):

			$full      = wp_get_attachment_image_src( $image_id, $size, false );
			$caption   = get_post( $image_id )->post_excerpt;

?>
           	<div class="aesop-stacked-img" style="background-image:url('<?php echo esc_url( $full[0] );?>');<?php echo $styles;?>">
           		<?php if ( $caption ) { ?>
           			<div class="aesop-stacked-caption"><?php echo aesop_component_media_filter( $caption );?></div>
           		<?php } ?>
           	</div>
           	<?php

		endforeach;

	}

	/**
	 * Draws a gallery with images in sequential order
	 *
	 * @since    1.0.0
	 */
	public function aesop_sequence_gallery( $image_ids ) {

		// image size
		$size    = apply_filters( 'aesop_sequence_gallery_size', 'large' );

		// lazy loader class
		$lazy_holder = AI_CORE_URL.'/public/assets/img/aesop-lazy-holder.png';

		foreach ( $image_ids as $image_id ):

			$img     = wp_get_attachment_image_src( $image_id, $size, false, '' );
		$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$caption = get_post( $image_id )->post_excerpt;

		$lazy   = class_exists( 'AesopLazyLoader' ) && ! is_user_logged_in() ? sprintf( 'src="%s" data-src="%s" class="aesop-sequence-img aesop-lazy-img"', $lazy_holder, esc_url( $img[0] ) ) : sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );

?>
           	<figure class="aesop-sequence-img-wrap">

           		<img <?php echo $lazy;?> alt="<?php echo esc_attr( $alt );?>">

           		<?php if ( $caption ) { ?>
           			<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo aesop_component_media_filter( $caption );?></figcaption>
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
	public function aesop_photoset_gallery( $gallery_id, $image_ids, $width ) {

		// allow theme developers to determine the spacing between grid items
		$space  = apply_filters( 'aesop_grid_gallery_spacing', 5 );

		// layout
		$layout = get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true ) ? get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true ) : '';

		$style  = $width ? sprintf( 'style="max-width:%s;margin-left:auto;margin-right:auto;"', esc_attr( $width ) ) : null;

		// lightbox
		$lightbox = get_post_meta( $gallery_id, 'aesop_photoset_gallery_lightbox', true );

		// image size
		$size    = apply_filters( 'aesop_photoset_gallery_size', 'large' );

?>
		<!-- Aesop Photoset Gallery -->
		<script>
			jQuery(window).load(function(){
				jQuery('.aesop-gallery-photoset').photosetGrid({
				  	gutter: "<?php echo absint( $space ).'px';?>",
				  	<?php if ( $lightbox ) { ?>
				  	highresLinks:true,
				  	<?php } ?>
				  	onComplete: function(){

				  		<?php if ( $lightbox ) { ?>
				  			jQuery('.aesop-gallery-photoset a').addClass('aesop-lightbox').prepend('<i class="dashicons dashicons-search"></i>');

				  		<?php } ?>

					   	 	jQuery('.aesop-gallery-photoset').attr('style', '');
					    	jQuery(".photoset-cell img").each(function(){

							caption = jQuery(this).attr('data-caption');

							if ( caption) {
								title = jQuery(this).attr('title');
								jQuery(this).after('<span class="aesop-photoset-caption"><span class="aesop-photoset-caption-title">' + title + '</span><span class="aesop-photoset-caption-caption">' + caption +'</span></span>');
								jQuery('.aesop-photoset-caption').hide().fadeIn();

								jQuery(this).closest('a').attr('title',title);
							}
						});
					}
				});
			});
		</script>

		<?php if ( $style !== null ) { echo '<div class="aesop-gallery-photoset-width" '.$style.' >'; }

		?><div class="aesop-gallery-photoset" data-layout="<?php echo absint( $layout );?>" ><?php

		foreach ( $image_ids as $image_id ) {

			$full     = wp_get_attachment_image_src( $image_id, $size, false );
			$alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$caption    = get_post( $image_id )->post_excerpt;
			$title     = get_post( $image_id )->post_title;

			$lb_link    = $lightbox ? sprintf( 'data-highres="%s"', esc_url( $full[0] ) ) : null;

			?><img src="<?php echo esc_url( $full[0] );?>" <?php echo $lb_link;?> data-caption="<?php echo esc_attr( $caption );?>" title="<?php echo esc_attr( $title );?>" alt="<?php echo esc_attr( $alt );?>"><?php

		}

		?></div><?php

		if ( $style !== null ) { echo '</div>'; }

	}

}
new AesopCoreGallery;
