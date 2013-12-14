<?php

/**
 	* Creates a character element that when clicked will open character into in modal. Can link to other characters.
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_character_shortcode')){

	function aesop_character_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> 'http://placekitten.com/180/300',
			'name' 				=> 'John Doe',
			'position' 			=> 'right',
		);

		$atts = apply_filters('aesop_character_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		$out = '';


		return apply_filters('aesop_character_output',$out);
	}
}