<?php

/**
 * Creates an interactive character element
 *
 * @since    1.0.0
 */
<<<<<<< HEAD
if ( ! function_exists( 'aesop_character_shortcode' ) ){
=======
if ( ! function_exists( 'aesop_character_shortcode' ) ) {
>>>>>>> release/1.5.1

	function aesop_character_shortcode( $atts, $content = null ) {

		$defaults = array(
			'img'      => '',
			'name'     => '',
			'caption'  => '',
			'align'    => 'left',
			'width'    => ''
		);

		// let this be used multiple times
		static $instance = 0;
		$instance++;
<<<<<<< HEAD
		$unique = sprintf( '%s-%s',get_the_ID(), $instance );

		$atts = apply_filters( 'aesop_character_defaults',shortcode_atts( $defaults, $atts ) );
=======
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		$atts = apply_filters( 'aesop_character_defaults', shortcode_atts( $defaults, $atts ) );
>>>>>>> release/1.5.1

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'character', '' ) : null;

		// width styles
<<<<<<< HEAD
		$styles = $atts['width'] ? sprintf( 'style="width:%s;"',esc_attr( $atts['width'] ) ) : null;
=======
		$styles = $atts['width'] ? sprintf( 'style="width:%s;"', esc_attr( $atts['width'] ) ) : null;
>>>>>>> release/1.5.1

		// wrapper float class
		$float = $atts['align'] ? sprintf( 'aesop-component-align-%s', esc_attr( $atts['align'] ) ) : null;

		// automatic alt tag
<<<<<<< HEAD
		$auto_alt 	= $atts['img'] ? basename( $atts['img'] ) : null;
		$alt 		= $auto_alt ? preg_replace( '/\\.[^.\\s]{3,4}$/', '', $auto_alt ) : null;
=======
		$auto_alt  = $atts['img'] ? basename( $atts['img'] ) : null;
		$alt   = $auto_alt ? preg_replace( '/\\.[^.\\s]{3,4}$/', '', $auto_alt ) : null;
>>>>>>> release/1.5.1

		// character wrap
		ob_start();

<<<<<<< HEAD
			do_action( 'aesop_character_before' ); // action
			?>
=======
		do_action( 'aesop_character_before' ); // action
?>
>>>>>>> release/1.5.1
				<aside id="aesop-character-component-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'character', $unique, $atts );?> class="aesop-character-component aesop-component <?php echo sanitize_html_class( $classes ).''.sanitize_html_class( $float );?> ">

					<?php do_action( 'aesop_character_inside_top' ); // action ?>

					<div class="aesop-character-inner aesop-content">
						<div class="aesop-character-float aesop-character-<?php echo esc_attr( $atts['align'] );?>" <?php echo $styles;?>>

							<?php do_action( 'aesop_character_inner_inside_top' ); // action ?>

							<?php if ( $atts['name'] ) {?>
								<span class="aesop-character-title"><?php echo aesop_component_media_filter( $atts['name'] );?></span>
							<?php } ?>

							<?php if ( $atts['img'] ) {?>
								<img class="aesop-character-avatar" src="<?php echo esc_url( $atts['img'] );?>" alt="<?php echo esc_attr_e( $alt );?>">
							<?php } ?>

							<?php if ( $content ) {?>
								<div class="aesop-character-text"><?php echo do_shortcode( $content );?></div>
							<?php } ?>

							<?php if ( $atts['caption'] ) { ?>
								<p class="aesop-character-cap"><?php echo aesop_component_media_filter( $atts['caption'] );?></p>
							<?php } ?>

							<?php do_action( 'aesop_character_inner_inside_bottom' ); // action  ?>

						</div>
					</div>

					<?php do_action( 'aesop_character_inside_bottom' ); // action ?>

				</aside>
			<?php

<<<<<<< HEAD
			do_action( 'aesop_character_after' ); // action
=======
		do_action( 'aesop_character_after' ); // action
>>>>>>> release/1.5.1

			return ob_get_clean();
	}
}//end if