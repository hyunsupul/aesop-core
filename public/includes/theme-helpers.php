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