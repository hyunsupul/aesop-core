<?php

if (!function_exists('aesop_parallax_shortcode')){

	function aesop_parallax_shortcode($atts, $content = null) {

		$defaults = array(
			'img' => 'http://placekitten.com/1200/700',
			'height' => 500,
			'speed'	=> 0.3,
			'floater' => false,
			'floatermedia' => '',
			'floaterposition' => 'right',
			'cappos' => 'bottom-left',
			'lightbox' => false
		);
		$atts = shortcode_atts($defaults, $atts);

		$hash = rand();

		$style = sprintf('style="background-image:url(\'%s\');background-size:cover;"',$atts['img'],$atts['height']);
		$lblink = 'on' == $atts['lightbox'] ? sprintf('<a class="aesop-lb-link swipebox" rel="lightbox" title="%s" href="%s"><i class="sorencon sorencon-search-plus">+</i></a>',do_shortcode($content),$atts['img']) : false;

		$floater = 'on' == $atts['floater'] ? sprintf('<div class="aesop-parallax-sc-floater floater-%s">%s</div>', $atts['floaterposition'], $atts['floatermedia']) : false;

		$out = sprintf('<script>
		jQuery(document).ready(function(){

		   		jQuery(\'.aesop-parallax-sc.aesop-parallax-sc-%s .aesop-parallax-sc-img\').parallax({
		    		speed: %s
		    	});
		});
		</script>',$hash,$atts['speed']);
		$out .= sprintf('<section class="aesop-parallax-sc aesop-parallax-sc-%s" style="height:%s;">', $hash, $atts['height']);


		$out .= sprintf('%s<div class="aesop-parallax-sc-caption-wrap %s"><div class="aesop-parallax-sc-caption">%s</div></div>%s<div class="aesop-parallax-sc-img" %s></div></section>', $floater, $atts['cappos'], do_shortcode($content), $lblink, $style);

		return $out;
	}
}