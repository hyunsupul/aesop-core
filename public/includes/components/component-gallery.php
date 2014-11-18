<?php
/**
 	* Creates a multipurpose gallery that can be shown as thumbnail, grid, gridset, and with lightbox and captions
 	*
 	* @since    1.0.0
*/

class AesopCoreGallery {

   	function __construct(){

        add_shortcode('aesop_gallery',  array($this,'aesop_post_gallery'));

    }

    /**
	 	* Main gallery component
	 	*
	 	* @since    1.0.0
	*/
	function aesop_post_gallery($atts, $content = null){

		global $post;

		// attributes
		$defaults 	= array('id'	=> '','a_type' => '');
		$atts 		= shortcode_atts($defaults, $atts);

		// gallery ID
		$gallery_id = $atts['id'];

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique 	= sprintf('%s-%s', $gallery_id, $instance);

		// get the gallery
		$gallery 	= wp_cache_get('aesop_gallery_retrieval_'.$unique);

		// cache teh gallery retrieval
		if ( false == $gallery ) {

			$gallery 	= get_post_gallery( $gallery_id , false);
			wp_cache_set('aesop_gallery_retrieval_'.$unique, $gallery);

		}

		// get gallery images and custom attrs
		$image_ids 	= explode( ',', $gallery['ids'] );
		$type 		= $gallery['a_type'];
		$width 		= get_post_meta($gallery_id,'aesop_gallery_width', true);

		//gallery caption
		$gallery_caption = get_post_meta( $gallery_id, 'aesop_gallery_caption', true);

		// set the type of gallery into post meta
		// @todo - move this to  save_post action so it doesn't run every time the sc loads
		update_post_meta( $gallery_id, 'aesop_gallery_type', sanitize_text_field( $type ) );

		ob_start();

			do_action('aesop_gallery_before', $type, $gallery_id); //action

			?><div id="aesop-gallery-<?php echo esc_attr( $unique );?>" class="aesop-component aesop-gallery-component aesop-<?php echo esc_attr($type);?>-gallery-wrap"><?php

				do_action('aesop_gallery_inside_top', $type, $gallery_id); //action

				if ( !empty($gallery['ids']) ) {

					switch($type):
						case 'thumbnail':
							$this->aesop_thumb_gallery( $gallery_id, $image_ids, $width );
						break;
						case 'grid':
							$this->aesop_grid_gallery( $gallery_id, $image_ids, $width );
						break;
						case 'stacked':
							$this->aesop_stacked_gallery( $gallery_id, $image_ids, $width, $unique );
						break;
						case 'sequence':
							$this->aesop_sequence_gallery( $gallery_id, $image_ids, $width );
						break;
						case 'photoset':
							$this->aesop_photoset_gallery( $gallery_id, $image_ids, $width );
						break;
						default:
							$this->aesop_grid_gallery( $gallery_id, $image_ids, $width );
						break;
					endswitch;

					if ( $gallery_caption ) {
						printf('<p class="aesop-component-caption">%s</p>', esc_html( $gallery_caption ) );
					}

					if ( is_user_logged_in() ) {
						$url = admin_url( 'post.php?post='.$gallery_id.'&action=edit' );
						$edit_gallery = __('edit gallery', 'aesop-core');
						printf('<a class="aesop-gallery-edit aesop-content" href="%s" target="_blank" title="%s">(%s)</a>',$url, $edit_gallery, $edit_gallery );
					}

				} else {

					?><div class="aesop-error aesop-content"><?php
						_e('This gallery is empty! It\'s also possible that you simply have the wrong gallery ID.', 'aesop-core');
					?></div><?php
				}

				do_action('aesop_gallery_inside_bottom', $type, $gallery_id); //action

			?></div><?php

			do_action('aesop_gallery_after', $type, $gallery_id); //action

		return ob_get_clean();

	}

