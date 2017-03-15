/*!
* Parallax
*/
(function($) {

    $.fn.parallax = function(options) {

        var windowHeight = $(window).height();

        // Establish default settings
        var settings = $.extend({
            speed        : 0.1
        }, options);

		function parallax_setpos($this)
	    {
			var scrollTop = $(window).scrollTop();
        	var offset = $this.offset().top;
        	var height = $this.parent().outerHeight();

	    	// Check if above or below viewport
			if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
				return;
			}

			var yBgPosition = Math.round((offset - scrollTop) * settings.speed);

    		$this.css({'transform':'translate3d(0px,' + yBgPosition + 'px, 0px)'});
		}

        return this.each( function() {

        	// Save a reference to the element
        	var $this = $(this);
			parallax_setpos($this);

        	// Set up Scroll Handler
        	$(document).scroll(function(){
		        parallax_setpos($this)
        	});
        });


    }
}(jQuery));