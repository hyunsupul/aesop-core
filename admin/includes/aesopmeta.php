<?php
/**
* create custom meta boxes for project meta
*
* @since version 1.0
* @param null
* @return custom meta boxes
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'cmb_meta_boxes', 'ba_aesop_metaboxes' );
function ba_aesop_metaboxes( array $meta_boxes ) {

	$opts = array(
		array(
			'id'             => 'ba_aesop_gallery_sc',
			'name'           => 'Insert Gallery Shortcode',
			'type'           => 'text',
		),

	);

	$meta_boxes[] = array(
		'title' => __('Aesop', 'aesop-core'),
		'pages' => 'post',
		'fields' => $opts
	);

	return $meta_boxes;

}

