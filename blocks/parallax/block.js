/**
 * BLOCK: Parallax
 *
 * Registering a basic block with Gutenberg.
 *
 * Styles:
 *        editor.css — Editor styles for the block.
 *        style.css  — Editor & Front end styles for the block.
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
	registerBlockType( 'ase/parallax', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Parallax Block', 'ASE' ), // Block title.
		icon: 'image-flip-vertical', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			img : {
				type: 'string'
			},
			height : {
				type: 'string'
			},
			caption : {
				type: 'string'
			},
			parallaxbg : {
				type: 'string'
			},
			parallaxspeed : {
				type: 'string'
			},
			captionposition : {
				type: 'string'
			},
			lightbox: {
				type: 'string'
			},
			floater: {
				type: 'string',
				default: 'off'
			},
			floatermedia: {
				type: 'string'
			},
			floaterdirection: {
				type: 'string'
			},
			floaterdistance: {
				type: 'string'
			},
			overlay_revealfx: {
				type: 'string'
			},
		},

		// The "edit" property must be a valid function.
		edit	( { attributes, setAttributes, isSelected, className }) {
			

			var onSelectMedia = ( media ) => {
				return setAttributes({                       
					img:media.url
                });
			};
			
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Background Movement Type' ),
								value: attributes.parallaxbg,
								onChange: function( newVal ) {
										setAttributes({
												parallaxbg: newVal
										});
								},
								options: [
								  { value: 'on', label:  'On'  },
								  { value: 'off', label: 'Off'  },
								  { value: 'fixed', label: 'Fixed'  },
								],
					}
				),
				el( wp.components.TextControl, {
						label: __( 'Image Height' ),
						value: attributes.height,
						onChange: function( content ) {
							setAttributes( { height: content } );
						},
					} 
				),
				el( wp.components.TextControl, {
						label: __( 'Caption' ),
						value: attributes.caption,
						onChange: function( content ) {
							setAttributes( { caption: content } );
						},
					} 
				),
			    el(
					wp.components.ToggleControl,
					{
						label: __( 'Image Lightbox' ),
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
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Enable Floater Element') ),
			    el(
					wp.components.ToggleControl,
					{
						label: __( 'This option will enable a second parallax media layer that will float on top of the background image.' ),
						checked: attributes.floater=='on',
						onChange: function( newVal ) {
										
										if (newVal) {
											setAttributes({
												floater: 'on'
											});
										} else {
											setAttributes({
												floater: 'off'
											});
										}
									
								},
					}
				),
				attributes.floater=='on' && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Floater Element Content') ),
				attributes.floater=='on' && el( wp.components.TextControl, {
						label: __( 'You can use html codes with tags' ),
						value: attributes.floatermedia,
						onChange: function( content ) {
							setAttributes( { floatermedia: content } );
						},
					} 
				),
				attributes.floater=='on' && attributes.floatermedia && el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Reveal animation effect for the floater.' ),
								value: attributes.overlay_revealfx,
								onChange: function( newVal ) {
										setAttributes({
												overlay_revealfx: newVal
										});
								},
								options: [
								  { value: 'off', label:  __('Off')  },
								  { value: 'inplace', label: __('In Place')  },
								  { value: 'inplaceslow', label: __('In Place Slow')  },
								  { value: 'frombelow', label: __('From Below')  },
								  { value: 'fromleft', label: __('From Left')  },
								  { value: 'fromright', label: __('From Right') },
								],
					}
				)
			);
			
			var controls = el( 'div', { className: '' }
				,
				isSelected &&  el(
					wp.editor.MediaUpload,
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
							{ className: "dashicons dashicons-image-flip-vertical" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							__('Aesop Parallax')
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
