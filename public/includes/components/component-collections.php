<?php

/**
 * Creates an interactive timeline component that works similar to chapter headings
 *
 * @since    1.0.0
 */
<<<<<<< HEAD
if ( ! function_exists( 'aesop_collection_shortcode' ) ){
=======
if ( ! function_exists( 'aesop_collection_shortcode' ) ) {
>>>>>>> release/1.5.1

	function aesop_collection_shortcode( $atts ) {

		$defaults = array(
			'collection'    => 1,
			'title'   		=> '',
			'columns'   	=> 2,
			'limit'   		=> -1,
			'splash'  		=> ''
		);
<<<<<<< HEAD
		$atts = apply_filters( 'aesop_collection_defaults',shortcode_atts( $defaults, $atts ) );
=======
		$atts = apply_filters( 'aesop_collection_defaults', shortcode_atts( $defaults, $atts ) );
>>>>>>> release/1.5.1

		// let this be used multiple times
		static $instance = 0;
		$instance++;
<<<<<<< HEAD
		$unique = sprintf( '%s-%s',get_the_ID(), $instance );

		ob_start();

		$col = $atts['columns'] ? preg_replace( '/[^0-9]/','',$atts['columns'] ) : null;
=======
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		ob_start();

		$col = $atts['columns'] ? preg_replace( '/[^0-9]/', '', $atts['columns'] ) : null;
>>>>>>> release/1.5.1

		$splash_class = 'on' == $atts['splash'] ? 'aesop-collection-splash' : null;

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'collections', '' ) : null;

		do_action( 'aesop_collection_before' ); // action

?>
			<!-- Collections -->
			<div <?php echo aesop_component_data_atts( 'collection', $unique, $atts );?> class="aesop-story-collection aesop-component <?php echo sanitize_html_class( $classes );?>">

				<?php do_action( 'aesop_collection_inside_top' ); // action ?>

<<<<<<< HEAD
				<?php if ( $atts['title'] ){?>
=======
				<?php if ( $atts['title'] ) {?>
>>>>>>> release/1.5.1
					<h4 class="aesop-story-collection-title"><span><?php echo esc_html( $atts['title'] );?></span></h4>
				<?php } ?>

					<div id="aesop-collection-<?php echo $unique;?>" class="aesop-collection-grid clearfix aesop-collection-grid-<?php echo absint( $col );?>col <?php echo sanitize_html_class( $splash_class );?>">

						<?php

		// if collection ID is set
		if ( $atts['collection'] ):

			// if splash mode is set
			if ( 'on' == $atts['splash'] ) {

				// cat query args
				$cat_args = array(
					'orderby'  	=> 'name',
					'order'  	=> 'ASC'
				);

<<<<<<< HEAD
								// get cached query
								$cats = wp_cache_get( 'aesop_splash_query_'.$atts['collection'] );

								// if no cached query then cache the query
								if ( false == $cats ) {
									$cats = get_categories( apply_filters( 'aesop_splash_query',$cat_args ) );
									wp_cache_set( 'aesop_splash_query_'.$atts['collection'], $cats );
								}
=======
				// get cached query
				$cats = wp_cache_get( 'aesop_splash_query_'.$atts['collection'] );

				// if no cached query then cache the query
				if ( false == $cats ) {
					$cats = get_categories( apply_filters( 'aesop_splash_query', $cat_args ) );
					wp_cache_set( 'aesop_splash_query_'.$atts['collection'], $cats );
				}
>>>>>>> release/1.5.1

				if ( $cats ):

					foreach ( $cats as $cat ) {

<<<<<<< HEAD
										?><div class="aesop-collection-item aesop-collection-category-<?php echo $cat->slug;?>">
=======
						?><div class="aesop-collection-item aesop-collection-category-<?php echo $cat->slug;?>">
>>>>>>> release/1.5.1
											<?php do_action( 'aesop_collection_inside_category_item_top' ); // action ?>
											<a class="aesop-collection-item-link" href="<?php echo get_category_link( $cat->term_id );?>">
												<div class="aesop-collection-item-inner">
													<h2 class="aesop-collection-entry-title" itemprop="title"><?php echo $cat->name;?></h2>
													<div class="aesop-collection-item-excerpt"><?php echo $cat->category_description;?></div>
												</div>
												<div class="aesop-collection-item-img"></div>
											</a>
											<?php do_action( 'aesop_collection_inside_category_item_bottom' ); // action ?>
										</div>
										<?php
					}

				endif;

<<<<<<< HEAD
								// else carry onto default mode
							} else {
=======
				// else carry onto default mode
			} else {
>>>>>>> release/1.5.1

			// query args
			$args = array(
				'posts_per_page' => $atts['limit'],
				'cat'    => $atts['collection'],
				'ignore_sticky' => true
			);

<<<<<<< HEAD
								// get cached query
								$query = wp_cache_get( 'aesop_collection_query_' . $atts['collection'] );

								// if no cached query then cache the query
								if ( false == $query ) {
									$query = new wp_query( apply_filters( 'aesop_collection_query', $args ) );
									wp_cache_set( 'aesop_collection_query_' . $atts['collection'] , $query );
								}
=======
			// get cached query
			$query = wp_cache_get( 'aesop_collection_query_' . $atts['collection'] );

			// if no cached query then cache the query
			if ( false == $query ) {
				$query = new wp_query( apply_filters( 'aesop_collection_query', $args ) );
				wp_cache_set( 'aesop_collection_query_' . $atts['collection'] , $query );
			}
>>>>>>> release/1.5.1

			// loop through the stories
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

<<<<<<< HEAD
										$coverimg 		= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

									?><div class="aesop-collection-item">
=======
				$coverimg   = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

			?><div class="aesop-collection-item">
>>>>>>> release/1.5.1
										<?php do_action( 'aesop_collection_inside_item_top' ); // action ?>
										<a class="aesop-fader aesop-collection-item-link" href="<?php the_permalink();?>">
											<div class="aesop-collection-item-inner">
												<h2 class="aesop-collection-entry-title" itemprop="title"><?php the_title();?></h2>
												<p class="aesop-collection-meta">Written by <?php echo get_the_author();?></p>
<<<<<<< HEAD
												<div class="aesop-collection-item-excerpt"><?php echo wp_trim_words( get_the_excerpt(),22,'...' );?></div>
=======
												<div class="aesop-collection-item-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 22, '...' );?></div>
>>>>>>> release/1.5.1
											</div>
											<div class="aesop-collection-item-img" style="background-image:url(<?php echo $coverimg[0];?>);background-repeat:no-repeat;background-size:cover;"></div>
										</a>
										<?php do_action( 'aesop_collection_inside_item_bottom' ); // action ?>
									</div>
									<?php

			endwhile;endif;
			wp_reset_postdata();

<<<<<<< HEAD
							}//end if

							// if collection ID isn't set warn them
							else :

								?><div class="aesop-error aesop-content"><?php
							_e( 'Specify a category ID to display stories from.','aesop-core' );
							?></div><?php
=======
		}//end if

		// if collection ID isn't set warn them
		else :

			?><div class="aesop-error aesop-content"><?php
			_e( 'Specify a category ID to display stories from.', 'aesop-core' );
		?></div><?php
>>>>>>> release/1.5.1

		endif;

?>
					</div>
				<?php

<<<<<<< HEAD
				do_action( 'aesop_collection_inside_bottom' ); // action ?>
=======
		do_action( 'aesop_collection_inside_bottom' ); // action ?>
>>>>>>> release/1.5.1

			</div>
		<?php

		do_action( 'aesop_collection_after' ); // action

		return ob_get_clean();
	}
<<<<<<< HEAD
}//end if
=======
}//end if
>>>>>>> release/1.5.1
