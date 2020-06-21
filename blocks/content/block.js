/**
 * BLOCK: Content
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
	registerBlockType( 'ase/content', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Content Block', 'ASE' ), // Block title.
		icon: 'editor-aligncenter', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			color : {
				type: 'string',
				default: '#FFFFFF',
			},
			background : {
				type: 'string',
				default: '#333333',
			},
			width : {
				type: 'string',
				default: '100%',
			},
			component_width : {
				type: 'string',
				default: '100%',
			},
			height : {
				type: 'string',
			},
			columns : {
				type: 'string',
				default: '1',
			},
			position : {
				type: 'string',
			},
			innerposition : {
				type: 'string',
			},
			img : {
				type: 'string',
			},
			imgposition : {
				type: 'string',
			},
			imgrepeat : {
				type: 'string',
				default: 'norepeat',
			},
			imgsize : {
				type: 'string',
			},
			disable_bgshading : {
				type: 'string',
			},
			floatermedia : {
				type: 'string',
			},
			floaterposition : {
				type: 'string',
			},
			floaterdirection : {
				type: 'string',
			},
			
			overlay_revealfx : {
				type: 'string',
			},
			
			revealfx : {
				type: 'string',
			},
			
			content : {
				type: 'string',
			},
		},

		// The "edit" property must be a valid function.
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			
			var id = attributes.id;
			var revealfx = attributes.revealfx;
            var textColor = {
                backgroundColor: attributes.color,
            };
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {value: id,},
				el( 'span', { className: 'wp-block-aesop-story-engine-option-label' },__('Color of Text') ),
                el( 'div', { className: 'wp-block-aesop-story-engine-color' , style: textColor} ),
				el( wp.editor.ColorPalette,{
					        label: __( 'Set a color to be used for the main text.' ),
                            value: attributes.color, 
                            onChange: function(value){
                                setAttributes( { color: value } );
                            }
                }),
				!attributes.img && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Background Color') ),
				!attributes.img && el( wp.components.ColorPalette,{
					        label: __( 'Choose an optional background color for the content component.' ),
                            value: attributes.background, 
                            onChange: function(value){
                                setAttributes( { background: value } );
                            }
                }),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Background Image') ),
				attributes.img && el( 'img', {src: attributes.img} ),
				el(
					wp.editor.MediaUpload,
					{
							title: __( attributes.img ),
							onSelect:function(value){
                                setAttributes( { img: value.url } );
                            },
							type: 'image',
							value: attributes.img,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  style: { width: '100%' },
									  onClick: obj.open
									},
									 __( 'Select Media' ) 
								); 
							}
					}
				),
				attributes.img && el( wp.components.Button, {
									  className:  'button button-large',
									  style: { width: '100%' },
									  onClick: function(){
											setAttributes( { img: "" } );
									  }
									},
									 __( 'Remove Image' ) 
				),
				
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Width of Content') ),
				el( wp.components.TextControl, {
						label: __( 'You can enter the size such as 40% or 500px. Enter the word content to restrict the width to that of the main text.' ),
						value: attributes.width,
						onChange: function( content ) {
							setAttributes( { width: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Width of Component') ),
				el( wp.components.TextControl, {
						label: __( 'You can enter the size such as 40% or 500px. Enter the word content to restrict the width to that of the main text.' ),
						value: attributes.component_width,
						onChange: function( content ) {
							setAttributes( { component_width: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Number of Columns') ),
				el( wp.components.TextControl, {
						label: __( 'Optionally set the number of columns that the text should be split into. For example, 2 will make 2 columns of text.' ),
						value: attributes.columns,
						onChange: function( content ) {
							setAttributes( { columns: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Content Block Alignment') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'This option allows you to float the text block to the left or right. This is useful when using a width like 300px.' ),
								value: attributes.position,
								onChange: function( newVal ) {
										setAttributes({
												position: newVal
										});
								},
								options: [
								  { value: 'none', label:  'None'  },
								  { value: 'left', label: 'Left'  },
								  { value: 'right', label: 'Right'  }
								],
					}
				),
				attributes.content && el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Reveal animation effect for the content.' ),
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
								  { value: 'off', label:  __('Off')  },
								  { value: 'inplace', label: __('In Place')  },
								  { value: 'inplaceslow', label: __('In Place Slow')  },
								  { value: 'frombelow', label: __('From Below')  },
								  { value: 'fromleft', label: __('From Left')  },
								  { value: 'fromright', label: __('From Right') },
								],
					}
				),
				
			);
			
			const controls = el( 'div', { className: 'wp-block-aesop-story-engine-bg',style: { backgroundImage: 'url("'+attributes.img+'")' , color:attributes.color, backgroundColor: attributes.background} }
				,
				
				el(  wp.components.TextareaControl, //todo: replace with wp.blocks.RichText, 
				{
								label: __( 'Content' ),
								value: attributes.content,
								//style: { color: attributes.color },
								onChange: function( newVal ) {
									setAttributes( { content : newVal } );
								},
							} 
				),
			);
			
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-editor-aligncenter" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Content'
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
