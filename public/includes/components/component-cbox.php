<?php

/**
 	* Creates an content section that can do offset text, iamge backgrounds, and magazine style columns
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_content_shortcode')){

	function aesop_content_shortcode($atts, $content = null) {

		// let this be used multiple times
		$hash = rand();

		$defaults = array(
			'width'				=> '100%',
			'columns'			=>'',
			'img' 				=> 'http://placekitten.com/100/100',
			'color' 				=> 'John Doe'
		);

		$atts = apply_filters('aesop_content_defaults',shortcode_atts($defaults, $atts));

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'is-content-width' : false;

		// are we doing columns or image and do a clas based on it
		$columns = $atts['columns'] ? sprintf('aesop-content-columns-%s',$atts['columns']) : false;
		$image = $atts['img'] ? 'aesop-content-img' : false;
		$typeclass = $columns.' '.$image;

		// image and width inline styles
		$imgstyle = $atts['img'] ? sprintf('background:url(\'%s\');background-size:cover;',$atts['img']) : false;
		$widthstyle = $atts['width'] ? sprintf('width:%s;',$atts['width']) : false;

		// all together
		$scinner = sprintf('<div class="%s" style="%s%s">%s</div>',$typeclass, $imgstyle, $widthstyle, do_shortcode($content));

		$out = sprintf('<section class="aesop-component aesop-content-component %s">%s</section>',$contentwidth,$scinner);

		return apply_filters('aesop_content_output',$out);
	}
}