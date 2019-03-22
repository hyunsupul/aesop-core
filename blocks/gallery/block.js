/**
 * BLOCK: Gallery
 *
 * Registering a basic block with Gutenberg.
 *
 */
( function() {
	var __ = wp.i18n.__; // The __() for internationalization.
	var el = wp.element.createElement; // The wp.element.createElement() function to create elements.
	var registerBlockType = wp.blocks.registerBlockType; // The registerBlockType() to register blocks.
	var withSelect = wp.data.withSelect;
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
	registerBlockType( 'ase/gallery', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Gallery Block', 'ASE' ), // Block title.
		icon: 'format-gallery', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			galleryname : {
				type: 'string',
			},
			id : {
				type: 'string',
			},
			revealfx : {
				type: 'string',
			},
			overlay_revealfx : {
				type: 'string',
			}
		},


		edit: withSelect( function( select ) {
			return {
				aesop_galleries: select( 'core' ).getEntityRecords( 'postType', 'ai_galleries',{ per_page: -1 } )
			};
		}
		)( function( props ) {
			
			if ( ! props.aesop_galleries ) {
				return "loading !";
			}
			
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-format-gallery" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Gallery'
						)
			);
			
			if ( props.aesop_galleries.length === 0 ) {
				var uis = [];

				uis.push(label);
				uis.push(__( 'No Galleries have been created.' ));
				return [
					el(
						'div', // Tag type.
						{ className: "wp-block-aesop-story-engine" }, 
						uis// Content inside the tag.
					)
				];	
			}
			
			var galleries = [];
			for (var i = 0, len = props.aesop_galleries.length; i < len; i++) {
			   galleries.push({value:props.aesop_galleries[i].id, label:props.aesop_galleries[i].title.rendered });
			}
			
			if (!props.attributes.id) {
				props.setAttributes({
					id: props.aesop_galleries[0].id
				});
			}
			
			
			const controls = el( 'div', { className: '' }
				,
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Galleries' ),
								value: props.attributes.id,
								onChange: function( newVal ) {
										props.setAttributes({
												id: newVal
										});
								},
								options: galleries,
					}
				),
			);
			const advcontrols = props.isSelected && el( wp.editor.InspectorControls, {},
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Animation effect when the component is revealed. Not applied to Parallax Gallery' ),
								value: props.attributes.revealfx,
								onChange: function( newVal ) {
										props.setAttributes({
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
					},
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Reveal animation effect for the overlay content. Only applied to Hero Gallery' ),
								value: props.attributes.overlay_revealfx,
								onChange: function( newVal ) {
										props.setAttributes({
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
		} ),

		// The "save" property must be specified and must be a valid function.
		save: function( props ) {
			return null;
		},
	} );
})();
