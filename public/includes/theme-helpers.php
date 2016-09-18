<?php
/**
 * Allows content to be centered
 *
 * @global $content_width Theme's content width.
 *
 * @since 1.0.4
 *
 * @param string  $content Shortcode content.
 *
 * @return string
 */
function aesop_center_content( $content ) {
	global $content_width;

	if ( ! isset( $content_width ) ) {
		$content_width = 960; }

	return "<div class='aesop-content-center' style='max-width: {$content_width}px; margin-left: auto; margin-right: auto;'>". do_shortcode( $content ) .'</div>';
}
add_shortcode( 'aesop_center', 'aesop_center_content' );


/**
 * Let classes be added to components by themers or plugin authors
 *
 * @since 1.0.4
 *
 * @param string  $component name of component being passed
 * @param string  $classes   class or multiple classes separated with a space
 *
 * @return filter
 */
function aesop_component_classes( $component = '', $classes = '' ) {

	return apply_filters( 'aesop_'.$component.'_component_classes', $classes );
}

/**
 * Checks to see if an aesop component is present in the post
 *
 * @since 1.0.6
 *
 * @param string  $component name of component being passed
 * @return null|boolean
 *
 * */
function aesop_component_exists( $component = '' ) {

	global $post;

	// bail if has_shortcode isn't present (pre wp 3.6)
	if ( ! function_exists( 'has_shortcode' ) ) {
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
 * Detect current theme and add a body class for it
 *  @since 1.0.9
 *  @return merged array of classes
 *  uses body_class
 *
 */
add_filter( 'body_class', 'aesop_check_theme' );
function aesop_check_theme( $classes ) {

	$theme   = wp_get_theme();
	$get_name   = strtolower( $theme->get( 'Name' ) );
	$name   = str_replace( ' ', '-', $get_name );

	$classes[] = 'aesop-on-'.$name;

	return $classes;

}

/**
 * Used on the front end to properly escape attributes where users have control over what input is entered
 * Currently used in content component floater and maps marker content
 *
 * @since 1.3
 * @return a sanitized string
 */
function aesop_component_media_filter( $input = '' ) {

	// bail if no input
	if ( empty( $input ) ) {
		return; }

	// setup our array of allowed content to pass
	$allowed_html = array(
		'a'    => array(
			'href'   => array(),
			'title'  => array(),
			'rel'  => array(),
			'target' => array(),
			'name'   => array()
		),
		'img'   => array(
			'src'   => array(),
			'alt'  => array(),
			'title'  => array()
		),
		'p'    => array(),
		'br'    => array(),
		'em'    => array(),
		'strong'   => array(),
		'h2'    => array(
			'align' => true,
		),
		'h3'    => array(
			'align' => true,
		),
		'h4'    => array(
			'align' => true,
		),
		'h5'    => array(
			'align' => true,
		),
		'h6'    => array(
			'align' => true,
		),
	);

	$out = wp_kses( $input, apply_filters( 'aesop_content_allowed_html', $allowed_html ) );

	return $out;
}

/**
 * Used to filter the map tile provider per post
 *
 * @param integer $postid int id of the post for the map tile provider to change on
 * @return string filtered map tile url based on provider
 * @since 1.3
 */
function aesop_map_tile_provider( $postid = 0 ) {

	// default provider - changed as of 1.5
	$mapboxid  = get_option( 'ase_mapbox_id', 'aesopinteractive.l74n2fi6' );

	// mapbox v4 api now requires a public token
	$token     = apply_filters( 'aesop_map_token', 'pk.eyJ1IjoiYWVzb3BpbnRlcmFjdGl2ZSIsImEiOiJ3TjJ4M0hJIn0.LwbGC9U8iKT_saX8c6v_4Q' );

	// setup a filter to change the provider
	$provider = apply_filters( 'aesop_map_tile_provider', 'mapbox', $postid );

	// mapbox map path
	$mapbox_upgraded = get_option( 'ase_mapbox_upgraded' );
	$path = empty( $mapbox_upgraded ) ? sprintf( '//{s}.tiles.mapbox.com/v3/%s/{z}/{x}/{y}.png', esc_attr( $mapboxid ) ) : sprintf( 'https://api.tiles.mapbox.com/v4/%s/{z}/{x}/{y}.png?access_token=%s', esc_attr( $mapboxid ), esc_attr( $token ) );

	switch ( $provider ) {
	case 'mapbox':
		$out = sprintf( '%s', $path );
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
		$out = sprintf( '//{s}.tiles.mapbox.com/v3/%s/{z}/{x}/{y}.png', esc_attr( $mapboxid ) );
		break;
	}
	return $out;
}

/**
 * Return data attributes for use with Aesop Story Editor
 *
 * @param string $type       the type of component
 * @param unknown $gallery_id int the id of the gallery component if being used
 * @param unknown $defaults   array the components attributes including users set merged
 * @param unknown $editable   bool is this component editable directly inline
 * @since 1.4.2
 */
function aesop_component_data_atts( $type, $gallery_id, $defaults, $editable = false ) {

	// bail if we dont have a type or if the current user can't do anything
	// may just need to back out to is user logged in like we had before
	if ( empty( $type ) || empty( $defaults ) || ! current_user_can( 'edit_posts' ) ) {
		return; }

	// if aesop story editor isn't activated then dont even bother
	if ( ! function_exists( 'lasso_editor_components' ) ) {
		return; }

	// we're looping through the default attributes that are fed to us and outputting them as data-attributes
	$options = '';

	if ( 'gallery' == $type ) {

		$options .= sprintf( '%s', aesop_gallery_component_data_atts( $gallery_id ) );
		$gallery_id = sprintf( 'data-id=%s', $gallery_id );

	} else {

		foreach ( $defaults as $default => $value ) {

			$options .= ! empty( $value ) ? 'data-'.$default.'="'.htmlentities( $value ).'" '  : false;
		}

		$gallery_id = false;
	}

	$edit_state = true == $editable ? 'contenteditable=true' : 'contenteditable=false';

	$out = sprintf( '%s data-component-type=%s %s %s ', $edit_state, $type, $gallery_id, $options );

	return $out;
}
/**
 * Return data attribtues for teh gallery component
 *  This one is different as teh attribute are stored in post meta and not as a shortcode attribute
 *
 * @return null|string array of gallery component info
 * @since 1.4.2
 */
function aesop_gallery_component_data_atts( $postid = '' ) {

	// bail out if aesop story editor isn't activated or if there's no gallery id passed
	if ( empty ( $postid ) || ! function_exists( 'lasso_editor_components' ) ) {
		return; }

	// type
	$type    = get_post_meta( $postid, 'aesop_gallery_type', true );

	// global
	$width    = get_post_meta( $postid, 'aesop_gallery_width', true );
	$caption   = get_post_meta( $postid, 'aesop_gallery_caption', true );

	// grid
	$grid_item_width = get_post_meta( $postid, 'aesop_grid_gallery_width', true );

	// thumbnail
	$thumb_trans  = get_post_meta( $postid, 'aesop_thumb_gallery_transition', true );
	$thumb_speed  = get_post_meta( $postid, 'aesop_thumb_gallery_transition_speed', true );
	$thumb_hide  = get_post_meta( $postid, 'aesop_thumb_gallery_hide_thumbs', true );

	// photoset
	$photoset_layout = get_post_meta( $postid, 'aesop_photoset_gallery_layout', true );
	$photoset_lb   = get_post_meta( $postid, 'aesop_photoset_gallery_lightbox', true );

	// get the meta and store into an array
	$meta = array(
		'id'   => $postid,
		'gallery-type'  => sanitize_text_field( trim( $type ) ),
		'width'   => sanitize_text_field( trim( $width ) ),
		'caption'   => sanitize_text_field( trim( $caption ) ),
		'itemwidth'  => trim( $grid_item_width ),
		'transition'  => sanitize_text_field( trim( $thumb_trans ) ),
		'speed'   => $thumb_speed,
		'thumbhide' => $thumb_hide,
		'pslayout'  => (int) trim( $photoset_layout ),
		'pslightbox' => sanitize_text_field( trim( $photoset_lb ) )
	);

	// map the meta to att values
	$options = '';

	foreach ( $meta as $item => $value ) {

		$options .= ! empty( $value ) ? 'data-'.$item.'="'.htmlentities( $value ).'" '  : false;
	}

	return $options;
}
