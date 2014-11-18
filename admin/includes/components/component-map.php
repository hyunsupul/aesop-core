<?php
/**
 	* Filters custom meta box class to add cusotm meta to map component
 	*
 	* @since    1.0.0
*/
class AesopMapComponentAdmin {

	public function __construct(){

		// new maps
		add_action( 'add_meta_boxes', 					array($this,'new_map_box') );
		add_action( 'admin_enqueue_scripts', 			array($this,'new_map_assets') );
		add_action( 'save_post',						array($this,'save_map_box') );

		// admin notice for upgrading
		add_action( 'admin_notices', 					array($this, 'upgrade_map_notice' ) );
		add_action( 'wp_ajax_upgrade_marker_meta', 		array($this, 'upgrade_marker_meta' ));
		add_action( 'admin_head',						array($this, 'upgrade_click_handle'));

		add_filter( 'aesop_avail_components',			array($this, 'options'));
		add_action( 'aesop_admin_styles', 				array($this, 'icon'));
		add_filter('cmb_meta_boxes', 							array($this,'aesop_map_tiles' ));

	}

/**
	 	* Adds custom gallery meta
	 	*
	 	* @since    1.0.0
	*/
	function aesop_map_tiles( array $meta_boxes ) {

		$meta_boxes[] = array(
			'title' 	=> __('Map Tiles', 'aesop-core'),
			'pages' 	=> 'post',
			'fields' 	=> array(
				array(
					'id'             => 'aesop_map_tiles',	
					'type'           => 'select',
					'desc'			=> __('Select from multiple map tiles -- the backdrop to your map. Free providers are below. <a href="http://mapbox.com/" target="_blank">Mapbox</a> offers a limited number of free tiles and awesome custom maps.','aesop-core'),
					'cols'			=> 12,
					'default'		=> 'mapbox',
					'options' => array(
        				'mapbox' => 'Mapbox',
        				'hydda' => 'Hydda',
        				'mq-sat' => 'MapQuest Satellite',
        				'mq-sat-c' => 'MapQuest Satellite Clean',
        				'acetate' => 'Acetate',
        				'stamen-tonerlite' => 'Stamen Grayscale',
        				'stamen-toner' => 'Stamen High Contrast',
        				'stamen-w' => 'Stamen Watercolor',
        				'stamen-w-c' => 'Stamen Watercolor Clean',
        				'openc' => 'OpenCycleMap',
        				'greenglobe' => 'GreenGlobe'
    				)
				)
			)
		);
		
		return $meta_boxes;

	}

	/**
	*
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
	*	Create the options for the shortcode that gets created when stickky maps is activated
	*	This lets the user use the user interface to add teh specific points in the story that the map should jump markers
	*
	*	@since 1.3
	*	@subpackage Component API
	*	@param $shortcodes array array of shortcodes to return
	*	@return return our own options merged into the aesop availabel optoins array
	*/
	function options($shortcodes) {

		$custom = array(
			'map_marker' 				=> array(
				'name' 					=> __('Aesop Map Marker', 'aesop-core'), // name of the component
				'type' 					=> 'single', // single - wrap
				'atts' 					=> array(
					'title' 			=> array(
						'type'			=> 'text', // a small text field
						'default' 		=> '',
						'desc' 			=> __('Title', 'aesop-core'),
						'tip'			=> __('By default we\'ll display an H2 heading with the text you specify here.','aesop-core')
					),
					'hidden' 				=> array(
						'type'			=> 'select', // a select dropdown 
						'values' 		=> array(
							array(
								'value' => 'off',
								'name'	=> __('Off','aesop-core')
							),
							array(
								'value' => 'on',
								'name'	=> __('On','aesop-core')
							)
						),
						'default' 		=> '',
						'desc' 			=> __('Hide this marker', 'aesop-core'),
						'tip'			=> __('Optionally hide this marker but retain the scroll to point in the map.','aesop-core')
					)
				)
			)
		);
		
		return array_merge( $shortcodes, $custom );

	}

