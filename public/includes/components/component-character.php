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
			'img' 				=> '',
			'name' 				=> '',
			'caption'			=> '',
			'align' 			=> 'left',
		);

		$atts = apply_filters('aesop_character_defaults',shortcode_atts($defaults, $atts));

		$img 	= sprintf('<img class="aesop-character-avatar" src="%s" alt="">', $atts['img']);
		$name 	= sprintf('<span class="aesop-character-title">%s</span>',$atts['name']);
		$txt 	= sprintf('<div class="aesop-character-text">%s</div>',do_shortcode($content));

		$actiontop = do_action('aesop_character_before');
		$actionbottom = do_action('aesop_character_after');
		$actioninsidetop = do_action('aesop_character_inside_top');
		$actioninsidebottom = do_action('aesop_character_inside_bottom');

		$caption = $atts['caption'] ? sprintf('<p class="aesop-character-cap">%s</p>',$atts['caption']) : false;
		
		$whole 	= sprintf('<div class="aesop-character-inner aesop-content "><div class="aesop-character-float aesop-character-%s">%s%s%s%s</div></div>', $atts['align'], $name, $img, $txt, $caption);

		// character wrap
		$out 	= sprintf('%s<aside class="aesop-character-component ">%s%s%s</aside>%s',  $actiontop, $actioninsidetop, $whole, $actioninsidebottom, $actionbottom);

		return apply_filters('aesop_character_output',$out);
	}
}