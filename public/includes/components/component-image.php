<?php
/**
 	* Provides an image and caption
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_image_shortcode')){

	function aesop_image_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> '',
			'imgwidth'			=> '300px',
			'offset'			=> '',
			'alt'				=> '',
			'align' 			=> 'left',
			'caption'			=> '',
			'credit'			=> '',
			'captionposition'	=> 'left',
			'lightbox' 			=> 'off'
		);

		$atts = apply_filters('aesop_image_defaults',shortcode_atts($defaults, $atts));

		// offset styles
		$offsetstyle = $atts['offset'] ? sprintf('style="margin-%s:%s;width:%s;"',$atts['align'], $atts['offset'], $atts['imgwidth']) : sprintf('style="width:%s;"', $atts['imgwidth']);

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'image', '' ) : null;

		// image width
		$width = $atts['imgwidth'] ? sprintf('style="width:%s;"',$atts['imgwidth']) : null;

		// combine into component shell
		ob_start();

		do_action('aesop_image_before'); //action
		?>
		<div class="aesop-component aesop-image-component <?php echo $classes;?>" >

			<?php do_action('aesop_image_inside_top'); //action ?>

			<figure class="aesop-content">
				<div class="aesop-image-component-image aesop-component-align-<?php echo $atts['align'];?> aesop-image-component-caption-<?php echo $atts['captionposition'];?>" <?php echo $offsetstyle;?>>
					<?php

					do_action('aesop_image_inner_inside_top'); //action 

					if('on' == $atts['lightbox']) { ?>

						<a class="aesop-lightbox" href="<?php echo $atts['img'];?>">
							<p class="aesop-img-enlarge"><i class="aesopicon aesopicon-search-plus"></i> <?php _e('Enlarge','aesop-core');?></p>
							<img src="<?php echo $atts['img'];?>" alt="<?php echo esc_attr($atts['alt']);?>">
						</a>

					<?php } else { ?>

						<img src="<?php echo $atts['img'];?>" alt="<?php echo esc_attr($atts['alt']);?>">

					<?php }

					if ($atts['caption']) { ?>

						<figcaption class="aesop-image-component-caption">
							<?php

							echo $atts['caption'];

							if($atts['credit']){ ?>
								<p class="aesop-cap-cred"><?php echo $atts['credit'];?></p>
							<?php } ?>

						</figcaption>

					<?php } ?>

					<?php do_action('aesop_image_inner_inside_bottom'); //action ?>

				</div>
			</figure>

			<?php do_action('aesop_image_inside_bottom'); //action ?>

		</div>
		<?php
		do_action('aesop_image_after'); //action

		return ob_get_clean();
	}
}