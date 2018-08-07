/**
 * BLOCK: Character
 *
 * Gutenberg Block for Aesop Character.
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
	registerBlockType( 'ase/character', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Character', 'ASE' ), // Block title.
		icon: 'businessman', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			img : {
				type: 'string'
			},
			name : {
				type: 'string'
			},
			caption : {
				type: 'string'
			},
			align : {
				type: 'string'
			},
			width : {
				type: 'width'
			},
			force_circle:{
				type : 'boolean'
			},
			revealfx : {
				type: 'string',
			}
		},

		// The "edit" property must be a valid function.			
		edit	( { attributes, setAttributes, isSelected, className }) {
			

			var onSelectMedia = ( media ) => {
				return setAttributes({                       
					img:media.url
                });
			};
			
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Caption') ),
				el( wp.components.TextControl, {
						label: __( 'Optional caption for the character. If you do not enter a caption, it will not show.' ),
						value: attributes.caption,
						onChange: function( content ) {
							setAttributes( { caption: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Force Circle') ),
			    el(
					wp.components.ToggleControl,
					{
						label: __( 'Force the display to be a circle instead of an oval.' ),
						checked: !! attributes.force_circle,
						onChange: function( newVal ) {
										setAttributes({
												force_circle: newVal
										});
								},
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Alignment') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Alignment of the character component. You can align it to the left or right of the main text.' ),
								value: attributes.align,
								onChange: function( newVal ) {
										setAttributes({
												align: newVal
										});
								},
								options: [
								  { value: 'left', label:  'Left'  },
								  { value: 'right', label: 'Right'  }
								],
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Width') ),
				el( wp.components.TextControl, {
						label: __( 'Width of the character component. You can enter the size such as 40% or 500px.' ),
						value: attributes.width,
						onChange: function( content ) {
							setAttributes( { width: content } );
						},
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
				),
				el( wp.components.TextControl, {
						label: __( 'Character Name' ),
						value: attributes.name,
						onChange: function( content ) {
							setAttributes( { name: content } );
						},
					} 
				),
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-businessman" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Character'
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
