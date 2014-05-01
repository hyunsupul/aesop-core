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
	    	'loop'		=> 'on',
	    	'autoplay'	=> 'on',
	    	'controls'	=> 'off',
	    	'viewstart' => 'off',
	    	'viewend'   => 'off',
	    	'caption' 	=> '',
	    	'vidwidth'  => '',
	    	'vidheight' => ''
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

	    if ( 'vine' == $atts['src'] || 'instagram' == $atts['src'] ) {

	    	$vineStagramClass = 'aesop-vine-stagram-container';
			$vineStagramAlign = $atts['align'] ? sprintf('aesop-vine-stagram-container-%s',$atts['align']) : false;

	    } else {

	    	$vineStagramAlign = null;
	    	$vineStagramClass = null;
	    }

	    $loopstatus 	= 'on' == $atts['loop'] ? true : false;
	    $autoplaystatus = 'on' == $atts['autoplay'] ? true : false;
	    $controlstatus = 'on' == $atts['controls'] ? 'controls-visible' : 'controls-hidden';

	    $iframe_height = $atts['vidheight'] ? sprintf('height="%s"', preg_replace('/[^0-9]/', '', $atts['vidheight']) ) : sprintf('height=""');
	    $iframe_width = $atts['vidwidth'] ? sprintf('width="%s"', preg_replace('/[^0-9]/', '', $atts['vidwidth']) ) : sprintf('width=""');

	    $iframe_size = sprintf('%s %s' ,$iframe_height, $iframe_width);

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'video', '' ) : null;

	    $hash = rand();

	    ob_start();

	    if ('on' == $atts['viewstart']) { ?>
	    	<script>
		    	jQuery(document).ready(function(){
					jQuery('#aesop-video-<?php echo $hash;?>').waypoint({
						offset: 'bottom-in-view',
						handler: function(direction){
					   		jQuery('#aesop-video-<?php echo $hash;?> .mejs-playpause-button button').trigger('click');
					   	}
					});
					<?php if ('on' == $atts['viewend']) { ?>
					jQuery('#aesop-video-<?php echo $hash;?>').waypoint({
						handler: function(direction){
					   		jQuery('#aesop-video-<?php echo $hash;?> .mejs-playpause-button button').trigger('click');
					   	}
					});
					<?php } ?>
		    	});
	    	</script>
    	<?php }

	    printf('%s<div id="aesop-video-%s" class="aesop-component aesop-video-component %s %s %s %s %s">%s<div class="aesop-video-container aesop-video-container-%s aesop-component-align-%s %s" %s>',$actiontop, $hash, $classes, $controlstatus, $contentwidth, $vineStagramClass, $vineStagramAlign, $actioninsidetop, $hash, $atts['align'], $atts['src'], $widthstyle);


	        switch( $atts['src'] ):

	            case 'vimeo':
	                printf( '<iframe src="//player.vimeo.com/video/%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>',$atts['id'], $iframe_size );
	                break;

	            case 'dailymotion':
	                printf( '<iframe src="//www.dailymotion.com/embed/video/%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>',$atts['id'], $iframe_size );
	                break;

	            case 'youtube':
	                printf( '<iframe src="//www.youtube.com/embed/%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>',$atts['id'], $iframe_size );
	                break;

	            case 'kickstarter':
	                printf( '<iframe src="%s" %s scrolling="no"> </iframe>',$atts['id'], $iframe_size );
	                break;

	            case 'viddler':
	                printf( '<iframe id="viddler-%s" src="//www.viddler.com/embed/%s/" %s mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>',$atts['id'], $atts['id'], $iframe_size );
	                break;

	           	case 'vine':
	                printf( '<iframe class="vine-embed" src="//vine.co/v/%s/embed/simple" width="480" height="480" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>',$atts['id'] );
	                break;

	           	case 'instagram':
	                printf( '<iframe class="instagram-embed" src="//instagram.com/p/%s/embed" width="612" height="710" frameborder="0"></iframe>',$atts['id'] );
	                break;

	            case 'self':
	            	echo do_shortcode('[video src="'.$atts['hosted'].'" loop="'.$loopstatus.'" autoplay="'.$autoplaystatus.'"]');

	        endswitch;

	    printf('</div>%s%s</div>%s',$caption, $actioninsidebottom, $actionbottom);

        return ob_get_clean();
	}
}