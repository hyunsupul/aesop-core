// General
jQuery(document).ready(function(){

	// actiave swipebox
	jQuery(".aesop-lightbox").swipebox();

	//Fitvids
	jQuery('.aesop-video-container').fitVids();

    jQuery(function(){
      	jQuery(document.body).on('click touchend','#swipebox-slider .current img', function(e){
            return false;
        })
        .on('click touchend','#swipebox-slider .current', function(e){
            jQuery('#swipebox-close').trigger('click');
        });
    });

    window.blockFotoramaData = true;

    // chapter component
	jQuery('.aesop-toggle-chapter-menu').click(function(e){
		e.preventDefault()
		jQuery('body').toggleClass('aesop-chapter-menu-open');
	});
	jQuery('.aesop-close-chapter-menu').click(function(e){
		e.preventDefault();
		jQuery('body').removeClass('aesop-chapter-menu-open');
	});
});
