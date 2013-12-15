<?php

/**
 	* Creates an interactive character element
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_character_shortcode')){

	function aesop_character_shortcode($atts, $content = null) {
		
		// let this be used multiple times
		$hash = rand();
		
		$defaults = array(
			'img' 				=> 'http://placekitten.com/100/100',
			'name' 				=> 'John Doe',
			'position' 			=> 'left',
		);

		$atts = apply_filters('aesop_character_defaults',shortcode_atts($defaults, $atts));


		$img 	= sprintf('<img class="aesop-character-avatar" src="%s" alt=""', $atts['img']);
		$name 	= sprintf('<h5 class="aesop-character-title">%s</h5>',$atts['name']);
		$txt 	= sprintf('<div class="aesop-character-text">%s</div>',do_shortcode($content));
		$whole 	= sprintf('<div class="aesop-character-wrap aesop-character-wrap-%s aesop-character-%s">%s%s%s</div>',$hash, $atts['position'], $img, $name, $txt);

		// character wrap
		$out 	= sprintf('<aside class="aesop-component aesop-character-component">%s</aside>', $whole);

		return apply_filters('aesop_character_output',$out);
	}
}