<?php

// popup character modal thingee
if (!function_exists('aesop_video_shortcode')){

	function aesop_video_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> 'http://placekitten.com/180/300',
			'name' 				=> 'John Doe',
			'position' 			=> 'right',
		);

		$atts = apply_filters('aesop_video_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		$out = '';


		return apply_filters('aesop_video_output',$out);
	}
}