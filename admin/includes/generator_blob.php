<?php

function aesop_shortcodes_blob() {
$codes = aesop_shortcodes();

$blob = array();

foreach( $codes as $slug => $shortcode ) {
	$return = '';
	// Shortcode has atts
	if ( count( $shortcode['atts'] ) && $shortcode['atts'] ) {
		foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {

			$return .= '<p>';
			$return .= '<a rel="tooltip" class="aesop-option-tip" href="#" data-toggle="tooltip" data-placement="right" title="'.$attr_info['tip'].'" ><i class="dashicons dashicons-editor-help"></i></a>';
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

				$attr_field_type = isset($attr_info['type']) ? $attr_info['type'] : 'text';

				// image upload
				if('media_upload' == $attr_info['type']) {

					$return .= '<input type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-'.$attr_field_type.'" />';
					$return .= '<input id="aesop-upload-img" type="button" class="button button-primary button-large" value="Select Media"/>';

				} elseif ('color' == $attr_info['type']) {

					$return .= '<input type="color" name="' . $attr_name . '" value="'.$attr_info['default'].'" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-'.$attr_field_type.'" />';

				} else {
					$return .= '<input type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-'.$attr_field_type.'" />';
				}
			}
			$return .= '</p>';
		}
	}

	// Single shortcode (not closed)
	if ('single' == $shortcode['type']) {

		$return .= '<input type="hidden" name="aesop-generator-content" id="aesop-generator-content" value="false" />';

	} else {

		$return .= '<p><label>' . __( 'Content', 'aesop-shortcodes' ) . '</label><input type="text" name="aesop-generator-content" id="aesop-generator-content" value="' . $shortcode['content'] . '" /></p>';
	}

	$return .= '<p class="aesop-component-description">Description:&nbsp; '.$shortcode['desc'].'</p>';
	$return .= '<p class="aesop-buttoninsert-wrap"><a href="#" id="aesop-generator-insert">' . __( 'Insert Component', 'aesop-shortcodes' ) . '</a></p> ';

	$return .= '<input type="hidden" name="aesop-generator-result" id="aesop-generator-result" value="" />';

	$blob[$slug] = $return;	
}
	return $blob;
}