jQuery(document).ready(function($) {

	$('.aesop-generator').dropkick({
		change: function () {
    		var queried_shortcode = $('#aesop-generator-select').find(':selected').val();
			$('#aesop-generator-settings').addClass('aesop-loading-animation');
			$('#aesop-generator-settings').load($('#aesop-generator-url').val() + '/admin/includes/generator.php?shortcode=' + queried_shortcode, function() {
				$('#aesop-generator-settings').removeClass('aesop-loading-animation');
			});      
        }

	});

	// Insert shortcode
	$('#aesop-generator-insert,.aesop-generator').live('click', function() {
		var queried_shortcode = $('.aesop-generator').find(':selected').val();
		var aesop_compatibility_mode_prefix = $('#aesop-compatibility-mode-prefix').val();
		$('#aesop-generator-result').val('[' + aesop_compatibility_mode_prefix + queried_shortcode);
		$('#aesop-generator-settings .aesop-generator-attr').each(function() {
			if ( $(this).val() !== '' ) {
				$('#aesop-generator-result').val( $('#aesop-generator-result').val() + ' ' + $(this).attr('name') + '="' + $(this).val() + '"' );
			}
		});
		$('#aesop-generator-result').val($('#aesop-generator-result').val() + ']');

		// wrap shortcode
		if ( $('#aesop-generator-content').val() != 'false' ) {
			$('#aesop-generator-result').val($('#aesop-generator-result').val() + $('#aesop-generator-content').val() + '[/' + aesop_compatibility_mode_prefix + queried_shortcode + ']');
		}
		window.send_to_editor(jQuery('#aesop-generator-result').val());
		return false;
	});

});