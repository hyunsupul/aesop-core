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
						'tip'		=> __('URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
					),
					'imgwidth' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '300px',
						'desc' 		=> __( 'Image Width', 'aesop-core' ),
						'tip'		=> __('Width of the image. You can enter the size as <code>40%</code> or <code>500px</code>.','aesop-core')
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Caption', 'aesop-core' ),
						'tip'		=> __('Optional caption for the image. If you do not enter a caption, it will not show.','aesop-core')
					),
					'credit' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image Credit', 'aesop-core' ),
						'tip'		=> __('This is typically used for the credit for the photographer. Enter a name, and it will show as <em>Photo by: Name</em>.','aesop-core')
					),
					'alt' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image ALT', 'aesop-core' ),
						'tip'		=> __('ALT tag used for the image. Primarily used for SEO purposes.','aesop-core')
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							'left',
							'right',
							'center'
						),
						'default' 	=> 'left',
						'desc' 		=> __( 'Image Alignment', 'aesop-core' ),
						'tip'		=> __('How should the image be aligned? If using a caption, the caption will automatically align with this option.','aesop-core')
					),
					'offset' 		=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Image Offset', 'aesop-core' ),
						'tip'		=> __('Using this option you can <em>float</em> an image outside of the text. Enter a size like <code>-200px</code>.','aesop-core')
					),
					'captionposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							'left',
							'right',
							'center'
						 ),
						'default' 	=> 'left',
						'desc' 		=> __( 'Caption Position', 'aesop-core' ),
						'tip'		=> __('Use this to override the alignment as inherited from the image.','aesop-core')
					),
					'lightbox' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Lightbox', 'aesop-core' ),
						'tip'		=> __('Choose <em>on</em> and the image will open up the full-size version in a lightbox.','aesop-core')
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
						'tip'		=> __('URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
					),
					'name' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Character Name', 'aesop-core' ),
						'tip'		=> __('Enter a name for the character. If you do not enter a name, it will not show.','aesop-core')
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Caption', 'aesop-core' ),
						'tip'		=> __('Optional caption for the character. If you do not enter a caption, it will not show.','aesop-core')
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							'left',
							'right'
						),
						'default' 	=> 'left',
						'desc' 		=> __( 'Alignment', 'aesop-core' ),
						'tip'		=> __('Alignment of the character component. To the left of the main text, or right of the main text.','aesop-core')
					),
					'width' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Width (px or %)', 'aesop-core' ),
						'tip'		=> __('Width of the character component. You can enter the size as <code>40%</code> or <code>500px</code>.','aesop-core')
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
						'tip'		=> __('You can enter the size as <code>40%</code> or <code>500px</code>. Enter the word <code>content</code> to restrict the width to that of the main text.','aesop-core')
					),
					'background' 	=> array(
						'values' 	=> array( ),
						'type'		=> 'color',
						'default' 	=> '#282828',
						'desc' 		=> __( 'Background Color', 'aesop-core' ),
						'tip'		=> __('Select a background color to be used as the background.','aesop-core')
					),
					'img' 	=> array(
						'values' 	=> array( ),
						'type'		=> 'media_upload',
						'default' 	=> '',
						'desc' 		=> __( 'Optional Background Image', 'aesop-core' ),
						'tip'		=> __('URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
					),
					'text'			 => array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#FFFFFF',
						'desc' 		=> __('Text Color', 'aesop-core' ),
						'tip'		=> __('Select a color for the quote text.','aesop-core')
					),
					'height' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> 'auto',
						'desc' 		=> __('Height of Image Area', 'aesop-core' ),
						'tip'		=> __('Choose a height for the component. The quote will automatically center itself vertically. By default this is set to <code>auto</code>.','aesop-core')
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							'left',
							'center',
							'right'
						),
						'default' 	=> 'center',
						'desc' 		=> __( 'Alignment', 'aesop-core' ),
						'tip'		=> __('By default the quote is centered, but you can choose to have it left, or right aligned as well.','aesop-core')
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
						'tip'		=> __('Font size of the quote.','aesop-core')
					),
					'parallax' 		=> array(
						'type'		=> 'text',
						'values'	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Enable Quote Parallax', 'aesop-core' ),
						'tip'		=> __('Set to <em>on</em> to enable the quote text to animate across the component.','aesop-core')
					),
					'offset' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> 300,
						'desc' 		=> __('If using parallax, starting offset.', 'aesop-core' ),
						'tip'		=> __('Start with a value like <code>100px</code>, and tweak until desired. This moves starting position of the quote back 100px if using parallax.','aesop-core')
					),
					'speed' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> '8',
						'desc' 		=> __('Speed of parallax movement. Lower is faster.', 'aesop-core' ),
						'tip'		=> __('How fast the quote should travel across the screen, if using parallax. Default is 8.','aesop-core')

					),
					'direction' => array(
						'type'		=> 'text',
						'values' 	=> array(
							'up',
							'down',
							'left',
							'right'
						),
						'default' 	=> 'up',
						'desc' 		=> __('Parallax Direction of Quote', 'aesop-core' ),
						'tip'		=> __('The direction that the quote should travel in, if using parallax.','aesop-core')
					),
					'quote' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> '',
						'desc' 		=> __('The quote', 'aesop-core' ),
						'tip'		=> __('The actual quote that will be displayed.','aesop-core')
					),
					'cite' 		=> array(
						'type'		=> 'text',
						'values'	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Cite (optional)', 'aesop-core' ),
						'tip'		=> __('Provide an optional cite or source for the quote.','aesop-core')
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
						'tip'		=> __('Set a color to be used for the main text.','aesop-core')
					),
					'background' 		=> array(
						'values' 	=> array(),
						'type'		=> 'color',
						'default' 	=> '#333333',
						'desc' 		=> __('Background Color', 'aesop-core' ),
						'tip'		=> __('Choose an optional background color for the content component.','aesop-core')
					),
					'width'			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '100%',
						'desc' 		=> __( 'Width of Component', 'aesop-core' ),
						'tip'		=> __('You can enter the size as <code>40%</code> or <code>500px</code>. Enter the word <code>content</code> to restrict the width to that of the main text.','aesop-core')
					),
					'height'			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Height of Component (optional)', 'aesop-core' ),
						'tip'		=> __('Enter an optional height for the component. By default it\'s set to <code>auto</code>. Use a large height like <code>1200px</code> to have a large blank area with small text.','aesop-core')
					),
					'columns' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Number of Columns', 'aesop-core' ),
						'tip'		=> __('Here you can optionally set the number of columns that the text should be split into. Example <code>2</code> will make 2 columns of text.','aesop-core')
					),
					'position' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							'none',
							'left',
							'right'
						),
						'default' 	=> 'none',
						'desc' 		=> __( 'Text Block Alignment', 'aesop-core' ),
						'tip'		=> __('This is optional, and allows you to float the text block to the left or right. This is useful when using a width like <code>300px</code>.','aesop-core')
					),
					'innerposition' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Floating Text Position <br />(ex: 10px, 20px, auto, auto)', 'aesop-core' ),
						'tip'		=> __('By setting this optional position, the text will be <em>floated</em> on the content component. In the example, it reads as 10px from the top, 20px from the right, and automatically positioned from bottom and left.','aesop-core')
					),
					'img' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Background Image', 'aesop-core' ),
						'tip'		=> __('URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
					),
					'imgrepeat' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							'no-repeat',
							'repeat',
							'repeat-vertical',
							'repeat-horizontal'
						),
						'default' 	=> 'no-repeat',
						'desc' 		=> __( 'Image Repeat', 'aesop-core' ),
						'tip'		=> __('If using a background image, should the background image repeat? Useful for using tiled images.','aesop-core')
					),
					'imgposition' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Background Image Position', 'aesop-core' ),
						'tip'		=> __('If using a background image, the position of the background. Default is center center.','aesop-core')
					),
					'imgsize' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Background Image Size', 'aesop-core' ),
						'tip'		=> __('If using a background image, the size of the image. By default it will be full width.','aesop-core')
					),
					'floatermedia' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Floater Media', 'aesop-core' ),
						'tip'		=> __('You can use text and images here. To use an image, use the full HTML tag without quotes around the image path.','aesop-core')
					),
					'floaterposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							'right',
							'left',
							'center'
						),
						'default' 	=> 'right',
						'desc' 		=> __('Position of Floater', 'aesop-core' ),
						'tip'		=> __('If you are using the Floater option, where should the floater be positioned?','aesop-core')
					),
					'floateroffset' => array(
						'type'		=> 'text',
						'values' 	=> array(),
						'desc' 		=> __('Offset Amount of Floater (px or %)', 'aesop-core' ),
						'tip'		=> __('This value will vary depending on your floater media. Enter a value like <code>-200px</code> and tweak as you see fit.','aesop-core')
					),
					'floaterdirection' => array(
						'type'		=> 'text',
						'values' 	=> array(
							'up',
							'down',
							'left',
							'right'
						),
						'default' 	=> 'up',
						'desc' 		=> __('Parallax Direction of Floater', 'aesop-core' ),
						'tip'		=> __('What direction should the floater media travel in?','aesop-core')
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
						'tip'		=> __('The label is what shows as the chapter navigation, and can be different from the title below.','aesop-core')
					),
					'title'			=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default'	=> '',
						'desc'		=> __('Chapter Title','aesop-core'),
						'tip'		=> __('The title of the chapter.','aesop-core')
					),
					'subtitle'			=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default'	=> '',
						'desc'		=> __('Chapter Subtitle (optional)','aesop-core'),
						'tip'		=> __('If filled out, will display a <em>sub-title</em> after the chapter title text.','aesop-core')
					),
					'bgtype'			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('img', 'aesop-core'),
							__('video', 'aesop-core')
						),
						'default'	=> 'img',
						'desc'		=> __('Background Type','aesop-core'),
						'tip'		=> __('Optionally set a looping video background.','aesop-core')
					),
					'img' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> ' ',
						'desc' 		=> __( 'Chapter Image or Video URL', 'aesop-core' ),
						'tip'		=> __('URL for the image or video background as set above. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
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
						'tip'		=> __('URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
					),
					'height' 		=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '500',
						'desc' 		=> __('Height of Image Area', 'aesop-core' ),
						'tip'		=> __('The height of the viewable image area. Enter a value such as <em>500</em>. Avoid using percentages as heights here.','aesop-core')
					),
					'parallaxbg' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Parallax Background Image', 'aesop-core' ),
						'tip'		=> __('If set to <em>on</em>, the image will move slightly as you scroll down the page.','aesop-core')
					),
					'floater' 		=> array(
						'type'		=> 'text',
						'values'	=> array(
							__('off', 'aesop-core'),
							__('on', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Enable Floating Element', 'aesop-core' ),
						'tip'		=> __('This option will enable a second parallax media layer that will float on top of the background image.','aesop-core')
					),
					'floatermedia' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '',
						'desc' 		=> __('Floater Media', 'aesop-core' ),
						'tip'		=> __('You can use text and images here. To use an image, use the full HTML tag without quotes around the image path.','aesop-core')
					),
					'floaterposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							'right',
							'left',
							'center'
						),
						'default' 	=> 'right',
						'desc' 		=> __('Position of Floater', 'aesop-core' ),
						'tip'		=> __('If you are using the Floater option, where should the floater be positioned?','aesop-core')
					),
					'floateroffset' => array(
						'type'		=> 'text',
						'values' 	=> array(),
						'desc' 		=> __('Offset Amount of Floater (px or %)', 'aesop-core' ),
						'tip'		=> __('This value will vary depending on your floater media. Enter a value like <code>-200px</code> and tweak as you see fit.','aesop-core')
					),
					'floaterdirection' => array(
						'type'		=> 'text',
						'values' 	=> array(
							'up',
							'down',
							'left',
							'right'
						),
						'default' 	=> 'up',
						'desc' 		=> __('Parallax Direction of Floater', 'aesop-core' ),
						'tip'		=> __('What direction should the floater media travel in?','aesop-core')
					),
					'caption' 	=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> 'false',
						'desc' 		=> __('Caption (optional)', 'aesop-core' ),
						'tip'		=> __('Provide an optional caption that will be displayed using the position below.','aesop-core')
					),
					'captionposition' => array(
						'type'		=> 'text',
						'values' 	=> array(
							'bottom-left',
							'bottom-right',
							'top-left',
							'top-right'
						),
						'default' 	=> 'bottom-left',
						'desc' 		=> __('Caption Position', 'aesop-core' ),
						'tip'		=> __('If using a caption, where should it be positioned within the parallax component?','aesop-core')
					),
					'lightbox' 		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Image Lightbox', 'aesop-core' ),
						'tip'		=> __('Enable an optional lightbox, that when clicked, will show the full size version of the parallax image.','aesop-core')
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
						'tip'		=> __('Provide an optional heading for the audio player.','aesop-core')
					),
					'src' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Audio URL', 'aesop-core' ),
						'tip'		=> __('URL to the mp3 file. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
					),
					'loop'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('off', 'aesop-core'),
							__('on', 'aesop-core')
						),
						'default' 	=> '',
						'desc' 		=> __( 'Loop Audio Player', 'aesop-core' ),
						'tip'		=> __('Enable looping within the audio player.','aesop-core')
					),
					'viewstart'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Start Audio When in View', 'aesop-core' ),
						'tip'		=> __('When set to <em>on</em> the audio will start playing automatically once scrolled into view.','aesop-core')
					),
					'viewend'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Stop Audio When out of View', 'aesop-core' ),
						'tip'		=> __('Used together with the option above, this option when set to <em>on</em> will stop the audio player from playing once scrolled out of view.','aesop-core')
					),
					'hidden'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('off', 'aesop-core'),
							__('on', 'aesop-core')
						),
						'default' 	=> '',
						'desc' 		=> __( 'Hide Audio Player', 'aesop-core' ),
						'tip'		=> __('Hide the audio player by setting this to <em>on</em>. This is useful for looping audio effects that do not need user controls.','aesop-core')
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
						'tip'		=> __('You can enter the size as <code>40%</code> or <code>500px</code>. Enter the word <code>content</code> to restrict the width to that of the main text.','aesop-core')
					),
					'align' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							'left',
							'center',
							'right'
						),
						'default' 	=> 'center',
						'desc' 		=> __( 'Alignment', 'aesop-core' ),
						'tip'		=> __('Should the video be floated to the left, right, or centered?','aesop-core')
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
						'tip'		=> __('Choose an available source for the video.','aesop-core')
					),
					'id' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Video ID (enter URL for Viddler)', 'aesop-core' ),
						'tip'		=> __('The video id can be found within any video URL, and typically looks something like <code>s8J2Ge4</code>.','aesop-core')
					),
					'hosted' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Video URL( if <em>self</em> as Source ). Click <em>Select Media</em> to open the WordPress Media Library. ', 'aesop-core' ),
						'tip'		=> __('This is only used if you are hosting the video yourself. Note, set the Video Source to <em>self</em> above to utilize this option.','aesop-core')
					),
					'loop' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Video Loop ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> __('Enable the video to loop.','aesop-core')
					),
					'autoplay' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'on',
						'desc' 		=> __('Autoplay ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> __('Should the video automatically start playing.','aesop-core')
					),
					'controls' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __('Video Controls ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> __('Hide or show the controls for the self-hosted video player.','aesop-core')
					),
					'viewstart'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Start Video When in View  ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> __('When set to <em>on</em> the video will start playing automatically once scrolled into view.','aesop-core')
					),
					'viewend'		=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on', 'aesop-core'),
							__('off', 'aesop-core')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Stop Video When Out of View  ( if <em>self</em> as Source )', 'aesop-core' ),
						'tip'		=> __('Used together with the option above, this option when set to <em>on</em> will stop the video player from playing once scrolled out of view.','aesop-core')
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Caption (optional)', 'aesop-core' ),
						'tip'		=> __('Optionally display a caption below the video.','aesop-core')
					)
				),
				'desc' 				=> __( 'Responsive video component with alignment and optional caption.','aesop-core' ),
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
						'tip'		=> __('The height of the map component. By default this is set to <code>500</code>. Avoid using percentages here.','aesop-core')
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
						'tip'		=> __('This is what is displayed as the timeline navigation label, and doesn\'t have to be a date specifically. Any text will work.','aesop-core')
					),
					'title' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Title', 'aesop-core' ),
						'tip'		=> __('The title that should be displayed within the story.','aesop-core')
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
						'tip'		=> __('The type of document. Choose image or PDF.','aesop-core')
					),
					'src' 			=> array(
						'type'		=> 'media_upload',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Document', 'aesop-core' ),
						'tip'		=> __('URL to the document. Click <em>Select Media</em> to open the WordPress Media Library.','aesop-core')
					),
					'caption' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Optional Caption', 'aesop-core' ),
						'tip'		=> __('Provide an optional caption for the document component.','aesop-core')
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
						'tip'		=> __('Display an optional heading to be used within the Collection component.','aesop-core')
					),
					'collection' 			=> array(
						'type'		=> 'text',
						'values' 	=> array( ),
						'default' 	=> '',
						'desc' 		=> __( 'Category ID', 'aesop-core' ),
						'tip'		=> __('Provide the ID of the category that you want stories to be displayed from.','aesop-core')
					),
					'limit' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(),
						'default' 	=> '',
						'desc' 		=> __( 'Posts to Show', 'aesop-core' ),
						'tip'		=> __('How many stories should be displayed.','aesop-core')
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
						'tip'		=> __('Stories are displayed in a grid. How many columns should the grid be?','aesop-core')
					),
					'splash' 			=> array(
						'type'		=> 'text',
						'values' 	=> array(
							__('on'),
							__('off')
						),
						'default' 	=> 'off',
						'desc' 		=> __( 'Splash Mode', 'aesop-core' ),
						'tip'		=> __('Setting this to <em>on</em>, will then only display the actual categories on your site with the category title.','aesop-core')
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