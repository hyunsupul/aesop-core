jQuery(document).ready(function($){
	var value_check = function( value ){

		if ( 'grid' == value ) {
			$('.ase-gallery-opts--thumb').fadeOut();
			$('.ase-gallery-opts--photoset').fadeOut();
			$('.ase-gallery-opts--sequence').fadeOut();
			$('.ase-gallery-opts--hero').fadeOut();
			$('.ase-gallery-opts--grid').fadeIn();
			$('.ase-gallery-opts--parallax').fadeOut();
		} else {
			$('.ase-gallery-opts--grid').fadeOut();
		}

		if ( 'thumbnail' == value ) {
			$('.ase-gallery-opts--grid').fadeOut();
			$('.ase-gallery-opts--photoset').fadeOut();
			$('.ase-gallery-opts--sequence').fadeOut();
			$('.ase-gallery-opts--hero').fadeOut();
			$('.ase-gallery-opts--thumb').fadeIn();
			$('.ase-gallery-opts--parallax').fadeOut();
		} else {
			$('.ase-gallery-opts--thumb').fadeOut();
		}
		
		if ( 'sequence' == value ) {
			$('.ase-gallery-opts--grid').fadeOut();
			$('.ase-gallery-opts--thumb').fadeOut();
			$('.ase-gallery-opts--photoset').fadeOut();
			$('.ase-gallery-opts--sequence').fadeIn();
			$('.ase-gallery-opts--hero').fadeOut();
			$('.ase-gallery-opts--parallax').fadeOut();
		}

		if ( 'photoset' == value ) {
			$('.ase-gallery-opts--grid').fadeOut();
			$('.ase-gallery-opts--thumb').fadeOut();
			$('.ase-gallery-opts--hero').fadeOut();
			$('.ase-gallery-opts--sequence').fadeOut();
			$('.ase-gallery-opts--photoset').fadeIn();
			$('.ase-gallery-opts--parallax').fadeOut();
		} else {
			$('.ase-gallery-opts--photoset').fadeOut();
		}
		
		if ( 'stacked' == value ) {
			$('.ase-gallery-opts--grid').fadeOut();
			$('.ase-gallery-opts--thumb').fadeOut();
			$('.ase-gallery-opts--photoset').fadeOut();
			$('.ase-gallery-opts--sequence').fadeOut();
			$('.ase-gallery-opts--hero').fadeOut();
			$('.ase-gallery-opts--parallax').fadeIn();
		} else {
			$('.ase-gallery-opts--parallax').fadeOut();
		}
		
		if ( 'hero' == value ) {
			$('.ase-gallery-opts--grid').fadeOut();
			$('.ase-gallery-opts--thumb').fadeOut();
			$('.ase-gallery-opts--photoset').fadeOut();
			$('.ase-gallery-opts--sequence').fadeOut();
			$('.ase-gallery-opts--parallax').fadeOut();
			$('.ase-gallery-opts--hero').fadeIn();
		} else {
			$('.ase-gallery-opts--hero').fadeOut();
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
