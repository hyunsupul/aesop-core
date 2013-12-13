<?php

if (!function_exists('aesop_map_shortcode')) {
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

class AesopMapComponent {

	public function __construct(){
		add_action('wp_footer', array($this,'aesop_map_loader'),99);
		add_filter( 'cmb_meta_boxes', array($this,'aesop_map_meta') );
	}

	function aesop_map_loader(){

		global $post;

		$markers = get_post_meta(get_the_ID(),'aesop_map_component_locations', false);
		$start = get_post_meta($post->ID,'aesop_map_start', true);

		if( has_shortcode( $post->post_content, 'aesop_map') )  { ?>
			<script>

				var map = L.map('map',{
					scrollWheelZoom: false,
					zoom:12,
					center: [51.5, -0.09]
				});

				L.tileLayer('http://{s}.tile.cloudmade.com/4595fbb0139f4a8b9ccbd1b150016109/997/256/{z}/{x}/{y}.png', {
					maxZoom: 18,
					attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
				}).addTo(map);

				L.marker([51.48, -0.09]).addTo(map).bindPopup("Sup").openPopup();

				<?php for($i=1;$i<=3;$i++){

					foreach($markers as $marker):

						$lat = $marker['lat'];
						$long = $marker['long'];
						$text = $marker['content'];

						$loc = $lat.','.$long;

						?> L.marker([<?php echo $loc;?>]).addTo(map).bindPopup("<?php echo $text;?>").openPopup(); <?php

					endforeach;
				}
				?>
			</script>

		<?php }
	}

	function aesop_map_meta( array $meta_boxes ) {

		$opts = array(
			array(
				'id'			=> 'aesop_map_start',
				'name'			=> __('Starting Coordinates', 'aesop-core'),
				'type'			=> 'text',
			),
			array(
				'id' 			=> 'aesop_map_component_locations',
				'name' 			=> __('Map Locations', 'aesop-core'),
				'type' 			=> 'group',
				'cols' 			=> 8,
				'repeatable'     => true,
				'repeatable_max' => 20,
				'sortable'		=> true,
				'fields' 		=> array(
					array(
						'id' 	=> 'lat',
						'name' 	=> 'Latitude',
						'type' 	=> 'text'
					),
					array(
						'id' 	=> 'long',
						'name' 	=> 'Longitude',
						'type' 	=> 'text'
					),
					array(
						'id' 	=> 'content',
						'name' 	=> 'Marker Text',
						'type' 	=> 'text'
					)
				)
			)
		);

		$meta_boxes[] = array(
			'title' => __('Map Component Locations', 'aesop-core'),
			'pages' => 'post',
			'fields' => $opts
		);

		return $meta_boxes;

	}

}
new AesopMapComponent;