<?php

/**
 	* 	Master list of all available shortcodes and attributes
 	*
 	* 	@since    1.0.0
 */

if(!function_exists('aesop_shortcodes')){
	function aesop_shortcodes( $shortcode = null ) {
		$shortcodes = array(
			'image' 			=> array(
				'name' 				=> __('Image', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'img' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image URL', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'imgwidth' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '300px',
						'desc' 		=> __( 'Image Width', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Caption', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'credit' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image Credit', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'alt' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image ALT', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('left', 'aesop-core'),
							__('right', 'aesop-core'),
							__('center', 'aesop-core')
						),
						'default' 	=> 'left',
						'desc' 		=> __( 'Image Alignment', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'offset' 		=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image Offset', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'captionposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('left', 'aesop-core'),
							__('right', 'aesop-core'),
							__('center', 'aesop-core')
						 ),
						'default' 	=> 'left',
						'desc' 		=> __( 'Caption Position', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'lightbox' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Lightbox', 'aesop-core' ),
						'tip'		=> 'sup'
					),

				),
				'desc' 				=> __( 'Creates an image component with caption, alignment, and lightbox options.','aesop-core' )
			),
			'character' 			=> array(
				'name' 				=> __('Character', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'img' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Character Image', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'name' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Character Name', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Caption', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('left', 'aesop-core'),
							__('right', 'aesop-core')
						),
						'default' 	=> 'left',
						'desc' 		=> __( 'Alignment', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'width' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Width (px or %)', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'desc' 				=> __( 'Creates a character that can be positioned to the left or right of your story.','aesop-core' )
			),
			'quote' 			=> array(
				'name' 				=> __('Aesop Quote Section', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'width' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '100%',
						'desc' 		=> __( 'Component Width', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'background' 	=> array(
						'values' 	=> array( ),
						'type'		=> 'color',
						'default' 	=> '#282828',
						'desc' 		=> __( 'Background Color', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'img' 	=> array(
						'values' 	=> array( ),
						'type'		=> 'media_upload',
						'default' 	=> '',
						'desc' 		=> __( 'Optional Background Image', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'text'			 => array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#FFFFFF',
						'desc' 		=> __('Text Color', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'height' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Height of Image Area', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('left', 'aesop-core'),
							__('center', 'aesop-core'),
							__('right', 'aesop-core')
						),
						'default' 	=> 'center',
						'desc' 		=> __( 'Alignment', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'size' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('2', 'aesop-core'),
							__('3', 'aesop-core'),
							__('4', 'aesop-core')
						),
						'default' 	=> '2',
						'desc' 		=> __( 'Quote Size', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'parallax' 		=> array(
						'type'		=> 'text',
						'values'	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Enable Quote Parallax', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'offset' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> 300,
						'desc' 		=> __('If using parallax, starting offset.', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'speed' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> 8,
						'desc' 		=> __('Speed of parallax movement. Lower is faster.', 'aesop-core' ),
						'tip'		=> 'sup'

					),
					'direction' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('up', 'aesop-core'),
							__('down', 'aesop-core'),
							__('left', 'aesop-core'),
							__('right', 'aesop-core')
						),
						'default' 	=> 'up',
						'desc' 		=> __('Parallax Direction of Quote', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'quote' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> '',
						'desc' 		=> __('The quote', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'cite' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Cite (optional)', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'desc' 				=> __( 'Section quote area with background and color controls.','aesop-core' )
			),
			'content' 			=> array(
				'name' 				=> __('Content', 'aesop-core'),
				'type' 				=> 'wrap',
				'atts' 				=> array(
					'color' 		=> array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#FFFFFF',
						'desc' 		=> __('Color of Text', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'background' 		=> array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#333333',
						'desc' 		=> __('Background Color', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'width'			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '100%',
						'desc' 		=> __( 'Width of Component', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'height'			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Height of Component (optional)', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'columns' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Number of Columns', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'position' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('none','aesop-core'),
							__('left','aesop-core'),
							__('right','aesop-core')
						),
						'default' 	=> 'none',
						'desc' 		=> __( 'Text Block Alignment', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'innerposition' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Floating Text Position <br />(ex: 10px, 20px, 5px, 5px)', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'img' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Background Image', 'aesop-core' ),
						'tip'		=> 'sup'
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
						'desc' 		=> __( 'Image Repeat', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'imgposition' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image Position', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'content' 			=> __( 'All your normal text goes here.', 'ba-shortcodes' ),
				'desc' 				=> __( 'Multiple use content area with options for background image, background color, and magazine style columns.','aesop-core' )
			),
			'chapter' 	=> array(
				'name' 				=> __('Chapter Block', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'label'			=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default'	=> '',
						'desc'		=> __('Label (not shown)','aesop-core'),
						'tip'		=> 'sup'
					),
					'title'			=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default'	=> '',
						'desc'		=> __('Chapter Title','aesop-core'),
						'tip'		=> 'sup'
					),
					'subtitle'			=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default'	=> '',
						'desc'		=> __('Chapter Subtitle (optional)','aesop-core'),
						'tip'		=> 'sup'
					),
					'bgtype'			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('img', 'aesop-core'),
							__('video', 'aesop-core')
						),
						'default'	=> 'img',
						'desc'		=> __('Background Type','aesop-core'),
						'tip'		=> 'sup'
					),
					'img' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> ' ',
						'desc' 		=> __( 'Chapter Image/Video', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'desc' 				=> __( 'Creates the scroll to point, as a chapter heading.','aesop-core' )
			),
			'parallax' 			=> array(
				'name' 				=> __('Parallax Image', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'img' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'height' 		=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '500',
						'desc' 		=> __('Height of Image Area', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'parallaxbg' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Parallax Background Image', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'floater' 		=> array(
						'type'		=> 'text',
						'values'	=> array(
							__('off', 'aesop-core'),
							__('on', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Enable Floating Element', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'floatermedia' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Floater Media', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'floaterposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('right', 'aesop-core'),
							__('left', 'aesop-core'),
							__('center', 'aesop-core')
						),
						'default' 	=> 'right',
						'desc' 		=> __('Position of Floater', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'floateroffset' => array(
						'type'		=> 'text',
						'values' 	=> array(),
						'desc' 		=> __('Offset Amount of Floater (px or %)', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'floaterdirection' => array(
						'type'		=> 'text',
						'values' 	=> array(
							__('up', 'aesop-core'),
							__('down', 'aesop-core'),
							__('left', 'aesop-core'),
							__('right', 'aesop-core')
						),
						'default' 	=> 'up',
						'desc' 		=> __('Parallax Direction of Floater', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'caption' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> 'false',
						'desc' 		=> __('Caption (optional)', 'aesop-core' ),
						'tip'		=> 'sup'
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
						'desc' 		=> __('Caption Position', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'lightbox' 		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Image Lightbox', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'content' 			=> __( 'Optional Caption', 'ba-shortcodes' ),
				'desc' 				=> __( 'Parallax styled image component with caption and optional lightbox.','aesop-core' )
			),
			'audio' 			=> array(
				'name' 				=> __('Audio', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'title' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Title (optional)', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'src' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Audio URL', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'loop'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('off', 'aesop-core'),
							__('on', 'aesop-core')
						),
						'default' 	=> '',
						'desc' 		=> __( 'Loop Audio Player', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'viewstart'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Start Audio When in View', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'viewend'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Start Audio When out of View', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'hidden'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('off', 'aesop-core'),
							__('on', 'aesop-core')
						),
						'default' 	=> '',
						'desc' 		=> __( 'Hide Audio Player', 'aesop-core' ),
						'tip'		=> 'sup'
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
						'desc' 		=> __( 'Component Width', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('left', 'aesop-core'),
							__('center', 'aesop-core'),
							__('right', 'aesop-core')
						),
						'default' 	=> 'center',
						'desc' 		=> __( 'Alignment', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'src' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('vimeo', 'aesop-core'),
							__('youtube', 'aesop-core'),
							__('kickstarter', 'aesop-core'),
							__('viddler', 'aesop-core'),
							__('vine', 'aesop-core'),
							__('wistia', 'aesop-core'),
							__('instagram','aesop-core'),
							__('dailymotion', 'aesop-core'),
							__('self', 'aesop-core')
						),
						'default' 	=> 'vimeo',
						'desc' 		=> __('Video Source', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'id' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Video ID (enter URL for Viddler)', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'hosted' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Video ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'loop' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Video Loop ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'autoplay' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Autoplay ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'controls' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Video Controls ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'viewstart'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Start Video When in View  ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'viewend'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Start Video When Out of View  ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Caption (optional)', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'desc' 				=> __( 'Responsive video component with alignment and optional caption.','aesop-core' ),
				'tip'		=> 'sup'
			),
			'map' 				=> array(
				'name' 				=> __('Map', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'height' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Height', 'aesop-core' ),
						'tip'		=> 'sup'
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
						'desc' 		=> __( 'Date', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'title' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Title', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'desc' 				=> __( 'Enter a number such as 2007, and a small timeline will be displayed with scroll to points. This works similar to the chapter heading.','aesop-core' )
			),
			'document' 	=> array(
				'name' 				=> __('Document', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'type' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('pdf'),
							__('image')
						),
						'default' 	=> 'pdf',
						'desc' 		=> __( 'Document Type', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'src' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Document', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Optional Caption', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'desc' 				=> __( 'Show a document that is revealed with a click.','aesop-core' )
			),
			'collection' 	=> array(
				'name' 				=> __('Collections', 'aesop-core'),
				'type' 				=> 'single',
				'atts' 				=> array(
					'title' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Optional Title', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'collection' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Category ID', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'limit' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '',
						'desc' 		=> __( 'Posts to Show', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'columns' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('2'),
							__('3'),
							__('4'),
							__('5')
						),
						'default' 	=> '2',
						'desc' 		=> __( 'Columns', 'aesop-core' ),
						'tip'		=> 'sup'
					),
					'splash' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on'),
							__('off')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Splash Mode', 'aesop-core' ),
						'tip'		=> 'sup'
					)
				),
				'desc' 				=> __( 'Show a collection of stories. Typically used on a page like the home page.','aesop-core' )
			)
		);

		if ( $shortcode )
			return apply_filters('aesop_avail_components', $shortcodes[$shortcode]);
		else
			return apply_filters('aesop_avail_components', $shortcodes);
	}
}

?>