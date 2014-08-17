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
			var st = '<div data-mce-resize="false" data-mce-placeholder="1" data-aesop-sc="' + window.encodeURIComponent( data ) + '" class="mceNonEditable mceItem ' + cls + '"><div class="aesop-component-bar mceNonEditable"><div class="aesop-component-controls mceNonEditable"><div class="aesop-button aesop-button-delete">&nbsp;</div><div class="aesop-button aesop-button-edit aesop-scope-' + parse[1] + '">&nbsp;</div></div><span class="mceNonEditable aesop-component-title aesop-' + parse[1] + '-title">' + parse[1] + '</span></div><div class="aesop-end">WcMgcq</div></div>';
		} else {
			var st = '<div data-mce-resize="false" data-mce-placeholder="1" data-aesop-sc="' + window.encodeURIComponent( data ) + '" class="mceItem ' + cls + '"><div class="aesop-component-bar mceNonEditable"><div class="aesop-component-controls"><div class="aesop-button aesop-button-delete">&nbsp;</div><div class="aesop-button aesop-button-edit aesop-scope-' + parse[1] + '">&nbsp;</div></div><span class="mceNonEditable aesop-component-title aesop-' + parse[1] + '-title">' + parse[1] + '</span></div><div class="aesop-component-content aesop-' + parse[1] + '">' + parse[3] + '</div></div>';
		}

		return st;
	}

	function delAesopComponent( component ) {

	}

	function restoreAesopShortcodes( content ) {
		return content.replace((/<div class="[^"]+aesop-component.*?aesop-sc="([^"]+)"[\s\S]*?aesop-component-content[^>]*>(.*?)<\/div><\/div>|<div class="[^"]+aesop-component.*aesop-sc="([^"]+)"[\s\S]*?WcMgcq<\/div><\/div>/g), function( match ){
			return shortcode( match );
		});
	}

	function shortcode( match ){
		var re_full = /<div class="[^"]+aesop-component.*?aesop-sc="([^"]+)"[\s\S]*?aesop-component-content[^>]*>(.*?)<\/div><\/div>/g;
		var re_short = /<div class="[^"]+aesop-component.*aesop-sc="([^"]+)"[\s\S]*?WcMgcq<\/div><\/div>/g;

		var parse = re_full.exec(match);

		// what if it's short?
		if ( !parse ){
			parse = re_short.exec(match);
			// what if it's not nothin'
			if ( !parse ){
				return match;
			}
			sc = window.decodeURIComponent(parse[1]);
			return sc;
		} else {
			sc = window.decodeURIComponent(parse[1]);

			// let's replace the shortcode content with any edits
			var sc_filter = /\[[^\]]*\]([^\[]*)[^\]]*\]/;
			var sc_filtered = sc_filter.exec(sc);
			sc = sc.replace(sc_filtered[1], parse[2]);
			return sc;
		}
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

	editor.onClick.add(function(editor, e) {
		if ( e.target.className.indexOf('aesop-button-delete') > -1 ) {
			var c = confirm('Are you sure you want to delete this Aesop Component?');
			if (c == true) {
				e.target.parentNode.parentNode.parentNode.parentNode.removeChild(e.target.parentNode.parentNode.parentNode);
			}
		}

		if ( e.target.className.indexOf('aesop-button-edit') > -1 ) {
			var re_scope = /aesop-scope-([a-z]*)/;
			var scope = re_scope.exec(e.target.className);

			if ( scope ) {
				// open the editor window
				window.tb_show('Component','#TB_inline?width=640&height=640&inlineId=aesop-generator-wrap',null);

				// open up the option based on scope
				var selector = '.dk_options li.' + scope[1] + ' a';
				window.jQuery(selector).click();

			}
		}
  });

	editor.addCommand( 'Aesop', function() {
		editMedia( editor.selection.getNode() );
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
