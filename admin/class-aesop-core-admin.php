<?php
/**
 	* AI Core
 	*
 	* @package   Aesop_Core_Admin
 	* @author    Nick Haskins <nick@aesopinteractive.com>
 	* @license   GPL-2.0+
 	* @link      http://aesopinteractive.com
 	* @copyright 2013 Nick Haskins
*/
/**
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

		require_once( AI_CORE_DIR.'admin/includes/help.php' );
		require_once( AI_CORE_DIR.'admin/includes/notify.php' );
		require_once( AI_CORE_DIR.'admin/includes/components/component-map.php' );
        require_once( AI_CORE_DIR.'admin/includes/components/component-gallery.php' );

        if( !class_exists( 'CMB_Meta_Box' ) ) {
    		require_once( AI_CORE_DIR.'/admin/includes/custom-meta-boxes/custom-meta-boxes.php' );
    	}

		/*
		 	* Call $plugin_slug from public plugin class.
		 	*
		*/
		$plugin = Aesop_Core::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();


		/*
		 	* Define custom functionality.
		 	*
		*/
		add_action( 'media_buttons', array($this,'generator_button' ),100);
		add_action( 'admin_footer', array($this,'generator_popup' ));
		add_action('admin_enqueue_scripts', array($this,'admin_scripts'));
		add_filter( 'wp_fullscreen_buttons', array($this,'fs_generator_button' ));
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
	public function admin_scripts(){

		// Register Scripts
		wp_register_script( 'ai-core-script', AI_CORE_URL. '/admin/assets/js/generator.min.js', AI_CORE_VERSION, true);

        //Register Styles
		wp_register_style( 'ai-core-styles', AI_CORE_URL. '/admin/assets/css/style.css', AI_CORE_VERSION, true);

		// Load styles and scripts on areas that users will edit
		if ( is_admin() ) {

			global $pagenow;

			// Load styles and scripts for bad ass generator only on these pages
			$aesop_generator_includes_pages = array( 'post.php', 'edit.php', 'post-new.php', 'index.php' );
			if ( in_array( $pagenow, $aesop_generator_includes_pages ) ) {

				// Enqueue scripts
				wp_enqueue_script( 'ai-core-script' );

				include( AI_CORE_DIR . '/admin/includes/generator_blob.php' );

				wp_localize_script( 'ai-core-script', 'aesopshortcodes', aesop_shortcodes_blob() );
				wp_enqueue_script('aesop-shortcodes-selectbox');

				// color picker
				wp_enqueue_style( 'wp-color-picker' );
        		wp_enqueue_script('wp-color-picker');

        		// media uploader
				wp_enqueue_media();

				// Enqueue styles
				wp_enqueue_style( 'ai-core-styles' );
			}
		}
	}

	/**
	 	* Add the generator button next to the media upload button
	 	*
	 	* @since     1.0.0
	*/
	public function generator_button() {
		echo '<a href="#TB_inline?width=640&height=640&inlineId=aesop-generator-wrap" class="button thickbox aesop-add-story-component" title="Add Story Component"><span class="aesop-admin-button-icon dashicons dashicons-plus"></span> ', _e('Add Component', 'aesop-core') ,'</a>';
	}

	/**
	 	* Add the generator button in distraction free writing mode
	 	*
	 	* @since     0.9.96
	*/
	public function fs_generator_button($buttons){
		$buttons[] = self::generator_button();
		return $buttons;
	}
	/**
	 	* Draw the component generator
	 	*
	 	* @since     1.0.0
	*/
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

					<div id="aesop-generator-settings-outer">
						<div id="aesop-generator-settings">

							<div class="aesop-generator-empty">
								<h2><?php _e('Select a story component.','aesop-core');?></h2>
							</div>

						</div>
					</div>

					<input type="hidden" name="aesop-generator-url" id="aesop-generator-url" value="<?php echo AI_CORE_URL; ?>" />
					<input type="hidden" name="aesop-compatibility-mode-prefix" id="aesop-compatibility-mode-prefix" value="aesop_" />

				</div>
			</div>
		</div>
		<?php
	}
}
