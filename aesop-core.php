<?php
/**
 * Open source platform for storytellers.
 *
 *
 * @package   Aesop_Core
 * @author    Nick Haskins <email@nickhaskins.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Nick Haskins
 *
 * @wordpress-plugin
 * Plugin Name:       Aesop Core
 * Plugin URI:        http://aesopinteractive.com
 * Description:       Open source platform for storytellers.
 * Version:           1.0.0
 * Author:            Nick Haskins
 * Author URI:        http://nickhaskins.com
 * Text Domain:       aesop-core
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-aesop-core.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'Aesop_Core', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Aesop_Core', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'Aesop_Core', 'get_instance' ) );


// constnats
// Set some constants
define('AI_CORE_VERSION', '0.1');

define('AI_CORE_DIR', plugin_dir_path( __FILE__ ));
define('AI_CORE_URL', plugins_url( '', __FILE__ ));

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {


	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-aesop-core-admin.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/rename.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/welcome.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/dashboard.php' );

	add_action( 'plugins_loaded', array( 'Aesop_Core_Admin', 'get_instance' ) );

}
