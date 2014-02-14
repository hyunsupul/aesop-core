<?php

/**
 	* Creates an interactive timeline component that works similar to chapter headings
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_collection_shortcode')){

	function aesop_collection_shortcode($atts, $content = null) {

		$defaults = array(
			'collection' => 1,
			'title' => ''
		);
		$atts = apply_filters('aesop_collection_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		ob_start();

		do_action('aesop_collection_before'); // action

		?>
			<!-- Collections -->
			<div class="aesop-story-collection">

				<?php do_action('aesop_collection_inside_top'); // action ?>

				<?php if($atts['title']){?>
					<h4 class="aesop-story-collection-title"><span><?php echo $atts['title'];?></span></h4>
				<?php } ?>
				
				<div id="aesop-collection-<?php echo $hash;?>" class="aesop-collection-grid clearfix">
					<?php

					$args1 = array(
						'posts_per_page' => -1,
						'cat' => $atts['collection']
					);
					$q1 = new wp_query( apply_filters( 'aesop_collection_query', $args1 ) );

					if($q1->have_posts()) : while($q1->have_posts()) : $q1->the_post();

						$coverimg 		= wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID() ), 'large' );

						?><div class="aesop-collection-item">
							<a class="aesop-fader aesop-collection-item-link" href="<?php the_permalink();?>">
								<div class="aesop-collection-item-inner">
									<h2 class="aesop-collection-entry-title" itemprop="title"><?php the_title();?></h2>
									<p class="aesop-collection-meta">Written by <?php echo get_the_author();?></p>
									<div class="aesop-collection-item-excerpt"><?php echo wp_trim_words(get_the_excerpt(),22,'...');?></div>
								</div>
								<div class="aesop-collection-item-img" style="background-image:url(<?php echo $coverimg[0];?>);background-repeat:no-repeat;background-size:cover;"></div>
							</a>
						</div>
						<?php

					endwhile;endif;

					?>
				</div>

				<?php do_action('aesop_collection_inside_bottom'); // action ?>				

			</div>
		<?php

		do_action('aesop_collection_after'); //action

		return ob_get_clean();
	}
}
