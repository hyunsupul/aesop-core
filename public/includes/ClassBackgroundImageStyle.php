<?php

namespace Aesop\Plugin\BackgroundImageStyle;

class ClassBackgroundImageStyle {

    protected $_bool_active;
    protected $_str_selector_prefix;
    protected $_obj_post;
    protected $_str_css_selector_slug;
    protected $_arr_breakpoints;
    protected $_arr_breakpoints_defaults;
    protected $_arr_wp_image_sizes;
    protected $_arr_push;

    public function __construct() {

        $this->setReset();
        $this->setPropertyDefaults();

    }

    protected function setPropertyDefaults() {


        $this->_str_selector_prefix = '#';
        // IMPORTANT - Order here matters. You want to start small (read: "mobile-first") and get larger.
        $this->_arr_breakpoints          = [

            'xs' => [
                'min_width' => 0,
                'unit'      => 'px',
            ],
            'sm' => [
                'min_width' => 576,
                'unit'      => 'px',
            ],
            'md' => [
                'min_width' => 768,
                'unit'      => 'px',
            ],
            'lg' => [
                'min_width' => 992,
                'unit'      => 'px',
            ],
            'xl' => [
                'min_width' => 1200,
                'unit'      => 'px',
            ],
        ];
        // TODO - setter? 
        $this->_arr_breakpoints_defaults = [
            'min_width' => 0,
            'unit'      => 'px'
        ];
        // optional - what wp image size to use for each breakpoint
        // if you don't set these then you MUST define the wp image size as you go, as you'll see below.
        $this->_arr_wp_image_sizes = [

            'xs' => false,
            'sm' => false,
            'md' => false,
            'lg' => false,
            'xl' => false
        ];
        $this->_arr_push           = [];

    }

    /**
     * You can reset if you need it. Recommended if you're looping
     */
    public function setReset($bool_push = false ) {

        $this->_bool_active = null;
        $this->_obj_post    = false;
        $this->_str_css_selector_slug  = false;

        if ( $bool_push === true ){
            $this->_arr_push           = [];
        }
    }

    public function setAttachmentID( $int_att_id = false ) {


        if ( is_integer( $int_att_id ) || is_string( $int_att_id ) ) {

            $int_temp = (integer)$int_att_id;
            https://codex.wordpress.org/Function_Reference/wp_attachment_is_image
            if ( wp_attachment_is_image( $int_temp ) ) {

                $this->_int_attachment_id = $int_temp;

                return true;
            }
        }

        return false;
    }


    /**
     * IMPORTANT - Do __not__ include the # or . or whatever. The default is #, or you can use setSelectorPrefix() to change it
     *
     * @param bool $str_css
     *
     * @return bool
     */
    public function setSelector( $str_css = false ) {

        if ( is_string( $str_css ) ) {

            $this->_str_css_selector_slug = trim( $str_css );

            return true;
        }

        return false;
    }

    /**
     * Default = '#'
     *
     * @param string $str_selector
     *
     * @return bool
     */
    public function setSelectorPrefix( $str_selector = '#' ) {

        if ( is_string( $str_selector ) ) {
            $this->_str_selector_prefix = $str_selector;

            return true;
        }

        return false;
    }


    public function setBreakpoints( $arr_breakpoints = false ) {

        if ( is_array( $arr_breakpoints ) ) {
            $this->_arr_breakpoints = $arr_breakpoints;

            return true;
        }

        return false;
    }

    /**
     * Optional
     *
     * @param bool $arr_wp_image_sizes
     *
     * @return bool
     */
    public function setImageSizes( $arr_wp_image_sizes = false ) {

        if ( is_array( $arr_wp_image_sizes ) ) {
            $this->_arr_wp_image_sizes = $arr_wp_image_sizes;

            return true;
        }

        return false;
    }
    
    // ------ once the attachment id and css selector are set, you simply "push" the breakpoint you want

    /**
     * @param bool $str_wp_img_size
     */
    public function pushXS( $str_wp_img_size = false ) {

        $this->pushSizeMaster( 'xs', $str_wp_img_size );

    }

    public function pushSM( $str_wp_img_size = false ) {

        $this->pushSizeMaster( 'sm', $str_wp_img_size );

    }

    public function pushMD( $str_wp_img_size = false ) {

        $this->pushSizeMaster( 'md', $str_wp_img_size );

    }

