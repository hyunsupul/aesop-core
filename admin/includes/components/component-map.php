<?php
/**
 	* Filters custom meta box class to add cusotm meta to map component
 	*
 	* @since    1.0.0
*/
class AesopMapComponentAdmin {

	public function __construct(){
		add_filter( 'cmb_meta_boxes', array($this,'aesop_map_meta') );

		add_action('aesop_admin_styles', 		array($this, 'icon') );
		add_filter('aesop_avail_components',	array($this, 'options'));
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
	*	Create the options for the shortcode that gets created when stickky maps is activated
	*	This lets the user use the user interface to add teh specific points in the story that the map should jump markers
	*
	*	@since 1.3
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
						'type'			=> 'text_small', // a small text field
						'default' 		=> '',
						'desc' 			=> __('Title', 'aesop-core'),
						'tip'			=> __('By default we\'ll display an H2 heading with the text you specify here.','aesop-core')
					),
					/*
					'location' 				=> array(
						'type'			=> 'select', // a select dropdown 
						'values' 		=> self::get_markers_for_option_array(),
						'default' 		=> '',
						'desc' 			=> __('Choose a marker to display', 'aesop-core'),
						'tip'			=> __('By default an H2 heading will be used. You can optionally hide this completely but retain the scroll to point in the map.','aesop-core')
					),
					*/
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
	*	Set a custom icon for our new map marker shortcode
	*	@since 1.3
	*
	*/
	function icon(){

		$icon = '\f230'; //css code for dashicon
		$slug = 'map_marker'; // name of component

		wp_add_inline_style('ai-core-styles', '#aesop-generator-wrap li.'.$slug.' {display:none;} #aesop-generator-wrap li.'.$slug.' a:before {content: "'.$icon.'";}');
	}

	/**
	*
	*	Get teh available markers for this post and create an option array to use in the optoin function above
	*
	*	@since 1.3
	*/
	function get_markers_for_option_array($postid = 0) {

		if ( empty($postid) )
			$postid = get_the_ID();

		$markers = get_post_meta( $postid, 'aesop_map_component_locations', false );


		$array = array();

		if ( $markers ):

			foreach( $markers as $marker ){

				$lat 	= $marker['lat'];
				$long 	= $marker['long'];

				$mark 	= sprintf('%s,%s',$lat,$long);

				array_push( $array, array(
		            'value' => $mark,
		            'name' 	=> !empty($marker['content']) ? esc_attr($marker['content']) : 'Marker'
		        ));
			}

			return $array;

		endif;
	}
}
new AesopMapComponentAdmin;