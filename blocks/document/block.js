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
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			type  : {
				type: 'string'
			},
			src : {
				type: 'string'
			},
			title : {
				type: 'string'
			},
			caption : {
				type: 'string'
			},
			download : {
				type: 'string'
			}
		},

		// The "edit" property must be a valid function.
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			

			var onSelectMedia = ( media ) => {
				return setAttributes({                       
					src:media.url // fixed by BORAY
                });
			};
			
			
			const advcontrols = isSelected && el( wp.blockEditor.InspectorControls, {},
				
				el( wp.components.TextControl, {
						label: __( 'Title' ),
						value: attributes.title,
						onChange: function( content ) {
							setAttributes( { title: content } );
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
				(attributes.type != 'download') && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Download Link') ),
				(attributes.type != 'download') && el(
					wp.components.ToggleControl,
					{
						label: __( 'Add a download link.' ),
						checked: attributes.download =='on',
						onChange: function( newVal ) {
										
										if (newVal) {
											setAttributes({
												download: 'on'
											});
										} else {
											setAttributes({
												download: 'off'
											});
										}
									
								},
					}
				),
			);
			
			var controls = el( 'div', { className: '' }
				,
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
								  { value: 'image', label: 'Image'  },
								  { value: 'ms', label:  'Microsoft'  },
								  { value: 'download', label: 'Download Link'  }
								],
					}
				),
				isSelected &&  el(
					wp.blockEditor.MediaUpload,
					{
							title: __( 'Select File' ),
							onSelect: onSelectMedia,
							type: '',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Set File Source' ) 
								); }
					}
				),
				attributes.src && el( 'div', { className: '' },attributes.src ),
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
