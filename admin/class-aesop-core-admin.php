<?php
/**
 * AI Core
 *
 * @package   Aesop_Core_Admin
 * @author    Nick Haskins <nick@aesopinteractive.com>
 * @license   GPL-2.0+
 * @link      http://aesopinteractive.com
 * @copyright 2014 Nick Haskins
 */

/**
 *
 *
 * @package Aesop_Core_Admin
 * @author  Nick Haskins <nick@aesopinteractive.com>
 */
class Aesop_Core_Admin {


	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		require_once AI_CORE_DIR . 'admin/includes/class.welcome.php';
		require_once AI_CORE_DIR . 'admin/includes/help.php';
		require_once AI_CORE_DIR . 'admin/includes/notify.php';
		require_once AI_CORE_DIR . 'admin/includes/components/component-map.php';
		require_once AI_CORE_DIR . 'admin/includes/components/component-gallery.php';


		/*
		*  Define custom functionality.
		*
		*/
		add_action( 'media_buttons', array( $this, 'generator_button' ), 100 );
		add_action( 'admin_footer', array( $this, 'generator_popup' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_filter( 'mce_css', array( $this, 'aesop_editor_styles' ) );
		add_filter( 'wp_fullscreen_buttons', array( $this, 'fs_generator_button' ) );
		add_filter( 'mce_external_plugins', array( $this, 'tinymce_plugin' ) );
		add_action( 'after_wp_tiny_mce', array( $this, 'ase_after_wp_tiny_mce' ) );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_meta' ), 10, 2 );
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
	 * Load scripts and styles for component generator
	 *
	 * @since     1.0.0
	 */
	public function admin_scripts() {

		// Register Scripts
		wp_register_script( 'ai-core-script', AI_CORE_URL . '/admin/assets/js/generator.min.js', AI_CORE_VERSION,
			true );

		// Register Styles
		wp_register_style( 'ai-core-styles', AI_CORE_URL . '/admin/assets/css/aesop-admin.css', AI_CORE_VERSION, true );

		// Load styles and scripts on areas that users will edit
		if ( is_admin() ) {

			global $pagenow;

			// Load styles and scripts for bad ass generator only on these pages
			$aesop_generator_includes_pages = array( 'post.php', 'edit.php', 'post-new.php', 'index.php' );
			if ( in_array( $pagenow, $aesop_generator_includes_pages ) ) {

				// Enqueue scripts
				wp_enqueue_script( 'ai-core-script' );

				include AI_CORE_DIR . '/admin/includes/generator_blob.php';

				wp_localize_script( 'ai-core-script', 'aesopshortcodes', aesop_shortcodes_blob() );
				wp_enqueue_script( 'aesop-shortcodes-selectbox' );

				// color picker
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );

				// media uploader
				wp_enqueue_media();

				// Enqueue styles
				wp_enqueue_style( 'ai-core-styles' );

				// 3rd party add-ons hook in to set icon in generator with css
				do_action( 'aesop_admin_styles' );
			}//end if
		}//end if
	}

	/**
	 * Add the generator button in distraction free writing mode
	 *
	 * @since     0.9.96
	 */
	public function fs_generator_button( $buttons ) {
		$buttons[] = self::generator_button();

		return $buttons;
	}

	/**
	 * Add the generator button next to the media upload button
	 *
	 * @since     1.0.0
	 */
	public function generator_button() {

		$getbutton = sprintf( '<a href="#aesop-generator-wrap" class="button aesop-add-story-component" title="Add Story Component"><span class="aesop-admin-button-icon dashicons dashicons-plus"></span> %s</a>',
			__( 'Add Component', 'aesop-core' ) );

		$button = apply_filters( 'aesop_generator_button', $getbutton );

		echo $button;

	}

	/**
	 * Add the tinymce plugin recognize specific shortcodes
	 *
	 * @since     1.1.0
	 */
	public function tinymce_plugin( $plugins_array ) {
		$plugins = array( 'aiview', 'noneditable' );

		foreach ( $plugins as $plugin ) {
			$plugins_array[ $plugin ] = plugins_url( 'assets/js/tinymce/', __FILE__ ) . $plugin . '/plugin.min.js';
		}

		return $plugins_array;
	}

	public function aesop_editor_styles( $mce_css ) {
		$mce_css .= ', ' . plugins_url( 'assets/css/tinymce/custom-editor-style.css', __FILE__ );

		return $mce_css;
	}

	/**
	 * Draw the component generator
	 *
	 * @since     1.0.0
	 */
	public function generator_popup() {

		global $pagenow;

		$aesop_generator_includes_pages = apply_filters( 'aesop_generator_loads_on',
			array( 'post.php', 'edit.php', 'post-new.php', 'index.php' ) );

		if ( in_array( $pagenow, $aesop_generator_includes_pages ) ) { ?>

			<div id="aesop-generator-wrap">
				<div id="aesop-generator" class="aesop-generator-inner-wrap">
					<a class="media-modal-close aesop-close-modal" href="#"><span class="media-modal-icon"><span
								class="screen-reader-text">Close media panel</span></span></a>

					<div id="aesop-generator-shell">


						<div class="aesop-select-wrap fix aesop-generator-left">
							<select name="aesop-select" class="aesop-generator" id="aesop-generator-select">

								<?php
								foreach ( aesop_shortcodes() as $name => $shortcode ) {
									?>
									<option value="<?php echo $name; ?>"><?php echo str_replace( '_', ' ',
											strtoupper( $name ) ); ?></option>
									<?php
								}
								?>
							</select>

							<?php if ( ! defined( 'AI_CORE_WATERMARK' ) ) {
								echo self::messages();
							} ?>
						</div>

						<div id="aesop-generator-settings-outer" class="aesop-generator-right">
							<div id="aesop-generator-settings">

								<div class="aesop-generator-empty">
									<h2><?php _e( 'Select a story component.', 'aesop-core' ); ?></h2>
								</div>

							</div>
						</div>

						<input type="hidden" name="aesop-generator-url" id="aesop-generator-url"
						       value="<?php echo AI_CORE_URL; ?>"/>
						<input type="hidden" name="aesop-compatibility-mode-prefix" id="aesop-compatibility-mode-prefix"
						       value="aesop_"/>

					</div>
				</div>
			</div>
		<?php }//end if
	}

	/**
	 *
	 *
	 * @since 1.1
	 * @return string of random messages used for watermark
	 *
	 */
	private function messages() {

		$message = array(
			__( 'Product of <span><a href="http://aesopstoryengine.com">AESOP INTERACTIVE LLC</a></span>',
				'aesop-core' ),
			__( '<span><a href="http://aesopstoryengine.com/donate">Support new features and bug fixes</a></span> of Aesop Story Engine',
				'aesop-core' ),
			__( 'Story Beautiful? <span><a href="http://aesopstoryengine.com/donate">Thank the developer</a></span>.',
				'aesop-core' )
		);

		return '<p class="aesop-generator-mark">' . $message[ array_rand( $message ) ] . '</p>';

	}

	/**
	 *
	 *
	 * @since 1.3
	 * @return handle some stuff after tiny mce is loaded
	 *
	 */
	public function ase_after_wp_tiny_mce() {

		?>

		<script type="text/javascript">
			function mceAlive() {
				if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
					var ed = tinymce.activeEditor;
					var sc_attr = jQuery(ed.contentDocument).find('.aesop-component').data('aesop-sc');
					sc_attr = window.decodeURIComponent(sc_attr);
					// let's check to see if sticky is on
					if (sc_attr.match(/sticky=['"](top|left|right|bottom)['"]/)) {
						var sticky_location = sc_attr.match(/sticky=['"](top|left|right|bottom)['"]/)[1];
						//console.log( 'The chosen sticky location is: ' + sticky_location );

						if ('off' !== sticky_location) {
							jQuery('#aesop-generator-wrap li.map_marker').fadeIn().css('display', 'inline-block');
						}

					}

				} else {
					setTimeout(mceAlive, 15);
				}
			}
			mceAlive();
		</script>

		<?php

	}

	/**
	 * Add some custom links to the plugins.php page for Aesop
	 *
	 * @since 1.3
	 *
	 * @param unknown $links array array of new links
	 * @param unknown $file
	 *
	 * @return array new array of links for our plugin listing on plugins.php
	 */
	public function plugin_meta( $links, $file ) {

		if ( strpos( $file, 'aesop-core.php' ) !== false ) {

			$new_links = array(
				'<a href="http://aesopstoryengine.com/help" target="_blank">Documentation</a>',
				'<a href="http://aesopstoryengine.com/donate" target="_blank">Donate</a>'
			);

			$links = array_merge( $links, $new_links );
		}

		return $links;
	}
}
