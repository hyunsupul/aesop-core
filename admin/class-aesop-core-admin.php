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
	const version = '0.1';

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
		add_action('init', array($this,'register_shortcodes'));
		add_action('admin_init', array($this,'load'));


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


	public function load(){

		// Register Scripts
		wp_register_script( 'aesop-shortcodes-generator-script', AI_CORE_URL. '/admin/assets/js/generator.js', AI_CORE_VERSION, true);


        //Register Styles
		wp_register_style( 'aesop-shortcodes-generator', AI_CORE_URL. '/admin/assets/css/style.css', AI_CORE_VERSION, true);

		// Load styles and scripts for bad ass generator
		if ( is_admin() ) {
			global $pagenow;

			// Load styles and scripts for bad ass generator only on these pages
			$aesop_generator_includes_pages = array( 'post.php', 'edit.php', 'post-new.php', 'index.php' );
			if ( in_array( $pagenow, $aesop_generator_includes_pages ) ) {

				// Enqueue styles
				wp_enqueue_style( 'aesop-shortcodes-generator' );

				// Enqueue scripts
				wp_enqueue_script( 'aesop-shortcodes-generator-script' );
				wp_enqueue_script('aesop-shortcodes-selectbox');

				wp_enqueue_style( 'wp-color-picker' );
        		wp_enqueue_script('wp-color-picker');
			}
		}
	}

	public function register_shortcodes(){
		// Register Shortcodes
		foreach ( aesop_shortcodes() as $shortcode => $params ) {
			add_shortcode ( $this->aesop_compatibility_mode_prefix() . $shortcode, 'aesop_' . $shortcode . '_shortcode' );
		}

	}

	public function generator_button() {
		echo '<a href="#TB_inline?width=640&height=640&inlineId=aesop-generator-wrap" class="thickbox"><img src="' . AI_CORE_URL . '/admin/assets/img/media-icon.png" alt="" /></a>';
	}

	// Auto compatability mode but this really isn't doing shit anymore so we need to take it out on the next update
    public function aesop_compatibility_mode_prefix() {
		$prefix = ( get_option( 'aesop_compatibility_mode' ) == 'on' ) ? 'aesop_' : 'aesop_';
		return $prefix;
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
					<input type="hidden" name="aesop-compatibility-mode-prefix" id="aesop-compatibility-mode-prefix" value="<?php echo $this->aesop_compatibility_mode_prefix(); ?>" />

				</div>
			</div>
		</div>
		<?php
	}

}
