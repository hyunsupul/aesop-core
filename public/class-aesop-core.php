<?php
/**
 * Aesop Core
 *
 * @package   Aesop_Core
 * @author    Nick Haskins <email@nickhaskins.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Nick Haskins
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 *
 * @package Aesop_Core
 * @author  Nick Haskins <email@nickhaskins,com>
 */
class Aesop_Core {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'aesop-core';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		//load component array
		require_once( AI_CORE_DIR.'admin/includes/available.php');

		// load components
		require_once( AI_CORE_DIR.'public/includes/components/component-parallax.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-map.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-image.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-video.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-gallery.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-character.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-timeline.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-heading.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-cbox.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-audio.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-quote.php' );
		require_once( AI_CORE_DIR.'public/includes/components/component-collections.php' );

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action('init', array($this,'register_shortcodes'));
		add_action('wp_enqueue_scripts', array($this,'scripts'));
		add_action('wp_footer',array($this,'skrollr_init'), 99);
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 *@return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}

	/**
	 * Load component styles and scripts
	 *
	 * @since    1.0.0
	 */
	public function scripts(){

		wp_enqueue_script('jquery');

		wp_enqueue_style('ai-core-style', AI_CORE_URL.'/public/assets/css/style.css', AI_CORE_VERSION, true);
		wp_enqueue_script('ai-core', AI_CORE_URL.'/public/assets/js/ai-core.js', array('jquery'), AI_CORE_VERSION, true);
	}

	/**
	 * Register shortcode components
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes(){
		// Register Shortcodes
		foreach ( aesop_shortcodes() as $shortcode => $params ) {
			add_shortcode ( 'aesop_'.$shortcode, 'aesop_'.$shortcode.'_shortcode' );
		}

	}

	public function skrollr_init(){
		?><script>
	        skrollr.init({
	                forceHeight: false
	        });
		</script><?php
	}


}
