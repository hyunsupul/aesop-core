(function(){
	/*
	 * Create the TinyMCE plugin object.
	 * 
	 * See http://www.tinymce.com/wiki.php/Creating_a_plugin for more information
	 * on how to create TinyMCE plugins.
	 */
    tinymce.create( 'tinymce.plugins.visualShortcodes', {
		
		/*
		 * Create the function to initialize our plugin. We're going to set up all the
		 * properties necessary to function and then set some event handlers to make everything
		 * work properly.
		 * 
		 * This function takes two arguments:
		 * 
		 * ed: the Editor object (this code will run once for each editor on the page)
		 * url: the URL of the directory that this file resides in
		 */
        init : function( ed, url ){
			
			// A counter will help us assign unique ids to each shortcode in this editor.
            this.counter = 0;
			
			// Set up some variables
            var t = this,
                i,
                shortcode,
                names = [];
			
			// Save the url in the object so that it's accessible elsewhere
            t.url = url;

			// Pull in the shortcodes object that we stored in the internationalization object earlier
            t._shortcodes = tinymce.i18n['visualShortcode.shortcodes'];
			
            if( !t._shortcodes || undefined === t._shortcodes.length || 0 == t._shortcodes.length ){
				// If we don't have any shortcodes, we don't need to do anything else. Bail immediately.
                return;
            }
			
			// Set up the shortcodes object and fill it with the shortcodes
            t.shortcodes = {};
            for( i = 0, shortcode = t._shortcodes[i]; i < t._shortcodes.length; shortcode = t._shortcodes[++i]){
                if(undefined === shortcode.shortcode || '' == shortcode.shortcode || undefined === shortcode.image || '' == shortcode.image){
					/*
					 * All shortcodes must have a non-empty string for the shortcode and image properties.
					 * If those conditions are not met, skip to the next one.
					 */
                    continue;
                }
                t.shortcodes[shortcode.shortcode] = shortcode;
                names.push(shortcode.shortcode);
            }
            if( names.length < 1 ){
				// Again, if we don't have any valid shortcodes to work with, bail.
                return;
            }

            t._buildRegex( names );

            t._createButtons();

			/*
			 * Add an event handler for our plugin on the 'mousedown' event. This sets up
			 * the handler to show our control buttons if the user clicks an image that
			 * represents a shortcode.
			 */
            ed.onMouseDown.add(function( ed, e ){
				// We're only interested in images that have the right class
                if( e.target.nodeName == 'IMG' && ed.dom.hasClass(e.target, 'jpbVisualShortcode')){
					// Get the name of the shortcode from the ID
                    var imgID = e.target.id.replace( /^vscImage\d+-(.+)$/, '$1' );
					// Check if the shortcode has a command defined. If so...
                    if( undefined !== t.shortcodes[imgID] && undefined !== t.shortcodes[imgID].command ){
						// Show both the delete and edit buttons. Otherwise...
                        ed.plugins.wordpress._showButtons(e.target, 'jpb_vscbuttons');
                    } else {
						// Only show the delete button
                        ed.plugins.wordpress._showButtons(e.target, 'jpb_vscbutton');
                    }
                } else {
					// If we're not clicking the right kind of image, hide the buttons just in case
                    t._hideButtons();
                }
            });

			/*
			 * Add an event handler for our plugin on the editor's 'change' event. This function
			 * replaces the shortcodes with their images and updates the content of the editor as
			 * the contents of the editor are being changed.
			 * 
			 * The 'change' event fires each time there is an 'undo-able' block change made.
			 */
			ed.onChange.add(function(ed, o){
				if( !t.regex.test(o.content)){
					/*
					 * We shouldn't bother with changing anything and repainting the editor if we
					 * don't even have a regex match on our shortcodes.
					 */
					return;
				}
				
				// Get the updated content
				o.content = t._doScImage( o.content );
				// Set the new content
				ed.setContent(o.content);
				// Repaint the editor
				ed.execCommand('mceRepaint');
			});

			/*
			 * Add an event handler for our plugin on the editor's 'beforesetcontent' event. This
			 * will swap the shortcode out for its image when the editor is initialized, or
			 * whenever switching from HTML to Visual mode.
			 */
            ed.onBeforeSetContent.add(function(ed, o){
				if( !t.regex.test(o.content)){
					/*
					 * We shouldn't bother with changing anything and repainting the editor if we
					 * don't even have a regex match on our shortcodes.
					 */
					return;
				}
				
				/*
				 * Honestly, I'm not sure why/how this works. We don't return anything and are
				 * making the change directly on the object passed in as the second argument. How
				 * does this change the content of the editor? I don't know. But it seems to work.
				 * 
				 * For whatever reason, this does not require a full setting / repainting of the
				 * editor's content like the function above.
				 * 
				 * This code was borrowed from the WordPress gallery TinyMCE plugin.
				 */
                o.content = t._doScImage( o.content );
            });

			/*
			 * Add an event handler for our plugin on the editor's 'postprocess' event. This
			 * changes the images back to shortcodes before saving the content to the form field
			 * and when switching from Visual mode to HTML mode.
			 * 
			 * This code was borrowed from the WordPress gallery TinyMCE plugin.
			 */
            ed.onPostProcess.add(function(ed, o) {
                if( o.get ){
                    o.content = t._getScImage( o.content );
				}
            });

			/*
			 * Add an event handler for the plugin on the editor's initialization event. This
			 * sets up some global event handlers to hide the buttons if the user scrolls or
			 * if they drag something with their mouse.
			 * 
			 * This code was borrowed from the WordPress gallery TinyMCE plugin.
			 */
            ed.onInit.add(function(ed) {
				// Hide the buttons if the user scrolls
                tinymce.dom.Event.add(ed.getWin(), 'scroll', function(e) {
                    t._hideButtons();
                });
				// Hide the buttons if the user drags something
                tinymce.dom.Event.add(ed.getBody(), 'dragstart', function(e) {
                    t._hideButtons();
                });
            });

        },

		/*
		 * Replace shortcodes with their respective images.
		 * 
		 * For each match, the function will replace it with an image. The arguments correspond,
		 * respectively, to:
		 *  - the whole matched string (the whole shortcode, possibly wrapped in <p> tags)
		 *  - the name of the shortcode
		 *  - the arguments of the shortcode (could be an empty string)
		 * 
		 * The id of the shortcode image will start with 'vscImage', followed by the current counter
		 * value (which is incremented as it's used, so next time it will be different), a hyphen, and 
		 * the name of the shortcode.
		 * 
		 * The class 'mceItem' prevents WordPress's normal image management icons from showing up when
		 * the image is clicked.
		 * 
		 * The arguments of the shortcode are encoded and stored in the 'title' attribute of the image.
		 * 
		 * This code is based largely on the WordPress gallery TinyMCE plugin.
		 */
        _doScImage: function( co ){
            var t = this;
            return co.replace( t.regex, function(a,b,c){
                return '<img src="'+t.shortcodes[b].image+'" id="vscImage'+(t.counter++)+'-'+b+'" class="mceItem jpbVisualShortcode" title="' + b + tinymce.DOM.encode(c) + '" />';
            });
        },

		/*
		 * Replace images with their respective shortcodes.
		 * 
		 * This code is based mostly on the WordPress gallery TinyMCE plugin.
		 */
        _getScImage: function( co ){

			// Used to grab the title/class attributes and decode them
            function getAttr(s, n) {
                n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
                return n ? tinymce.DOM.decode(n[1]) : '';
            };

            return co.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,im) {
                var cls = getAttr(im, 'class');

                if ( cls.indexOf('jpbVisualShortcode') != -1 )
                    return '<p>['+tinymce.trim(getAttr(im, 'title'))+']</p>';

                return a;
            });
        },

		/*
		 * Builds the plugin's shortcode for finding registered shortcodes
		 * 
		 * The regex is global and case insensitive, and only searches for self-closing
		 * shortcodes.
		 */
        _buildRegex: function( names ){
            var t = this,
                reString = '';
            reString = '\\\[(' + names.join('|') + ')(( [^\\\]]+)*)\\\]';
            t.regex = new RegExp( reString, 'gi' );
        },

		/* 
		 * Hide the buttons from the user!
		 */
        _hideButtons: function(){
            tinymce.DOM.hide('jpb_vscbuttons');
            tinymce.DOM.hide('jpb_vscbutton');
        },

		/* 
		 * Creates the action buttons
		 * 
		 * We need two sets of buttons: one for shortcodes that only get a delete button
		 * and one for shortcodes that get both a delete and an edit button. Set up the
		 * event handlers for all three of the buttons here too.
		 */
        _createButtons: function(){
			
			// Initialize the variables we need/want
            var t = this,
                ed = tinyMCE.activeEditor,
                DOM = tinyMCE.DOM,
                edbutton,
                delbutton,
                delbutton2;
				
			// Remove extra copies of our buttons (in case we have multiple editors on the page)
            DOM.remove( 'jpb_vscbuttons' );
            DOM.remove( 'jpb_vscbutton' );

			/*
			 * Add the divs to hold the buttons and make sure they start their lives hidden.
			 * We have two button holder divs; the one with the id 'jpb_vscbuttons' will have
			 * both an edit and a delete button, whereas the one with the id 'jpb_vscbutton'
			 * will have only a delete button.
			 */
            DOM.add( document.body, 'div', {
                id: 'jpb_vscbuttons',
                style: 'display:none;'
            });
            DOM.add( document.body, 'div', {
                id: 'jpb_vscbutton',
                style: 'display:none;'
            });

			// Add the 'edit' button
            edbutton = DOM.add( 'jpb_vscbuttons', 'img', {
                src: t.url + '/img/edit.png',
                id: 'jpb_editshortcode',
                width: '24',
                height: '24',
                style: 'margin:2px;'
            });

			// Add the event handler for clicking the 'edit' button
            tinymce.dom.Event.add( edbutton, 'mousedown', function(e){
				// Initialize some variables
                var ed = tinyMCE.activeEditor,
					el = ed.selection.getNode(),
					imgID = el.id.replace( /^vscImage\d+-(.+)$/, '$1' );

				if( !imgID || undefined === t.shortcodes[imgID] || undefined === t.shortcodes[imgID].command ){
					// We don't want to be here if we're not on a valid shortcode with a command
	            	return;
				}
				
				// Execute the command
				ed.execCommand( t.shortcodes[imgID].command );
				// Hide the buttons
				t._hideButtons();
            });

			// Add the 'delete' button (to go with the 'edit' button)
            delbutton = DOM.add( 'jpb_vscbuttons', 'img', {
                src: t.url + '/img/delete.png',
                id: 'jpb_delshortcode',
                width: '24',
                height: '24',
                style: 'margin:2px;'
            });

			// Add the 'delete' button (to go by itself)
            delbutton2 = DOM.add( 'jpb_vscbutton', 'img', {
                src: t.url + '/img/delete.png',
                id: 'jpb_delshortcode2',
                width: '24',
                height: '24',
                style: 'margin:2px;'
            });

			// Add an event handler for both delete buttons to delete the image on click
			tinymce.dom.Event.add( [ delbutton, delbutton2 ], 'mousedown', function(e){
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode(), el2;
				if( el.nodeName == 'IMG' && ed.dom.hasClass( el, 'jpbVisualShortcode' ) ){
					// If we have the right kind of image selected, go about deleting it.
					// Grab the parent node ahead of time.
					el2 = el.parentNode;
					// Get rid of the element
					ed.dom.remove( el );
					// Repaint the editor, just in case.
					ed.execCommand( 'mceRepaint' );
					// Hide the buttons
					t._hideButtons();
					// Select the parent element
					ed.selection.select(el2);
					// Prevent bubbling.
					return false;
				}
			});
            
        }
    });

	// Add the plugin object to the TinyMCE plugin manager
    tinymce.PluginManager.add( 'visualshortcodes', tinymce.plugins.visualShortcodes );
	
})();
