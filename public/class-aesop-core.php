<?php
/**
 * Aesop Core
 *
 * @package   Aesop_Core
 * @author    Nick Haskins <nick@aesopinteractive.com>
 * @license   GPL-2.0+
 * @link      http://aesopinteractive.com
 * @copyright 2014 Nick Haskins
 */

/**
 * Plugin class
 *
 * @package Aesop_Core
 * @author  Nick Haskins <nick@aesopinteractive.com>
 */
class Aesop_Core {

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// load component array
		require_once AI_CORE_DIR.'admin/includes/available.php';

		// load component helpers
		require_once AI_CORE_DIR.'public/includes/browserclasses.php';
		require_once AI_CORE_DIR.'public/includes/imgsizes.php';
		require_once AI_CORE_DIR.'public/includes/theme-helpers.php';

		// load optoins
		require_once AI_CORE_DIR.'public/includes/options.php';

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// we are loading this super late so that themes can override shortcode fucntions
		add_action( 'wp', array( $this, 'register_shortcodes' ), 10 );

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// remove strap br and p tags beore and after shortcodes
		add_filter( 'the_content', array( $this, 'shortcode_empty_paragraph_fix' ) );

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = 'aesop-core';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		$out = load_textdomain( $domain, trailingslashit( AI_CORE_DIR ). 'languages/' . $domain . '-' . $locale . '.mo' );

		return $out;
	}

	/**
	 * enqueue plugin files
	 *
	 * @since 1.0
	 *
	 * add_theme_support('aesop-component-styles');
	 * added to a themes functions.php will enqueue an additional css file with extended css support for all aesop components
	 *
	 * @since 1.0.9
	 *
	 */
	public function scripts() {

		wp_enqueue_script( 'jquery' );

		// if the define for unstyled all of aesop isn't set, continue
		if ( ! defined( 'AI_CORE_UNSTYLED' ) ) {

			wp_enqueue_style( 'ai-core-style', AI_CORE_URL.'/public/assets/css/ai-core.css', AI_CORE_VERSION, true );
			wp_style_add_data( 'ai-core-style', 'rtl', 'replace' );
			wp_enqueue_style( 'dashicons' );

		}

		// core script
		wp_enqueue_script( 'ai-core', AI_CORE_URL.'/public/assets/js/ai-core.min.js', array( 'jquery' ), AI_CORE_VERSION, true );

	}

	/**
	 * Load and register components
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {

		foreach ( glob( AI_CORE_DIR.'public/includes/components/*.php' ) as $component ) {
			require_once $component;
		}

		foreach ( aesop_shortcodes() as $shortcode => $params ) {
			add_shortcode( 'aesop_'.$shortcode, 'aesop_'.$shortcode.'_shortcode' );
		}

	}

	/**
	 * Prevent p and br tags from breaking shortcode layouts
	 *
	 * @since    1.0.0
	 */
	public function shortcode_empty_paragraph_fix( $content ) {

		$array = array(
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']'
		);

		// remove empty paragraphs and break tags next to shortcodes
		$content = strtr( $content, $array );

		// remove paragraphs with empty spaces
		$clean_content = str_replace( '<p>&nbsp;</p>', '', $content );

		return $clean_content;
	}
}
new Aesop_Core;