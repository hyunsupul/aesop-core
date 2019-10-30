<?php

/**
 *  Master list of all available shortcodes and attributes
 *
 * @since    1.0.0
 */

if ( ! function_exists( 'aesop_shortcodes' ) ) {
	function aesop_shortcodes( $shortcode = null ) {
		$shortcodes = array(
			'image'    => array(
				'name'     => __( 'Image', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'img'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Image URL', 'aesop-core' ),
						'tip'  => __( 'URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'panorama'    => array(
						'type'  => 'select',
						'values'  => array(						
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Panorama', 'aesop-core' ),
						'tip'  => __( 'Enable Panorama Mode. Can display an image wider than the screen and can be viewed the moose cursor.', 'aesop-core' )
					),
					'imgwidth'    => array(
						'type'  => 'text_small',
						'default'  => '300px',
						'desc'   => __( 'Image Width', 'aesop-core' ),
						'tip'  => __( 'Width of the image. You can enter the size in pixels or percentage such as <code>40%</code> or <code>500px</code>.', 'aesop-core' )
					),
					'imgheight'    => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Image Height', 'aesop-core' ),
						'tip'  => __( 'Used only for the Panorama mode. Can be set using pixel values such as <code>500px</code>. If unspecified, the original height would be used. ', 'aesop-core' )
					),					
					'offset'   => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Image Offset', 'aesop-core' ),
						'tip'  => __( 'Using this option you can <em>float</em> an image outside of the text. Enter a size like <code>-200px</code>.', 'aesop-core' )
					),
					'credit'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Image Credit', 'aesop-core' ),
						'tip'  => __( 'This is typically used to credit the photographer. Enter a name and it will show as <em>Photo by: Name</em>.', 'aesop-core' )
					),
					'alt'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Image ALT', 'aesop-core' ),
						'tip'  => __( 'ALT tag used for the image. Primarily used for SEO purposes.', 'aesop-core' )
					),
					'align'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'center',
								'name' => __( 'Center', 'aesop-core' ),
							),
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' ),
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' ),
							)
						),
						'default'  => 'center',
						'desc'   => __( 'Image Alignment', 'aesop-core' ),
						'tip'  => __( 'How should the image be aligned? If using a caption, the caption will automatically align with this option.', 'aesop-core' )
					),
					'lightbox'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Lightbox', 'aesop-core' ),
						'tip'  => __( 'Choose <em>on</em> and the image will open up the full-size version in a lightbox.', 'aesop-core' )
					),
					'captionsrc'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'custom',
								'name' => __( 'Custom', 'aesop-core' )
							),
							array(
								'value' => 'wp_media_caption',
								'name' => __( 'WP Media Caption', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Caption Source', 'aesop-core' ),
						'tip'  => __( 'Choose if the image caption should be pulled from the media information.', 'aesop-core' )
					),
					'caption'    => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Caption', 'aesop-core' ),
						'tip'  => __( 'Optional caption for the image.', 'aesop-core' )
					),
					'captionposition' => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' ),
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' ),
							),
							array(
								'value' => 'center',
								'name' => __( 'Center', 'aesop-core' ),
							)
						),
						'default'  => 'left',
						'desc'   => __( 'Caption Position', 'aesop-core' ),
						'tip'  => __( 'Use this to override the alignment as inherited from the image.', 'aesop-core' )
					),
					'overlay_content'     => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Overlay Content', 'aesop-core' ),
						'tip'  => __( 'Text or HTML content to be overlayed. You can use tags like H2, H3 etc.', 'aesop-core' )
					),

				),
				'desc'     => __( 'Creates an image component with caption, alignment, and lightbox options.', 'aesop-core' ),
				'codes'    => '<script>	            
						jQuery(document).ready(function($){
							function panoramaSetting(panorama){
							    if (panorama=="off") {
									jQuery(".aesop-image-imgwidth,.aesop-image-offset,.aesop-image-align").slideDown();
									jQuery(".aesop-image-imgheight").slideUp();
								}
								else if (panorama=="on") {
									jQuery(".aesop-image-imgheight").slideDown();
									jQuery(".aesop-image-imgwidth,.aesop-image-offset,.aesop-image-align").slideUp();
								}
							}
							function captionSetting(captionsrc){
							    if (captionsrc=="wp_media_caption") {
									jQuery(".aesop-image-caption").slideUp();
								} else {
									jQuery(".aesop-image-caption").slideDown();
								}
							}
							setTimeout( function() { 
							    panoramaSetting(jQuery( "#aesop-generator-attr-panorama" ).val());
								captionSetting(jQuery( "#aesop-generator-attr-captionsrc" ).val()); }, 500);
							jQuery( "#aesop-generator-attr-panorama" ).change(function() {
								panoramaSetting(this.value);
							});
							jQuery( "#aesop-generator-attr-captionsrc" ).change(function() {
								captionSetting(this.value);
							});
							
						});
			           </script>'
			),
			'character'    => array(
				'name'     => __( 'Character', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'img'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Character Image', 'aesop-core' ),
						'tip'  => __( 'URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'name'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Character Name', 'aesop-core' ),
						'tip'  => __( 'Enter a name for the character. If you do not enter a name, it will not show.', 'aesop-core' )
					),
					'caption'    => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Caption', 'aesop-core' ),
						'tip'  => __( 'Optional caption for the character. If you do not enter a caption, it will not show.', 'aesop-core' )
					),
					'align'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' )
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' )
							)
						),
						'default'  => 'left',
						'desc'   => __( 'Alignment', 'aesop-core' ),
						'tip'  => __( 'Alignment of the character component. You can align it to the left or right of the main text.', 'aesop-core' )
					),
					'width'    => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Width', 'aesop-core' ),
						'tip'  => __( 'Width of the character component. You can enter the size such as <code>40%</code> or <code>500px</code>.', 'aesop-core' )
					),
					'force_circle'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Force Circle', 'aesop-core' ),
						'tip'  => __( 'Force the display to be a circle instead of an oval.', 'aesop-core' )
					),
				),
				'desc'     => __( 'Creates a character that can be positioned to the left or right of your story.', 'aesop-core' ),
				'codes'    => ''
			),
			'quote'    => array(
				'name'     => __( 'Aesop Quote Section', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'type'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'block',
								'name' => __( 'Full Width', 'aesop-core' ),
							),
							array(
								'value' => 'pull',
								'name' => __( 'Pull Quote', 'aesop-core' ),
							),
						),
						'default'  => 'block',
						'desc'   => __( 'Quote Styles', 'aesop-core' ),
						'tip'  => __( 'By default the quote is full width, but you can change that here.', 'aesop-core' )
					),
					'background'  => array(
						'type'  => 'color',
						'default'  => '#282828',
						'desc'   => __( 'Background Color', 'aesop-core' ),
						'tip'  => __( 'Select a background color to be used as the quote background. Used only for full width quotes', 'aesop-core' )
					),
					'text'    => array(
						'type'  => 'color',
						'default'  => '#FFFFFF',
						'desc'   => __( 'Text Color', 'aesop-core' ),
						'tip'  => __( 'Select a color for the quote text.', 'aesop-core' )
					),
					'width'    => array(
						'type'  => 'text_small',
						'default'  => '100%',
						'desc'   => __( 'Component Width', 'aesop-core' ),
						'tip'  => __( 'You can enter the size such as <code>40%</code> or <code>500px</code>. Enter the word <code>content</code> to restrict the width to that of the main text.', 'aesop-core' )
					),
					'height'   => array(
						'type'  => 'text_small',
						'default'  => 'auto',
						'desc'   => __( 'Height of Quote Area', 'aesop-core' ),
						'tip'  => __( 'Enter a quote area height like <code>400px</code>. The quote will automatically center itself vertically. By default this is set to <code>auto</code>.', 'aesop-core' )
					),
					'align'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' ),
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' ),
							),
							array(
								'value' => 'center',
								'name' => __( 'Center', 'aesop-core' ),
							)
						),
						'default'  => 'center',
						'desc'   => __( 'Alignment', 'aesop-core' ),
						'tip'  => __( 'By default the quote is centered but you can choose to have it left or right aligned as well.', 'aesop-core' )
					),
					'size'    => array(
						'type'  => 'select',
						'values'  => aesop_option_counter( 10 ),
						'default'  => '2',
						'desc'   => __( 'Quote Size', 'aesop-core' ),
						'tip'  => __( 'Font size of the quote.', 'aesop-core' )
					),
					'img'  => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Background Image', 'aesop-core' ),
						'tip'  => __( 'Optionally add a background image to the quote area. Enter the image URL or click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'quote'   => array(
						'type'  => 'text_area',
						'default'  => 'Stories are made of atoms, not people.',
						'desc'   => __( 'Quote Text', 'aesop-core' ),
						'tip'  => __( 'The actual quote text that will be displayed.', 'aesop-core' )
					),
					'cite'   => array(
						'type'  => 'text_area',
						'default'  => 'Great person',
						'desc'   => __( 'Cite', 'aesop-core' ),
						'tip'  => __( 'Provide an optional cite or source for the quote.', 'aesop-core' )
					),
					'parallax'   => array(
						'type'  => 'select',
						'values' => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Enable Quote Parallax', 'aesop-core' ),
						'tip'  => __( 'Set to <em>on</em> to enable the quote text to animate across the component.', 'aesop-core' )
					),
					'direction' => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' )
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' )
							)
						),
						'default'  => 'right',
						'desc'   => __( 'Parallax Direction of Quote', 'aesop-core' ),
						'tip'  => __( 'The direction that the quote should travel in, if using parallax.', 'aesop-core' )
					)
				),
				'desc'     => __( 'Section quote area with background and color controls.', 'aesop-core' ),
				'codes'    => ''
			),
			'content'    => array(
				'name'     => __( 'Content', 'aesop-core' ),
				'type'     => 'wrap',
				'atts'     => array(
					'color'   => array(
						'type'  => 'color',
						'default'  => '#FFFFFF',
						'desc'   => __( 'Color of Text', 'aesop-core' ),
						'tip'  => __( 'Set a color to be used for the main text.', 'aesop-core' )
					),
					'background'   => array(
						'type'  => 'color',
						'default'  => '#333333',
						'desc'   => __( 'Background Color', 'aesop-core' ),
						'tip'  => __( 'Choose an optional background color for the content component.', 'aesop-core' ).__( 'Not used if using image background.', 'aesop-core' )
					),
					'width'   => array(
						'type'  => 'text_small',
						'default'  => '100%',
						'desc'   => __( 'Width of Content', 'aesop-core' ),
						'tip'  => __( 'You can enter the size such as <code>40%</code> or <code>500px</code>. Enter the word <code>content</code> to restrict the width to that of the main text.', 'aesop-core' )
					),
					'component_width'   => array(
						'type'  => 'text_small',
						'default'  => '100%',
						'desc'   => __( 'Width of Component', 'aesop-core' ),
						'tip'  => __( 'You can enter the size such as <code>40%</code> or <code>500px</code>.', 'aesop-core' )
					),
					'height'   => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Height of Component', 'aesop-core' ),
						'tip'  => __( 'Enter an optional height for the component. You can enter the size such as <code>40%</code> or <code>500px</code>. By default it\'s set to <code>auto</code>. Use a large height like <code>1200px</code> to have a large blank area with small text.', 'aesop-core' )
					),
					'columns'    => array(
						'type'  => 'select',
						'values'  => aesop_option_counter( 4 ),
						'default'  => '',
						'desc'   => __( 'Number of Columns', 'aesop-core' ),
						'tip'  => __( 'Optionally set the number of columns that the text should be split into. For example, <code>2</code> will make 2 columns of text.', 'aesop-core' )
					),
					'position'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'none',
								'name' => __( 'None', 'aesop-core' )
							),
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' )
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' )
							)
						),
						'default'  => 'none',
						'desc'   => __( 'Content Block Alignment', 'aesop-core' ),
						'tip'  => __( 'This option allows you to float the text block to the left or right. This is useful when using a width like <code>300px</code>.', 'aesop-core' )
					),
					'innerposition'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Floating Text Position', 'aesop-core' ),
						'tip'  => __( 'By setting this optional position, the text will be <em>floated</em> on the content component. For example, entering <code>10px, 20px, auto, auto</code> outputs the position as 10px from the top, 20px from the right, and automatically positioned from the bottom and left.', 'aesop-core' )
					),
					'img'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Background Image', 'aesop-core' ),
						'tip'  => __( 'URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'imgrepeat'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'no-repeat',
								'name' => __( 'No Repeat', 'aesop-core' )
							),
							array(
								'value' => 'repeat',
								'name' => __( 'Repeat', 'aesop-core' )
							),
							array(
								'value' => 'repeat-vertical',
								'name' => __( 'Repeat Vertical', 'aesop-core' )
							),
							array(
								'value' => 'repeat-horizontal',
								'name' => __( 'Repeat Horizontal', 'aesop-core' )
							)
						),
						'default'  => 'no-repeat',
						'desc'   => __( 'Image Repeat', 'aesop-core' ),
						'tip'  => __( 'If using a background image, should the background image repeat? Useful for using tiled images.', 'aesop-core' )
					),
					'imgposition'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Background Image Position', 'aesop-core' ),
						'tip'  => __( 'If using a background image, this option sets the position of the background image. Default is <code>center center</code> which results in the image being centered horizontally and vertically.', 'aesop-core' )
					),
					'imgsize'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Background Image Size', 'aesop-core' ),
						'tip'  => __( 'If using a background image, this option sets the size of the image. By default the image will be full width.', 'aesop-core' )
					),
					'disable_bgshading'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Do not shade the image background.', 'aesop-core' ),
						'tip'  => __( 'When using an image background, by default the background is shaded to make the text stand out. Set this option on to disable shading.', 'aesop-core' )
					),
					'floatermedia'  => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Floater Element Content', 'aesop-core' ),
						'tip'  => __( 'You can use text and images here. To use an image, use the full HTML tag without quotes around the image path. Example: <code><span class="dashicons dashicons-arrow-left-alt2"></span>img src=image.jpg<span class="dashicons dashicons-arrow-right-alt2"></span></code> You can also use tags like <code><span class="dashicons dashicons-arrow-left-alt2"></span>h2<span class="dashicons dashicons-arrow-right-alt2"></span>Text<span class="dashicons dashicons-arrow-left-alt2"></span>/h2<span class="dashicons dashicons-arrow-right-alt2"></span></code>', 'aesop-core' )
					),
					'floaterposition' => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' ),
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' ),
							),
							array(
								'value' => 'center',
								'name' => __( 'Center', 'aesop-core' ),
							)
						),
						'default'  => 'right',
						'desc'   => __( 'Position of Floater Element', 'aesop-core' ),
						'tip'  => __( 'If using the Floater Element option, where should it be positioned?', 'aesop-core' )
					),
					'floaterdirection' => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'up',
								'name' => __( 'Up', 'aesop-core' )
							),
							array(
								'value' => 'down',
								'name' => __( 'Down', 'aesop-core' )
							),
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' )
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' )
							)
						),
						'default'  => 'up',
						'desc'   => __( 'Movement Direction of Floater Element', 'aesop-core' ),
						'tip'  => __( 'In what direction should the Floater Element travel?', 'aesop-core' )
					)
				),
				'content'    => __( 'All your normal text goes here.', 'ba-shortcodes' ),
				'desc'     => __( 'Multiple use content area with options for background image, background color, and magazine style columns.', 'aesop-core' ),
				'tip'    => __( 'The actual content text that will be displayed.', 'aesop-core' ),
				'codes'    => ''
			),
			'chapter'  => array(
				'name'     => __( 'Chapter Block', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'title'   => array(
						'type'  => 'text',
						'default' => '',
						'desc'  => __( 'Chapter Title', 'aesop-core' ),
						'tip'  => __( 'The title of the chapter.', 'aesop-core' )
					),
					'subtitle'   => array(
						'type'  => 'text',
						'default' => '',
						'desc'  => __( 'Chapter Subtitle', 'aesop-core' ),
						'tip'  => __( 'This will optionally display a subtitle after the Chapter Title text.', 'aesop-core' )
					),
					'bgtype'   => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'img',
								'name' => __( 'Image', 'aesop-core' )
							),
							array(
								'value' => 'video',
								'name' => __( 'Video', 'aesop-core' )
							),
							array(
								'value' => 'color',
								'name' => __( 'Solid Color', 'aesop-core' )
							)
						),
						'default' => 'img',
						'desc'  => __( 'Background Type', 'aesop-core' ),
						'tip'  => __( 'Choose from an image or a looping video background.', 'aesop-core' )
					),
					'full'   => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default' => '',
						'desc'  => __( 'Full-size Background Image', 'aesop-core' ),
						'tip'  => __( 'If set to on, the background image of the chapter will be as large as the browser window.', 'aesop-core' )
					),
					'img'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Chapter Image or Video URL', 'aesop-core' ),
						'tip'  => __( 'URL for the image or video background as set above. Click <em>Select Media</em> to open the WordPress Media Library. If using video, you can use Youtube, Vimeo, or self-hosted URL.', 'aesop-core' )
					),
					'alternate_img'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Alternate Image for Mobile', 'aesop-core' ),
						'tip'  => __( 'Used only on a mobile device and if the Background Type is set to Video.', 'aesop-core' )
					),
					'video_autoplay'=>  array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'play_scroll',
								'name' => __( 'Play/Pause on Scroll', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
							
						),
						'default' => 'play_scroll',
						'desc'  => __( 'Autoplay Setting for Video', 'aesop-core' ),
						'tip'  => __( 'Autoplay setting. Only used if the type is set to video.', 'aesop-core' )
					),
					'bgcolor'    => array(
						'type'  => 'color',
						'default'  => '#888888',
						'desc'   => __( 'Background Color', 'aesop-core' ),
						'tip'  => __( 'Select a color for the background. Used ONLY IF the Background Type is set to Solid Color', 'aesop-core' )
					),
					'minheight'    => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Minimum Height', 'aesop-core' ),
						'tip'  => __( 'You can enter the minimum height in number of pixels like <code>300px</code>.', 'aesop-core' )
					),
					'maxheight'    => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Maximum Height', 'aesop-core' ),
						'tip'  => __( 'You can enter the maximum height in number of pixels like <code>300px</code> or <code>50%</code>. 100% by default.', 'aesop-core' )
					),
					'overlay_content'     => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Overlay Content', 'aesop-core' ),
						'tip'  => __( 'Text or HTML content to be displayed. You can use tags like H2, H3 etc. Important: If set, it will not show title and subtitle. The chapter menu will still use what you put in for Title.', 'aesop-core' )
					),
				),
				'desc'     => __( 'Creates the scroll to point, as a chapter heading.', 'aesop-core' ),
				'codes'    => '<script>	            
						jQuery(document).ready(function($){
							
							function bgSetting(bg){
							    if (bg=="img") {
									jQuery(".aesop-chapter-img,.aesop-chapter-full").slideDown();
									jQuery(".aesop-chapter-bgcolor,.aesop-chapter-alternate_img,.aesop-chapter-video_autoplay").slideUp();
								}
								else if (bg=="video") {
									jQuery(".aesop-chapter-img,.aesop-chapter-alternate_img,.aesop-chapter-video_autoplay").slideDown();
									jQuery(".aesop-chapter-bgcolor,.aesop-chapter-full").slideUp();
								}
								else if (bg=="color") {
									jQuery(".aesop-chapter-bgcolor").slideDown();
									jQuery(".aesop-chapter-img,.aesop-chapter-alternate_img,.aesop-chapter-video_autoplay,.aesop-chapter-full").slideUp();
								}
							}
							setTimeout( function() { 
							    bgSetting(jQuery( "#aesop-generator-attr-bgtype" ).val()); }, 500);
							jQuery( "#aesop-generator-attr-bgtype" ).change(function() {
								bgSetting(this.value);
							})
						});
			           </script>'
			),
			'parallax'    => array(
				'name'     => __( 'Parallax Image', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					
					'height' 		=> array(
						'type'		=> 'text_small',
						'default' 	=> '',
						'desc' 		=> __('Height of Image Area', 'aesop-core' ),
						'tip'		=> __('The height of the viewable image area. Enter a value such as <code>500px</code>. Avoid using percentages with this option. Leave blank for the default value.','aesop-core')
					),
					
					'img'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Parallax Image', 'aesop-core' ),
						'tip'  => __( 'URL for the image. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					
					'parallaxbg'  => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'fixed',
								'name' => __( 'Fixed', 'aesop-core' )
							)
						),
						'default'  => 'on',
						'desc'   => __( 'Image Movement', 'aesop-core' ),
						'tip'  => __( 'If set to <em>On</em>, the image will move slightly as you scroll down the page. If set to <em>Fixed</em> the background image will stay at fixed position as you scroll.', 'aesop-core' )
					),
					'parallaxspeed' 		=> array(
						'type'		=> 'text_small',
						'default' 	=> '1',
						'desc' 		=> __('Parallax Speed', 'aesop-core' ),
						'tip'		=> __('The minimum and default value is 1. The maximum value is 6.','aesop-core')
					),
					'caption'  => array(
						'type'  => 'text_area',
						'default'  => 'false',
						'desc'   => __( 'Caption', 'aesop-core' ),
						'tip'  => __( 'Display an optional caption that will appear where set in the next option.', 'aesop-core' )
					),
					'captionposition' => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'bottom-left',
								'name' => __( 'Bottom Left', 'aesop-core' )
							),
							array(
								'value' => 'bottom-right',
								'name' => __( 'Bottom Right', 'aesop-core' )
							),
							array(
								'value' => 'top-left',
								'name' => __( 'Top Left', 'aesop-core' )
							),
							array(
								'value' => 'top-right',
								'name' => __( 'Top Right', 'aesop-core' )
							)
						),
						'default'  => 'bottom-left',
						'desc'   => __( 'Caption Position', 'aesop-core' ),
						'tip'  => __( 'If using a caption, where should it be positioned within the parallax component?', 'aesop-core' )
					),
					'lightbox'   => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Image Lightbox', 'aesop-core' ),
						'tip'  => __( 'Enable an optional lightbox. When a user clicks the image, it will display the full size version of the parallax image in a lightbox.', 'aesop-core' )
					),
					'floater'   => array(
						'type'  => 'select',
						'values' => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Enable Floater Element', 'aesop-core' ),
						'tip'  => __( 'This option will enable a second parallax media layer that will float on top of the background image.', 'aesop-core' )
					),
					'floatermedia'  => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Floater Element Content', 'aesop-core' ),
						'tip'  => __( 'You can use text and images here with tags. Example: <code><span class="dashicons dashicons-arrow-left-alt2"></span>img src="image.jpg"<span class="dashicons dashicons-arrow-right-alt2"></span></code> You can also use classes and styles in tags.', 'aesop-core' )
					),
					'floaterposition' => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' ),
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' ),
							),
							array(
								'value' => 'center',
								'name' => __( 'Center', 'aesop-core' ),
							)
						),
						'default'  => 'right',
						'desc'   => __( 'Position of Floater Element', 'aesop-core' ),
						'tip'  => __( 'If you are using the Floater option, where should the floater be positioned?', 'aesop-core' )
					),
					'floaterdirection' => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'none',
								'name' => __( 'None', 'aesop-core' )
							),
							array(
								'value' => 'up',
								'name' => __( 'Up', 'aesop-core' )
							),
							array(
								'value' => 'down',
								'name' => __( 'Down', 'aesop-core' )
							),
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' )
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' )
							)
						),
						'default'  => 'none',
						'desc'   => __( 'Movement Direction of Floater Element', 'aesop-core' ),
						'tip'  => __( 'What direction should the floater media travel in?', 'aesop-core' )
					),
					'floaterdistance' 		=> array(
						'type'		=> 'text_small',
						'default' 	=> '',
						'desc' 		=> __('Floater Distance', 'aesop-core' ),
						'tip'		=> __('The distance the floater travels. You can specift 50%, 200px etc. The default is 33% of width or height.','aesop-core')
					),
				),
				'content'    => __( 'Optional Caption', 'ba-shortcodes' ),
				'desc'     => __( 'Parallax styled image component with caption and optional lightbox.', 'aesop-core' ),
				'codes'    => '<script>	            
						jQuery(document).ready(function($){
							
							function parallaxSetting(parallax){
							    if (parallax=="on") {
									jQuery(".aesop-parallax-parallaxspeed").slideDown();
								} else {
									jQuery(".aesop-parallax-parallaxspeed").slideUp();
								}
								
							}
							function floaterSetting(floater){
							    if (floater=="on") {
									jQuery(".aesop-parallax-floatermedia,.aesop-parallax-floaterdistance,.aesop-parallax-floaterdirection,.aesop-parallax-floaterdistance,.aesop-parallax-floaterposition,.aesop-parallax-overlay_revealfx").slideDown();
								} else {
									jQuery(".aesop-parallax-floatermedia,.aesop-parallax-floaterdistance,.aesop-parallax-floaterdirection,.aesop-parallax-floaterdistance,.aesop-parallax-floaterposition,.aesop-parallax-overlay_revealfx").slideUp();
								}
								
							}
							setTimeout( function() { 
							    parallaxSetting(jQuery( "#aesop-generator-attr-parallaxbg" ).val()); 
								floaterSetting(jQuery( "#aesop-generator-attr-floater" ).val());}, 500);
								 
							jQuery( "#aesop-generator-attr-parallaxbg" ).change(function() {
								parallaxSetting(this.value);
							});
							jQuery( "#aesop-generator-attr-floater" ).change(function() {
								floaterSetting(this.value);
							});
						});
			           </script>'
			),
			'audio'    => array(
				'name'     => __( 'Audio', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'title'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Title', 'aesop-core' ),
						'tip'  => __( 'Provide an optional heading for the audio player.', 'aesop-core' )
					),
					'src'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Audio URL', 'aesop-core' ),
						'tip'  => __( 'URL to the mp3 file. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'loop'  => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => '',
						'desc'   => __( 'Loop Audio Player', 'aesop-core' ),
						'tip'  => __( 'Enable looping within the audio player.', 'aesop-core' )
					),
					'viewstart'  => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Start Audio When in View', 'aesop-core' ),
						'tip'  => __( 'When set to <em>on</em> the audio will start playing automatically once scrolled into view.', 'aesop-core' )
					),
					'viewend'  => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Stop Audio When Out of View', 'aesop-core' ),
						'tip'  => __( 'Used together with the option above, this option when set to <em>on</em> will stop the audio player from playing once scrolled out of view.', 'aesop-core' )
					),
					'hidden'  => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => '',
						'desc'   => __( 'Hide Audio Player', 'aesop-core' ),
						'tip'  => __( 'Hide the audio player by setting this to <em>on</em>. This is useful for looping audio effects that do not need user controls.', 'aesop-core' )
					)
				),
				'desc'     => __( 'Creates an audio player with your own audio.', 'aesop-core' )
			),
			'video'    => array(
				'name'     => __( 'Video Section', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					
					'src'    => array(
						'type'  => 'select',
						'values'  => array(

						    array(
								'value' => 'youtube',
								'name' => __( 'YouTube', 'aesop-core' )
							),
							array(
								'value' => 'vimeo',
								'name' => __( 'Vimeo', 'aesop-core' )
							),
							array(
								'value' => 'kickstarter',
								'name' => __( 'Kickstarter', 'aesop-core' )
							),
							array(
								'value' => 'viddler',
								'name' => __( 'Viddler', 'aesop-core' )
							),
							array(
								'value' => 'vine',
								'name' => __( 'Vine', 'aesop-core' )
							),
							array(
								'value' => 'wistia',
								'name' => __( 'Wistia', 'aesop-core' )
							),
							array(
								'value' => 'instagram',
								'name' => __( 'Instagram', 'aesop-core' )
							),
							array(
								'value' => 'dailymotion',
								'name' => __( 'Dailymotion', 'aesop-core' )
							),
							array(
								'value' => 'self',
								'name' => __( 'Self', 'aesop-core' )
							)
						),
						'default'  => 'youtube',
						'desc'   => __( 'Video Source', 'aesop-core' ),
						'tip'  => __( 'Choose an available source for the video.', 'aesop-core' )
					),
					'id'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Video ID', 'aesop-core' ),
						'tip'  => __( 'The video ID can be found within the video URL and typically looks something like <code>s8J2Ge4</code>. For Viddler videos, enter the full URL instead.', 'aesop-core' )
					),
					'hosted'   => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Video URL (only if using <em>self</em> as video source)', 'aesop-core' ),
						'tip'  => __( 'This is only used if you are hosting the video yourself and have set the Video Source (above) to <em>self</em>. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'width'    => array(
						'type'  => 'text_small',
						'default'  => '100%',
						'desc'   => __( 'Component Width', 'aesop-core' ),
						'tip'  => __( 'You can enter the size such as <code>40%</code> or <code>500px</code>. Enter the word <code>content</code> to restrict the width to that of the main text.', 'aesop-core' )
					),
					'align'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'center',
								'name' => __( 'Center', 'aesop-core' )
							),
							array(
								'value' => 'left',
								'name' => __( 'Left', 'aesop-core' )
							),
							array(
								'value' => 'right',
								'name' => __( 'Right', 'aesop-core' )
							)
						),
						'default'  => 'center',
						'desc'   => __( 'Alignment', 'aesop-core' ),
						'tip'  => __( 'Should the video be floated to the left, right, or centered?', 'aesop-core' )
					),
					'caption'   => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Caption', 'aesop-core' ),
						'tip'  => __( 'Optionally display a caption below the video.', 'aesop-core' )
					),
					'disable_for_mobile'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => 'on',
						'desc'   => __( 'Disable video on Mobile Devices.', 'aesop-core' ),
						'tip'  => __( 'Disable video on Mobile Devices. Must specify the Poster Frame image.', 'aesop-core' )
					),
					'poster_frame'  => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Poster Frame', 'aesop-core' ),
						'tip'  => __( 'Image to display before the video plays if the target is self. Or the image to display if the video is disabled for mobile. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'loop'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => 'on',
						'desc'   => __( 'Video Loop', 'aesop-core' ),
						'tip'  => __( 'Enable the video to loop.', 'aesop-core' )
					),
					'controls'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Video Controls', 'aesop-core' ),
						'tip'  => __( 'Hide or show the controls for the video player.', 'aesop-core' )
					),
					'mute'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Mute', 'aesop-core' ),
						'tip'  => __( 'Mute Video. Using Youtube or Vimeo, you need to mute the video to have autoplay work.', 'aesop-core' )
					),
					'autoplay'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Autoplay', 'aesop-core' ),
						'tip'  => __( 'Should the video automatically start playing.', 'aesop-core' )
					),
					'viewstart'  => array(
						'type'  => 'select',
						'values'  => array(	
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Start Video When in View', 'aesop-core' ),
						'tip'  => __( 'When set to <em>on</em> the video will start playing automatically once scrolled into view.', 'aesop-core' )
					),
					'viewend'  => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'pip',
								'name' => __( 'Picture in Picture Mode', 'aesop-core' )
							)
						),
						'default'  => 'off',
						'desc'   => __( 'Stop Video When Out of View', 'aesop-core' ),
						'tip'  => __( 'Used together with the option above, this option when set to <em>on</em> will stop the video player from playing once scrolled out of view. Selecting "Picture in Picture Mode" will move the video to a corner of the screen, allowing you to scroll and continue watching the video.', 'aesop-core' )
					),
					'show_subtitles'  => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Show Subtitles', 'aesop-core' ),
						'tip'  => __( 'Does not work with auto-generated subtitles. Must specify the language code below.', 'aesop-core' )
					),
					'lang_pref'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Subtitle Language', 'aesop-core' ),
						'tip'  => __( 'Language code of the default subtitle language (e.g "en" "fr")', 'aesop-core' )
					),
					'overlay_content'     => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Overlay Content', 'aesop-core' ),
						'tip'  => __( 'Text or HTML content to be overlayed. You can use tags like H2, H3 etc.', 'aesop-core' )
					),
					
				),
				'desc'     => __( 'Responsive video component with alignment and optional caption.', 'aesop-core' ),
				'codes'    => '<script>	            
						jQuery(document).ready(function($){
							function srcSetting(src){								
							    if ( src=="kickstarter" || src=="viddler" || src=="vine" || src=="wistia" || src=="instagram" || src=="dailymotion") {
									jQuery(".aesop-video-id").slideDown();
									jQuery(".aesop-video-hosted,.aesop-video-disable_for_mobile,.aesop-video-poster_frame,.aesop-video-loop,.aesop-video-autoplay,.aesop-video-controls,.aesop-video-viewstart, .aesop-video-mute, .aesop-video-viewend,.aesop-video-show_subtitles,.aesop-video-lang_pref").slideUp();
								}
								else if (src=="youtube") {
									jQuery(".aesop-video-id,.aesop-video-loop,.aesop-video-mute,.aesop-video-autoplay,.aesop-video-controls,.aesop-video-viewstart,.aesop-video-viewend,.aesop-video-show_subtitles,.aesop-video-lang_pref").slideDown();
									jQuery(".aesop-video-hosted").slideUp();
								}
								else if (src=="vimeo") {
									jQuery(".aesop-video-id,.aesop-video-loop,.aesop-video-mute,.aesop-video-autoplay,.aesop-video-viewstart, .aesop-video-viewend").slideDown();
									jQuery(".aesop-video-hosted,.aesop-video-controls,.aesop-video-show_subtitles,.aesop-video-lang_pref").slideUp();
								}
								else if (src=="self") {
									jQuery("#aesop-generator-settings").children().slideDown();
									jQuery(".aesop-video-id,.aesop-video-show_subtitles,.aesop-video-lang_pref").slideUp();
								}
								disableMobileSetting(jQuery( "#aesop-generator-attr-disable_for_mobile" ).val());
							}
							function disableMobileSetting(onOff) {
								if (jQuery( "#aesop-generator-attr-src" ).val()=="self" || onOff=="on") {
									jQuery(".aesop-video-poster_frame").slideDown();
								} else {
									jQuery(".aesop-video-poster_frame").slideUp();
								}
							}
							function muteSetting(onOff) {
								if (jQuery( "#aesop-generator-attr-src" ).val()=="vimeo" || jQuery( "#aesop-generator-attr-src" ).val()=="youtube") {
									if (onOff=="on") {
										jQuery(".aesop-video-autoplay,.aesop-video-viewstart, .aesop-video-viewend").slideDown();
									} else {
										jQuery(".aesop-video-autoplay,.aesop-video-viewstart, .aesop-video-viewend").slideUp();
									}
								}
							}
							setTimeout( function() { 
                                srcSetting(jQuery( "#aesop-generator-attr-src" ).val()); 
								disableMobileSetting(jQuery( "#aesop-generator-attr-disable_for_mobile" ).val());
								muteSetting(jQuery( "#aesop-generator-attr-mute" ).val());}, 
							500);
								
							jQuery( "#aesop-generator-attr-src" ).change(function() {
								srcSetting(this.value);
							})
							jQuery( "#aesop-generator-attr-disable_for_mobile" ).change(function() {
								disableMobileSetting(this.value);
							})
							jQuery( "#aesop-generator-attr-mute" ).change(function() {
								muteSetting(this.value);
							})
						});
			           </script>'
			),
			'map'     => array(
				'name'     => __( 'Map', 'aesop-core' ),
				'type'     => 'single',
				'front'    => true,
				'front_type'  => 'map',
				'atts'     => array(
					'height'    => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Height', 'aesop-core' ),
						'tip'  => __( 'The height of the map component. By default this is set to <em>500px</em>. Avoid using percentages with this option.', 'aesop-core' )
					),
					'sticky'  => array(
						'type'  => 'select',
						'default' => 'off',
						'desc'  => __( 'Sticky Maps', 'aesop-core' ),
						'tip'  => __( 'By choosing a position the map will follow the scrolling of the story with the markers that you\'ll add below.<br /><br />After toggling a location, a new Map Marker component will show up. Add a marker for each stop in the story that you would ike the map to start at. Stops are made in the order that you added the markers in the map admin.', 'aesop-core' ),
						'values' => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'left',
								'name' => __( 'Sticky Left', 'aesop-core' )
							),
							array(
								'value' => 'top',
								'name' => __( 'Sticky Top', 'aesop-core' )
							),
							array(
								'value' => 'right',
								'name' => __( 'Sticky Right', 'aesop-core' )
							),
							array(
								'value' => 'bottom',
								'name'
								=> __( 'Sticky Bottom', 'aesop-core' )
							)
						)
					)
				),
				'desc'     => __( 'Creates the basic map component. Use the Map Locations edit boxes when writing your story to add locations.', 'aesop-core' ),
				'codes'    => ''
			),
			'timeline_stop'  => array(
				'name'     => __( 'Timeline Stop', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'num'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Navigation Menu Item Label', 'aesop-core' ),
						'tip'  => __( 'This is what is displayed for the timeline navigation menu item label. Example usage includes dates, years, colors, locations, and names.', 'aesop-core' )
					),
					'title'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Timeline Title', 'aesop-core' ),
						'tip'  => __( 'The timeline title that should be displayed within the story.', 'aesop-core' )
					)
				),
				'desc'     => __( 'Enter a number such as 2007, and a small timeline will be displayed with scroll to points. This works similar to the chapter heading.', 'aesop-core' ),
                'codes'    => ''
				),
			'document'  => array(
				'name'     => __( 'Document', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'type'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'pdf',
								'name' => __( 'PDF', 'aesop-core' )
							),
							array(
								'value' => 'image',
								'name' => __( 'Image', 'aesop-core' )
							),
							array(
								'value' => 'ms',
								'name' => __( 'Microsoft', 'aesop-core' )
							),
							array(
								'value' => 'download',
								'name' => __( 'Download Link', 'aesop-core' )
							)
						),
						'default'  => 'pdf',
						'desc'   => __( 'Document Type', 'aesop-core' ),
						'tip'  => __( 'The type of document. Choose image, PDF or Miscrosoft.', 'aesop-core' ).__( 'Or "download" to just add a download link.', 'aesop-core' )
					),
					'src'    => array(
						'type'  => 'media_upload',
						'default'  => '',
						'desc'   => __( 'Document URL', 'aesop-core' ),
						'tip'  => __( 'URL to the document. Click <em>Select Media</em> to open the WordPress Media Library.', 'aesop-core' )
					),
					'title'    => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Title', 'aesop-core' ),
						'tip'  => __( 'By default, the title is "DOCUMENT".', 'aesop-core' )
					),
					'caption'    => array(
						'type'  => 'text_area',
						'default'  => '',
						'desc'   => __( 'Document Caption', 'aesop-core' ),
						'tip'  => __( 'Provide an optional caption for the document component.', 'aesop-core' )
					),
					'download'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Download Link', 'aesop-core' ),
						'tip'  => __( 'Add a download link for the file.', 'aesop-core' )
					)
				),
				'desc'     => __( 'Show a document that is revealed with a click.', 'aesop-core' ),
				'codes'    => '<script>	            
						jQuery(document).ready(function($){
							function typeSetting(t){								
							    if ( t=="download") {
									jQuery(".aesop-document-download").slideUp();						
								}
								else  {
									jQuery(".aesop-document-download").slideDown();
								}
								
								disableMobileSetting(jQuery( "#aesop-generator-attr-disable_for_mobile" ).val());
							}
							
							setTimeout( function() { 
                                typeSetting(jQuery( "#aesop-generator-attr-type" ).val()); 
								}, 500);
								
							jQuery( "#aesop-generator-attr-type" ).change(function() {
								typeSetting(this.value);
							})
						});
			           </script>'
			),
			'collection'  => array(
				'name'     => __( 'Collections', 'aesop-core' ),
				'type'     => 'single',
				'atts'     => array(
					'title'    => array(
						'type'  => 'text',
						'default'  => '',
						'desc'   => __( 'Title', 'aesop-core' ),
						'tip'  => __( 'Display an optional heading to be used within the Collection component.', 'aesop-core' )
					),
					'collection'    => array(
						'type'  => 'select_multiple',
						'values' => aesop_option_get_categories(),
						'default'  => '',
						'desc'   => __( 'Category', 'aesop-core' ),
						'tip'  => __( 'Select the category that you want stories to be displayed from.', 'aesop-core' )
					),
					'limit'    => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Number of Stories', 'aesop-core' ),
						'tip'  => __( 'How many stories should be displayed in this collection?', 'aesop-core' )
					),
					'columns'    => array(
						'type'  => 'select',
						'values'  => aesop_option_counter( 5 ),
						'default'  => '2',
						'desc'   => __( 'Columns', 'aesop-core' ),
						'tip'  => __( 'Stories are displayed in a grid. How many columns should the grid be?', 'aesop-core' )
					),
					'splash'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Splash Mode', 'aesop-core' ),
						'tip'  => __( 'Setting this to on will display only the actual category titles (without images).', 'aesop-core' )
					),
					'order'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'default',
								'name' => __( 'Default', 'aesop-core' )
							),
							array(
								'value' => 'reverse',
								'name' => __( 'Reverse', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Post Order', 'aesop-core' ),
						'tip'  => __( 'Choose Default to show the newest post first.', 'aesop-core' )
					),
					'loadmore'    => array(
						'type'  => 'select',
						'values'  => array(
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
						),
						'default'  => 'off',
						'desc'   => __( 'Load More', 'aesop-core' ),
						'tip'  => __( 'Setting this to on will display Load More link to load more posts.', 'aesop-core' )
					),
					'showexcerpt'    => array(
						'type'  => 'select',
						'values'  => array(						
							array(
								'value' => 'on',
								'name' => __( 'On', 'aesop-core' )
							),
							array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
						),
						'default'  => 'on',
						'desc'   => __( 'Show Excerpt', 'aesop-core' ),
						'tip'  => __( 'Setting this to on will display excerpts from each post', 'aesop-core' )
					)
				),
				'desc'     => __( 'Show a collection of stories. Typically used on a page like the home page.', 'aesop-core' ),
				'codes'    => ''
			),
			'gallery'     => array(
				'name'     => __( 'Gallery', 'aesop-core' ),
				'type'     => 'single',
				'front'    => true,
				'front_type'  => 'gallery',
				'atts'     => array(
					'id'    => array(
						'type'  => 'select',
						'values'  => aesop_option_get_posts( 'ai_galleries' ),
						'default'  => '',
						'desc'   => __( 'Choose Gallery', 'aesop-core' ),
						'tip'  => __( 'Select a gallery below to insert it.', 'aesop-core' )
					)
				),
				'desc'     => __( ' ', 'aesop-core' ),
				'codes'    => ''
			)
		);

		if ( $shortcode ) {
			return apply_filters( 'aesop_avail_components', $shortcodes[$shortcode] ); }
		else {
			return apply_filters( 'aesop_avail_components', $shortcodes ); }
	}
}//end if

