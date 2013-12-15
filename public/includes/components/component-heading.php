<?php

/**
 	* Creates an interactive character element
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_chapter_shortcode')){

	function aesop_chapter_shortcode($atts, $content = null) {
		$defaults = array(
			'num' => 1,
		);
		$atts = shortcode_atts($defaults, $atts);

		$out = sprintf('<h2 class="aesop-chapter-heading">%s</h2>',$atts['num']);
		return $out;
	}
}


class AesopHeadingComponent {

	function __construct(){
		add_action('wp_footer', array($this,'aesop_heading_loader'),22);
	}

	function aesop_heading_loader(){

		global $post;

		if( has_shortcode( $post->post_content, 'aesop_chapter_heading') )  { ?>
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
}
new AesopHeadingComponent;
