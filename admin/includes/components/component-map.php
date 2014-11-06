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

	/**
	*
	*	Create metabox to store coordinates for maps
	*	@since 1.0
	*/
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
	*
	* 	@todo - save map markers, currently a button just to retrieve, shoudl run on post_save ?
	* 	@todo - retrieve any markers previously saved and add them to the map for backwards compatibility
	*	@todo - we need a way for the user to enter text in the popup called "Marker Text"
	*/
	function render_map_box( $post ){

		wp_nonce_field( 'ase_map_meta', 'ase_map_meta_nonce' );

		$mapboxid 	= get_option('ase_mapbox_id','aesopinteractive.hkoag9o3');

		// this is just a example button as a trigger to get all the makers
		// maybe this should be tied into post_save or something?
		// check console after clicking
		echo '<a class="get-markers">click me</a>';

		echo '<div id="aesop-map" style="height:350px;"></div>';

		?>
			<!-- Aesop Maps -->
			<script>

				jQuery(document).ready(function(){

					var map = L.map('aesop-map',{
						scrollWheelZoom: false,
						zoom: 12,
						center: [29.76, -95.38]
					});

					L.tileLayer('//{s}.tiles.mapbox.com/v3/<?php echo esc_attr($mapboxid);?>/{z}/{x}/{y}.png', {
						maxZoom: 20
					}).addTo(map);

					// adding a new marker
					map.on('click', onMapClick);

					function onMapClick(e) {

					    var geojsonFeature = {

					        "type": "Feature",
					        "properties": {},
					        "geometry": {
					                "type": "Point",
					                "coordinates": [e.latlng.lat, e.latlng.lng]
					        }
					    }

					    var marker;

					    L.geoJson(geojsonFeature, {

					        pointToLayer: function(feature, latlng){

					            marker = L.marker(e.latlng, {

					                title: 'Resource Location',
					                alt: 'Resource Location',
					                riseOnHover: true,
					                draggable: true,

					            }).bindPopup("<input type='button' value='Delete this marker' class='marker-delete-button'/>");

					            marker.on('popupopen', onPopupOpen);

					            return marker;
					        }
					    }).addTo(map);
					}

					// open popup
					function onPopupOpen() {

					    var tempMarker = this;

					    // To remove marker on click of delete button in the popup of marker
					    jQuery('.marker-delete-button:visible').click(function () {
					        map.removeLayer(tempMarker);
					    });
					}

					// get all the makers on teh map
					function getAllMarkers() {

					    var allMarkersObjArray = []; // for marker objects
					    var allMarkersGeoJsonArray = []; // for readable geoJson markers

					    jQuery.each(map._layers, function (ml) {

					        if (map._layers[ml].feature) {

					            allMarkersObjArray.push(this)
					            allMarkersGeoJsonArray.push(JSON.stringify(this.toGeoJSON()))
					        }
					    })

					    console.log(allMarkersObjArray);
					}

					jQuery('.get-markers').on('click', getAllMarkers);
				});
			</script>
		<?php

	}
	/**
	*
	* 	Save the meta when the post is saved.
	*
	* 	@param int $post_id The ID of the post being saved.
	*	@since 1.3
	*
	*	@todo data needs to be saved
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