    /**
	 	* Draws a thumbnail gallery using fotorama
	 	*
	 	* @since    1.0.0
	*/
	function aesop_thumb_gallery($gallery_id, $image_ids, $width){

		$thumbs 	= get_post_meta( $gallery_id, 'aesop_thumb_gallery_hide_thumbs', true) ? sprintf('data-nav=false') : sprintf('data-nav=thumbs');
		$autoplay 	= get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true) ? sprintf('data-autoplay="%s"', get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true)) : null;
		$transition = get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition', true) ? get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition', true) : 'slide';

		// image size
		$size    = apply_filters('aesop_thumb_gallery_size', 'full');

		?><div id="aesop-thumb-gallery-<?php echo esc_attr($gallery_id);?>" class="fotorama" 	data-transition="crossfade"
																			data-width="<?php echo esc_attr($width);?>"
																			<?php echo esc_attr($autoplay);?>
																			data-keyboard="true"
																			<?php echo esc_attr($thumbs);?>
																			data-allow-full-screen="native"
																			data-click="true"><?php

			foreach ($image_ids as $image_id):

                $full    =  wp_get_attachment_image_src($image_id, $size, false);
                $alt     =  get_post_meta($image_id, '_wp_attachment_image_alt', true);
                $caption 	= get_post($image_id)->post_excerpt;

               ?><img src="<?php echo esc_url($full[0]);?>" data-caption="<?php echo esc_attr($caption);?>" alt="<?php echo esc_attr($alt);?>"><?php

			endforeach;

		?></div><?php
	}

    /**
	 	* Draws a grid style gallery using wookmark
	 	*
	 	* @since    1.0.0
	*/
	function aesop_grid_gallery($gallery_id, $image_ids, $width){

		$getgridwidth 	= get_post_meta( $gallery_id, 'aesop_grid_gallery_width', true );
		$gridwidth 		= $getgridwidth ? self::sanitize_int($getgridwidth) : 400;

		// allow theme developers to determine the spacing between grid items
		$space = apply_filters('aesop_grid_gallery_spacing', 5 );

		// image size
		$size    = apply_filters('aesop_grid_gallery_size', 'large');

		?>
		<!-- Aesop Grid Gallery -->
		<script>
			jQuery(document).ready(function(){
			    jQuery('#aesop-grid-gallery-<?php echo esc_attr($gallery_id);?>').imagesLoaded(function() {
			        var options = {
			          	autoResize: true,
			          	container: jQuery('#aesop-grid-gallery-<?php echo esc_attr($gallery_id);?>'),
			          	offset: <?php echo $space;?>,
			          	flexibleWidth: <?php echo $gridwidth;?>
			        };
			        var handler = jQuery('#aesop-grid-gallery-<?php echo esc_attr($gallery_id);?> li');
			        jQuery(handler).wookmark(options);
			    });
			});
		</script>
		<div id="aesop-grid-gallery-<?php echo esc_attr($gallery_id);?>" class="aesop-grid-gallery aesop-grid-gallery" style="width:100%;max-width:<?php echo esc_attr($width);?>;margin:0 auto;"><ul><?php

			foreach ($image_ids as $image_id):

                $getimage 		= wp_get_attachment_image($image_id, 'aesop-grid-image', false, array('class' => 'aesop-grid-image'));
            	$getimagesrc    = wp_get_attachment_image_src($image_id, 'full');
                $img_title 	  	= get_post($image_id)->post_title;
                $caption 		= get_post($image_id)->post_excerpt;

			?>

			<li class="aesop-grid-gallery-item"><a class="aesop-lightbox" href="<?php echo $getimagesrc[0];?>" title="<?php echo esc_attr($img_title);?>">
				<?php if ( $caption ){ ?>
					<span class="aesop-grid-gallery-caption"><?php echo $caption;?></span>
				<?php } ?>
			<span class="clearfix"><?php echo $getimage;?></span></a></li>

			<?php

			endforeach;


		?></ul></div><?php
	}

    /**
	 	* Draws a stacked parallax style gallery
	 	*
	 	* @since    1.0.0
	*/
	function aesop_stacked_gallery( $gallery_id, $image_ids, $width, $unique){

		?>
		<!-- Aesop Stacked Gallery -->
		<script>
		jQuery(document).ready(function(){

			var stackedResizer = function(){
				jQuery('.aesop-stacked-img').css({'height':(jQuery(window).height())+'px', 'width':(jQuery(this).parent())+'px'});
			}
			stackedResizer();

			jQuery(window).resize(function(){
				stackedResizer();
			});
		});
		</script>
		<?php

		$stacked_styles = 'background-size:cover;';
		$styles = apply_filters( 'aesop_stacked_gallery_styles_'.$unique, $stacked_styles );

		// image size
		$size    = apply_filters('aesop_stacked_gallery_size', 'full');

		foreach ( $image_ids as $image_id ):

            $full    		=  wp_get_attachment_image_src($image_id, $size, false);
            $caption 		= get_post($image_id)->post_excerpt;

           	?>
           	<div class="aesop-stacked-img" style="background-image:url('<?php echo esc_url($full[0]);?>');<?php echo $styles;?>">
           		<?php if ( $caption ){ ?>
           			<div class="aesop-stacked-caption"><?php echo esc_html($caption);?></div>
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
	function aesop_sequence_gallery( $gallery_id, $image_ids, $width ){

		// image size
		$size    = apply_filters('aesop_sequence_gallery_size', 'large');

		foreach ( $image_ids as $image_id ):

            $img     =  wp_get_attachment_image($image_id, $size, false,'');
            $alt     =  get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $caption 	= get_post($image_id)->post_excerpt;

           	?>
           	<figure class="aesop-sequence-img-wrap">

           		<?php

           		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
           		if ( is_plugin_active('aesop-lazy-loader/aesop-lazy-loader.php') ) {?>
					<img class="aesop-sequence-img" data-original="<?php echo esc_url($img[0]);?>" alt="<?php echo esc_attr($alt);?>">
           		<?php } else { ?>
           			<img class="aesop-sequence-img" src="<?php echo esc_url($img[0]);?>" alt="<?php echo esc_attr($alt);?>">
           		<?php } ?>

           		<?php if ( $caption ) { ?>
           			<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo esc_html($caption);?></figcaption>
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
	function aesop_photoset_gallery($gallery_id, $image_ids, $width){

		// allow theme developers to determine the spacing between grid items
		$space 	= apply_filters('aesop_grid_gallery_spacing', 5);

		// layout
		$layout = get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true) ? get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true) : '';

		$style 	= $width ? sprintf('style="max-width:%s;margin-left:auto;margin-right:auto;"', esc_attr( $width ) ) : null;

		// lightbox
		$lightbox = get_post_meta( $gallery_id, 'aesop_photoset_gallery_lightbox', true );

		// image size
		$size    = apply_filters('aesop_photoset_gallery_size', 'large');

		?>
		<!-- Aesop Photoset Gallery -->
		<script>
			jQuery(window).load(function(){
				jQuery('.aesop-gallery-photoset').photosetGrid({
				  	gutter: "<?php echo absint($space).'px';?>",
				  	<?php if ( $lightbox ) { ?>
				  	highresLinks:true,
				  	<?php } ?>
				  	onComplete: function(){

				  		<?php if ( $lightbox ) { ?>
				  			jQuery('.aesop-gallery-photoset a').addClass('aesop-lightbox').prepend('<i class="dashicons dashicons-search"></i>');

				  		<?php } ?>

					    jQuery('.aesop-gallery-photoset').attr('style', '');
					    jQuery(".aesop-gallery-photoset img").each(function(){

							caption = jQuery(this).attr('alt');

							if ( caption ) {
								title = jQuery(this).attr('data-title');
								jQuery(this).after('<span class="aesop-photoset-caption"><span class="aesop-photoset-caption-title">' + title + '</span><span class="aesop-photoset-caption-caption">' + caption +'</span></span>');
								jQuery('.aesop-photoset-caption').hide().fadeIn();

								jQuery(this).closest('a').attr('title',title);
							}
						});
					}
				});
			});
		</script>

		<?php if ( $style ) {
			echo '<div class="aesop-gallery-photoset-width" '.$style.' >';
		}

			?><div class="aesop-gallery-photoset" data-layout="<?php echo absint($layout);?>" ><?php

				foreach ( $image_ids as $image_id ):

		            $full    	=  wp_get_attachment_image_src( $image_id, $size, false);
		            $alt     	=  get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                	$title 	  	= 	get_post($image_id)->post_title;

		            $lb_link    =  $lightbox ? sprintf('data-highres="%s"', esc_url( $full[0] ) ) : null;

		           	?><img src="<?php echo esc_url($full[0]);?>" <?php echo $lb_link;?> data-title="<?php echo esc_attr($title);?>" title="<?php echo esc_attr($title);?>" alt="<?php echo esc_attr($alt);?>"><?php

				endforeach;

			?></div><?php

		if ( $style ) {
			echo '</div>';
		}

	}

    /**
	 	* Ensure users only enter whole number
	 	*
	 	* @since    1.0.0
	*/
	function sanitize_int( $input = ''  ) {
		return wp_filter_nohtml_kses( round( $input ) );

	}
}
new AesopCoreGallery;