<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Lasso
 * @author    Nick Haskins <nick@aesopinteractive.com>
 * @license   GPL-2.0+
 * @link      http://aesopinteractive.com
 * @copyright 2015 Aesopinteractive LLC
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option('lasso_license_status');
delete_option('lasso_editor');
delete_option('lasso_updated_from');
delete_option('lasso_version');
