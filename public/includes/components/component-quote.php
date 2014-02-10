<?php

/**
 	* Audio component utilizes core wordpress audio
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_quote_shortcode')){

	function aesop_quote_shortcode($atts, $content = null) {

		$defaults = array(
			'width'		=> '100%',
			'background' => '#222222',
			'img'		=> '',
			'text' 		=> '#FFFFFF',
			'height'	=> 'auto',
			'align'		=> 'left',
			'size'		=> '4',
			'parallax'  => '',
			'offset'	=> 500,
			'quote'		=> '',

		);
		$atts = apply_filters('aesop_quote_defaults',shortcode_atts($defaults, $atts));
		
		// use multiple times
		$hash = rand();

		// actions
		$actiontop = do_action('aesop_quote_before'); //action
		$actionbottom = do_action('aesop_quote_after'); //action
		$actioninsidetop = do_action('aesop_quote_inside_top'); //action
		$actioninsidebottom = do_action('aesop_quote_inside_bottom'); //action

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// set size
		$size = $atts['size'] ? sprintf('%srem', $atts['size']) : false;

		//bg img
		$bgimg = $atts['img'] ? sprintf('background-image:url(%s);background-size:cover;background-position:center center',$atts['img']) : false;

		// set styles
		$style = $atts['background'] || $atts['text'] || $atts['height'] || $atts['width'] ? sprintf('style="background-color:%s;%s;color:%s;height:%s;width:%s;"',$atts['background'], $bgimg, $atts['text'], $atts['height'], $atts['width']) : false;

		$isparallax = 'on' == $atts['parallax'] ? 'quote-is-parallax' : false;
		//parallax
		$parallax = 'on' == $atts['parallax'] ? sprintf('
				var obj = jQuery(\'#aesop-quote-component-%s blockquote\');
		       	function scrollParallax(){
		       	    var floater = (jQuery(window).scrollTop() / 6) - %s;
		            jQuery(obj).css({\'transform\':\'translate3d(0px,-\' + floater + \'px, 0px)\'});

		       	}
		       	scrollParallax();
				jQuery(window).scroll(function() {scrollParallax();});
			',$hash, $atts['offset']) : false;

		// start wrapper
		$out = sprintf('%s<section id="aesop-quote-component-%s" class="aesop-component aesop-quote-component %s %s" %s>%s',$actiontop, $hash,$contentwidth, $isparallax, $style, $actioninsidetop);

		// call waypoints
		$out .= sprintf('<script>
		jQuery(document).ready(function(){
			jQuery(\'#aesop-quote-component-%s blockquote\').waypoint({
				offset: \'bottom-in-view\',
				handler: function(direction){
			   		jQuery(this).toggleClass(\'aesop-quote-faded\');
			   	}
			});
		%s
		});
		</script>', $hash,$parallax);

		// output
		$out .= sprintf('<blockquote class="aesop-component-align-%s" style="font-size:%s;">%s</blockquote>%s</section>%s',$atts['align'],$size,$atts['quote'],$actioninsidebottom, $actionbottom);

		return apply_filters('aesop_quote_output',$out);
	}
}