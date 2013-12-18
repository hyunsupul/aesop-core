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
			'align'		=> '',
			'background' => '#222222',
			'text' 		=> '#FFFFFF',
			'height'	=> 'auto'
		);
		$atts = apply_filters('aesop_quote_defaults',shortcode_atts($defaults, $atts));
		
		// use multiple times
		$hash = rand();

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// set styles
		$style = $atts['background'] || $atts['text'] || $atts['height'] ? sprintf('style="background:%s;color:%s;height:%s;"',$atts['background'], $atts['text'], $atts['height']) : false;

		// start wrapper
		$out = sprintf('<section id="aesop-quote-component-%s" class="aesop-component aesop-quote-component %s" %s>',$hash,$contentwidth, $style);

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
		$out .= sprintf('<blockquote>%s</blockquote></section>',do_shortcode($content));

		return apply_filters('aesop_quote_output',$out);
	}
}