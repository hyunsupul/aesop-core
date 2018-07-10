/**
 * BLOCK: Video
 *
 * Gutenberg Block for Aesop Video.
 *
 */
( function() {
	var __ = wp.i18n.__; // The __() for internationalization.
	var el = wp.element.createElement; // The wp.element.createElement() function to create elements.
	var registerBlockType = wp.blocks.registerBlockType; // The registerBlockType() to register blocks.

	/**
	 * Register Basic Block.
	 *
	 * Registers a new block provided a unique name and an object defining its
	 * behavior. Once registered, the block is made available as an option to any
	 * editor interface where blocks are implemented.
	 *
	 * @param  {string}   name     Block name.
	 * @param  {Object}   settings Block settings.
	 * @return {?WPBlock}          The block, if it has been successfully
	 *                             registered; otherwise `undefined`.
	 */
	registerBlockType( 'ase/video', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Video', 'ASE' ), // Block title.
		icon: 'format-video', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			src : {
				type: 'string'
			},
			id : {
				type: 'string'
			},
			hosted : {
				type: 'string'
			},
			caption : {
				type: 'string'
			},
			align : {
				type: 'string'
			},
			autoplay:{
				type : 'boolean'
			},
			controls:{
				type : 'boolean'
			},
			viewstart:{
				type : 'boolean'
			},
			viewend:{
				type : 'boolean'
			},
			overlay_revealfx : {
				type: 'string',
			},
			revealfx : {
				type: 'string',
			}
		},

		// The "edit" property must be a valid function.
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			
			var onSelectMedia = ( media ) => {
				return setAttributes({                       
										hosted:media.url
                                });
			};
			
			var canAutoPlay = (attributes) => {
				return attributes.src == 'youtube';
			}
			
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Video Source') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Choose an available source for the video.' ),
								value: attributes.src,
								onChange: function( newVal ) {
										setAttributes({
												src: newVal
										});
								},
								options: [
								  { value: 'youtube', label:  'Youtube'  },
								  { value: 'vimeo', label: 'Vimeo'  },
								  { value: 'kickstarter', label: 'Kickstarter'  },
								  { value: 'viddler', label: 'Viddler'  },
								  { value: 'instagram', label: 'Instagram'  },
								  { value: 'dailymotion', label: 'Dailymotion'  },
								  { value: 'vine', label: 'Vine'  },
								  { value: 'wistia', label: 'Wistia'  },
								  { value: 'self', label: 'Self Hosted'  }
								],
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Video ID') ),
				attributes.src != 'self' && el( wp.components.TextControl, {
						label: __( 'The video ID can be found within the video URL and typically looks something like s8J2Ge4. For Viddler videos, enter the full URL instead.' ),
						value: attributes.id,
						onChange: function( content ) {
							setAttributes( { id: content } );
						},
					} 
				),
				attributes.src == 'self' && el(
					wp.blocks.MediaUpload,
					{
							title: __( 'Select Video File' ),
							onSelect: onSelectMedia,
							type: 'image',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Set Video File' ) 
								); }
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Caption') ),
				el( wp.components.TextControl, {
						label: __( 'Optionally display a caption below the video.' ),
						value: attributes.caption,
						onChange: function( content ) {
							setAttributes( { caption: content } );
						},
					} 
				),
			    (attributes.src == 'youtube' || attributes.src == 'vimeo' || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Autoplay' ),
						checked: !! attributes.viewstart,
						onChange: function( content ) {
							setAttributes( { autoplay: content } );
						}
					}
				),
			    (attributes.src == 'youtube' || attributes.src == 'vimeo' || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Start Video When in View' ),
						checked: !! attributes.viewstart,
						onChange: function( content ) {
							setAttributes( { viewstart: content } );
						}
					}
				),
				(attributes.src == 'youtube' || attributes.src == 'vimeo' || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Stop Video When Out of View' ),
						checked: !! attributes.viewend,
						onChange: function( content ) {
							setAttributes( { viewend: content } );
						}
					}
				),
				(attributes.src == 'youtube' || attributes.src == 'vimeo' || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Loop Video' ),
						checked: !! attributes.loop,
						onChange: function( content ) {
							setAttributes( { loop: content } );
						}
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Disable video on Mobile Devices.') ),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Disable video on Mobile Devices. Must specify the Poster Frame image.' ),
						checked: attributes.disable_for_mobile =='on',
						onChange: function( newVal ) {										
										if (newVal) {
											setAttributes({
												disable_for_mobile: 'on'
											});
										} else {
											setAttributes({
												disable_for_mobile: 'off'
											});
										}
									
								},
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Poster Frame.') ),
				el(
					wp.blocks.MediaUpload,
					{
							title: __( 'Image to display before the video plays if the target is self. Or the image to display if the video is disabled for mobile. Click <em>Select Media</em> to open the WordPress Media Library.' ),
							onSelect: function( content ) {
								setAttributes( { poster_frame: content } );
							},
							type: 'image',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Select Media' ) 
								); }
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Overlay Content') ),
				el( wp.components.TextControl, {
						label: __( 'Text or HTML content to be overlayed. You can use tags like H2, H3 etc.' ),
						value: attributes.overlay_content,
						onChange: function( content ) {
							setAttributes( { overlay_content: content } );
						},
					} 
				),
				attributes.overlay_content && el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Overlay Reveal Effect' ),
								value: attributes.overlay_revealfx,
								onChange: function( newVal ) {
										setAttributes({
												overlay_revealfx: newVal
										});
								},
								options: [
								  { value: 'off', label:  'Off'  },
								  { value: 'inplace', label: 'In Place'  },
								  { value: 'inplaceslow', label: 'In Place Slow'  },
								  { value: 'frombelow', label: 'From Below'  },
								  { value: 'fromleft', label: 'From Left'  },
								  { value: 'fromright', label: 'From Right'  },
								],
					}
				),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Reveal Animation' ),
								value: attributes.revealfx,
								onChange: function( newVal ) {
										setAttributes({
												revealfx: newVal
										});
								},
								options: [
								  { value: 'off', label:  'Off'  },
								  { value: 'inplace', label: 'In Place'  },
								  { value: 'inplaceslow', label: 'In Place Slow'  },
								  { value: 'frombelow', label: 'From Below'  },
								  { value: 'fromleft', label: 'From Left'  },
								  { value: 'fromright', label: 'From Right'  },
								],
					}
				)
			);
			
			var controls = el( 'div', { className: '' }
				,
				/*isSelected &&  el(
					wp.blocks.MediaUpload,
					{
							title: __( 'Select Image' ),
							onSelect: onSelectMedia,
							type: 'image',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Set Image Source' ) 
								); }
					}
				),
				attributes.img && el(
					'img', // Tag type.
					{ 
					src: attributes.img}
				)*/
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-format-video" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Video'
						)
			);

				
			var uis = [];

			uis.push(label);	
            uis.push(controls);
			
			return [ advcontrols,
				el(
					'div', // Tag type.
					{ className: "wp-block-aesop-story-engine" }, 
					uis// Content inside the tag.
				)
			];
	
							

		},

		// The "save" property must be specified and must be a valid function.
		save: function( props ) {
			return null;
		},
	} );
})();
