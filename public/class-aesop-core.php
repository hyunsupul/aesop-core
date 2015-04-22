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
	 * Unique identifier
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

		// load component array
		require_once AI_CORE_DIR.'admin/includes/available.php';

		// load component helpers
		require_once AI_CORE_DIR.'public/includes/browserclasses.php';
		require_once AI_CORE_DIR.'public/includes/imgsizes.php';
		require_once AI_CORE_DIR.'public/includes/theme-helpers.php';

		// load optoins
		require_once AI_CORE_DIR.'public/includes/options.php';

		// additinoal css support
		require_once AI_CORE_DIR.'public/includes/css.php';

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// we are loading this super late so that themes can override shortcode fucntions
		add_action( 'wp', array( $this, 'register_shortcodes' ), 10 );

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// remove strap br and p tags beore and after shortcodes
		add_filter( 'the_content', array( $this, 'shortcode_empty_paragraph_fix' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    string slug variable.
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
	 * @param boolean $network_wide True if WPMU superadmin uses
	 *                                 "Network Activate" action, false if
	 *                                 WPMU is disabled or plugin is
	 *                                 activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				if ( is_array( $blog_ids ) ) {

					foreach ( $blog_ids as $blog_id ) {

						switch_to_blog( $blog_id );
						self::single_activate();
					}
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}//end if

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses
	 *                                 "Network Deactivate" action, false if
	 *                                 WPMU is disabled or plugin is
	 *                                 deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				if ( is_array( $blog_ids ) ) {

					foreach ( $blog_ids as $blog_id ) {

						switch_to_blog( $blog_id );
						self::single_deactivate();

					}
				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}//end if

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param integer $blog_id ID of the new blog.
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
		// set transietn for activation welcome
		set_transient( '_aesop_welcome_redirect', true, 30 );
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {

		// delete option used to check version for notification
		if ( false == delete_option( 'ai_core_version' ) ) {

			$out = '<div class="error"><p>';
			$out .= __( 'Doh! There was an issue deactivating Aesop. Try again perhaps?.', 'aesop-core' );
			$out .= '</p></div>';

			echo apply_filters( 'ai_deactivation_error_message', $out );

		}
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
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

			// core css file
			wp_enqueue_style( 'ai-core-style', AI_CORE_URL.'/public/assets/css/ai-core.css', AI_CORE_VERSION, true );
			wp_style_add_data( 'ai-core-style', 'rtl', 'replace' );

			// load dashicons if extended support
			if ( current_theme_supports( 'aesop-component-styles' ) ) {
				wp_enqueue_style( 'dashicons' );
			}
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
