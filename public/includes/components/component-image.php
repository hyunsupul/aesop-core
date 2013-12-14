<?php

if (!function_exists('aesop_image_shortcode')){

	function aesop_image_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> 'http://placekitten.com/1200/700',
			'position' 			=> 'left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_image_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();

		$out = '';

		//$shcode = '[caption id="' . $id . '" align="align' . $align        . '" width="' . $width . '"]' . $html . ' ' . $caption . '[/caption]';

		return apply_filters('aesop_image_output',$out);
	}
}