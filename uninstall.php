<?php
/**
 	* Fired when the plugin is uninstalled.
 	*
 * @package   Aesop_Core
 * @author    Nick Haskins <nick@aesopinteractive.com>
 * @license   GPL-2.0+
 * @link      http://aesopinteractive.com
 * @copyright 2013 Nick Haskins
*/

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}