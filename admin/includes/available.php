<?php

/**
 * List of available shortcodes
 */
if(!function_exists('aesop_shortcodes')){
	function aesop_shortcodes( $shortcode = null ) {
		$shortcodes = array(
			'parallax' 				=> array(
				'name' 				=> __('Aesop Parallax', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'img' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '#',
						'desc' 		=> __( 'Image', 'aesop-core' ),
					),
					'height' 		=> array(
						'values' 	=> array(),
						'default' 	=> '500',
						'desc' 		=> __('Height of Image Area', 'aesop-core' )
					),
					'parallaxbg' 	=> array(
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Parallax Background Image', 'aesop-core' )
					),
					'parallaxspeed' => array(
						'values' 	=> array(),
						'default' 	=> '0.3',
						'desc' 		=> __('Parallax Background Speed', 'aesop-core' )
					),
					'floater' 		=> array(
						'values'	=> array(
							__('true', 'aesop-core'),
							__('false', 'aesop-core')
						),
						'default' 	=> 'false',
						'desc' 		=> __('Enable Floating Element', 'aesop-core' )
					),
					'floatermedia' 	=> array(
						'values' 	=> array(),
						'default' 	=> 'false',
						'desc' 		=> __('Floater Media', 'aesop-core' )
					),
					'floaterposition' => array(
						'values' 	=> array(
							__('right', 'aesop-core'),
							__('left', 'aesop-core'),
							__('center', 'aesop-core')
						),
						'default' 	=> 'right',
						'desc' 		=> __('Position of Floater', 'aesop-core' )
					),
					'floaterdirection' => array(
						'values' 	=> array(
							__('up', 'aesop-core'),
							__('down', 'aesop-core')
						),
						'default' 	=> 'up',
						'desc' 		=> __('Parallax Direction of Floater', 'aesop-core' )
					),
					'captionposition' => array(
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
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Image Lightbox', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Caption', 'ba-shortcodes' ),
				'usage' 			=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Parallax styled image component with caption and optional lightbox.','aesop-core' )
			),
			'quote' 				=> array(
				'name' 				=> __('Aesop Quote Section', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
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
						'values'	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Height of Image Area', 'aesop-core' )
					),
				),
				'content' 			=> __( 'Quote Here', 'ba-shortcodes' ),
				'usage' 			=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Section quote area with background and color controls.','aesop-core' )
			),
			'image_back' 			=> array(
				'name' 				=> __('Image Back', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'img' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '#',
						'desc' 		=> __( 'Image URL', 'aesop-core' )
					),
					'color' 		=> array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#FFFFFF',
						'desc' 		=> __('Color of Text', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Your normal content goes here.', 'ba-shortcodes' ),
				'usage' 			=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates a background image section, with text in the middle.','aesop-core' )
			),
			'columns' 				=> array(
				'name' 				=> __('Magazine Columns', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'num' 			=> array(
						'values' 	=> array( ),
						'default' 	=> 2,
						'desc' 		=> __( 'Number of Columns', 'aesop-core' )
					)
				),
				'content' 			=> __( 'All your normal text goes here.', 'ba-shortcodes' ),
				'usage' 			=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Wraps your text in magazine style columns.','aesop-core' )
			),
			'chapter' 			=> array(
				'name' 				=> __('Chapter Heading', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'num' 			=> array(
						'values' 	=> array( ),
						'default' 	=> 1,
						'desc' 		=> __( 'What Chapter is This?', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Null here', 'ba-shortcodes' ),
				'usage' 			=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates the scroll to point, as a chapter heading.','aesop-core' )
			),
			'video' 				=> array(
				'name' 				=> __('Video Section', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'src' 			=> array(
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
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Video ID', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Null here', 'ba-shortcodes' ),
				'usage'				=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates a video section.','aesop-core' )
			),
			'map' 				=> array(
				'name' 				=> __('Map', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'height' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Height', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Null here', 'ba-shortcodes' ),
				'usage'				=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates a video section.','aesop-core' )
			),
			'character' 				=> array(
				'name' 				=> __('Character', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'img' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Character Image', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Null here', 'ba-shortcodes' ),
				'usage'				=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates a character.','aesop-core' )
			),
			'timeline' 				=> array(
				'name' 				=> __('Timeline', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'img' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Character Image', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Null here', 'ba-shortcodes' ),
				'usage'				=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates a character.','aesop-core' )
			)
		);

		if ( $shortcode )
			return apply_filters('aesop_avail_components', $shortcodes[$shortcode]);
		else
			return apply_filters('aesop_avail_components', $shortcodes);
	}
}

?>