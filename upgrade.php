<?php

		// admin notice for upgrading
	add_action( 'admin_notices', 					'upgrade_map_notice' );
	add_action( 'wp_ajax_aesop_upgrade_meta', 		'aesop_upgrade_meta' );
	add_action( 'admin_head',						'aesop_upgrade_js');
	/**
	*
	*	Map the old map post meta keys to the new map post meta keys to preserve backwards compatibility
	*	when the user updates to 1.3
	*
	*	@since 1.3
	*	@todo uncomment the version conditional before 1.3 goes live
	*/
	function upgrade_map_notice(){

		//if( get_option('ai_core_version') >= 1.3 ) {

			$out = '<div class="error"><p>';

			$out .= __( 'Welcome to Aesop Story Engine 1.3. We need to upgrade any map markers that you might have. Click <a id="aesop-upgrade-map-meta" href="#">here</a> to start the upgrade process.', 'aesop-core' );

			$out .= '</p></div>';

			echo $out;

		//}
	}

	/**
	*
	*	When the user starts the upgrade process let's run a function to map the old meta to the new meta
	*
	*	@since 1.3
	*	@todo map the new meta to the old meta
	*/
	function aesop_upgrade_meta(){

		// get the posts with the maps shortode
		$posts = get_posts(array ('s' => '[aesop_map','post_type' => array ( 'page', 'post' ) ));

		$count = 0;

		if ( $posts ) :
			foreach( $posts as $post ) {

				$id = $post->ID;

				// additional check really isnt necessary but doesn't hurt
				if ( has_shortcode($post->post_content,'aesop_gallery') ){

					// at this point we have an array of posts that have our shortcodes
					// now let's loop through the map meta in this post and map to the new meta
				}
			}
		endif;

		echo 'AJAX SUCCESS!';

		// die for ajax
		die();
	}

	/**
	*
	*	Handles the click function for upgrading the old map meta to the new map meta
	*
	*	@since 1.3
	*/
	function aesop_upgrade_js(){

		//if( get_option('ai_core_version') >= 1.3 ) { ?>
			<!-- Aesop Upgrade Map Meta -->
			<script>
				jQuery(document).ready(function(){
				  	jQuery('#aesop-upgrade-map-meta').click(function(e){

				  		e.preventDefault();

				  		var data = {
				            action: 'aesop_upgrade_meta'
				        };

					  	jQuery.post(ajaxurl, data, function(response) {
					        alert(response);
					    });

				    });
				});
			</script>
		<?php // }
	}