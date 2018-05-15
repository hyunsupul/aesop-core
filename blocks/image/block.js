/**
 * BLOCK: Image
 *
 * Gutenberg Block for Aesop Image.
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
	registerBlockType( 'ase/image', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Image Block', 'ASE' ), // Block title.
		icon: 'format-image', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			img : {
				type: 'string'
			},
			imgwidth : {
				type: 'string'
			},
			imgheight : {
				type: 'string'
			},
			panorama:{
				type : 'string'
			},
			lightbox:{
				type : 'string'
			},
			credit : {
				type: 'string'
			},
			alt : {
				type: 'string'
			},
			caption : {
				type: 'string'
			},
			captionposition : {
				type: 'string'
			},
			overlay_content: {
				type: 'string'
			},
			overlay_revealfx : {
				type: 'string',
			},
			revealfx : {
				type: 'string',
			}
		},

		// The "edit" property must be a valid function.
		//edit: function(props ) {
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			

			var onSelectMedia = ( media ) => {
				return setAttributes({                       
					img:media.url
                });
			};
			
			
			const advcontrols = isSelected && el( wp.blocks.InspectorControls, {},
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Panorama') ),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Enable Panorama Mode. Can display an image wider than the screen and can be viewed the moose cursor.' ),
						checked: attributes.panorama =='on',
						onChange: function( newVal ) {
										
										if (newVal) {
											setAttributes({
												panorama: 'on'
											});
										} else {
											setAttributes({
												panorama: 'off'
											});
										}
									
								},
					}
				),
				!attributes.panorama && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Image Width') ),
				!attributes.panorama && el( wp.components.TextControl, {
						label: __( 'Width of the image. You can enter the size in pixels or percentage such as 40% or 500px.' ),
						value: attributes.imgwidth,
						onChange: function( content ) {
							setAttributes( { imgwidth: content } );
						},
					} 
				),
				attributes.panorama && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Panorama Height') ),
				attributes.panorama && el( wp.components.TextControl, {
						label: __( 'Used only for the Panorama mode. Can be set using pixel values such as 500px. If unspecified, the original height would be used.' ),
						value: attributes.imgheight,
						onChange: function( content ) {
							setAttributes( { imgheight: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Image Credit') ),
				el( wp.components.TextControl, {
						label: __( 'This is typically used to credit the photographer. Enter a name and it will show as Photo by: Name.' ),
						value: attributes.credit,
						onChange: function( content ) {
							setAttributes( { credit : content} );
						},
					} 
				),
				!attributes.panorama && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Align') ),
				!attributes.panorama && el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'How should the image be aligned? If using a caption, the caption will automatically align with this option.' ),
								value: attributes.align,
								onChange: function( newVal ) {
										setAttributes({
												align: newVal
										});
								},
								options: [
								  { value: 'center', label:  'Center'  },
								  { value: 'left', label: 'Left'  },
								  { value: 'right', label: 'Right'  }
								],
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Lightbox') ),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Choose on and the image will open up the full-size version in a lightbox.' ),
						checked: attributes.lightbox =='on',
						onChange: function( newVal ) {										
										if (newVal) {
											setAttributes({
												lightbox: 'on'
											});
										} else {
											setAttributes({
												lightbox: 'off'
											});
										}
									
								},
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Image Caption') ),
				el( wp.components.TextControl, {
						label: __( 'Optional caption for the image. If you do not enter a caption, it will not show.' ),
						value: attributes.caption,
						onChange: function( content ) {
							setAttributes( { caption: content } );
						},
					} 
				),
				
				attributes.caption && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Caption Position') ),
				attributes.caption && el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Use this to override the alignment as inherited from the image.' ),
								value: attributes.captionposition,
								onChange: function( newVal ) {
										setAttributes({
												captionposition: newVal
										});
								},
								options: [
								  { value: 'center', label:  'Center'  },
								  { value: 'left', label: 'Left'  },
								  { value: 'right', label: 'Right'  }
								],
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Image Alt') ),
				el( wp.components.TextControl, {
						label: __( 'ALT tag used for the image. Primarily used for SEO purposes.' ),
						value: attributes.alt,
						onChange: function( content ) {
							setAttributes( { alt: content } );
						},
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
				isSelected &&  el(
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
				)
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-format-image" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Image'
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
