/**
 * BLOCK: Audio
 *
 * Gutenberg Block for Aesop Audio.
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
	registerBlockType( 'ase/audio', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Audio Block', 'ASE' ), // Block title.
		icon: 'format-audio', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			src : {
				type: 'string'
			},
			title : {
				type: 'string'
			},
			viewstart:{
				type : 'string'
			},
			viewend:{
				type : 'string'
			},
			loop:{
				type : 'string'
			},
			hidden:{
				type : 'boolean'
			}
		},

		// The "edit" property must be a valid function.
		//edit: function(props ) {
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			

			var onSelectMedia = ( media ) => {
				return setAttributes({                       
										src:media.url
                                });
			};
			
			
			var onSetStart = ( state ) => {
				var value = state ? "on" : "off"; 
				setAttributes({                       
										viewstart:value
                                });
			};
			var onSetEnd = ( state ) => {
				var value = state ? "on" : "off"; 
				setAttributes({                       
										viewend:value
                                });
			};
			var onSetLoop = ( state ) => {
				var value = state ? "on" : "off"; 
				setAttributes({                       
										loop:value
                                });
			};
			var onSetHidden = ( state ) => {
				setAttributes({                       
										hidden:state
                                });
			};
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				el( wp.components.TextControl, {
						label: __( 'Optional Title' ),
						value: attributes.title,
						onChange: function( content ) {
							setAttributes( { title: content } );
						},
					} 
				),
			    el(
					wp.components.ToggleControl,
					{
						label: __( 'Start Audio When in View' ),
						checked: attributes.viewstart == "on",
						onChange: onSetStart
					}
				),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Stop Audio When Out of View' ),
						checked: attributes.viewend == "on",
						onChange: onSetEnd
					}
				),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Loop Audio' ),
						checked: attributes.loop  == "on",
						onChange: onSetLoop
					}
				),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Hidden' ),
						checked: !! attributes.hidden,
						onChange: onSetHidden
					}
				)
			);
			
			var controls = el( 'div', { className: '' }
				,
				isSelected &&  el(
					wp.editor.MediaUpload,
					{
							title: __( 'Select Audio' ),
							onSelect: onSelectMedia,
							//onChange: onSetHref,
							type: 'image',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Set Audio Source' ) 
								); }
					}
				),
				attributes.src && el(
					'audio', // Tag type.
					{ 
					  controls: true, 
					src: attributes.src}, 
					''
				)
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-format-audio" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Audio'
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
