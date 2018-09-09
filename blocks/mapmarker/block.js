/**
 * BLOCK: Map
 *
 * Gutenberg Block for Aesop Map Marker.
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
	registerBlockType( 'ase/mapmarker', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Map Marker', 'ASE' ), // Block title.
		icon: 'location', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			title : {
				type: 'string'
			},
			hidden:{
				type : 'string'
			}
		},

		// The "edit" property must be a valid function.
			
		edit	( { attributes, setAttributes, isSelected, className }) {		
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
			el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Title') ),
				el( wp.components.TextControl, {
						//label: __( '' ),
						value: attributes.title,
						onChange: function( content ) {
							setAttributes( { title: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Hidden') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								//label: __( '' ),
								value: attributes.hidden,
								onChange: function( newVal ) {
										setAttributes({
												hidden: newVal
										});
								},
								options: [
								  { value: 'off', label:  'Off'  },
								  { value: 'on', label: 'On'  },
								],
					} 
				),
			);
								
			return [ advcontrols, el(
						'div', 
						{ className: "wp-block-aesop-story-engine" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-location" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							__('Aesop Map Marker')
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
