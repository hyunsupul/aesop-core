<?php

/**
 	* Creates an interactive character element
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_character_shortcode')){

	function aesop_character_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> '',
			'name' 				=> '',
			'caption'			=> '',
			'align' 			=> 'left',
			'width'				=> ''
		);

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf('%s-%s',get_the_ID(), $instance);

		$atts = apply_filters('aesop_character_defaults',shortcode_atts($defaults, $atts));

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'character', '' ) : null;

		// width styles
		$styles = $atts['width'] ? sprintf('style="width:%s;"',$atts['width']) : null;

		// wrapper float class
		$float = $atts['align'] ? sprintf('aesop-component-align-%s', $atts['align']) : null;

		// character wrap
		ob_start();

			do_action('aesop_character_before'); //action
			?>
				<aside id="aesop-character-component-<?php echo $unique;?>" class="aesop-character-component <?php echo $classes.''.$float;?> ">

					<?php do_action('aesop_character_inside_top'); //action ?>

					<div class="aesop-character-inner aesop-content">
						<div class="aesop-character-float aesop-character-<?php echo $atts['align'];?>" <?php echo $styles;?>>

							<?php do_action('aesop_character_inner_inside_top'); //action ?>

							<?php if ($atts['name']) {?>
								<span class="aesop-character-title"><?php echo $atts['name'];?></span>
							<?php } ?>

							<?php if ($atts['img']) {?>
								<img class="aesop-character-avatar" src="<?php echo $atts['img'];?>" alt="">
							<?php } ?>

							<?php if ($content) {?>
								<div class="aesop-character-text"><?php echo do_shortcode($content);?></div>
							<?php } ?>

							<?php if ($atts['caption']) { ?>
								<p class="aesop-character-cap"><?php echo $atts['caption'];?></p>
							<?php } ?>

							<?php do_action('aesop_character_inner_inside_bottom'); //action  ?>

						</div>
					</div>

					<?php do_action('aesop_character_inside_bottom'); //action ?>

				</aside>
			<?php

			do_action('aesop_character_after'); //action

		return ob_get_clean();
	}
}