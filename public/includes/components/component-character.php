<?php

/**
 * Creates an interactive character element
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_character_shortcode' ) ) {

    function aesop_make_square( $id ) {

        ?>
        <script>
            document.getElementById("<?php echo $id;?>").style.height = document.getElementById("<?php echo $id;?>").clientWidth + "px";
        </script>
        <?php
    }

    function aesop_character_shortcode( $atts, $content = null ) {
        $defaults = array(
            'img'          => '',
            'name'         => '',
            'caption'      => '',
            'align'        => 'left',
            'width'        => '',
            'force_circle' => 'off',
            'revealfx'     => '',
            'link'         => '',
            'className'=>''
        );

        // let this be used multiple times
        static $instance = 0;
        $instance++;
        $unique = sprintf( '%s-%s', get_the_ID(), $instance );

        $atts = apply_filters( 'aesop_character_defaults', shortcode_atts( $defaults, $atts, 'aesop_character' ) );

        // custom classes
        $classes = $atts['className'].' '.(function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'character', '' ) : null);

        // width styles
        $styles = $atts['width'] ? sprintf( 'style="width:%s;"', esc_attr( $atts['width'] ) ) : null;

        // wrapper float class
        $float = $atts['align'] ? sprintf( 'aesop-component-align-%s', esc_attr( $atts['align'] ) ) : null;

        // automatic alt tag
        $auto_alt = $atts['img'] ? basename( $atts['img'] ) : null;
        $alt      = $auto_alt ? preg_replace( '/\\.[^.\\s]{3,4}$/', '', $auto_alt ) : null;

        // character wrap
        ob_start();

        do_action( 'aesop_character_before', $atts, $unique ); // action

        ?>
        <aside id="aesop-character-component-<?php echo esc_attr( $unique ); ?>" <?php echo aesop_component_data_atts( 'character', $unique, $atts ); ?>
               class="aesop-character-component aesop-component <?php echo sanitize_html_classes( $classes ) . '' . sanitize_html_classes( $float ); ?> "
            <?php echo aesop_revealfx_set( $atts ) ? 'style="visibility:hidden;"' : null ?>
        >

            <?php do_action( 'aesop_character_inside_top', $atts, $unique ); // action
            // new
            $bool_custom = false;
            $arr_args    = array(
                'alt'      => $alt,
                'auto_alt' => $auto_alt,
                'atts'     => $atts,
                'content'  => $content,
                'instance' => $instance,
                'styles'   => $styles,
                'unique'   => $unique
            );
            $bool_custom = apply_filters( 'aesop_character_custom_view', $bool_custom, $arr_args );

            if ( $bool_custom === false ) {


                ?>

                <div class="aesop-character-inner aesop-content">
                    <div class="aesop-character-float aesop-character-<?php echo esc_attr( $atts['align'] ); ?>" <?php echo $styles; ?>>

                        <?php do_action( 'aesop_character_inner_inside_top', $atts, $unique ); // action ?>

                        <?php if ( $atts['name'] ) { ?>
                            <span class="aesop-character-title"><?php echo aesop_component_media_filter( $atts['name'] ); ?></span>
                        <?php } ?>

                        <?php if ( $atts['img'] ) { ?>
                            <img class="aesop-character-avatar"
                                 id="aesop-character-avatar-<?php echo esc_attr( $unique ); ?>"
                                 src="<?php echo esc_url( $atts['img'] ); ?>"
                                 alt="<?php echo esc_attr_e( $alt ); ?>">
                        <?php } ?>

                        <?php if ( $atts['force_circle'] !== 'off' ) {
                            aesop_make_square( "aesop-character-avatar-" . esc_attr( $unique ) );
                        } ?>

                        <?php if ( $content ) { ?>
                            <div class="aesop-character-text"><?php echo do_shortcode( $content ); ?></div>
                        <?php } ?>

                        <?php if ( $atts['caption'] ) { ?>
                            <p class="aesop-character-cap"><?php echo aesop_component_media_filter( $atts['caption'] ); ?></p>
                        <?php } ?>

                        <?php do_action( 'aesop_character_inner_inside_bottom', $atts, $unique );   ?>

                    </div>
                </div>

                <?php
            }
            do_action( 'aesop_character_inside_bottom', $atts, $unique ); ?>

        </aside>
        <?php

        do_action( 'aesop_character_after', $atts, $unique ); // action

        return ob_get_clean();
    }


}//end if
