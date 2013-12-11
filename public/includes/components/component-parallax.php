<?php

if (!function_exists('aesop_parallax_shortcode')){

	function aesop_parallax_shortcode($atts, $content = null) {

		$defaults = array(
			'img' => 'http://placekitten.com/1200/700',
			'height' => 500,
			'cappos' => 'bottom-left',
			'speed'	 => 0.15,
			'lightbox' => false
		);
		$atts = shortcode_atts($defaults, $atts);

		$hash = rand();

		$style = sprintf('style="background-image:url(\'%s\');background-size:cover;height:%spx;"',$atts['img'],$atts['height']);
		$lblink = 'on' == $atts['lightbox'] ? sprintf('<a class="aesop-lb-link swipebox" rel="lightbox" title="%s" href="%s"><i class="sorencon sorencon-search-plus"></i></a>',do_shortcode($content),$atts['img']) : false;

		$out = sprintf('<section class="aesop-parallax-sc aesop-parallax-sc-%s" %s data-0="background-position:0px 0px;" data-500="background-position:0px -250px;">', $hash, $style);

		$out .= sprintf('<div class="aesop-parallax-sc-caption-wrap %s"><div class="aesop-parallax-sc-caption">%s</div></div>%s</section>', $atts['cappos'], do_shortcode($content), $lblink);

		return $out;
	}
}