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
		if ( self::should_load_default_style( 'gallery' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/gallery.css' );
		}

		// parallax
		if ( self::should_load_default_style( 'parallax' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/parallax.css' );
		}

		// content
		if ( self::should_load_default_style( 'content' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/content.css' );
		}

		// image
		if ( self::should_load_default_style( 'image' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/image.css' );
		}

		// video
		if ( self::should_load_default_style( 'video' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/video.css' );
		}

		// audio
		if ( self::should_load_default_style( 'audio' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/audio.css' );
		}

		// quote
		if ( self::should_load_default_style( 'quote' ) ) {
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/quote.css' );
		}

		// collection
		if ( self::should_load_default_style( 'collection' ) ) {
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/collection.css' );
		}

		
		// chapter
		if ( self::should_load_default_style( 'chapter' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/chapter.css' );
		}

		// character
		if ( self::should_load_default_style( 'character' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/character.css' );
		}

		// document
		if ( self::should_load_default_style( 'document' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/document.css' );
		}

		// map
		if ( self::should_load_default_style( 'map' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/map.css' );
		}

		// timeline
		if ( self::should_load_default_style( 'timeline' ) ) 
		{
			$css .= file_get_contents( AI_CORE_DIR.'/public/assets/css/components/timeline.css' );

		}

		wp_add_inline_style( 'ai-core-style', $css );
	}
	
	/**
	 * Helper function used to see if a theme is known to have ASE supports
	 * @since 1.0.9
	 */
	
	public function known_ase_theme() {
		$name  	= wp_get_theme()->get('Name');
		$slug  	= sanitize_text_field( strtolower( preg_replace('/[\s_]/', '-', $name ) ) );
		$known_themes = array('jorgen', 'novella','genji','kerouac','fable','andersen','lore','zealot','worldview','canvas','myth','longform','longformpro',
		                      'jorgen-child', 'novella-child','genji-child','kerouac-child','fable-child','andersen-child','lore-child','zealot-child','worldview-child','canvas-child','myth-child','longform-child','longformpro-child');

		return in_array ( $slug , $known_themes );
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
		
		if ( empty( $supports ) || ! is_array( $supports ) ) {
			return false;
		}

		if ( in_array( $component, $supports[0] ) ) {;
			return true; }
		else {
			return false; }
	}
	
	/** A significant change in the logic determining if we should load the default styles for components */
	public function should_load_default_style($component = '') {
	    $supports = get_theme_support( 'aesop-component-styles' );
		
		if ( empty( $supports ) || ! is_array( $supports ) )  {
		    // if it's a known ase theme that supplies its own style, return false
		    if (self::known_ase_theme()) return false;
			
			// if post class has aesop-entry-content. If it's present this theme must support ASE
			$postClass = get_post_class(); 
			if (in_array ( 'aesop-entry-content', $postClass ) )
			{
			   return false;
			}
			
			// Test filter aesop_chapter_scroll_container. If it's present this theme must support ASE
			$dummy = apply_filters( 'aesop_chapter_scroll_container', 'dummy' );
			if ($dummy != 'dummy') {
			   return false;
			}

			return true;
		} else {
			if ( in_array( $component, $supports[0] ) ) {;
			    // the theme explicitly instructs to load the default style for this component
				return true; 
			}
			else {
				return false; 
			}
		}
	
	}
	
	

}
new aiCoreCSSMerger;