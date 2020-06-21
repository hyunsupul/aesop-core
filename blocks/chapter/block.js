/**
 * BLOCK: Chapter
 *
 * Gutenberg Block for Aesop Chapter Component.
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
	registerBlockType( 'ase/chapter', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Chapter Block', 'ASE' ), // Block title.
		icon: 'book', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			title : {
				type: 'string'
			},
			subtitle : {
				type: 'string'
			},
			bgtype : {
				type: 'string'
			},
			full : {
				type: 'boolean'
			},
			img : {
				type: 'string'
			},
			alternate_img : {
				type: 'string'
			},
			video_autoplay : {
				type: 'string'
			},
			bgcolor : {
				type: 'string'
			},
			minheight : {
				type: 'string'
			},
			maxheight : {
				type: 'string'
			},
			overlay_content : {
				type: 'string'
			},
			overlay_revealfx : {
				type: 'string',
			},
			revealfx : {
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
            var backColor = {
                backgroundColor: attributes.bgcolor,
            };
			
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Background Type') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Choose from an image or a looping video background.' ),
								value: attributes.bgtype,
								onChange: function( newVal ) {
										setAttributes({
												bgtype: newVal
										});
								},
								options: [
								  { value: 'image', label:  'Image'  },
								  { value: 'video', label: 'Video'  },
								  { value: 'color', label: 'Solid Color'  },
								],
					}
				),
				
				attributes.bgtype != 'image' && el( 'img', {src: attributes.img} ),
				attributes.bgtype != 'color' && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Chapter Image or Video URL') ),
				attributes.bgtype != 'color' && el(
					wp.editor.MediaUpload,
					{
							title: __( 'Chapter Image or Video URL' ),
							onSelect: onSelectMedia,
							type: 'image',
							value: attributes.img,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Chapter Image or Video URL' ) 
								); 
							}
					}
				),
				attributes.img && el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: function(){
											setAttributes( { img: "" } );
									  }
									},
									 __( 'Remove Media' ) 
				),	
				attributes.bgtype == 'color' && el( 'span', { className: 'wp-block-aesop-story-engine-option-label' },__('Background Color') ),
                attributes.bgtype == 'color' && el( 'div', { className: 'wp-block-aesop-story-engine-color' , style: backColor} ),
				attributes.bgtype == 'color' && el( wp.editor.ColorPalette,{
					        label: __( 'Background Color' ),
                            value: attributes.bgcolor, 
                            onChange: function(newVal){
								value = newVal;
                                setAttributes( { bgcolor: newVal } );
                            }
                }),
				attributes.bgtype == 'video' && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Alternate Image for Mobile') ),
				attributes.bgtype == 'video' && el(
					wp.editor.MediaUpload,
					{
							title: __( 'Used only on a mobile device and if the Background Type is set to Video.' ),
							onSelect: onSelectMedia,
							type: 'image',
							value: attributes.alternate_img,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Alternate Image for Mobile' ) 
								); 
							}
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Full-size Background') ),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'If set to on, the background image of the chapter will be as large as the browser window.' ),
						checked: !! attributes.full,
						onChange: function( newVal ) {
									setAttributes( { full : newVal } );
								},
					}
				),
				!attributes.full && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Minimum Height') ),
				!attributes.full && el( wp.components.TextControl, {
								label: __( 'You can enter the minimum height in number of pixels like 300px.' ),
								value: attributes.minheight,
								onChange: function( newVal ) {
									setAttributes( { minheight : newVal } );
								},
							} 
				),		
				!attributes.full && el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Maximum Height') ),
				!attributes.full && el( wp.components.TextControl, {
								label: __( 'You can enter the maximum height in number of pixels like 300px or 50%. 100% by default.' ),
								value: attributes.maxheight,
								onChange: function( newVal ) {
									setAttributes( { maxheight : newVal } );
								},
							} 
				),
				
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Overlay Content') ),
				el( wp.components.TextControl, {
						label: __( 'Text or HTML content to be displayed. You can use tags like H2, H3 etc. Important: If set, it will not show title and subtitle. The chapter menu will still use what you put in for Title.' ),
						value: attributes.overlay_content,
						onChange: function( content ) {
							setAttributes( { overlay_content: content } );
						},
					} 
				),
				attributes.overlay_content && el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Overlay Reveal Effect' ),
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
			
			const controls = el( 'div', { className: 'wp-block-aesop-story-engine-bg',style: { backgroundImage: 'url("'+attributes.img+'")', backgroundColor: attributes.bgcolor }}
				,
				el( wp.components.TextControl, {
								label: __( 'Title' ),
								value: attributes.title,
                                style: { fontSize:"20px" },
								onChange: function( newVal ) {
									setAttributes( { title : newVal } );
								},
							} 
				),
				el( wp.components.TextControl, {
								label: __( 'Subtitle: Optionally display a subtitle after the Chapter Title text.' ),
								value: attributes.subtitle,
								onChange: function( newVal ) {
									setAttributes( { subtitle : newVal } );
								},
							} 
				),
			);

			
			
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-book" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Chapter'
						)
			);

				
			var uis = [];

			uis.push(label);	
            uis.push(controls);
			
			return [ advcontrols,
				el(
					'div', // Tag type.
					{ className: "wp-block-aesop-story-engine",
					  //style: { backgroundImage: 'url("'+attributes.img+'")', backgroundSize: "cover" },
					}, 
					uis// Content inside the tag.
				)
			];	
	
					
			return retval;			

		},

		// The "save" property must be specified and must be a valid function.
		save: function( props ) {
			return null;
		},
	} );
})();
