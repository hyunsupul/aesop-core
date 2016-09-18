jQuery(document).ready(function($){
	var value_check = function( value ){

		if ( 'grid' == value ) {
			$('.ase-gallery-opts--thumb').fadeOut();
			$('.ase-gallery-opts--photoset').fadeOut();
			$('.ase-gallery-opts--grid').fadeIn();
		} else {
			$('.ase-gallery-opts--grid').fadeOut();
		}

		if ( 'thumbnail' == value ) {
			$('.ase-gallery-opts--grid').fadeOut();
			$('.ase-gallery-opts--photoset').fadeOut();
			$('.ase-gallery-opts--thumb').fadeIn();
		} else {
			$('.ase-gallery-opts--thumb').fadeOut();
		}

		if ( 'photoset' == value ) {
			$('.ase-gallery-opts--grid').fadeOut();
			$('.ase-gallery-opts--thumb').fadeOut();
			$('.ase-gallery-opts--photoset').fadeIn();
		} else {
			$('.ase-gallery-opts--photoset').fadeOut();
		}
	}

	$('.ase-gallery-type-radio').each(function(){

		if ( $(this).is(':checked') ) {
			$(this).parent().addClass('selected');
		var value = $(this).val();
  		value_check(value);

		}

	});

	$('.ase-gallery-layout-label').click(function(){
		$('.ase-gallery-layout-label').removeClass('selected');
		$(this).addClass('selected');
		var value = $(this).find('input').val();
		value_check(value);
	});
})
