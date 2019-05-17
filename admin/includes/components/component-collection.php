<?php
/**
 * Filters custom meta box class to add cusotm meta to collection component
 *
 * @since    1.9.3
 */
class AesopCollectionComponentAdmin {

	public function __construct() {
		add_action( 'wp_ajax_aesop_get_more_posts',     array( $this, 'get_more_posts' ) );
		add_action( 'wp_ajax_nopriv_aesop_get_more_posts',     array( $this, 'get_more_posts' ) );
	}
	/**
	 * @since 1.9.3
	 */
	public function get_more_posts() {

		$cat= $_POST["cat"];
		$ppp = $_POST["posts_per_page"];
		$paged = $_POST["page"];
		$order = $_POST["order"];

		$args = array(
			'orderby' => array( 'date'  => $order ),
			'posts_per_page' => $ppp,
			'cat' => $cat,
			'ignore_sticky' => true,
			'post_status' => array('publish'),
			'paged' => $paged
		);

		$query = new wp_query( apply_filters( 'aesop_collection_query', $args ) );
		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

							$coverimg   = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

						?><div class="aesop-collection-item <?php if ($coverimg) {echo "aesop-has-image";} ?>">
													<?php do_action( 'aesop_collection_inside_item_top', $atts, $unique ); // action ?>
													<a class="aesop-fader aesop-collection-item-link" href="<?php the_permalink();?>">
														<div class="aesop-collection-item-inner">
															<h2 class="aesop-collection-entry-title" itemprop="title"><?php the_title();?></h2>
															<p class="aesop-collection-meta"><?php printf( __( 'Written by %s', 'aesop-core' ), apply_filters( 'aesop_collection_author', get_the_author(), get_the_ID() ) ); ?></p>
															<div class="aesop-collection-item-excerpt"><?php echo wp_trim_words( preg_replace( '/\[[^\]]+\]/', '', get_the_excerpt()), 16, '...' );?></div>
														</div>
														<div class="aesop-collection-item-img" style="background-image:url(<?php echo $coverimg[0];?>);background-repeat:no-repeat;background-size:cover;"></div>
													</a>
													<?php do_action( 'aesop_collection_inside_item_bottom', $atts, $unique ); // action ?>
												</div>
												<?php

						endwhile;endif;
		wp_reset_postdata();

		exit; 
	}

}
new AesopCollectionComponentAdmin;
