<?php
/**
 	* Filters custom meta box class to add cusotm meta to map component
 	*
 	* @since    1.0.0
*/
class AesopMapComponentAdmin {

	public function __construct(){
		add_filter( 'cmb_meta_boxes', array($this,'aesop_map_meta') );

		// new maps
		add_action( 'add_meta_boxes', 					array($this,'new_map_box') );
		add_action('admin_enqueue_scripts', 		array($this,'new_map_assets') );
	}

	function aesop_map_meta( array $meta_boxes ) {

		$opts = array(
			array(
				'id'			=> 'aesop_map_start',
				'name'			=> __('Starting Coordinates', 'aesop-core'),
				'type'			=> 'text',
			),
			array(
				'id'			=> 'aesop_map_component_zoom',
				'name'			=> __('Default Zoom Level', 'aesop-core'),
				'type'			=> 'text',
				'desc'			=> __('The larger the number, the more zoomed in the default will be. Limit is 20. Default is 12.','aesop-core')
			),
			array(
				'id' 			=> 'aesop_map_component_locations',
				'name' 			=> __('Map Markers', 'aesop-core'),
				'type' 			=> 'group',
				'repeatable'     => true,
				'repeatable_max' => 20,
				'desc'			=> __('Assign latitude and longitude for each marker.', 'aesop-core'),
				'fields' 		=> array(
					array(
						'id' 	=> 'lat',
						'name' 	=> __('Latitude', 'aesop-core'),
						'type' 	=> 'text',
						'cols'	=> 6
					),
					array(
						'id' 	=> 'long',
						'name' 	=> __('Longitude', 'aesop-core'),
						'type' 	=> 'text',
						'cols'	=> 6
					),
					array(
						'id' 	=> 'content',
						'name' 	=> __('Marker Text', 'aesop-core'),
						'type' 	=> 'textarea',
						'cols'	=> 12
					)
				)
			),
		);

		$meta_boxes[] = array(
			'title' 	=> __('Map Component Locations', 'aesop-core'),
			'pages' 	=> apply_filters('aesop_map_meta_location','post'),
			'context' 	=> 'side',
			'fields' 	=> $opts
		);

		return $meta_boxes;

	}

	/**
	*
	*	Enqueue assets used for map but only on post pages
	*
	*	@since 1.3
	*/
	function new_map_assets($hook){

		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_enqueue_script('aesop-map-script',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.js');
			wp_enqueue_style('aesop-map-style',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.css', AI_CORE_VERSION, true);
		}
	}

	/**
	*
	*	New metabox to select map markers on the map
	*
	*	@since 1.3
	*/
	function new_map_box(){

		$screens = apply_filters('aesop_map_meta_location',array( 'post' ) );

		foreach ( $screens as $screen ) {
			add_meta_box('ase_map_component',__( 'Map Locations', 'aesop-core' ),array($this,'render_map_box'), $screen);

		}
	}

	/**
	* 	Render Meta Box content.
	*
	* 	@param WP_Post $post The post object.
	*	@since 1.3
	*/
	function render_map_box( $post ){

		wp_nonce_field( 'ase_map_meta', 'ase_map_meta_nonce' );

		$mapboxid 	= get_option('ase_mapbox_id','aesopinteractive.hkoag9o3');

		echo '<div id="aesop-map" style="height:350px;"></div>';

		?>
			<!-- Aesop Maps -->
			<script>

				var map = L.map('aesop-map',{
					scrollWheelZoom: false,
					zoom: 12,
					center: [29.76, -95.38]
				});

				L.tileLayer('//{s}.tiles.mapbox.com/v3/<?php echo $mapboxid;?>/{z}/{x}/{y}.png', {
					maxZoom: 20
				}).addTo(map);

			</script>
		<?php

	}
	/**
	*
	* 	Save the meta when the post is saved.
	*
	* 	@param int $post_id The ID of the post being saved.
	*	@since 1.3
	*/
	function save_map_box( $post_id ) {

		// if nonce not set bail
		if ( ! isset( $_POST['ase_map_meta_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ase_map_meta_nonce'];

		// if nonce not verified bail
		if ( ! wp_verify_nonce( $nonce, 'ase_map_meta' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// if user doesn't have permissions then bail
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		// ok to continue and save
		//update_post_meta.....

	}

}
new AesopMapComponentAdmin;