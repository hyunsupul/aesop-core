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
			'floaterdistance'   => '',
			'overlay_revealfx'  => '',
			'floaterspeed'		=> 1, // not used,
            'className'=>''
		);

		$atts = apply_filters( 'aesop_parallax_defaults', shortcode_atts( $defaults, $atts, 'aesop_parallax' ) );
		$floater_ratio =0;
		$floater_distance = 0;
		
		if ($atts['floaterdirection'] != 'none') {
			if (strpos($atts['floaterdistance'], '%') !== false) {
				$floater_ratio = floatval($atts['floaterdistance']) / 100;
			} else {
				$floater_distance = intval(str_replace('px', '', $atts['floaterdistance']));
            }	
            if ($floater_distance<=0 && $floater_ratio <=0) {
				$floater_ratio = 0.33;
				$floater_distance = 0;
			}			
		}
		
		if (wp_is_mobile()) {
			$atts['parallaxbg'] = 'off';
		}

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		// add a css class if parallax bg is set to on
		$laxclass  = 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
		
		// add parallax and floater speed options
		$parallax_speed = intval($atts['parallaxspeed']);
		$floater_speed = $atts['floaterspeed'];
		
		if (empty($parallax_speed) || $parallax_speed <1) $parallax_speed =1;
		else if ($parallax_speed >6) $parallax_speed =6;
		

		// add custom css classes through our utility function
		$classes = $atts['className'].' '.(aesop_component_classes( 'parallax', '' ));

		// automatically provide an alt tag for the image based on the name of the image file
		$auto_alt  = $atts['img'] ? basename( $atts['img'] ) : null;

		$floater_direction = $atts['floaterdirection'] ? $atts['floaterdirection'] : 'up';

		ob_start();

		do_action( 'aesop_parallax_before', $atts, $unique ); // action
		$nowebkitxform = ('fixed' == $atts['parallaxbg']) ? '-webkit-transform: none;':'';

		?><div id="aesop-parallax-component-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'parallax', $unique, $atts );?> class="aesop-component aesop-parallax-component <?php echo sanitize_html_class( $classes );?>"><?php

			do_action( 'aesop_parallax_inside_top', $atts, $unique ); // action

        // new
        $bool_custom = false;
        $arr_args    = array(
            'atts'    => $atts,
            'auto_alt' => $auto_alt,
            'classes' => $classes,
            'floater_direction' => $floater_direction,
            'floater_distance' => $floater_distance,
            'floater_ratio' => $floater_ratio,
            'instance' => $instance,
            'laxclass' => $laxclass,
            'unique'  => $unique
        );

        $bool_custom = apply_filters( 'aesop_parallax_custom_view', $bool_custom, $arr_args );

        if ( $bool_custom === false ) {
        ?>

			<script>
				jQuery(document).ready(function($){

				    <?php /*if (empty($atts['height']))*/ {?>
					var img 	  = $('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-img')
					, 	
					setHeight = function() {

					        <?php if (empty($atts['height'])) {?> /* if height is not explicitly defined */
							img.parent().imagesLoaded( function() {

								var imgHeight 		= img.height()
								,	imgCont     	= img.parent()

								<?php if( 'off' == $atts['parallaxbg'] || 'fixed' == $atts['parallaxbg']) { ?>

									imgCont.css('height', imgHeight)

								<?php } else { ?>

									//imgCont.css('height',Math.round(imgHeight * 0.69))
									imgCont.css('height',Math.round(imgHeight * (0.80-0.06*<?php echo $parallax_speed ?>)))

									if ( $(window).height < 760 ) {
										imgCont.css('height',Math.round(imgHeight * (0.70-0.06*<?php echo $parallax_speed ?>)))
									}

								<?php } ?>
							});
							<?php }
                            /* the following code fixes extra vertical space after the image */
                            ?>
							if ($('#aesop-parallax-component-<?php echo esc_attr( $unique );?>').height() > img.height()) {
								$('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?>').css('height',img.height());
								$('#aesop-parallax-component-<?php echo esc_attr( $unique );?>').css('height',img.height());
							}

						}

					$(window).on('load',function(){
					    setHeight();
					});
					

					$(window).resize(function(){
						setHeight();
					});
				<?php }?>
					<?php
					{
						//new version

						 if ( ! wp_is_mobile() && ( 'on' == $atts['parallaxbg'] || 'on' == $atts['floater'] )  ) {

							if ( 'on' == $atts['parallaxbg'] ) { ?>

							    var img 	  = $('.aesop-parallax-sc.aesop-parallax-sc-<?php echo esc_attr( $unique );?> .aesop-parallax-sc-img');
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

                                    //scroll ratio									
									var ratio = 1.0-(rect.bottom/($(window).height()+(rect.bottom-rect.top-100)));
									<?php if ($floater_distance >0) { ?>
									   var dist = <?php echo $floater_distance;?>;
									<?php } else if ($floater_direction=='down' || $floater_direction=='up') { ?>
									   var dist = (obj.parent().height())*<?php echo $floater_ratio;?>;
									<?php } else {?>
									   var dist = (obj.parent().width())*<?php echo $floater_ratio;?>;
									<?php } ?>
									
									
									if (direction =='right') {									
										obj.css({'transform':'translate3d('+ratio*dist+'px, 0px, 0px)'});
									} else if (direction =='left') {
										obj.css({'transform':'translate3d(-'+ratio*dist+'px, 0px, 0px)'});
									} else if (direction =='up') {
										obj.css({'transform':'translate3d(0px, -'+ ratio*dist+'px, 0px)'});
									} else if (direction =='down') {
										obj.css({'transform':'translate3d(0px, '+ ratio*dist+'px, 0px)'});
									}
								} // end if on floater
								scrollParallax<?php echo str_replace('-', '_', $unique);?>();
								$(window).scroll(function() { scrollParallax<?php echo str_replace('-', '_', $unique);?>(); });
							
							<?php }//end on floater

						} //end if is not mobile and parallax is on 
						
					} 
				?>
				}); // end jquery doc ready
			</script>

			<?php if (!empty($atts['height'])) {?>
			  <figure class="aesop-parallax-sc aesop-parallax-sc-<?php echo esc_attr( $unique );?>" style="height:<?php echo esc_attr( $atts['height'] );?>;<?php echo $nowebkitxform;?>">
			<?php } else {?>
			  <figure class="aesop-parallax-sc aesop-parallax-sc-<?php echo esc_attr( $unique );?>" style="<?php echo $nowebkitxform;?>">
			  
			<?php } ?>

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
						<div class="aesop-stacked-img" style="background-attachment: fixed;height:100%;background-image:url('<?php echo esc_url( $atts['img'] );?>');background-size:cover;background-position:center center;">
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

		<?php
        }
		do_action( 'aesop_parallax_after', $atts, $unique ); // action

		return ob_get_clean();
	}
}//end if
