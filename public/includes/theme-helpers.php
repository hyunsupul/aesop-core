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
		if (  function_exists( 'has_blocks' ) ) {
			if ($component == 'timeline_stop') {
				$component = 'timeline';
			}
			// if Gutenberg is on, check for Aesop Gutenberg blocks
			if ( is_object( $post) && has_blocks( $post->post_content ) ) {
				// check if the given Aesop block exists
				// If the Gutenberg plugin is installed
				if ( function_exists( 'gutenberg_parse_blocks' ) ) :
					$blocks = gutenberg_parse_blocks($post->post_content );
				
				// If WordPress is upgraded to 5.0
				elseif ( function_exists( 'parse_blocks' ) ) :
					$blocks = parse_blocks($post->post_content );
				endif;
				
				if ( isset( $blocks ) ) :
					foreach ($blocks as &$block) {
						if ( is_array( $block )) {
							if ( array_key_exists('blockName', $block) && $block['blockName'] == 'ase/'.$component ) {
								return true;
							}
						} else {
							if ( $block->blockName == 'ase/'.$component ) {
								return true;
							}
						}
					}
				endif;
			}
		}
		return false;
	}
}

// a function to enable panorama features
function aesop_panorama()
{
	?>
		<script>

				jQuery(document).ready(function($){
					var screensize = $(window).height();
					$( ".aesop-panorama" ).each(function() {
						if ($(this).height() > screensize) {
							$( this ).height(screensize);
						}
					});
				  	jQuery('.aesop-panorama').paver();
				});		 
		</script>
		<?php
	
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
		    'class' => true,
            'style' => true,
			'href'   => array(),
			'title'  => array(),
			'rel'  => array(),
			'target' => array(),
			'name'   => array()
		),
		'img'   => array(
		    'class' => true,
            'style' => true,
			'src'   => array(),
			'alt'  => array(),
			'title'  => array()
		),
		'p'    => array(),
		'br'    => array(),
		'em'    => array(),
		'strong'   => array(),
		'h1'    => array(
			'align' => true,
			'class' => true,
			'style' => true
		),
		'h2'    => array(
			'align' => true,
			'class' => true,
			'style' => true
		),
		'h3'    => array(
		    'class' => true,
			'align' => true,
            'style' => true
		),
		'h4'    => array(
		    'class' => true,
			'align' => true,
            'style' => true
		),
		'h5'    => array(
		    'class' => true,
			'align' => true,
            'style' => true
		),
		'h6'    => array(
		    'class' => true,
			'align' => true,
            'style' => true
		),
		'div'    => array(
		    'class' => true,
			'align' => true,
            'style' => true
		)		,
		'span'    => array(
		    'class' => true,
            'style' => true
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

	$mapbox_style  = get_option( 'ase_mapbox_style', 'v1/mapbox/streets-v11' );
	if (empty($mapbox_style)) {
		$mapbox_style  = 'v1/mapbox/streets-v11';
    }


	// mapbox api now requires a public token
	//$token     = apply_filters( 'aesop_map_token', 'pk.eyJ1IjoiYWVzb3BpbnRlcmFjdGl2ZSIsImEiOiJ3TjJ4M0hJIn0.LwbGC9U8iKT_saX8c6v_4Q' );
	$token = get_option( 'ase_mapbox_token', 'pk.eyJ1IjoiaHl1bnN0ZXIiLCJhIjoiY2lrd3Jjb2NkMDBsM3U0bTNjbDd6c2liYSJ9.4R-XjaHyC3xbdTpHp_v1Ag' );
    $token = apply_filters( 'aesop_map_token', $token  );

	// setup a filter to change the provider
	$provider = apply_filters( 'aesop_map_tile_provider', 'mapbox', $postid );

	// mapbox map path
	$mapbox_upgraded = get_option( 'ase_mapbox_upgraded' );
    $path =  'https://api.mapbox.com/styles/'.$mapbox_style .'/tiles/256/{z}/{x}/{y}?title=true&access_token='.$token;


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
    
    // a way to customize this URL programatically
    $out = apply_filters( 'aesop_map_tile_url', $out, $postid );
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

	// hero
	$hero_content   = get_post_meta( $postid, 'aesop_hero_gallery_content', true );

	
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
		'pslayout'  =>  sanitize_text_field(trim( $photoset_layout )),
		'pslightbox' => sanitize_text_field( trim( $photoset_lb ) ),
		'content' => sanitize_text_field( trim( $hero_content ) ),
	);

	// map the meta to att values
	$options = '';

	foreach ( $meta as $item => $value ) {

		$options .= ! empty( $value ) ? 'data-'.$item.'="'.htmlentities( $value ).'" '  : false;
	}

	return $options;
}

/**
 * Returns if the current component has revealfx set.
 * This function can be used to override enabling/disabling of animation
 * @since 1.9.3
 */
 if ( ! function_exists( 'aesop_revealfx_set' ) ) {
	function aesop_revealfx_set($atts)
	{
		if (  (!empty($atts['revealfx']) && $atts['revealfx']!='off') || (!empty($atts['overlay_revealfx']) && $atts['overlay_revealfx']!='off') ){
			return true;
		}
		return false;
	}
}

/*
 A helper function to make sense out of a video URL
*/
 if ( ! function_exists( 'aesop_video_url_parse' ) ) {
	function aesop_video_url_parse($url)
	{
		$atts = array(
		    'type'   => "self",
			'id'     => "",
			'url'    => $url
		);
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			$atts['id'] = $match[1];
			$atts['type'] = 'youtube';
			return $atts;
		} 
		else if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $match)) {
			$atts['id'] = $match[5];
			$atts['type'] = 'vimeo';
			return $atts;
		} else {
			// not youtube or vimeo, assume self hosted for now
			$atts['type'] = 'self';
		}
		return $atts;
	}
}

/*
 A helper function to process pixel size string
*/
 if ( ! function_exists( 'aesop_size_string_parse' ) ) {
	function aesop_size_string_parse($size, $default)
	{
		$i = intval($size);
		if ($i == 0) {
			return $default;
		}
		if (strpos($size, 'px') == false) {
			return $i."px";
		}
		return $size;
	}
}