/**
 * Helper function to retrieve posts for use in option array
 *
 * @since 1.1
 * @todo cache this query
 * @param unknown $type - post-type
 * @todo implement caching based on component settings view
 */

function aesop_option_get_posts( $type = 'post' ) {

	$args = array( 'posts_per_page' => -1, 'post_type' => $type );

	$posts = get_posts( $args );

	$array = array();

	if ( $posts ):

		foreach ( $posts as $post ) {

			array_push( $array, array(
					'value' => $post->ID,
					'name'  => $post->post_title
				) );
		}

	return $array;

	endif;
}

/**
 * Helper function to retrieve teh categories for use in option array
 *
 * @since 1.1
 * @todo cache this query
 * @param unknown $type - post-type
 * @todo implement caching based on component settings view
 */
function aesop_option_get_categories( $type = 'post' ) {

	$args = array( 'type' => $type );

	$cats = get_categories( $args );

	$array = array();

	if ( $cats ):

		foreach ( $cats as $cat ) {

			array_push( $array, array(
					'value' => $cat->cat_ID,
					'name'  => $cat->cat_name
				) );
		}

	return $array;

	endif;
}

/**
 * Helper function to build a dropdown with integers
 *
 * @since 1.1
 * @param integer $count - int
 */
function aesop_option_counter( $count = 10 ) {

	$array = array();

	for ( $i = 1; $i <= $count; $i++ ) {

		array_push( $array, array(
				'value' => $i,
				'name'  => $i
			) );

	}

	return $array;
}
