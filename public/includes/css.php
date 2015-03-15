<?php

/**
 * Allows theme developers to conditionally load component styles with
 * add_theme_support('aesop-component-styles', array('parallax', 'image', 'quote', 'gallery', 'content', 'video', 'audio', 'collection', 'chapter', 'document', 'character', 'map', 'timeline' ) );
 *
 * @since 1.0.9
 *
 */

class aiCoreCSSMerger {

	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'merger' ), 11 );
	}

	/**
	 * conditionally load css depending on the component being called in add_theme_support
	 *   wp_add_inline_styles used to load css in head
	 *
	 * @since 1.0.9
	 *
	 */
	public function merger() {

		$css = '';

		// gallery
		if ( self::aesop_theme_supports( 'gallery' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/gallery.css' );

		}

		// parallax
		if ( self::aesop_theme_supports( 'parallax' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/parallax.css' );

		}

		// content
		if ( self::aesop_theme_supports( 'content' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/content.css' );

		}

		// image
		if ( self::aesop_theme_supports( 'image' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/image.css' );

		}

		// video
		if ( self::aesop_theme_supports( 'video' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/video.css' );

		}

		// audio
		if ( self::aesop_theme_supports( 'audio' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/audio.css' );

		}

		// quote
		if ( self::aesop_theme_supports( 'quote' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/quote.css' );

		}

		// collection
		if ( self::aesop_theme_supports( 'collection' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/collection.css' );

		}

		// chapter
		if ( self::aesop_theme_supports( 'chapter' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/chapter.css' );

		}

		// character
		if ( self::aesop_theme_supports( 'character' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/character.css' );

		}

		// document
		if ( self::aesop_theme_supports( 'document' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/document.css' );

		}

		// map
		if ( self::aesop_theme_supports( 'map' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/map.css' );

		}

		// timeline
		if ( self::aesop_theme_supports( 'timeline' ) ) {

			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/timeline.css' );

		}

		wp_add_inline_style( 'ai-core-style', $css );
	}

	/**
	 * Helper function used in seeing if a particular theme has added extended styles support
	 *   For example, say a theme has add_theme_support('whatever', array('thing_one', 'thing_two'))
	 *
	 *   aesop_theme_supports( $component ) is used to see if the particular arg within an array exists
	 *
	 * @param unknown $component - array of components
	 * @since 1.0.9
	 */

	public function aesop_theme_supports( $component = '' ) {

		$supports = get_theme_support( 'aesop-component-styles' );

		// bail if no support
		if ( empty( $supports ) || ! is_array( $supports ) ) {
			return; }

		if ( in_array( $component, $supports[0] ) ) {
			return true; }
		else {
			return false; }

	}

}
new aiCoreCSSMerger;