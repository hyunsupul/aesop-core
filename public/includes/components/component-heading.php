<?php

/**
 	* Creates a fullscreen chapter heading
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_chapter_shortcode')){

	function aesop_chapter_shortcode($atts, $content = null) {
		$defaults = array(
			'title' => '',
			'img' => ''
		);
		$atts = shortcode_atts($defaults, $atts);
		$hash = rand();

		ob_start();
		?>
		<section id="chapter-hash-<?php echo $hash;?>" class="aesop-article-chapter-wrap default-cover">
			<div class="aesop-article-chapter clearfix" style="background:url('<?php echo $atts['img'];?>') center center;background-size:cover;">
				<h1 class="aesop-cover-title aesop-chapter-title" itemprop="title"><?php echo $atts['title'];?></h1>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}
}

if (!function_exists('aesop_chapter_heading_loader')){

	add_action('wp','aesop_chapter_heading_loader');
	function aesop_chapter_heading_loader() {

		global $post;

		if( has_shortcode( $post->post_content, 'aesop_chapter') )  { 

			new AesopChapterHeadingComponent;

		}
	}

}

class AesopChapterHeadingComponent {

	function __construct(){
		add_action('wp_footer', array($this,'aesop_chapter_loader'),21);
	}

	function aesop_chapter_loader(){

		?>
			<script>
			jQuery(document).ready(function(){

				jQuery('.aesop-entry-content').scrollNav({
				    sections: '.aesop-article-chapter-wrap',
				    arrowKeys: true,
				    insertTarget: '.aesop-story-header',
				    insertLocation: 'appendTo',
				    showTopLink: false,
				    showHeadline: false,
				    scrollOffset: 36,
				});

			});

			</script>

		<?php 
	}
}





