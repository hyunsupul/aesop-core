<?php

/**
 	* Creates a fullscreen chapter heading
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_chapter_shortcode')){

	function aesop_chapter_shortcode($atts, $content = null) {
		$defaults = array(
			'title' 	=> '',
			'subtitle' 	=> '',
			'bgtype' 	=> 'img',
			'img' 		=> '',
			'full'		=> ''
		);

		$atts = apply_filters('aesop_chapter_defaults',shortcode_atts($defaults, $atts));

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf('%s-%s',get_the_ID(), $instance);

		ob_start();

		$inline_styles 		= 'background-size:cover;background-position:center center;';
		$styles 			= apply_filters( 'aesop_chapter_img_styles_'.esc_attr( $unique ), esc_attr( $inline_styles ) );

		$img_style 		 	= 'img' == $atts['bgtype'] && $atts['img'] ? sprintf('style="background:url(\'%s\');%s"', esc_url( $atts['img'] ), $styles) : 'style="height:auto;" ';
		$img_style_class 	= 'img' == $atts['bgtype'] && $atts['img'] ? 'has-chapter-image' : 'no-chapter-image';

		$video_chapter_class = 'video' == $atts['bgtype'] ? 'aesop-video-chapter' : null;

		do_action('aesop_chapter_before'); //action

			if ( 'on' == $atts['full'] ) { ?>
			<script>
				jQuery(document).ready(function(){
					var coverSizer = function(){
						jQuery('.aesop-article-chapter').css({'height':(jQuery(window).height())+'px'});
					}
					coverSizer();
				    jQuery(window).resize(function(){
        				coverSizer();
    				});
				});
			</script>
			<?php } ?>
			<div id="chapter-unique-<?php echo $unique;?>" class="aesop-article-chapter-wrap default-cover <?php echo $video_chapter_class;?> aesop-component <?php echo $img_style_class;?>" >

				<?php do_action('aesop_chapter_inside_top'); //action ?>

				<div class="aesop-article-chapter clearfix" <?php echo $img_style;?> >

					<h2 class="aesop-cover-title" itemprop="title" >
						<?php echo esc_html( $atts['title'] );

						if ( $atts['subtitle'] ) { ?>
							<small><?php echo esc_html( $atts['subtitle'] );?></small>
						<?php } ?>
					</h2>

					<?php if ( 'video' == $atts['bgtype'] ) { ?>
					<div class="video-container">
						<?php echo do_shortcode('[video src="'.esc_url( $atts['img'] ).'" loop="on" autoplay="on"]'); ?>
					</div>
					<?php } ?>

				</div>

				<?php do_action('aesop_chapter_inside_bottom'); //action ?>

			</div>
		<?php

		do_action('aesop_chapter_after'); //action

		return ob_get_clean();
	}
}

if (!function_exists('aesop_chapter_heading_loader')){

	add_action('wp','aesop_chapter_heading_loader',11);
	function aesop_chapter_heading_loader() {

		global $post;

		$default_location 	= is_single();
		$location 			= apply_filters( 'aesop_chapter_component_appears', $default_location );

		if( isset($post->post_content) && ( $location ) && has_shortcode( $post->post_content, 'aesop_chapter') )  {

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

		// allow theme developers to determine the offset amount
		$chapterOffset = apply_filters('aesop_chapter_scroll_offset', 0 );

		// filterable content class
		$contentClass = apply_filters('aesop_chapter_scroll_container', '.aesop-entry-content');

		// filterabl content header class
		$contentHeaderClass = apply_filters('aesop_chapter_scroll_nav', '.aesop-entry-header');
		?>
			<!-- Chapter Loader -->
			<script>
				jQuery(document).ready(function(){

					jQuery('<?php echo esc_attr( $contentClass );?>').scrollNav({
					    sections: '.aesop-article-chapter-wrap',
					    arrowKeys: true,
					    insertTarget: '<?php echo esc_attr( $contentHeaderClass );?>',
					    insertLocation: 'appendTo',
					    showTopLink: true,
					    showHeadline: false,
					    scrollOffset: <?php echo absint( $chapterOffset );?>,
					});

				});
			</script>

		<?php
	}
}





