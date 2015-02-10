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
			'height' 			=> 500, // deprecated 1.4.2
			'parallaxbg' 		=> 'on',
			'floater' 			=> '',
			'floatermedia' 		=> '',
			'floaterposition' 	=> 'right',
			'floaterdirection'	=> 'up',
			'caption'			=> '',
			'captionposition' 	=> 'bottom-left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_parallax_defaults',shortcode_atts( $defaults, $atts ) );

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf('%s-%s',get_the_ID(), $instance);

		// add a css class if parallax bg is set to on
		$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;

		// add custom css classes through our utility function
		$classes = aesop_component_classes( 'parallax', '' );

		// automatically provide an alt tag for the image based on the name of the image file
		$auto_alt 	= $atts['img'] ? basename( $atts['img'] ) : null;

		ob_start();

		do_action('aesop_parallax_before'); //action

			?><div id="aesop-parallax-component-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'parallax', $unique, $atts );?> class="aesop-component aesop-parallax-component <?php echo sanitize_html_class( $classes );?>"><?php

				do_action('aesop_parallax_inside_top'); // action

				// only run parallax if not on mobile and parallax is on
				if ( !wp_is_mobile() && ( 'on' == $atts['parallaxbg'] || 'on' == $atts['floater'] ) ) { ?>
					<script>
						jQuery(document).ready(function($){

						<?php if ( 'on' == $atts['parallaxbg'] ) { ?>

							var img 	  = $('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-img')
							, 	setHeight = function() {

								var imgHeight 		= img.height()
								,	imgCont     	= img.parent()

								imgCont.css('height',Math.round(imgHeight * 0.69))

								if ( $(window).height < 760 ) {
									imgCont.css('height',Math.round(imgHeight * 0.65))
								}

							}

							setHeight();

							$(window).resize(function(){
								setHeight();
							})

				   			img.parallax({speed: 0.1});

	        			<?php } ?>

	        			<?php if ( 'on' == $atts['floater'] ) {?>
							var obj = $('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-floater');
					       	function scrollParallax(){
					       	    var height 			= obj.height(),
    	        					offset 			= obj.offset().top,
					       	    	scrollTop 		= $(window).scrollTop(),
					       	    	windowHeight 	= $(window).height(),
					       	    	floater 		= Math.round( (offset - scrollTop) * 0.1);

					       	    // only run parallax if in view
					       	    if (offset >= scrollTop + windowHeight) {
									return;
								}

					       	    <?php if ('left' == $atts['floaterdirection'] || 'right' == $atts['floaterdirection']){

									if ('left' == $atts['floaterdirection']){ ?>
					            		obj.css({'transform':'translate3d(' + floater + 'px, 0px, 0px)'});
					            	<?php } else { ?>
										obj.css({'transform':'translate3d(-' + floater + 'px, 0px, 0px)'});
					            	<?php }

					       	    } else {

					       	    	if ('up' == $atts['floaterdirection']){ ?>
					            		obj.css({'transform':'translate3d(0px,' + floater + 'px, 0px)'});
									<?php } else { ?>
										obj.css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});
									<?php }
					            } ?>
					       	}
					      	scrollParallax();
					        $(window).scroll(function() {scrollParallax();});
					    <?php } ?>
					});
					</script>
				<?php } ?>
					<figure class="aesop-parallax-sc aesop-parallax-sc-<?php echo esc_attr( $unique );?>">

						<?php do_action('aesop_parallax_inner_inside_top'); //action ?>

						<?php if ('on' == $atts['floater']){?>
							<div class="aesop-parallax-sc-floater floater-<?php echo sanitize_html_class( $atts['floaterposition'] );?>" data-speed="10">
								<?php echo aesop_component_media_filter( $atts['floatermedia'] );?>
							</div>
						<?php } ?>

						<?php if ( 'on' == $atts['lightbox']){?>
							<a class="aesop-lb-link aesop-lightbox" rel="lightbox" title="<?php echo esc_attr( $atts['caption'] );?>" href="<?php echo esc_url( $atts['img'] );?>"><i class="aesopicon aesopicon-search-plus"></i></a>
						<?php } ?>

						<img class="aesop-parallax-sc-img <?php echo $laxclass;?>" src="<?php echo esc_url( $atts['img'] );?>" alt="<?php echo esc_attr( $auto_alt );?>" >

						<?php if ( $atts['caption'] ){ ?>
							<figcaption class="aesop-parallax-sc-caption-wrap <?php echo sanitize_html_class( $atts['captionposition'] );?>">
								<?php echo aesop_component_media_filter( trim( $atts['caption'] ) );?>
							</figcaption>
						<?php } ?>

						<?php do_action('aesop_parallax_inner_inside_bottom'); //action ?>

					</figure>

					<?php do_action('aesop_parallax_inside_bottom'); //action ?>

			</div>

		<?php do_action('aesop_parallax_after'); // action

		return ob_get_clean();
	}
}