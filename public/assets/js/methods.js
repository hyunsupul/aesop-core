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

    var closeChapter = function(){
    	jQuery('body').removeClass('aesop-chapter-menu-open');
    }

    // chapter component
	jQuery('.aesop-toggle-chapter-menu').click(function(e){
		e.preventDefault()
		jQuery('body').toggleClass('aesop-chapter-menu-open');
	});
	jQuery('.aesop-close-chapter-menu').click(function(e){
		e.preventDefault();
		closeChapter();
	});
	jQuery('.aesop-chapter-menu-open article').live('click',function(e){
		e.preventDefault();
		closeChapter();
	});
	jQuery('.scroll-nav__link').live('click',function(){
		closeChapter();
	});
});


