<?php

/**
 	* Creates an interactive timeline component that works similar to chapter headings
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_timeline_stop_shortcode')){

	function aesop_timeline_stop_shortcode($atts, $content = null) {

		$defaults = array(
			'num' => '2007',
		);
		$atts = shortcode_atts($defaults, $atts);

		$out = sprintf('<h2 class="aesop-timeline-stop">%s</h2>',$atts['num']);
		
		return apply_filters('aesop_timeline_output',$out);
	}
}

class AesopTimelineComponent {

	function __construct(){
		add_action('wp_footer', array($this,'aesop_timeline_loader'),21);
		add_action('aesop_inside_body_top', array($this,'draw_timeline'));
	}

	function aesop_timeline_loader(){

		global $post;

		if( has_shortcode( $post->post_content, 'aesop_timeline_stop') )  { ?>
			<script>
				jQuery('.aesop-entry-content').scrollNav({
				    sections: '.aesop-timeline-stop',
				    arrowKeys: true,
				    insertTarget: 'body',
				    insertLocation: 'prependTo',
				    showTopLink: false,
				    showHeadline: false,
				    scrollOffset: 80,
				});

			</script>

		<?php }
	}

	function draw_timeline(){

		global $post;

		if( has_shortcode( $post->post_content, 'aesop_timeline_stop') )  {
			echo 'test';
		}
	}
}
new AesopTimelineComponent;




