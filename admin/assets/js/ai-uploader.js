// Uploading files
var file_frame;

jQuery('.aesop-generator-attr-image_upload').live('click', function( event ){

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      	file_frame.open();
      	return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      	title: jQuery( this ).data( 'uploader_title' ),
      	button: {
        	text: jQuery( this ).data( 'uploader_button_text' ),
      	},
      	multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      	attachment = file_frame.state().get('selection').first().toJSON();
  		jQuery('#aesop-generator-attr-img').val(attachment.url);
    });

    // Finally, open the modal
    file_frame.open();
});