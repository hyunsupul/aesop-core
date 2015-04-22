<?php

if ( ! function_exists( 'aesop_map_shortcode' ) ) {
	function aesop_map_shortcode( $atts ) {

		$defaults = array(
			'height'  	=> 500,
			'sticky' 	=> 'off'
		);

		wp_enqueue_script( 'aesop-map-script', AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.js' );
		wp_enqueue_style( 'aesop-map-style', AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.css', AI_CORE_VERSION, true );

		$atts = apply_filters( 'aesop_map_defaults', shortcode_atts( $defaults, $atts ) );

		// sticky maps class
		$sticky = 'off' !== $atts['sticky'] ? sprintf( 'aesop-sticky-map-%s', esc_attr( $atts['sticky'] ) ) : null;

		// clean height
		$get_height = 'off' == $atts['sticky'] ? preg_replace( '/[^0-9]/', '', $atts['height'] ) : null;
		$height = $get_height ? sprintf( 'style="height:%spx;"', $get_height ) : null;

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'map', '' ) : null;

		// get markers - since 1.3
		$markers  = get_post_meta( get_the_ID(), 'ase_map_component_locations', false );

		// filterable map marker waypoint offset - since 1.3
		// 50% means when the id hits 50% from the top the waypoint will fire
		$marker_waypoint_offset = apply_filters( 'aesop_map_waypoint_offset', '50%' );

		$default_location  = is_single();
		$location    = apply_filters( 'aesop_map_component_appears', $default_location );

		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		ob_start();

		do_action( 'aesop_map_before', $atts, $unique );

		$url    = admin_url( 'post.php?post='.get_the_ID().'&action=edit' );
		$edit_map   = __( 'Add Map Markers', 'aesop-core' );
		$add_markers  = sprintf( '<a href="%s" target="_blank" title="%s">(%s)</a>', $url, $edit_map, $edit_map );

		if ( empty( $markers ) && is_user_logged_in() && current_user_can( 'edit_post', get_the_ID() ) && ! function_exists( 'lasso_editor_components' ) ) {

			?><div class="aesop-error aesop-content"><?php
			_e( 'Add some markers '.$add_markers.' to activate the map.', 'aesop-core' );
			?></div><?php

		} ?>

			<div id="aesop-map-component" <?php echo aesop_component_data_atts( 'map', $unique, $atts );?> class="aesop-component aesop-map-component <?php echo sanitize_html_class( $classes );?> " <?php echo $height;?>>

				<?php
		/**
		 *  if sticky and we have markers do scroll waypoints
		 *
		 * @since 1.3
		 */
		if ( 'off' !== $atts['sticky'] && $markers && $location ):

?>
					<!-- Aesop Sticky Maps -->
					<script>
						jQuery(document).ready(function(){

							jQuery('body').addClass('aesop-sticky-map <?php echo esc_attr( $sticky );?>');

							map.invalidateSize();

							<?php
		$i = 0;

		foreach ( $markers as $key => $marker ): $i++;

		$loc  = sprintf( '%s,%s', $marker['lat'], $marker['lng'] );

?>
								jQuery('#aesop-map-marker-<?php echo absint( $i );?>').waypoint({
									offset: '<?php echo esc_attr( $marker_waypoint_offset );?>',
									handler: function(direction){
										map.panTo(new L.LatLng(<?php echo esc_attr( $loc );?>));
									}
								});
								<?php

		endforeach;
?>
						});
					</script><?php

		endif;

		?></div><?php
		do_action( 'aesop_map_before', $atts, $unique );

		return ob_get_clean();
	}

}//end if

class AesopMapComponent {

	public function __construct() {
		add_action( 'wp_footer', array( $this, 'aesop_map_loader' ), 20 );

		// map marker shortcode
		add_shortcode( 'aesop_map_marker', array( $this, 'aesop_map_marker_sc' ) );

	}

	public function aesop_map_loader() {

		global $post;

		$id         = isset( $post ) ? $post->ID : null;

		$markers  = isset( $post ) ? get_post_meta( $id, 'ase_map_component_locations', false ) : false;
		$start   = isset( $post ) && self::get_map_meta( $id, 'ase_map_component_start' ) ? self::get_map_meta( $id, 'ase_map_component_start' ) : self::start_fallback( $markers );
		$zoom   = isset( $post ) && self::get_map_meta( $id, 'ase_map_component_zoom' ) ? self::get_map_meta( $id, 'ase_map_component_zoom' ) : 12;

		$default_location  = is_single();
		$location    = apply_filters( 'aesop_map_component_appears', $default_location );

		$tiles = isset( $post ) ? aesop_map_tile_provider( $post->ID ) : false;

		if ( function_exists( 'aesop_component_exists' ) && aesop_component_exists( 'map' ) && ( $location ) ) { ?>
			<!-- Aesop Locations -->
			<script>

				<?php

			if ( $markers ): ?>

					var map = L.map('aesop-map-component',{
						scrollWheelZoom: false,
						zoom: <?php echo wp_filter_nohtml_kses( round( $zoom ) );?>,
						center: [<?php echo $start;?>]
					});

					L.tileLayer('<?php echo $tiles;?>', {
						maxZoom: 20
					}).addTo(map);

					<?php
			foreach ( $markers as $marker ):

				$lat  = $marker['lat'];
			$long  = $marker['lng'];
			$text  = $marker['title'] ? $marker['title'] : null;

			$loc  = sprintf( '%s,%s', esc_attr( $lat ), esc_attr( $long ) );

			// if market content is set run a popup
			if ( $text ) { ?>

							L.marker([<?php echo $loc;?>]).addTo(map).bindPopup('<?php echo aesop_component_media_filter( $text );?>').openPopup();

						<?php } else { ?>

							L.marker([<?php echo $loc;?>]).addTo(map);

						<?php }

			endforeach;

			else :

				if ( is_user_logged_in() ) {
					$url   = admin_url( 'post.php?post='.$id.'&action=edit' );
					$editlink  = sprintf( '<a href="%s">here</a>', $url );

					?>jQuery('#aesop-map-component').append('<div class="aesop-error aesop-content"><?php echo __( "Your map appears to be empty! Setup and configure your map markers in this post {$editlink}.", 'aesop-core' );?></div>');<?php

				}

			endif;
?>
			</script>

		<?php }//end if
	}

	/**
	 * Retrieve meta settings for map component
	 *
	 * @param integer $post_id int
	 * @param unknown $key     string -meta key
	 * @return starting coordinate
	 * @since 1.1
	 */
	private function get_map_meta( $post_id = 0, $key = '' ) {

		// bail if no post id set or no key
		if ( empty( $post_id ) || empty( $key ) ) {
			return; }

		$meta = get_post_meta( $post_id, $key, true );

		return empty( $meta ) ? null : $meta;

	}

	/**
	 * If the user has not entered a starting view coordinate,
	 * then fallback to the first coordinate entered if present.
	 *
	 * @param unknown $markers - array - gps coordinates entered aspost meta within respective post
	 * @return null|string gps marker found
	 * @since 1.1
	 *
	 */
	private function start_fallback( $markers ) {

		// bail if no markers found
		if ( empty( $markers ) ) {
			return; }

		$i = 0;

		foreach ( $markers as $marker ) { $i++;

			$lat  = sanitize_text_field( $marker['lat'] );
			$long  = sanitize_text_field( $marker['lng'] );

			$mark  = sprintf( '%s,%s', $lat, $long );

			if ( $i == 1 ) {}
			break;

		}

		return !empty( $mark ) ? $mark : false;

	}

	/**
	 * Add a shortcode that lets users decide trigger points in map component
	 * Note: this is ONLY used when maps is in sticky mode, considered an internal but public function
	 *
	 *
	 */
	public function aesop_map_marker_sc( $atts ) {

		$defaults = array( 'title' => '', 'hidden' => '' );

		$atts = shortcode_atts( $defaults, $atts );

		// let this be used multiple times
		static $instance = 0;
		$instance++;

		$out = sprintf( '<h2 id="aesop-map-marker-%s" class="aesop-map-marker">%s</h2>', $instance, esc_html( $atts[ 'title'] ) );

		return apply_filters( 'aesop_map_marker_output', $out );
	}
}
new AesopMapComponent;
