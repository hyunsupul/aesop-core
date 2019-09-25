/**
 * BLOCK: Video
 *
 * Gutenberg Block for Aesop Video.
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
	registerBlockType( 'ase/video', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Video', 'ASE' ), // Block title.
		icon: 'format-video', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'aesop-story-engine', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			src : {
				type: 'string',
				default: 'youtube',
			},
			width : {
				type: 'string',
				default: '100%',
			},
			vidwidth : {
				type: 'string'
			},
			vidheight : {
				type: 'string'
			},
			id : {
				type: 'string'
			},
			hosted : {
				type: 'string'
			},
			caption : {
				type: 'string'
			},
			align : {
				type: 'string'
			},
			autoplay:{
				type : 'string'
			},
			loop:{
				type : 'string'
			},
			disable_for_mobile:{
				type : 'string'
			},
			mute:{
				default: 'off',
				type : 'string'
			},
			controls:{
				type : 'string'
			},
			viewstart:{
				type : 'string'
			},
			viewend:{
				type : 'string'
			},
			// poster_frame ATTRIBUTE ADDED BY BORAY
			poster_frame:{
				type : 'string'
			},
			overlay_revealfx : {
				type: 'string',
			},
			revealfx : {
				type: 'string',
			},
			nocookies:{
				type : 'string'
			},
			show_subtitles:{
				type : 'string'
			},
			lang_pref:{
				type : 'string'
			},
		},

		// The "edit" property must be a valid function.
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			
			var onSelectMedia = ( media ) => {
				return setAttributes({                       
										hosted:media.url
                                });
			};
			
			var canAutoPlay = (attributes) => {
				return attributes.src == 'youtube';
			}

			var checked = ( val ) => {
				return val == 'on' || val == 1;
			}

			var setChecked = ( attr ) => {
				return ( val ) => {
					setAttributes({
						[attr]: val ? 'on' : 'off'
					});
				}
			}

			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Caption') ),
				el( wp.components.TextControl, {
						label: __( 'Optionally display a caption below the video.' ),
						value: attributes.caption,
						onChange: function( content ) {
							setAttributes( { caption: content } );
						},
					} 
				),
				(attributes.src == 'youtube')
				&& el(
				wp.components.ToggleControl,
				{
					label: __( 'No cookies' ),
					checked: checked(attributes.nocookies),
					onChange: setChecked( 'nocookies' )
				}),
				el( wp.components.TextControl, {
						label: __( 'Video (max) width' ),
						value: attributes.width,
						onChange: function( content ) {
							setAttributes( { width: content } );
						}
					}
				),
				el( wp.components.TextControl, {
						label: __( 'Iframe width' ),
						value: attributes.vidwidth,
						onChange: function( content ) {
							setAttributes( { vidwidth: content } );
						},
					}
				),
				el( wp.components.TextControl, {
						label: __( 'Iframe height' ),
						value: attributes.vidheight,
						onChange: function( content ) {
							setAttributes( { vidheight: content } );
						},
					}
				),
				(attributes.src == 'youtube' )
				&& el(
				wp.components.ToggleControl,
				{
					label: __( 'Show controls' ),
					checked: checked(attributes.controls),
					onChange: setChecked( 'controls' )
				}
				),
				(attributes.src == 'youtube' || attributes.src == 'vimeo' || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Mute Video. Using Youtube or Vimeo, you need to mute the video to have autoplay work.' ),
						checked: attributes.mute =='on',
						onChange: function( newVal ) {				
										if (newVal) {
											setAttributes({
												mute: 'on'
											});
										} else {
											setAttributes({
												mute: 'off'
											});
										}
									
								},
					}
				),
				(((attributes.src == 'youtube' || attributes.src == 'vimeo') && attributes.mute=='on') || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Autoplay' ),
						checked: attributes.autoplay =='on',
						onChange: function( newVal ) {				
										if (newVal) {
											setAttributes({
												autoplay: 'on'
											});
										} else {
											setAttributes({
												autoplay: 'off'
											});
										}
								},
					}
				),
			    (((attributes.src == 'youtube' || attributes.src == 'vimeo') && attributes.mute=='on') || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Start Video When in View' ),
						checked: checked(attributes.viewstart),
						onChange: setChecked( 'viewstart' )
					}
				),
				(((attributes.src == 'youtube' || attributes.src == 'vimeo') && attributes.mute=='on') || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Stop Video When Out of View' ),
						checked: checked(attributes.viewend),
						onChange: setChecked( 'viewend' )
					}
				),
				(((attributes.src == 'youtube' || attributes.src == 'vimeo') && attributes.mute=='on') || attributes.src == 'self')
				&& el(
					wp.components.ToggleControl,
					{
						label: __( 'Loop Video' ),
						checked: checked(attributes.loop),
						onChange: setChecked( 'loop' )
					}
				),
				(attributes.src == 'youtube')
				&& el(
				wp.components.ToggleControl,
				{
					label: __( 'Show Subtitles. Does not work with auto-generated subtitles. Must specify the language code below.' ),
					checked: checked(attributes.show_subtitles),
					onChange: setChecked( 'show_subtitles' )
				}),
				(attributes.src == 'youtube')
				&& el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Default subtitle language') ),
				(attributes.src == 'youtube')
				&& el( wp.components.TextControl, {
						label: __( 'Language code of the default subtitle language (e.g "fr").' ),
						value: attributes.lang_pref,
						onChange: function( pref ) {
							setAttributes( { lang_pref: pref } );
						},
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Disable video on Mobile Devices.') ),
				el(
					wp.components.ToggleControl,
					{
						label: __( 'Disable video on Mobile Devices. Must specify the Poster Frame image.' ),
						checked: checked(attributes.disable_for_mobile),
						onChange: setChecked( 'disable_for_mobile' )
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Poster Frame.') ),
				el(
					wp.editor.MediaUpload,
					{
							title: __( 'Image to display before the video plays if the target is self. Or the image to display if the video is disabled for mobile. Click <em>Select Media</em> to open the WordPress Media Library.' ),
							onSelect: function( content ) {
								setAttributes( { poster_frame: content } );
							},
							type: 'image',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  style: { width: '100%' },
									  onClick: obj.open
									},
									 __( 'Select Media' ) 
								); }
					}
				),
				attributes.poster_frame && el( wp.components.Button, {
									  className:  'button button-large',
									  style: { width: '100%' },
									  onClick: function(){
											setAttributes( { poster_frame: "" } );
									  }
									},
									 __( 'Remove Image' ) 
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Overlay Content') ),
				el( wp.components.TextControl, {
						label: __( 'Text or HTML content to be overlayed. You can use tags like H2, H3 etc.' ),
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
				)
			);
			
			var controls = el( 'div', { className: '' },
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Video Source') ),
				el(
					wp.components.SelectControl, 
					{ 
								type: 'string',
								label: __( 'Choose an available source for the video.' ),
								value: attributes.src,
								onChange: function( newVal ) {
										setAttributes({
												src: newVal
										});
								},
								options: [
								  { value: 'youtube', label:  'Youtube'  },
								  { value: 'vimeo', label: 'Vimeo'  },
								  { value: 'kickstarter', label: 'Kickstarter'  },
								  { value: 'viddler', label: 'Viddler'  },
								  { value: 'instagram', label: 'Instagram'  },
								  { value: 'dailymotion', label: 'Dailymotion'  },
								  { value: 'vine', label: 'Vine'  },
								  { value: 'wistia', label: 'Wistia'  },
								  { value: 'self', label: 'Self Hosted'  }
								],
					}
				),
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Video ID') ),
				attributes.src != 'self' && el( wp.components.TextControl, {
						label: __( 'The video ID can be found within the video URL and typically looks something like s8J2Ge4. For Viddler videos, enter the full URL instead.' ),
						value: attributes.id,
						onChange: function( content ) {
							setAttributes( { id: content } );
						},
					} 
				),
				attributes.src == 'self' && el(
					wp.editor.MediaUpload,
					{
							title: __( 'Select Video File' ),
							onSelect: onSelectMedia,
							type: 'image',
							value: attributes.src,
							render: function( obj ) {
										return el( wp.components.Button, {
									  className:  'button button-large',
									  onClick: obj.open
									},
									 __( 'Set Video File' ) 
								); }
					}
				)
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-format-video" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Video'
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
