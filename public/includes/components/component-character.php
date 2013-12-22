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
			'caption'			=> '',
			'align' 			=> 'left',
		);

		$atts = apply_filters('aesop_character_defaults',shortcode_atts($defaults, $atts));

		$img 	= sprintf('<img class="aesop-character-avatar" src="%s" alt="">', $atts['img']);
		$name 	= sprintf('<span class="aesop-character-title">%s</span>',$atts['name']);
		$txt 	= sprintf('<div class="aesop-character-text">%s</div>',do_shortcode($content));

		$caption = $atts['caption'] ? sprintf('<p class="aesop-character-cap">%s</p>',$atts['caption']) : false;
		
		$whole 	= sprintf('<div class="aesop-character-inner aesop-content "><div class="aesop-character-float aesop-character-%s">%s%s%s%s</div></div>', $atts['align'], $name, $img, $txt, $caption);

		// character wrap
		$out 	= sprintf('<aside class="aesop-character-component ">%s</aside>',  $whole);

		return apply_filters('aesop_character_output',$out);
	}
}