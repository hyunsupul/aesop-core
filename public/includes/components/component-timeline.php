<?php

/**
 * Creates an interactive timeline component that works similar to chapter
 * headings
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_timeline_stop_shortcode' ) ) {

    function aesop_timeline_stop_shortcode( $atts ) {

        $defaults = array(
            'num'   => '2007',
            'title' => '',
            'className'=>''
        );
        $atts     = apply_filters( 'aesop_timeline_defaults', shortcode_atts( $defaults, $atts ) );

        // let this be used multiple times
        static $instance = 0;
        $instance++;
        $unique = sprintf( '%s-%s', get_the_ID(), $instance );

        $datatitle = $atts['title'] ? sprintf( 'data-title="%s"', esc_attr( $atts['title'] ) ) : null;
        // actions
        $actiontop    = do_action( 'aesop_timeline_before', $atts, $unique ); // action
        $actionbottom = do_action( 'aesop_timeline_after', $atts, $unique ); // action

        // new
        $bool_custom = false;
        $arr_args    = array(
            'actiontop'    => $actiontop,
            'actionbottom' => $actionbottom,
            'atts'         => $atts,
            'datatitle'    => $datatitle,
            'instance'     => $instance,
            'unique'       => $unique
        );
        $bool_custom = apply_filters( 'aesop_timeline_custom_view', $bool_custom, $arr_args );

        if ( $bool_custom === false ) {

            $out = sprintf( '%s<h2 class="aesop-timeline-stop aesop-component %s" %s %s>%s</h2>%s', $actiontop, $atts['className'], $datatitle, aesop_component_data_atts( 'timeline_stop', $unique, $atts ), esc_html( $atts['num'] ), $actionbottom );

            return apply_filters( 'aesop_timeline_output', $out );
        }
    }
}//end if

if ( ! function_exists( 'aesop_timeline_class_loader' ) ) {

    add_action( 'wp', 'aesop_timeline_class_loader', 11 ); // has to run after components are loaded
    function aesop_timeline_class_loader() {

        global $post;

        $default_location = is_single() || is_page();
        $location         = apply_filters( 'aesop_timeline_component_appears', $default_location );

        if ( function_exists( 'aesop_component_exists' ) && ( $location ) && 
             (aesop_component_exists( 'timeline_stop' )  || (aesop_component_exists( 'chapter' ) && get_post_meta($post->ID, 'ase_chapter_enable_timeline', true) =='on') )) {
                 
            new AesopTimelineComponent();

        }
    }

}

class AesopTimelineComponent {

    public function __construct() {

        // call our method in the footer
        add_action( 'wp_footer', array( $this, 'aesop_timeline_loader' ), 21 );

        // add a body class if timeline is active
        add_filter( 'body_class', array( $this, 'body_class' ) );

    }

    public function aesop_timeline_loader() {
        
        // allow theme developers to determine the offset amount
        $timelineOffset = apply_filters( 'aesop_timeline_scroll_offset', 0 );

        // filterable content class
        $postClass = get_post_class();
        if ( in_array( 'aesop-entry-content', $postClass ) ) {
            $contentClass = '.aesop-entry-content';
        } else {
            $contentClass = apply_filters( 'aesop_chapter_scroll_container', '.entry-content' );
        }

        // filterable target class
        $appendTo = apply_filters( 'aesop_timeline_scroll_nav', '.aesop-timeline' );

        $post_meta = get_post_meta(get_the_ID(), 'ase_chapter_enable_timeline', true);
        $use_chapter = (aesop_component_exists( 'chapter' ) && ( $post_meta === true || $post_meta === 'on' ) ) ;
        
        $stop_class =  !$use_chapter ?  '.aesop-timeline-stop'  : '.aesop-article-chapter';
        
        

        ?>
        <!-- Aesop Timeline -->
        <script>
            jQuery(document).ready(function ($) {

                contentClass = '<?php echo esc_attr( $contentClass );?>';
                if (jQuery(contentClass).length == 0) {
                    contentClass = '.aesop-entry-content';
                }

                $('body').append('<div class="aesop-timeline"></div>');

                $(contentClass).scrollNav({
                    sections: '<?php echo $stop_class;?>',
                    arrowKeys: true,
                    insertTarget: '<?php echo esc_attr( $appendTo );?>',
                    insertLocation: 'appendTo',
                    showTopLink: false,
                    showHeadline: false,
                    scrollOffset: <?php echo (int)$timelineOffset;?>,
                });

                $('.aesop-timeline-stop').each(function () {
                    var label = $(this).attr('data-title');
                    $(this).text(label);
                });

            });

        </script>

        <?php
    }


    public function body_class( $classes ) {

        $classes[] = 'has-timeline';

        return $classes;

    }
}
