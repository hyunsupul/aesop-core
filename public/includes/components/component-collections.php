<?php

/**
 	* Creates an interactive timeline component that works similar to chapter headings
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_collection_shortcode')){

	function aesop_collection_shortcode($atts, $content = null) {

		$defaults = array(
			'collection' 	=> 1,
			'title' 		=> '',
			'columns' 		=> 2,
			'limit'			=> -1,
			'splash'		=> ''
		);
		$atts = apply_filters('aesop_collection_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		ob_start();

		$col = $atts['columns'] ? preg_replace('/[^0-9]/','',$atts['columns']) : null;

		$splash_class = 'on' == $atts['splash'] ? 'aesop-collection-splash' : null;

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'collections', '' ) : null;

		do_action('aesop_collection_before'); // action

		?>
			<!-- Collections -->
			<div class="aesop-story-collection <?php echo $classes;?>">

				<?php do_action('aesop_collection_inside_top'); // action ?>

				<?php if($atts['title']){?>
					<h4 class="aesop-story-collection-title"><span><?php echo $atts['title'];?></span></h4>
				<?php } ?>

					<div id="aesop-collection-<?php echo $hash;?>" class="aesop-collection-grid clearfix aesop-collection-grid-<?php echo $col;?>col <?php echo $splash_class;?>">

						<?php

						// if collection ID is set
						if ($atts['collection']):

							// if splash mode is set
							if ('on' == $atts['splash']) {

								// cat query args
								$cat_args = array(
								  	'orderby' 	=> 'name',
								  	'order' 	=> 'ASC'
								);

								// get cached query
								$cats = wp_cache_get('aesop_splash_query');

								// if no cached query then cache the query
								if (false == $cats ) {
									$cats = get_categories(apply_filters('aesop_splash_query',$cat_args));
									wp_cache_set('aesop_splash_query', $cats);
								}

								if ($cats):

									foreach($cats as $cat) {

										?><div class="aesop-collection-item aesop-collection-category-<?php echo $cat->slug;?>">
											<a class="aesop-collection-item-link" href="<?php echo get_category_link($cat->term_id);?>">
												<div class="aesop-collection-item-inner">
													<h2 class="aesop-collection-entry-title" itemprop="title"><?php echo $cat->name;?></h2>
													<div class="aesop-collection-item-excerpt"><?php echo $cat->category_description;?></div>
												</div>
												<div class="aesop-collection-item-img"></div>
											</a>
										</div>
										<?php
									}

								endif;

							// else carry onto default mode
							} else {

								// query args
								$args = array(
									'posts_per_page' => $atts['limit'],
									'cat' 			=> $atts['collection'],
									'ignore_sticky' => true
								);

								// get cached query
								$query = wp_cache_get('aesop_collection_query');

								// if no cached query then cache the query
								if (false == $query ) {
									$query = new wp_query( apply_filters( 'aesop_collection_query', $args ) );
									wp_cache_set('aesop_collection_query', $query);
								}

								// loop through the stories
								if($query->have_posts()) : while($query->have_posts()) : $query->the_post();

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
								wp_reset_postdata();

							}

						// if collection ID isn't set warn them
						else:

							_e('Specify a category ID to display stories from.','aesop-core');

						endif;

						?>
					</div>
				<?php

				do_action('aesop_collection_inside_bottom'); // action ?>

			</div>
		<?php

		do_action('aesop_collection_after'); //action

		return ob_get_clean();
	}
}
