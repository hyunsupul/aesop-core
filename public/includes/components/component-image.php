<?php
/**
 * Provides an image and caption
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_image_shortcode' ) ) {

	function aesop_image_shortcode( $atts ) {

		$defaults = array(
			'img'     			=> '',
			'imgwidth'   		=> '300px',
			'offset'   			=> '',
			'alt'    			=> '',
			'align'    			=> 'left',
			'caption'   		=> '',
			'credit'   			=> '',
			'captionposition' 	=> 'left',
			'lightbox'    		=> 'off'
		);

		$atts = apply_filters( 'aesop_image_defaults', shortcode_atts( $defaults, $atts ) );

		// offset styles
		$offsetstyle = $atts['offset'] && ( 'left' == $atts['align'] || 'right' == $atts['align'] ) ? sprintf( 'style=margin-%s:%s;width:%s;', $atts['align'], $atts['offset'], $atts['imgwidth'] ) : 'style=max-width:'.$atts['imgwidth'].';';

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'image', '' ) : null;

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		// lazy loader class
		$lazy_holder = AI_CORE_URL.'/public/assets/img/aesop-lazy-holder.png';
		$lazy   = class_exists( 'AesopLazyLoader' ) && ! is_user_logged_in() ? sprintf( 'src="%s" data-src="%s" class="aesop-lazy-img"', $lazy_holder, esc_url( $atts['img'] ) ) : sprintf( 'src="%s"', esc_url( $atts['img'] ) );

		// automatic alt tag fallback if none specified
		$auto_alt  = $atts['img'] ? basename( $atts['img'] ) : null;
		$alt   = $atts['alt'] ? $atts['alt'] : preg_replace( '/\\.[^.\\s]{3,4}$/', '', $auto_alt );

		// combine into component shell
		ob_start();

		do_action( 'aesop_image_before', $atts, $unique ); // action
?>
		<div id="aesop-image-component-<?php echo esc_html( $unique );?>" <?php echo aesop_component_data_atts( 'image', $unique, $atts );?> class="aesop-component aesop-image-component <?php echo sanitize_html_class( $classes );?>" >

			<?php do_action( 'aesop_image_inside_top', $atts, $unique ); // action ?>

			<figure class="aesop-content">
				<div class="aesop-image-component-image aesop-component-align-<?php echo sanitize_html_class( $atts['align'] );?> aesop-image-component-caption-<?php echo sanitize_html_class( $atts['captionposition'] );?>" <?php echo esc_attr( $offsetstyle );?>>
					<?php

		do_action( 'aesop_image_inner_inside_top', $atts, $unique ); // action

		if ( 'on' == $atts['lightbox'] ) { ?>

						<a class="aesop-lightbox" href="<?php echo $atts['img'];?>" title="<?php echo $atts['caption'];?>">
							<p class="aesop-img-enlarge"><i class="aesopicon aesopicon-search-plus"></i> <?php _e( 'Enlarge', 'aesop-core' );?></p>
							<img <?php echo $lazy;?> alt="<?php echo esc_attr( $alt );?>">
						</a>

					<?php } else { ?>

						<img <?php echo $lazy;?> alt="<?php echo esc_attr( $alt );?>">

					<?php }

		if ( $atts['caption'] ) { ?>

						<figcaption class="aesop-image-component-caption">
							<?php

			echo aesop_component_media_filter( $atts['caption'] );

			if ( $atts['credit'] ) { ?>
								<p class="aesop-cap-cred"><?php echo esc_html( $atts['credit'] );?></p>
							<?php } ?>

						</figcaption>

					<?php } ?>

					<?php do_action( 'aesop_image_inner_inside_bottom', $atts, $unique ); // action ?>

				</div>
			</figure>

			<?php do_action( 'aesop_image_inside_bottom', $atts, $unique ); // action ?>

		</div>
		<?php
		do_action( 'aesop_image_after', $atts, $unique ); // action

		return ob_get_clean();
	}
}//end if
