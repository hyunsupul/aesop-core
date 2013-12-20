<?php

/**
 	* Creates an interactive character element
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

		ob_start();
		?>
		<section class="aesop-article-chapter-wrap">
			<div class="aesop-article-chapter clearfix" style="background:url('<?php echo $atts['img'];?>') center center;background-size:cover;">
				<h1 class="aesop-chapter-title" itemprop="title"><?php echo $atts['title'];?></h1>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}
}