<?php

function aesop_shortcodes_blob() {

    $codes = aesop_shortcodes();

    $blob = array();

    $arr_core_types_1 = array ('color', 'media_upload', 'select', 'select_multiple', 'text', 'text_area', 'text_small' );
    $arr_core_types_2 = array('radio_col', 'radio_row');

    foreach ( $codes as $slug => $shortcode ) {
        $return = '';
        // Shortcode has atts
        if ( count( $shortcode['atts'] ) && $shortcode['atts'] ) {

            foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {

                if ( in_array( $attr_info['type'], $arr_core_types_1 ) ) {

                    // TODO - prefix is for?
                    $prefix = isset( $attr_info['prefix'] ) ? sprintf( '<span class="aesop-option-prefix">%s</span>', $attr_info['prefix'] ) : null;

                    // TODO - in theory the type might not be suppported so this shouldn't output until we're 100% certain it's necessary
                    $return .= '<p class="aesop-' . $slug . '-' . $attr_name . '">';
                    $return .= '<label for="aesop-generator-attr-' . $attr_name . '">' . $attr_info['desc'] . '</label>';
                    $return .= '<small class="aesop-option-desc">' . $attr_info['tip'] . '</small>';

                    // Select
                    // Select multiple
                    $str_select = 'select';
                    if ( isset( $attr_info['values'] ) && substr( $attr_info['type'], 0, strlen( $str_select ) ) === $str_select ) {

                        $str_select_multi = '';
                        if ( 'select_multiple' == $attr_info['type'] ) {

                            $str_select_multi = 'multiple';
                        }

                        $return .= '<select ' . esc_attr( $str_select_multi ) . ' name="' . $attr_name . '" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr">';

                        $i = 0;

                        // TODO - add use of default if value is not yet set
                        foreach ( $attr_info['values'] as $attr_value ) {
                            $attr_value_selected = ( $attr_info['default'] == $attr_value ) ? ' selected="selected"' : '';

                            $return .= '<option value="' . $attr_info['values'][ $i ]['value'] . '" ' . $attr_value_selected . '>' . $attr_info['values'][ $i ]['name'] . '</option>';

                            $i++;
                        }

                        $return .= '</select>';


                    } else {

                        $attr_field_type = isset( $attr_info['type'] ) ? $attr_info['type'] : 'text';

                        // image upload
                        if ( 'media_upload' == $attr_info['type'] ) {

                            $return .= '<input type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-' . $attr_field_type . '" />';
                            $return .= '<input id="aesop-upload-img" type="button" class="button button-primary button-large" value="Select Media"/>';

                        } elseif ( 'color' == $attr_info['type'] ) {

                            $return .= '<input type="color" name="' . $attr_name . '" value="' . $attr_info['default'] . '" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-' . $attr_field_type . '" />';

                        } elseif ( 'text_area' == $attr_info['type'] ) {

                            $return .= '<textarea type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-' . $attr_field_type . '" />' . $prefix . '';

                        } else {
                            $return .= '<input type="' . $attr_field_type . '" name="' . $attr_name . '" value="" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-' . $attr_field_type . '" />' . $prefix . '';
                        }
                    }
                    $return .= '</p>';
                } elseif( in_array( $attr_info['type'], $arr_core_types_2 ) ) {


                 //   $slug = $arr_args['slug'];
                 //   $attr_name = $arr_args['att_name'];
                 //   $attr_info = $arr_args['att_info'];

                    $prefix = isset( $attr_info['prefix'] ) ? sprintf( '<span class="aesop-option-prefix">%s</span>', $attr_info['prefix'] ) : null;

                    $return .= '<p class="aesop-type-radio aesop-type-' . esc_attr($attr_info['type']) . ' aesop-' . esc_attr($slug) . '-' . esc_attr($attr_name) . '">';
                    //  $return .= '<label for="aesop-generator-attr-' . $attr_name . '">' . $attr_info['desc'] . '</label>';
                    $return .= '<span class="aesop-span-label" for="aesop-generator-attr-' . esc_attr($attr_name) . '">' . esc_html($attr_info['desc']) . '</span>';
                    $return .= '<small class="aesop-option-desc">' . esc_html($attr_info['tip']) . '</small>';

                    if (isset($attr_info['default'])){
                        $str_default = $attr_info['default'];
                    }
                    $str_temp = '';
                    if ( isset($attr_info['values']) && is_array($attr_info['values'])){

                        foreach ( $attr_info['values'] as $ndx => $arr_pair ){

                            $str_id = 'aesop-radio-' . trim($attr_name) . '-' . $ndx;
                            $str_temp .= '<span class="aesop-radio-wrap">';
                            $str_checked = '';
                            if ( $str_default === $arr_pair['value'] ){
                                $str_checked = ' checked ';
                            }
                            $str_temp .= '<input type="radio" id="' . esc_attr( $str_id) .'" name="' . esc_attr($attr_name) . '" value="' . esc_attr($arr_pair['value']) .'"' . $str_checked . '>';
                            $str_temp .= '<label for="' . esc_attr($str_id) . '">' . esc_attr($arr_pair['name']) . '</label>';
                            $str_temp .= '</span>';
                            // $return .= $arr_pair['value'] . ' -- ' . $arr_pair['name'];

                        }
                    }
                    $return .= $str_temp . '</p>';

                    //     $return .= '<input type="' . 'hidden' . '" name="' . $attr_name . '" value="123" id="aesop-generator-attr-' . $attr_name . '" class="aesop-generator-attr aesop-generator-attr-' . 'text' . '" />' . $prefix . '';
                    // return $return; //$bool_custom;

                } else {

                    $bool_custom = false;
                    // wanna render a custom type (e.g., radio), this is the filter for you :)
                    $arr_args = array(
                        'slug' => $slug,
                        'att_name' => $attr_name,
                        'att_info' => $attr_info,
                    );
                    $bool_custom = apply_filters( 'aesop_custom_att_type', $bool_custom, $arr_args );

                    if ( is_string( $bool_custom ) ) {
                        $return .= $bool_custom;
                    }


                }
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

        // extra JS codes
        if ( isset( $shortcode['codes'] ) ) :
            $return .= $shortcode['codes'];
        endif;


        $blob[ $slug ] = $return;
    }//end foreach
    return $blob;
}
