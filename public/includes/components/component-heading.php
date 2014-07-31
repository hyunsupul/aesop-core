<?php

/**
 	* Creates a fullscreen chapter heading
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_chapter_shortcode')){

	function aesop_chapter_shortcode($atts, $content = null) {
		$defaults = array(
			'label'		=> '',
			'title' 	=> '',
			'subtitle' 	=> '',
			'bgtype' 	=> 'img',
			'img' 		=> ''
		);

		$atts = apply_filters('aesop_chapter_defaults',shortcode_atts($defaults, $atts));

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf('%s-%s',get_the_ID(), $instance);

		ob_start();

		$inline_styles = 'background-size:cover;background-position:center center;';
		$styles = apply_filters( 'aesop_chapter_img_styles_'.$unique, $inline_styles );

		$img_style = $atts['img'] ? sprintf('style="background:url(\'%s\');%s"', $atts['img'], $styles) : null;
		$img_style_class = $atts['img'] ? 'has-chapter-image' : 'no-chapter-image';

		do_action('aesop_chapter_before'); //action

			if ('video' == $atts['bgtype']) { ?>

				<div id="chapter-unique-<?php echo $unique;?>" class="aesop-article-chapter-wrap default-cover aesop-video-chapter aesop-component" >

					<?php do_action('aesop_chapter_inside_top'); //action ?>

					<div class="aesop-article-chapter clearfix" style="height:auto;">
						<span class="aesop-chapter-title"><?php echo $atts['label'];?></span>
						<h2 class="aesop-cover-title" itemprop="title" >
							<?php echo $atts['title'];

							if ($atts['subtitle']) { ?>
								<small><?php echo $atts['subtitle'];?></small>
							<?php } ?>
						</h2>
						<div class="video-container">
							<?php echo do_shortcode('[video src="'.$atts['img'].'" loop="on" autoplay="on"]'); ?>
						</div>
					</div>

					<?php do_action('aesop_chapter_inside_bottom'); //action ?>

				</div>

			<?php } else { ?>

				<div id="chapter-unique-<?php echo $unique;?>" class="aesop-article-chapter-wrap default-cover aesop-component <?php echo $img_style_class;?> ">

					<?php do_action('aesop_chapter_inside_top'); //action ?>

					<div class="aesop-article-chapter clearfix " <?php echo $img_style;?> >

						<?php do_action('aesop_chapter_inner_inside_top'); //action ?>

						<span class="aesop-chapter-title"><?php echo $atts['label'];?></span>
						<h2 class="aesop-cover-title" itemprop="title" >
							<?php echo $atts['title'];
							if ($atts['subtitle']) { ?>
								<small><?php echo $atts['subtitle'];?></small>
							<?php } ?>
						</h2>

						<?php do_action('aesop_chapter_inner_inside_bottom'); //action ?>

					</div>

					<?php do_action('aesop_chapter_inside_bottom'); //action ?>

				</div>

			<?php }

		do_action('aesop_chapter_after'); //action

		return ob_get_clean();
	}
}

if (!function_exists('aesop_chapter_heading_loader')){

	add_action('wp','aesop_chapter_heading_loader',11);
	function aesop_chapter_heading_loader() {

		global $post;

		if( isset($post->post_content) && is_single() && has_shortcode( $post->post_content, 'aesop_chapter') )  {

			new AesopChapterHeadingComponent;

		}
	}

}

// @TODO - this needs to be moved to theme level because not all will use the offset and setup here
class AesopChapterHeadingComponent {

	function __construct(){
		add_action('wp_footer', array($this,'aesop_chapter_loader'),21);
	}

	function aesop_chapter_loader(){

		// maintain backwards compatibility
		$offset = 0;

		// allow theme developers to determine the offset amount
		$chapterOffset = apply_filters('aesop_chapter_scroll_offset', $offset );

		// filterable content class
		$contentClass = apply_filters('aesop_chapter_scroll_container', '.aesop-entry-content');

		// filterabl content header class
		$contentHeaderClass = apply_filters('aesop_chapter_scroll_nav', '.aesop-entry-header');
		?>
			<!-- Chapter Loader -->
			<script>
				jQuery(document).ready(function(){

					jQuery('<?php echo $contentClass;?>').scrollNav({
					    sections: '.aesop-chapter-title',
					    arrowKeys: true,
					    insertTarget: '<?php echo $contentHeaderClass;?>',
					    insertLocation: 'appendTo',
					    showTopLink: true,
					    showHeadline: false,
					    scrollOffset: <?php echo $chapterOffset;?>,
					});

				});
			</script>

		<?php
	}
}





