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
			'offset'			=> '',
			'alt'				=> '',
			'align' 			=> 'left',
			'captionposition'	=> 'bottom',
			'lightbox' 			=> 'off'
		);

		$atts = apply_filters('aesop_image_defaults',shortcode_atts($defaults, $atts));

		// global component content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// draw caption
		$caption = $content ? sprintf('<div class="aesop-image-component-caption">%s</div>', $content) : false;

		// offset styles
		$offsetstyle = $atts['offset'] ? sprintf('style="margin-%s:%s;"',$atts['align'], $atts['offset']) : false;

		// get the image
		$image = 'on' == $atts['lightbox'] ?
										sprintf('<a class="swipebox" href="%s"><img style="width:%s;" src="%s" alt="%s"></a>', $atts['img'],$atts['imgwidth'], $atts['img'], $atts['alt']) : 
										sprintf('<img style="width:%s;" src="%s" alt="%s">',$atts['imgwidth'], $atts['img'], $atts['alt']);

		// draw core
		$core = sprintf('<div class="%s aesop-caption-%s">
							<div class="aesop-image-component-image aesop-component-align-%s" %s>
								%s
								%s
								</div>
								</div>',$contentwidth, $atts['captionposition'],$atts['align'], $offsetstyle, $image, $caption);

		// combine into component shell
		$out = sprintf('<aside class="aesop-component aesop-image-component">%s</aside>',$core);

		return apply_filters('aesop_image_output',$out);
	}
}