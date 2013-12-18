<?php

/**
 * List of available shortcodes
 */
if(!function_exists('aesop_shortcodes')){
	function aesop_shortcodes( $shortcode = null ) {
		$shortcodes = array(
			'parallax' 			=> array(
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
			'quote' 			=> array(
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
			'content' 			=> array(
				'name' 				=> __('Content', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'width'			=> array(
						'values' 	=> array( ),
						'default' 	=> '100%',
						'desc' 		=> __( 'Width of Component', 'aesop-core' )
					),
					'columns' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Number of Columns', 'aesop-core' )
					),
					'position' 			=> array(
						'values' 	=> array(
							__('none','aesop-core'),
							__('left','aesop-core'),
							__('right','aesop-core')
						),
						'default' 	=> 'none',
						'desc' 		=> __( 'Text Block Alignment', 'aesop-core' )
					),
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
				'content' 			=> __( 'All your normal text goes here.', 'ba-shortcodes' ),
				'usage' 			=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Wraps your text in magazine style columns.','aesop-core' )
			),
			'chapter_heading' 	=> array(
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
			'audio' 			=> array(
				'name' 				=> __('Audio', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'src' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Audio URL', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Null here', 'ba-shortcodes' ),
				'usage'				=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates a character.','aesop-core' )
			),
			'video' 			=> array(
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
			'character' 		=> array(
				'name' 				=> __('Character', 'aesop-core'),
				'type' 				=> 'single',
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
			'timeline_stop' 	=> array(
				'name' 				=> __('Timeline Stop', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'num' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Year', 'aesop-core' )
					)
				),
				'content' 			=> __( 'Null here', 'ba-shortcodes' ),
				'usage'				=> '[aesop-social-icon type="twitter-icon" link="http://link.com" target="_blank"]',
				'desc' 				=> __( 'Creates a character.','aesop-core' )
			),
			'image' 			=> array(
				'name' 				=> __('Image', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'img' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image', 'aesop-core' )
					),
					'alt' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image ALT', 'aesop-core' )
					),
					'align' 			=> array(
						'values' 	=> array(
							__('left', 'aesop-core'),
							__('center', 'aesop-core'),
							__('right', 'aesop-core')
						),
						'default' 	=> 'center',
						'desc' 		=> __( 'Component Alignment', 'aesop-core' )
					),
					'captionposition' => array(
						'values' 	=> array(
							__('bottom', 'aesop-core'),
							__('top', 'aesop-core')
						 ),
						'default' 	=> 'bottom',
						'desc' 		=> __( 'Caption Position', 'aesop-core' )
					),
					'width' 			=> array(
						'values' 	=> array( ),
						'default' 	=> '300px',
						'desc' 		=> __( 'Image Width', 'aesop-core' )
					),
					'lightbox' 			=> array(
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Lightbox', 'aesop-core' )
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