/* global tinymce */
tinymce.PluginManager.add('aiview', function( editor ) {

	function replaceAesopShortcodes( content ) {
		return content.replace( /(\[aesop_([a-zA-Z]+)\s([^\[\]]*)]([^\[\]]+)\[\/aesop_[a-zA-Z]+]|\[aesop_([a-zA-Z]+)\s([^\[\]]*)])/g, function( match ) {
			return html( 'aesop-component', match );
		});
	}

	function html( cls, data ) {
		// let's pull out the shortcode type, options and content
		var re_full = /\[aesop_([a-zA-Z]+)\s([^\[\]]*)]([^\[\]]+)\[\/aesop_[a-zA-Z]+]/g;
		var re_short = /\[aesop_([a-zA-Z]+)\s([^\[\]]*)]/g;

		var parse = re_full.exec(data);

		if ( !parse ){
			parse = re_short.exec(data);
			var st = '<div data-mce-resize="false" data-mce-placeholder="1" data-aesop-sc="' + window.encodeURIComponent( data ) + '" class="mceItem ' + cls + '"><div class="aesop-component-bar mceNonEditable"><div class="aesop-component-controls"><div class="aesop-button aesop-button-delete">&nbsp;</div><div class="aesop-button aesop-button-edit">&nbsp;</div></div><span class="mceNonEditable aesop-component-title aesop-' + parse[1] + '-title">' + parse[1] + '</span></div></div>';
		} else {
			var st = '<div data-mce-resize="false" data-mce-placeholder="1" data-aesop-sc="' + window.encodeURIComponent( data ) + '" class="mceItem ' + cls + '"><div class="aesop-component-bar mceNonEditable"><div class="aesop-component-controls"><div class="aesop-button aesop-button-delete">&nbsp;</div><div class="aesop-button aesop-button-edit">&nbsp;</div></div><span class="mceNonEditable aesop-component-title aesop-' + parse[1] + '-title">' + parse[1] + '</span></div><div class="aesop-component-content aesop-' + parse[1] + '">' + parse[3] + '</div></div>';
		}

		return st;
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
