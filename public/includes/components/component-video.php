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
    		'width' => '100%',
    		'align' => 'center',
	    	'src' =>'vimeo',
	    	'hosted' => '',
	    	'id'	=> ''
	    );
	    $atts = apply_filters('aesop_video_defaults',shortcode_atts($defaults, $atts));
	    $contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;
	    $widthstyle = $atts['width'] ? sprintf('style="width:%s;"',$atts['width']) : false;

	    $caption = $content ? sprintf('<div class="aesop-video-component-caption aesop-component-align-%s" %s>%s</div>',$atts['align'], $widthstyle, $content) : false;

	    $out = sprintf('<section class="aesop-component aesop-video-component %s"><div class="aesop-video-container aesop-video-container-%s aesop-component-align-%s %s" %s>',$contentwidth, $hash, $atts['align'], $atts['src'], $widthstyle);

	        switch( $atts['src'] ):

	            case 'vimeo':
	                $out .= sprintf( '<iframe src="http://player.vimeo.com/video/%s" width="" height=""  frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent"></iframe>',$atts['id'] );
	                break;

	            case 'dailymotion':
	                $out .= sprintf( '<iframe src="http://www.dailymotion.com/embed/video/%s" width="" height=""  frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent"></iframe>',$atts['id'] );
	                break;

	            case 'youtube':
	                $out .= sprintf( '<iframe src="http://player.vimeo.com/video/%s" width="" height=""  frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent"></iframe>',$atts['id'] );
	                break;

	            case 'kickstarter':
	                $out .= sprintf( '<<iframe width="" height="" src="%s" frameborder="0" scrolling="no"> </iframe>',$atts['id'] );
	                break;

	            case 'viddler':
	                $out .= sprintf( '<iframe id="viddler-%s" src="//www.viddler.com/embed/%s/" width="" height="" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>',$atts['id'], $atts['id'] );
	                break;

	            case 'self':
	            	$out .= do_shortcode('[video src="'.$atts['hosted'].'" loop="on" autoplay="on"]');

	        endswitch;

	    $out .= sprintf('</div>%s</section>',$caption);

        return apply_filters('aesop_video_output',$out);
	}
}