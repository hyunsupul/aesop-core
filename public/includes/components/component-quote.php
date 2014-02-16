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
			'speed' 	=> 8,
			'direction' => '',
			'offset'	=> 300,
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
		$lrclass	= 'left' == $atts['direction'] || 'right' == $atts['direction'] ? 'quote-left-right' : false;


		ob_start();

		do_action('aesop_quote_before'); //action
		?>
			<div id="aesop-quote-component-<?php echo $hash;?>" class="aesop-component aesop-quote-component <?php echo $contentwidth.' '.$isparallax.' '.$lrclass.' ';?>" <?php echo $style;?>>

				<!-- Aesop Core | Quote -->
				<script>
					jQuery(document).ready(function(){

						var obj = jQuery('#aesop-quote-component-<?php echo $hash;?> blockquote');

						<?php if ( 'on' == $atts['parallax'] ) { ?>

					       	function scrollParallax(){
					       	    var floater = (jQuery(window).scrollTop() / <?php echo sanitize_text_field($atts['speed']);?>) - <?php echo sanitize_text_field($atts['offset']);?>;

					            jQuery(obj).css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});

					       	    <?php if ('left' == $atts['direction'] || 'right' == $atts['direction']){

									if ('left' == $atts['direction']){ ?>
					            		jQuery(obj).css({'transform':'translate3d(' + floater + 'px, 0px, 0px)'});
					            	<?php } else { ?>
										jQuery(obj).css({'transform':'translate3d(-' + floater + 'px, 0px, 0px)'});
					            	<?php }

					       	    } else {

					       	    	if ('up' == $atts['direction']){ ?>
					            		jQuery(obj).css({'transform':'translate3d(0px,' + floater + 'px, 0px)'});
									<?php } else { ?>
										jQuery(obj).css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});
									<?php }
					            } ?>
					       	}
					       	jQuery(obj).waypoint({
								offset: 'bottom-in-view',
								handler: function(direction){
						   			jQuery(this).toggleClass('aesop-quote-faded');

						   			// fire parallax
						   			scrollParallax();
									jQuery(window).scroll(function() {scrollParallax();});
							   	}
							});

						<?php } else { ?>

							jQuery(obj).waypoint({
								offset: 'bottom-in-view',
								handler: function(direction){
							   		jQuery(this).toggleClass('aesop-quote-faded');

							   	}
							});
						<?php } ?>

					});
				</script>

				<?php do_action('aesop_quote_inside_top'); //action ?>

				<blockquote class="aesop-component-align-<?php echo $atts['align'];?>" style="font-size:<?php echo sanitize_text_field($atts['size']);?>;">
					<?php echo $atts['quote'];?>
				</blockquote>

				<?php do_action('aesop_quote_inside_bottom'); //action ?>

			</div>
		<?php
		do_action('aesop_quote_after'); //action

		return ob_get_clean();
	}
}