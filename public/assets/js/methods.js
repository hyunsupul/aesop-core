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
});
