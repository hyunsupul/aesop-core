<?php

/**
 * This file runs when tinymce is being put together by WordPress. If you
 * need to get a shortcode registered, this is where to do it. You need to
 * hook onto the filter 'jpb_visual_shortcodes'. The filter passes you an
 * array. Each element in the array should be an associative array with the
 * following required values:
 * 
 *   - shortcode : The name of the shortcode to replace.
 *   - image     : The url of the image to replace the shortcodes
 * 
 * The following values are optional:
 * 
 *   - command   : If this is provided, the shortcode image will also have
 *                 an edit button when the image is clicked. Clicking the
 *                 edit button will execute the tinyMCE command that this
 *                 value contains.
 * 
 * I'm not sure what the latest you can add these filters is, but if you
 * stick with either init or admin_init, you won't go wrong. See the example
 * below for an idea of how to send your shortcode's data through.
 */

$shortcodes = array(
	array(
		'shortcode' => 'aesop_gallery',
		'image' => 'http://placekitten.com/300/300', AI_CORE_DIR.'admin/includes/visualsc.php',
		'command' => 'mceaesop_gallery',
	),
	array(
		'shortcode' => 'aesop_document',
		'image' => 'http://placekitten.com/30/30', AI_CORE_DIR.'admin/includes/visualsc.php',
	),

);

// JSON-encode our shortcodes.
$shortcodes = json_encode( apply_filters( 'jpb_visual_shortcodes', $shortcodes ) );

// TinyMCE localization in WordPress asks us to send data as an escaped string
// in the variable `$strings'.
$strings = 'tinyMCE.addI18n("visualShortcode", {
shortcodes:' . $shortcodes . '
});';