    public function pushLG( $str_wp_img_size = false ) {

        $this->pushSizeMaster( 'lg', $str_wp_img_size );

    }


    public function pushXL( $str_wp_img_size = false ) {

        $this->pushSizeMaster( 'xl', $str_wp_img_size );

    }


    public function pushSizeMaster( $str_bp = 'xs', $str_wp_img_size = false ) {

        if ( $this->getActive() === true ) {

            if ( ! is_string( $str_wp_img_size ) ) {
                // if we don't pass in the size we want to use, is there a usable value in $_arr_wp_image_sizes
                if ( isset( $this->_arr_wp_image_sizes[ $str_bp ] ) && is_string( $this->_arr_wp_image_sizes[ $str_bp ] ) ) {
                    $str_wp_img_size = $this->_arr_wp_image_sizes[ $str_bp ];
                } else {
                    // $str_wp_img_size is ! string && there's no default / fallback. we're outta here!
                    return false;
                }
            } elseif ( ! is_string( $str_bp ) ) {
                $str_bp = 'xs';
            }
            $str_wp_img_size = trim( $str_wp_img_size );

            // https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
            // IMPORTANT - if the attachment image does not have the requested size WP will return the original full sized image.
            $mix = wp_get_attachment_image_src( $this->_int_attachment_id, $str_wp_img_size );

            if ( isset( $mix[0] ) ) {

                // [by Breakpoint][by css selector] = image url for the wp image size specified
                $this->_arr_push[ $str_bp ][ $this->_str_css_selector_slug ] = $mix[0];

                return true;

            }
        }

        return false;
    }

    /**
     * Are the properties we need property set?
     *
     * @return bool
     */
    public function getActive() {

        if ( $this->_bool_active === null ) {

            $this->_bool_active = false;
            if ( is_integer( $this->_int_attachment_id ) && is_string( $this->_str_css_selector_slug ) && ! empty( esc_attr( $this->_str_css_selector_slug ) ) ) {
                $this->_bool_active = true;
            }
        }

        return $this->_bool_active;
    }

    public function getPushArray() {

        return $this->_arr_push;
    }


    protected function backgroundImage( $id, $url ) {

        return esc_attr( $this->_str_selector_prefix ) . esc_attr( $id ) . '{background-image: url(' . esc_attr( $url ) . ');}';
    }


    /**
     * Return a string (or array) of what's been push'ed (above)
     *
     * @param bool $bool_echo
     *
     * @return array|bool
     */
    public function getStyle( $bool_echo = true ) {

        $arr_ret = [];
        foreach ( $this->_arr_breakpoints as $str_key => $arr_args ) {

            if ( is_array( $arr_args ) ) {
                $arr_args = array_merge( $this->_arr_breakpoints_defaults, $arr_args );
            }

            // for this bp, was something push'ed and it must be an array
            if ( isset( $this->_arr_push[ $str_key ] ) && is_array( $this->_arr_push[ $str_key ] ) ) {

                $arr_temp = [];
                // loop over the pairs [ css_selector , url] and make the magic happen for this bp
                foreach ( $this->_arr_push[ $str_key ] as $str_css_sel => $str_url ) {
                    if ( is_string( $str_css_sel ) && is_string( $str_url ) ) {
                        $arr_temp[] = $this->backgroundImage( $str_css_sel, $str_url );
                    }
                }
                if ( ! empty( $arr_temp ) ) {
                    $str_bp = esc_attr( $arr_args['min_width'] . $arr_args['unit'] );
                    if ( $arr_args['min_width'] > 0 ) {
                        $str_ret = ' @media screen and (min-width:' . $str_bp . '){';
                        $str_ret .= implode( ' ', $arr_temp );
                        $str_ret .= '} ';

                    } else {
                        $str_ret = implode( ' ', $arr_temp );
                    }
                    // add the string to the (return) array
                    $arr_ret[ $str_bp ] = $str_ret;
                }

            }

        }
        if ( $bool_echo !== false ) {

            // Only do the <style>...</style> if we have something.
            if ( is_array($arr_ret) && ! empty( $arr_ret ) ) {

                $str_style = '<style>' . implode( ' ', $arr_ret ) . ' </style>';
                echo $str_style;

                return true;
            }

            return false;
        }

        return $arr_ret;
    }


}