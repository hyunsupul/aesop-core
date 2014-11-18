<?php

/**
 	* Creates a parallax component with background image, caption, lightbox, and optional "floater" item which can also be parallax, with multiple position and directions.
 	*
 	* @since    1.0.0
*/

if (!function_exists('aesop_parallax_shortcode')){

	function aesop_parallax_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> '',
			'height' 			=> 500,
			'parallaxbg' 		=> 'on',
			'floater' 			=> '',
			'floatermedia' 		=> '',
			'floaterposition' 	=> 'right',
			'floaterdirection'	=> 'up',
			'caption'			=> '',
			'captionposition' 	=> 'bottom-left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_parallax_defaults',shortcode_atts($defaults, $atts));

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf('%s-%s',get_the_ID(), $instance);

		$height = preg_replace('/[^0-9]/','',$atts['height']);

		$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
		$style 		= sprintf('style="background-image:url(\'%s\');background-size:cover;"', esc_url( $atts['img'] ));

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'parallax', '' ) : null;

		ob_start();

		do_action('aesop_parallax_before'); //action

			?><div class="aesop-component aesop-parallax-component <?php echo sanitize_html_class( $classes );?>"><?php

				do_action('aesop_parallax_inside_top'); // action

				// only run parallax if not on mobile and parallax is on
				if ( !wp_is_mobile() && ( 'on' == $atts['parallaxbg'] || 'on' == $atts['floater'] ) ) { ?>
					<script>
						jQuery(document).ready(function(){

							<?php if ( 'on' == $atts['parallaxbg'] ) { ?>
					   		jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-img').parallax({speed: 0.1});
					        var viewport = jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?>').outerHeight();
		        			jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-img.is-parallax').css({'height': viewport * 1.5});
		        			<?php } ?>

		        			<?php if ( 'on' == $atts['floater'] ) {?>
								var obj = jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-floater');
						       	function scrollParallax(){
						       	    var height 			= jQuery(obj).height(),
        	        					offset 			= jQuery(obj).offset().top,
						       	    	scrollTop 		= jQuery(window).scrollTop(),
						       	    	windowHeight 	= jQuery(window).height(),
						       	    	floater 		= Math.round( (offset - scrollTop) * 0.1);

						       	    // only run parallax if in view
						       	    if (offset >= scrollTop + windowHeight) {
										return;
									}

						       	    <?php if ('left' == $atts['floaterdirection'] || 'right' == $atts['floaterdirection']){

										if ('left' == $atts['floaterdirection']){ ?>
						            		jQuery(obj).css({'transform':'translate3d(' + floater + 'px, 0px, 0px)'});
						            	<?php } else { ?>
											jQuery(obj).css({'transform':'translate3d(-' + floater + 'px, 0px, 0px)'});
						            	<?php }

						       	    } else {

						       	    	if ('up' == $atts['floaterdirection']){ ?>
						            		jQuery(obj).css({'transform':'translate3d(0px,' + floater + 'px, 0px)'});
										<?php } else { ?>
											jQuery(obj).css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});
										<?php }
						            } ?>
						       	}
						      	scrollParallax();
						        jQuery(window).scroll(function() {scrollParallax();});
						    <?php } ?>
						});
					</script>
				<?php } ?>
					<figure class="aesop-parallax-sc aesop-parallax-sc-<?php echo esc_attr( $unique );?>" style="height:<?php echo absint( $height );?>px;">

						<?php do_action('aesop_parallax_inner_inside_top'); //action ?>

						<?php if ('on' == $atts['floater']){?>
							<div class="aesop-parallax-sc-floater floater-<?php echo sanitize_html_class( $atts['floaterposition'] );?>" data-speed="10">
								<?php echo esc_html($atts['floatermedia']);?>
							</div>
						<?php } ?>

						<?php if ($atts['caption']){?>
							<figcaption class="aesop-parallax-sc-caption-wrap <?php echo sanitize_html_class( $atts['captionposition'] );?>">
								<?php echo esc_html( $atts['caption'] );?>
							</figcaption>
						<?php } ?>

						<?php if ( 'on' == $atts['lightbox']){?>
							<a class="aesop-lb-link aesop-lightbox" rel="lightbox" title="<?php echo esc_attr( $atts['caption'] );?>" href="<?php echo esc_url( $atts['img'] );?>"><i class="aesopicon aesopicon-search-plus"></i></a>
						<?php } ?>

						<?php do_action('aesop_parallax_inner_inside_bottom'); //action ?>

						<div class="aesop-parallax-sc-img <?php echo sanitize_html_class( $laxclass );?>" <?php echo $style;?>></div>
					</figure>

					<?php do_action('aesop_parallax_inside_bottom'); //action ?>

			</div>

		<?php do_action('aesop_parallax_after'); // action

		return ob_get_clean();
	}
}