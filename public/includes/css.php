<?php

/**
* Allows theme developers to conditionally load component styles with
* add_theme_support('aesop-component-styles', array('component-name'));
*
* @since 1.0.9
*
*/

class aiCoreCSSMerger {

	function __construct(){

		add_action('wp_enqueue_scripts', array($this,'merger'),11);
	}

	/**
	*
	*	conditionally load css depending on the component being called in add_theme_support
	*
	*/
	function merger(){

		$css = '';

		// test support
		if ( self::aesop_theme_supports('test') ) {

			$css .= file_get_contents(AI_CORE_DIR.'/public/assets/css/components/test.css');

		}

		// test quote support
		if ( self::aesop_theme_supports('quote') ) {

			$css .= file_get_contents(AI_CORE_DIR.'/public/assets/css/components/quote.css');
		}

		wp_add_inline_style('ai-core-style', $css);
	}

	/**
	*
	*	Helper function used in seeing if a particular theme has added extended styles support
	* 	@param $component - string - name of component
	*/

	static function aesop_theme_supports( $component = '' ) {

		$supports = get_theme_support( 'aesop-component-styles');

		// bail if no support
		if ( empty( $supports ) || !is_array($supports) )
			return;

		if ( false !== strpos( $supports[0][0], $component ) )
			return true;
		else
			return false;

	}

}
new aiCoreCSSMerger;