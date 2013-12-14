<?php

// popup character modal thingee
if (!function_exists('aesop_gallery_shortcode')){

	function aesop_gallery_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> 'http://placekitten.com/180/300',
			'name' 				=> 'John Doe',
			'position' 			=> 'right',
		);

		$atts = apply_filters('aesop_gallery_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		$out = '';


		return apply_filters('aesop_gallery_output',$out);
	}
}