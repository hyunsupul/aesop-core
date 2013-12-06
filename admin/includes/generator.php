<?php

	// Start WordPress
	require( '../../../../../wp-load.php' );

	// Capability check
	if ( !current_user_can( 'publish_posts' ) )
		die( 'Access denied' );

	// Param check
	if ( empty( $_GET['shortcode'] ) )
		die( 'Shortcode not specified' );

	$shortcode = aesop_shortcodes( $_GET['shortcode'] );

	$return = null;
	
	// Shortcode has atts
	if ( count( $shortcode['atts'] ) && $shortcode['atts'] ) {
		foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {
			$return .= '<p>';
			$return .= '<label for="aesop-generator-attr-' . $attr_name . '">' . $attr_info['desc'] . '</label>';
			// Select
			if ( count( $attr_info['values'] ) && $attr_info['values'] ) {
				$return .= '<select name="' . $attr_name . '" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr">';
				foreach ( $attr_info['values'] as $attr_value ) {
					$attr_value_selected = ( $attr_info['default'] == $attr_value ) ? ' selected="selected"' : '';
					$return .= '<option' . $attr_value_selected . '>' . $attr_value . '</option>';
				}
				$return .= '</select>';
			}
			// Text input
			else {
				$attr_info['type'] = null;
				$attr_field_type = ( $attr_info['type'] == 'color' ) ? 'color' : 'text';
				$return .= '<input type="' . $attr_field_type . '" name="' . $attr_name . '" value="' . $attr_info['default'] . '" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr" />';
			}
			$return .= '</p>';
		}
	}

	// Single shortcode (not closed)
	if ( $shortcode['type'] == 'single' ) {
		$return .= '<input type="hidden" name="aesop-generator-content" id="aesop-generator-content" value="false" />';
	} else {

		$return .= '<p><label>' . __( 'Content', 'aesop-shortcodes' ) . '</label><input type="text" name="aesop-generator-content" id="aesop-generator-content" value="' . $shortcode['content'] . '" /></p>';
	}

	$return .= '<p class="aesop-buttoninsert-wrap"><a href="#" class="button-primary" id="aesop-generator-insert">' . __( 'Insert Shortcode', 'aesop-shortcodes' ) . '</a></p> ';

	$return .= '<input type="hidden" name="aesop-generator-result" id="aesop-generator-result" value="" />';

	echo $return;
?>