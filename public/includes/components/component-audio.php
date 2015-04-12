<?php

/**
 * Audio component utilizes core wordpress audio
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_audio_shortcode' ) ) {

	function aesop_audio_shortcode( $atts ) {

		$defaults   = array(
			'title'    	=> '',
			'src'      	=> '',
			'viewstart' => 'off',
			'viewend'  	=> 'off',
			'loop'     	=> 'off',
			'hidden'   	=> ''
		);
		$atts     = apply_filters( 'aesop_audio_defaults', shortcode_atts( $defaults, $atts ) );

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'audio', '' ) : null;

		// hidden
		$hidden = 'on' == $atts['hidden'] ? 'style=height:0;z-index:-1;position:absolute;opacity:0;' : null;

		// optional title
		$title = $atts['title'] ? apply_filters( 'aesop_audio_component_title', sprintf( '<h5>%s</h5>', $atts['title'] ) ) : null;

		// loop
		$loop = 'on' == $atts['loop'] ? 'true' : false;

		// waypoint filter
		$point    = 'bottom-in-view';
		$waypoint   = apply_filters( 'aesop_audio_component_waypoint', $point, $unique );

		ob_start();

		do_action( 'aesop_audio_before', $atts, $unique ); // action

		?><aside id="aesop-audio-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'audio', $unique, $atts );?> class="aesop-component aesop-audio-component <?php echo sanitize_html_class( $classes );?>" <?php echo esc_attr( $hidden );?>>

			<?php if ( 'on' == $atts['viewstart'] ) { ?>
				<script>
				jQuery(document).ready(function($){
					$('#aesop-audio-<?php echo esc_attr( $unique );?>').arrive('.mejs-audio', function(){

						$('#aesop-audio-<?php echo esc_attr( $unique );?>').waypoint({
							offset: '<?php echo esc_attr( $waypoint );?>',
							handler: function(direction){
								$('#aesop-audio-<?php echo esc_attr( $unique );?> .mejs-playpause-button button').css({'cursor':'pointer'}).click();
							}
						});

						<?php if ( 'on' == $atts['viewend'] ) { ?>
						$('#aesop-audio-<?php echo esc_attr( $unique );?>').waypoint({
							handler: function(direction){
								$('#aesop-audio-<?php echo esc_attr( $unique );?> .mejs-playpause-button button').css({'cursor':'pointer'}).click();
							}
						});
						<?php } ?>

						});
					});
				</script>
			<?php }//end if

			do_action( 'aesop_audio_inside_top', $atts, $unique ); // action

			if ( $title ) {
				echo aesop_component_media_filter( $title );
			}

			echo wp_audio_shortcode( array( 'src' => $atts['src'], 'loop' => $loop ) );

			do_action( 'aesop_audio_inside_bottom', $atts, $unique ); // action

		?></aside><?php

		do_action( 'aesop_audio_after', $atts, $unique ); // action

		return ob_get_clean();
	}
}//end if
