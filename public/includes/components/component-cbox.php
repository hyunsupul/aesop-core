<?php

/**
 * Creates an content section that can do offset text, image backgrounds, and magazine style columns
 *
 * @since    1.0.0
 */
<<<<<<< HEAD
if ( ! function_exists( 'aesop_content_shortcode' ) ){
=======
if ( ! function_exists( 'aesop_content_shortcode' ) ) {
>>>>>>> release/1.5.1

	function aesop_content_shortcode( $atts, $content = null ) {

		// let this be used multiple times
		static $instance = 0;
		$instance++;
<<<<<<< HEAD
		$unique = sprintf( '%s-%s',get_the_ID(), $instance );

		$defaults = array(
			'height'			=> '',
			'width'				=> '100%',
			'columns'			=> '',
			'position'			=> 'center',
			'innerposition'		=> '',
			'img' 				=> '',
			'imgrepeat'			=> 'no-repeat',
			'imgposition'		=> 'center center',
			'imgsize'			=> 'cover',
			'floatermedia' 		=> '',
			'floaterdirection'	=> 'down',
=======
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		$defaults = array(
			'height'   			=> '',
			'width'    			=> '100%',
			'columns'   		=> '',
			'position'   		=> 'center',
			'innerposition'  	=> '',
			'img'     			=> '',
			'imgrepeat'   		=> 'no-repeat',
			'imgposition'  		=> 'center center',
			'imgsize'   		=> 'cover',
			'floatermedia'   	=> '',
			'floaterdirection' 	=> 'down',
>>>>>>> release/1.5.1
			'floaterposition'	=> 'left',
			'color'    			=> '#FFFFFF',
			'background'  		=> '#222222'
		);

<<<<<<< HEAD
		$atts = apply_filters( 'aesop_cbox_defaults',shortcode_atts( $defaults, $atts ) );
=======
		$atts = apply_filters( 'aesop_cbox_defaults', shortcode_atts( $defaults, $atts ) );
>>>>>>> release/1.5.1

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// height
<<<<<<< HEAD
		$height = $atts['height'] ? sprintf( 'min-height:%s;',esc_attr( $atts['height'] ) ) : false;
=======
		$height = $atts['height'] ? sprintf( 'min-height:%s;', esc_attr( $atts['height'] ) ) : false;
>>>>>>> release/1.5.1

		// inner positioning
		$getinnerposition = $atts['innerposition'] ? preg_split( '/[\s,]+/', $atts['innerposition'] ) : false;

		$positionArray = array(
			'top'    => $getinnerposition[0],
			'right'  => $getinnerposition[1],
			'bottom' => $getinnerposition[2],
			'left'   => $getinnerposition[3]
		);

<<<<<<< HEAD
		$innerposition = is_array( $positionArray ) && $atts['innerposition'] ? sprintf( 'position:absolute;top:%s;right:%s;bottom:%s;left:%s;',$positionArray['top'], $positionArray['right'], $positionArray['bottom'], $positionArray['left'] ) : false;

		// are we doing columns or image and do a clas based on it
		$columns = $atts['columns'] ? sprintf( 'aesop-content-comp-columns-%s',$atts['columns'] ) : false;
=======
		$innerposition = is_array( $positionArray ) && $atts['innerposition'] ? sprintf( 'position:absolute;top:%s;right:%s;bottom:%s;left:%s;', $positionArray['top'], $positionArray['right'], $positionArray['bottom'], $positionArray['left'] ) : false;

		// are we doing columns or image and do a clas based on it
		$columns = $atts['columns'] ? sprintf( 'aesop-content-comp-columns-%s', $atts['columns'] ) : false;
>>>>>>> release/1.5.1
		$image = $atts['img'] ? 'aesop-content-img' : false;
		$typeclass = $columns.' '.$image;

		// image and width inline styles
<<<<<<< HEAD
		$bgcolor = $atts['background'] ? sprintf( 'background-color:%s;',esc_url( $atts['background'] ) ) : false;
		$imgstyle = $atts['img'] ? sprintf( '%sbackground-image:url(\'%s\');background-size:%s;background-position:%s;background-repeat:%s;',$bgcolor, esc_url( $atts['img'] ), esc_attr( $atts['imgsize'] ), esc_attr( $atts['imgposition'] ), esc_attr( $atts['imgrepeat'] ) ) : false;

		$position	= ('left' == $atts['position'] || 'right' == $atts['position']) ? sprintf( 'float:%s;',esc_attr( $atts['position'] ) ) : 'margin-left:auto;margin-right:auto;';
		$widthContentStyle = 'content' == $atts['width'] ? false : sprintf( 'max-width:%s;',esc_attr( $atts['width'] ) );
		$innerstyle = $atts['width'] || $position || $atts['innerposition'] ? sprintf( 'style="%s%s%s"',$widthContentStyle,$position,$innerposition ) : false;
		$txtcolor 	= $atts['color'] ? sprintf( 'color:%s;', $atts['color'] ) : false;
			$itemstyle = $imgstyle || $txtcolor || $height ? sprintf( 'style="%s%s%s%s"',$imgstyle, $txtcolor, $bgcolor, $height ) : false;
=======
		$bgcolor = $atts['background'] ? sprintf( 'background-color:%s;', esc_url( $atts['background'] ) ) : false;
		$imgstyle = $atts['img'] ? sprintf( '%sbackground-image:url(\'%s\');background-size:%s;background-position:%s;background-repeat:%s;', $bgcolor, esc_url( $atts['img'] ), esc_attr( $atts['imgsize'] ), esc_attr( $atts['imgposition'] ), esc_attr( $atts['imgrepeat'] ) ) : false;

		$position = ( 'left' == $atts['position'] || 'right' == $atts['position'] ) ? sprintf( 'float:%s;', esc_attr( $atts['position'] ) ) : 'margin-left:auto;margin-right:auto;';
		$widthContentStyle = 'content' == $atts['width'] ? false : sprintf( 'max-width:%s;', esc_attr( $atts['width'] ) );
		$innerstyle = $atts['width'] || $position || $atts['innerposition'] ? sprintf( 'style="%s%s%s"', $widthContentStyle, $position, $innerposition ) : false;
		$txtcolor  = $atts['color'] ? sprintf( 'color:%s;', $atts['color'] ) : false;
		$itemstyle = $imgstyle !== false || $txtcolor !== false || $height !== false ? sprintf( 'style="%s%s%s%s"', $imgstyle, $txtcolor, $bgcolor, $height ) : false;
>>>>>>> release/1.5.1

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'content', '' ) : false;

		// has image class
		$has_img = $atts['img'] ? 'aesop-content-has-img' : false;

		// has floater
		$has_floater = $atts['floatermedia'] ? 'aesop-content-has-floater' : false;

		// floater positoin
		$floaterposition = $atts['floaterposition'] ? sprintf( 'floater-%s', $atts['floaterposition'] ) : false;

		ob_start();

		do_action( 'aesop_cbox_before' ); // action
<<<<<<< HEAD
			?>
=======
?>
>>>>>>> release/1.5.1
				<div <?php echo aesop_component_data_atts( 'content', $unique, $atts, true );?> class="aesop-component aesop-content-component <?php echo sanitize_html_class( $classes ).' '.$has_img. ' '.$has_floater;?>" style="<?php echo $height;?>" >

					<?php if ( $atts['floatermedia'] && ! wp_is_mobile() ) { ?>
						<!-- Aesop Content Component -->
						<script>
						jQuery(document).ready(function($){

<<<<<<< HEAD
							var obj = jQuery('#aesop-content-component-<?php echo esc_attr( $unique );?> .aesop-content-component-floater');
=======
							var obj = $('#aesop-content-component-<?php echo esc_attr( $unique );?> .aesop-content-component-floater');
>>>>>>> release/1.5.1

					       	function scrollParallax(){

					       	    var height 			= $(obj).height(),
	    	        				offset 			= $(obj).offset().top,
						       	    scrollTop 		= $(window).scrollTop(),
						       	    windowHeight 	= $(window).height(),
						       	    floater 		= Math.round( (offset - scrollTop) * 0.1);

						    	// only run parallax if in view
					       		if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
									return;
								}

<<<<<<< HEAD
					       	    <?php if ( 'up' == $atts['floaterdirection'] ){ ?>
					            	jQuery(obj).css({'transform':'translate3d(0px,' + floater + 'px, 0px)'});
=======
					       	    <?php if ( 'up' == $atts['floaterdirection'] ) { ?>
					            	$(obj).css({'transform':'translate3d(0px,' + floater + 'px, 0px)'});
>>>>>>> release/1.5.1
								<?php } else { ?>
									$(obj).css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});
								<?php } ?>
					       	}
					      	scrollParallax();

					        $(window).scroll(function() {scrollParallax();});
						});
						</script>

					<?php }//end if

<<<<<<< HEAD
					echo do_action( 'aesop_cbox_inside_top' ); // action ?>
=======
		echo do_action( 'aesop_cbox_inside_top' ); // action ?>
>>>>>>> release/1.5.1

					<div id="aesop-content-component-<?php echo $unique;?>" class="aesop-content-comp-wrap <?php echo $typeclass;?>" <?php echo $itemstyle;?>>

						<?php echo do_action( 'aesop_cbox_content_inside_top' ); // action

<<<<<<< HEAD
						if ( $atts['floatermedia'] && ! wp_is_mobile() ) { ?>
=======
		if ( $atts['floatermedia'] && ! wp_is_mobile() ) { ?>
>>>>>>> release/1.5.1

							<div class="aesop-content-component-floater <?php echo $floaterposition;?>" data-speed="10"><?php echo aesop_component_media_filter( $atts['floatermedia'] );?></div>

						<?php } ?>

						<div class="aesop-component-content-data aesop-content-comp-inner <?php echo $contentwidth;?>" <?php echo $innerstyle;?>>

							<?php echo do_action( 'aesop_cbox_content_inner_inside_top' ); // action ?>

								<?php echo do_shortcode( wpautop( html_entity_decode( $content ) ) );?>

							<?php echo do_action( 'aesop_cbox_content_inner_inside_bottom' ); // action ?>

						</div>

						<?php echo do_action( 'aesop_cbox_content_inside_bottom' ); // action ?>

					</div>

					<?php echo do_action( 'aesop_cbox_inside_bottom' ); // action ?>

				</div>
			<?php

<<<<<<< HEAD
			do_action( 'aesop_cbox_after' ); // action
=======
		do_action( 'aesop_cbox_after' ); // action
>>>>>>> release/1.5.1

			return ob_get_clean();
	}
}//end if