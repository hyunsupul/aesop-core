<?php
/**
 * BLOCK: Basic
 *
 * Gutenberg Custom Block assets.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'ase_block_basic_editor_assets' );

/**
 * Enqueue the block's assets for the editor.
 *
 * `wp-blocks`: includes block type registration and related functions.
 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
 * `wp-i18n`: To internationalize the block's text.
 */
function ase_block_basic_editor_assets() {
	// Scripts.
	//image
	wp_enqueue_script(
		'ase-block-image', // Handle.
		plugins_url( 'image/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'image/block.js' ) // filemtime — Gets file modification time.
	);
	
	wp_enqueue_script(
		'ase-block-gallery', // Handle.
		plugins_url( 'gallery/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'gallery/block.js' ) // filemtime — Gets file modification time.
	);
	
	wp_enqueue_script(
		'ase-block-audio', // Handle.
		plugins_url( 'audio/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'audio/block.js' ) // filemtime — Gets file modification time.
	);
	
	wp_enqueue_script(
		'ase-block-quote', // Handle.
		plugins_url( 'quote/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'quote/block.js' ) // filemtime — Gets file modification time.
	);
	
	wp_enqueue_script(
		'ase-block-map', // Handle.
		plugins_url( 'map/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'map/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-mapmarker', // Handle.
		plugins_url( 'mapmarker/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'mapmarker/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-character', // Handle.
		plugins_url( 'character/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'character/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-video', // Handle.
		plugins_url( 'video/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'video/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-document', // Handle.
		plugins_url( 'document/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'document/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-timeline', // Handle.
		plugins_url( 'timeline/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'timeline/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-content', // Handle.
		plugins_url( 'content/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'content/block.js' ) // filemtime — Gets file modification time.
	);
	
	wp_enqueue_script(
		'ase-block-parallax', // Handle.
		plugins_url( 'parallax/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'parallax/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-chapter', // Handle.
		plugins_url( 'chapter/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'chapter/block.js' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_script(
		'ase-block-collection', // Handle.
		plugins_url( 'collection/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'collection/block.js' ) // filemtime — Gets file modification time.
	);

	// Styles.
	wp_enqueue_style(
		'ase-block-editor', // Handle.
		plugins_url( 'editor.css', __FILE__ ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // filemtime — Gets file modification time.
	);
} // End function gb_block_01_basic_editor_assets().


