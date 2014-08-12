/* global tinymce */
tinymce.PluginManager.add('aiview', function( editor ) {

	function replaceAesopShortcodes( content ) {
		return content.replace( /\[aesop_content([^\[\]]*)]([^\[\]]+)\[\/aesop_content]/g, function( match ) {
			return html( 'aesop-content', match );
		});
	}

	function html( cls, data ) {
		data = window.encodeURIComponent( data );
		return ':placeholder:';
		//return '<img src="' + tinymce.Env.transparentSrc + '" class="wp-media mceItem ' + cls + '" ' +
		//	'data-wp-media="' + data + '" data-mce-resize="false" data-mce-placeholder="1" />';
	}

	function restoreAesopShortcodes( content ) {
		function getAttr( str, name ) {
			name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str );
			return name ? window.decodeURIComponent( name[1] ) : '';
		}

		return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
			var data = getAttr( image, 'data-wp-media' );

			if ( data ) {
				return '<p>' + data + '</p>';
			}

			return match;
		});
	}

	function editComponent( node ) {
		var content, frame, data;

/*		if ( node.nodeName !== 'IMG' ) {
			return;
		}

		// Check if the `wp.media` API exists.
		if ( typeof wp === 'undefined' || ! wp.media ) {
			return;
		}

		data = window.decodeURIComponent( editor.dom.getAttrib( node, 'data-wp-media' ) );

		// Make sure we've selected a gallery node.
		if ( editor.dom.hasClass( node, 'wp-gallery' ) && wp.media.gallery ) {
			gallery = wp.media.gallery;
			frame = gallery.edit( data );

			frame.state('gallery-edit').on( 'update', function( selection ) {
				var shortcode = gallery.shortcode( selection ).string();
				editor.dom.setAttrib( node, 'data-wp-media', window.encodeURIComponent( shortcode ) );
				frame.detach();
			});
		}*/
	}

	editor.addCommand( 'Aesop', function() {
		editMedia( editor.selection.getNode() );
	});

	editor.on( 'mouseup', function( event ) {
		var dom = editor.dom,
			node = event.target;

		function unselect() {
			dom.removeClass( dom.select( 'div.aesop-selected' ), 'aesop-selected' );
		}

	// Have to replace this handler to recognize all of the different components
/*		if ( node.nodeName === 'DIV' && dom.getAttrib( node, 'data-wp-media' ) ) {
			// Don't trigger on right-click
			if ( event.button !== 2 ) {
				if ( dom.hasClass( node, 'wp-media-selected' ) ) {
					editMedia( node );
				} else {
					unselect();
					dom.addClass( node, 'wp-media-selected' );
				}
			}
		} else {
			unselect();
		}*/
	});

	// Display gallery, audio or video instead of img in the element path
	editor.on( 'ResolveName', function( event ) {
		var dom = editor.dom,
			node = event.target;

		/*if ( node.nodeName === 'DIV' && dom.getAttrib( node, 'data-wp-media' ) ) {
			if ( dom.hasClass( node, 'wp-gallery' ) ) {
				event.name = 'gallery';
			}
		}*/
	});

	editor.on( 'BeforeSetContent', function( event ) {
		event.content = replaceAesopShortcodes( event.content );
	});

	editor.on( 'PostProcess', function( event ) {
		if ( event.get ) {
			event.content = restoreAesopShortcodes( event.content );
		}
	});
});
