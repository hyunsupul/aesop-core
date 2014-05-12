<?php
/**
* 	Open-sourced suite of tools to build interactive, long-form storytelling themes for Wordpress.
*
*
* 	@package   Aesop_Core
* 	@author    Nick Haskins <nick@aesopinteractive.com>
* 	@license   GPL-2.0+
* 	@link      http://aesopinteractive.com
* 	@copyright 2013 Nick Haskins
*
* 	@wordpress-plugin
* 	Plugin Name:       Aesop Story Engine
* 	Plugin URI:        http://aesopstories.com/story-engine
* 	Description:       Aesop Story Engine is an open-sourced suite of tools that empowers developers to build feature-rich, interactive, long-form storytelling themes for Wordpress.
* 	Version:           1.0.5
* 	Author:            Nick "Bearded Avenger" Haskins
* 	Author URI:        http://nickhaskins.com
* 	Text Domain:       aesop-core
* 	License:           GPL-2.0+
* 	License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* 	Domain Path:       /languages
* 	GitHub Plugin URI: https://github.com/bearded-avenger/aesop-core
*   Github Branch:     dev
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Set some constants
define('AI_CORE_VERSION', '1.0.5');
define('AI_CORE_DIR', plugin_dir_path( __FILE__ ));
define('AI_CORE_URL', plugins_url( '', __FILE__ ));

/*----------------------------------------------------------------------------*
* 	Public-Facing Functionality
*----------------------------------------------------------------------------*/

require_once( AI_CORE_DIR.'public/class-aesop-core.php' );

/*
* 	Register hooks that are fired when the plugin is activated or deactivated.
* 	When the plugin is deleted, the uninstall.php file is loaded.
*/
register_activation_hook( __FILE__, array( 'Aesop_Core', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Aesop_Core', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'Aesop_Core', 'get_instance' ) );

/*----------------------------------------------------------------------------*
* 	Dashboard and Administrative Functionality
*----------------------------------------------------------------------------*/

/*
* 	The code below is intended to to give the lightest footprint possible.
*/
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( AI_CORE_DIR.'admin/class-aesop-core-admin.php' );

	add_action( 'plugins_loaded', array( 'Aesop_Core_Admin', 'get_instance' ) );

}