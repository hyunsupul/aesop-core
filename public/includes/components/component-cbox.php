<?php

/**
 	* Creates an content section that can do offset text, iamge backgrounds, and magazine style columns
 	*
 	* @since    1.0.0
 	* @TODO work in imgrepeat and imgposition attributes
*/
if (!function_exists('aesop_content_shortcode')){

	function aesop_content_shortcode($atts, $content = null) {

		// let this be used multiple times
		$hash = rand();

		$defaults = array(
			'width'				=> '100%',
			'columns'			=>'',
			'position'			=> 'center',
			'img' 				=> 'http://placekitten.com/100/100',
			'imgrepeat'			=> 'no-repeat',
			'imgposition'		=> '',
			'color' 			=> '#FFFFFF',
			'background'		=> '#333333'
		);

		$atts = apply_filters('aesop_content_defaults',shortcode_atts($defaults, $atts));

		// actions
		$actiontop = do_action('aesop_cbox_component_before');
		$actionbottom = do_action('aesop_cbox_component_after');
		$actioninsidetop = do_action('aesop_cbox_component_inside_top');
		$actioninsidebottom = do_action('aesop_cbox_component_inside_bottom');

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// are we doing columns or image and do a clas based on it
		$columns = $atts['columns'] ? sprintf('aesop-content-comp-columns-%s',$atts['columns']) : false;
		$image = $atts['img'] ? 'aesop-content-img' : false;
			$typeclass = $columns.' '.$image;

		// image and width inline styles
		$imgstyle = $atts['img'] ? sprintf('background:%s url(\'%s\');background-size:cover;background-position:center center;',$atts['background'], $atts['img']) : false;
		

		$widthstyle = $atts['width'] ? sprintf('width:%s;',$atts['width']) : false;
		$txtcolor 	= $atts['color'] ? sprintf('color:%s;', $atts['color']) : false;
		$position	= ('left' == $atts['position'] || 'right' == $atts['position']) ? sprintf('float:%s',$atts['position']) : false;
			$itemstyle = $imgstyle || $widthstyle || $position || $txtcolor ? sprintf('style="%s%s%s%s"',$imgstyle,$widthstyle,$position, $txtcolor) : false;

		// all together
		$scinner = sprintf('<div id="aesop-content-component-%s" class="%s" %s><div class="aesop-content-comp-inner">%s</div></div>',$hash,$typeclass, $itemstyle, do_shortcode($content));

		$out = sprintf('%s<section class="aesop-component aesop-content-component %s">%s%s%s</section>%s',$actiontop, $contentwidth, $actioninsidetop, $scinner, $actioninsidebottom, $actionbottom);

		return apply_filters('aesop_cbox_output',$out);
	}
}