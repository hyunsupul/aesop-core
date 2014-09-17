<?php

/**
	* Audio component utilizes core wordpress audio
	*
	* @since    1.0.0
*/
if (!function_exists('aesop_audio_shortcode')){

	function aesop_audio_shortcode($atts, $content = null) {

			$defaults   = array(
				'title'   => '',
				'src'     =>  '',
				'viewstart' => 'off',
				'viewend' =>  'off',
				'loop'    => 'off',
				'hidden'  => ''
			);
			$atts     = apply_filters('aesop_video_defaults',shortcode_atts($defaults, $atts));
		
		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf('%s-%s',get_the_ID(), $instance);

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'audio', '' ) : null;

		// hidden
		$hidden = 'on' == $atts['hidden'] ? 'style="height:0;z-index:-1;position:absolute;opacity:0;"' : null;

		// optional title
		$title = $atts['title'] ? apply_filters('aesop_audio_component_title', sprintf('<h5>%s</h5>', $atts['title'])) : null;

		// loop
		$loop = 'on' == $atts['loop'] ? 'true' : false;

		// waypoint filter
		$point    = 'bottom-in-view';
		$waypoint   = apply_filters('aesop_audio_component_waypoint', $point, $unique);

			ob_start();

			do_action('aesop_audio_before'); //action

				?><aside id="aesop-audio-<?php echo $unique;?>" class="aesop-component aesop-audio-component <?php echo $classes;?>" <?php echo $hidden;?>>

					<?php if ('on' == $atts['viewstart']) { ?>
						<script>
						jQuery(document).ready(function(){
							jQuery('#aesop-audio-<?php echo $unique;?>').arrive('.mejs-audio', function(){
								
								jQuery('#aesop-audio-<?php echo $unique;?>').waypoint({
									offset: '<?php echo $waypoint;?>',
									handler: function(direction){
										jQuery('#aesop-audio-<?php echo $unique;?> .mejs-playpause-button button').css({'cursor':'pointer'}).click();
									}
								});

								<?php if ('on' == $atts['viewend']) { ?>
								jQuery('#aesop-audio-<?php echo $unique;?>').waypoint({
									handler: function(direction){
											jQuery('#aesop-audio-<?php echo $unique;?> .mejs-playpause-button button').css({'cursor':'pointer'}).click();
										}
								});
								<?php } ?>

								});
							});
						</script>
					<?php } ?>

					<?php
					do_action('aesop_audio_inside_top'); //action

						if ($title) {
							echo $title;
						}

						echo wp_audio_shortcode(  array( 'src' => $atts['src'], 'loop' => $loop ) );

					do_action('aesop_audio_inside_bottom'); //action

				?></aside><?php

			do_action('aesop_audio_after'); //action

				return ob_get_clean();
	}
}