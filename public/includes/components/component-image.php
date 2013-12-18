<?php
/**
 	* Essentially a clone of the image gallery shortcode in wordpress core.
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_image_shortcode')){

	function aesop_image_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> 'http://placekitten.com/1200/700',
			'alt'				=> '',
			'align' 			=> 'left',
			'captionposition'	=> 'bottom',
			'width'				=> '300px',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_image_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		$caption = $content ? sprintf('<span class="aesop-image-component-caption">%s</div>', $content) : false;
		$core = sprintf('<div class="aesop-image-component-image aesop-caption-%s"><img src="%s" alt="%s">%s</div>',$atts['captionposition'], $atts['img'], $atts['alt'], $caption);
		$out = sprintf('<section class="aesop-component aesop-image-component aesop-component-align-%s">%s</section>',$atts['align'],$core);

		return apply_filters('aesop_image_output',$out);
	}
}