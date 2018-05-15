/**
 * BLOCK: Map
 *
 * Gutenberg Block for Aesop Map.
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
	registerBlockType( 'ase/map', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Map Block', 'ASE' ), // Block title.
		icon: 'admin-site', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			height : {
				type: 'string'
			},
			sticky:{
				type : 'string'
			}
		},

		// The "edit" property must be a valid function.			
		edit	( { attributes, setAttributes, isSelected, className }) {		
			const advcontrols = isSelected && el( wp.blocks.InspectorControls, {},
			el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Height') ),
				el( wp.components.TextControl, {
						label: __( 'The height of the map component. By default this is set to 500px. Avoid using percentages with this option.' ),
						value: attributes.height,
						onChange: function( content ) {
							setAttributes( { height: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Sticky') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								//label: __( '' ),
								value: attributes.sticky,
								onChange: function( newVal ) {
										setAttributes({
												sticky: newVal
										});
								},
								options: [
								  { value: 'off', label:  'Off'  },
								  { value: 'left', label: 'Sticky Left'  },
								  { value: 'top', label: 'Sticky Top'  },
								  { value: 'right', label: 'Sticky Right'  },
								  { value: 'bottom', label: 'Sticky Bottom'  },
								],
					} 
				),
			);
								
			return [ advcontrols, el(
						'div', 
						{ className: "wp-block-aesop-story-engine" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-admin-site" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							__('Aesop Map')
						)
				)
			];

		},

		// The "save" property must be specified and must be a valid function.
		save: function( props ) {
			return null;
			
		},
	} );
})();
