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
	registerBlockType( 'ase/timeline', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Timeline Stop', 'ASE' ), // Block title.
		icon: 'clock', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			num : {
				type: 'string'
			},
			title : {
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
			
			
			const advcontrols =  null;
			
			var controls = el( 'div', { className: '' }
				,
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Timeline Title') ),
				el( wp.components.TextControl, {
						label: __( 'The timeline title that should be displayed within the story.' ),
						value: attributes.title,
						onChange: function( content ) {
							setAttributes( { title: content } );
						},
					} 
				),
                el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Navigation Menu Item Label') ),
				el( wp.components.TextControl, {
						label: __( 'This is what is displayed for the timeline navigation menu item label. Example usage includes dates, years, colors, locations, and names.' ),
						value: attributes.num,
						onChange: function( content ) {
							setAttributes( { num: content } );
						},
					} 
				)
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-clock" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							__('Aesop Timeline')
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
