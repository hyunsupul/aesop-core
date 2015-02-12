(function($) {
/* global tinymce */
tinymce.PluginManager.add('aiview', function( editor ) {

	// process any aesop shortcodes in the tinymce content
	function replaceAesopShortcodes( content ) {
		return content.replace( /(\[aesop_([a-zA-Z_]+)\s([^\[\]]*)]([^\[\]]+)\[\/aesop_[a-zA-Z_]+]|\[aesop_([a-zA-Z_]+)\s?([^\[\]]*)])/g, function( match ) {
			return html( 'aesop-component', match );
		});
	}

	// return the html div equivalent of the shortcodes
	function html( cls, data ) {
		// let's pull out the shortcode type, options and content
		var re_full = /\[aesop_([a-zA-Z_]+)\s([^\[\]]*)]([^\[\]]+)\[\/aesop_[a-zA-Z_]+]/g;
		var re_short = /\[aesop_([a-zA-Z_]+)\s?([^\[\]]*)]/g;
		// let's clear the line break we added on items that were already parsed as p
		var re_cleaner = /(<\/p>[\s]*<p><\/p>\s<p>)[\s]*$/;
		// let's fix the closing tag on those items without a forced line break
		var re_cleaner_short = /(<\/p>[\s]*<p>)[\s]*$/;

		var parsed = re_full.exec(data);

		if ( !parsed ){
			parsed = re_short.exec(data);
			var parsedShortcode = parse(parsed);
			var componentTitle = typeof parsedShortcode.title == 'string' && parsedShortcode.title.length > 0 ? ': ' + parsedShortcode.title : '';
			var st = '<div data-mce-resize="false" data-mce-placeholder="1" data-aesop-sc="' + window.encodeURIComponent( data ) + '" class="mceItem aesop-component-short ' + cls + '"><div class="aesop-component-mask mceNonEditable unselectable" contenteditable="false"></div><div class="aesop-component-bar" contenteditable="false"><div class="aesop-component-controls"><div title="Delete Component" class="aesop-button aesop-button-delete">&nbsp;</div><div title="Clone Component" class="aesop-button aesop-button-clone">&nbsp;</div><div title="Edit Component" class="aesop-button aesop-button-edit aesop-scope-' + parsed[1] + '">&nbsp;</div><div title="Cut Component / CTRL + ALT + ENTER to Paste" class="aesop-button aesop-button-clipboard">&nbsp;</div></div><span class="mceNonEditable aesop-component-title unselectable aesop-' + parsed[1] + '-title">' + parsed[1].replace(/_/g, " ") + componentTitle + '</span></div><div class="aesop-end">WcMgcq</div></div>';
		} else {
			var parsedShortcode = parse(parsed);
			var componentTitle = typeof parsedShortcode.title == 'string' && parsedShortcode.title.length > 0 ? ': ' + parsedShortcode.title : '';
			parsed[3] = parsed[3].replace( re_cleaner, '');
			parsed[3] = parsed[3].replace( re_cleaner_short, '');
			var st = '<div data-mce-resize="false" data-mce-placeholder="1" data-aesop-sc="' + window.encodeURIComponent( data ) + '" class="mceItem aesop-component-long ' + cls + '"><div class="aesop-component-mask mceNonEditable unselectable" contenteditable="false"></div><div class="aesop-component-bar" contenteditable="false"><div class="aesop-component-controls"><div title="Delete Component" class="aesop-button aesop-button-delete">&nbsp;</div><div title="Clone Component" class="aesop-button aesop-button-clone">&nbsp;</div><div title="Edit Component" class="aesop-button aesop-button-edit aesop-scope-' + parsed[1] + '">&nbsp;</div><div title="Cut Component / CTRL + ALT + ENTER to Paste" class="aesop-button aesop-button-clipboard">&nbsp;</div></div><span class="mceNonEditable aesop-component-title unselectable aesop-' + parsed[1] + '-title">' + parsed[1].replace(/_/g, " ") + componentTitle + '</span></div><div class="aesop-component-content aesop-' + parsed[1] + '"><p>' + parsed[3] + '</p></div></div>';
		}

		return st;
	}

	// restore the Aesop shortcode from the div placeholder
	function restoreAesopShortcodes( content ) {
		return content.replace((/<div[^>]+?class="[^"]+?aesop-component-long.*?aesop-sc="([^"]+)"[\s\S]*?aesop-component-content[^>]*?>(.*?)<\/div>[\s]*?<\/div>|<div class="[^"+]+?aesop-component-short.*?aesop-sc="([^"]+)"[\s\S]*?WcMgcq<\/div><\/div>/g), function( match ){
			return shortcode( match );
		});
	}

	// return the shortcode equivalent for any matches and update the content with the new version
	function shortcode( match ){
		var re_full = /<div[^>]+?class="[^"]+?aesop-component.*?aesop-sc="([^"]+)"[\s\S]*?aesop-component-content[^>]*?>(.*?)<\/div>[\s]*?<\/div>/g;
		var re_short = /<div class="[^"+]+?aesop-component.*?aesop-sc="([^"]+)"[\s\S]*?WcMgcq<\/div><\/div>/g;
		var re_clean = /<div\s*class="clipboardControl[^>]+?><div\s*class="aesop[^>]+>\s*<\/div><\/div>/g;

		match = match.replace(re_clean, '');
		//var re_clean = /<p> <\/p>\s*/g;

		var parse = re_full.exec(match);

		// what if it's short?
		if ( !parse ){
			parse = re_short.exec(match);
			// what if it's not nothin'
			if ( !parse ){
				return match;
			}
			var sc = window.decodeURIComponent(parse[1]);
			return '<p>' + sc + '</p>';

		} else {
			var sc = window.decodeURIComponent(parse[1]);

			// let's replace the shortcode content with any edits
			var sc_filter = /\[[^\]]*\]([^\[]*)[^\]]*\]/;
			var sc_filtered = sc_filter.exec(sc);
			if( sc_filtered != null ){
				parse[2] = parse[2].replace(/^<p>\W<\/p>/,'');
				sc = sc.replace(sc_filtered[1], parse[2]);
			}

			return '<p>' + sc + '</p>';
		}
	}

	// parse the shortcode and turn it into an array
	function parse( sc ) {
		var re_full = /\[aesop_([a-zA-Z_]+)\s([^\[\]]*)]([^\[\]]+)\[\/aesop_[a-zA-Z]+]/g;
		var re_short = /\[aesop_([a-zA-Z_]+)\s([^\[\]]*)]/g;
		var re_clean = /<br data-mce-bogus="1">/g;
		var re_slice = /([^\s]+="[^"]+")/g
		var re_parse = /([^\s]+)\s?/g;

		var parse = re_full.exec(sc);

		// what if it's short?
		if ( !parse ){
			parse = re_short.exec(sc);
			// what if it's not nothin'
			if ( !parse ){
				return sc;
			}
		}

		var result;
		var attrs = [];

		// loop through the matches and throw them into an array
		while( (result = re_slice.exec(parse[2])) !== null ) {
			attrs.push(result[1]);
		}

		var ai_map = [];

		// split based on equal sign
		attrs.forEach(function(attr) {
			attr = attr.split('=');

			var attr_key = attr[0];
			var attr_value = attr[1];

			// trim first and last character to get rid of the quotes
			attr_value = attr_value.slice(0, -1);
			ai_map[attr_key] = attr_value.substring(1);
		});

		if (typeof parse[3] !== "undefined") {
			ai_map.content = parse[3].replace(re_clean, '');
		}

		return ai_map;
	}

	function removeComponent( c ) {
		c.parentNode.removeChild(c);
	}

	function hideComponent( c ) {
		if( c.style.display !== "none" ) {
			c.style.display = "none";
		}
	}

	function showComponent( c ) {
		if( c.style.display !== "block" ) {
			c.style.display = "block";
		}
	}

	function restoreComponents( cls ) {
		var components = timymce.activeEditor.dom.select('.' + cls);
	}

	// add the clipboard control if the clipboard is active - p is the hidden component
	function addClipboardControl( p ) {
		window.clipboardSource = p;
		var ed = tinymce.activeEditor;

		var el = ed.dom.create('div', { 'class' : 'clipboardControl mceNonEditable unselectable' }, '<div class="aesop-button aesop-button-paste mceNonEditable unselectable" title="Ctrl + Alt + Enter to Paste">&nbsp;</div>');
		ed.getBody().insertBefore(el, ed.getBody().firstChild);
		window.clipboardControl = $(el);
	}

	function removeClipboardControl() {
		var ed = tinymce.activeEditor;
		var c = ed.dom.select('.clipboardControl');
		ed.dom.remove(c);

		delete window.clipboard;
		delete window.clipboardSource;
		delete window.clipboardControl;
	}

	function pasteClipboard() {
		var p = window.clipboardSource;
		var ed = tinymce.activeEditor;
		ed.dom.remove(p);
		showComponent(window.clipboard);
		ed.execCommand('mceInsertRawHTML', false, window.clipboard.outerHTML);
		removeClipboardControl();
	}

	function cloneComponent( p ) {
		var ed = tinymce.activeEditor;
		//jQuery(p).focusEnd();
		jQuery(p.outerHTML).insertAfter( p );
		//ed.execCommand('mceInsertRawHTML', false, 'hello');
	}

	jQuery.fn.setCursorPosition = function(position){
    if(this.length == 0) return this;
    return $(this).setSelection(position, position);
	}

	jQuery.fn.setSelection = function(selectionStart, selectionEnd) {
	    if(this.length == 0) return this;
	    input = this[0];

	    if (input.createTextRange) {
	        var range = input.createTextRange();
	        range.collapse(true);
	        range.moveEnd('character', selectionEnd);
	        range.moveStart('character', selectionStart);
	        range.select();
	    } else if (input.setSelectionRange) {
	        input.focus();
	        input.setSelectionRange(selectionStart, selectionEnd);
	    }

	    return this;
	}

	jQuery.fn.focusEnd = function(){
	    this.setCursorPosition(this.val().length);
	            return this;
	}

	// handle the click events
	editor.onClick.add(function(ed, e) {

		delete window.ailocked;
		delete window.aiactive;

		if( typeof $(ed.selection.getNode()).parents('.aesop-component')[0] !== "undefined" ) {
			window.aiactive = true;
		}

		// let's handle the delete button
		if ( e.target.className.indexOf('aesop-button-delete') > -1 ) {
			var c = confirm('Are you sure you want to delete this Aesop Component?');
			if (c === true) {
				e.target.parentNode.parentNode.parentNode.parentNode.removeChild(e.target.parentNode.parentNode.parentNode);
			}
			//$(ed).click();
			//tinymce.activeEditor.execCommand('mceFocus',false);
			delete window.aiactive;
			window.ailocked = true;
			tinymce.execCommand('mceFocus',false,ed.id);
			//ed.setCursorLocation();
		}

		// let's handle the edit button
		if ( e.target.className.indexOf('aesop-button-edit') > -1 ) {

			var re_scope = /aesop-scope-([a-z_]*)/;
			var scope = re_scope.exec(e.target.className);

			var ai_parent = e.target.parentNode.parentNode.parentNode;

			var sc = restoreAesopShortcodes(ai_parent.outerHTML);

			ai_parent.setAttribute("id", 'aesop-generator-editing');

			if ( scope ) {
				$('body').toggleClass('modal-open');
				$('body').addClass('modal-updating');
				$('#aesop-generator-wrap').toggleClass('aesop-generator-open');

				// open up the option based on scope
				var selector = '.dk_options li.' + scope[1] + ' a';
				$(selector). click();

				var attrs = parse(sc);

				for (var key in attrs) {
					if ( key === 'content' ) {
						$('#aesop-generator-content').val(attrs[key]);
					}	else {
						$('#aesop-generator-settings [name="' + key + '"]').val(attrs[key]);
					}
				}
			}
			ed.selection.collapse(false);
		}

		// let's handle the clipboard button
		if (e.target.className.indexOf('aesop-button-clipboard') > -1 ) {
			var ai_parent = e.target.parentNode.parentNode.parentNode;
			window.clipboard = ai_parent;

			hideComponent(ai_parent);
			addClipboardControl(ai_parent);
			ed.selection.collapse(false);
		}

		// let's handle the clone button
		if (e.target.className.indexOf('aesop-button-clone') > -1 ) {
			var ai_parent = e.target.parentNode.parentNode.parentNode;
			cloneComponent( ai_parent );
			ed.selection.collapse(false);
		}
  });

	// if they press enter while inside the editor, move to the next line
	editor.onKeyDown.add(function(ed, e) {
		delete window.ailocked;
		if( e.keyCode===13 && !e.ctrlKey && !e.shiftKey && !e.altKey) {
			var container = ed.selection.getNode();
			var component = $(container).parents('.aesop-component');
			if ( $(container).parents('.aesop-component')[0] ) {
				e.preventDefault();
				e.stopPropagation();
				var insertion = $('<p><br/></p>').insertAfter( component );
				insertion.uniqueId();

				var uniqueId = insertion.attr('id');
				var element = ed.dom.select('#' + uniqueId)[0];
				ed.selection.setCursorLocation(element);
			}
		}

		if( e.ctrlKey && e.altKey && e.keyCode===13 ) {
			e.preventDefault();
			e.stopPropagation();
			if ( typeof window.clipboard === "undefined" ) {
				alert('Clipboard is empty');
			} else if ( typeof window.aiactive !== 'undefined' ) {
				alert('Please do not paste into an existing aesop component');
			} else {
				pasteClipboard();
			}
		}

	});

	editor.onKeyUp.add(function(ed, e) {
		if( typeof $(ed.selection.getNode()).parents('.aesop-component')[0] !== "undefined" ) {
			window.aiactive = true;
		} else {
			delete window.aiactive;
		};
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
})( window.jQuery );