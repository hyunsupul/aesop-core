<?php

/**
 	* Creates an content section that can do offset text, image backgrounds, and magazine style columns
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_content_shortcode')){

	function aesop_content_shortcode($atts, $content = null) {

		// let this be used multiple times
		$hash = rand();

		$defaults = array(
			'height'			=> '',
			'width'				=> '100%',
			'columns'			=>'',
			'position'			=> 'center',
			'innerposition'		=> '',
			'img' 				=> '',
			'imgrepeat'			=> 'no-repeat',
			'imgposition'		=> '',
			'floatermedia' 		=> '',
			'floaterdirection'	=> 'up',
			'floateroffset'		=> '',
			'color' 			=> '#FFFFFF',
			'background'		=> '#333333'
		);

		$atts = apply_filters('aesop_cbox_defaults',shortcode_atts($defaults, $atts));

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// height
		$height = $atts['height'] ? sprintf('min-height:%s";',$atts['height']) : false;

		// inner positioning
		$getinnerposition = $atts['innerposition'] ? preg_split("/[\s,]+/", $atts['innerposition']) : false;

		$positionArray = array(
			'top' 		=> $getinnerposition[0],
			'right' 	=> $getinnerposition[1],
			'bottom' 	=> $getinnerposition[2],
			'left' 		=> $getinnerposition[3]
		);

		$innerposition =  is_array($positionArray) && $atts['innerposition'] ? sprintf('position:absolute;top:%s;right:%s;bottom:%s;left:%s;',$positionArray['top'], $positionArray['right'], $positionArray['bottom'], $positionArray['left']) : false;

		// are we doing columns or image and do a clas based on it
		$columns = $atts['columns'] ? sprintf('aesop-content-comp-columns-%s',$atts['columns']) : false;
		$image = $atts['img'] ? 'aesop-content-img' : false;
			$typeclass = $columns.' '.$image;

		// image and width inline styles
		$bgcolor = $atts['background'] ? sprintf('background-color:%s;',$atts['background']) : false;
		$imgstyle = $atts['img'] ? sprintf('%sbackground-image:url(\'%s\');background-size:cover;background-position:center center;',$bgcolor, $atts['img']) : false;

		$position	= ('left' == $atts['position'] || 'right' == $atts['position']) ? sprintf('float:%s;',$atts['position']) : 'margin-left:auto;margin-right:auto;';
		$widthContentStyle = 'content' == $atts['width'] ? false : sprintf('max-width:%s;',$atts['width']);
		$innerstyle = $atts['width'] || $position || $atts['innerposition'] ? sprintf('style="%s%s%s"',$widthContentStyle,$position,$innerposition) : false;
		$txtcolor 	= $atts['color'] ? sprintf('color:%s;', $atts['color']) : false;
			$itemstyle = $imgstyle || $txtcolor || $height ? sprintf('style="%s%s%s%s"',$imgstyle, $txtcolor, $bgcolor, $height) : false;

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'content', '' ) : null;

		ob_start();

		do_action('aesop_cbox_before'); //action
			?>
				<div class="aesop-component aesop-content-component <?php echo $classes;?>" style="<?php echo $height;?>" >

					<?php if ( $atts['floatermedia'] && !wp_is_mobile() ) { ?>
						<!-- Aesop Content Component -->
						<script>
							jQuery(document).ready(function(){

								var obj = jQuery('#aesop-content-component-<?php echo $hash;?> .aesop-content-component-floater');

						       	function scrollParallax(){

						       	    var floater = (jQuery(window).scrollTop() / jQuery(obj).data('speed')) - <?php echo absint(sanitize_text_field($atts['floateroffset']));?>;

						       	    <?php if ('up' == $atts['floaterdirection']){ ?>
						            	jQuery(obj).css({'transform':'translate3d(0px,' + floater + 'px, 0px)'});
									<?php } else { ?>
										jQuery(obj).css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});
									<?php } ?>
						       	}
						      	scrollParallax();

						        jQuery(window).scroll(function() {scrollParallax();});
						});
						</script>

					<?php }

					echo do_action('aesop_cbox_inside_top'); //action ?>

					<div id="aesop-content-component-<?php echo $hash;?>" class="aesop-content-comp-wrap <?php echo $typeclass;?>" <?php echo $itemstyle;?>>

						<?php echo do_action('aesop_cbox_content_inside_top'); //action

						if ( $atts['floatermedia'] && !wp_is_mobile() ) { ?>

							<div class="aesop-content-component-floater" data-speed="10"><?php echo $atts['floatermedia'];?></div>

						<?php } ?>

						<div class="aesop-content-comp-inner <?php echo $contentwidth;?>" <?php echo $innerstyle;?>>

							<?php echo do_action('aesop_cbox_content_inner_inside_top'); //action ?>

							<?php echo do_shortcode($content);?>

							<?php echo do_action('aesop_cbox_content_inner_inside_bottom'); //action ?>

						</div>

						<?php echo do_action('aesop_cbox_content_inside_bottom'); //action ?>

					</div>

					<?php echo do_action('aesop_cbox_inside_bottom'); //action ?>

				</div>
			<?php

		do_action('aesop_cbox_after'); //action

		return ob_get_clean();
	}
}