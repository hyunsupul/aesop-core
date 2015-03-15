<?php

if ( ! function_exists( 'aesop_map_shortcode' ) ) {
<<<<<<< HEAD
	function aesop_map_shortcode($atts, $content = null) {
=======
	function aesop_map_shortcode( $atts ) {
>>>>>>> release/1.5.1

		$defaults = array(
			'height'  	=> 500,
			'sticky' 	=> 'off'
		);

<<<<<<< HEAD
		wp_enqueue_script( 'aesop-map-script',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.js' );
		wp_enqueue_style( 'aesop-map-style',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.css', AI_CORE_VERSION, true );

		$atts = apply_filters( 'aesop_map_defaults',shortcode_atts( $defaults, $atts ) );
=======
		wp_enqueue_script( 'aesop-map-script', AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.js' );
		wp_enqueue_style( 'aesop-map-style', AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.css', AI_CORE_VERSION, true );

		$atts = apply_filters( 'aesop_map_defaults', shortcode_atts( $defaults, $atts ) );
>>>>>>> release/1.5.1

		// sticky maps class
		$sticky = 'off' !== $atts['sticky'] ? sprintf( 'aesop-sticky-map-%s', esc_attr( $atts['sticky'] ) ) : null;

		// clean height
<<<<<<< HEAD
		$get_height = 'off' == $atts['sticky'] ? preg_replace( '/[^0-9]/','',$atts['height'] ) : null;
		$height = $get_height ? sprintf( 'style="height:%spx;"',$get_height ) : null;
=======
		$get_height = 'off' == $atts['sticky'] ? preg_replace( '/[^0-9]/', '', $atts['height'] ) : null;
		$height = $get_height ? sprintf( 'style="height:%spx;"', $get_height ) : null;
>>>>>>> release/1.5.1

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'map', '' ) : null;

		// get markers - since 1.3
<<<<<<< HEAD
		$markers 	= get_post_meta( get_the_ID(), 'ase_map_component_locations', false );
=======
		$markers  = get_post_meta( get_the_ID(), 'ase_map_component_locations', false );
>>>>>>> release/1.5.1

		// filterable map marker waypoint offset - since 1.3
		// 50% means when the id hits 50% from the top the waypoint will fire
		$marker_waypoint_offset = apply_filters( 'aesop_map_waypoint_offset', '50%' );

		$default_location  = is_single();
		$location    = apply_filters( 'aesop_map_component_appears', $default_location );

		static $instance = 0;
		$instance++;
<<<<<<< HEAD
		$unique = sprintf( '%s-%s',get_the_ID(), $instance );
=======
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );
>>>>>>> release/1.5.1

		ob_start();

		do_action( 'aesop_map_before' );

<<<<<<< HEAD
			$url 			= admin_url( 'post.php?post='.get_the_ID().'&action=edit' );
			$edit_map 		= __( 'Add Map Markers', 'aesop-core' );
			$add_markers 	= sprintf( '<a href="%s" target="_blank" title="%s">(%s)</a>',$url, $edit_map, $edit_map );
=======
		$url    = admin_url( 'post.php?post='.get_the_ID().'&action=edit' );
		$edit_map   = __( 'Add Map Markers', 'aesop-core' );
		$add_markers  = sprintf( '<a href="%s" target="_blank" title="%s">(%s)</a>', $url, $edit_map, $edit_map );
>>>>>>> release/1.5.1

		if ( empty( $markers ) && is_user_logged_in() && current_user_can( 'edit_posts' ) && ! class_exists( 'Lasso' ) ) {

			?><div class="aesop-error aesop-content"><?php
<<<<<<< HEAD
				_e( 'Add some markers '.$add_markers.' to activate the map.', 'aesop-core' );
=======
			_e( 'Add some markers '.$add_markers.' to activate the map.', 'aesop-core' );
>>>>>>> release/1.5.1
			?></div><?php

		} ?>

			<div id="aesop-map-component" <?php echo aesop_component_data_atts( 'map', $unique, $atts );?> class="aesop-component aesop-map-component <?php echo sanitize_html_class( $classes );?> " <?php echo $height;?>>

				<?php
<<<<<<< HEAD
				/**
				 *
				 * 	if sticky and we have markers do scroll waypoints
				 *
				 * @since 1.3
				 */
				if ( 'off' !== $atts['sticky'] && $markers && $location ):

					?>
=======
		/**
		 *  if sticky and we have markers do scroll waypoints
		 *
		 * @since 1.3
		 */
		if ( 'off' !== $atts['sticky'] && $markers && $location ):

?>
>>>>>>> release/1.5.1
					<!-- Aesop Sticky Maps -->
					<script>
						jQuery(document).ready(function(){

							jQuery('body').addClass('aesop-sticky-map <?php echo esc_attr( $sticky );?>');

							map.invalidateSize();

							<?php
		$i = 0;

<<<<<<< HEAD
							foreach ( $markers as $key => $marker ): $i++;

								$loc 	= sprintf( '%s,%s',$marker['lat'],$marker['lng'] );

								?>
=======
		foreach ( $markers as $key => $marker ): $i++;

		$loc  = sprintf( '%s,%s', $marker['lat'], $marker['lng'] );

?>
>>>>>>> release/1.5.1
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

<<<<<<< HEAD
				?></div><?php
=======
		?></div><?php
>>>>>>> release/1.5.1
		do_action( 'aesop_map_before' );

		return ob_get_clean();
	}

}//end if

class AesopMapComponent {

<<<<<<< HEAD
	function __construct(){
		add_action( 'wp_footer', array($this,'aesop_map_loader'),20 );

		// map marker shortcode
		add_shortcode( 'aesop_map_marker', array($this,'aesop_map_marker_sc') );
=======
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'aesop_map_loader' ), 20 );

		// map marker shortcode
		add_shortcode( 'aesop_map_marker', array( $this, 'aesop_map_marker_sc' ) );
>>>>>>> release/1.5.1

	}

	public function aesop_map_loader() {

		global $post;

		$id         = isset( $post ) ? $post->ID : null;

<<<<<<< HEAD
		$markers 	= isset( $post ) ? get_post_meta( $id, 'ase_map_component_locations', false ) : false;
		$start 		= isset( $post ) && self::get_map_meta( $id, 'ase_map_component_start' ) ? self::get_map_meta( $id, 'ase_map_component_start' ) : self::start_fallback( $markers );
		$zoom 		= isset( $post ) && self::get_map_meta( $id, 'ase_map_component_zoom' ) ? self::get_map_meta( $id, 'ase_map_component_zoom' ) : 12;
=======
		$markers  = isset( $post ) ? get_post_meta( $id, 'ase_map_component_locations', false ) : false;
		$start   = isset( $post ) && self::get_map_meta( $id, 'ase_map_component_start' ) ? self::get_map_meta( $id, 'ase_map_component_start' ) : self::start_fallback( $markers );
		$zoom   = isset( $post ) && self::get_map_meta( $id, 'ase_map_component_zoom' ) ? self::get_map_meta( $id, 'ase_map_component_zoom' ) : 12;
>>>>>>> release/1.5.1

		$default_location  = is_single();
		$location    = apply_filters( 'aesop_map_component_appears', $default_location );

		$tiles = isset( $post ) ? aesop_map_tile_provider( $post->ID ) : false;

<<<<<<< HEAD
		if ( function_exists( 'aesop_component_exists' ) && aesop_component_exists( 'map' ) && ( $location ) )  { ?>
=======
		if ( function_exists( 'aesop_component_exists' ) && aesop_component_exists( 'map' ) && ( $location ) ) { ?>
>>>>>>> release/1.5.1
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
<<<<<<< HEAD
					foreach ( $markers as $marker ):
=======
			foreach ( $markers as $marker ):
>>>>>>> release/1.5.1

				$lat  = $marker['lat'];
			$long  = $marker['lng'];
			$text  = $marker['title'] ? $marker['title'] : null;

<<<<<<< HEAD
						$loc 	= sprintf( '%s,%s',esc_attr( $lat ),esc_attr( $long ) );
=======
			$loc  = sprintf( '%s,%s', esc_attr( $lat ), esc_attr( $long ) );
>>>>>>> release/1.5.1

			// if market content is set run a popup
			if ( $text ) { ?>

							L.marker([<?php echo $loc;?>]).addTo(map).bindPopup('<?php echo aesop_component_media_filter( $text );?>').openPopup();

						<?php } else { ?>

							L.marker([<?php echo $loc;?>]).addTo(map);

						<?php }

			endforeach;

<<<<<<< HEAD
				else :

					if ( is_user_logged_in() ) {
						$url 		= admin_url( 'post.php?post='.$id.'&action=edit' );
						$editlink 	= sprintf( '<a href="%s">here</a>',$url );

						?>jQuery('#aesop-map-component').append('<div class="aesop-error aesop-content"><?php echo __( "Your map appears to be empty! Setup and configure your map markers in this post {$editlink}.",'aesop-core' );?></div>');<?php
=======
			else :

				if ( is_user_logged_in() ) {
					$url   = admin_url( 'post.php?post='.$id.'&action=edit' );
					$editlink  = sprintf( '<a href="%s">here</a>', $url );

					?>jQuery('#aesop-map-component').append('<div class="aesop-error aesop-content"><?php echo __( "Your map appears to be empty! Setup and configure your map markers in this post {$editlink}.", 'aesop-core' );?></div>');<?php
>>>>>>> release/1.5.1

				}

			endif;
?>
			</script>

		<?php }//end if
	}

	/**
<<<<<<< HEAD
	 *
	 *	Retrieve meta settings for map component
	 *
	 * @param $post_id int
	 * @param $key string -meta key
	 * @return starting coordinate
	 * @since 1.1
	 */
	private function get_map_meta($post_id = 0, $key = ''){
=======
	 * Retrieve meta settings for map component
	 *
	 * @param integer $post_id int
	 * @param unknown $key     string -meta key
	 * @return starting coordinate
	 * @since 1.1
	 */
	private function get_map_meta( $post_id = 0, $key = '' ) {
>>>>>>> release/1.5.1

		// bail if no post id set or no key
		if ( empty( $post_id ) || empty( $key ) ) {
			return; }

<<<<<<< HEAD
			$meta = get_post_meta( $post_id, $key, true );

			return empty( $meta ) ? null : $meta;
=======
		$meta = get_post_meta( $post_id, $key, true );

		return empty( $meta ) ? null : $meta;
>>>>>>> release/1.5.1

	}

	/**
<<<<<<< HEAD
	 *
	 *	If the user has not entered a starting view coordinate,
	 *	then fallback to the first coordinate entered if present.
	 *
	 * @param $markers - array - gps coordinates entered aspost meta within respective post
	 * @return first gps marker found
=======
	 * If the user has not entered a starting view coordinate,
	 * then fallback to the first coordinate entered if present.
	 *
	 * @param unknown $markers - array - gps coordinates entered aspost meta within respective post
	 * @return null|string gps marker found
>>>>>>> release/1.5.1
	 * @since 1.1
	 *
	 */
	private function start_fallback( $markers ) {

		// bail if no markers found
		if ( empty( $markers ) ) {
			return; }

		$i = 0;

		foreach ( $markers as $marker ) { $i++;

<<<<<<< HEAD
			$lat 	= sanitize_text_field( $marker['lat'] );
			$long 	= sanitize_text_field( $marker['lng'] );

			$mark 	= sprintf( '%s,%s',$lat,$long );

			if ( $i == 1 ) {}
				break;
=======
			$lat  = sanitize_text_field( $marker['lat'] );
			$long  = sanitize_text_field( $marker['lng'] );

			$mark  = sprintf( '%s,%s', $lat, $long );

			if ( $i == 1 ) {}
			break;
>>>>>>> release/1.5.1

		}

		return !empty( $mark ) ? $mark : false;

	}

	/**
<<<<<<< HEAD
	 *
	 *	Add a shortcode that lets users decide trigger points in map component
	 *	Note: this is ONLY used when maps is in sticky mode, considered an internal but public function
	 *
	 *
	 */
	function aesop_map_marker_sc($atts, $content = null) {
=======
	 * Add a shortcode that lets users decide trigger points in map component
	 * Note: this is ONLY used when maps is in sticky mode, considered an internal but public function
	 *
	 *
	 */
	public function aesop_map_marker_sc( $atts ) {
>>>>>>> release/1.5.1

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
