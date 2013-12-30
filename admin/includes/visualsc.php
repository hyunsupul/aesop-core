<?php

// major props to Visual Shortcodes as thats where msot of this code came from
class JPB_Visual_Shortcodes {

	/**
	 * Class constructor
	 * 
	 * This function adds all the necessary hooks and actions to make our
	 * plugin function
	 * 
	 * @since 0.1
	 */
	function __construct() {

		if ( get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array($this, 'plugins'));
			add_filter('mce_external_languages', array($this, 'lang'));
		}
	}

	function plugins($plugins) {
		$plugins['visualshortcodes'] = AI_CORE_URL.'/admin/assets/js/aesopmce.min.js';
		return $plugins;
	}

	/**
	 * Registers this plugin's language pack.
	 * 
	 * We're going to hijack the localization tool that tinymce uses so that
	 * we can send namespaced data to TinyMCE in the localization array. This
	 * data will be telling the plugin which shortcodes to replace and which
	 * images to use to replace them. If a shortcode also has a tinymce command
	 * that should be executable when clicked, that can also be registered
	 * through this method.
	 * 
	 * More information is in the documentation in visualshortcodes/langs.php
	 *
	 * @since 0.1
	 * @param array $langs An associative array of language files
	 * @return array
	 */
	function lang($langs) {
		$langs['visualshortcodes'] = AI_CORE_DIR.'admin/includes/mcelangs.php';
		return $langs;
	}

}

/**
 * Initialize plugin. We don't even want a global object.
 */
new JPB_Visual_Shortcodes();