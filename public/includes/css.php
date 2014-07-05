<?php

class aiCoreCSSMerger {
	function __construct(){

		add_action('wp_enqueue_scripts', array($this,'merger'),11);
	}

	function merger(){

		$css = '';

		if ( current_theme_supports('aesop-component-styles', 'test') ) {

			$css = file_get_contents(AI_CORE_DIR.'/public/assets/css/test.css');

		}

		if ( current_theme_supports('aesop-component-styles', 'quote') ) {

			$css .= file_get_contents(AI_CORE_DIR.'/public/assets/css/quote.css');
		}

		wp_add_inline_style('ai-core-style', $css);
	}
}
new aiCoreCSSMerger;