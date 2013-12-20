<?php

/**
 	* Creates an interactive timeline component that works similar to chapter headings
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_collection_shortcode')){

	function aesop_collection_shortcode($atts, $content = null) {

		$defaults = array(
			'type'		=> 'carousel',
			'collection' => 1
		);
		$atts = shortcode_atts($defaults, $atts);

		$hash = rand();
		ob_start();
		?>
			<script>
				jQuery(document).ready(function(){
					jQuery("#aesop-collection-<?php echo $hash;?>").owlCarousel();
				});
			</script>
			<section class="aesop-story-collection">

				<div id="aesop-collection-<?php echo $hash;?>" class="owl-carousel">
					<?php

					$args1 = array(
						'posts_per_page' => -1,
						'cat' => $atts['collection']
					);
					$q1 = new wp_query($args1);

					if($q1->have_posts()) : while($q1->have_posts()) : $q1->the_post();

						?><div><?php
							echo the_title();
						?></div><?php

					endwhile;endif;

					?>
				</div>

			</section>
		<?php
		return ob_get_clean();
	}
}
