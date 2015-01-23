<?php

/**
 	* Creates a styled quote with large type
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
			'align'		=> 'center',
			'size'		=> '1',
			'parallax'  => '',
			'direction' => '',
			'quote'		=> 'Quote',
			'cite'		=> 'Cite',

		);
		$atts = apply_filters('aesop_quote_defaults',shortcode_atts($defaults, $atts));

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf('%s-%s',get_the_ID(), $instance);

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// set size
		$size_unit 	= apply_filters( 'aesop_quote_size_unit', 'em', $unique );
		$size 		= $atts['size'] ? sprintf( '%s%s', $atts['size'], $size_unit ) : false;

		//bg img
		$bgimg = $atts['img'] ? sprintf('background-image:url(%s);background-size:cover;background-position:center center',esc_url( $atts['img'] )) : false;

		// set styles
		$style = $atts['background'] || $atts['text'] || $atts['height'] || $atts['width'] ? sprintf('style="background-color:%s;%s;color:%s;height:%s;width:%s;"',esc_attr( $atts['background'] ), $bgimg, esc_attr( $atts['text'] ), esc_attr( $atts['height'] ), esc_attr( $atts['width'] )) : false;

		$isparallax = 'on' == $atts['parallax'] ? 'quote-is-parallax' : false;
		$lrclass	= 'left' == $atts['direction'] || 'right' == $atts['direction'] ? 'quote-left-right' : false;

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'quote', '' ) : null;

		// cite
		$cite = $atts['cite'] ? apply_filters('aesop_quote_component_cite',sprintf('<cite class="aesop-quote-component-cite">%s</cite>',esc_html( $atts['cite'] ))) : null;

		//align
		$align = $atts['align'] ? sprintf('aesop-component-align-%s', esc_attr($atts['align'])) : null;

		ob_start();

		do_action('aesop_quote_before'); //action
		?>
			<div id="aesop-quote-component-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'quote', $unique, $atts );?> class="aesop-component aesop-quote-component <?php echo sanitize_html_class( $classes ).' '.sanitize_html_class( $align ).' '.sanitize_html_class( $contentwidth ).' '.sanitize_html_class( $isparallax ).' '.sanitize_html_class( $lrclass ).' ';?>" <?php echo $style;?>>
				<!-- Aesop Core | Quote -->
				<script>
					jQuery(document).ready(function(){

						var moving 		= jQuery('#aesop-quote-component-<?php echo esc_attr( $unique );?> blockquote'),
							component   = jQuery('#aesop-quote-component-<?php echo esc_attr( $unique );?>');

						// if parallax is on and we're not on mobile
						<?php if ( 'on' == $atts['parallax'] && !wp_is_mobile() ) { ?>

					       	function scrollParallax(){
					       	    var height 			= jQuery(component).height(),
        	        				offset 			= jQuery(component).offset().top,
						       	    scrollTop 		= jQuery(window).scrollTop(),
						       	    windowHeight 	= jQuery(window).height(),
						       	    position 		= Math.round( scrollTop * 0.1 );

						       	// only run parallax if in view
						       	if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
									return;
								}

					            jQuery(moving).css({'transform':'translate3d(0px,-' + position + 'px, 0px)'});

					       	    <?php if ('left' == $atts['direction']){ ?>
					            	jQuery(moving).css({'transform':'translate3d(-' + position + 'px, 0px, 0px)'});
					            <?php } elseif ( 'right' == $atts['direction'] ) { ?>
									jQuery(moving).css({'transform':'translate3d(' + position + 'px, 0px, 0px)'});
					            <?php } ?>
					       	}
					       	jQuery(component).waypoint({
								offset: '100%',
								handler: function(direction){
						   			jQuery(this).toggleClass('aesop-quote-faded');

						   			// fire parallax
						   			scrollParallax();
									jQuery(window).scroll(function() {scrollParallax();});
							   	}
							});

						<?php } else { ?>

							jQuery(moving).waypoint({
								offset: '90%',
								handler: function(direction){
							   		jQuery(this).toggleClass('aesop-quote-faded');

							   	}
							});
						<?php } ?>

					});
				</script>

				<?php do_action('aesop_quote_inside_top'); //action ?>

				<blockquote class="<?php echo sanitize_html_class( $align );?>" style="font-size:<?php echo esc_attr( $size);?>;">
					<span><?php echo esc_html( $atts['quote'] );?></span>

					<?php echo $cite;?>
				</blockquote>

				<?php do_action('aesop_quote_inside_bottom'); //action ?>

			</div>
		<?php
		do_action('aesop_quote_after'); //action

		return ob_get_clean();
	}
}