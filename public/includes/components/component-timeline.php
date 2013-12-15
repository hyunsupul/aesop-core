<?php

/**
 	* Creates an interactive character element
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_timeline_shortcode')){

	function aesop_timeline_shortcode($atts, $content = null) {

		$defaults = array(

		);
		$atts = shortcode_atts($defaults, $atts);

		$out = '';

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

		if( has_shortcode( $post->post_content, 'aesop_timeline') )  { ?>
			<script>
				jQuery('.aesop-entry-content').scrollNav({
				    sections: '.aesop-chapter-heading',
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

		if( has_shortcode( $post->post_content, 'aesop_timeline') )  {
			echo 'test';
		}
	}
}
new AesopTimelineComponent;




