<?php

if (!function_exists('aesop_map_shortcode')){

	function aesop_map_shortcode($atts, $content = null) {

		$defaults = array(
			'height' 				=> 500,
		);

		wp_enqueue_script('aesop-map-script',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.js');
		wp_enqueue_style('aesop-map-style',AI_CORE_URL.'/public/includes/libs/leaflet/leaflet.css', AI_CORE_VERSION, true);
		
		$atts = apply_filters('aesop_map_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();

		ob_start();

		?>

		<div id="map" style="height:<?php echo $atts['height'];?>px"></div>

		<?php return ob_get_clean();
	}
}

if (!function_exists('aesop_map_loader')){

	function aesop_map_loader(){

		global $post;

		if( has_shortcode( $post->post_content, 'aesop_map') )  { ?>
			<script>

				var map = L.map('map').setView([51.505, -0.09], 13);

				L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
					maxZoom: 18,
					attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
				}).addTo(map);


				L.marker([51.5, -0.09]).addTo(map)
					.bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();

				L.circle([51.508, -0.11], 500, {
					color: 'red',
					fillColor: '#f03',
					fillOpacity: 0.5
				}).addTo(map).bindPopup("I am a circle.");

				L.polygon([
					[51.509, -0.08],
					[51.503, -0.06],
					[51.51, -0.047]
				]).addTo(map).bindPopup("I am a polygon.");


				var popup = L.popup();

				function onMapClick(e) {
					popup
						.setLatLng(e.latlng)
						.setContent("You clicked the map at " + e.latlng.toString())
						.openOn(map);
				}

				map.on('click', onMapClick);

			</script>

		<?php }
	}
	add_action('wp_footer', 'aesop_map_loader',99);
}