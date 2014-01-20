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
			'parallaxspeed'		=> 0.1,
			'floater' 			=> false,
			'floatermedia' 		=> '',
			'floaterposition' 	=> 'right',
			'floaterdirection'	=> 'up',
			'caption'			=> '',
			'captionposition' 	=> 'bottom-left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_parallax_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();


		// actions
		$actiontop = do_action('aesop_parallax_component_before');
		$actionbottom = do_action('aesop_parallax_component_after');
		$actioninsidetop = do_action('aesop_parallax_component_inside_top');
		$actioninsidebottom = do_action('aesop_parallax_component_inside_bottom');

		// final destination of the floater is half the height of the viewport that's set
		$floaterdestination = $atts['height'] / 2;

		$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
		$style 		= sprintf('style="background-image:url(\'%s\');background-size:cover;"',$atts['img'],$atts['height']);

		$animateup = sprintf('data-speed="8"');
		$animatedown = sprintf('data-speed="8"');

		$itemanimate = 'up' == $atts['floaterdirection'] ? $animateup : $animatedown;
		$lblink 	= 'on' == $atts['lightbox'] ? sprintf('<a class="aesop-lb-link swipebox" rel="lightbox" title="%s" href="%s"><i class="aesopicon aesopicon-search-plus"></i></a>',$atts['caption'],$atts['img']) : false;
		$floater 	= 'on' == $atts['floater'] ? sprintf('<div class="aesop-parallax-sc-floater floater-%s" %s>%s</div>', $atts['floaterposition'], $itemanimate , $atts['floatermedia']) : false;

		// caption
		$caption = $atts['caption'] ? sprintf('<div class="aesop-parallax-sc-caption-wrap %s"><div class="aesop-parallax-sc-caption">%s</div></div>',$atts['captionposition'], $atts['caption']) : false;

		$out = sprintf('%s<section class="aesop-component aesop-parallax-component" style="height:%spx;">%s',$actiontop,$atts['height'], $actioninsidetop);

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

					var obj = jQuery(\'.aesop-parallax-sc.aesop-parallax-sc-%s .aesop-parallax-sc-floater\');
			        jQuery(window).scroll(function() {
			            var floater = (jQuery(window).scrollTop() / jQuery(obj).data(\'speed\') - viewport);
			            var pos = floater + \'px\';
			            jQuery(obj).css({\'transform\':\'translate3d(0px,\' + pos + \', 0px)\'});
			        });

				});
			</script>',$hash,$atts['parallaxspeed'], $hash, $hash, $hash);
		}

		$out 	.= sprintf('<div class="aesop-parallax-sc aesop-parallax-sc-%s" style="height:%spx;">%s%s%s<div class="aesop-parallax-sc-img %s" %s></div></div>%s</section>%s',
							$hash,
							$atts['height'],
							$floater,
							$caption,
							$lblink,
							$laxclass,
							$style,
							$actioninsidebottom,
							$actionbottom
							);

		return apply_filters('aesop_parallax_output',$out);
	}
}