/**
 * BLOCK: Document
 *
 * Gutenberg Block for Aesop Document.
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
	registerBlockType( 'ase/document', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Document', 'ASE' ), // Block title.
		icon: 'format-aside', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			type  : {
				type: 'string'
			},
			src : {
				type: 'string'
			},
			caption : {
				type: 'string'
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
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Document Type' ),
								value: attributes.type,
								onChange: function( newVal ) {
										setAttributes({
												type: newVal
										});
								},
								options: [
								  { value: 'pdf', label:  'PDF'  },
								  { value: 'image', label: 'Image'  }
								],
					}
				),
				el( wp.components.TextControl, {
						label: __( 'Caption' ),
						value: attributes.caption,
						onChange: function( content ) {
							setAttributes( { caption: content } );
						},
					} 
				)
			);
			
			var controls = el( 'div', { className: '' }
				,
				isSelected &&  el(
					wp.blocks.MediaUpload,
					{
							title: __( 'Select File' ),
							onSelect: onSelectMedia,
							type: 'image',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Set File Source' ) 
								); }
					}
				)
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-format-aside" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							__('Aesop Document')
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
