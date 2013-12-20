<?php

/**
 * List of available shortcodes
 */
if(!function_exists('aesop_shortcodes')){
	function aesop_shortcodes( $shortcode = null ) {
		$shortcodes = array(
			'image' 			=> array(
				'name' 				=> __('Image', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'width' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> 'content',
						'desc' 		=> __( 'Component Width', 'aesop-core' )
					),
					'imgwidth' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '300px',
						'desc' 		=> __( 'Image Width', 'aesop-core' )
					),
					'img' 			=> array(
						'type'		=> 'image_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image URL', 'aesop-core' )
					),
					'alt' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image ALT', 'aesop-core' )
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('left', 'aesop-core'),
							__('center', 'aesop-core'),
							__('right', 'aesop-core')
						),
						'default' 	=> 'center',
						'desc' 		=> __( 'Image Alignment', 'aesop-core' )
					),
					'offset' 		=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image Offset', 'aesop-core' )
					),
					'captionposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('bottom', 'aesop-core'),
							__('top', 'aesop-core')
						 ),
						'default' 	=> 'bottom',
						'desc' 		=> __( 'Caption Position', 'aesop-core' )
					),
					'lightbox' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Lightbox', 'aesop-core' )
					),

				),
				'content' 			=> __( 'Optional Caption', 'ba-shortcodes' ),
				'desc' 				=> __( 'Creates an image component with caption, alignment, and lightbox options.','aesop-core' )
			),
			'character' 			=> array(
				'name' 				=> __('Character', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'width' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> 'content',
						'desc' 		=> __( 'Component Width', 'aesop-core' )
					),
					'img' 			=> array(
						'type'		=> 'image_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Character Image', 'aesop-core' )
					),
					'name' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Character Name', 'aesop-core' )
					),
					'position' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Alignment', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Character text.', 'ba-shortcodes' ),
				'desc' 				=> __( 'Creates a character that can be positioned to the left or right of your story.','aesop-core' )
			),
			'quote' 			=> array(
				'name' 				=> __('Aesop Quote Section', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'width' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '100%',
						'desc' 		=> __( 'Component Width', 'aesop-core' )
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Alignment', 'aesop-core' )
					),
					'background' 	=> array(
						'values' 	=> array( ),
						'type'		=> 'color',
						'default' 	=> '#282828',
						'desc' 		=> __( 'Hex Color of Background', 'aesop-core' )
					),
					'text'			 => array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#FFFFFF',
						'desc' 		=> __('Hex Color of Text', 'aesop-core' )
					),
					'height' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Height of Image Area', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Enter quote here.', 'ba-shortcodes' ),
				'desc' 				=> __( 'Section quote area with background and color controls.','aesop-core' )
			),
			'content' 			=> array(
				'name' 				=> __('Content', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'width'			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '100%',
						'desc' 		=> __( 'Width of Component', 'aesop-core' )
					),
					'columns' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Number of Columns', 'aesop-core' )
					),
					'position' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('none','aesop-core'),
							__('left','aesop-core'),
							__('right','aesop-core')
						),
						'default' 	=> 'none',
						'desc' 		=> __( 'Text Block Alignment', 'aesop-core' )
					),
					'img' 			=> array(
						'type'		=> 'image_upload',
						'values' 	=> array( ),
						'default' 	=> '#',
						'desc' 		=> __( 'Image URL', 'aesop-core' )
					),
					'imgrepeat' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('no-repeat', 'aesop-core'),
							__('repeat', 'aesop-core'),
							__('repeat-vertical', 'aesop-core'),
							__('repeat-horizontal', 'aesop-core')
						),
						'default' 	=> 'no-repeat',
						'desc' 		=> __( 'Image Repeat', 'aesop-core' )
					),
					'imgposition' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image Position', 'aesop-core' )
					),
					'color' 		=> array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#FFFFFF',
						'desc' 		=> __('Color of Text', 'aesop-core' )
					)
				),
				'content' 			=> __( 'All your normal text goes here.', 'ba-shortcodes' ),
				'desc' 				=> __( 'Multiple use content area with options for background image, background color, and magazine style columns.','aesop-core' )
			),
			'chapter' 	=> array(
				'name' 				=> __('Chapter Heading', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'num' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> 1,
						'desc' 		=> __( 'What Chapter is This?', 'aesop-core' )
					)
				),
				'desc' 				=> __( 'Creates the scroll to point, as a chapter heading.','aesop-core' )
			),
			'parallax' 			=> array(
				'name' 				=> __('Parallax Image', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'img' 			=> array(
						'type'		=> 'image_upload',
						'values' 	=> array( ),
						'default' 	=> '#',
						'desc' 		=> __( 'Image', 'aesop-core' ),
					),
					'height' 		=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '500',
						'desc' 		=> __('Height of Image Area', 'aesop-core' )
					),
					'parallaxbg' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Parallax Background Image', 'aesop-core' )
					),
					'parallaxspeed' => array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '0.3',
						'desc' 		=> __('Parallax Background Speed', 'aesop-core' )
					),
					'floater' 		=> array(
						'type'		=> 'text',
						'values'	=> array(
							__('true', 'aesop-core'),
							__('false', 'aesop-core')
						),
						'default' 	=> 'false',
						'desc' 		=> __('Enable Floating Element', 'aesop-core' )
					),
					'floatermedia' 	=> array(
						'type'		=> 'image_upload',
						'values' 	=> array(),
						'default' 	=> 'false',
						'desc' 		=> __('Floater Media', 'aesop-core' )
					),
					'floaterposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('right', 'aesop-core'),
							__('left', 'aesop-core'),
							__('center', 'aesop-core')
						),
						'default' 	=> 'right',
						'desc' 		=> __('Position of Floater', 'aesop-core' )
					),
					'floaterdirection' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('up', 'aesop-core'),
							__('down', 'aesop-core')
						),
						'default' 	=> 'up',
						'desc' 		=> __('Parallax Direction of Floater', 'aesop-core' )
					),
					'captionposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('bottom-left', 'aesop-core'),
							__('bottom-right', 'aesop-core'),
							__('top-left', 'aesop-core'),
							__('top-right', 'aesop-core')
						),
						'default' 	=> 'bottom-left',
						'desc' 		=> __('Caption Position', 'aesop-core' )
					),
					'lightbox' 		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Image Lightbox', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Optional Caption', 'ba-shortcodes' ),
				'desc' 				=> __( 'Parallax styled image component with caption and optional lightbox.','aesop-core' )
			),
			'audio' 			=> array(
				'name' 				=> __('Audio', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'src' 			=> array(
						'type'		=> 'audio_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Audio URL', 'aesop-core' )
					)
				),
				'desc' 				=> __( 'Creates an audio player with your own audio.','aesop-core' )
			),
			'video' 			=> array(
				'name' 				=> __('Video Section', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'width' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '100%',
						'desc' 		=> __( 'Component Width', 'aesop-core' )
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> 'center',
						'desc' 		=> __( 'Alignment', 'aesop-core' )
					),
					'src' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('vimeo', 'aesop-core'),
							__('youtube', 'aesop-core'),
							__('kickstarter', 'aesop-core'),
							__('viddler', 'aesop-core'),
							__('dailymotion', 'aesop-core')
						),
						'default' 	=> 'vimeo',
						'desc' 		=> __('Video Source', 'aesop-core' )
					),
					'id' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Video ID', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Optional caption', 'ba-shortcodes' ),
				'desc' 				=> __( 'Responsive video component with alignment and optional caption.','aesop-core' )
			),
			'map' 				=> array(
				'name' 				=> __('Map', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'height' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Height', 'aesop-core' )
					)
				),
				'desc' 				=> __( 'Creates the basic map component. Use the Map Locations edit boxes when writing your story to add locations.','aesop-core' )
			),
			'timeline_stop' 	=> array(
				'name' 				=> __('Timeline Stop', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'num' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Date', 'aesop-core' )
					)
				),
				'desc' 				=> __( 'Enter a number such as 2007, and a small timeline will be displayed with scroll to points. This works similar to the chapter heading.','aesop-core' )
			)
		);

		if ( $shortcode )
			return apply_filters('aesop_avail_components', $shortcodes[$shortcode]);
		else
			return apply_filters('aesop_avail_components', $shortcodes);
	}
}

?>