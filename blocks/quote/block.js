/**
 * BLOCK: Quote
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
	registerBlockType( 'ase/quote', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Quote Block', 'ASE' ), // Block title.
		icon: 'format-quote', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			quote : {
				type: 'string',
			},
			cite : {
				type: 'string',
			},
			type : {
				type: 'string',
			},
			text : {  // background color
				type: 'string',
				default: '#FFFFFF',
			},
			background : {  // background color
				type: 'string',
				default: '#282828',
			},
			img : {
				type: 'string',
			},
			align : {
				type: 'string',
			},
			revealfx : {
				type: 'string',
			}
		},

		// The "edit" property must be a valid function.
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			
			
			var revealfx = attributes.revealfx;
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Cite') ),
				el( wp.components.TextControl, {
						label: __( 'Provide an optional cite or source for the quote.' ),
						value: attributes.cite,
						onChange: function( content ) {
							setAttributes( { cite: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Quote Styles') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'By default the quote is full width, but you can change that here.' ),
								value: attributes.type,
								onChange: function( newVal ) {
										setAttributes({
												type: newVal
										});
								},
								options: [
								  { value: 'block', label:  'Full Width'  },
								  { value: 'pull', label: 'Pull Quote'  }
								],
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Background Image') ),
				attributes.img && el( 'img', {src: attributes.img} ),
				el(
					wp.editor.MediaUpload,
					{
							title: __( 'Optionally add a background image to the quote area.' ),
							onSelect: function(value){
                                setAttributes( { img: value.url } );
                            },
							type: 'image',
							value: attributes.img,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Background Image' ) 
								); 
							}
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Alignment') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'By default the quote is centered but you can choose to have it left or right aligned as well.' ),
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
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Text Color') ),
				el( wp.components.ColorPalette,{
					        label: __( 'Select a color for the quote text.' ),
                            value: attributes.text, 
                            //colors: ['#282828'], 
                            onChange: function(newVal){
								value = newVal;
                                setAttributes( { text: newVal } );
                            }
                }),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Background Color') ),
				el( wp.components.ColorPalette,{
					        label: __( 'Background Color' ),
                            value: attributes.background, 
                            //colors: ['#282828'], 
                            onChange: function(newVal){
								value = newVal;
                                setAttributes( { background: newVal } );
                            }
                }),
				
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Reveal Animation') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								//label: __( '' ),
								value: revealfx,
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
			
			const controls = el( 'div', { className: '' }
				,
				el( wp.components.TextControl, {
								label: __( 'Quote' ),
								value: attributes.quote,
								onChange: function( content ) {
									setAttributes( { quote: content } );
								},
							} 
				),
			);
			
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-format-quote" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							' Aesop Quote'
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
