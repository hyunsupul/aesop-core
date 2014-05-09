<?php
/**
 	* Filters custom meta box class to add cusotm meta to map component
 	*
 	* @since    1.0.0
*/
class AesopMapComponentAdmin {

	public function __construct(){
		add_filter( 'cmb_meta_boxes', array($this,'aesop_map_meta') );
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

}
new AesopMapComponentAdmin;