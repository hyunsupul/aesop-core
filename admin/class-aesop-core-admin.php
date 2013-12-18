<?php
/**
 * Plugin Name.
 *
 * @package   Aesop_Core_Admin
 * @author    Nick Haskins <email@nickhaskins.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Nick Haskins
 */

/**
 *
 * @package Aesop_Core_Admin
 * @author  Your Name <email@example.com>
 */
class Aesop_Core_Admin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const version = '1.0';

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

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */
		require_once( AI_CORE_DIR.'admin/includes/nextpagebtn.php' );
		require_once( AI_CORE_DIR.'admin/includes/storytab.php' );
		require_once( AI_CORE_DIR.'admin/includes/components/component-map.php' );
        require_once( AI_CORE_DIR.'admin/includes/components/component-gallery.php' );

        if( !class_exists( 'CMB_Meta_Box' ) ) {
    		require_once( AI_CORE_DIR.'/admin/includes/custom-meta-boxes/custom-meta-boxes.php' );
    	}

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 * @TODO:
		 *
		 * - Rename "Aesop_Core" to the name of your initial plugin class
		 *
		 */
		$plugin = Aesop_Core::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();


		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'media_buttons', array($this,'generator_button' ),100);
		add_action( 'admin_footer', array($this,'generator_popup' ));
		add_action('admin_enqueue_scripts', array($this,'admin_scripts'));
	}	

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function admin_scripts(){

		// Register Scripts
		wp_register_script( 'ai-core-script', AI_CORE_URL. '/admin/assets/js/generator.min.js', AI_CORE_VERSION, true);

        //Register Styles
		wp_register_style( 'ai-core-styles', AI_CORE_URL. '/admin/assets/css/style.css', AI_CORE_VERSION, true);

		// Load styles and scripts
		if ( is_admin() ) {

			global $pagenow;

			// Enqueue styles
			wp_enqueue_style( 'ai-core-styles' );

			// Load styles and scripts for bad ass generator only on these pages
			$aesop_generator_includes_pages = array( 'post.php', 'edit.php', 'post-new.php', 'index.php' );
			if ( in_array( $pagenow, $aesop_generator_includes_pages ) ) {

				// Enqueue scripts
				wp_enqueue_script( 'ai-core-script' );
				wp_enqueue_script('aesop-shortcodes-selectbox');

				wp_enqueue_style( 'wp-color-picker' );
        		wp_enqueue_script('wp-color-picker');

        		// media uploader
				wp_enqueue_media();
			}
		}
	}

	public function generator_button() {
		echo '<a href="#TB_inline?width=640&height=640&inlineId=aesop-generator-wrap" class="button thickbox" title="Add Story Component"><span class="aesop-admin-button-icon dashicons dashicons-plus"></span> Add Component</a>';
	}

	public function generator_popup() {
		?>
		<div id="aesop-generator-wrap" style="display:none">
			<div id="aesop-generator" class="aesop-generator-inner-wrap">
				<div id="aesop-generator-shell">


					<div class="aesop-select-wrap fix">
						<select name="aesop-select" class="aesop-generator" id="aesop-generator-select">

							<?php
							foreach ( aesop_shortcodes() as $name => $shortcode ) {
							?>
							<option value="<?php echo $name; ?>"><?php echo strtoupper( $name ); ?>:&nbsp;&nbsp;<?php echo $shortcode['desc']; ?></option>
							<?php
							}
							?>
						</select>
					</div>

					<div id="aesop-generator-settings-outer"><div id="aesop-generator-settings"></div></div>

					<input type="hidden" name="aesop-generator-url" id="aesop-generator-url" value="<?php echo AI_CORE_URL; ?>" />
					<input type="hidden" name="aesop-compatibility-mode-prefix" id="aesop-compatibility-mode-prefix" value="aesop_" />

				</div>
			</div>
		</div>
		<?php
	}

}
