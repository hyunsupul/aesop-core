<?php
/**
 * Responsive video component with full width settings
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_video_shortcode' ) ) {
	function aesop_video_shortcode( $atts ) {

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );
		$defaults = array(
			'width'  	=> '100%',
			'align'  	=> 'center',
			'src'   	=> 'vimeo',
			'hosted'  	=> '',
			'id'  		=> '',
			'loop'  	=> 'on',
			'autoplay' 	=> 'on',
			'controls' 	=> 'off',
			'viewstart' => 'off',
			'viewend'   => 'off',
			'caption'  	=> '',
			'vidwidth'  => '',
			'vidheight' => ''
		);
		$atts = apply_filters( 'aesop_video_defaults', shortcode_atts( $defaults, $atts ) );

		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		$widthstyle = $atts['width'] && 'center' !== $atts['align'] ? sprintf( 'style=width:%s;', $atts['width'] ) : sprintf( 'style=max-width:%s;', $atts['width'] );

		// width constraint class if
		$caption = !empty( $atts['caption'] ) ? sprintf( '<div class="aesop-video-component-caption aesop-component-align-%s" %s>%s</div>', $atts['align'], $widthstyle, $atts['caption'] ) : false;

		if ( 'vine' == $atts['src'] || 'instagram' == $atts['src'] ) {
			$vineStagramClass = 'aesop-vine-stagram-container';
			$vineStagramAlign = $atts['align'] ? sprintf( 'aesop-vine-stagram-container-%s', $atts['align'] ) : false;
		} else {
			$vineStagramAlign = null;
			$vineStagramClass = null;
		}

		$loopstatus  = 'on' == $atts['loop'] ? true : false;
		$autoplaystatus = 'on' == $atts['autoplay'] ? true : false;
		$controlstatus = 'on' == $atts['controls'] ? 'controls-visible' : 'controls-hidden';
		$iframe_height = $atts['vidheight'] ? sprintf( 'height="%s"', preg_replace( '/[^0-9]/', '', $atts['vidheight'] ) ) : sprintf( 'height=""' );
		$iframe_width = $atts['vidwidth'] ? sprintf( 'width="%s"', preg_replace( '/[^0-9]/', '', $atts['vidwidth'] ) ) : sprintf( 'width=""' );
		$iframe_size = sprintf( '%s %s' , $iframe_height, $iframe_width );

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'video', '' ) : null;

		// waypoint filter
		$point   = 'bottom-in-view';
		$waypoint  = apply_filters( 'aesop_video_component_waypoint', $point, $unique );

		ob_start();

		if ( 'on' == $atts['viewstart'] && 'self' == $atts['src'] ) { ?>
	    	<script>
		    	jQuery(document).ready(function($){
		    		$('#aesop-video-<?php echo esc_attr( $unique );?>').arrive('.mejs-video', function(){
						$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
							offset: '<?php echo esc_attr( $waypoint );?>',
							handler: function(direction){
						   		$('#aesop-video-<?php echo esc_attr( $unique );?> .mejs-playpause-button button').trigger('click');
						   	}
						});
						<?php if ( 'on' == $atts['viewend'] ) { ?>
						$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
							handler: function(direction){
						   		$('#aesop-video-<?php echo esc_attr( $unique );?> .mejs-playpause-button button').trigger('click');
						   	}
						});
						<?php } ?>
					});
		    	});
	    	</script>
    	<?php }//end if
		do_action( 'aesop_video_before', $atts, $unique ); // action
?>
	    <div id="aesop-video-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'video', $unique, $atts );?> class="aesop-component aesop-video-component aesop-component-align-<?php echo sanitize_html_class( $atts['align'] );?> <?php echo sanitize_html_class( $classes );?> <?php echo sanitize_html_class( $controlstatus );?> <?php echo sanitize_html_class( $contentwidth );?> <?php echo sanitize_html_class( $vineStagramClass );?> <?php echo sanitize_html_class( $vineStagramAlign );?>">

	    	<?php do_action( 'aesop_video_inside_top', $atts, $unique ); // action ?>

	    	<div class="aesop-video-container aesop-video-container-<?php echo esc_attr( $unique );?> aesop-component-align-<?php echo sanitize_html_class( $atts['align'] );?> <?php echo sanitize_html_class( $atts['src'] );?>" <?php echo $widthstyle;?> >

				<?php
		switch ( $atts['src'] ) {
		case 'vimeo':
			printf( '<iframe src="//player.vimeo.com/video/%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>', esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
			break;
		case 'dailymotion':
			printf( '<iframe src="//www.dailymotion.com/embed/video/%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>', esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
			break;
		case 'youtube':
			printf( '<iframe src="//www.youtube.com/embed/%s?rel=0&wmode=transparent" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>', esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
			break;
		case 'kickstarter':
			printf( '<iframe src="%s" %s scrolling="no"> </iframe>', esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
			break;
		case 'viddler':
			printf( '<iframe id="viddler-%s" src="//www.viddler.com/embed/%s/" %s mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>', esc_attr( $atts['id'] ), esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
			break;
		case 'vine':
			printf( '<iframe class="vine-embed" src="//vine.co/v/%s/embed/simple" width="480" height="480" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>', esc_attr( $atts['id'] ) );
			break;
		case 'wistia':
			printf( '
									<div id="wistia_%s" class="wistia_embed" style="width:640px;height:360px;">&nbsp;</div>
									<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"></script>
									<script> wistiaEmbed = Wistia.embed("%s",{videoFoam: true }); </script>
				                	', esc_attr( $atts['id'] ), esc_attr( $atts['id'] ) );
			break;
		case 'instagram':
			printf( '<iframe class="instagram-embed" src="//instagram.com/p/%s/embed" width="612" height="710" frameborder="0"></iframe>', esc_attr( $atts['id'] ) );
			break;
		case 'self':
			echo do_shortcode( '[video src="'.$atts['hosted'].'" loop="'.esc_attr( $loopstatus ).'" autoplay="'.esc_attr( $autoplaystatus ).'"]' );
		}
?>
		    </div>

	   	 	<?php echo $caption;

		do_action( 'aesop_video_inside_bottom', $atts, $unique ); // action ?>
		</div>

		<?php do_action( 'aesop_video_after', $atts, $unique ); // action
		return ob_get_clean();
	}
}//end if
