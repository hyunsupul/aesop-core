<?php

function aesop_shortcodes_blob() {
	$codes = aesop_shortcodes();

	$blob = array();

	foreach ( $codes as $slug => $shortcode ) {
		$return = '';
		// Shortcode has atts
		if ( count( $shortcode['atts'] ) && $shortcode['atts'] ) {

			foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {

				$prefix = isset( $attr_info['prefix'] ) ? sprintf( '<span class="aesop-option-prefix">%s</span>', $attr_info['prefix'] ) : null;

				$return .= '<p class="aesop-'.$slug.'-'.$attr_name.'">';
				$return .= '<label for="aesop-generator-attr-' . $attr_name . '">' . $attr_info['desc'] . '</label>';
				$return .= '<small class="aesop-option-desc">'.$attr_info['tip'].'</small>';
				// Select
				if ( isset( $attr_info['values'] ) ) {

					$return .= '<select name="' . $attr_name . '" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr">';

					$i = 0;

					foreach ( $attr_info['values'] as $attr_value ) {
						$attr_value_selected = ( $attr_info['default'] == $attr_value ) ? ' selected="selected"' : '';

						$return .= '<option value="'.$attr_info['values'][$i]['value'].'" ' . $attr_value_selected . '>'.$attr_info['values'][$i]['name'].'</option>';

						$i++;
					}

					$return .= '</select>';

				} else {

					$attr_field_type = isset( $attr_info['type'] ) ? $attr_info['type'] : 'text';

					// image upload
					if ( 'media_upload' == $attr_info['type'] ) {

						$return .= '<input type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-'.$attr_field_type.'" />';
						$return .= '<input id="aesop-upload-img" type="button" class="button button-primary button-large" value="Select Media"/>';

					} elseif ( 'color' == $attr_info['type'] ) {

						$return .= '<input type="color" name="' . $attr_name . '" value="'.$attr_info['default'].'" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-'.$attr_field_type.'" />';

					} elseif ( 'text_area' == $attr_info['type'] ) {

						$return .= '<textarea type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-'.$attr_field_type.'" />'.$prefix.'';

					} else {
						$return .= '<input type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-'.$attr_field_type.'" />'.$prefix.'';
					}
				}//end if
				$return .= '</p>';
			}//end foreach
		}//end if

		// Single shortcode (not closed)
		if ( 'single' == $shortcode['type'] ) {

			$return .= '<input type="hidden" name="aesop-generator-content" id="aesop-generator-content" value="false" />';

		} else {

			$return .= '<p><label>' . __( 'Content', 'aesop-core' ) . '</label><textarea type="text" name="aesop-generator-content" id="aesop-generator-content" value="' . $shortcode['content'] . '" /></p>';
		}

		$return .= '<p class="aesop-buttoninsert-wrap"><a href="#" id="aesop-generator-insert"><span class="aesop-generator-button-insert">' . __( 'Insert Component', 'aesop-core' ) . '</span><span class="aesop-generator-button-update">' . __( 'Update Component', 'aesop-core' ) . '</span></a></p> ';

		$return .= '<input type="hidden" name="aesop-generator-result" id="aesop-generator-result" value="" />';

		$blob[$slug] = $return;
	}//end foreach
	return $blob;
}
