<?php

/**
 	* Responsive video component with full width settings
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_video_shortcode')){

	function aesop_video_shortcode($atts, $content = null) {

    	$hash = rand();
    	$defaults = array(
    		'width' 	=> '100%',
    		'align' 	=> 'center',
	    	'src' 		=> 'vimeo',
	    	'hosted' 	=> '',
	    	'id'		=> '',
	    	'caption' 	=> ''
	    );
	    $atts = apply_filters('aesop_video_defaults',shortcode_atts($defaults, $atts));
	    $contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;
	    $widthstyle = $atts['width'] ? sprintf('style="width:%s;"',$atts['width']) : false;

	    // actions
		$actiontop = do_action('aesop_video_before'); //action
		$actionbottom = do_action('aesop_video_after'); //action
		$actioninsidetop = do_action('aesop_videox_inside_top'); //action
		$actioninsidebottom = do_action('aesop_video_inside_bottom'); //action

	    $caption = $atts['caption'] ? sprintf('<div class="aesop-video-component-caption aesop-component-align-%s" %s>%s</div>',$atts['align'], $widthstyle, $atts['caption']) : false;

	    $out = sprintf('%s<div class="aesop-component aesop-video-component %s">%s<div class="aesop-video-container aesop-video-container-%s aesop-component-align-%s %s" %s>',$actiontop, $contentwidth, $actioninsidetop, $hash, $atts['align'], $atts['src'], $widthstyle);

	        switch( $atts['src'] ):

	            case 'vimeo':
	                $out .= sprintf( '<iframe src="//player.vimeo.com/video/%s" width="" height=""  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent"></iframe>',$atts['id'] );
	                break;

	            case 'dailymotion':
	                $out .= sprintf( '<iframe src="//www.dailymotion.com/embed/video/%s" width="" height=""  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent"></iframe>',$atts['id'] );
	                break;

	            case 'youtube':
	                $out .= sprintf( '<iframe src="//www.youtube.com/embed/%s" width="" height=""  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent"></iframe>',$atts['id'] );
	                break;

	            case 'kickstarter':
	                $out .= sprintf( '<iframe width="" height="" src="%s" scrolling="no"> </iframe>',$atts['id'] );
	                break;

	            case 'viddler':
	                $out .= sprintf( '<iframe id="viddler-%s" src="//www.viddler.com/embed/%s/" width="" height="" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>',$atts['id'], $atts['id'] );
	                break;

	            case 'self':
	            	$out .= do_shortcode('[video src="'.$atts['hosted'].'" loop="on" autoplay="on"]');

	        endswitch;

	    $out .= sprintf('</div>%s%s</div>%s',$caption, $actioninsidebottom, $actionbottom);

        return apply_filters('aesop_video_output',$out);
	}
}