<?php
/**
 * Provides an image and caption
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_image_shortcode' ) ) {

    function aesop_image_shortcode( $atts ) {
        $defaults = array(
            'panorama'         => 'off',
            'img'              => '',
            'imgwidth'         => '100%',
            'imgheight'        => '',
            'offset'           => '',
            'alt'              => '',
            'align'            => 'center', // deffault value fixed BY BORAY
			'captionsrc'      => 'custom',
            'caption'          => '',
            'credit'           => '',
            'captionposition'  => 'left',
            'lightbox'         => 'off',
            'force_fullwidth'  => 'off',
            'overlay_content'  => '',
            'revealfx'         => '',
            'overlay_revealfx' => '',
            'className'=>''
        );

        $atts = apply_filters( 'aesop_image_defaults', shortcode_atts( $defaults, $atts, 'aesop_image' ) );

        $panorama  = $atts['panorama'] == "on";
        $imgheight = 0;

        if ( $panorama ) {
            // panorama mode is on
            wp_enqueue_script( 'aesop-paver', AI_CORE_URL . '/public/assets/js/jquery.paver.min.js', array( 'ai-core' ) );
            $atts['imgwidth'] = "100%";
            if ( empty( $atts['imgheight'] ) ) {
                list( $width, $height, $type, $attr ) = getimagesize( $atts['img'] );

                if ( empty( $height ) ) {
                    $imgheight = "500px";
                } else {
                    $imgheight = $height . "px";
                }
            } else {
                $imgheight = aesop_size_string_parse( $atts['imgheight'], "500px" );
            }

            //$image_id = aesop_get_image_id($atts['img']);

            add_action( 'wp_footer', 'aesop_panorama', 20 );
        }

        // offset styles
        $offsetstyle = $atts['offset'] && ( 'left' == $atts['align'] || 'right' == $atts['align'] ) ? sprintf( 'style=margin-%s:%s;width:%s;', $atts['align'], $atts['offset'], $atts['imgwidth'] ) : 'style=max-width:' . $atts['imgwidth'] . ';';

        // custom classes
        $classes = $atts['className'].' '.(function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'image', '' ) : null);

        // let this be used multiple times
        static $instance = 0;
        $instance++;
        $unique = sprintf( '%s-%s', get_the_ID(), $instance );

        // lazy loader class
        $lazy_holder = AI_CORE_URL . '/public/assets/img/aesop-lazy-holder.png';
        $lazy        = class_exists( 'AesopLazyLoader' ) && ! is_user_logged_in() ? sprintf( 'src="%s" data-src="%s" class="aesop-lazy-img"', $lazy_holder, esc_url( $atts['img'] ) ) : sprintf( 'src="%s"', esc_url( $atts['img'] ) );

        // try to use srcset and sizes on new WP installs
		if ( function_exists('wp_get_attachment_image_srcset') && $attachment_id = attachment_url_to_postid( $atts['img'] ) ) {
			$srcset = wp_get_attachment_image_srcset( $attachment_id, 'full' );
			$sizes = wp_get_attachment_image_sizes( $attachment_id, 'full' );
            $lazy = "srcset='$srcset' sizes='$sizes' $lazy";
        }

        // automatic alt tag fallback if none specified
        $auto_alt = $atts['img'] ? basename( $atts['img'] ) : null;
        $alt      = $atts['alt'] ? $atts['alt'] : preg_replace( '/\\.[^.\\s]{3,4}$/', '', $auto_alt );

        // combine into component shell
        ob_start();
		
		//get attachment caption
		if ($atts['captionsrc'] == 'wp_media_caption') {
			$image_id = aesop_get_image_id($atts['img']);
			if ($image_id) {	
				$atts['caption'] = wp_get_attachment_caption( $image_id  );
			}
		}

        do_action( 'aesop_image_before', $atts, $unique ); // action
        // hide the component initially if revealfx is set
        ?>
        <div id="aesop-image-component-<?php echo esc_html( $unique ); ?>" <?php echo aesop_component_data_atts( 'image', $unique, $atts ); ?>
             class="aesop-component aesop-image-component <?php echo sanitize_html_class( $classes ) ?> alignfull"
            <?php echo aesop_revealfx_set( $atts ) ? 'style="visibility:hidden;"' : null ?>
        >


            <?php do_action( 'aesop_image_inside_top', $atts, $unique ); // action
            // new
            $bool_custom = false;
            $arr_args    = array(
                'alt'         => $alt,
                'atts'        => $atts,
                'auto_alt'    => $auto_alt,
                'imgheight'   => $imgheight,
                'instance'    => $instance,
                '$lazy'       => $lazy,
                'lazy_holder' => $lazy_holder,
                'panorama'    => $panorama,
                'unique'      => $unique
            );

            $bool_custom = apply_filters( 'aesop_image_custom_view', $bool_custom, $arr_args );

            if ( $bool_custom === false ) {
                ?>

                <div>
                    <figure class="aesop-image-component-image aesop-component-align-<?php echo sanitize_html_class( $atts['align'] ); ?> aesop-image-component-caption-<?php echo sanitize_html_class( $atts['captionposition'] ); ?>" <?php echo esc_attr( $offsetstyle ); ?>>
                        <?php

                        do_action( 'aesop_image_inner_inside_top', $atts, $unique ); // action


                        if ( 'on' == $atts['lightbox'] ) { ?>

                            <a class="aesop-lightbox"
                               href="<?php echo $atts['img']; ?>"
                               title="<?php echo $atts['caption']; ?>">
                                <p class="aesop-img-enlarge"><i
                                            class="aesopicon aesopicon-search-plus"></i> <?php _e( 'Enlarge', 'aesop-core' ); ?>
                                </p>
                                <?php
                                if ( $panorama ) { ?>
                                <div class="aesop-panorama"
                                     style="height:<?php echo $imgheight; ?>;">
                                    <?php
                                    } ?>
                                    <img <?php echo $lazy; ?>
                                            alt="<?php echo esc_attr( $alt ); ?>">
                                    <?php
                                    if ( $panorama ) { ?>
                                </div>
                            <?php
                            } ?>
                            </a>

                        <?php } else { ?>
                            <?php
                            if ( $panorama ) { ?>
                                <div class="aesop-panorama" style="height:<?php echo $imgheight; ?>;">
                                <?php
                            } ?>
                            <img <?php echo $lazy; ?>
                                    alt="<?php echo esc_attr( $alt ); ?>">
                            <?php
                            if ( $panorama ) { ?>
                                </div>
                                <?php
                            } ?>

                        <?php }

                        if ( $atts['caption'] || $atts['credit'] ) { ?>

                            <figcaption class="aesop-image-component-caption">
                                <?php

                                echo aesop_component_media_filter( $atts['caption'] );

                                if ( $atts['credit'] ) { ?>
                                    <p class="aesop-cap-cred"><?php echo $atts['credit']; ?></p>
                                    <?php
                                } ?>

                            </figcaption>

                            <?php
                        }
                        ?>


                        <?php do_action( 'aesop_image_inner_inside_bottom', $atts, $unique ); // action ?>

                    </figure>
                </div>
                <div class="aesop-image-overlay-content">
                    <?php echo $atts['overlay_content']; ?>
                </div>

                <?php
            }
            do_action( 'aesop_image_inside_bottom', $atts, $unique ); // action ?>

        </div>
        <?php
        do_action( 'aesop_image_after', $atts, $unique ); // action

        return ob_get_clean();
    }

    function aesop_get_image_id( $image_url ) {

        global $wpdb;
        $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

        return $attachment[0];
    }


}//end if
