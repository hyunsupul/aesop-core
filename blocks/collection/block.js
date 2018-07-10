/**
 * BLOCK: Collection
 *
 * Registering a basic block with Gutenberg.
 *
 */
( function() {
	var __ = wp.i18n.__; // The __() for internationalization.
	var el = wp.element.createElement; // The wp.element.createElement() function to create elements.
	var registerBlockType = wp.blocks.registerBlockType; // The registerBlockType() to register blocks.
	var withAPIData = wp.components.withAPIData;
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
	registerBlockType( 'ase/collection', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Collection Block', 'ASE' ), // Block title.
		icon: 'feedback', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			title : {
				type: 'string',
			},
			collection : {
				type: 'string',
			},
			limit : {
				type: 'string',
			},
			columns : {
				type: 'string',
				default: '1',
			},
			splash : {
				type: 'string',
			},
			order : {
				type: 'string',
			},
			loadmore : {
				type: 'boolean',
			},
			revealfx : {
				type: 'string',
			},
		},

		// The "edit" property must be a valid function.
		edit: withAPIData( function() {
			return {
				categories: '/wp/v2/categories'
			};
		} )( function( props ) {
			if ( ! props.categories.data ) {
				return "loading !";
			}
			if ( props.categories.data.length === 0 ) {
				return "No posts";
			}
			var cats = [];
			for (var i = 0, len = props.categories.data.length; i < len; i++) {
			   cats.push({value:props.categories.data[i].id, label:props.categories.data[i].name });
			}
			
			
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-feedback" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Collection'
						)
			);
			const controls = el( 'div', { className: '' }
				,
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Category' ),
								value: props.attributes.collection,
								onChange: function( newVal ) {
										props.setAttributes({
												collection: newVal
										});
								},
								options: cats,
					}
				),
			);
			const advcontrols = props.isSelected && el( wp.editor.InspectorControls, {},
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Title') ),
				el( wp.components.TextControl, {
						label: __( 'Display an optional heading to be used within the Collection component.' ),
						value: props.attributes.title,
						onChange: function( content ) {
							props.setAttributes( { title: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Number of Stories') ),
				el( wp.components.TextControl, {
						label: __( 'How many stories should be displayed in this collection?' ),
						value: props.attributes.limit,
						onChange: function( content ) {
							props.setAttributes( { limit: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Columns') ),
				el( wp.components.TextControl, {
						label: __( 'Stories are displayed in a grid. How many columns should the grid be?' ),
						value: props.attributes.columns,
						onChange: function( content ) {
							props.setAttributes( { columns: content } );
						},
					} 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Post Order') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Choose Default to show the newest post first.' ),
								value: props.attributes.order,
								onChange: function( newVal ) {
										props.setAttributes({
												order: newVal
										});
								},
								options: [
								  { value: 'default', label:  'Default'  },
								  { value: 'reverse', label: 'Reverse'  },
								],
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Load More') ),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Setting this to on will display Load More link to load more posts.' ),
						checked: !! props.attributes.loadmore,
						onChange: function( newVal ) {
									props.setAttributes( { loadmore : newVal } );
								},
					}
				),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Reveal Animation' ),
								value: props.attributes.revealfx,
								onChange: function( newVal ) {
										props.setAttributes({
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
				),
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
