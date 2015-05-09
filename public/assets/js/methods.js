// General
jQuery(document).ready(function($){

	$('.aesop-lightbox').swipebox();

    $(function(){
      	$(document.body).on('click touchend','#swipebox-slider .current img', function(e){
            return false;
        })
        .on('click touchend','#swipebox-slider .current', function(e){
            $('#swipebox-close').trigger('click');
        });
    });

	//Fitvids
	$('.aesop-video-container').fitVids();

    window.blockFotoramaData = true;

    var closeChapter = function(){
    	$('body').removeClass('aesop-chapter-menu-open');
    }

    // chapter component
	$('.aesop-toggle-chapter-menu').click(function(e){
		e.preventDefault()
		$('body').toggleClass('aesop-chapter-menu-open');
	});
	$('.aesop-close-chapter-menu').click(function(e){
		e.preventDefault();
		closeChapter();
	});
	$('.aesop-chapter-menu-open article').live('click',function(e){
		e.preventDefault();
		closeChapter();
	});
	$('.scroll-nav__link').live('click',function(){
		closeChapter();
	});
});


