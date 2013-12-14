<?php
/**
 	* Creates a multipurpose gallery that can be shown as thumbnail, grid, gridset, and with lightbox and captions
 	* Class removes the core wordpess shortcode, and adds it back using our own custom attributes
 	*
 	* @since    1.0.0
 	* @TODO   right now this is using a regex to get the ids to parse the shortcode to ge tthe atts. the problem is that user may have multiple
 	*         galleries. next, need to use the include attribute with the id's .
 	*         this means somehow swapping id attribute for includes
*/



class AesopCoreGallery {

   	function __construct(){

   		add_action('print_media_templates',  array($this,'aesop_gallery_opts'));

       	remove_shortcode('gallery', 		array($this,'gallery_shortcode'));
        add_shortcode('gallery',        	array($this,'aesop_post_gallery'));

    }

	/**
	 	* Merges custom shortcode attributes into native wordpress gallery
	 	*
	 	* @since    1.0.0
	*/
	function aesop_gallery_opts (){

	  	?>
	  	<script type="text/html" id="tmpl-aesop-gallery-extended-opts">
		    <label class="setting">
		      	<span><?php _e('Type','aesop-core'); ?></span>
		      	<select data-setting="a_type">
		      		<option value="">- Select -</option>
		        	<option value="grid">Grid</option>
		        	<option value="thumbnail">Thumbnail</option>
		      	</select>
		    </label>
	  	</script>

	  	<script>

		    jQuery(document).ready(function(){

		     	 // add your shortcode attribute and its default value to the
		      	// gallery settings list; $.extend should work as well...
		      	_.extend(wp.media.gallery.defaults, {
		        	a_type: 'a_type'
		      	});

		     	 // merge default gallery settings template with yours
		      	wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
			        template: function(view){
			          	return wp.media.template('gallery-settings')(view) + wp.media.template('aesop-gallery-extended-opts')(view);
			        }
		      	});

		    });

	  	</script>
	<?php }

    /**
	 	* Overrides core wordpress gallery and provides grid / thumbnail type galleries
	 	*
	 	* @since    1.0.0
	*/
	function aesop_post_gallery($atts, $content = null){

		// get the post via ID so we can access data and print it within an array to fetch
		global $post;

        $id                 = $post->ID;
        $galleryid			= rand();

		// Get the gallery shortcode out of the post content, and parse the ID's in teh gallery shortcode
		$shortcode_args = shortcode_parse_atts(self::gallery_match('/\[gallery\s(.*)\]/isU', $post->post_content));

		// set gallery shortcode image id's
		$ids = $shortcode_args["ids"];

		// do cusotm atts
		$defaults = array(
			'a_type' => '',
			'width' => '100%'
		);
		$atts = shortcode_atts($defaults, $atts);


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
		$images = get_posts($args);


		ob_start();

			?><section class="aesop-component aesop-gallery-component"><?php

				if ('thumbnail' == $atts['a_type']) {
					$this->aesop_thumb_gallery($galleryid, $images, $atts);
				} else {
					$this->aesop_grid_gallery($galleryid, $images,$atts, $id);
				}

			?></section><?php



		return ob_get_clean();


	}

    /**
	 	* Draws a thumbnail gallery using fotorama
	 	*
	 	* @since    1.0.0
	*/
	function aesop_thumb_gallery($galleryid, $images, $atts){

		?><div id="aesop-thumb-gallery-<?php echo $galleryid;?>" class="fotorama" data-width="<?php echo $atts['width'];?>" data-keyboard="true" data-nav="thumbs" data-allow-full-screen="native" data-click="true"><?php

			foreach ($images as $image):

                $full    =  wp_get_attachment_url($image->ID, 'full', false,'');
                $alt     =  get_post_meta($image->ID, '_wp_attachment_image_alt', true);
                $caption =  $image->post_excerpt;
                $desc    =  $image->post_content;

               ?><img src="<?php echo $full;?>" data-caption="<?php echo $caption;?>" alt="<?php echo $alt;?>"><?php

			endforeach;

		?></div><?php
	}

    /**
	 	* Draws a grid style gallery using wookmark
	 	*
	 	* @since    1.0.0
	*/
	function aesop_grid_gallery($galleryid, $images, $atts, $id){

		?>
		<script>
			jQuery(document).ready(function(){
			    jQuery('#aesop-grid-gallery-<?php echo $galleryid;?>').imagesLoaded(function() {
			        var options = {
			          	autoResize: true,
			          	container: jQuery('#aesop-grid-gallery-<?php echo $galleryid;?>'),
			          	offset: 5,
			          	flexibleWidth: 400
			        };
			        var handler = jQuery('#aesop-grid-gallery-<?php echo $galleryid;?> img');
			        jQuery(handler).wookmark(options);
			    });
			});
		</script>
		<div id="aesop-grid-gallery-<?php echo $galleryid;?>" class="aesop-grid-gallery aesop-grid-gallery-<?php echo $id;?>"><?php

			foreach ($images as $image):

                $full    =  wp_get_attachment_url($image->ID, 'full', false,'');
                $alt     =  get_post_meta($image->ID, '_wp_attachment_image_alt', true);
                $caption =  $image->post_excerpt;
                $desc    =  $image->post_content;

               ?><img src="<?php echo $full;?>" alt="<?php echo $alt;?>"><?php

			endforeach;

		?></div><?php
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
}
new AesopCoreGallery;