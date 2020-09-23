<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Aesop_Core
 * @author    Nick Haskins <nick@aesopinteractive.com>
 * @license   GPL-2.0+
 * @link      http://aesopinteractive.com
 * @copyright 2014 Nick Haskins
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'ai_core_version' );
delete_option( 'ase_upgraded_to' );
delete_option( 'ase_galleries_upgraded_to' );