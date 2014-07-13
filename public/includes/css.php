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
	*	merges styles inline into head
	*	@todo - this logic could stand to be shortened
	*
	*/
	function merger(){

		$css = '';

		// test support
		if ( current_theme_supports( 'aesop-component-styles', 'test' ) ) {

			$css = file_get_contents(AI_CORE_DIR.'/public/assets/css/components/test.css');

		}

		// test more support
		if ( current_theme_supports( 'aesop-component-styles', 'quote' ) ) {

			$css .= file_get_contents(AI_CORE_DIR.'/public/assets/css/components/quote.css');
		}

		wp_add_inline_style('ai-core-style', $css);
	}

}
new aiCoreCSSMerger;