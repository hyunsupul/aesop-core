<?php

/**
 	* Audio component utilizes core wordpress audio
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_audio_shortcode')){

	function aesop_audio_shortcode($atts, $content = null) {

    	$defaults = array('src' =>'');
	    $atts = apply_filters('aesop_video_defaults',shortcode_atts($defaults, $atts));

	    ob_start();

	    do_action('aesop_audio_before'); //action

	   		?><aside class="aesop-component aesop-audio-component"><?php 

	   			do_action('aesop_audio_inside_top'); //action

	   				echo wp_audio_shortcode(  array( 'src' => $atts['src']) );

	   			do_action('aesop_audio_inside_bottom'); //action

	   		?></aside><?php

	   	do_action('aesop_audio_after'); //action

        return ob_get_clean();
	}
}