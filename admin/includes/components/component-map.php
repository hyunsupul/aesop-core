<?php
/**
 	* Filters custom meta box class to add cusotm meta to map component
 	*
 	* @since    1.0.0
*/
class AesopMapComponentAdmin {

	public function __construct(){

		// old meta
		// @todo - retire before 1.3 goes out
		add_filter( 'cmb_meta_boxes', array($this,'aesop_map_meta') );

		// new maps
		add_action( 'add_meta_boxes', 					array($this,'new_map_box') );
		add_action( 'admin_enqueue_scripts', 			array($this,'new_map_assets') );
		add_action( 'save_post',						array($this,'save_map_box') );

		// admin notice for upgrading
		add_action( 'admin_notices', 					array($this, 'upgrade_map_notice' ) );
		add_action( 'wp_ajax_upgrade_marker_meta', 		array($this, 'upgrade_marker_meta' ));
		add_action( 'admin_head',						array($this, 'upgrade_click_handle'));


	}

	/**
	*
	*	Create metabox to store coordinates for maps
	*	@since 1.0
	*	@todo map these to the new map meta keys and retire this beofre 1.3 goes out
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

			wp_enqueue_script('google-maps','//maps.googleapis.com/maps/api/js?libraries=places&sensor=false');
			wp_enqueue_script('aesop-map-script',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.js');
			wp_enqueue_script('jquery-geocomplete',AI_CORE_URL.'/admin/assets/js/vendor/jquery.geocomplete.min.js');
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

		echo '<div class="aesop-map-data" style="display: hidden;">';
		wp_nonce_field( 'ase_map_meta', 'ase_map_meta_nonce' );
		echo '</div>';

		$mapboxid 	= get_option('ase_mapbox_id','aesopinteractive.hkoag9o3');

		// this is just a example button as a trigger to get all the makers
		// maybe this should be tied into post_save or something?
		// check console after clicking

		echo "Starting location: <input type='text' id='aesop-map-address'/>";
		echo '<div id="aesop-map" style="height:350px;"></div>';

		$ase_map_locations = get_post_meta( $post->ID, 'ase_map_component_locations' );
		$ase_map_start_point = get_post_meta( $post->ID, 'ase_map_component_start_point', true );
		$ase_map_zoom = get_post_meta( $post->ID, 'ase_map_component_zoom', true);

		if ( empty ( $ase_map_start_point ) ) {
			$ase_map_start_point = [29.76, -95.38];
		} else {
			$ase_map_start_point = [$ase_map_start_point['lat'],$ase_map_start_point['lng']];
		}

		if ( empty ( $ase_map_zoom ) ) {
			$ase_map_zoom = 12;
		}

		$ase_map_start_point = json_encode($ase_map_start_point);
		$ase_map_locations = json_encode($ase_map_locations);

		?>
			<!-- Aesop Maps -->
			<script>

				jQuery(document).ready(function(){

					var start_point = <?php echo $ase_map_start_point; ?>;
					var start_zoom = <?php echo $ase_map_zoom; ?>;

					var map = L.map('aesop-map',{
						scrollWheelZoom: false,
						zoom: start_zoom,
						center: start_point
					});

					setMapCenter(start_point[0],start_point[1]);

					jQuery('#aesop-map-address').geocomplete().bind('geocode:result', function(event, result){
						var lat = result.geometry.location.k;
						var lng = result.geometry.location.B;
						map.panTo(new L.LatLng(lat,lng));
						setMapCenter(lat,lng);
  				});

					L.tileLayer('//{s}.tiles.mapbox.com/v3/<?php echo esc_attr($mapboxid);?>/{z}/{x}/{y}.png', {
						maxZoom: 20
					}).addTo(map);

					<?php if ( ! empty( $ase_map_locations )) : ?>
						var ase_map_locations = <?php echo $ase_map_locations; ?>
					<?php endif; ?>

					ase_map_locations.forEach(function(location) {
						createMapMarker([location['lat'],location['lng']],location['title']).addTo(map);
						createMarkerField( marker._leaflet_id, encodeMarkerData(location['lat'], location['lng'], location['title']) );
					});

					// adding a new marker
					map.on('click', onMapClick);
					map.on('dragend', onMapDrag);
					map.on('zoomend', onMapZoom);

					function setMapCenter(k, B) {
						var ldata = encodeLocationData(k,B);
						jQuery('input[name="ase-map-component-start-point"').remove();
						jQuery('.aesop-map-data').append('<input type="hidden" name="ase-map-component-start-point" data-ase="map" value="' + ldata + '">');
						jQuery('#aesop-map-address').val(k + ', ' + B);
					}

					function setMapZoom(z) {
						jQuery('input[name="ase-map-component-zoom"').remove();
						jQuery('.aesop-map-data').append('<input type="hidden" name="ase-map-component-zoom" data-ase="map" value="' + z + '">');
					}

					function onMarkerDrag(e) {
						updateMarkerField(e.target);
					}

					function onMapDrag(e) {
						var mapCenter = e.target.getCenter()
						setMapCenter(rnd(mapCenter.lat),rnd(mapCenter.lng));
					}

					function onMapZoom(e) {
						setMapZoom(e.target.getZoom());
					}

					function rnd(n) {
						return Math.round(n * 100) / 100
					}

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

					            }).bindPopup("\
					            	<input type='text' name='ase_marker_text[]' value='Location Title'>\
					            	<input type='button' value='Update' class='marker-update-button'/>\
					            	<input type='button' value='Delete' class='marker-delete-button'/>\
					            	");

					            marker.on('popupopen', onPopupOpen);
					            marker.on('dragend', onMarkerDrag);

					            return marker;
					        }
					    }).addTo(map);

					   	createMarkerField( marker._leaflet_id, encodeMarkerData(e.latlng.lat, e.latlng.lng, 'Location Title') );

					}

					// open popup
					function onPopupOpen() {

				    var tempMarker = this;

				    // To remove marker on click of delete button in the popup of marker
				    jQuery('.marker-delete-button:visible').click(function () {
				    	jQuery('input[data-marker="' + tempMarker._leaflet_id + '"]').remove();
				      map.removeLayer(tempMarker);
				    });

				    // Update the title of the location
				    jQuery('.marker-update-button:visible').click(function (t) {
				    	var title = t.target.previousElementSibling.value;
				    	var tdata = encodeMarkerData(tempMarker._latlng.lat, tempMarker._latlng.lng, title);
				    	jQuery('input[data-marker="' + tempMarker._leaflet_id + '"]').val(tdata);
				    	tempMarker.options.title = title;
				    	tempMarker.closePopup();
				    	tempMarker.bindPopup("\
					            	<input type='text' name='ase_marker_text[]' value='" + title + "'>\
					            	<input type='button' value='Update' class='marker-update-button'/>\
					            	<input type='button' value='Delete' class='marker-delete-button'/>\
					            	");
				    });
					}

					// create map marker
					function createMapMarker(latlng, title) {
            marker = L.marker(latlng, {
              title: title,
              alt: title,
              riseOnHover: true,
              draggable: true,
            }).bindPopup("\
            	<input type='text' name='ase_marker_text[]' value='" + title + "'>\
            	<input type='button' value='Update' class='marker-update-button'/>\
            	<input type='button' value='Delete' class='marker-delete-button'/>\
            	");
            marker.on('popupopen', onPopupOpen);
            marker.on('dragend', onMarkerDrag);
            return marker;
					}

					function getAllMarkers() {
				    var allMarkersObjArray = []; // for marker objects
				    var allMarkersGeoJsonArray = []; // for readable geoJson markers
				    jQuery.each(map._layers, function (ml) {
			        if (map._layers[ml].feature) {
			          allMarkersObjArray.push(this)
			          allMarkersGeoJsonArray.push(JSON.stringify(this.toGeoJSON()))
			        }
				    })
					}

					// let's create a hidden form element for the marker
					function createMarkerField(mid, mdata) {
					  jQuery('.aesop-map-data').append('<input type="hidden" name="ase-map-component-locations[]" data-ase="map" data-marker="' + mid + '" value="' + mdata + '">');
					}

					function updateMarkerField(m) {
						var tdata = encodeMarkerData(m._latlng.lat, m._latlng.lng, m.options.title);
						jQuery('input[data-marker="' + m._leaflet_id + '"]').val(tdata);
					}

					// encode the information into a string
					function encodeMarkerData(mlat, mlng, mtitle) {
						return encodeURIComponent(JSON.stringify({lat: mlat, lng: mlng, title: mtitle}));
					}

					// encode location into a string
					function encodeLocationData(mlat, mlng) {
						return encodeURIComponent(JSON.stringify({lat: mlat, lng: mlng}));
					}

					// decode the information
					function decodeMarkerData(mdata) {
						return decodeURIComponent(JSON.parse(mdata));
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

		delete_post_meta( $post_id, 'ase_map_component_locations' );
		delete_post_meta( $post_id, 'ase_map_component_start_point' );

		if ( isset( $_POST['ase-map-component-locations'] ) ) {
			foreach( $_POST['ase-map-component-locations'] as $location ){
				//var_dump($location);
				// let's decode and convert the data into an array
				$location_data = json_decode(urldecode($location), true);
				//var_dump($location_data);
				add_post_meta( $post_id, 'ase_map_component_locations', $location_data);	
			}
		}

		if ( isset( $_POST['ase-map-component-start-point'] ) ) {
			// let's decode and convert the data into an array
			$start_point = json_decode(urldecode($_POST['ase-map-component-start-point']), true);
			update_post_meta( $post_id, 'ase_map_component_start_point', $start_point);
		}

		if ( isset( $_POST['ase-map-component-zoom'] ) ) {
			// let's decode and convert the data into an array
			$zoom = json_decode(urldecode($_POST['ase-map-component-zoom']), true);
			update_post_meta( $post_id, 'ase_map_component_zoom', $zoom);
		}
	}

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

			update_option('ai_core_version', AI_CORE_VERSION );

			echo apply_filters('ai_activation_notification',$out);

		//}
	}

	/**
	*
	*	When the user starts the upgrade process let's run a function to map the old meta to the new meta
	*
	*	@since 1.3
	*	@todo this is returning 0 but not our succes message?
	*/
	function upgrade_marker_meta(){

		echo 'success';

		// die for ajax
		exit();
	}

	/**
	*
	*	Handles the click function for upgrading the old map meta to the new map meta
	*
	*	@since 1.3
	*/
	function upgrade_click_handle(){

		//if( get_option('ai_core_version') >= 1.3 ) { ?>
			<!-- Aesop Upgrade Map Meta -->
			<script>
				jQuery(document).ready(function(){
				  	jQuery('#aesop-upgrade-map-meta').click(function(e){

				  		e.preventDefault();

				  		var data = {
				            action: 'upgrade_marker_meta'
				        };

					  	jQuery.post(ajaxurl, data, function(response) {
					        alert(response);
					    });

				    });
				});
			</script>
		<?php // }
	}

}
new AesopMapComponentAdmin;