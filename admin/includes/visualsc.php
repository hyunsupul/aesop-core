<?php
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
		add_filter('mce_external_plugins', array($this, 'plugins'));
		add_filter('mce_external_languages', array($this, 'lang'));
	}

	/**
	 * Registers the shortcode images script as a tinyMCE plugin.
	 * 
	 * @since 0.1
	 * @param array $plugins An associative array of plugins
	 * @return array 
	 */
	function plugins($plugins) {
		$plugins['visualshortcodes'] = AI_CORE_URL.'/admin/assets/js/example.js';
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
	 * @see ./visualshortcodes/langs.php
	 * @param array $langs An associative array of language files
	 * @return array
	 */
	function lang($langs) {
		$langs['visualshortcodes'] = AI_CORE_DIR.'admin/includes/langs.php';
		return $langs;
	}

}

/**
 * Initialize plugin. We don't even want a global object.
 */
new JPB_Visual_Shortcodes();