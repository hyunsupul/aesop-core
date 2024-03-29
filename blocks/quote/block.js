/**
 * BLOCK: Quote
 *
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
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
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
			size : {
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
            
            // form color
            var textColor = {
                backgroundColor: attributes.text,
            };
            var backColor = {
                backgroundColor: attributes.background,
            };
			
			const advcontrols = isSelected && el( wp.blockEditor.InspectorControls, {},
				
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
					wp.blockEditor.MediaUpload,
					{
							title: __( 'Optionally add a background image to the quote area.' ),
							onSelect: function(value){
                                setAttributes( { img: value.url } );
                            },
							type: 'image',
							value: attributes.img,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button',
									  style: { width: '100%' },
									  onClick: obj.open
									},
									 __( 'Set Background Image' ) 
								); 
							}
					}
				),
				attributes.img && el( wp.components.Button, {
									  className:  'button',
									  style: { width: '100%' },
									  onClick: function(){
											setAttributes( { img: "" } );
									  }
									},
									 __( 'Remove Image' ) 
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
				el( 'span', { className: 'wp-block-aesop-story-engine-option-label' },__('Text Color') ),
                el( 'div', { className: 'wp-block-aesop-story-engine-color' , style: textColor} ),
				el( wp.blockEditor.ColorPalette,{
					        label: __( 'Select a color for the quote text.' ),
                            value: attributes.text, 
                            onChange: function(newVal){
								value = newVal;
                                setAttributes( { text: newVal } );
                            }
                }),
				el( 'span', { className: 'wp-block-aesop-story-engine-option-label' },__('Background Color') ),
                el( 'div', { className: 'wp-block-aesop-story-engine-color' , style: backColor} ),
				el( wp.blockEditor.ColorPalette,{
					        label: __( 'Background Color' ),
                            value: attributes.background, 
                            onChange: function(newVal){
								value = newVal;
                                setAttributes( { background: newVal } );
                            }
                }),
				
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Quote Font Size') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								//label: __( '' ),
								value: attributes.size,
								onChange: function( newVal ) {
										setAttributes({
												size: newVal
										});
								},
								options: [
								  { value: '1', label:  __('1')  },
								  { value: '2', label: __('2')  },
								  { value: '3', label: __('3')  },
								  { value: '4', label: __('4')  },
								  { value: '5', label: __('5')  },
								],
					}
				),
				
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
			
			const controls = el( 'div', { className: 'wp-block-aesop-story-engine-bg',style: { backgroundImage: 'url("'+attributes.img+'")', color: attributes.text, backgroundColor: attributes.background  }}
				,
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Quote') ),
				el( wp.components.TextControl, {
								value: attributes.quote,
								onChange: function( content ) {
									setAttributes( { quote: content } );
								},
							} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Cite') ),
				el( wp.components.TextControl, {
						label: __( 'Provide an optional cite or source for the quote.' ),
						value: attributes.cite,
						onChange: function( content ) {
							setAttributes( { cite: content } );
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
