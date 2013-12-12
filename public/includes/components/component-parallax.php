<?php

if (!function_exists('aesop_parallax_shortcode')){

	function aesop_parallax_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> 'http://placekitten.com/1200/700',
			'height' 			=> 500,
			'parallaxbg' 		=> 'on',
			'parallaxspeed'		=> 0.3,
			'floater' 			=> false,
			'floatermedia' 		=> '',
			'floaterposition' 	=> 'right',
			'captionposition' 	=> 'bottom-left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_parallax_defaults',shortcode_atts($defaults, $atts));

		$out = '';
		$hash = rand();

		// final destination of the floater is half the height of the viewport that's set
		$floaterdestination = $atts['height'] / 2;

		$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
		$style 		= sprintf('style="background-image:url(\'%s\');background-size:cover;"',$atts['img'],$atts['height']);
		$lblink 	= 'on' == $atts['lightbox'] ? sprintf('<a class="aesop-lb-link swipebox" rel="lightbox" title="%s" href="%s"><i class="sorencon sorencon-search-plus">+</i></a>',do_shortcode($content),$atts['img']) : false;
		$floater 	= 'on' == $atts['floater'] ? sprintf('<div class="aesop-parallax-sc-floater floater-%s" data-top-bottom="margin-top:20px;" data-bottom-top="margin-top:%spx;">%s</div>', $atts['floaterposition'], $floaterdestination, $atts['floatermedia']) : false;


		$out = sprintf('<section class="aesop-component aesop-parallax-component">');

		// Call Parallax Method if Set
		if ('on' == $atts['parallaxbg']) {
			$out .= sprintf('
				<script>
			jQuery(document).ready(function(){
		   		jQuery(\'.aesop-parallax-sc.aesop-parallax-sc-%s .aesop-parallax-sc-img\').parallax({
		    		speed: %s
		    	});
			});
			</script>',$hash,$atts['parallaxspeed']);
		}

		$out 	.= sprintf('<div class="aesop-parallax-sc aesop-parallax-sc-%s" style="height:%spx;">
								%s
								<div class="aesop-parallax-sc-caption-wrap %s">
									<div class="aesop-parallax-sc-caption">%s</div>
								</div>
								%s
								<div class="aesop-parallax-sc-img %s" %s></div>
							</div></section>',$hash, $atts['height'], $floater, $atts['captionposition'], do_shortcode($content), $lblink, $laxclass, $style);

		return apply_filters('aesop_parallax_output',$out);
	}
}