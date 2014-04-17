<?php
/**
 * Allows content to be centered
 *
 * @global $content_width Theme's content width.
 *
 * @since 1.1
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
