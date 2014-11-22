<?php
/**
 * Allows content to be centered
 *
 * @global $content_width Theme's content width.
 *
 * @since 1.0.4
 *
 * @param  array $atts Attributes of the shortcode.
 * @param  string $content Shortcode content.
 *
 * @return string
 */
function aesop_center_content( $atts, $content ) {
	global $content_width;

	if ( ! isset( $content_width ) )
		$content_width = 960;

	return "<div class='aesop-content-center' style='max-width: {$content_width}px; margin-left: auto; margin-right: auto;'>". do_shortcode( $content ) ."</div>";
}
add_shortcode( 'aesop_center', 'aesop_center_content' );


/**
 * Let classes be added to components by themers or plugin authors
 *
 * @since 1.0.4
 *
 * @param  string $component name of component being passed
 * @param  string $classes class or multiple classes separated with a space
 *
 * @return filter
 */
function aesop_component_classes( $component = '', $classes = '' ) {

	return apply_filters('aesop_'.$component.'_component_classes', $classes );
}

/**
* Checks to see if an aesop component is present in the post
*
* @since 1.0.6
*
* @param string $component name of component being passed
* @return bool
*
**/
function aesop_component_exists( $component = '' ) {

	global $post;

	// bail if has_shortcode isn't present (pre wp 3.6)
	if ( !function_exists('has_shortcode') ) {
		return;
	}

	// check the post content for the passed shortcode
	if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'aesop_'.$component ) ) {

		return true;

	} else {

		return false;
	}
}

/**
*
*	Detect current theme and add a body class for it
* 	@since 1.0.9
* 	@return merged array of classes
* 	uses body_class
*
*/
add_filter('body_class', 'aesop_check_theme');
function aesop_check_theme($classes){

	$theme 		= wp_get_theme();
	$get_name  	=  strtolower( $theme->get( 'Name' ) );
	$name 		= str_replace(' ', '-', $get_name );

	$classes[] = 'aesop-on-'.$name;

	return $classes;

}

/**
*	Used on the front end to properly escape attributes where users have control over what input is entered
*	Currently used in content component floater and maps marker content
*	
*	@since 1.3
*	@return a sanitized string
*/
function aesop_component_media_filter( $input = '' ) {

	// bail if no input
	if ( empty( $input ) )
		return;

	// setup our array of allowed content to pass
	$allowed_html = array(
		'a' 			=> array(
		    'href' 		=> array(),
		    'title' 	=> array(),
		    'rel'		=> array(),
		    'target'	=> array(),
		    'name' 		=> array()
		),
		'img'			=> array(
			'src' 		=> array(),
			'alt'		=> array(),
			'title'		=> array()
		),
		'p'				=> array(),
		'br' 			=> array(),
		'em' 			=> array(),
		'strong' 		=> array()
	);

	$out = wp_kses( $input, apply_filters('aesop_content_allowed_html', $allowed_html ) );

	return $out;
}

/**
*
*	Used to filter the map tile provider per post
*
*	@param $postid int id of the post for the map tile provider to change on
*	@return a filtered map tile url based on provider
*	@since 1.3
*/
function aesop_map_tile_provider( $postid = 0 ) {

	// default provider
	$mapboxid 	= get_option('ase_mapbox_id','aesopinteractive.hkoag9o3');

	// setup a filter to change the provider
	$provider = apply_filters('aesop_map_tile_provider', 'mapbox', $postid);

	switch ($provider) {
		case 'mapbox':
			$out = sprintf('//{s}.tiles.mapbox.com/v3/%s/{z}/{x}/{y}.png', esc_attr( $mapboxid ) );
			break;
		case 'stamen-toner-lite':
			$out = '//{s}.tile.stamen.com/toner-lite/{z}/{x}/{y}.png';
			break;
		case 'stamen-toner':
			$out = '//{s}.tile.stamen.com/toner/{z}/{x}/{y}.png';
			break;
		case 'stamen-watercolor':
			$out = '//{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png';
			break;
		case 'mapquest':
			$out = '//oatile{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg';
			break;
		case 'acetate':
			$out = '//a{s}.acetate.geoiq.com/tiles/acetate-hillshading/{z}/{x}/{y}.png';
			break;
		case 'hydda-full':
			$out = '//{s}.tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png';
			break;
		default:
			$out = sprintf('//{s}.tiles.mapbox.com/v3/%s/{z}/{x}/{y}.png', esc_attr( $mapboxid ) );
			break;
	}

	return $out;
}