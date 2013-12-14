<?php

/**
 	* Creates a parallax component with background image, caption, lightbox, and optional "floater" item which can also be parallax, with multiple position and directions.
 	*
 	* @since    1.0.0
*/

if (!function_exists('aesop_parallax_shortcode')){

	function aesop_parallax_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> 'http://placekitten.com/1200/700',
			'height' 			=> 500,
			'parallaxbg' 		=> 'on',
			'parallaxspeed'		=> 0.15,
			'floater' 			=> false,
			'floatermedia' 		=> '',
			'floaterposition' 	=> 'right',
			'floaterdirection'	=> 'up',
			'captionposition' 	=> 'bottom-left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_parallax_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();

		// final destination of the floater is half the height of the viewport that's set
		$floaterdestination = $atts['height'] / 2;

		$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
		$style 		= sprintf('style="background-image:url(\'%s\');background-size:cover;"',$atts['img'],$atts['height']);

		$animateup = sprintf('data-top-bottom="transform: translate3d(0px, 0px, 0px);" data-bottom-top="transform: translate3d(0px, %spx, 0px);"',$atts['height']);
		$animatedown = sprintf('data-top-bottom="transform: translate3d(0px, %spx, 0px);" data-bottom-top="transform: translate3d(0px, 0px, 0px);"',$atts['height']);

		$itemanimate = 'up' == $atts['floaterdirection'] ? $animateup : $animatedown;
		$lblink 	= 'on' == $atts['lightbox'] ? sprintf('<a class="aesop-lb-link swipebox" rel="lightbox" title="%s" href="%s"><i class="sorencon sorencon-search-plus">+</i></a>',do_shortcode($content),$atts['img']) : false;
		$floater 	= 'on' == $atts['floater'] ? sprintf('<div class="aesop-parallax-sc-floater floater-%s" %s>%s</div>', $atts['floaterposition'], $itemanimate , $atts['floatermedia']) : false;


		$out = sprintf('<section class="aesop-component aesop-parallax-component" style="height:%spx;">',$atts['height']);

		// Call Parallax Method if Set
		if ('on' == $atts['parallaxbg']) {

			$out .= sprintf('
				<script>
				jQuery(document).ready(function(){
			   		jQuery(\'.aesop-parallax-sc.aesop-parallax-sc-%s .aesop-parallax-sc-img\').parallax({
			    		speed: %s
			    	});
			        var viewport = jQuery(\'.aesop-parallax-sc.aesop-parallax-sc-%s\').outerHeight();
        			jQuery(\'.aesop-parallax-sc.aesop-parallax-sc-%s .aesop-parallax-sc-img.is-parallax\').css({\'height\': viewport * 1.65});
				});
			</script>',$hash,$atts['parallaxspeed'], $hash, $hash);
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