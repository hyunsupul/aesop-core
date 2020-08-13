<?php

/**
 * Creates an interactive timeline component that works similar to chapter
 * headings
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_collection_shortcode' ) ) {

    function aesop_collection_shortcode( $atts ) {
        $defaults = array(
            'collection'  => 1,
            'title'       => '',
            'columns'     => 1,
            'limit'       => -1,
            'splash'      => '',
            'loadmore'    => 'off',
            'showexcerpt' => 'on',
            'order'       => 'default',
            'revealfx'    => '',
            'className'=>''
        );

        $atts     = apply_filters( 'aesop_collection_defaults', shortcode_atts( $defaults, $atts, 'aesop_collection' ) );

        // let this be used multiple times
        static $instance = 0;
        $instance++;
        $unique = sprintf( '%s-%s', get_the_ID(), $instance );

        ob_start();

        $col = $atts['columns'] ? preg_replace( '/[^0-9]/', '', $atts['columns'] ) : null;

        $splash_class = 'on' == $atts['splash'] ? 'aesop-collection-splash' : null;

        // custom classes
        $classes = $atts['className'].' '.(function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'collections', '' ) : null);

        $hidden = "";
        if ( aesop_revealfx_set( $atts ) ) {
            $hidden = 'style="visibility:hidden;"';
        }

        do_action( 'aesop_collection_before', $atts, $unique ); // action

        ?>
        <!-- Collections -->
        <div <?php echo aesop_component_data_atts( 'collection', $unique, $atts ); ?>
                class="aesop-story-collection alignfull aesop-component <?php echo sanitize_html_class( $classes ); ?>">

            <?php do_action( 'aesop_collection_inside_top', $atts, $unique ); // action

            // new
            $bool_custom = false;
            $arr_args    = array(
                'atts'         => $atts,
                'classes'      => $classes,
                'col'          => $col,
                'hidden'       => $hidden,
                'instance'     => $instance,
                'splash_class' => $splash_class,
                'unique'       => $unique
            );
            $bool_custom = apply_filters( 'aesop_collections_custom_view', $bool_custom, $arr_args );

            if ( $bool_custom === false ) {

                ?>

                <?php if ( $atts['title'] ) { ?>
                <h4 class="aesop-story-collection-title">
                    <span><?php echo esc_html( $atts['title'] ); ?></span></h4>
            <?php } ?>

                <div id="aesop-collection-<?php echo $unique; ?>"
                     class="aesop-collection-grid clearfix aesop-collection-grid-<?php echo absint( $col ); ?>col <?php echo sanitize_html_class( $splash_class ); ?>">

                    <?php

                    // if collection ID is set
                    if ( $atts['collection'] ):

                        // if splash mode is set
                        if ( 'on' == $atts['splash'] ) {

                            // cat query args
                            $cat_args = array(
                                'orderby' => 'name',
                                'order'   => 'ASC'
                            );

                            // get cached query
                            //$cats = wp_cache_get( 'aesop_splash_query_' . $atts['collection'] );

                            // if no cached query then cache the query
                            //if ( false == $cats ) {
                            //    $cats = get_categories( apply_filters( 'aesop_splash_query', $cat_args ) );
                            //    wp_cache_set( 'aesop_splash_query_' . $atts['collection'], $cats );
                            //}

                            if ( $cats ):

                                foreach ( $cats as $cat ) {

                                    ?>
                                    <div
                                            class="aesop-collection-item aesop-collection-category-<?php echo $cat->slug; ?>" <?php echo $hidden; ?>>
                                        <?php do_action( 'aesop_collection_inside_category_item_top', $atts, $unique ); // action ?>
                                        <a class="aesop-collection-item-link"
                                           href="<?php echo get_category_link( $cat->term_id ); ?>">
                                            <div class="aesop-collection-item-inner">
                                                <h2 class="aesop-collection-entry-title"
                                                    itemprop="title"><?php echo $cat->name; ?></h2>
                                                <div class="aesop-collection-item-excerpt"><?php echo $cat->category_description; ?></div>
                                            </div>
                                            <div class="aesop-collection-item-img"></div>
                                        </a>
                                        <?php do_action( 'aesop_collection_inside_category_item_bottom', $atts, $unique ); // action ?>
                                    </div>
                                    <?php
                                }

                            endif;

                            // else carry onto default mode
                        } else {

                            // query args
                            $order = $atts['order'] == 'default' ? 'DESC' : 'ASC';
                            $args  = array(
                                'orderby'        => array( 'date' => $order ),
                                'posts_per_page' => $atts['limit'],
                                'cat'            => $atts['collection'],
                                'ignore_sticky'  => true,
                                'post_status' => array('publish'),
                                'paged'          => 1
                            );

                            // do not use cache any more
                            //$query = wp_cache_get( 'aesop_collection_query_' . $atts['collection'] );

                            $query = new wp_query( apply_filters( 'aesop_collection_query', $args ) );
                            //wp_cache_set( 'aesop_collection_query_' . $atts['collection'], $query );


                            $maxpages = $query->max_num_pages;

                            // loop through the stories
                            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

                                $coverimg     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
                                $excerpt      = '';
                                $gutenberg_on = function_exists( 'register_block_type' );
                                if ( ! $gutenberg_on && $atts['showexcerpt'] == 'on' ) {
                                    // for an unknown reason, the following code fails when running with Gutenberg
                                    $excerpt = get_the_excerpt( get_the_ID() );
                                }


                                ?>
                                <div
                                        class="aesop-collection-item <?php if ( $coverimg ) {
                                            echo "aesop-has-image";
                                        } ?>" <?php echo $hidden; ?>>
                                    <?php do_action( 'aesop_collection_inside_item_top', $atts, $unique ); // action ?>
                                    <a class="aesop-fader aesop-collection-item-link"
                                       href="<?php the_permalink(); ?>">
                                        <div class="aesop-collection-item-inner">
                                            <h2 class="aesop-collection-entry-title"
                                                itemprop="title"><?php the_title(); ?></h2>
                                            <p class="aesop-collection-meta"><?php printf( __( 'Written by %s', 'aesop-core' ), apply_filters( 'aesop_collection_author', get_the_author(), get_the_ID() ) ); ?></p>
                                            <div class="aesop-collection-item-excerpt"><?php echo wp_trim_words( $excerpt, 16, '...' ); ?></div>
                                        </div>
                                        <div class="aesop-collection-item-img"
                                             style="background-image:url(<?php echo $coverimg[0]; ?>);background-repeat:no-repeat;background-size:cover;"></div>
                                    </a>
                                    <?php do_action( 'aesop_collection_inside_item_bottom', $atts, $unique ); // action ?>
                                </div>
                            <?php

                            endwhile;endif;

                            wp_reset_postdata();

                        }//end if

                    // if collection ID isn't set warn them
                    else :

                        ?>
                        <div class="aesop-error aesop-content"><?php
                        _e( 'Specify a category ID to display stories from.', 'aesop-core' );
                        ?></div><?php

                    endif;

                    ?>
                </div>
            <?php
            if ( $atts['loadmore'] == 'on' && $atts['splash'] != 'on' && $maxpages > 1 ) {
            ?>
                <div class="aesop-collection-load-more"
                     id="aesop-load-more-<?php echo $unique; ?>"><span
                            class="aesop-loadmore-text"><?php echo __( 'Load More', 'aesop-core' ); ?></span>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        var pageindex = 2;
                        var loadMoreText = "<?php echo __( 'Load More', 'aesop-core' );?>";
                        var loadingText = "<?php echo __( 'Loading', 'aesop-core' );?>";
                        jQuery('#aesop-load-more-<?php echo $unique;?>').click(function (e) {

                            e.preventDefault();

                            $(this).find(".aesop-loadmore-text").text(loadingText);

                            var data = {
                                action: 'aesop_get_more_posts',
                                posts_per_page: '<?php echo $atts['limit']?>',
                                order: '<?php echo $order?>',
                                cat: '<?php echo $atts['collection']?>',
                                page: pageindex,
                            };
                            ajaxurl = '<?php echo admin_url( 'admin-ajax.php' );?>';

                            jQuery.post(ajaxurl, data).done(function (response) {
                                if (response) {
                                    jQuery("#aesop-collection-<?php echo $unique;?>").append(response);
                                    pageindex++;
                                    if (pageindex > <?php echo $maxpages?>) {
                                        jQuery("#aesop-load-more-<?php echo $unique;?>").remove();
                                    } else {
                                        $("#aesop-load-more-<?php echo $unique;?> .aesop-loadmore-text").text(loadMoreText);
                                    }
                                } else {
                                    jQuery("#aesop-load-more-<?php echo $unique;?>").remove();
                                }
                            })
                                .fail(function (xhr, status, error) {
                                    $(this).find(".aesop-loadmore-text").text("AJAX Error");
                                });

                        });
                    });
                </script>
                <?php
            }
            }


            do_action( 'aesop_collection_inside_bottom', $atts, $unique ); // action ?>

        </div>
        <?php

        do_action( 'aesop_collection_after', $atts, $unique ); // action

        return ob_get_clean();
    }
}//end if
