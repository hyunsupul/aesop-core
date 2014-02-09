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

	    do_action('aesop_audio_before');

	   		?><aside class="aesop-component aesop-audio-component"><?php 

	   			do_action('aesop_audio_inside_top');

	   				echo wp_audio_shortcode( $defaults );

	   			do_action('aesop_audio_inside_bottom');

	   		?></aside><?php

	   	do_action('aesop_audio_after');

        return ob_get_clean();
	}
}