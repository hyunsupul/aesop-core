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
			'width'				=> '100%',
			'columns'			=>'',
			'position'			=> 'center',
			'img' 				=> '',
			'imgrepeat'			=> 'no-repeat',
			'imgposition'		=> '',
			'color' 			=> '#FFFFFF',
			'background'		=> '#333333'
		);

		$atts = apply_filters('aesop_cbox_defaults',shortcode_atts($defaults, $atts));

		// set component to content width
		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		// are we doing columns or image and do a clas based on it
		$columns = $atts['columns'] ? sprintf('aesop-content-comp-columns-%s',$atts['columns']) : false;
		$image = $atts['img'] ? 'aesop-content-img' : false;
			$typeclass = $columns.' '.$image;

		// image and width inline styles
		$bgcolor = $atts['background'] ? sprintf('background-color:%s;',$atts['background']) : false;
		$imgstyle = $atts['img'] ? sprintf('%sbackground-image:url(\'%s\');background-size:cover;background-position:center center;',$bgcolor, $atts['img']) : false;

		$widthContentStyle = 'content' == $atts['width'] ? false : sprintf('max-width:%s;',$atts['width']);
		$widthstyle = $atts['width'] ? sprintf('style="%smargin-left:auto;margin-right:auto;"',$widthContentStyle) : false;
		$txtcolor 	= $atts['color'] ? sprintf('color:%s;', $atts['color']) : false;
		$position	= ('left' == $atts['position'] || 'right' == $atts['position']) ? sprintf('float:%s;',$atts['position']) : false;
			$itemstyle = $imgstyle || $position || $txtcolor ? sprintf('style="%s%s%s%s"',$imgstyle,$position, $txtcolor, $bgcolor) : false;

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'content', '' ) : null;

		ob_start();

		do_action('aesop_cbox_before'); //action
			?>
				<div class="aesop-component aesop-content-component <?php echo $classes;?>">

					<?php echo do_action('aesop_cbox_inside_top'); //action ?>

					<div id="aesop-content-component-<?php echo $hash;?>" class="aesop-content-comp-wrap <?php echo $typeclass;?>" <?php echo $itemstyle;?>>

						<?php echo do_action('aesop_cbox_content_inside_top'); //action ?>

						<div class="aesop-content-comp-inner <?php echo $contentwidth;?>" <?php echo $widthstyle;?>>

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