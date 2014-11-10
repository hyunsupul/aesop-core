<?php

if (!function_exists('aesop_map_shortcode')) {
	function aesop_map_shortcode($atts, $content = null) {

		$defaults = array(
			'height' 	=> 500,
			'sticky'	=> 'off'
		);

		wp_enqueue_script('aesop-map-script',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.js');
		wp_enqueue_style('aesop-map-style',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.css', AI_CORE_VERSION, true);

		$atts = apply_filters('aesop_map_defaults',shortcode_atts($defaults, $atts));

		// sticky maps
		$sticky = 'on' == $atts['sticky'] ? 'aesop-sticky-map' : null;

		//clean height
		$get_height = 'off' == $atts['sticky'] ? preg_replace('/[^0-9]/','',$atts['height']) : null;
		$height = $get_height ? sprintf('style="height:%s;"',$get_height) : null;

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'map', '' ) : null;

		// get markers - since 1.3
		$markers 	= get_post_meta( get_the_ID(), 'aesop_map_component_locations', false);

		// filterable map marker waypoint offset - since 1.3
		// 50% means when the id hits 50% from the top the waypoint will fire
		$marker_waypoint_offset = apply_filters('aesop_map_waypoint_offset', '50%');

		ob_start();

		// if sticky do scroll waypoints - since 1.3
		if ( 'on' == $atts['sticky'] ):

			?><script>
				jQuery(document).ready(function(){

					<?php if ( $markers ):

						$i = 0;

						foreach( $markers as $key => $marker ): $i++;

							$loc 	= sprintf('%s,%s',$marker['lat'],$marker['long']);

							?>
							jQuery('#aesop-map-marker-<?php echo $i;?>').waypoint({
								offset: '<?php echo esc_attr($marker_waypoint_offset);?>',
								handler: function(direction){
									map.panTo(new L.LatLng(<?php echo esc_attr($loc);?>));
								}
							});
							<?php

						endforeach;

					endif;?>
				});
			</script><?php

		endif;

		do_action('aesop_map_before');
			?><div id="aesop-map-component" class="aesop-component aesop-map-component <?php echo sanitize_html_class($classes);?> <?php sanitize_html_class($sticky);?>" <?php echo $height;?>></div><?php
		do_action('aesop_map_before');

		return ob_get_clean();
	}

}

class AesopMapComponent {

	function __construct(){
		add_action('wp_footer', array($this,'aesop_map_loader'),20);

		// add a body class if map is sticky
		add_filter('body_class',		array($this,'body_class'));
	}

	/**
	*
	*	Add a body class if map is in sticky mod
	*
	*	@param $classes array return array of classes
	*	@since 1.3
	*/
	function body_class($classes) {

	    $classes[] = 'aesop-sticky-map';

	    return $classes;

	}

	public function aesop_map_loader(){

		global $post;

		$id         = isset( $post ) ? $post->ID : null;

		$mapboxid 	= get_option('ase_mapbox_id','aesopinteractive.hkoag9o3');
		$markers 	= isset( $post ) ? get_post_meta( $id, 'aesop_map_component_locations', false) : false;
		$start 		= isset( $post ) && self::get_map_meta( $id, 'aesop_map_start') ? self::get_map_meta( $id, 'aesop_map_start' ) : self::start_fallback( $markers );
		$zoom 		= isset( $post ) && self::get_map_meta( $id, 'aesop_map_component_zoom') ? self::get_map_meta( $id, 'aesop_map_component_zoom' ) : 12;

		$default_location 	= is_single();
		$location 			= apply_filters( 'aesop_map_component_appears', $default_location );

		if ( function_exists('aesop_component_exists') && aesop_component_exists('map') && ( $location ) )  { ?>
			<!-- Aesop Locations -->
			<script>

				<?php

				if ( $markers ):

					if ( !self::get_map_meta($id,'aesop_map_start') && is_user_logged_in() ) { ?>

						jQuery('#aesop-map-component').before('<div class="aesop-error aesop-content"><?php echo __("Looks like you didn\'t specify a starting coordinate, so we\'re using the first one you entered.","aesop-core");?></div>');

					<?php } ?>

					var map = L.map('aesop-map-component',{
						scrollWheelZoom: false,
						zoom: <?php echo wp_filter_nohtml_kses( round( $zoom ) );?>,
						center: [<?php echo $start;?>]
					});

					L.tileLayer('//{s}.tiles.mapbox.com/v3/<?php echo $mapboxid;?>/{z}/{x}/{y}.png', {
						maxZoom: 20
					}).addTo(map);

					<?php
					foreach( $markers as $marker ):

						$lat 	= sanitize_text_field($marker['lat']);
						$long 	= sanitize_text_field($marker['long']);
						$text 	= $marker['content'] ? $marker['content'] : null;

						$loc 	= sprintf('%s,%s',$lat,$long);

						// if market content is set run a popup
						if ( $text ) { ?>

							L.marker([<?php echo $loc;?>]).addTo(map).bindPopup("<?php echo $text;?>").openPopup();

						<?php } else { ?>

							L.marker([<?php echo $loc;?>]).addTo(map);

						<?php }

					endforeach;

				else:

					if ( is_user_logged_in() ) {
						$url 		= admin_url( 'post.php?post='.$id.'&action=edit' );
						$editlink 	= sprintf('<a href="%s">here</a>',$url );

						?>jQuery('#aesop-map-component').append('<div class="aesop-error aesop-content"><?php echo __("Your map appears to be empty! Setup and configure your map markers in this post {$editlink}.","aesop-core");?></div>');<?php

					}

				endif;
				?>
			</script>

		<?php }
	}

	/**
	*
	*	Retrieve meta settings for map component
	*
	*	@param $post_id int
	*   @param $key string -meta key
	* 	@return starting coordinate
	* 	@since 1.1
	*/
	private function get_map_meta($post_id = 0, $key = ''){

		// bail if no post id set or no key
		if ( empty( $post_id ) || empty( $key ) )
			return;

  		$meta = get_post_meta( $post_id, $key, true );

  		return empty( $meta ) ? null : $meta;

	}

	/**
	*
	*	If the user has not entered a starting view coordinate,
	*	then fallback to the first coordinate entered if present.
	*
	*	@param $markers - array - gps coordinates entered aspost meta within respective post
	*	@return first gps marker found
	* 	@since 1.1
	*
	*/
	private function start_fallback( $markers ) {

		// bail if no markers found
		if( empty( $markers ) )
			return;

		$i = 0;

		foreach ( $markers as $marker ) { $i++;

			$lat 	= sanitize_text_field($marker['lat']);
			$long 	= sanitize_text_field($marker['long']);

			$mark 	= sprintf('%s,%s',$lat,$long);

			if ( $i == 1 );
				break;

		}

		return $mark;

	}

}
new AesopMapComponent;
