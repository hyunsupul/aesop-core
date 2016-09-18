<?php

/**
 * Creates a parallax component with background image, caption, lightbox, and optional "floater" item which can also be parallax, with multiple position and directions.
 *
 * @since    1.0.0
 */

if ( ! function_exists( 'aesop_parallax_shortcode' ) ) {

	function aesop_parallax_shortcode( $atts ) {

		$defaults = array(
			'img'				=> '',
			'parallaxspeed'		=> 1,
			'height'			=> '',//used again as of 1.9.0 ignored if not set
			'parallaxbg'		=> 'on',
			'floater'			=> '',
			'floatermedia'		=> '',
			'floaterposition'	=> 'right',
			'floaterdirection'	=> 'up',
			'caption'			=> '',
			'captionposition'	=> 'bottom-left',
			'lightbox'			=> false,
			'floaterspeed'		=> 1 // not used
		);

		$atts = apply_filters( 'aesop_parallax_defaults', shortcode_atts( $defaults, $atts ) );

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		// add a css class if parallax bg is set to on
		$laxclass  = 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
		
		// add parallax and floater speed options
		$parallax_speed = $atts['parallaxspeed'];
		$floater_speed = $atts['floaterspeed'];
		
		if ($parallax_speed <1) $parallax_speed =1;
		else if ($parallax_speed >6) $parallax_speed =6;
		

		// add custom css classes through our utility function
		$classes = aesop_component_classes( 'parallax', '' );

		// automatically provide an alt tag for the image based on the name of the image file
		$auto_alt  = $atts['img'] ? basename( $atts['img'] ) : null;

		$floater_direction = $atts['floaterdirection'] ? $atts['floaterdirection'] : 'up';

		ob_start();

		do_action( 'aesop_parallax_before', $atts, $unique ); // action

		?><div id="aesop-parallax-component-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'parallax', $unique, $atts );?> class="aesop-component aesop-parallax-component <?php echo sanitize_html_class( $classes );?>"><?php

			do_action( 'aesop_parallax_inside_top', $atts, $unique ); // action ?>

			<script>
				jQuery(document).ready(function($){

					var img 	  = $('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-img')
					, 	setHeight = function() {

							img.parent().imagesLoaded( function() {

								var imgHeight 		= img.height()
								,	imgCont     	= img.parent()

								<?php if( 'off' == $atts['parallaxbg'] ) { ?>

									imgCont.css('height', imgHeight)

								<?php } else { ?>

									//imgCont.css('height',Math.round(imgHeight * 0.69))
									imgCont.css('height',Math.round(imgHeight * (0.80-0.06*<?php echo $parallax_speed ?>)))

									if ( $(window).height < 760 ) {
										imgCont.css('height',Math.round(imgHeight * (0.70-0.06*<?php echo $parallax_speed ?>)))
									}

								<?php } ?>
							});

						}

					setHeight();

					$(window).resize(function(){
						setHeight();
					})

					<?php if ( ! wp_is_mobile() && ( 'on' == $atts['parallaxbg'] || 'on' == $atts['floater'] )  ) {

						if ( 'on' == $atts['parallaxbg'] ) { ?>

				   			img.parallax({speed: <?php echo $parallax_speed*0.1 ?>});

		        		<?php 
						}//end if

						if ( 'on' == $atts['floater'] && 'none' != $floater_direction ) { ?>

							var obj = $('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-floater');
				
					       	function scrollParallax<?php echo str_replace('-', '_', $unique);?>(){
					       	    var height 			= obj.height(),
		        					offset 			= obj.offset().top,
					       	    	scrollTop 		= $(window).scrollTop(),
					       	    	windowHeight 	= $(window).height(),
					       	    	floater 		= Math.round( (offset - scrollTop) * 0.1),
									floaterposition = '<?php echo $atts['floaterposition'];?>';
									direction = '<?php echo $floater_direction;?>';
									
					       	    // only run parallax if in view
								var rect = $(obj)[0].getBoundingClientRect();

								if (rect.bottom<=0 || (rect.top+100) > $(window).height()) 
								{
									return;
								}				
								var ratio = 1.0-(rect.bottom/($(window).height()+rect.bottom-100));
								
								if (direction =='right') {									
									var xEnd = (obj.parent().width())/2;
									obj.css({'transform':'translate3d('+ratio*xEnd+'px, 0px, 0px)'});
								} else if (direction =='left') {
									var xEnd = (obj.parent().width())/2;
									obj.css({'transform':'translate3d(-'+ratio*xEnd+'px, 0px, 0px)'});
								} else if (direction =='up') {
									var yEnd = 200;
									obj.css({'transform':'translate3d(0px, -'+ ratio*yEnd+'px, 0px)'});
								} else if (direction =='down') {
									var yEnd = 200;
									obj.css({'transform':'translate3d(0px, '+ ratio*yEnd+'px, 0px)'});
								}
								

								
							} // end if on floater

							scrollParallax<?php echo str_replace('-', '_', $unique);?>();
							$(window).scroll(function() { scrollParallax<?php echo str_replace('-', '_', $unique);?>(); });
						
					    <?php }//end on floater

					} //end if is not mobile and parallax is on ?>

				}); // end jquery doc ready
			</script>

			<figure class="aesop-parallax-sc aesop-parallax-sc-<?php echo esc_attr( $unique );?>" style="height:<?php echo esc_attr( $atts['height'] );?>;">

				<?php do_action( 'aesop_parallax_inner_inside_top', $atts, $unique ); // action ?>

				<?php if ( 'on' == $atts['floater'] ) {?>
					<div class="aesop-parallax-sc-floater floater-<?php echo sanitize_html_class( $atts['floaterposition'] );?>" data-speed="10">
						<?php echo aesop_component_media_filter( $atts['floatermedia'] );?>
					</div>
				<?php } ?>

				<?php if ( 'on' == $atts['lightbox'] ) {?>
					<a class="aesop-lb-link aesop-lightbox" rel="lightbox" title="<?php echo esc_attr( $atts['caption'] );?>" href="<?php echo esc_url( $atts['img'] );?>"><i class="aesopicon aesopicon-search-plus"></i></a>
				<?php } 

				if ('fixed' == $atts['parallaxbg']) {
					if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
					?>
						<div class="aesop-stacked-img">
							<img src="<?php echo esc_url(  $atts['img'] );?>" >
						</div>
					<?php
					} else {
				    ?>
						<div class="aesop-stacked-img" style="height:100%;background-image:url('<?php echo esc_url( $atts['img'] );?>');background-size:cover;background-position:center center;?>">
						</div>
					<?php
					}
				} else {
				?>
				    <img class="aesop-parallax-sc-img <?php echo $laxclass;?>" src="<?php echo esc_url( $atts['img'] );?>" alt="<?php echo esc_attr( $auto_alt );?>" >
				<?php
				}
				
				

				if ( $atts['caption'] ) { ?>
					<figcaption class="aesop-parallax-sc-caption-wrap <?php echo sanitize_html_class( $atts['captionposition'] );?>">
						<?php echo aesop_component_media_filter( trim( $atts['caption'] ) );?>
					</figcaption>
				<?php } ?>

				<?php do_action( 'aesop_parallax_inner_inside_bottom', $atts, $unique ); // action ?>

			</figure>

			<?php do_action( 'aesop_parallax_inside_bottom', $atts, $unique ); // action ?>

		</div>

		<?php do_action( 'aesop_parallax_after', $atts, $unique ); // action

		return ob_get_clean();
	}
}//end if
