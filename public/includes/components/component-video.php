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
	    	'src' =>'vimeo',
	    	'id'	=> ''
	    );
	    $atts = apply_filters('aesop_video_defaults',shortcode_atts($defaults, $atts));

	    $caption = $content ? sprintf('<div class="aesop-video-component-caption">%s</div>',$content) : false;

	    $out = sprintf('<section class="aesop-component aesop-video-component">%s<div class="aesop-video-container aesop-video-container-%s">',$caption,$hash);

	        $out .= sprintf('<script>
		    	jQuery(document).ready(function(){
		    		jQuery(\'.aesop-video-container.aesop-video-container-%s\').fitVids();
		    	});
		    	</script>
		    		', $hash);

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

	            default:
	                $out .= sprintf('<iframe src="http://www.youtube.com/embed/%s%s" width="%s" height="" frameborder="0" allowfullscreen wmode="transparent"></iframe>', $atts['id']) ;

	        endswitch;

	    $out .= sprintf('</div></section>');

        return apply_filters('aesop_video_output',$out);
	}
}