	/**
	*
	*	Add an icon to our placeholder
	*	@subpackage Component API
	*	@since 1.3
	*/
	function icon(){

		$icon = '\f230'; //css code for dashicon
		$slug = 'map_marker'; // name of component

		wp_add_inline_style('ai-core-styles', '#aesop-generator-wrap li.'.$slug.' {display:none;} #aesop-generator-wrap li.'.$slug.' a:before {content: "'.$icon.'";}');

	}

	/**
	*
	*
	*	New metabox to select map markers on the map
	*
	*	@since 1.3
	*/
	function new_map_box(){

		$screens = apply_filters('aesop_map_meta_location', array( 'post' ) );

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
	*/
	function render_map_box( $post ){

		echo '<div class="aesop-map-data" style="display: hidden;">';
			wp_nonce_field( 'ase_map_meta', 'ase_map_meta_nonce' );
		echo '</div>';

		$mapboxid 	= get_option('ase_mapbox_id','aesopinteractive.hkoag9o3');

		echo "Starting location: <input type='text' id='aesop-map-address'/>";
		echo __('<em>Hint: Type to search for locations</em>','aesop-core');
		echo '<div id="aesop-map" style="height:350px;"></div>';

		$ase_map_locations 		= get_post_meta( $post->ID, 'ase_map_component_locations' );
		$ase_map_start_point 	= get_post_meta( $post->ID, 'ase_map_component_start_point', true );
		$get_map_zoom 			= get_post_meta( $post->ID, 'ase_map_component_zoom', true);
		$tiles 					= get_post_meta( $post->ID, 'aesop_map_tiles', true);

		$ase_map_start_point 	= empty ( $ase_map_start_point ) ? [29.76, -95.38] : [$ase_map_start_point['lat'],$ase_map_start_point['lng']];
		$ase_map_zoom 			= empty ( $get_map_zoom ) ? 12 : $get_map_zoom;

		$ase_map_start_point 	= json_encode($ase_map_start_point);
		$ase_map_locations 		= json_encode($ase_map_locations);

		?>
			<!-- Aesop Maps -->
			<script>

				jQuery(document).ready(function(){

					var start_point = <?php echo $ase_map_start_point; ?>;
					var start_zoom = <?php echo absint($ase_map_zoom); ?>;

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

			  <?php if ( 'hydda' == $tiles ) { ?>
					L.tileLayer('http://{s}.tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png', {
						minZoom: 0,
						maxZoom: 18,
						attribution: 'Tiles <a href="http://openstreetmap.se/" target="_blank">OSM Sweden</a> &mdash; Data &copy; <a href="http://openstreetmap.org">OSM</a>'
					}).addTo(map);
				<?php } elseif ( 'mq-sat' == $tiles ) { ?>
					L.tileLayer('http://oatile{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg', {
						attribution: 'Tiles <a href="http://www.mapquest.com/">MapQuest</a>, NASA/JPL-Caltech, US Dept. of Ag.',
						subdomains: '1234'
					}).addTo(map);
					L.tileLayer('http://{s}.tile.stamen.com/toner-hybrid/{z}/{x}/{y}.png', {
						attribution: 'Tiles <a href="http://stamen.com">Stamen Design</a> &mdash; Data &copy; <a href="http://openstreetmap.org">OSM</a>',
						subdomains: 'abcd',
						minZoom: 0,
						maxZoom: 20
					}).addTo(map);
				<?php } elseif ( 'mq-sat-c' == $tiles ) { ?>
					L.tileLayer('http://oatile{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg', {
						attribution: 'Tiles <a href="http://www.mapquest.com/">MapQuest</a>, NASA/JPL-Caltech, US Dept. of Ag.',
						subdomains: '1234'
					}).addTo(map);
				<?php } elseif ( 'acetate' == $tiles ) { ?>
					L.tileLayer('http://a{s}.acetate.geoiq.com/tiles/acetate-hillshading/{z}/{x}/{y}.png', {
						attribution: '&copy; Esri & Stamen, Data OSM & Natural Earth',
						subdomains: '0123',
						minZoom: 2,
						maxZoom: 18
					}).addTo(map);
				<?php } elseif ( 'stamen-tonerlite' == $tiles ) { ?>
					L.tileLayer('http://{s}.tile.stamen.com/toner-lite/{z}/{x}/{y}.png', {
						attribution: 'Tiles <a href="http://stamen.com">Stamen Design</a> &mdash; Data &copy; <a href="http://openstreetmap.org">OSM</a>',
						subdomains: 'abcd',
						minZoom: 0,
						maxZoom: 20
					}).addTo(map);
				<?php } elseif ( 'stamen-toner' == $tiles ) { ?>
					L.tileLayer('http://{s}.tile.stamen.com/toner/{z}/{x}/{y}.png', {
						attribution: 'Tiles <a href="http://stamen.com">Stamen Design</a> &mdash; Data &copy; <a href="http://openstreetmap.org">OSM</a>',
						subdomains: 'abcd',
						minZoom: 0,
						maxZoom: 20
					}).addTo(map);
				<?php } elseif ( 'stamen-w' == $tiles ) { ?>
					L.tileLayer('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png', {
						attribution: 'Tiles <a href="http://stamen.com">Stamen Design</a> &mdash; Data &copy; <a href="http://openstreetmap.org">OSM</a>',
						subdomains: 'abcd',
						minZoom: 1,
						maxZoom: 16
					}).addTo(map);
					L.tileLayer('http://{s}.tile.stamen.com/toner-hybrid/{z}/{x}/{y}.png', {
						attribution: 'Tiles <a href="http://stamen.com">Stamen Design</a> &mdash; Data &copy; <a href="http://openstreetmap.org">OSM</a>',
						subdomains: 'abcd',
						minZoom: 0,
						maxZoom: 20
					}).addTo(map);
				<?php } elseif ( 'stamen-w-c' == $tiles ) { ?>
					L.tileLayer('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png', {
						attribution: 'Tiles <a href="http://stamen.com">Stamen Design</a> &mdash; Data &copy; <a href="http://openstreetmap.org">OSM</a>',
						subdomains: 'abcd',
						minZoom: 1,
						maxZoom: 16
					}).addTo(map);
				<?php } elseif ( 'openc' == $tiles ) { ?>
				L.tileLayer('http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png', {
					attribution: '&copy; <a href="http://www.opencyclemap.org">OpenCycleMap</a>, &copy; <a href="http://openstreetmap.org">OSM</a>'
					}).addTo(map);
				<?php } elseif ( 'greenglobe' == $tiles) { ?>
				L.tileLayer('http://tile.mtbmap.cz/mtbmap_tiles/{z}/{x}/{y}.png').addTo(map);
				L.tileLayer('http://{s}.tile.stamen.com/toner-hybrid/{z}/{x}/{y}.png', {
					attribution: 'Tiles <a href="http://stamen.com">Stamen Design</a>, <a href="http://openstreetmap.org">OSM</a>',
					subdomains: 'abcd',
					minZoom: 0,
					maxZoom: 20
					}).addTo(map);
				<?php } elseif ( 'mapbox' == $tiles) { ?>
					L.tileLayer('//{s}.tiles.mapbox.com/v3/<?php echo esc_attr($mapboxid);?>/{z}/{x}/{y}.png', {
						maxZoom: 20
					}).addTo(map);
				<?php } else { ?>
					L.tileLayer('//{s}.tiles.mapbox.com/v3/<?php echo esc_attr($mapboxid);?>/{z}/{x}/{y}.png', {
						maxZoom: 20
					}).addTo(map);
				<?php } if ( ! empty( $ase_map_locations ) ) : ?>
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
					            	<a class='marker-update-button dashicons dashicons-yes'/></a>\
					            	<a class='marker-delete-button dashicons dashicons-trash'/></a>\
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
						            	<a class='marker-update-button dashicons dashicons-yes'/></a>\
						            	<a class='marker-delete-button dashicons dashicons-trash'/></a>\
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
			            	<a class='marker-update-button dashicons dashicons-yes'/></a>\
			            	<a class='marker-delete-button dashicons dashicons-trash'/></a>\
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
				// let's decode and convert the data into an array
				$location_data = json_decode(urldecode($location), true);
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
	*
	*	Map the old map post meta keys to the new map post meta keys to preserve backwards compatibility
	*	when the user updates to 1.3
	*
	*	@since 1.3
	*/
	function upgrade_map_notice(){

		// only run if we have markers and have never upgraded
		if ( get_option('ase_upgraded_to') < AI_CORE_VERSION && 'true' == self::aesop_check_for_old_markers() ) {

			$out = '<div class="error"><p>';

			$out .= __( 'Welcome to Aesop Story Engine 1.3. We need to upgrade any map markers that you might have. Click <a id="aesop-upgrade-map-meta" href="#">here</a> to start the upgrade process.', 'aesop-core' );

			$out .= '</p></div>';

			echo $out;

		}
	}

	/**
	*
	*	Check to see if our old post meta exists
	*	if it does exist then proceed with the upgrade
	*
	*	@since 1.3
	*	@return bool true if old meta exists, false if not
	*/
	function aesop_check_for_old_markers(){

		$posts = get_posts( array( 'post_type' => array('page', 'post'), 'posts_per_page' => -1 ) );

		$return = '';

		if ( $posts ) :

			foreach( $posts as $post ) {

				$meta = get_post_meta( get_the_ID(), 'aesop_map_component_locations', true );

				if ( ! empty ( $meta ) )
					$return = 'true';
				else
					$return = 'false';
			}

		endif;

		return $return;

	}

	/**
	*
	*	When the user starts the upgrade process let's run a function to map the old meta to the new meta
	*
	*	@since 1.3
	*/
	function upgrade_marker_meta(){

		check_ajax_referer( 'aesop-map-upgrade', 'security' );

		// get the posts with the maps shortode
		$posts = get_posts( array( 'post_type' => array('page', 'post'), 'posts_per_page' => -1 ) );

		$count = 0;

		if ( $posts ) :
			foreach( $posts as $post ) {
				$id = $post->ID;

				// at this point we have an array of posts that have our shortcodes
				// now let's loop through the map meta in this post and map to the new meta

				$old_locations = get_post_meta( $id, 'aesop_map_component_locations' );
				if ( ! empty ( $old_locations ) ) {
					foreach( $old_locations as $location ){
						$translated = [];
						$translated['lat'] = $location['lat'];
						$translated['lng'] = $location['long'];
						$translated['title'] = $location['content'];
						add_post_meta( $id, 'ase_map_component_locations', $translated );
					}
				}

				$old_zoom = get_post_meta( $id, 'aesop_map_component_zoom' );
				if ( ! empty ( $old_zoom ) && is_numeric( $old_zoom ) ) {
					update_post_meta( $id, 'ase_map_component_zoom', $old_zoom);
				}

				$old_start_point = get_post_meta( $id, 'aesop_map_start', true );
				if ( ! empty ( $old_start_point ) ) {
					echo $old_start_point;
					$old_start_point = explode ( ',', $old_start_point);
					if ( count( $old_start_point ) == 2 ) {
						$translated = [];
						$translated['lat'] = $old_start_point[0];
						$translated['lng'] = $old_start_point[1];
						update_post_meta( $id, 'ase_map_component_start_point', $translated );
					}
				}

				delete_post_meta( $id, 'aesop_map_component_locations' );
				delete_post_meta( $id, 'aesop_map_start' );
				delete_post_meta( $id, 'aesop_map_component_zoom' );
			}
		endif;

		update_option( 'ase_upgraded_to', AI_CORE_VERSION );

		echo 'SUCCESS';

		// die for ajax
		die();
	}

	/**
	*
	*	Handles the click function for upgrading the old map meta to the new map meta
	*
	*	@since 1.3
	*/
	function upgrade_click_handle(){

		$nonce = wp_create_nonce('aesop-map-upgrade');

		// only run if we have markers and have never upgraded
		if ( get_option('ase_upgraded_to') < AI_CORE_VERSION && 'true' == self::aesop_check_for_old_markers() ) { ?>
			<!-- Aesop Upgrade Map Meta -->
			<script>
				jQuery(document).ready(function(){
				  	jQuery('#aesop-upgrade-map-meta').click(function(e){

				  		e.preventDefault();

				  		var data = {
				            action: 'upgrade_marker_meta',
				            security: '<?php echo $nonce;?>'
				        };

					  	jQuery.post(ajaxurl, data, function(response) {
					  		if( response ){
					        	location.reload();
					  		}
					    });

				    });
				});
			</script>
		<?php }
	}

}
new AesopMapComponentAdmin;