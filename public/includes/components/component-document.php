<?php

/**
 * Creates a dropdown document revealer
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_document_shortcode' ) ) {

	function aesop_document_shortcode( $atts ) {

		$defaults = array(
			'type'  	=> 'pdf',
			'src'  		=> '',
			'caption' 	=> '',
			'title' 	=> '',
			'download'  => '',
            'className'=>''
		);
		$atts = apply_filters( 'aesop_document_defaults', shortcode_atts( $defaults, $atts, 'aesop_document' ) );

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );

		// actions
		$actiontop = do_action( 'aesop_document_before', $atts, $unique ); // action
		$actionbottom = do_action( 'aesop_document_cafter', $atts, $unique ); // action
		$actioninsidetop = do_action( 'aesop_document_inside_top', $atts, $unique ); // action
		$actioninsidebottom = do_action( 'aesop_document_inside_bottom', $atts, $unique ); // action
		
		$showpdflink = ($atts['type'] =='pdf' && wp_is_mobile());

		// custom classes
		$classes = $atts['className'].' '.(function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'document', '' ) : null);

		switch ( $atts['type'] ) {
		case 'pdf':
			$source = sprintf( '<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', esc_url( $atts['src'] ) );
			break;
		case 'image':
			$source = sprintf( '<img src="%s"', esc_url( $atts['src'] ) );
			break;
		case 'ms':
		    $source = sprintf( '<iframe class="aesop-ms-doc" src="http://docs.google.com/viewer?url=%s&embedded=true" ></iframe>', esc_url( $atts['src'] )  );
		    break;
		case 'download':
		    $source = sprintf( '<a href="%s" download>'.__('Download','aesop-core' ).'</a>', esc_url( $atts['src'] ) );
			break;
		default:
			$source = sprintf( '<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', esc_url( $atts['src'] ) );
			break;
		}
		
		if ($atts['download']=='on' && $atts['type'] != 'download') {
			 $source = sprintf( '<a href="%s" download>'.__('Download','aesop-core' ).'</a>', esc_url( $atts['src'] ) ).$source;
		}

        // new
        $bool_custom = false;
        $arr_args    = array(
            'actiontop' => $actiontop,
            'actionbottom' => $actionbottom,
            'actioninsidetop' => $actioninsidetop,
            'actioninsidebottom' => $actioninsidebottom,
            'atts'    => $atts,
            'classes' => $classes,
            'instance' => $instance,
            'showpdflink' => $showpdflink,
            'unique'  => $unique
        );
        $bool_custom = apply_filters( 'aesop_document_custom_view', $bool_custom, $arr_args );

        if ( $bool_custom === false ) {

            $script = sprintf( '
			<script>
			jQuery(document).ready(function($){
				$(\'.aesop-doc-reveal-%s\').click(function(e){
					e.preventDefault;
					$( "#aesop-doc-collapse-%s" ).slideToggle();
					return false;
				});
			});
		    </script>
		', esc_attr( $unique ), esc_attr( $unique ) );

            $slide = $atts['caption'] ? esc_html( $atts['caption'] ) : false;
			if ($atts['title']=='') {
				$link = sprintf( '<a href="#" class="aesop-doc-reveal-%s"><span class="aesop-document-component--label">'.__('document','aesop-core' ).'</span><br /> <div class="aesop-document-component--caption">%s</div></a>', esc_attr( $unique ), $slide );
			} else {
				$link = sprintf( '<a href="#" class="aesop-doc-reveal-%s"><span class="aesop-document-component--label">'. esc_attr($atts['title']).'</span><br /> <div class="aesop-document-component--caption">%s</div></a>', esc_attr( $unique ), $slide );
			}
            $guts  = sprintf( '<div id="aesop-doc-collapse-%s" style="display:none;" class="aesop-content">%s</div>', esc_attr( $unique ), $source );
            if ( $showpdflink ) {
                $guts .= sprintf( '<a href="%s">%s</a>', esc_url( $atts['src'] ), __( 'PDF Download', 'aesop-core' ) );
            }

            $out = sprintf( '%s<aside %s class="aesop-component aesop-document-component aesop-content %s">%s%s%s%s%s</aside>%s', $actiontop, aesop_component_data_atts( 'document', $unique, $atts ), $classes, $script, $actioninsidetop, $link, $guts, $actioninsidebottom, $actionbottom );
        }
		return apply_filters( 'aesop_document_output', $out );
	}
}//end if
