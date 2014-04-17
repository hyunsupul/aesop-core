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

		// do cusotm atts
		$defaults = array(
			'id'	=> '',
			'a_type' => ''
		);
		$atts = shortcode_atts($defaults, $atts);

		// gallery ID
		$id = $atts['id'];

		// get the post via ID so we can access data and print it within an array to fetch
		$getpost = get_post($id, ARRAY_A);

		// Get the gallery shortcode out of the post content, and parse the ID's in teh gallery shortcode
		$shortcode_args = shortcode_parse_atts($this->gallery_match('/\[gallery\s(.*)\]/isU', $getpost['post_content']));

		// set gallery shortcode image id's
		$ids = $shortcode_args["ids"];
		$type = $shortcode_args['a_type'];
		$width = get_post_meta($id,'aesop_gallery_width', true);

		//gallery caption
		$gallery_caption = get_post_meta($id, 'aesop_gallery_caption', true);

		$images = wp_cache_get( 'aesop_gallery_wp_query_'.$id );

		if ( false == $images) {

			// setup some args so we can pull only images from this content
			$args = array(
	            'include'        => $ids,
	            'post_status'    => 'inherit',
	            'post_type'      => 'attachment',
	            'post_mime_type' => 'image',
	            'order'          => 'menu_order ID',
	            'orderby'        => 'post__in', //required to order results based on order specified the "include" param
	        );

			// fetch the image id's that the user has within the gallery shortcode
			$images = get_posts( apply_filters('aesop_gallery_query',$args) );

			wp_cache_set( 'aesop_gallery_wp_query_'.$id, $images, '', 60*60*12 );

		}

		ob_start();

			do_action('aesop_gallery_before', $atts['a_type'], $id); //action

			?><div class="aesop-component aesop-gallery-component aesop-<?php echo $type;?>-gallery-wrap"><?php

				do_action('aesop_gallery_inside_top', $atts['a_type'], $id); //action

				if ($images) {

					switch($type):
						case 'thumbnail':
							$this->aesop_thumb_gallery($atts, $images, $width);
						break;
						case 'grid':
							$this->aesop_grid_gallery($atts,$images,$width);
						break;
						case 'stacked':
							$this->aesop_stacked_gallery($atts,$images,$width);
						break;
						case 'sequence':
							$this->aesop_sequence_gallery($atts,$images,$width);
						break;
						default:
							$this->aesop_grid_gallery($atts,$images,$width);
						break;
					endswitch;

					if ($gallery_caption) {
						printf('<p class="aesop-component-caption">%s</p>', $gallery_caption);
					}

				} else {
					_e('No images found', 'aesop-core');
				}

				do_action('aesop_gallery_inside_bottom', $atts['a_type'], $id); //action

			?></div><?php

			do_action('aesop_gallery_after', $atts['a_type'], $id); //action

		return ob_get_clean();

	}

    /**
	 	* Draws a thumbnail gallery using fotorama
	 	*
	 	* @since    1.0.0
	*/
	function aesop_thumb_gallery($atts, $images, $width){

		$thumbs = get_post_meta( $atts['id'], 'aesop_thumb_gallery_hide_thumbs', true) ? sprintf('data-nav="false"') : sprintf('data-nav="thumbs"');
		$autoplay 	= get_post_meta( $atts['id'], 'aesop_thumb_gallery_transition_speed', true) ? sprintf('data-autoplay="%s"', get_post_meta( $atts['id'], 'aesop_thumb_gallery_transition_speed', true)) : null;
		$transition = get_post_meta( $atts['id'], 'aesop_thumb_gallery_transition', true) ? get_post_meta( $atts['id'], 'aesop_thumb_gallery_transition', true) : 'slide';


		?><div id="aesop-thumb-gallery-<?php echo $atts['id'];?>" class="fotorama" 	data-transition="crossfade"
																			data-width="<?php echo $width;?>"
																			<?php echo $autoplay;?>
																			data-keyboard="true"
																			<?php echo $thumbs;?>
																			data-allow-full-screen="native"
																			data-click="true"><?php

			foreach ($images as $image):

                $full    =  wp_get_attachment_url($image->ID, 'full', false,'');
                $alt     =  get_post_meta($image->ID, '_wp_attachment_image_alt', true);
                $caption =  $image->post_excerpt;
                $desc    =  $image->post_content;

               ?><img src="<?php echo $full;?>" data-caption="<?php echo $caption;?>" alt="<?php echo esc_attr($alt);?>"><?php

			endforeach;

		?></div><?php
	}

    /**
	 	* Draws a grid style gallery using wookmark
	 	*
	 	* @since    1.0.0
	*/
	function aesop_grid_gallery($atts, $images, $width){

		$getgridwidth = get_post_meta($atts["id"],'aesop_grid_gallery_width', true);
		$gridwidth = $getgridwidth ? self::sanitize_int($getgridwidth) : 400;

		$gridspace = 5;
		// allow theme developers to determine the spacing between grid items
		$space = apply_filters('aesop_grid_gallery_spacing', $gridspace );

		?>
		<!-- Aesop Grid Gallery -->
		<script>
			jQuery(document).ready(function(){
			    jQuery('#aesop-grid-gallery-<?php echo $atts["id"];?>').imagesLoaded(function() {
			        var options = {
			          	autoResize: true,
			          	container: jQuery('#aesop-grid-gallery-<?php echo $atts["id"];?>'),
			          	offset: <?php echo $space;?>,
			          	flexibleWidth: <?php echo $gridwidth;?>
			        };
			        var handler = jQuery('#aesop-grid-gallery-<?php echo $atts["id"];?> img');
			        jQuery(handler).wookmark(options);
			    });
			});
		</script>
		<div id="aesop-grid-gallery-<?php echo $atts["id"];?>" class="aesop-grid-gallery aesop-grid-gallery" style="width:100%;max-width:<?php echo $width;?>;margin:0 auto;"><?php

			foreach ($images as $image):

                $getimage 		= wp_get_attachment_image($image->ID, 'aesop-grid-image', false, array('class' => 'aesop-grid-image'));
				$getimgsrc 		= wp_get_attachment_image_src($image->ID,'large');
                $caption 		=  $image->post_excerpt;
                $desc    		=  $image->post_content;
                $img_title 	  	= $image->post_title;

               	printf('<a class="aesop-lightbox" href="%s" title="%s"><span class="clearfix">%s</span></a>',$getimgsrc[0], esc_attr($img_title), $getimage);

			endforeach;


		?></div><?php
	}

    /**
	 	* Draws a stacked parallax style gallery
	 	*
	 	* @since    1.0.0
	*/
	function aesop_stacked_gallery($atts, $images, $width){

		foreach ($images as $image):

            $full    =  wp_get_attachment_url($image->ID, 'full', false,'');
            $alt     =  get_post_meta($image->ID, '_wp_attachment_image_alt', true);
            $caption =  $image->post_excerpt;
            $desc    =  $image->post_content;

           	?>
           	<div class="aesop-stacked-img" style="background-image:url('<?php echo $full;?>');background-size:cover;">
           		<?php if($caption){ ?>
           			<div class="aesop-stacked-caption"><?php echo $caption;?></div>
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
	function aesop_sequence_gallery($atts, $images, $width){

		foreach ($images as $image):

            $img    =  wp_get_attachment_url($image->ID, 'large', false,'');
            $alt     =  get_post_meta($image->ID, '_wp_attachment_image_alt', true);
            $caption =  $image->post_excerpt;
            $desc    =  $image->post_content;

           	?>
           	<figure class="aesop-sequence-img-wrap">

           		<?php

           		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
           		if (is_plugin_active('aesop-lazy-loader/aesop-lazy-loader.php')) {?>
					<img class="aesop-sequence-img" data-original="<?php echo $img;?>" alt="<?php echo esc_attr($alt);?>">
           		<?php } else {?>
           			<img class="aesop-sequence-img" src="<?php echo $img;?>" alt="<?php echo esc_attr($alt);?>">
           		<?php } ?>

           		<?php if($caption){ ?>
           			<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo $caption;?></figcaption>
           		<?php } ?>

           	</figure>
           	<?php

		endforeach;

	}
    /**
	 	* Regex helper used in gallery shortcode to extra ids
	 	*
	 	* @since    1.0.0
	 	* @return matches
	 	* @param content - content being searched
	 	* @param regex - regex being run
	*/
	function gallery_match( $regex, $content ) {
        preg_match($regex, $content, $matches);
        return $matches[1];
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