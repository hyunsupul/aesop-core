<?php

/**
 	* Creates an interactive character element
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_chapter_shortcode')){

	function aesop_chapter_shortcode($atts, $content = null) {
		$defaults = array(
			'num' => 1,
		);
		$atts = shortcode_atts($defaults, $atts);

		$out = sprintf('<h2 class="aesop-chapter-heading">%s</h2>',$atts['num']);
		return $out;
	}
}