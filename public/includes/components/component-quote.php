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
			'text' 		=> '#FFFFFF',
			'height'	=> 'auto',
			'align'		=> 'left',
			'quote'		=> ''
		);
		$atts = apply_filters('aesop_quote_defaults',shortcode_atts($defaults, $atts));
		
		// use multiple times
		$hash = rand();

		// actions
		$actiontop = do_action('aesop_quote_component_before');
		$actionbottom = do_action('aesop_quote_component_after');
		$actioninsidetop = do_action('aesop_quote_component_inside_top');
		$actioninsidebottom = do_action('aesop_quote_component_inside_bottom');

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// set styles
		$style = $atts['background'] || $atts['text'] || $atts['height'] || $atts['width'] ? sprintf('style="background:%s;color:%s;height:%s;width:%s;"',$atts['background'], $atts['text'], $atts['height'], $atts['width']) : false;

		// start wrapper
		$out = sprintf('%s<section id="aesop-quote-component-%s" class="aesop-component aesop-quote-component %s" %s>%s',$actiontop, $hash,$contentwidth, $style, $actioninsidetop);

		// call waypoints
		$out .= sprintf('<script>
		jQuery(document).ready(function(){
			jQuery(\'#aesop-quote-component-%s blockquote\').waypoint({
				offset: \'bottom-in-view\',
				handler: function(direction){
			   		jQuery(this).toggleClass(\'aesop-quote-faded\');
			   	}
			});
		});
		</script>', $hash);

		// output
		$out .= sprintf('<blockquote class="aesop-component-align-%s">%s</blockquote>%s</section>%s',$atts['align'],$atts['quote'],$actioninsidebottom, $actionbottom);

		return apply_filters('aesop_quote_output',$out);
	}
}