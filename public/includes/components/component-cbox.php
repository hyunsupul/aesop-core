<?php

/**
 	* Creates an content section that can do offset text, image backgrounds, and magazine style columns
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
			'position'			=> 'center',
			'img' 				=> '',
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
		$bgcolor = $atts['background'] ? sprintf('background-color:%s;',$atts['background']) : false;
		$imgstyle = $atts['img'] ? sprintf('%sbackground-image:url(\'%s\');background-size:cover;background-position:center center;',$bgcolor, $atts['img']) : false;
		

		$widthstyle = $atts['width'] ? sprintf('style="width:%s;margin-left:auto;margin-right:auto;"',$atts['width']) : false;
		$txtcolor 	= $atts['color'] ? sprintf('color:%s;', $atts['color']) : false;
		$position	= ('left' == $atts['position'] || 'right' == $atts['position']) ? sprintf('float:%s',$atts['position']) : false;
			$itemstyle = $imgstyle || $position || $txtcolor ? sprintf('style="%s%s%s%s"',$imgstyle,$position, $txtcolor, $bgcolor) : false;

		// all together
		$scinner = sprintf('<div id="aesop-content-component-%s" class="aesop-content-comp-wrap %s" %s><div class="aesop-content-comp-inner" %s>%s</div></div>',$hash,$typeclass, $itemstyle, $widthstyle, do_shortcode($content));

		$out = sprintf('%s<section class="aesop-component aesop-content-component %s">%s%s%s</section>%s',$actiontop, $contentwidth, $actioninsidetop, $scinner, $actioninsidebottom, $actionbottom);

		return apply_filters('aesop_cbox_output',$out);
	}
}