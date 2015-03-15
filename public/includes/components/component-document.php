<?php

/**
 * Creates a dropdown document revealer
 *
 * @since    1.0.0
 */
<<<<<<< HEAD
if ( ! function_exists( 'aesop_document_shortcode' ) ){
=======
if ( ! function_exists( 'aesop_document_shortcode' ) ) {
>>>>>>> release/1.5.1

	function aesop_document_shortcode( $atts ) {

		$defaults = array(
			'type'  	=> 'pdf',
			'src'  		=> '',
			'caption' 	=> ''
		);
<<<<<<< HEAD
		$atts = apply_filters( 'aesop_document_defaults',shortcode_atts( $defaults, $atts ) );
=======
		$atts = apply_filters( 'aesop_document_defaults', shortcode_atts( $defaults, $atts ) );
>>>>>>> release/1.5.1

		// let this be used multiple times
		static $instance = 0;
		$instance++;
<<<<<<< HEAD
		$unique = sprintf( '%s-%s',get_the_ID(), $instance );
=======
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );
>>>>>>> release/1.5.1

		// actions
		$actiontop = do_action( 'aesop_document_before' ); // action
		$actionbottom = do_action( 'aesop_document_cafter' ); // action
		$actioninsidetop = do_action( 'aesop_document_inside_top' ); // action
		$actioninsidebottom = do_action( 'aesop_document_inside_bottom' ); // action

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'document', '' ) : null;

		switch ( $atts['type'] ) {
<<<<<<< HEAD
			case 'pdf':
				$source = sprintf( '<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', esc_url( $atts['src'] ) );
			break;
			case 'image':
				$source = sprintf( '<img src="%s"', esc_url( $atts['src'] ) );
			break;
			default:
				$source = sprintf( '<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', esc_url( $atts['src'] ) );
=======
		case 'pdf':
			$source = sprintf( '<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', esc_url( $atts['src'] ) );
			break;
		case 'image':
			$source = sprintf( '<img src="%s"', esc_url( $atts['src'] ) );
			break;
		default:
			$source = sprintf( '<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', esc_url( $atts['src'] ) );
>>>>>>> release/1.5.1
			break;
		}

		$out = sprintf( '
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
<<<<<<< HEAD
		$link = sprintf( '<a href="#" class="aesop-doc-reveal-%s"><span>document</span><br /> %s</a>', esc_attr( $unique ),$slide );
		$guts = sprintf( '<div id="aesop-doc-collapse-%s" style="display:none;" class="aesop-content">%s</div>',esc_attr( $unique ), $source );

		$out .= sprintf( '%s<aside %s class="aesop-component aesop-document-component aesop-content %s">%s%s%s%s</aside>%s',$actiontop, aesop_component_data_atts( 'document', $unique, $atts ), $classes, $actioninsidetop, $link, $guts, $actioninsidebottom, $actionbottom );

		return apply_filters( 'aesop_document_output', $out );
	}
}//end if
=======
		$link = sprintf( '<a href="#" class="aesop-doc-reveal-%s"><span>document</span><br /> %s</a>', esc_attr( $unique ), $slide );
		$guts = sprintf( '<div id="aesop-doc-collapse-%s" style="display:none;" class="aesop-content">%s</div>', esc_attr( $unique ), $source );

		$out .= sprintf( '%s<aside %s class="aesop-component aesop-document-component aesop-content %s">%s%s%s%s</aside>%s', $actiontop, aesop_component_data_atts( 'document', $unique, $atts ), $classes, $actioninsidetop, $link, $guts, $actioninsidebottom, $actionbottom );

		return apply_filters( 'aesop_document_output', $out );
	}
}//end if
>>>>>>> release/1.5.1
