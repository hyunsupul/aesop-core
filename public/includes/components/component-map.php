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

		// actions
		$actiontop = do_action('aesop_map_before'); //action
		$actionbottom = do_action('aesop_map_after'); //action

		//clean height
		$height = preg_replace('/[^0-9]/','',$atts['height']);

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'map', '' ) : null;

		$out = sprintf('%s<div id="aesop-map-component" class="aesop-component aesop-map-component %s" style="height:%spx"></div>%s',$actiontop, $classes, $height, $actionbottom);

		return apply_filters('aesop_map_output',$out);
	}

}

class AesopMapComponent {

	function __construct(){
		add_action('wp_footer', array($this,'aesop_map_loader'),20);
	}

	function aesop_map_loader(){

		global $post;

		$markers = isset( $post ) ? get_post_meta($post->ID,'aesop_map_component_locations', false) : false;
		$start = isset( $post ) ? get_post_meta($post->ID,'aesop_map_start', true) : false;
		$mapboxid = get_option('ase_mapbox_id','aesopinteractive.hkoag9o3');
		$zoom = isset( $post ) ? get_post_meta($post->ID,'aesop_map_component_zoom', true) : 12;

		if( isset($post) && is_single() && has_shortcode( $post->post_content, 'aesop_map') )  { ?>
			<!-- Aesop Locations -->
			<script>

				var map = L.map('aesop-map-component',{
					scrollWheelZoom: false,
					zoom: <?php echo wp_filter_nohtml_kses( round( $zoom ) );?>,
					center: [<?php echo $start;?>]
				});

				L.tileLayer('//{s}.tiles.mapbox.com/v3/<?php echo $mapboxid;?>/{z}/{x}/{y}.png', {
					maxZoom: 20
				}).addTo(map);

				<?php

				if($markers):

					foreach($markers as $marker):

						$lat 	= sanitize_text_field($marker['lat']);
						$long 	= sanitize_text_field($marker['long']);
						$text 	= $marker['content'] ? $marker['content'] : false;

						$loc 	= sprintf('%s,%s',$lat,$long);

						?> L.marker([<?php echo $loc;?>]).addTo(map).bindPopup("<?php echo $text;?>").openPopup(); <?php

					endforeach;

				endif;
				?>
			</script>

		<?php }
	}

}
new AesopMapComponent;
