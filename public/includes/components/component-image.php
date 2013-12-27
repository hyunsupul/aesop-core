<?php
/**
 	* Provides an image and caption
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_image_shortcode')){

	function aesop_image_shortcode($atts, $content = null) {

		$defaults = array(
			'width'				=> 'content',
			'img' 				=> 'http://placekitten.com/1200/700',
			'imgwidth'			=> '300px',
			'offset'			=> '-150px',
			'alt'				=> '',
			'align' 			=> 'left',
			'caption'			=> '',
			'credit'			=> '',
			'captionposition'	=> 'bottom',
			'lightbox' 			=> 'off'
		);

		$atts = apply_filters('aesop_image_defaults',shortcode_atts($defaults, $atts));

		// global component content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// offset styles
		$offsetstyle = $atts['offset'] ? sprintf('style="margin-%s:%s;"',$atts['align'], $atts['offset']) : false;

		// combine into component shell
		ob_start();

		do_action('aesop_image_component_before'); //action
		?>
		<aside class="aesop-component aesop-image-component">

			<?php do_action('aesop_image_component_inside_top'); //action ?>

			<div class="<?php echo $contentwidth;?> aesop-caption-<?php echo $atts['captionposition'];?>">
				<div class="aesop-image-component-image aesop-component-align-<?php echo $atts['align'];?>" <?php echo $offsetstyle;?>>
					<?php

					if('on' == $atts['lightbox']) { ?>

						<a class="swipebox" href="<?php echo $atts['img'];?>">
							<p class="aesop-img-enlarge"><i class="aesopicon aesopicon-search-plus"></i> Enlarge</p>
							<img style="width:<?php echo $atts['imgwidth'];?>;" src="<?php echo $atts['img'];?>" alt="<?php echo $atts['alt'];?>">
						</a>

					<?php } else { ?>

						<img style="width:<?php echo $atts['imgwidth'];?>;" src="<?php echo $atts['img'];?>" alt="<?php echo $atts['alt'];?>">

					<?php }

					if ($atts['caption']) { ?>

						<div class="aesop-image-component-caption">
							<?php

							echo $atts['caption'];

							if($atts['credit']){ ?>
								<p class="aesop-cap-cred"><?php echo $atts['credit'];?></p>
							<?php } ?>

						</div>

					<?php } ?>

				</div>
			</div>

			<?php do_action('aesop_image_component_inside_bottom'); //action ?>

		</aside>
		<?php
		do_action('aesop_image_component_after'); //action

		return ob_get_clean();
	}
}