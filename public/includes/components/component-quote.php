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

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// set size
		$size = $atts['size'] ? sprintf('%srem', $atts['size']) : false;

		//bg img
		$bgimg = $atts['img'] ? sprintf('background-image:url(%s);background-size:cover;background-position:center center',$atts['img']) : false;

		// set styles
		$style = $atts['background'] || $atts['text'] || $atts['height'] || $atts['width'] ? sprintf('style="background-color:%s;%s;color:%s;height:%s;width:%s;"',$atts['background'], $bgimg, $atts['text'], $atts['height'], $atts['width']) : false;

		$isparallax = 'on' == $atts['parallax'] ? 'quote-is-parallax' : false;


		ob_start();

		do_action('aesop_quote_before'); //action
		?>
			<div id="aesop-quote-component-<?php echo $hash;?>" class="aesop-component aesop-quote-component <?php echo $contentwidth.' '.$isparallax;?>" <?php echo $style;?>>

				<!-- Aesop Core | Quote -->
				<script>
					jQuery(document).ready(function(){
						jQuery('#aesop-quote-component-<?php echo $hash;?> blockquote').waypoint({
							offset: 'bottom-in-view',
							handler: function(direction){
						   		jQuery(this).toggleClass('aesop-quote-faded');
						   	}
						});
						<?php if ( 'on' == $atts['parallax'] ) { ?>
							var obj = jQuery('#aesop-quote-component-<?php echo $hash;?> blockquote');
					       	function scrollParallax(){
					       	    var floater = (jQuery(window).scrollTop() / 6) - <?php echo sanitize_text_field($atts['offset']);?>;
					            jQuery(obj).css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});
					       	}
					       	scrollParallax();
							jQuery(window).scroll(function() {scrollParallax();});
						<?php } ?>
					});
				</script>

				<?php do_action('aesop_quote_inside_top'); //action ?>

				<blockquote class="aesop-component-align-<?php echo $atts['align'];?>" style="font-size:<?php echo $size;?>;">
					<?php echo $atts['quote'];?>
				</blockquote>

				<?php do_action('aesop_quote_inside_bottom'); //action ?>

			</div>
		<?php
		do_action('aesop_quote_after'); //action

		return ob_get_clean();
	}
}